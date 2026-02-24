<?php

namespace Database\Factories;

use App\Models\Keg;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Keg>
 */
class KegFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'   => $this->faker->words(2, true),
            'volume' => $this->faker->randomElement([9, 18]),
        ];
    }
}
