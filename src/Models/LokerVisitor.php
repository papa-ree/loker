<?php

namespace Bale\Loker\Models;

use Bale\Cms\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class LokerVisitor extends Model
{
    use UsesTenantConnection;
    use HasUuids;

    protected $table = 'loker_visitor';

    protected $fillable = [
        'loker_slug',
        'date',
        'pageviews',
        'visitors',
        'visits',
        'bounce_rate',
        'avg_session_duration',
    ];

    protected $casts = [
        'date' => 'date',
        'pageviews' => 'integer',
        'visitors' => 'integer',
        'visits' => 'integer',
        'bounce_rate' => 'float',
        'avg_session_duration' => 'integer',
    ];

    /**
     * Get the loker that owns the visitor record.
     */
    public function loker()
    {
        return $this->belongsTo(Loker::class, 'loker_slug', 'slug');
    }
}
