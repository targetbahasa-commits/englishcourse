<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IeltsReadingPassage extends Model
{
    protected $fillable = ['material_id', 'title', 'content', 'order'];

    public function questions()
    {
        return $this->hasMany(IeltsReadingQuestion::class, 'passage_id')
            ->orderBy('order')
            ->orderBy('question_number');
    }
}
