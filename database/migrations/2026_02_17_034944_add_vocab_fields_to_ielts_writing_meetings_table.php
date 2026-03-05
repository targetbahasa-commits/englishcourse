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
        Schema::table('ielts_writing_meetings', function (Blueprint $table) {
            $table->json('idioms')->nullable();
            $table->json('collocations')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ielts_writing_meetings', function (Blueprint $table) {
            $table->dropColumn(['idioms', 'collocations']);
        });
    }
};
