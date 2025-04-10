<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function getFollowPosts()
    {
        $followPosts = Post::all();

        return response()->json([
            'followPosts' => $followPosts,
        ]);
    }
}
