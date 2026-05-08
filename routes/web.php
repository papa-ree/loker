<?php

use Bale\Loker\Livewire\Overview;
use Illuminate\Support\Facades\Route;
use Bale\Cms\Middleware\EnsureBaleSelected;
use Bale\Cms\Middleware\SwitchBaleConnection;

/*
|--------------------------------------------------------------------------
| Loker Routes
|--------------------------------------------------------------------------
|
| Diintegrasikan ke dalam prefix /cms agar sesuai dengan navigasi sidebar Bale CMS.
| Menggunakan middleware tenant agar koneksi database sesuai dengan bale yang aktif.
|
*/

Route::middleware(['web', 'auth'])->prefix('cms/loker')->name('loker.')->group(function () {
    Route::middleware([EnsureBaleSelected::class, SwitchBaleConnection::class])->group(function () {
        Route::get('/', Overview::class)->name('overview');
    });
});
