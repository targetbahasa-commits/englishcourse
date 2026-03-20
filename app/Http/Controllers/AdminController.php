<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RegistrationLead;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    

    public function index(Request $request)
    {
        $totalStudents = User::where('role', 'student')->count();
        $totalTeachers = User::where('role', 'teacher')->count();
        $totalPrograms = \App\Models\Program::count();
        $activeAssignments = \App\Models\Meeting::count();
        $threshold = Carbon::now()->subHours(24)->timestamp;

        $activeStudents = DB::table('sessions')
            ->whereNotNull('user_id')
            ->where('last_activity', '>=', $threshold)
            ->join('users', 'sessions.user_id', '=', 'users.id')
            ->whereIn('users.role', ['teacher', 'student', 'guest'])
            ->leftJoin('programs', 'users.program_id', '=', 'programs.id')
            ->select(
                'users.id',
                'users.name',
                'users.role',
                'programs.name as program_name',
                'sessions.last_activity'
            )
            ->orderBy('sessions.last_activity', 'desc')
            ->get()
            ->unique('id')
            ->values();

        // Program Performance Summary
        $programPerformance = \App\Models\Program::withCount([
            'users as students_count' => function ($q) {
                $q->where('role', 'student');
            },
            'users as active_students_count' => function ($q) use ($threshold) {
                $q->where('role', 'student')
                    ->join('sessions', 'users.id', '=', 'sessions.user_id')
                    ->where('sessions.last_activity', '>=', $threshold)
                    ->distinct('users.id');
            },
        ])
            ->orderByDesc('students_count')
            ->limit(5)
            ->get();

        // Teacher Activity Summary
        $teacherActivitySummary = User::where('role', 'teacher')
            ->selectRaw('users.id, users.name, COUNT(DISTINCT programs.id) as program_count')
            ->leftJoin('programs', 'users.program_id', '=', 'programs.id')
            ->leftJoin('sessions', 'users.id', '=', 'sessions.user_id')
            ->groupBy('users.id', 'users.name')
            ->orderByRaw('MAX(sessions.last_activity) DESC')
            ->limit(5)
            ->get();

        $dbStatus = 'Disconnected';
        try {
            DB::connection()->getPdo();
            $dbStatus = 'Connected';
        } catch (\Exception $e) {
        }

        $appVersion = config('app.version', 'v' . app()->version());
        $mailService = config('mail.default', 'smtp');

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalPrograms',
            'activeAssignments',
            'activeStudents',
            'programPerformance',
            'teacherActivitySummary',
            'dbStatus',
            'appVersion',
            'mailService'
        ));
    }

    

    public function impersonate($role)
    {
        // Only admins can impersonate (this should be protected by middleware ideally, but handled here as fallback)
        $currentUser = Auth::user();

        if ($currentUser && $currentUser->role === 'admin' && in_array($role, ['teacher', 'student', 'guest'])) {
            session(['view_as_role' => $role]);
        }
        
        if ($role === 'teacher') {
            return redirect()->route('teacher.dashboard');
        } elseif ($role === 'student' || $role === 'guest') {
            return redirect()->route('dashboard');
        }

        return back();
    }

    public function stopImpersonate()
    {
        session()->forget('view_as_role');
        return redirect()->route('admin.dashboard');
    }
}
