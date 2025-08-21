<?php

namespace App\Http\Requests\Tender;

use Illuminate\Foundation\Http\FormRequest;

class TenderRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'company_id' => 'required|string|exists:companies,id',
            'region_id' => 'required|string|exists:regions,id',
            'category_id' => 'required|string|exists:tender_categories,id',
            'payment_id' => 'nullable|string|exists:tender_payments,id',

            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit_quantity' => 'required|integer|min:1',
            'unit_measure' => 'nullable|string',

            'start_date' => 'required|date',
            'end_date' => 'required|date',

            'start_price' => 'required|integer|min:1',
            'max_price' => 'required|integer|min:1',

            'files' => 'nullable|array',
            'files.*.url' => 'string',
            'files.*.type' => 'string',

            'recommend_before_tender_end' => 'boolean',
            'is_escrow_tender' => 'boolean',
            'notifications_new_members' => 'boolean',
            'notifications_offer_changes' => 'boolean',
        ];
    }
}
