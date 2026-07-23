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
        Schema::create('online_test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('test_slug');
            $table->string('test_label');
            $table->string('status')->default('in_progress');
            $table->unsignedSmallInteger('duration_minutes')->default(0);
            $table->unsignedInteger('time_spent_seconds')->nullable();
            $table->decimal('score', 5, 2)->nullable();
            $table->json('answers_data')->nullable();
            $table->json('evaluation_data')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'test_slug']);
            $table->index(['test_slug', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_test_results');
    }
};
