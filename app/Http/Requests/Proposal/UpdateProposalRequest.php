<?php

namespace App\Http\Requests\Proposal;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProposalRequest extends FormRequest
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
            'society_term_id' => ['nullable', 'exists:society_terms,id'],
            'introduction' => ['nullable', 'string'],
            'background' => ['nullable', 'string'],
            'objectives' => ['nullable', 'string'],
            'impact_sustainability' => ['nullable', 'string'],
            'impact_care_compassion' => ['nullable', 'string'],
            'impact_respect' => ['nullable', 'string'],
            'impact_innovation' => ['nullable', 'string'],
            'impact_prosperity' => ['nullable', 'string'],
            'impact_trust' => ['nullable', 'string'],
            'programme_date' => ['nullable', 'date'],
            'venue' => ['nullable', 'string', 'max:255'],
            'organizer' => ['nullable', 'string', 'max:255'],
            'participants' => ['nullable', 'string'],

            'schedule' => ['nullable', 'array'],
            'schedule.*.time' => ['nullable', 'string', 'max:100'],
            'schedule.*.activity' => ['nullable', 'string', 'max:255'],

            'committee' => ['nullable', 'array'],
            'committee.*.position' => ['nullable', 'string', 'max:100'],
            'committee.*.name' => ['nullable', 'string', 'max:255'],
            'committee.*.matric_no' => ['nullable', 'string', 'max:50'],
            'committee.*.phone_no' => ['nullable', 'string', 'max:50'],

            'no_budget_required' => ['nullable', 'boolean'],
            'budget_expenditure_stadd' => ['nullable', 'array'],
            'budget_expenditure_stadd.*.particular' => ['nullable', 'string', 'max:255'],
            'budget_expenditure_stadd.*.price_per_unit' => ['nullable', 'numeric', 'min:0'],
            'budget_expenditure_stadd.*.quantity' => ['nullable', 'integer', 'min:0'],
            'budget_expenditure_stadd.*.amount' => ['nullable', 'numeric', 'min:0'],
            'budget_expenditure_sap' => ['nullable', 'array'],
            'budget_expenditure_sap.*.particular' => ['nullable', 'string', 'max:255'],
            'budget_expenditure_sap.*.price_per_unit' => ['nullable', 'numeric', 'min:0'],
            'budget_expenditure_sap.*.quantity' => ['nullable', 'integer', 'min:0'],
            'budget_expenditure_sap.*.amount' => ['nullable', 'numeric', 'min:0'],
            'budget_expenditure_sponsorship' => ['nullable', 'array'],
            'budget_expenditure_sponsorship.*.particular' => ['nullable', 'string', 'max:255'],
            'budget_expenditure_sponsorship.*.price_per_unit' => ['nullable', 'numeric', 'min:0'],
            'budget_expenditure_sponsorship.*.quantity' => ['nullable', 'integer', 'min:0'],
            'budget_expenditure_sponsorship.*.amount' => ['nullable', 'numeric', 'min:0'],
            'funding_source' => ['nullable', 'string', 'max:255'],

            'prepared_by_name' => ['nullable', 'string', 'max:255'],
            'prepared_by_position' => ['nullable', 'string', 'max:255'],
            'prepared_by_date' => ['nullable', 'date'],
            'checked_by_signatory_proposal_id' => ['nullable', 'exists:signatories_proposal,id'],
            'checked_by_date' => ['nullable', 'date'],
            'reviewed_by_signatory_id' => ['nullable', 'exists:signatories,id'],
            'reviewed_by_date' => ['nullable', 'date'],
            'recommended_by_signatory_proposal_id' => ['nullable', 'exists:signatories_proposal,id'],
            'recommended_by_date' => ['nullable', 'date'],
            'approved_by_signatory_proposal_id' => ['nullable', 'exists:signatories_proposal,id'],
            'approved_by_date' => ['nullable', 'date'],

            'action' => ['required', 'in:draft,submit'],

            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'max:10240'],
            'attachment_labels' => ['nullable', 'array'],
            'attachment_labels.*' => ['nullable', 'string', 'max:255'],
            'remove_attachments' => ['nullable', 'array'],
            'remove_attachments.*' => ['integer', 'exists:proposal_attachments,id'],
        ];
    }
}
