<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpectedGraduationLetter extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reference_no',
        'letter_type_id',
        'date',
        'student_id',
        'current_academic_session_id',
        'joined_academic_session_id',
        'graduation_semester_text',
        'include_cgpa',
        'cgpa_academic_session_id',
        'cgpa',
        'include_ia_statement',
        'ia_academic_session_id',
        'ia_completion_date',
        'endorsing_body_text',
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
            'include_cgpa' => 'boolean',
            'cgpa' => 'decimal:2',
            'include_ia_statement' => 'boolean',
            'ia_completion_date' => 'date',
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

    public function currentAcademicSession(): BelongsTo
    {
        return $this->belongsTo(AcademicSession::class, 'current_academic_session_id');
    }

    public function joinedAcademicSession(): BelongsTo
    {
        return $this->belongsTo(AcademicSession::class, 'joined_academic_session_id');
    }

    public function cgpaAcademicSession(): BelongsTo
    {
        return $this->belongsTo(AcademicSession::class, 'cgpa_academic_session_id');
    }

    public function iaAcademicSession(): BelongsTo
    {
        return $this->belongsTo(AcademicSession::class, 'ia_academic_session_id');
    }
}
