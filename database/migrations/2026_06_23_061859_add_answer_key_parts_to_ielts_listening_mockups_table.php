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
        Schema::table('ielts_listening_mockups', function (Blueprint $table) {
            $table->dropColumn('answer_key');
            for ($i = 1; $i <= 4; $i++) {
                $table->text('answer_key_' . $i)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ielts_listening_mockups', function (Blueprint $table) {
            $table->text('answer_key')->nullable();
            for ($i = 1; $i <= 4; $i++) {
                $table->dropColumn('answer_key_' . $i);
            }
        });
    }
};
