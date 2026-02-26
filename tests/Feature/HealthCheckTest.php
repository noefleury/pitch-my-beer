<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthCheckTest extends TestCase
{

    public function test_base_db_accessible(): void
    {
        $this->assertDatabaseEmpty('beers');
    }

    public function test_the_application_returns_a_successful_response(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_can_ping_api(): void
    {
        $this->get('/api/ping')
            ->assertOk()
            ->assertExactJson(['data' => 'pong']);
    }

}
