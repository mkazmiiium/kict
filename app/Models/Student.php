<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone_no',
        'gender',
        'matric_no',
        'passport_no',
        'nric_no',
        'program_id',
        'department_id',
        'year_of_study',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'year_of_study' => 'integer',
        ];
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
