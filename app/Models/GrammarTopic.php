<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrammarTopic extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'desc', 'order'];

    public function questions()
    {
        return $this->hasMany(GrammarTopicQuestion::class, 'grammar_topic_id')->orderBy('order');
    }
}
