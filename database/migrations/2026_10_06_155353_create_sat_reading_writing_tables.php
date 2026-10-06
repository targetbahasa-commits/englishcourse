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
        // 1. Meetings Table
        Schema::create('sat_reading_writing_meetings', function (Blueprint $table) {
            $table->id();
            $table->integer('meeting_number')->unique();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_locked')->default(false);
            $table->timestamps();
        });

        // 2. Questions Table
        Schema::create('sat_reading_writing_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained('sat_reading_writing_meetings')->onDelete('cascade');
            $table->integer('question_number');
            $table->string('category')->nullable(); // e.g. Vocabulary, Purpose, Conventions of Standard English, Transitions, Rhetorical Synthesis
            $table->longText('passage')->nullable(); // reading text / stimuli / notes
            $table->text('question_prompt')->nullable(); // Which choice completes the text...?
            $table->text('option_a')->nullable();
            $table->text('option_b')->nullable();
            $table->text('option_c')->nullable();
            $table->text('option_d')->nullable();
            $table->string('correct_answer', 10); // A, B, C, D
            $table->longText('explanation')->nullable(); // Explanation from Princeton Review
            $table->timestamps();

            $table->index(['meeting_id', 'question_number']);
        });

        // 3. User Scores Table
        Schema::create('sat_reading_writing_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('meeting_number');
            $table->decimal('score', 8, 2);
            $table->integer('correct_count');
            $table->integer('total_questions');
            $table->json('answers')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'meeting_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sat_reading_writing_scores');
        Schema::dropIfExists('sat_reading_writing_questions');
        Schema::dropIfExists('sat_reading_writing_meetings');
    }
};
