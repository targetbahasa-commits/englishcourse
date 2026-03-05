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
        Schema::create('grammar_questions', function (Blueprint $table) {
            $table->id();
            $table->integer('meeting_number');
            $table->integer('question_number');
            $table->text('question_text');
            $table->text('correct_answer');
            $table->text('example_id')->nullable();
            $table->text('example_en')->nullable();
            $table->text('vocab')->nullable(); // Store JSON/string vocab hint
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grammar_questions');
    }
};
