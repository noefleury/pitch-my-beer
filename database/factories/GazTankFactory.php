<?php

namespace Database\Factories;

use App\Models\GazTank;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GazTank>
 */
class GazTankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $percent = $this->faker->randomFloat(0, 0, 100);

        return [
            'name'        => $this->faker->words(2, true),
            'co2_percent' => $percent,
            'n2_percent'  => 100.0 - $percent,
        ];
    }
}
