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
        Schema::table('ielts_listening_materials', function (Blueprint $table) {
            for ($i = 1; $i <= 20; $i++) {
                $table->text('answer_key_practice_' . $i)->nullable()->after('answer_key');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ielts_listening_materials', function (Blueprint $table) {
            for ($i = 1; $i <= 20; $i++) {
                $table->dropColumn('answer_key_practice_' . $i);
            }
        });
    }
};
