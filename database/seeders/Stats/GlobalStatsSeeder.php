<?php

namespace Database\Seeders\Stats;

use App\Enums\BeerStatus;
use App\Models\Beer;
use App\Models\Bottle;
use App\Models\Bottling;
use App\Models\Fermentation;
use App\Models\Fermenter;
use App\Models\Wort;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;

class GlobalStatsSeeder extends Seeder
{

    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create 3 bought beers -> total 40L -> consumed 10L
        Beer::factory()
            ->count(3)
            ->sequence(
                ['volume' => 10.0, 'status' => BeerStatus::Consumed],
                ['volume' => 10.0, 'status' => BeerStatus::Ready],
                ['volume' => 20.0, 'status' => BeerStatus::Ready],
            )->create(['fermentation_id' => null,]);

        // create 3 homemade beers -> total 50L -> consumed 30L
        Beer::factory()
            ->count(3)
            ->sequence(
                [
                    'volume'          => 10.0,
                    'fermentation_id' => $this->buildFermentationFactory(),
                    'status'          => BeerStatus::Consumed,
                ],
                [
                    'volume'          => 20.0,
                    'fermentation_id' => $this->buildFermentationFactory(),
                    'status'          => BeerStatus::Consumed,
                ],
                [
                    'volume'          => 20.0,
                    'fermentation_id' => $this->buildFermentationFactory(),
                    'status'          => BeerStatus::Ready,
                ],
            )
            ->create();

        // let's make 5 bottling and consume 4 of it
        Bottling::factory()
            ->count(4)
            ->for(Bottle::factory())
            ->sequence(
                ['deleted_at' => Carbon::now()],
                ['deleted_at' => Carbon::now()],
                ['deleted_at' => Carbon::now()],
                ['deleted_at' => Carbon::now()],
                ['deleted_at' => null],
            )
            ->create(['beer_id' => Beer::query()->first()->getKey()]);
    }

    private function buildFermentationFactory(): Factory
    {
        return Fermentation::factory()->for(Wort::factory())->for(Fermenter::factory());
    }
}
