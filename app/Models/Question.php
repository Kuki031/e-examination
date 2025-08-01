<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    protected static function booted()
    {
        static::saving(function ($question) {
            $question->question_hash = hash('sha256', $question->question);
        });
    }

    protected $casts = [
        "answers" => "array"
    ];

    protected $fillable = ["question", "answers", "exam_id"];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
