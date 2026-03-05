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
        Schema::create('toefl_dictionaries', function (Blueprint $table) {
            $table->id();
            $table->string('word')->unique();
            $table->text('translation');
            $table->text('synonyms')->nullable(); // JSON or comma separated
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toefl_dictionaries');
    }
};
