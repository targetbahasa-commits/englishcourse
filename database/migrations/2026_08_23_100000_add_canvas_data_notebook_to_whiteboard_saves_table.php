<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds a third, independent layer to whiteboard_saves for a student's
 * private "Notebook" tab - own personal notes, isolated from the staff/
 * student layers (see LiveDrawingController::LAYER_COLUMNS). Deliberately
 * NOT added to whiteboard_archives - notebook content is never archivable,
 * it's personal scratch space, not part of the teaching-session history.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('whiteboard_saves', function (Blueprint $table) {
            $table->longText('canvas_data_notebook')->nullable()->after('canvas_data_student');
        });
    }

    public function down(): void
    {
        Schema::table('whiteboard_saves', function (Blueprint $table) {
            $table->dropColumn('canvas_data_notebook');
        });
    }
};
