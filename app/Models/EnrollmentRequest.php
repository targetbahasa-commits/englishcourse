<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnrollmentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'program_id',
        'class_period_id',
        'status',
        'notes',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function classPeriod(): BelongsTo
    {
        return $this->belongsTo(ClassPeriod::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
