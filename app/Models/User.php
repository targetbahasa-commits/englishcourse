<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;

class User extends Authenticatable
{
    public function programAccesses()
    {
        return $this->hasMany(\App\Models\ProgramAccess::class);
    }
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected static ?bool $announcementReadsTableExists = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'google_id',
        'phone_number',
        'role',
        'password',
        'status',
        'profile_photo',
        'profile_photo',
        'referral_code',
        'referral_points',
        'referred_by_id',
        'partner_id',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_content',
        'utm_term',
        'acquisition_referrer',
        'acquisition_landing_path',
        'acquisition_source_page',
        'acquisition_variant',
        'acquisition_last_cta',

        'class_period_id',
        'teacher_id',
        'program_id',
        'learning_mode',
        'camp_id',
        'camp_room_id',
        'bio',
        'last_seen_at',
        'self_study_grammar_mode_override',
    ];

    /**
     * @deprecated Use enrollments() instead to get class periods per program.
     */
    public function classPeriod(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ClassPeriod::class);
    }

    public function enrollments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Enrollment::class);
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

    public function getEnrolledProgramIdsAttribute(): array
    {
        $ids = [];
        if ($this->program_id) {
            $ids[] = (int) $this->program_id;
        }
        if ($this->relationLoaded('enrollments')) {
            foreach ($this->enrollments as $enrollment) {
                if ($enrollment->program_id && in_array($enrollment->status, ['active', 'completed'])) {
                    $ids[] = (int) $enrollment->program_id;
                }
            }
        } else {
            $enrollmentIds = \App\Models\Enrollment::where('user_id', $this->id)
                ->whereIn('status', ['active', 'completed'])
                ->pluck('program_id')
                ->map(fn($id) => (int) $id)
                ->toArray();
            $ids = array_merge($ids, $enrollmentIds);
        }
        return array_values(array_unique(array_filter($ids)));
    }

    public function camp(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Camp::class, 'camp_id');
    }

    public function campRoom(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CampRoom::class, 'camp_room_id');
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
        return in_array($this->active_role, ['guest', 'guest_quick']);
    }

    public function isTestTaker()
    {
        return $this->active_role === 'test-taker';
    }

    public function isIntern()
    {
        return $this->active_role === 'intern';
    }

    public function internPermissions()
    {
        return $this->hasMany(InternPermission::class);
    }

    public function hasInternPermission(string $permission)
    {
        return $this->internPermissions()->where('permission', $permission)->exists();
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
            'last_seen_at' => 'datetime',
            'email_verification_code_expires_at' => 'datetime',
        ];
    }

    /**
     * Get the user that referred this user.
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by_id');
    }

    public function partner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function announcementReads()
    {
        return $this->belongsToMany(Announcement::class, 'announcement_user_reads')
            ->withPivot('read_at')
            ->withTimestamps();
    }

    public function unreadAnnouncements(): Builder
    {
        if (!$this->hasAnnouncementReadsTable()) {
            return Announcement::query()
                ->active()
                ->visibleTo($this)
                ->select('announcements.*');
        }

        return Announcement::query()
            ->active()
            ->visibleTo($this)
            ->leftJoin('announcement_user_reads as announcement_reads', function ($join) {
                $join->on('announcements.id', '=', 'announcement_reads.announcement_id')
                    ->where('announcement_reads.user_id', '=', $this->id);
            })
            ->where(function ($query) {
                $query->whereNull('announcement_reads.read_at')
                    ->orWhereColumn('announcement_reads.read_at', '<', 'announcements.updated_at');
            })
            ->select('announcements.*');
    }

    public function hasUnreadChat(): bool
    {
        $hasUnreadDirect = \App\Models\DirectMessage::where('receiver_id', $this->id)
            ->whereNull('read_at')->exists();

        if ($this->role === 'admin') {
            $hasUnreadAdmin = \App\Models\DirectMessage::whereNull('receiver_id')
                ->whereNull('read_at')->exists();

            return $hasUnreadDirect || $hasUnreadAdmin;
        }

        return $hasUnreadDirect;
    }

    public function hasUnreadNotificationBadge(): bool
    {
        return $this->unreadNotifications()->exists();
    }

    public function hasUnreadAnnouncements(): bool
    {
        if ($this->isAdmin()) {
            return false;
        }

        return $this->unreadAnnouncements()->exists();
    }

    protected function hasAnnouncementReadsTable(): bool
    {
        return self::$announcementReadsTableExists ??= Schema::hasTable('announcement_user_reads');
    }

    public function hasUnreadInbox(): bool
    {
        return $this->hasUnreadNotificationBadge() || $this->hasUnreadChat();
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

    public function onlineTestResults()
    {
        return $this->hasMany(OnlineTestResult::class);
    }

    /**
     * Payments owned by this user.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Payments created/recorded by this user (typically admin/staff).
     */
    public function createdPayments()
    {
        return $this->hasMany(Payment::class, 'created_by');
    }

    /**
     * Get the scholarships saved by the user.
     */
    public function savedScholarships()
    {
        return $this->belongsToMany(Scholarship::class, 'saved_scholarships', 'user_id', 'scholarship_id')->withTimestamps();
    }

    /**
     * Get the scholarships targeted by the user.
     */
    public function targetScholarships()
    {
        return $this->belongsToMany(Scholarship::class, 'target_scholarships', 'user_id', 'scholarship_id')->withTimestamps();
    }
}
