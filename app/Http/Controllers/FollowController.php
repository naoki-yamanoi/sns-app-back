<?php

namespace App\Http\Controllers;

use App\Services\FollowService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FollowController extends Controller
{
    public function __construct(
        private readonly FollowService $followService
    ) {}

    /**
     * フォロー処理
     */
    public function createFollow(Request $request): JsonResponse
    {
        try {
            $this->followService->create($request->followed_id);

            return response()->json([
                'message' => 'フォローに成功しました。',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => 'フォローに失敗しました。',
            ]);
        }
    }

    /**
     * フォロー外す処理
     */
    public function deleteFollow(Request $request): JsonResponse
    {
        try {
            $this->followService->delete($request->followed_id);

            return response()->json([
                'message' => 'フォロー外すことに成功しました。',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => 'フォロー外すことに失敗しました。',
            ]);
        }
    }
}
