<?php

use Illuminate\Support\Facades\Route;

Route::domain('alkaukaba.com')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
});
