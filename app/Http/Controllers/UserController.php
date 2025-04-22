<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProfileRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    private $NO_IMAGE_PATH = 'images/EvPRPJqfRE15VzVazYBPu0uFm6183NUcwdu0rW6g.png';

    public function registUser(RegisterRequest $request)
    {
        $validated = $request->validated();

        try {
            if (User::where('email', $validated['email'])->exists()) {
                return response()->json([
                    'errors' => '既に登録済みのメールアドレスです。',
                    'message' => '既に登録済みのメールアドレスです。',
                ]);
            }

            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            return response()->json([
                'message' => '新規登録に成功しました。',
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'errors' => '新規登録に失敗しました。',
                'message' => '新規登録に失敗しました。',
            ]);
        }
    }

    public function getUserId()
    {
        return Auth::user()->id;
    }

    public function getRecommendUsers()
    {
        $authUser = Auth::user();
        // 自身以外のユーザーをランダムで取得
        $users = User::where('id', '<>', $authUser->id)->inRandomOrder()->limit(3)->get();

        return UserResource::collection($users);
    }

    public function editProfile(EditProfileRequest $request)
    {
        $validated = $request->validated();
        $authUser = Auth::user();
        $path = null;
        DB::beginTransaction();
        try {
            if (array_key_exists('userImage', $validated)) {
                // storage/app/public/imagesに保存
                $path = $validated['userImage']->store('images', 'public');
            }
            // users更新
            $authUser->update([
                'name' => $validated['userName'],
            ]);
            // user_info更新
            $authUser->userInfo()->updateOrCreate(
                ['user_id' => $authUser->id],
                ['image' => $path ?? $this->NO_IMAGE_PATH, 'comment' => $validated['comment']]
            );
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
                'message' => 'プロフィール更新に失敗しました。',
            ]);
        }
    }

    public function getUserProfile()
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
