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
        Schema::create('custom_class_speaking_ai_interview_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('class_period_id')
                ->constrained(indexName: 'cc_speaking_ai_eval_class_period_foreign')
                ->cascadeOnDelete();
            $table->unsignedSmallInteger('meeting_number');
            // 0-100 scale, CEFR-based - mirrors speaking_meeting_evaluations.
            $table->unsignedTinyInteger('overall_score')->default(0);
            $table->string('cefr_level', 2)->nullable();
            $table->unsignedTinyInteger('fluency_score')->nullable();
            $table->unsignedTinyInteger('vocabulary_score')->nullable();
            $table->unsignedTinyInteger('grammar_score')->nullable();
            $table->unsignedTinyInteger('pronunciation_score')->nullable();
            $table->json('scores_data')->nullable();
            $table->json('transcripts_data')->nullable();
            $table->text('general_feedback')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'class_period_id', 'meeting_number'], 'cc_speaking_ai_eval_user_class_meeting_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_class_speaking_ai_interview_evaluations');
    }
};
