<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('outreach_messages', function (Blueprint $table) {
            $table->id();
            $table->string('test_type'); // e.g. 'toefl_itp'
            $table->enum('target_role', ['guest', 'student']); // to differentiate the copy for guests vs students
            $table->decimal('min_score', 8, 2)->nullable();
            $table->decimal('max_score', 8, 2)->nullable();
            $table->text('message_content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outreach_messages');
    }
};
