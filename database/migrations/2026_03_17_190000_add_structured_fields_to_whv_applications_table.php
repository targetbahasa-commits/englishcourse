<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('whv_applications', function (Blueprint $table) {
            $table->string('status')->default('draft')->after('country');
            $table->date('opening_date')->nullable()->after('how_to_apply');
            $table->string('education_requirement')->nullable()->after('age_requirement');
            $table->string('financial_requirement')->nullable()->after('education_requirement');
            $table->text('support_letter_info')->nullable()->after('financial_requirement');
            $table->longText('job_opportunities')->nullable()->after('benefits');
            $table->longText('cost_breakdown')->nullable()->after('job_opportunities');
            $table->longText('testimonials')->nullable()->after('cost_breakdown');
            $table->longText('faqs')->nullable()->after('testimonials');
        });

        DB::table('whv_applications')
            ->select('id', 'is_active', 'application_deadline')
            ->orderBy('id')
            ->chunkById(100, function ($applications) {
                foreach ($applications as $application) {
                    $status = 'draft';

                    if ($application->is_active) {
                        $status = $application->application_deadline && $application->application_deadline < now()->toDateString()
                            ? 'closed'
                            : 'open';
                    }

                    DB::table('whv_applications')
                        ->where('id', $application->id)
                        ->update(['status' => $status]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('whv_applications', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'opening_date',
                'education_requirement',
                'financial_requirement',
                'support_letter_info',
                'job_opportunities',
                'cost_breakdown',
                'testimonials',
                'faqs',
            ]);
        });
    }
};