<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    /**
     * ログイン処理
     */
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $token = $this->authService->login(validated: $validated);

        if (! $token) {
            return response()->json([
                'errors' => 'ログインに失敗しました。',
                'message' => 'ログインに失敗しました。',
            ], 401);
        }

        return response()->json([
            'message' => 'ログイン成功',
            'token' => $token,
        ]);
    }

    /**
     * ログアウト処理
     */
    public function logout(Request $request)
    {
        try {
            $this->authService->logout(request: $request);

            return response()->json(['message' => 'ログアウトしました。']);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'errors' => 'ログアウトに失敗しました。',
                'message' => 'ログアウトに失敗しました。',
            ]);
        }
    }

    /**
     * パスワードリセット処理
     */
    public function resetPassword(PasswordResetRequest $request)
    {
        $validated = $request->validated();

        try {
            $this->authService->resetPassword(
                email: $validated['email'],
                oldPassword: $request->old_password,
                newPassword: $validated['new_password']
            );

            return response()->json(['message' => 'パスワードリセットに成功しました。']);
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return response()->json([
                'errors' => $e->getMessage(),
                'message' => $e->getMessage(),
            ], 404);
        } catch (ValidationException $e) {
            Log::error($e->getMessage());

            return response()->json([
                'errors' => $e->getMessage(),
                'message' => $e->getMessage(),
            ], 422);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'errors' => 'パスワードリセットに失敗しました。',
                'message' => 'パスワードリセットに失敗しました。',
            ]);
        }
    }
}
