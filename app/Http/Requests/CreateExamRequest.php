<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateExamRequest extends FormRequest
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
            "name" => "required|unique:exams,name",
            "description" => "nullable",
            "time_to_solve" => "required|integer|min:10",
            "user_id" => "required"
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Naziv provjere znanja je obavezan.",
            "name.unique" => "Provjera znanja sa ovim imenom već postoji.",
            "time_to_solve.required" => "Vrijeme potrebno za rješavanje provjere znanja je obavezno.",
            "time_to_solve.min" => "Vrijeme potrebno za rješavanje mora biti minimalno 10 minuta.",
            "user_id.required" => "ID korisnika je obavezan."
        ];
    }
}
