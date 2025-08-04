<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQuestionsRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Exam;
use App\Models\Question;
use App\Traits\Search;
use App\Traits\ToastInterface;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    use ToastInterface, Search;

    public function saveQuestions(CreateQuestionsRequest $request)
    {
        try {

            DB::beginTransaction();
            foreach ($request->validated()['questions'] as $question) {
                Question::create([
                    'question' => $question['questionValue'],
                    'answers' => $question['answers'],
                    'exam_id' => $question['examId'],
                ]);
            }

            $examId = $request->validated()['questions'][0]['examId'];

            $exam = Exam::findOrFail($examId);
            $numOfQuestions = $exam->num_of_questions + sizeof($request->validated()['questions']);
            $numOfPoints = $exam->num_of_points + sizeof($request->validated()['questions']);

            $exam->update([
                "num_of_questions" => $numOfQuestions,
                "num_of_points" => $numOfPoints
            ]);
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(["message" => "Nešto nije u redu."]);
        }

        return response()->json(["message" => "Pohrana pitanja uspješno izvršena!"]);
    }


    public function getQuestionsForExam(Exam $exam)
    {
        $questions = $this->searchAny(Question::class, ['question'])
            ->where("exam_id", "=", $exam->id)
            ->orderByDesc('created_at')
            ->paginate(5);

        return view('exams.questionList', compact('questions', 'exam'));
    }

    public function getQuestionDetails(Exam $exam, Question $question)
    {
        return view("exams.questionDetails", compact("exam", "question"));
    }

    public function updateQuestion(Exam $exam, Question $question, UpdateQuestionRequest $updateQuestionRequest)
    {
        $validated = $updateQuestionRequest->validated();
        $question->update($validated);

        $this->constructToastMessage("Pitanje uspješno ažurirano.", "Uspješno ažuriranje", "success");
        return back();

    }

    public function deleteQuestion(Exam $exam, Question $question)
    {
        DB::beginTransaction();

        $numOfQuestions = $exam->num_of_questions -1;
        $numOfPoints = $exam->num_of_points -1;

        $exam->update([
            "num_of_questions" => $numOfQuestions,
            "num_of_points" => $numOfPoints
        ]);

        $question->delete();
        DB::commit();

        $this->constructToastMessage("Pitanje uspješno izbrisano!", "Uspješno izbrisano", "success");
        return to_route("teacher.exam_question_list", compact("exam"));
    }

    public function saveAnswers(Exam $exam, Question $question, UpdateQuestionRequest $updateQuestionRequest)
    {

        try {

            $question->update([
                "answers" => $updateQuestionRequest->questions['answers']
            ]);

            return response()->json(["message" => "Odgovori uspješno ažurirani!"]);

        } catch (Exception $e) {
            return response()->json(["message" => "Nešto nije u redu."], 500);
        }
    }
}
