<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReadmissionLetter extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reference_no',
        'letter_type_id',
        'date',
        'student_id',
        'readmission_academic_session_id',
        'readmission_condition_id',
        'meeting_number',
        'meeting_date',
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

    public function readmissionAcademicSession(): BelongsTo
    {
        return $this->belongsTo(AcademicSession::class, 'readmission_academic_session_id');
    }

    public function readmissionCondition(): BelongsTo
    {
        return $this->belongsTo(ReadmissionCondition::class);
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
