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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|string|exists:tender_categories,id',
            'item_name' => 'required|string',
            'unit_of_measure' => 'required|string',
            'quantity' => 'required|integer',
            'price_per_unit' => 'required|integer',
            'total_amount' => 'required|integer',
            'delivery_place' => 'nullable|string',
            'notes' => 'nullable|string',
            'submission_deadline' => 'required|date',
            'auction_date' => 'nullable|date',
            'payment_id' => 'required|string|exists:tender_payments,id'
        ];
    }
}
