<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Fixture\UserFixture;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ログアウト成功
     */
    public function test_logout_200(): void
    {
        $user = UserFixture::createTestData();
        $token = $user->createToken('YourAppName')->plainTextToken;

        // ログアウト処理
        $response2 = $this->postJson(
            uri: 'api/logout',
            headers: ['Authorization' => 'Bearer '.$token]
        );
        $response2->assertStatus(200);
        $response2->assertJsonPath('message', 'ログアウトしました。');
        $response2->assertJsonStructure(['message']);
    }

    /**
     * ログアウト失敗（トークンを作っていない）
     */
    public function test_fail_logout_500(): void
    {
        $user = UserFixture::createTestData();

        // ログアウト処理
        $response = $this->postJson('api/logout');
        $response->assertStatus(401);
        $response->assertJsonPath('message', 'Unauthenticated.');
        $response->assertJsonStructure(['message']);
    }
}
