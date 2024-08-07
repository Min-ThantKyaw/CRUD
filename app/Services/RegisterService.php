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
        $user->phone = $data['phone'] ?? null;
        $user->address = $data['address'] ?? null;
        $user->type = $data['type'] ?? 1;
        $file = $data['profile']->hasFile('profile');
        $fileName = uniqid() . $file->getClientOriginalName();
        $user->profile = $fileName;
        if (isset($data['dob'])) {
            $user->dob = Carbon::parse(($data['dob']));
        }



        $user->created_user_id = Auth::id() ?? null;
        $user->updated_user_id = Auth::id() ?? null;
        $user->deleted_user_id = null;
        $user->save();

        return $user;
    }
}
