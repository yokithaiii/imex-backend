<?php

namespace App\Http\Requests\Tender;

use Illuminate\Foundation\Http\FormRequest;

class TenderUpdateRequest extends FormRequest
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
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|string|exists:tender_categories,id',
            'item_name' => 'nullable|string',
            'unit_of_measure' => 'nullable|string',
            'quantity' => 'nullable|integer',
            'price_per_unit' => 'nullable|integer',
            'total_amount' => 'nullable|integer',
            'delivery_place' => 'nullable|string',
            'notes' => 'nullable|string',
            'submission_deadline' => 'nullable|date',
            'auction_date' => 'nullable|date',
            'payment_id' => 'nullable|string|exists:tender_payments,id'
        ];
    }
}
