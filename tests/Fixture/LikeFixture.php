<?php

namespace Tests\Fixture;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;

class LikeFixture
{
    public static function createTestData(
        User $user,
        Post $post,
    ) {
        return Like::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }
}
