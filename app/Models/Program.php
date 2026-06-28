<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Program extends Model
{
    public function programAccesses()
    {
        return $this->hasMany(ProgramAccess::class);
    }

    public function subprograms(): BelongsToMany
    {
        return $this->belongsToMany(Program::class, 'program_subprograms', 'package_id', 'subprogram_id');
    }
    protected $fillable = ['name', 'slug', 'period', 'description', 'color', 'icon', 'price', 'price_offline', 'price_private', 'price_private_offline', 'price_semi_private', 'price_semi_private_offline', 'is_active', 'brochure_image', 'brochure_pdf', 'active_class_period_id', 'program_type'];

    public function activeClassPeriod(): BelongsTo
    {
        return $this->belongsTo(ClassPeriod::class, 'active_class_period_id');
    }
    public function certificate(): HasOne
    {
        return $this->hasOne(FreeTestCertificate::class);
    }

    public function meetings(): HasMany
    {
        return $this->hasMany(Meeting::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function classPeriods(): HasMany
    {
        return $this->hasMany(ClassPeriod::class);
    }

    public function discounts(): HasMany
    {
        return $this->hasMany(ProgramDiscount::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function meetingScores(): HasMany
    {
        return $this->hasMany(MeetingScore::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function scopeWithoutMockTests($query)
    {
        return $query
            ->where('slug', 'not like', 'cambridge-%')
            ->where('slug', 'not like', 'toefl-itp-mock-package-%')
            ->where('slug', 'not like', '%mock%')
            ->whereRaw('LOWER(name) NOT LIKE ?', ['%mock%']);
    }

    public function getCategoryAttribute()
    {
        $name = strtolower($this->name);

        if (str_contains($name, 'ielts academic')) {
            return 'IELTS Academic';
        }
        if (str_contains($name, 'ielts general')) {
            return 'IELTS General';
        }
        if (str_contains($name, 'ielts')) {
            return 'IELTS Preparation';
        }
        if (str_contains($name, 'toefl')) {
            return 'TOEFL Preparation';
        }
        if (str_contains($name, 'pte')) {
            return 'PTE Academic';
        }
        if (str_contains($name, 'grammar')) {
            return 'Grammar for Writing';
        }
        if (str_contains($name, 'speaking')) {
            return 'Speaking';
        }

        return 'Other Programs';
    }
}

