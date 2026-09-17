<?php

// config for Bale/Loker
return [

    /*
    |--------------------------------------------------------------------------
    | API
    |--------------------------------------------------------------------------
    |
    | Konfigurasi endpoint `api/v1/loker`. Loker hanya tersedia dari tenant
    | yang ditentukan (tenant-scoped), default bale disnaker.
    |
    */
    'api' => [
        'tenant_slug' => env('LOKER_API_TENANT_SLUG', 'dinas-tenaga-kerja'),
        'per_page' => 50,
        'max_per_page' => 100,
    ],

];
