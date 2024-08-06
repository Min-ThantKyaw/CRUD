@extends('layouts.master')
@section('content')
    <div class="row border border-dark">
        <div class="col-12 bg-success rounded">
            <h3>User List</h3>
        </div>
        <div class=" offset-1 col-10 my-3">
            <form action="" class="form d-flex">
                Name::<input type="text" class="form-control mx-2">
                Emial::<input type="text" class="form-control">
                From::<input type="date" id="start" name="startDate" value="" class="form-control mx-2">
                to::<input type="date" id="start" name="endDate" value="" class="form-control">
                <input type="submit" value="Search" class="btn btn-success mx-2">
            </form>
        </div>
        <div class="col-12">
            <table class="table table-striped">
                <tr class="table-primary">
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created User</th>
                    <th>Type</th>
                    <th>Phone</th>
                    <th>Date Of Birth</th>
                    <th>Address</th>
                    <th>Created_at</th>
                    <th>Updated_at</th>
                    <th>Operation</th>
                </tr>
                @foreach ($users as $index => $user)
                    <tr class="table">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            {{ $user->type == 1 ? 'Admin' : 'User' }}

                        </td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->dob }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                        <td>
                            <!-- Button trigger modal -->
                            <a class="btn btn-primary" href="" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Details
                            </a>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">User Details</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-4">
                                                    <img src="" alt="User's Photo">
                                                </div>
                                                <div class="col-8">
                                                    <form action="" enctype="multipart/form-data">
                                                        @csrf
                                                        <label for="" class="form-control">Name:</label>
                                                        <label for="" class="form-control">Emial:</label>
                                                        <label for="" class="form-control">Phone:</label>
                                                        <label for="" class="form-control">Address</label>
                                                        <label for="" class="form-control">Type:</label>
                                                        <label for="" class="form-control">Created_User:</label>
                                                        <label for="" class="form-control">Created_at:</label>
                                                        <label for="" class="form-control">Update User:</label>
                                                        <label for="" class="form-control">Updated_at:</label>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Delete Confirm Modal --}}
                            <a class="btn btn-danger" href="" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                Delete
                            </a>

                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Are you sure to delete?</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <form action="" enctype="multipart/form-data">
                                                        @csrf
                                                        <label for="" class="form-control">Name:</label>
                                                        <label for="" class="form-control">Emial:</label>
                                                        <label for="" class="form-control">Phone:</label>
                                                        <label for="" class="form-control">Address</label>
                                                        <label for="" class="form-control">Type:</label>
                                                        <label for="" class="form-control">Created_User:</label>
                                                        <label for="" class="form-control">Created_at:</label>
                                                        <label for="" class="form-control">Update User:</label>
                                                        <label for="" class="form-control">Updated_at:</label>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="" class="btn btn-danger">Delete</a>
                                            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Delete</button> --}}

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>

                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
