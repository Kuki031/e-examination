<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $desc = "
        Ispit sadrži 20 pitanja iz područja modernog web razvoja: frontend, backend, baze podataka, sigurnost, mrežni protokoli i razvojni alati. Svako pitanje ima 2–4 ponuđena odgovora, a samo jedan je točan. Cilj ispita je provjeriti i proširiti znanje o naprednim konceptima i najboljim praksama u web developmentu.
        ";
        $userId = User::where("role", "admin")->first();

        return [
            "name" => "Web development - Ispit 1",
            "description" => $desc,
            "is_quiz" => false,
            "user_id" => $userId->id,
            "time_to_solve" => 15,
            "num_of_questions" => 20,
            "num_of_points" => 20,
            "required_for_pass" => 10
        ];
    }
}
