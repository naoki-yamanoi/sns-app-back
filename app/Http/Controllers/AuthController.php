<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

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

    public function resetPassword(PasswordResetRequest $request)
    {
        $validated = $request->validated();

        try {
            $user = User::where('email', $validated['email'])->first();
            if (! $user) {
                throw new ModelNotFoundException('該当ユーザーが存在しません。');
            }

            // 旧パスワードが一致するか
            if (! Hash::check($request->old_password, $user->password)) {
                throw ValidationException::withMessages([
                    'old_password' => ['現在のパスワードが正しくありません。'],
                ]);
            }

            // パスワード更新
            $user->update([
                'password' => Hash::make($validated['new_password']),
            ]);

            return response()->json(['message' => 'パスワードリセットに成功しました。']);
        } catch (ModelNotFoundException|ValidationException $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => $e->getMessage(),
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => 'パスワードリセットに失敗しました。',
            ]);
        }
    }
}
