<?php

namespace Bale\Loker\Models;

use Bale\Cms\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use UsesTenantConnection;
    use HasUuids;
    use SoftDeletes;

    protected $table = 'loker_companies';

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'website',
        'address',
        'description',
        'actived',
    ];

    protected $casts = [
        'actived' => 'boolean',
    ];

    /**
     * Get logo URL from CDN
     */
    protected function logoUrl(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn() => $this->logo ? \Bale\Core\Support\Cdn::url('logos/' . $this->logo) : null,
        );
    }
}
