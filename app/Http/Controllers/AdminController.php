<?php

namespace App\Http\Controllers;

use App\Application\Admin\GetAdminDashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct(
        private readonly GetAdminDashboard $getAdminDashboard,
    ) {
    }

    public function index(Request $request)
    {
        $data = $this->getAdminDashboard->execute();

        return view('admin.dashboard', $data);
    }

    /**
     * Standalone "Recently Active Students/Teachers" view - the same
     * realtime-monitoring widget shown on the Dashboard, but reachable
     * directly from the sidebar so admins don't have to go back to the
     * Dashboard first just to check who's online / open a live view.
     */
    public function livePreview(Request $request)
    {
        $data = $this->getAdminDashboard->execute($this->resolveActiveWindowHours($request));

        return view('admin.live-preview', $data);
    }

    /** Only 24 or 48 are offered in the UI; anything else falls back to 24. */
    private function resolveActiveWindowHours(Request $request): int
    {
        $hours = (int) $request->query('hours', 24);

        return $hours === 48 ? 48 : 24;
    }

    /**
     * JSON endpoint for polling online/active students in realtime dashboard.
     * Polled every 30 seconds by the frontend. Accepts ?hours=24|48 to
     * switch the "recently active" window.
     */
    public function activeStudentsJson(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $this->getAdminDashboard->execute($this->resolveActiveWindowHours($request));
        $activeStudents = $data['activeStudents'] ?? [];

        // Normalize to plain arrays so json_encode works correctly
        $students = array_values(array_map(function ($student) {
            $s = is_array($student) ? (object) $student : $student;
            return [
                'id'            => (int) ($s->id ?? 0),
                'name'          => $s->name ?? '',
                'role'          => $s->role ?? 'student',
                'program_name'  => ($s->role ?? '') === 'guest'
                    ? 'Free Test'
                    : ($s->program_name ?? 'No Program Assigned'),
                'last_activity' => (int) ($s->last_activity ?? 0),
                'activity_url'  => $s->activity_url ?? null,
            ];
        }, $activeStudents));

        return response()->json([
            'students'    => $students,
            'server_time' => now()->timestamp,
        ]);
    }

    /** Accepts ?hours=24|48 to switch the "recently active" window. */
    public function activeTeachersJson(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $this->getAdminDashboard->execute($this->resolveActiveWindowHours($request));
        $activeTeachers = $data['activeTeachers'] ?? [];

        $teachers = array_values(array_map(function ($teacher) {
            $t = is_array($teacher) ? (object) $teacher : $teacher;
            return [
                'id'            => (int) ($t->id ?? 0),
                'name'          => $t->name ?? '',
                'role'          => $t->role ?? 'teacher',
                'program_name'  => $t->program_name ?? 'Teacher Dashboard',
                'last_activity' => (int) ($t->last_activity ?? 0),
            ];
        }, $activeTeachers));

        return response()->json([
            'teachers'    => $teachers,
            'server_time' => now()->timestamp,
        ]);
    }

    public function impersonate($role)
    {
        $currentUser = Auth::user();

        if ($currentUser && $currentUser->role === 'admin' && in_array($role, ['teacher', 'student', 'guest', 'test-taker'], true)) {
            session(['view_as_role' => $role]);
        }

        if ($role === 'teacher') {
            return redirect()->route('teacher.dashboard');
        }

        if ($role === 'student' || $role === 'guest') {
            return redirect()->route('dashboard');
        }

        if ($role === 'test-taker') {
            return redirect()->route('online-test.index');
        }

        return back();
    }

    public function stopImpersonate()
    {
        session()->forget('view_as_role');

        return redirect()->route('admin.dashboard');
    }
}
