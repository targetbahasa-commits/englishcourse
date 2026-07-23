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
            // Nullable so existing "Free Test" certificates (toefl_itp, ielts_academic, etc.)
            // remain unaffected. Program-linked certificates will have this set.
            $table->unsignedBigInteger('program_id')->nullable()->after('id');

            $table->foreign('program_id')
                  ->references('id')
                  ->on('programs')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('free_test_certificates', function (Blueprint $table) {
            $table->dropForeign(['program_id']);
            $table->dropColumn('program_id');
        });
    }
};
