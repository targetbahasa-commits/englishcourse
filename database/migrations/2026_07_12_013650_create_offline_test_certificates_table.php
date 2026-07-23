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
        Schema::create('offline_test_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('test_type')->unique(); // e.g. toefl_itp, ielts_academic
            $table->boolean('is_active')->default(true);
            $table->string('text_color')->default('#0f172a');
            $table->string('background_image')->nullable();
            $table->json('template_config')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offline_test_certificates');
    }
};
