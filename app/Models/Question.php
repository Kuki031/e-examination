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
        "answers" => "array",
        "created_at" => "datetime",
        "updated_at" => "datetime",
    ];

    protected $appends = ["created_at_formatted", "updated_at_formatted"];

    protected $fillable = ["question", "answers", "exam_id", "image"];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function getCreatedAtFormattedAttribute()
    {
        return $this?->created_at?->format("d.m.y H:i:s");
    }

    public function getUpdatedAtFormattedAttribute()
    {
        return $this?->updated_at?->format("d.m.y H:i:s");
    }
}
