<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CompanyVerifyRequest extends FormRequest
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
            'power_of_attorney' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'egrul' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'passport' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (
                !$this->hasFile('power_of_attorney') &&
                !($this->hasFile('egrul') && $this->hasFile('passport'))
            ) {
                $validator->errors()->add('documents', 'Загрузите либо доверенность, либо ЕГРЮЛ и паспорт.');
            }
        });
    }
}
