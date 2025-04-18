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
            'image' => 'images/EvPRPJqfRE15VzVazYBPu0uFm6183NUcwdu0rW6g.png',
            'comment' => 'ユーザー１の自己紹介です。ユーザー１の自己紹介です。ユーザー１の自己紹介です。',
        ]);

        DB::table('user_info')->insert([
            'id' => 2,
            'user_id' => 2,
            'image' => 'images/EvPRPJqfRE15VzVazYBPu0uFm6183NUcwdu0rW6g.png',
            'comment' => 'ユーザー２の自己紹介です。ユーザー２の自己紹介です。ユーザー２の自己紹介です。',
        ]);

        DB::table('user_info')->insert([
            'id' => 3,
            'user_id' => 3,
            'image' => 'images/EvPRPJqfRE15VzVazYBPu0uFm6183NUcwdu0rW6g.png',
            'comment' => 'ユーザー３の自己紹介です。ユーザー３の自己紹介です。ユーザー３の自己紹介です。',
        ]);

        DB::table('user_info')->insert([
            'id' => 4,
            'user_id' => 4,
            'image' => 'images/EvPRPJqfRE15VzVazYBPu0uFm6183NUcwdu0rW6g.png',
            'comment' => 'ユーザー４の自己紹介です。ユーザー４の自己紹介です。ユーザー４の自己紹介です。',
        ]);
    }
}
