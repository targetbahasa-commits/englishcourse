<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Unauthorized access.');
        }

        // If the requested role is 'admin' and the user's actual role is 'admin',
        // clear any lingering impersonation session and grant access directly.
        if ($role === 'admin' && $user->role === 'admin') {
            if ($request->hasSession() && $request->session()->has('view_as_role')) {
                $request->session()->forget('view_as_role');
            }
            return $next($request);
        }

        if ($user->active_role !== $role) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
