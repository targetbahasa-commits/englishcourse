<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Program;
use App\Models\Scholarship;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Core stats
        $totalStudents = User::where('role', 'student')->count();
        $totalTeachers = User::where('role', 'teacher')->count();
        $totalPrograms = Program::count();
        $activeAssignments = \App\Models\Meeting::where('is_locked', false)->count();

        // Recently active students (last 24 hours)
        $activeStudents = User::whereNotNull('last_activity')
            ->where('last_activity', '>=', now()->subHours(24)->timestamp)
            ->orderByDesc('last_activity')
            ->limit(20)
            ->get()
            ->map(function ($user) {
                $user->program_name = optional($user->program)->name;
                return $user;
            });

        // Scholarships closing in the next 14 days (active only, not yet expired)
        $closingSoonScholarships = Scholarship::where('is_active', true)
            ->whereBetween('deadline', [now()->startOfDay(), now()->addDays(14)->endOfDay()])
            ->orderBy('deadline')
            ->limit(5)
            ->get();

        // System info
        $dbStatus = 'Connected';
        try { DB::connection()->getPdo(); } catch (\Exception $e) { $dbStatus = 'Disconnected'; }
        $appVersion = config('app.version', '2.5.0');
        $mailService = config('mail.default', 'smtp');

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalPrograms',
            'activeAssignments',
            'activeStudents',
            'closingSoonScholarships',
            'dbStatus',
            'appVersion',
            'mailService',
        ));
    }
}

