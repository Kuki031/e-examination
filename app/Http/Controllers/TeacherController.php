<?php

namespace App\Http\Controllers;

use App\Events\StopExamEvent;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\User;
use App\Traits\Search;
use App\Traits\ToastInterface;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
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

        $exam->update([
            "in_process" => true,
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

            $exam->update([
                "in_process" => false,
                "end_time" => Carbon::now()
            ]);

            $usersToStop = ExamAttempt::where("exam_id", "=", $exam->id)
                ->get(["user_id"])
                ->pluck("user_id");

            foreach($usersToStop as $user) {
                User::where("id", "=", $user)
                    ->update([
                        "is_in_exam" => false
                    ]);
            }
            DB::commit();
            broadcast(new StopExamEvent($exam->id));

        }

        catch (\Throwable $th) {
            DB::rollBack();
            $this->constructToastMessage("Nešto nije u redu.", "Neuspjeh", "error");
            return back();
        }

        $this->constructToastMessage("Provjera znanja uspješno zaustavljena.", "Uspjeh", "success");
        return back();
    }
}
