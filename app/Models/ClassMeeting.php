<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassMeeting extends Model
{
    protected $fillable = [
        'class_period_id',
        'meeting_id',
        'meeting_date',
        'meeting_number',
        'start_time',
        'end_time',
        'topic',
        'meeting_link',
        'recording_url',
        'recording_urls',
        'recording_password',
        'recording_passwords',
    ];

    protected $casts = [
        'meeting_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'recording_urls' => 'array',
        'recording_passwords' => 'array',
    ];

    public function classPeriod()
    {
        return $this->belongsTo(ClassPeriod::class);
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function changeRequests()
    {
        return $this->hasMany(ClassMeetingChangeRequest::class);
    }
}
