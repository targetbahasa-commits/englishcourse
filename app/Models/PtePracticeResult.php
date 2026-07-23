<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PtePracticeResult extends Model
{
    protected $fillable = [
        'user_id', 'module', 'topic_id',
        'score', 'max_score', 'duration_seconds', 'detail',
    ];

    protected $casts = [
        'detail' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
