<?php

namespace Bale\Loker\Commands;

use Bale\Cms\Models\BaleList;
use Bale\Loker\Jobs\SyncLokerVisitorsJob;
use Illuminate\Console\Command;

class SyncLokerVisitors extends Command
{
    protected $signature = 'loker:sync-visitors
                            {--tenant= : The slug of the tenant}
                            {--days=30 : Date range in days to query from Umami}';

    protected $description = 'Sync per-loker visitor stats from Umami into the loker_visitor table via job queue';

    public function handle(): int
    {
        $tenantSlug = $this->option('tenant');
        $days = (int) $this->option('days');

        if ($tenantSlug) {
            $tenant = BaleList::where('slug', $tenantSlug)->first();

            if (! $tenant) {
                $this->error("Tenant '{$tenantSlug}' not found.");

                return self::FAILURE;
            }

            SyncLokerVisitorsJob::dispatch($tenant->id, $days);
            $this->info("Sync job dispatched for tenant: {$tenant->slug}");
        } else {
            $tenants = BaleList::all();

            if ($tenants->isEmpty()) {
                $this->error('No tenants found in bale_lists table.');

                return self::FAILURE;
            }

            foreach ($tenants as $tenant) {
                SyncLokerVisitorsJob::dispatch($tenant->id, $days);
            }

            $this->info('Sync jobs dispatched for '.$tenants->count().' tenant(s).');
        }

        return self::SUCCESS;
    }
}
