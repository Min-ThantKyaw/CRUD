<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class RegisterService
{
    public function registerUser($data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->phone = $data['phone'];
        $user->address = $data['address'] ?? null;
        $user->type = $data['type'] ?? 0;
        if (isset($data['dob'])) {
            $user->dob = Carbon::createFromFormat('Y-m-d', $data['dob'])->format('Y-m-d');
        }

        // Handle file upload for profile
        if (isset($data['profile'])) {
            $filePath = $data['profile']->store('profiles', 'public');
            $user->profile = $filePath;
        }

        $user->created_user_id = Auth::id() ?? null;
        $user->updated_user_id = Auth::id() ?? null;
        $user->deleted_user_id = null;
        $user->save();

        return $user;
    }
}
