<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'class_meeting_id',
        'status',
        'notes',
        'recorded_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classMeeting()
    {
        return $this->belongsTo(ClassMeeting::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
