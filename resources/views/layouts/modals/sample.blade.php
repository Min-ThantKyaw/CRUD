// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
public function showLoginForm()
{
return view('auth.login');
}

public function login(Request $request)
{
$request->validate([
'email' => 'required|email',
'password' => 'required',
]);

$user = User::where('email', $request->email)->first();

if ($user && Hash::check($request->password, $user->password)) {
Auth::login($user, $request->has('remember'));

// If "Remember Me" is checked, store a cookie
if ($request->has('remember')) {
$rememberToken = $user->createToken('remember_me_token')->plainTextToken;
$cookie = cookie('remember_me', $rememberToken, 43200); // 30 days

return redirect()->intended('/home')->cookie($cookie);
}

return redirect()->intended('/home');
}

return redirect()->back()->withErrors(['email' => 'The provided credentials do not match our records.']);
}

public function logout(Request $request)
{
Auth::logout();

// Forget the remember me cookie
$cookie = \Cookie::forget('remember_me');

return redirect('/login')->withCookie($cookie);
}
}


// app/Http/Middleware/RememberMeMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RememberMeMiddleware
{
public function handle(Request $request, Closure $next)
{
if (!Auth::check() && $request->hasCookie('remember_me')) {
$rememberToken = $request->cookie('remember_me');
$user = User::where('remember_token', $rememberToken)->first();

if ($user) {
Auth::login($user);
}
}

return $next($request);
}
}
