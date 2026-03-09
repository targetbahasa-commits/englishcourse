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
            $table->string('country')->nullable()->after('location');
            $table->decimal('min_ielts', 3, 1)->nullable()->after('requirements');
            $table->integer('min_toefl')->nullable()->after('min_ielts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scholarships', function (Blueprint $table) {
            $table->dropColumn(['country', 'min_ielts', 'min_toefl']);
        });
    }
};
