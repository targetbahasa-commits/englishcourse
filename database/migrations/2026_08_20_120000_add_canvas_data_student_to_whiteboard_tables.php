<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Splits the whiteboard into two independently-clearable layers: staff
 * (teacher/admin/intern) and student. The existing `canvas_data` column
 * keeps its name but now specifically means the STAFF layer (the
 * whiteboard's original/legacy content, drawn before this split existed,
 * is treated as staff-authored - it was mainly used for teachers explaining
 * material). `canvas_data_student` is the new, separate student layer.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('whiteboard_saves', function (Blueprint $table) {
            $table->longText('canvas_data_student')->nullable()->after('canvas_data');
        });

        Schema::table('whiteboard_archives', function (Blueprint $table) {
            $table->longText('canvas_data_student')->nullable()->after('canvas_data');
        });
    }

    public function down(): void
    {
        Schema::table('whiteboard_saves', function (Blueprint $table) {
            $table->dropColumn('canvas_data_student');
        });

        Schema::table('whiteboard_archives', function (Blueprint $table) {
            $table->dropColumn('canvas_data_student');
        });
    }
};
