<?php

namespace Tests\Fixture;

use App\Models\User;

class UserFixture
{
    public static function createTestData(
        $name = 'テストユーザー１',
        $email = 'aaa@aaa.com',
        $password = 'aaaa1111'
    ) {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
    }
}
