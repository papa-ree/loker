<div>
    <livewire:core-shared-components::data-table model="Bale\Loker\Models\Company"
        rowView="loker::livewire.company.section.row"
        connectionResolver="Bale\Cms\Services\TenantConnectionService::resolveForQuery" :columns="[
        [
            'key' => 'name',
            'label' => __('Perusahaan'),
            'sortable' => true,
        ],
        [
            'key' => 'address',
            'label' => __('Alamat'),
            'sortable' => true,
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
        :searchable="['name', 'address', 'website']" 
        sortField="name"
        sortDirection="asc" :perPage="20" />
</div>
