<?php

namespace App\Helpers\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Tests\Feature\Helpers\Models\UniqueIdentifierTest;

/**
 * @see UniqueIdentifierTest
 */
class UniqueIdentifier
{

    /**
     * @throws Exception
     */
    public static function getModelUniqueIdentifier(Model $model): string
    {
        $modelClass = get_class($model);
        if ($modelIdentifier = config("custom.models.unique_identifiers.$modelClass")) {
            return "$modelIdentifier#".$model->getKey();
        }
        throw new Exception("Cannot get unique identifier of the given model: $modelClass");
    }

    /**
     * @throws Exception
     */
    public static function getModelByUniqueIdentifier(string $identifier): Model
    {
        $explodedIdentifier = explode('#', $identifier);
        if (count($explodedIdentifier) !== 2) {
            throw new Exception("Malformed unique identifier: $identifier");
        }

        /** @var Model $model */
        if ($model = array_search($explodedIdentifier[0], config('custom.models.unique_identifiers'))) {
            return $model::query()->findOrFail($explodedIdentifier[1]);
        }
        throw new Exception("Cannot get model from unique identifier: $identifier");
    }

}
