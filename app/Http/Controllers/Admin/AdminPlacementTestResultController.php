<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlacementTestResult;
use App\Models\Program;
use Illuminate\Http\Request;

class AdminPlacementTestResultController extends Controller
{
    public function index(Request $request)
    {
        $query = PlacementTestResult::with(['user', 'package'])->orderByDesc('id');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('cefr_level')) {
            $query->where('cefr_level', $request->cefr_level);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        $totalResults = PlacementTestResult::count();
        $completedResults = PlacementTestResult::where('status', 'completed')->count();
        $inProgressResults = PlacementTestResult::where('status', 'in_progress')->count();
        $advancedLevelCount = PlacementTestResult::whereIn('cefr_level', ['C1', 'C2'])->count();

        $results = $query->paginate(20)->withQueryString();

        return view('admin.placement-test.results.index', compact(
            'results',
            'totalResults',
            'completedResults',
            'inProgressResults',
            'advancedLevelCount'
        ));
    }

    public function show(PlacementTestResult $result)
    {
        $result->load(['user', 'package']);

        $recommendedPrograms = collect();
        if (!empty($result->recommended_program_ids)) {
            $recommendedPrograms = Program::whereIn('id', $result->recommended_program_ids)->get();
        }

        return view('admin.placement-test.results.show', compact('result', 'recommendedPrograms'));
    }
}
