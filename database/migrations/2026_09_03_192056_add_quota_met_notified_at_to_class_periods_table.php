<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('class_periods', function (Blueprint $table) {
            $table->timestamp('quota_met_notified_at')->nullable()->default(null)->after('min_capacity');
        });
    }

    public function down(): void
    {
        Schema::table('class_periods', function (Blueprint $table) {
            $table->dropColumn('quota_met_notified_at');
        });
    }
};
