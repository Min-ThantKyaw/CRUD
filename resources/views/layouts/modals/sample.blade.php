namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
public function show()
{
return view('profile');
}

public function edit()
{
return view('editProfile');
}

public function update(Request $request)
{
$validatedData = $request->validate([
'name' => 'required|max:255',
'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
'phone' => 'required|max:15',
'dob' => 'required|date',
'address' => 'required|max:255',
'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
]);

$user = Auth::user();
$user->name = $validatedData['name'];
$user->email = $validatedData['email'];
$user->phone = $validatedData['phone'];
$user->dob = $validatedData['dob'];
$user->address = $validatedData['address'];

if ($request->hasFile('profile')) {
$profilePath = $request->file('profile')->store('profiles', 'public');
$user->profile = $profilePath;
}

$user->save();

return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
}
}


<Profile class="edit">

    Copy code
    @extends('layouts.master')
    @section('content')
        <div class="row">
            <div class="col-6 mx-auto border border-dark py-3">
                <div class="bg-success rounded-top">
                    <h4>Edit Profile</h4>
                </div>
                <div class="bg-light py-3 px-4">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <label for="">Name</label>
                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                            class="form-control">
                        @error('name')
                            <small class="alert text-danger">{{ $message }}</small><br>
                        @enderror

                        <label for="" class="my-2">Email Address</label>
                        <input type="text" name="email" value="{{ old('email', Auth::user()->email) }}"
                            class="form-control">
                        @error('email')
                            <small class="alert text-danger">{{ $message }}</small><br>
                        @enderror

                        <label for="" class="my-2">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}"
                            class="form-control">
                        @error('phone')
                            <small class="alert text-danger">{{ $message }}</small><br>
                        @enderror

                        <label for="" class="my-2">Date Of Birth</label>
                        <input type="date" name="dob" value="{{ old('dob', Auth::user()->dob) }}"
                            class="form-control">
                        @error('dob')
                            <small class="alert text-danger">{{ $message }}</small><br>
                        @enderror

                        <label for="">Address</label>
                        <input type="text" name="address" value="{{ old('address', Auth::user()->address) }}"
                            class="form-control">
                        @error('address')
                            <small class="alert text-danger">{{ $message }}</small><br>
                        @enderror

                        <label for="">Profile Picture</label>
                        <input type="file" name="profile" class="form-control">
                        @error('profile')
                            <small class="alert text-danger">{{ $message }}</small><br>
                        @enderror

                        <div class="mt-3">
                            <input type="submit" value="Update" class="btn btn-success">
                            <a href="{{ route('profile.show') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
</Profile>


//Search
@extends('layouts.master')
@section('content')
    <div class="row border border-dark">
        <div class="col-12 bg-success rounded">
            <h3>User List</h3>
        </div>
        <div class="offset-1 col-10 my-3">
            <form action="{{ route('users.index') }}" method="GET" class="form d-flex">
                Name::<input type="text" name="name" value="{{ request('name') }}" class="form-control mx-2">
                Email::<input type="text" name="email" value="{{ request('email') }}" class="form-control mx-2">
                From::<input type="date" name="startDate" value="{{ request('startDate') }}" class="form-control mx-2">
                To::<input type="date" name="endDate" value="{{ request('endDate') }}" class="form-control mx-2">
                <input type="submit" value="Search" class="btn btn-success mx-2">
            </form>
        </div>
        <div class="col-12">
            <table class="table table-striped">
                <tr class="table-primary">
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created User</th>
                    <th>Type</th>
                    <th>Phone</th>
                    <th>Date Of Birth</th>
                    <th>Address</th>
                    <th>Created_at</th>
                    <th>Updated_at</th>
                    <th>Operation</th>
                </tr>
                @foreach ($users as $index => $user)
                    <tr class="table">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            @if ($user->type == 1)
                                Admin
                            @else
                                User
                            @endif
                        </td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->dob }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                        <td>
                            <a class="btn btn-primary" href="" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Details
                            </a>

                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">User Details</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-4">
                                                    <img src="{{ asset('storage/' . $user->profile) }}"
                                                        alt="User's Photo">
                                                </div>
                                                <div class="col-8">
                                                    <form action="" enctype="multipart/form-data">
                                                        @csrf
                                                        <label for="" class="form-control">Name:
                                                            {{ $user->name }}</label>
                                                        <label for="" class="form-control">Email:
                                                            {{ $user->email }}</label>
                                                        <label for="" class="form-control">Phone:
                                                            {{ $user->phone }}</label>
                                                        <label for="" class="form-control">Address:
                                                            {{ $user->address }}</label>
                                                        <label for="" class="form-control">Type:
                                                            {{ $user->type == 1 ? 'Admin' : 'User' }}</label>
                                                        <label for="" class="form-control">Created User:
                                                            {{ $user->created_user }}</label>
                                                        <label for="" class="form-control">Created at:
                                                            {{ $user->created_at }}</label>
                                                        <label for="" class="form-control">Update User:
                                                            {{ $user->updated_user }}</label>
                                                        <label for="" class="form-control">Updated at:
                                                            {{ $user->updated_at }}</label>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a class="btn btn-danger" href="" data-bs-toggle="modal"
                                data-bs-target="#deleteModal">
                                Delete
                            </a>

                            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Are you sure to delete?
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <form action="" enctype="multipart/form-data">
                                                        @csrf
                                                        <label for="" class="form-control">Name:
                                                            {{ $user->name }}</label>
                                                        <label for="" class="form-control">Email:
                                                            {{ $user->email }}</label>
                                                        <label for="" class="form-control">Phone:
                                                            {{ $user->phone }}</label>
                                                        <label for="" class="form-control">Address:
                                                            {{ $user->address }}</label>
                                                        <label for="" class="form-control">Type:
                                                            {{ $user->type == 1 ? 'Admin' : 'User' }}</label>
                                                        <label for="" class="form-control">Created User:
                                                            {{ $user->created_user }}</label>
                                                        <label for="" class="form-control">Created at:
                                                            {{ $user->created_at }}</label>
                                                        <label for="" class="form-control">Update User:
                                                            {{ $user->updated_user }}</label>
                                                        <label for="" class="form-control">Updated at:
                                                            {{ $user->updated_at }}</label>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="{{ route('users.destroy', $user->id) }}"
                                                class="btn btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
amespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
public function index(Request $request)
{
$filters = $request->only(['name', 'email', 'startDate', 'endDate']);
$users = User::search($filters)->get();

return view('user.index', compact('users'));
}
}

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class User extends Model
{
// Other model methods and properties

/**
* Scope a query to filter users based on search criteria.
*
* @param \Illuminate\Database\Eloquent\Builder $query
* @param array $filters
* @return \Illuminate\Database\Eloquent\Builder
*/
public function scopeSearch(Builder $query, array $filters)
{
if (!empty($filters['name'])) {
$query->where('name', 'like', '%' . $filters['name'] . '%');
}

if (!empty($filters['email'])) {
$query->where('email', 'like', '%' . $filters['email'] . '%');
}

if (!empty($filters['startDate'])) {
$query->whereDate('created_at', '>=', $filters['startDate']);
}

if (!empty($filters['endDate'])) {
$query->whereDate('created_at', '<=', $filters['endDate']); } return $query; } }

ditailMOadl
@extends('layouts.master')
@section('content')
    <div class="row border border-dark">
        <div class="col-12 bg-success rounded">
            <h3>User List</h3>
        </div>
        <div class="offset-1 col-10 my-3">
            <form action="{{ route('users.index') }}" method="GET" class="form d-flex">
                Name::<input type="text" name="name" value="{{ request('name') }}" class="form-control mx-2">
                Email::<input type="text" name="email" value="{{ request('email') }}" class="form-control mx-2">
                From::<input type="date" name="startDate" value="{{ request('startDate') }}"
                    class="form-control mx-2">
                To::<input type="date" name="endDate" value="{{ request('endDate') }}" class="form-control mx-2">
                <input type="submit" value="Search" class="btn btn-success mx-2">
            </form>
        </div>
        <div class="col-12">
            <table class="table table-striped">
                <tr class="table-primary">
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created User</th>
                    <th>Type</th>
                    <th>Phone</th>
                    <th>Date Of Birth</th>
                    <th>Address</th>
                    <th>Created_at</th>
                    <th>Updated_at</th>
                    <th>Operation</th>
                </tr>
                @foreach ($users as $index => $user)
                    <tr class="table">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_user }}</td>
                        <td>{{ $user->type == 1 ? 'Admin' : 'User' }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->dob }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                        <td>
                            <button class="btn btn-primary btn-details" data-bs-toggle="modal"
                                data-bs-target="#userDetailsModal" data-id="{{ $user->id }}"
                                data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                data-phone="{{ $user->phone }}" data-address="{{ $user->address }}"
                                data-type="{{ $user->type == 1 ? 'Admin' : 'User' }}"
                                data-created_user="{{ $user->created_user }}" data-created_at="{{ $user->created_at }}"
                                data-updated_user="{{ $user->updated_user }}" data-updated_at="{{ $user->updated_at }}">
                                Details
                            </button>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    @include('modals.userDetailsModal')
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.btn-details').on('click', function() {
            $('#userName').text($(this).data('name'));
            $('#userEmail').text($(this).data('email'));
            $('#userPhone').text($(this).data('phone'));
            $('#userAddress').text($(this).data('address'));
            $('#userType').text($(this).data('type'));
            $('#userCreatedUser').text($(this).data('created_user'));
            $('#userCreatedAt').text($(this).data('created_at'));
            $('#userUpdatedUser').text($(this).data('updated_user'));
            $('#userUpdatedAt').text($(this).data('updated_at'));
            // Assuming profile photo URL is passed, you can handle it similarly
            // $('#userProfilePhoto').attr('src', $(this).data('profile_photo_url'));
        });
    });
</script>
<!-- resources/views/modals/userDetailsModal.blade.php -->
<div class="modal fade" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="userDetailsModalLabel">User Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <img id="userProfilePhoto" src="" alt="User's Photo" class="img-fluid">
                    </div>
                    <div class="col-8">
                        <label class="form-control">Name: <span id="userName"></span></label>
                        <label class="form-control">Email: <span id="userEmail"></span></label>
                        <label class="form-control">Phone: <span id="userPhone"></span></label>
                        <label class="form-control">Address: <span id="userAddress"></span></label>
                        <label class="form-control">Type: <span id="userType"></span></label>
                        <label class="form-control">Created User: <span id="userCreatedUser"></span></label>
                        <label class="form-control">Created at: <span id="userCreatedAt"></span></label>
                        <label class="form-control">Update User: <span id="userUpdatedUser"></span></label>
                        <label class="form-control">Updated at: <span id="userUpdatedAt"></span></label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RegisterService
{
    public function saveUser($data, $user = null)
    {
        if (is_null($user)) {
            $user = new User();
        }

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->phone = $data['phone'] ?? null;
        $user->address = $data['address'] ?? null;
        $user->dob = $data['dob'] ?? null;

        if (isset($data['profile'])) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $path = $data['profile']->store('profiles', 'public');
            $user->profile_photo_path = $path;
        }

        $user->save();

        return $user;
    }
}
