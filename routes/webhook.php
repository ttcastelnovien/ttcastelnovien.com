<?php

use App\Http\Controllers\WebHooks\BrevoWebHookController;
use Illuminate\Support\Facades\Route;

Route::name('webhook.')
    ->prefix('webhook')
    ->group(function () {
        Route::post('brevo', BrevoWebHookController::class);
    });
