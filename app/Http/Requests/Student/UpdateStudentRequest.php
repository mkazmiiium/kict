<?php

namespace App\Http\Requests\Student;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone_no' => ['nullable', 'string', 'max:50'],
            'gender' => ['nullable', 'in:male,female'],
            'matric_no' => ['required', 'string', 'max:50', Rule::unique('students', 'matric_no')->ignore($this->route('student'))],
            'passport_no' => ['nullable', 'string', 'max:50'],
            'nric_no' => ['nullable', 'string', 'max:50'],
            'program_id' => ['required', 'exists:programs,id'],
            'department_id' => ['required', 'exists:departments,id'],
            'year_of_study' => ['nullable', 'integer', 'min:1', 'max:8'],
            'status' => ['required', 'in:active,inactive,graduated'],
        ];
    }
}
