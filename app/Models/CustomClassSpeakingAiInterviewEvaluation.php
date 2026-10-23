<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomClassSpeakingAiInterviewEvaluation extends Model
{
    use HasFactory;

    protected $table = 'custom_class_speaking_ai_interview_evaluations';

    protected $fillable = [
        'user_id',
        'class_period_id',
        'meeting_number',
        'overall_score',
        'cefr_level',
        'fluency_score',
        'vocabulary_score',
        'grammar_score',
        'pronunciation_score',
        'scores_data',
        'transcripts_data',
        'general_feedback',
    ];

    protected $casts = [
        'meeting_number' => 'integer',
        'overall_score' => 'integer',
        'fluency_score' => 'integer',
        'vocabulary_score' => 'integer',
        'grammar_score' => 'integer',
        'pronunciation_score' => 'integer',
        'scores_data' => 'array',
        'transcripts_data' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function classPeriod(): BelongsTo
    {
        return $this->belongsTo(ClassPeriod::class);
    }
}
