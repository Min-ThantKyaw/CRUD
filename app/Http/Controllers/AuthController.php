<?php

namespace App\Http\Controllers;

use App\Services\LoginService;
use App\Services\RegisterService;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Services\PasswordService;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;


class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }
    public function loginUser()
    {
        $user = Auth::user();
        return view('layouts.master', compact('user'));
    }
    public function registerPage()
    {
        return view('auth.register');
    }

    protected $loginService;
    protected $registerService;
    protected $authService;

    public function __construct(LoginService $loginService, RegisterService $registerService, PasswordService $authService)
    {
        $this->loginService = $loginService;
        $this->registerService = $registerService;
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {

        try {
            $user = $this->loginService->loginUser($request->validated());

            $request->session()->put('loginId', $user->id);
            Auth::login($user);

            return redirect()->route('post.postlist');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function logout()
    {
        if (Session::has('loginId')) {
            Session::pull('loginId');
        }

        Auth::logout();

        return redirect()->route('loginPage');
    }

    public function forgotPassword()
    {
        return view('auth.forgotPassword');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = $this->authService->sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
}
