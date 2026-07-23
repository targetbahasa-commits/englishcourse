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
        Schema::table('toefl_listening_meetings', function (Blueprint $table) {
            $table->boolean('is_free_tier')->default(false)->after('title');
        });

        Schema::table('toefl_structure_meetings', function (Blueprint $table) {
            $table->boolean('is_free_tier')->default(false)->after('title');
        });

        Schema::table('toefl_reading_meetings', function (Blueprint $table) {
            $table->boolean('is_free_tier')->default(false)->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('toefl_listening_meetings', function (Blueprint $table) {
            $table->dropColumn('is_free_tier');
        });

        Schema::table('toefl_structure_meetings', function (Blueprint $table) {
            $table->dropColumn('is_free_tier');
        });

        Schema::table('toefl_reading_meetings', function (Blueprint $table) {
            $table->dropColumn('is_free_tier');
        });
    }
};
