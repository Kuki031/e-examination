<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuestionsRequest extends FormRequest
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
    public function rules()
    {
        return [
            'questions' => 'required|array|min:1',
            'questions.*.questionValue' => 'required|string',
            'questions.*.answers' => 'required|array|min:2',
            'questions.*.examId' => 'required|integer|exists:exams,id',
        ];
    }

    public function messages()
    {
        return [
            "questions.required" => "Pitanja su obavezna.",
            "questions.array" => "Pitanja moraju biti poslana u obliku niza.",
            "questions.min" => "Broj pitanja je minimalno 2.",
        ];
    }
}
