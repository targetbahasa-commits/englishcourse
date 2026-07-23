<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listening_banks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('level')->default('Band 6'); // e.g. Band 5, Band 6, Band 7, TOEFL 500
            $table->string('topic')->nullable();
            $table->string('accent')->default('UK'); // UK / US / AUS / NZ
            $table->string('voice')->default('Mixed'); // Male / Female / Mixed
            $table->string('background_sound')->default('none'); // none, cafe, airport, library, office, classroom, street
            $table->string('audio')->nullable(); // storage path to generated .mp3
            $table->integer('duration')->nullable(); // seconds
            $table->longText('transcript'); // raw admin input
            $table->longText('humanized_transcript')->nullable(); // LLM-rewritten version
            $table->string('status')->default('draft'); // draft, processing, ready, failed
            $table->text('error_message')->nullable(); // store failure reason
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listening_banks');
    }
};
