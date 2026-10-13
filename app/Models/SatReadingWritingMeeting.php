<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatReadingWritingMeeting extends Model
{
    use HasFactory;

    protected $table = 'sat_reading_writing_meetings';

    protected $fillable = [
        'meeting_number',
        'test_number',
        'module_number',
        'context',
        'title',
        'subtitle',
        'description',
        'is_locked',
    ];

    protected $casts = [
        'is_locked' => 'boolean',
        'meeting_number' => 'integer',
        'test_number' => 'integer',
        'module_number' => 'integer',
    ];

    public function questions()
    {
        return $this->hasMany(SatReadingWritingQuestion::class, 'meeting_id')->orderBy('question_number');
    }
}
