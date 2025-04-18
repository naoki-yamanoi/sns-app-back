<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Fixture\UserFixture;
use Tests\TestCase;

class GetIdTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ユーザーid取得成功
     */
    public function test_get_user_id_200(): void
    {
        // ログイン処理
        $user = UserFixture::createTestData();
        $request = [
            'email' => $user->email,
            'password' => 'aaaa1111',
        ];
        $response = $this->postJson('api/login', $request);
        $response->assertStatus(200);
        $response->assertJsonPath('message', 'ログイン成功');
        $response->assertJsonStructure(['message', 'token']);

        // ログインユーザーID取得
        $token = $user->createToken('YourAppName')->plainTextToken;
        $response = $this->getJson(
            uri: 'api/user',
            headers: ['Authorization' => 'Bearer '.$token]
        );
        $this->assertSame($response->json(), $user->id);
    }
}
