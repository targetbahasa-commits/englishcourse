<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassPeriod extends Model
{
    protected $fillable = [
        'name',
        'program_id',
        'teacher_id',
        'class_type',
        'status',
        'learning_mode',
        'batch_type',
        'max_capacity',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function meetings(): BelongsToMany
    {
        return $this->belongsToMany(Meeting::class, 'class_period_meetings')
            ->withPivot('is_open')
            ->withTimestamps();
    }

    public function classMeetings(): HasMany
    {
        return $this->hasMany(ClassMeeting::class);
    }
}
