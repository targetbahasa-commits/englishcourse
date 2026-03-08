<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramDiscount extends Model
{
    protected $fillable = [
        'program_id', 'type', 'label', 'discount_type', 'discount_value', 'conditions', 'is_active',
    ];

    protected $casts = [
        'conditions' => 'array',
        'is_active'  => 'boolean',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Human-readable type label
     */
    public function typeLabelAttribute(): string
    {
        return match ($this->type) {
            'guest'    => 'Guest',
            'new_user' => 'New User',
            'student'  => 'Student',
            'referral' => 'Referral Teman',
            'holiday'  => 'Hari Libur Khusus',
            'region'   => 'Daerah Khusus',
            default    => ucfirst($this->type),
        };
    }

    /**
     * Formatted discount string e.g. "20%" or "Rp 200.000"
     */
    public function formattedValueAttribute(): string
    {
        if ($this->discount_type === 'percentage') {
            return $this->discount_value . '%';
        }
        return 'Rp ' . number_format($this->discount_value, 0, ',', '.');
    }
}
