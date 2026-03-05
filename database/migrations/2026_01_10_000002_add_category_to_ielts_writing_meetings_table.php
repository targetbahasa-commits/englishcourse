<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryToIeltsWritingMeetingsTable extends Migration
{
    public function up()
    {
        Schema::table('ielts_writing_meetings', function (Blueprint $table) {
            $table->string('category')->default('lesson')->after('view_type')->comment('lesson, practice');
        });
    }

    public function down()
    {
        Schema::table('ielts_writing_meetings', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
}
