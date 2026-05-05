<?php

namespace App\Models\Authentication;

use Carbon\Carbon;
use Database\Factories\Authentication\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class user
 *
 * @property int    $id
 * @property string $username
 * @property string $email
 * @property string $email_verified_at
 * @property string $password
 * @property int    $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @see UserFactory
 */
class User extends Authenticatable
{

    use HasApiTokens;
    use HasFactory;

    protected $fillable = [
        'username',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
    ];

    protected static function booted(): void
    {
        static::saving(function (User $user) {
            $user->password = bcrypt($user->password);
        });
    }
}
