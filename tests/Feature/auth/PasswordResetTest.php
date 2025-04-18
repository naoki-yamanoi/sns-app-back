<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Fixture\UserFixture;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * パスワードリセット成功
     */
    public function test_password_reset_200(): void
    {
        $user = UserFixture::createTestData();

        // パスワードリセット処理
        $response = $this->postJson('api/password/reset', [
            'email' => $user->email,
            'old_password' => 'aaaa1111',
            'new_password' => 'aabb1122',
            'new_password_confirmation' => 'aabb1122',
        ]);
        $response->assertStatus(200);
        $response->assertJsonPath('message', 'パスワードリセットに成功しました。');
    }

    /**
     * パスワードリセット失敗（emailがnull）
     */
    public function test_password_reset_null_email_422(): void
    {
        $user = UserFixture::createTestData();

        // パスワードリセット処理
        $response = $this->postJson('api/password/reset', [
            'email' => null,
            'old_password' => 'aaaa1111',
            'new_password' => 'aabb1122',
            'new_password_confirmation' => 'aabb1122',
        ]);
        $response->assertStatus(422);
        $response->assertJsonPath('message', 'メールアドレスは必須です。');
    }

    /**
     * パスワードリセット失敗（old_passwordがnull）
     */
    public function test_password_reset_null_old_password_422(): void
    {
        $user = UserFixture::createTestData();

        // パスワードリセット処理
        $response = $this->postJson('api/password/reset', [
            'email' => $user->email,
            'old_password' => null,
            'new_password' => 'aabb1122',
            'new_password_confirmation' => 'aabb1122',
        ]);
        $response->assertStatus(422);
        $response->assertJsonPath('message', '旧パスワードは必須です。');
    }

    /**
     * パスワードリセット失敗（new_passwordがnull）
     */
    public function test_password_reset_null_new_password_422(): void
    {
        $user = UserFixture::createTestData();

        // パスワードリセット処理
        $response = $this->postJson('api/password/reset', [
            'email' => $user->email,
            'old_password' => 'aaaa1111',
            'new_password' => null,
            'new_password_confirmation' => 'aabb1122',
        ]);
        $response->assertStatus(422);
        $response->assertJsonPath('message', '新パスワードは必須です。');
    }

    /**
     * パスワードリセット失敗（emailの形式が正しくない。）
     */
    public function test_password_reset_not_email_422(): void
    {
        $user = UserFixture::createTestData();

        // パスワードリセット処理
        $response = $this->postJson('api/password/reset', [
            'email' => 'aaabbbccc',
            'old_password' => 'aaaa1111',
            'new_password' => 'aabb1122',
            'new_password_confirmation' => 'aabb1122',
        ]);
        $response->assertStatus(422);
        $response->assertJsonPath('message', 'メールアドレスの形式が正しくありません。');
    }

    /**
     * パスワードリセット失敗（old_passwordが8文字未満）
     */
    public function test_password_reset_not_min_old_password_422(): void
    {
        $user = UserFixture::createTestData();

        // パスワードリセット処理
        $response = $this->postJson('api/password/reset', [
            'email' => $user->email,
            'old_password' => 'aa1111',
            'new_password' => 'aabb1122',
            'new_password_confirmation' => 'aabb1122',
        ]);
        $response->assertStatus(422);
        $response->assertJsonPath('message', '旧パスワードは8文字以上である必要があります。');
    }

    /**
     * パスワードリセット失敗（new_passwordが8文字未満、パスワード確認と一致しない）
     */
    public function test_password_reset_not_min_and_not_same_new_password_422(): void
    {
        $user = UserFixture::createTestData();

        // パスワードリセット処理
        $response = $this->postJson('api/password/reset', [
            'email' => $user->email,
            'old_password' => 'aaaa1111',
            'new_password' => 'ab1122',
            'new_password_confirmation' => 'aabb1122',
        ]);
        $response->assertStatus(422);
        $response->assertJsonPath('errors.new_password.0', '新パスワードは8文字以上である必要があります。');
        $response->assertJsonPath('errors.new_password.1', 'パスワード確認と一致しません。');
    }

    /**
     * パスワードリセット失敗（該当ユーザーが存在しない）
     */
    public function test_password_reset_none_user_404(): void
    {
        $user = UserFixture::createTestData();

        // パスワードリセット処理
        $response = $this->postJson('api/password/reset', [
            'email' => 'testtest@test.com',
            'old_password' => 'aaaa1111',
            'new_password' => 'aabb1122',
            'new_password_confirmation' => 'aabb1122',
        ]);
        $response->assertStatus(404);
        $response->assertJsonPath('message', '該当ユーザーが存在しません。');
    }

    /**
     * パスワードリセット失敗（パスワードが一致しない。）
     */
    public function test_password_reset_not_same_password_422(): void
    {
        $user = UserFixture::createTestData();

        // パスワードリセット処理
        $response = $this->postJson('api/password/reset', [
            'email' => $user->email,
            'old_password' => 'aacc1133',
            'new_password' => 'aabb1122',
            'new_password_confirmation' => 'aabb1122',
        ]);
        $response->assertStatus(422);
        $response->assertJsonPath('message', '現在のパスワードが正しくありません。');
    }
}
