<?php

namespace App\Console\Commands\Authentication;

use App\Models\Authentication\User;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Tests\Feature\Console\Commands\Authentication\CreateUserTest;

/**
 * @see CreateUserTest
 */
#[Signature('auth:create-user')]
#[Description('Create user')]
class CreateUser extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $username = $this->ask('Username');
        $email    = $this->ask('Email');
        $password = $this->ask('Password');
        User::query()->create([
            'username'          => $username,
            'email'             => $email,
            'email_verified_at' => Carbon::now(),
            'password'          => $password,
        ]);

        return self::SUCCESS;
    }
}
