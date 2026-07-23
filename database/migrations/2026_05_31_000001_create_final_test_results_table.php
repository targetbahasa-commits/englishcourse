<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('final_test_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('name')->nullable();
            $table->string('email')->nullable()->index();
            $table->string('candidate_id')->nullable()->index();
            $table->string('test_type')->nullable()->index();
            $table->string('test_label')->nullable();
            $table->string('status')->nullable()->index();
            $table->integer('duration_minutes')->nullable();
            $table->integer('time_spent_seconds')->nullable();
            $table->decimal('score', 6, 2)->nullable();
            $table->json('answers_data')->nullable();
            $table->json('evaluation_data')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('final_test_results');
    }
};
