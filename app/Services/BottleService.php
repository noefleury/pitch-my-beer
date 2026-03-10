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
