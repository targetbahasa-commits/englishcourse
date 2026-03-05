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
        Schema::create('toefl_listening_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('meeting_number'); // 1-20
            $table->integer('score'); // 0-100
            $table->json('answers'); // Store user answers
            $table->timestamp('submitted_at');
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'meeting_number']);
            $table->unique(['user_id', 'meeting_number']); // One submission per meeting per user
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toefl_listening_scores');
    }
};
