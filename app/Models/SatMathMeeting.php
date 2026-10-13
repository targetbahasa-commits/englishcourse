<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatMathMeeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_number',
        'test_number',
        'module_number',
        'context',
        'title',
        'domain',
        'subtitle',
        'description',
        'is_locked',
    ];

    protected $casts = [
        'is_locked' => 'boolean',
        'test_number' => 'integer',
        'module_number' => 'integer',
    ];

    public function questions()
    {
        return $this->hasMany(SatMathQuestion::class, 'meeting_id');
    }
}
