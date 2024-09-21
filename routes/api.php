<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'test']);
    Route::get('/user/comments', [CommentController::class, 'index']);
    Route::get('/users', [UserController::class, 'index']);

    Route::apiResource('posts', PostController::class)->scoped([
        'post' => 'slug',
    ]);
    Route::post('/posts/like/{post:slug}', [PostController::class, 'like']);

    Route::apiResource('posts.comments', CommentController::class)->only('store', 'update', 'destroy')->scoped([
        'post' => 'slug',
    ]);
});

require __DIR__.'/auth.php';
