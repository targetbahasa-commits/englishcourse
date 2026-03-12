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
        Schema::table('toefl_listening_questions', function (Blueprint $table) {
            $table->integer('set_number')->default(1)->after('meeting_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('toefl_listening_questions', function (Blueprint $table) {
            $table->dropColumn('set_number');
        });
    }
};
