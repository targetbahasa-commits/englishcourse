<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Stamps users.last_seen_at on every authenticated request - the
 * general-purpose "was this user recently active" signal used by the
 * admin dashboard's Recently Active Students/Teachers widgets (see
 * EloquentAdminRepository::getActiveStudents()/getActiveTeachers()).
 *
 * Deliberately NOT derived from the `sessions` table: session rows are
 * garbage-collected once SESSION_LIFETIME (2 hours) of inactivity
 * passes, so relying on session survival as a presence proxy silently
 * undercounts anyone inactive for longer than that - even well within a
 * 24h or 48h "recently active" window.
 */
class UpdateLastSeen
{
    /**
     * How often (in seconds) to actually write to the database per user.
     * Every request would be wasteful at scale; nothing here needs
     * second-level precision - "recently active" is checked in hours.
     */
    private const THROTTLE_SECONDS = 60;

    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && (!$user->last_seen_at || $user->last_seen_at->lt(now()->subSeconds(self::THROTTLE_SECONDS)))) {
            // saveQuietly(): a heartbeat timestamp shouldn't fire model
            // events/observers on every write.
            $user->forceFill(['last_seen_at' => now()])->saveQuietly();
        }

        return $next($request);
    }
}
