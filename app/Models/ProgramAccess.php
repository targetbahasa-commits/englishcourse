<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'program_id',
        'granted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
