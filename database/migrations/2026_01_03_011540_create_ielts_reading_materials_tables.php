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
        // Create passages table
        Schema::create('ielts_reading_passages', function (Blueprint $table) {
            $table->id();
            $table->integer('material_id')->index(); // Reading material number (1, 2, 3, etc.)
            $table->string('title');
            $table->text('content');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Create questions table
        Schema::create('ielts_reading_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('passage_id')->constrained('ielts_reading_passages')->onDelete('cascade');
            $table->integer('question_number');
            $table->text('question_text');
            $table->enum('type', ['radio', 'checkbox'])->default('radio');
            $table->json('options'); // {"A": "text", "B": "text", ...}
            $table->json('correct_answer'); // ["A"] or ["B", "E"] for checkbox
            $table->text('explanation')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ielts_reading_questions');
        Schema::dropIfExists('ielts_reading_passages');
    }
};
