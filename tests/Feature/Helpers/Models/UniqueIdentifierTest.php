<?php

namespace Tests\Feature\Helpers\Models;

use App\Helpers\Models\UniqueIdentifier;
use App\Models\Fermenter;
use Exception;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

/**
 * @see UniqueIdentifier
 */
class UniqueIdentifierTest extends TestCase
{

    private Fermenter $fermenter; // let's use a Fermenter, but it could have been anything else as long as unique identifier set in config

    protected function setUp(): void
    {
        parent::setUp();
        Config::set('custom.models.unique_identifiers.App\Models\Fermenter', 'DUMMY-FRM');
        $this->fermenter = Fermenter::factory()->create(['id' => 123]);
    }

    /**
     * @throws Exception
     */
    public function test_get_model_unique_identifier()
    {
        $uniqueIdentifier = UniqueIdentifier::getModelUniqueIdentifier($this->fermenter);
        $this->assertSame('DUMMY-FRM#123', $uniqueIdentifier);
    }

    /**
     * @throws Exception
     */
    public function test_get_model_unique_identifier_when_model_not_in_config()
    {
        Config::set('custom.models.unique_identifiers.App\Models\Fermenter');
        $this->expectExceptionMessage('Cannot get unique identifier of the given model: App\Models\Fermenter');
        UniqueIdentifier::getModelUniqueIdentifier($this->fermenter);
    }

    /**
     * @throws Exception
     */
    public function test_get_model_by_unique_identifier()
    {
        $model = UniqueIdentifier::getModelByUniqueIdentifier('DUMMY-FRM#123');
        $this->assertInstanceOf(Fermenter::class, $model);
        $this->assertSame(123, $model->getKey());
    }

    /**
     * @throws Exception
     */
    public function test_get_model_by_unique_identifier_when_not_in_config()
    {
        Config::set('custom.models.unique_identifiers.App\Models\Fermenter');
        $this->expectExceptionMessage('Cannot get model from unique identifier: DUMMY-FRM#123');
        UniqueIdentifier::getModelByUniqueIdentifier('DUMMY-FRM#123');
    }

    /**
     * @throws Exception
     */
    public function test_get_model_by_unique_identifier_when_malformed()
    {
        $this->expectExceptionMessage('Malformed unique identifier: DUMMY-FRM@123');
        UniqueIdentifier::getModelByUniqueIdentifier('DUMMY-FRM@123');
    }

}

