<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * General-purpose "was this user recently active" signal, updated by
 * App\Http\Middleware\UpdateLastSeen on every authenticated request.
 *
 * This is deliberately separate from the `sessions` table's
 * last_activity: sessions are garbage-collected once SESSION_LIFETIME
 * (2 hours) of inactivity passes, so relying on session survival as a
 * presence proxy silently undercounts anyone inactive for longer than
 * that - even well within a 24h or 48h "recently active" window.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('last_seen_at')->nullable()->index()->after('remember_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_seen_at');
        });
    }
};
