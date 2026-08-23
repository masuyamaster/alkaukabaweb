<?php

use App\Http\Controllers\CircleMemberController;
use Illuminate\Support\Facades\Route;

Route::domain('alkaukaba.com')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::post('/join-circle', [CircleMemberController::class, 'store'])->name('circle.join');
});
