<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('online_test_user_access', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('test_slug');
            $table->boolean('access_granted')->default(true); // admin can revoke/grant
            $table->foreignId('granted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'test_slug']);
            $table->index('test_slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('online_test_user_access');
    }
};
