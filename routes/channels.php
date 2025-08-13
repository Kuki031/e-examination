<?php

use App\Models\ExamAttempt;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('exam.{examId}', function ($user, $examId) {
    return ExamAttempt::where('exam_id', $examId)
        ->where('user_id', $user->id)
        ->exists();
});
