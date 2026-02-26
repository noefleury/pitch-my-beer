<?php

namespace Tests\Feature\Traits\Models;

use App\Traits\Models\HasUniqueIdentifier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

/**
 * @see HasUniqueIdentifier
 */
class HasUniqueIdentifierTest extends TestCase
{

    public function test_model_using_trait_has_unique_identifier(): void
    {
        $modelClass = new class extends Model {
            use HasUniqueIdentifier;
        };
        Config::set('custom.models.unique_identifiers.'.get_class($modelClass), 'DUMMY-FRM');

        $model     = new $modelClass();
        $model->id = 321;

        $this->assertSame('DUMMY-FRM#321', $model->getUniqueIdentifier());
    }

}
