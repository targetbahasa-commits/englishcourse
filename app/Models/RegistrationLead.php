<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class RegistrationLead extends Model
{
    use Notifiable;

    protected $fillable = [
        'full_name', 'whatsapp', 'email', 'city', 'age', 'profession', 'profession_other',
        'program_id', 'class_period_id', 'converted_user_id', 'program_interest', 'mode', 'schedule_preference', 'preferred_time',
        'learning_goal', 'target_score', 'source', 'source_detail',
        'utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term',
        'acquisition_referrer', 'acquisition_landing_path', 'acquisition_source_page', 'acquisition_variant', 'acquisition_last_cta',
        'has_previous_course', 'previous_course_name', 'budget_range', 'best_contact_time',
        'notes', 'status', 'admin_notes', 'contacted_at', 'converted_at', 'password',
    ];

    protected $casts = [
        'has_previous_course' => 'boolean',
        'contacted_at'        => 'datetime',
        'converted_at'        => 'datetime',
        'age'                 => 'integer',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function classPeriod(): BelongsTo
    {
        return $this->belongsTo(ClassPeriod::class);
    }

    public function convertedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'converted_user_id');
    }

    /**
     * Email logs sent to this lead's email address or related to this lead.
     */
    public function emailLogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EmailLog::class, 'related_id')
                    ->where('related_type', 'registration_lead');
    }

    /**
     * Payments made by the converted student.
     */
    public function payments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Payment::class, 'user_id', 'converted_user_id');
    }



    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'new'       => 'blue',
            'contacted' => 'yellow',
            'converted' => 'green',
            'cancelled' => 'red',
            default     => 'gray',
        };
    }

    public function getModeColorAttribute(): string
    {
        return match($this->mode) {
            'online'   => 'purple',
            'offline'  => 'orange',
            'flexible' => 'teal',
            default    => 'gray',
        };
    }
}
