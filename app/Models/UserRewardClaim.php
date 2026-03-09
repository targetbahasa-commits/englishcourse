<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRewardClaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reward_id',
        'status',
        'shipping_address',
        'admin_notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reward()
    {
        return $this->belongsTo(ReferralReward::class, 'reward_id');
    }
}
