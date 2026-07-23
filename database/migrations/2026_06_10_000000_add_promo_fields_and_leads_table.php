<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update writing questions table
        Schema::table('ielts_writing_questions', function (Blueprint $table) {
            $table->boolean('is_free_tier')->default(false);
            $table->string('test_type')->nullable(); // 'writing_t1', 'writing_t2'
            $table->json('graph_data_json')->nullable();
            $table->text('system_prompt_override')->nullable();
        });

        // Update speaking topics table
        Schema::table('ielts_speaking_topics', function (Blueprint $table) {
            $table->boolean('is_free_tier')->default(false);
            $table->string('test_type')->nullable(); // 'speaking'
            $table->text('system_prompt_override')->nullable();
        });

        // Create free_test_submissions (Leads Tracker)
        Schema::create('free_test_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('whatsapp_number');
            $table->string('test_type'); // writing_t1, writing_t2, speaking
            $table->decimal('estimated_band_score', 3, 1)->nullable();
            $table->json('ai_raw_json_feedback')->nullable();
            $table->string('follow_up_status')->default('pending'); // pending, contacted, enrolled
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('free_test_submissions');

        Schema::table('ielts_writing_questions', function (Blueprint $table) {
            $table->dropColumn(['is_free_tier', 'test_type', 'graph_data_json', 'system_prompt_override']);
        });

        Schema::table('ielts_speaking_topics', function (Blueprint $table) {
            $table->dropColumn(['is_free_tier', 'test_type', 'system_prompt_override']);
        });
    }
};
