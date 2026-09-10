<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassPeriodGameVisibility extends Model
{
    protected $table = 'class_period_game_visibility';

    protected $fillable = [
        'class_period_id',
        'meeting_id',
        'game_index',
        'is_open',
    ];

    protected $casts = [
        'is_open' => 'boolean',
    ];

    public function classPeriod(): BelongsTo
    {
        return $this->belongsTo(ClassPeriod::class);
    }

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }
}
