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
        Schema::table('grammar_questions', function (Blueprint $table) {
            $table->text('example')->nullable()->after('correct_answer');
            $table->text('vocabulary')->nullable()->after('example');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grammar_questions', function (Blueprint $table) {
            $table->dropColumn(['example', 'vocabulary']);
        });
    }
};
