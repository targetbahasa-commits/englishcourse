<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->string('min_cefr_level', 2)->nullable()->after('program_type');
            $table->string('max_cefr_level', 2)->nullable()->after('min_cefr_level');
        });
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn(['min_cefr_level', 'max_cefr_level']);
        });
    }
};
