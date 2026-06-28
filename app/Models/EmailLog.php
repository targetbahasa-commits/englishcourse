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
        if ($this->related_type === 'registration_lead') {
            return $this->belongsTo(RegistrationLead::class, 'related_id');
        }
        if ($this->related_type === 'payment') {
            return $this->belongsTo(Payment::class, 'related_id');
        }
        return null;
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
