<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getRecommendUsers()
    {
        $authUser = Auth::user();
        // 自身以外のユーザー取得
        $users = User::where('id', '<>', $authUser->id)->get();
        return UserResource::collection($users);
    }
}
