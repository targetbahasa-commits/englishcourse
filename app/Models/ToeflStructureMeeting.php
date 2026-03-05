<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToeflStructureMeeting extends Model
{
    use HasFactory;
    
    protected $fillable = ['meeting_number', 'title', 'is_locked'];
}
