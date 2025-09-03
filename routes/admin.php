<?php

use App\Http\Controllers\Admin\GenerateLicenceAttestationController;
use App\Http\Controllers\Admin\GenerateLicenceFormController;
use App\Http\Middleware\AdminReserved;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', AdminReserved::class])
    ->name('admin.gen.')
    ->group(function () {
        Route::get('gen/{licence}/licence-form', GenerateLicenceFormController::class)
            ->name('licence_form');
        Route::get('gen/{licence}/licence-attestation', GenerateLicenceAttestationController::class)
            ->name('licence_attestation');
    });
