<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [UserController::class, 'registUser']);
Route::post('/password/reset', [AuthController::class, 'resetPassword']);

// 認証必要なルート群
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/posts/follow', [PostController::class, 'getFollowPosts']);
    Route::get('/posts/like', [PostController::class, 'getLikePosts']);
    Route::get('/posts/mine', [PostController::class, 'getMyPosts']);
    Route::get('/posts/search', [PostController::class, 'getSearchPosts']);

    Route::post('/post/create', [PostController::class, 'createPost']);

    Route::post('/like/create', [LikeController::class, 'createLike']);
    Route::post('/like/delete', [LikeController::class, 'deleteLike']);

    Route::post('/follow/create', [FollowController::class, 'createFollow']);
    Route::post('/follow/delete', [FollowController::class, 'deleteFollow']);

    Route::get('/user', [UserController::class, 'getUserId']);
    Route::post('/user/profile/edit', [UserController::class, 'editProfile']);
    Log::debug('000');
    Route::get('/user/profile', [UserController::class, 'getUserProfile']);
    Route::get('/users/recommend', [UserController::class, 'getRecommendUsers']);
});
