<?php

namespace Bale\Loker\Models;

use Bale\Cms\Traits\UsesTenantConnection;
use Bale\Core\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasUuids;
    use LogsActivity;
    use SoftDeletes;
    use UsesTenantConnection;

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
