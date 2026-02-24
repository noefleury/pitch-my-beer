<?php

namespace Database\Factories;

use App\Models\Fermenter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Fermenter>
 */
class FermenterFactory extends Factory
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
            'volume' => $this->faker->randomFloat(1, 5.0, 20.0),
        ];
    }
}
