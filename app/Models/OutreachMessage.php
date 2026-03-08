<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutreachMessage extends Model
{
    protected $fillable = [
        'test_type',
        'target_role',
        'program_id',
        'min_score',
        'max_score',
        'message_content'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
