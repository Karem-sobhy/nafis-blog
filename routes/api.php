<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'test']);

    Route::apiResource('posts', PostController::class)->scoped([
        'post' => 'slug'
    ]);
    Route::apiResource('posts.comments', CommentController::class)->scoped([
        'post' => 'slug'
    ]);
});

require __DIR__.'/auth.php';
