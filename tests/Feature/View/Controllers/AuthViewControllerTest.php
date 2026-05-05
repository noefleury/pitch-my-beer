<?php

namespace Tests\Feature\View\Controllers;

use App\Models\Authentication\User;
use App\View\Controllers\Authentication\AuthViewController;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

/**
 * @see AuthViewController
 */
class AuthViewControllerTest extends TestCase
{

    protected bool $actAsAuthUser = false;

    protected function setUp(): void
    {
        parent::setUp();
        User::factory()->create(['username' => 'dummy-user', 'email' => 'dummy@example.org', 'password' => 'pass-123']);
    }

    public function test_can_login_with_username()
    {
        $this->assertFalse(Auth::check());

        $this->post('/login', ['login' => 'dummy-user', 'password' => 'pass-123'])->assertRedirect();

        $this->assertTrue(Auth::check());
    }

    public function test_can_login_with_email()
    {
        $this->assertFalse(Auth::check());

        $this->post('/login', ['login' => 'dummy@example.org', 'password' => 'pass-123'])->assertRedirect();

        $this->assertTrue(Auth::check());
    }

    public function test_cannot_login_with_wrong_pass()
    {
        $this->assertFalse(Auth::check());

        $this->post('/login', ['login' => 'dummy@example.org', 'password' => 'pass-321'])->assertRedirectBack();

        $this->assertFalse(Auth::check());
    }

}
