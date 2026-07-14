<?php

namespace Bale\Loker\Livewire\Loker;

use Bale\Loker\Models\Category;
use Bale\Loker\Models\Company;
use Bale\Loker\Models\Loker;
use Bale\Loker\Models\Type;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Bale\Cms\Services\TenantConnectionService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

#[Layout('cms::layouts.app')]
class Form extends Component
{
    public ?string $lokerId = null;

    public array $tipeOptions = [];
    public array $companyOptions = [];
    public array $categoryOptions = [];

    // Form fields
    public string $nama_perusahaan = '';
    public ?string $deskripsi_perusahaan = '';
    public ?string $url_perusahaan = '';
    public ?string $alamat_perusahaan = '';
    public string $nama_pekerjaan = '';
    public ?string $deskripsi_pekerjaan = '';
    public ?string $lokasi = '';
    public ?string $gaji = '';
    public ?string $tipe = '';
    public ?string $kategory = '';
    public ?string $apply = '';
    public array $persyaratan_kualifikasi = [];
    public string $slug = '';
    public string $randomRef = '';
    public bool $actived = true;
    public ?string $tgl_berakhir = null;

    public function mount(?string $id = null): void
    {
        TenantConnectionService::ensureActive();
        $this->fetchOptions();
        $this->randomRef = Str::lower(Str::random(5));

        if ($id) {
            $this->lokerId = $id;
            $loker = Loker::findOrFail($id);
            $this->fill($loker->toArray());

            // Extract randomRef from existing slug if it exists in the format -ref-xxxxx
            if (preg_match('/-ref-([a-z0-9]{5})$/', $this->slug, $matches)) {
                $this->randomRef = $matches[1];
            }

            if ($loker->tgl_berakhir) {
                $this->tgl_berakhir = $loker->tgl_berakhir->format('Y-m-d');
            }
        }
    }

    public function fetchOptions(): void
    {
        TenantConnectionService::ensureActive();
        $connection = TenantConnectionService::connection();

        $this->companyOptions = Company::on($connection)->where('actived', true)->get(['name', 'website', 'address', 'description'])->toArray();
        $this->tipeOptions = Type::on($connection)->where('actived', true)->get(['name'])->toArray();
        $this->categoryOptions = Category::on($connection)->where('actived', true)->get(['name'])->toArray();
    }

    public function updatedNamaPerusahaan($value): void
    {
        $company = collect($this->companyOptions)->where('name', $value)->first();
        if ($company) {
            $this->url_perusahaan = $company['website'] ?? $this->url_perusahaan;
            $this->alamat_perusahaan = $company['address'] ?? $this->alamat_perusahaan;
            $this->deskripsi_perusahaan = $company['description'] ?? $this->deskripsi_perusahaan;
        }
    }

    public function rules()
    {
        TenantConnectionService::ensureActive();
        $connection = TenantConnectionService::connection();

        return [
            'nama_perusahaan' => 'required|string|max:255',
            'nama_pekerjaan' => 'required|string|max:255',
            'slug' => 'required|string|unique:' . $connection . '.loker,slug,' . ($this->lokerId ?? 'NULL') . ',id',
            'tgl_berakhir' => 'nullable|date',
        ];
    }

