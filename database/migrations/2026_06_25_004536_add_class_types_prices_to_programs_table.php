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
        Schema::table('programs', function (Blueprint $table) {
            $table->integer('price_private')->nullable()->default(0)->after('price_offline');
            $table->integer('price_private_offline')->nullable()->default(0)->after('price_private');
            $table->integer('price_semi_private')->nullable()->default(0)->after('price_private_offline');
            $table->integer('price_semi_private_offline')->nullable()->default(0)->after('price_semi_private');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn([
                'price_private',
                'price_private_offline',
                'price_semi_private',
                'price_semi_private_offline',
            ]);
        });
    }
};
