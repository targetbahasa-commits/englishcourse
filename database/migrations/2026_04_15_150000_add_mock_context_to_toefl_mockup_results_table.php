<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('toefl_mockup_results', function (Blueprint $table) {
            $table->string('exam_type')->default('toefl_itp')->after('email');
            $table->string('test_family')->default('mock_test')->after('exam_type');
            $table->string('source_context')->default('assignment_mock_test')->after('test_family');
            $table->string('submitted_by_role')->nullable()->after('source_context');
            $table->json('raw_scores')->nullable()->after('total_score');
            $table->json('scaled_scores')->nullable()->after('raw_scores');
            $table->json('result_payload')->nullable()->after('scaled_scores');
            $table->timestamp('completed_at')->nullable()->after('answers_data');
        });
    }

    public function down(): void
    {
        Schema::table('toefl_mockup_results', function (Blueprint $table) {
            $table->dropColumn([
                'exam_type',
                'test_family',
                'source_context',
                'submitted_by_role',
                'raw_scores',
                'scaled_scores',
                'result_payload',
                'completed_at',
            ]);
        });
    }
};
