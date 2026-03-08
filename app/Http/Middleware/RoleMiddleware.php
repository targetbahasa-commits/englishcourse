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

        if ($user->active_role !== $role) {
            // If the user is actually an admin who is currently impersonating someone else,
            // and they try to access an admin-only route, automatically stop impersonating.
            if ($user->role === 'admin' && $role === 'admin') {
                return redirect()->route('admin.impersonate.stop');
            }
            
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
