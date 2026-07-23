<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grammar_intro_topics', function (Blueprint $table) {
            $table->id();
            $table->string('label');           // e.g. "8a"
            $table->string('topic');           // e.g. "Modal"
            $table->text('grammar_rules')->nullable(); // optional: explanation rules for the AI prompt
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grammar_intro_topics');
    }
};
