<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineTestResult extends Model
{
    protected $fillable = [
        'user_id',
        'online_test_taker_id',
        'test_slug',
        'test_label',
        'status',
        'duration_minutes',
        'time_spent_seconds',
        'score',
        'answers_data',
        'evaluation_data',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'duration_minutes' => 'integer',
        'time_spent_seconds' => 'integer',
        'score' => 'decimal:2',
        'answers_data' => 'array',
        'evaluation_data' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
