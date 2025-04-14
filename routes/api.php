<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/posts/follow', [PostController::class, 'getFollowPosts']);
Route::middleware('auth:sanctum')->get('/posts/mine', [PostController::class, 'getMyPosts']);

Route::middleware('auth:sanctum')->post('/post/create', [PostController::class, 'createPost']);

Route::middleware('auth:sanctum')->post('/follow/create', [FollowController::class, 'createFollow']);
Route::middleware('auth:sanctum')->post('/follow/delete', [FollowController::class, 'deleteFollow']);

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
