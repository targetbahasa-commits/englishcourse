<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PteBookmark extends Model
{
    protected $fillable = ['user_id', 'module', 'topic_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
