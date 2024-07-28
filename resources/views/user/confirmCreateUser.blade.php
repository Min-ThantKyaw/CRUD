@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-6 mx-auto border border-dark py-3">
        <div class="bg-success rounded-top">
            <h4>Register</h4>
        </div>
        <div class="bg-light">
            <form action="">
                <label for="">Name</label>
                <input type="text" name="name" class="form-control" disabled>
                <label for="" class="my-2">Email Address</label>
                <input type="text" name="email" class="form-control" disabled>
                <label for="" class="my-2">Password</label>
                <input type="password" name="password" class="form-control" disabled>
                <label for="" class="my-2">Password Confirmation</label>
                <input type="password" name="password_confirmation" class="form-control" disabled>
                <label for="" class="my-2">Type</label>
                <select class="form-select" disabled>
                    <option value="">User</option>
                    <option value="">Admin</option>


                  </select>
                  <label for="" class="my-2">Phone</label>
                <input type="text" name="phone" class="form-control" disabled>
                <label for="" class="my-2">Date Of Birth</label>
                <input type="date" id="start" name="dob" value="" class="form-control" disabled>
                <label for="">Address</label>
                <input type="text" name="address" class="form-control" disabled>
                <label for="">Profile</label>
                <input type="file" name="profile" class="form-control" disabled>
               <div>
                <input type="submit" value="Confirm" class="btn btn-success my-2">
                <input type="submit" value="Cancel" class="btn btn-secondary my-2">
               </div>

            </form>
        </div>
        </div>
    </div>

@endsection
