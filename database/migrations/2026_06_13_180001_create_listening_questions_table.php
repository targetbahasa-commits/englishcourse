<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listening_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listening_bank_id')->constrained('listening_banks')->cascadeOnDelete();
            $table->string('type')->default('multiple_choice'); // multiple_choice / true_false_not_given
            $table->text('question_text');
            $table->json('options')->nullable(); // ["A) ...", "B) ...", "C) ...", "D) ..."]
            $table->string('correct_answer'); // "B" or "True" / "False" / "Not Given"
            $table->text('explanation')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listening_questions');
    }
};
