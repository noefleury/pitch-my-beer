<?php

use App\Http\Controllers\BeerController;
use App\Http\Controllers\BottleController;
use App\Http\Controllers\BottlingController;
use App\Http\Controllers\FermentationController;
use App\Http\Controllers\FermenterController;
use App\Http\Controllers\GazTankController;
use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\KegController;
use App\Http\Controllers\KeggingController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\TapController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', [HealthCheckController::class, 'ping'])->withoutMiddleware('auth:sanctum');
Route::get('/ping-server', [HealthCheckController::class, 'pingServer']);

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
                Route::post('/', 'create');
            });
        Route::prefix('gaz-tanks')
            ->controller(GazTankController::class)
            ->group(function () {
                Route::get('/{gazTank}', 'show');
                Route::post('/', 'create');
                Route::delete('/{id}', 'delete');
            });
        Route::prefix('kegs')
            ->controller(KegController::class)
            ->group(function () {
                Route::get('/{keg}', 'show');
                Route::get('/{keg}/relations', 'getRelations');
                Route::post('/', 'create');
            });
        Route::prefix('taps')
            ->controller(TapController::class)
            ->group(function () {
                Route::get('/{tap}', 'show');
                Route::post('/', 'create');
            });
        Route::prefix('bottles')
            ->controller(BottleController::class)
            ->group(function () {
                Route::get('/{bottle}', 'show');
                Route::get('/{bottle}/relations', 'getRelations');
                Route::post('/', 'create');
            });
    });

Route::prefix('beers')
    ->controller(BeerController::class)
    ->group(function () {
        Route::get('/', 'list');
        Route::get('/{beer}', 'get');
        Route::get('/{beer}/relations', 'getRelations');
        Route::post('/', 'create');
    });

Route::prefix('on-taps')
    ->controller(TapController::class)
    ->group(function () {
        Route::get('/', 'getOnTaps');
    });

Route::prefix('stats')
    ->controller(StatsController::class)
    ->group(function () {
        Route::get('/', 'computeGlobalStats');
        Route::get('/kegs/{keg}', 'computeKegStats');
    });

Route::prefix('keggings')
    ->controller(KeggingController::class)
    ->group(function () {
        Route::post('/', 'create');
    });

Route::prefix('bottlings')
    ->controller(BottlingController::class)
    ->group(function () {
        Route::get('/', 'list');
        Route::post('/', 'create');
    });

Route::prefix('fermentations')
    ->controller(FermentationController::class)
    ->group(function () {
        Route::get('/', 'list');
        Route::post('/', 'create');
        Route::patch('/{fermentation}/gravity', 'updateGravity');
    });

Route::prefix('comments')
    ->controller(\App\Http\Controllers\CommentController::class)
    ->group(function () {
        Route::get('/', 'list');
    });
