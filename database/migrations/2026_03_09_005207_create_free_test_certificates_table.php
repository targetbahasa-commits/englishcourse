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
        Schema::create('free_test_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('test_type')->unique(); 
            $table->string('background_image')->nullable();
            $table->text('description')->nullable();
            $table->string('text_color')->default('#000000');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('free_test_certificates');
    }
};
