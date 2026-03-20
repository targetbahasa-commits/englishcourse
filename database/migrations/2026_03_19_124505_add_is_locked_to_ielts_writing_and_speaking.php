<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ielts_writing_meetings', function (Blueprint $table) {
            $table->boolean('is_locked')->default(true)->after('collocations');
        });

        Schema::table('ielts_speaking_topics', function (Blueprint $table) {
            $table->boolean('is_locked')->default(false)->after('order');
        });
    }

    public function down(): void
    {
        Schema::table('ielts_writing_meetings', function (Blueprint $table) {
            $table->dropColumn('is_locked');
        });

        Schema::table('ielts_speaking_topics', function (Blueprint $table) {
            $table->dropColumn('is_locked');
        });
    }
};
