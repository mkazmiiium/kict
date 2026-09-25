<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proposal extends Model
{
    use SoftDeletes;

    /**
     * Maps each expenditure category to its Source of Funds label and the
     * running "Financial Implication" total — used to derive the read-only
     * Source of Funds table and total from the editable expenditure tables.
     */
    public const BUDGET_CATEGORIES = [
        'stadd_trust_fund' => 'STADD Trust Fund, S-173-0001',
        'student_activities_programme' => 'Student Activities Programme, B52201',
        'sponsorships_participants_fee' => 'Sponsorships/Participants Fee',
    ];

    public const STATUS_LABELS = [
        'draft' => 'Draft',
        'under_review' => 'Under Review',
        'approved' => 'Approved',
        'make_correction' => 'Make Correction',
    ];

    public const STATUS_BADGES = [
        'draft' => 'bg-label-secondary',
        'under_review' => 'bg-label-info',
        'approved' => 'bg-label-success',
        'make_correction' => 'bg-label-warning',
    ];

    protected $fillable = [
        'name',
        'society_term_id',
        'introduction',
        'background',
        'objectives',
        'impact_sustainability',
        'impact_care_compassion',
        'impact_respect',
        'impact_innovation',
        'impact_prosperity',
        'impact_trust',
        'programme_date',
        'venue',
        'organizer',
        'participants',
        'no_budget_required',
        'financial_implication_amount',
        'funding_source',
        'prepared_by_name',
        'prepared_by_position',
        'prepared_by_date',
        'checked_by_signatory_proposal_id',
        'checked_by_date',
        'reviewed_by_signatory_id',
        'reviewed_by_date',
        'recommended_by_signatory_proposal_id',
        'recommended_by_date',
        'approved_by_signatory_proposal_id',
        'approved_by_date',
        'status',
        'ddsdce_remark',
        'final_document_path',
        'final_document_original_filename',
        'final_document_uploaded_by',
        'final_document_uploaded_at',
        'needs_sponsorship_letter',
        'needs_invitation_letter',
        'needs_appointment_letter',
        'needs_approval_letter',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'no_budget_required' => 'boolean',
            'needs_sponsorship_letter' => 'boolean',
            'needs_invitation_letter' => 'boolean',
            'needs_appointment_letter' => 'boolean',
            'needs_approval_letter' => 'boolean',
            'financial_implication_amount' => 'decimal:2',
            'final_document_uploaded_at' => 'datetime',
            'programme_date' => 'date',
            'prepared_by_date' => 'date',
            'checked_by_date' => 'date',
            'reviewed_by_date' => 'date',
            'recommended_by_date' => 'date',
            'approved_by_date' => 'date',
        ];
    }

    public function societyTerm(): BelongsTo
    {
        return $this->belongsTo(SocietyTerm::class);
    }

    public function scheduleItems(): HasMany
    {
        return $this->hasMany(ProposalScheduleItem::class)->orderBy('sort_order');
    }

    public function committees(): HasMany
    {
        return $this->hasMany(ProposalCommittee::class)->orderBy('sort_order');
    }

    public function budgetItems(): HasMany
    {
        return $this->hasMany(ProposalBudgetItem::class)->orderBy('sort_order');
    }

    /**
     * The read-only "Source of Funds" rows — one per expenditure category,
     * each amount being that category's expenditure subtotal. Always derived
     * live from the expenditure tables rather than stored, so it can never
     * drift out of sync with them.
     */
    public function sourceOfFundsRows(): array
    {
        $totals = $this->budgetItems
            ->groupBy('category')
            ->map(fn ($items) => $items->sum('amount'));

        return collect(self::BUDGET_CATEGORIES)
            ->map(fn ($label, $category) => [
                'category' => $category,
                'particular' => $label,
                'amount' => (float) ($totals[$category] ?? 0),
            ])
            ->values()
            ->all();
    }

    public function sourceOfFundsTotal(): float
    {
        return array_sum(array_column($this->sourceOfFundsRows(), 'amount'));
    }

    /**
     * ICTSS loses edit access once DDSDCE has approved the proposal.
     */
    public function isEditableByIctss(): bool
    {
        return $this->status !== 'approved';
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ProposalAttachment::class);
    }

    public function letters(): HasMany
    {
        return $this->hasMany(ProposalLetter::class);
    }

    /**
     * The letter-type keys (from ProposalLetter::TYPES) DDSDCE has ticked for
     * this proposal — generated automatically once the proposal is approved.
     */
    public function neededLetterTypes(): array
    {
        return array_keys(array_filter([
            'sponsorship' => $this->needs_sponsorship_letter,
            'invitation' => $this->needs_invitation_letter,
            'appointment' => $this->needs_appointment_letter,
            'approval' => $this->needs_approval_letter,
        ]));
    }

    public function checkedBySignatory(): BelongsTo
    {
        return $this->belongsTo(SignatoryProposal::class, 'checked_by_signatory_proposal_id');
    }

    public function reviewedBySignatory(): BelongsTo
    {
        return $this->belongsTo(Signatory::class, 'reviewed_by_signatory_id');
    }

    public function recommendedBySignatory(): BelongsTo
    {
        return $this->belongsTo(SignatoryProposal::class, 'recommended_by_signatory_proposal_id');
    }

    public function approvedBySignatory(): BelongsTo
    {
        return $this->belongsTo(SignatoryProposal::class, 'approved_by_signatory_proposal_id');
    }

    public function finalDocumentUploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'final_document_uploaded_by');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
