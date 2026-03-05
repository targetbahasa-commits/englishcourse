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
        Schema::table('users', function (Blueprint $table) {
            $table->string('class_period')->nullable()->after('status');
        });

        Schema::create('class_period_meeting_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('class_period')->index();
            $table->foreignId('meeting_id')->constrained()->onDelete('cascade');
            $table->boolean('is_locked')->default(true);
            $table->timestamps();
            
            $table->unique(['class_period', 'meeting_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_period_meeting_statuses');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('class_period');
        });
    }
};
