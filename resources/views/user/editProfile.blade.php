@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-8 bg-success rounded  mx-auto">
            <h3 class="">Profile</h3>
        </div>
        <div class="col-8 bg-light mx-auto my-2 border border-dark py-3">
            <form action="" method="POST" id="profileUpdateForm">
                @csrf
                @if ($user->profile)
                    <img src="{{ asset('storage/' . $user->profile) }}" alt="Profile Photo" class="img-fluid rounded-circle">
                @else
                    <img src="{{ asset('images/default_photo.png') }}" alt="Profile Photo"
                        class="img-fluid rounded-circle"><br>
                @endif
                <label for="">Name</label>
                <input type="text" name="" value="{{ $user->name }}" class="form-control">
                <label for="">Email</label>
                <input type="email" name="" value="{{ $user->email }}" class="form-control">
                <label for="">Phone</label>
                <input type="text" name="" value="{{ $user->phone }}" class="form-control">
                <label for="">Address</label>
                <input type="text" name="" value="{{ $user->address }}" class="form-control">
                <label for="">DOB</label>
                <input type="date" name="" value="{{ $user->dob }}" class="form-control">
                <label for="">Choose New Profile</label>
                <input type="file" name="image" value="" class="form-control">
                <div class="mt-2">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-primary" id="formReset">Clear</button>
                    <a href="">Change Password?</a>
                </div>
            </form>
        </div>
    @endsection
