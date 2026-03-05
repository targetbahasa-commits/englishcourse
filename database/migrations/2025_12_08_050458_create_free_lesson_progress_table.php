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
        Schema::create('free_lesson_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('lesson_slug');
            $table->integer('score');
            $table->integer('total_questions')->nullable();
            $table->timestamp('completed_at')->useCurrent();
            $table->timestamps();

            // Unique constraint to ensure one score per lesson per user (we update existing)
            $table->unique(['user_id', 'lesson_slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('free_lesson_progress');
    }
};
