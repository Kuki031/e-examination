<?php

namespace App\Http\Controllers;

use App\Events\StopExamEvent;
use App\Models\ConductedExam;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\User;
use App\Traits\Search;
use App\Traits\ToastInterface;
use Carbon\Carbon;
use COM;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{

    use ToastInterface, Search;
    public function startExam(Exam $exam)
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
            "in_process" => true
        ]);

        ConductedExam::create([
            "exam_id" => $exam->id,
            "start_time" => Carbon::now()
        ]);

        $this->constructToastMessage("Prijava znanja uspješno pokrenuta. Kako bi studenti mogli pristupiti istoj, morate im podijeliti pristupni kod.", "Uspjeh", "success", 4500);
        return back();
    }

    public function stopExam(Exam $exam) {

        if (!$exam->in_process) {
            $this->constructToastMessage("Provjera znanja nije pokrenuta.", "Neuspjeh", "error");
            return back();
        }

        try {

            DB::beginTransaction();

            $lastConcludedExam = ConductedExam::where("exam_id", $exam->id)
            ->latest()
            ->first();

            $exam->update([
                "in_process" => false,
            ]);

            $usersToStop = ExamAttempt::where("exam_id", "=", $exam->id)
                ->where("started_at", ">", $lastConcludedExam->start_time)
                ->get(["user_id"])
                ->pluck("user_id");

            $countOfParticipants = sizeof($usersToStop);

            foreach($usersToStop as $user) {
                User::where("id", "=", $user)
                    ->update([
                        "is_in_exam" => false
                    ]);
            }

            $lastConcludedExam->update([
                "num_of_participants" => $countOfParticipants,
                "end_time" => Carbon::now()
            ]);

            DB::commit();
            broadcast(new StopExamEvent($exam->id));

            $examAttempts = ExamAttempt::where("exam_id", "=", $exam->id)
                ->where("started_at", ">", $lastConcludedExam->start_time)
                ->get();

            foreach($examAttempts as $attempt)
            {
                if (!$attempt->ended_at) {
                    $attempt->update([
                        "score" => 0,
                        "status" => "finished",
                        "has_passed" => 0,
                        "ended_at" => Carbon::now(),
                        "note" => "Ispit zaustavljen - Nije bio prisutan"
                    ]);
                } else {
                    continue;
                }
            }
        }

        catch (\Throwable $th) {
            DB::rollBack();
            $this->constructToastMessage("Nešto nije u redu.", "Neuspjeh", "error");
            return back();
        }

        $this->constructToastMessage("Provjera znanja uspješno zaustavljena.", "Uspjeh", "success");
        return back();
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

        return view("teacher.conductedExams", compact("conductedExams"));
    }
}
