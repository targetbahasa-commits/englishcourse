<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToeflReadingPassage extends Model
{
    protected $fillable = [
        'meeting_id',
        'passage_number',
        'content',
        'indonesian_translation',
    ];

    public function questions()
    {
        return $this->hasMany(ToeflReadingQuestion::class, 'passage_id');
    }
}
