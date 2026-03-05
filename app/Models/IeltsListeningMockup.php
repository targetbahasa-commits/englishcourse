<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IeltsListeningMockup extends Model
{
    protected $fillable = [
        'test_id',
        'audio_file',
        'transcript_en',
        'transcript_id',
        'answer_key',
    ];
}
