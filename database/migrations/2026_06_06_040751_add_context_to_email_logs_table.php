<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('email_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->string('related_type')->nullable()->after('user_id'); // e.g. 'registration_lead', 'payment'
            $table->unsignedBigInteger('related_id')->nullable()->after('related_type');

            $table->index('user_id');
            $table->index(['related_type', 'related_id']);
        });
    }

    public function down(): void
    {
        Schema::table('email_logs', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['related_type', 'related_id']);
            $table->dropColumn(['user_id', 'related_type', 'related_id']);
        });
    }
};
