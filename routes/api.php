<?php

use App\Http\Controllers\DailyQuoteController;
use App\Http\Controllers\DoaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/doa-categories', [DoaController::class, 'categories']);
Route::get('/doa-categories/{slug}', [DoaController::class, 'items']);

Route::get('/daily-quote', [DailyQuoteController::class, 'today']);
