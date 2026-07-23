<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineTestUserAccess extends Model
{
    protected $table = 'online_test_user_access';

    protected $fillable = [
        'online_test_taker_id',
        'user_id',
        'test_slug',
        'access_granted',
        'granted_by',
    ];

    protected $casts = [
        'access_granted' => 'boolean',
    ];

    public function taker()
    {
        return $this->belongsTo(OnlineTestTaker::class, 'online_test_taker_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function grantedByUser()
    {
        return $this->belongsTo(User::class, 'granted_by');
    }
}
