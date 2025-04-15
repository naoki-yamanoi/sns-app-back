<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FollowController extends Controller
{
    public function createFollow(Request $request)
    {
        $user = Auth::user();

        try {
            $user->follows()->attach($request->followed_id);

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

    public function deleteFollow(Request $request)
    {
        $user = Auth::user();

        try {
            $user->follows()->detach($request->followed_id);

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
