<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use App\Http\Requests\PostCreateRequest;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function postListPage(Request $request)
    {
        $user = Auth::user();
        $searchTerm = $request->input('searchKey');

        $query = Post::query();

        if ($user->type != 1) {
            $query->where('created_user_id', $user->id);
        }

        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('body', 'LIKE', "%{$searchTerm}%");
            });
        }

        $posts = $query->get();

        return view('post.postList', compact('posts', 'searchTerm'));
    }

    public function postCreatePage()
    {
        return view('post.createPost');
    }

    protected $postService;
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    public function postAdd(PostCreateRequest $request)
    {
        try {
            $post = $this->postService->postAdd($request->validated());

            return redirect()->route('post.postlist')->with('success', 'Post Creation Success.');
        } catch (\Exception $e) {
            return response()->json();
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }
}
