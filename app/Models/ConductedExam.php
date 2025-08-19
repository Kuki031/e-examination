<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConductedExam extends Model
{
    protected $fillable = ["exam_id", "exam_attempt_id", "num_of_participants", "start_time", "end_time", "time_to_solve", "required_for_pass", "num_of_participants", "num_of_questions", "num_of_points"];
    protected $appends = ["created_at_formatted", "updated_at_formatted", "start_time_formatted", "end_time_formatted"];

    protected $casts = [
        "created_at" => "datetime",
        "updated_at" => "datetime",
        "start_time" => "datetime",
        "end_time" => "datetime"
    ];

    public function getCreatedAtFormattedAttribute() {
        return $this->created_at->format("d.m.Y H:i:s");
    }

    public function getUpdatedAtFormattedAttribute() {
        return $this->updated_at->format("d.m.Y H:i:s");
    }

    public function getStartTimeFormattedAttribute()
    {
        return $this->start_time?->format("d.m.Y H:i:s") ?? 0;
    }

    public function getEndTimeFormattedAttribute()
    {
        return $this->end_time?->format("d.m.Y H:i:s") ?? 0;
    }

    public function exam() {
        return $this->belongsTo(Exam::class);
    }

}
