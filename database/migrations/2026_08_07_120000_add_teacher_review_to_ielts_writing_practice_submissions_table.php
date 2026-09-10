<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ielts_writing_practice_submissions', function (Blueprint $table) {
            $table->text('teacher_feedback')->nullable()->after('error_message');
            $table->decimal('teacher_score', 3, 1)->nullable()->after('teacher_feedback');
            $table->foreignId('reviewed_by')->nullable()->after('teacher_score')->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
        });
    }

    public function down(): void
    {
        Schema::table('ielts_writing_practice_submissions', function (Blueprint $table) {
            $table->dropForeign(['reviewed_by']);
            $table->dropColumn(['teacher_feedback', 'teacher_score', 'reviewed_by', 'reviewed_at']);
        });
    }
};
