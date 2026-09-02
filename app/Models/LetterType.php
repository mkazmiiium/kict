<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LetterType extends Model
{
    protected $fillable = [
        'code',
        'name',
        'reference_no_pattern',
        'year',
        'current_running_number',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'current_running_number' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
