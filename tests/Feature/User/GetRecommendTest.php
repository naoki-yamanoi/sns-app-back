<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Fixture\UserFixture;
use Tests\Fixture\UserInfoFixture;
use Tests\TestCase;

class GetRecommendTest extends TestCase
{
    use RefreshDatabase;

    /**
     * おすすめユーザー取得成功
     */
    public function test_get_recommend_200(): void
    {
        $user1 = UserFixture::createTestData(name: 'ユーザー１', email: 'aaa@aaa.com');
        $user2 = UserFixture::createTestData(name: 'ユーザー２', email: 'bbb@bbb.com');
        $user3 = UserFixture::createTestData(name: 'ユーザー３', email: 'ccc@ccc.com');
        $user4 = UserFixture::createTestData(name: 'ユーザー４', email: 'ddd@ddd.com');
        UserInfoFixture::createTestData(user: $user1);
        UserInfoFixture::createTestData(user: $user2);
        UserInfoFixture::createTestData(user: $user3);
        UserInfoFixture::createTestData(user: $user4);

        // ログイン処理
        $request = [
            'email' => $user1->email,
            'password' => 'aaaa1111',
        ];
        $response = $this->postJson('api/login', $request);

        $response->assertStatus(200);
        $response->assertJsonPath('message', 'ログイン成功');

        // おすすめユーザー取得
        $token = $user1->createToken('YourAppName')->plainTextToken;

        $response = $this->getJson(
            uri: 'api/users/recommend',
            headers: ['Authorization' => 'Bearer '.$token]
        );

        $response->assertStatus(200);
        $this->assertEqualsCanonicalizing($response->json(), [
            [
                'id' => $user2->id,
                'name' => $user2->name,
                'comment' => $user2->userInfo->comment,
                'image' => 'http://localhost/storage/images/EvPRPJqfRE15VzVazYBPu0uFm6183NUcwdu0rW6g.png',
                'followFlg' => false,
            ],
            [
                'id' => $user3->id,
                'name' => $user3->name,
                'comment' => $user3->userInfo->comment,
                'image' => 'http://localhost/storage/images/EvPRPJqfRE15VzVazYBPu0uFm6183NUcwdu0rW6g.png',
                'followFlg' => false,
            ],
            [
                'id' => $user4->id,
                'name' => $user4->name,
                'comment' => $user4->userInfo->comment,
                'image' => 'http://localhost/storage/images/EvPRPJqfRE15VzVazYBPu0uFm6183NUcwdu0rW6g.png',
                'followFlg' => false,
            ],
        ]);
    }
}
