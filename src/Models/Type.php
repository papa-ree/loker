<?php

namespace Bale\Loker\Models;

use Bale\Cms\Traits\UsesTenantConnection;
use Bale\Core\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use HasUuids;
    use LogsActivity;
    use SoftDeletes;
    use UsesTenantConnection;

    protected $table = 'loker_types';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'actived',
    ];

    protected $casts = [
        'actived' => 'boolean',
    ];
}
