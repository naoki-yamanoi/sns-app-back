<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ユーザー登録成功
     */
    public function test_register_user_200(): void
    {
        // まだ作成されていない
        $user = User::where('email', 'test111@test.com')->first();
        $this->assertFalse((bool) $user);

        // 登録処理
        $response = $this->postJson('api/register', [
            'name' => 'テストユーザー',
            'email' => 'test111@test.com',
            'password' => 'abc123456',
        ]);
        $response->assertStatus(200);
        $response->assertJsonPath('message', '新規登録に成功しました。');

        // 作成されているかどうか
        $createdUser = User::where('email', 'test111@test.com')->first();
        $this->assertTrue((bool) $createdUser);
    }
}
