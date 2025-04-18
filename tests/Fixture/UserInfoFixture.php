<?php

namespace Tests\Fixture;

use App\Models\User;
use App\Models\UserInfo;

class UserInfoFixture
{
    public static function createTestData(
        User $user,
        $image = 'images/EvPRPJqfRE15VzVazYBPu0uFm6183NUcwdu0rW6g.png',
        $comment = '自己紹介コメントです。'
    ) {
        return UserInfo::create([
            'user_id' => $user->id,
            'image' => $image,
            'comment' => $comment,
        ]);
    }
}
