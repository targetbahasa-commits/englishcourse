<?php

namespace App\Http\Controllers;

use App\Application\Scholarship\SearchScholarships;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScholarshipSearchController extends Controller
{
    public function __construct(
        private readonly SearchScholarships $searchScholarships,
    ) {
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'country', 'degree_level', 'funding_type', 'major']);
        $scholarships = $this->searchScholarships->search($filters, 12);
        $filterOptions = $this->searchScholarships->getFilterOptions();

        $countries    = $filterOptions['countries'];
        $degreeLevels = $filterOptions['degreeLevels'];
        $fundingTypes = $filterOptions['fundingTypes'];
        $majors       = $filterOptions['majors'];

        $predictedScore = null;
        if (Auth::check() && Auth::user()->isStudent()) {
            $ieltsScore = Auth::user()->freeTestResults()->where('test_type', 'ielts')->max('score');
            $toeflScore = Auth::user()->freeTestResults()->where('test_type', 'toefl_itp')->max('score');
            $predictedScore = ['ielts' => $ieltsScore, 'toefl' => $toeflScore];
        }

        $savedScholarshipIds = [];
        if (Auth::check()) {
            $savedScholarshipIds = Auth::user()->savedScholarships()->pluck('scholarships.id')->toArray();
        }

        $latestNews = $this->searchScholarships->getLatestNews(3);

        return view('scholarships.index', compact(
            'scholarships', 'countries', 'degreeLevels', 'fundingTypes', 'majors',
            'predictedScore', 'savedScholarshipIds', 'latestNews'
        ));
    }

    public function show(Scholarship $scholarship)
    {
        if (!$scholarship->is_active || ($scholarship->deadline && \Carbon\Carbon::parse($scholarship->deadline)->isPast())) {
            abort(404, 'Scholarship not found or expired.');
        }

        $predictedScore = null;
        if (Auth::check() && Auth::user()->isStudent()) {
            $ieltsScore = Auth::user()->freeTestResults()->where('test_type', 'ielts')->max('score');
            $toeflScore = Auth::user()->freeTestResults()->where('test_type', 'toefl_itp')->max('score');
            $predictedScore = ['ielts' => $ieltsScore, 'toefl' => $toeflScore];
        }

        $savedScholarshipIds = [];
        $targetScholarshipId = null;
        if (Auth::check()) {
            $savedScholarshipIds = Auth::user()->savedScholarships()->pluck('scholarships.id')->toArray();
            $targetScholarshipId = Auth::user()->targetScholarships()->first()->id ?? null;
        }

        return view('scholarships.show', compact('scholarship', 'predictedScore', 'savedScholarshipIds', 'targetScholarshipId'));
    }

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

    public function toggleTarget(Scholarship $scholarship)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $isTarget = $user->targetScholarships()->where('scholarships.id', $scholarship->id)->exists();

        if ($isTarget) {
            $user->targetScholarships()->detach($scholarship->id);
            return response()->json(['status' => 'untargeted', 'message' => 'Target removed.']);
        } else {
            $user->targetScholarships()->sync([$scholarship->id]);
            return response()->json(['status' => 'targeted', 'message' => 'Set as your target scholarship!']);
        }
    }

    public function getCalendarEvents(Request $request)
    {
        $scholarships = $this->searchScholarships->getActiveForCalendar();

        $events = [];
        foreach ($scholarships as $scholarship) {
            if ($scholarship->opening_date) {
                $events[] = [
                    'id'    => $scholarship->id,
                    'title' => 'Open: ' . $scholarship->title,
                    'date'  => $scholarship->opening_date->format('Y-m-d'),
                    'type'  => 'opening',
                    'url'   => route('scholarships.search.show', $scholarship->id),
                ];
            }
            if ($scholarship->deadline) {
                $events[] = [
                    'id'    => $scholarship->id,
                    'title' => 'Deadline: ' . $scholarship->title,
                    'date'  => $scholarship->deadline->format('Y-m-d'),
                    'type'  => 'deadline',
                    'url'   => route('scholarships.search.show', $scholarship->id),
                ];
            }
        }

        return response()->json($events);
    }
}
