<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalStudents = \App\Models\User::where('role', 'student')->count();
        $totalTeachers = \App\Models\User::where('role', 'teacher')->count();
        $totalPrograms = \App\Models\Program::count();
        $activeAssignments = \App\Models\Meeting::count();

        // Fetch students and guests active in the last 24 hours
        $threshold = \Carbon\Carbon::now()->subHours(24)->timestamp;
        
        $activeStudents = \Illuminate\Support\Facades\DB::table('sessions')
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
            // Get unique users only (in case of multiple sessions per user)
            ->get()
            ->unique('id')
            ->values();

        // System Status Data
        $dbStatus = 'Disconnected';
        try {
            \Illuminate\Support\Facades\DB::connection()->getPdo();
            $dbStatus = 'Connected';
        } catch (\Exception $e) {}

        $appVersion = config('app.version', 'v' . app()->version());
        $mailService = config('mail.default', 'smtp');

        return view('admin.dashboard', compact(
            'totalStudents', 
            'totalTeachers', 
            'totalPrograms', 
            'activeAssignments', 
            'activeStudents',
            'dbStatus',
            'appVersion',
            'mailService'
        ));
    }

    public function impersonate($role)
    {
        // Only admins can impersonate (this should be protected by middleware ideally, but handled here as fallback)
        if (auth()->user()->role === 'admin' && in_array($role, ['teacher', 'student', 'guest'])) {
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
