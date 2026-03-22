<?php

namespace Database\Seeders;

use App\Enums\KeggedType;
use App\Models\Beer;
use App\Models\Keg;
use App\Models\Kegging;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KeggingTransferSeeder extends Seeder
{

    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $baseKegging = Kegging::factory()
            ->for(Beer::factory(), 'kegged')
            ->for(Keg::factory())
            ->create(['volume' => 10]);

        // transfer
        Kegging::factory()
            ->for(Keg::factory())
            ->create(
                [
                    'volume'      => 5,
                    'kegged_id'   => $baseKegging->getKey(),
                    'kegged_type' => KeggedType::Kegging,
                ]
            );
    }
}
