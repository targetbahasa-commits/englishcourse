<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_reported',
        'user_id',
        'program_id',
        'meeting_number',
        'score',
        'submitted_at',
        'answers_data'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'answers_data' => 'array',
    ];

    /**
     * Get the user that owns the meeting score.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the program that the meeting score belongs to.
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
