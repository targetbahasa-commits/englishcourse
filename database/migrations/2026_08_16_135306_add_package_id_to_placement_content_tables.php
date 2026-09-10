<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('placement_reading_passages', function (Blueprint $table) {
            $table->foreignId('placement_test_package_id')->nullable()->after('id')->constrained('placement_test_packages')->cascadeOnDelete();
        });
        Schema::table('placement_listening_banks', function (Blueprint $table) {
            $table->foreignId('placement_test_package_id')->nullable()->after('id')->constrained('placement_test_packages')->cascadeOnDelete();
        });
        Schema::table('placement_writing_prompts', function (Blueprint $table) {
            $table->foreignId('placement_test_package_id')->nullable()->after('id')->constrained('placement_test_packages')->cascadeOnDelete();
        });
        Schema::table('placement_speaking_prompts', function (Blueprint $table) {
            $table->foreignId('placement_test_package_id')->nullable()->after('id')->constrained('placement_test_packages')->cascadeOnDelete();
        });
        Schema::table('placement_test_results', function (Blueprint $table) {
            $table->foreignId('placement_test_package_id')->nullable()->after('user_id')->constrained('placement_test_packages')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('placement_reading_passages', function (Blueprint $table) {
            $table->dropConstrainedForeignId('placement_test_package_id');
        });
        Schema::table('placement_listening_banks', function (Blueprint $table) {
            $table->dropConstrainedForeignId('placement_test_package_id');
        });
        Schema::table('placement_writing_prompts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('placement_test_package_id');
        });
        Schema::table('placement_speaking_prompts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('placement_test_package_id');
        });
        Schema::table('placement_test_results', function (Blueprint $table) {
            $table->dropConstrainedForeignId('placement_test_package_id');
        });
    }
};
