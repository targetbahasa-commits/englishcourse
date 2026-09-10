<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('final_test_drafts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->string('test_type')->index();
            $table->json('answers')->nullable();
            $table->integer('time_spent_seconds')->nullable();
            $table->timestamp('last_saved_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'test_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('final_test_drafts');
    }
};
