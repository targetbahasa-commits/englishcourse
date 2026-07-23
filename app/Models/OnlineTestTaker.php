<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineTestTaker extends Model
{
    protected $fillable = [
        'source_user_id',
        'name',
        'email',
        'date_of_birth',
        'sex',
        'country_of_origin',
        'country_of_nationality',
        'first_language',
        'test_type',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    protected static function booted(): void
    {
        static::created(function (OnlineTestTaker $taker): void {
            if ($taker->candidate_id) {
                return;
            }

            $taker->forceFill([
                'candidate_id' => self::generateCandidateId($taker->id),
            ])->saveQuietly();
        });
    }

    public static function generateCandidateId(int $takerId): string
    {
        return 'OTK-' . str_pad((string) $takerId, 8, '0', STR_PAD_LEFT);
    }

    public function accesses()
    {
        return $this->hasMany(OnlineTestUserAccess::class, 'online_test_taker_id');
    }

    public function results()
    {
        return $this->hasMany(OnlineTestResult::class, 'online_test_taker_id');
    }
}
