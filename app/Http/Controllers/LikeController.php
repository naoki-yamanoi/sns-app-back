<?php

namespace App\Http\Controllers;

use App\Services\LikeService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LikeController extends Controller
{
    public function __construct(
        private readonly LikeService $likeService
    ) {}

    /**
     * いいね追加処理
     */
    public function createLike(Request $request): JsonResponse
    {
        try {
            $this->likeService->create($request->post_id);

            return response()->json([
                'message' => 'いいねに成功しました。',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => 'いいねに失敗しました。',
            ]);
        }
    }

    /**
     * いいね削除処理
     */
    public function deleteLike(Request $request): JsonResponse
    {
        try {
            $this->likeService->delete($request->post_id);

            return response()->json([
                'message' => 'いいねを外すことに成功しました。',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => 'いいねを外すことに失敗しました。',
            ]);
        }
    }
}
