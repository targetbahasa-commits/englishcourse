<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'target_role',
        'is_active',
    ];

    public function readers()
    {
        return $this->belongsToMany(User::class, 'announcement_user_reads')
            ->withPivot('read_at')
            ->withTimestamps();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        $role = strtolower((string) $user->active_role);

        if ($role === 'teacher') {
            return $query->whereIn('target_role', ['all', 'teacher']);
        }

        if ($role === 'student') {
            return $query->whereIn('target_role', ['all', 'student']);
        }

        return $query->where('target_role', 'all');
    }
}
