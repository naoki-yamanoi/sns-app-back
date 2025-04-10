<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('posts')->insert([
            'user_id' => 1,
            'post' => '１つ目の投稿です。１つ目の投稿です。１つ目の投稿です。１つ目の投稿です。',
        ]);

        DB::table('posts')->insert([
            'user_id' => 2,
            'post' => '２つ目の投稿です。２つ目の投稿です。２つ目の投稿です。２つ目の投稿です。',
        ]);

        DB::table('posts')->insert([
            'user_id' => 3,
            'post' => '３つ目の投稿です。３つ目の投稿です。３つ目の投稿です。３つ目の投稿です。',
        ]);
    }
}
