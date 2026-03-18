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
        Schema::create('registration_leads', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('whatsapp', 20);
            $table->string('email')->nullable();
            $table->string('city', 100);
            $table->unsignedTinyInteger('age')->nullable();
            $table->enum('profession', ['student_sma', 'mahasiswa', 'karyawan', 'other'])->default('other');
            $table->string('profession_other', 100)->nullable();
            $table->foreignId('program_id')->nullable()->constrained('programs')->nullOnDelete();
            $table->string('program_interest', 100)->nullable(); // free text jika tidak pilih program
            $table->enum('mode', ['online', 'offline', 'flexible'])->default('flexible');
            $table->enum('schedule_preference', ['weekday', 'weekend', 'flexible'])->default('flexible');
            $table->enum('preferred_time', ['pagi', 'siang', 'sore', 'malam', 'flexible'])->default('flexible');
            $table->text('learning_goal')->nullable();
            $table->string('target_score', 50)->nullable();
            $table->enum('source', ['instagram', 'tiktok', 'teman', 'google', 'brosur', 'youtube', 'other'])->default('other');
            $table->string('source_detail', 100)->nullable();
            $table->boolean('has_previous_course')->default(false);
            $table->string('previous_course_name', 100)->nullable();
            $table->string('budget_range', 50)->nullable();
            $table->string('best_contact_time', 100)->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['new', 'contacted', 'converted', 'cancelled'])->default('new');
            $table->text('admin_notes')->nullable();
            $table->timestamp('contacted_at')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('mode');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_leads');
    }
};
