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
            'ielts_writing_meetings',
            'ielts_speaking_topics',
            'toefl_listening_meetings',
            'toefl_structure_meetings',
            'toefl_reading_meetings'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    $table->timestamp('promo_deadline')->nullable();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promo_tables', function (Blueprint $table) {
            //
        });
    }
};
