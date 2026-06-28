<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('toefl_listening_meetings', function (Blueprint $table) {
            $table->boolean('transcript_enabled')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('toefl_listening_meetings', function (Blueprint $table) {
            $table->dropColumn('transcript_enabled');
        });
    }
};
