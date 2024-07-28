<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginService
{
    public function loginUser($data)
    {
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['This email is not registered.'],
            ]);
        }

        // Check if the password is correct
        if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            throw ValidationException::withMessages([
                'password' => ['Password incorrect.'],
            ]);
        }

        return Auth::user();
    }
}
