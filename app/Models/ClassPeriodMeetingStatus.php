<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassPeriodMeetingStatus extends Model
{
    protected $fillable = ['class_period', 'meeting_id', 'is_locked'];

    protected $casts = [
        'is_locked' => 'boolean',
    ];

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }
}
