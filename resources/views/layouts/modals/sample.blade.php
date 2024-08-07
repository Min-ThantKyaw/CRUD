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
        return $this->saveUser(new User(), $data);
    }

    public function updateUser($userId, $data)
    {
        $user = User::find($userId);

        if (!$user) {
            return null;
        }

        return $this->saveUser($user, $data);
    }

    private function saveUser(User $user, $data)
    {
        $user->name = $data['name'];
        $user->email = $data['email'];

        if (isset($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->phone = $data['phone'] ?? null;
        $user->address = $data['address'] ?? null;
        $user->type = $data['type'] ?? 1;

        if (isset($data['profile']) && $data['profile']->isValid()) {
            $file = $data['profile'];
            $fileName = uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('profiles'), $fileName);
            $user->profile = $fileName;
        }

        if (isset($data['dob'])) {
            $user->dob = Carbon::parse($data['dob']);
        }

        $user->created_user_id = $user->exists ? $user->created_user_id : Auth::id();
        $user->updated_user_id = Auth::id();
        $user->deleted_user_id = null;
        $user->save();

        return $user;
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\RegisterService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function create()
    {
        return view('user_form');
    }

    public function store(RegisterRequest $request)
    {
        $user = $this->registerService->registerUser($request->validated());
        return redirect()->route('users.edit', $user->id)->with('success', 'User registered successfully');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user_form', compact('user'));
    }

    public function update(RegisterRequest $request, $id)
    {
        $user = $this->registerService->updateUser($id, $request->validated());
        if ($user) {
            return redirect()->route('users.edit', $user->id)->with('success', 'User updated successfully');
        }
        return redirect()->route('users.edit', $id)->with('error', 'User not found');
    }
}
use App\Http\Controllers\UserController;

Route::get('users/create', [UserController::class, 'create'])->name('users.create');
Route::post('users', [UserController::class, 'store'])->name('users.store');
Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
@if(isset($user))
            @method('PUT')
        @endif
