<div>
    <livewire:core-shared-components::data-table model="Bale\Loker\Models\Loker"
        rowView="loker::livewire.loker.section.row"
        connectionResolver="Bale\Cms\Services\TenantConnectionService::resolveForQuery"
        :with="['visitors']"
        :columns="[
        [
            'key' => 'nama_pekerjaan',
            'label' => __('Pekerjaan'),
            'sortable' => true,
        ],
        [
            'key' => 'kategory',
            'label' => __('Kategori'),
            'sortable' => true,
        ],
        [
            'key' => 'lokasi',
            'label' => __('Lokasi'),
            'sortable' => true,
        ],
        [
            'key' => 'gaji',
            'label' => __('Gaji'),
            'sortable' => true,
        ],
        [
            'key' => 'tgl_berakhir',
            'label' => __('Masa Berlaku'),
            'sortable' => true,
        ],
        [
            'key' => 'visitors',
            'label' => __('Pengunjung'),
            'sortable' => false,
        ],
        [
            'key' => 'actived',
            'label' => __('Status'),
            'sortable' => true,
        ],
        [
            'key' => 'actions',
            'label' => '',
            'sortable' => false,
        ],
    ]"
        :searchable="['nama_pekerjaan', 'nama_perusahaan', 'lokasi', 'kategory']" sortField="created_at"
        sortDirection="desc" :perPage="20" />
</div>
