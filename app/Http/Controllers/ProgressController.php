<?php

namespace App\Http\Controllers;

use App\Models\FreeTestResult;
use App\Models\MeetingScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Performance Overview
        $totalAssignments = MeetingScore::where('user_id', $user->id)->count();
        $averageScore = MeetingScore::where('user_id', $user->id)->avg('score') ?? 0;
        
        // 2. Free Tests History
        $freeTests = FreeTestResult::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // 3. Meeting Scores History
        $meetingScores = MeetingScore::where('user_id', $user->id)
            ->orderBy('meeting_number', 'asc')
            ->get();

        // 4. Calculate Skill/Band Distribution for Radar Chart (Optional/Simulated)
        // Grouping meetings into mock skills for visualization
        $skillScores = [
            'Grammar' => MeetingScore::where('user_id', $user->id)->whereIn('meeting_number', [1, 2, 3, 4, 5])->avg('score') ?? 0,
            'Vocabulary' => MeetingScore::where('user_id', $user->id)->whereIn('meeting_number', [6, 7, 8, 9, 10])->avg('score') ?? 0,
            'Reading' => MeetingScore::where('user_id', $user->id)->whereIn('meeting_number', [11, 12, 13])->avg('score') ?? 0,
            'Writing' => MeetingScore::where('user_id', $user->id)->whereIn('meeting_number', [14, 15, 16, 17])->avg('score') ?? 0,
            'Listening' => MeetingScore::where('user_id', $user->id)->whereIn('meeting_number', [18, 19, 20])->avg('score') ?? 0,
        ];

        return view('student.progress.index', compact(
            'totalAssignments',
            'averageScore',
            'freeTests',
            'meetingScores',
            'skillScores'
        ));
    }
}
