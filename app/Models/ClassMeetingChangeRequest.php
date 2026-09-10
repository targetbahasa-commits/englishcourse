<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassMeetingChangeRequest extends Model
{
    protected $fillable = [
        'program_id',
        'class_period_id',
        'class_meeting_id',
        'requested_by',
        'requested_date',
        'status',
        'admin_note',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'requested_date' => 'date',
        'reviewed_at' => 'datetime',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function classPeriod()
    {
        return $this->belongsTo(ClassPeriod::class);
    }

    public function classMeeting()
    {
        return $this->belongsTo(ClassMeeting::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
