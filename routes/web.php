<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CircleMemberController;
use Illuminate\Support\Facades\Route;

Route::domain(config('app.route_domain'))->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::post('/join-circle', [CircleMemberController::class, 'store'])->name('circle.join');
});

// Mirrors the legacy alkaukabaauth/api.php?action=... contract used by the Android app.
// Not domain-scoped: the mobile app may hit this via IP (emulator/local testing) or a
// different host than the marketing site's vhost domain.
Route::post('/api.php', [AuthController::class, 'handle'])->name('auth.api');
