<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalTestResult extends Model
{
    protected $fillable = [
        'user_id', 'name', 'email', 'candidate_id', 'test_type', 'test_label', 'status',
        'duration_minutes', 'time_spent_seconds', 'score', 'answers_data', 'evaluation_data',
        'started_at', 'completed_at',
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
