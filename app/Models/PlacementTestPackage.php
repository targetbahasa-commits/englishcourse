<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlacementTestPackage extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'active_from',
        'active_until',
        'order',
    ];

    protected $casts = [
        'active_from' => 'datetime',
        'active_until' => 'datetime',
    ];

    public function readingPassages(): HasMany
    {
        return $this->hasMany(PlacementReadingPassage::class);
    }

    public function listeningBanks(): HasMany
    {
        return $this->hasMany(PlacementListeningBank::class);
    }

    public function writingPrompts(): HasMany
    {
        return $this->hasMany(PlacementWritingPrompt::class);
    }

    public function speakingPrompts(): HasMany
    {
        return $this->hasMany(PlacementSpeakingPrompt::class);
    }

    /**
     * Manually toggled on via the "Activate"/"Deactivate" actions - this is
     * the admin's intent, independent of whether a schedule window is
     * currently open. Use effectivelyActive() for "is this the package that
     * should actually serve students right now".
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * The package that should actually serve students right now: manually
     * activated AND (no schedule set OR current time is inside the
     * active_from/active_until window). Computed at read-time so it doesn't
     * depend on a cron/scheduler running reliably.
     */
    public function scopeEffectivelyActive($query)
    {
        return $query->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('active_from')->orWhere('active_from', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('active_until')->orWhere('active_until', '>=', now());
            });
    }

    public function isEffectivelyActive(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }
        if ($this->active_from && now()->lt($this->active_from)) {
            return false;
        }
        if ($this->active_until && now()->gt($this->active_until)) {
            return false;
        }

        return true;
    }

    /**
     * @return 'active'|'scheduled'|'expired'|'draft'
     */
    public function scheduleState(): string
    {
        if ($this->status !== 'active') {
            return 'draft';
        }
        if ($this->active_from && now()->lt($this->active_from)) {
            return 'scheduled';
        }
        if ($this->active_until && now()->gt($this->active_until)) {
            return 'expired';
        }

        return 'active';
    }
}
