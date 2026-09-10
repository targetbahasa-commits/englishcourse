<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('placement_speaking_prompts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('prompt_text');
            $table->unsignedSmallInteger('prep_seconds')->default(30);
            $table->unsignedSmallInteger('response_seconds')->default(60);
            $table->string('status')->default('ready'); // draft, ready
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('placement_speaking_prompts');
    }
};
