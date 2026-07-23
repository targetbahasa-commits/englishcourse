<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialMediaLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'social_media_post_id',
        'type',
        'url',
        'description',
    ];

    public function post()
    {
        return $this->belongsTo(SocialMediaPost::class, 'social_media_post_id');
    }
}
