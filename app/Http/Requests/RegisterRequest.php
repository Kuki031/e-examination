<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use App\Enums\Pin;
use App\Enums\Status;
use App\Rules\PINRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            "email" => "required|email|unique:users,email",
            "pin" => ["required", Rule::in(array_column(Pin::cases(), 'value'))],
            "pin_value" => ["required", new PINRule($this->input('pin'))],
            "full_name" => "required|regex:/^\s*\S+(?:\s+\S+)+\s*$/",
            "gender" => ["required", Rule::in(array_column(Gender::cases(), 'value'))],
            "status" => ["required", Rule::in(array_column(Status::cases(), 'value'))],
            "password" => "required|min:8|confirmed"
        ];
    }

    public function messages(): array
    {
        return [
            "email.required" => "E-mail adresa je obavezna.",
            "email.email" => "Netočan format e-mail adrese.",
            "email.unique" => "E-mail adresa već postoji u aplikaciji.",
            "pin_value.required" => "{$this->input('pin')} je obavezan.",
            "full_name.required" => "Prezime i ime je obavezno.",
            "full_name.regex" => "Prezime i ime se mora sastojati od najmanje dvije riječi.",
            "gender.required" => "Spol je obavezan.",
            "status.required" => "Status je obavezan.",
            "password.required" => "Lozinka je obavezna.",
            "password.min" => "Lozinka mora imati najmanje 8 znakova.",
            "password.confirmed" => "Lozinke se moraju podudarati."
        ];
    }
}
