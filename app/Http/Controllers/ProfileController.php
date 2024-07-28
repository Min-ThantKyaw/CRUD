<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public function profilePage(): View
    {
        $authUser = Auth::user();
        return view('user.profile', compact('authUser'));
    }
    public function profileEditPage(): View
    {
        $user = Auth::user();
        return view('user.editProfile', compact('user'));
    }
}
