<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIeltsWritingMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ielts_writing_meetings', function (Blueprint $table) {
            $table->id();
            $table->integer('task_type')->comment('1 for Task 1, 2 for Task 2');
            $table->integer('meeting_number');
            $table->string('title');
            $table->text('prompt');
            $table->string('image')->nullable()->comment('For Task 1 charts/graphs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ielts_writing_meetings');
    }
}
