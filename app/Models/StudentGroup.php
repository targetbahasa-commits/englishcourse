<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StudentGroup extends Model
{
    protected $fillable = [
        'class_period_id',
        'meeting_id',
        'game_index',
        'name',
    ];

    public function classPeriod(): BelongsTo
    {
        return $this->belongsTo(ClassPeriod::class);
    }

    /**
     * Null means this group applies batch-wide (all meetings) - the
     * original behavior before per-meeting grouping was added.
     */
    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'student_group_members')->withTimestamps();
    }
}
