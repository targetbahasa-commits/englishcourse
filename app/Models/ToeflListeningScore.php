<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToeflListeningScore extends Model
{
    protected $fillable = [
        'is_reported',
        'user_id',
        'meeting_number',
        'set_number',
        'score',
        'answers',
        'submitted_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'submitted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
