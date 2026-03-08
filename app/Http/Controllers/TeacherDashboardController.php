<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $announcements = \App\Models\Announcement::where('is_active', true)
            ->whereIn('target_role', ['all', 'teacher'])
            ->latest()
            ->get();
            
        return view('teacher.dashboard', compact('announcements'));
    }
}
