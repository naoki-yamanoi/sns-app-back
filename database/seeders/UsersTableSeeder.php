<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'ユーザー１',
            'email' => 'aaa@example.com',
            'password' => Hash::make('aaaa1111'),
        ]);

        DB::table('users')->insert([
            'name' => 'ユーザー２',
            'email' => 'bbb@example.com',
            'password' => Hash::make('bbbb2222'),
        ]);

        DB::table('users')->insert([
            'name' => 'ユーザー３',
            'email' => 'ccc@example.com',
            'password' => Hash::make('cccc3333'),
        ]);
    }
}
