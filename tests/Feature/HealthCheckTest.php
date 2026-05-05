<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthCheckTest extends TestCase
{

    protected bool $actAsAuthUser = false;

    public function test_base_db_accessible(): void
    {
        $this->assertDatabaseEmpty('beers');
    }

    public function test_the_application_returns_a_successful_response(): void
    {
        $this->actingAsAuthUser()->get('/')->assertOk();
    }

    public function test_the_application_is_protected_with_auth(): void
    {
        $this->get('/')->assertRedirectToRoute('login');
    }

    public function test_can_ping_api(): void
    {
        $this->get('/api/ping')
            ->assertOk()
            ->assertExactJson(['data' => 'pong']);
    }

    public function test_can_ping_api_server(): void
    {
        define('LARAVEL_START', microtime(true)); // manually define variable as not set during testing
        $this->actingAsAuthUser()
            ->get('/api/ping-server')
            ->assertOk()
            ->assertExactJsonStructure([
                'laravel_version',
                'php_version',
                'processing_duration',
            ]);
    }

    public function test_the_api_is_protected_with_bearer(): void
    {
        $this->getJson('/api/ping-server')
            ->assertUnauthorized();
    }

}
