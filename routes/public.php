<?php

use App\Http\Controllers\Public\ICalController;
use App\Http\Controllers\Public\InvitationController;
use App\Http\Middleware\HandleInertiaRequests;
use App\Services\OFXParser\OFXParser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::middleware([HandleInertiaRequests::class])
    ->name('public.')
    ->group(function () {
        Route::get('invite/{invitation}', [InvitationController::class, 'show'])
            ->name('invite.show');

        Route::post('invite/{invitation}', [InvitationController::class, 'accept'])
            ->name('invite.accept');
    });

Route::name('public.')
    ->group(function () {
        Route::get('ical/{person}/stream', [ICalController::class, 'streamPersonCalendar'])
            ->name('ical.stream');

        Route::get('ical/{person}/download', [ICalController::class, 'downloadPersonCalendar'])
            ->name('ical.download');

        Route::get('ofx', function (): Response {
            return \response()->view('ofx');
        })->name('ofx');

        Route::post('ofx', function (Request $request): Response {
            $file = $request->file('file');
            $parsed = $file->getContent();

            dd(OFXParser::parse($parsed));
        })->name('ofx.post');

        Route::get('pdfe', function () {
            return response()->view('pdf.page_emulator');
        })->name('pdf.emulate');
    });
