<?php

namespace Tests\Feature;

use Tests\TestCase;

class IndexTest extends TestCase
{
    public function test_post(): void
    {
        $response = $this->get('api/posts/follow');

        $response->assertStatus(200);
        $response->assertJson([
            'followPosts' => [
                [
                    'user_id' => 1,
                    'post' => '１つ目の投稿です。１つ目の投稿です。１つ目の投稿です。１つ目の投稿です。',
                ],
                [
                    'user_id' => 2,
                    'post' => '２つ目の投稿です。２つ目の投稿です。２つ目の投稿です。２つ目の投稿です。',
                ],
                [
                    'user_id' => 3,
                    'post' => '３つ目の投稿です。３つ目の投稿です。３つ目の投稿です。３つ目の投稿です。',
                ],
            ],
        ]);
    }
}
