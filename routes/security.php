<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest', HandleInertiaRequests::class])->group(function () {
    Route::get('login', [AuthenticationController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticationController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware(['auth', HandleInertiaRequests::class])->group(function () {
    Route::post('logout', [AuthenticationController::class, 'destroy'])
        ->name('logout');
});
