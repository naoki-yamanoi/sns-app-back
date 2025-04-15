<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostFollowResource;
use App\Http\Resources\PostLikeResource;
use App\Http\Resources\PostMineResource;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        $myPosts = $user->posts()->orderBy('posts.created_at', 'desc')->get();

        return PostMineResource::collection($myPosts);
    }

    public function getLikePosts()
    {
        $user = Auth::user();
        // いいねしている投稿全て取得
        $likePosts = $user->likes()->orderBy('likes.created_at', 'desc')->get();

        return PostLikeResource::collection($likePosts);
    }

    public function createPost(Request $request)
    {
        $user = Auth::user();
        try {
            // 新規投稿作成
            Post::create(['user_id' => $user->id, 'post' => $request->post]);

            return response()->json([
                'message' => '新規投稿を作成しました。',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => '新規投稿の作成に失敗しました。',
            ]);
        }
    }
}
