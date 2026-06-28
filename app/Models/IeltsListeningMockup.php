<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IeltsListeningMockup extends Model
{
    protected $fillable = [
        'test_id',
        'answer_key',
        'audio_file_1', 'audio_file_2', 'audio_file_3', 'audio_file_4',
        'transcript_en_1', 'transcript_en_2', 'transcript_en_3', 'transcript_en_4',
        'transcript_id_1', 'transcript_id_2', 'transcript_id_3', 'transcript_id_4',
    ];
}
