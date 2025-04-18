<?php

namespace Tests\Fixture;

use App\Models\Follow;
use App\Models\User;

class FollowFixture
{
    public static function createTestData(
        User $user,
        User $followedUser,
    ) {
        return Follow::create([
            'follow_id' => $user->id,
            'followed_id' => $followedUser->id,
        ]);
    }
}
