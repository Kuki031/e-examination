<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateExamRequest extends FormRequest
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
            "name" => ["sometimes", Rule::unique('exams', 'name')->ignore($this->exam)],
            "description" => "nullable",
            "num_of_points" => ["sometimes"],
            "time_to_solve" => "sometimes|integer|min:10",
            "required_for_pass" => "sometimes|lte:num_of_points",
            "user_id" => "required"
        ];
    }

    public function messages()
    {
        return [
            "name.unique" => "Provjera znanja sa ovim imenom već postoji.",
            "time_to_solve.min" => "Vrijeme potrebno za rješavanje mora biti minimalno 10 minuta.",
            "user_id.required" => "ID korisnika je obavezan.",
            "required_for_pass.lte" => "Broj bodova potrebnih za prolaz ne može biti veći od broja ukupnih bodova.",
        ];
    }

    protected function prepareForValidation()
    {
        if (!$this->has('num_of_points') && $this->exam) {
            $this->merge([
                'num_of_points' => $this->exam->num_of_points,
            ]);
        }
    }
}
