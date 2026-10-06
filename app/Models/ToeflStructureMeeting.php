<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToeflStructureMeeting extends Model
{
    use HasFactory;
    
    protected $fillable = ['meeting_number', 'title', 'description', 'is_locked', 'is_free_tier'];

    protected $casts = [
        'is_locked' => 'boolean',
        'is_free_tier' => 'boolean',
    ];
}
