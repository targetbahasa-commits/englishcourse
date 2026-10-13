<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Introduces an explicit (test_number, module_number) pairing so a "full
     * Digital SAT test" is defined by data instead of being hardcoded to
     * meeting_number 1/2 in the controllers. A meeting with test_number=null
     * is a standalone topical drill (single module, raw % score, not part of
     * a full-length adaptive test) rather than a fabricated "full test".
     */
    public function up(): void
    {
        foreach (['sat_reading_writing_meetings', 'sat_math_meetings'] as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'test_number')) {
                Schema::table($table, function (Blueprint $blueprint) {
                    $blueprint->unsignedInteger('test_number')->nullable()->after('meeting_number');
                    $blueprint->unsignedTinyInteger('module_number')->nullable()->after('test_number');
                });

                Schema::table($table, function (Blueprint $blueprint) use ($table) {
                    $blueprint->unique(['context', 'test_number', 'module_number'], $table . '_test_module_unique');
                });
            }
        }
    }

    public function down(): void
    {
        foreach (['sat_reading_writing_meetings', 'sat_math_meetings'] as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'test_number')) {
                Schema::table($table, function (Blueprint $blueprint) use ($table) {
                    $blueprint->dropUnique($table . '_test_module_unique');
                    $blueprint->dropColumn(['test_number', 'module_number']);
                });
            }
        }
    }
};
