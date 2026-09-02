<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class DisciplinaryRecordPhoto extends Model
{
    protected $fillable = [
        'disciplinary_record_id',
        'path',
    ];

    public function disciplinaryRecord(): BelongsTo
    {
        return $this->belongsTo(DisciplinaryRecord::class);
    }

    public function url(): string
    {
        return Storage::disk('public')->url($this->path);
    }
}
