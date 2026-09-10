<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IeltsReadingPracticeResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'material_id',
        'correct_count',
        'total_questions',
        'band_score',
        'answers_data'
    ];

    protected $casts = [
        'answers_data' => 'array'
    ];
}
