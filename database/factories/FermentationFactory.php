<?php

namespace Database\Factories;

use App\Models\Fermentation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Fermentation>
 */
class FermentationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'volume' => $this->faker->randomFloat(1, 5.0, 20.0),
        ];
    }
}
