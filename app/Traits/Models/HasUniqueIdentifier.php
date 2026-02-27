<?php

namespace App\Traits\Models;

use App\Helpers\Models\UniqueIdentifier;
use Exception;

/**
 * @see HasUniqueIdentifierTest
 */
trait HasUniqueIdentifier
{

    protected function initializeHasUniqueIdentifier(): void
    {
        $this->append('uid');
    }

    /**
     * @throws Exception
     */
    public function getUniqueIdentifier(): string
    {
        return UniqueIdentifier::getModelUniqueIdentifier($this);
    }

    /**
     * @throws Exception
     */
    protected function getUidAttribute(): string
    {
        return $this->getUniqueIdentifier();
    }

}
