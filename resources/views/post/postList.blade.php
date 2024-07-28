@extends('layouts.master')
@section('content')
<div class="row border border-dark">
    <div class="col-12 bg-success rounded">
        <h3>Post List</h3>
    </div>
    <div class=" offset-1 col-10 d-flex justify-content-between my-3">
<form action="" class="form d-flex">
    Keyword::<input type="" class="form-control me-2">
    <input type="submit" value="Search" class="btn btn-success">
</form>

    <button class="btn btn-success">Create</button>
    <button class="btn btn-success">Upload</button>
    <button class="btn btn-success"> Download</button>

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
        <tr class="table">
            <td>
                             <!-- Button trigger modal -->
<a  class="text-decoration-none" href="" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Details
  </a>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Post Details</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                    <form action="" enctype="multipart/form-data">
                        @csrf
                        <label for="" class="form-control">Title:</label>
                        <label for="" class="form-control">Description:</label>
                        <label for="" class="form-control">Status:</label>
                        <label for="" class="form-control">Created Date:</label>
                        <label for="" class="form-control">Created_User:</label>
                        <label for="" class="form-control">Updated:</label>
                        <label for="" class="form-control">Update User:</label>
                      </form>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

        </div>
      </div>
    </div>
  </div>
            </td>
            <td>Description1</td>
            <td>Min Thant Kyaw</td>
            <td>2024/07/22</td>
            <td>
                <a href="" class="btn btn-info">Edit</a>
                <a  class="text-decoration-none btn btn-danger" href="" data-bs-toggle="modal" data-bs-target="#delete">
                    Delete
                  </a>

                  <!-- Modal -->
                  <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Are you sure to delete?</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                                    <form action="" enctype="multipart/form-data">
                                        @csrf
                                        <label for="" class="form-control">Title:</label>
                                        <label for="" class="form-control">Description:</label>
                                        <label for="" class="form-control">Status:</label>
                                        <label for="" class="form-control">Created Date:</label>
                                        <label for="" class="form-control">Created_User:</label>
                                        <label for="" class="form-control">Updated:</label>
                                        <label for="" class="form-control">Update User:</label>
                                      </form>


                        </div>
                        <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                         <a href="" class="btn btn-danger">Delete</a>
                        </div>
                      </div>
                    </div>
                  </div>

            </td>
        </tr>
      </table>
</div>
</div>
@endsection
