<?php

namespace App\Http\Controllers\StudentActivity;

use App\Http\Controllers\Concerns\HandlesProposalForm;
use App\Http\Controllers\Controller;
use App\Http\Requests\Proposal\StoreProposalRequest;
use App\Http\Requests\Proposal\UpdateProposalRequest;
use App\Models\Proposal;
use App\Models\ProposalAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProposalController extends Controller
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

        return view('student-activity.proposal.index', [
            'proposals' => $proposals,
            'sort' => $sort,
            'direction' => $direction,
            'search' => $search,
            'status' => $status,
            'perPage' => $this->perPage($request),
        ]);
    }

    public function create()
    {
        return view('student-activity.proposal.create', $this->formData());
    }

    public function store(StoreProposalRequest $request)
    {
        $data = $request->validated();

        $proposal = Proposal::create([
            ...$this->headerFields($data),
            'prepared_by_name' => $request->user()->name,
            'status' => $data['action'] === 'submit' ? 'under_review' : 'draft',
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
        ]);

        $this->syncScheduleItems($proposal, $data['schedule'] ?? []);
        $this->syncCommittees($proposal, $data['committee'] ?? []);
        $this->syncBudgetItems($proposal, $data);
        $this->storeAttachments($proposal, $request);
        $this->recalculateFinancials($proposal);

        return redirect()->route('student-activity.proposal.index')
            ->with('status', "Proposal \"{$proposal->name}\" created.");
    }

    public function show(Proposal $proposal)
    {
        $proposal->load([
            'scheduleItems', 'committees', 'budgetItems', 'attachments', 'societyTerm',
            'checkedBySignatory', 'reviewedBySignatory', 'recommendedBySignatory', 'approvedBySignatory',
        ]);

        return view('student-activity.proposal.show', compact('proposal'));
    }

    public function edit(Proposal $proposal)
    {
        abort_unless($proposal->isEditableByIctss(), 403, 'This proposal has been approved and can no longer be edited.');

        $proposal->load(['scheduleItems', 'committees', 'budgetItems', 'attachments', 'societyTerm']);

        return view('student-activity.proposal.edit', [
            'proposal' => $proposal,
            ...$this->formData(),
        ]);
    }

    public function update(UpdateProposalRequest $request, Proposal $proposal)
    {
        abort_unless($proposal->isEditableByIctss(), 403, 'This proposal has been approved and can no longer be edited.');

        $data = $request->validated();

        $proposal->update([
            ...$this->headerFields($data),
            'status' => $data['action'] === 'submit' ? 'under_review' : 'draft',
            'updated_by' => $request->user()->id,
        ]);

        $this->syncScheduleItems($proposal, $data['schedule'] ?? []);
        $this->syncCommittees($proposal, $data['committee'] ?? []);
        $this->syncBudgetItems($proposal, $data);
        $this->removeAttachments($proposal, $data['remove_attachments'] ?? []);
        $this->storeAttachments($proposal, $request);
        $this->recalculateFinancials($proposal);

        return redirect()->route('student-activity.proposal.index')
            ->with('status', "Proposal \"{$proposal->name}\" updated.");
    }

    public function destroy(Request $request, Proposal $proposal)
    {
        $name = $proposal->name;

        $proposal->update(['updated_by' => $request->user()->id]);
        $proposal->delete();

        return redirect()->route('student-activity.proposal.index')
            ->with('status', "Proposal \"{$name}\" deleted.");
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
