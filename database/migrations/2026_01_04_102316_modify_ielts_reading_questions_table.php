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
        Schema::table('ielts_reading_questions', function (Blueprint $table) {
            // Change type from enum to string to allow custom types
            $table->string('type')->default('radio')->change();
            // Add a flexible data column for extras (box_title, summary_text, etc)
            $table->json('data')->nullable();
            
            // Make options/correct_answer nullable as some types might not use them
            $table->json('options')->nullable()->change();
            $table->json('correct_answer')->nullable()->change();
            $table->integer('question_number')->default(0)->change();
            $table->text('question_text')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ielts_reading_questions', function (Blueprint $table) {
            $table->dropColumn('data');
        });
    }
};
