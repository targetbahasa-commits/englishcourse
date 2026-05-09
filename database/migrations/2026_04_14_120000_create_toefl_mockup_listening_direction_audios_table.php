<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('toefl_mockup_listening_direction_audios', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('package_number');
            $table->string('audio_part_a', 500)->nullable();
            $table->string('audio_part_b', 500)->nullable();
            $table->string('audio_part_c', 500)->nullable();
            $table->timestamps();

            $table->unique('package_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('toefl_mockup_listening_direction_audios');
    }
};
