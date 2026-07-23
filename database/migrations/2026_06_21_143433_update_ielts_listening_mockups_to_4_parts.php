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
        Schema::table('ielts_listening_mockups', function (Blueprint $table) {
            $table->dropColumn(['audio_file', 'transcript_en', 'transcript_id']);

            for ($i = 1; $i <= 4; $i++) {
                $table->string('audio_file_' . $i)->nullable()->after('test_id');
                $table->longText('transcript_en_' . $i)->nullable()->after('audio_file_' . $i);
                $table->longText('transcript_id_' . $i)->nullable()->after('transcript_en_' . $i);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ielts_listening_mockups', function (Blueprint $table) {
            $table->string('audio_file')->nullable();
            $table->longText('transcript_en')->nullable();
            $table->longText('transcript_id')->nullable();

            for ($i = 1; $i <= 4; $i++) {
                $table->dropColumn([
                    'audio_file_' . $i,
                    'transcript_en_' . $i,
                    'transcript_id_' . $i,
                ]);
            }
        });
    }
};
