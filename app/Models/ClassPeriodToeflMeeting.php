<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassPeriodToeflMeeting extends Model
{
    protected $fillable = [
        'class_period_id',
        'module',
        'meeting_number',
        'is_open',
    ];

    protected $casts = [
        'is_open' => 'boolean',
    ];
}
