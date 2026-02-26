<?php

use App\Http\Controllers\MaterialController;
use Illuminate\Support\Facades\Route;

// todo handle auth

Route::get('/ping', function () {
    return response()->json(['data' => 'pong']);
});

Route::prefix('materials')
    ->controller(MaterialController::class)
    ->group(function () {
        Route::get('/', 'index');
    });
