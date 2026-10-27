<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Null = use the student's self-study grammar placement test result;
            // 'A'/'B' = admin-forced mode, bypassing the placement test entirely.
            $table->enum('self_study_grammar_mode_override', ['A', 'B'])->nullable()->after('remember_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('self_study_grammar_mode_override');
        });
    }
};
