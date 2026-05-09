<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('toefl_mockup_questions', function (Blueprint $table) {
            $table->longText('transcript_en')->nullable()->after('audio_file');
            $table->longText('transcript_id')->nullable()->after('transcript_en');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('toefl_mockup_questions', function (Blueprint $table) {
            $table->dropColumn(['transcript_en', 'transcript_id']);
        });
    }
};
