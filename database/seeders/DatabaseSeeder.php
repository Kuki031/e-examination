<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'full_name' => 'Pero Perić',
            'email' => 'student@example.com',
            'pin' => "jmbag",
            'pin_value' => "1234567891",
            'gender' => "m",
            'status' => "r",
            "registration_type" => "student",
            'role' => "student",
            'is_allowed' => true,
            'is_in_pending_status' => false
        ]);

        User::factory()->create([
            'full_name' => 'Ana Anić',
            'email' => 'nastavnik@example.com',
            'pin' => "oib",
            'pin_value' => "00000000000",
            'gender' => "f",
            'status' => "n",
            "registration_type" => "teacher",
            'role' => "teacher",
            "password" => Hash::make("password"),
            'is_allowed' => true,
            'is_in_pending_status' => false
        ]);

        User::factory()->create([
            'full_name' => 'Luka Lukić',
            'email' => 'admin@example.com',
            'pin' => "oib",
            'pin_value' => "00000000001",
            'gender' => "m",
            'status' => "n",
            "registration_type" => "teacher",
            'role' => "admin",
            "password" => Hash::make("password"),
            'is_allowed' => true,
            'is_in_pending_status' => false
        ]);
    }
}
