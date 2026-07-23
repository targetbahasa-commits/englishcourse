<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('online_test_batches', function (Blueprint $table) {
            $table->id();
            $table->string('test_slug');
            $table->string('label');             // e.g. "Batch Mei 2026"
            $table->string('code');              // e.g. "TB-A1B2C3"
            $table->boolean('is_active')->default(false);
            $table->boolean('code_access_enabled')->default(true); // toggle on/off
            $table->timestamps();

            $table->index('test_slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('online_test_batches');
    }
};
