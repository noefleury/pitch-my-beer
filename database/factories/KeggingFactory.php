<?php

namespace Database\Factories;

use App\Models\Kegging;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Kegging>
 */
class KeggingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'volume' => $this->faker->randomFloat(0, 1, 9),
        ];
    }
}
