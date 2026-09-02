<?php

namespace App\Http\Requests\AttendanceLetter;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAttendanceLetterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'student_id' => ['required', 'exists:students,id'],
            'academic_session_ids' => ['required', 'array', 'min:1'],
            'academic_session_ids.*' => ['exists:academic_sessions,id'],
            'attendance_percentage' => ['required', 'numeric', 'between:0,100'],
            'body_text' => ['required', 'string'],
            'signatory_id' => ['required', 'exists:signatories,id'],
            'date' => ['required', 'date'],
            'language' => ['required', 'in:bm'],
        ];
    }
}
