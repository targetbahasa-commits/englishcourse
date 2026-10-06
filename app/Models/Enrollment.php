<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'program_id',
        'class_period_id',
        'teacher_id',
        'class_period_booked_at',
        'enrolled_at',
        'status'
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
        'class_period_booked_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function classPeriod(): BelongsTo
    {
        return $this->belongsTo(ClassPeriod::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
