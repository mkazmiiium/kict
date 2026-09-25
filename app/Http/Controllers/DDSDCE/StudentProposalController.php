<?php

namespace App\Http\Controllers\DDSDCE;

use App\Http\Controllers\Concerns\HandlesProposalForm;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentProposal\UpdateStudentProposalRequest;
use App\Models\LetterType;
use App\Models\Proposal;
use App\Models\ProposalAttachment;
use App\Models\ProposalLetter;
use App\Models\Signatory;
use App\Services\LetterNumberingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentProposalController extends Controller
{
    use HandlesProposalForm;

    public function index(Request $request)
    {
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';
        $search = $request->get('search');
        $status = $request->get('status');

        $sortable = [
            'name' => 'name',
            'status' => 'status',
            'created_at' => 'created_at',
        ];
        $sortColumn = $sortable[$sort] ?? $sortable['created_at'];

        $proposals = Proposal::query()
            ->where('status', '!=', 'draft')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('venue', 'like', "%{$search}%")
                        ->orWhere('organizer', 'like', "%{$search}%");
                });
            })
            ->when($status, fn ($query) => $query->where('status', $status))
            ->orderBy($sortColumn, $direction)
            ->orderByDesc('id')
            ->paginate($this->perPage($request))
            ->withQueryString();

        return view('ddsdce.student-proposal.index', [
            'proposals' => $proposals,
            'sort' => $sort,
            'direction' => $direction,
            'search' => $search,
            'status' => $status,
            'perPage' => $this->perPage($request),
        ]);
    }

    public function edit(Proposal $proposal)
    {
        $proposal->load(['scheduleItems', 'committees', 'budgetItems', 'attachments', 'societyTerm']);

        return view('ddsdce.student-proposal.edit', [
            'proposal' => $proposal,
            ...$this->formData(),
        ]);
    }

    public function update(UpdateStudentProposalRequest $request, Proposal $proposal)
    {
        $data = $request->validated();

        $status = match ($data['action']) {
            'accept' => 'approved',
            'reject' => 'make_correction',
            default => 'under_review',
        };

        $proposal->update([
            ...$this->headerFields($data),
            'status' => $status,
            'ddsdce_remark' => $data['action'] === 'reject' ? $data['ddsdce_remark'] : $proposal->ddsdce_remark,
            'needs_sponsorship_letter' => $data['needs_sponsorship_letter'] ?? false,
            'needs_invitation_letter' => $data['needs_invitation_letter'] ?? false,
            'needs_appointment_letter' => $data['needs_appointment_letter'] ?? false,
            'needs_approval_letter' => true,
            'updated_by' => $request->user()->id,
        ]);

        $this->syncScheduleItems($proposal, $data['schedule'] ?? []);
        $this->syncCommittees($proposal, $data['committee'] ?? []);
        $this->syncBudgetItems($proposal, $data);
        $this->removeAttachments($proposal, $data['remove_attachments'] ?? []);
        $this->storeAttachments($proposal, $request);
        $this->recalculateFinancials($proposal);
        $this->removeUnneededLetters($proposal);

        if ($data['action'] === 'accept') {
            $this->generateLetters($proposal, $request->user()->id);
        }

        $message = match ($data['action']) {
            'accept' => "Proposal \"{$proposal->name}\" approved.",
            'reject' => "Proposal \"{$proposal->name}\" sent back for correction.",
            default => "Proposal \"{$proposal->name}\" saved.",
        };

        return redirect()->route('ddsdce.student-proposal.index')->with('status', $message);
    }

    /**
     * Auto-generate a dummy letter for each ticked type that doesn't already
     * exist for this proposal — Approval Letter always included. Content is a
     * placeholder for now; it's derived purely from the proposal's own fields.
     *
     * A type ticked, unticked (soft-deleted by removeUnneededLetters) and
     * re-ticked must restore + refresh that same row rather than insert a new
     * one — the (proposal_id, type) unique index still sees the trashed row,
     * so a plain create() would collide with it.
     */
    private function generateLetters(Proposal $proposal, int $userId): void
    {
        $numbering = app(LetterNumberingService::class);
        $signatoryId = Signatory::where('is_active', true)->orderBy('id')->value('id');
        $existingTypes = $proposal->letters()->pluck('type')->all();
        $trashedByType = ProposalLetter::onlyTrashed()->where('proposal_id', $proposal->id)->get()->keyBy('type');

        foreach ($proposal->neededLetterTypes() as $type) {
            if (in_array($type, $existingTypes, true)) {
                continue;
            }

            $numbered = $numbering->generate(ProposalLetter::TYPES[$type]['code']);

            $attributes = [
                'reference_no' => $numbered['reference_no'],
                'letter_type_id' => $numbered['letter_type_id'],
                'date' => now(),
                'body_text' => "This is a dummy {$type} letter automatically generated for the approved proposal \"{$proposal->name}\", scheduled on ".($proposal->programme_date?->format('j F Y') ?? 'a date to be confirmed')." at ".($proposal->venue ?: 'a venue to be confirmed').", organized by {$proposal->organizer}.\n\nThis content is a placeholder and will be replaced with the actual letter wording.",
                'signatory_id' => $signatoryId,
                'updated_by' => $userId,
            ];

            if ($trashed = $trashedByType->get($type)) {
                $trashed->restore();
                $trashed->update($attributes);

                continue;
            }

            ProposalLetter::create([
                'proposal_id' => $proposal->id,
                'type' => $type,
                'created_by' => $userId,
                ...$attributes,
            ]);
        }
    }

    /**
     * If DDSDCE unticks a letter type that was already generated, remove that
     * letter — checked on every save, not just Accept, so unticking takes
     * effect immediately regardless of which action button was used.
     */
    private function removeUnneededLetters(Proposal $proposal): void
    {
        $unneeded = array_diff(
            array_keys(ProposalLetter::TYPES),
            $proposal->neededLetterTypes()
        );

        if (! empty($unneeded)) {
            $proposal->letters()->whereIn('type', $unneeded)->delete();
        }
    }

    public function letters(Proposal $proposal)
    {
        $proposal->load(['letters' => fn ($query) => $query->orderBy('type')]);

        return view('ddsdce.student-proposal.letters', [
            'proposal' => $proposal,
        ]);
    }

    public function downloadAttachment(Proposal $proposal, ProposalAttachment $attachment)
    {
        abort_unless($attachment->proposal_id === $proposal->id, 404);

        return Storage::disk('public')->download($attachment->file_path, $attachment->original_filename);
    }

    public function viewPdf(Proposal $proposal)
    {
        return $this->buildPdf($proposal)->stream($this->pdfFilename($proposal));
    }

    public function print(Proposal $proposal)
    {
        return $this->buildPdf($proposal)->download($this->pdfFilename($proposal));
    }
}
