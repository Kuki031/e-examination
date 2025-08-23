<?php

namespace App\Http\Requests;

use App\Enums\Pin;
use App\Rules\PINRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthenticateRequest extends FormRequest
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
            "pin" => ["required", Rule::in(array_column(Pin::cases(), 'value'))],
            "pin_value" => "required",
            "password" => "required"
        ];
    }

    public function messages(): array
    {
        return [
            "pin_value.required" => "{$this->input('pin')} je obavezan.",
            "password.required" => "Lozinka je obavezna."
        ];
    }
}
