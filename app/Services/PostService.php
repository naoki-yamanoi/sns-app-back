<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function getFollows()
    {
        $user = Auth::user();
        // フォローしているユーザーID全て取得
        $followUserIds = $user->follows()->pluck('follows.followed_id');

        // フォローしているユーザー投稿全て取得
        return Post::whereIn('user_id', $followUserIds)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getMine()
    {
        $user = Auth::user();

        // 自分の投稿全て取得
        return $user->posts()->orderBy('posts.created_at', 'desc')->get();
    }

    public function getLikes()
    {
        $user = Auth::user();

        // いいねしている投稿全て取得
        return $user->likes()->orderBy('likes.created_at', 'desc')->get();
    }

    public function getSearch($keyword)
    {
        // キーワードが含まれる投稿全て取得
        return $keyword ? Post::where('post', 'LIKE', '%'.$keyword.'%')->get() : collect();
    }

    public function create($post)
    {
        $user = Auth::user();
        // 新規投稿作成
        Post::create(['user_id' => $user->id, 'post' => $post]);
    }
}
