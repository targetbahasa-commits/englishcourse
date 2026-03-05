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
        // 1. Create class_periods table
        Schema::create('class_periods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "September 2024"
            $table->foreignId('program_id')->nullable()->constrained()->onDelete('set null');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'upcoming', 'closed'])->default('active');
            $table->timestamps();
        });

        // 2. Update users table
        Schema::table('users', function (Blueprint $table) {
            // Drop old string column if exists (from previous partial implementation)
            if (Schema::hasColumn('users', 'class_period')) {
                $table->dropColumn('class_period');
            }
            $table->foreignId('class_period_id')->nullable()->after('status')->constrained('class_periods')->onDelete('set null');
        });

        // 3. Create class_period_meetings table (pivot/access control)
        Schema::create('class_period_meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_period_id')->constrained('class_periods')->onDelete('cascade');
            $table->foreignId('meeting_id')->constrained('meetings')->onDelete('cascade');
            $table->boolean('is_open')->default(false); // Default to locked
            $table->timestamps();

            $table->unique(['class_period_id', 'meeting_id']);
        });

        // Drop the old temporary table if exists
        Schema::dropIfExists('class_period_meeting_statuses');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_period_meetings');
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['class_period_id']);
            $table->dropColumn('class_period_id');
            $table->string('class_period')->nullable(); // Restore old column
        });

        Schema::dropIfExists('class_periods');
        
        // Cannot easily restore old table data, but structure:
        Schema::create('class_period_meeting_statuses', function (Blueprint $table) {
             $table->id();
             $table->string('class_period')->index();
             $table->foreignId('meeting_id')->constrained()->onDelete('cascade');
             $table->boolean('is_locked')->default(true);
             $table->timestamps();
        });
    }
};
