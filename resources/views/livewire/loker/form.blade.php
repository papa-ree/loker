<div x-data="{ 
    nama_pekerjaan: @entangle('nama_pekerjaan'), 
    nama_perusahaan: @entangle('nama_perusahaan'),
    lokasi: @entangle('lokasi'),
    randomRef: @entangle('randomRef'),
    slug: @entangle('slug'),
    get combinedTitle() {
        let parts = [this.nama_pekerjaan, this.nama_perusahaan, this.lokasi];
        let base = parts.filter(p => p && p.trim() !== '').join(' ');
        return base ? (base + ' ref ' + this.randomRef) : '';
    }
}">
    <x-core::breadcrumb :items="[['label' => __('Daftar Lowongan'), 'route' => 'loker.loker.index']]" :active="$lokerId ? __('Edit Lowongan') : __('Tambah Lowongan')" />

    <form @submit.prevent="saveLoker($event)">
        <div class="max-w-4xl mx-auto mt-6 space-y-6">

            {{-- ── PAGE TITLE ── --}}
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                        {{ $lokerId ? __('Edit Lowongan Kerja') : __('Tambah Lowongan Baru') }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                        {{ __('Isi informasi di bawah ini dengan lengkap dan akurat.') }}
                    </p>
                </div>
                {{-- Progress indicator --}}
                <div class="hidden md:flex items-center gap-2">
                    <span class="text-xs text-gray-400 dark:text-gray-500">5 bagian</span>
                    <div class="flex gap-1">
                        @foreach(range(1, 5) as $i)
                            <div class="w-6 h-1.5 rounded-full bg-indigo-500 opacity-{{ $i <= 2 ? '100' : '30' }}"></div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════════════════════ --}}
            {{-- SECTION 1: Informasi Pekerjaan --}}
            {{-- ═══════════════════════════════════════════════════════════════ --}}
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden">
                {{-- Section Header --}}
                <div
                    class="flex items-center gap-3 px-6 py-4 bg-indigo-50/60 dark:bg-indigo-900/10 border-b border-indigo-100 dark:border-indigo-900/30">
                    <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                        <x-lucide-briefcase class="w-4 h-4 text-indigo-600 dark:text-indigo-400" />
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ __('Informasi Pekerjaan') }}</h3>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">
                            {{ __('Data utama posisi yang ditawarkan') }}</p>
                    </div>
                    <span
                        class="ml-auto text-[10px] font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-100 dark:bg-indigo-900/40 px-2 py-0.5 rounded-full">01</span>
                </div>

                <div class="p-6 space-y-5">
                    {{-- Nama Pekerjaan --}}
                    <div>
                        <x-core::input label="{{ __('Nama / Posisi Pekerjaan') }}" name="nama_pekerjaan" wire:model="nama_pekerjaan"
                            x-model="nama_pekerjaan"
                            placeholder="{{ __('Contoh: Frontend Developer, Marketing Manager') }}" required />
                        <x-core::input-error for="nama_pekerjaan" />
                        <p class="mt-1.5 text-[11px] text-gray-400 dark:text-gray-500">
                            {{ __('Nama posisi yang jelas membantu kandidat lebih mudah menemukan lowongan ini.') }}</p>
                    </div>

                    {{-- Slug --}}
                    <div>
                        <x-core::input label="{{ __('Slug URL') }}" name="slug" wire:model="slug" x-model="slug" x-slug="combinedTitle" required />
                        <x-core::input-error for="slug" />
                        <p class="mt-1.5 text-[11px] text-gray-400 dark:text-gray-500 flex items-center gap-1">
                            <x-lucide-info class="w-3 h-3" />
                            {{ __('Otomatis dibuat dari nama pekerjaan + perusahaan. Bisa diubah manual.') }}
                        </p>
                    </div>

                    {{-- Baris: Tipe & Kategori --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        {{-- Tipe Pekerjaan --}}
                        <div>
                            <x-core::select-dropdown :label="__('Tipe Pekerjaan')" :items="$tipeOptions" model="tipe"
                                labelField="name" valueField="name" />
                            <input type="hidden" name="tipe" x-model="$wire.tipe">
                            <x-core::input-error for="tipe" />
                        </div>

                        {{-- Kategori --}}
                        <div>
                            <x-core::select-dropdown :label="__('Kategori')" :items="$categoryOptions" model="kategory"
                                labelField="name" valueField="name" />
                            <input type="hidden" name="kategory" x-model="$wire.kategory">
                            <x-core::input-error for="kategory" />
                        </div>
                    </div>

                    {{-- Baris: Gaji --}}
                    <div>
                        <x-core::input label="{{ __('Perkiraan Gaji') }}" name="gaji" wire:model="gaji"
                            placeholder="{{ __('Contoh: Rp 5.000.000 – Rp 7.000.000 / bulan') }}" />
                        <x-core::input-error for="gaji" />
                        <p class="mt-1.5 text-[11px] text-gray-400 dark:text-gray-500">
                            {{ __('Menampilkan kisaran gaji meningkatkan jumlah pelamar yang relevan.') }}</p>
                    </div>

                    {{-- Tanggal Berakhir --}}
                    <div
                        class="flex items-start gap-3 p-4 bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-800/40 rounded-xl">
                        <div class="mt-0.5 p-1.5 bg-amber-100 dark:bg-amber-900/30 rounded-lg">
                            <x-lucide-calendar-x-2 class="w-4 h-4 text-amber-600 dark:text-amber-400" />
                        </div>
                        <div class="flex-1">
                            <x-core::input type="date" label="{{ __('Tanggal Berakhir Lowongan') }}" name="tgl_berakhir"
                                onclick="this.showPicker()"
                                wire:model="tgl_berakhir" />
                            <x-core::input-error for="tgl_berakhir" />
                            <p class="mt-1.5 text-[11px] text-amber-600 dark:text-amber-400">
                                {{ __('Lowongan akan otomatis ditandai "Expired" setelah tanggal ini. Kosongkan jika tanpa batas.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════════════════════ --}}
            {{-- SECTION 2: Informasi Perusahaan --}}
            {{-- ═══════════════════════════════════════════════════════════════ --}}
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden">
                <div
                    class="flex items-center gap-3 px-6 py-4 bg-emerald-50/60 dark:bg-emerald-900/10 border-b border-emerald-100 dark:border-emerald-900/30">
                    <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                        <x-lucide-building-2 class="w-4 h-4 text-emerald-600 dark:text-emerald-400" />
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ __('Informasi Perusahaan') }}
                        </h3>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">
                            {{ __('Profil dan kontak perusahaan pemberi kerja') }}</p>
                    </div>
                    <span
                        class="ml-auto text-[10px] font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-900/40 px-2 py-0.5 rounded-full">02</span>
                </div>

                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-core::select-dropdown :label="__('Nama Perusahaan')" :items="$companyOptions" model="nama_perusahaan"
                                labelField="name" valueField="name" />
                            <input type="hidden" name="nama_perusahaan" x-model="$wire.nama_perusahaan">
                            <x-core::input-error for="nama_perusahaan" />
                        </div>
                        <div>
                            <x-core::input label="{{ __('Website Perusahaan') }}" name="url_perusahaan" wire:model="url_perusahaan"
                                placeholder="https://perusahaan.com" />
                            <x-core::input-error for="url_perusahaan" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <x-core::input label="{{ __('Kota / Lokasi') }}" name="lokasi" wire:model="lokasi"
                                placeholder="{{ __('Jakarta, Remote, dll.') }}" />
                            <x-core::input-error for="lokasi" />
                        </div>
                        <div>
                            <x-core::input label="{{ __('Alamat Lengkap') }}" name="alamat_perusahaan" wire:model="alamat_perusahaan"
                                placeholder="{{ __('Jl. Contoh No. 1, Kecamatan…') }}" />
                            <x-core::input-error for="alamat_perusahaan" />
                        </div>
                    </div>

                    <div>
                        <x-core::textarea label="{{ __('Tentang Perusahaan') }}" name="deskripsi_perusahaan" wire:model="deskripsi_perusahaan" rows="3"
                            placeholder="{{ __('Deskripsikan perusahaan secara singkat — bidang, visi, atau keunggulan yang menarik kandidat.') }}" />
                        <x-core::input-error for="deskripsi_perusahaan" />
                    </div>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════════════════════ --}}
            {{-- SECTION 3: Detail Pekerjaan --}}
            {{-- ═══════════════════════════════════════════════════════════════ --}}
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden">
                <div
                    class="flex items-center gap-3 px-6 py-4 bg-blue-50/60 dark:bg-blue-900/10 border-b border-blue-100 dark:border-blue-900/30">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                        <x-lucide-file-text class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ __('Detail Pekerjaan') }}</h3>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">
                            {{ __('Deskripsi tugas dan cara melamar') }}</p>
                    </div>
                    <span
                        class="ml-auto text-[10px] font-bold text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900/40 px-2 py-0.5 rounded-full">03</span>
                </div>

                <div class="p-6 space-y-5">
                    <div>
                        <x-core::textarea label="{{ __('Deskripsi Pekerjaan') }}" name="deskripsi_pekerjaan" wire:model="deskripsi_pekerjaan" rows="5"
                            placeholder="{{ __('Jelaskan tugas, tanggung jawab, dan ekspektasi dari posisi ini…') }}" />
                        <x-core::input-error for="deskripsi_pekerjaan" />
                    </div>

                    <div
                        class="flex items-start gap-3 p-4 bg-blue-50 dark:bg-blue-900/10 border border-blue-200 dark:border-blue-800/40 rounded-xl">
                        <div class="mt-0.5 p-1.5 bg-blue-100 dark:bg-blue-900/30 rounded-lg shrink-0">
                            <x-lucide-send class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                        </div>
                        <div class="flex-1">
                            <label
                                class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Cara Melamar') }}</label>
                            <x-core::textarea name="apply" wire:model="apply" rows="3"
                                placeholder="{{ __('Contoh: Kirim CV dan portofolio ke hr@perusahaan.com dengan subjek "
                                Nama – Posisi"') }}" />
                            <x-core::input-error for="apply" />
                            <p class="mt-1.5 text-[11px] text-blue-600 dark:text-blue-400">
                                {{ __('Jelaskan langkah-langkah yang harus dilakukan pelamar agar tidak ada kebingungan.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════════════════════ --}}
            {{-- SECTION 4: Persyaratan & Kualifikasi (EditorJS) --}}
            {{-- ═══════════════════════════════════════════════════════════════ --}}
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden">
                <div
                    class="flex items-center gap-3 px-6 py-4 bg-purple-50/60 dark:bg-purple-900/10 border-b border-purple-100 dark:border-purple-900/30">
                    <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                        <x-lucide-list-checks class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                            {{ __('Persyaratan & Kualifikasi') }}</h3>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">
                            {{ __('Gunakan heading, poin, atau tabel sesuai kebutuhan') }}</p>
                    </div>
                    <span
                        class="ml-auto text-[10px] font-bold text-purple-600 dark:text-purple-400 bg-purple-100 dark:bg-purple-900/40 px-2 py-0.5 rounded-full">04</span>
                </div>

                <div class="p-6">
                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                        {{-- Editor toolbar hint --}}
                        <div
                            class="px-4 py-2 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                            <div class="flex items-center gap-3 text-[11px] text-gray-400 dark:text-gray-500">
                                <span class="flex items-center gap-1"><x-lucide-type class="w-3 h-3" />Heading</span>
                                <span class="flex items-center gap-1"><x-lucide-list class="w-3 h-3" />List</span>
                                <span class="flex items-center gap-1"><x-lucide-table class="w-3 h-3" />Tabel</span>
                            </div>
                            <span
                                class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">{{ __('Rich Text') }}</span>
                        </div>
                        {{-- Editor --}}
                        <div wire:ignore id="editorjs-persyaratan"
                            class="p-6 min-h-[280px] prose prose-slate dark:prose-invert max-w-none bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
                        </div>
                    </div>
                    <x-core::input-error for="persyaratan_kualifikasi" />
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════════════════════ --}}
            {{-- SECTION 5: Pengaturan Publikasi --}}
            {{-- ═══════════════════════════════════════════════════════════════ --}}
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden">
                <div
                    class="flex items-center gap-3 px-6 py-4 bg-rose-50/60 dark:bg-rose-900/10 border-b border-rose-100 dark:border-rose-900/30">
                    <div class="p-2 bg-rose-100 dark:bg-rose-900/30 rounded-lg">
                        <x-lucide-settings-2 class="w-4 h-4 text-rose-600 dark:text-rose-400" />
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ __('Pengaturan Publikasi') }}
                        </h3>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">
                            {{ __('Visibilitas lowongan di halaman publik') }}</p>
                    </div>
                    <span
                        class="ml-auto text-[10px] font-bold text-rose-600 dark:text-rose-400 bg-rose-100 dark:bg-rose-900/40 px-2 py-0.5 rounded-full">05</span>
                </div>

                <div class="p-6">
                    <label for="active-toggle" class="flex items-center justify-between cursor-pointer group">
                        <div class="flex items-center gap-4">
                            <div
                                class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl group-hover:bg-emerald-100 dark:group-hover:bg-emerald-900/30 transition-colors">
                                <x-lucide-eye class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ __('Publikasikan Lowongan') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                    {{ __('Aktifkan agar lowongan tampil di halaman publik dan dapat dilamar.') }}</p>
                            </div>
                        </div>
                        <div class="relative inline-block w-12 h-6 shrink-0 ml-4">
                            <input type="checkbox" id="active-toggle" name="actived" value="1" wire:model="actived" class="peer sr-only" />
                            <span
                                class="absolute inset-0 bg-gray-300 dark:bg-slate-700 rounded-full transition-colors duration-300 peer-checked:bg-emerald-500"></span>
                            <span
                                class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow-sm transition-transform duration-300 peer-checked:translate-x-6"></span>
                        </div>
                    </label>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════════════════════ --}}
            {{-- STICKY ACTION BAR --}}
            {{-- ═══════════════════════════════════════════════════════════════ --}}
            <div class="sticky bottom-4 z-30">
                <div
                    class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-md rounded-2xl border border-gray-200 dark:border-slate-700 shadow-xl px-6 py-4 flex items-center justify-between gap-4">
                    <div class="hidden sm:block">
                        <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">
                            {{ $lokerId ? __('Perbarui') : __('Simpan') }} {{ __('semua perubahan') }}</p>
                        <p class="text-[11px] text-gray-400 dark:text-gray-500">
                            {{ __('Pastikan semua bagian telah terisi sebelum menyimpan.') }}</p>
                    </div>
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <x-core::secondary-button link href="{{ route('loker.loker.index') }}"
                            label="{{ __('Batal') }}" />
                        <div class="flex-1 sm:flex-none">
                            <x-core::button type="submit"
                                label="{{ $lokerId ? __('Perbarui Lowongan') : __('Simpan Lowongan') }}" spinner="save">
                                <x-slot name="icon"><x-lucide-check class="w-4 h-4" /></x-slot>
                            </x-core::button>
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- end max-w --}}
    </form>

    @push('styles')
        <style>
            /* ─── Editor Dark Mode ──────────────────────────────────────── */
            .dark #editorjs-persyaratan .ce-block {
                color: #e2e8f0;
            }

            .dark #editorjs-persyaratan *::selection {
                background-color: rgba(59, 130, 246, .6);
                color: #fff;
            }

            .dark #editorjs-persyaratan .ce-block--selected .ce-block__content {
                background-color: rgba(51, 65, 85, .6);
            }

            .dark #editorjs-persyaratan .ce-paragraph[data-placeholder]:empty::before {
                color: #475569;
            }

            .dark .ce-toolbar__plus,
            .dark .ce-toolbar__settings-btn {
                color: #94a3b8;
            }

            .dark .ce-toolbar__plus:hover,
            .dark .ce-toolbar__settings-btn:hover {
                color: #f1f5f9;
                background-color: #334155;
            }

            .dark .ce-popover,
            .dark .ce-popover__container {
                background-color: #1e293b;
                border-color: #334155;
            }

            .dark .ce-popover {
                box-shadow: 0 8px 24px rgba(0, 0, 0, .45);
            }

            .dark .ce-popover-item {
                color: #e2e8f0;
            }

            .dark .ce-popover-item:hover,
            .dark .ce-popover-item--focused {
                background-color: #334155;
            }

            .dark .ce-inline-toolbar {
                background-color: #1e293b;
                border-color: #334155;
            }

            .dark .ce-inline-tool {
                color: #cbd5e1;
            }

            .dark .ce-inline-tool:hover {
                background-color: #334155;
                color: #f1f5f9;
            }
        </style>
    @endpush

    @script
    <script>
        let editor;

        const initEditor = () => {
            // Destroy existing instance if any (clean up for wire:navigate)
            if (editor && typeof editor.destroy === 'function') {
                editor.destroy();
            }

            const data = @js($persyaratan_kualifikasi);
            editor = new EditorJS({
                holder: 'editorjs-persyaratan',
                tools: {
                    header: {
                        class: Header,
                        inlineToolbar: ['link'],
                        config: { placeholder: 'Header', levels: [2, 3, 4], defaultLevel: 3 }
                    },
                    list: {
                        class: List,
                        inlineToolbar: true,
                        config: { defaultStyle: 'unordered' }
                    },
                    table: {
                        class: Table,
                        inlineToolbar: true,
                        config: { rows: 2, cols: 3 }
                    },
                },
                data: data,
                placeholder: "{{ __('Tulis persyaratan dan kualifikasi di sini…') }}"
            });
        };

        // Initialize immediately (handles initial load and wire:navigate)
        initEditor();

        window.saveLoker = async function (event)
        {
            const savedData = await editor.saver.save();
            const formData = Object.fromEntries(new FormData(event.target));
            $wire.save(formData, savedData);
        }
    </script>
    @endscript
</div>