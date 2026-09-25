<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SignatoryProposal extends Model
{
    protected $table = 'signatories_proposal';

    protected $fillable = [
        'name',
        'designation_en',
        'signature_path',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
