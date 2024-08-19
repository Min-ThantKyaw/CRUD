<?php

namespace App\Services;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Validation\ValidationException;

class LoginService
{
    /**
     * Login function and validation message for login page
     * @param mixed $data
     * @return Authenticatable
     */
    public function loginUser($data): Authenticatable
    {
        try {
            DB::beginTransaction();
            $credentials = [
                'email' => $data['email'],
                'password' => $data['password'],
            ];

            $user = User::where('email', $data['email'])->first();
            if (!$user) {
                throw ValidationException::withMessages([
                    'email' => ['This email is not registered.'],
                ]);
            }
            if (!Auth::attempt($credentials, !empty($data['remember']))) {
                throw ValidationException::withMessages([
                    'password' => ['Password incorrect.'],
                ]);
            }
            if (!empty($data['remember'])) {
                // Store email and password in cache for 7 days
                Cache::put('login_data', $credentials, 60 * 24 * 7); // 7 days
            } else {
                // Remove login data from cache
                Cache::forget('login_data');
            }
            DB::commit();
            return Auth::user();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    /**
     * Retrieve login data from cache.
     *
     * @return array|null
     */
    public function getCachedLoginData()
    {
        return Cache::get('login_data');
    }
}
public function loginPage(): View
    {
        $cachedData = $this->loginService->getCachedLoginData();
        return view('auth.login', [
            'cachedEmail' => $cachedData['email'] ?? null,
            'cachedPassword' => $cachedData['password'] ?? null,
        ]);
    }
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- Font awaesome CDN Link --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Bulletin_Board_OJT</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="offset-3 col-md-6 bg-success mt-5 rounded-top text-white">
                <h3>Login</h3>
            </div>

            <div class="offset-3 col-md-6 border border-success">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="my-3 row">
                        <label for="email" class="col-sm-2 col-form-label text-end">Email</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" name="email"
                                value="{{ old('password', $cachedEmail) }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="password" class="col-sm-2 col-form-label text-end">Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="password"
                                value="{{ old('password', $cachedPassword) }}">
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>Remember
                        Me
                        <a href="" class="px-5 text-decoration-none">Forget Password?</a>
                    </div>
                    <div class="row">
                        <button class="btn btn-success col-10 offset-1" type="submit">Login</button>
                    </div>
                </form>
                <a href="{{ route('registerPage') }}" class="text-decoration-none  col-4 offset-2">Create an Account?<i
                        class="fa-solid fa-user-plus"></i></a>
            </div>
        </div>
    </div>
</body>
<!-- Bootstrap Js Link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

</html>
