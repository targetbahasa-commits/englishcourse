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
        Schema::create('camp_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('camp_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('restrict');
            $table->tinyInteger('tingkat_kebersihan')->unsigned()->comment('Scale 1-5');
            $table->tinyInteger('kualitas_fasilitas')->unsigned()->comment('Scale 1-5');
            $table->text('kritik_saran')->nullable();
            $table->date('tanggal_review');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camp_reviews');
    }
};
