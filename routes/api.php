<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

// 認証必要なルート群
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/posts/follow', [PostController::class, 'getFollowPosts']);
    Route::get('/posts/mine', [PostController::class, 'getMyPosts']);

    Route::post('/post/create', [PostController::class, 'createPost']);

    Route::post('/follow/create', [FollowController::class, 'createFollow']);
    Route::post('/follow/delete', [FollowController::class, 'deleteFollow']);

    Route::get('/users/recommend', [UserController::class, 'getRecommendUsers']);
});
