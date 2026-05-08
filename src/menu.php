<?php

return [
    [
        'id'         => 'loker-overview',
        'group'      => 'loker',
        'label'      => 'Overview',
        'url'        => 'loker/overview',
        'icon'       => 'bar-chart-3',
        'permission' => \Bale\Loker\LokerPermissions::VIEW_LOKER,
    ],
    [
        'id'         => 'loker-management',
        'group'      => 'loker',
        'label'      => 'Daftar Lowongan',
        'url'        => 'loker',
        'icon'       => 'briefcase',
        'permission' => \Bale\Loker\LokerPermissions::VIEW_LOKER,
    ],
    [
        'id'         => 'loker-category',
        'group'      => 'loker',
        'label'      => 'Kategori Lowongan',
        'url'        => 'loker/categories',
        'icon'       => 'tag',
        'permission' => \Bale\Loker\LokerPermissions::VIEW_CATEGORY,
    ],
    [
        'id'         => 'loker-type',
        'group'      => 'loker',
        'label'      => 'Tipe Pekerjaan',
        'url'        => 'loker/types',
        'icon'       => 'clock',
        'permission' => \Bale\Loker\LokerPermissions::VIEW_TYPE,
    ],
    [
        'id'         => 'loker-company',
        'group'      => 'loker',
        'label'      => 'Manajemen Perusahaan',
        'url'        => 'loker/companies',
        'icon'       => 'building-2',
        'permission' => \Bale\Loker\LokerPermissions::VIEW_COMPANY,
    ],
];
