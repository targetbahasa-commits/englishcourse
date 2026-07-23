<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfflineTestResult extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'program',
        'batch',
        'test_type',
        'score',
        'score_details',
        'certificate_sent_at',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'score_details' => 'array',
        'certificate_sent_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
