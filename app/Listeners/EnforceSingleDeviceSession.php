<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;

/**
 * Limits student accounts to one active device/browser at a time. Every
 * successful login deletes any other session rows for that user, so a
 * previous device's session stops resolving on its next request.
 *
 * Scoped to students only - admins/teachers/interns are left free to use
 * multiple devices, which is normal for their work.
 */
class EnforceSingleDeviceSession
{
    public function handle(Login $event): void
    {
        $user = $event->user;

        if (!$user || $user->role !== 'student') {
            return;
        }

        $currentSessionId = session()->getId();

        DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '!=', $currentSessionId)
            ->delete();

        // Note: any other device's "remember me" cookie is invalidated
        // separately, in LoginRequest::authenticate() (which runs before
        // Auth::attempt() so it doesn't disturb THIS login's own fresh
        // remember_token/cookie).
    }
}
