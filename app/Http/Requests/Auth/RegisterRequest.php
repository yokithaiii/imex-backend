<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'firstname' => 'string|required',
            'lastname' => 'string|nullable',
            'secondname' => 'string|nullable',
            'inn' => 'string|nullable',
            'birthdate' => 'string|required',
            'birthplace' => 'string|nullable',
            'passport_number' => 'integer|nullable|max_digits:4',
            'passport_series' => 'integer|nullable',
            'passport_issued_date' => 'string|nullable',
            'passport_issued_who' => 'string|nullable',
            'registration_address' => 'string|nullable',
            'password' => 'string|confirmed',
        ];
    }
}
