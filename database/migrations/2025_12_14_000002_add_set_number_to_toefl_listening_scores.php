<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('toefl_listening_scores', function (Blueprint $table) {
            if (!Schema::hasColumn('toefl_listening_scores', 'set_number')) {
                $table->integer('set_number')->nullable()->after('meeting_number');
            }
        });
    }

    public function down()
    {
        Schema::table('toefl_listening_scores', function (Blueprint $table) {
            if (Schema::hasColumn('toefl_listening_scores', 'set_number')) {
                $table->dropColumn('set_number');
            }
        });
    }
};
