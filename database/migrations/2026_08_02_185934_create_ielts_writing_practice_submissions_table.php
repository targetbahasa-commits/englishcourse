<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ielts_writing_practice_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('meeting_id')->nullable()->constrained('ielts_writing_meetings')->nullOnDelete();
            $table->unsignedTinyInteger('task_type');
            $table->longText('essay');
            $table->json('scores')->nullable();
            $table->string('evaluation_status')->default('failed');
            $table->text('error_message')->nullable();
            $table->unsignedInteger('attempts')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ielts_writing_practice_submissions');
    }
};
