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
            'volume'      => $this->faker->randomElement([3.0, 10.0, 13.0, 20.0, 40.0]),
            'co2_percent' => $percent,
            'n2_percent'  => 100.0 - $percent,
        ];
    }
}
