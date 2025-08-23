<?php

namespace App\Http\Controllers;

use App\Events\SendNotification;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Traits\Search;
use App\Traits\ToastInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProctorController extends Controller
{
    use ToastInterface, Search;

    public function logActivity(ExamAttempt $examAttempt, Exam $exam, Request $request)
    {
        $activity = $request->input("activity");
        $time = Carbon::now()->format("d.m.Y H:i:s");

        $entry = [
            "activity" => $activity,
            "time" => $time
        ];

        $examAttemptJson = $examAttempt->actions;
        $examAttemptJson[] = $entry;

        $examAttempt->update([
            "actions" => $examAttemptJson
        ]);

        return response()->json(["activity" => $activity, "time" => $time, "actions" => $examAttemptJson]);
    }

    public function enterProctoringMode(Exam $exam) {
        return view("exams.process.proctoring", compact("exam"));
    }

    public function sendNotificationViaSocket(Request $request, Exam $exam) {
        $notification = $request->input("notification");
        broadcast(new SendNotification($exam->id, $notification));
    }
}
