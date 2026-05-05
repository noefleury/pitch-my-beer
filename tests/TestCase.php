<?php

namespace Tests;

use App\Models\Authentication\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{

    use RefreshDatabase;

    protected bool $actAsAuthUser = true;

    protected function setUp(): void
    {
        parent::setUp();
        if ($this->actAsAuthUser) {
            $this->actingAsAuthUser();
        }
    }

    protected function actingAsAuthUser(): static
    {
        Sanctum::actingAs(User::factory()->create());

        return $this;
    }
}
