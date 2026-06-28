<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        try {
            Schema::table('toefl_listening_scores', function (Blueprint $table) {
                $table->dropUnique(['user_id', 'meeting_number']);
            });
        } catch (\Exception $e) {
            // Ignore if it doesn't exist
        }

        Schema::table('toefl_listening_scores', function (Blueprint $table) {
            if (!Schema::hasColumn('toefl_listening_scores', 'set_number')) {
                $table->integer('set_number')->nullable()->after('meeting_number');
            }
            
            // Add new unique index including set_number
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
