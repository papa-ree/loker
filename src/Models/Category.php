<?php

namespace Bale\Loker\Models;

use Bale\Cms\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use UsesTenantConnection;
    use HasUuids;
    use SoftDeletes;

    protected $table = 'loker_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'actived',
    ];

    protected $casts = [
        'actived' => 'boolean',
    ];
}
