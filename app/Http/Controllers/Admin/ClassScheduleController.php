<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassMeeting;
use App\Models\ClassMeetingChangeRequest;
use App\Models\ClassPeriod;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClassScheduleController extends Controller
{
    public function index()
    {
        $stats = [
            'staff' => [
                'teachers' => \App\Models\User::where('role', 'teacher')->count(),
                'students' => \App\Models\User::where('role', 'student')->count(),
            ],
            'classes' => [
                'programs' => \App\Models\Program::where('is_active', true)->count(),
                'class_periods' => ClassPeriod::whereIn('status', ['active', 'upcoming'])->count(),
            ],
        ];

        $pendingClassMeetingChangeRequests = ClassMeetingChangeRequest::where('status', 'pending')
            ->with(['program', 'classMeeting', 'requester'])
            ->latest()
            ->get();

        return view('admin.class-schedules.index', compact('stats', 'pendingClassMeetingChangeRequests'));
    }

    /**
     * "Jam Kelas" confirmation: a teacher/admin on an assignment track page
     * designated a meeting as happening today whose scheduled date didn't
     * match (see ManageGrammarWritingMeetings::updateActiveClassMeeting()).
     * Approving moves that meeting's real calendar date and makes it the
     * program's active meeting for auto-attendance purposes.
     */
    public function approveClassMeetingChangeRequest(ClassMeetingChangeRequest $classMeetingChangeRequest)
    {
        if ($classMeetingChangeRequest->status !== 'pending') {
            return back()->with('error', 'Permintaan ini sudah diproses sebelumnya.');
        }

        DB::transaction(function () use ($classMeetingChangeRequest) {
            $classMeetingChangeRequest->classMeeting->update([
                'meeting_date' => $classMeetingChangeRequest->requested_date,
            ]);

            $classMeetingChangeRequest->program->update([
                'active_class_meeting_id' => $classMeetingChangeRequest->class_meeting_id,
            ]);

            $classMeetingChangeRequest->update([
                'status' => 'approved',
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
            ]);
        });

        return back()->with('success', 'Perubahan jadwal jam kelas dikonfirmasi.');
    }

    public function rejectClassMeetingChangeRequest(ClassMeetingChangeRequest $classMeetingChangeRequest)
    {
        if ($classMeetingChangeRequest->status !== 'pending') {
            return back()->with('error', 'Permintaan ini sudah diproses sebelumnya.');
        }

        $classMeetingChangeRequest->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Permintaan perubahan jadwal ditolak.');
    }

    public function apiEvents(Request $request)
    {
        $this->syncClassPeriodMeetings();

        $start = $request->query('start');
        $end = $request->query('end');

        $query = ClassMeeting::with([
            'classPeriod' => function ($q) {
                $q->with('program', 'teacher')
                  ->withCount('users');
            }
        ]);

        if ($start) {
            $query->whereDate('meeting_date', '>=', Carbon::parse($start));
        }
        if ($end) {
            $query->whereDate('meeting_date', '<=', Carbon::parse($end));
        }

        // Also fetch meetings that don't have a meeting_date but have a start_time within range
        // Or we can just get all if range is not provided, though typically fullcalendar provides start and end.

        $meetings = $query->get();

        $events = $meetings->map(function ($meeting) {
            $classPeriod = $meeting->classPeriod;
            if (!$classPeriod) return null;

            $batchLabel = $classPeriod->batch_number ? "Batch {$classPeriod->batch_number}" : "";
            $title = trim($batchLabel . ' - ' . ($classPeriod->name ?: 'Class'));
            $title .= ' (M' . $meeting->meeting_number . ')';
            
            if ($meeting->topic) {
                $title .= ' - ' . $meeting->topic;
            }

            $dateStr = $meeting->meeting_date ? $meeting->meeting_date->format('Y-m-d') : null;
            $startStr = $meeting->start_time ? $meeting->start_time->format('H:i:s') : null;
            $endStr = $meeting->end_time ? $meeting->end_time->format('H:i:s') : null;

            $startIso = null;
            $endIso = null;

            if ($dateStr) {
                if ($startStr) {
                    $startIso = $dateStr . 'T' . $startStr;
                } else {
                    $startIso = $dateStr;
                }

                if ($endStr) {
                    $endIso = $dateStr . 'T' . $endStr;
                }
            } else if ($meeting->start_time) {
                $startIso = $meeting->start_time->toIso8601String();
                if ($meeting->end_time) {
                    $endIso = $meeting->end_time->toIso8601String();
                }
            }

            if (!$startIso) {
                return null;
            }

            $color = '#3B82F6'; // Default Blue
            if ($classPeriod->learning_mode === 'offline') {
                $color = '#8B5CF6'; // Purple
            } elseif ($classPeriod->status === 'completed') {
                $color = '#10B981'; // Emerald
            }

            return [
                'id' => $meeting->id,
                'title' => $title,
                'start' => $startIso,
                'end' => $endIso,
                'backgroundColor' => $color,
                'borderColor' => $color,
                'extendedProps' => [
                    'meeting_id' => $meeting->id,
                    'class_period_id' => $classPeriod->id,
                    'class_name' => $classPeriod->name,
                    'batch_number' => $classPeriod->batch_number,
                    'program_name' => $classPeriod->program ? $classPeriod->program->name : 'N/A',
                    'meeting_number' => $meeting->meeting_number,
                    'topic' => $meeting->topic,
                    'meeting_link' => $meeting->meeting_link,
                    'teacher_name' => $classPeriod->teacher ? $classPeriod->teacher->name : 'No Teacher',
                    'students_count' => $classPeriod->users_count ?? 0,
                    'learning_mode' => ucfirst($classPeriod->learning_mode ?? 'Online'),
                    'status' => ucfirst($classPeriod->status ?? 'Active'),
                ]
            ];
        })->filter();

        return response()->json(array_values($events->toArray()));
    }

    private function syncClassPeriodMeetings(): void
    {
        ClassPeriod::with(['program.meetings', 'classMeetings'])
            ->whereIn('status', ['active', 'upcoming'])
            ->chunkById(50, function ($classPeriods) {
                foreach ($classPeriods as $classPeriod) {
                    $programMeetings = $classPeriod->program?->meetings ?? collect();

                    if ($programMeetings->isEmpty()) {
                        $this->ensureClassMeeting($classPeriod, null, 1);
                        continue;
                    }

                    foreach ($programMeetings as $meeting) {
                        $this->ensureClassMeeting($classPeriod, $meeting, (int) ($meeting->meeting_number ?: 1));
                    }
                }
            });
    }

    private function ensureClassMeeting(ClassPeriod $classPeriod, ?Meeting $meeting, int $meetingNumber): void
    {
        $query = ClassMeeting::where('class_period_id', $classPeriod->id)
            ->where('meeting_number', $meetingNumber);

        if ($meeting) {
            $query->where(function ($q) use ($meeting) {
                $q->where('meeting_id', $meeting->id)
                    ->orWhereNull('meeting_id');
            });
        }

        $classMeeting = $query->first();

        $defaults = [
            'class_period_id' => $classPeriod->id,
            'meeting_id' => $meeting?->id,
            'meeting_number' => $meetingNumber,
            'topic' => $meeting?->title ?? 'Class Session',
            'meeting_date' => $this->resolveMeetingDate($classPeriod, $meetingNumber),
        ];

        if (!$classMeeting) {
            ClassMeeting::create($defaults);
            return;
        }

        $updates = [];

        if ($meeting && !$classMeeting->meeting_id) {
            $updates['meeting_id'] = $meeting->id;
        }

        if (!$classMeeting->topic && $defaults['topic']) {
            $updates['topic'] = $defaults['topic'];
        }

        if (!$classMeeting->meeting_date && $defaults['meeting_date']) {
            $updates['meeting_date'] = $defaults['meeting_date'];
        }

        if (!empty($updates)) {
            $classMeeting->update($updates);
        }
    }

    private function resolveMeetingDate(ClassPeriod $classPeriod, int $meetingNumber): ?Carbon
    {
        if (!$classPeriod->start_date) {
            return null;
        }

        $date = $classPeriod->start_date->copy()->addWeeks(max(0, $meetingNumber - 1));

        if ($classPeriod->end_date && $date->greaterThan($classPeriod->end_date)) {
            return $classPeriod->end_date->copy();
        }

        return $date;
    }

    public function update(Request $request, ClassMeeting $meeting)
    {
        $validated = $request->validate([
            'meeting_date' => 'nullable|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'topic' => 'nullable|string|max:255',
            'meeting_link' => 'nullable|url|max:1000',
        ]);

        $meetingDate = $validated['meeting_date'] ?? optional($meeting->meeting_date)->format('Y-m-d');

        if (!empty($validated['start_time']) && $meetingDate) {
            $meeting->start_time = Carbon::parse($meetingDate . ' ' . $validated['start_time']);
        } else {
            $meeting->start_time = null;
        }

        if (!empty($validated['end_time']) && $meetingDate) {
            $meeting->end_time = Carbon::parse($meetingDate . ' ' . $validated['end_time']);
        } else {
            $meeting->end_time = null;
        }
        
        if (isset($validated['meeting_date'])) {
            $meeting->meeting_date = $validated['meeting_date'];
        }

        if (array_key_exists('topic', $validated)) {
            $meeting->topic = $validated['topic'];
        }
        if (array_key_exists('meeting_link', $validated)) {
            $meeting->meeting_link = $validated['meeting_link'];
        }

        // Guard: reject the reschedule if it overlaps another meeting taught by the same teacher.
        if ($meeting->start_time && $meeting->end_time) {
            $teacherId = $meeting->classPeriod ? $meeting->classPeriod->teacher_id : null;

            if ($teacherId) {
                $conflict = ClassMeeting::whereHas('classPeriod', function ($query) use ($teacherId) {
                        $query->where('teacher_id', $teacherId);
                    })
                    ->where('id', '!=', $meeting->id)
                    ->whereNotNull('start_time')
                    ->whereNotNull('end_time')
                    ->where('start_time', '<', $meeting->end_time)
                    ->where('end_time', '>', $meeting->start_time)
                    ->exists();

                if ($conflict) {
                    return response()->json([
                        'message' => 'Jadwal ini bentrok dengan jadwal mengajar guru yang sama pada waktu tersebut.',
                    ], 422);
                }
            }
        }

        $meeting->save();

        return response()->json([
            'message' => 'Meeting updated successfully',
            'meeting' => $meeting
        ]);
    }
}
