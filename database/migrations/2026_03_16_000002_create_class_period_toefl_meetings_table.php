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
        Schema::create('class_period_toefl_meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_period_id')->constrained('class_periods')->cascadeOnDelete();
            $table->string('module', 20); // listening|reading|structure
            $table->unsignedInteger('meeting_number');
            $table->boolean('is_open')->default(false);
            $table->timestamps();

            $table->unique(['class_period_id', 'module', 'meeting_number'], 'cptm_unique');
            $table->index(['module', 'meeting_number'], 'cptm_module_meeting_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_period_toefl_meetings');
    }
};
