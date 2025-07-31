<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ["question", "answers", "exam_id"];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
