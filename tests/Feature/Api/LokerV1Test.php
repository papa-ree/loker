<?php

use Bale\Api\Services\TokenManager;
use Bale\Cms\Services\TenantManager;
use Bale\Loker\Models\Loker;
use Bale\Loker\Services\LokerTenantResolver;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

beforeEach(function () {
    TenantManager::clear();

    if (! Schema::hasTable('loker')) {
        Schema::create('loker', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_perusahaan');
            $table->text('deskripsi_perusahaan')->nullable();
            $table->string('url_perusahaan')->nullable();
            $table->text('alamat_perusahaan')->nullable();
            $table->string('nama_pekerjaan');
            $table->text('deskripsi_pekerjaan')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('gaji')->nullable();
            $table->string('tipe')->nullable();
            $table->string('kategory')->nullable();
            $table->text('apply')->nullable();
            $table->json('persyaratan_kualifikasi')->nullable();
            $table->date('tgl_berakhir')->nullable();
            $table->string('slug')->unique();
            $table->boolean('actived')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    app()->instance(LokerTenantResolver::class, new class
    {
        public function connection(): string
        {
            return 'sqlite';
        }
    });

    $this->tokens = app(TokenManager::class);
});

function createLoker(string $name, bool $actived = true, ?string $expiresAt = null): Loker
{
    return Loker::create([
        'nama_perusahaan' => 'PT Contoh',
        'nama_pekerjaan' => $name,
        'slug' => Str::slug($name).'-'.uniqid(),
        'lokasi' => 'Ponorogo',
        'gaji' => '',
        'tipe' => 'Full time',
        'kategory' => 'Umum',
        'actived' => $actived,
        'tgl_berakhir' => $expiresAt,
    ]);
}

test('list loker default pagination 50 item', function () {
    createLoker('Vacancy '.now()->timestamp);

    for ($i = 0; $i < 50; $i++) {
        createLoker('Vacancy '.now()->timestamp.'-'.$i);
    }

    $issued = $this->tokens->issue('Client', ['loker.read']);

    $this->getJson('/api/v1/loker/lokers', ['Authorization' => 'Bearer '.$issued['plain']])
        ->assertOk()
        ->assertJsonStructure(['data', 'meta'])
        ->assertJsonCount(50, 'data')
        ->assertJsonPath('meta.per_page', 50)
        ->assertJsonPath('meta.total', 51)
        ->assertJsonPath('meta.current_page', 1)
        ->assertJsonPath('meta.last_page', 2);
});

test('list loker supports page parameter', function () {
    for ($i = 0; $i < 60; $i++) {
        createLoker('Vacancy '.$i);
    }

    $issued = $this->tokens->issue('Client', ['loker.read']);

    $this->getJson('/api/v1/loker/lokers?page=2', ['Authorization' => 'Bearer '.$issued['plain']])
        ->assertOk()
        ->assertJsonPath('meta.current_page', 2)
        ->assertJsonCount(10, 'data');
});

test('inactive loker excluded from listing', function () {
    createLoker('Inactive', false);
    createLoker('Active 1');
    createLoker('Active 2');

    $issued = $this->tokens->issue('Client', ['loker.read']);

    $this->getJson('/api/v1/loker/lokers', ['Authorization' => 'Bearer '.$issued['plain']])
        ->assertOk()
        ->assertJsonPath('meta.total', 2);
});

test('expired loker excluded, future expiry included with is_expired flag', function () {
    createLoker('Expired', true, today()->subDay()->toDateString());
    createLoker('Active Forever', true, null);
    createLoker('Active Until Tomorrow', true, today()->addDay()->toDateString());

    $issued = $this->tokens->issue('Client', ['loker.read']);

    $this->getJson('/api/v1/loker/lokers', ['Authorization' => 'Bearer '.$issued['plain']])
        ->assertOk()
        ->assertJsonPath('meta.total', 2)
        ->assertJsonPath('meta.per_page', 50)
        ->assertJsonPath('data.0.is_expired', false);
});

test('per_page override is capped at config max', function () {
    createLoker('Only One');

    $issued = $this->tokens->issue('Client', ['loker.read']);

    $this->getJson('/api/v1/loker/lokers?per_page=1000', ['Authorization' => 'Bearer '.$issued['plain']])
        ->assertOk()
        ->assertJsonPath('meta.per_page', 100);
});

test('token without loker.read ability is forbidden', function () {
    $issued = $this->tokens->issue('Client', ['rakaca.form.read']);

    $this->getJson('/api/v1/loker/lokers', ['Authorization' => 'Bearer '.$issued['plain']])
        ->assertForbidden();
});

test('missing token is unauthorized', function () {
    $this->getJson('/api/v1/loker/lokers')->assertUnauthorized();
});

test('unknown tenant slug returns 404', function () {
    app()->instance(LokerTenantResolver::class, new class
    {
        public function connection(): string
        {
            throw new ModelNotFoundException('Tenant with slug [unknown-tenant] not found.');
        }
    });

    $issued = $this->tokens->issue('Client', ['loker.read']);

    $this->getJson('/api/v1/loker/lokers', ['Authorization' => 'Bearer '.$issued['plain']])
        ->assertNotFound()
        ->assertJsonPath('message', 'Tenant with slug [unknown-tenant] not found.');
});
