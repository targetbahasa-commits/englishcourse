<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Partner extends Model
{
    protected $fillable = [
        'name',
        'pic_name',
        'pic_phone',
        'pic_email',
        'industry',
        'program_id',
        'total_meetings',
        'program_start_date',
        'program_end_date',
        'status',
        'registration_code',
        'discount_type',
        'discount_value',
        'certificate_delivery_mode',
        'is_active',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'program_start_date' => 'date',
        'program_end_date' => 'date',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(User::class, 'partner_id');
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * "8 Sep 2026 - 3 Nov 2026" style range for the Partner show page,
     * falling back gracefully if only one end of the range is set.
     */
    public function programPeriodLabelAttribute(): ?string
    {
        if (!$this->program_start_date && !$this->program_end_date) {
            return null;
        }

        if ($this->program_start_date && $this->program_end_date) {
            return $this->program_start_date->format('d M Y') . ' - ' . $this->program_end_date->format('d M Y');
        }

        return $this->program_start_date
            ? 'Mulai ' . $this->program_start_date->format('d M Y')
            : 'Sampai ' . $this->program_end_date->format('d M Y');
    }

    /**
     * Same clamping rules as DiscountPolicy::calculateAmount() for
     * ProgramDiscount, applied to this partner's own flat corporate rate
     * instead of a per-program rule.
     */
    public function discountAmountFor(int $baseAmount): int
    {
        if ($baseAmount <= 0 || !$this->discount_type || $this->discount_value === null) {
            return 0;
        }

        if ($this->discount_type === 'percentage') {
            $percentage = max(0, min(100, (int) $this->discount_value));
            $amount = (int) floor(($baseAmount * $percentage) / 100);
            return max(0, min($baseAmount, $amount));
        }

        $amount = max(0, (int) $this->discount_value);
        return min($baseAmount, $amount);
    }

    public function formattedDiscountAttribute(): ?string
    {
        if (!$this->discount_type || $this->discount_value === null) {
            return null;
        }

        return $this->discount_type === 'percentage'
            ? $this->discount_value . '%'
            : 'Rp ' . number_format($this->discount_value, 0, ',', '.');
    }

    public function certificateDeliveryModeLabelAttribute(): string
    {
        return match ($this->certificate_delivery_mode) {
            'score_sheet' => 'Lembar Nilai (Sheet)',
            default => 'Certificate',
        };
    }
}
