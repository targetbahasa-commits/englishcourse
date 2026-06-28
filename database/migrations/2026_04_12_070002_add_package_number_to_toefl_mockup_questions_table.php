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
        if (!Schema::hasColumn('toefl_mockup_questions', 'package_number')) {
            Schema::table('toefl_mockup_questions', function (Blueprint $table) {
                $table->integer('package_number')->default(1);
            });
        }

        try {
            Schema::table('toefl_mockup_questions', function (Blueprint $table) {
                $table->index(['section', 'package_number', 'question_number'], 'tmq_sec_pkg_qnum_idx');
            });
        } catch (\Exception $e) {
            // Index may already exist, skip
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('toefl_mockup_questions', function (Blueprint $table) {
            //
        });
    }
};
