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
        Schema::table('toefl_reading_questions', function (Blueprint $table) {
            $table->json('keywords')->nullable()->after('correct_answer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('toefl_reading_questions', function (Blueprint $table) {
            $table->dropColumn('keywords');
        });
    }
};
