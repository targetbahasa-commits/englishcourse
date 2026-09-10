<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->enum('certificate_delivery_mode', ['certificate', 'score_sheet'])
                ->default('certificate')
                ->after('discount_value');
        });
    }

    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn('certificate_delivery_mode');
        });
    }
};
