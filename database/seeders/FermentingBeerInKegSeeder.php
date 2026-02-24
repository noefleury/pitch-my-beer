<?php

namespace Database\Seeders;

use App\Enums\BeerStatus;
use App\Models\Beer;
use App\Models\Comment;
use App\Models\Fermentation;
use App\Models\FermentationGravity;
use App\Models\Keg;
use App\Models\Wort;
use Illuminate\Database\Seeder;

class FermentingBeerInKegSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create equipment
        $kegFermenter = Keg::factory()->create();

        // create fermentation
        $wort         = Wort::factory()->create();
        $fermentation = Fermentation::factory()->for($wort)->for($kegFermenter, 'fermenter')->create();
        FermentationGravity::factory()->for($fermentation)->create();
        FermentationGravity::factory()->for($fermentation)->create(['value' => 1.005]);
        Beer::factory()->for($fermentation)->create(['status' => BeerStatus::Fermenting]);
        Comment::factory()->for($fermentation, 'entity')->create(['value' => 'fermenting directly inside keg !']);
    }
}
