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
        Schema::table('registration_leads', function (Blueprint $table) {
            $table->foreignId('converted_user_id')
                ->nullable()
                ->after('class_period_id')
                ->constrained('users')
                ->nullOnDelete();

            $table->index('converted_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registration_leads', function (Blueprint $table) {
            $table->dropConstrainedForeignId('converted_user_id');
        });
    }
};
