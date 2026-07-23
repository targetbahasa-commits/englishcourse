<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ielts_writing_questions', function (Blueprint $table) {
            $table->dropColumn(['is_free_tier', 'test_type', 'graph_data_json', 'system_prompt_override']);
        });

        Schema::table('ielts_writing_meetings', function (Blueprint $table) {
            $table->boolean('is_free_tier')->default(false);
            $table->string('test_type')->nullable(); // 'writing_t1', 'writing_t2'
            $table->json('graph_data_json')->nullable();
            $table->text('system_prompt_override')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('ielts_writing_meetings', function (Blueprint $table) {
            $table->dropColumn(['is_free_tier', 'test_type', 'graph_data_json', 'system_prompt_override']);
        });

        Schema::table('ielts_writing_questions', function (Blueprint $table) {
            $table->boolean('is_free_tier')->default(false);
            $table->string('test_type')->nullable(); // 'writing_t1', 'writing_t2'
            $table->json('graph_data_json')->nullable();
            $table->text('system_prompt_override')->nullable();
        });
    }
};
