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
        Schema::table('meeting_scores', function (Blueprint $table) {
            if (!Schema::hasColumn('meeting_scores', 'teacher_score')) {
                $table->decimal('teacher_score', 5, 2)->nullable()->after('score');
            }
            if (!Schema::hasColumn('meeting_scores', 'teacher_feedback')) {
                $table->text('teacher_feedback')->nullable()->after('answers_data');
            }
            if (!Schema::hasColumn('meeting_scores', 'reviewed_by')) {
                $table->foreignId('reviewed_by')->nullable()->after('teacher_feedback')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('meeting_scores', 'reviewed_at')) {
                $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meeting_scores', function (Blueprint $table) {
            if (Schema::hasColumn('meeting_scores', 'reviewed_by')) {
                $table->dropConstrainedForeignId('reviewed_by');
            }
            $table->dropColumn(array_filter([
                Schema::hasColumn('meeting_scores', 'teacher_score') ? 'teacher_score' : null,
                Schema::hasColumn('meeting_scores', 'teacher_feedback') ? 'teacher_feedback' : null,
                Schema::hasColumn('meeting_scores', 'reviewed_at') ? 'reviewed_at' : null,
            ]));
        });
    }
};
