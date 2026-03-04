<?php

use App\Models\Bottle;
use App\Models\Fermenter;
use App\Models\GazTank;
use App\Models\Keg;
use App\Models\Tap;
use App\Services\BottleService;
use App\Services\FermenterService;
use App\Services\GazTankService;
use App\Services\KegService;
use App\Services\MaterialService;
use App\Services\TapService;
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
    Route::get('/find/{uid}', function (MaterialService $materialService, string $uid) {
        return redirect($materialService->getUriByUid($uid));
    })->name('material-find');
    Route::get('/fermenters/{fermenter}', function (Fermenter $fermenter, FermenterService $fermenterService) {
        return view('materials.fermenter', [
            'fermenter' => $fermenterService->show($fermenter),
            'relations' => (object)$fermenterService->getRelationsData($fermenter),
        ]);
    })->name('fermenter');
    Route::get('/gaz-tanks/{gazTank}', function (GazTank $gazTank, GazTankService $gazTankService) {
        return view('materials.gaz-tank', [
            'gazTank' => $gazTankService->show($gazTank),
        ]);
    })->name('gaz-tank');
    Route::get('/kegs/{keg}', function (Keg $keg, KegService $kegService) {
        return view('materials.keg', [
            'keg' => $kegService->show($keg),
        ]);
    })->name('keg');
    Route::get('/taps/{tap}', function (Tap $tap, TapService $tapService) {
        return view('materials.tap', [
            'tap' => $tapService->show($tap),
        ]);
    })->name('tap');
    Route::get('/bottles/{bottle}', function (Bottle $bottle, BottleService $bottleService) {
        return view('materials.bottle', [
            'bottle' => $bottleService->show($bottle),
        ]);
    })->name('bottle');
});
