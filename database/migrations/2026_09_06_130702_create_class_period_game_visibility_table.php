<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_period_game_visibility', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_period_id')->constrained()->cascadeOnDelete();
            $table->foreignId('meeting_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('game_index');
            // Default true (open) - the inverse of class_period_meetings.is_open,
            // which defaults locked. Every meeting today has exactly 1 game and
            // must keep working with zero admin action, so a row here only ever
            // needs to exist to record an explicit hide, not an explicit show.
            $table->boolean('is_open')->default(true);
            $table->timestamps();

            $table->unique(['class_period_id', 'meeting_id', 'game_index'], 'class_period_game_visibility_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_period_game_visibility');
    }
};
