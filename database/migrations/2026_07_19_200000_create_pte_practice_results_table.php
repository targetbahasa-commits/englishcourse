<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table to store every PTE practice attempt result
        Schema::create('pte_practice_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('module', 80); // e.g. 'mcsa', 'mcma', 'reorder', 'rfib', 'rwfib', 'describe-image', 'read-aloud', etc.
            $table->unsignedInteger('topic_id');
            $table->unsignedInteger('score')->default(0);      // raw score (e.g. 1)
            $table->unsignedInteger('max_score')->default(1);  // max possible (e.g. 1)
            $table->unsignedInteger('duration_seconds')->default(0);
            $table->json('detail')->nullable(); // extra data (e.g. chosen answer, correct answer)
            $table->timestamps();

            $table->index(['user_id', 'module', 'topic_id']);
        });

        // Table to store bookmarks
        Schema::create('pte_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('module', 80);
            $table->unsignedInteger('topic_id');
            $table->timestamps();

            $table->unique(['user_id', 'module', 'topic_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pte_practice_results');
        Schema::dropIfExists('pte_bookmarks');
    }
};
