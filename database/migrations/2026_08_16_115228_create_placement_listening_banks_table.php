<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('placement_listening_banks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('level', 2)->nullable(); // A1-C2, target CEFR level of this clip
            $table->string('audio')->nullable(); // storage path
            $table->integer('duration')->nullable(); // seconds
            $table->longText('transcript');
            $table->string('status')->default('ready'); // draft, ready
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('placement_listening_banks');
    }
};
