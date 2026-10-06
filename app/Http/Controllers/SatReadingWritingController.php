<?php

namespace App\Http\Controllers;

use App\Models\SatReadingWritingMeeting;
use App\Models\SatReadingWritingQuestion;
use App\Models\SatReadingWritingScore;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SatReadingWritingController extends Controller
{
    use HandlesAssignmentAccess;

    public function __construct()
    {
        $this->registerAssignmentAccessMiddleware();
    }

    /**
     * Display the list of SAT Reading & Writing meetings/lessons.
     */
    public function index()
    {
        $user = Auth::user();

        $meetings = SatReadingWritingMeeting::withCount('questions')
            ->orderBy('meeting_number')
            ->get();

        $scoresByMeeting = $user
            ? SatReadingWritingScore::where('user_id', $user->id)
                ->get()
                ->keyBy('meeting_number')
            : collect();

        $meetings->each(function ($meeting) use ($scoresByMeeting) {
            $userScore = $scoresByMeeting->get($meeting->meeting_number);
            $meeting->completed = ($userScore !== null);
            $meeting->user_score = $userScore ? $userScore->score : null;
        });

        return view('assignments.sat.reading-writing', [
            'meetings' => $meetings,
        ]);
    }

    /**
     * Show a specific SAT Reading & Writing meeting with interactive practice.
     */
    public function showMeeting(Request $request, int $number)
    {
        $user = Auth::user();

        if ($request->has('retry')) {
            SatReadingWritingScore::where('user_id', $user->id)
                ->where('meeting_number', $number)
                ->delete();

            return redirect()->route('assignments.sat.reading-writing.meeting', $number)
                ->with('info', 'Latihan telah direset. Silakan kerjakan kembali.');
        }

        $meeting = SatReadingWritingMeeting::with(['questions' => function ($query) {
            $query->orderBy('question_number');
        }])->where('meeting_number', $number)->firstOrFail();

        if ($meeting->is_locked && !$user->isAdmin() && !$user->isTeacher()) {
            return redirect()->route('assignments.sat.reading-writing')
                ->with('error', 'Meeting ini saat ini terkunci.');
        }

        $existingScore = SatReadingWritingScore::where('user_id', $user->id)
            ->where('meeting_number', $number)
            ->first();

        return view('assignments.sat.reading-writing-meeting', [
            'meeting' => $meeting,
            'questions' => $meeting->questions,
            'existingScore' => $existingScore,
        ]);
    }

    /**
     * Submit answers for a meeting and calculate score.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'meeting_number' => 'required|integer',
        ]);

        $user = Auth::user();
        $meetingNumber = $request->integer('meeting_number');

        $meeting = SatReadingWritingMeeting::with('questions')
            ->where('meeting_number', $meetingNumber)
            ->firstOrFail();

        $totalQuestions = $meeting->questions->count();
        if ($totalQuestions === 0) {
            return back()->with('error', 'Tidak ada soal dalam meeting ini.');
        }

        $correctCount = 0;
        $submittedAnswers = [];

        foreach ($meeting->questions as $question) {
            $submitted = $request->input('question_' . $question->id);
            if ($submitted !== null && $submitted !== '') {
                $submitted = strtoupper(trim((string)$submitted));
                $submittedAnswers[$question->id] = $submitted;

                if ($submitted === strtoupper(trim((string)$question->correct_answer))) {
                    $correctCount++;
                }
            } else {
                $submittedAnswers[$question->id] = null;
            }
        }

        $score = round(($correctCount / $totalQuestions) * 100, 2);

        SatReadingWritingScore::updateOrCreate(
            [
                'user_id' => $user->id,
                'meeting_number' => $meetingNumber,
            ],
            [
                'score' => $score,
                'correct_count' => $correctCount,
                'total_questions' => $totalQuestions,
                'answers' => $submittedAnswers,
            ]
        );

        return redirect()->route('assignments.sat.reading-writing.meeting', $meetingNumber)
            ->with('success', "Jawaban berhasil dikirim! Skor Anda: {$score} ({$correctCount}/{$totalQuestions} benar).");
    }

    /**
     * Admin: Store new meeting.
     */
    public function storeMeeting(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'meeting_number' => 'required|integer|unique:sat_reading_writing_meetings,meeting_number',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_locked' => 'nullable|boolean',
        ]);

        $validated['is_locked'] = $request->boolean('is_locked');

        SatReadingWritingMeeting::create($validated);

        return back()->with('success', 'Practice test SAT berhasil ditambahkan.');
    }

    /**
     * Admin: Toggle lock status of meeting.
     */
    public function toggleLock(SatReadingWritingMeeting $meeting)
    {
        $this->ensureAdmin();

        $meeting->update([
            'is_locked' => !$meeting->is_locked,
        ]);

        return back()->with('success', 'Status kunci practice test berhasil diperbarui.');
    }

    /**
     * Admin: Update meeting info.
     */
    public function updateMeeting(Request $request, SatReadingWritingMeeting $meeting)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $meeting->update($validated);

        return back()->with('success', 'Data practice test berhasil diperbarui.');
    }

    /**
     * Admin: Delete meeting.
     */
    public function destroyMeeting(SatReadingWritingMeeting $meeting)
    {
        $this->ensureAdmin();

        $meeting->delete();

        return back()->with('success', 'Practice test berhasil dihapus.');
    }

    /**
     * Admin: Store Question.
     */
    public function storeQuestion(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'meeting_id' => 'required|exists:sat_reading_writing_meetings,id',
            'question_number' => 'required|integer',
            'category' => 'nullable|string|max:100',
            'passage' => 'nullable|string',
            'question_prompt' => 'nullable|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'nullable|string',
            'correct_answer' => 'required|string|max:10',
            'explanation' => 'nullable|string',
        ]);

        $validated['correct_answer'] = strtoupper(trim($validated['correct_answer']));

        SatReadingWritingQuestion::create($validated);

        return back()->with('success', 'Soal berhasil ditambahkan.');
    }

    /**
     * Admin: Update Question.
     */
    public function updateQuestion(Request $request, SatReadingWritingQuestion $question)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'question_number' => 'required|integer',
            'category' => 'nullable|string|max:100',
            'passage' => 'nullable|string',
            'question_prompt' => 'nullable|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'nullable|string',
            'correct_answer' => 'required|string|max:10',
            'explanation' => 'nullable|string',
        ]);

        $validated['correct_answer'] = strtoupper(trim($validated['correct_answer']));

        $question->update($validated);

        return back()->with('success', 'Soal berhasil diperbarui.');
    }

    /**
     * Admin: Delete Question.
     */
    public function destroyQuestion(SatReadingWritingQuestion $question)
    {
        $this->ensureAdmin();

        $question->delete();

        return back()->with('success', 'Soal berhasil dihapus.');
    }

    private function ensureAdmin(): void
    {
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403, 'Akses terbatas untuk administrator.');
        }
    }
}
