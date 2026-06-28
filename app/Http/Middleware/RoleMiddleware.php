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

        // For admin routes: check actual DB role, not active_role.
        // This lets admins access admin pages even while impersonating.
        // Interns are also allowed into admin routes, but their access
        // is further restricted by specific permissions in controllers/views.
        if ($role === 'admin') {
            if (!in_array($user->role, ['admin', 'intern'])) {
                abort(403, 'Unauthorized access.');
            }

            if ($user->role === 'intern') {
                $routeName = $request->route()->getName();
                if ($routeName && $routeName !== 'admin.dashboard') {
                    $allowed = false;
                    
                    $permissionMap = [
                        'manage_payments' => ['admin.payments.', 'admin.payment-queue', 'admin.transfer-proofs'],
                        'manage_announcements' => ['admin.announcements.', 'admin.broadcast-messages.', 'admin.outreach-messages.', 'admin.leads.'],
                        'manage_users' => ['users.', 'students.', 'teachers.', 'admin.guest-users.', 'admin.api.active-students', 'admin.api.active-teachers', 'admin.chat.'],
                        'view_reports' => ['admin.reports.', 'admin.attendance.', 'admin.assignment-results.', 'admin.evaluations.', 'admin.class-evaluations.', 'admin.toefl-mockup-results.', 'admin.final-test-results.', 'admin.online-test-results.'],
                        'manage_programs' => ['programs.', 'admin.camps.', 'class-periods.', 'admin.class-schedules.', 'assignments.', 'final-test', 'admin.manage-final-test', 'online-test.', 'admin.online-tests.', 'mock-test', 'admin.free-tests.certificates.', 'free-lesson', 'admin.chat.'],
                    ];

                    foreach ($permissionMap as $permission => $prefixes) {
                        foreach ($prefixes as $prefix) {
                            if (str_starts_with($routeName, $prefix) && $user->hasInternPermission($permission)) {
                                $allowed = true;
                                break 2;
                            }
                        }
                    }

                    if (!$allowed) {
                        abort(403, 'Unauthorized access. You do not have the required intern permission.');
                    }
                }
            }

            return $next($request);
        }

        // For all other roles: check active_role (respects view_as_role session).
        if ($user->active_role !== $role) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
