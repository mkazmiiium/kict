<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoaLetter extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reference_no',
        'letter_type_id',
        'date',
        'student_id',
        'leave_academic_session_id',
        'meeting_number',
        'meeting_date',
        'status',
        'reason_type',
        'other_reason_note',
        'remarks',
        'signatory_id',
        'language',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'meeting_date' => 'date',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function leaveAcademicSession(): BelongsTo
    {
        return $this->belongsTo(AcademicSession::class, 'leave_academic_session_id');
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
