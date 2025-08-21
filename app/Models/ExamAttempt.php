<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    protected $fillable = ["user_id", "exam_id", "started_at", "ended_at", "questions", "score", "status", "state", "stored_answers", "has_passed", "note", "ip_address", "actions", "total_points"];
    protected $appends = ["started_at_formatted", "ended_at_formatted"];

    public function exam() {
        return $this->belongsTo(Exam::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        "questions" => "array",
        "started_at" => "datetime",
        "ended_at" => "datetime",
        "state" => "array",
        "stored_answers" => "array",
        "actions" => "array"
    ];

    public function getStartedAtFormattedAttribute() {
        return $this?->started_at?->format("d.m.Y H:i:s");
    }

    public function getEndedAtFormattedAttribute() {
        return $this?->ended_at?->format("d.m.Y H:i:s");
    }
}
