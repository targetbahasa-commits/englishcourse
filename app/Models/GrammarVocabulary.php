<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrammarVocabulary extends Model
{
    protected $fillable = [
        'meeting_number',
        'section',
        'word',
        'translation',
        'pos'
    ];
}
