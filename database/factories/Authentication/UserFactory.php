<?php

namespace Database\Factories\Authentication;

use App\Models\Authentication\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => $this->faker->userName,
            'email'    => $this->faker->email,
            'password' => $this->faker->password,
        ];
    }
}
