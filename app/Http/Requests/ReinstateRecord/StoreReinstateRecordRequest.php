<?php

namespace App\Http\Requests\ReinstateRecord;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReinstateRecordRequest extends FormRequest
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
            'academic_session_id' => [
                'required',
                'exists:academic_sessions,id',
                Rule::unique('reinstate_records', 'academic_session_id')
                    ->where(fn ($query) => $query->where('student_id', $this->student_id)),
            ],
            'cgpa' => ['required', 'numeric', 'between:0,4'],
            'date' => ['required', 'date'],
            'meeting_number' => ['nullable', 'string', 'max:255'],
            'meeting_date' => ['nullable', 'date'],
            'remarks' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'academic_session_id.unique' => 'A reinstatement record for this student in the selected semester already exists.',
        ];
    }
}
