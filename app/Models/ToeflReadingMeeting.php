<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToeflReadingMeeting extends Model
{
    protected $fillable = [
        'meeting_number',
        'title',
        'is_locked',
        'is_free_tier'
    ];

    protected $casts = [
        'is_locked' => 'boolean',
        'is_free_tier' => 'boolean',
    ];
}
