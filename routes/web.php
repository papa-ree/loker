<?php

use Bale\Cms\Middleware\EnsureBaleSelected;
use Bale\Cms\Middleware\SwitchBaleConnection;
use Bale\Cms\Models\BaleList;
use Bale\Loker\Jobs\SyncLokerVisitorsJob;
use Bale\Loker\Livewire\Category\Form as CategoryForm;
use Bale\Loker\Livewire\Category\Index as CategoryIndex;
use Bale\Loker\Livewire\Company\Form as CompanyForm;
use Bale\Loker\Livewire\Company\Index as CompanyIndex;
use Bale\Loker\Livewire\Loker\Form as LokerForm;
use Bale\Loker\Livewire\Loker\Index as LokerIndex;
use Bale\Loker\Livewire\Overview\Index as OverviewIndex;
use Bale\Loker\Livewire\Type\Form as TypeForm;
use Bale\Loker\Livewire\Type\Index as TypeIndex;
use Illuminate\Support\Facades\Route;

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

        // Overview
        Route::get('/overview', OverviewIndex::class)->name('overview');

        // Management
        Route::name('loker.')->group(function () {
            Route::get('/', LokerIndex::class)->name('index');
            Route::get('/create', LokerForm::class)->name('create');
            Route::get('/edit/{id}', LokerForm::class)->name('edit');
        });

        // Categories
        Route::name('category.')->prefix('categories')->group(function () {
            Route::get('/', CategoryIndex::class)->name('index');
            Route::get('/create', CategoryForm::class)->name('create');
            Route::get('/edit/{id}', CategoryForm::class)->name('edit');
        });

        // Types
        Route::name('type.')->prefix('types')->group(function () {
            Route::get('/', TypeIndex::class)->name('index');
            Route::get('/create', TypeForm::class)->name('create');
            Route::get('/edit/{id}', TypeForm::class)->name('edit');
        });

        // Companies
        Route::name('company.')->prefix('companies')->group(function () {
            Route::get('/', CompanyIndex::class)->name('index');
            Route::get('/create', CompanyForm::class)->name('create');
            Route::get('/edit/{id}', CompanyForm::class)->name('edit');
        });

        // Sync Visitor Stats
        Route::post('/sync-visitors', function () {
            $tenant = BaleList::where('slug', session('bale_active_slug'))->first();

            if ($tenant) {
                SyncLokerVisitorsJob::dispatch($tenant->id);
            }

            return response()->json(['status' => 'ok']);
        })->name('sync-visitors');

    });
});