    public function save($formData, array $editorData = [])
    {
        if (!empty($editorData)) {
            $this->persyaratan_kualifikasi = $editorData;
        }

        // Map formData to properties
        $this->nama_pekerjaan = $formData['nama_pekerjaan'] ?? $this->nama_pekerjaan;
        $this->slug = $formData['slug'] ?? $this->slug;
        $this->nama_perusahaan = $formData['nama_perusahaan'] ?? $this->nama_perusahaan;
        $this->tipe = $formData['tipe'] ?? $this->tipe;
        $this->kategory = $formData['kategory'] ?? $this->kategory;
        $this->gaji = $formData['gaji'] ?? $this->gaji;
        $this->tgl_berakhir = !empty($formData['tgl_berakhir']) ? $formData['tgl_berakhir'] : null;
        $this->url_perusahaan = $formData['url_perusahaan'] ?? $this->url_perusahaan;
        $this->lokasi = $formData['lokasi'] ?? $this->lokasi;
        $this->alamat_perusahaan = $formData['alamat_perusahaan'] ?? $this->alamat_perusahaan;
        $this->deskripsi_perusahaan = $formData['deskripsi_perusahaan'] ?? $this->deskripsi_perusahaan;
        $this->deskripsi_pekerjaan = $formData['deskripsi_pekerjaan'] ?? $this->deskripsi_pekerjaan;
        $this->apply = $formData['apply'] ?? $this->apply;
        $this->actived = isset($formData['actived']) ? (bool)$formData['actived'] : $this->actived;

        $this->validate();

        \DB::beginTransaction();

        try {
            TenantConnectionService::ensureActive();
            $connection = TenantConnectionService::connection();

            // Future-proof slug: ensure uniqueness
            if (!$this->lokerId) {
                $this->slug = $this->makeUniqueSlug($this->slug ?: Str::slug($this->nama_pekerjaan), $connection);
            }

            $data = [
                'nama_perusahaan' => $this->nama_perusahaan,
                'deskripsi_perusahaan' => $this->deskripsi_perusahaan,
                'url_perusahaan' => $this->url_perusahaan,
                'alamat_perusahaan' => $this->alamat_perusahaan,
                'nama_pekerjaan' => $this->nama_pekerjaan,
                'deskripsi_pekerjaan' => $this->deskripsi_pekerjaan,
                'lokasi' => $this->lokasi,
                'gaji' => $this->gaji,
                'tipe' => $this->tipe,
                'kategory' => $this->kategory,
                'apply' => $this->apply,
                'persyaratan_kualifikasi' => $this->persyaratan_kualifikasi,
                'slug' => $this->slug,
                'actived' => $this->actived,
                'tgl_berakhir' => $this->tgl_berakhir,
            ];

            if ($this->lokerId) {
                Loker::on($connection)->where('id', $this->lokerId)->update($data);
                $this->dispatch('toast', message: __('Lowongan kerja berhasil diperbarui.'), type: 'success');
            } else {
                Loker::on($connection)->create($data);
                $this->dispatch('toast', message: __('Lowongan kerja berhasil ditambahkan.'), type: 'success');
            }

            \DB::commit();

            $this->redirectRoute('loker.loker.index', navigate: true);
        } catch (\Throwable $th) {
            \DB::rollBack();
            info('Loker save failed: ' . $th->getMessage());
            $this->dispatch('toast', message: __('Terjadi kesalahan saat menyimpan data: ') . $th->getMessage(), type: 'error');
        }
    }

    protected function makeUniqueSlug(string $slug, string $connection): string
    {
        $originalSlug = $slug;

        // Check if slug exists
        if (Loker::on($connection)->where('slug', $slug)->exists()) {
            // Append a short random string for better uniqueness and future-proofing
            $slug = $originalSlug . '-' . Str::lower(Str::random(5));
            
            // In the extremely rare case it still exists, fallback to original unique logic
            while (Loker::on($connection)->where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . Str::lower(Str::random(5));
            }
        }

        return $slug;
    }

    public function render()
    {
        $lokerVisitorStats = null;

        if ($this->lokerId) {
            TenantConnectionService::ensureActive();
            $connection = TenantConnectionService::connection();

            // Ambil aggregate kunjungan untuk loker ini berdasarkan slug
            $loker = Loker::find($this->lokerId);

            if ($loker) {
                $lokerVisitorStats = DB::connection($connection)
                    ->table('loker_visitor')
                    ->where('loker_slug', $loker->slug)
                    ->selectRaw('
                        COALESCE(SUM(pageviews), 0) as total_pageviews,
                        COALESCE(SUM(visitors), 0)  as total_visitors,
                        COUNT(*) as total_days_tracked,
                        MAX(date) as last_tracked_date
                    ')
                    ->first();

                // Chart 7 hari terakhir untuk loker ini
                $timezone  = config('core.analytics.umami.timezone', 'Asia/Jakarta');
                $startDate = now($timezone)->subDays(6)->startOfDay()->format('Y-m-d');

                $rawChart = DB::connection($connection)
                    ->table('loker_visitor')
                    ->selectRaw("DATE_FORMAT(date, '%Y-%m-%d') as date_key, pageviews, visitors")
                    ->where('loker_slug', $loker->slug)
                    ->where('date', '>=', $startDate)
                    ->orderBy('date_key')
                    ->get()
                    ->keyBy('date_key');

                $chartLabels = $chartPageviews = $chartVisitors = [];
                for ($i = 6; $i >= 0; $i--) {
                    $day = now($timezone)->subDays($i);
                    $key = $day->format('Y-m-d');
                    $chartLabels[]    = $day->format('M d');
                    $chartPageviews[] = (int) ($rawChart->get($key)?->pageviews ?? 0);
                    $chartVisitors[]  = (int) ($rawChart->get($key)?->visitors ?? 0);
                }

                $lokerVisitorStats->chart = [
                    'labels'    => $chartLabels,
                    'pageviews' => $chartPageviews,
                    'visitors'  => $chartVisitors,
                ];
            }
        }

        return view('loker::livewire.loker.form', compact('lokerVisitorStats'))
            ->title($this->lokerId ? 'Edit Lowongan' : 'Tambah Lowongan');
    }
}
