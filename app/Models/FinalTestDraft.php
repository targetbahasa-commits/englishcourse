<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Autosaved in-progress answers for a Final Test, keyed by (user_id, test_type).
 * Purely a crash/exit-safety net - completeFinalTest() deletes the row for
 * that user+test_type the moment a real submission succeeds.
 */
class FinalTestDraft extends Model
{
    protected $fillable = [
        'user_id',
        'test_type',
        'answers',
        'time_spent_seconds',
        'last_saved_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'last_saved_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
