<?php

namespace Bale\Loker\Commands;

use Bale\Cms\Models\BaleList;
use Bale\Cms\Services\TenantManager;
use Illuminate\Console\Command;
use Throwable;

class MigrateLoker extends Command
{
    protected $signature = 'loker:migrate {--tenant= : The slug of the tenant}';

    protected $description = 'Publish Loker migrations and run them for a specific tenant database';

    public function handle(): int
    {
        $tenantSlug = $this->option('tenant');

        if (!$tenantSlug) {
            $tenants = BaleList::all();
            if ($tenants->isEmpty()) {
                $this->error('No tenants found in bale_lists table.');
                return self::FAILURE;
            }

            $tenantSlug = $this->choice(
                'Which tenant database do you want to migrate?',
                $tenants->pluck('slug')->toArray()
            );
        }

        try {
            $tenant = BaleList::where('slug', $tenantSlug)->firstOrFail();
            
            $this->info("Publishing Loker migrations...");
            $this->call('vendor:publish', [
                '--tag'   => 'loker:migrations',
                '--force' => true,
            ]);

            $this->info("Initializing connection for tenant: {$tenant->slug}");
            TenantManager::initializeFromBaleUuid($tenant->id);
            $connection = TenantManager::getActiveConnection();

            if (!$connection) {
                throw new \Exception("Failed to activate connection for tenant {$tenant->slug}");
            }

            $this->info("Migrating Loker tables (DB: {$tenant->database_name})...");

            $this->call('migrate', [
                '--database' => $connection,
                '--path'     => 'database/migrations/tenant',
                '--force'    => true,
            ]);

            $this->info("Migration for tenant {$tenant->slug} completed.");

            return self::SUCCESS;
        } catch (Throwable $e) {
            $this->error("Migration failed: " . $e->getMessage());
            return self::FAILURE;
        }
    }
}
