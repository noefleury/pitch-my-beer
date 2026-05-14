<?php

namespace App\View\Controllers\Authentication;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\ViewController;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Tests\Feature\View\Controllers\AuthViewControllerTest;

/**
 * @see AuthViewControllerTest
 */
class AuthViewController extends ViewController
{

    public function showLogin(): RedirectResponse|View
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $this->normalizeCredentials($credentials);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended();
        }

        return back();
    }

    /**
     * Normalize credentials
     *
     * @note allow use to log-in using username or email
     *
     * @param   array  $credentials
     *
     * @return void
     */
    private function normalizeCredentials(array &$credentials): void
    {
        if (str_contains($credentials['login'], '@')) {
            $credentials['email'] = $credentials['login'];
        } else {
            $credentials['username'] = $credentials['login'];
        }
        unset($credentials['login']);
    }


}
