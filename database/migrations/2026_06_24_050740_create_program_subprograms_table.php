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
        Schema::create('program_subprograms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('programs')->cascadeOnDelete();
            $table->foreignId('subprogram_id')->constrained('programs')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['package_id', 'subprogram_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_subprograms');
    }
};
