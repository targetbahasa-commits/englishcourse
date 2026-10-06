<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatReadingWritingScore extends Model
{
    use HasFactory;

    protected $table = 'sat_reading_writing_scores';

    protected $fillable = [
        'user_id',
        'meeting_number',
        'score',
        'correct_count',
        'total_questions',
        'answers',
    ];

    protected $casts = [
        'score' => 'float',
        'correct_count' => 'integer',
        'total_questions' => 'integer',
        'meeting_number' => 'integer',
        'answers' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
