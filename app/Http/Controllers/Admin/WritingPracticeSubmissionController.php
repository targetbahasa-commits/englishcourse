<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IeltsWritingDraft;
use App\Models\IeltsWritingPracticeSubmission;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WritingPracticeSubmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:teacher');
    }

    public function index(Request $request)
    {
        $query = IeltsWritingPracticeSubmission::with(['user.classPeriod', 'user.enrollments.classPeriod', 'meeting', 'reviewer']);

        $status = $request->query('status', 'all');
        if ($status === 'failed') {
            $query->where('evaluation_status', 'failed');
        } elseif ($status === 'success') {
            $query->where('evaluation_status', 'success');
        } elseif ($status === 'pending_review') {
            $query->whereNull('teacher_feedback');
        } elseif ($status === 'reviewed') {
            $query->whereNotNull('teacher_feedback');
        }

        if ($request->filled('task_type')) {
            $query->where('task_type', (int) $request->query('task_type'));
        }

        if ($request->filled('batch_id')) {
            $batchId = (int) $request->query('batch_id');
            $query->whereHas('user', function ($u) use ($batchId) {
                $u->where('class_period_id', $batchId)
                  ->orWhereHas('enrollments', function ($e) use ($batchId) {
                      $e->where('class_period_id', $batchId);
                  });
            });
        }

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('meeting', function ($m) use ($search) {
                    $m->where('title', 'like', "%{$search}%");
                })->orWhere('essay', 'like', "%{$search}%");
            });
        }

        $sort = $request->query('sort', 'latest');
        if ($sort === 'oldest') {
            $query->oldest('ielts_writing_practice_submissions.updated_at');
        } elseif ($sort === 'score_ai_desc') {
            $query->orderByRaw("CAST(COALESCE(JSON_UNQUOTE(JSON_EXTRACT(scores, '$.overall_band_score')), JSON_UNQUOTE(JSON_EXTRACT(scores, '$.overall_band')), '0') AS DECIMAL(3,1)) DESC");
        } elseif ($sort === 'score_ai_asc') {
            $query->orderByRaw("CAST(COALESCE(JSON_UNQUOTE(JSON_EXTRACT(scores, '$.overall_band_score')), JSON_UNQUOTE(JSON_EXTRACT(scores, '$.overall_band')), '99') AS DECIMAL(3,1)) ASC");
        } elseif ($sort === 'teacher_score_desc') {
            $query->orderByRaw("COALESCE(teacher_score, 0) DESC");
        } elseif ($sort === 'teacher_score_asc') {
            $query->orderByRaw("COALESCE(teacher_score, 99) ASC");
        } elseif ($sort === 'name_asc') {
            $query->join('users', 'users.id', '=', 'ielts_writing_practice_submissions.user_id')
                  ->orderBy('users.name', 'asc')
                  ->select('ielts_writing_practice_submissions.*');
        } elseif ($sort === 'name_desc') {
            $query->join('users', 'users.id', '=', 'ielts_writing_practice_submissions.user_id')
                  ->orderBy('users.name', 'desc')
                  ->select('ielts_writing_practice_submissions.*');
        } elseif ($sort === 'batch_asc') {
            $query->join('users', 'users.id', '=', 'ielts_writing_practice_submissions.user_id')
                  ->leftJoin('class_periods', 'class_periods.id', '=', 'users.class_period_id')
                  ->orderBy('class_periods.name', 'asc')
                  ->select('ielts_writing_practice_submissions.*');
        } elseif ($sort === 'batch_desc') {
            $query->join('users', 'users.id', '=', 'ielts_writing_practice_submissions.user_id')
                  ->leftJoin('class_periods', 'class_periods.id', '=', 'users.class_period_id')
                  ->orderBy('class_periods.name', 'desc')
                  ->select('ielts_writing_practice_submissions.*');
        } elseif ($sort === 'meeting_asc') {
            $query->orderBy('task_type', 'asc')->orderBy('meeting_id', 'asc');
        } elseif ($sort === 'meeting_desc') {
            $query->orderBy('task_type', 'desc')->orderBy('meeting_id', 'desc');
        } else {
            $query->latest('ielts_writing_practice_submissions.updated_at');
        }

        $submissions = $query->paginate(20)->withQueryString();

        $inProgressQuery = IeltsWritingDraft::whereNotExists(function ($q) {
            $q->select(DB::raw(1))
                ->from('ielts_writing_practice_submissions')
                ->whereColumn('ielts_writing_practice_submissions.user_id', 'ielts_writing_drafts.user_id')
                ->whereColumn('ielts_writing_practice_submissions.meeting_id', 'ielts_writing_drafts.meeting_id')
                ->whereColumn('ielts_writing_practice_submissions.task_type', 'ielts_writing_drafts.task_type');
        });

        $inProgressSubmissions = $inProgressQuery->with(['user', 'meeting'])
            ->orderByDesc('last_saved_at')
            ->limit(100)
            ->get()
            ->filter(function ($draft) {
                $answers = is_array($draft->answers) ? $draft->answers : json_decode($draft->answers, true);
                if (empty($answers)) return false;
                return collect($answers)->flatten()->contains(function ($v) {
                    return $v !== null && trim((string) $v) !== '';
                });
            });

        $stats = [
            'total' => IeltsWritingPracticeSubmission::count(),
            'success' => IeltsWritingPracticeSubmission::where('evaluation_status', 'success')->count(),
            'failed' => IeltsWritingPracticeSubmission::where('evaluation_status', 'failed')->count(),
            'reviewed' => IeltsWritingPracticeSubmission::whereNotNull('teacher_feedback')->count(),
            'inProgress' => $inProgressSubmissions->count(),
        ];

        $aiSetting = \App\Models\Setting::where('key', 'ielts_writing_ai_evaluation_enabled')->value('value');
        $aiEnabled = $aiSetting === null || $aiSetting === '1';

        $classPeriods = \App\Models\ClassPeriod::orderBy('name')->get();

        return view('admin.writing-practice-submissions.index', compact('submissions', 'status', 'stats', 'aiEnabled', 'classPeriods', 'inProgressSubmissions'));
    }

    public function show(IeltsWritingPracticeSubmission $submission)
    {
        $submission->load(['user', 'meeting', 'reviewer']);

        $aiSetting = \App\Models\Setting::where('key', 'ielts_writing_ai_evaluation_enabled')->value('value');
        $aiEnabled = $aiSetting === null || $aiSetting === '1';

        return view('admin.writing-practice-submissions.show', compact('submission', 'aiEnabled'));
    }

    public function toggleAi(Request $request)
    {
        $enabled = $request->input('enabled') ? '1' : '0';
        \App\Models\Setting::updateOrCreate(
            ['key' => 'ielts_writing_ai_evaluation_enabled'],
            ['value' => $enabled]
        );

        return response()->json([
            'status' => 'success',
            'ai_enabled' => $enabled === '1',
            'message' => $enabled === '1'
                ? 'Fitur Penilaian AI berhasil DIAKTIFKAN. Esai student akan dinilai otomatis oleh AI.'
                : 'Fitur Penilaian AI berhasil DINONAKTIFKAN. Pengajuan esai student akan langsung dialihkan ke lembar penilaian coret-coret pengajar.'
        ]);
    }

    public function saveReview(Request $request, IeltsWritingPracticeSubmission $submission)
    {
        $validated = $request->validate([
            'teacher_feedback'         => 'nullable|string|max:5000',
            'teacher_correction_html'  => 'nullable|string',
            'annotation_canvas_data'   => 'nullable|string',
            'task_achievement_score'   => 'nullable|numeric|min:0|max:9',
            'coherence_cohesion_score' => 'nullable|numeric|min:0|max:9',
            'lexical_resource_score'   => 'nullable|numeric|min:0|max:9',
            'grammatical_range_score'  => 'nullable|numeric|min:0|max:9',
            'feedback'                          => 'nullable|array',
            'feedback.task_achievement'         => 'nullable|string|max:2000',
            'feedback.coherence_cohesion'       => 'nullable|string|max:2000',
            'feedback.lexical_resource'         => 'nullable|string|max:2000',
            'feedback.grammatical_range'        => 'nullable|string|max:2000',
        ]);

        $scores = $submission->scores ?? [];

        if ($request->has('teacher_correction_html')) {
            $scores['teacher_correction_html'] = $request->input('teacher_correction_html');
        }

        if ($request->has('annotation_canvas_data')) {
            $scores['annotation_canvas_data'] = $request->input('annotation_canvas_data');
        }

        // Teacher/Admin can fill in or override the 4 IELTS band sub-scores directly
        // (important for manually-graded submissions where AI grading was skipped, and
        // for correcting an AI score the teacher disagrees with). A blank field leaves
        // whatever value (AI's or a prior teacher edit) already there untouched.
        $subScoreKeys = ['task_achievement_score', 'coherence_cohesion_score', 'lexical_resource_score', 'grammatical_range_score'];
        foreach ($subScoreKeys as $key) {
            if (isset($validated[$key]) && $validated[$key] !== '') {
                $scores[$key] = (float) $validated[$key];
            }
        }

        // Per-criterion feedback (alongside the general "teacher_feedback" field below)
        // shares the same scores.feedback[...] shape the AI grading already writes to,
        // so the student's existing result page picks these up with no extra display
        // work - a blank textarea leaves the AI's own text for that criterion untouched.
        $feedback = $scores['feedback'] ?? [];
        foreach (['task_achievement', 'coherence_cohesion', 'lexical_resource', 'grammatical_range'] as $key) {
            $value = $validated['feedback'][$key] ?? null;
            if ($value !== null && $value !== '') {
                $feedback[$key] = $value;
            }
        }
        if ($feedback !== []) {
            $scores['feedback'] = $feedback;
        }

        // Overall band is no longer typed in manually - it's derived from the 4
        // sub-scores above, using IELTS's standard rounding (nearest half band; .25
        // rounds up to .5, .75 rounds up to the next whole band). Only computed once
        // all 4 components have a value.
        $subScoreValues = array_map(fn ($key) => $scores[$key] ?? null, $subScoreKeys);
        $teacherScore = in_array(null, $subScoreValues, true)
            ? null
            : round((array_sum($subScoreValues) / 4) * 2) / 2;

        $submission->update([
            'teacher_feedback' => $validated['teacher_feedback'] ?? null,
            'teacher_score'    => $teacherScore,
            'scores'           => $scores,
            'reviewed_by'      => Auth::id(),
            'reviewed_at'      => now(),
        ]);

        return back()->with('success', 'Catatan, koreksi interaktif, dan hasil coretan pengajar berhasil disimpan!');
    }
}
