<?php

namespace Bale\Loker\Models;

use Bale\Cms\Traits\UsesTenantConnection;
use Bale\Core\Support\Cdn;
use Bale\Core\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasUuids;
    use LogsActivity;
    use SoftDeletes;
    use UsesTenantConnection;

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
    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->logo ? Cdn::url('logos/'.$this->logo) : null,
        );
    }
}
