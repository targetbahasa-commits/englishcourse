<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('grammar_topics', function (Blueprint $table) {
            $table->boolean('is_free_tier')->default(false)->after('order');
            $table->timestamp('promo_start')->nullable()->after('is_free_tier');
            $table->timestamp('promo_deadline')->nullable()->after('promo_start');
        });
    }

    public function down(): void
    {
        Schema::table('grammar_topics', function (Blueprint $table) {
            $table->dropColumn(['is_free_tier', 'promo_start', 'promo_deadline']);
        });
    }
};
