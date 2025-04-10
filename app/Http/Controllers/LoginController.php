<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        // 認証処理
        if (Auth::attempt($validated)) {
            // 認証に成功した場合、APIトークンを発行
            $user = Auth::user();
            $token = $user->createToken('YourAppName')->plainTextToken;

            return response()->json([
                'message' => 'ログイン成功',
                'token' => $token,
            ]);
        }

        return response()->json(['message' => 'ログインに失敗しました。'], 401);
    }
}
