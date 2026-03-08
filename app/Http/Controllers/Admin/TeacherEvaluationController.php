<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TeacherEvaluation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class TeacherEvaluationController extends Controller
{
    /**
     * Display a listing of all teacher evaluations for admin.
     */
    public function index(Request $request)
    {
        $query = TeacherEvaluation::with(['student', 'teacher']);
            
        // Filter by specific teacher if requested
        if ($request->has('teacher_id') && $request->teacher_id != '') {
            $query->where('teacher_id', $request->teacher_id);
        }

        $evaluations = $query->latest()->paginate(20);
        
        // Get list of teachers who have evaluations for the filter dropdown
        $teachersWithEvaluations = User::whereIn('id', function($q) {
            $q->select('teacher_id')->from('teacher_evaluations');
        })->get();

        // Get aggregate stats
        $averageRating = TeacherEvaluation::avg('rating') ?? 0;
        $totalEvaluations = TeacherEvaluation::count();

        // Best performing teachers
        $topTeachers = User::select('users.id', 'users.name', DB::raw('AVG(teacher_evaluations.rating) as avg_rating'), DB::raw('COUNT(teacher_evaluations.id) as total_reviews'))
            ->join('teacher_evaluations', 'users.id', '=', 'teacher_evaluations.teacher_id')
            ->groupBy('users.id', 'users.name')
            ->having('total_reviews', '>=', 1) // Optionally require min reviews
            ->orderByDesc('avg_rating')
            ->orderByDesc('total_reviews')
            ->take(5)
            ->get();

        return view('admin.evaluations.index', compact(
            'evaluations', 
            'teachersWithEvaluations', 
            'averageRating', 
            'totalEvaluations',
            'topTeachers'
        ));
    }
}
