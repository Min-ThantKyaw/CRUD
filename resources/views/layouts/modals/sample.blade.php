<!DOCTYPE html>
<html>

<head>
    <title>Posts</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Posts</h1>
        <form action="{{ route('post.index') }}" method="GET">
            <div class="form-group">
                <label for="search">Search:</label>
                <input type="text" id="search" name="search" class="form-control" value="{{ $searchTerm }}">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Body</th>
                    <th>Posted By</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->body }}</td>
                        <td>{{ $post->user->name }}</td>
                        <td>{{ $post->created_at }}</td>
                        <td>
                            <button class="btn btn-danger" data-toggle="modal"
                                data-target="#deleteModal{{ $post->id }}">Delete</button>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $post->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Confirm Delete</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete the following post?</p>
                                            <strong>Title:</strong> {{ $post->title }}<br>
                                            <strong>Body:</strong> {{ $post->body }}<br>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <form action="{{ route('post.destroy', $post->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Delete Modal -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
public function index(Request $request)
{
$searchTerm = $request->input('search');
$posts = Post::search($searchTerm);

return view('post.index', compact('posts', 'searchTerm'));
}

public function destroy($id)
{
$post = Post::find($id);
if ($post) {
$post->delete();
}

return redirect()->route('post.index')->with('success', 'Post deleted successfully.');
}
}
