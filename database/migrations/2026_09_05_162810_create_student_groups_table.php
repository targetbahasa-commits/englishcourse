<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_period_id')->constrained()->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_groups');
    }
};
