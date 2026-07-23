<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrammarTopicQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'grammar_topic_id',
        'type',
        'question_id',
        'answer_en',
        'vocab_helper',
        'example',
        'order',
    ];

    protected $casts = [
        'vocab_helper' => 'array',
        'example' => 'array',
    ];

    public function topic()
    {
        return $this->belongsTo(GrammarTopic::class, 'grammar_topic_id');
    }
}
