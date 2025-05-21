<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Client\CreateController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', LoginController::class)->name('login');

// Authenticated routes (require valid Sanctum token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', LogoutController::class)->name('logout');

    // Client management routes
    Route::middleware(['role:admin|head|manager'])->group(function () {
        Route::post('/clients', CreateController::class)
            ->middleware('permission:manage_clients|manage_own_clients')
            ->name('clients.create');
    });

    // Admin-only routes
    Route::middleware('role:admin')->group(function () {
        Route::post('/register', RegisterController::class)->name('register');
    });
});

// Route::post('/clients', CreateController::class);
