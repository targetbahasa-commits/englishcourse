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
        Schema::create('ielts_listening_mockups', function (Blueprint $table) {
            $table->id();
            $table->integer('test_id')->unique();
            $table->string('audio_file')->nullable();
            $table->longText('transcript_en')->nullable();
            $table->longText('transcript_id')->nullable();
            $table->text('answer_key')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ielts_listening_mockups');
    }
};
