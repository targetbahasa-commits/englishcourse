<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineTestBatch extends Model
{
    protected $fillable = [
        'test_slug',
        'label',
        'code',
        'is_active',
        'code_access_enabled',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'code_access_enabled' => 'boolean',
    ];

    public function scopeForSlug($query, string $slug)
    {
        return $query->where('test_slug', $slug);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
