<?php

namespace App\Http\Requests\LoaLetter;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLoaLetterRequest extends FormRequest
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
            'leave_academic_session_id' => ['required', 'exists:academic_sessions,id'],
            'meeting_number' => ['nullable', 'string', 'max:255'],
            'meeting_date' => ['nullable', 'date'],
            'status' => ['required', 'in:approved,rejected'],
            'reason_type' => ['required', 'in:medical,maternity,other'],
            'other_reason_note' => ['required_if:reason_type,other', 'nullable', 'string', 'max:255'],
            'remarks' => ['nullable', 'string'],
            'signatory_id' => ['required', 'exists:signatories,id'],
            'date' => ['required', 'date'],
            'language' => ['required', 'in:en'],
        ];
    }
}
