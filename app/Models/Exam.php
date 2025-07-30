<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{

    protected $fillable = [
        "name", "description", "num_of_questions", "num_of_points", "required_for_pass", "user_id", "in_process", "start_time", "end_time", "time_to_solve"
    ];

    protected $appends = ["created_at_formatted", "updated_at_formatted"];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        "created_at" => "datetime",
        "updated_at" => "datetime"
    ];

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->format("d.m.Y h:m:s");
    }

    public function getUpdatedAtFormattedAttribute()
    {
        return $this->updated_at->format("d.m.Y h:m:s");
    }
}
