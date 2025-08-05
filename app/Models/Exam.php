<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Exam extends Model
{

    protected $fillable = [
        "name", "description", "num_of_questions", "num_of_points", "required_for_pass", "user_id", "in_process", "start_time", "end_time", "time_to_solve", "access_code", "access_code_encrypted"
    ];

    protected $appends = ["created_at_formatted", "updated_at_formatted", "access_code_formatted"];

    protected static function booted()
    {
        static::saving(function ($exam) {
            if ($exam->isDirty('access_code')) {
                $plainCode = $exam->getDirty()['access_code'];
                $exam->access_code_encrypted = Crypt::encryptString($plainCode);
                $exam->access_code = hash('sha256', $plainCode);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    protected $casts = [
        "created_at" => "datetime",
        "updated_at" => "datetime"
    ];

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->format("d.m.Y H:m:s");
    }

    public function getUpdatedAtFormattedAttribute()
    {
        return $this->updated_at->format("d.m.Y H:m:s");
    }

    public function getAccessCodeFormattedAttribute(): ?string
    {
        if (!$this->access_code_encrypted) {
            return null;
        }

        try {
            return Crypt::decryptString($this->access_code_encrypted);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function verifyAccessCode(string $input): bool
    {
        return hash('sha256', $input) === $this->access_code;
    }
}
