<?php

namespace App\Http\Requests\ExpectedGraduationLetter;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreExpectedGraduationLetterRequest extends FormRequest
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
            'current_academic_session_id' => ['nullable', 'exists:academic_sessions,id'],
            'joined_academic_session_id' => ['required', 'exists:academic_sessions,id'],
            'graduation_semester_text' => ['required', 'string', 'max:255'],
            'include_cgpa' => ['nullable', 'boolean'],
            'cgpa_academic_session_id' => ['required_if:include_cgpa,1', 'nullable', 'exists:academic_sessions,id'],
            'cgpa' => ['required_if:include_cgpa,1', 'nullable', 'numeric', 'between:0,4'],
            'include_ia_statement' => ['nullable', 'boolean'],
            'ia_academic_session_id' => ['required_if:include_ia_statement,1', 'nullable', 'exists:academic_sessions,id'],
            'ia_completion_date' => ['nullable', 'date'],
            'endorsing_body_text' => ['nullable', 'string'],
            'contact_email' => ['nullable', 'email'],
            'body_text' => ['required', 'string'],
            'signatory_id' => ['required', 'exists:signatories,id'],
            'date' => ['required', 'date'],
            'language' => ['required', 'in:en'],
        ];
    }
}
