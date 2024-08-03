@extends('layouts.master')
@section('content')
    <div class="row border border-dark">
        <div class="col-12 bg-success rounded">
            <h3>Post List</h3>
        </div>
        <div class="col-12 d-flex justify-content-between my-3">
            <form action="">
                <a href="{{ route('post.postCreatePage') }}" class="btn btn-success">Create</a>
            </form>
            <form action="{{ route('post.postlist') }}" method="GET" class="form d-flex">
                Keyword::<input type="text" name="searchKey" class="form-control me-2">
                <input type="submit" value="Search" class="btn btn-success">
            </form>
            <form action="{{ route('post.upload') }}" method="POST" enctype="multipart/form-data" class="d-flex">
                @csrf
                <input type="file" name="csv_file" id="csv_file" class="form-control">
                <button type="submit" class="btn btn-success">Upload</button>
            </form>
            <form action="">
                <a href="{{ route('post.download', ['searchKey' => $searchTerm]) }}" class="btn btn-success">Download
                    Excel</a>
            </form>

        </div>
        <div class="col-12">
            <table class="table table-striped">
                <tr class="table-primary">
                    <th>Post Title</th>
                    <th>Post Description</th>
                    <th>Posted User</th>
                    <th>Posted Created</th>
                    <th>Operation</th>
                </tr>
                @foreach ($posts as $post)
                    <tr class="table">

                        <td>
                            <a class="text-decoration-none" href="#" data-bs-toggle="modal"
                                data-bs-target="#detailsModal" class="btn-details" data-id="{{ $post->id }}"
                                data-title="{{ $post->title }}" data-body="{{ $post->body }}"
                                data-user="{{ $post->created_user_id ? $post->user->name : 'Unknown' }}"
                                data-created="{{ $post->created_at }}">
                                {{ $post->title }}
                            </a>
                        </td>
                        <td>{{ $post->body }}</td>
                        <td>{{ $post->user->name }}</td>
                        <td>{{ $post->created_at }}</td>
                        <td>
                            <a href="" class="btn btn-info">Edit</a>
                            <a class="text-decoration-none btn btn-danger" href="" data-bs-toggle="modal"
                                data-bs-target="#delete">
                                Delete
                            </a>
                        </td>

                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    @include('layouts.modals.postDelete');
    @include('layouts.modals.postDetails')
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.btn-details').on('click', function() {
            var postId = $(this).data('id'); // Get the ID of the post
            var postTitle = $(this).data('title'); // Get the title of the post
            var postBody = $(this).data('body'); // Get the body of the post
            var postUser = $(this).data('user'); // Get the name of the user
            var postCreated = $(this).data('created'); // Get the created date

            // Populate the modal with post details
            $('#postTitle').text(postTitle);
            $('#postBody').text(postBody);
            $('#postUser').text(postUser);
            $('#postCreated').text(postCreated);

            // Show the modal
            $('#detailsModal').modal('show');
        });
    });
</script>
