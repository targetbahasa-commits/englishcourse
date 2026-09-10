<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('placement_test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('status')->default('in_progress'); // in_progress, completed, failed
            $table->decimal('reading_score', 5, 2)->nullable();
            $table->decimal('listening_score', 5, 2)->nullable();
            $table->decimal('writing_score', 5, 2)->nullable();
            $table->decimal('speaking_score', 5, 2)->nullable();
            $table->decimal('overall_percentage', 5, 2)->nullable();
            $table->string('cefr_level', 2)->nullable(); // A1-C2
            $table->json('answers_data')->nullable(); // raw MCQ answers + essay text + audio path, per skill
            $table->json('evaluation_data')->nullable(); // full AI grading payloads: transcript, sub-scores, provider/model used
            $table->json('recommended_program_ids')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('placement_test_results');
    }
};
