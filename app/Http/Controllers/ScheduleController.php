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

        // Get all enrollments that have a class period assigned
        $enrollments = $user->enrollments()->with('classPeriod.program')->whereNotNull('class_period_id')->get();

        if ($enrollments->isEmpty()) {
            return view('student.schedule.index', [
                'hasActivePeriod' => false,
                'upcomingMeetings' => collect(),
                'pastMeetings' => collect()
            ]);
        }

        $now = now();
        $classPeriodIds = $enrollments->pluck('class_period_id');

        // Get Upcoming Meetings across all enrolled class periods
        $upcomingMeetings = \App\Models\ClassMeeting::with(['meeting', 'classPeriod.program'])
            ->whereIn('class_period_id', $classPeriodIds)
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
        $pastMeetings = \App\Models\ClassMeeting::with(['meeting', 'classPeriod.program'])
            ->whereIn('class_period_id', $classPeriodIds)
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
