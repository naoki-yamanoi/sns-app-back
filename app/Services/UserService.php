<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService
{
    private $NO_IMAGE_PATH = 'images/EvPRPJqfRE15VzVazYBPu0uFm6183NUcwdu0rW6g.png';

    public function register($name, $email, $password)
    {
        if (User::where('email', $email)->exists()) {
            throw ValidationException::withMessages([
                'email' => ['既に登録済みのメールアドレスです。'],
            ]);
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
    }

    public function getRecommends()
    {
        $authUser = Auth::user();

        // 自身以外のユーザーをランダムで取得
        return User::where('id', '<>', $authUser->id)->inRandomOrder()->limit(3)->get();
    }

    public function editProfile($validated, $path)
    {
        $authUser = Auth::user();

        if (array_key_exists('userImage', $validated)) {
            // storage/app/public/imagesに保存
            $path = $validated['userImage']->store('images', 'public');
        }

        // users更新
        $authUser->update([
            'name' => $validated['userName'],
        ]);

        // user_info更新
        $authUser->userInfo()->updateOrCreate(
            ['user_id' => $authUser->id],
            ['image' => $path ?? $this->NO_IMAGE_PATH, 'comment' => $validated['comment']]
        );

        return $path;
    }
}
