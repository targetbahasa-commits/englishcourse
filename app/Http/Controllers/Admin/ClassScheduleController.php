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
                    'recording_urls' => $meeting->recording_urls ?? [],
                    'recording_passwords' => $meeting->recording_passwords ?? [],
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
            'recording_urls' => 'nullable|array',
            'recording_urls.*' => 'url|max:1000',
            'recording_passwords' => 'nullable|array',
            'recording_passwords.*.label' => 'nullable|string|max:100',
            'recording_passwords.*.password' => 'nullable|string|max:255',
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
        if (array_key_exists('recording_urls', $validated)) {
            $meeting->recording_urls = array_values(array_unique(array_filter($validated['recording_urls'] ?? [])));
        }
        if (array_key_exists('recording_passwords', $validated)) {
            $meeting->recording_passwords = array_values(array_filter(
                $validated['recording_passwords'] ?? [],
                fn ($entry) => !empty($entry['password'])
            ));
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

    /**
     * Lightweight sibling of update() for the inline "Tonton Rekaman Kelas"
     * editor on each program's meeting card grid (grammar-writing-track,
     * speaking-track, toefl-itp/ielts index pages) - admins AND teachers can
     * use this (route middleware is 'role:teacher', which also lets admins
     * through via RoleMiddleware's own top-level admin bypass), unlike the
     * full update() endpoint above which is admin-only. Keyed by
     * (meeting_id, class_period_id) rather than a ClassMeeting id, since a
     * card's ClassMeeting row may not have been created yet (it's normally
     * auto-seeded by syncClassPeriodMeetings() the first time an admin opens
     * the Class Schedule calendar - a teacher setting a recording link from
     * the card first shouldn't be blocked on that ever having happened).
     */
    public function updateRecordingLink(Request $request)
    {
        $validated = $request->validate([
            'meeting_id' => 'required|integer|exists:meetings,id',
            'class_period_id' => 'required|integer|exists:class_periods,id',
            'recording_urls' => 'nullable|array',
            'recording_urls.*' => 'url|max:1000',
            'recording_passwords' => 'nullable|array',
            'recording_passwords.*.label' => 'nullable|string|max:100',
            'recording_passwords.*.password' => 'nullable|string|max:255',
        ]);

        $classPeriod = ClassPeriod::findOrFail($validated['class_period_id']);
        $user = Auth::user();

        // Admins may edit any class period's link; a teacher may only edit
        // one they actually teach.
        if ($user->role !== 'admin' && $classPeriod->teacher_id !== $user->id) {
            abort(403, 'Anda tidak mengajar kelas ini.');
        }

        $meeting = Meeting::findOrFail($validated['meeting_id']);
        $urls = array_values(array_unique(array_filter($validated['recording_urls'] ?? [])));

        $attributes = [
            'recording_urls' => $urls,
            'meeting_number' => $meeting->meeting_number,
        ];
        // Only touch passwords if the caller actually sent the field - this
        // endpoint is also called from the "add another link" flow (which
        // never includes recording_passwords), and that request shouldn't
        // silently wipe out passwords saved earlier from the full Class
        // Schedule form or a previous password-only save here. The client
        // always resends the FULL current list on every add/remove (same
        // pattern as recording_urls above), so there's no separate
        // add/remove endpoint needed.
        if (array_key_exists('recording_passwords', $validated)) {
            $attributes['recording_passwords'] = array_values(array_filter(
                $validated['recording_passwords'] ?? [],
                fn ($entry) => !empty($entry['password'])
            ));
        }

        $classMeeting = ClassMeeting::updateOrCreate(
            ['class_period_id' => $classPeriod->id, 'meeting_id' => $meeting->id],
            $attributes
        );

        return response()->json([
            'message' => 'Link rekaman berhasil disimpan.',
            'recording_urls' => $classMeeting->recording_urls ?? [],
            'recording_passwords' => $classMeeting->recording_passwords ?? [],
        ]);
    }

    /**
     * Lightweight sibling of update() for the inline "Jam Kelas" (start/end
     * time) editor on each meeting card - same admin+teacher access as
     * updateRecordingLink() above, and reuses update()'s own
     * date+time-combining and same-teacher overlap guard. Only ever touches
     * an EXISTING ClassMeeting row (found by meeting_id + class_period_id) -
     * unlike the recording link editor, setting a time without a real
     * scheduled meeting_date wouldn't mean anything, and every meeting shown
     * on these cards already has its date auto-seeded by
     * syncClassPeriodMeetings(), so the card's own inline editor is only
     * ever rendered once a ClassMeeting row (and therefore a date) exists.
     */
    public function updateClassTime(Request $request)
    {
        $validated = $request->validate([
            'meeting_id' => 'required|integer|exists:meetings,id',
            'class_period_id' => 'required|integer|exists:class_periods,id',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
        ]);

        $classPeriod = ClassPeriod::findOrFail($validated['class_period_id']);
        $user = Auth::user();

        if ($user->role !== 'admin' && $classPeriod->teacher_id !== $user->id) {
            abort(403, 'Anda tidak mengajar kelas ini.');
        }

        $meeting = Meeting::findOrFail($validated['meeting_id']);

        $classMeeting = ClassMeeting::where('class_period_id', $classPeriod->id)
            ->where('meeting_id', $meeting->id)
            ->first();

        if (!$classMeeting || !$classMeeting->meeting_date) {
            return response()->json([
                'message' => 'Tanggal meeting ini belum diatur - atur tanggalnya dulu di Class Schedule.',
            ], 422);
        }

        $meetingDate = $classMeeting->meeting_date->format('Y-m-d');

        $newStartTime = !empty($validated['start_time']) ? Carbon::parse($meetingDate . ' ' . $validated['start_time']) : null;
        $newEndTime = !empty($validated['end_time']) ? Carbon::parse($meetingDate . ' ' . $validated['end_time']) : null;

        // Guard: reject if it overlaps another meeting taught by the same teacher.
        if ($newStartTime && $newEndTime && $classPeriod->teacher_id) {
            $conflict = ClassMeeting::whereHas('classPeriod', function ($query) use ($classPeriod) {
                    $query->where('teacher_id', $classPeriod->teacher_id);
                })
                ->where('id', '!=', $classMeeting->id)
                ->whereNotNull('start_time')
                ->whereNotNull('end_time')
                ->where('start_time', '<', $newEndTime)
                ->where('end_time', '>', $newStartTime)
                ->exists();

            if ($conflict) {
                return response()->json([
                    'message' => 'Jadwal ini bentrok dengan jadwal mengajar guru yang sama pada waktu tersebut.',
                ], 422);
            }
        }

        $classMeeting->start_time = $newStartTime;
        $classMeeting->end_time = $newEndTime;
        $classMeeting->save();

        return response()->json([
            'message' => 'Jam kelas berhasil disimpan.',
            'start_time' => $classMeeting->start_time?->format('H:i'),
            'end_time' => $classMeeting->end_time?->format('H:i'),
        ]);
    }
}
