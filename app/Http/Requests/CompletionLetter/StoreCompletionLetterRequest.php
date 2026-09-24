<?php

namespace App\Http\Requests\CompletionLetter;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCompletionLetterRequest extends FormRequest
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
            'joined_academic_session_id' => ['required', 'exists:academic_sessions,id'],
            'ia_academic_session_id' => ['required', 'exists:academic_sessions,id'],
            'ia_completion_date' => ['nullable', 'date'],
            'graduation_status' => ['required', 'in:subject_to_endorsement,fulfilled'],
            'graduation_semester_text' => ['required_if:graduation_status,subject_to_endorsement', 'nullable', 'string', 'max:255'],
            'expected_graduation_date' => ['required_if:graduation_status,fulfilled', 'nullable', 'date'],
            'contact_email' => ['nullable', 'email'],
            'body_text' => ['required', 'string'],
            'signatory_id' => ['required', 'exists:signatories,id'],
            'date' => ['required', 'date'],
            'language' => ['required', 'in:en'],
        ];
    }
}
