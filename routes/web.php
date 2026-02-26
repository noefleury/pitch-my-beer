<?php

use App\Services\MaterialService;
use Illuminate\Support\Facades\Route;

// todo handle auth

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/materials', function (MaterialService $materialService) {
    return view('materials', [
        'materialsByType' => $materialService->listMaterialsByType(),
    ]);
})->name('materials');
