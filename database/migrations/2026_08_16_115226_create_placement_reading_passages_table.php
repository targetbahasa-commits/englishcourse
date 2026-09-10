<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('placement_reading_passages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('passage_text');
            $table->string('level', 2)->nullable(); // A1-C2, target CEFR level of this passage
            $table->string('status')->default('ready'); // draft, ready
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('placement_reading_passages');
    }
};
