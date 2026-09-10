<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('free_test_submissions', function (Blueprint $table) {
            $table->longText('answer_text')->nullable()->after('test_type');
            $table->json('audio_paths')->nullable()->after('answer_text');
            $table->string('evaluation_status')->default('success')->after('ai_raw_json_feedback');
        });
    }

    public function down(): void
    {
        Schema::table('free_test_submissions', function (Blueprint $table) {
            $table->dropColumn(['answer_text', 'audio_paths', 'evaluation_status']);
        });
    }
};
