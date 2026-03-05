<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meeting extends Model
{
    protected $fillable = ['program_id', 'meeting_number', 'title', 'is_locked'];

    protected $casts = [
        'is_locked' => 'boolean',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function classPeriods(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(ClassPeriod::class, 'class_period_meetings')
            ->withPivot('is_open')
            ->withTimestamps();
    }

    public function isLockedFor($user): bool
    {
        // If user has no class period, fall back to global lock defaults (or locked)
        if (!$user || !$user->class_period_id) {
            return $this->is_locked; // Fallback to global setting
        }
        
        // Check specific setting for this user's class period
        // We look for the pivot entry
        $periodSetting = $this->classPeriods()
            ->where('class_period_id', $user->class_period_id)
            ->first();

        if ($periodSetting) {
            // Rule exists: is_open = true means NOT locked. is_open = false means LOCKED.
            return !$periodSetting->pivot->is_open;
        }

        // No rule exists for this period? 
        // Logic: "Student must NOT see or access meetings from other class periods"
        // This implies default should be LOCKED if not explicitly opened.
        // However, to be safe during migration, maybe stick to global default?
        // Let's stick to: Default is LOCKED if not explicitly opened for that period.
        return true; 
    }
    public function ieltsSections(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(IeltsSection::class);
    }
}
