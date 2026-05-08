<div>
    <livewire:core-shared-components::data-table 
        model="Bale\Loker\Models\Type"
        rowView="loker::livewire.type.row"
        connectionResolver="Bale\Cms\Services\TenantConnectionService::resolveForQuery" 
        :columns="[
            [
                'key' => 'name',
                'label' => __('Tipe Pekerjaan'),
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
        :searchable="['name', 'description']" 
        sortField="name"
        sortDirection="asc" 
        :perPage="20" 
    />
</div>
