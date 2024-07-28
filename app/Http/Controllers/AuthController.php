<?php

namespace App\Http\Controllers;

use App\Services\LoginService;
use App\Services\RegisterService;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }
    public function loginUser()
    {
        $user = Auth::user();
        dd($user);
        return view('layouts.master', compact('user'));
    }
    public function registerPage()
    {
        return view('auth.register');
    }

    protected $loginService;
    protected $registerService;

    public function __construct(LoginService $loginService, RegisterService $registerService)
    {
        $this->loginService = $loginService;
        $this->registerService = $registerService;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->registerService->registerUser($request->validated());

            return redirect()->route('loginPage')->with('success', 'Register Success.Login Again.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }
    public function login(LoginRequest $request)
    {

        try {
            $user = $this->loginService->loginUser($request->validated());

            // Redirect based on user role
            if ($user->type == 1) {
                return redirect()->route('user.userlist');
            } else {
                return redirect()->route('post.postlist');
            }
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }
}
