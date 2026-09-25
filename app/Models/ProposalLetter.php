<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProposalLetter extends Model
{
    use SoftDeletes;

    /**
     * Maps each letter type to its LetterType reference-numbering code and its
     * printed title — used both to auto-generate letters on proposal approval
     * and to drive the 4 DDSDCE menu pages (one per type).
     */
    public const TYPES = [
        'sponsorship' => ['code' => 'PROPOSAL_SPONSORSHIP', 'label' => 'Sponsorship Letter'],
        'invitation' => ['code' => 'PROPOSAL_INVITATION', 'label' => 'Invitation Letter'],
        'appointment' => ['code' => 'PROPOSAL_APPOINTMENT', 'label' => 'Appointment Letter'],
        'approval' => ['code' => 'PROPOSAL_APPROVAL', 'label' => 'Approval Letter'],
    ];

    protected $fillable = [
        'proposal_id',
        'type',
        'reference_no',
        'letter_type_id',
        'date',
        'body_text',
        'signatory_id',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }

    public function signatory(): BelongsTo
    {
        return $this->belongsTo(Signatory::class);
    }

    public function letterType(): BelongsTo
    {
        return $this->belongsTo(LetterType::class);
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
