namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class PostController extends Controller
{
// Show the form for creating a new post
public function create()
{
return view('posts.create');
}

// Show the form for editing an existing post
public function edit($id)
{
$post = Post::find($id);

if (!$post) {
return redirect()->back()->with('error', 'Post not found.');
}

return view('posts.edit', compact('post'));
}

// Store a newly created or updated post
public function store(Request $request, $id = null)
{
// Validate the request data
$request->validate([
'title' => 'required|string|max:255',
'body' => 'required|string',
]);

if ($id) {
// Update existing post
$post = Post::find($id);

if (!$post) {
return redirect()->back()->with('error', 'Post not found.');
}

$post->title = $request->input('title');
$post->body = $request->input('body');
$post->updated_user_id = Auth::id(); // Store the ID of the user who updated the post
$post->save();

return redirect()->route('post.postlist')->with('success', 'Post updated successfully.');
} else {
// Create new post
$post = new Post();
$post->title = $request->input('title');
$post->body = $request->input('body');
$post->created_user_id = Auth::id(); // Store the ID of the user who created the post
$post->save();

return redirect()->route('post.postlist')->with('success', 'Post created successfully.');
}
}
}
