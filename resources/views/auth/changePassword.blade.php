@extends('layouts.master')
@section('content')
<div class="row">

    <div class="col-6 bg-light mx-auto my-2 border border-dark py-3">
        <h3 class="" >Change Password</h3>
       <form action="">
        <label for="">Old Password</label>
        <input type="password" name="oldPassword" value="" class="form-control">
        <label for="">New Password</label>
        <input type="password" name="newPassword" value="" class="form-control">
        <label for="">Confirm Password</label>
        <input type="password" name="passwordConfirmation" value="" class="form-control">
       <button type="submit" class="btn btn-success mt-2">Update</button>
       </form>
</div>
@endsection

