<?php

namespace Database\Factories;

use App\Enums\TapType;
use App\Models\Tap;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tap>
 */
class TapFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'type' => $this->faker->randomElement(TapType::cases()),
        ];
    }
}
