<?php

use App\Http\Controllers\BeerController;
use App\Http\Controllers\BottleController;
use App\Http\Controllers\FermenterController;
use App\Http\Controllers\GazTankController;
use App\Http\Controllers\KegController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\TapController;
use Illuminate\Support\Facades\Route;

// todo handle auth

Route::get('/ping', function () {
    return response()->json(['data' => 'pong']);
});

Route::prefix('materials')
    ->controller(MaterialController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/find/{uid}', 'findByUid');
        Route::prefix('fermenters')
            ->controller(FermenterController::class)
            ->group(function () {
                Route::get('/{fermenter}', 'show');
                Route::get('/{fermenter}/relations', 'getRelations');
            });
        Route::prefix('gaz-tanks')
            ->controller(GazTankController::class)
            ->group(function () {
                Route::get('/{gazTank}', 'show');
            });
        Route::prefix('kegs')
            ->controller(KegController::class)
            ->group(function () {
                Route::get('/{keg}', 'show');
            });
        Route::prefix('taps')
            ->controller(TapController::class)
            ->group(function () {
                Route::get('/{tap}', 'show');
            });
        Route::prefix('bottles')
            ->controller(BottleController::class)
            ->group(function () {
                Route::get('/{bottle}', 'show');
            });
    });

Route::prefix('beers')
    ->controller(BeerController::class)
    ->group(function () {
        Route::get('/', 'list');
        Route::get('/{beer}', 'get');
        Route::get('/{beer}/relations', 'getRelations');
    });
