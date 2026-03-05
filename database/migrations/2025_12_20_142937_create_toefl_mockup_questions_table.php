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
        Schema::create('toefl_mockup_questions', function (Blueprint $table) {
            $table->id();
            $table->enum('section', ['listening', 'structure', 'reading'])->default('listening');
            $table->string('part', 10); // A, B, C
            $table->integer('question_number');
            $table->text('question_text');
            $table->text('option_a');
            $table->text('option_b');
            $table->text('option_c');
            $table->text('option_d');
            $table->enum('correct_answer', ['A', 'B', 'C', 'D']);
            $table->string('audio_file')->nullable();
            $table->timestamps();
            
            // Index for faster queries
            $table->index(['section', 'part', 'question_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toefl_mockup_questions');
    }
};
