<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlacementListeningBank extends Model
{
    protected $fillable = [
        'placement_test_package_id',
        'title',
        'level',
        'audio',
        'duration',
        'transcript',
        'status',
        'order',
    ];

    protected $casts = [
        'duration' => 'integer',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(PlacementTestPackage::class, 'placement_test_package_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(PlacementListeningQuestion::class)->orderBy('order');
    }

    public function getAudioUrlAttribute(): ?string
    {
        return $this->audio ? asset('storage/' . $this->audio) : null;
    }

    public function isReady(): bool
    {
        return $this->status === 'ready';
    }
}
