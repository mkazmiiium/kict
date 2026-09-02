<?php

namespace App\Http\Requests\DisciplinaryRecord;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateDisciplinaryRecordRequest extends FormRequest
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
            'offense_id' => ['nullable', 'exists:offenses,id'],
            'location' => ['required', 'in:KICT,Mahallah,Centre,Others'],
            'remarks' => ['nullable', 'string'],
            'photos' => ['nullable', 'array'],
            'photos.*' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:8192'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $existingCount = $this->route('disciplinaryRecord')->photos()->count();
            $newCount = count($this->file('photos', []));

            if ($existingCount + $newCount > 3) {
                $validator->errors()->add('photos', 'A disciplinary record can have at most 3 photos in total.');
            }
        });
    }
}
