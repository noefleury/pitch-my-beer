<?php

namespace Database\Factories;

use App\Enums\FermenterType;
use App\Models\Fermentation;
use App\Models\Fermenter;
use App\Models\Wort;
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
            'wort_id'        => Wort::factory()->create()->getKey(),
            'fermenter_id'   => Fermenter::factory()->create()->getKey(),
            'fermenter_type' => FermenterType::Fermenter,
            'volume'         => $this->faker->randomFloat(1, 5.0, 20.0),
        ];
    }
}
