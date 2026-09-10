<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlacementListeningQuestion extends Model
{
    protected $fillable = [
        'placement_listening_bank_id',
        'question_text',
        'options',
        'correct_answer',
        'explanation',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function bank(): BelongsTo
    {
        return $this->belongsTo(PlacementListeningBank::class, 'placement_listening_bank_id');
    }
}
