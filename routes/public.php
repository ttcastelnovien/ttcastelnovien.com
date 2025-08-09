<?php

use App\Http\Controllers\Public\ICalController;
use App\Http\Controllers\Public\InvitationController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')
    ->name('public.')
    ->group(function () {
        Route::get('ical/{user}/stream', [ICalController::class, 'streamUserCalendar'])
            ->name('ical.stream');

        Route::get('ical/{user}/download', [ICalController::class, 'downloadUserCalendar'])
            ->name('ical.download');

        Route::get('invite/{invitation}', [InvitationController::class, 'show'])
            ->name('invite.show');

        Route::post('invite/{invitation}', [InvitationController::class, 'accept'])
            ->name('invite.accept');
    });
