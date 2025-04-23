<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostFollowResource;
use App\Http\Resources\PostKeywordResource;
use App\Http\Resources\PostLikeResource;
use App\Http\Resources\PostMineResource;
use App\Services\PostService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function __construct(
        private readonly PostService $postService
    ) {}

    /**
     * フォローユーザーの投稿取得処理
     */
    public function getFollowPosts(): ResourceCollection
    {
        $followPosts = $this->postService->getFollows();

        return PostFollowResource::collection($followPosts);
    }

    /**
     * 自分の投稿取得処理
     */
    public function getMyPosts(): ResourceCollection
    {
        $myPosts = $this->postService->getMine();

        return PostMineResource::collection($myPosts);
    }

    /**
     * いいね投稿取得処理
     */
    public function getLikePosts(): ResourceCollection
    {
        $likePosts = $this->postService->getLikes();

        return PostLikeResource::collection($likePosts);
    }

    /**
     * キーワード検索投稿取得処理
     */
    public function getSearchPosts(Request $request): ResourceCollection
    {
        // キーワードが含まれる投稿全て取得
        $inKeywordPosts = $this->postService->getSearch($request->query('keyword'));

        return PostKeywordResource::collection($inKeywordPosts);
    }

    /**
     * 新規投稿作成処理
     */
    public function createPost(Request $request): JsonResponse
    {
        try {
            $this->postService->create($request->post);

            return response()->json([
                'message' => '新規投稿を作成しました。',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'message' => '新規投稿の作成に失敗しました。',
            ]);
        }
    }
}
