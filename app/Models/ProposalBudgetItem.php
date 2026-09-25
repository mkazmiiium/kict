<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProposalBudgetItem extends Model
{
    protected $fillable = [
        'proposal_id',
        'category',
        'particular',
        'price_per_unit',
        'quantity',
        'amount',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price_per_unit' => 'decimal:2',
            'amount' => 'decimal:2',
        ];
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }
}
