<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function userListPage()
    {
        $users = User::all();
        return view('user.userList', compact('users'));
    }
    public function userCreatePage()
    {
        return view('user.createUser');
    }
    public function confirmPage(Request $request)
    {
        $data = $request->all();
        return view('user.confirmCreateUser', ['data' => $data]);
    }
}
