@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-6 mx-auto border border-dark py-3 ">
            <div class="bg-success rounded-top">
                <h4>Create Post</h4>
            </div>
            <div class="bg-light">
                <form action="">
                    <label for="">Title</label>
                    <input type="text" name="title" value="" class="form-control" disabled>
                    <label for="" class="my-2">Description</label>
                    <input type="text" name="description" value="" class="form-control" disabled>
                    <div>
                        <input type="submit" value="Confirm" class="btn btn-success my-2">
                        {{-- <a href="{{ route('user.userCreatePage')->withInput($data) }}">Cancel</a> --}}
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
