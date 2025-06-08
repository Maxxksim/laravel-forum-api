<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('posts', PostController::class)->withoutMiddlewareFor(['index', 'show'], 'auth:sanctum');
    Route::apiResource('comments', CommentController::class)->withoutMiddlewareFor(['index'], 'auth:sanctum');
    Route::apiResource('users', UserController::class)->withoutMiddlewareFor(['show'], 'auth:sanctum');

    Route::controller(LikeController::class)->group(function () {
        Route::post('/like/{post}', 'toLike');
        Route::delete('/like/{post}', 'toUnlike');
    });

});

