<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('placement_reading_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('placement_reading_passage_id')->constrained('placement_reading_passages')->cascadeOnDelete();
            $table->text('question_text');
            $table->json('options'); // ["A) ...", "B) ...", "C) ...", "D) ..."]
            $table->string('correct_answer'); // "A" / "B" / "C" / "D"
            $table->text('explanation')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('placement_reading_questions');
    }
};
