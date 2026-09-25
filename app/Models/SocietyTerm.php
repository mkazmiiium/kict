<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocietyTerm extends Model
{
    protected $fillable = [
        'term',
        'is_current',
    ];

    protected function casts(): array
    {
        return [
            'is_current' => 'boolean',
        ];
    }
}
