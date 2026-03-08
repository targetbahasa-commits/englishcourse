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
        Schema::table('class_meetings', function (Blueprint $table) {
            $table->foreignId('meeting_id')->nullable()->constrained('meetings')->nullOnDelete()->after('class_period_id');
            $table->time('start_time')->nullable()->after('meeting_number');
            $table->time('end_time')->nullable()->after('start_time');
            $table->string('meeting_link')->nullable()->after('topic');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('class_meetings', function (Blueprint $table) {
            $table->dropForeign(['meeting_id']);
            $table->dropColumn(['meeting_id', 'start_time', 'end_time', 'meeting_link']);
        });
    }
};
