# bale/loker

Package fitur **Job Vacancy (Loker)** untuk `bale/cms`. Menyediakan pengelolaan
lowongan kerja beserta kategori, tipe lowongan, dan perusahaan di dalam CMS
multi-tenant. Seluruh data berada pada **koneksi tenant** (aktif), bukan landlord.

## Kebutuhan

| Dependency | Alasan |
|------------|--------|
| `bale/cms` | Multi-tenancy, `SwitchBaleConnection`, `EnsureBaleSelected`, komponen CMS |
| `bale/core` | Auth, permission, komponen UI, layout |

## Instalasi

```bash
composer require bale/loker
```

```bash
php artisan vendor:publish --tag="loker:migrations"
php artisan migrate
```

```bash
php artisan vendor:publish --tag="loker:config"
```

## Command

| Command | Fungsi |
|---------|--------|
| `loker:install` | Seed permission, kategori, dan tipe lowongan bawaan |
| `loker:migrate` | Publish lalu jalankan migration Loker |
| `loker:publish-config` | Publish `config/loker.php` |
| `loker:sync-visitors` | Sinkronisasi data visitor lowongan |

## Routing

Semua route berada di bawah prefix `cms/loker`, middleware `web` + `auth`, dan
di-guard oleh `EnsureBaleSelected` + `SwitchBaleConnection`.

| Path | Nama route | Keterangan |
|------|------------|------------|
| `GET /cms/loker/overview` | `loker.overview` | Dashboard lowongan |
| `GET /cms/loker` | `loker.loker.index` | Daftar lowongan |
| `GET /cms/loker/create` | `loker.loker.create` | Form lowongan |
| `GET /cms/loker/edit/{id}` | `loker.loker.edit` | Edit lowongan |
| `GET /cms/loker/categories` | `loker.category.index` | Kategori lowongan |
| `GET /cms/loker/types` | `loker.type.index` | Tipe lowongan |
| `GET /cms/loker/companies` | `loker.company.index` | Perusahaan |
| `POST /cms/loker/sync-visitors` | `loker.sync-visitors` | Trigger sinkronisasi visitor |

## Testing

```bash
vendor\bin\pest packages\loker
```

## License

MIT. Lihat [LICENSE.md](LICENSE.md).
