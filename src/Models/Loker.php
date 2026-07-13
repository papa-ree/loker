<?php

namespace Bale\Loker\Models;

use Bale\Cms\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loker extends Model
{
    use UsesTenantConnection;
    use HasUuids;
    use SoftDeletes;

    protected $table = 'loker';

    protected $fillable = [
        'nama_perusahaan',
        'deskripsi_perusahaan',
        'url_perusahaan',
        'alamat_perusahaan',
        'nama_pekerjaan',
        'deskripsi_pekerjaan',
        'lokasi',
        'gaji',
        'tipe',
        'kategory',
        'apply',
        'persyaratan_kualifikasi',
        'slug',
        'actived',
        'tgl_berakhir',
    ];

    protected $casts = [
        'persyaratan_kualifikasi' => 'json',
        'actived' => 'boolean',
        'tgl_berakhir' => 'date',
    ];

    /**
     * Cek apakah lowongan sudah kadaluarsa.
     */
    protected function isExpired(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->tgl_berakhir && $this->tgl_berakhir->isPast(),
        );
    }

    /**
     * Get the visitor metrics for the loker.
     */
    public function visitors()
    {
        return $this->hasMany(LokerVisitor::class, 'loker_slug', 'slug');
    }
}

