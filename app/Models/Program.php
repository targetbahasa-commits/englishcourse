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
    protected $fillable = ['name', 'slug', 'period', 'description', 'color', 'icon', 'price', 'price_offline', 'price_private', 'price_private_offline', 'price_semi_private', 'price_semi_private_offline', 'is_active', 'brochure_image', 'brochure_pdf', 'active_class_period_id', 'active_class_meeting_id', 'current_meeting_number', 'program_type', 'min_cefr_level', 'max_cefr_level', 'delivery_mode', 'linked_program_id', 'price_discount_type', 'price_discount_value', 'price_offline_discount_type', 'price_offline_discount_value', 'price_semi_private_discount_type', 'price_semi_private_discount_value', 'price_semi_private_offline_discount_type', 'price_semi_private_offline_discount_value', 'price_private_discount_type', 'price_private_discount_value', 'price_private_offline_discount_type', 'price_private_offline_discount_value'];

    /**
     * The flat/percentage amount knocked off $this->{$field} by its own inline
     * discount fields (e.g. field='price_private' reads
     * price_private_discount_type/price_private_discount_value) - separate
     * from the audience-based ProgramDiscount promo rules (see discounts()).
     * Returns 0 if no discount is configured or the base price is 0.
     */
    public function priceDiscountAmount(string $field): int
    {
        $base = (int) ($this->{$field} ?? 0);
        if ($base <= 0) {
            return 0;
        }

        $type = $this->{$field . '_discount_type'} ?? null;
        $value = $this->{$field . '_discount_value'} ?? null;
        if (!$type || $value === null || (int) $value <= 0) {
            return 0;
        }

        if ($type === 'percentage') {
            $percentage = max(0, min(100, (int) $value));
            return (int) floor($base * $percentage / 100);
        }

        return min($base, (int) $value);
    }

    /**
     * $this->{$field} after applying its own inline discount (never below 0).
     */
    public function discountedPrice(string $field): int
    {
        return max(0, (int) ($this->{$field} ?? 0) - $this->priceDiscountAmount($field));
    }

    public function onlineSibling(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'linked_program_id');
    }

    public function offlineSibling(): HasOne
    {
        return $this->hasOne(Program::class, 'linked_program_id');
    }

    public function activeClassPeriod(): BelongsTo
    {
        return $this->belongsTo(ClassPeriod::class, 'active_class_period_id');
    }

    public function activeClassMeeting(): BelongsTo
    {
        return $this->belongsTo(ClassMeeting::class, 'active_class_meeting_id');
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

    public function getCategoryAttribute(): string
    {
        $name = strtolower($this->name);

        if (str_contains($name, 'cambridge')) {
            return 'Cambridge Practice Tests';
        }
        if (str_contains($name, 'toefl itp mock')) {
            return 'TOEFL Mock Packages';
        }
        if (str_contains($name, 'ielts')) {
            return 'IELTS Courses & Skills';
        }
        if (str_contains($name, 'toefl') || str_contains($name, 'pte')) {
            return 'TOEFL & PTE Courses';
        }
        if (str_contains($name, 'grammar') || str_contains($name, 'speaking')) {
            return 'Grammar & Speaking Courses';
        }

        return 'Program Lainnya';
    }
}

