<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Added this line

class ReferralReward extends Model
{
    use HasFactory; // Added this line

    protected $fillable = [
        'name',
        'description',
        'points_required',
        'is_active',
        'image',
    ];

    public function claims()
    {
        return $this->hasMany(UserRewardClaim::class, 'reward_id');
    }
}
