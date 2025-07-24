<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => fake('hr-HR')->name(),
            'email' => fake()->email,
            'pin' => "JMBAG",
            'pin_value' => fake()->numerify(str_repeat('#', 11)),
            'gender' => "m",
            'status' => "r",
            "registration_type" => "student",
            'role' => "student",
            "password" => Hash::make("password"),
            'is_allowed' => true,
            'is_in_pending_status' => false
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
