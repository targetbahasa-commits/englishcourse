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
        'min_capacity',
        'max_capacity',
        'batch_number',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'quota_met_at' => 'datetime',
        'quota_met_notified_at' => 'datetime',
        'quota_met_decided_at' => 'datetime',
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

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
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

    public function studentGroups(): HasMany
    {
        return $this->hasMany(StudentGroup::class);
    }

    /**
     * Counts occupied seats as the union of the legacy users.class_period_id
     * assignment (admin's manual "Add Student") and active Enrollment rows
     * (self-service / admin-registered booking), deduplicated by student - a
     * seat is occupied either way, and a student could in principle appear
     * via both.
     */
    public function occupiedSeats(): int
    {
        $legacyIds = User::where('class_period_id', $this->id)->where('role', 'student')->pluck('id');
        $enrollmentIds = Enrollment::where('class_period_id', $this->id)->where('status', 'active')->pluck('user_id');

        return $legacyIds->merge($enrollmentIds)->unique()->count();
    }
}
