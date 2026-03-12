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
        Schema::table('toefl_listening_questions', function (Blueprint $table) {
            $table->dropUnique(['meeting_number', 'question_number']);
            $table->unique(['meeting_number', 'set_number', 'question_number'], 'toefl_l_q_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('toefl_listening_questions', function (Blueprint $table) {
            $table->dropUnique('toefl_l_q_unique');
            $table->unique(['meeting_number', 'question_number']);
        });
    }
};
