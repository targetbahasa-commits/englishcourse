<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('placement_writing_prompts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('prompt_text');
            $table->unsignedInteger('min_words')->default(100);
            $table->string('status')->default('ready'); // draft, ready
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('placement_writing_prompts');
    }
};
