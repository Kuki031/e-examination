<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use App\Enums\Pin;
use App\Enums\Status;
use App\Rules\PINRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class updateUserProfileRequest extends FormRequest
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
        $id = Auth::id();

        return [
            "email" => "sometimes|email|unique:users,email,{$id}",
            "pin" => ["sometimes", Rule::in(array_column(Pin::cases(), 'value'))],
            "pin_value" => ["sometimes", new PINRule($this->input('pin')), "unique:users,pin_value,{$id}"],
            'profile_picture' => 'sometimes|file|mimes:jpg,png|max:2048',
            "full_name" => "sometimes|regex:/^\s*\S+(?:\s+\S+)+\s*$/",
            "gender" => ["sometimes", Rule::in(array_column(Gender::cases(), 'value'))],
            "status" => ["sometimes", Rule::in(array_column(Status::cases(), 'value'))],
        ];
    }

    public function messages()
    {
        return [
            "email.email" => "Netočan format e-mail adrese.",
            "email.unique" => "E-mail adresa već postoji.",
            "pin_value.unique" => "{$this->input('pin')} već postoji u bazi podataka.",
            "profile_picture.mimes" => "Slika profila mora biti formata .jpg ili .png",
            "profile_picture.max" => "Slika profila može biti maksimalno veličine 2MB.",
            "full_name.regex" => "Prezime i ime mora sadržavati najmanje dvije riječi."
        ];
    }
}
