<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    protected $fillable = ["user_id", "exam_id", "started_at", "ended_at", "questions", "score", "status", "state"];
    protected $appends = [];

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
        "state" => "array"
    ];
}
