<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrammarIntroTopic extends Model
{
    use HasFactory;

    protected $table = 'grammar_intro_topics';

    protected $fillable = ['label', 'topic', 'grammar_rules', 'order'];
}
