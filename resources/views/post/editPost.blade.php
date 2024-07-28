@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-6 mx-auto border border-dark py-3">
        <div class="bg-success rounded-top ">
            <h4>Edit Post</h4>
        </div>
        <div class="bg-light">
            <form action="">
                <label for="">Title</label>
                <input type="text" name="title" value="" class="form-control">
                <label for="" class="my-2">Description</label>
                <input type="text" name="description" value="" class="form-control">
                <label for="">Status</label>
                <input type="checkbox" name="status">
               <div>
                {{-- //Go To Edit confrim page --}}
                <input type="submit" value="Edit"  class="btn btn-success my-2">
                {{-- //To Clear Form Data --}}
                <input type="submit" value="Clear" class="btn btn-secondary my-2">
               </div>

            </form>
        </div>
        </div>
    </div>
@endsection
