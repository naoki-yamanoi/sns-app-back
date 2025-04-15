<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
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

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json(['message' => 'ログアウトしました。']);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => 'ログアウトに失敗しました。',
            ]);
        }
    }
}
