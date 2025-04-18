<?php

namespace Tests\Fixture;

use App\Models\Post;
use App\Models\User;

class PostFixture
{
    public static function createTestData(
        User $user,
        $post = '投稿です。投稿です。投稿です。',
    ) {
        return Post::create([
            'user_id' => $user->id,
            'post' => $post,
        ]);
    }
}
