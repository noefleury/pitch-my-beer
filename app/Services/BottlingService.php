<?php

namespace App\Services;

use App\Models\Bottling;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class BottlingService
{

    /**
     * @return Collection<Bottling>
     */
    public function list(): Collection
    {
        return Bottling::query()
            ->whereNull('deleted_at')
            ->with(['beer', 'bottle:id,volume'])
            ->orderBy('beer_id')
            ->orderBy('id')
            ->get()
            ->map(function (Bottling $bottling) {
                $bottling->beer->setVisible(['id', 'uid', 'name', 'type', 'abv', 'is_homemade']);

                return $bottling->makeHidden('deleted_at');
            });
    }

    public function create(int $beerId, array $bottleIds): true
    {
        foreach ($bottleIds as $bottleId) {
            Bottling::query()->create([
                'beer_id'   => $beerId,
                'bottle_id' => $bottleId,
            ]);
        }

        return true;
    }

    public function delete(int $bottlingId): bool
    {
        $bottling = Bottling::query()->whereNull('deleted_at')->findOrFail($bottlingId);

        $bottling->deleted_at = Carbon::now();

        return $bottling->save();
    }

}
