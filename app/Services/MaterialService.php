<?php

namespace App\Services;

use App\Models\Fermenter;
use App\Models\GazTank;
use App\Models\Keg;
use App\Models\Tap;
use Illuminate\Database\Eloquent\Collection;

class MaterialService
{

    public function listMaterialsByType(bool $includeDeleted = false): array
    {
        return [
            'fermenters' => $this->getFermenters($includeDeleted),
            'gaz_tanks'  => $this->getGazTanks($includeDeleted),
            'kegs'       => $this->getKegs($includeDeleted),
            'taps'       => $this->getTaps($includeDeleted),
        ];
    }

    private function getFermenters(bool $includeDeleted): Collection
    {
        return Fermenter::withTrashed($includeDeleted)->get()->makeHidden(['created_at', 'deleted_at']);
    }

    private function getGazTanks(bool $includeDeleted): Collection
    {
        return GazTank::withTrashed($includeDeleted)->get()->makeHidden(['created_at', 'deleted_at']);
    }

    private function getKegs(bool $includeDeleted): Collection
    {
        return Keg::withTrashed($includeDeleted)->get()->makeHidden(['created_at', 'deleted_at']);
    }

    private function getTaps(bool $includeDeleted): Collection
    {
        return Tap::withTrashed($includeDeleted)->get()->makeHidden(['created_at', 'deleted_at']);
    }

}
