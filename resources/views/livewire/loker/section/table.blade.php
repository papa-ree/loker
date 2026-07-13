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
            'key' => 'nama_perusahaan',
            'label' => __('Perusahaan'),
            'sortable' => true,
        ],
        [
            'key' => 'lokasi',
            'label' => __('Lokasi'),
            'sortable' => true,
        ],
        [
            'key' => 'tgl_berakhir',
            'label' => __('Masa Berlaku'),
            'sortable' => true,
        ],
        [
            'key' => 'visitors',
            'label' => __('Pengunjung (PV/UV)'),
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