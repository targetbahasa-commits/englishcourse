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
        Schema::table('scholarships', function (Blueprint $table) {
            $table->string('funding_type')->nullable()->after('level_of_study');
            $table->json('majors')->nullable()->after('funding_type');
            $table->boolean('has_work_contract')->default(false)->after('majors');
            $table->decimal('min_gpa', 3, 2)->nullable()->after('min_toefl');
            $table->integer('max_age')->nullable()->after('min_gpa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scholarships', function (Blueprint $table) {
            $table->dropColumn(['funding_type', 'majors', 'has_work_contract', 'min_gpa', 'max_age']);
        });
    }
};
