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
        Schema::table('job_vacancies', function (Blueprint $table) {
            $table->string('location')->nullable()->after('country');
            $table->string('salary')->nullable()->after('job_type');
            $table->boolean('visa_sponsorship')->default(false)->after('salary');
            $table->text('benefits')->nullable()->after('requirements');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_vacancies', function (Blueprint $table) {
            $table->dropColumn(['location', 'salary', 'visa_sponsorship', 'benefits']);
        });
    }
};
