<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlacementSpeakingPrompt extends Model
{
    protected $fillable = [
        'placement_test_package_id',
        'title',
        'prompt_text',
        'prep_seconds',
        'response_seconds',
        'status',
        'order',
    ];

    protected $casts = [
        'prep_seconds' => 'integer',
        'response_seconds' => 'integer',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(PlacementTestPackage::class, 'placement_test_package_id');
    }

    public function isReady(): bool
    {
        return $this->status === 'ready';
    }
}
