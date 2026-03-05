<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ielts_writing_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ielts_writing_meeting_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('instruction')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ielts_writing_questions');
    }
};
