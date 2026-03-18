<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    protected $fillable = ['name', 'slug', 'period', 'description', 'color', 'icon', 'price', 'is_active', 'brochure_image', 'brochure_pdf'];

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
}

