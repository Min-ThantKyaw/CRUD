<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use App\Http\Requests\PostCreateRequest;

class PostController extends Controller
{
    public function postListPage(Request $request)
    {
        $searchTerm = $request->input('searchKey');
        $post = new Post();
        $posts = $post->search($searchTerm);
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
