<?php

namespace Tests\Feature;

use Tests\TestCase;

class IndexTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        $response = $this->get('api/');

        $response->assertStatus(200);
        $response->assertJsonPath('test', 'test');
    }
}
