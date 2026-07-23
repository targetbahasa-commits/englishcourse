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
        $tables = [
            'meeting_scores',
            'toefl_listening_scores',
            'toefl_reading_scores',
            'toefl_mockup_results',
            'ielts_listening_mockups'
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->boolean('is_reported')->default(true)->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'meeting_scores',
            'toefl_listening_scores',
            'toefl_reading_scores',
            'toefl_mockup_results',
            'ielts_listening_mockups'
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('is_reported');
            });
        }
    }
};
