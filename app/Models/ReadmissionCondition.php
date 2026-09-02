<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadmissionCondition extends Model
{
    protected $fillable = [
        'name',
        'footnote_text',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
