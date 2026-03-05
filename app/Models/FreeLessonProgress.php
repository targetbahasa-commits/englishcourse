<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeLessonProgress extends Model
{
    use HasFactory;

    protected $table = 'free_lesson_progress';

    protected $fillable = [
        'user_id',
        'lesson_slug',
        'score',
        'total_questions',
        'completed_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
