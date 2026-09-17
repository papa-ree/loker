<?php

namespace Bale\Loker\Services;

use Bale\Cms\Models\BaleList;
use Bale\Cms\Services\TenantManager;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LokerTenantResolver
{
    /**
     * Resolve tenant connection name untuk package bale/loker.
     *
     * Tenant dipilih via slug (default `dinas-tenaga-kerja` = bale disnaker)
     * dari tabel landlord `bale_lists`, kemudian koneksi diinisialisasi
     * melalui TenantManager (MySQL dinamis `bale_{uuid}`).
     *
     * @throws ModelNotFoundException
     * @throws \Throwable error inisialisasi koneksi tenant
     */
    public function connection(): string
    {
        $slug = config('loker.api.tenant_slug', 'dinas-tenaga-kerja');

        $bale = BaleList::query()
            ->where('slug', $slug)
            ->first();

        if (! $bale) {
            throw new ModelNotFoundException("Tenant with slug [{$slug}] not found.");
        }

        TenantManager::initializeFromBaleUuid($bale->id);

        return TenantManager::getActiveConnection();
    }
}
