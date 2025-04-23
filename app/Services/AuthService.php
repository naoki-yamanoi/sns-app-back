<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login($validated)
    {
        // 認証処理
        if (! Auth::attempt($validated)) {
            return false;
        }

        $user = Auth::user();

        // 認証に成功した場合、APIトークンを発行
        return $user->createToken('YourAppName')->plainTextToken;
    }

    public function logout($request)
    {
        // APIトークン削除
        $request->user()->currentAccessToken()->delete();
    }

    public function resetPassword($email, $oldPassword, $newPassword)
    {
        $user = User::where('email', $email)->first();
        if (! $user) {
            throw new ModelNotFoundException('該当ユーザーが存在しません。');
        }

        // 旧パスワードが一致するか
        if (! Hash::check($oldPassword, $user->password)) {
            throw ValidationException::withMessages([
                'old_password' => ['現在のパスワードが正しくありません。'],
            ]);
        }

        // パスワード更新
        $user->update([
            'password' => Hash::make($newPassword),
        ]);
    }
}
