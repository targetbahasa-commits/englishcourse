<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('grammar_placement_questions', function (Blueprint $table) {
            $table->foreignId('grammar_placement_package_id')->nullable()->after('id')
                ->constrained('grammar_placement_packages')->cascadeOnDelete();
        });

        Schema::table('grammar_placement_results', function (Blueprint $table) {
            $table->foreignId('grammar_placement_package_id')->nullable()->after('id')
                ->constrained('grammar_placement_packages')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('grammar_placement_questions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('grammar_placement_package_id');
        });

        Schema::table('grammar_placement_results', function (Blueprint $table) {
            $table->dropConstrainedForeignId('grammar_placement_package_id');
        });
    }
};
