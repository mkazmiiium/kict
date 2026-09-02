<?php

namespace App\Http\Requests\DsuStudent;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDsuStudentRequest extends FormRequest
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
            'student_id' => ['required', 'exists:students,id', 'unique:dsu_students,student_id'],
            'disability_category_id' => ['nullable', 'exists:disability_categories,id'],
            'disability_detail' => ['nullable', 'string', 'max:255'],
            'disabled_since' => ['nullable', 'string', 'max:255'],
            'equipment_used' => ['nullable', 'string', 'max:255'],
            'joined_academic_session_id' => [
                'required',
                Rule::exists('academic_sessions', 'id')->where(fn ($query) => $query->where('semester', '!=', 3)),
            ],
            'remarks' => ['nullable', 'string'],
        ];
    }
}
