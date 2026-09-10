<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ielts_writing_meetings', function (Blueprint $table) {
            $table->boolean('ai_grading_enabled')->default(true)->after('view_type');
        });
    }

    public function down(): void
    {
        Schema::table('ielts_writing_meetings', function (Blueprint $table) {
            $table->dropColumn('ai_grading_enabled');
        });
    }
};
