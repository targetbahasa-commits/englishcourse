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
        Schema::create('grammar_vocabularies', function (Blueprint $table) {
            $table->id();
            $table->integer('meeting_number');
            $table->string('section')->default('global'); // 'global', 'paragraph', etc.
            $table->string('word');
            $table->string('translation');
            $table->string('pos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grammar_vocabularies');
    }
};
