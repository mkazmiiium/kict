<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DsuStudent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'disability_category_id',
        'disability_detail',
        'disabled_since',
        'equipment_used',
        'joined_academic_session_id',
        'remarks',
        'created_by',
        'updated_by',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function disabilityCategory(): BelongsTo
    {
        return $this->belongsTo(DisabilityCategory::class);
    }

    public function joinedAcademicSession(): BelongsTo
    {
        return $this->belongsTo(AcademicSession::class, 'joined_academic_session_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Number of semesters completed since joining, counting only semester 1
     * and semester 2 of each academic year (semester 3 — the short semester
     * — is excluded), up through the configured "current" semester. This is
     * intentionally computed on the fly rather than stored, since it changes
     * every time a new semester begins.
     */
    public function semestersSinceJoining(): ?int
    {
        $joined = $this->joinedAcademicSession;

        if (! $joined || $joined->semester === 3) {
            return null;
        }

        $joinedIndex = ((int) substr($joined->academic_year, 0, 4)) * 2 + ($joined->semester - 1);

        $currentYear = (int) substr(config('academic.current_year'), 0, 4);
        $currentSemester = config('academic.current_semester');
        $currentIndex = $currentYear * 2 + ($currentSemester - 1);

        return max(0, $currentIndex - $joinedIndex + 1);
    }
}
