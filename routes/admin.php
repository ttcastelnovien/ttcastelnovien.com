<?php

use App\Http\Controllers\Admin\GroupController;
use App\Http\Middleware\AdminReserved;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', AdminReserved::class])
    ->prefix('admin/')
    ->name('admin.')
    ->group(function () {
        Route::get('groups', [GroupController::class, 'index'])->name('groups.index');
    });
