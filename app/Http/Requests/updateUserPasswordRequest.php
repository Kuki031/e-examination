<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateUserPasswordRequest extends FormRequest
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
            "password" => "required",
            "new_password" => "required|min:8",
            "new_password_repeat" => "same:new_password"
        ];
    }

    public function messages()
    {
        return [
            "password.required" => "Trenutna lozinka je obavezna.",
            "new_password.required" => "Nova lozinka je obavezna.",
            "new_password.min" => "Nova lozinka mora imati najmanje 8 znakova.",
            "new_password_repeat.same" => "Lozinke se ne podudaraju."
        ];
    }
}
