<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ToeflReadingScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_reported',
        'user_id',
        'meeting_number',
        'score',
        'correct_count',
        'total_questions',
    ];
}
