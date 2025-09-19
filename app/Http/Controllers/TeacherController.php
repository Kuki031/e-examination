<?php

namespace App\Http\Controllers;

use App\Events\EmitStopSignal;
use App\Events\StopExamEvent;
use App\Models\ConductedExam;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\User;
use App\Traits\Search;
use App\Traits\ToastInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{

    use ToastInterface, Search;
    public function startExam(Exam $exam, Request $request)
    {

        if (!$exam->required_for_pass) {
            $this->constructToastMessage("Nije definiran broj bodova potreban za prolaz.", "Neuspjelo pokretanje ispita", "error");
            return back();
        }
        if (!$exam->access_code) {
            $this->constructToastMessage("Nije generiran pristupni kod za provjeru znanja.", "Neuspjelo pokretanje ispita.", "error");
            return back();
        }

        if ($exam->required_for_pass > $exam->num_of_points) {
            $this->constructToastMessage("Broj bodova potrebnih za prolaz ne može biti veći od broja ukupnih bodova.", "Neuspjelo pokretanje ispita.", "error");
            return back();
        }

        $exam->update([
            "in_process" => true,
            "is_quiz" => $request->input("is_quiz") ? true : false,
        ]);

        ConductedExam::create([
            "exam_id" => $exam->id,
            "start_time" => Carbon::now(),
            "time_to_solve" => $exam->time_to_solve,
            "required_for_pass" => $exam->required_for_pass,
            "num_of_points" => $exam->num_of_points,
            "num_of_questions" => $exam->num_of_questions
        ]);

        $this->constructToastMessage("Prijava znanja uspješno pokrenuta. Kako bi studenti mogli pristupiti istoj, morate im podijeliti pristupni kod.", "Uspjeh", "success", 4500);
        return back();
    }

    public function triggerStartQuiz(Exam $exam, Request $request) {

        $exam->update([
            "is_quiz_in_progress" => true
        ]);

        return response()->json(["message" => "Kviz uspješno pokrenut."]);
    }

    public function stopExam(Exam $exam, Request $request) {

        if (!$exam->in_process) {
            $this->constructToastMessage("Provjera znanja nije pokrenuta.", "Neuspjeh", "error");
            return back();
        }

        if ($exam->is_quiz) {
            broadcast(new EmitStopSignal($exam->id));
        } else {
            broadcast(new StopExamEvent($exam->id));
        }

        try {

            DB::beginTransaction();

            $lastConcludedExam = ConductedExam::where("exam_id", $exam->id)
            ->latest()
            ->first();

            $exam->update([
                "in_process" => false,
                "is_quiz" => 0,
                "is_quiz_in_progress" => false
            ]);

            $usersToStop = ExamAttempt::where(column: "exam_id", operator: "=", value: $exam->id)
                ->where("started_at", ">", $lastConcludedExam->start_time)
                ->get(["user_id"])
                ->pluck("user_id");


            foreach($usersToStop as $user) {
                User::where("id", "=", $user)
                    ->update([
                        "is_in_exam" => false
                    ]);
            }

            $examAttempts = ExamAttempt::where("exam_id", "=", $exam->id)
                ->where("started_at", ">", $lastConcludedExam->start_time)
                ->get();


            $now = Carbon::now();
            foreach($examAttempts as $attempt)
            {
                if (!$attempt->ended_at) {
                    $attempt->update([
                        "score" => 0,
                        "status" => "finished",
                        "has_passed" => 0,
                        "ended_at" => $now,
                        "note" => "Ispit zaustavljen - Nije bio prisutan"
                    ]);
                } else {
                    continue;
                }
            }

            $lastConcludedExam->timestamps = false;
            $lastConcludedExam->forceFill([
                "num_of_participants" => $lastConcludedExam->num_of_participants,
                "end_time" => $now->copy()->addSeconds(10),
                "updated_at" => $now->copy()->addSeconds(10)
            ])->save();

            DB::commit();
        }

        catch (\Throwable $th) {
            DB::rollBack();
            $this->constructToastMessage("Nešto nije u redu.", "Neuspjeh", "error");
            return back();
        }

        $this->constructToastMessage("Provjera znanja uspješno zaustavljena.", "Uspjeh", "success");
        return to_route("teacher.exam_details", ["exam" => $exam]);
    }

    public function getUser(User $user) {

        $latestAttempt = $user->examAttempts()
            ->latest()
            ->first();

        return view("teacher.user_profile", compact("user", "latestAttempt"));
    }

    public function getConductedExamList() {
        $conductedExams = ConductedExam::whereHas('exam', function ($query) {
            $query->where('user_id', Auth::id());
        })
        ->orderByDesc("created_at")
        ->paginate(5);

        return view("teacher.conductedExams", data: compact("conductedExams"));
    }

    public function getConductedExamDetails(ConductedExam $conductedExam, Exam $exam) {

        $passes = 0;
        $fails = 0;
        $attempts = $exam->examAttempts()
            ->where('created_at', ">=", $conductedExam->created_at)
            ->where('updated_at', "<=", $conductedExam->updated_at)
            ->get();


        foreach($attempts as $attempt)
        {
            if ($attempt['has_passed']) {
                $passes++;
            } else {
                $fails++;
            }
        }

        return view("teacher.conducted_exam_details", compact("exam","conductedExam", "passes", "fails"));
    }

    public function getParticipantsForConductedExam(ConductedExam $conductedExam, Exam $exam) {

        $attempts = $exam->examAttempts()
            ->where('created_at', ">=", $conductedExam->created_at)
            ->where('updated_at', "<=", $conductedExam->updated_at)
            ->paginate(5);

        return view("teacher.conducted_participants", compact("attempts", "conductedExam", "exam"));
    }

    public function loadActivitesForStudent(Exam $exam, User $user) {

        $attempt = $exam->examAttempts()
            ->where("user_id", $user->id)
            ->where("exam_id", $exam->id)
            ->latest()
            ->first();

        return view("teacher.conducted_exam_activites", compact("attempt"));
    }

    public function loadQuizControl(Exam $exam) {

        $lastConductedExam = $exam->conductedExams()
        ->latest()
        ->first();

        $questions = $exam->questions->toArray();

        return view("teacher.quiz_control", compact("lastConductedExam", "questions", "exam"));
    }
}
