<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IeltsSection extends Model
{
    protected $fillable = ['meeting_id', 'section_number', 'title', 'description', 'audio_file', 'transcript_en', 'transcript_id', 'answer_key'];

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }
}
