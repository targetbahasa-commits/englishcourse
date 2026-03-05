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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->nullable()->after('email');
            $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete()->after('status');
            $table->foreignId('program_id')->nullable()->constrained('programs')->nullOnDelete()->after('teacher_id');
            $table->text('bio')->nullable()->after('program_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropForeign(['program_id']);
            $table->dropColumn(['phone_number', 'teacher_id', 'program_id', 'bio']);
        });
    }
};
