<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListeningQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'listening_bank_id',
        'type',
        'question_text',
        'options',
        'correct_answer',
        'explanation',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
        'order'   => 'integer',
    ];

    public function bank()
    {
        return $this->belongsTo(ListeningBank::class, 'listening_bank_id');
    }
}
