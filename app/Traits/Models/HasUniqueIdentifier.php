<?php

namespace App\Traits\Models;

use App\Helpers\Models\UniqueIdentifier;
use Exception;

/**
 * @see HasUniqueIdentifierTest
 */
trait HasUniqueIdentifier
{

    /**
     * @throws Exception
     */
    public function getUniqueIdentifier(): string
    {
        return UniqueIdentifier::getModelUniqueIdentifier($this);
    }

}
