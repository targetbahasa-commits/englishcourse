<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('class_meetings', function (Blueprint $table) {
            // Make meeting_date nullable so ClassMeetings can be auto-generated without a scheduled date
            $table->date('meeting_date')->nullable()->change();

            // Add meeting_id FK if not already present
            if (!Schema::hasColumn('class_meetings', 'meeting_id')) {
                $table->foreignId('meeting_id')->nullable()->constrained()->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('class_meetings', function (Blueprint $table) {
            $table->date('meeting_date')->nullable(false)->change();

            if (Schema::hasColumn('class_meetings', 'meeting_id')) {
                $table->dropForeign(['meeting_id']);
                $table->dropColumn('meeting_id');
            }
        });
    }
};
