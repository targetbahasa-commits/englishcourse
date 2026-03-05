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
        Schema::table('toefl_reading_passages', function (Blueprint $table) {
            $table->longText('indonesian_translation')->nullable()->after('content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('toefl_reading_passages', function (Blueprint $table) {
            $table->dropColumn('indonesian_translation');
        });
    }
};
