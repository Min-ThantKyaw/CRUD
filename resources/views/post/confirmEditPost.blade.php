@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-6 mx-auto border border-dark py-3 ">
            <div class="bg-success rounded-top">
                <h4>Edit Post</h4>
            </div>
            <div class="bg-light">
                <form action="{{ route('posts.update', $post->id) }}" method="POST">
                    @csrf
                    <label for="">{{ $updatePost['title'] }}</label>
                    <input type="hidden" name="title" value="{{ $updatePost['title'] }}" class="form-control">
                    <label for="" class="my-2">Description</label>
                    <input type="hidden" name="body" value="{{ $updatePost['body'] }}" class="form-control">
                    <label for="">{{ $updatePost['body'] }}</label>
                    {{-- <input type="checkbox" @if ($updatePost['status'] == 1) checked @endif> --}}
                    <div>
                        {{-- To Update Post Data --}}
                        <input type="submit" value="Update" class="btn btn-success my-2">
                        {{-- //Return back to edit post page --}}
                        <a href="{{ route('post.edit', $post->id) }}">Cancel</a>

                </form>
            </div>
        </div>
    </div>
@endsection
