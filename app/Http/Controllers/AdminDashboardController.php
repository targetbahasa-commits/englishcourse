<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Program;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalStudents = User::where('role', 'student')->count();
        $totalTeachers = User::where('role', 'teacher')->count();
        $totalPrograms = Program::count();
        
        // For now, we'll count active assignments as total meetings across all programs
        // This can be refined later based on specific "active" criteria
        $activeAssignments = \App\Models\Meeting::where('is_locked', false)->count();

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalPrograms',
            'activeAssignments'
        ));
    }
}
