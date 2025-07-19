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
            'name' => 'Pero Perić',
            'email' => 'test@example.com',
            'pin' => "jmbag",
            'pin_value' => "1234567891",
            'gender' => "m",
            'status' => "r",
            "registration_type" => "student",
            'role' => "student"
        ]);

        User::factory()->create([
            'name' => 'Ana Anić',
            'email' => 'test1@example.com',
            'pin' => "oib",
            'pin_value' => "00000000000",
            'gender' => "f",
            'status' => "n",
            "registration_type" => "teacher",
            'role' => "teacher",
            "password" => Hash::make("password")
        ]);
    }
}
