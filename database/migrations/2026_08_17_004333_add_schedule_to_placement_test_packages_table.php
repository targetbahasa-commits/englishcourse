<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('placement_test_packages', function (Blueprint $table) {
            $table->timestamp('active_from')->nullable()->after('status');
            $table->timestamp('active_until')->nullable()->after('active_from');
        });
    }

    public function down(): void
    {
        Schema::table('placement_test_packages', function (Blueprint $table) {
            $table->dropColumn(['active_from', 'active_until']);
        });
    }
};
