<?php

namespace App\Http\Requests\CounsellingRecord;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCounsellingRecordRequest extends FormRequest
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
            'date' => ['required', 'date'],
            'referred_by' => ['nullable', 'string', 'max:255'],
            'emailed_to_ccsc_date' => ['nullable', 'date'],
            'remarks' => ['nullable', 'string'],
        ];
    }
}
