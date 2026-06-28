<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'program_id',
        'enrollment_id',
        'created_by',
        'invoice_number',
        'external_reference',
        'amount',
        'discount_amount',
        'paid_amount',
        'currency',
        'status',
        'payment_method',
        'payment_channel',
        'payment_provider',
        'due_at',
        'paid_at',
        'expired_at',
        'meta',
        'notes',
        'proof_file',
        'verified_by',
    ];

    protected $casts = [
        'due_at' => 'datetime',
        'paid_at' => 'datetime',
        'expired_at' => 'datetime',
        'meta' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Registration lead that led to this payment (via the user's converted_user_id).
     */
    public function registrationLead(): \Illuminate\Database\Eloquent\Relations\HasOneThrough
    {
        return $this->hasOneThrough(
            RegistrationLead::class,
            User::class,
            'id',            // users.id
            'converted_user_id', // registration_leads.converted_user_id
            'user_id',       // payments.user_id
            'id'             // users.id
        );
    }

    /**
     * Email logs related to this payment.
     */
    public function emailLogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EmailLog::class, 'related_id')
                    ->where('related_type', 'payment');
    }
}
