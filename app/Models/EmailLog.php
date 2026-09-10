<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailLog extends Model
{
    protected $fillable = [
        'user_id',
        'related_type',
        'related_id',
        'to_email',
        'subject',
        'body',
        'status',
        'error_message',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the owning related model (RegistrationLead, Payment, etc.)
     */
    public function related()
    {
        return match ($this->related_type) {
            'registration_lead' => $this->belongsTo(RegistrationLead::class, 'related_id'),
            'payment' => $this->belongsTo(Payment::class, 'related_id'),
            'free_test_submission' => $this->belongsTo(FreeTestSubmission::class, 'related_id'),
            'outreach_message' => $this->belongsTo(OutreachMessage::class, 'related_id'),
            'offline_test_result' => $this->belongsTo(OfflineTestResult::class, 'related_id'),
            'final_test_result' => $this->belongsTo(FinalTestResult::class, 'related_id'),
            'user' => $this->belongsTo(User::class, 'related_id'),
            default => null,
        };
    }

    /**
     * Get the related registration lead if applicable.
     */
    public function registrationLead(): BelongsTo
    {
        return $this->belongsTo(RegistrationLead::class, 'related_id');
    }

    /**
     * Get the related payment if applicable.
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'related_id');
    }
}
