<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_groups', function (Blueprint $table) {
            // Nullable: null means the group applies batch-wide (all meetings),
            // matching every group created before this column existed.
            $table->foreignId('meeting_id')->nullable()->after('class_period_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('student_groups', function (Blueprint $table) {
            $table->dropConstrainedForeignId('meeting_id');
        });
    }
};
