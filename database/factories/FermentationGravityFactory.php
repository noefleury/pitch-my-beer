<?php

namespace Database\Factories;

use App\Models\FermentationGravity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FermentationGravity>
 */
class FermentationGravityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'value' => $this->faker->randomFloat(1, 1.01, 1.06),
        ];
    }
}
