<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// todo handle auth

Route::get('/ping', function () {
    return response()->json(['data' => 'pong']);
});
