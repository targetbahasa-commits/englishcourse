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
            $table->integer('meeting_number')->after('id');
            $table->string('title')->after('meeting_number');
            $table->boolean('is_locked')->default(false)->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('toefl_listening_meetings', function (Blueprint $table) {
            $table->dropColumn(['meeting_number', 'title', 'is_locked']);
        });
    }
};
