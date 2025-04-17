<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Fixture\UserFixture;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ログイン成功
     */
    public function test_login_200(): void
    {
        $user = UserFixture::createTestData();

        $request = [
            'email' => $user->email,
            'password' => 'aaaa1111',
        ];

        $response = $this->postJson('api/login', $request);

        $response->assertStatus(200);
        $response->assertJsonPath('message', 'ログイン成功');
        $response->assertJsonStructure(['message', 'token']);
    }

    /**
     * ログイン失敗（emailがnull）
     */
    public function test_login_none_email_422(): void
    {
        $user = UserFixture::createTestData();

        $request = [
            'email' => null,
            'password' => 'aaaa1111',
        ];

        $response = $this->postJson('api/login', $request);

        $response->assertStatus(422);
        $response->assertJsonPath('message', 'メールアドレスは必須です。');
        $response->assertJsonPath('errors.email.0', 'メールアドレスは必須です。');
        $response->assertJsonStructure(['message', 'errors']);
    }

    /**
     * ログイン失敗（emailの形式が違う）
     */
    public function test_login_not_email_422(): void
    {
        $user = UserFixture::createTestData();

        $request = [
            'email' => 'aaaaaacom',
            'password' => 'aaaa1111',
        ];

        $response = $this->postJson('api/login', $request);

        $response->assertStatus(422);
        $response->assertJsonPath('message', 'メールアドレスの形式が正しくありません。');
        $response->assertJsonPath('errors.email.0', 'メールアドレスの形式が正しくありません。');
        $response->assertJsonStructure(['message', 'errors']);
    }

    /**
     * ログイン失敗（passwordがnull）
     */
    public function test_login_none_password_422(): void
    {
        $user = UserFixture::createTestData();

        $request = [
            'email' => $user->email,
            'password' => null,
        ];

        $response = $this->postJson('api/login', $request);

        $response->assertStatus(422);
        $response->assertJsonPath('message', 'パスワードは必須です。');
        $response->assertJsonPath('errors.password.0', 'パスワードは必須です。');
        $response->assertJsonStructure(['message', 'errors']);
    }

    /**
     * ログイン失敗（passwordが8文字未満）
     */
    public function test_login_not_min_password_422(): void
    {
        $user = UserFixture::createTestData();

        $request = [
            'email' => $user->email,
            'password' => 'aaaa11',
        ];

        $response = $this->postJson('api/login', $request);

        $response->assertStatus(422);
        $response->assertJsonPath('message', 'パスワードは8文字以上である必要があります。');
        $response->assertJsonPath('errors.password.0', 'パスワードは8文字以上である必要があります。');
        $response->assertJsonStructure(['message', 'errors']);
    }

    /**
     * ログイン失敗（emailが存在しない値）
     */
    public function test_login_not_email_401(): void
    {
        $user = UserFixture::createTestData();

        $request = [
            'email' => 'not@aaa.com',
            'password' => 'aaaa1111',
        ];

        $response = $this->postJson('api/login', $request);

        $response->assertStatus(401);
        $response->assertJsonPath('message', 'ログインに失敗しました。');
        $response->assertJsonStructure(['message']);
    }

    /**
     * ログイン失敗（passwordが存在しない値）
     */
    public function test_login_not_password_401(): void
    {
        $user = UserFixture::createTestData();

        $request = [
            'email' => $user->email,
            'password' => 'aaaa1122',
        ];

        $response = $this->postJson('api/login', $request);

        $response->assertStatus(401);
        $response->assertJsonPath('message', 'ログインに失敗しました。');
        $response->assertJsonStructure(['message']);
    }
}
