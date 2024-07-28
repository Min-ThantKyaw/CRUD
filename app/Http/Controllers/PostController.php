<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function postListPage()
    {
        return view('post.postList');
    }
}
