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
        Schema::create('ielts_reading_practice_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('material_id');
            $table->integer('correct_count');
            $table->integer('total_questions');
            $table->decimal('band_score', 3, 1);
            $table->json('answers_data')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'material_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ielts_reading_practice_results');
    }
};
