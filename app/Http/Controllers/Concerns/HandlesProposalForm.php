<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Proposal;
use App\Models\Signatory;
use App\Models\SignatoryProposal;
use App\Models\SocietyTerm;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Shared between the ICTSS-facing ProposalController and the DDSDCE-facing
 * StudentProposalController — both edit the same Proposal record (with its
 * schedule/committee/budget child rows, attachments and PDF), just with
 * different permissions and save/decision actions around it.
 */
trait HandlesProposalForm
{
    private function buildPdf(Proposal $proposal)
    {
        $proposal->load([
            'scheduleItems', 'committees', 'budgetItems', 'societyTerm',
            'checkedBySignatory', 'reviewedBySignatory', 'recommendedBySignatory', 'approvedBySignatory',
        ]);

        $pdf = Pdf::loadView('student-activity.proposal.pdf', ['proposal' => $proposal]);
        $pdf->setEncryption('', config('pdf.password'), ['print' => true]);

        return $pdf;
    }

    private function pdfFilename(Proposal $proposal): string
    {
        return 'Proposal-'.Str::slug($proposal->name).'-'.$proposal->id.'.pdf';
    }

    private function headerFields(array $data): array
    {
        return [
            'name' => $data['name'],
            'society_term_id' => $data['society_term_id'] ?? SocietyTerm::where('is_current', true)->value('id'),
            'introduction' => $data['introduction'] ?? null,
            'background' => $data['background'] ?? null,
            'objectives' => $data['objectives'] ?? null,
            'impact_sustainability' => $data['impact_sustainability'] ?? null,
            'impact_care_compassion' => $data['impact_care_compassion'] ?? null,
            'impact_respect' => $data['impact_respect'] ?? null,
            'impact_innovation' => $data['impact_innovation'] ?? null,
            'impact_prosperity' => $data['impact_prosperity'] ?? null,
            'impact_trust' => $data['impact_trust'] ?? null,
            'programme_date' => $data['programme_date'] ?? null,
            'venue' => $data['venue'] ?? null,
            'organizer' => $data['organizer'] ?? null,
            'participants' => $data['participants'] ?? null,
            'no_budget_required' => $data['no_budget_required'] ?? false,
            'funding_source' => $data['funding_source'] ?? null,
            'prepared_by_position' => $data['prepared_by_position'] ?? null,
            'prepared_by_date' => $data['prepared_by_date'] ?? null,
            'checked_by_signatory_proposal_id' => $data['checked_by_signatory_proposal_id']
                ?? SignatoryProposal::where('is_active', true)->where('designation_en', 'President')->value('id'),
            'checked_by_date' => $data['checked_by_date'] ?? null,
            'reviewed_by_signatory_id' => $data['reviewed_by_signatory_id'] ?? null,
            'reviewed_by_date' => $data['reviewed_by_date'] ?? null,
            'recommended_by_signatory_proposal_id' => $data['recommended_by_signatory_proposal_id']
                ?? SignatoryProposal::where('is_active', true)->where('designation_en', 'Deputy Director')->value('id'),
            'recommended_by_date' => $data['recommended_by_date'] ?? null,
            'approved_by_signatory_proposal_id' => $data['approved_by_signatory_proposal_id']
                ?? SignatoryProposal::where('is_active', true)->where('designation_en', 'Dean')->value('id'),
            'approved_by_date' => $data['approved_by_date'] ?? null,
        ];
    }

    private function syncScheduleItems(Proposal $proposal, array $rows): void
    {
        $proposal->scheduleItems()->delete();

        foreach (array_values($rows) as $index => $row) {
            if (empty($row['activity'])) {
                continue;
            }

            $proposal->scheduleItems()->create([
                'time' => $row['time'] ?? null,
                'activity' => $row['activity'],
                'sort_order' => $index,
            ]);
        }
    }

    private function syncCommittees(Proposal $proposal, array $rows): void
    {
        $proposal->committees()->delete();

        foreach (array_values($rows) as $index => $row) {
            if (empty($row['position']) && empty($row['name'])) {
                continue;
            }

            $proposal->committees()->create([
                'position' => $row['position'] ?? '',
                'name' => $row['name'] ?? null,
                'matric_no' => $row['matric_no'] ?? null,
                'phone_no' => $row['phone_no'] ?? null,
                'sort_order' => $index,
            ]);
        }
    }

    private function syncBudgetItems(Proposal $proposal, array $data): void
    {
        $proposal->budgetItems()->delete();

        $categoryFields = [
            'stadd_trust_fund' => 'budget_expenditure_stadd',
            'student_activities_programme' => 'budget_expenditure_sap',
            'sponsorships_participants_fee' => 'budget_expenditure_sponsorship',
        ];

        foreach ($categoryFields as $category => $field) {
            foreach (array_values($data[$field] ?? []) as $index => $row) {
                if (empty($row['particular'])) {
                    continue;
                }

                $proposal->budgetItems()->create([
                    'category' => $category,
                    'particular' => $row['particular'],
                    'price_per_unit' => $row['price_per_unit'] ?? null,
                    'quantity' => $row['quantity'] ?? null,
                    'amount' => $row['amount'] ?? null,
                    'sort_order' => $index,
                ]);
            }
        }
    }

    /**
     * "Source of Funds" and "Financial Implication" are both derived from the
     * expenditure tables, not user input — recompute them after every save so
     * they can never drift out of sync with the expenditure rows just synced.
     */
    private function recalculateFinancials(Proposal $proposal): void
    {
        $proposal->load('budgetItems');

        $proposal->update([
            'financial_implication_amount' => $proposal->no_budget_required ? 0 : $proposal->sourceOfFundsTotal(),
        ]);
    }

    private function storeAttachments(Proposal $proposal, Request $request): void
    {
        if (! $request->hasFile('attachments')) {
            return;
        }

        $labels = $request->input('attachment_labels', []);

        foreach ($request->file('attachments') as $index => $file) {
            if (! $file || ! $file->isValid()) {
                continue;
            }

            $path = $file->store('proposal-attachments', 'public');

            $proposal->attachments()->create([
                'label' => $labels[$index] ?? null,
                'file_path' => $path,
                'original_filename' => $file->getClientOriginalName(),
                'uploaded_by' => $request->user()->id,
            ]);
        }
    }

    private function removeAttachments(Proposal $proposal, array $ids): void
    {
        if (empty($ids)) {
            return;
        }

        $attachments = $proposal->attachments()->whereIn('id', $ids)->get();

        foreach ($attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
            $attachment->delete();
        }
    }

    private function formData(): array
    {
        return [
            'signatories' => Signatory::where('is_active', true)->orderByDesc('id')->get(),
            'defaultCheckedBy' => SignatoryProposal::where('is_active', true)->where('designation_en', 'President')->first(),
            'defaultRecommendedBy' => SignatoryProposal::where('is_active', true)->where('designation_en', 'Deputy Director')->first(),
            'defaultApprovedBy' => SignatoryProposal::where('is_active', true)->where('designation_en', 'Dean')->first(),
            'currentSocietyTerm' => SocietyTerm::where('is_current', true)->first(),
            'students' => Student::orderBy('name')->get(['id', 'name', 'matric_no']),
        ];
    }
}
