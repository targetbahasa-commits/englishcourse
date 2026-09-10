<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlacementReadingPassage extends Model
{
    protected $fillable = [
        'placement_test_package_id',
        'title',
        'passage_text',
        'level',
        'status',
        'order',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(PlacementTestPackage::class, 'placement_test_package_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(PlacementReadingQuestion::class)->orderBy('order');
    }

    public function isReady(): bool
    {
        return $this->status === 'ready';
    }
}
