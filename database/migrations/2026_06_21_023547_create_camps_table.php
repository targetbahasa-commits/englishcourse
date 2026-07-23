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
        Schema::create('camps', function (Blueprint $table) {
            $table->id();
            $table->string('nama_camp');
            $table->text('alamat')->nullable();
            $table->enum('gender_khusus', ['Putra', 'Putri']);
            $table->foreignId('teacher_id')->constrained('users')->onDelete('restrict');
            $table->integer('jumlah_toilet')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camps');
    }
};
