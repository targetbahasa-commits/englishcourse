<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_groups', function (Blueprint $table) {
            // Null means this group applies to every game within the meeting -
            // mirrors how meeting_id = null already means "every meeting in the batch".
            $table->unsignedTinyInteger('game_index')->nullable()->default(null)->after('meeting_id');
        });
    }

    public function down(): void
    {
        Schema::table('student_groups', function (Blueprint $table) {
            $table->dropColumn('game_index');
        });
    }
};
