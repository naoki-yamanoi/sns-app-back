<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * ログイン成功
     */
    public function test_login_200(): void
    {
        $request = [
            'email' => 'aaa@example.com',
            'password' => 'aaaa1111',
        ];

        $response = $this->post('api/login', $request);

        $response->assertStatus(200);
        $response->assertJsonPath('message', 'ログイン成功');
        $response->assertJsonStructure([
            'message',
            'token',
        ]);
    }
}
