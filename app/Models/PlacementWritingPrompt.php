<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlacementWritingPrompt extends Model
{
    protected $fillable = [
        'placement_test_package_id',
        'title',
        'prompt_text',
        'min_words',
        'status',
        'order',
    ];

    protected $casts = [
        'min_words' => 'integer',
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
