<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', LoginController::class);

// Authenticated routes (require valid Sanctum token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', LogoutController::class);

    // Admin-only routes
    Route::middleware('admin')->group(function () {
        Route::post('/register', RegisterController::class);
    });
});
