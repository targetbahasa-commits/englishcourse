<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViewTypeToIeltsWritingMeetingsTable extends Migration
{
    public function up()
    {
        Schema::table('ielts_writing_meetings', function (Blueprint $table) {
            $table->string('view_type')->default('standard')->after('image')->comment('standard, layout_builder');
        });
    }

    public function down()
    {
        Schema::table('ielts_writing_meetings', function (Blueprint $table) {
            $table->dropColumn('view_type');
        });
    }
}
