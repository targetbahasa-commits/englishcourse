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
     * JSON endpoint for polling online/active students in realtime dashboard.
     * Polled every 30 seconds by the frontend.
     */
    public function activeStudentsJson(): JsonResponse
    {
        $data = $this->getAdminDashboard->execute();
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
            ];
        }, $activeStudents));

        return response()->json([
            'students'    => $students,
            'server_time' => now()->timestamp,
        ]);
    }

    public function activeTeachersJson(): \Illuminate\Http\JsonResponse
    {
        $data = $this->getAdminDashboard->execute();
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
