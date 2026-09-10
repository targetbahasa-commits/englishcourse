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
        Schema::create('speaking_ai_interview_overrides', function (Blueprint $table) {
            $table->id();
            $table->string('level');
            $table->unsignedInteger('meeting_number');
            $table->json('questions');
            $table->timestamps();

            $table->unique(['level', 'meeting_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speaking_ai_interview_overrides');
    }
};
