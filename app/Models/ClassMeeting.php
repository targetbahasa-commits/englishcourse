<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassMeeting extends Model
{
    protected $fillable = [
        'class_period_id',
        'meeting_date',
        'meeting_number',
        'topic',
    ];

    protected $casts = [
        'meeting_date' => 'date',
    ];

    public function classPeriod()
    {
        return $this->belongsTo(ClassPeriod::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
