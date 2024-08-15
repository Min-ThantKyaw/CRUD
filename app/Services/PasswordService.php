<?php

namespace App\Services;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class PasswordService
{
    public function sendResetLink(array $credentials)
    {
        return Password::sendResetLink($credentials);
    }

    public function resetPassword(array $credentials)
    {
        return Password::reset($credentials, function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));
        });
    }
}
