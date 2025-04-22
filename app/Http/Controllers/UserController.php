<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProfileRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    /**
     * ユーザー登録処理
     */
    public function registUser(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        try {
            $this->userService->register(
                name: $validated['name'],
                email: $validated['email'],
                password: $validated['password']
            );

            return response()->json([
                'message' => '新規登録に成功しました。',
            ]);
        } catch (ValidationException $e) {
            Log::error($e->getMessage());

            return response()->json([
                'errors' => '既に登録済みのメールアドレスです。',
                'message' => '既に登録済みのメールアドレスです。',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'errors' => '新規登録に失敗しました。',
                'message' => '新規登録に失敗しました。',
            ]);
        }
    }

    /**
     * ログインユーザーID取得処理
     */
    public function getUserId(): int
    {
        return Auth::user()->id;
    }

    /**
     * おすすめユーザー取得処理
     */
    public function getRecommendUsers(): ResourceCollection
    {
        $recommendUsers = $this->userService->getRecommends();

        return UserResource::collection($recommendUsers);
    }

    /**
     * プロフィール編集処理
     */
    public function editProfile(EditProfileRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $path = null;

        DB::beginTransaction();

        try {
            $path = $this->userService->editProfile(validated: $validated, path: $path);

            DB::commit();

            return response()->json([
                'message' => 'プロフィール更新に成功しました。',
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            // 保存されていたら画像も削除
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            Log::error($e->getMessage());

            return response()->json([
                'errors' => 'プロフィール更新に失敗しました。',
                'message' => 'プロフィール更新に失敗しました。',
            ]);
        }
    }

    /**
     * ログインユーザープロフィール取得処理
     */
    public function getUserProfile(): JsonResponse
    {
        $authUser = Auth::user();
        $image = $authUser->userInfo->image ?? 'images/EvPRPJqfRE15VzVazYBPu0uFm6183NUcwdu0rW6g.png';
        // 公開URLの生成
        $url = asset('storage/'.$image);

        return response()->json([
            'name' => $authUser->name,
            'comment' => $authUser->userInfo->comment ?? '',
            'url' => $url,
        ]);
    }
}
