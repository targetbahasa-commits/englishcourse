<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('toefl_listening_scores', function (Blueprint $table) {
            // Drop the existing unique index if it exists
            // Verify index name first or try catch, but usually standard name is table_col1_col2_unique
            $table->dropUnique(['user_id', 'meeting_number']);
            
            // Add new unique index including set_number
            // We use a raw DB statement because Blueprint might not handle nullable unique composites consistently across drivers in older Laravel/SQLite
            // But standard unique() usually works.
            $table->unique(['user_id', 'meeting_number', 'set_number']);
        });
    }

    public function down()
    {
        Schema::table('toefl_listening_scores', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'meeting_number', 'set_number']);
            $table->unique(['user_id', 'meeting_number']);
        });
    }
};
