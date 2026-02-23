<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthCheckTest extends TestCase
{

    public function test_base_db_accessible(): void
    {
        $this->assertDatabaseEmpty('cache');
    }

}
