@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-6 mx-auto border border-dark py-3">
            <div class="bg-success rounded-top ">
                <h4>Create Post</h4>
            </div>
            <div class="bg-light">
                <form action="{{ route('post.add') }}" method="post">
                    @csrf
                    <label for="">Title</label>
                    <input type="text" name="title" class="form-control">
                    <label for="" class="my-2">Description</label>
                    <input type="text" name="body" class="form-control">
                    <div>
                        <input type="submit" value="Create" class="btn btn-success my-2">
                        <a href="{{ route('post.postlist') }}" class="btn btn-primary">Cancel</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
