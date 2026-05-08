<div>
    <livewire:core-shared-components::data-table 
        model="Bale\Loker\Models\Company"
        rowView="loker::livewire.company.row"
        connectionResolver="Bale\Cms\Services\TenantConnectionService::resolveForQuery" 
        :columns="[
            [
                'key' => 'name',
                'label' => __('Nama Perusahaan'),
                'sortable' => true,
            ],
            [
                'key' => 'website',
                'label' => __('Website'),
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
        :searchable="['name', 'website', 'description', 'address']" 
        sortField="name"
        sortDirection="asc" 
        :perPage="20" 
    />
</div>
