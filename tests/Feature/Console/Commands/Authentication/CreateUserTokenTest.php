<?php

namespace Tests\Feature\Console\Commands\Authentication;

use App\Console\Commands\Authentication\CreateUserToken;
use App\Models\Authentication\User;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

/**
 * @see CreateUserToken
 */
class CreateUserTokenTest extends TestCase
{

    protected bool $actAsAuthUser = false;

    #[TestWith(['dummy-user'])]
    #[TestWith(['dummy@example.org'])]
    public function test_handle_create_user_token(string $usernameOrEmail)
    {
        Carbon::setTestNow('2026-05-03 16:31');

        $user = User::factory()->create(['username' => 'dummy-user', 'email' => 'dummy@example.org']);

        $this->assertDatabaseEmpty('personal_access_tokens');

        $this->artisan('auth:create-user-token')
            ->expectsQuestion('Username or Email', $usernameOrEmail)
            ->expectsQuestion('Token name', 'Dummy token')
            ->expectsQuestion('Duration', '1 hour')
            ->expectsOutput('Token created')
            ->expectsOutput('Expiration : 2026-05-03 17:31:00 (UTC)')
            ->assertSuccessful();

        $this->assertDatabaseCount('personal_access_tokens', 1);
        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_type' => 'user',
            'tokenable_id'   => $user->getKey(),
            'name'           => 'Dummy token',
            'abilities'      => json_encode(['*']),
            'last_used_at'   => null,
            'expires_at'     => '2026-05-03 17:31:00',
        ]);
    }

}
