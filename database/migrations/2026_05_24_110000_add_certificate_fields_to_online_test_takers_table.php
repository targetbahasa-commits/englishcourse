<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('online_test_takers', function (Blueprint $table) {
            $table->string('candidate_id')->nullable()->unique()->after('email');
            $table->date('date_of_birth')->nullable()->after('candidate_id');
            $table->string('sex', 1)->nullable()->after('date_of_birth');
            $table->string('country_of_origin')->nullable()->after('sex');
            $table->string('country_of_nationality')->nullable()->after('country_of_origin');
            $table->string('first_language')->nullable()->after('country_of_nationality');
            $table->string('test_type')->nullable()->after('first_language');
        });
    }

    public function down(): void
    {
        Schema::table('online_test_takers', function (Blueprint $table) {
            $table->dropUnique('online_test_takers_candidate_id_unique');
            $table->dropColumn([
                'candidate_id',
                'date_of_birth',
                'sex',
                'country_of_origin',
                'country_of_nationality',
                'first_language',
                'test_type',
            ]);
        });
    }
};
