<?php

namespace App\Http\Requests\ReadmissionLetter;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReadmissionLetterRequest extends FormRequest
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
            'readmission_academic_session_id' => ['required', 'exists:academic_sessions,id'],
            'readmission_condition_id' => ['required', 'exists:readmission_conditions,id'],
            'meeting_number' => ['nullable', 'string', 'max:255'],
            'meeting_date' => ['nullable', 'date'],
            'signatory_id' => ['required', 'exists:signatories,id'],
            'date' => ['required', 'date'],
            'language' => ['required', 'in:en'],
        ];
    }
}
