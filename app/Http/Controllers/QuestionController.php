<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQuestionsRequest;
use App\Models\Question;
use App\Traits\Search;
use App\Traits\ToastInterface;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    use ToastInterface, Search;

    public function saveQuestions(CreateQuestionsRequest $request)
    {
        foreach ($request->validated()['questions'] as $question) {
            Question::create([
                'question' => $question['questionValue'],
                'answers' => json_encode($question['answers']),
                'exam_id' => $question['examId'],
            ]);
        }

        return response()->json(["message" => "Successfully saved to database!"]);
    }
}
