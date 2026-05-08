<?php

namespace Bale\Loker\Commands;

use Bale\Loker\LokerPermissions;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Throwable;

class InstallLoker extends Command
{
    protected $signature = 'loker:install';

    protected $description = 'Main installer for bale/loker with interactive options';

    public function handle(): int
    {
        $this->renderHeader();

        $option = $this->choice(
            'What would you like to install/run?',
            [
                0 => 'All (Migrations & Permissions)',
                1 => 'Role & Permissions Only',
                2 => 'Migrations Only',
            ],
            0
        );

        try {
            if ($option === 'All (Migrations & Permissions)' || $option === 'Role & Permissions Only' || $option === 0 || $option === 1) {
                $this->task('Seeding permissions and roles', function () {
                    $this->seedPermissions();
                    $this->seedRoles();
                });
            }

            if ($option === 'All (Migrations & Permissions)' || $option === 'Migrations Only' || $option === 0 || $option === 2) {
                $this->task('Running migrations', function () {
                    $this->call('loker:migrate');
                });
            }

            $this->newLine();
            $this->info('  Installation step(s) completed successfully. 🎉');
            $this->newLine();

            return self::SUCCESS;

        } catch (Throwable $e) {
            $this->newLine();
            $this->error('  [ERROR] Installation failed: ' . $e->getMessage());
            return self::FAILURE;
        }
    }

    protected function seedPermissions(): void
    {
        $this->info('Seeding permissions...');

        foreach (LokerPermissions::ALL as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission],
                ['guard_name' => 'web']
            );
        }

        $this->info('Permissions seeded and updated.');

        // Force sync to root role if exists
        $rootRole = Role::where('name', 'root')->first();
        if ($rootRole) {
            $this->info('Force syncing Loker permissions to root role...');
            $rootRole->givePermissionTo(LokerPermissions::ALL);

            // Clear cache
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            $this->info('Permissions force synced and cache cleared for root role.');
        }
    }

    protected function seedRoles(): void
    {
        $this->info('Creating default roles...');

        $adminLoker = Role::firstOrCreate(
            ['name'       => 'bale-loker-admin'],
            ['guard_name' => 'web'],
        );
        $adminLoker->syncPermissions(LokerPermissions::ALL);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->info('Default roles created and permissions synced.');
    }

    protected function renderHeader(): void
    {
        $this->newLine();
        $this->line('  <fg=cyan;options=bold>┌─────────────────────────────────┐</>');
        $this->line('  <fg=cyan;options=bold>│       bale/loker installer      │</>');
        $this->line('  <fg=cyan;options=bold>│      Manajemen Lowongan Kerja   │</>');
        $this->line('  <fg=cyan;options=bold>└─────────────────────────────────┘</>');
        $this->newLine();
    }

    protected function task(string $label, callable $callback): void
    {
        $this->line("  <fg=gray>→</> {$label}...");

        try {
            $callback();
            $this->line("  <fg=green>✓</> {$label}");
        } catch (Throwable $e) {
            $this->line("  <fg=red>✗</> {$label}");
            throw $e;
        }
    }
}
