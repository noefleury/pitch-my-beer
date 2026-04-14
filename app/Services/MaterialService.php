<?php

namespace App\Services;

use App\Helpers\Models\UniqueIdentifier;
use App\Models\Bottle;
use App\Models\Fermenter;
use App\Models\GazTank;
use App\Models\Keg;
use App\Models\Tap;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MaterialService
{

    public function listMaterialsByType(bool $includeDeleted = false): array
    {
        return [
            'fermenters' => $this->getFermenters($includeDeleted),
            'gaz_tanks'  => $this->getGazTanks($includeDeleted),
            'kegs'       => $this->getKegs($includeDeleted),
            'taps'       => $this->getTaps($includeDeleted),
            'bottles'    => $this->getBottles($includeDeleted),
        ];
    }

    private function getMaterial(Model|string $model, bool $includeDeleted)
    {
        $query = $model::query();

        if (!$includeDeleted) {
            $query->whereNull('deleted_at');
        }

        return $query->get()->makeHidden(['created_at', 'deleted_at']);
    }

    private function getFermenters(bool $includeDeleted): Collection
    {
        return $this->getMaterial(Fermenter::class, $includeDeleted);
    }

    private function getGazTanks(bool $includeDeleted): Collection
    {
        return $this->getMaterial(GazTank::class, $includeDeleted);
    }

    private function getKegs(bool $includeDeleted): Collection
    {
        return $this->getMaterial(Keg::class, $includeDeleted);
    }

    private function getTaps(bool $includeDeleted): Collection
    {
        return $this->getMaterial(Tap::class, $includeDeleted);
    }

    private function getBottles(bool $includeDeleted): Collection
    {
        return $this->getMaterial(Bottle::class, $includeDeleted);
    }

    /**
     * Return URI path to the given material uid
     *
     * @param   string  $uid
     *
     * @return string
     * @throws Exception
     */
    public function getUriByUid(string $uid): string
    {
        $model = UniqueIdentifier::getModelByUniqueIdentifier($uid);

        // normalize to get view name and material id attribute
        // todo maybe deal with it by another way as we'll cannot use it for non material (eg: Beer)
        $viewName            = Str::replace('_', '-', $model->getMorphClass());
        $materialIdAttribute = Str::camel($model->getMorphClass());

        return route($viewName, [$materialIdAttribute => $model->getKey()], absolute: false);
    }

}
