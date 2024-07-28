@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-8 bg-success rounded  mx-auto">
            <h3 class="">Profile</h3>
        </div>
        <div class="col-8 bg-light mx-auto my-2 border border-dark py-3">
            <form action="">
                <label for="">Name</label>
                <input type="text" name="name" value="{{ $authUser->name }}" class="form-control" disabled>
                <label for="">Email</label>
                <input type="email" name="email" value="{{ $authUser->email }}" class="form-control" disabled>
                <label for="">Phone</label>
                <input type="text" name="" value="{{ $authUser->phone }}" class="form-control" disabled>
                <label for="">Address</label>
                <input type="text" name="" value="{{ $authUser->address }}" class="form-control" disabled>
                <label for="">DOB</label>
                <input type="date" name="" value="{{ $authUser->dob }}" class="form-control" disabled>
                <label for="">Type</label>
                <input type="text" name=""
                    value="{{ $authUser->type == 1 ? 'Admin' : 'User' }}"class="form-control" disabled>
                @if ($authUser->profile)
                    <img src="{{ asset('storage/' . $user->profile) }}" alt="Profile Photo"
                        class="img-fluid rounded-circle">
                @else
                    <img src="{{ asset('images/default_photo.png') }}" alt="Profile Photo"
                        class="img-fluid rounded-circle"><br>
                @endif
                <div class="mt-2">
                    <a href="{{ route('user.profileEdit') }}" class="btn btn-success">Edit</a>
                    <a href="{{ route('user.userlist') }}" class="btn btn-success">Back</a>
                </div>
            </form>
        </div>
    @endsection
