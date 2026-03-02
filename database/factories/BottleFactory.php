<?php

namespace Database\Factories;

use App\Models\Bottle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Bottle>
 */
class BottleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'volume' => $this->faker->randomElement([250, 330, 490, 500, 560, 750, 1000]),
        ];
    }
}
