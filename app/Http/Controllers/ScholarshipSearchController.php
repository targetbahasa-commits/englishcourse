<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScholarshipSearchController extends Controller
{
    /**
     * Display a listing of active scholarships with filtering.
     */
    public function index(Request $request)
    {
        $query = Scholarship::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('deadline')
                  ->orWhere('deadline', '>=', now()->startOfDay());
            });

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('provider', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Country Filter
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        // Degree Level Filter
        if ($request->filled('degree_level')) {
            $query->where('level_of_study', $request->degree_level);
        }

        // Funding Type Filter
        if ($request->filled('funding_type')) {
            $query->where('funding_type', $request->funding_type);
        }

        // Major Filter (JSON search)
        if ($request->filled('major')) {
            $query->whereJsonContains('majors', $request->major);
        }

        $scholarships = $query->orderBy('deadline', 'asc')->paginate(12)->withQueryString();

        // Get unique dropdown options from DB for filters
        $countries = Scholarship::whereNotNull('country')->where('country', '!=', '')->distinct()->pluck('country');
        $degreeLevels = Scholarship::whereNotNull('level_of_study')->where('level_of_study', '!=', '')->distinct()->pluck('level_of_study');
        $fundingTypes = Scholarship::whereNotNull('funding_type')->where('funding_type', '!=', '')->distinct()->pluck('funding_type');

        // Extract unique majors (since they are stored as JSON arrays)
        $allMajors = [];
        $scholarshipsWithMajors = Scholarship::whereNotNull('majors')->get();
        foreach ($scholarshipsWithMajors as $scholarship) {
            if (is_array($scholarship->majors)) {
                $allMajors = array_merge($allMajors, $scholarship->majors);
            }
        }
        $majors = collect($allMajors)->unique()->sort()->values();

        // If authenticated student, get predicted score for Smart Match
        $predictedScore = null;
        if (Auth::check() && Auth::user()->isStudent()) {
            // Simplified logic: Using highest recent IELTS/TOEFL score as predicted score
            // In a real scenario, this might be a more complex calculation
            $ieltsScore = Auth::user()->freeTestResults()->where('test_type', 'ielts')->max('score');
            $toeflScore = Auth::user()->freeTestResults()->where('test_type', 'toefl_itp')->max('score');
            
            $predictedScore = [
                'ielts' => $ieltsScore,
                'toefl' => $toeflScore,
            ];
        }

        $savedScholarshipIds = [];
        if (Auth::check()) {
            $savedScholarshipIds = Auth::user()->savedScholarships()->pluck('scholarships.id')->toArray();
        }

        return view('scholarships.index', compact(
            'scholarships', 'countries', 'degreeLevels', 'fundingTypes', 'majors', 'predictedScore', 'savedScholarshipIds'
        ));
    }

    /**
     * Display the specified scholarship detail.
     */
    public function show(Scholarship $scholarship)
    {
        if (!$scholarship->is_active || ($scholarship->deadline && $scholarship->deadline->isPast())) {
            abort(404, 'Scholarship not found or expired.');
        }

        $predictedScore = null;
        if (Auth::check() && Auth::user()->isStudent()) {
            $ieltsScore = Auth::user()->freeTestResults()->where('test_type', 'ielts')->max('score');
            $toeflScore = Auth::user()->freeTestResults()->where('test_type', 'toefl_itp')->max('score');
            
            $predictedScore = [
                'ielts' => $ieltsScore,
                'toefl' => $toeflScore,
            ];
        }

        $savedScholarshipIds = [];
        if (Auth::check()) {
            $savedScholarshipIds = Auth::user()->savedScholarships()->pluck('scholarships.id')->toArray();
        }

        return view('scholarships.show', compact('scholarship', 'predictedScore', 'savedScholarshipIds'));
    }

    /**
     * Toggle save/bookmark status for a scholarship (AJAX).
     */
    public function toggleSave(Scholarship $scholarship)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $isSaved = $user->savedScholarships()->where('scholarships.id', $scholarship->id)->exists();

        if ($isSaved) {
            $user->savedScholarships()->detach($scholarship->id);
            return response()->json(['status' => 'unsaved', 'message' => 'Scholarship removed from saved list.']);
        } else {
            $user->savedScholarships()->attach($scholarship->id);
            return response()->json(['status' => 'saved', 'message' => 'Scholarship saved!']);
        }
    }
}
