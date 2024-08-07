<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\RegisterService;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function userListPage()
    {
        $users = User::with('createUser')->get();
        return view('user.userList', compact('users'));
    }
    public function userCreatePage()
    {
        return view('user.createUser');
    }
    protected $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }
    public function createUser(RegisterRequest $request)
    {
        $user = $this->registerService->registerUser($request);
        return redirect()->route('post.postlist')->with('success', 'Created Account Successfully');
    }
}
