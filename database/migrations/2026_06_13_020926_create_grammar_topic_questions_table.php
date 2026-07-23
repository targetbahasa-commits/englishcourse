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
        Schema::create('grammar_topic_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grammar_topic_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['sentence', 'paragraph']);
            $table->text('question_id'); // ID Text
            $table->text('answer_en'); // EN Answer
            $table->json('vocab_helper')->nullable();
            $table->json('example')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grammar_topic_questions');
    }
};
