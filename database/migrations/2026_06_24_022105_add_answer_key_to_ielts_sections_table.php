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
            $table->text('answer_key')->nullable()->after('transcript_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ielts_sections', function (Blueprint $table) {
            $table->dropColumn('answer_key');
        });
    }
};
