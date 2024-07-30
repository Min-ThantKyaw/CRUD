<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class PostService
{

    public function postAdd($data)
    {
        try {
            $post = new Post();
            $post->title = $data['title'];
            $post->body = $data['body'];
            $post->created_user_id = Auth::id();
            $post->updated_user_id = null;

            $post->save();

            Log::info('Post created successfully', ['post' => $post]);

            return $post;
        } catch (Exception $e) {
            Log::error('Error saving post', ['error' => $e->getMessage()]);
            throw new Exception('Error saving post.');
        }
    }
}
