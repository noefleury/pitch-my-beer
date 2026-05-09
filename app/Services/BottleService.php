<?php

namespace App\Services;

use App\Models\Bottle;
use Exception;

class BottleService
{

    public function show(Bottle $bottle): Bottle
    {
        return $bottle;
    }

    /**
     * Get relations data
     *
     * @param   Bottle  $bottle
     *
     * @return array
     */
    public function getRelationsData(Bottle $bottle): array
    {
        return [
            'bottling'     => $bottle->bottlings()->whereNull('deleted_at')->first([
                'id',
                'created_at',
            ]),
            'bottled_beer' => (object)$bottle->bottlings()->whereNull('deleted_at')->first()?->beer()->first()->only([
                'id',
                'uid',
                'name',
                'type',
                'status',
                'is_homemade',
            ]),
            'comments'     => $bottle->comments()->get(),
        ];
    }

    /**
     * Create bottle
     *
     * @param   int  $milliliters
     * @param   int  $count  for multiple creations
     *
     * @return array<int> of created bottle IDs
     * @throws Exception
     */
    public function create(int $milliliters, int $count = 1): array
    {
        $ids = [];

        for ($x = 0; $x < $count; $x++) {
            $object = Bottle::query()->create(['volume' => $milliliters]);
            $ids[]  = $object->only(['id', 'uid']);
        }

        return $ids;
    }

}
