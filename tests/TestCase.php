<?php

namespace Bale\Loker\Tests;

use Bale\Api\ApiServiceProvider;
use Bale\Cms\CmsServiceProvider;
use Bale\Core\CoreServiceProvider;
use Bale\Loker\LokerServiceProvider;
use Illuminate\Support\Facades\Schema;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Permission\PermissionServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LivewireServiceProvider::class,
            PermissionServiceProvider::class,
            CoreServiceProvider::class,
            CmsServiceProvider::class,
            ApiServiceProvider::class,
            LokerServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
        $app['config']->set('auth.defaults.guard', 'web');
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->createApiTokensTable();
    }

    protected function createApiTokensTable(): void
    {
        Schema::create('api_tokens', function ($table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->json('abilities')->nullable();
            $table->json('allowed_ips')->nullable();
            $table->json('allowed_hosts')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->timestamps();
        });
    }
}
