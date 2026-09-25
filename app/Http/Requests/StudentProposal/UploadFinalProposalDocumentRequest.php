<?php

namespace App\Http\Requests\StudentProposal;

use Illuminate\Foundation\Http\FormRequest;

class UploadFinalProposalDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'final_document' => ['required', 'file', 'mimes:pdf', 'max:20480'],
        ];
    }
}
