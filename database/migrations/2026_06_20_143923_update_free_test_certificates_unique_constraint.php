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
        Schema::table('free_test_certificates', function (Blueprint $table) {
            // Drop the old unique constraint
            $table->dropUnique(['test_type']);
            // Add new unique constraint
            $table->unique(['test_type', 'program_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('free_test_certificates', function (Blueprint $table) {
            $table->dropUnique(['test_type', 'program_id']);
            $table->unique('test_type');
        });
    }
};
