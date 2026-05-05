<?php

namespace Tests\Feature\Console\Commands\Authentication;

use App\Console\Commands\Authentication\CreateUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

/**
 * @see CreateUser
 */
class CreateUserTest extends TestCase
{

    protected bool $actAsAuthUser = false;

    public function test_handle_create_user()
    {
        Carbon::setTestNow('2026-05-03 15:16');

        $this->assertDatabaseEmpty('users');

        $this->artisan('auth:create-user')
            ->expectsQuestion('Username', 'dummy-user')
            ->expectsQuestion('Email', 'dummy@example.org')
            ->expectsQuestion('Password', 'dummy-123')
            ->assertSuccessful();

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'username'          => 'dummy-user',
            'email'             => 'dummy@example.org',
            'email_verified_at' => '2026-05-03 15:16:00',
        ]);

        $this->assertTrue(Auth::attempt(['email' => 'dummy@example.org', 'password' => 'dummy-123']));
    }

}
