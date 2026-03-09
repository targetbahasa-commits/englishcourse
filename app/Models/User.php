<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'role',
        'password',
        'status',
        'profile_photo',
        'profile_photo',
        'referral_code',
        'referral_points',
        'referred_by_id',

        'class_period_id',
        'teacher_id',
        'program_id',
        'learning_mode',
        'bio',
    ];

    public function classPeriod(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ClassPeriod::class);
    }

    public function teacher(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function students(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class, 'teacher_id');
    }

    public function classes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ClassPeriod::class, 'teacher_id');
    }

    public function program(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function getActiveRoleAttribute()
    {
        if ($this->role === 'admin' && request()->hasSession() && session()->has('view_as_role')) {
            return session('view_as_role');
        }
        return $this->role;
    }

    public function isAdmin()
    {
        return strtolower($this->active_role) === 'admin';
    }

    public function isTeacher()
    {
        return $this->active_role === 'teacher';
    }

    public function isStudent()
    {
        return $this->active_role === 'student';
    }

    public function isGuest()
    {
        return $this->active_role === 'guest';
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    // Query Scopes
    public function scopeByRole($query, $role)
    {
        if ($role) {
            return $query->where('role', $role);
        }
        return $query;
    }

    public function scopeByStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        return $query;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user that referred this user.
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by_id');
    }

    /**
     * Get the users referred by this user.
     */
    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by_id');
    }

    /**
     * Get the user's reward claims.
     */
    public function rewardClaims()
    {
        return $this->hasMany(UserRewardClaim::class);
    }

    /**
     * Get the social media submissions made by this user.
     */
    public function socialMediaSubmissions()
    {
        return $this->hasMany(SocialMediaSubmission::class);
    }

    /**
     * Get the free test results for this user.
     */
    public function freeTestResults()
    {
        return $this->hasMany(FreeTestResult::class);
    }

    /**
     * Get the scholarships saved by the user.
     */
    public function savedScholarships()
    {
        return $this->belongsToMany(Scholarship::class, 'saved_scholarships', 'user_id', 'scholarship_id')->withTimestamps();
    }
}
