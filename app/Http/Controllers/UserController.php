<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProfileRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function registUser(RegisterRequest $request)
    {
        $validated = $request->validated();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'message' => '新規登録成功',
        ]);
    }

    public function getUserId()
    {
        return Auth::user()->id;
    }

    public function getRecommendUsers()
    {
        $authUser = Auth::user();
        // 自身以外のユーザー取得
        $users = User::where('id', '<>', $authUser->id)->get();

        return UserResource::collection($users);
    }

    public function editProfile(EditProfileRequest $request)
    {
        $validated = $request->validated();

        // storage/app/public/imagesに保存
        $path = $validated['userImage']->store('images', 'public');

        $authUser = Auth::user();
        // users更新
        $authUser->update([
            'name' => $validated['userName'],
        ]);
        // user_info更新
        $authUser->userInfo()->updateOrCreate([
            'image' => $path,
            'comment' => $validated['comment'],
        ]);

        return response()->json([
            'message' => 'アップロード成功',
        ]);
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
