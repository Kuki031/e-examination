<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'pin',
        'pin_value',
        'full_name',
        'gender',
        'status',
        'registration_type',
        'role',
        'password',
        'is_allowed',
        'is_in_pending_status',
        "profile_picture"
    ];

    protected $appends = [
        "registration_type_formatted", "is_allowed_formatted", "full_name_formatted", "status_formatted", "role_formatted"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getIsAllowedFormattedAttribute()
    {
        return $this->is_allowed === 0 ? "Ne" : "Da";
    }

    public function getRegistrationTypeFormattedAttribute()
    {
        return $this->registration_type === "teacher" ? "Nastavnik" : "Student";
    }

    public function getFullNameFormattedAttribute()
    {
        $fullName = explode(" ", $this->full_name);
        $fullNameLower = array_map(fn($item) => strtolower($item), $fullName);
        $firstLetterUc = array_map(fn($item) => ucfirst($item), $fullNameLower);
        $convert = implode(" ", $firstLetterUc);

        return $convert;
    }

    public function getGenderFormattedAttribute()
    {
        return $this->gender === "m" ? "Muški" : "Ženski";
    }

    public function getStatusFormattedAttribute()
    {
        return match ($this->status) {
            'n' => 'Nastavnik',
            'r' => 'Redovan',
            default => 'Izvanredan',
        };
    }

    public function getRoleFormattedAttribute()
    {
        return match ($this->role) {
            'admin' => 'Administrator',
            'teacher' => 'Nastavnik',
            default => 'Student',
        };
    }
}
