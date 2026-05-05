<?php

namespace App\Console\Commands\Authentication;

use App\Models\Authentication\User;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Tests\Feature\Console\Commands\Authentication\CreateUserTokenTest;

/**
 * @see CreateUserTokenTest
 */
#[Signature('auth:create-user-token')]
#[Description('Create user token')]
class CreateUserToken extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->ask('Email');
        $user  = User::query()->where('email', $email)->first();

        if (!$user) {
            $this->warn('No user found');

            return self::FAILURE;
        }

        $tokenName     = $this->ask('Token name');
        $tokenDuration = $this->askWithCompletion(
            'Duration',
            ['1 hour', '1 day', '1 week', '1 months', '3 months', '6 months', '1 year'],
        );

        $token = $user->createToken($tokenName, expiresAt: Carbon::now()->add($tokenDuration));
        $this->line('Token created');
        $this->line('Expiration : '.$token->accessToken->expires_at.' (UTC)');
        $this->line($token->plainTextToken);
        $this->newLine();

        return self::SUCCESS;
    }
}
