<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompletionLetter extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reference_no',
        'letter_type_id',
        'date',
        'student_id',
        'joined_academic_session_id',
        'ia_academic_session_id',
        'ia_completion_date',
        'graduation_status',
        'graduation_semester_text',
        'expected_graduation_date',
        'contact_email',
        'body_text',
        'signatory_id',
        'language',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'ia_completion_date' => 'date',
            'expected_graduation_date' => 'date',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
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

    public function joinedAcademicSession(): BelongsTo
    {
        return $this->belongsTo(AcademicSession::class, 'joined_academic_session_id');
    }

    public function iaAcademicSession(): BelongsTo
    {
        return $this->belongsTo(AcademicSession::class, 'ia_academic_session_id');
    }
}
