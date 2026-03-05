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
        Schema::create('toefl_reading_passages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained('toefl_reading_meetings')->onDelete('cascade');
            $table->integer('passage_number');
            $table->longText('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toefl_reading_passages');
    }
};
