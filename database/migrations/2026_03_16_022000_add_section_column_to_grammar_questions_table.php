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
        if (!Schema::hasColumn('grammar_questions', 'section')) {
            Schema::table('grammar_questions', function (Blueprint $table) {
                $table->string('section')->nullable()->after('question_number');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('grammar_questions', 'section')) {
            Schema::table('grammar_questions', function (Blueprint $table) {
                $table->dropColumn('section');
            });
        }
    }
};
