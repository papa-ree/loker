<?php

use Bale\Loker\LokerPermissions;

return [
    [
        'id' => 'loker-overview',
        'group' => 'loker',
        'label' => 'Overview',
        'url' => 'loker/overview',
        'icon' => 'bar-chart-3',
        'permission' => LokerPermissions::VIEW_LOKER,
        'table' => 'loker',
    ],
    [
        'id' => 'loker-management',
        'group' => 'loker',
        'label' => 'Daftar Lowongan',
        'url' => 'loker',
        'icon' => 'briefcase',
        'permission' => LokerPermissions::VIEW_LOKER,
        'table' => 'loker',
    ],
    [
        'id' => 'loker-category',
        'group' => 'loker',
        'label' => 'Kategori Lowongan',
        'url' => 'loker/categories',
        'icon' => 'tag',
        'permission' => LokerPermissions::VIEW_CATEGORY,
        'table' => 'loker_categories',
    ],
    [
        'id' => 'loker-type',
        'group' => 'loker',
        'label' => 'Tipe Pekerjaan',
        'url' => 'loker/types',
        'icon' => 'clock',
        'permission' => LokerPermissions::VIEW_TYPE,
        'table' => 'loker_types',
    ],
    [
        'id' => 'loker-company',
        'group' => 'loker',
        'label' => 'Manajemen Perusahaan',
        'url' => 'loker/companies',
        'icon' => 'building-2',
        'permission' => LokerPermissions::VIEW_COMPANY,
        'table' => 'loker_companies',
    ],
];
