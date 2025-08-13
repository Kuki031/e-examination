<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

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
        return $this?->created_at?->format("d.m.Y H:i:s");
    }

    public function getUpdatedAtFormattedAttribute()
    {
        return $this?->updated_at?->format("d.m.Y H:i:s");
    }
}
