<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class LikeService
{
    public function create($postId)
    {
        $user = Auth::user();
        $user->likes()->attach($postId);
    }

    public function delete($postId)
    {
        $user = Auth::user();
        $user->likes()->detach($postId);
    }
}
