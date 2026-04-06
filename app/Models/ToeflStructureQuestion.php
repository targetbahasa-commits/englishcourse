<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToeflStructureQuestion extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'section_id',
        'question_number',
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'explanation',
    ];

    public function meeting()
    {
        return $this->belongsTo(ToeflStructureMeeting::class, 'section_id');
    }
}
