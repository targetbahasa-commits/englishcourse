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
        Schema::table('meeting_scores', function (Blueprint $table) {
            if (!Schema::hasColumn('meeting_scores', 'answers_data')) {
                $table->json('answers_data')->nullable()->after('score');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meeting_scores', function (Blueprint $table) {
            if (Schema::hasColumn('meeting_scores', 'answers_data')) {
                $table->dropColumn('answers_data');
            }
        });
    }
};
