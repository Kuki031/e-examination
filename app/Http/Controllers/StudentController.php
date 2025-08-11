<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\User;
use App\Traits\Search;
use App\Traits\ToastInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    use ToastInterface, Search;
    public function getAvailableExamList()
    {
        $exams = $this->searchAny(Exam::class, ['name'])
            ->where('in_process', "=", true)
            ->orderByDesc('created_at')
            ->paginate(5);

        return view('exams.process.list', compact('exams'));
    }

    public function getExamConfirmationView(Exam $exam)
    {
        return view("exams.process.welcome", compact("exam"));
    }

    public function joinExam(Exam $exam, Request $request) {
        $isCodeCorrect = $this->isCodeCorrect($request->input("access_code"), $exam);

        if (!$isCodeCorrect) {
            $this->constructToastMessage("Netočan pristupni kod!", "Neuspjeh", "error");
            return back();
        }

        $questions = $exam->questions()->inRandomOrder()->get(["question", "answers", "image"]);

        try {

            DB::beginTransaction();

            $attempt = ExamAttempt::create([
                "exam_id" => $exam->id,
                "user_id" => Auth::id(),
                "questions" => $questions,
                "status" => "in_process",
                "started_at" => Carbon::now()
            ]);

            User::where("id", "=", Auth::id())->update([
                "is_in_exam" => true
            ]);

            DB::commit();

            return to_route("exams.load_exam", [
                    'examAttempt' => $attempt->id,
                    'exam' => $exam->id
                ]);

        } catch (\Throwable $th) {
            DB::rollBack();

            $this->constructToastMessage("Došlo je do greške prilikom pridruživanja ispitu.", "Neuspjeh", "error");
            return back();
        }
    }

    public function loadExam(ExamAttempt $examAttempt, Exam $exam) {
        $examAttempt = ExamAttempt::where("user_id", "=", Auth::id())
            ->where("exam_id", "=", $exam->id)
            ->latest()
            ->first();

        return view("exams.process.spa", compact("examAttempt"));
    }

    private function isCodeCorrect(string $accessCode, Exam $exam) {
        return hash('sha256', $accessCode) === $exam->access_code;
    }
}
