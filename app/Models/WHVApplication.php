<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WHVApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'visa_type',
        'country',
        'status',
        'description',
        'requirements',
        'benefits',
        'job_opportunities',
        'cost_breakdown',
        'testimonials',
        'faqs',
        'eligibility_criteria',
        'age_requirement',
        'education_requirement',
        'financial_requirement',
        'support_letter_info',
        'english_requirement',
        'min_score',
        'processing_time',
        'application_fee',
        'visa_duration',
        'how_to_apply',
        'opening_date',
        'application_deadline',
        'url',
        'sponsored_by',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'opening_date' => 'date',
        'application_deadline' => 'date',
    ];

    protected $table = 'whv_applications';
}
