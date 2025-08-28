<?php

use App\Http\Controllers\Protected\FileController;
use App\Http\Middleware\AdminReserved;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->group(function () {
        Route::get('files/admin/{path}', [FileController::class, 'adminOnly'])
            ->name('files.admin_only')
            ->middleware(AdminReserved::class);

        Route::get('files/auth/{path}', [FileController::class, 'authenticatedOnly'])
            ->name('files.authenticated_only');

        Route::get('files/drive/{fileId}', [FileController::class, 'openFileFromDrive'])
            ->name('files.open_from_drive');
    });
