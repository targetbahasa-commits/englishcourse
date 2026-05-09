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
        Schema::create('toefl_mockup_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->integer('package_number')->default(1);
            
            // Raw Correct Counts
            $table->integer('listening_correct')->default(0);
            $table->integer('structure_correct')->default(0);
            $table->integer('reading_correct')->default(0);
            
            // Converted Scaled Scores
            $table->integer('listening_score')->default(0);
            $table->integer('structure_score')->default(0);
            $table->integer('reading_score')->default(0);
            
            // Final TOEFL
            $table->integer('total_score')->default(0);
            
            // Keep JSON of answers for audit / review if needed
            $table->json('answers_data')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toefl_mockup_results');
    }
};
