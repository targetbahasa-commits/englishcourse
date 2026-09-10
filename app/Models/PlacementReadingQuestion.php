<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlacementReadingQuestion extends Model
{
    protected $fillable = [
        'placement_reading_passage_id',
        'question_text',
        'options',
        'correct_answer',
        'explanation',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function passage(): BelongsTo
    {
        return $this->belongsTo(PlacementReadingPassage::class, 'placement_reading_passage_id');
    }
}
