<?php

use Bale\Loker\Http\Controllers\Api\V1\LokerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Loker (v1)
|--------------------------------------------------------------------------
|
| Dimuat oleh LokerServiceProvider. Middleware group `bale.api` disediakan
| oleh bale/api; scope per endpoint didaftarkan lewat registerApiScopes().
|
*/

Route::middleware('bale.api')->prefix('api/v1/loker')->name('api.loker.v1.')->group(function () {
    Route::get('lokers', [LokerController::class, 'index'])
        ->middleware('scope:loker.read')
        ->name('lokers.index');
});
