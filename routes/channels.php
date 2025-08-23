<?php

use App\Models\ConductedExam;
use App\Models\ExamAttempt;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('exam.{examId}', function ($user, $examId) {
    return ExamAttempt::where('exam_id', $examId)
        ->where('user_id', $user->id)
        ->exists();
});

Broadcast::channel('quiz.{examId}', function($user, $examId) {
    return ['id' => $user->id, 'name' => $user->full_name_formatted, 'picture' => $user->profile_picture, 'role' => $user->role, "exam_id" => $examId];
});

Broadcast::channel('proctor.{examId}', function ($user, $examId) {
    return ['id' => $user->id, 'name' => $user->full_name_formatted, 'picture' => $user->profile_picture, 'role' => $user->role];
});
