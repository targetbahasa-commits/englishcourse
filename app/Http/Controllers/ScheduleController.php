<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ensure user has a ClassPeriod assigned
        if (!$user->classPeriod) {
            return view('student.schedule.index', [
                'hasActivePeriod' => false,
                'upcomingMeetings' => collect(),
                'pastMeetings' => collect()
            ]);
        }

        $now = now();

        // Get Upcoming Meetings
        // Priority: Future date first, then future time if same day.
        $upcomingMeetings = $user->classPeriod->classMeetings()
            ->with('meeting') // Assuming this relation exists for topic/details
            ->where(function($query) use ($now) {
                $query->where('meeting_date', '>', $now->toDateString())
                      ->orWhere(function($subq) use ($now) {
                          $subq->where('meeting_date', '=', $now->toDateString())
                               ->where('end_time', '>=', $now->toTimeString());
                      });
            })
            ->orderBy('meeting_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        // Get Past Meetings
        $pastMeetings = $user->classPeriod->classMeetings()
            ->with('meeting')
            ->where(function($query) use ($now) {
                $query->where('meeting_date', '<', $now->toDateString())
                      ->orWhere(function($subq) use ($now) {
                          $subq->where('meeting_date', '=', $now->toDateString())
                               ->where('end_time', '<', $now->toTimeString());
                      });
            })
            ->orderBy('meeting_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get();

        return view('student.schedule.index', [
            'hasActivePeriod' => true,
            'upcomingMeetings' => $upcomingMeetings,
            'pastMeetings' => $pastMeetings
        ]);
    }
}
