<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('pic_name')->nullable();
            $table->string('pic_phone')->nullable();
            $table->string('pic_email')->nullable();
            $table->string('industry')->nullable();
            $table->enum('status', ['prospecting', 'negotiating', 'active', 'inactive'])->default('prospecting');
            $table->string('registration_code')->unique();
            $table->enum('discount_type', ['percentage', 'fixed'])->nullable();
            $table->integer('discount_value')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
