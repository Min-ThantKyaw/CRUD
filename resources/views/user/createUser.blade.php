@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-6 mx-auto border border-dark py-3">
            <div class="bg-success rounded-top">
                <h4>Register</h4>
            </div>
            <div class="bg-light">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control">
                    @error('name')
                        <small class="alert text-danger">{{ $message }}</small><br>
                    @enderror
                    <label for="" class="my-2">Email Address</label>
                    <input type="text" name="email" class="form-control">
                    @error('email')
                        <small class="alert text-danger">{{ $message }}</small><br>
                    @enderror
                    <label for="" class="my-2">Password</label>
                    <input type="password" name="password" class="form-control">
                    @error('password')
                        <small class="alert text-danger">{{ $message }}</small><br>
                    @enderror
                    <label for="" class="my-2">Password Confirmation</label>
                    <input type="password" name="password_confirmation" class="form-control">
                    @error('password')
                        <small class="alert text-danger">{{ $message }}</small><br>
                    @enderror

                    @if (Auth::check() && Auth::user()->type == 1)
                        <label for="" class="my-2">Type</label>
                        <select name="type" class="form-select" id="type" aria-label="Default select example">
                            <option value="0">User</option>
                            <option value="1">Admin</option>
                        </select>
                    @endif

                    <label for="" class="my-2">Phone</label>
                    <input type="text" name="phone" class="form-control">
                    @error('phone')
                        <small class="alert text-danger">{{ $message }}</small><br>
                    @enderror
                    <label for="" class="my-2">Date Of Birth</label>
                    <input type="date" id="start" name="dob" value="" class="form-control">
                    @error('dob')
                        <small class="alert text-danger">{{ $message }}</small><br>
                    @enderror
                    <label for="">Address</label>
                    <input type="text" name="address" class="form-control">
                    @error('address')
                        <small class="alert text-danger">{{ $message }}</small><br>
                    @enderror
                    <label for="">Profile</label>
                    <input type="file" name="profile" class="form-control">
                    @error('profile')
                        <small class="alert text-danger">{{ $message }}</small><br>
                    @enderror
                    <div>
                        <input type="submit" value="Register" class="btn btn-success my-2">
                        <input type="submit" value="Clear" class="btn btn-secondary my-2">
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
