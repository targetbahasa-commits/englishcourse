<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ielts_writing_drafts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('meeting_id')->constrained('ielts_writing_meetings')->cascadeOnDelete();
            $table->unsignedTinyInteger('task_type');
            $table->json('answers')->nullable();
            $table->timestamp('last_saved_at')->useCurrent();
            $table->timestamps();

            $table->unique(['user_id', 'meeting_id', 'task_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ielts_writing_drafts');
    }
};
