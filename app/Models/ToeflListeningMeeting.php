<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToeflListeningMeeting extends Model
{
    protected $fillable = [
        'meeting_number',
        'title',
        'description',
        'is_locked',
        'transcript_enabled',
    ];

    protected $casts = [
        'is_locked' => 'boolean',
        'transcript_enabled' => 'boolean',
    ];
}
