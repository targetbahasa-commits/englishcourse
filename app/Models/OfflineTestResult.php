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

    protected static function booted()
    {
        static::creating(function (self $result) {
            if (empty($result->certificate_number)) {
                $result->certificate_number = app(\App\Application\Certificates\GenerateCertificateNumber::class)
                    ->generate($result->test_type, now());
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
