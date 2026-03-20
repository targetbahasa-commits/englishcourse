<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IeltsSpeakingTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'icon',
        'color',
        'questions',
        'subtopics',
        'order',
        'is_locked',
    ];


    protected $casts = [
        'questions' => 'array',
        'subtopics' => 'array',
        'order' => 'integer',
        'is_locked' => 'boolean',
    ];

}
