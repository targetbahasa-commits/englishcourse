<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToeflMockupListeningDirectionAudio extends Model
{
    protected $table = 'toefl_mockup_listening_direction_audios';

    protected $fillable = [
        'package_number',
        'audio_part_a',
        'audio_part_b',
        'audio_part_c',
    ];
}
