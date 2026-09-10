<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('placement_listening_questions', function (Blueprint $table) {
            $table->id();
            // Explicit short FK constraint name: the auto-generated
            // "placement_listening_questions_placement_listening_bank_id_foreign"
            // exceeds MySQL's 64-character identifier limit (SQLite has no such limit,
            // so this only surfaces when migrating against MySQL).
            $table->foreignId('placement_listening_bank_id')->constrained('placement_listening_banks', 'id', 'plq_bank_id_foreign')->cascadeOnDelete();
            $table->text('question_text');
            $table->json('options');
            $table->string('correct_answer');
            $table->text('explanation')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('placement_listening_questions');
    }
};
