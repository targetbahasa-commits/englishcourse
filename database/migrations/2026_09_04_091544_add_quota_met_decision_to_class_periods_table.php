<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('class_periods', function (Blueprint $table) {
            $table->timestamp('quota_met_at')->nullable()->default(null)->after('min_capacity');
            $table->string('quota_met_decision')->nullable()->default(null)->after('quota_met_notified_at');
            $table->timestamp('quota_met_decided_at')->nullable()->default(null)->after('quota_met_decision');
        });
    }

    public function down(): void
    {
        Schema::table('class_periods', function (Blueprint $table) {
            $table->dropColumn(['quota_met_at', 'quota_met_decision', 'quota_met_decided_at']);
        });
    }
};
