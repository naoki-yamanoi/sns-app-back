<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_info')->insert([
            'id' => 1,
            'user_id' => 1,
            'image' => '/src/assets/images/44631706_p0_master1200.jpg',
            'comment' => 'ユーザー１の自己紹介です。ユーザー１の自己紹介です。ユーザー１の自己紹介です。',
        ]);

        DB::table('user_info')->insert([
            'id' => 2,
            'user_id' => 2,
            'image' => '/src/assets/images/55e25798c9c8e6b02e5d01ec21e03065_t.jpeg',
            'comment' => 'ユーザー２の自己紹介です。ユーザー２の自己紹介です。ユーザー２の自己紹介です。',
        ]);

        DB::table('user_info')->insert([
            'id' => 3,
            'user_id' => 3,
            'image' => '/src/assets/images/55e25798c9c8e6b02e5d01ec21e03065_t.jpeg',
            'comment' => 'ユーザー３の自己紹介です。ユーザー３の自己紹介です。ユーザー３の自己紹介です。',
        ]);
    }
}
