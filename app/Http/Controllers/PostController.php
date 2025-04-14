<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostFollowResource;
use App\Http\Resources\PostMineResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function getFollowPosts()
    {
        $user = Auth::user();
        // フォローしているユーザーID全て取得
        $followUserIds = $user->follows()->pluck('follows.followed_id');

        // フォローしているユーザー投稿全て取得
        $followPosts = Post::whereIn('user_id', $followUserIds)
            ->orderBy('created_at', 'desc')
            ->get();

        return PostFollowResource::collection($followPosts);
    }

    public function getMyPosts()
    {
        $user = Auth::user();
        // 自分の投稿全て取得
        $myPosts = $user->posts()->get();

        return PostMineResource::collection($myPosts);
    }

    public function createPost(Request $request)
    {
        $user = Auth::user();
        // 新規投稿作成
        Post::create(['user_id' => $user->id, 'post' => $request->post]);

        return response()->json([
            'message' => '新規投稿を作成しました。',
        ]);
    }
}
