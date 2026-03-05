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
        Schema::create('toefl_listening_questions', function (Blueprint $table) {
            $table->id();
            $table->integer('meeting_number'); // 1-20
            $table->integer('question_number'); // 1-2 per meeting
            $table->string('audio_file')->nullable(); // Path to audio file
            $table->text('question_text');
            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d');
            $table->char('correct_answer', 1); // A, B, C, or D
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index('meeting_number');
            $table->unique(['meeting_number', 'question_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toefl_listening_questions');
    }
};
