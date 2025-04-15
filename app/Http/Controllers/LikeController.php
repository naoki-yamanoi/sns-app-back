<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LikeController extends Controller
{
    public function createLike(Request $request)
    {
        $user = Auth::user();
        try {
            $user->likes()->attach($request->post_id);

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

    public function deleteLike(Request $request)
    {
        $user = Auth::user();

        try {
            $user->likes()->detach($request->post_id);

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
