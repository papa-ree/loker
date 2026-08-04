<?php

use Bale\Loker\LokerPermissions;

/**
 * Menu definisi untuk package bale/loker (Tenant/CMS Layout).
 *
 * Grup 'loker' berisi fitur manajemen lowongan pekerjaan.
 * Menggunakan type 'tenant' agar muncul di CMS sidebar via MenuRegistry.
 */
return [
    'type' => 'tenant',

    'groups' => [
        [
            'key' => 'loker',
            'label' => 'Loker',
            'icon' => 'briefcase',
            'items' => [
                [
                    'label' => 'Overview',
                    'url' => 'loker/overview',
                    'icon' => 'bar-chart-3',
                    'permission' => LokerPermissions::VIEW_LOKER,
                    'table' => 'loker',
                ],
                [
                    'label' => 'Daftar Lowongan',
                    'url' => 'loker',
                    'icon' => 'briefcase',
                    'permission' => LokerPermissions::VIEW_LOKER,
                    'table' => 'loker',
                ],
                [
                    'label' => 'Kategori Lowongan',
                    'url' => 'loker/categories',
                    'icon' => 'tag',
                    'permission' => LokerPermissions::VIEW_CATEGORY,
                    'table' => 'loker_categories',
                ],
                [
                    'label' => 'Tipe Pekerjaan',
                    'url' => 'loker/types',
                    'icon' => 'clock',
                    'permission' => LokerPermissions::VIEW_TYPE,
                    'table' => 'loker_types',
                ],
                [
                    'label' => 'Manajemen Perusahaan',
                    'url' => 'loker/companies',
                    'icon' => 'building-2',
                    'permission' => LokerPermissions::VIEW_COMPANY,
                    'table' => 'loker_companies',
                ],
            ],
        ],
    ],
];
