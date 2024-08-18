<?php

namespace App\Mail;

use Illuminate\Support\Facades\Mail;

class PasswordResetMail
{
    public function sendPasswordResetEmail($email, $token)
    {
        Mail::send('emails.password-reset', ['token' => $token], function ($message) use ($email) {
            $message->to($email);
            $message->subject('Reset Password');
        });
    }
}
<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Services\passwordService;
use Illuminate\Support\Facades\DB;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\passwordChangeRequest;
use Illuminate\Auth\Notifications\ResetPassword;

class PasswordController extends Controller
{
    protected $passwordService;
    protected $passwordResetMail;
    /**
     * Summary of __construct
     * @param passwordService $passwordService
     */
    public function __construct(PasswordService $passwordService, PasswordResetMail $passwordResetMail)
    {
        $this->passwordService = $passwordService;
        $this->passwordResetMail = $passwordResetMail;
    }
    /**
     * Summary of passwordChangePage
     * @param mixed $id
     * @return View
     */
    public function passwordChangePage(): View
    {
        return view('auth.changePassword');
    }
    public function passwordChange(passwordChangeRequest $request)
    {
        $this->passwordService->passwordChange($request);
        return redirect()->route('user.userlist')->with('success', 'Password is successfully updated.');
    }

    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email',
        ]);

        $token = $this->passwordService->createPasswordResetToken($request->email);
        $this->passwordResetMail->sendPasswordResetEmail($request->email, $token);

        return back()->with('success', 'Email has been sent. Check your email.');
    }

    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', compact('token'));
    }

    public function resetPassword(Request $request)
    {
        $user = $this->passwordService->findUserByToken($request->token);

        if (!$user) {
            return redirect()->route('password.reset.form')->with('error', 'Invalid token.');
        }

        $this->passwordService->updateUserPassword($user->email, $request->password);

        return redirect()->route('loginPage')->with('success', 'Password reset successfully. Login to your account.');
    }
}
public function createPasswordResetToken($email)
    {
        $token = Str::random(60);

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        return $token;
    }

    public function findUserByToken($token)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();
        return $passwordReset ? User::where('email', $passwordReset->email)->first() : null;
    }

    public function updateUserPassword($email, $password)
    {
        User::where('email', $email)->update(['password' => Hash::make($password)]);
        DB::table('password_resets')->where('email', $email)->delete();
    }
    Route::get('forgot-password', [PasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [PasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset/password/{token}', [PasswordController::class, 'showResetPasswordForm'])->name('password.reset.form');
Route::post('/reset/password/comfirm', [PasswordController::class, 'resetPassword'])->name('password.reset');
<!DOCTYPE html>
<html>

<head>
    <title>Password Reset</title>
</head>

<body>
    <p>Hello,</p>
    <p>Click the link below to reset your password:</p>
    <a href="{{ route('password.reset.form', $token) }}">Reset Password</a>
</body>

</html>
