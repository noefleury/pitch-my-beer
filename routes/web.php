<?php

use App\Models\Fermenter;
use App\Services\FermenterService;
use App\Services\MaterialService;
use Illuminate\Support\Facades\Route;

// todo handle auth

Route::get('/', function () {
    return view('home');
})->name('home');

Route::prefix('materials')->group(function () {
    Route::get('/', function (MaterialService $materialService) {
        return view('materials', [
            'materialsByType' => $materialService->listMaterialsByType(),
        ]);
    })->name('materials');
    Route::get('/fermenters/{fermenter}', function (Fermenter $fermenter, FermenterService $fermenterService) {
        return view('materials.fermenter', [
            'fermenter' => $fermenterService->show($fermenter),
        ]);
    })->name('fermenter');
});
