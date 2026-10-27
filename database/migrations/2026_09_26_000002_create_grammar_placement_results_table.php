<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grammar_placement_results', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->string('student_phone')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('administered_by')->nullable()->constrained('users')->nullOnDelete();
            $table->json('answers_data');
            $table->unsignedInteger('correct_count');
            $table->unsignedInteger('total_count');
            $table->decimal('percentage', 5, 2);
            $table->string('cefr_level', 2);
            $table->foreignId('recommended_program_id')->nullable()->constrained('programs')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grammar_placement_results');
    }
};
