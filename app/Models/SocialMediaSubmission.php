<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialMediaSubmission extends Model
{
    protected $fillable = [
        'user_id',
        'platform',
        'url',
        'status',
        'admin_note',
        'points_awarded',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
