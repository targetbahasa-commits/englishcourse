<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeTestResult extends Model
{
    protected $fillable = [
        'user_id',
        'test_type',
        'score',
        'evaluation_data'
    ];

    protected $casts = [
        'evaluation_data' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
