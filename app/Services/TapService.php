<?php

namespace App\Services;

use App\Enums\TapType;
use App\Models\Link;
use App\Models\Tap;
use Illuminate\Support\Collection;

class TapService
{

    public function show(Tap $tap): Tap
    {
        return $tap;
    }

    public function create(TapType $type, ?string $name = null)
    {
        $tap = Tap::query()->create([
            'name' => $name,
            'type' => $type,
        ]);

        return $tap->only(['id', 'uid']);
    }

    /**
     * @return Collection<object>
     */
    public function getOnTaps(): Collection
    {
        return Link::query()
            ->with(['kegging.kegged', 'gazTank', 'tap'])
            ->get()
            ->map(function (Link $link) {
                return (object)[
                    'id'          => $link->getKey(),
                    'beer_id'     => $link->kegging->beer()->getKey(),
                    'beer_type'   => $link->kegging->beer()->type,
                    'beer_name'   => $link->kegging->beer()->name,
                    'gaz_tank_id' => $link->gazTank->getKey(),
                    'gaz_blend'   => $link->gazTank->blend,
                    'tap_id'      => $link->tap->getKey(),
                    'tap_type'    => $link->tap->type,
                    'date'        => $link->created_at,
                ];
            });
    }

}
