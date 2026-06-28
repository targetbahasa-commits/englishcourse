<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IeltsSpeakingTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'part',
        'slug',
        'title',
        'icon',
        'color',
        'questions',
        'subtopics',
        'order',
        'is_locked',
        'idioms',
        'collocations',
        'advanced_verbs',
        'advanced_adverbs',
        'advanced_adjectives',
        'part3_title',
        'part3_questions',
        'part3_idioms',
        'part3_collocations',
        'is_free_tier',
        'test_type',
        'system_prompt_override',
    ];


    protected $casts = [
        'part' => 'integer',
        'questions' => 'array',
        'subtopics' => 'array',
        'order' => 'integer',
        'is_locked' => 'boolean',
        'idioms' => 'array',
        'collocations' => 'array',
        'advanced_verbs' => 'array',
        'advanced_adverbs' => 'array',
        'advanced_adjectives' => 'array',
        'part3_questions' => 'array',
        'part3_idioms' => 'array',
        'part3_collocations' => 'array',
    ];

}
