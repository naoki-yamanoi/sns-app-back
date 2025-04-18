<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Fixture\UserFixture;
use Tests\Fixture\UserInfoFixture;
use Tests\TestCase;

class EditProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * プロフィール編集成功（comment,imageがnull）
     */
    public function test_edit_profile_200(): void
    {
        $user = UserFixture::createTestData(name: 'ユーザー１', email: 'aaa@aaa.com');
        UserInfoFixture::createTestData(user: $user);

        // ログイン処理
        $request = [
            'email' => $user->email,
            'password' => 'aaaa1111',
        ];
        $response = $this->postJson('api/login', $request);

        $response->assertStatus(200);
        $response->assertJsonPath('message', 'ログイン成功');

        // プロフィール編集
        $token = $user->createToken('YourAppName')->plainTextToken;

        $response = $this->postJson(
            uri: 'api/user/profile/edit',
            data: [
                'userName' => 'ユーザー１変更後',
                'comment' => null,
                'userImage' => null,
            ],
            headers: ['Authorization' => 'Bearer '.$token]
        );

        $response->assertStatus(200);
        $response->assertJsonPath('message', 'プロフィール更新に成功しました。');

        // 変更されているかどうか
        $updatedUser = User::where('email', 'aaa@aaa.com')->first();
        $this->assertSame($updatedUser->name, 'ユーザー１変更後');
    }
}
