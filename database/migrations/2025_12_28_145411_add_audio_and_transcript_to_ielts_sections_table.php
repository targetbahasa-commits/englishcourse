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
        Schema::table('ielts_sections', function (Blueprint $table) {
            $table->string('audio_file')->nullable()->after('description');
            $table->text('transcript_en')->nullable()->after('audio_file');
            $table->text('transcript_id')->nullable()->after('transcript_en');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ielts_sections', function (Blueprint $table) {
            $table->dropColumn(['audio_file', 'transcript_en', 'transcript_id']);
        });
    }
};
