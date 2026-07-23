<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listening_bank_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listening_bank_id')->constrained('listening_banks')->cascadeOnDelete();
            // module_type: practice | mock_test | placement_test | homework | exam
            $table->string('module_type');
            // polymorphic module_id (e.g. class_period_id, online_test_id, etc.)
            $table->unsignedBigInteger('module_id')->nullable();
            $table->timestamps();

            $table->index(['module_type', 'module_id']);
            $table->unique(['listening_bank_id', 'module_type', 'module_id'], 'bank_module_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listening_bank_modules');
    }
};
