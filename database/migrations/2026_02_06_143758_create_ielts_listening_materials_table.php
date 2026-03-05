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
        Schema::create('ielts_listening_materials', function (Blueprint $table) {
            $table->id();
            $table->integer('material_type_id')->unique();
            $table->string('title')->nullable();
            $table->string('audio_file')->nullable();
            $table->text('transcript_en')->nullable();
            $table->text('transcript_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ielts_listening_materials');
    }
};
