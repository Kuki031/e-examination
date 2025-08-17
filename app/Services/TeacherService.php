<?php

namespace App\Services;

use App\Events\StopExamEvent;
use App\Models\ConductedExam;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\User;
use App\Traits\Search;
use App\Traits\ToastInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TeacherService {

    use ToastInterface, Search;

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

            $countOfParticipants = sizeof($usersToStop);

            foreach($usersToStop as $user) {
                User::where("id", "=", $user)
                    ->update([
                        "is_in_exam" => false
                    ]);
            }

            ConductedExam::create([
                "exam_id" => $exam->id,
                "num_of_participants" => $countOfParticipants
            ]);

            DB::commit();
            broadcast(new StopExamEvent($exam->id));

            $examAttempts = ExamAttempt::where("exam_id", "=", $exam->id)
                ->where("started_at", ">", $exam->start_time)
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
}
