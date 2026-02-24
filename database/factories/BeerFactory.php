<?php

namespace Database\Factories;

use App\Enums\BeerStatus;
use App\Models\Beer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Beer>
 */
class BeerFactory extends Factory
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
            'type'   => $this->faker->randomElement(['Pale Ale', 'Lager']),
            'volume' => $this->faker->randomFloat(1, 5.0, 20.0),
            'status' => $this->faker->randomElement(BeerStatus::cases()),
        ];
    }
}
