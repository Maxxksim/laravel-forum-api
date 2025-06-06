<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('posts', PostController::class)->withoutMiddlewareFor(['index', 'show'], 'auth:sanctum');
});

