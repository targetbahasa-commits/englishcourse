<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whv_applications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('visa_type'); // e.g., "Working Holiday Visa", "Young Professional Visa"
            $table->string('country'); // e.g., "Australia", "Canada", "New Zealand"
            $table->longText('description');
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();
            $table->text('eligibility_criteria')->nullable();
            $table->string('age_requirement')->nullable(); // e.g., "18-35", "18-30"
            $table->string('english_requirement')->nullable(); // ielts, toefl_itp, toefl_ibt, pte, none, other
            $table->string('min_score')->nullable(); // e.g. 6.5, 500
            $table->string('processing_time')->nullable(); // e.g., "2-4 weeks"
            $table->string('application_fee')->nullable(); // e.g., "AUD 600"
            $table->string('visa_duration')->nullable(); // e.g., "12 months", "24 months"
            $table->text('how_to_apply')->nullable();
            $table->date('application_deadline')->nullable();
            $table->string('url')->nullable(); // Official government link
            $table->string('sponsored_by')->nullable(); // e.g., "Australian Department of Home Affairs"
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whv_applications');
    }
};
