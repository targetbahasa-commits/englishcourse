<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'company',
        'country',
        'location',
        'job_type',
        'salary',
        'visa_sponsorship',
        'description',
        'requirements',
        'benefits',
        'english_requirement',
        'min_score',
        'deadline',
        'url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'deadline' => 'date',
    ];
}
