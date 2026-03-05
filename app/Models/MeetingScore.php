<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'meeting_number',
        'score',
        'submitted_at'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    /**
     * Get the user that owns the meeting score.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
