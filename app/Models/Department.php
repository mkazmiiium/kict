<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = [
        'kulliyyah_id',
        'name_en',
        'name_bm',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function kulliyyah(): BelongsTo
    {
        return $this->belongsTo(Kulliyyah::class);
    }

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }
}
