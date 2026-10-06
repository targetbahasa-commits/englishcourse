<?php

namespace App\Http\Controllers;

use App\Application\GrammarWriting\BuildGrammarWritingIndexData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting2ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting3ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting4ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting6ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting10ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting11ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting12ViewData;
use App\Application\FinalTest\StudentFinalTestAccess;
use App\Application\GrammarWriting\Concerns\ScoresWordMatchAnswers;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting2Submission;
use App\Application\GrammarWriting\GrammarWritingDataRepository;
use App\Application\GrammarWriting\ManageGrammarWritingContent;
use App\Application\GrammarWriting\ManageGrammarWritingMeetings;
use App\Http\Requests\StoreGrammarQuestionRequest;
use App\Http\Requests\StoreGrammarVocabularyRequest;
use App\Http\Requests\UpdateAssignmentBatchPeriodRequest;
use App\Http\Requests\UpdateGrammarQuestionRequest;
use App\Http\Requests\UpdateGrammarVocabularyRequest;
use App\Http\Requests\UpdateGrammarWritingPeriodRequest;
use App\Models\GrammarQuestion;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Concerns\HasProficiencyMeetingContent;
use App\Http\Controllers\Concerns\HandlesLegacyGrammarWritingData;

class GrammarWritingAdminController extends Controller
{
    use ScoresWordMatchAnswers;
    use HasProficiencyMeetingContent;
    use HandlesLegacyGrammarWritingData;
    use \App\Http\Controllers\Concerns\EvaluatesClassPeriodEnd;
    use \App\Http\Controllers\Concerns\HandlesAssignmentAccess;

    /**
     * Persist a graded Introductory/Complexity/Proficiency track submission into
     * meeting_scores, reusing the same table the fast-track meeting system already
     * saves to (program_id disambiguates track vs fast-track, since meeting_number
     * ranges overlap). $answersData leaves must each include a 'user_answer' key so
     * the shared partials/grammar-writing-answers-tree.blade.php partial can render them.
     */
    private function persistGrammarTrackScore(int $meetingNumber, $score, string $programSlug, array $answersData): void
    {
        $user = Auth::user();
        if (!$user || !$user->isStudent()) {
            return;
        }

        $programId = \App\Models\Program::where('slug', $programSlug)->value('id') ?? $user->program_id;
        if (!$programId) {
            return;
        }

        $isReported = !$this->isStudentClassPeriodEnded($programSlug);

        \App\Models\MeetingScore::updateOrCreate(
            [
                'user_id' => $user->id,
                'meeting_number' => $meetingNumber,
                'program_id' => $programId,
                'is_reported' => $isReported,
            ],
            [
                'score' => $score,
                'is_reported' => $isReported,
                'submitted_at' => now(),
                'answers' => $answersData,
                'answers_data' => $answersData,
            ]
        );

        try {
            \App\Models\AssignmentDraft::updateOrCreate(
                ['user_id' => $user->id, 'program_id' => $programId, 'meeting_number' => $meetingNumber],
                ['answers' => $answersData, 'last_saved_at' => now()]
            );
        } catch (\Throwable $e) {}
    }

    /**
     * Track keys used for the per-meeting AI grading toggle (Setting key
     * "grammar_writing_ai_{track}_meeting_{meetingNumber}_enabled") and matching
     * Admin\AdminGrammarWritingReviewController::TRACKS. Fast-track is included
     * for UI consistency even though its current grading is pure exact/word-match
     * and never calls AI - toggling it has no effect on grading behavior.
     */
    public const AI_TOGGLE_TRACKS = ['fast-track', 'introductory', 'complexity', 'proficiency'];

    /**
     * Whether AI-assisted grading is enabled for the given track+meeting.
     * Toggle is per individual meeting (e.g. Introductory Meeting 1a can be
     * AI ON while Meeting 1b is AI OFF), not per whole track. Defaults to
     * enabled when no Setting row exists yet (matches the IELTS Writing AI
     * toggle convention). When disabled, submit handlers skip the AI call;
     * Introductory/Proficiency fall back to their existing deterministic
     * word-match scoring, while Complexity (which has no non-AI fallback)
     * scores 0 and waits for a teacher to fill in a manual score via the
     * Grammar Writing review page.
     *
     * Auto-override: an admin turning this off usually means "I'll grade
     * this meeting myself while the class is live" - but once the
     * SUBMITTING STUDENT's own batch has ended, no teacher is grading
     * anything for it anymore, so a manual-off setting would otherwise
     * leave every late/ended-batch submission stuck at a 0 "waiting for
     * manual review" that will never come. Forcing AI back on for that
     * student keeps them able to actually learn from feedback past their
     * batch's end date. This only ever fires for a real student submitting
     * their own work - isStudentClassPeriodEnded() returns false
     * immediately for any non-student caller (e.g. the admin/teacher
     * viewing the toggle badge itself), so the admin-facing toggle display
     * always still reflects the literal stored setting.
     */
    private function isGrammarWritingAiEnabled(string $track, int $meetingNumber): bool
    {
        $value = \App\Models\Setting::where('key', "grammar_writing_ai_{$track}_meeting_{$meetingNumber}_enabled")->value('value');

        if ($value === null || $value === '1') {
            return true;
        }

        return $this->isStudentClassPeriodEnded("{$track}-grammar-for-writing");
    }

    /**
     * GrammarWritingAdminController
     *
     * Handles all grammar-writing admin and management actions (CRUD, period, lock, batch updates).
     * Only grammar admins and teachers should access these endpoints.
     */
    protected function requireGrammarWritingAdminOrTeacher(): mixed
    {
        $user = Auth::user();

        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            abort(403);
        }

        return $user;
    }

    /**
     * Resolve the set of grammar program slugs the given user is enrolled in.
     * Includes both direct program_id assignment and active/completed enrollments.
     */
    private function resolveGrammarEnrolledSlugs(?\App\Models\User $user): array
    {
        if (!$user) {
            return [];
        }

        $slugs = [];

        if ($user->program_id && $user->program) {
            $slugs[] = $user->program->slug;
        }

        $enrollmentSlugs = $user->enrollments()
            ->with('program:id,slug')
            ->whereIn('status', ['active', 'completed'])
            ->get()
            ->pluck('program.slug')
            ->filter()
            ->toArray();

        $accessSlugs = $user->programAccesses()
            ->with('program:id,slug')
            ->get()
            ->pluck('program.slug')
            ->filter()
            ->toArray();

        return array_values(array_unique(array_merge($slugs, $enrollmentSlugs, $accessSlugs)));
    }

    public function updateBatchPeriod(UpdateAssignmentBatchPeriodRequest $request, ManageGrammarWritingMeetings $manageGrammarWritingMeetings)
    {
        $this->requireGrammarWritingAdminOrTeacher();

        $result = $manageGrammarWritingMeetings->updateBatchPeriod(
            $request->programId(),
            $request->classPeriodId(),
        );

        if (!$result['ok']) {
            return back()->with('error', $result['message']);
        }

        return back()->with('success', $result['message']);
    }

    public function updateActiveClassMeeting(\App\Http\Requests\UpdateActiveClassMeetingRequest $request, ManageGrammarWritingMeetings $manageGrammarWritingMeetings)
    {
        $user = $this->requireGrammarWritingAdminOrTeacher();

        $result = $manageGrammarWritingMeetings->updateActiveClassMeeting(
            $request->programId(),
            $request->classMeetingId(),
            $user,
        );

        if (!$result['ok']) {
            return back()->with('error', $result['message']);
        }

        return back()->with('success', $result['message']);
    }

    public function grammarWritingClasses(Request $request)
    {
        $user = Auth::user();
        $enrolledSlugs = $this->resolveGrammarEnrolledSlugs($user instanceof \App\Models\User ? $user : null);
        $isAdminOrTeacher = $user && ($user->isAdmin() || $user->isTeacher());

        // A student enrolled in the Offline sibling (e.g.
        // "introductory-grammar-for-writing-offline") has that exact slug in
        // $enrolledSlugs, not the online base slug checked below - without
        // stripping "-offline" here they'd see every tier as locked despite
        // being actively enrolled.
        $normalizedEnrolledSlugs = array_map(
            static fn (string $slug) => preg_replace('/-offline$/', '', $slug),
            $enrolledSlugs
        );

        $accessIntroductory = $isAdminOrTeacher || in_array('introductory-grammar-for-writing', $normalizedEnrolledSlugs);
        $accessComplexity   = $isAdminOrTeacher || in_array('complexity-grammar-for-writing', $normalizedEnrolledSlugs);
        $accessProficiency  = $isAdminOrTeacher || in_array('proficiency-grammar-for-writing', $normalizedEnrolledSlugs);
        $accessFastTrack    = $isAdminOrTeacher || in_array('fast-track-grammar-for-writing', $normalizedEnrolledSlugs);

        // Which delivery mode's tracks to link into next - carried through
        // from the Online/Offline tab on the assignments overview grid (see
        // assignments/index.blade.php) so the tiles below route into the
        // matching Online/Offline program's own schedule and lock-status
        // instead of always the Online one. grammarWritingTrack() below
        // re-derives this independently from the student's actual
        // enrollment, so a stale/missing mode here can't show a real
        // student the wrong class - this only drives which links to build.
        $mode = $request->query('mode') === 'offline' ? 'offline' : 'online';

        return view('assignments.grammar-writing-classes', compact(
            'accessIntroductory', 'accessComplexity', 'accessProficiency', 'accessFastTrack', 'isAdminOrTeacher', 'mode'
        ));
    }

    public function grammarWritingPractice()
    {
        $topics = \App\Models\GrammarTopic::orderBy('order')->get();

        if ($topics->isEmpty()) {
            $defaultTopics = [
                ['title' => 'Parts of Speech Dasar', 'desc' => 'Mengenal Nouns, Pronouns, Verbs, dan Adjectives.'],
                ['title' => 'Articles', 'desc' => ''],
                ['title' => 'Pronoun', 'desc' => ''],
                ['title' => 'Simple Present Verbal', 'desc' => 'Memahami fakta dan kebiasaan.'],
                ['title' => 'Simple Present Nominal', 'desc' => ''],
                ['title' => 'Simple Present Passive', 'desc' => ''],
                ['title' => 'Simple Present Verbal, Nominal, Passive', 'desc' => ''],
                ['title' => 'Simple Past Tense', 'desc' => 'Memahami kejadian masa lalu.'],
                ['title' => 'Simple Future Tense', 'desc' => 'Memahami rencana masa depan.'],
                ['title' => 'Present Continuous Tense', 'desc' => 'Memahami kegiatan yang sedang berlangsung.'],
                ['title' => 'Kalimat Dasar', 'desc' => 'Cara menyusun kalimat positif, negatif, dan tanya (interrogative).'],
                ['title' => 'Adverbs', 'desc' => ''],
                ['title' => 'Adjective', 'desc' => ''],
                ['title' => 'Prepositions', 'desc' => ''],
                ['title' => 'Conjunctions', 'desc' => ''],
                ['title' => 'Present Perfect Tense', 'desc' => 'Kejadian yang sudah selesai namun berkaitan dengan masa sekarang.'],
                ['title' => 'Past & Future Continuous Tense', 'desc' => 'Kejadian yang sedang berlangsung di masa lalu/depan.'],
                ['title' => 'Modals', 'desc' => 'Penggunaan can, could, should, must, might, would.'],
                ['title' => 'Negative Simple Present & Past Verbal', 'desc' => ''],
                ['title' => 'Interogative Sentence', 'desc' => ''],
                ['title' => 'Comparative & Superlative', 'desc' => 'Cara membandingkan sifat (contoh: bigger, biggest).'],
                ['title' => 'Positive Degree', 'desc' => ''],
                ['title' => 'Passive Voice', 'desc' => 'Mengubah kalimat aktif menjadi pasif'],
                ['title' => 'Advanced Tenses', 'desc' => 'Past Perfect, Future Perfect, dan semua bentuk Perfect Continuous.'],
                ['title' => 'Conditional Sentences', 'desc' => 'Kalimat pengandaian tipe 0, 1, 2, dan 3.'],
                ['title' => 'Direct & Indirect Speech', 'desc' => 'Cara mengubah kalimat kutipan langsung menjadi tidak langsung.'],
                ['title' => 'Relative Pronoun as Subject Clauses', 'desc' => 'Menggunakan kata hubung who, which, that, whom, whose.'],
                ['title' => 'Relative Pronoun as Object', 'desc' => ''],
                ['title' => 'Relative Pronoun as Possesive', 'desc' => ''],
                ['title' => 'Relative Adverb', 'desc' => ''],
                ['title' => 'Using Quantity and Quality', 'desc' => ''],
                ['title' => 'Indefinite Quantity', 'desc' => ''],
                ['title' => 'Suffixes', 'desc' => ''],
                ['title' => 'Prefixes', 'desc' => ''],
                ['title' => 'Regular Vs Irregular Verb', 'desc' => ''],
                ['title' => 'Participle', 'desc' => ''],
                ['title' => 'Noun Phrase', 'desc' => ''],
                ['title' => 'Conditional Sentence', 'desc' => ''],
                ['title' => 'Gerunds', 'desc' => ''],
                ['title' => 'To Infinitives', 'desc' => 'Aturan penggunaan kata kerja dengan -ing atau to + verb.'],
                ['title' => 'Subjunctive & Inversion', 'desc' => 'Struktur kalimat yang lebih formal dan kompleks.'],
                ['title' => 'Adverbial Clause', 'desc' => ''],
                ['title' => 'Noun Clause', 'desc' => ''],
                ['title' => 'Reducing', 'desc' => ''],
                ['title' => 'Abridgement', 'desc' => ''],
                ['title' => 'Omitting', 'desc' => ''],
            ];

            foreach ($defaultTopics as $index => $topic) {
                \App\Models\GrammarTopic::create([
                    'title' => $topic['title'],
                    'desc' => $topic['desc'],
                    'order' => $index + 1
                ]);
            }
        }

        $user = Auth::user();
        $enrolledSlugs = $this->resolveGrammarEnrolledSlugs($user instanceof \App\Models\User ? $user : null);

        $isAdminOrTeacher = $user && ($user->isAdmin() || $user->isTeacher());

        // Fast Track is its own standalone track — but it grants access to All Grammar Practice
        // Each track is only accessible if the student is enrolled in that specific program.
        $accessIntroductory = $isAdminOrTeacher || in_array('introductory-grammar-for-writing', $enrolledSlugs);
        $accessComplexity   = $isAdminOrTeacher || in_array('complexity-grammar-for-writing', $enrolledSlugs);
        $accessProficiency  = $isAdminOrTeacher || in_array('proficiency-grammar-for-writing', $enrolledSlugs);
        $accessAll = $isAdminOrTeacher || in_array('fast-track-grammar-for-writing', $enrolledSlugs);

        return view('assignments.grammar-writing-practice', compact(
            'topics', 'accessIntroductory', 'accessComplexity', 'accessProficiency', 'accessAll'
        ));
    }

    public function grammarWritingPracticeReorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|exists:grammar_topics,id',
            'order.*.order' => 'required|integer',
        ]);

        foreach ($request->order as $item) {
            \App\Models\GrammarTopic::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }

    public function grammarWritingPracticeUpdate(Request $request, \App\Models\GrammarTopic $topic)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'nullable|string',
        ]);

        $topic->update($request->only('title', 'desc'));

        return response()->json(['success' => true]);
    }

    public function grammarWritingPracticeStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'nullable|string',
        ]);

        $maxOrder = \App\Models\GrammarTopic::max('order') ?? 0;

        \App\Models\GrammarTopic::create([
            'title' => $request->title,
            'desc' => $request->desc,
            'order' => $maxOrder + 1,
        ]);

        return response()->json(['success' => true]);
    }

    public function grammarWritingPracticeDestroy(\App\Models\GrammarTopic $topic)
    {
        $topic->delete();
        return response()->json(['success' => true]);
    }

    public function grammarWritingPracticeQuestionStore(Request $request, \App\Models\GrammarTopic $topic)
    {
        $request->validate([
            'type' => 'required|in:sentence,paragraph',
            'question_id' => 'required|string',
            'answer_en' => 'required|string',
            'vocab_helper' => 'nullable|string',
            'example' => 'nullable|string',
        ]);

        $vocabHelper = null;
        if ($request->vocab_helper) {
            $vocabHelper = json_decode($request->vocab_helper, true);
        }

        $example = null;
        if ($request->example) {
            $example = json_decode($request->example, true);
        }

        $order = $topic->questions()->max('order') + 1;

        $topic->questions()->create([
            'type' => $request->type,
            'question_id' => $request->question_id,
            'answer_en' => $request->answer_en,
            'vocab_helper' => $vocabHelper,
            'example' => $example,
            'order' => $order,
        ]);

        return redirect()->back()->with('success', 'Soal berhasil ditambahkan.');
    }

    public function grammarWritingPracticeQuestionUpdate(Request $request, \App\Models\GrammarTopicQuestion $question)
    {
        $request->validate([
            'question_id' => 'required|string',
            'answer_en' => 'required|string',
            'vocab_helper' => 'nullable|string',
            'example' => 'nullable|string',
        ]);

        $vocabHelper = null;
        if ($request->vocab_helper) {
            $vocabHelper = json_decode($request->vocab_helper, true);
        }

        $example = null;
        if ($request->example) {
            $example = json_decode($request->example, true);
        }

        $question->update([
            'question_id' => $request->question_id,
            'answer_en' => $request->answer_en,
            'vocab_helper' => $vocabHelper,
            'example' => $example,
        ]);

        return redirect()->back()->with('success', 'Soal berhasil diperbarui.');
    }

    public function grammarWritingPracticeQuestionDestroy(\App\Models\GrammarTopicQuestion $question)
    {
        $question->delete();
        return redirect()->back()->with('success', 'Soal berhasil dihapus.');
    }

    public function grammarWritingPracticeTopic(\App\Models\GrammarTopic $topic)
    {
        $questions = $topic->questions;
        $sentences = $questions->where('type', 'sentence')->values();
        $paragraph = $questions->where('type', 'paragraph')->first();

        $sessionKey = 'practice_topic_' . $topic->id;
        $submitted = session($sessionKey . '_submitted', false);
        $userAnswers = session($sessionKey . '_answers', []);
        $results = session($sessionKey . '_results', []);
        $finalScore = session($sessionKey . '_score', 0);

        return view('assignments.grammar-writing-practice-topic', compact(
            'topic', 'sentences', 'paragraph', 'submitted', 'userAnswers', 'results', 'finalScore'
        ));
    }

    use \App\Application\GrammarWriting\Concerns\ScoresWordMatchAnswers;

    public function grammarWritingPracticeTopicSubmit(Request $request, \App\Models\GrammarTopic $topic)
    {
        $questions = $topic->questions;
        $userAnswers = $request->input('userAnswers', []);
        
        $results = ['sentences' => [], 'paragraph' => null];
        $totalScore = 0;
        $totalItems = count($questions);

        if ($totalItems === 0) {
            return back()->with('error', 'Belum ada soal untuk dinilai.');
        }

        $aiItems = [];
        foreach ($questions as $idx => $q) {
            $key = $q->type === 'sentence' ? "sentence_{$idx}" : 'paragraph';
            $userAns = $q->type === 'sentence' ? ($userAnswers['sentences'][$idx] ?? '') : ($userAnswers['paragraph'] ?? '');
            $aiItems[] = ['id' => $key, 'correct_answer' => $q->answer_en, 'user_answer' => $userAns];
        }
        $aiScores = $this->gradeItemsWithAi($aiItems);

        foreach ($questions as $idx => $q) {
            $key = $q->type === 'sentence' ? "sentence_{$idx}" : 'paragraph';
            $userAns = $q->type === 'sentence' ? ($userAnswers['sentences'][$idx] ?? '') : ($userAnswers['paragraph'] ?? '');

            $eval = $this->evaluateAnswer($userAns, $q->answer_en);
            if ($aiScores && isset($aiScores[$key])) {
                // AI score is already 0-100, matching evaluateAnswer's maxScore=100.
                $eval['score'] = round($aiScores[$key]['score']);
                $eval['ai_feedback'] = $aiScores[$key]['feedback'];
                $eval['graded_by'] = 'ai';
            } else {
                $eval['graded_by'] = 'deterministic';
            }

            if ($q->type === 'sentence') {
                $results['sentences'][$idx] = $eval;
            } else {
                $results['paragraph'] = $eval;
            }
            $totalScore += $eval['score'];
        }

        $finalScore = round($totalScore / $totalItems);

        $sessionKey = 'practice_topic_' . $topic->id;
        session([
            $sessionKey . '_submitted' => true,
            $sessionKey . '_answers' => $userAnswers,
            $sessionKey . '_results' => $results,
            $sessionKey . '_score' => $finalScore
        ]);

        return redirect()->route('assignments.grammar-writing.practice.topic', $topic->id)
                         ->with('success', 'Jawaban berhasil disubmit!');
    }

    private function evaluateAnswer(string $userTranslation, string $correctAnswer): array
    {
        return $this->scoreWordMatchAnswer($userTranslation, $correctAnswer, 100);
    }

    /**
     * Batch AI-grade a set of grammar answers, judging grammatical correctness
     * and paraphrase-equivalence rather than exact word overlap (which unfairly
     * penalizes valid alternate phrasing). One AI call grades every item in
     * the submission at once, rather than one call per sentence.
     *
     * Deterministic word-match/similar_text scoring and its diff HTML are
     * still always computed by the caller for display purposes - this only
     * supplies a better-informed numeric score on top, and is meant to be
     * used with graceful per-item fallback: if this returns null (all AI
     * providers failed) or a given id is missing from the result, the caller
     * keeps the deterministic score for that item unchanged.
     *
     * @param  array<int, array{id: string, correct_answer: string, user_answer: string}>  $items
     * @return array<string, array{score: float, feedback: ?string}>|null  Keyed by item id
     */
    private function gradeItemsWithAi(array $items): ?array
    {
        if (empty($items)) {
            return null;
        }

        $itemsJson = json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $systemPrompt = 'You are a strict English grammar examiner API that strictly outputs JSON.';
        $userPrompt = "Grade each of the following English grammar practice answers on a 0-100 scale. For each "
            . "item, judge whether the candidate's user_answer is grammatically correct AND conveys the same "
            . "meaning as correct_answer (correct_answer may list multiple acceptable variants separated by '|' - "
            . "matching any one variant counts as fully correct). Valid paraphrases or equivalent correct phrasing "
            . "should score well, not just exact word matches, but genuinely wrong or ungrammatical answers must "
            . "score low. An empty user_answer must score 0.\n\nItems:\n{$itemsJson}\n\n"
            . "Return ONLY a valid JSON object, no markdown: {\"results\": [{\"id\": \"...\", \"score\": 85, "
            . "\"feedback\": \"one short sentence in Bahasa Indonesia explaining the score\"}, ...]}. "
            . "score is an integer 0-100. Include exactly one entry per item, matching each item's id.";

        $providers = ['sambanova', 'groq', 'siliconflow', 'gemini', 'openai'];
        $decoded = \App\Services\MultiProviderAiClient::chatJson($providers, $systemPrompt, $userPrompt, [
            'groq_feature' => 'writing',
            'temperature' => 0.2,
        ]);

        if (!$decoded || !isset($decoded['results']) || !is_array($decoded['results'])) {
            return null;
        }

        $map = [];
        foreach ($decoded['results'] as $r) {
            if (isset($r['id'])) {
                $map[(string) $r['id']] = [
                    'score' => max(0, min(100, (float) ($r['score'] ?? 0))),
                    'feedback' => $r['feedback'] ?? null,
                ];
            }
        }

        return $map;
    }

    public function grammarWritingPracticeTopicReset(\App\Models\GrammarTopic $topic)
    {
        $sessionKey = 'practice_topic_' . $topic->id;
        session()->forget([
            $sessionKey . '_submitted',
            $sessionKey . '_answers',
            $sessionKey . '_results',
            $sessionKey . '_score'
        ]);

        return redirect()->route('assignments.grammar-writing.practice.topic', $topic->id);
    }

    public function grammarWritingPracticeLevel($level)
    {
        $user = Auth::user();
        $enrolledSlugs = $this->resolveGrammarEnrolledSlugs($user instanceof \App\Models\User ? $user : null);

        $isAdminOrTeacher = $user && ($user->isAdmin() || $user->isTeacher());

        // Fast Track grants access to All Grammar Practice, which includes every
        // individual level - not just the combined "all" view. A Fast Track-only
        // enrollee must be able to open Introductory/Complexity/Proficiency
        // directly too, otherwise they hit a false "not enrolled" lock despite
        // having paid for full access.
        $hasFastTrack = $isAdminOrTeacher || in_array('fast-track-grammar-for-writing', $enrolledSlugs);
        $access = [
            'introductory' => $hasFastTrack || in_array('introductory-grammar-for-writing', $enrolledSlugs),
            'complexity'   => $hasFastTrack || in_array('complexity-grammar-for-writing', $enrolledSlugs),
            'proficiency'  => $hasFastTrack || in_array('proficiency-grammar-for-writing', $enrolledSlugs),
        ];
        $access['all'] = $hasFastTrack;

        if (!$isAdminOrTeacher && (!isset($access[$level]) || !$access[$level])) {
            return redirect()->route('assignments.grammar-writing.practice')->with('error', 'Anda tidak memiliki akses ke level practice ini. Silakan mendaftar program yang sesuai.');
        }

        $titles = [
            'introductory' => 'Introductory Practice',
            'complexity' => 'Complexity Practice',
            'proficiency' => 'Proficiency Practice',
            'all' => 'All Grammar Practice',
        ];
        
        $title = $titles[$level] ?? 'Practice';
        $desc = 'Latihan untuk ' . $title . ' sedang disiapkan.';
        $topics = \App\Models\GrammarTopic::orderBy('order')->get();
        
        if ($level === 'introductory') {
            // Use DB-stored intro topics if available, otherwise fall back to hardcoded catalog
            $dbIntroTopics = \App\Models\GrammarIntroTopic::orderBy('order')->get();
            if ($dbIntroTopics->isNotEmpty()) {
                $availableTopics = $dbIntroTopics->pluck('topic');
                $introTopics = $dbIntroTopics;
            } else {
                $availableTopics = collect($this->introductoryMeetingCatalog())->pluck('topic');
                $introTopics = collect($this->introductoryMeetingCatalog())->map(fn($t, $i) => (object)[
                    'id' => null,
                    'label' => $t['label'],
                    'topic' => $t['topic'],
                    'grammar_rules' => '',
                    'order' => $i + 1,
                ]);
            }
        } elseif ($level === 'complexity') {
            $availableTopics = collect($this->complexityMeetingCatalog())->pluck('topic');
            $introTopics = collect($this->complexityMeetingCatalog())->map(fn($t, $i) => (object)[
                'id' => null,
                'label' => 'Meeting ' . ($i + 1),
                'topic' => $t['topic'],
                'grammar_rules' => '',
                'order' => $i + 1,
            ]);
        } elseif ($level === 'proficiency') {
            $availableTopics = collect($this->buildProficiencyTrackMeetings())->pluck('topic');
            $introTopics = collect($this->buildProficiencyTrackMeetings())->map(fn($t, $i) => (object)[
                'id' => null,
                'label' => 'Meeting ' . ($i + 1),
                'topic' => $t['topic'],
                'grammar_rules' => '',
                'order' => $i + 1,
            ]);
        } else {
            // For 'all' level, merge introductory (from DB if exists, else catalog), complexity, and proficiency
            $dbIntroTopics = \App\Models\GrammarIntroTopic::orderBy('order')->get();
            $introAvailable = $dbIntroTopics->isNotEmpty() ? $dbIntroTopics->pluck('topic') : collect($this->introductoryMeetingCatalog())->pluck('topic');
            $complexityAvailable = collect($this->complexityMeetingCatalog())->pluck('topic');
            $proficiencyAvailable = collect($this->buildProficiencyTrackMeetings())->pluck('topic');
            
            $availableTopics = collect(['Mix'])->merge($introAvailable)->merge($complexityAvailable)->merge($proficiencyAvailable)->unique()->values();
            
            $introTopics = \App\Models\GrammarIntroTopic::orderBy('order')->get();
        }

        $availableTopics = collect($availableTopics)
            ->flatMap(function ($t) {
                if (strtolower(trim((string)$t)) === 'abridgement and omitting') {
                    return ['Abridgement', 'Omitting'];
                }
                return [$t];
            })
            ->reject(fn($t) => in_array(strtolower(trim((string)$t)), ['exam', 'examination']))
            ->unique()
            ->values();
        
        return view('assignments.grammar-writing-practice-level', compact('title', 'desc', 'level', 'topics', 'availableTopics', 'introTopics'));
    }

    // ============================================================
    // Admin CRUD for Grammar Intro Topics
    // ============================================================

    public function grammarWritingIntroTopics()
    {
        $this->requireGrammarWritingAdminOrTeacher();
        $topics = \App\Models\GrammarIntroTopic::orderBy('order')->get();

        // Seed from hardcoded catalog if empty
        if ($topics->isEmpty()) {
            foreach ($this->introductoryMeetingCatalog() as $index => $item) {
                \App\Models\GrammarIntroTopic::create([
                    'label' => $item['label'],
                    'topic' => $item['topic'],
                    'grammar_rules' => '',
                    'order' => $index + 1,
                ]);
            }
            $topics = \App\Models\GrammarIntroTopic::orderBy('order')->get();
        }

        return response()->json($topics);
    }

    public function grammarWritingIntroTopicStore(Request $request)
    {
        $this->requireGrammarWritingAdminOrTeacher();
        $request->validate([
            'label' => 'required|string|max:20',
            'topic' => 'required|string|max:255',
            'grammar_rules' => 'nullable|string',
        ]);

        $maxOrder = \App\Models\GrammarIntroTopic::max('order') ?? 0;

        $topic = \App\Models\GrammarIntroTopic::create([
            'label' => $request->label,
            'topic' => $request->topic,
            'grammar_rules' => $request->grammar_rules ?? '',
            'order' => $maxOrder + 1,
        ]);

        return response()->json(['success' => true, 'topic' => $topic]);
    }

    public function grammarWritingIntroTopicUpdate(Request $request, \App\Models\GrammarIntroTopic $topic)
    {
        $this->requireGrammarWritingAdminOrTeacher();
        $request->validate([
            'label' => 'required|string|max:20',
            'topic' => 'required|string|max:255',
            'grammar_rules' => 'nullable|string',
        ]);

        $topic->update([
            'label' => $request->label,
            'topic' => $request->topic,
            'grammar_rules' => $request->grammar_rules ?? '',
        ]);

        return response()->json(['success' => true, 'topic' => $topic]);
    }

    public function grammarWritingIntroTopicDestroy(\App\Models\GrammarIntroTopic $topic)
    {
        $this->requireGrammarWritingAdminOrTeacher();
        $topic->delete();
        return response()->json(['success' => true]);
    }

    public function grammarWritingIntroTopicReorder(Request $request)
    {
        $this->requireGrammarWritingAdminOrTeacher();
        $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|exists:grammar_intro_topics,id',
            'order.*.order' => 'required|integer',
        ]);

        foreach ($request->order as $item) {
            \App\Models\GrammarIntroTopic::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }

    public function grammarWritingTrack(Request $request, string $track, BuildGrammarWritingIndexData $buildGrammarWritingIndexData, StudentFinalTestAccess $studentFinalTestAccess)
    {
        $trackData = $this->grammarWritingTracks()[$track] ?? null;

        abort_if($trackData === null, 404);

        $user = Auth::user();
        $isAdminOrTeacher = $user && ($user->isAdmin() || $user->isTeacher());
        $baseProgramSlug = $trackData['program_slug'];
        $offlineProgramSlug = $baseProgramSlug . '-offline';

        // Online and Offline can run on completely different batches/schedules
        // and meeting-lock states (see BuildGrammarWritingIndexData, which
        // resolves the student's class period from this exact slug) - so a
        // student enrolled in the Offline sibling must be routed to that
        // program, not the Online base slug this track normally points to.
        $resolvedProgramSlug = $baseProgramSlug;

        if (!$isAdminOrTeacher && $user?->isStudent()) {
            $enrolledSlugs = $this->resolveGrammarEnrolledSlugs($user);
            if (in_array($offlineProgramSlug, $enrolledSlugs, true)) {
                $resolvedProgramSlug = $offlineProgramSlug;
            } elseif (!in_array($baseProgramSlug, $enrolledSlugs, true)) {
                return redirect()->route('assignments.grammar-writing.classes')
                    ->with('error', 'Anda tidak memiliki akses ke track ini. Silakan daftar program yang sesuai.');
            }
        } elseif ($isAdminOrTeacher && $request->query('mode') === 'offline') {
            // Admin/teacher have no enrollment to key off - honor whichever
            // tab (Online/Offline) they browsed in from, so previewing from
            // the Offline tab actually shows the Offline class.
            $resolvedProgramSlug = $offlineProgramSlug;
        }

        if ($resolvedProgramSlug !== $baseProgramSlug && !\App\Models\Program::where('slug', $resolvedProgramSlug)->exists()) {
            $resolvedProgramSlug = $baseProgramSlug;
        }

        $indexData = $buildGrammarWritingIndexData->handle(
            $user,
            $resolvedProgramSlug
        );

        $aiEnabledByMeeting = [];
        if ($isAdminOrTeacher) {
            foreach ($trackData['meetings'] as $meetingRow) {
                $meetingNumber = $meetingRow['source_meeting_number'];
                $aiEnabledByMeeting[$meetingNumber] = $this->isGrammarWritingAiEnabled($track, $meetingNumber);
            }
        }

        // Once a student has finished every meeting in this track, surface a
        // link straight to this track's Final Test (same variant slug the
        // final-test.show route already expects: introductory/complexity/
        // proficiency/fast-track) instead of making them find it themselves
        // via the separate Final Test menu.
        $hasCompletedAllMeetings = $user && $user->isStudent() && $indexData['program']
            ? $studentFinalTestAccess->hasCompletedAllMeetings($user, $indexData['program']->id)
            : false;

        $allMeetingsUnlocked = true;
        if (isset($indexData['program']) && $indexData['program']->meetings->isNotEmpty()) {
            foreach ($trackData['meetings'] as $meetingRow) {
                if (!empty($meetingRow['is_bonus'])) {
                    continue;
                }
                $dbMeeting = $indexData['program']->meetings->firstWhere('meeting_number', $meetingRow['source_meeting_number']);
                if (!$dbMeeting || $dbMeeting->is_locked || empty($meetingRow['available'])) {
                    $allMeetingsUnlocked = false;
                    break;
                }
            }
        } else {
            $allMeetingsUnlocked = false;
        }

        return view('assignments.grammar-writing-track', array_merge(
            $indexData,
            [
                'track' => $track,
                'trackData' => $trackData,
                'aiEnabledByMeeting' => $aiEnabledByMeeting,
                'hasCompletedAllMeetings' => $hasCompletedAllMeetings,
                'allMeetingsUnlocked' => $allMeetingsUnlocked,
            ]
        ));
    }

    public function grammarWritingIntroductoryMeeting(int $meeting, bool $isInternalCall = false)
    {
        $user = Auth::user();
        $isAdminOrTeacher = $user && ($user->isAdmin() || $user->isTeacher());

        if (!$isInternalCall && !$isAdminOrTeacher && request()->is('promo/test/*')) {
            return $this->grammarWritingIntroductoryMeetingPromo(request(), $meeting);
        }

        if (!$isAdminOrTeacher && $user?->isStudent()) {
            $enrolledSlugs = $this->resolveGrammarEnrolledSlugs($user);
            if (!in_array('introductory-grammar-for-writing', $enrolledSlugs, true)) {
                return redirect()->route('assignments.grammar-writing.classes')
                    ->with('error', 'Anda tidak memiliki akses ke kelas Introductory Grammar for Writing.');
            }
        }

        if (!$isInternalCall) {
            $this->maybeRecordAttendanceForAssignmentAccess($user, 'grammar-for-writing', request());
        }

        $introductoryMeetings = $this->introductoryMeetingCatalog();
        $meetingData = $introductoryMeetings[$meeting - 1] ?? null;

        abort_if($meetingData === null, 404);

        $resolvedMeetingContent = $this->resolveIntroductoryMeetingContent($meeting);
        $resolvedParagraphContent = $this->resolveIntroductoryMeetingParagraph($meeting);

        $submitted = false;
        $score = null;
        $results = [];
        $userAnswers = [];
        $userParagraphAnswer = '';
        $paragraphResult = null;
        $draftAnswers = session("introductory_meeting{$meeting}_draft_answers", []);
        $draftParagraphAnswer = session("introductory_meeting{$meeting}_draft_paragraph_answer", '');

        if ($user) {
            try {
                $programId = \App\Models\Program::where('slug', 'introductory-grammar-for-writing')->value('id') ?? $user->program_id;
                if ($programId) {
                    $scoreRecord = \App\Models\MeetingScore::where('user_id', $user->id)
                        ->where('program_id', $programId)
                        ->where('meeting_number', $meeting)
                        ->latest('submitted_at')
                        ->first();

                    if ($scoreRecord) {
                        $submitted = true;
                        $score = $scoreRecord->score;
                        $scoreData = is_array($scoreRecord->answers) ? $scoreRecord->answers : json_decode($scoreRecord->answers ?? '[]', true);
                        if (!empty($scoreData)) {
                            $results = $scoreData['results'] ?? [];
                            $paragraphResult = $scoreData['paragraph_result'] ?? null;
                            $userAnswers = $scoreData['user_answers'] ?? [];
                            $userParagraphAnswer = $scoreData['user_paragraph_answer'] ?? ($scoreData['paragraph_answer'] ?? '');
                        }
                    }

                    if (empty($draftAnswers) && empty($userAnswers)) {
                        $draft = \App\Models\AssignmentDraft::where('user_id', $user->id)
                            ->where('program_id', $programId)
                            ->where('meeting_number', $meeting)
                            ->first();
                        if ($draft && is_array($draft->answers)) {
                            $savedDraft = $draft->answers;
                            if (isset($savedDraft['paragraph_answer'])) {
                                if ($draftParagraphAnswer === '' && $userParagraphAnswer === '') {
                                    $draftParagraphAnswer = (string) $savedDraft['paragraph_answer'];
                                }
                                unset($savedDraft['paragraph_answer']);
                            }
                            $draftAnswers = $savedDraft;
                        }
                    }
                }
            } catch (\Throwable $e) {}
        }

        return view('assignments.grammar-writing-introductory-meeting', [
            'meetingNumber' => $meeting,
            'meetingLabel' => $meetingData['label'],
            'topic' => $meetingData['topic'],
            'trackTitle' => 'Introductory Grammar for Writing',
            'questions' => $resolvedMeetingContent['questions'],
            'questionHelpers' => $this->introductoryMeetingQuestionHelpers($meeting),
            'cheatSheet' => $this->introductoryMeetingCheatSheet($meeting),
            'questionEditorData' => $resolvedMeetingContent['editorData'],
            'submitted' => $submitted,
            'score' => $score,
            'results' => $results,
            'userAnswers' => $userAnswers,
            'meeting11Answers' => [],
            'paragraphData' => $resolvedParagraphContent['paragraphData'],
            'paragraphEditorData' => $resolvedParagraphContent['editorData'],
            'userParagraphAnswer' => $userParagraphAnswer,
            'paragraphResult' => $paragraphResult,
            'draftAnswers' => !empty($userAnswers) ? $userAnswers : $draftAnswers,
            'draftParagraphAnswer' => $userParagraphAnswer !== '' ? $userParagraphAnswer : $draftParagraphAnswer,
        ]);
    }

    public function grammarWritingIntroductoryMeetingSubmit(Request $request, int $meeting)
    {
        $introductoryMeetings = $this->introductoryMeetingCatalog();
        $meetingData = $introductoryMeetings[$meeting - 1] ?? null;

        abort_if($meetingData === null, 404);

        $resolvedMeetingContent = $this->resolveIntroductoryMeetingContent($meeting);
        $questions = $resolvedMeetingContent['questions'];
        $questionHelpers = $this->introductoryMeetingQuestionHelpers($meeting);
        $answerKeys = $resolvedMeetingContent['answerKeys'];
        $userAnswers = (array) $request->input('answers', []);
        $meeting11Answers = (array) $request->input('meeting11_answers', []);

        if ($meeting === 11 && !empty($meeting11Answers)) {
            foreach ($questions as $index => $questionText) {
                $questionNumber = $index + 1;
                $v2 = trim((string) ($meeting11Answers[$questionNumber]['v2'] ?? ''));
                $v3 = trim((string) ($meeting11Answers[$questionNumber]['v3'] ?? ''));

                if ($v2 !== '' || $v3 !== '') {
                    $combined = trim($v2 . ', ' . $v3, ', ');
                    $userAnswers[$questionNumber] = $combined;
                }
            }
        }
        $resolvedParagraphContent = $this->resolveIntroductoryMeetingParagraph($meeting);
        $paragraphData = $resolvedParagraphContent['paragraphData'];
        $userParagraphAnswer = trim((string) $request->input('paragraph_answer', ''));

        $aiItems = [];
        foreach ($questions as $index => $questionText) {
            $questionNumber = $index + 1;
            $userAnswer = trim((string) ($userAnswers[$questionNumber] ?? ''));
            $correctAnswer = trim((string) ($answerKeys[$questionNumber] ?? ''));
            // Not attempted - excluded from AI grading and from scoring
            // below entirely (never counted toward maxRawScore), not
            // marked wrong. Lets "Cek Jawaban"-style partial checks work
            // without penalizing questions the student hasn't reached yet.
            if ($correctAnswer !== '' && $userAnswer !== '') {
                $aiItems[] = ['id' => "sentence_{$questionNumber}", 'correct_answer' => $correctAnswer, 'user_answer' => $userAnswer];
            }
        }
        if ($paragraphData !== null && !empty($paragraphData['en']) && $userParagraphAnswer !== '') {
            $aiItems[] = ['id' => 'paragraph', 'correct_answer' => (string) $paragraphData['en'], 'user_answer' => $userParagraphAnswer];
        }
        $introductoryAiEnabled = $this->isGrammarWritingAiEnabled('introductory', $meeting);
        $aiScores = $introductoryAiEnabled ? $this->gradeItemsWithAi($aiItems) : null;

        $results = [];
        $totalScore = 0;
        $gradedQuestionCount = 0;

        foreach ($questions as $index => $questionText) {
            $questionNumber = $index + 1;
            $userAnswer = trim((string) ($userAnswers[$questionNumber] ?? ''));
            $correctAnswer = trim((string) ($answerKeys[$questionNumber] ?? ''));
            $answered = $correctAnswer !== '' && $userAnswer !== '';

            $questionScore = 0;
            $formattedAnswer = '';

            if ($correctAnswer !== '') {
                // Always resolve which correct-answer variant to display
                // (evaluateIntroductorySentenceAnswer() picks the
                // best-matching one out of the pipe-separated alternatives
                // and normalizes $correctAnswer to just that one) even when
                // unanswered - but only actually SCORE it, and count it
                // toward the total, when the student attempted this question.
                [$scoredValue, $formattedValue, $correctAnswer] = $this->evaluateIntroductorySentenceAnswer($userAnswer, $correctAnswer);
                if ($answered) {
                    $questionScore = $scoredValue;
                    $formattedAnswer = $formattedValue;
                    $aiKey = "sentence_{$questionNumber}";
                    if ($aiScores && isset($aiScores[$aiKey])) {
                        // AI score is 0-100; this item's scale is 0-10.
                        $questionScore = round($aiScores[$aiKey]['score'] / 10, 1);
                    }
                    $totalScore += $questionScore;
                    $gradedQuestionCount++;
                }
            }

            $results[$questionNumber] = [
                'user_answer' => $userAnswer,
                'formatted_answer' => $formattedAnswer,
                'score' => $questionScore,
                'correct_answer' => $correctAnswer,
                'answered' => $answered,
            ];
        }

        $paragraphResult = null;
        $maxRawScore = $gradedQuestionCount * 10;
        $paragraphAnswered = $paragraphData !== null && !empty($paragraphData['en']) && $userParagraphAnswer !== '';

        if ($paragraphAnswered) {
            $paragraphResult = $this->evaluateIntroductoryParagraphAnswer($userParagraphAnswer, (string) $paragraphData['en']);
            if ($aiScores && isset($aiScores['paragraph'])) {
                // AI score is 0-100; this item's max_score is 20.
                $paragraphResult['score'] = round($aiScores['paragraph']['score'] / 100 * $paragraphResult['max_score']);
            }
            $totalScore += $paragraphResult['score'];
            $maxRawScore += $paragraphResult['max_score'];
        }

        $finalScore = $maxRawScore > 0 ? round(($totalScore / $maxRawScore) * 100, 1) : 0;

        $trackAnswersData = ['results' => $results, 'ai_enabled' => $introductoryAiEnabled];
        if ($paragraphResult !== null) {
            $trackAnswersData['paragraph_result'] = array_merge($paragraphResult, ['user_answer' => $userParagraphAnswer]);
        }
        $this->persistGrammarTrackScore($meeting, $finalScore, 'introductory-grammar-for-writing', $trackAnswersData);

        return view('assignments.grammar-writing-introductory-meeting', [
            'meetingNumber' => $meeting,
            'meetingLabel' => $meetingData['label'],
            'topic' => $meetingData['topic'],
            'trackTitle' => 'Introductory Grammar for Writing',
            'questions' => $questions,
            'questionHelpers' => $questionHelpers,
            'cheatSheet' => $this->introductoryMeetingCheatSheet($meeting),
            'questionEditorData' => $resolvedMeetingContent['editorData'],
            'submitted' => true,
            'score' => $finalScore,
            'results' => $results,
            'userAnswers' => $userAnswers,
            'meeting11Answers' => $meeting11Answers,
            'paragraphData' => $paragraphData,
            'paragraphEditorData' => $resolvedParagraphContent['editorData'],
            'userParagraphAnswer' => $userParagraphAnswer,
            'paragraphResult' => $paragraphResult,
        ]);
    }

    public function grammarWritingIntroductoryMeetingReset(int $meeting)
    {
        // Was a pure no-op (redirect only) - grammarWritingIntroductoryMeeting()
        // above has no "submitted" session flag at all, it derives $submitted
        // purely from whether a MeetingScore row exists, so without deleting
        // that row (and the AssignmentDraft/draft session keys it also falls
        // back to) this reset endpoint could never actually unlock a
        // previously-submitted meeting for retry - only ever touches the
        // clicking user's own row.
        session()->forget([
            "introductory_meeting{$meeting}_draft_answers",
            "introductory_meeting{$meeting}_draft_paragraph_answer",
        ]);

        $userId = Auth::id();
        if ($userId) {
            try {
                $programId = \App\Models\Program::where('slug', 'introductory-grammar-for-writing')->value('id') ?? Auth::user()?->program_id;
                if ($programId) {
                    \App\Models\MeetingScore::where('user_id', $userId)
                        ->where('program_id', $programId)
                        ->where('meeting_number', $meeting)
                        ->delete();

                    \App\Models\AssignmentDraft::where('user_id', $userId)
                        ->where('program_id', $programId)
                        ->where('meeting_number', $meeting)
                        ->delete();
                }
            } catch (\Throwable $e) {}
        }

        return redirect()->route('assignments.grammar-writing.introductory.meeting', ['meeting' => $meeting]);
    }

    public function grammarWritingComplexityMeeting(
        int $meeting,
        BuildGrammarWritingMeeting2ViewData $buildGrammarWritingMeeting2ViewData,
        BuildGrammarWritingMeeting3ViewData $buildGrammarWritingMeeting3ViewData,
        BuildGrammarWritingMeeting4ViewData $buildGrammarWritingMeeting4ViewData,
        BuildGrammarWritingMeeting6ViewData $buildGrammarWritingMeeting6ViewData,
        BuildGrammarWritingMeeting10ViewData $buildGrammarWritingMeeting10ViewData,
        BuildGrammarWritingMeeting11ViewData $buildGrammarWritingMeeting11ViewData,
        BuildGrammarWritingMeeting12ViewData $buildGrammarWritingMeeting12ViewData,
        GrammarWritingDataRepository $grammarWritingDataRepository,
    )
    {
        $user = Auth::user();
        $isAdminOrTeacher = $user && ($user->isAdmin() || $user->isTeacher());

        if (!$isAdminOrTeacher && $user?->isStudent()) {
            $enrolledSlugs = $this->resolveGrammarEnrolledSlugs($user);
            if (!in_array('complexity-grammar-for-writing', $enrolledSlugs, true)) {
                return redirect()->route('assignments.grammar-writing.classes')
                    ->with('error', 'Anda tidak memiliki akses ke kelas Complexity Grammar for Writing.');
            }
        }

        $this->maybeRecordAttendanceForAssignmentAccess($user, 'grammar-for-writing', request());

        if ($meeting === 1) {
            return view('assignments.grammar-writing.meeting2', array_merge(
                $buildGrammarWritingMeeting2ViewData->handle(
                    $grammarWritingDataRepository->meeting2Tenses,
                    $grammarWritingDataRepository->meeting2TenseExamples,
                    $grammarWritingDataRepository->meeting2Vocabularies,
                    'complexity',
                ),
                [
                    'backRoute' => route('assignments.grammar-writing.track', 'complexity'),
                    'displayMeetingNumber' => $meeting,
                ]
            ));
        }

        $complexityMeetings = $this->complexityMeetingCatalog();
        $meetingData = $complexityMeetings[$meeting - 1] ?? null;

        abort_if($meeting < 1 || $meeting > 10, 404);
        abort_if($meetingData === null, 404);

        $static = $this->complexityStaticQuestions($meeting);

        abort_if($static === null, 404);

        $submitted = session("complexity_meeting{$meeting}_submitted", false);
        $results = session("complexity_meeting{$meeting}_results", []);
        $finalScore = session("complexity_meeting{$meeting}_final_score", 0);
        $userAnswers = session("complexity_meeting{$meeting}_user_answers", []);
        $draftAnswers = session("complexity_meeting{$meeting}_draft_answers", []);

        if ($user) {
            try {
                $programId = \App\Models\Program::where('slug', 'complexity-grammar-for-writing')->value('id') ?? $user->program_id;
                if ($programId) {
                    if (!$submitted) {
                        $scoreRecord = \App\Models\MeetingScore::where('user_id', $user->id)
                            ->where('program_id', $programId)
                            ->where('meeting_number', $meeting)
                            ->latest('submitted_at')
                            ->first();

                        if ($scoreRecord) {
                            $submitted = true;
                            $finalScore = $scoreRecord->score;
                            $scoreData = is_array($scoreRecord->answers) ? $scoreRecord->answers : json_decode($scoreRecord->answers ?? '[]', true);
                            if (!empty($scoreData)) {
                                $results = $scoreData['results'] ?? [];
                                $userAnswers = $scoreData['user_answers'] ?? [];
                            }
                        }
                    }

                    if (empty($draftAnswers) && empty($userAnswers)) {
                        $draft = \App\Models\AssignmentDraft::where('user_id', $user->id)
                            ->where('program_id', $programId)
                            ->where('meeting_number', $meeting)
                            ->first();
                        if ($draft && is_array($draft->answers)) {
                            $draftAnswers = $draft->answers;
                        }
                    }
                }
            } catch (\Throwable $e) {}
        }

        return view('assignments.grammar-writing-complexity-meeting', [
            'meetingNumber' => $meeting,
            'topic' => $static['topic'] ?? $meetingData['topic'],
            'trackTitle' => 'Complexity Grammar for Writing',
            'track' => 'complexity',
            'questions' => $static['questions'],
            'questionHelpers' => $static['questionHelpers'] ?? [],
            'cheatSheet' => $this->complexityMeetingCheatSheet($meeting),
            'submitted' => $submitted,
            'results' => $results,
            'finalScore' => $finalScore,
            'userAnswers' => $userAnswers,
            'draftAnswers' => !empty($userAnswers) ? $userAnswers : $draftAnswers,
        ]);
    }

        public function complexityMeetingCheatSheet(int $meeting): ?array
    {
        return match ($meeting) {
            1 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Ringkasan Matriks 16 Tenses Utama & Modal
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Tenses</th><th class="p-3.5 font-semibold border-b border-gray-700">Pola Verbal (Aktif)</th><th class="p-3.5 font-semibold border-b border-gray-700">Pola Nominal</th><th class="p-3.5 font-semibold border-b border-gray-700">Pola Pasif (Passive)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Simple Present</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + V1(s/es)</td><td class="p-3.5 text-gray-800">S + am/is/are + Nominal</td><td class="p-3.5 italic text-gray-600">S + am/is/are + V3</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Present Continuous</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + am/is/are + V-ing</td><td class="p-3.5 text-gray-800">S + am/is/are + being</td><td class="p-3.5 italic text-gray-600">S + am/is/are + being + V3</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Present Perfect</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + have/has + V3</td><td class="p-3.5 text-gray-800">S + have/has + been</td><td class="p-3.5 italic text-gray-600">S + have/has + been + V3</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Present Perf. Cont.</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + have/has + been + V-ing</td><td class="p-3.5 text-gray-800">S + have/has + been + being</td><td class="p-3.5 italic text-gray-600">S + have/has + been + being + V3</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Simple Past</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + V2</td><td class="p-3.5 text-gray-800">S + was/were + Nominal</td><td class="p-3.5 italic text-gray-600">S + was/were + V3</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Past Continuous</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + was/were + V-ing</td><td class="p-3.5 text-gray-800">S + was/were + being</td><td class="p-3.5 italic text-gray-600">S + was/were + being + V3</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Past Perfect</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + had + V3</td><td class="p-3.5 text-gray-800">S + had + been</td><td class="p-3.5 italic text-gray-600">S + had + been + V3</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Simple Future</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + will + V1</td><td class="p-3.5 text-gray-800">S + will + be</td><td class="p-3.5 italic text-gray-600">S + will + be + V3</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Modal</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + Modal + V1</td><td class="p-3.5 text-gray-800">S + Modal + be</td><td class="p-3.5 italic text-gray-600">S + Modal + be + V3</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">1. Tentukan jenis predikat: Verbal (aksi), Nominal (keadaan), Pasif (di-/ter-).</li><li class="leading-relaxed">2. Tentukan aspek: Perfect (sudah), Continuous (sedang), Modal (harus/bisa), atau Simple.</li><li class="leading-relaxed">3. Tentukan waktu: Present, Past, atau Future.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">adalah, merupakan, berada, berupa = Nominal (gunakan be).</li><li class="leading-relaxed">di-, ter- = Pasif (gunakan be + V3).</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Gunakan matriks ini sebagai referensi utama penentuan tenses.</em>
    </div>
    
HTML
],
            2 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            <span class="bg-emerald-600 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold shadow-xs">⚔️</span>
            Teknik Silang - Silang Penentuan Formula Tenses
        </h5>
        
        <!-- Outer Box resembling Target Bahasa Module -->
        <div class="rounded-2xl border-2 border-gray-800 bg-white p-4 sm:p-5 shadow-sm space-y-4">
            
            <!-- Top 3 Columns: Bentuk, Aspek, Waktu -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                
                <!-- Box 1: Bentuk / Jenis Kalimat -->
                <div class="border-2 border-gray-800 rounded-xl p-3.5 bg-gray-50/50 flex flex-col justify-between">
                    <div class="space-y-2.5">
                        <div class="flex justify-between items-baseline border-b border-gray-200 pb-1.5">
                            <span class="font-extrabold text-xs tracking-wider text-gray-900">VERBAL</span>
                            <span class="font-bold text-sm font-mono text-gray-800">Ø</span>
                        </div>
                        <div class="border-b border-gray-200 pb-1.5">
                            <div class="flex justify-between items-baseline">
                                <span class="font-extrabold text-xs tracking-wider text-gray-900">NOMINAL</span>
                                <span class="font-bold text-sm font-mono text-blue-700">be</span>
                            </div>
                            <span class="text-[11px] text-gray-500 italic block mt-0.5">tanpa kata kerja</span>
                        </div>
                        <div>
                            <div class="flex justify-between items-baseline">
                                <span class="font-extrabold text-xs tracking-wider text-gray-900">PASSIVE</span>
                                <span class="font-bold text-sm font-mono text-blue-700">be + V3</span>
                            </div>
                            <span class="text-[11px] text-gray-500 italic block mt-0.5">di- / ter-</span>
                        </div>
                    </div>
                </div>

                <!-- Box 2: Aspek (Aspect) -->
                <div class="border-2 border-gray-800 rounded-xl p-3.5 bg-gray-50/50 flex flex-col justify-between">
                    <div class="space-y-2.5">
                        <div class="border-b border-gray-200 pb-1.5">
                            <div class="flex justify-between items-baseline">
                                <span class="font-extrabold text-xs tracking-wider text-gray-900">PERFECT</span>
                                <span class="font-bold text-sm font-mono text-purple-700">have + V3</span>
                            </div>
                            <span class="text-[11px] text-gray-500 italic block mt-0.5">sudah / telah</span>
                        </div>
                        <div class="border-b border-gray-200 pb-1.5">
                            <div class="flex justify-between items-baseline">
                                <span class="font-extrabold text-xs tracking-wider text-gray-900">CONTINUOUS</span>
                                <span class="font-bold text-sm font-mono text-purple-700">be + V-ing</span>
                            </div>
                            <span class="text-[11px] text-gray-500 italic block mt-0.5">sedang</span>
                        </div>
                        <div class="flex justify-between items-baseline pt-0.5">
                            <span class="font-extrabold text-xs tracking-wider text-gray-900">SIMPLE</span>
                            <span class="font-bold text-sm font-mono text-gray-800">Ø</span>
                        </div>
                    </div>
                </div>

                <!-- Box 3: Waktu & Modal -->
                <div class="border-2 border-gray-800 rounded-xl p-3.5 bg-gray-50/50 flex flex-col justify-between">
                    <div class="space-y-2">
                        <div class="flex justify-between items-baseline border-b border-gray-200 pb-1">
                            <span class="font-extrabold text-xs tracking-wider text-gray-900">PRESENT</span>
                            <span class="font-bold text-xs font-mono text-emerald-700">V1 / Vs,es</span>
                        </div>
                        <div class="flex justify-between items-baseline border-b border-gray-200 pb-1">
                            <span class="font-extrabold text-xs tracking-wider text-gray-900">PAST</span>
                            <span class="font-bold text-xs font-mono text-emerald-700">V2</span>
                        </div>
                        <div class="flex justify-between items-baseline border-b border-gray-200 pb-1">
                            <span class="font-extrabold text-xs tracking-wider text-gray-900">FUTURE</span>
                            <span class="font-bold text-xs font-mono text-emerald-700">will + V1</span>
                        </div>
                        <div class="flex justify-between items-baseline">
                            <span class="font-extrabold text-xs tracking-wider text-gray-900">MODAL</span>
                            <span class="font-bold text-xs font-mono text-emerald-700">modal + V1</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Table: Perubahan Bentuk Kata Bantu (Auxiliary / Be / Have / Will) -->
            <div class="overflow-x-auto border-2 border-gray-800 rounded-xl bg-white">
                <table class="w-full text-center border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-100 border-b-2 border-gray-800 font-extrabold text-gray-900 tracking-wider">
                            <th class="p-2.5 border-r-2 border-gray-800">V</th>
                            <th class="p-2.5 border-r border-gray-300">Vs/es</th>
                            <th class="p-2.5 border-r border-gray-300">V1</th>
                            <th class="p-2.5 border-r border-gray-300">V2</th>
                            <th class="p-2.5 border-r border-gray-300">V3</th>
                            <th class="p-2.5">V-ing</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-gray-800 font-mono text-xs sm:text-sm">
                        <tr class="hover:bg-gray-50">
                            <td class="p-2.5 font-bold border-r-2 border-gray-800 bg-gray-50">be</td>
                            <td class="p-2.5 border-r border-gray-200 text-gray-400">-</td>
                            <td class="p-2.5 border-r border-gray-200 font-semibold text-blue-700">is / am / are</td>
                            <td class="p-2.5 border-r border-gray-200 font-semibold text-blue-700">was / were</td>
                            <td class="p-2.5 border-r border-gray-200 font-semibold text-purple-700">been</td>
                            <td class="p-2.5 font-semibold text-emerald-700">being</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="p-2.5 font-bold border-r-2 border-gray-800 bg-gray-50">have</td>
                            <td class="p-2.5 border-r border-gray-200 font-semibold text-blue-700">has</td>
                            <td class="p-2.5 border-r border-gray-200 font-semibold text-blue-700">have</td>
                            <td class="p-2.5 border-r border-gray-200 font-semibold text-blue-700">had</td>
                            <td class="p-2.5 border-r border-gray-200 font-semibold text-purple-700">had</td>
                            <td class="p-2.5 font-semibold text-emerald-700">having</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="p-2.5 font-bold border-r-2 border-gray-800 bg-gray-50">will</td>
                            <td class="p-2.5 border-r border-gray-200 text-gray-400">-</td>
                            <td class="p-2.5 border-r border-gray-200 font-semibold text-blue-700">will</td>
                            <td class="p-2.5 border-r border-gray-200 font-semibold text-blue-700">would</td>
                            <td class="p-2.5 border-r border-gray-200 text-gray-400">-</td>
                            <td class="p-2.5 text-gray-400">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Modal List Footer Note -->
            <div class="pt-1 text-center text-xs text-gray-700 font-medium tracking-wide">
                <span class="font-bold text-gray-900">modal =</span> can, could, will, would, must, should, may, might, used to, ought to
            </div>

        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            💡 3 Tahap Penentuan Tenses:
        </strong>
        <ol class="list-decimal list-inside space-y-2 ml-1 text-xs sm:text-sm text-blue-950">
            <li class="leading-relaxed">
                <strong>Tahap 1: Tentukan Jenis Bentuk Kalimat (Verbal, Nominal, atau Pasif)</strong>
                <ul class="list-disc list-inside ml-4 text-xs space-y-0.5 text-blue-900 mt-0.5">
                    <li><strong>Verbal:</strong> Ada kata kerja aksi aktif (<em>me-, ber-, tanpa awalan</em>).</li>
                    <li><strong>Nominal:</strong> Menyatakan sifat/profesi/keberadaan (<em>adalah, merupakan, ada, berada, berupa &rarr; be</em>).</li>
                    <li><strong>Pasif:</strong> Subjek dikenai aksi (<em>di-, ter- &rarr; be + V3</em>).</li>
                </ul>
            </li>
            <li class="leading-relaxed">
                <strong>Tahap 2: Tentukan Aspek Bentuk (Aspect)</strong>
                <ul class="list-disc list-inside ml-4 text-xs space-y-0.5 text-blue-900 mt-0.5">
                    <li><strong>Perfect:</strong> Ada kata <em>sudah, telah, pernah, belum</em> &rarr; <code>have/has/had + V3</code>.</li>
                    <li><strong>Continuous:</strong> Ada kata <em>sedang</em> &rarr; <code>be + V-ing</code>.</li>
                    <li><strong>Modal:</strong> Ada kata <em>bisa/dapat (can), mungkin (may), harus (must), seharusnya (should)</em>.</li>
                    <li><strong>Simple:</strong> Jika tidak memiliki aspek di atas &rarr; gunakan pola <strong>Simple</strong>.</li>
                </ul>
            </li>
            <li class="leading-relaxed">
                <strong>Tahap 3: Tentukan Waktu (Time Frame)</strong>
                <ul class="list-disc list-inside ml-4 text-xs space-y-0.5 text-blue-900 mt-0.5">
                    <li><strong>Present:</strong> Masa sekarang, kebiasaan, fakta umum (<em>default jika tidak ada penanda lampau/future</em>).</li>
                    <li><strong>Past:</strong> Masa lampau / sejarah / peristiwa selesai (<em>kemarin, tahun lalu, era kuno &rarr; V2 / was / were / had</em>).</li>
                    <li><strong>Future:</strong> Masa depan (<em>akan, tahun depan &rarr; will + V1</em>).</li>
                </ul>
            </li>
        </ol>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            ⚠️ Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed"><strong>adalah, ada, berada, berupa, merupakan = Nominal</strong> (Wajib gunakan be: <em>am/is/are/was/were</em>).</li>
            <li class="leading-relaxed"><strong>di-, ter- = Pasif</strong> (Wajib gunakan <em>be + V3</em>).</li>
            <li class="leading-relaxed">Pastikan kesesuaian subjek tunggal/jamak (<em>plural subject</em>) dengan kata kerja (misal: <em>characteristics <u>are</u></em>, <em>parameters <u>have been</u></em>).</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Silangkan formula antara (Bentuk &times; Aspek &times; Waktu) untuk mendapatkan rumus yang tepat.</em>
    </div>
    
HTML
],
            3 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            1. Pola Bentuk Gramatikal To Infinitive vs Gerund (Modul Hal. 22-24)
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Jenis Verb Palsu</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Aktif</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Nominal</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Pasif</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">To Infinitive</td>
                            <td class="p-3.5 font-mono text-blue-700">to + V1 <em>(to learn)</em></td>
                            <td class="p-3.5 font-mono text-blue-700">to + be + Compl <em>(to be a doctor)</em></td>
                            <td class="p-3.5 font-mono text-blue-700">to + be + V3 <em>(to be examined)</em></td>
                        </tr>
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Gerund (V-ing as Noun)</td>
                            <td class="p-3.5 font-mono text-blue-700">Ving <em>(learning)</em></td>
                            <td class="p-3.5 font-mono text-blue-700">being + Compl <em>(being a doctor)</em></td>
                            <td class="p-3.5 font-mono text-blue-700">being + V3 <em>(being examined)</em></td>
                        </tr>
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Bare Infinitive / Adj</td>
                            <td class="p-3.5 font-mono text-blue-700" colspan="3">S + have / let / make / would rather / prove / help + Object + V1 (tanpa 'to') / Adj</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2 mt-6">
            2. Daftar Kata Kerja (List of Verbs) Sesuai Modul PDF (Hal. 23-24)
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 text-xs sm:text-sm">
            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
                <strong class="block text-blue-900 font-bold mb-2 border-b pb-1 text-sm flex items-center justify-between">
                    <span>1) Diikuti TO INFINITIVE (to + V1):</span>
                </strong>
                <p class="text-gray-700 leading-relaxed font-mono text-[11px] sm:text-xs">
                    afford, agree, appear, arrange, ask, attempt, beg, choose, claim, decide, demand, deserve, expect, fail, hesitate, hope, intend, learn, manage, mean, offer, plan, prepare, pretend, promise, refuse, seem, threaten, want, wish.
                </p>
                <em class="block mt-2 text-[11px] text-gray-500 italic">Contoh: Scientists attempt <u>to understand</u> the universe.</em>
            </div>

            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
                <strong class="block text-purple-900 font-bold mb-2 border-b pb-1 text-sm flex items-center justify-between">
                    <span>2) Diikuti GERUND (V-ing):</span>
                </strong>
                <p class="text-gray-700 leading-relaxed font-mono text-[11px] sm:text-xs">
                    admit, advise, appreciate, avoid, consider, delay, deny, discuss, dislike, enjoy, finish, forget, keep, mention, mind, miss, postpone, practice, quit, recall, recommend, regret, remember, risk, stop, suggest, tolerate.
                </p>
                <em class="block mt-2 text-[11px] text-gray-500 italic">Contoh: Developing a new vaccine requires <u>testing</u>. / She enjoys <u>reading</u>.</em>
            </div>

            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
                <strong class="block text-emerald-900 font-bold mb-2 border-b pb-1 text-sm flex items-center justify-between">
                    <span>3) Diikuti OBJECT + TO INFINITIVE:</span>
                </strong>
                <p class="text-gray-700 leading-relaxed font-mono text-[11px] sm:text-xs">
                    advise, allow, ask, cause, encourage, forbid, force, invite, order, permit, persuade, remind, require, teach, tell, urge, warn.
                </p>
                <em class="block mt-2 text-[11px] text-gray-500 italic">Contoh: The teacher encouraged students <u>to study</u>. / It requires us <u>to focus</u>.</em>
            </div>

            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
                <strong class="block text-amber-900 font-bold mb-2 border-b pb-1 text-sm flex items-center justify-between">
                    <span>4) Diikuti BARE INFINITIVE / ADJ:</span>
                </strong>
                <p class="text-gray-700 leading-relaxed font-mono text-[11px] sm:text-xs">
                    have, let, make, would rather, prove, help.
                </p>
                <em class="block mt-2 text-[11px] text-gray-500 italic">Contoh: The study makes researchers <u>rethink</u> (bukan to rethink). / Let him <u>go</u>.</em>
            </div>
        </div>

        <div class="bg-indigo-100 border border-indigo-200 rounded-xl p-4 mb-4 text-xs sm:text-sm text-indigo-950" style="background-color: #e0e7ff !important;">
            <strong class="block text-indigo-900 font-bold mb-2 text-sm">3) Perbedaan Makna Kata Kerja Khusus (Stop, Remember/Forget, Try):</strong>
            <ul class="space-y-2 text-xs">
                <li>• <strong>Stop + V-ing</strong> (berhenti dari aktivitas) vs <strong>Stop + To V1</strong> (berhenti sejenak untuk melakukan aktivitas lain):<br>
                    <span class="italic text-gray-600">He stopped smoking. (Berhenti merokok) | He stopped to buy water. (Berhenti sejenak untuk membeli air)</span>
                </li>
                <li>• <strong>Remember / Forget + V-ing</strong> (mengingat/lupa kejadian lalu) vs <strong>Remember / Forget + To V1</strong> (mengingat/lupa tugas yang harus dilakukan):<br>
                    <span class="italic text-gray-600">I remember meeting him. (Ingat pernah bertemu) | Remember to lock the door. (Ingat untuk mengunci pintu)</span>
                </li>
                <li>• <strong>Try + V-ing</strong> (mencoba sebagai eksperimen) vs <strong>Try + To V1</strong> (berusaha keras mencapai tujuan):<br>
                    <span class="italic text-gray-600">Try adding some salt. (Coba tambah garam) | Try to solve the problem. (Berusaha keras memecahkan masalah)</span>
                </li>
            </ul>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman To Infinitive & Gerund:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed"><strong>To Infinitive (to + V1)</strong> menyatakan tujuan, rencana, atau harapan di masa depan.</li>
            <li class="leading-relaxed"><strong>Gerund (V-ing)</strong> menyatakan aktivitas sebagai konsep kata benda utuh.</li>
            <li class="leading-relaxed">Setelah preposisi (<em>of, in, by, for, about, with, without, from</em>), kata kerja <u>WAJIB</u> berbentuk Gerund (<strong>V-ing</strong>).</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
             Aturan Emas Gramatikal:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Gerund sebagai subjek kalimat selalu dihitung sebagai <strong>kata benda tunggal (Singular Subject)</strong>.</li>
            <li class="leading-relaxed">Setelah kata kerja <em>make, let, have, would rather</em>, jangan gunakan <em>'to'</em> (Gunakan Bare Infinitive).</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Developing a new vaccine <u>requires</u>... | To understand the universe <u>is</u>...</em>
    </div>
HTML
],
            4 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            <span class="bg-indigo-600 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold shadow-xs">1</span>
            Comparative & Superlative Degree
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Bentuk Perbandingan</th><th class="p-3.5 font-semibold border-b border-gray-700">Formula Utama</th><th class="p-3.5 font-semibold border-b border-gray-700">Makna Gramatikal</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat Akademik</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-blue-700 whitespace-nowrap">Comparative Degree</td><td class="p-3.5 font-mono text-xs sm:text-sm">more + Adj + than / Adj-er than</td><td class="p-3.5 text-gray-800">Lebih ... daripada</td><td class="p-3.5 italic text-gray-600">Renewable energy grows <strong>much faster than</strong> fossil energy.</td></tr>
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-red-700 whitespace-nowrap">Superlative Degree</td><td class="p-3.5 font-mono text-xs sm:text-sm">the most + Adj / the Adj-est</td><td class="p-3.5 text-gray-800">Paling ... / Ter-...</td><td class="p-3.5 italic text-gray-600">Jupiter is <strong>the largest</strong> planet in our solar system.</td></tr>
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-purple-700 whitespace-nowrap">Double Comparative</td><td class="p-3.5 text-gray-800">The more..., the more...</td><td class="p-3.5 text-gray-800">Semakin ..., semakin ...</td><td class="p-3.5 italic text-gray-600"><strong>The more complex</strong> the data, <strong>the harder</strong> the analysis.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <h6 class="text-sm font-bold text-gray-800 mb-1 mt-4">Perubahan Adjective/Adverb</h6>
        <p class="text-xs text-gray-600 mb-2">Regular comparative & superlative sebagai berikut :</p>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700 w-32 text-center">Syllable /<br>Suku kata</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Positive</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Comparative<br><span class="text-gray-300 font-normal text-xs normal-case">(Lebih... daripada ...)</span></th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Superlative<br><span class="text-gray-300 font-normal text-xs normal-case">(Ter... / paling...)</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="p-3.5 font-bold text-gray-900 text-center align-top bg-gray-50/50">1</td>
                            <td class="p-3.5 align-top">
                                <ul class="space-y-1 font-medium text-gray-800">
                                    <li>- Tall</li>
                                    <li>- Smart</li>
                                    <li>- Short</li>
                                </ul>
                            </td>
                            <td class="p-3.5 align-top font-bold text-blue-700">
                                <ul class="space-y-1">
                                    <li>- Taller</li>
                                    <li>- Smarter</li>
                                    <li>- Shorter</li>
                                </ul>
                            </td>
                            <td class="p-3.5 align-top font-bold text-red-700">
                                <ul class="space-y-1">
                                    <li>- Tallest</li>
                                    <li>- Smartest</li>
                                    <li>- Shortest</li>
                                </ul>
                            </td>
                        </tr>
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="p-3.5 font-bold text-gray-900 text-center align-top bg-gray-50/50">2</td>
                            <td class="p-3.5 align-top">
                                <ul class="space-y-1 font-medium text-gray-800">
                                    <li>- Clever</li>
                                </ul>
                            </td>
                            <td class="p-3.5 align-top font-bold text-blue-700">
                                <ul class="space-y-1">
                                    <li>- Cleverer / more clever</li>
                                </ul>
                            </td>
                            <td class="p-3.5 align-top font-bold text-red-700">
                                <ul class="space-y-1">
                                    <li>- Cleverest / most clever</li>
                                </ul>
                            </td>
                        </tr>
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="p-3.5 font-bold text-gray-900 text-center align-top bg-gray-50/50">&gt; 2</td>
                            <td class="p-3.5 align-top">
                                <ul class="space-y-1 font-medium text-gray-800">
                                    <li>- Beautiful</li>
                                    <li>- Diligent</li>
                                </ul>
                            </td>
                            <td class="p-3.5 align-top font-bold text-blue-700">
                                <ul class="space-y-1">
                                    <li>- More beautiful</li>
                                    <li>- More diligent</li>
                                </ul>
                            </td>
                            <td class="p-3.5 align-top font-bold text-red-700">
                                <ul class="space-y-1">
                                    <li>- Most beautiful</li>
                                    <li>- Most diligent</li>
                                </ul>
                            </td>
                        </tr>
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="p-3.5 font-bold text-purple-900 text-center align-top bg-purple-50/40">
                                PCP<br><span class="text-xs font-semibold text-purple-700">Ving / V3</span>
                            </td>
                            <td class="p-3.5 align-top">
                                <ul class="space-y-1 font-medium text-gray-800">
                                    <li>- Broken</li>
                                    <li>- Tiring</li>
                                </ul>
                            </td>
                            <td class="p-3.5 align-top font-bold text-blue-700">
                                <ul class="space-y-1">
                                    <li>- More broken</li>
                                    <li>- More tiring</li>
                                </ul>
                            </td>
                            <td class="p-3.5 align-top font-bold text-red-700">
                                <ul class="space-y-1">
                                    <li>- Most broken</li>
                                    <li>- Most tiring</li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2 mt-6">
            <span class="bg-indigo-600 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold shadow-xs">2</span>
            Irregular Comparative & Superlative (Bentuk Tidak Beraturan)
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Positive (Bentuk Dasar)</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Comparative (Lebih ...)</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Superlative (Paling / Ter-...)</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Makna Indonesia</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="p-3 font-bold text-gray-900 font-mono">good / well</td>
                            <td class="p-3 font-semibold text-blue-700 font-mono">better</td>
                            <td class="p-3 font-semibold text-red-700 font-mono">the best</td>
                            <td class="p-3 text-gray-800">baik &rarr; lebih baik &rarr; terbaik</td>
                        </tr>
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="p-3 font-bold text-gray-900 font-mono">bad / badly</td>
                            <td class="p-3 font-semibold text-blue-700 font-mono">worse</td>
                            <td class="p-3 font-semibold text-red-700 font-mono">the worst</td>
                            <td class="p-3 text-gray-800">buruk &rarr; lebih buruk &rarr; terburuk</td>
                        </tr>
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="p-3 font-bold text-gray-900 font-mono">far <span class="text-gray-500 font-sans text-xs">(jarak fisik)</span></td>
                            <td class="p-3 font-semibold text-blue-700 font-mono">farther</td>
                            <td class="p-3 font-semibold text-red-700 font-mono">the farthest</td>
                            <td class="p-3 text-gray-800">jauh &rarr; lebih jauh &rarr; terjauh</td>
                        </tr>
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="p-3 font-bold text-gray-900 font-mono">far <span class="text-gray-500 font-sans text-xs">(tingkat/abstrak)</span></td>
                            <td class="p-3 font-semibold text-blue-700 font-mono">further</td>
                            <td class="p-3 font-semibold text-red-700 font-mono">the furthest</td>
                            <td class="p-3 text-gray-800">lanjut &rarr; lebih lanjut &rarr; paling lanjut</td>
                        </tr>
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="p-3 font-bold text-gray-900 font-mono">little <span class="text-gray-500 font-sans text-xs">(jumlah tak terhitung)</span></td>
                            <td class="p-3 font-semibold text-blue-700 font-mono">less</td>
                            <td class="p-3 font-semibold text-red-700 font-mono">the least</td>
                            <td class="p-3 text-gray-800">sedikit &rarr; lebih sedikit &rarr; paling sedikit</td>
                        </tr>
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="p-3 font-bold text-gray-900 font-mono">many / much <span class="text-gray-500 font-sans text-xs">(banyak)</span></td>
                            <td class="p-3 font-semibold text-blue-700 font-mono">more</td>
                            <td class="p-3 font-semibold text-red-700 font-mono">the most</td>
                            <td class="p-3 text-gray-800">banyak &rarr; lebih banyak &rarr; terbanyak / paling banyak</td>
                        </tr>
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="p-3 font-bold text-gray-900 font-mono">old <span class="text-gray-500 font-sans text-xs">(saudara/keluarga)</span></td>
                            <td class="p-3 font-semibold text-blue-700 font-mono">elder</td>
                            <td class="p-3 font-semibold text-red-700 font-mono">the eldest</td>
                            <td class="p-3 text-gray-800">tua &rarr; lebih tua &rarr; tertua (sulung)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2 mt-6">
            <span class="bg-indigo-600 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold shadow-xs">3</span>
            Positive Degree (Tingkat Setara - Modul Hal. 28)
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Pola / Bentuk</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Formula Gramatikal</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Makna Indonesia</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="p-3.5 font-bold text-emerald-700 whitespace-nowrap">as + Adjective + as</td>
                            <td class="p-3.5 font-mono text-xs text-blue-700 font-semibold">S + be + as + Adj + as + N/Pron</td>
                            <td class="p-3.5 text-gray-800">Sama [sifat] dengan / Se-[sifat]</td>
                            <td class="p-3.5 italic text-gray-600">The moon appears <strong>as big as</strong> the sun.</td>
                        </tr>
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="p-3.5 font-bold text-emerald-700 whitespace-nowrap">as + Adverb + as</td>
                            <td class="p-3.5 font-mono text-xs text-blue-700 font-semibold">S + Verb + as + Adv + as + N/Pron</td>
                            <td class="p-3.5 text-gray-800">Sama [cara] dengan</td>
                            <td class="p-3.5 italic text-gray-600">He runs <strong>as quickly as</strong> a cheetah.</td>
                        </tr>
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="p-3.5 font-bold text-emerald-700 whitespace-nowrap">not as / so + Adj + as</td>
                            <td class="p-3.5 font-mono text-xs text-blue-700 font-semibold">S + be + not + as/so + Adj + as + N</td>
                            <td class="p-3.5 text-gray-800">Tidak se-[sifat] dengan</td>
                            <td class="p-3.5 italic text-gray-600">Silver is <strong>not as expensive as</strong> gold.</td>
                        </tr>
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="p-3.5 font-bold text-emerald-700 whitespace-nowrap">the same (Noun) as</td>
                            <td class="p-3.5 font-mono text-xs text-blue-700 font-semibold">S + V + the same + (Noun) + as + N</td>
                            <td class="p-3.5 text-gray-800">Sama [kata benda]-nya dengan</td>
                            <td class="p-3.5 italic text-gray-600">He has <strong>the same age as</strong> my brother.</td>
                        </tr>
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="p-3.5 font-bold text-emerald-700 whitespace-nowrap">as many / much + N + as</td>
                            <td class="p-3.5 font-mono text-xs text-blue-700 font-semibold">S + V + as + many/much + Noun + as + N</td>
                            <td class="p-3.5 text-gray-800">Sama banyak [benda] dengan</td>
                            <td class="p-3.5 italic text-gray-600">She has <strong>as many books as</strong> I do.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-emerald-50 border border-emerald-200 text-emerald-950 p-4 rounded-xl mb-5 text-xs sm:text-sm">
            <strong class="block mb-2 text-emerald-900 font-bold flex items-center gap-1">
                <span>📌</span> Pasangan Perubahan: as + Adjective + as &harr; the same + Noun + as
            </strong>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs font-mono">
                <span class="bg-white p-2 rounded-lg border border-emerald-200 shadow-xs"><strong class="text-emerald-700">as old as</strong> &harr; the same age as</span>
                <span class="bg-white p-2 rounded-lg border border-emerald-200 shadow-xs"><strong class="text-emerald-700">as heavy as</strong> &harr; the same weight as</span>
                <span class="bg-white p-2 rounded-lg border border-emerald-200 shadow-xs"><strong class="text-emerald-700">as tall as</strong> &harr; the same height as</span>
                <span class="bg-white p-2 rounded-lg border border-emerald-200 shadow-xs"><strong class="text-emerald-700">as big as</strong> &harr; the same size as</span>
                <span class="bg-white p-2 rounded-lg border border-emerald-200 shadow-xs"><strong class="text-emerald-700">as wide as</strong> &harr; the same width as</span>
                <span class="bg-white p-2 rounded-lg border border-emerald-200 shadow-xs"><strong class="text-emerald-700">as deep as</strong> &harr; the same depth as</span>
                <span class="bg-white p-2 rounded-lg border border-emerald-200 shadow-xs"><strong class="text-emerald-700">as long as</strong> &harr; the same length as</span>
                <span class="bg-white p-2 rounded-lg border border-emerald-200 shadow-xs"><strong class="text-emerald-700">as expensive as</strong> &harr; the same price as</span>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            💡 Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Gunakan akhiran <strong>-er / -est</strong> untuk kata sifat 1 suku kata (fast → faster → fastest).</li>
            <li class="leading-relaxed">Gunakan <strong>more / most</strong> untuk kata sifat 2+ suku kata (accurate → more accurate → most accurate).</li>
            <li class="leading-relaxed">Hafalkan bentuk <strong>Irregular</strong> seperti <em>good &rarr; better &rarr; best</em> dan <em>bad &rarr; worse &rarr; worst</em>.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            ⚠️ Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Perbandingan 'sama dengan' wajib menggunakan pasangan <strong>as ... as</strong>.</li>
            <li class="leading-relaxed">Jangan gabungkan <em>more</em> dengan <em>-er</em> (<s>more faster</s> → <strong>faster</strong>) atau <em>most</em> dengan <em>-est</em>.</li>
            <li class="leading-relaxed">Superlative wajib menggunakan artikel <strong>the</strong> (<em>the largest, the best</em>).</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Gunakan 'much' atau 'far' sebelum comparative untuk memberi penekanan (much larger, far more expensive).</em>
    </div>
    
HTML
],
            5 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Pola Parallel Structures (Struktur Sejajar)
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Jenis Penghubung</th><th class="p-3.5 font-semibold border-b border-gray-700">Formula Gramatikal</th><th class="p-3.5 font-semibold border-b border-gray-700">Aturan Kesejajaran</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat Akademik</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Coordinating (and, or, but)</td><td class="p-3.5 text-gray-800">Element A + and/or/but + Element B</td><td class="p-3.5 text-gray-800">Bentuk kata A & B wajib setara</td><td class="p-3.5 italic text-gray-600">Researchers collect soil samples, analyze data, and write reports.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Correlative (not only... but also)</td><td class="p-3.5 text-gray-800">not only + A + but also + B</td><td class="p-3.5 text-gray-800">Struktur A & B wajib identik</td><td class="p-3.5 italic text-gray-600">The project requires not only funding but also time.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Correlative (either... or)</td><td class="p-3.5 text-gray-800">either + A + or + B</td><td class="p-3.5 text-gray-800">Pilihan ganda setara</td><td class="p-3.5 italic text-gray-600">We must either reduce emissions or face climate risks.</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Unsur sebelum dan sesudah kata hubung harus memiliki bentuk gramatikal yang setara (Noun dengan Noun, V-ing dengan V-ing, Verb dengan Verb).</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Pola paralelisme wajib dijaga dalam deretan kata kerja seri (misal: <em>collect, analyze, and write</em>).</li><li class="leading-relaxed">Hindari ketidakseimbangan bentuk (<s>collecting soil, analyze data, and to write</s>).</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Semua kata dalam seri paralel wajib menggunakan bentuk tata bahasa yang sama.</em>
    </div>
    
HTML
],
            6 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            1. Pola & Formulasi Adverbial Clause (Modul Hal. 33-35)
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Posisi Adverbial Clause</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Formula Gramatikal</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Aturan Tanda Koma (,)</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat Akademik</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Initial Position (Di Awal)</td>
                            <td class="p-3.5 font-mono text-blue-700">Conj + S + V, S + V</td>
                            <td class="p-3.5 text-gray-800">WAJIB koma setelah Sub Clause</td>
                            <td class="p-3.5 italic text-gray-600"><strong>When</strong> roaming the Earth, dinosaurs dominated.</td>
                        </tr>
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Middle Position (Di Tengah)</td>
                            <td class="p-3.5 font-mono text-blue-700">S, + Conj + S + V, + V</td>
                            <td class="p-3.5 text-gray-800">Diapit dua koma (,)</td>
                            <td class="p-3.5 italic text-gray-600">Mesites, <strong>although</strong> able to fly, spend time on ground.</td>
                        </tr>
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Final Position (Di Akhir)</td>
                            <td class="p-3.5 font-mono text-blue-700">S + V + Conj + S + V</td>
                            <td class="p-3.5 text-gray-800">Tidak perlu koma</td>
                            <td class="p-3.5 italic text-gray-600">Species became extinct <strong>soon after</strong> they evolved.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2 mt-6">
            2. Daftar Lengkap 10 Jenis Adverbial Clause & Kata Hubung + Arti Bahasa Indonesia (Modul Hal. 34-35)
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 text-xs sm:text-sm">
            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
                <strong class="block text-blue-900 font-bold mb-2 border-b pb-1 text-sm">1) Waktu (Time):</strong>
                <ul class="space-y-1 text-gray-700 font-mono text-[11px] sm:text-xs">
                    <li>• <strong>when</strong> = ketika / saat</li>
                    <li>• <strong>whenever</strong> = kapan pun / sewaktu-waktu</li>
                    <li>• <strong>while / as</strong> = selagi / sementara / ketika</li>
                    <li>• <strong>before</strong> = sebelum | <strong>after</strong> = setelah / sesudah</li>
                    <li>• <strong>since</strong> = sejak / semenjak</li>
                    <li>• <strong>until / till</strong> = hingga / sampai</li>
                    <li>• <strong>as soon as / once</strong> = segera setelah / begitu...</li>
                    <li>• <strong>by the time</strong> = pada saat / menjelang</li>
                    <li>• <strong>as long as / so long as</strong> = selama / sepanjang</li>
                    <li>• <strong>every time / the moment</strong> = setiap kali / tepat ketika</li>
                </ul>
            </div>

            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
                <strong class="block text-emerald-900 font-bold mb-2 border-b pb-1 text-sm">2) Tempat (Place):</strong>
                <ul class="space-y-1 text-gray-700 font-mono text-[11px] sm:text-xs">
                    <li>• <strong>where</strong> = di mana / tempat di mana</li>
                    <li>• <strong>wherever</strong> = di mana pun / ke mana pun</li>
                    <li>• <strong>everywhere</strong> = di mana-mana / di setiap tempat</li>
                    <li>• <strong>anywhere</strong> = di mana saja</li>
                </ul>
                <strong class="block text-emerald-900 font-bold mt-3 mb-2 border-b pb-1 text-sm">3) Sebab / Alasan (Cause & Reason):</strong>
                <ul class="space-y-1 text-gray-700 font-mono text-[11px] sm:text-xs">
                    <li>• <strong>because / as</strong> = karena / sebab</li>
                    <li>• <strong>since</strong> = karena / mengingat bahwa</li>
                    <li>• <strong>in that</strong> = karena / dalam hal bahwa</li>
                    <li>• <strong>for</strong> = karena (formal di awal/tengah)</li>
                    <li>• <strong>seeing that / seeing as</strong> = mengingat bahwa / lantaran</li>
                    <li>• <strong>now that</strong> = sekarang setelah / karena sekarang</li>
                </ul>
            </div>

            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
                <strong class="block text-purple-900 font-bold mb-2 border-b pb-1 text-sm">4) Hasil / Akibat (Effect & Result):</strong>
                <ul class="space-y-1 text-gray-700 font-mono text-[11px] sm:text-xs">
                    <li>• <strong>so + adj/adv + that</strong> = sangat... sehingga...</li>
                    <li>• <strong>such + NP + that</strong> = sangat... sehingga...</li>
                    <li>• <strong>so that</strong> = sehingga / akibatnya</li>
                </ul>
                <strong class="block text-purple-900 font-bold mt-3 mb-2 border-b pb-1 text-sm">5) Tujuan (Purpose):</strong>
                <ul class="space-y-1 text-gray-700 font-mono text-[11px] sm:text-xs">
                    <li>• <strong>so that / in order that</strong> = agar / supaya</li>
                    <li>• <strong>in order to / so as to (+V1)</strong> = agar / untuk</li>
                    <li>• <strong>for fear that / lest</strong> = karena takut bahwa / jangan sampai</li>
                </ul>
            </div>

            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
                <strong class="block text-amber-900 font-bold mb-2 border-b pb-1 text-sm">6) Syarat / Pengandaian (Condition):</strong>
                <ul class="space-y-1 text-gray-700 font-mono text-[11px] sm:text-xs">
                    <li>• <strong>if</strong> = jika / jikalau / bila</li>
                    <li>• <strong>unless</strong> = kecuali jika / jika tidak</li>
                    <li>• <strong>provided that / providing that</strong> = asalkan / dengan syarat bahwa</li>
                    <li>• <strong>on condition that / as long as</strong> = dengan syarat / asalkan</li>
                    <li>• <strong>in case (that)</strong> = untuk jaga-jaga jika / antisipasi</li>
                    <li>• <strong>only if</strong> = hanya jika</li>
                    <li>• <strong>whether or not</strong> = apakah... atau tidak</li>
                    <li>• <strong>even if</strong> = meskipun / walaupun jika</li>
                </ul>
            </div>

            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
                <strong class="block text-rose-900 font-bold mb-2 border-b pb-1 text-sm">7) Pertentangan / Konsesi (Concession & Contrast):</strong>
                <ul class="space-y-1 text-gray-700 font-mono text-[11px] sm:text-xs">
                    <li>• <strong>although / even though / though</strong> = meskipun / walaupun</li>
                    <li>• <strong>while / whereas</strong> = sedangkan / sementara itu / sebaliknya</li>
                    <li>• <strong>despite the fact that</strong> = meskipun kenyataan bahwa</li>
                    <li>• <strong>much as</strong> = sungguhpun / betapapun</li>
                    <li>• <strong>no matter how / what</strong> = tak peduli seberapa / apa pun</li>
                </ul>
            </div>

            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
                <strong class="block text-teal-900 font-bold mb-2 border-b pb-1 text-sm">8) Cara / Gaya (Manner):</strong>
                <ul class="space-y-1 text-gray-700 font-mono text-[11px] sm:text-xs font-semibold">
                    <li>• <strong>as / just as</strong> = sebagaimana / seperti / persis seperti</li>
                    <li>• <strong>as if / as though</strong> = seolah-olah / seakan-akan</li>
                    <li>• <strong>in the way that</strong> = dengan cara seperti</li>
                </ul>
                <strong class="block text-teal-900 font-bold mt-3 mb-2 border-b pb-1 text-sm">9) Perbandingan & 10) Skala (Comparison & Scale):</strong>
                <ul class="space-y-1 text-gray-700 font-mono text-[11px] sm:text-xs">
                    <li>• <strong>than</strong> = daripada | <strong>as... as</strong> = sama... seperti</li>
                    <li>• <strong>in proportion as</strong> = sebanding dengan / seiring dengan</li>
                    <li>• <strong>the more..., the more...</strong> = semakin..., semakin...</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Hukum Utama Adverbial Clause:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed"><strong>Rumus Utama Jumlah Verb:</strong> <strong>Total Verb Asli (Tenses) = Total Conjunction + 1</strong>.</li>
            <li class="leading-relaxed">Adverbial Clause berfungsi sebagai kata keterangan (Adverb) yang menjelaskan waktu, tempat, sebab, akibat, syarat, pertentangan, tujuan, cara, perbandingan, atau skala.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
             Aturan Emas Pembeda Preposisi vs Konjungsi:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed"><strong>because / although / while</strong> <u>WAJIB</u> diikuti Klausa (<strong>Subjek + Verb</strong>).</li>
            <li class="leading-relaxed"><strong>because of / despite / in spite of</strong> <u>WAJIB</u> diikuti Noun / Noun Phrase / Gerund (tanpa Verb tenses).</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Bedakan: because the climate changed (S+V) vs because of climate change (NP).</em>
    </div>
    
HTML
],
            7 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Pola Adjective Clause - RPS & RPO (Klausa Kata Sifat)
        </h5>
        
        <div class="bg-blue-100 border border-blue-200 rounded-xl p-4 mb-4 shadow-xs" style="background-color: #dbeafe !important;">
            <div class="flex items-center gap-2 mb-2">
                <span class="text-base"></span>
                <h6 class="text-xs uppercase tracking-wider font-bold text-blue-900">Formula / Pola Dasar Adjective Clause:</h6>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs sm:text-sm font-mono">
                <div class="bg-white p-3 rounded-lg border border-blue-100 text-gray-900 shadow-xs">
                    <span class="font-bold text-blue-800 font-sans block mb-1">1. Pola RPS (Relative Pronoun Subject):</span>
                    <span class="px-2 py-1 bg-gray-100 rounded text-blue-900 font-bold">Pola RPS = Conjunction + Verb</span>
                    <span class="block text-xs font-sans text-gray-600 mt-1.5 italic">(Contoh: who + Verb / which + Verb)</span>
                </div>
                <div class="bg-white p-3 rounded-lg border border-blue-100 text-gray-900 shadow-xs">
                    <span class="font-bold text-blue-800 font-sans block mb-1">2. Pola RPO (Relative Pronoun Object):</span>
                    <span class="px-2 py-1 bg-gray-100 rounded text-blue-900 font-bold">Pola RPO = Conjunction + S + V</span>
                    <span class="block text-xs font-sans text-gray-600 mt-1.5 italic">(Contoh: who / whom + S + V / which + S + V)</span>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Jenis Relative Pronoun</th><th class="p-3.5 font-semibold border-b border-gray-700">Fungsi Gramatikal</th><th class="p-3.5 font-semibold border-b border-gray-700">Formula Klausa</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat Akademik</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Relative Pronoun Subject (RPS)</td><td class="p-3.5 text-gray-800">Menggantikan Subjek Orang</td><td class="p-3.5 text-gray-800">who + Verb</td><td class="p-3.5 italic text-gray-600">Architects who design green buildings won sustainability awards.</td></tr>
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Relative Pronoun Subject (RPS)</td><td class="p-3.5 text-gray-800">Menggantikan Subjek Benda</td><td class="p-3.5 text-gray-800">which / that + Verb</td><td class="p-3.5 italic text-gray-600">Chemical elements which have high atomic numbers are unstable.</td></tr>
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Relative Pronoun Object (RPO)</td><td class="p-3.5 text-gray-800">Menggantikan Objek Orang</td><td class="p-3.5 text-gray-800">who / whom / that + S + V</td><td class="p-3.5 italic text-gray-600">Candidates who / whom the committee chose have extensive financial experience.</td></tr>
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Relative Pronoun Object (RPO)</td><td class="p-3.5 text-gray-800">Menggantikan Objek Benda</td><td class="p-3.5 text-gray-800">which / that + S + V</td><td class="p-3.5 italic text-gray-600">Research methodology which the author used was verified by experts.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Gunakan <strong>who</strong> untuk manusia sebagai subjek (Pola RPS: <code>who + Verb</code>) maupun objek (Pola RPO: <code>who + S + V</code>).</li>
            <li class="leading-relaxed">Gunakan <strong>whom</strong> khusus untuk manusia sebagai objek secara formal (Pola RPO: <code>whom + Subject + Verb</code>).</li>
            <li class="leading-relaxed">Gunakan <strong>which / that</strong> untuk benda/hewan baik sebagai subjek (RPS: <code>which + Verb</code>) maupun objek (RPO: <code>which + Subject + Verb</code>).</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed"><strong>Pola RPS (Subject):</strong> <code class="bg-amber-50 text-amber-900 px-1.5 py-0.5 rounded font-mono text-xs">Conjunction + Verb</code> (Setelah <strong>who / which / that</strong> langsung diikuti Kata Kerja / Verb).</li>
            <li class="leading-relaxed"><strong>Pola RPO (Object):</strong> <code class="bg-amber-50 text-amber-900 px-1.5 py-0.5 rounded font-mono text-xs">Conjunction + Subject + Verb</code> (Setelah <strong>who / whom / which / that</strong> diikuti Subjek baru + Verb).</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: RPS = Conjunction + Verb (who discovered) | RPO = Conjunction + S + V (who/whom they chose | which we collect).</em>
    </div>
    
HTML
],
            8 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Pola Adjective Clause - RPO, RA, & Reduced Clause
        </h5>

        <div class="bg-blue-100 border border-blue-200 rounded-xl p-4 mb-4 shadow-xs" style="background-color: #dbeafe !important;">
            <div class="flex items-center gap-2 mb-2">
                <span class="text-base"></span>
                <h6 class="text-xs uppercase tracking-wider font-bold text-blue-900">Formula / Pola Dasar Adjective Clause (RPO, RA, & Reduced):</h6>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs font-mono">
                <div class="bg-white p-3 rounded-lg border border-blue-100 text-gray-900 shadow-xs">
                    <span class="font-bold text-blue-800 font-sans block mb-1">1. Pola RPO (Relative Pronoun Object):</span>
                    <span class="px-2 py-1 bg-gray-100 rounded text-blue-900 font-bold">RPO = Conjunction + S + V</span>
                    <span class="block text-xs font-sans text-gray-600 mt-1.5 italic">(whom/which + Subject + Verb)</span>
                </div>
                <div class="bg-white p-3 rounded-lg border border-blue-100 text-gray-900 shadow-xs">
                    <span class="font-bold text-blue-800 font-sans block mb-1">2. Pola RA (Relative Adverb):</span>
                    <span class="px-2 py-1 bg-gray-100 rounded text-blue-900 font-bold">RA = Conjunction + S + V</span>
                    <span class="block text-xs font-sans text-gray-600 mt-1.5 italic">(where/when/why + Subject + Verb)</span>
                </div>
                <div class="bg-white p-3 rounded-lg border border-blue-100 text-gray-900 shadow-xs">
                    <span class="font-bold text-blue-800 font-sans block mb-1">3. Pola Reduced Clause:</span>
                    <span class="px-2 py-1 bg-gray-100 rounded text-blue-900 font-bold">Aktif: V-ing | Pasif: V3</span>
                    <span class="block text-xs font-sans text-gray-600 mt-1.5 italic">(Hapus Pronoun + Be)</span>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Jenis Klausa</th><th class="p-3.5 font-semibold border-b border-gray-700">Pronoun / Adverb</th><th class="p-3.5 font-semibold border-b border-gray-700">Formula Klausa</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat Akademik</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Relative Pronoun Object (RPO)</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">whom (orang) / which (benda)</td><td class="p-3.5 text-gray-800">whom/which + Subject + Verb</td><td class="p-3.5 italic text-gray-600">The methodology which authors used has been verified.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Relative Adverb (RA)</td><td class="p-3.5 text-gray-800">where (tempat) / when (waktu) / why (alasan)</td><td class="p-3.5 text-gray-800">where/when/why + Subject + Verb</td><td class="p-3.5 italic text-gray-600">The laboratory where experiments were conducted has high standards.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Reduced Clause (Aktif)</td><td class="p-3.5 text-gray-800">Penghapusan Pronoun + Be</td><td class="p-3.5 text-gray-800">V-ing (Present Participle)</td><td class="p-3.5 italic text-gray-600">Spesies living in oceans possess unique adaptation.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Reduced Clause (Pasif)</td><td class="p-3.5 text-gray-800">Penghapusan Pronoun + Be</td><td class="p-3.5 text-gray-800">V3 (Past Participle)</td><td class="p-3.5 italic text-gray-600">The data collected from the survey shows growth.</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Relative Pronoun Object (whom/which) dapat dihilangkan dalam gaya penulisan ringkas.</li><li class="leading-relaxed">Klausa dapat diraduksi menjadi Participle jika Relative Pronoun berfungsi sebagai Subjek.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Reduksi Aktif: Relative Pronoun + Active Verb → <strong>V-ing</strong> (<em>who live → living</em>).</li><li class="leading-relaxed">Reduksi Pasif: Relative Pronoun + Passive Verb → <strong>V3</strong> (<em>which was collected → collected</em>).</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Reduksi hanya bisa dilakukan jika relative pronoun berfungsi sebagai subjek klausa!</em>
    </div>
    
HTML
],
            9 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            <span class="bg-blue-600 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold shadow-xs">📌</span>
            Pola Noun Clause (Klausa Kata Benda)
        </h5>

        <div class="bg-blue-100 border border-blue-200 rounded-xl p-4 mb-4 shadow-xs" style="background-color: #dbeafe !important;">
            <div class="flex items-center gap-2 mb-2">
                <h6 class="text-xs uppercase tracking-wider font-bold text-blue-900">Formula / Pola Dasar Noun Clause:</h6>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs font-mono">
                <div class="bg-white p-3 rounded-lg border border-blue-100 text-gray-900 shadow-xs">
                    <span class="font-bold text-blue-800 font-sans block mb-1">1. Pola Noun Clause (Standar):</span>
                    <span class="px-2 py-1 bg-gray-100 rounded text-blue-900 font-bold">Pola NC = Conjunction + Subject + Verb</span>
                    <span class="block text-xs font-sans text-gray-600 mt-1.5 italic">(Contoh: that / how / why + S + V)</span>
                </div>
                <div class="bg-white p-3 rounded-lg border border-blue-100 text-gray-900 shadow-xs">
                    <span class="font-bold text-blue-800 font-sans block mb-1">2. Pola Noun Clause (Sebagai Subjek):</span>
                    <span class="px-2 py-1 bg-gray-100 rounded text-blue-900 font-bold">Pola NC = Conjunction + Verb</span>
                    <span class="block text-xs font-sans text-gray-600 mt-1.5 italic">(Contoh: what happened / who came)</span>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm min-w-[720px]">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700 w-1/4">Jenis Noun Clause</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700 min-w-[220px]">Kata Hubung & Makna Indonesia</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700 min-w-[200px]">Formula Klausa</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700 min-w-[220px]">Contoh Kalimat Akademik</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">That-Clause (Pernyataan)</td>
                            <td class="p-3.5 text-gray-800"><strong class="text-blue-700 font-mono">that</strong> = <em>bahwa</em></td>
                            <td class="p-3.5 text-blue-900 font-mono text-xs whitespace-nowrap">that + Subject + Verb</td>
                            <td class="p-3.5 italic text-gray-600">Researchers discovered <u>that climate change affects biodiversity</u>.</td>
                        </tr>
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">If / Whether Clause (Pilihan / Keraguan)</td>
                            <td class="p-3.5 text-gray-800"><strong class="text-blue-700 font-mono">whether / if</strong> = <em>apakah</em></td>
                            <td class="p-3.5 text-blue-900 font-mono text-xs whitespace-nowrap">whether / if + Subject + Verb</td>
                            <td class="p-3.5 italic text-gray-600">Students ask <u>whether the theory is still relevant</u> today.</td>
                        </tr>
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Question Word Clause (Informasi)</td>
                            <td class="p-3.5 text-gray-800">
                                <div class="space-y-1 text-xs">
                                    <div>• <strong class="text-blue-700 font-mono">what</strong> = <em>apa / apa yang</em></div>
                                    <div>• <strong class="text-blue-700 font-mono">where</strong> = <em>di mana / ke mana</em></div>
                                    <div>• <strong class="text-blue-700 font-mono">when</strong> = <em>kapan / waktu ketika</em></div>
                                    <div>• <strong class="text-blue-700 font-mono">why</strong> = <em>mengapa / kenapa</em></div>
                                    <div>• <strong class="text-blue-700 font-mono">how</strong> = <em>bagaimana / cara bagaimana</em></div>
                                    <div>• <strong class="text-blue-700 font-mono">who / whom / whose</strong> = <em>siapa / milik siapa</em></div>
                                    <div>• <strong class="text-blue-700 font-mono">which</strong> = <em>yang mana</em></div>
                                </div>
                            </td>
                            <td class="p-3.5 text-blue-900 font-mono text-xs">
                                <div>1) Q-Word + S + V</div>
                                <div class="mt-1">2) Q-Word (S) + V</div>
                            </td>
                            <td class="p-3.5 italic text-gray-600">
                                <div>Astronomers observe <u>how black holes absorb surrounding matter</u>.</div>
                                <div class="mt-1.5">We still don't know <u>what happened</u>.</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2 mt-6">
            <span class="bg-blue-600 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold shadow-xs">📖</span>
            Daftar Lengkap Conjunction Noun Clause & Artinya
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4 text-xs sm:text-sm">
            <div class="bg-white p-3.5 rounded-xl border border-gray-200 shadow-xs space-y-1.5 text-gray-800">
                <div>• <strong class="text-blue-700 font-mono">that</strong> = <em>bahwa</em> (menyatakan fakta/pernyataan)</div>
                <div>• <strong class="text-blue-700 font-mono">whether / if</strong> = <em>apakah</em> (menyatakan keraguan/pilihan)</div>
                <div>• <strong class="text-blue-700 font-mono">what</strong> = <em>apa / apa yang</em></div>
                <div>• <strong class="text-blue-700 font-mono">where</strong> = <em>di mana / ke mana</em></div>
                <div>• <strong class="text-blue-700 font-mono">when</strong> = <em>kapan / waktu ketika</em></div>
                <div>• <strong class="text-blue-700 font-mono">why</strong> = <em>mengapa / alasan kenapa</em></div>
                <div>• <strong class="text-blue-700 font-mono">how</strong> = <em>bagaimana / cara bagaimana</em></div>
            </div>
            <div class="bg-white p-3.5 rounded-xl border border-gray-200 shadow-xs space-y-1.5 text-gray-800">
                <div>• <strong class="text-blue-700 font-mono">who</strong> = <em>siapa</em> (sebagai Subjek orang)</div>
                <div>• <strong class="text-blue-700 font-mono">whom</strong> = <em>siapa</em> (sebagai Objek orang)</div>
                <div>• <strong class="text-blue-700 font-mono">whose</strong> = <em>milik siapa / kepemilikan</em></div>
                <div>• <strong class="text-blue-700 font-mono">which</strong> = <em>yang mana</em></div>
                <div>• <strong class="text-blue-700 font-mono">whatever</strong> = <em>apa pun yang</em></div>
                <div>• <strong class="text-blue-700 font-mono">whoever</strong> = <em>siapa pun yang</em></div>
                <div>• <strong class="text-blue-700 font-mono">whichever</strong> = <em>yang mana pun</em></div>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            💡 Tips & Panduan Pemahaman Noun Clause:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Noun Clause dapat menempati posisi <strong>Subjek</strong> kalimat (<em><u>What you said</u> is true</em>) atau posisi <strong>Objek</strong> kata kerja (<em>I know <u>that you are right</u></em>).</li>
            <li class="leading-relaxed">Jika dalam bahasa Indonesia terdapat kata <strong>"bahwa"</strong>, gunakan konjungsi <strong class="font-mono">that</strong>.</li>
            <li class="leading-relaxed">Jika dalam bahasa Indonesia terdapat kata <strong>"apakah"</strong> di tengah kalimat pernyataan (bukan kalimat tanya langsung), gunakan konjungsi <strong class="font-mono">whether / if</strong>.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            ⚠️ Aturan & Formula Penting Noun Clause:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Urutan kata dalam Noun Clause <u>WAJIB</u> berbentuk <strong>kalimat berita (Subject + Verb)</strong>, bukan susunan kalimat tanya (tidak boleh ada auxiliary sebelum subjek)!</li>
            <li class="leading-relaxed"><s>why did the system fail</s> → <strong>why the system failed</strong>.</li>
            <li class="leading-relaxed"><s>where does he live</s> → <strong>where he lives</strong>.</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Format benar: how black holes absorb | why politics increases | whether Mars contains water.</em>
    </div>
    
HTML
],
            10 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Sintesis Kompleksitas Kalimat Akademik (Complexity Track)
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Tipe Kalimat Kompleks</th><th class="p-3.5 font-semibold border-b border-gray-700">Struktur Utuh</th><th class="p-3.5 font-semibold border-b border-gray-700">Fokus Aplikasi Penulisan</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat Akademik</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Complex Comparison</td><td class="p-3.5 text-gray-800">Superlative + Reduced Adj Clause</td><td class="p-3.5 text-gray-800">Penulisan klausa sains</td><td class="p-3.5 italic text-gray-600">Jupiter is the largest planet orbiting our sun.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Complex Adverbial + Passive</td><td class="p-3.5 text-gray-800">Adverbial Clause + Passive Main Clause</td><td class="p-3.5 text-gray-800">Penulisan esai argumen</td><td class="p-3.5 italic text-gray-600">Although technology is advanced, space missions carry high risk.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Complex Noun Clause + Inversion</td><td class="p-3.5 text-gray-800">Noun Clause + Complex Object</td><td class="p-3.5 text-gray-800">Penulisan laporan akademik</td><td class="p-3.5 italic text-gray-600">Researchers still study why some species adapt faster than others.</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Selamat! Anda telah menguasai seluruh aspek kalimat kompleks (B2 Upper-Intermediate Level).</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Kombinasikan klausa dengan cermat tanpa membuat kalimat terlalu berbelit-belit (*run-on sentence*).</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Gunakan tanda baca koma dan kata hubung secara presisi dalam penulisan ilmiah.</em>
    </div>
    
HTML
],
            default => null,
        };
    }

    /**
     * Static (code-authored) question banks for the Complexity track meetings that don't
     * reuse another meetingN.blade.php - these have no stored reference translation, so
     * grammarWritingComplexityMeetingSubmit() grades them with AI instead of word-matching.
     *
     * @return array{topic: string, questions: array<int, string>, questionHelpers?: array}|null
     */
    public function complexityStaticQuestions(int $meeting): ?array
    {
        if ($meeting === 2) {
            return [
                'topic' => 'Latihan penerapan tenses',
                'questions' => [
                    'Seluruh parameter penelitian telah diselesaikan melalui proses verifikasi yang ketat.',
                    'Para kartografer sedang melakukan pemetaan komprehensif terhadap wilayah pesisir.',
                    'Karakteristik geomorfologi di wilayah pegunungan ini sangat unik.',
                    'Peradaban kuno tersebut membangun sistem irigasi yang kompleks di wilayah gersang.',
                    'Setiap elemen dalam ekosistem ini harus tetap seimbang.',
                    'Strategi mitigasi bencana sedang ditinjau kembali oleh otoritas terkait.',
                    'Ilmuwan asal Polandia tersebut telah menjadi figur sentral dalam teori fisika kuantum.',
                    'Mekanisme fotosintesis mempermudah konversi energi surya menjadi energi kimia.',
                    'Struktur birokrasi pada masa kekaisaran tersebut tidak kaku.',
                    'Naskah kuno tersebut dikirimkan ke museum pusat untuk proses preservasi digital.',
                    'Analisis spektrum cahaya dapat memberikan informasi krusial mengenai komposisi bintang.',
                    'Para arsitek telah membangun fondasi tahan guncangan pada gedung tersebut.',
                    'Kondisi atmosfer di planet tersebut sedang berada dalam tahap transisi ekstrem.',
                    'Kebijakan dekarbonisasi ekonomi wajib diimplementasikan secara global.',
                    'Tim arkeolog menemukan sisa-sisa permukiman neolitikum selama ekskavasi kemarin.',
                ],
                'questionHelpers' => $this->complexityMeeting2QuestionHelpers(),
                'paragraph' => [
                    'id' => 'Para ilmuwan di seluruh dunia terus mempelajari dinamika perubahan iklim global. Selama beberapa dekade terakhir, suhu rata-rata bumi telah meningkat secara signifikan akibat emisi gas rumah kaca. Saat ini, tim peneliti sedang menganalisis data satelit untuk memantau pencairan lapisan es di kutub. Pada tahun lalu, stasiun meteorologi mencatat rekor suhu tertinggi di berbagai belahan dunia. Jika tren pemanasan ini tidak segera dihentikan, keanekaragaman hayati laut akan mengalami kepunahan massal dalam beberapa dekade mendatang. Oleh karena itu, kebijakan transisi energi terbarukan harus diterapkan secara komprehensif oleh seluruh negara.',
                    'en' => 'Scientists around the world continue to study the dynamics of global climate change. Over the past few decades, the earth\'s average temperature has increased significantly due to greenhouse gas emissions. Currently, research teams are analyzing satellite data to monitor the melting of polar ice caps. Last year, meteorological stations recorded the highest temperature records in various parts of the world. If this warming trend is not stopped immediately, marine biodiversity will suffer mass extinction in the coming decades. Therefore, renewable energy transition policies must be implemented comprehensively by all nations.',
                    'vocab' => [
                        'climate change' => ['id' => 'perubahan iklim', 'pos' => '(n)'],
                        'average temperature' => ['id' => 'suhu rata-rata', 'pos' => '(n)'],
                        'greenhouse gas emissions' => ['id' => 'emisi gas rumah kaca', 'pos' => '(n)'],
                        'satellite data' => ['id' => 'data satelit', 'pos' => '(n)'],
                        'polar ice caps' => ['id' => 'lapisan es kutub', 'pos' => '(n)'],
                        'meteorological station' => ['id' => 'stasiun meteorologi', 'pos' => '(n)'],
                        'biodiversity' => ['id' => 'keanekaragaman hayati', 'pos' => '(n)'],
                        'mass extinction' => ['id' => 'kepunahan massal', 'pos' => '(n)'],
                        'renewable energy' => ['id' => 'energi terbarukan', 'pos' => '(n)'],
                        'comprehensively' => ['id' => 'secara komprehensif', 'pos' => '(adv)'],
                    ]
                ],
            ];
        }

        if ($meeting === 3) {
            return [
                'topic' => 'To Infinitive & Gerund',
                'questions' => [
                    'Mengembangkan vaksin baru membutuhkan waktu penelitian bertahun-tahun.',
                    'Para ilmuwan berusaha untuk memahami asal-usul alam semesta.',
                    'Menjaga keseimbangan ekosistem sangat penting untuk kelangsungan hidup spesies.',
                    'Komite menolak untuk menerima proposal riset tanpa bukti empiris yang memadai.',
                    'Memprediksi gerak benda langit secara presisi merupakan tantangan utama dalam astrofisika.',
                    'Otoritas berencana untuk mengimplementasikan kebijakan lingkungan baru bulan depan.',
                    'Mengurangi emisi karbon secara signifikan membutuhkan kerja sama antarnegara.',
                    'Perusahaan ini bertujuan untuk menciptakan teknologi energi terbarukan yang lebih efisien.',
                    'Menganalisis sampel jaringan bawah mikroskop membutuhkan ketelitian sangat tinggi.',
                    'Para peneliti berharap untuk menemukan indikasi kehidupan purba di Mars.',
                    'Memelihara keanekaragaman hayati dapat mencegah kepunahan spesies langka.',
                    'Pemerintah memutuskan untuk membatasi ekspor komoditas mentah demi hilirisasi.',
                    'Mengisolasi senyawa aktif dari tanaman obat merupakan tahap awal pembuatan obat.',
                    'Kandidat berjanji untuk meningkatkan alokasi anggaran riset dan pengembangan.',
                    'Mengkaji struktur molekul protein membantu memahami mekanisme infeksi virus.',
                ],
                'questionHelpers' => $this->complexityMeeting3QuestionHelpers(),
            ];
        }

        if ($meeting === 4) {
            return [
                'topic' => 'Comparative, superlative, positive degree',
                'questions' => [
                    'Planet Jupiter jauh lebih besar dibandingkan seluruh planet lain di tata surya kita.',
                    'Great Barrier Reef adalah struktur karang terbesar yang pernah dibangun oleh organisme hidup.',
                    'Analisis data terbaru sama akuratnya dengan prediksi matematis sebelumnya.',
                    'Sektor energi terbarukan tumbuh jauh lebih cepat daripada sektor energi fosil.',
                    'Vaksin ini dianggap sebagai salah satu penemuan medis paling krusial abad ini.',
                    'Protokol keamanan jaringan baru tidak seramai sistem lama dalam hal lalu lintas data.',
                    'Fluktuasi pasar finansial bulan ini lebih ekstrem dibandingkan periode sebelumnya.',
                    'Peradaban Mesopotamia merupakan salah satu peradaban tertua dalam sejarah manusia.',
                    'Metode eksperimen baru ini sama efektifnya dengan pendekatan konvensional.',
                    'Eksplorasi luar angkasa membutuhkan biaya jauh lebih mahal daripada proyek infrastruktur biasa.',
                    'Teleskop Hubble menghasilkan citra antariksa paling tajam yang pernah dicapai manusia.',
                    'Kapasitas memori superkomputer tersebut sama besarnya dengan gabungan seribu komputer biasa.',
                    'Gedung pencakar langit ini lebih tahan guncangan gempa daripada bangunan standar.',
                    'Spesies organisme ini memiliki tingkat adaptasi paling tinggi di lingkungan ekstrem.',
                    'Proses dekarbonisasi industri tidak semudah yang diperkirakan para pengambil kebijakan.',
                ],
                'questionHelpers' => $this->complexityMeeting4QuestionHelpers(),
            ];
        }

        if ($meeting === 5) {
            return [
                'topic' => 'Parallel Structures',
                'questions' => [
                    'Tim peneliti mengumpulkan sampel tanah, menganalisis data, dan menyusun laporan akhir.',
                    'Proyek riset ini tidak hanya membutuhkan dana besar tetapi juga memerlukan waktu yang lama.',
                    'Eksperimen tersebut dirancang dengan cermat, dilaksanakan secara presisi, dan dievaluasi dengan ketat.',
                    'Para ilmuwan harus berpikir secara kritis, bekerja dengan teliti, dan berkomunikasi dengan jelas.',
                    'Kebijakan baru ini bertujuan untuk mengurangi emisi, meningkatkan efisiensi, dan mendorong inovasi.',
                    'Teknologi energi baru ini ramah lingkungan, hemat biaya, dan mudah dioperasikan.',
                    'Analisis spektrum membantu menentukan suhu bintang, menghitung kecepatan rotasi, dan mengidentifikasi unsur kimia.',
                    'Pengemudi yang baik selalu berkendara secara hati-hati, mematuhi rambu lalu lintas, dan menghormati pengguna jalan lain.',
                    'Restrukturisasi perusahaan mencakup rasionalisasi biaya, pembaruan sistem IT, dan pelatihan ulang karyawan.',
                    'Vaksin tersebut terbukti aman untuk orang dewasa, efektif bagi lansia, dan terjangkau oleh masyarakat.',
                    'Laporan ini tidak hanya memuat data kuantitatif tetapi juga menyajikan analisis kualitatif.',
                    'Mahasiswa diharapkan membaca literatur ilmiah, melakukan analisis kritis, dan menulis esai akademik.',
                    'Strategi mitigasi mencakup pembangunan tanggul laut, penanaman mangrove, dan penataan kawasan pesisir.',
                    'Proses preservasi digital memerlukan pemindaian beresolusi tinggi, indeksasi otomatis, dan penyimpanan terenkripsi.',
                    'Peradaban kuno tersebut terkenal karena arsitekturnya yang megah, hukumnya yang adil, dan seninya yang bernilai tinggi.',
                ],
                'questionHelpers' => $this->complexityMeeting5QuestionHelpers(),
            ];
        }

        if ($meeting === 6) {
            return [
                'topic' => 'Adverbial Clause',
                'questions' => [
                    'Meskipun teknologinya canggih, misi luar angkasa itu tetap berisiko tinggi.',
                    'Suhu laut terus meningkat, sehingga banyak terumbu karang mengalami pemutihan.',
                    'Ekosistem itu runtuh karena predator utamanya punah.',
                    'Jika tingkat keasaman laut meningkat drastis, organisme bersangkang akan mengalami kerusakan.',
                    'Ketika revolusi industri terjadi, struktur sosial masyarakat berubah secara permanen.',
                    'Sementara beberapa spesies beradaptasi dengan cepat, spesies lain menghadapi ancaman kepunahan.',
                    'Sebelum instrumen tersebut digunakan, teknisi wajib melakukan kalibrasi ulang.',
                    'Supaya proses verifikasi berjalan lancar, seluruh dokumen wajib diunggah secara lengkap.',
                    'Seiring berkembangnya teknologi AI, kebutuhan akan regulasi etis semakin mendesak.',
                    'Meskipun pasokan energi terbarukan meningkat, ketergantungan pada batu bara masih tinggi.',
                    'Setelah eksperimen selesai dilakukan, tim peneliti mengunci laboratorium utama.',
                    'Apabila kadar polusi udara melampaui batas aman, aktivitas luar ruangan akan dibatasi.',
                    'Agar populasi satwa liar terlindungi, pemerintah menetapkan kawasan tersebut sebagai suaka margasatwa.',
                    'Oleh karena fluktuasi harga komoditas sangat tajam, para investor cenderung berhati-hati.',
                    'Meskipun hasil awal sangat menjanjikan, uji klinis tahap ketiga tetap harus dilaksanakan.',
                ],
                'questionHelpers' => $this->complexityMeeting6QuestionHelpers(),
            ];
        }

        if ($meeting === 7) {
            return [
                'topic' => 'Adjective Clause - RPS / RPO',
                'questions' => [
                    'Metodologi penelitian yang penulis gunakan telah diverifikasi oleh dewan pakar internasional.',
                    'Arsitek yang merancang gedung ramah lingkungan tersebut memenangkan penghargaan desain berkelanjutan.',
                    'Data statistik yang tim analis kumpulkan menunjukkan tren pertumbuhan ekonomi yang positif.',
                    'Unsur kimia yang memiliki nomor atom tertinggi bersifat sangat tidak stabil di alam.',
                    'Kandidat yang komite pilih sebagai direktur utama memiliki pengalaman luas di bidang finansial.',
                    'Para ilmuwan yang menemukan vaksin tersebut bekerja di laboratorium pusat universitas.',
                    'Dokumen sejarah yang arkeolog temukan di situs neolitikum kini disimpan di museum nasional.',
                    'Teori fisika yang menjelaskan pembentukan lubang hitam telah terbukti secara matematis.',
                    'Instrumen musik yang seniman itu mainkan terbuat dari material kayu yang sangat langka.',
                    'Spesies burung yang bermigrasi setiap musim dingin melintasi ribuan mil laut tanpa henti.',
                    'Teori sosiologi yang Marx kemukakan menjadi dasar analisis bagi banyak peneliti modern.',
                    'Perangkat lunak yang mendeteksi intrusi jaringan bekerja secara otomatis selama 24 jam.',
                    'Masalah teknis yang teknisi identifikasi pada mesin utama telah diperbaiki sepenuhnya.',
                    'Mahasiswa yang menguasai tiga bahasa asing mendapatkan prioritas dalam seleksi beasiswa.',
                    'Sampel batuan yang astronot ambil memberikan informasi penting tentang usia tata surya.',
                    'Galaksi yang terletak jutaan tahun cahaya dari Bumi memancarkan radiasi elektromagnetik kuat.',
                    'Strategi pemasaran yang manajemen terapkan berhasil meningkatkan volume penjualan tahun ini.',
                    'Kebijakan pemerintah yang mengatur penggunaan energi fosil mulai diberlakukan secara ketat.',
                    'Rekan kerja yang saya temui di konferensi internasional berasal dari institusi ternama.',
                    'Organisme yang hidup di dasar samudra memiliki kemampuan adaptasi yang luar biasa unik.',
                ],
                'questionHelpers' => $this->complexityMeeting7QuestionHelpers(),
            ];
        }

        if ($meeting === 8) {
            return [
                'topic' => 'Adjective Clause RPP, RA',
                'questions' => [
                    // A. Relative Pronoun of Possessive (Whose)
                    'Ilmuwan yang penemuan nya merevolusi dunia kedokteran mendapatkan penghargaan Nobel.',
                    'Galaksi yang massa nya sangat besar cenderung memiliki lubang hitam di pusatnya.',
                    'Perusahaan yang saham nya anjlok secara drastis segera melakukan restrukturisasi internal.',
                    'Spesies tanaman yang akar nya mampu menyerap logam berat digunakan untuk rehabilitasi lahan.',
                    'Arsitek yang rancangan nya memadukan estetika dan fungsionalitas diakui oleh dunia internasional.',
                    'Negara yang kebijakan ekonomi nya stabil menarik banyak investor asing setiap tahun.',
                    'Mahasiswa yang tesis nya diterbitkan di jurnal internasional lulus dengan pujian tertinggi.',
                    'Unsur kimia yang struktur atom nya unik menunjukkan sifat konduktivitas yang luar biasa.',
                    'Tokoh sejarah yang pengaruh nya melintasi batas negara sering menjadi subjek penelitian sosiologi.',
                    'Organisasi yang visi nya berfokus pada kemanusiaan memberikan bantuan medis ke daerah konflik.',
                    // B. Relative Adverb (Where, When, Why)
                    'Laboratorium tempat (di mana) eksperimen itu dilakukan memiliki standar keamanan tingkat tinggi.',
                    'Abad ke-18 adalah masa ketika Revolusi Industri mengubah struktur sosial masyarakat Eropa secara masif.',
                    'Tim investigasi belum menemukan alasan mengapa sistem keamanan tersebut gagal mendeteksi intrusi.',
                    'Situs arkeologi tempat fragmen tembikar itu ditemukan kini menjadi area yang dilindungi pemerintah.',
                    'Kita harus memahami momen ketika fluktuasi pasar mulai berdampak pada daya beli masyarakat lokal.',
                    'Teori sosiologi menjelaskan faktor mengapa polarisasi politik meningkat di era media digital.',
                    'Wilayah tempat ekosistem terumbu karang itu berada mengalami pemanasan suhu laut yang ekstrem.',
                    'Tahun 1945 merupakan titik balik ketika tatanan dunia baru mulai terbentuk setelah perang besar.',
                    'Peneliti sedang mempelajari penyebab mengapa bakteri tertentu menjadi resistan terhadap antibiotik.',
                    'Ruang hampa adalah lingkungan tempat gelombang suara tidak dapat merambat sama sekali.',
                ],
                'questionHelpers' => $this->complexityMeeting8QuestionHelpers(),
            ];
        }

        if ($meeting === 9) {
            return [
                'topic' => 'Noun Clause',
                'questions' => [
                    'Tim peneliti tidak mengetahui kapan fenomena vulkanik tersebut akan berakhir.',
                    'Bahwa lapisan ozon mulai membaik merupakan hasil dari kebijakan lingkungan global.',
                    'Para astronom sedang mengamati bagaimana lubang hitam melahap materi di sekitarnya.',
                    'Komite seleksi akan memutuskan siapa yang berhak menerima pendanaan riset tersebut.',
                    'Kita harus memahami mengapa stabilitas ekosistem sangat bergantung pada predator puncak.',
                    'Apa yang ditemukan oleh para arkeolog di situs tersebut mengubah sejarah peradaban kuno.',
                    'Dewan direksi belum menentukan di mana fasilitas manufaktur baru itu akan dibangun.',
                    'Analis data menjelaskan bahwa fluktuasi pasar dipengaruhi oleh sentimen investor.',
                    'Bagaimana teknologi AI memproses informasi massal tetap menjadi subjek diskusi etika.',
                    'Mahasiswa sering kali bertanya apakah teori tersebut masih relevan dengan kondisi saat ini.',
                    'Siapa yang memenangkan penghargaan Nobel tahun ini akan diumumkan pada bulan Oktober.',
                    'Eksperimen ini menunjukkan seberapa cepat bakteri dapat beradaptasi dengan antibiotik.',
                    'Mengapa suhu global meningkat secara drastis menjadi fokus utama dalam konferensi iklim.',
                    'Sistem ini secara otomatis mendeteksi apa pun yang mengancam integritas jaringan komputer.',
                    'Bahwa pendidikan adalah kunci mobilitas sosial telah diakui oleh para sosiolog dunia.',
                ],
                'questionHelpers' => $this->complexityMeeting9QuestionHelpers(),
            ];
        }

        if ($meeting === 10) {
            return [
                'topic' => 'Exam',
                'questions' => [
                    'Planet Jupiter jauh lebih besar dibandingkan seluruh planet lain di tata surya kita.',
                    'Great Barrier Reef adalah struktur karang terbesar yang pernah dibangun oleh organisme hidup.',
                    'Mengembangkan vaksin baru membutuhkan waktu penelitian bertahun-tahun.',
                    'Para ilmuwan berusaha untuk memahami asal-usul alam semesta.',
                    'Tim peneliti mengumpulkan sampel tanah, dan mereka menganalisisnya di laboratorium.',
                    'Teori itu menjelaskan banyak fenomena, tetapi masih memiliki beberapa kelemahan.',
                    'Suhu laut terus meningkat, sehingga banyak terumbu karang mengalami pemutihan.',
                    'Ekosistem itu runtuh karena predator utamanya punah.',
                    'Meskipun teknologinya canggih, misi luar angkasa itu tetap berisiko tinggi.',
                    'Ilmuwan yang menemukan partikel itu memenangkan penghargaan Nobel.',
                    'Teori yang para fisikawan uji akhirnya terbukti benar.',
                    'Perusahaan yang produknya paling inovatif mendominasi pasar teknologi.',
                    'Laboratorium tempat vaksin itu dikembangkan menerapkan standar keamanan tertinggi.',
                    'Bahwa perubahan iklim dipengaruhi oleh aktivitas manusia sudah diakui secara luas oleh komunitas ilmiah.',
                    'Para peneliti masih mempelajari mengapa beberapa spesies mampu beradaptasi lebih cepat daripada yang lain.',
                ],
                'questionHelpers' => $this->complexityMeeting10QuestionHelpers(),
            ];
        }

        return null;
    }

    /**
     * AI-based grading for grammarWritingComplexityMeeting()'s static question banks
     * (meetings 2, 7, 8, 9, 10) - these questions have no stored reference translation
     * (unlike GrammarQuestion rows elsewhere), so scoring can't use wordAccuracy(); an AI
     * judges whether each submitted English sentence is grammatically correct and applies
     * the target grammar structure for the given topic.
     */
    public function grammarWritingComplexityMeetingSubmit(Request $request, int $meeting)
    {
        $user = Auth::user();
        $isAdminOrTeacher = $user && ($user->isAdmin() || $user->isTeacher());

        if (!$isAdminOrTeacher && $user?->isStudent()) {
            $enrolledSlugs = $this->resolveGrammarEnrolledSlugs($user);
            if (!in_array('complexity-grammar-for-writing', $enrolledSlugs, true)) {
                return redirect()->route('assignments.grammar-writing.classes')
                    ->with('error', 'Anda tidak memiliki akses ke kelas Complexity Grammar for Writing.');
            }
        }

        // Meeting 1 is the "Teknik Silang" tenses-matrix exercise (shared
        // with fast-track's own meeting 1 - see
        // grammarWritingComplexityMeeting()'s meeting===1 branch), a
        // completely different question format (tenses/sentences/matrix)
        // from every other complexity meeting's simple answers[N]
        // translate-only questions below - it needs its own evaluator, not
        // this method's answers[N]-shaped grading.
        if ($meeting === 1) {
            return $this->handleComplexityMeeting1Submit($request);
        }

        $static = $this->complexityStaticQuestions($meeting);
        abort_if($static === null, 404);

        // The form field is named answers[N] (see grammar-writing-complexity-meeting
        // blade view); this used to read a 'userAnswers' key the form never sent,
        // so every submission was graded against blank answers regardless of
        // what the student actually typed.
        $userAnswers = $request->input('answers', []);
        // Only questions the student actually attempted go to the AI (and
        // count toward $scores below) - the prompt already told the AI
        // "an empty submitted_answer must score 0", but that still meant
        // every unanswered question dragged the average down instead of
        // being excluded the way "Cek Jawaban"-style partial checks need.
        $items = [];
        foreach ($static['questions'] as $i => $prompt) {
            $questionNumber = $i + 1;
            $submitted = trim((string) ($userAnswers[$questionNumber] ?? ''));
            if ($submitted === '') {
                continue;
            }
            $items[] = [
                // 1-based, matching the blade's own $results[$i + 1] lookup
                // (grammar-writing-complexity-meeting.blade.php) - this used
                // to store 0-based here, silently showing every question's
                // AI feedback shifted onto the NEXT question and dropping
                // the last question's feedback entirely.
                'index' => $questionNumber,
                'prompt_id' => $prompt,
                'submitted_answer' => $submitted,
            ];
        }

        $complexityAiEnabled = $this->isGrammarWritingAiEnabled('complexity', $meeting) && !empty($items);
        $decoded = null;
        if ($complexityAiEnabled) {
            $itemsJson = json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            $systemPrompt = 'You are a strict English grammar examiner API that strictly outputs JSON.';
            $userPrompt = "Grade each English translation below for the grammar topic \"{$static['topic']}\". For each "
                . "item, judge whether submitted_answer is a grammatically correct English translation of prompt_id "
                . "AND correctly applies the \"{$static['topic']}\" structure being practiced.\n\nItems:\n{$itemsJson}\n\n"
                . "Return ONLY a valid JSON object, no markdown: {\"results\": [{\"index\": 0, \"accuracy_score\": 85, "
                . "\"feedback\": \"one short sentence in Bahasa Indonesia explaining the score\"}, ...]}. "
                . "accuracy_score is an integer 0-100. Include exactly one entry per item, matching each item's index.";

            $decoded = \App\Services\MultiProviderAiClient::chatJson(
                ['sambanova', 'groq', 'siliconflow', 'gemini', 'openai'],
                $systemPrompt,
                $userPrompt,
                ['groq_feature' => 'writing', 'temperature' => 0.2]
            );
        }

        $aiResults = ($decoded && isset($decoded['results']) && is_array($decoded['results'])) ? $decoded['results'] : null;

        // Complexity has no deterministic fallback grader (unlike Introductory/
        // Proficiency), so when AI is disabled every ANSWERED item scores 0
        // and the submission simply waits in the teacher review queue for a
        // manual score. Unanswered items never reach this - see the
        // "answered" branch below.
        $noAiFeedback = $this->isGrammarWritingAiEnabled('complexity', $meeting)
            ? 'AI tidak dapat menilai jawaban ini, silakan coba lagi.'
            : 'Penilaian AI dinonaktifkan untuk track ini - menunggu penilaian manual dari guru.';

        $results = [];
        $scores = [];
        foreach ($static['questions'] as $i => $prompt) {
            $questionNumber = $i + 1;
            $userAnswer = trim((string) ($userAnswers[$questionNumber] ?? ''));

            if ($userAnswer === '') {
                $results[$questionNumber] = [
                    'score' => 0,
                    'feedback' => null,
                    'answered' => false,
                ];
                continue;
            }

            $aiResult = null;
            if ($aiResults) {
                foreach ($aiResults as $r) {
                    if ((int) ($r['index'] ?? -1) === $questionNumber) {
                        $aiResult = $r;
                        break;
                    }
                }
            }

            $score = $aiResult ? max(0, min(100, (int) ($aiResult['accuracy_score'] ?? 0))) : 0;
            $results[$questionNumber] = [
                'score' => $score,
                'feedback' => $aiResult['feedback'] ?? $noAiFeedback,
                'answered' => true,
            ];
            $scores[] = $score;
        }

        $finalScore = count($scores) ? (int) round(array_sum($scores) / count($scores)) : 0;

        $normalizedResults = [];
        foreach ($results as $i => $r) {
            $normalizedResults[$i] = [
                'user_answer' => $userAnswers[$i] ?? '',
                'score' => $r['score'],
                'feedback' => $r['feedback'] ?? null,
                'answered' => $r['answered'] ?? true,
            ];
        }
        $this->persistGrammarTrackScore($meeting, $finalScore, 'complexity-grammar-for-writing', ['results' => $normalizedResults, 'ai_enabled' => $complexityAiEnabled]);

        session([
            "complexity_meeting{$meeting}_submitted" => true,
            "complexity_meeting{$meeting}_results" => $results,
            "complexity_meeting{$meeting}_final_score" => $finalScore,
            "complexity_meeting{$meeting}_user_answers" => $userAnswers,
        ]);

        return redirect()->route('assignments.grammar-writing.complexity.meeting', $meeting);
    }

    /**
     * Complexity meeting 1's own evaluator - mirrors
     * GrammarWritingSessionController::meeting2Submit() (which does the
     * exact same tenses-matrix grading for fast-track's meeting 1, the
     * $track=null case), but writes to "complexity_"-prefixed session
     * keys and records the score against the Complexity program instead
     * of fast-track's. See grammarWritingComplexityMeetingSubmit()'s
     * meeting===1 branch for why this needs to be a separate method
     * rather than that one's answers[N]-shaped grading.
     */
    private function handleComplexityMeeting1Submit(Request $request): \Illuminate\Http\RedirectResponse
    {
        $track = 'complexity';
        $dataRepository = app(GrammarWritingDataRepository::class);
        $stage = session("{$track}_meeting2_stage", 1);

        $evaluation = app(EvaluateGrammarWritingMeeting2Submission::class)->handle(
            $stage,
            $request->all(),
            $dataRepository->meeting2Tenses,
            $dataRepository->meeting2TranslationSentences,
            $dataRepository->meeting2TranslationMatrix,
            (int) session("{$track}_meeting2_score_part1", 0),
            $track,
        );

        $sessionPayload = $evaluation['session'] ?? [];
        if (!empty($sessionPayload)) {
            session($sessionPayload);
        }

        if (!empty($evaluation['saveScore'])) {
            $this->persistGrammarTrackScore(
                1,
                $evaluation['totalScore'],
                'complexity-grammar-for-writing',
                $sessionPayload,
            );
        }

        return redirect()->route('assignments.grammar-writing.complexity.meeting', 1);
    }

    public function grammarWritingComplexityMeetingReset(int $meeting)
    {
        // Session keys alone used to be forgotten here, but every
        // grammarWritingComplexityMeeting()/Meeting2ViewData load also falls
        // back to the DB (MeetingScore/AssignmentDraft) whenever those exist
        // for this user+meeting, regardless of session state - so without
        // deleting those rows too, the very next page load silently
        // re-locked the page to the scored/readonly view no matter how many
        // times the student clicked "Ulangi Latihan". Only ever touches the
        // clicking user's own row.
        $userId = Auth::id();
        if ($userId) {
            try {
                $programId = \App\Models\Program::where('slug', 'complexity-grammar-for-writing')->value('id') ?? Auth::user()?->program_id;
                if ($programId) {
                    \App\Models\MeetingScore::where('user_id', $userId)
                        ->where('program_id', $programId)
                        ->where('meeting_number', $meeting)
                        ->delete();

                    \App\Models\AssignmentDraft::where('user_id', $userId)
                        ->where('program_id', $programId)
                        ->where('meeting_number', $meeting)
                        ->delete();
                }
            } catch (\Throwable $e) {}
        }

        if ($meeting === 1) {
            session()->forget([
                'complexity_meeting2_stage',
                'complexity_meeting2_results',
                'complexity_meeting2_trans_results',
                'complexity_meeting2_score_part1',
                'complexity_meeting2_score_part2',
                'complexity_meeting2_total_score',
                'complexity_meeting1_draft_answers',
                'complexity_meeting1_draft_paragraph_answer',
            ]);

            return redirect()->route('assignments.grammar-writing.complexity.meeting', 1);
        }

        session()->forget([
            "complexity_meeting{$meeting}_submitted",
            "complexity_meeting{$meeting}_results",
            "complexity_meeting{$meeting}_final_score",
            "complexity_meeting{$meeting}_user_answers",
            "complexity_meeting{$meeting}_draft_answers",
            "complexity_meeting{$meeting}_draft_paragraph_answer",
        ]);

        return redirect()->route('assignments.grammar-writing.complexity.meeting', $meeting);
    }

    private function complexityMeeting2QuestionHelpers(): array
    {
        return [
            1 => ['example' => ['id' => 'Seluruh dokumen telah diverifikasi oleh tim audit internal.', 'en' => 'All documents have been verified by the internal audit team.'], 'vocab' => ['verify' => ['id' => 'memverifikasi', 'pos' => '(v1)'], 'strict process' => ['id' => 'proses ketat', 'pos' => '(n)']]],
            2 => ['example' => ['id' => 'Para peneliti sedang memetakan area pesisir secara detail.', 'en' => 'Researchers are mapping the coastal area in detail.'], 'vocab' => ['mapping' => ['id' => 'pemetaan', 'pos' => '(n)'], 'coastal area' => ['id' => 'wilayah pesisir', 'pos' => '(n)']]],
            3 => ['example' => ['id' => 'Karakteristik geologis daerah ini sangat berbeda.', 'en' => 'The geological characteristics of this region are very different.'], 'vocab' => ['geomorphology' => ['id' => 'geomorfologi', 'pos' => '(n)'], 'mountainous' => ['id' => 'pegunungan', 'pos' => '(adj)']]],
            4 => ['example' => ['id' => 'Peradaban kuno membangun kanal irigasi di area kering.', 'en' => 'Ancient civilizations built irrigation canals in arid areas.'], 'vocab' => ['civilization' => ['id' => 'peradaban', 'pos' => '(n)'], 'arid' => ['id' => 'gersang', 'pos' => '(adj)']]],
            5 => ['example' => ['id' => 'Setiap komponen sistem harus berada dalam keseimbangan.', 'en' => 'Each system component must remain in balance.'], 'vocab' => ['element' => ['id' => 'elemen', 'pos' => '(n)'], 'balanced' => ['id' => 'seimbang', 'pos' => '(adj)']]],
            6 => ['example' => ['id' => 'Strategi mitigasi sedang ditinjau oleh lembaga terkait.', 'en' => 'The mitigation strategy is being reviewed by the relevant institution.'], 'vocab' => ['mitigation' => ['id' => 'mitigasi', 'pos' => '(n)'], 'review' => ['id' => 'meninjau', 'pos' => '(v1)']]],
            7 => ['example' => ['id' => 'Ilmuwan itu menjadi tokoh penting dalam fisika modern.', 'en' => 'That scientist became a key figure in modern physics.'], 'vocab' => ['scientist' => ['id' => 'ilmuwan', 'pos' => '(n)'], 'central figure' => ['id' => 'figur sentral', 'pos' => '(n)']]],
            8 => ['example' => ['id' => 'Fotosintesis mengubah energi cahaya menjadi energi kimia.', 'en' => 'Photosynthesis converts light energy into chemical energy.'], 'vocab' => ['photosynthesis' => ['id' => 'fotosintesis', 'pos' => '(n)'], 'converts' => ['id' => 'mengonversi', 'pos' => '(v1)']]],
            9 => ['example' => ['id' => 'Struktur administrasi pada era itu tidak terlalu kaku.', 'en' => 'The administrative structure in that era was not too rigid.'], 'vocab' => ['bureaucratic structure' => ['id' => 'struktur birokrasi', 'pos' => '(n)'], 'rigid' => ['id' => 'kaku', 'pos' => '(adj)']]],
            10 => ['example' => ['id' => 'Naskah bersejarah dikirim ke museum untuk digitalisasi.', 'en' => 'The historical manuscript was sent to the museum for digitization.'], 'vocab' => ['manuscript' => ['id' => 'naskah', 'pos' => '(n)'], 'digital preservation' => ['id' => 'preservasi digital', 'pos' => '(n)']]],
            11 => ['example' => ['id' => 'Analisis spektrum membantu menentukan unsur bintang.', 'en' => 'Spectrum analysis helps determine stellar elements.'], 'vocab' => ['spectrum analysis' => ['id' => 'analisis spektrum', 'pos' => '(n)'], 'composition' => ['id' => 'komposisi', 'pos' => '(n)']]],
            12 => ['example' => ['id' => 'Arsitek membangun fondasi antigempa untuk gedung utama.', 'en' => 'Architects built an earthquake-resistant foundation for the main building.'], 'vocab' => ['foundation' => ['id' => 'fondasi', 'pos' => '(n)'], 'earthquake-resistant' => ['id' => 'tahan guncangan', 'pos' => '(adj)']]],
            13 => ['example' => ['id' => 'Atmosfer planet itu berada dalam fase transisi ekstrem.', 'en' => 'That planet atmosphere is in an extreme transition phase.'], 'vocab' => ['atmosphere' => ['id' => 'atmosfer', 'pos' => '(n)'], 'transition phase' => ['id' => 'tahap transisi', 'pos' => '(n)']]],
            14 => ['example' => ['id' => 'Kebijakan dekarbonisasi wajib diterapkan oleh setiap negara.', 'en' => 'Decarbonization policies must be implemented by every country.'], 'vocab' => ['decarbonization' => ['id' => 'dekarbonisasi', 'pos' => '(n)'], 'implement' => ['id' => 'mengimplementasikan', 'pos' => '(v1)']]],
            15 => ['example' => ['id' => 'Tim arkeolog menemukan permukiman neolitikum saat ekskavasi.', 'en' => 'The archaeologist team discovered a Neolithic settlement during excavation.'], 'vocab' => ['archaeologist' => ['id' => 'arkeolog', 'pos' => '(n)'], 'excavation' => ['id' => 'ekskavasi', 'pos' => '(n)']]],
        ];
    }

    private function complexityMeeting4QuestionHelpers(): array
    {
        return [
            1 => ['example' => ['id' => 'Mobil ini lebih cepat daripada mobil itu.', 'en' => 'This car is faster than that car.'], 'vocab' => ['Jupiter' => ['id' => 'Jupiter', 'pos' => '(n)'], 'much larger' => ['id' => 'jauh lebih besar', 'pos' => '(adj)'], 'solar system' => ['id' => 'tata surya', 'pos' => '(n)']]],
            2 => ['example' => ['id' => 'Gunung Everest adalah gunung tertinggi di dunia.', 'en' => 'Mount Everest is the highest mountain in the world.'], 'vocab' => ['coral structure' => ['id' => 'struktur karang', 'pos' => '(n)'], 'largest' => ['id' => 'terbesar', 'pos' => '(adj)'], 'living organisms' => ['id' => 'organisme hidup', 'pos' => '(n)']]],
            3 => ['example' => ['id' => 'Dia secerdas saudaranya.', 'en' => 'She is as smart as her brother.'], 'vocab' => ['data analysis' => ['id' => 'analisis data', 'pos' => '(n)'], 'as accurate as' => ['id' => 'sama akuratnya dengan', 'pos' => '(adj)'], 'predictions' => ['id' => 'prediksi', 'pos' => '(n)']]],
            4 => ['example' => ['id' => 'Perusahaan ini berkembang lebih cepat daripada pesaingnya.', 'en' => 'This company grows faster than its competitors.'], 'vocab' => ['renewable energy' => ['id' => 'energi terbarukan', 'pos' => '(n)'], 'grows much faster' => ['id' => 'tumbuh jauh lebih cepat', 'pos' => '(v)'], 'fossil energy' => ['id' => 'energi fosil', 'pos' => '(n)']]],
            5 => ['example' => ['id' => 'Ini adalah salah satu film terbaik tahun ini.', 'en' => 'This is one of the best movies of the year.'], 'vocab' => ['vaccine' => ['id' => 'vaksin', 'pos' => '(n)'], 'most crucial' => ['id' => 'paling krusial', 'pos' => '(adj)'], 'medical discovery' => ['id' => 'penemuan medis', 'pos' => '(n)']]],
            6 => ['example' => ['id' => 'Kota ini tidak seramai Jakarta.', 'en' => 'This city is not as crowded as Jakarta.'], 'vocab' => ['security protocol' => ['id' => 'protokol keamanan', 'pos' => '(n)'], 'not as busy as' => ['id' => 'tidak seramai/sepadat', 'pos' => '(adj)'], 'data traffic' => ['id' => 'lalu lintas data', 'pos' => '(n)']]],
            7 => ['example' => ['id' => 'Cuaca hari ini lebih ekstrem daripada kemarin.', 'en' => 'Today weather is more extreme than yesterday.'], 'vocab' => ['market fluctuations' => ['id' => 'fluktuasi pasar', 'pos' => '(n)'], 'more extreme' => ['id' => 'lebih ekstrem', 'pos' => '(adj)'], 'previous period' => ['id' => 'periode sebelumnya', 'pos' => '(n)']]],
            8 => ['example' => ['id' => 'Gedung ini adalah salah satu bangunan tertua di kota.', 'en' => 'This building is one of the oldest structures in the city.'], 'vocab' => ['civilization' => ['id' => 'peradaban', 'pos' => '(n)'], 'one of the oldest' => ['id' => 'salah satu yang tertua', 'pos' => '(adj)'], 'human history' => ['id' => 'sejarah manusia', 'pos' => '(n)']]],
            9 => ['example' => ['id' => 'Metode ini sama efektifnya dengan metode lama.', 'en' => 'This method is as effective as the old method.'], 'vocab' => ['experimental method' => ['id' => 'metode eksperimen', 'pos' => '(n)'], 'as effective as' => ['id' => 'sama efektifnya dengan', 'pos' => '(adj)'], 'conventional approach' => ['id' => 'pendekatan konvensional', 'pos' => '(n)']]],
            10 => ['example' => ['id' => 'Rumah ini lebih mahal daripada apartment tersebut.', 'en' => 'This house is more expensive than that apartment.'], 'vocab' => ['space exploration' => ['id' => 'eksplorasi luar angkasa', 'pos' => '(n)'], 'much more expensive' => ['id' => 'jauh lebih mahal', 'pos' => '(adj)'], 'infrastructure project' => ['id' => 'proyek infrastruktur', 'pos' => '(n)']]],
            11 => ['example' => ['id' => 'Kamera ini menghasilkan foto paling tajam.', 'en' => 'This camera produces the sharpest photos.'], 'vocab' => ['Hubble telescope' => ['id' => 'teleskop Hubble', 'pos' => '(n)'], 'sharpest images' => ['id' => 'citra paling tajam', 'pos' => '(n)'], 'achieve' => ['id' => 'mencapai', 'pos' => '(v1)']]],
            12 => ['example' => ['id' => 'Kapasitas tangki ini sama besarnya dengan dua drum.', 'en' => 'This tank capacity is as large as two drums.'], 'vocab' => ['memory capacity' => ['id' => 'kapasitas memori', 'pos' => '(n)'], 'as large as' => ['id' => 'sama besarnya dengan', 'pos' => '(adj)'], 'combine' => ['id' => 'menggabungkan', 'pos' => '(v1)']]],
            13 => ['example' => ['id' => 'Bahan ini lebih tahan panas daripada plastik.', 'en' => 'This material is more heat-resistant than plastic.'], 'vocab' => ['skyscraper' => ['id' => 'pencakar langit', 'pos' => '(n)'], 'more resistant' => ['id' => 'lebih tahan', 'pos' => '(adj)'], 'earthquake shock' => ['id' => 'guncangan gempa', 'pos' => '(n)']]],
            14 => ['example' => ['id' => 'Pohon ini memiliki daya tahan paling tinggi.', 'en' => 'This tree has the highest resilience.'], 'vocab' => ['organism species' => ['id' => 'spesies organisme', 'pos' => '(n)'], 'highest adaptation level' => ['id' => 'tingkat adaptasi paling tinggi', 'pos' => '(n)'], 'extreme environment' => ['id' => 'lingkungan ekstrem', 'pos' => '(n)']]],
            15 => ['example' => ['id' => 'Ujian ini tidak semudah yang diperkirakan.', 'en' => 'This exam is not as easy as expected.'], 'vocab' => ['decarbonization process' => ['id' => 'proses dekarbonisasi', 'pos' => '(n)'], 'not as easy as' => ['id' => 'tidak semudah', 'pos' => '(adj)'], 'policymakers' => ['id' => 'pengambil kebijakan', 'pos' => '(n)']]],
        ];
    }

    private function complexityMeeting3QuestionHelpers(): array
    {
        return [
            1 => ['example' => ['id' => 'Belajar bahasa baru membutuhkan kesabaran.', 'en' => 'Learning a new language requires patience.'], 'vocab' => ['vaccine' => ['id' => 'vaksin', 'pos' => '(n)'], 'develop' => ['id' => 'mengembangkan', 'pos' => '(v1)'], 'years of research' => ['id' => 'penelitian bertahun-tahun', 'pos' => '(n)']]],
            2 => ['example' => ['id' => 'Dia berusaha untuk menyelesaikan tugasnya tepat waktu.', 'en' => 'He strives to finish his task on time.'], 'vocab' => ['strive to' => ['id' => 'berusaha untuk', 'pos' => '(v)'], 'understand' => ['id' => 'memahami', 'pos' => '(v)'], 'origin of universe' => ['id' => 'asal-usul alam semesta', 'pos' => '(n)']]],
            3 => ['example' => ['id' => 'Menjaga kebersihan itu penting.', 'en' => 'Maintaining cleanliness is important.'], 'vocab' => ['ecosystem balance' => ['id' => 'keseimbangan ekosistem', 'pos' => '(n)'], 'crucial' => ['id' => 'sangat penting', 'pos' => '(adj)'], 'species survival' => ['id' => 'kelangsungan hidup spesies', 'pos' => '(n)']]],
            4 => ['example' => ['id' => 'Manajer menolak untuk menandatangani kontrak itu.', 'en' => 'The manager refused to sign that contract.'], 'vocab' => ['committee' => ['id' => 'komite', 'pos' => '(n)'], 'refused to accept' => ['id' => 'menolak untuk menerima', 'pos' => '(v)'], 'empirical evidence' => ['id' => 'bukti empiris', 'pos' => '(n)']]],
            5 => ['example' => ['id' => 'Memprediksi cuaca secara tepat sangat sulit.', 'en' => 'Predicting the weather accurately is very difficult.'], 'vocab' => ['predict' => ['id' => 'memprediksi', 'pos' => '(v1)'], 'celestial bodies' => ['id' => 'benda langit', 'pos' => '(n)'], 'astrophysics' => ['id' => 'astrofisika', 'pos' => '(n)']]],
            6 => ['example' => ['id' => 'Pemerintah berencana untuk membangun bandara baru.', 'en' => 'The government plans to build a new airport.'], 'vocab' => ['authority' => ['id' => 'otoritas', 'pos' => '(n)'], 'plans to implement' => ['id' => 'berencana untuk mengimplementasikan', 'pos' => '(v)'], 'environmental policy' => ['id' => 'kebijakan lingkungan', 'pos' => '(n)']]],
            7 => ['example' => ['id' => 'Mengurangi sampah plastik adalah tanggung jawab bersama.', 'en' => 'Reducing plastic waste is a shared responsibility.'], 'vocab' => ['reducing carbon emissions' => ['id' => 'mengurangi emisi karbon', 'pos' => '(n)'], 'significantly' => ['id' => 'secara signifikan', 'pos' => '(adv)'], 'international cooperation' => ['id' => 'kerja sama antarnegara', 'pos' => '(n)']]],
            8 => ['example' => ['id' => 'Tim ini bertujuan untuk memenangkan kompetisi.', 'en' => 'This team aims to win the competition.'], 'vocab' => ['aims to create' => ['id' => 'bertujuan untuk menciptakan', 'pos' => '(v)'], 'renewable energy' => ['id' => 'energi terbarukan', 'pos' => '(n)'], 'more efficient' => ['id' => 'lebih efisien', 'pos' => '(adj)']]],
            9 => ['example' => ['id' => 'Menganalisis data rumit butuh ketelitian.', 'en' => 'Analyzing complex data requires precision.'], 'vocab' => ['tissue samples' => ['id' => 'sampel jaringan', 'pos' => '(n)'], 'microscope' => ['id' => 'mikroskop', 'pos' => '(n)'], 'high accuracy' => ['id' => 'ketelitian tinggi', 'pos' => '(n)']]],
            10 => ['example' => ['id' => 'Siswa berharap untuk mendapat nilai bagus.', 'en' => 'Students hope to get good grades.'], 'vocab' => ['researchers' => ['id' => 'para peneliti', 'pos' => '(n)'], 'hope to discover' => ['id' => 'berharap untuk menemukan', 'pos' => '(v)'], 'ancient life' => ['id' => 'kehidupan purba', 'pos' => '(n)']]],
            11 => ['example' => ['id' => 'Memelihara hutan mencegah tanah longsor.', 'en' => 'Preserving forests prevents landslides.'], 'vocab' => ['biodiversity' => ['id' => 'keanekaragaman hayati', 'pos' => '(n)'], 'extinction' => ['id' => 'kepunahan', 'pos' => '(n)'], 'rare species' => ['id' => 'spesies langka', 'pos' => '(n)']]],
            12 => ['example' => ['id' => 'Presiden memutuskan untuk menunda rapat.', 'en' => 'The president decided to postpone the meeting.'], 'vocab' => ['decided to limit' => ['id' => 'memutuskan untuk membatasi', 'pos' => '(v)'], 'raw commodities' => ['id' => 'komoditas mentah', 'pos' => '(n)'], 'downstream processing' => ['id' => 'hilirisasi', 'pos' => '(n)']]],
            13 => ['example' => ['id' => 'Mengisolasi zat beracun sangat berbahaya.', 'en' => 'Isolating toxic substances is very dangerous.'], 'vocab' => ['active compound' => ['id' => 'senyawa aktif', 'pos' => '(n)'], 'medicinal plants' => ['id' => 'tanaman obat', 'pos' => '(n)'], 'drug manufacturing' => ['id' => 'pembuatan obat', 'pos' => '(n)']]],
            14 => ['example' => ['id' => 'Walikota berjanji untuk memperbaiki jalan.', 'en' => 'The mayor promised to repair the roads.'], 'vocab' => ['candidate' => ['id' => 'kandidat', 'pos' => '(n)'], 'promised to increase' => ['id' => 'berjanji untuk meningkatkan', 'pos' => '(v)'], 'R&D budget' => ['id' => 'anggaran riset & pengembangan', 'pos' => '(n)']]],
            15 => ['example' => ['id' => 'Mengkaji teks sejarah membantu memahami masa lalu.', 'en' => 'Studying historical texts helps understand the past.'], 'vocab' => ['study' => ['id' => 'mengkaji', 'pos' => '(v1)'], 'protein molecular structure' => ['id' => 'struktur molekul protein', 'pos' => '(n)'], 'viral infection' => ['id' => 'infeksi virus', 'pos' => '(n)']]],
        ];
    }

    private function complexityMeeting5QuestionHelpers(): array
    {
        return [
            1 => ['example' => ['id' => 'Dia membaca buku, menulis ringkasan, dan mengirimkannya.', 'en' => 'She reads the book, writes a summary, and submits it.'], 'vocab' => ['soil samples' => ['id' => 'sampel tanah', 'pos' => '(n)'], 'analyze data' => ['id' => 'menganalisis data', 'pos' => '(v1)'], 'final report' => ['id' => 'laporan akhir', 'pos' => '(n)']]],
            2 => ['example' => ['id' => 'Gedung ini tidak hanya megah tetapi juga kuat.', 'en' => 'This building is not only majestic but also strong.'], 'vocab' => ['not only... but also' => ['id' => 'tidak hanya... tetapi juga', 'pos' => '(conj)'], 'large funding' => ['id' => 'dana besar', 'pos' => '(n)'], 'long time' => ['id' => 'waktu lama', 'pos' => '(n)']]],
            3 => ['example' => ['id' => 'Tugas ini dibuat dengan rapi, diketik dengan benar, dan dikumpul tepat waktu.', 'en' => 'This task was made neatly, typed correctly, and submitted on time.'], 'vocab' => ['design carefully' => ['id' => 'merancang dengan cermat', 'pos' => '(v1)'], 'execute precisely' => ['id' => 'melaksanakan secara presisi', 'pos' => '(v1)'], 'evaluate strictly' => ['id' => 'mengevaluasi dengan ketat', 'pos' => '(v1)']]],
            4 => ['example' => ['id' => 'Siswa harus belajar giat, datang tepat waktu, dan mendengarkan guru.', 'en' => 'Students must study hard, arrive on time, and listen to the teacher.'], 'vocab' => ['think critically' => ['id' => 'berpikir secara kritis', 'pos' => '(v)'], 'work thoroughly' => ['id' => 'bekerja dengan teliti', 'pos' => '(v)'], 'communicate clearly' => ['id' => 'berkomunikasi dengan jelas', 'pos' => '(v)']]],
            5 => ['example' => ['id' => 'Program ini bertujuan untuk melatih siswa, menguji skill, dan memberi sertifikat.', 'en' => 'This program aims to train students, test skills, and award certificates.'], 'vocab' => ['reduce emissions' => ['id' => 'mengurangi emisi', 'pos' => '(v)'], 'increase efficiency' => ['id' => 'meningkatkan efisiensi', 'pos' => '(v)'], 'foster innovation' => ['id' => 'mendorong inovasi', 'pos' => '(v)']]],
            6 => ['example' => ['id' => 'Mobil ini cepat, aman, dan nyaman.', 'en' => 'This car is fast, safe, and comfortable.'], 'vocab' => ['eco-friendly' => ['id' => 'ramah lingkungan', 'pos' => '(adj)'], 'cost-effective' => ['id' => 'hemat biaya', 'pos' => '(adj)'], 'easy to operate' => ['id' => 'mudah dioperasikan', 'pos' => '(adj)']]],
            7 => ['example' => ['id' => 'Aplikasi ini membantu mencatat transaksi, menghitung pajak, dan mencetak resi.', 'en' => 'This app helps record transactions, calculate taxes, and print receipts.'], 'vocab' => ['determine stellar temperature' => ['id' => 'menentukan suhu bintang', 'pos' => '(v)'], 'calculate rotation speed' => ['id' => 'menghitung kecepatan rotasi', 'pos' => '(v)'], 'identify chemical elements' => ['id' => 'mengidentifikasi unsur kimia', 'pos' => '(v)']]],
            8 => ['example' => ['id' => 'Pegawai profesional selalu datang pagi, bekerja fokus, dan bersikap sopan.', 'en' => 'Professional employees always arrive early, work focused, and act politely.'], 'vocab' => ['drives carefully' => ['id' => 'berkendara secara hati-hati', 'pos' => '(v)'], 'obeys traffic signs' => ['id' => 'mematuhi rambu', 'pos' => '(v)'], 'respects road users' => ['id' => 'menghormati pengguna jalan', 'pos' => '(v)']]],
            9 => ['example' => ['id' => 'Rencana kerja mencakup pembersihan area, perbaikan alat, dan pendaftaran anggota.', 'en' => 'The work plan includes area cleanup, equipment repair, and member registration.'], 'vocab' => ['cost rationalization' => ['id' => 'rasionalisasi biaya', 'pos' => '(n)'], 'IT system upgrade' => ['id' => 'pembaruan sistem IT', 'pos' => '(n)'], 'employee retraining' => ['id' => 'pelatihan ulang karyawan', 'pos' => '(n)']]],
            10 => ['example' => ['id' => 'Obat ini aman untuk anak-anak, manjur bagi dewasa, dan murah.', 'en' => 'This medicine is safe for children, effective for adults, and cheap.'], 'vocab' => ['safe for adults' => ['id' => 'aman untuk dewasa', 'pos' => '(adj)'], 'effective for elderly' => ['id' => 'efektif bagi lansia', 'pos' => '(adj)'], 'affordable' => ['id' => 'terjangkau oleh masyarakat', 'pos' => '(adj)']]],
            11 => ['example' => ['id' => 'Buku ini tidak hanya menarik tetapi juga edukatif.', 'en' => 'This book is not only interesting but also educational.'], 'vocab' => ['quantitative data' => ['id' => 'data kuantitatif', 'pos' => '(n)'], 'qualitative analysis' => ['id' => 'analisis kualitatif', 'pos' => '(n)'], 'contains & presents' => ['id' => 'memuat & menyajikan', 'pos' => '(v)']]],
            12 => ['example' => ['id' => 'Peserta wajib mendaftar online, membayar biaya, dan mengikuti tes.', 'en' => 'Participants must register online, pay fees, and take the test.'], 'vocab' => ['read scientific literature' => ['id' => 'membaca literatur ilmiah', 'pos' => '(v)'], 'conduct critical analysis' => ['id' => 'melakukan analisis kritis', 'pos' => '(v)'], 'write academic essays' => ['id' => 'menulis esai akademik', 'pos' => '(v)']]],
            13 => ['example' => ['id' => 'Langkah pencegahan meliputi pembersihan selokan, penanaman pohon, dan pembuatan penampungan.', 'en' => 'Prevention steps include cleaning drains, planting trees, and constructing reservoirs.'], 'vocab' => ['sea wall construction' => ['id' => 'pembangunan tanggul laut', 'pos' => '(n)'], 'mangrove planting' => ['id' => 'penanaman mangrove', 'pos' => '(n)'], 'coastal zone management' => ['id' => 'penataan kawasan pesisir', 'pos' => '(n)']]],
            14 => ['example' => ['id' => 'Sistem membutuhkan login username, verifikasi OTP, dan konfirmasi email.', 'en' => 'The system requires username login, OTP verification, and email confirmation.'], 'vocab' => ['high-res scanning' => ['id' => 'pemindaian beresolusi tinggi', 'pos' => '(n)'], 'automatic indexing' => ['id' => 'indeksasi otomatis', 'pos' => '(n)'], 'encrypted storage' => ['id' => 'penyimpanan terenkripsi', 'pos' => '(n)']]],
            15 => ['example' => ['id' => 'Kota itu terkenal karena keindahan tamannya, kebersihan jalannya, dan keharmonisan warganya.', 'en' => 'That city is famous for its park beauty, street cleanliness, and citizen harmony.'], 'vocab' => ['magnificent architecture' => ['id' => 'arsitektur megah', 'pos' => '(n)'], 'fair laws' => ['id' => 'hukum yang adil', 'pos' => '(n)'], 'valuable art' => ['id' => 'seni bernilai tinggi', 'pos' => '(n)']]],
        ];
    }

    private function complexityMeeting6QuestionHelpers(): array
    {
        return [
            1 => ['example' => ['id' => 'Meskipun hujan deras, pertandingan tetap berlangsung.', 'en' => 'Although it rained heavily, the match continued.'], 'vocab' => ['advanced technology' => ['id' => 'teknologi canggih', 'pos' => '(n)'], 'space mission' => ['id' => 'misi luar angkasa', 'pos' => '(n)'], 'high-risk' => ['id' => 'berisiko tinggi', 'pos' => '(adj)']]],
            2 => ['example' => ['id' => 'Hujan turun sangat lebat, sehingga jalanan tergenang.', 'en' => 'It rained very heavily, so the streets were flooded.'], 'vocab' => ['ocean temperature' => ['id' => 'suhu laut', 'pos' => '(n)'], 'coral reefs' => ['id' => 'terumbu karang', 'pos' => '(n)'], 'bleaching' => ['id' => 'pemutihan', 'pos' => '(n)']]],
            3 => ['example' => ['id' => 'Acara dibatalkan karena cuaca buruk.', 'en' => 'The event was canceled because the weather was bad.'], 'vocab' => ['ecosystem collapsed' => ['id' => 'ekosistem runtuh', 'pos' => '(v)'], 'apex predator' => ['id' => 'predator utama', 'pos' => '(n)'], 'extinct' => ['id' => 'punah', 'pos' => '(adj)']]],
            4 => ['example' => ['id' => 'Jika kamu belajar giat, kamu akan lulus.', 'en' => 'If you study hard, you will pass.'], 'vocab' => ['ocean acidity' => ['id' => 'keasaman laut', 'pos' => '(n)'], 'shelled organisms' => ['id' => 'organisme bersangkang', 'pos' => '(n)'], 'damage' => ['id' => 'kerusakan', 'pos' => '(n)']]],
            5 => ['example' => ['id' => 'Ketika bel berbunyi, siswa meninggalkan kelas.', 'en' => 'When the bell rang, students left the class.'], 'vocab' => ['Industrial Revolution' => ['id' => 'revolusi industri', 'pos' => '(n)'], 'social structure' => ['id' => 'struktur sosial', 'pos' => '(n)'], 'permanently' => ['id' => 'secara permanen', 'pos' => '(adv)']]],
            6 => ['example' => ['id' => 'Sementara ia membaca, saudaranya menonton TV.', 'en' => 'While she read, her brother watched TV.'], 'vocab' => ['adapt rapidly' => ['id' => 'beradaptasi dengan cepat', 'pos' => '(v)'], 'face threat of extinction' => ['id' => 'menghadapi ancaman kepunahan', 'pos' => '(v)'], 'while' => ['id' => 'sementara', 'pos' => '(conj)']]],
            7 => ['example' => ['id' => 'Sebelum obat diminum, kocok botol terlebih dahulu.', 'en' => 'Before taking the medicine, shake the bottle first.'], 'vocab' => ['instrument' => ['id' => 'instrumen', 'pos' => '(n)'], 'technician' => ['id' => 'teknisi', 'pos' => '(n)'], 'recalibrate' => ['id' => 'kalibrasi ulang', 'pos' => '(v)']]],
            8 => ['example' => ['id' => 'Supaya rapat berjalan efisien, buat agenda jelas.', 'en' => 'So that the meeting runs efficiently, make a clear agenda.'], 'vocab' => ['verification process' => ['id' => 'proses verifikasi', 'pos' => '(n)'], 'all documents' => ['id' => 'seluruh dokumen', 'pos' => '(n)'], 'upload completely' => ['id' => 'mengunggah secara lengkap', 'pos' => '(v1)']]],
            9 => ['example' => ['id' => 'Seiring berjalannya waktu, luka itu akan sembuh.', 'en' => 'As time goes by, that wound will heal.'], 'vocab' => ['AI technology advances' => ['id' => 'berkembangnya teknologi AI', 'pos' => '(n)'], 'ethical regulation' => ['id' => 'regulasi etis', 'pos' => '(n)'], 'increasingly urgent' => ['id' => 'semakin mendesak', 'pos' => '(adj)']]],
            10 => ['example' => ['id' => 'Meskipun harga barang naik, permintaan tetap tinggi.', 'en' => 'Although prices rose, demand remained high.'], 'vocab' => ['renewable energy supply' => ['id' => 'pasokan energi terbarukan', 'pos' => '(n)'], 'coal reliance' => ['id' => 'ketergantungan pada batu bara', 'pos' => '(n)'], 'remains high' => ['id' => 'masih tinggi', 'pos' => '(adj)']]],
            11 => ['example' => ['id' => 'Setelah ujian selesai, siswa meninggalkan ruangan.', 'en' => 'After the exam finished, students left the room.'], 'vocab' => ['after experiment' => ['id' => 'setelah eksperimen', 'pos' => '(conj)'], 'research team' => ['id' => 'tim peneliti', 'pos' => '(n)'], 'lock main lab' => ['id' => 'mengunci laboratorium utama', 'pos' => '(v1)']]],
            12 => ['example' => ['id' => 'Apabila suhu melampaui batas, sistem akan mati.', 'en' => 'If temperature exceeds the limit, the system will shut down.'], 'vocab' => ['air pollution level' => ['id' => 'kadar polusi udara', 'pos' => '(n)'], 'exceeds safe limit' => ['id' => 'melampaui batas aman', 'pos' => '(v)'], 'outdoor activities' => ['id' => 'aktivitas luar ruangan', 'pos' => '(n)']]],
            13 => ['example' => ['id' => 'Agar air bersih terjaga, sumber air dilindungi.', 'en' => 'In order to preserve clean water, water sources are protected.'], 'vocab' => ['wildlife population' => ['id' => 'populasi satwa liar', 'pos' => '(n)'], 'protect' => ['id' => 'melindungi', 'pos' => '(v1)'], 'wildlife sanctuary' => ['id' => 'suaka margasatwa', 'pos' => '(n)']]],
            14 => ['example' => ['id' => 'Oleh karena hujan deras, sungai meluap.', 'en' => 'Because of heavy rain, the river overflowed.'], 'vocab' => ['commodity price fluctuation' => ['id' => 'fluktuasi harga komoditas', 'pos' => '(n)'], 'sharp' => ['id' => 'tajam', 'pos' => '(adj)'], 'cautious investors' => ['id' => 'investor berhati-hati', 'pos' => '(n)']]],
            15 => ['example' => ['id' => 'Meskipun tes awal sukses, pengujian lanjutan tetap perlu.', 'en' => 'Although initial tests were successful, further testing is still needed.'], 'vocab' => ['initial results' => ['id' => 'hasil awal', 'pos' => '(n)'], 'promising' => ['id' => 'menjanjikan', 'pos' => '(adj)'], 'phase 3 clinical trial' => ['id' => 'uji klinis tahap ketiga', 'pos' => '(n)']]],
        ];
    }

    private function complexityMeeting7QuestionHelpers(): array
    {
        return [
            1 => ['example' => ['id' => 'Buku yang dosen rekomendasikan sangat membantu.', 'en' => 'The book that the lecturer recommended is very helpful.'], 'vocab' => ['methodology' => ['id' => 'metodologi', 'pos' => '(n)'], 'verify' => ['id' => 'memverifikasi', 'pos' => '(v1)'], 'expert panel' => ['id' => 'dewan pakar', 'pos' => '(n)']]],
            2 => ['example' => ['id' => 'Insinyur yang merancang jembatan itu hebat.', 'en' => 'The engineer who designed that bridge is great.'], 'vocab' => ['architect' => ['id' => 'arsitek', 'pos' => '(n)'], 'eco-friendly' => ['id' => 'ramah lingkungan', 'pos' => '(adj)'], 'sustainable design' => ['id' => 'desain berkelanjutan', 'pos' => '(n)']]],
            3 => ['example' => ['id' => 'Laporan yang kami baca menunjukkan hasil bagus.', 'en' => 'The report which we read shows good results.'], 'vocab' => ['statistical data' => ['id' => 'data statistik', 'pos' => '(n)'], 'collect' => ['id' => 'mengumpulkan', 'pos' => '(v1)'], 'growth trend' => ['id' => 'tren pertumbuhan', 'pos' => '(n)']]],
            4 => ['example' => ['id' => 'Bahan yang sangat bereaksi itu disimpan di wadah khusus.', 'en' => 'The material that reacts strongly is stored in a special container.'], 'vocab' => ['chemical element' => ['id' => 'unsur kimia', 'pos' => '(n)'], 'atomic number' => ['id' => 'nomor atom', 'pos' => '(n)'], 'unstable' => ['id' => 'tidak stabil', 'pos' => '(adj)']]],
            5 => ['example' => ['id' => 'Manajer yang pemilik perusahaan pilih sangat berpengalaman.', 'en' => 'The manager whom the company owner chose is very experienced.'], 'vocab' => ['candidate' => ['id' => 'kandidat', 'pos' => '(n)'], 'chief executive' => ['id' => 'direktur utama', 'pos' => '(n)'], 'extensive experience' => ['id' => 'pengalaman luas', 'pos' => '(n)']]],
            6 => ['example' => ['id' => 'Dokter yang menemukan obat baru itu menerima penghargaan.', 'en' => 'The doctor who discovered the new drug received an award.'], 'vocab' => ['scientists' => ['id' => 'para ilmuwan', 'pos' => '(n)'], 'discover' => ['id' => 'menemukan', 'pos' => '(v1)'], 'vaccine' => ['id' => 'vaksin', 'pos' => '(n)']]],
            7 => ['example' => ['id' => 'Artefak yang tim temukan dipajang di galeri.', 'en' => 'The artifact that the team found is displayed in the gallery.'], 'vocab' => ['historical document' => ['id' => 'dokumen sejarah', 'pos' => '(n)'], 'neolithic site' => ['id' => 'situs neolitikum', 'pos' => '(n)'], 'preserve' => ['id' => 'menyimpan/mempreservasi', 'pos' => '(v1)']]],
            8 => ['example' => ['id' => 'Rumus yang menjelaskan gravitasi telah diuji.', 'en' => 'The formula that explains gravity has been tested.'], 'vocab' => ['physics theory' => ['id' => 'teori fisika', 'pos' => '(n)'], 'black hole' => ['id' => 'lubang hitam', 'pos' => '(n)'], 'prove mathematically' => ['id' => 'membuktikan secara matematis', 'pos' => '(v1)']]],
            9 => ['example' => ['id' => 'Alat musik yang dimainkan musisi itu kuno.', 'en' => 'The instrument which the musician plays is ancient.'], 'vocab' => ['musical instrument' => ['id' => 'instrumen musik', 'pos' => '(n)'], 'rare wood' => ['id' => 'kayu langka', 'pos' => '(n)'], 'make of' => ['id' => 'membuat dari', 'pos' => '(v1)']]],
            10 => ['example' => ['id' => 'Ikan yang hidup di air tawar sangat beragam.', 'en' => 'Fish that live in freshwater are very diverse.'], 'vocab' => ['bird species' => ['id' => 'spesies burung', 'pos' => '(n)'], 'migrates' => ['id' => 'bermigrasi', 'pos' => '(v1)'], 'nautical miles' => ['id' => 'mil laut', 'pos' => '(n)']]],
            11 => ['example' => ['id' => 'Gagasan yang Einstein cetuskan mengubah fisika.', 'en' => 'The idea which Einstein proposed changed physics.'], 'vocab' => ['sociological theory' => ['id' => 'teori sosiologi', 'pos' => '(n)'], 'propose' => ['id' => 'mengemukakan', 'pos' => '(v1)'], 'foundation' => ['id' => 'dasar/fondasi', 'pos' => '(n)']]],
            12 => ['example' => ['id' => 'Aplikasi yang mengamankan data berjalan otomatis.', 'en' => 'The application that secures data runs automatically.'], 'vocab' => ['software' => ['id' => 'perangkat lunak', 'pos' => '(n)'], 'network intrusion' => ['id' => 'intrusi jaringan', 'pos' => '(n)'], 'automatically' => ['id' => 'secara otomatis', 'pos' => '(adv)']]],
            13 => ['example' => ['id' => 'Kendala yang mekanik perbaiki telah selesai.', 'en' => 'The problem which the mechanic fixed is resolved.'], 'vocab' => ['technical issue' => ['id' => 'masalah teknis', 'pos' => '(n)'], 'technician' => ['id' => 'teknisi', 'pos' => '(n)'], 'repair fully' => ['id' => 'memperbaiki sepenuhnya', 'pos' => '(v1)']]],
            14 => ['example' => ['id' => 'Siswa yang lulus ujian masuk menerima beasiswa.', 'en' => 'Students who pass the entrance exam receive a scholarship.'], 'vocab' => ['foreign languages' => ['id' => 'bahasa asing', 'pos' => '(n)'], 'priority' => ['id' => 'prioritas', 'pos' => '(n)'], 'scholarship selection' => ['id' => 'seleksi beasiswa', 'pos' => '(n)']]],
            15 => ['example' => ['id' => 'Batu yang dikumpulkan tim memberikan gambaran geologi.', 'en' => 'The rocks that the team collected provide geological insights.'], 'vocab' => ['rock sample' => ['id' => 'sampel batuan', 'pos' => '(n)'], 'astronaut' => ['id' => 'astronot', 'pos' => '(n)'], 'solar system' => ['id' => 'tata surya', 'pos' => '(n)']]],
            16 => ['example' => ['id' => 'Bintang yang terletak di galaksi jauh memancarkan cahaya.', 'en' => 'Stars located in distant galaxies emit light.'], 'vocab' => ['galaxy' => ['id' => 'galaksi', 'pos' => '(n)'], 'light years' => ['id' => 'tahun cahaya', 'pos' => '(n)'], 'emits' => ['id' => 'memancarkan', 'pos' => '(v1)']]],
            17 => ['example' => ['id' => 'Rencana yang tim buat meningkatkan penjualan.', 'en' => 'The plan that the team created increased sales.'], 'vocab' => ['marketing strategy' => ['id' => 'strategi pemasaran', 'pos' => '(n)'], 'implement' => ['id' => 'menerapkan', 'pos' => '(v1)'], 'sales volume' => ['id' => 'volume penjualan', 'pos' => '(n)']]],
            18 => ['example' => ['id' => 'Aturan yang membatasi emisi diterapkan ketat.', 'en' => 'Rules that limit emissions are strictly enforced.'], 'vocab' => ['government policy' => ['id' => 'kebijakan pemerintah', 'pos' => '(n)'], 'fossil energy' => ['id' => 'energi fosil', 'pos' => '(n)'], 'enforce' => ['id' => 'memberlakukan', 'pos' => '(v1)']]],
            19 => ['example' => ['id' => 'Teman yang saya temui di kampus sangat ramah.', 'en' => 'The friend whom I met on campus is very friendly.'], 'vocab' => ['colleague' => ['id' => 'rekan kerja', 'pos' => '(n)'], 'international conference' => ['id' => 'konferensi internasional', 'pos' => '(n)'], 'reputable institution' => ['id' => 'institusi ternama', 'pos' => '(n)']]],
            20 => ['example' => ['id' => 'Makhluk yang hidup di hutan hujan memiliki keunikan.', 'en' => 'Creatures that live in the rainforest possess uniqueness.'], 'vocab' => ['ocean floor' => ['id' => 'dasar samudra', 'pos' => '(n)'], 'organism' => ['id' => 'organisme', 'pos' => '(n)'], 'adaptability' => ['id' => 'kemampuan adaptasi', 'pos' => '(n)']]],
        ];
    }

    private function complexityMeeting8QuestionHelpers(): array
    {
        return [
            1 => ['example' => ['id' => 'Penulis yang bukunya laris memenangkan penghargaan.', 'en' => 'The author whose book is a bestseller won an award.'], 'vocab' => ['discovery' => ['id' => 'penemuan', 'pos' => '(n)'], 'revolutionize' => ['id' => 'merevolusi', 'pos' => '(v1)'], 'Nobel Prize' => ['id' => 'penghargaan Nobel', 'pos' => '(n)']]],
            2 => ['example' => ['id' => 'Bintang yang ukurannya raksasa akan menjadi supernova.', 'en' => 'Stars whose size is giant will become supernovas.'], 'vocab' => ['mass' => ['id' => 'massa', 'pos' => '(n)'], 'tend to' => ['id' => 'cenderung', 'pos' => '(v1)'], 'center' => ['id' => 'pusat', 'pos' => '(n)']]],
            3 => ['example' => ['id' => 'Toko yang pendapatannya turun mulai berbenah.', 'en' => 'The store whose revenue dropped started to reform.'], 'vocab' => ['stock/shares' => ['id' => 'saham', 'pos' => '(n)'], 'plummet' => ['id' => 'anjlok', 'pos' => '(v1)'], 'restructuring' => ['id' => 'restrukturisasi', 'pos' => '(n)']]],
            4 => ['example' => ['id' => 'Pohon yang daunnya lebat memberi peneduh.', 'en' => 'Trees whose leaves are dense provide shade.'], 'vocab' => ['plant species' => ['id' => 'spesies tanaman', 'pos' => '(n)'], 'roots' => ['id' => 'akar', 'pos' => '(n)'], 'heavy metals' => ['id' => 'logam berat', 'pos' => '(n)']]],
            5 => ['example' => ['id' => 'Seniman yang karyanya indah dikenal luas.', 'en' => 'The artist whose artwork is beautiful is widely known.'], 'vocab' => ['design/blueprint' => ['id' => 'rancangan', 'pos' => '(n)'], 'blends' => ['id' => 'memadukan', 'pos' => '(v1)'], 'functionality' => ['id' => 'fungsionalitas', 'pos' => '(n)']]],
            6 => ['example' => ['id' => 'Kota yang sistem transportasinya bagus menarik wisatawan.', 'en' => 'Cities whose transport system is good attract tourists.'], 'vocab' => ['economic policy' => ['id' => 'kebijakan ekonomi', 'pos' => '(n)'], 'stable' => ['id' => 'stabil', 'pos' => '(adj)'], 'foreign investors' => ['id' => 'investor asing', 'pos' => '(n)']]],
            7 => ['example' => ['id' => 'Siswa yang nilainya tertinggi mendapat hadiah.', 'en' => 'The student whose grades are highest got a prize.'], 'vocab' => ['thesis' => ['id' => 'tesis', 'pos' => '(n)'], 'publish' => ['id' => 'menerbitkan', 'pos' => '(v1)'], 'highest honors' => ['id' => 'pujian tertinggi', 'pos' => '(n)']]],
            8 => ['example' => ['id' => 'Bahan yang molekulnya unik sangat kuat.', 'en' => 'Materials whose molecules are unique are very strong.'], 'vocab' => ['atomic structure' => ['id' => 'struktur atom', 'pos' => '(n)'], 'conductivity' => ['id' => 'konduktivitas', 'pos' => '(n)'], 'remarkable' => ['id' => 'luar biasa', 'pos' => '(adj)']]],
            9 => ['example' => ['id' => 'Pemimpin yang pemikirannya maju dikenang sejarah.', 'en' => 'Leaders whose thinking is advanced are remembered by history.'], 'vocab' => ['historical figure' => ['id' => 'tokoh sejarah', 'pos' => '(n)'], 'influence' => ['id' => 'pengaruh', 'pos' => '(n)'], 'crosses borders' => ['id' => 'melintasi batas', 'pos' => '(v1)']]],
            10 => ['example' => ['id' => 'Klinik yang layanannya ramah disukai pasien.', 'en' => 'Clinics whose service is friendly are liked by patients.'], 'vocab' => ['humanitarian vision' => ['id' => 'visi kemanusiaan', 'pos' => '(n)'], 'medical aid' => ['id' => 'bantuan medis', 'pos' => '(n)'], 'conflict area' => ['id' => 'daerah konflik', 'pos' => '(n)']]],
            11 => ['example' => ['id' => 'Ruangan tempat rapat diadakan cukup luas.', 'en' => 'The room where the meeting is held is quite spacious.'], 'vocab' => ['laboratory' => ['id' => 'laboratorium', 'pos' => '(n)'], 'conduct' => ['id' => 'melakukan', 'pos' => '(v1)'], 'safety standards' => ['id' => 'standar keamanan', 'pos' => '(n)']]],
            12 => ['example' => ['id' => 'Tahun 1990 adalah masa ketika teknologi internet berkembang.', 'en' => '1990 was the time when internet technology grew.'], 'vocab' => ['Industrial Revolution' => ['id' => 'Revolusi Industri', 'pos' => '(n)'], 'social structure' => ['id' => 'struktur sosial', 'pos' => '(n)'], 'massively' => ['id' => 'secara masif', 'pos' => '(adv)']]],
            13 => ['example' => ['id' => 'Kami mengerti alasan mengapa acara ditunda.', 'en' => 'We understand the reason why the event was delayed.'], 'vocab' => ['investigation team' => ['id' => 'tim investigasi', 'pos' => '(n)'], 'security system' => ['id' => 'sistem keamanan', 'pos' => '(n)'], 'intrusion' => ['id' => 'intrusi', 'pos' => '(n)']]],
            14 => ['example' => ['id' => 'Taman tempat kami berkumpul sangat asri.', 'en' => 'The park where we gathered is very pleasant.'], 'vocab' => ['archaeological site' => ['id' => 'situs arkeologi', 'pos' => '(n)'], 'pottery fragments' => ['id' => 'fragmen tembikar', 'pos' => '(n)'], 'protected area' => ['id' => 'area dilindungi', 'pos' => '(n)']]],
            15 => ['example' => ['id' => 'Saat ketika keputusan dibuat sangat krusial.', 'en' => 'The moment when the decision was made was crucial.'], 'vocab' => ['market fluctuation' => ['id' => 'fluktuasi pasar', 'pos' => '(n)'], 'purchasing power' => ['id' => 'daya beli', 'pos' => '(n)'], 'local public' => ['id' => 'masyarakat lokal', 'pos' => '(n)']]],
            16 => ['example' => ['id' => 'Studi menjelaskan sebab mengapa harga naik.', 'en' => 'The study explains the cause why prices rose.'], 'vocab' => ['political polarization' => ['id' => 'polarisasi politik', 'pos' => '(n)'], 'digital era' => ['id' => 'era digital', 'pos' => '(n)'], 'increase' => ['id' => 'meningkat', 'pos' => '(v1)']]],
            17 => ['example' => ['id' => 'Danau tempat ikan itu berada sangat bersih.', 'en' => 'The lake where the fish are is very clean.'], 'vocab' => ['coral reef' => ['id' => 'terumbu karang', 'pos' => '(n)'], 'ocean temperature' => ['id' => 'suhu laut', 'pos' => '(n)'], 'extreme warming' => ['id' => 'pemanasan ekstrem', 'pos' => '(n)']]],
            18 => ['example' => ['id' => 'Tahun itu adalah saat ketika babak baru dimulai.', 'en' => 'That year was when a new chapter began.'], 'vocab' => ['turning point' => ['id' => 'titik balik', 'pos' => '(n)'], 'new world order' => ['id' => 'tatanan dunia baru', 'pos' => '(n)'], 'form' => ['id' => 'membentuk', 'pos' => '(v1)']]],
            19 => ['example' => ['id' => 'Dokter meneliti alasan mengapa virus menyebar.', 'en' => 'Doctors research the reason why the virus spread.'], 'vocab' => ['resistant' => ['id' => 'resistan', 'pos' => '(adj)'], 'antibiotic' => ['id' => 'antibiotik', 'pos' => '(n)'], 'cause' => ['id' => 'penyebab', 'pos' => '(n)']]],
            20 => ['example' => ['id' => 'Ruang sidang adalah tempat hukum ditegakkan.', 'en' => 'The courtroom is where law is enforced.'], 'vocab' => ['vacuum space' => ['id' => 'ruang hampa', 'pos' => '(n)'], 'sound waves' => ['id' => 'gelombang suara', 'pos' => '(n)'], 'propagate' => ['id' => 'merambat', 'pos' => '(v1)']]],
        ];
    }

    private function complexityMeeting9QuestionHelpers(): array
    {
        return [
            1 => ['example' => ['id' => 'Saya tahu kapan rapat akan dimulai.', 'en' => 'I know when the meeting will start.'], 'vocab' => ['research team' => ['id' => 'tim peneliti', 'pos' => '(n)'], 'volcanic phenomenon' => ['id' => 'fenomena vulkanik', 'pos' => '(n)'], 'end' => ['id' => 'berakhir', 'pos' => '(v1)']]],
            2 => ['example' => ['id' => 'Bahwa bumi itu bulat adalah fakta.', 'en' => 'That the earth is round is a fact.'], 'vocab' => ['ozone layer' => ['id' => 'lapisan ozon', 'pos' => '(n)'], 'recover' => ['id' => 'membaik', 'pos' => '(v1)'], 'global environmental policy' => ['id' => 'kebijakan lingkungan global', 'pos' => '(n)']]],
            3 => ['example' => ['id' => 'Guru menjelaskan bagaimana mesin itu bekerja.', 'en' => 'The teacher explained how that engine works.'], 'vocab' => ['astronomers' => ['id' => 'para astronom', 'pos' => '(n)'], 'devours' => ['id' => 'melahap', 'pos' => '(v1)'], 'surrounding matter' => ['id' => 'materi sekitar', 'pos' => '(n)']]],
            4 => ['example' => ['id' => 'Panitia menentukan siapa yang menang.', 'en' => 'The committee determined who won.'], 'vocab' => ['selection committee' => ['id' => 'komite seleksi', 'pos' => '(n)'], 'entitled' => ['id' => 'berhak', 'pos' => '(adj)'], 'research funding' => ['id' => 'pendanaan riset', 'pos' => '(n)']]],
            5 => ['example' => ['id' => 'Kita mengerti mengapa hal itu terjadi.', 'en' => 'We understand why that happened.'], 'vocab' => ['ecosystem stability' => ['id' => 'stabilitas ekosistem', 'pos' => '(n)'], 'apex predator' => ['id' => 'predator puncak', 'pos' => '(n)'], 'relies on' => ['id' => 'bergantung pada', 'pos' => '(v1)']]],
            6 => ['example' => ['id' => 'Apa yang kamu katakan sangat menarik.', 'en' => 'What you said is very interesting.'], 'vocab' => ['archaeologists' => ['id' => 'para arkeolog', 'pos' => '(n)'], 'ancient civilization' => ['id' => 'peradaban kuno', 'pos' => '(n)'], 'alter' => ['id' => 'mengubah', 'pos' => '(v1)']]],
            7 => ['example' => ['id' => 'Manajemen memilih di mana kantor baru berada.', 'en' => 'Management chose where the new office is located.'], 'vocab' => ['board of directors' => ['id' => 'dewan direksi', 'pos' => '(n)'], 'manufacturing facility' => ['id' => 'fasilitas manufaktur', 'pos' => '(n)'], 'build' => ['id' => 'membangun', 'pos' => '(v1)']]],
            8 => ['example' => ['id' => 'Laporan menyatakan bahwa harga sudah stabil.', 'en' => 'The report stated that prices are stable.'], 'vocab' => ['data analyst' => ['id' => 'analis data', 'pos' => '(n)'], 'market fluctuation' => ['id' => 'fluktuasi pasar', 'pos' => '(n)'], 'investor sentiment' => ['id' => 'sentimen investor', 'pos' => '(n)']]],
            9 => ['example' => ['id' => 'Bagaimana sistem bekerja masih dipelajari.', 'en' => 'How the system works is still studied.'], 'vocab' => ['mass information' => ['id' => 'informasi massal', 'pos' => '(n)'], 'processes' => ['id' => 'memproses', 'pos' => '(v1)'], 'ethics discussion' => ['id' => 'diskusi etika', 'pos' => '(n)']]],
            10 => ['example' => ['id' => 'Dia bertanya apakah kita bisa hadir.', 'en' => 'She asked whether we could attend.'], 'vocab' => ['students' => ['id' => 'mahasiswa', 'pos' => '(n)'], 'relevant' => ['id' => 'relevan', 'pos' => '(adj)'], 'current conditions' => ['id' => 'kondisi saat ini', 'pos' => '(n)']]],
            11 => ['example' => ['id' => 'Siapa yang memimpin proyek akan diumumkan.', 'en' => 'Who leads the project will be announced.'], 'vocab' => ['Nobel Prize' => ['id' => 'penghargaan Nobel', 'pos' => '(n)'], 'announce' => ['id' => 'mengumumkan', 'pos' => '(v1)'], 'winner' => ['id' => 'pemenang', 'pos' => '(n)']]],
            12 => ['example' => ['id' => 'Tes ini mengukur seberapa cepat anak belajar.', 'en' => 'This test measures how fast children learn.'], 'vocab' => ['experiment' => ['id' => 'eksperimen', 'pos' => '(n)'], 'adapt to' => ['id' => 'beradaptasi dengan', 'pos' => '(v1)'], 'antibiotics' => ['id' => 'antibiotik', 'pos' => '(n)']]],
            13 => ['example' => ['id' => 'Mengapa harga berfluktuasi dijelaskan di buku.', 'en' => 'Why prices fluctuate is explained in the book.'], 'vocab' => ['global temperature' => ['id' => 'suhu global', 'pos' => '(n)'], 'drastically' => ['id' => 'secara drastis', 'pos' => '(adv)'], 'climate conference' => ['id' => 'konferensi iklim', 'pos' => '(n)']]],
            14 => ['example' => ['id' => 'Program ini memblokir apa pun yang berbahaya.', 'en' => 'This program blocks whatever is dangerous.'], 'vocab' => ['automatically' => ['id' => 'secara otomatis', 'pos' => '(adv)'], 'threatens' => ['id' => 'mengancam', 'pos' => '(v1)'], 'network integrity' => ['id' => 'integritas jaringan', 'pos' => '(n)']]],
            15 => ['example' => ['id' => 'Bahwa kerja keras membawa hasil diakui semua orang.', 'en' => 'That hard work brings results is recognized by everyone.'], 'vocab' => ['social mobility' => ['id' => 'mobilitas sosial', 'pos' => '(n)'], 'key' => ['id' => 'kunci', 'pos' => '(n)'], 'recognize' => ['id' => 'mengakui', 'pos' => '(v1)']]],
        ];
    }

    private function complexityMeeting10QuestionHelpers(): array
    {
        return [
            1 => ['example' => ['id' => 'Bumi lebih besar dari Bulan.', 'en' => 'The Earth is larger than the Moon.'], 'vocab' => ['solar system' => ['id' => 'tata surya', 'pos' => '(n)']]],
            2 => ['example' => ['id' => 'Gunung Everest adalah gunung tertinggi.', 'en' => 'Mount Everest is the highest mountain.'], 'vocab' => ['coral structure' => ['id' => 'struktur karang', 'pos' => '(n)']]],
            3 => ['example' => ['id' => 'Belajar bahasa membutuhkan latihan.', 'en' => 'Learning language requires practice.'], 'vocab' => ['develop' => ['id' => 'mengembangkan', 'pos' => '(v1)']]],
            4 => ['example' => ['id' => 'Mereka berusaha untuk menyelesaikan masalah.', 'en' => 'They strive to solve the problem.'], 'vocab' => ['origin of the universe' => ['id' => 'asal-usul alam semesta', 'pos' => '(n)']]],
            5 => ['example' => ['id' => 'Tim mengumpulkan data dan menganalisisnya.', 'en' => 'The team collected data and analyzed it.'], 'vocab' => ['soil samples' => ['id' => 'sampel tanah', 'pos' => '(n)']]],
            6 => ['example' => ['id' => 'Teori ini menarik tetapi rumit.', 'en' => 'This theory is interesting but complex.'], 'vocab' => ['weaknesses' => ['id' => 'kelemahan', 'pos' => '(n)']]],
            7 => ['example' => ['id' => 'Hujan turun deras, sehingga jalanan banjir.', 'en' => 'It rained heavily, so the streets flooded.'], 'vocab' => ['bleaching' => ['id' => 'pemutihan', 'pos' => '(n)']]],
            8 => ['example' => ['id' => 'Bangunan itu rubuh karena gempa.', 'en' => 'The building collapsed because of the earthquake.'], 'vocab' => ['extinct' => ['id' => 'punah', 'pos' => '(adj)']]],
            9 => ['example' => ['id' => 'Meskipun mahal, mobil ini sangat cepat.', 'en' => 'Although expensive, this car is very fast.'], 'vocab' => ['space mission' => ['id' => 'misi luar angkasa', 'pos' => '(n)']]],
            10 => ['example' => ['id' => 'Peneliti yang menemukan obat itu dipuji.', 'en' => 'The researcher who discovered the drug was praised.'], 'vocab' => ['particle' => ['id' => 'partikel', 'pos' => '(n)']]],
            11 => ['example' => ['id' => 'Hipotesis yang ilmuwan tes ternyata benar.', 'en' => 'The hypothesis that scientists tested turned out true.'], 'vocab' => ['test' => ['id' => 'menguji', 'pos' => '(v1)']]],
            12 => ['example' => ['id' => 'Negara yang ekonominya kuat memimpin.', 'en' => 'Countries whose economy is strong lead.'], 'vocab' => ['innovative' => ['id' => 'inovatif', 'pos' => '(adj)']]],
            13 => ['example' => ['id' => 'Klinik tempat obat dibuat sangat bersih.', 'en' => 'The clinic where medicine is made is clean.'], 'vocab' => ['highest standard' => ['id' => 'standar tertinggi', 'pos' => '(n)']]],
            14 => ['example' => ['id' => 'Bahwa fakta ini benar tidak diragukan.', 'en' => 'That this fact is true is undoubted.'], 'vocab' => ['recognize widely' => ['id' => 'mengakui secara luas', 'pos' => '(v1)']]],
            15 => ['example' => ['id' => 'Kami mempelajari mengapa beberapa hewan bermigrasi.', 'en' => 'We study why some animals migrate.'], 'vocab' => ['adapt faster' => ['id' => 'beradaptasi lebih cepat', 'pos' => '(v1)']]],
        ];
    }

    public function downloadMaterialPdf(string $track, int $meeting)
    {
        $trackName = match($track) {
            'introductory' => 'Introductory Grammar for Writing',
            'complexity'   => 'Complexity Grammar for Writing',
            'proficiency'  => 'Proficiency Grammar for Writing',
            'fast-track'   => 'Fast Track Grammar for Writing',
            default        => 'Grammar for Writing',
        };

        $cheatSheet = match($track) {
            'introductory' => $this->introductoryMeetingCheatSheet($meeting),
            'complexity'   => $this->complexityMeetingCheatSheet($meeting),
            'proficiency'  => $this->proficiencyMeetingCheatSheet($meeting),
            'fast-track'   => app(\App\Http\Controllers\AssignmentController::class)->getFastTrackCheatSheet($meeting),
            default        => null,
        };

        if (empty($cheatSheet)) {
            $cheatSheet = ['__html__' => '<p>Penjelasan materi untuk meeting ini mengacu pada Modul Target Bahasa Basic Writing.</p>'];
        }

        $meetingTitle = "Meeting {$meeting}";
        if ($track === 'introductory') {
            $meetings = $this->buildIntroductoryTrackMeetings();
            $meetingTitle = $meetings[$meeting - 1]['topic'] ?? "Meeting {$meeting}";
        } elseif ($track === 'complexity') {
            $meetings = $this->complexityMeetingCatalog();
            $meetingTitle = $meetings[$meeting - 1]['topic'] ?? "Meeting {$meeting}";
        } elseif ($track === 'proficiency') {
            $meetings = $this->buildProficiencyTrackMeetings();
            $meetingTitle = $meetings[$meeting - 1]['topic'] ?? "Meeting {$meeting}";
        }

        $data = [
            'trackTitle' => $trackName,
            'meetingNumber' => $meeting,
            'meetingTitle' => $meetingTitle,
            'cheatSheetHtml' => $cheatSheet['__html__'] ?? '',
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('assignments.grammar-writing.material-pdf', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download("Modul_{$track}_Meeting_{$meeting}.pdf");
    }

    public function grammarWritingProficiencyMeeting(int $meeting)
    {
        $user = Auth::user();
        $isAdminOrTeacher = $user && ($user->isAdmin() || $user->isTeacher());

        if (!$isAdminOrTeacher && $user?->isStudent()) {
            $enrolledSlugs = $this->resolveGrammarEnrolledSlugs($user);
            if (!in_array('proficiency-grammar-for-writing', $enrolledSlugs, true)) {
                return redirect()->route('assignments.grammar-writing.classes')
                    ->with('error', 'Anda tidak memiliki akses ke kelas Proficiency Grammar for Writing.');
            }
        }

        $this->maybeRecordAttendanceForAssignmentAccess($user, 'grammar-for-writing', request());

        $meetings = $this->buildProficiencyTrackMeetings();
        $meetingData = $meetings[$meeting - 1] ?? null;

        abort_if($meetingData === null, 404);

        $resolvedMeetingContent = $this->resolveProficiencyMeetingContent($meeting);
        $resolvedParagraphContent = $this->resolveProficiencyMeetingParagraph($meeting);

        $submitted = false;
        $score = null;
        $results = [];
        $userAnswers = [];
        $userParagraphAnswer = '';
        $paragraphResult = null;
        $draftAnswers = session("proficiency_meeting{$meeting}_draft_answers", []);
        $draftParagraphAnswer = session("proficiency_meeting{$meeting}_draft_paragraph_answer", '');

        if ($user) {
            try {
                $programId = \App\Models\Program::where('slug', 'proficiency-grammar-for-writing')->value('id') ?? $user->program_id;
                if ($programId) {
                    $scoreRecord = \App\Models\MeetingScore::where('user_id', $user->id)
                        ->where('program_id', $programId)
                        ->where('meeting_number', $meeting)
                        ->latest('submitted_at')
                        ->first();

                    if ($scoreRecord) {
                        $submitted = true;
                        $score = $scoreRecord->score;
                        $scoreData = is_array($scoreRecord->answers) ? $scoreRecord->answers : json_decode($scoreRecord->answers ?? '[]', true);
                        if (!empty($scoreData)) {
                            $results = $scoreData['results'] ?? [];
                            $paragraphResult = $scoreData['paragraph_result'] ?? null;
                            $userAnswers = $scoreData['user_answers'] ?? [];
                            $userParagraphAnswer = $scoreData['user_paragraph_answer'] ?? ($scoreData['paragraph_answer'] ?? '');
                        }
                    }

                    if (empty($draftAnswers) && empty($userAnswers)) {
                        $draft = \App\Models\AssignmentDraft::where('user_id', $user->id)
                            ->where('program_id', $programId)
                            ->where('meeting_number', $meeting)
                            ->first();
                        if ($draft && is_array($draft->answers)) {
                            $savedDraft = $draft->answers;
                            if (isset($savedDraft['paragraph_answer'])) {
                                if ($draftParagraphAnswer === '' && $userParagraphAnswer === '') {
                                    $draftParagraphAnswer = (string) $savedDraft['paragraph_answer'];
                                }
                                unset($savedDraft['paragraph_answer']);
                            }
                            $draftAnswers = $savedDraft;
                        }
                    }
                }
            } catch (\Throwable $e) {}
        }

        return view('assignments.grammar-writing-proficiency-meeting', [
            'meetingNumber' => $meeting,
            'meetingLabel' => 'Meeting ' . $meeting,
            'topic' => $meetingData['topic'],
            'meetingData' => $meetingData,
            'trackTitle' => 'Proficiency Grammar for Writing',
            'questions' => $resolvedMeetingContent['questions'],
            'cheatSheet' => $this->proficiencyMeetingCheatSheet($meeting),
            'questionHelpers' => $this->proficiencyMeetingQuestionHelpers($meeting),
            'questionEditorData' => $resolvedMeetingContent['editorData'],
            'submitted' => $submitted,
            'score' => $score,
            'results' => $results,
            'userAnswers' => $userAnswers,
            'paragraphData' => $resolvedParagraphContent['paragraphData'],
            'paragraphEditorData' => $resolvedParagraphContent['editorData'],
            'userParagraphAnswer' => $userParagraphAnswer,
            'paragraphResult' => $paragraphResult,
            'draftAnswers' => !empty($userAnswers) ? $userAnswers : $draftAnswers,
            'draftParagraphAnswer' => $userParagraphAnswer !== '' ? $userParagraphAnswer : $draftParagraphAnswer,
        ]);
    }

    public function grammarWritingProficiencyMeetingSubmit(Request $request, int $meeting)
    {
        $meetings = $this->buildProficiencyTrackMeetings();
        $meetingData = $meetings[$meeting - 1] ?? null;

        abort_if($meetingData === null, 404);

        $resolvedMeetingContent = $this->resolveProficiencyMeetingContent($meeting);
        $questions = $resolvedMeetingContent['questions'];
        $answerKeys = $resolvedMeetingContent['answerKeys'];
        $userAnswers = (array) $request->input('answers', []);

        $resolvedParagraphContent = $this->resolveProficiencyMeetingParagraph($meeting);
        $paragraphData = $resolvedParagraphContent['paragraphData'];
        $userParagraphAnswer = trim((string) $request->input('paragraph_answer', ''));

        $aiItems = [];
        foreach ($questions as $index => $questionText) {
            $questionNumber = $index + 1;
            $userAnswer = trim((string) ($userAnswers[$questionNumber] ?? ''));
            $correctAnswer = trim((string) ($answerKeys[$questionNumber] ?? ''));
            // Not attempted - excluded from AI grading and from scoring
            // below entirely (never counted toward maxRawScore), not
            // marked wrong. Lets "Cek Jawaban"-style partial checks work
            // without penalizing questions the student hasn't reached yet.
            if ($correctAnswer !== '' && $userAnswer !== '') {
                $aiItems[] = ['id' => "sentence_{$questionNumber}", 'correct_answer' => $correctAnswer, 'user_answer' => $userAnswer];
            }
        }
        if ($paragraphData !== null && !empty($paragraphData['en']) && $userParagraphAnswer !== '') {
            $aiItems[] = ['id' => 'paragraph', 'correct_answer' => (string) $paragraphData['en'], 'user_answer' => $userParagraphAnswer];
        }
        $proficiencyAiEnabled = $this->isGrammarWritingAiEnabled('proficiency', $meeting);
        $aiScores = $proficiencyAiEnabled ? $this->gradeItemsWithAi($aiItems) : null;

        $results = [];
        $totalScore = 0;
        $gradedQuestionCount = 0;

        foreach ($questions as $index => $questionText) {
            $questionNumber = $index + 1;
            $userAnswer = trim((string) ($userAnswers[$questionNumber] ?? ''));
            $correctAnswer = trim((string) ($answerKeys[$questionNumber] ?? ''));
            $answered = $correctAnswer !== '' && $userAnswer !== '';

            $questionScore = 0;
            $formattedAnswer = '';

            if ($correctAnswer !== '') {
                // Always resolve which correct-answer variant to display
                // even when unanswered, but only actually SCORE it - and
                // count it toward the total - when the student attempted
                // this question.
                [$scoredValue, $formattedValue, $correctAnswer] = $this->evaluateIntroductorySentenceAnswer($userAnswer, $correctAnswer);
                if ($answered) {
                    $questionScore = $scoredValue;
                    $formattedAnswer = $formattedValue;
                    $aiKey = "sentence_{$questionNumber}";
                    if ($aiScores && isset($aiScores[$aiKey])) {
                        // AI score is 0-100; this item's scale is 0-10.
                        $questionScore = round($aiScores[$aiKey]['score'] / 10, 1);
                    }
                    $totalScore += $questionScore;
                    $gradedQuestionCount++;
                }
            }

            $results[$questionNumber] = [
                'user_answer' => $userAnswer,
                'formatted_answer' => $formattedAnswer,
                'score' => $questionScore,
                'correct_answer' => $correctAnswer,
                'answered' => $answered,
            ];
        }

        $paragraphResult = null;
        $maxRawScore = $gradedQuestionCount * 10;
        $paragraphAnswered = $paragraphData !== null && !empty($paragraphData['en']) && $userParagraphAnswer !== '';

        if ($paragraphAnswered) {
            $paragraphResult = $this->evaluateIntroductoryParagraphAnswer($userParagraphAnswer, (string) $paragraphData['en']);
            if ($aiScores && isset($aiScores['paragraph'])) {
                // AI score is 0-100; this item's max_score is 20.
                $paragraphResult['score'] = round($aiScores['paragraph']['score'] / 100 * $paragraphResult['max_score']);
            }
            $totalScore += $paragraphResult['score'];
            $maxRawScore += $paragraphResult['max_score'];
        }

        $finalScore = $maxRawScore > 0 ? round(($totalScore / $maxRawScore) * 100, 1) : 0;

        $trackAnswersData = ['results' => $results, 'ai_enabled' => $proficiencyAiEnabled];
        if ($paragraphResult !== null) {
            $trackAnswersData['paragraph_result'] = array_merge($paragraphResult, ['user_answer' => $userParagraphAnswer]);
        }
        $this->persistGrammarTrackScore($meeting, $finalScore, 'proficiency-grammar-for-writing', $trackAnswersData);

        return view('assignments.grammar-writing-proficiency-meeting', [
            'meetingNumber' => $meeting,
            'meetingLabel' => 'Meeting ' . $meeting,
            'topic' => $meetingData['topic'],
            'meetingData' => $meetingData,
            'trackTitle' => 'Proficiency Grammar for Writing',
            'questions' => $questions,
            'questionHelpers' => $this->proficiencyMeetingQuestionHelpers($meeting),
            'questionEditorData' => $resolvedMeetingContent['editorData'],
            'submitted' => true,
            'score' => $finalScore,
            'results' => $results,
            'userAnswers' => $userAnswers,
            'paragraphData' => $paragraphData,
            'paragraphEditorData' => $resolvedParagraphContent['editorData'],
            'userParagraphAnswer' => $userParagraphAnswer,
            'paragraphResult' => $paragraphResult,
        ]);
    }

    public function grammarWritingProficiencyMeetingReset(int $meeting)
    {
        // Was a pure no-op (redirect only) - grammarWritingProficiencyMeeting()
        // above has no "submitted" session flag at all, it derives $submitted
        // purely from whether a MeetingScore row exists, so without deleting
        // that row (and the AssignmentDraft/draft session keys it also falls
        // back to) this reset endpoint could never actually unlock a
        // previously-submitted meeting for retry - only ever touches the
        // clicking user's own row.
        session()->forget([
            "proficiency_meeting{$meeting}_draft_answers",
            "proficiency_meeting{$meeting}_draft_paragraph_answer",
        ]);

        $userId = Auth::id();
        if ($userId) {
            try {
                $programId = \App\Models\Program::where('slug', 'proficiency-grammar-for-writing')->value('id') ?? Auth::user()?->program_id;
                if ($programId) {
                    \App\Models\MeetingScore::where('user_id', $userId)
                        ->where('program_id', $programId)
                        ->where('meeting_number', $meeting)
                        ->delete();

                    \App\Models\AssignmentDraft::where('user_id', $userId)
                        ->where('program_id', $programId)
                        ->where('meeting_number', $meeting)
                        ->delete();
                }
            } catch (\Throwable $e) {}
        }

        return redirect()->route('assignments.grammar-writing.proficiency.meeting', ['meeting' => $meeting]);
    }

    /**
     * Per-keystroke draft autosave shared by the Introductory/Complexity/
     * Proficiency tracks (and Fast-Track Meeting 2, which reuses the
     * Complexity view) - none of them persisted in-progress answers before
     * final submit, so a normal refresh looked like typed work had vanished.
     * Mirrors the session-based draft pattern already used by IELTS Writing.
     */
    public function grammarWritingMeetingDraft(Request $request, string $track, int $meeting): \Illuminate\Http\JsonResponse
    {
        abort_unless(in_array($track, ['introductory', 'complexity', 'proficiency', 'fast-track'], true), 404);

        $answers = $request->input('answers', []);
        $paragraphAnswer = $request->input('paragraph_answer', '');
        $answers = is_array($answers) ? $answers : [];
        $paragraphAnswer = is_string($paragraphAnswer) ? $paragraphAnswer : '';

        session([
            "{$track}_meeting{$meeting}_draft_answers" => $answers,
            "{$track}_meeting{$meeting}_draft_paragraph_answer" => $paragraphAnswer,
        ]);
        session()->save();

        $user = Auth::user();
        if ($user) {
            $programSlug = $this->grammarWritingTracks()[$track]['program_slug'] ?? null;
            $programId = $programSlug ? \App\Models\Program::where('slug', $programSlug)->value('id') : null;
            if (!$programId && $user->program_id) {
                $programId = $user->program_id;
            }

            $mergedAnswers = $answers;
            if ($programId) {
                $existingDraft = \App\Models\AssignmentDraft::where('user_id', $user->id)
                    ->where('program_id', $programId)
                    ->where('meeting_number', $meeting)
                    ->first();

                if ($existingDraft && is_array($existingDraft->answers)) {
                    foreach ($existingDraft->answers as $k => $oldVal) {
                        if ($k === 'paragraph_answer') {
                            if ($paragraphAnswer === '' && is_string($oldVal) && trim($oldVal) !== '') {
                                $paragraphAnswer = $oldVal;
                            }
                            continue;
                        }

                        $isNewEmpty = !isset($mergedAnswers[$k])
                            || (is_string($mergedAnswers[$k]) && trim($mergedAnswers[$k]) === '')
                            || (is_array($mergedAnswers[$k]) && !collect($mergedAnswers[$k])->flatten()->contains(fn($v) => $v !== null && !is_array($v) && trim((string)$v) !== ''));

                        if ($isNewEmpty) {
                            if (is_string($oldVal) && trim($oldVal) !== '') {
                                $mergedAnswers[$k] = $oldVal;
                            } elseif (is_array($oldVal) && collect($oldVal)->flatten()->contains(fn($v) => $v !== null && !is_array($v) && trim((string)$v) !== '')) {
                                if (!isset($mergedAnswers[$k]) || !is_array($mergedAnswers[$k])) {
                                    $mergedAnswers[$k] = $oldVal;
                                } else {
                                    // $subV may itself be a nested array (e.g. trans_matrix[verb] form
                                    // map) - never cast it to string directly.
                                    foreach ($oldVal as $subK => $subV) {
                                        $currentSubVal = $mergedAnswers[$k][$subK] ?? null;
                                        $currentSubEmpty = $currentSubVal === null
                                            || (is_string($currentSubVal) && trim($currentSubVal) === '')
                                            || (is_array($currentSubVal) && !collect($currentSubVal)->flatten()->contains(fn($v) => $v !== null && !is_array($v) && trim((string)$v) !== ''));
                                        $subHasContent = is_array($subV)
                                            ? collect($subV)->flatten()->contains(fn($v) => $v !== null && !is_array($v) && trim((string)$v) !== '')
                                            : trim((string)$subV) !== '';
                                        if ($currentSubEmpty && $subHasContent) {
                                            $mergedAnswers[$k][$subK] = $subV;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                $hasAnyFilledAnswer = (trim($paragraphAnswer) !== '') || collect($mergedAnswers)->flatten()->contains(function ($v) {
                    return $v !== null && trim((string)$v) !== '';
                });

                if ($hasAnyFilledAnswer) {
                    \App\Models\AssignmentDraft::updateOrCreate(
                        ['user_id' => $user->id, 'program_id' => $programId, 'meeting_number' => $meeting],
                        ['answers' => $mergedAnswers + ($paragraphAnswer !== '' ? ['paragraph_answer' => $paragraphAnswer] : []), 'last_saved_at' => now()]
                    );
                }
            }

            \Illuminate\Support\Facades\Cache::put(
                'user_' . $user->id . '_' . "{$track}_meeting{$meeting}_draft_answers",
                $mergedAnswers,
                now()->addHours(24)
            );
            if ($paragraphAnswer !== '') {
                \Illuminate\Support\Facades\Cache::put(
                    'user_' . $user->id . '_' . "{$track}_meeting{$meeting}_draft_paragraph_answer",
                    $paragraphAnswer,
                    now()->addHours(24)
                );
            }
        }

        return response()->json(['ok' => true, 'saved_at' => now()->toIso8601String()]);
    }

    private function resolveProficiencyMeetingContent(int $meeting): array
    {
        $fallbackQuestions = $this->proficiencyMeetingQuestions($meeting);
        $fallbackAnswerKeys = $this->proficiencyMeetingAnswerKeys($meeting);
        $questionRecords = collect($this->proficiencyMeetingQuestionRecords($meeting))->keyBy('question_number');

        $questions = [];
        $answerKeys = [];
        $editorData = [];

        foreach ($fallbackQuestions as $index => $fallbackQuestionText) {
            $questionNumber = $index + 1;
            $record = $questionRecords->get($questionNumber);

            $resolvedQuestionText = $record?->question_text ?? $fallbackQuestionText;
            $resolvedCorrectAnswer = (string) ($record?->correct_answer ?? ($fallbackAnswerKeys[$questionNumber] ?? ''));

            $questions[] = $resolvedQuestionText;
            $answerKeys[$questionNumber] = $resolvedCorrectAnswer;
            $editorData[$questionNumber] = [
                'db_id' => $record?->id,
                'question_text' => $resolvedQuestionText,
                'correct_answer' => $resolvedCorrectAnswer,
            ];
        }

        return [
            'questions' => $questions,
            'answerKeys' => $answerKeys,
            'editorData' => $editorData,
        ];
    }

    private function grammarQuestionsHasSectionColumn(): bool
    {
        static $hasSectionColumn = null;

        if ($hasSectionColumn === null) {
            $hasSectionColumn = \Illuminate\Support\Facades\Schema::hasColumn('grammar_questions', 'section');
        }

        return $hasSectionColumn;
    }

    private function proficiencyMeetingQuestionRecords(int $meeting): array
    {
        $query = GrammarQuestion::where('meeting_number', $meeting);
        if ($this->grammarQuestionsHasSectionColumn()) {
            $query->where('section', 'proficiency_' . $meeting);
        }
        return $query->orderBy('question_number')->get()->all();
    }

    private function resolveProficiencyMeetingParagraph(int $meeting): array
    {
        $fallbackParagraphs = $this->proficiencyMeetingParagraphs($meeting);
        $paragraphData = empty($fallbackParagraphs) ? null : $fallbackParagraphs;
        
        $query = GrammarQuestion::where('meeting_number', $meeting);
        if ($this->grammarQuestionsHasSectionColumn()) {
            $query->where('section', 'proficiency_paragraph_' . $meeting);
        }
        $record = $query->first();

        $editorData = [
            'db_id' => null,
            'question_text' => '',
            'correct_answer' => '',
        ];

        if ($record) {
            if ($paragraphData === null) {
                $paragraphData = ['id' => '', 'en' => '', 'vocab' => []];
            }
            $paragraphData['id'] = $record->question_text;
            $paragraphData['en'] = $record->correct_answer;
            $editorData['db_id'] = $record->id;
            $editorData['question_text'] = $record->question_text;
            $editorData['correct_answer'] = $record->correct_answer;
        } elseif ($paragraphData !== null) {
            $editorData['question_text'] = $paragraphData['id'] ?? '';
            $editorData['correct_answer'] = $paragraphData['en'] ?? '';
        }

        return [
            'paragraphData' => $paragraphData,
            'editorData' => $editorData,
        ];
    }

    public function grammarWriting(Request $request, BuildGrammarWritingIndexData $buildGrammarWritingIndexData, StudentFinalTestAccess $studentFinalTestAccess)
    {
        return $this->grammarWritingTrack($request, 'fast-track', $buildGrammarWritingIndexData, $studentFinalTestAccess);
    }

    public function updatePeriod(UpdateGrammarWritingPeriodRequest $request, ManageGrammarWritingMeetings $manageGrammarWritingMeetings)
    {
        $this->requireGrammarWritingAdminOrTeacher();

        $result = $manageGrammarWritingMeetings->updateActivePeriod(
            $request->classPeriodId(),
        );

        return back()
            ->with('success', $result['message'])
            ->with('success_state', $result['success_state']);
    }

    public function toggleLock(Meeting $meeting, Request $request, ManageGrammarWritingMeetings $manageGrammarWritingMeetings)
    {
        $this->requireGrammarWritingAdminOrTeacher();

        $result = $manageGrammarWritingMeetings->toggleLock($meeting->id, $request->integer('class_period_id'));

        return back()
            ->with('success', $result['message'])
            ->with('success_state', $result['success_state']);
    }
    public function bulkStoreIntroductoryQuestions(Request $request)
    {
        abort_unless(Auth::user()->isAdmin(), 403);

        $request->validate([
            'meeting_number' => 'required|integer',
            'questions_text' => 'required|string',
        ]);

        $meeting = (int) $request->input('meeting_number');
        $section = $this->introductoryMeetingSection($meeting);
        
        $lines = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $request->input('questions_text')))));
        
        $questionNumber = 1;
        foreach ($lines as $line) {
            if (empty($line)) continue;

            $query = GrammarQuestion::where('meeting_number', $meeting)
                ->where('question_number', $questionNumber);
            if ($this->grammarQuestionsHasSectionColumn()) {
                $query->where('section', $section);
            }
            $record = $query->first();

            if ($record) {
                $record->update(['question_text' => $line]);
            } else {
                $createData = [
                    'meeting_number' => $meeting,
                    'question_number' => $questionNumber,
                    'question_text' => $line,
                    'correct_answer' => '',
                ];
                if ($this->grammarQuestionsHasSectionColumn()) {
                    $createData['section'] = $section;
                }
                GrammarQuestion::create($createData);
            }
            $questionNumber++;
        }

        return back()->with('success', 'Soal berhasil diupdate secara massal.');
    }

    public function storeGrammarQuestion(StoreGrammarQuestionRequest $request, ManageGrammarWritingContent $manageGrammarWritingContent)
    {
        $manageGrammarWritingContent->createQuestion($request->validated());

        return back()->with('success', 'Question added successfully.');
    }

    public function updateGrammarQuestion(UpdateGrammarQuestionRequest $request, $id, ManageGrammarWritingContent $manageGrammarWritingContent)
    {
        $manageGrammarWritingContent->updateQuestion((int) $id, $request->validated());

        return back()->with('success', 'Question updated successfully.');
    }

    public function destroyGrammarQuestion($id, ManageGrammarWritingContent $manageGrammarWritingContent)
    {
        $manageGrammarWritingContent->deleteQuestion((int) $id);

        return back()->with('success', 'Question deleted successfully.');
    }

    public function storeGrammarVocabulary(StoreGrammarVocabularyRequest $request, ManageGrammarWritingContent $manageGrammarWritingContent)
    {
        $manageGrammarWritingContent->createVocabulary($request->validated());

        return back()->with('success', 'Vocabulary added successfully.');
    }

    public function updateGrammarVocabulary(UpdateGrammarVocabularyRequest $request, $id, ManageGrammarWritingContent $manageGrammarWritingContent)
    {
        $manageGrammarWritingContent->updateVocabulary((int) $id, $request->validated());

        return back()->with('success', 'Vocabulary updated successfully.');
    }

    public function destroyGrammarVocabulary($id, ManageGrammarWritingContent $manageGrammarWritingContent)
    {
        $manageGrammarWritingContent->deleteVocabulary((int) $id);

        return back()->with('success', 'Vocabulary deleted successfully.');
    }

    private function grammarWritingTracks(): array
    {
        return [
            'fast-track' => [
                'title' => 'Fast Track Grammar for Writing',
                'program_slug' => 'fast-track-grammar-for-writing',
                'description' => 'Program intensif 10 pertemuan grammar.',
                'summary' => '10 meetings mencakup dasar hingga lanjutan.',
                'accent' => 'blue',
                'gradient' => 'from-blue-400 to-blue-600',
                'meetings' => $this->buildFastTrackMeetings(),
            ],
            'introductory' => [
                'title' => 'Introductory Grammar for Writing',
                'program_slug' => 'introductory-grammar-for-writing',
                'description' => 'Kelas dasar tata bahasa Inggris untuk penulisan akademik.',
                'summary' => '19 focused meetings dari struktur dasar hingga persiapan examination.',
                'accent' => 'orange',
                'gradient' => 'from-orange-400 to-orange-600',
                'meetings' => $this->buildIntroductoryTrackMeetings(),
            ],
            'complexity' => [
                'title' => 'Complexity Grammar for Writing',
                'program_slug' => 'complexity-grammar-for-writing',
                'description' => 'Penguasaan struktur kalimat kompleks untuk penulisan lanjutan.',
                'summary' => '10 meetings untuk koordinasi, subordinasi, dan struktur kalimat yang lebih kompleks.',
                'accent' => 'green',
                'gradient' => 'from-green-400 to-green-600',
                'meetings' => $this->buildComplexityTrackMeetings(),
            ],
            'proficiency' => [
                'title' => 'Proficiency Grammar for Writing',
                'program_slug' => 'proficiency-grammar-for-writing',
                'description' => 'Tingkat mahir tata bahasa untuk penulisan akademik dan profesional.',
                'summary' => '10 meetings roadmap lanjutan untuk akurasi, gaya akademik, dan revisi tingkat mahir.',
                'accent' => 'purple',
                'gradient' => 'from-purple-400 to-purple-600',
                'meetings' => $this->buildProficiencyTrackMeetings(),
            ],
        ];
    }

    private function buildFastTrackMeetings(): array
    {
        $meetings = [];
        
        $topics = [
            1 => 'Silang - silang tenses',
            2 => 'Latihan penerapan tenses',
            3 => 'Modal',
            4 => 'Negative sentence',
            5 => 'To Infinitive & Gerund',
            6 => 'Noun Phrase, Comparative, Superlative, & Positive Degree',
            7 => 'FANBOYS & Adverbial Clause',
            8 => 'Adjective Clause - RPS / RPO',
            9 => 'Adjective Clause RPP, RA',
            10 => 'Noun Clause & Prepositional Phrase',
        ];
        
        for ($i = 1; $i <= 10; $i++) {
            $meetings[] = [
                'title' => 'Meeting ' . $i,
                'source_meeting_number' => $i,
                'topic' => $topics[$i],
                'description' => 'Latihan terarah untuk topik ' . strtolower($topics[$i]) . '.',
                'route_name' => 'assignments.grammar-writing.meeting' . $i,
                'route_parameters' => [],
                'available' => \Illuminate\Support\Facades\Route::has('assignments.grammar-writing.meeting' . $i),
                'is_bonus' => false,
            ];
        }

        $meetings[] = [
            'title' => 'Pertemuan Bonus',
            'source_meeting_number' => 11,
            'topic' => 'Peringkasan: Reducing, Abridgement, Omitting',
            'description' => 'Materi & latihan komprehensif teknik peringkasan: Reducing (Adj Clause), Abridgement (Adv Clause), dan Omitting (Noun & Relative Clause).',
            'route_name' => 'assignments.grammar-writing.fast-track.bonus',
            'route_parameters' => [],
            'available' => true,
            'is_bonus' => true,
        ];

        return $meetings;
    }

    private function buildIntroductoryTrackMeetings(): array
    {
        $introductoryMeetings = $this->introductoryMeetingCatalog();
        $meetings = [];

        foreach ($introductoryMeetings as $index => $introductoryMeeting) {
            $meetingNumber = $index + 1;
            $label = $introductoryMeeting['label'] ?? (string) $meetingNumber;

            $meetings[] = [
                'title' => 'Meeting ' . $label,
                'source_meeting_number' => $meetingNumber,
                'topic' => $introductoryMeeting['topic'],
                'description' => 'Latihan terarah untuk topik ' . strtolower($introductoryMeeting['topic']) . '.',
                'route_name' => 'assignments.grammar-writing.introductory.meeting',
                'route_parameters' => ['meeting' => $meetingNumber],
                'available' => true,
            ];
        }

        return $meetings;
    }

    public function introductoryMeetingCatalog(): array
    {
        return [
            ['label' => '1a', 'topic' => 'Simple Present Verbal'],
            ['label' => '1b', 'topic' => 'Simple Present Pasif'],
            ['label' => '2a', 'topic' => 'Simple Present Nominal'],
            ['label' => '2b', 'topic' => 'Simple Present Campuran'],
            ['label' => '3a', 'topic' => 'To Infinitive'],
            ['label' => '3b', 'topic' => 'Simple Past Verbal'],
            ['label' => '4a', 'topic' => 'Simple Past Passive + Nominal'],
            ['label' => '4b', 'topic' => 'Negative Simple Present Verbal dan Simple Past Verbal'],
            ['label' => '5a', 'topic' => 'Simple Present & Simple Past Campuran'],
            ['label' => '5b', 'topic' => 'Pronoun'],
            ['label' => '6a', 'topic' => 'Irregular Verb'],
            ['label' => '6b', 'topic' => 'Present Continuous Verbal, Nominal, Passive'],
            ['label' => '7a', 'topic' => 'Present Perfect & Negative, Present Perfect Continuous Positive & Negative'],
            ['label' => '7b', 'topic' => 'Review Simple Present - Present Perfect'],
            ['label' => '8a', 'topic' => 'Modal'],
            ['label' => '8b', 'topic' => 'Gerund'],
            ['label' => '9a', 'topic' => 'Complex Ditransitive'],
            ['label' => '9b', 'topic' => 'Noun Phrase'],
            ['label' => '10a', 'topic' => 'Examination'],
        ];
    }

    public function introductoryMeetingCheatSheet(int $meeting): ?array
    {
        return match ($meeting) {
            1 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Pola Simple Present Verbal (Simple Present Aktif)
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Subjek</th><th class="p-3.5 font-semibold border-b border-gray-700">Pola Kalimat (Formula)</th><th class="p-3.5 font-semibold border-b border-gray-700">Akhiran Verb</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">I / You / We / They / Jamak</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + V1 + O / C</td><td class="p-3.5 text-gray-800">V1 tanpa akhiran</td><td class="p-3.5 italic text-gray-600">I study English every day.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">He / She / It / Tunggal</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + V1(s/es) + O / C</td><td class="p-3.5 text-gray-800">V1 + -s / -es</td><td class="p-3.5 italic text-gray-600">She works at the hospital.</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Gunakan Simple Present untuk menyatakan fakta umum, kebiasaan sehari-hari, atau rutinitas tetap.</li><li class="leading-relaxed">Penanda waktu umum: <em>every day, always, usually, often, sometimes, never, generally</em>.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Subjek tunggal (He/She/It) wajib menambahkan akhiran <strong>-s</strong> atau <strong>-es</strong> pada kata kerja.</li><li class="leading-relaxed">Akhiran -es untuk verb berakhiran -ch, -sh, -s, -x, -z, -o (<em>watch → watches, go → goes</em>).</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Jangan tambahkan be (am/is/are) sebelum V1 pada kalimat verbal aktif!</em>
    </div>
    
HTML
],
            2 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Pola Simple Present Pasif (Passive Voice)
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Subjek Pasif</th><th class="p-3.5 font-semibold border-b border-gray-700">To Be</th><th class="p-3.5 font-semibold border-b border-gray-700">Verb 3 (Past Participle)</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat Pasif</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">I</td><td class="p-3.5 text-gray-800">am</td><td class="p-3.5 text-gray-800">V3 (analyzed, invited)</td><td class="p-3.5 italic text-gray-600">I am invited to the conference.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">He / She / It / Tunggal</td><td class="p-3.5 text-gray-800">is</td><td class="p-3.5 text-gray-800">V3 (sent, cleaned, written)</td><td class="p-3.5 italic text-gray-600">The letter is sent by the secretary.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">You / We / They / Jamak</td><td class="p-3.5 text-gray-800">are</td><td class="p-3.5 text-gray-800">V3 (washed, built, printed)</td><td class="p-3.5 italic text-gray-600">The cars are washed by my father.</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Kalimat pasif fokus pada objek/penerima tindakan, bukan pelakunya.</li><li class="leading-relaxed">Frasa <code>by + pelaku</code> opsional jika pelaku tidak penting.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Rumus utama: <strong>Subjek + am/is/are + V3</strong>.</li><li class="leading-relaxed">Verb wajib berbentuk Past Participle (V3).</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Contoh V3: analyze → analyzed, write → written, wash → washed.</em>
    </div>
    
HTML
],
            3 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Pola Simple Present Nominal
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Subjek</th><th class="p-3.5 font-semibold border-b border-gray-700">To Be</th><th class="p-3.5 font-semibold border-b border-gray-700">Komplemen (Adj / Noun / Prep)</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">I</td><td class="p-3.5 text-gray-800">am</td><td class="p-3.5 text-gray-800">Nominal (student, happy)</td><td class="p-3.5 italic text-gray-600">I am a student at the university.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">He / She / It / Tunggal</td><td class="p-3.5 text-gray-800">is</td><td class="p-3.5 text-gray-800">Nominal (clean, spacious)</td><td class="p-3.5 italic text-gray-600">Our new house is clean and spacious.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">You / We / They / Jamak</td><td class="p-3.5 text-gray-800">are</td><td class="p-3.5 text-gray-800">Nominal (happy, teachers)</td><td class="p-3.5 italic text-gray-600">We are all happy living here.</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Kalimat nominal predikatnya bukan kata kerja aksi (adalah, merupakan, berada).</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Rumus: <strong>Subjek + am/is/are + Nominal</strong>.</li><li class="leading-relaxed">Jangan gabungkan am/is/are dengan V1 langsung.</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Gunakan 'am' (I), 'is' (Tunggal), 'are' (Jamak/You/We/They).</em>
    </div>
    
HTML
],
            4 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Perbandingan 3 Pola Simple Present
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Jenis Kalimat</th><th class="p-3.5 font-semibold border-b border-gray-700">Formula Utama</th><th class="p-3.5 font-semibold border-b border-gray-700">Makna Predikat</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Verbal Aktif</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + V1 / V1(s/es)</td><td class="p-3.5 text-gray-800">Melakukan aksi (me-, ber-)</td><td class="p-3.5 italic text-gray-600">Mother buys storybooks every month.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Nominal</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + am/is/are + Nominal</td><td class="p-3.5 text-gray-800">Keadaan / Identitas (adalah)</td><td class="p-3.5 italic text-gray-600">The house is comfortable and spacious.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Pasif</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + am/is/are + V3</td><td class="p-3.5 text-gray-800">Menerima aksi (di-, ter-)</td><td class="p-3.5 italic text-gray-600">The room is cleaned by mother.</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Tentukan jenis predikat sebelum memilih rumus.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Verbal Aktif: V1(s/es) tanpa be.</li><li class="leading-relaxed">Nominal: am/is/are + Nominal.</li><li class="leading-relaxed">Pasif: am/is/are + V3.</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Selalu sesuaikan be / verb dengan subjeknya.</em>
    </div>
    
HTML
],
            5 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Pola To Infinitive (To + V1)
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Fungsi</th><th class="p-3.5 font-semibold border-b border-gray-700">Formula</th><th class="p-3.5 font-semibold border-b border-gray-700">Makna</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Objek Verb</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + Verb + To + V1</td><td class="p-3.5 text-gray-800">Menyatakan niat/rencana</td><td class="p-3.5 italic text-gray-600">I want to buy a new storybook.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Keterangan Tujuan</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + Verb + To + V1</td><td class="p-3.5 text-gray-800">Tujuan dari aksi</td><td class="p-3.5 italic text-gray-600">We study hard to achieve our goals.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Setelah Adjective</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + Be + Adj + To + V1</td><td class="p-3.5 text-gray-800">Sifat dari tindakan</td><td class="p-3.5 italic text-gray-600">It is important to maintain cleanliness.</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Verb yang diikuti To Infinitive: <em>want, decide, plan, aim, need, agree, hope, promise, refuse</em>.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Setelah <strong>to</strong> wajib kata kerja <strong>V1 dasar</strong>.</li><li class="leading-relaxed">Dilarang menambahkan -s, -ed, atau -ing setelah 'to'.</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Format benar: to buy, to study, to learn.</em>
    </div>
    
HTML
],
            6 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Pola Simple Past Verbal
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Subjek</th><th class="p-3.5 font-semibold border-b border-gray-700">Verb 2</th><th class="p-3.5 font-semibold border-b border-gray-700">Jenis Verb</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Semua Subjek</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">V2 (visited, lived)</td><td class="p-3.5 text-gray-800">Regular (V1 + -ed)</td><td class="p-3.5 italic text-gray-600">I visited my grandmother last week.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Semua Subjek</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">V2 (bought, wrote)</td><td class="p-3.5 text-gray-800">Irregular (Bentuk khusus)</td><td class="p-3.5 italic text-gray-600">Mother bought a storybook yesterday.</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Menyatakan kejadian yang selesai di masa lampau.</li><li class="leading-relaxed">Penanda waktu: <em>yesterday, last week, ago, in 2020</em>.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Semua subjek menggunakan bentuk V2 yang sama.</li><li class="leading-relaxed">Regular Verb +ed, Irregular Verb punya bentuk khusus.</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Gunakan tabel Irregular Verbs untuk menghafal perubahan kata kerja.</em>
    </div>
    
HTML
],
            7 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Pola Simple Past Pasif & Nominal
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Jenis Kalimat</th><th class="p-3.5 font-semibold border-b border-gray-700">Subjek</th><th class="p-3.5 font-semibold border-b border-gray-700">To Be Lampau</th><th class="p-3.5 font-semibold border-b border-gray-700">Komplemen / V3</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Past Pasif</td><td class="p-3.5 text-gray-800">I / He / She / It / Single</td><td class="p-3.5 text-gray-800">was</td><td class="p-3.5 text-gray-800">V3 (built, cleaned)</td><td class="p-3.5 italic text-gray-600">This old house was built in 1990.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Past Pasif</td><td class="p-3.5 text-gray-800">You / We / They / Plural</td><td class="p-3.5 text-gray-800">were</td><td class="p-3.5 text-gray-800">V3 (built, cleaned)</td><td class="p-3.5 italic text-gray-600">The books were given to students.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Past Nominal</td><td class="p-3.5 text-gray-800">I / He / She / It / Single</td><td class="p-3.5 text-gray-800">was</td><td class="p-3.5 text-gray-800">Nominal (quiet, happy)</td><td class="p-3.5 italic text-gray-600">The city was quiet 10 years ago.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Past Nominal</td><td class="p-3.5 text-gray-800">You / We / They / Plural</td><td class="p-3.5 text-gray-800">were</td><td class="p-3.5 text-gray-800">Nominal (happy, ready)</td><td class="p-3.5 italic text-gray-600">We were happy during the trip.</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Gunakan <strong>was</strong> untuk I, He, She, It, Single.</li><li class="leading-relaxed">Gunakan <strong>were</strong> untuk You, We, They, Plural.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Past Pasif: <strong>was/were + V3</strong>.</li><li class="leading-relaxed">Past Nominal: <strong>was/were + Nominal</strong>.</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Perhatikan perbedaan present (am/is/are) vs past (was/were).</em>
    </div>
    
HTML
],
            8 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Pola Negatif Present & Past Verbal
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Tenses</th><th class="p-3.5 font-semibold border-b border-gray-700">Subjek</th><th class="p-3.5 font-semibold border-b border-gray-700">Auxiliary Negatif</th><th class="p-3.5 font-semibold border-b border-gray-700">Verb</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Simple Present</td><td class="p-3.5 text-gray-800">I / You / We / They</td><td class="p-3.5 text-gray-800">do not (don't)</td><td class="p-3.5 text-gray-800">V1 Dasar</td><td class="p-3.5 italic text-gray-600">I do not drink coffee every morning.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Simple Present</td><td class="p-3.5 text-gray-800">He / She / It / Single</td><td class="p-3.5 text-gray-800">does not (doesn't)</td><td class="p-3.5 text-gray-800">V1 Dasar</td><td class="p-3.5 italic text-gray-600">He does not work on Sunday.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Simple Past</td><td class="p-3.5 text-gray-800">Semua Subjek</td><td class="p-3.5 text-gray-800">did not (didn't)</td><td class="p-3.5 text-gray-800">V1 Dasar</td><td class="p-3.5 italic text-gray-600">They did not visit the museum yesterday.</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Present: <em>don't / doesn't</em>. Past: <em>didn't</em>.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Setelah <strong>do / does / did</strong>, verb WAJIB kembali ke <strong>V1 Dasar</strong>!</li><li class="leading-relaxed"><s>doesn't works</s> → <strong>doesn't work</strong>.</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Auxiliary sudah membawa aspek tense, sehingga verb utama selalu netral (V1).</em>
    </div>
    
HTML
],
            9 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Matriks 6 Pola Dasar Simple Present & Past
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">No</th><th class="p-3.5 font-semibold border-b border-gray-700">Pola Kalimat</th><th class="p-3.5 font-semibold border-b border-gray-700">Formula Utama</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">1</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">Present Verbal Aktif</td><td class="p-3.5 text-gray-800">S + V1 / V1(s/es)</td><td class="p-3.5 italic text-gray-600">She reads a book every day.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">2</td><td class="p-3.5 text-gray-800">Present Nominal</td><td class="p-3.5 text-gray-800">S + am/is/are + Nominal</td><td class="p-3.5 italic text-gray-600">The classroom is clean.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">3</td><td class="p-3.5 text-gray-800">Present Pasif</td><td class="p-3.5 text-gray-800">S + is/am/are + V3</td><td class="p-3.5 italic text-gray-600">The room is cleaned every day.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">4</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">Past Verbal Aktif</td><td class="p-3.5 text-gray-800">S + V2</td><td class="p-3.5 italic text-gray-600">They visited Bali last year.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">5</td><td class="p-3.5 text-gray-800">Past Nominal</td><td class="p-3.5 text-gray-800">S + was/were + Nominal</td><td class="p-3.5 italic text-gray-600">He was tired yesterday.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">6</td><td class="p-3.5 text-gray-800">Past Pasif</td><td class="p-3.5 text-gray-800">S + was/were + V3</td><td class="p-3.5 italic text-gray-600">The car was repaired yesterday.</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Cek keterangan waktu untuk menentukan Present vs Past.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Identifikasi jenis predikat sebelum menerapkan rumus.</li><li class="leading-relaxed">Pastikan kesesuaian subjek dengan be / auxiliary.</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Latihan campuran ini menguji pemahaman menyeluruh.</em>
    </div>
    
HTML
],
            10 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Tabel Kata Ganti (Pronouns)
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Subject</th><th class="p-3.5 font-semibold border-b border-gray-700">Object</th><th class="p-3.5 font-semibold border-b border-gray-700">Possessive Adj</th><th class="p-3.5 font-semibold border-b border-gray-700">Possessive Pronoun</th><th class="p-3.5 font-semibold border-b border-gray-700">Reflexive</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">I</td><td class="p-3.5 text-gray-800">me</td><td class="p-3.5 text-gray-800">my (+ Noun)</td><td class="p-3.5 text-gray-800">mine</td><td class="p-3.5 italic text-gray-600">myself</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">You</td><td class="p-3.5 text-gray-800">you</td><td class="p-3.5 text-gray-800">your (+ Noun)</td><td class="p-3.5 text-gray-800">yours</td><td class="p-3.5 italic text-gray-600">yourself / yourselves</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">He</td><td class="p-3.5 text-gray-800">him</td><td class="p-3.5 text-gray-800">his (+ Noun)</td><td class="p-3.5 text-gray-800">his</td><td class="p-3.5 italic text-gray-600">himself</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">She</td><td class="p-3.5 text-gray-800">her</td><td class="p-3.5 text-gray-800">her (+ Noun)</td><td class="p-3.5 text-gray-800">hers</td><td class="p-3.5 italic text-gray-600">herself</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">It</td><td class="p-3.5 text-gray-800">it</td><td class="p-3.5 text-gray-800">its (+ Noun)</td><td class="p-3.5 text-gray-800">its</td><td class="p-3.5 italic text-gray-600">itself</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">We</td><td class="p-3.5 text-gray-800">us</td><td class="p-3.5 text-gray-800">our (+ Noun)</td><td class="p-3.5 text-gray-800">ours</td><td class="p-3.5 italic text-gray-600">ourselves</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">They</td><td class="p-3.5 text-gray-800">them</td><td class="p-3.5 text-gray-800">their (+ Noun)</td><td class="p-3.5 text-gray-800">theirs</td><td class="p-3.5 italic text-gray-600">themselves</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Subject diletakkan sebelum verb. Object diletakkan setelah verb/preposisi.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Possessive Adjective (my, his, her) WAJIB diikuti kata benda.</li><li class="leading-relaxed">Possessive Pronoun (mine, hers, theirs) berdiri sendiri.</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Bedakan 'its' (kepemilikan) dan 'it's' (it is / it has).</em>
    </div>
    
HTML
],
            11 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Pola Irregular Verbs
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">V1 (Base)</th><th class="p-3.5 font-semibold border-b border-gray-700">V2 (Past)</th><th class="p-3.5 font-semibold border-b border-gray-700">V3 (Participle)</th><th class="p-3.5 font-semibold border-b border-gray-700">Makna</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">go</td><td class="p-3.5 text-gray-800">went</td><td class="p-3.5 text-gray-800">gone</td><td class="p-3.5 italic text-gray-600">pergi</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">buy</td><td class="p-3.5 text-gray-800">bought</td><td class="p-3.5 text-gray-800">bought</td><td class="p-3.5 italic text-gray-600">membeli</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">write</td><td class="p-3.5 text-gray-800">wrote</td><td class="p-3.5 text-gray-800">written</td><td class="p-3.5 italic text-gray-600">menulis</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">take</td><td class="p-3.5 text-gray-800">took</td><td class="p-3.5 text-gray-800">taken</td><td class="p-3.5 italic text-gray-600">mengambil</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">see</td><td class="p-3.5 text-gray-800">saw</td><td class="p-3.5 text-gray-800">seen</td><td class="p-3.5 italic text-gray-600">melihat</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">make</td><td class="p-3.5 text-gray-800">made</td><td class="p-3.5 text-gray-800">made</td><td class="p-3.5 italic text-gray-600">membuat</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Irregular Verbs tidak menggunakan akhiran -ed.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">V2 untuk Simple Past Aktif.</li><li class="leading-relaxed">V3 untuk Passive Voice & Present Perfect.</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Gunakan fitur tombol 🔀 (Irregular Verbs) di pojok layar.</em>
    </div>
    
HTML
],
            12 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Pola Present Continuous
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Jenis Kalimat</th><th class="p-3.5 font-semibold border-b border-gray-700">Subjek</th><th class="p-3.5 font-semibold border-b border-gray-700">Auxiliary & Aspect</th><th class="p-3.5 font-semibold border-b border-gray-700">Predikat / Komplemen</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Verbal Aktif</td><td class="p-3.5 text-gray-800">I</td><td class="p-3.5 text-gray-800">am</td><td class="p-3.5 text-gray-800">V-ing (reading, studying)</td><td class="p-3.5 italic text-gray-600">I am reading a storybook now.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Verbal Aktif</td><td class="p-3.5 text-gray-800">He / She / It / Single</td><td class="p-3.5 text-gray-800">is</td><td class="p-3.5 text-gray-800">V-ing (writing, working)</td><td class="p-3.5 italic text-gray-600">She is writing a letter right now.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Verbal Aktif</td><td class="p-3.5 text-gray-800">You / We / They / Plural</td><td class="p-3.5 text-gray-800">are</td><td class="p-3.5 text-gray-800">V-ing (playing, learning)</td><td class="p-3.5 italic text-gray-600">They are studying in the library.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Pasif</td><td class="p-3.5 text-gray-800">Subjek Pasif</td><td class="p-3.5 text-gray-800">am/is/are + being</td><td class="p-3.5 text-gray-800">V3 (cleaned, built)</td><td class="p-3.5 italic text-gray-600">The house is being cleaned right now.</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Aksi sedang berlangsung saat ini (now, right now, currently).</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            <li class="leading-relaxed">Verbal: <strong>am/is/are + V-ing</strong>.</li><li class="leading-relaxed">Pasif: <strong>am/is/are + being + V3</strong>.</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Stative verbs (like, know, want) jarang digunakan dalam bentuk continuous.</em>
    </div>
    
HTML
],
            13 => ['__html__' => <<<'HTML'

    <!-- Section 1: Fungsi Utama Tenses -->
    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            <span class="bg-indigo-600 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold shadow-xs">1</span>
            Fungsi & Kegunaan Utama Tenses
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5 mb-4 text-xs sm:text-sm">
            <!-- Present Perfect Functions -->
            <div class="bg-blue-50/80 border border-blue-200 rounded-xl p-4 text-blue-950 shadow-xs">
                <strong class="block text-blue-900 font-bold mb-2 pb-1 border-b border-blue-200 text-sm flex items-center gap-1.5">
                    <span>📌 Fungsi Present Perfect Tense:</span>
                </strong>
                <ul class="space-y-2 text-xs leading-relaxed text-blue-950">
                    <li>• <strong>Pengalaman Hidup (Experience):</strong> Aksi pernah/belum pernah dialami tanpa waktu lampau spesifik.<br>
                        <em class="text-blue-800">Contoh: I have visited Japan twice. (Saya sudah pernah ke Jepang 2x).</em>
                    </li>
                    <li>• <strong>Hasil Nyata di Saat Ini (Present Result):</strong> Aksi selesai di masa lalu, tapi akibat/efeknya terasa sekarang.<br>
                        <em class="text-blue-800">Contoh: She has lost her key. (Kuncinya hilang, sekarang belum ketemu).</em>
                    </li>
                    <li>• <strong>Durasi s.d. Sekarang (Unfinished Past):</strong> Dimulai masa lalu & masih berlangsung sampai sekarang.<br>
                        <em class="text-blue-800">Contoh: We have lived here for 5 years. (Masih tinggal di sini).</em>
                    </li>
                    <li>• <strong>Baru Saja Terjadi (Recent Action):</strong> Menggunakan <em>just, already, yet</em>.<br>
                        <em class="text-blue-800">Contoh: The train has just arrived. / He hasn't eaten yet.</em>
                    </li>
                </ul>
            </div>

            <!-- Present Perfect Continuous Functions -->
            <div class="bg-emerald-50/80 border border-emerald-200 rounded-xl p-4 text-emerald-950 shadow-xs">
                <strong class="block text-emerald-900 font-bold mb-2 pb-1 border-b border-emerald-200 text-sm flex items-center gap-1.5">
                    <span>⏱️ Fungsi Present Perfect Continuous:</span>
                </strong>
                <ul class="space-y-2 text-xs leading-relaxed text-emerald-950">
                    <li>• <strong>Menekankan Durasi & Proses Berkelanjutan:</strong> Menyoroti lama waktu aktivitas yang terus berjalan.<br>
                        <em class="text-emerald-800">Contoh: He has been studying for 3 hours. (Sudah 3 jam dan masih belajar).</em>
                    </li>
                    <li>• <strong>Aktivitas Baru Saja Berhenti dengan Bukti Jelas:</strong> Aktivitas baru selesai tapi buktinya nyata terlihat.<br>
                        <em class="text-emerald-800">Contoh: It has been raining. (Hujannya baru reda, tapi jalanan masih basah).</em>
                    </li>
                    <li>• <strong>Aktivitas Sementara / Kebiasaan Akhir-akhir Ini:</strong> Dengan <em>lately, recently</em>.<br>
                        <em class="text-emerald-800">Contoh: I have been exercising a lot lately. (Akhir-akhir ini rajin berolahraga).</em>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Box Perbedaan Kunci -->
        <div class="bg-indigo-50/90 border border-indigo-200 rounded-xl p-3.5 text-xs text-indigo-950 shadow-xs mb-4">
            <strong class="block text-indigo-900 font-bold mb-1 text-xs sm:text-sm">⚡ Perbedaan Kunci (Present Perfect vs Continuous):</strong>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-1.5 text-xs">
                <div class="bg-white p-2.5 rounded-lg border border-indigo-100">
                    <span class="font-bold text-blue-900 block mb-0.5">Present Perfect &rarr; Fokus HASIL SELESAI</span>
                    <span class="text-gray-700 italic">"I have written 3 letters."</span> (Menekankan jumlah surat yang <u>sudah selesai</u> dibuat).
                </div>
                <div class="bg-white p-2.5 rounded-lg border border-indigo-100">
                    <span class="font-bold text-emerald-900 block mb-0.5">Present Perfect Cont. &rarr; Fokus DURASI / PROSES</span>
                    <span class="text-gray-700 italic">"I have been writing letters all morning."</span> (Menekankan <u>proses menulisnya</u> yang memakan waktu).
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Pola Present Perfect Tense -->
    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            <span class="bg-indigo-600 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold shadow-xs">2</span>
            Pola & Formula Present Perfect Tense
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3 font-semibold border-b border-gray-700">Jenis Kalimat</th>
                            <th class="p-3 font-semibold border-b border-gray-700">Subjek</th>
                            <th class="p-3 font-semibold border-b border-gray-700">Formula Utama</th>
                            <th class="p-3 font-semibold border-b border-gray-700">Contoh Kalimat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-slate-50 transition-colors">
                            <td class="p-3 font-bold text-blue-800 whitespace-nowrap">Verbal Positif (+)</td>
                            <td class="p-3 text-gray-800">I, You, We, They, Plural</td>
                            <td class="p-3 font-mono text-blue-700 text-xs">S + have + V3</td>
                            <td class="p-3 italic text-gray-600">I <strong>have lived</strong> in this city for 5 years.</td>
                        </tr>
                        <tr class="bg-white hover:bg-slate-50 transition-colors">
                            <td class="p-3 font-bold text-blue-800 whitespace-nowrap">Verbal Positif (+)</td>
                            <td class="p-3 text-gray-800">He, She, It, Single</td>
                            <td class="p-3 font-mono text-blue-700 text-xs">S + has + V3</td>
                            <td class="p-3 italic text-gray-600">She <strong>has written</strong> two articles.</td>
                        </tr>
                        <tr class="bg-white hover:bg-slate-50 transition-colors">
                            <td class="p-3 font-bold text-red-800 whitespace-nowrap">Verbal Negatif (-)</td>
                            <td class="p-3 text-gray-800">Semua Subjek</td>
                            <td class="p-3 font-mono text-red-700 text-xs">S + have/has + not + V3</td>
                            <td class="p-3 italic text-gray-600">We <strong>have not received</strong> the letter yet.</td>
                        </tr>
                        <tr class="bg-white hover:bg-slate-50 transition-colors">
                            <td class="p-3 font-bold text-purple-800 whitespace-nowrap">Nominal (Keadaan)</td>
                            <td class="p-3 text-gray-800">Semua Subjek</td>
                            <td class="p-3 font-mono text-purple-700 text-xs">S + have/has + been + Adj/Noun</td>
                            <td class="p-3 italic text-gray-600">He <strong>has been sick</strong> since yesterday.</td>
                        </tr>
                        <tr class="bg-white hover:bg-slate-50 transition-colors">
                            <td class="p-3 font-bold text-amber-800 whitespace-nowrap">Pasif (Passive)</td>
                            <td class="p-3 text-gray-800">Subjek Pasif</td>
                            <td class="p-3 font-mono text-amber-700 text-xs">S + have/has + been + V3</td>
                            <td class="p-3 italic text-gray-600">The new rules <strong>have been announced</strong>.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Section 3: Pola Present Perfect Continuous Tense -->
    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            <span class="bg-indigo-600 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold shadow-xs">3</span>
            Pola & Formula Present Perfect Continuous Tense
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3 font-semibold border-b border-gray-700">Jenis Kalimat</th>
                            <th class="p-3 font-semibold border-b border-gray-700">Subjek</th>
                            <th class="p-3 font-semibold border-b border-gray-700">Formula Utama</th>
                            <th class="p-3 font-semibold border-b border-gray-700">Contoh Kalimat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-slate-50 transition-colors">
                            <td class="p-3 font-bold text-emerald-800 whitespace-nowrap">Verbal Positif (+)</td>
                            <td class="p-3 text-gray-800">I, You, We, They, Plural</td>
                            <td class="p-3 font-mono text-emerald-700 text-xs">S + have + been + V-ing</td>
                            <td class="p-3 italic text-gray-600">They <strong>have been playing</strong> for 2 hours.</td>
                        </tr>
                        <tr class="bg-white hover:bg-slate-50 transition-colors">
                            <td class="p-3 font-bold text-emerald-800 whitespace-nowrap">Verbal Positif (+)</td>
                            <td class="p-3 text-gray-800">He, She, It, Single</td>
                            <td class="p-3 font-mono text-emerald-700 text-xs">S + has + been + V-ing</td>
                            <td class="p-3 italic text-gray-600">He <strong>has been working</strong> since morning.</td>
                        </tr>
                        <tr class="bg-white hover:bg-slate-50 transition-colors">
                            <td class="p-3 font-bold text-red-800 whitespace-nowrap">Verbal Negatif (-)</td>
                            <td class="p-3 text-gray-800">Semua Subjek</td>
                            <td class="p-3 font-mono text-red-700 text-xs">S + have/has + not + been + V-ing</td>
                            <td class="p-3 italic text-gray-600">She <strong>has not been feeling</strong> well lately.</td>
                        </tr>
                        <tr class="bg-white hover:bg-slate-50 transition-colors">
                            <td class="p-3 font-bold text-indigo-800 whitespace-nowrap">Tanya (?)</td>
                            <td class="p-3 text-gray-800">Semua Subjek</td>
                            <td class="p-3 font-mono text-indigo-700 text-xs">Have/Has + S + been + V-ing?</td>
                            <td class="p-3 italic text-gray-600"><strong>Have you been waiting</strong> long?</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Section 4: Keterangan Waktu Khas (Signal Words) -->
    <div class="mb-5 bg-white border border-gray-200 rounded-xl p-4 shadow-xs text-xs sm:text-sm">
        <strong class="block text-gray-900 font-bold mb-2 flex items-center gap-1.5 text-sm">
            <span>🕒 Keterangan Waktu & Signal Words Populer:</span>
        </strong>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
            <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200">
                <span class="font-bold text-indigo-900">Since vs For:</span>
                <ul class="list-disc list-inside text-gray-700 mt-1 space-y-0.5">
                    <li><strong>Since + Titik Waktu Awal:</strong> <em>since 2018, since morning, since Monday, since last year</em>.</li>
                    <li><strong>For + Durasi Waktu:</strong> <em>for 5 years, for two hours, for three days, for a long time</em>.</li>
                </ul>
            </div>
            <div class="bg-slate-50 p-2.5 rounded-lg border border-slate-200">
                <span class="font-bold text-indigo-900">Signal Words Lainnya:</span>
                <ul class="list-disc list-inside text-gray-700 mt-1 space-y-0.5">
                    <li><strong>Already:</strong> Sudah (kalimat positif).</li>
                    <li><strong>Yet:</strong> Belum / Sudahkah (kalimat negatif / tanya di akhir).</li>
                    <li><strong>Just / Recently / Lately:</strong> Baru saja / akhir-akhir ini.</li>
                    <li><strong>Ever / Never:</strong> Pernah / Tidak pernah.</li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Tips & Panduan Pemahaman -->
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            💡 Tips & Panduan Pemahaman Menerjemahkan:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Jika kalimat menyebutkan <strong>sudah/telah</strong> melakukan aksi atau memiliki hasil saat ini &rarr; gunakan <strong>Present Perfect (have/has + V3)</strong>.</li>
            <li class="leading-relaxed">Jika kalimat menekankan <strong>sudah sedang / terus berlangsung</strong> selama durasi waktu &rarr; gunakan <strong>Present Perfect Continuous (have/has + been + V-ing)</strong>.</li>
            <li class="leading-relaxed">Jika kalimat berpredikat kata sifat/tempat (<em>adalah, berada, sakit, senang</em>) &rarr; gunakan <strong>have/has + been + Nominal</strong>.</li>
        </ul>
    </div>
    
    <!-- Aturan & Formula Penting -->
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            ⚠️ Aturan Emas Gramatikal:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed"><strong>Have</strong> untuk <em>I, You, We, They, Jamak</em>; <strong>Has</strong> untuk <em>He, She, It, Tunggal</em>.</li>
            <li class="leading-relaxed">Present Perfect Verbal <strong>WAJIB menggunakan Verb 3 (Past Participle)</strong>, bukan V1 atau V2.</li>
            <li class="leading-relaxed"><strong>Stative Verbs</strong> (kata kerja non-aksi seperti <em>know, like, belong, understand, believe</em>) tidak menggunakan continuous, gunakan Present Perfect biasa (<em>I have known him for 10 years</em>).</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Perhatikan subjek dan penanda waktu (since/for/already/yet) sebelum menerjemahkan.</em>
    </div>
HTML
],
            14 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Review Simple Present s.d. Present Perfect
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Tense</th><th class="p-3.5 font-semibold border-b border-gray-700">Fokus Waktu</th><th class="p-3.5 font-semibold border-b border-gray-700">Formula</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Simple Present</td><td class="p-3.5 text-gray-800">Fakta / Rutinitas</td><td class="p-3.5 text-gray-800">S + V1(s/es) | am/is/are</td><td class="p-3.5 italic text-gray-600">I live in Jakarta.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Simple Past</td><td class="p-3.5 text-gray-800">Kejadian selesai di masa lalu</td><td class="p-3.5 text-gray-800">S + V2 | was/were</td><td class="p-3.5 italic text-gray-600">I lived in Bandung in 2018.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Present Continuous</td><td class="p-3.5 text-gray-800">Sedang terjadi saat ini</td><td class="p-3.5 text-gray-800">S + am/is/are + V-ing</td><td class="p-3.5 italic text-gray-600">I am studying English now.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Present Perfect</td><td class="p-3.5 text-gray-800">Pengalaman / Durasi s.d. sekarang</td><td class="p-3.5 text-gray-800">S + have/has + V3</td><td class="p-3.5 italic text-gray-600">I have lived here for 5 years.</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Cek keterangan waktu untuk memilih tense secara tepat.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Simple Past memerlukan waktu spesifik lampau.</li><li class="leading-relaxed">Present Perfect berfokus pada hasil/durasi s.d. sekarang.</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Latihan campuran ini memantapkan pemahaman tenses dasar.</em>
    </div>
    
HTML
],
            15 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            1. Pola Summary Chart of Modals & Phrasal Modals (Modul Hal. 13-16)
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Kategori Modal</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Daftar Anggota</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Bentuk Present / Future</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Bentuk Lampau (Past Form)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Pure Modals (Modal Dasar)</td>
                            <td class="p-3.5 font-mono text-blue-700">can, could, may, might, will, would, shall, should, must, ought to, used to</td>
                            <td class="p-3.5 font-mono text-blue-700">Modal + V1 / be</td>
                            <td class="p-3.5 font-mono text-blue-700">Modal + have + V3 / been</td>
                        </tr>
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Phrasal Modals</td>
                            <td class="p-3.5 font-mono text-blue-700">be going to, be able to, be supposed to, have to, have got to, had better</td>
                            <td class="p-3.5 font-mono text-blue-700">is/am/are/have + V1</td>
                            <td class="p-3.5 font-mono text-blue-700">was/were/had + V1</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2 mt-6">
            2. Detail Penggunaan Modals & Past Modals Sesuai Modul PDF (Hal. 14-16)
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 text-xs sm:text-sm">
            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
                <strong class="block text-blue-900 font-bold mb-2 border-b pb-1 text-sm">Kemampuan & Izin (Ability & Permission):</strong>
                <ul class="space-y-1.5 text-gray-700">
                    <li>• <strong>Can / Be able to:</strong> Kemampuan (*I can swim / I am able to help*).</li>
                    <li>• <strong>May / Can / Could:</strong> Izin sopan (*May I leave? / Could you help me?*).</li>
                    <li>• <strong>Could:</strong> Kemampuan masa lalu (*I could run fast when young*).</li>
                </ul>
            </div>

            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
                <strong class="block text-purple-900 font-bold mb-2 border-b pb-1 text-sm">Saran & Keharusan (Advice & Necessity):</strong>
                <ul class="space-y-1.5 text-gray-700">
                    <li>• <strong>Should / Ought to / Had better:</strong> Saran (*You should rest / You had better be on time*).</li>
                    <li>• <strong>Must / Have to / Have got to:</strong> Keharusan kuat (*You must wear helmet / I have to go*).</li>
                    <li>• <strong>Must not:</strong> Larangan keras (*You must not open door*).</li>
                </ul>
            </div>

            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
                <strong class="block text-emerald-900 font-bold mb-2 border-b pb-1 text-sm">Kepastian & Kemungkinan (Probability):</strong>
                <ul class="space-y-1.5 text-gray-700">
                    <li>• <strong>Will / Be going to:</strong> 100% Kepastian / Rencana pasti (*He will arrive at 6*).</li>
                    <li>• <strong>Should / Ought to:</strong> 90% Harapan (*She should do well on test*).</li>
                    <li>• <strong>Must:</strong> 95% Dugaan kuat (*Mary must be sick*).</li>
                    <li>• <strong>May / Might / Could:</strong> &lt;50% Kemungkinan (*It might rain*).</li>
                </ul>
            </div>

            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
                <strong class="block text-amber-900 font-bold mb-2 border-b pb-1 text-sm">Past Modals (Kemungkinan & Penyesalan Masa Lalu):</strong>
                <ul class="space-y-1.5 text-gray-700">
                    <li>• <strong>May / Might / Could + have + V3:</strong> Kemungkinan di masa lalu (*He might have been at library*).</li>
                    <li>• <strong>Should / Ought to + have + V3:</strong> Seharusnya terjadi di masa lalu tapi tidak dilakukan (*I should have studied*).</li>
                    <li>• <strong>Must + have + V3:</strong> Dugaan kuat di masa lalu (*She must have been sick yesterday*).</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman Modals:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Setelah <strong>Pure Modal (can, could, may, might, must, should, will, would, shall)</strong>, kata kerja berikutnya <u>WAJIB</u> berbentuk Kata Kerja Dasar / Verb 1 (tanpa 's', 'ed', 'ing', atau 'to').</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
             Aturan Emas Modal Verbs:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Jangan pernah gunakan dua Pure Modal bersamaan (<s>will can</s> $\rightarrow$ <strong>will be able to</strong>).</li>
            <li class="leading-relaxed">Untuk menyatakan keharusan di masa lalu, gunakan <strong>had to</strong> (bukan musted).</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: I will be able to help (bukan I will can help).</em>
    </div>
    
HTML
],
            16 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Pola Gerund (V-ing sebagai Noun)
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Fungsi</th><th class="p-3.5 font-semibold border-b border-gray-700">Pola Kalimat</th><th class="p-3.5 font-semibold border-b border-gray-700">Penjelasan</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Sebagai Subjek</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">Gerund (V-ing) + Verb...</td><td class="p-3.5 text-gray-800">V-ing sebagai subjek</td><td class="p-3.5 italic text-gray-600">Learning a foreign language requires patience.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Setelah Verb Khusus</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + Verb + Gerund</td><td class="p-3.5 text-gray-800">Diikuti V-ing</td><td class="p-3.5 italic text-gray-600">She enjoys reading storybooks.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Setelah Preposisi</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">Preposisi + V-ing</td><td class="p-3.5 text-gray-800">Setelah kata depan</td><td class="p-3.5 italic text-gray-600">Thank you for helping me.</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Verb yang diikuti Gerund: <em>enjoy, finish, avoid, consider, suggest, mind, deny, keep, recommend</em>.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Gerund sebagai subjek dianggap kata benda tunggal (Gunakan be 'is' / Verb+s).</li><li class="leading-relaxed"><em>Reading books <u>is</u> a good habit.</em></li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Bedakan Gerund (Noun) vs Present Continuous (Verb).</em>
    </div>
    
HTML
],
            17 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            <span class="bg-blue-600 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold shadow-xs">📌</span>
            1. Pola Ditransitive & Complex Ditransitive Verbs
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm min-w-[750px]">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700 w-1/4">Kategori Pola</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700 min-w-[280px]">Formula Gramatikal</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700">Penjelasan & Pola Alternatif</th>
                            <th class="p-3.5 font-semibold border-b border-gray-700 min-w-[200px]">Contoh Kalimat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Ditransitive (Pola 1 - Tanpa Preposisi)</td>
                            <td class="p-3.5 font-semibold text-blue-700 font-mono text-xs whitespace-nowrap">S + V + Indirect Object (Orang) + Direct Object (Benda)</td>
                            <td class="p-3.5 text-gray-800">Penerima di depan, benda di belakang</td>
                            <td class="p-3.5 italic text-gray-600">Father <u>gave me a new bike</u> on my birthday.</td>
                        </tr>
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Ditransitive (Pola 2 - Preposisi TO/FOR)</td>
                            <td class="p-3.5 font-semibold text-blue-700 font-mono text-xs whitespace-nowrap">S + V + Direct Object (Benda) + to / for + Indirect Object (Orang)</td>
                            <td class="p-3.5 text-gray-800">Benda di depan: gunakan <strong>to</strong> (memberikan) / <strong>for</strong> (membelikan/membuatkan)</td>
                            <td class="p-3.5 italic text-gray-600">Mother <u>bought a beautiful red dress for my sister</u>.</td>
                        </tr>
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Causative Verb (Bare Inf)</td>
                            <td class="p-3.5 font-semibold text-blue-700 font-mono text-xs whitespace-nowrap">S + Make / Let / Have + Objek + V1 (tanpa 'to')</td>
                            <td class="p-3.5 text-gray-800">Menyuruh / membiarkan aksi berlangsung</td>
                            <td class="p-3.5 italic text-gray-600">Mother <u>made my brother clean</u> his room.</td>
                        </tr>
                        <tr class="bg-white hover:bg-white transition-colors">
                            <td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Perception Verb (Bare Inf / V-ing)</td>
                            <td class="p-3.5 font-semibold text-blue-700 font-mono text-xs whitespace-nowrap">S + See / Hear / Watch / Notice + Objek + V1 / V-ing</td>
                            <td class="p-3.5 text-gray-800">Aksi utuh (V1) vs Aksi sedang berlangsung (V-ing)</td>
                            <td class="p-3.5 italic text-gray-600">I <u>saw him cross</u> (crossing) the street.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2 mt-6">
            <span class="bg-blue-600 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold shadow-xs">📌</span>
            2. Daftar Lengkap Kosa Kata (List of Verbs) Ditransitive & Complex Ditransitive
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 text-xs sm:text-sm">
            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
                <strong class="block text-blue-900 font-bold mb-2 border-b pb-1 text-sm flex items-center justify-between">
                    <span>1) Ditransitive + Preposisi 'TO' (Memberikan / Menyampaikan):</span>
                </strong>
                <p class="text-gray-700 leading-relaxed font-mono text-[11px] sm:text-xs">
                    give, send, show, teach, tell, offer, pay, pass, read, write, lend, hand, bring, promise, grant, award, mail, throw, wish.
                </p>
                <em class="block mt-2 text-[11px] text-gray-500 italic">Format: give sb sth | give sth TO sb (She sent her friend a gift / sent a gift TO her friend).</em>
            </div>

            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
                <strong class="block text-emerald-900 font-bold mb-2 border-b pb-1 text-sm flex items-center justify-between">
                    <span>2) Ditransitive + Preposisi 'FOR' (Membuatkan / Membelikan / Memasak):</span>
                </strong>
                <p class="text-gray-700 leading-relaxed font-mono text-[11px] sm:text-xs">
                    buy, make, cook, build, find, get, order, reserve, prepare, fetch, save, choose, bake, leave, hire.
                </p>
                <em class="block mt-2 text-[11px] text-gray-500 italic">Format: buy sb sth | buy sth FOR sb (Mother bought my sister a dress / bought a dress FOR my sister).</em>
            </div>

            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
                <strong class="block text-purple-900 font-bold mb-2 border-b pb-1 text-sm flex items-center justify-between">
                    <span>3) Causative & Perception Verbs (Bare Inf V1 / V-ing):</span>
                </strong>
                <ul class="space-y-1 text-gray-700 text-[11px] sm:text-xs font-mono">
                    <li>• <strong>Causative (V1 tanpa 'to'):</strong> make, let, have, help</li>
                    <li>• <strong>Perception (V1 / V-ing):</strong> see, hear, watch, notice, observe, feel, smell, listen to</li>
                </ul>
                <em class="block mt-2 text-[11px] text-gray-500 italic">Contoh: Let piston move forward (bukan to move). | I heard her sing (singing).</em>
            </div>

            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-xs">
                <strong class="block text-amber-900 font-bold mb-2 border-b pb-1 text-sm flex items-center justify-between">
                    <span>4) Complex Transitive (Objek + To-Inf / Noun / Adj):</span>
                </strong>
                <ul class="space-y-1 text-gray-700 text-[11px] sm:text-xs font-mono">
                    <li>• <strong>Object + To-Inf:</strong> allow, permit, ask, tell, advise, require, encourage, force, invite, order, persuade, remind, warn, expect, enable</li>
                    <li>• <strong>Object + Noun / Adj:</strong> call, name, elect, appoint, consider, declare, find, make, keep</li>
                </ul>
                <em class="block mt-2 text-[11px] text-gray-500 italic">Contoh: The teacher allowed us to leave early. / They elected him president.</em>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-50/80 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            💡 Tips & Panduan Pemahaman Ditransitive:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Jika objek penerima (orang) mendahului objek benda, <u>JANGAN</u> gunakan preposisi (<em>Father gave me a bike</em>).</li>
            <li class="leading-relaxed">Jika objek benda mendahului objek penerima, gunakan preposisi <strong>to</strong> (memberikan/mengirimkan) atau <strong>for</strong> (membeli/membuatkan/memasak).</li>
        </ul>
    </div>
    
    <div class="bg-amber-50/90 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            ⚠️ Aturan Emas Causative vs Object + To-Inf:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Setelah <strong>make / let / have + Objek</strong>, kata kerja <u>WAJIB</u> berbentuk <strong>V1 tanpa 'to' (Bare Infinitive)</strong> (<s>let me to go</s> → <strong>let me go</strong>).</li>
            <li class="leading-relaxed">Kata kerja perintah lain seperti <em>allow, permit, ask, tell, require, encourage</em> tetap wajib menggunakan <strong>To Infinitive</strong> (<em>allow me <u>to go</u></em>).</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Bedakan make/let/have (V1 tanpa to) vs allow/permit/ask (To + V1).</em>
    </div>
    
HTML
],
            18 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Review Komprehensif Seluruh Struktur Dasar (Part 1)
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Topik</th><th class="p-3.5 font-semibold border-b border-gray-700">Formula Kunci</th><th class="p-3.5 font-semibold border-b border-gray-700">Poin Penting</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Tenses & Aspect</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + Predikat (Present/Past/Continuous/Perfect)</td><td class="p-3.5 text-gray-800">Kesesuaian Tense & Penanda Waktu</td><td class="p-3.5 italic text-gray-600">Every day people work to achieve goals.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Modals & Infinitives</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">Modal + V1 | To + V1 | Gerund (V-ing)</td><td class="p-3.5 text-gray-800">Aturan V1 setelah modal/to</td><td class="p-3.5 italic text-gray-600">Learning requires regular practice.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Causative & Object</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + Causative + O + V1</td><td class="p-3.5 text-gray-800">Tanpa 'to' setelah make/let/have</td><td class="p-3.5 italic text-gray-600">Mother bought my sibling a new book.</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Periksa kelengkapan Subjek + Predikat pada setiap kalimat.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Hindari kesalahan bentuk kata kerja dan kesesuaian subjek-verb.</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Membaca ulang kalimat membantu menemukan kesalahan ketik.</em>
    </div>
    
HTML
],
            19 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Panduan Strategi Ujian Komprehensif Grammar
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Langkah</th><th class="p-3.5 font-semibold border-b border-gray-700">Tindakan Pemeriksaan</th><th class="p-3.5 font-semibold border-b border-gray-700">Fokus Cek Tata Bahasa</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Aplikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">1. Identifikasi Subjek</td><td class="p-3.5 text-gray-800">Tentukan pelaku & jumlah</td><td class="p-3.5 text-gray-800">Singular / Plural</td><td class="p-3.5 italic text-gray-600">Children (Plural) → go (V1)</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">2. Tentukan Tense</td><td class="p-3.5 text-gray-800">Cari keterangan waktu</td><td class="p-3.5 text-gray-800">Present / Past / Future</td><td class="p-3.5 italic text-gray-600">yesterday → bought (V2)</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">3. Cek Predikat</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">Verbal / Nominal / Pasif</td><td class="p-3.5 text-gray-800">To Be / Verb 3</td><td class="p-3.5 italic text-gray-600">Environment is maintained (Pasif)</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Kerjakan soal dengan cermat dan teliti.</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Gunakan waktu secara efisien dan periksa ejaan kata.</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Kunci sukses ujian adalah ketelitian pada perubahan bentuk kata kerja.</em>
    </div>
    
HTML
],
            20 => ['__html__' => <<<'HTML'

    <div class="mb-6">
        <h5 class="text-base font-bold text-gray-800 mb-3 flex items-center gap-2">
            Ringkasan Akhir Introductory Grammar for Writing
        </h5>
        <div class="overflow-hidden rounded-xl border border-gray-200 shadow-xs mb-4">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse bg-white text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-gray-800 text-white text-xs uppercase tracking-wider">
                            <th class="p-3.5 font-semibold border-b border-gray-700">Kategori</th><th class="p-3.5 font-semibold border-b border-gray-700">Pola Utama</th><th class="p-3.5 font-semibold border-b border-gray-700">Aplikasi Penulisan</th><th class="p-3.5 font-semibold border-b border-gray-700">Contoh Kalimat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        <tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Basic Tenses</td><td class="p-3.5 text-gray-800">Present, Past, Continuous, Perfect</td><td class="p-3.5 text-gray-800">Menyatakan waktu & aspek</td><td class="p-3.5 italic text-gray-600">Every day many people study foreign languages.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Modals & Verbs</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">Modal + V1, To + V1, Gerund</td><td class="p-3.5 text-gray-800">Menyatakan niat, saran, & keharusan</td><td class="p-3.5 italic text-gray-600">Maintaining cleanliness is important for health.</td></tr>
<tr class="bg-white hover:bg-white transition-colors"><td class="p-3.5 font-bold text-gray-900 whitespace-nowrap">Passive & Causative</td><td class="p-3.5 font-semibold text-blue-700 font-mono text-xs sm:text-sm">S + Be + V3 | S + Make/Let + O + V1</td><td class="p-3.5 text-gray-800">Fokus pada objek & aksi terarah</td><td class="p-3.5 italic text-gray-600">Storybooks were bought by mother yesterday.</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-100 border border-blue-200/80 text-blue-950 p-4 sm:p-5 rounded-xl mb-5 shadow-xs" style="background-color: #dbeafe !important;">
        <strong class="block mb-2 text-sm font-bold text-blue-900 flex items-center gap-2">
            Tips & Panduan Pemahaman:
        </strong>
        <ul class="list-disc list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-blue-900">
            <li class="leading-relaxed">Selamat! Anda telah menguasai seluruh landasan tata bahasa dasar (A1-B1 Introductory Grammar).</li>
        </ul>
    </div>
    
    <div class="bg-amber-100 border border-amber-200 text-amber-950 p-4 sm:p-5 rounded-xl mb-6 shadow-xs" style="background-color: #fef3c7 !important;">
        <strong class="block mb-2 text-sm font-bold text-amber-900 flex items-center gap-2">
            Aturan & Formula Penting:
        </strong>
        <ol class="list-decimal list-inside space-y-1.5 ml-1 text-xs sm:text-sm text-amber-950">
            <li class="leading-relaxed">Terapkan struktur ini secara konsisten dalam penulisan harian.</li>
        </ol>
        <em class="block mt-2.5 text-xs text-amber-900 font-medium border-t border-amber-200/60 pt-2">Catatan Kunci: Lanjutkan ke tingkat Complexity untuk menguasai klausa kompleks!</em>
    </div>
    
HTML
],
            default => null,
        };
    }

    private function introductoryMeetingQuestions(int $meeting): array
    {
        return match ($meeting) {
            1 => [
                'Saya bangun jam 6 pagi setiap hari.',
                'Ayah saya bekerja di kantor setiap hari Senin sampai Jumat.',
                'Matahari terbit di timur dan tenggelam di barat.',
                'Kucing saya suka minum susu segar.',
                'Mereka tinggal di sebuah rumah yang besar dan indah.',
                'Adik perempuan saya belajar bahasa Inggris setiap malam.',
                'Kami selalu makan malam bersama jam 7 malam.',
                'Dia (perempuan) memasak makanan lezat untuk keluarga kami.',
                'Air membeku pada suhu nol derajat Celsius.',
                'Siswa-siswa pergi ke sekolah naik bus setiap pagi.',
                'Toko roti ini buka jam 8 pagi setiap hari.',
                'Dia (laki-laki) berbicara bahasa Inggris dengan sangat lancar.',
                'Kami membaca buku di perpustakaan setiap hari Sabtu.',
                'Ibu saya membeli sayuran segar di pasar tradisional.',
                'Burung-burung bernyanyi di atas pohon setiap pagi.',
            ],
            2 => [
                'Surat ini dikirim oleh sekretaris setiap pagi.',
                'Mobil itu dicuci oleh ayah saya setiap hari Minggu.',
                'Kamar tidur ini dibersihkan oleh ibu setiap hari.',
                'Sampah dibuang ke tempat sampah setiap sore.',
                'Kopi hangat disajikan di kafe ini setiap hari.',
                'Bunga-bunga disiram oleh tukang kebun setiap pagi.',
                'Pintu toko dikunci oleh pemiliknya jam 9 malam.',
                'Buku-buku disusun rapi di rak perpustakaan.',
                'Roti tawar dipanggang oleh koki setiap pagi.',
                'Makanan ini disiapkan untuk para tamu undangan.',
                'Pakaian kotor dicuci menggunakan mesin cuci.',
                'Bahasa Inggris digunakan di banyak negara di dunia.',
                'Lampu kamar dimatikan sebelum tidur.',
                'Laporan harian ditulis oleh staf administrasi.',
                'Paket ini diantar oleh kurir ke rumah kami.',
            ],
            3 => [
                'Dia (perempuan) adalah seorang guru yang ramah dan baik hati.',
                'Kami adalah siswa di sekolah menengah pertama.',
                'Ayah saya adalah seorang dokter di rumah sakit kota.',
                'Hari ini cuaca sangat cerah dan hangat.',
                'Mereka sangat bahagia setelah mendengar berita baik itu.',
                'Buku ini sangat menarik dan bermanfaat bagi pembaca.',
                'Kucing itu sangat lucu dan penurut.',
                'Rumah baru kami bersih, nyaman, dan luas.',
                'Dia (laki-laki) adalah penyanyi terkenal di negara kami.',
                'Kota ini sangat indah dan tenang di malam hari.',
                'Makanan ini sangat lezat dan sehat untuk tubuh.',
                'Saya bangga menjadi bagian dari tim ini.',
                'Perpustakaan sekolah kami sangat bersih dan rapi.',
                'Kopi ini sangat panas, harap berhati-hati.',
                'Sepatu baru ini sangat ringan dan nyaman dipakai.',
            ],
            4 => [
                'Dia (perempuan) adalah seorang dokter dan dia bekerja di rumah sakit.',
                'Kami adalah siswa yang rajin dan kami belajar setiap hari.',
                'Rumah ini sangat besar, tetapi memiliki dua kamar saja.',
                'Ayah saya sangat sibuk karena dia mengelola toko roti.',
                'Kucing itu sangat lapar dan ia makan ikan segar.',
                'Taman ini indah dan banyak orang berkunjung setiap sore.',
                'Buku ini sangat bagus dan menyajikan banyak cerita menarik.',
                'Dia (laki-laki) adalah pemain sepak bola dan dia berlatih setiap pagi.',
                'Makanan di restoran ini lezat dan harganya sangat murah.',
                'Saya adalah seorang mahasiswa dan saya pergi ke kampus naik bus.',
                'Kota ini sangat ramai dan memiliki banyak pusat perbelanjaan.',
                'Ibu saya ramah dan semua tetangga menyukai beliau.',
                'Komputer ini baru dan berjalan dengan sangat cepat.',
                'Gedung ini sangat tinggi dan mempunyai dua puluh lantai.',
                'Mereka adalah teman baik dan selalu saling membantu.',
            ],
            5 => [
                'Saya ingin membeli buku baru di toko buku.',
                'Dia (perempuan) belajar giat untuk lulus ujian esok hari.',
                'Kami berencana untuk berlibur ke Bali bulan depan.',
                'Dia (laki-laki) berjanji untuk datang tepat waktu esok pagi.',
                'Adik saya memutuskan untuk melanjutkan kuliah di kota ini.',
                'Sangat penting untuk minum cukup air setiap hari.',
                'Mereka berharap untuk memenangkan pertandingan sepak bola esok.',
                'Ibu saya pergi ke pasar untuk membeli buah-buahan segar.',
                'Dia (laki-laki) menolak untuk menjual mobil lamanya.',
                'Kami berada di sini untuk membantu kamu menyelesaikan tugas.',
                'Sangat mudah untuk membuat kue pisang lezat ini.',
                'Dia (perempuan) mencoba untuk memperbaiki sepeda adiknya.',
                'Manager kami setuju untuk mengadakan rapat jam 10 pagi.',
                'Anak-anak suka berjalan-jalan di taman setiap sore.',
                'Tidak mudah untuk belajar bahasa asing dengan cepat.',
            ],
            6 => [
                'Saya mengunjungi nenek saya di desa minggu lalu.',
                'Dia (laki-laki) membeli mobil baru dua hari yang lalu.',
                'Kami menonton film yang sangat seru di bioskop kemarin malam.',
                'Ibu saya memasak sup ayam yang lezat tadi pagi.',
                'Mereka bermain sepak bola di lapangan kemarin sore.',
                'Dia (perempuan) menulis surat untuk temannya kemarin.',
                'Hujan deras turun sepanjang malam kemarin.',
                'Ayah saya mengendarai mobil ke kantor tadi pagi.',
                'Kami menyelesaikan tugas kelompok kami dua jam yang lalu.',
                'Dia (laki-laki) kehilangan dompetnya di pasar kemarin.',
                'Siswa-siswa mempelajari bab baru pada pelajaran kemarin.',
                'Toko itu tutup jam 8 malam kemarin.',
                'Dia (perempuan) memberi saya hadiah ulang tahun minggu lalu.',
                'Kami bangun pagi jam 5 tadi pagi.',
                'Mereka tiba di stasiun kereta tepat waktu kemarin.',
            ],
            7 => [
                'Rumah tua ini dibangun oleh kakek saya pada tahun 1990.',
                'Sepeda saya diperbaiki oleh paman kemarin sore.',
                'Kue ulang tahun ini dibuat oleh ibu saya tadi pagi.',
                'Kemarin cuaca sangat dingin dan berangin.',
                'Mereka sangat lelah setelah berjalan jauh kemarin.',
                'Surat ini dikirim oleh sekretaris minggu lalu.',
                'Laporan tahunan itu diselesaikan oleh tim kemarin.',
                'Dia (laki-laki) adalah seorang siswa yang pintar saat masih kecil.',
                'Gedung sekolah ini didirikan sepuluh tahun yang lalu.',
                'Kami sangat senang dapat menghadiri acara itu kemarin.',
                'Kunci rumah saya ditemukan di bawah meja tadi pagi.',
                'Dia (perempuan) adalah teman sekelas saya saat di SD.',
                'Buku cerita ini ditulis oleh penulis terkenal tahun lalu.',
                'Pintu gerbang dikunci oleh penjaga jam 10 malam kemarin.',
                'Ujian kemarin sangat sulit bagi para siswa.',
            ],
            8 => [
                'Saya tidak minum kopi setiap pagi.',
                'Dia (laki-laki) tidak pergi ke kantor naik bus kemarin.',
                'Kami tidak menonton televisi tadi malam.',
                'Dia (perempuan) tidak menyukai makanan pedas.',
                'Mereka tidak datang ke pesta ulang tahun saya kemarin.',
                'Adik saya tidak bermain game komputer setiap hari.',
                'Ayah saya tidak membeli mobil baru bulan lalu.',
                'Kami tidak menemukan kunci yang hilang itu kemarin.',
                'Dia (laki-laki) tidak mengerjakan tugas rumahnya tadi malam.',
                'Toko roti ini tidak buka pada hari Minggu.',
                'Siswa-siswa tidak memahami penjelasan guru kemarin.',
                'Dia (perempuan) tidak menelepon saya tadi pagi.',
                'Kami tidak tinggal di kota besar ini lima tahun lalu.',
                'Kucing itu tidak makan ikan asin.',
                'Mereka tidak menyelesaikan proyek itu tepat waktu minggu lalu.',
            ],
            9 => [
                'Saya tinggal di Jakarta sekarang, tetapi saya tinggal di Bandung tahun lalu.',
                'Dia (perempuan) memasak kue setiap minggu dan dia membuat kue lezat kemarin.',
                'Apakah kamu belajar bahasa Inggris setiap hari?',
                'Apakah mereka mengunjungi museum kemarin sore?',
                'Ayah saya biasanya naik kereta, tetapi dia mengendarai mobil kemarin.',
                'Kami tidak suka cuaca dingin hari ini.',
                'Apakah dia (laki-laki) membeli buku baru di toko kemarin?',
                'Mengapa kamu datang terlambat ke sekolah pagi ini?',
                'Toko ini buka jam 8 pagi setiap hari, tetapi kemarin buka jam 9 pagi.',
                'Apakah ibu kamu memasak sarapan tadi pagi?',
                'Dia (perempuan) sangat rajin dan dia membaca tiga buku minggu lalu.',
                'Kami menonton film seru kemarin malam dan kami sangat menyukainya.',
                'Di mana kamu tinggal saat kamu masih kecil?',
                'Dia (laki-laki) tidak bekerja hari ini karena dia sakit.',
                'Kapan mereka menyelesaikan tugas rumah mereka kemarin?',
            ],
            10 => [
                'Dia (perempuan) memberikan bukunya kepada saya kemarin.',
                'Kami mengundang mereka ke rumah kami minggu lalu.',
                'Ini adalah tas saya dan tas itu adalah milik kamu.',
                'Dia (laki-laki) menelepon dia (perempuan) tadi malam.',
                'Mobil ini adalah milik mereka dan mobil itu adalah milik kami.',
                'Ibu saya memasak makanan lezat untuk kami setiap hari.',
                'Apakah ini pensil kamu atau pensil dia (laki-laki)?',
                'Mereka membantu saya menyelesaikan tugas saya kemarin.',
                'Kucing ini lucu dan bulunya sangat lembut.',
                'Dia (perempuan) kehilangan dompetnya dan kami membantunya mencarinya.',
                'Rumah ini adalah milik dia (laki-laki), bukan milik saya.',
                'Saya membawa buku kamu dan kamu membawa buku saya.',
                'Guru kami memberi kami banyak nasehat baik.',
                'Sepatu ini sangat nyaman dan saya sangat menyukainya.',
                'Dia (laki-laki) meminjam sepeda saya dan dia mengembalikannya kemarin.',
            ],
            11 => [
                'Dia (laki-laki) membawa surat penting itu ke kantor kemarin.',
                'Kami menemukan kucing kecil di depan rumah kemarin sore.',
                'Mereka membangun rumah baru di kota ini tahun lalu.',
                'Saya membeli dua buku cerita di toko buku kemarin.',
                'Angin kencang bertiup di pantai semalam.',
                'Dia (perempuan) menulis surat untuk temannya dalam waktu sepuluh menit.',
                'Kami mengetahui jawaban dari pertanyaan itu setelah berdiskusi.',
                'Ayah saya memberi hadiah sepeda baru kepada adik saya kemarin.',
                'Dia (laki-laki) menangkap bola dengan sangat cepat kemarin.',
                'Dia (perempuan) minum dua gelas air segar setelah berlari.',
                'Dokter mengambil sampel darah pasien kemarin pagi.',
                'Tim kami membuat kue pisang lezat bulan lalu.',
                'Mereka datang dari kota lain untuk menghadiri acara kami.',
                'Gelas kaca itu jatuh dan pecah tadi pagi.',
                'Saya mendengar berita gembira itu dari ibu tadi sore.',
            ],
            12 => [
                'Saya sedang membaca buku pelajaran di kamar sekarang.',
                'Dia (perempuan) sedang memasak makan siang di dapur.',
                'Mereka sedang bermain bola basket di lapangan saat ini.',
                'Mobil itu sedang dicuci oleh paman saya di depan rumah.',
                'Kamar tidur sedang dibersihkan oleh ibu sekarang.',
                'Apakah kamu sedang mendengarkan musik sekarang?',
                'Dia (laki-laki) sedang tidak bekerja karena dia sedang berlibur.',
                'Adik saya sedang gembira karena dia mendapat hadiah baru.',
                'Roti tawar sedang dipanggang oleh koki di dapur.',
                'Anak-anak sedang belajar bahasa Inggris bersama guru mereka.',
                'Apakah rumah itu sedang dicat oleh para pekerja sekarang?',
                'Cuaca sedang sangat dingin dan hujan sedang turun di luar.',
                'Saya sedang menunggu bus di halte bus sekarang.',
                'Laporan harian sedang ditulis oleh staf di kantor.',
                'Mereka sedang menikmati makan malam bersama keluarga.',
            ],
            13 => [
                'Saya telah tinggal di kota ini selama lima tahun.',
                'Dia (perempuan) sudah menyelesaikan tugas rumahnya.',
                'Kami belum makan siang hari ini.',
                'Mereka telah mengunjungi Bali sebanyak dua kali.',
                'Ayah saya belum membeli mobil baru itu.',
                'Apakah kamu sudah membaca buku cerita ini?',
                'Dia (laki-laki) telah bekerja di perusahaan ini sejak tahun 2020.',
                'Kami belum pernah bertemu dengan penyanyi terkenal itu.',
                'Siswa-siswa telah mengumpulkan tugas kelompok mereka.',
                'Apakah dia (perempuan) sudah menelepon kamu hari ini?',
                'Saya belum pernah melihat pemandangan indah seperti ini sebelumnya.',
                'Hujan telah berhenti dan matahari mulai bersinar.',
                'Mereka belum membayar tagihan listrik bulan ini.',
                'Dia (laki-laki) telah kehilangan kuncinya sejak kemarin.',
                'Kami sudah menonton film menarik itu di bioskop.',
            ],
            14 => [
                'Saya belajar bahasa Inggris setiap hari, dan saya telah belajar selama dua tahun.',
                'Dia (perempuan) bekerja di bank ini sekarang, dan dia telah bekerja di sini sejak 2021.',
                'Apakah kamu pernah mengunjungi museum nasional di Jakarta?',
                'Kami sudah menyelesaikan proyek kami dan kami merasa sangat senang.',
                'Ayah saya mengendarai mobil setiap pagi, tetapi kemarin dia naik bus.',
                'Toko ini buka setiap hari, tetapi toko ini belum buka pagi ini.',
                'Apakah dia (laki-laki) sudah mengirim email itu kepada manajer?',
                'Mereka biasanya makan malam jam 7, tetapi mereka sudah makan malam jam 6 tadi.',
                'Kucing itu tidur di sofa sekarang karena ia sudah makan banyak.',
                'Saya belum menerima surat balasan dari teman saya.',
                'Dia (perempuan) sangat pintar dan dia telah memenangkan dua lomba menulis.',
                'Kami selalu membantu tetangga kami ketika mereka membutuhkan bantuan.',
                'Apakah mereka sudah membayar biaya pendaftaran ujian?',
                'Hujan turun sangat deras kemarin, tetapi hari ini cuaca sangat cerah.',
                'Dia (laki-laki) belum pernah mengendarai sepeda motor sebelumnya.',
            ],
            15 => [
                'Kamu harus mematuhi aturan lalu lintas saat mengemudi.',
                'Dia (perempuan) dapat berbicara tiga bahasa asing dengan lancar.',
                'Siswa sebaiknya membaca buku pelajaran sebelum ujian dimulai.',
                'Bolehkah saya meminjam pena kamu sebentar?',
                'Kamu tidak boleh membuang sampah di sini.',
                'Kami bisa menyelesaikan tugas ini tepat waktu jika kami bekerja bersama.',
                'Dia (laki-laki) harus membawa paspor saat pergi ke luar negeri.',
                'Kamu sebaiknya beristirahat jika kamu merasa lelah.',
                'Apakah saya boleh membuka jendela kamar ini?',
                'Anak-anak tidak boleh bermain di jalan raya yang ramai.',
                'Dia (perempuan) mungkin datang terlambat karena macet.',
                'Kita harus menjaga kebersihan lingkungan rumah kita.',
                'Kamu seharusnya tidak makan makanan yang terlalu pedas.',
                'Bisakah kamu membantu saya membawa tas berat ini?',
                'Setiap pengendara motor wajib menggunakan helm demi keselamatan.',
            ],
            16 => [
                'Membaca buku setiap hari dapat meningkatkan pengetahuan kita.',
                'Dia (perempuan) sangat suka memasak makanan lezat untuk keluarganya.',
                'Berenang di kolam renang adalah olahraga favorit saya.',
                'Kami menikmati mendengarkan musik santai di sore hari.',
                'Dia (laki-laki) berhenti merokok demi kesehatan tubuhnya.',
                'Belajar bahasa asing membutuhkan waktu dan kesabaran.',
                'Ibu saya menghindari makan makanan yang mengandung banyak gula.',
                'Berjalan-jalan di taman pagi hari sangat menyegarkan tubuh.',
                'Mereka selesai membersihkan kelas sepuluh menit yang lalu.',
                'Dia (perempuan) berlatih menari setiap hari Sabtu sore.',
                'Menulis buku cerita adalah hobi adik perempuan saya.',
                'Saya tidak keberatan menunggu kamu di depan perpustakaan.',
                'Mengendarai sepeda di daerah pegunungan sangat menyenangkan.',
                'Dia (laki-laki) menyarankan untuk memesan makanan secara online.',
                'Menjaga kebersihan tangan sangat penting sebelum makan.',
            ],
            17 => [
                'Ayah memberi saya sebuah sepeda baru pada hari ulang tahun saya.',
                'Dia (perempuan) mengirim temannya sebuah hadiah ulang tahun.',
                'Guru menunjukkan kami gambar peta dunia di depan kelas.',
                'Ibu membelikan adik saya sebuah gaun merah yang indah.',
                'Dia (laki-laki) meminjamkan saya buku cerita favoritnya.',
                'Saya menuliskan nenek saya sebuah surat ucapan selamat.',
                'Paman membawakan kami banyak buah-buahan segar dari desa.',
                'Klien itu membayar perusahaan kami biaya layanan tepat waktu.',
                'Dia (perempuan) mengajarkan anak-anak lagu bahasa Inggris yang mudah.',
                'Kawan saya membawakan saya secangkir teh hangat.',
                'Dia (laki-laki) menceritakan kami kisah petualangan yang sangat seru.',
                'Saya memesankan sepupu saya semangkuk bakso lezat.',
                'Mereka menawarkan tamu-tamu minuman dingin yang segar.',
                'Ibu memanggangkan kami roti cokelat yang manis.',
                'Dia (perempuan) menunjukkan saya cara membuat kue pisang.',
            ],
            18 => [
                'Saya bangun jam 6 pagi setiap hari dan membaca buku.',
                'Surat ini dikirim oleh sekretaris kemarin sore.',
                'Dia (perempuan) adalah seorang guru dan dia mengajar bahasa Inggris.',
                'Kami ingin membeli buah-buahan segar di pasar.',
                'Ayah saya membeli mobil baru minggu lalu.',
                'Dia (laki-laki) tidak pergi ke kantor kemarin karena dia sakit.',
                'Apakah kamu sudah menyelesaikan tugas rumah kamu?',
                'Kamu harus mematuhi aturan sekolah demi kebaikan bersama.',
                'Berenang di laut adalah kegiatan yang sangat menyenangkan.',
                'Ibu saya membelikan adik saya sebuah mainan baru.',
                'Mobil itu sedang dicuci oleh paman di depan rumah.',
                'Dia (perempuan) memberikan bukunya kepada saya tadi pagi.',
                'Kami telah tinggal di rumah ini selama sepuluh tahun.',
                'Dia (laki-laki) tidak minum kopi hangat setiap pagi.',
                'Sangat penting untuk menjaga kesehatan tubuh kita.',
            ],
            19 => [
                'Matahari terbit di timur setiap pagi.',
                'Buku ini ditulis oleh seorang penulis terkenal tahun lalu.',
                'Dia (perempuan) sangat ramah dan semua orang menyukainya.',
                'Kami berencana untuk berkunjung ke Bali bulan depan.',
                'Dia (laki-laki) membeli sepatu baru dua hari yang lalu.',
                'Saya tidak menonton film di bioskop kemarin malam.',
                'Apakah mereka sudah membayar biaya sekolah bulan ini?',
                'Kamu sebaiknya minum cukup air setiap hari.',
                'Membaca buku di perpustakaan adalah hobi favorit saya.',
                'Ayah memberikan saya sebuah jam tangan baru kemarin.',
                'Kamar tidur ini sedang dibersihkan oleh ibu sekarang.',
                'Ini adalah tas saya dan tas itu adalah milik kamu.',
                'Dia (laki-laki) telah bekerja di restoran ini selama tiga tahun.',
                'Mereka tidak tinggal di kota kecil ini lima tahun lalu.',
                'Belajar bahasa asing membutuhkan latihan secara teratur.',
            ],
            20 => [
                'Bumi mengelilingi matahari setiap tahun.',
                'Air adalah sumber kehidupan utama bagi semua manusia.',
                'Sampah plastik didaur ulang di pabrik modern.',
                'Para siswa berusaha untuk mendapat nilai yang bagus.',
                'Dia (laki-laki) menemukan kunci lamanya kemarin.',
                'Rumah baru itu dibangun oleh tukang bangunan bulan lalu.',
                'Saya tidak percaya pada cerita bohong itu.',
                'Mereka tidak menyelesaikan tugas itu tepat waktu kemarin.',
                'Buku cerita ini adalah miliknya, bukan milik kami.',
                'Dia (perempuan) menulis laporan harian tadi pagi.',
                'Kami sedang belajar bahasa Inggris bersama di kelas.',
                'Saya belum menyelesaikan membaca bab terakhir buku ini.',
                'Setiap orang wajib mematuhi aturan lalu lintas.',
                'Mengumpulkan sampah plastik di pantai sangat membantu lingkungan.',
                'Guru memberikan para siswa penjelasan yang sangat jelas.',
            ],
            default => [],
        };
    }

    private function resolveIntroductoryMeetingContent(int $meeting): array
    {
        $fallbackQuestions = $this->introductoryMeetingQuestions($meeting);
        $fallbackAnswerKeys = $this->introductoryMeetingAnswerKeys($meeting);
        $questionRecords = collect($this->introductoryMeetingQuestionRecords($meeting))->keyBy('question_number');

        $questions = [];
        $answerKeys = [];
        $editorData = [];

        foreach ($fallbackQuestions as $index => $fallbackQuestionText) {
            $questionNumber = $index + 1;
            $record = $questionRecords->get($questionNumber);

            $resolvedQuestionText = $record?->question_text ?? $fallbackQuestionText;
            $resolvedCorrectAnswer = (string) ($record?->correct_answer ?? ($fallbackAnswerKeys[$questionNumber] ?? ''));

            $questions[] = $resolvedQuestionText;
            $answerKeys[$questionNumber] = $resolvedCorrectAnswer;
            $editorData[$questionNumber] = [
                'db_id' => $record?->id,
                'question_text' => $resolvedQuestionText,
                'correct_answer' => $resolvedCorrectAnswer,
            ];
        }

        return [
            'questions' => $questions,
            'answerKeys' => $answerKeys,
            'editorData' => $editorData,
        ];
    }

    private function introductoryMeetingQuestionRecords(int $meeting): array
    {
        try {
            $query = GrammarQuestion::where('meeting_number', $meeting);
            if ($this->grammarQuestionsHasSectionColumn()) {
                $query->where('section', $this->introductoryMeetingSection($meeting));
            } else {
                $query->where('question_number', '!=', 999);
            }
            return $query->orderBy('question_number')->get()->all();
        } catch (\Throwable $e) {
            return [];
        }
    }

    private function introductoryMeetingSection(int $meeting): string
    {
        return 'introductory_' . $meeting;
    }

    private function introductoryMeetingQuestionHelpers(int $meeting): array
    {
        $presetHelpers = match ($meeting) {
            1 => [
                1 => [
                    'example' => ['id' => 'Bulan mengelilingi bumi setiap bulan.', 'en' => 'The moon orbits the earth every month.'],
                    'vocab' => [
                        'rotate' => ['id' => 'berputar', 'pos' => '(v)'],
                        'axis' => ['id' => 'poros', 'pos' => '(n)'],
                    ],
                ],
                2 => [
                    'example' => ['id' => 'Para dosen berdiskusi dengan rektor setiap minggu.', 'en' => 'The lecturers discuss with the rector every week.'],
                    'vocab' => [
                        'discuss' => ['id' => 'berdiskusi', 'pos' => '(v)'],
                        'final-year students' => ['id' => 'mahasiswa tingkat akhir', 'pos' => '(n)'],
                        'dean board' => ['id' => 'dewan dekanat', 'pos' => '(n)'],
                    ],
                ],
                3 => [
                    'example' => ['id' => 'Murid-murid membahas isu lingkungan di kelas.', 'en' => 'The students discuss environmental issues in class.'],
                    'vocab' => [
                        'discuss' => ['id' => 'berdiskusi / membahas', 'pos' => '(v)'],
                        'economic theory' => ['id' => 'teori ekonomi', 'pos' => '(n)'],
                        'classroom' => ['id' => 'ruang kelas', 'pos' => '(n)'],
                    ],
                ],
                4 => [
                    'example' => ['id' => 'Es mencair pada suhu nol derajat Celsius.', 'en' => 'Ice melts at zero degrees Celsius.'],
                    'vocab' => [
                        'boil' => ['id' => 'mendidih', 'pos' => '(v)'],
                        'degrees Celsius' => ['id' => 'derajat Celsius', 'pos' => '(n)'],
                    ],
                ],
                5 => [
                    'example' => ['id' => 'Setiap anak berhak memperoleh layanan kesehatan.', 'en' => 'Every child has the right to receive healthcare services.'],
                    'vocab' => [
                        'citizen' => ['id' => 'warga negara', 'pos' => '(n)'],
                        'proper education' => ['id' => 'pendidikan yang layak', 'pos' => '(n)'],
                    ],
                ],
                6 => [
                    'example' => ['id' => 'Program pelatihan ini bertujuan meningkatkan keterampilan kerja.', 'en' => 'This training program aims to improve job skills.'],
                    'vocab' => [
                        'aim' => ['id' => 'bertujuan', 'pos' => '(v)'],
                        'scholarship program' => ['id' => 'program beasiswa', 'pos' => '(n)'],
                    ],
                ],
                7 => [
                    'example' => ['id' => 'Para ilmuwan bekerja rutin di pusat riset nasional.', 'en' => 'The scientists work regularly at the national research center.'],
                    'vocab' => [
                        'work' => ['id' => 'bekerja', 'pos' => '(v)'],
                        'researchers' => ['id' => 'para peneliti', 'pos' => '(n)'],
                        'central laboratory' => ['id' => 'laboratorium pusat', 'pos' => '(n)'],
                    ],
                ],
                8 => [
                    'example' => ['id' => 'Kajian ini berfokus pada pengaruh media sosial.', 'en' => 'This study focuses on the influence of social media.'],
                    'vocab' => [
                        'focus on' => ['id' => 'berfokus pada', 'pos' => '(v)'],
                        'social impact' => ['id' => 'dampak sosial', 'pos' => '(n)'],
                    ],
                ],
                9 => [
                    'example' => ['id' => 'Warga desa berpartisipasi dalam program kebersihan sungai.', 'en' => 'Village residents participate in the river-cleaning program.'],
                    'vocab' => [
                        'participate in' => ['id' => 'berpartisipasi dalam', 'pos' => '(v)'],
                        'local community' => ['id' => 'masyarakat lokal', 'pos' => '(n)'],
                        'forest conservation' => ['id' => 'pelestarian hutan', 'pos' => '(n)'],
                    ],
                ],
                10 => [
                    'example' => ['id' => 'Data ekonomi ini berasal dari laporan tahunan pemerintah.', 'en' => 'This economic data comes from the government\'s annual report.'],
                    'vocab' => [
                        'come from' => ['id' => 'berasal dari', 'pos' => '(v)'],
                        'statistical data' => ['id' => 'data statistik', 'pos' => '(n)'],
                        'population survey' => ['id' => 'survei penduduk', 'pos' => '(n)'],
                    ],
                ],
                11 => [
                    'example' => ['id' => 'Kualitas air laut bergantung pada kebersihan pantai.', 'en' => 'Sea water quality depends on beach cleanliness.'],
                    'vocab' => [
                        'depend on' => ['id' => 'bergantung pada', 'pos' => '(v)'],
                        'upstream flows' => ['id' => 'aliran hulu', 'pos' => '(n)'],
                    ],
                ],
                12 => [
                    'example' => ['id' => 'Setiap siswa bertanggung jawab atas kebersihan kelas.', 'en' => 'Every student is responsible for classroom cleanliness.'],
                    'vocab' => [
                        'responsible for' => ['id' => 'bertanggung jawab atas', 'pos' => '(adj)'],
                        'environmental sustainability' => ['id' => 'kelestarian lingkungan', 'pos' => '(n)'],
                    ],
                ],
                13 => [
                    'example' => ['id' => 'Temuan terbaru berbeda dari prediksi sebelumnya.', 'en' => 'The latest findings differ from the previous prediction.'],
                    'vocab' => [
                        'differ from' => ['id' => 'berbeda dari', 'pos' => '(v)'],
                        'research results' => ['id' => 'hasil penelitian', 'pos' => '(n)'],
                        'initial hypothesis' => ['id' => 'hipotesis awal', 'pos' => '(n)'],
                    ],
                ],
                14 => [
                    'example' => ['id' => 'Kegiatan pelatihan berlangsung dari siang sampai malam.', 'en' => 'The training session runs from noon to evening.'],
                    'vocab' => [
                        'run / take place' => ['id' => 'berlangsung', 'pos' => '(v)'],
                        'teaching and learning process' => ['id' => 'proses belajar-mengajar', 'pos' => '(n)'],
                    ],
                ],
                15 => [
                    'example' => ['id' => 'Sebagian ikan bergerak ke perairan hangat saat cuaca dingin.', 'en' => 'Some fish move to warmer waters during cold weather.'],
                    'vocab' => [
                        'migrate' => ['id' => 'bermigrasi', 'pos' => '(v)'],
                        'south' => ['id' => 'ke arah selatan', 'pos' => '(adv)'],
                    ],
                ],
            ],
            2 => [
                1 => [
                    'example' => ['id' => 'Laporan keuangan dianalisis secara rinci di pusat data nasional.', 'en' => 'The financial report is analyzed in detail in the national data center.'],
                    'vocab' => [
                        'analyze' => ['id' => 'menganalisis', 'pos' => '(v)'],
                        'research data' => ['id' => 'data penelitian', 'pos' => '(n)'],
                        'central database' => ['id' => 'database pusat', 'pos' => '(n)'],
                    ],
                ],
                2 => [
                    'example' => ['id' => 'Teori baru diuji di bawah pengawasan ketat para peneliti.', 'en' => 'The new theory is tested under strict supervision by researchers.'],
                    'vocab' => [
                        'test' => ['id' => 'menguji', 'pos' => '(v)'],
                        'hypothesis' => ['id' => 'hipotesis', 'pos' => '(n)'],
                        'strict laboratory conditions' => ['id' => 'kondisi laboratorium yang ketat', 'pos' => '(n)'],
                    ],
                ],
                3 => [
                    'example' => ['id' => 'Peristiwa cuaca ini diklasifikasikan sebagai anomali musiman.', 'en' => 'This weather event is classified as a seasonal anomaly.'],
                    'vocab' => [
                        'classify' => ['id' => 'mengklasifikasikan', 'pos' => '(v)'],
                        'significant climate change' => ['id' => 'perubahan iklim signifikan', 'pos' => '(n)'],
                    ],
                ],
                4 => [
                    'example' => ['id' => 'Hutan lindung dikelola secara terpadu untuk menjaga keanekaragaman hayati.', 'en' => 'Protected forests are managed in an integrated way to preserve biodiversity.'],
                    'vocab' => [
                        'manage' => ['id' => 'mengelola', 'pos' => '(v)'],
                        'natural resources' => ['id' => 'sumber daya alam', 'pos' => '(n)'],
                        'sustainably' => ['id' => 'secara berkelanjutan', 'pos' => '(adv)'],
                    ],
                ],
                5 => [
                    'example' => ['id' => 'Konsep antropologi diterapkan dalam penelitian sosial kontemporer.', 'en' => 'Anthropological concepts are applied in contemporary social research.'],
                    'vocab' => [
                        'apply' => ['id' => 'menerapkan', 'pos' => '(v)'],
                        'sociological theories' => ['id' => 'teori-teori sosiologi', 'pos' => '(n)'],
                        'urban community case studies' => ['id' => 'studi kasus masyarakat perkotaan', 'pos' => '(n)'],
                    ],
                ],
                6 => [
                    'example' => ['id' => 'Manuskrip ilmiah ditinjau sebelum dipublikasikan secara resmi.', 'en' => 'Scientific manuscripts are reviewed before being officially published.'],
                    'vocab' => [
                        'review' => ['id' => 'meninjau', 'pos' => '(v)'],
                        'closed review system' => ['id' => 'sistem peninjauan tertutup', 'pos' => '(n)'],
                    ],
                ],
                7 => [
                    'example' => ['id' => 'Dokumen rahasia dilindungi oleh sistem enkripsi berlapis.', 'en' => 'Confidential documents are protected by a layered encryption system.'],
                    'vocab' => [
                        'protect' => ['id' => 'melindungi', 'pos' => '(v)'],
                        'sensitive information' => ['id' => 'informasi sensitif', 'pos' => '(n)'],
                        'encrypted servers' => ['id' => 'server terenkripsi', 'pos' => '(n)'],
                    ],
                ],
                8 => [
                    'example' => ['id' => 'Kinerja siswa dinilai berdasarkan indikator akademik yang jelas.', 'en' => 'Student performance is evaluated based on clear academic indicators.'],
                    'vocab' => [
                        'evaluate' => ['id' => 'menilai / mengevaluasi', 'pos' => '(v)'],
                        'student achievement' => ['id' => 'pencapaian mahasiswa', 'pos' => '(n)'],
                        'objective assessment criteria' => ['id' => 'kriteria penilaian yang objektif', 'pos' => '(n)'],
                    ],
                ],
                9 => [
                    'example' => ['id' => 'Bantuan logistik diberikan oleh organisasi internasional selama krisis.', 'en' => 'Logistical support is provided by international organizations during crises.'],
                    'vocab' => [
                        'provide' => ['id' => 'memberikan', 'pos' => '(v)'],
                        'major contributions' => ['id' => 'kontribusi besar', 'pos' => '(n)'],
                        'research institutions' => ['id' => 'lembaga penelitian', 'pos' => '(n)'],
                    ],
                ],
                10 => [
                    'example' => ['id' => 'Aturan keselamatan dipatuhi oleh operator di area kerja berisiko tinggi.', 'en' => 'Safety regulations are followed by operators in high-risk work areas.'],
                    'vocab' => [
                        'follow / obey' => ['id' => 'mematuhi', 'pos' => '(v)'],
                        'operational procedures' => ['id' => 'prosedur operasional', 'pos' => '(n)'],
                        'production line' => ['id' => 'lini produksi', 'pos' => '(n)'],
                    ],
                ],
                11 => [
                    'example' => ['id' => 'Peraturan baru disusun oleh komite akademik pusat.', 'en' => 'New regulations are formulated by the central academic committee.'],
                    'vocab' => [
                        'formulate' => ['id' => 'menyusun / merumuskan', 'pos' => '(v)'],
                        'academic policies' => ['id' => 'kebijakan akademik', 'pos' => '(n)'],
                        'university senate' => ['id' => 'senat universitas', 'pos' => '(n)'],
                    ],
                ],
                12 => [
                    'example' => ['id' => 'Sampel air diambil dari beberapa titik sungai untuk analisis kualitas.', 'en' => 'Water samples are taken from several river points for quality analysis.'],
                    'vocab' => [
                        'take' => ['id' => 'mengambil', 'pos' => '(v)'],
                        'soil samples' => ['id' => 'sampel tanah', 'pos' => '(n)'],
                        'mineral content' => ['id' => 'kandungan mineral', 'pos' => '(n)'],
                    ],
                ],
                13 => [
                    'example' => ['id' => 'Dana proyek dialokasikan secara terbuka untuk fasilitas penelitian modern.', 'en' => 'Project funds are allocated transparently for modern research facilities.'],
                    'vocab' => [
                        'allocate' => ['id' => 'mengalokasikan', 'pos' => '(v)'],
                        'annual budget' => ['id' => 'anggaran tahunan', 'pos' => '(n)'],
                        'faculty management' => ['id' => 'manajemen fakultas', 'pos' => '(n)'],
                    ],
                ],
                14 => [
                    'example' => ['id' => 'Model pembelajaran baru diperkenalkan dalam program lintas disiplin.', 'en' => 'A new learning model is introduced in an interdisciplinary program.'],
                    'vocab' => [
                        'introduce' => ['id' => 'memperkenalkan', 'pos' => '(v)'],
                        'new paradigm' => ['id' => 'paradigma baru', 'pos' => '(n)'],
                        'integrated science curriculum' => ['id' => 'kurikulum sains terpadu', 'pos' => '(n)'],
                    ],
                ],
                15 => [
                    'example' => ['id' => 'Kesimpulan akhir ditarik dari data lapangan yang konsisten.', 'en' => 'Final conclusions are drawn from consistent field data.'],
                    'vocab' => [
                        'draw' => ['id' => 'menarik (kesimpulan)', 'pos' => '(v)'],
                        'research conclusions' => ['id' => 'kesimpulan penelitian', 'pos' => '(n)'],
                        'empirical evidence' => ['id' => 'bukti empiris', 'pos' => '(n)'],
                    ],
                ],
            ],
            3 => [
                1 => ['vocab' => ['microplastic particles' => ['id' => 'partikel mikroplastik', 'pos' => '(n)'], 'harmful to' => ['id' => 'berbahaya bagi', 'pos' => '(adj)'], 'marine biota' => ['id' => 'biota laut', 'pos' => '(n)']]],
                2 => ['vocab' => ['energy conservation strategy' => ['id' => 'strategi konservasi energi', 'pos' => '(n)'], 'effective' => ['id' => 'efektif', 'pos' => '(adj)'], 'electricity consumption' => ['id' => 'konsumsi listrik', 'pos' => '(n)']]],
                3 => ['vocab' => ['ozone layer' => ['id' => 'lapisan ozon', 'pos' => '(n)'], 'vulnerable to' => ['id' => 'rentan terhadap', 'pos' => '(adj)'], 'chemical pollutants' => ['id' => 'polutan kimia', 'pos' => '(n)']]],
                4 => ['vocab' => ['disaster mitigation' => ['id' => 'mitigasi bencana', 'pos' => '(n)'], 'top priority' => ['id' => 'prioritas utama', 'pos' => '(n)'], 'spatial planning' => ['id' => 'perencanaan tata wilayah', 'pos' => '(n)']]],
                5 => ['vocab' => ['research data' => ['id' => 'data penelitian', 'pos' => '(n)'], 'accurate' => ['id' => 'akurat', 'pos' => '(adj)'], 'initial hypothesis' => ['id' => 'hipotesis awal', 'pos' => '(n)']]],
            ],
            4 => [
                1 => ['vocab' => ['manage' => ['id' => 'mengelola', 'pos' => '(v)'], 'industrial waste' => ['id' => 'limbah industri', 'pos' => '(n)'], 'river pollution' => ['id' => 'polusi sungai', 'pos' => '(n)']]],
                2 => ['vocab' => ['cybersecurity' => ['id' => 'keamanan siber', 'pos' => '(n)'], 'main priority' => ['id' => 'prioritas utama', 'pos' => '(n)'], 'tech companies' => ['id' => 'perusahaan teknologi', 'pos' => '(n)']]],
                3 => ['vocab' => ['allocate' => ['id' => 'mengalokasikan', 'pos' => '(v)'], 'central government' => ['id' => 'pemerintah pusat', 'pos' => '(n)'], 'protected forests' => ['id' => 'hutan lindung', 'pos' => '(n)']]],
                4 => ['vocab' => ['statistical data' => ['id' => 'data statistik', 'pos' => '(n)'], 'relevant to' => ['id' => 'relevan dengan', 'pos' => '(adj)'], 'field conditions' => ['id' => 'kondisi lapangan', 'pos' => '(n)']]],
                5 => ['vocab' => ['use' => ['id' => 'menggunakan', 'pos' => '(v)'], 'communication tool' => ['id' => 'alat komunikasi', 'pos' => '(n)'], 'global forum' => ['id' => 'forum global', 'pos' => '(n)']]],
                6 => ['vocab' => ['facilitate' => ['id' => 'mempermudah', 'pos' => '(v)'], 'long-distance communication' => ['id' => 'komunikasi jarak jauh', 'pos' => '(n)']]],
                7 => ['vocab' => ['quality education' => ['id' => 'pendidikan berkualitas', 'pos' => '(n)'], 'fundamental right' => ['id' => 'hak asasi', 'pos' => '(n)'], 'citizen' => ['id' => 'warga negara', 'pos' => '(n)']]],
                8 => ['vocab' => ['check / audit' => ['id' => 'memeriksa / mengaudit', 'pos' => '(v)'], 'annual report' => ['id' => 'laporan tahunan', 'pos' => '(n)'], 'board of directors' => ['id' => 'dewan direksi', 'pos' => '(n)']]],
                9 => ['vocab' => ['observe' => ['id' => 'mengamati', 'pos' => '(v)'], 'scientists' => ['id' => 'para ilmuwan', 'pos' => '(n)'], 'climate change' => ['id' => 'perubahan iklim', 'pos' => '(n)']]],
                10 => ['vocab' => ['optimistic about' => ['id' => 'optimis mengenai', 'pos' => '(adj)'], 'international collaboration' => ['id' => 'kolaborasi internasional', 'pos' => '(n)']]],
                11 => ['vocab' => ['implement' => ['id' => 'menerapkan', 'pos' => '(v)'], 'new rules' => ['id' => 'aturan baru', 'pos' => '(n)'], 'simultaneously' => ['id' => 'secara serentak', 'pos' => '(adv)']]],
                12 => ['vocab' => ['contribute' => ['id' => 'berkontribusi / menyumbang', 'pos' => '(v)'], 'tourism sector' => ['id' => 'sektor pariwisata', 'pos' => '(n)'], 'regional revenue' => ['id' => 'pendapatan daerah', 'pos' => '(n)']]],
                13 => ['vocab' => ['predict' => ['id' => 'memprediksi', 'pos' => '(v)'], 'research methodology' => ['id' => 'metodologi penelitian', 'pos' => '(n)'], 'accurate' => ['id' => 'akurat', 'pos' => '(adj)']]],
                14 => ['vocab' => ['produce' => ['id' => 'memproduksi', 'pos' => '(v)'], 'various medicines' => ['id' => 'berbagai obat-obatan', 'pos' => '(n)'], 'national laboratory' => ['id' => 'laboratorium nasional', 'pos' => '(n)']]],
                15 => ['vocab' => ['emit' => ['id' => 'memancarkan', 'pos' => '(v)'], 'affect' => ['id' => 'memengaruhi', 'pos' => '(v)'], 'ultraviolet radiation' => ['id' => 'radiasi ultraviolet', 'pos' => '(n)']]],
                16 => ['vocab' => ['economic stability' => ['id' => 'stabilitas ekonomi', 'pos' => '(n)'], 'crucial for' => ['id' => 'krusial untuk', 'pos' => '(adj)'], 'long-term growth' => ['id' => 'pertumbuhan jangka panjang', 'pos' => '(n)']]],
                17 => ['vocab' => ['make / take' => ['id' => 'membuat / mengambil', 'pos' => '(v)'], 'strategic decision' => ['id' => 'keputusan strategis', 'pos' => '(n)'], 'in-depth analysis' => ['id' => 'analisis data mendalam', 'pos' => '(n)']]],
                18 => ['vocab' => ['apply / implement' => ['id' => 'menerapkan', 'pos' => '(v)'], 'strict work ethics' => ['id' => 'standar etika kerja ketat', 'pos' => '(n)']]],
                19 => ['vocab' => ['admire' => ['id' => 'mengagumi', 'pos' => '(v)'], 'cultural diversity' => ['id' => 'keanekaragaman budaya', 'pos' => '(n)'], 'global community' => ['id' => 'masyarakat dunia', 'pos' => '(n)']]],
                20 => ['vocab' => ['process' => ['id' => 'memproses', 'pos' => '(v)'], 'advanced AI system' => ['id' => 'sistem AI canggih', 'pos' => '(n)'], 'in seconds' => ['id' => 'dalam hitungan detik', 'pos' => '(adv)']]],
            ],
            5 => [
                1 => ['vocab' => ['analyze' => ['id' => 'menganalisis', 'pos' => '(v)'], 'purpose' => ['id' => 'tujuan', 'pos' => '(n)'], 'urbanization impact' => ['id' => 'dampak urbanisasi', 'pos' => '(n)'], 'air quality' => ['id' => 'kualitas udara', 'pos' => '(n)']]],
                2 => ['vocab' => ['need' => ['id' => 'membutuhkan', 'pos' => '(v)'], 'validate' => ['id' => 'memvalidasi', 'pos' => '(v)'], 'additional data' => ['id' => 'data tambahan', 'pos' => '(n)'], 'hypothesis' => ['id' => 'hipotesis', 'pos' => '(n)']]],
                3 => ['vocab' => ['implement' => ['id' => 'mengimplementasikan', 'pos' => '(v)'], 'crucial' => ['id' => 'krusial', 'pos' => '(adj)'], 'sustainable policies' => ['id' => 'kebijakan berkelanjutan', 'pos' => '(n)']]],
                4 => ['vocab' => ['measure' => ['id' => 'mengukur', 'pos' => '(v)'], 'energy efficiency' => ['id' => 'efisiensi energi', 'pos' => '(n)'], 'manufacturing system' => ['id' => 'sistem manufaktur', 'pos' => '(n)']]],
                5 => ['vocab' => ['identify' => ['id' => 'mengidentifikasi', 'pos' => '(v)'], 'first person' => ['id' => 'orang pertama', 'pos' => '(n)'], 'link / correlation' => ['id' => 'kaitan', 'pos' => '(n)'], 'sleep patterns' => ['id' => 'pola tidur', 'pos' => '(n)']]],
                6 => ['vocab' => ['cite' => ['id' => 'mengutip', 'pos' => '(v)'], 'avoid' => ['id' => 'menghindari', 'pos' => '(v)'], 'original sources' => ['id' => 'sumber asli', 'pos' => '(n)'], 'plagiarism' => ['id' => 'plagiarisme', 'pos' => '(n)']]],
                7 => ['vocab' => ['reject' => ['id' => 'menolak', 'pos' => '(v)'], 'decide' => ['id' => 'memutuskan', 'pos' => '(v)'], 'ethics board' => ['id' => 'dewan etik', 'pos' => '(n)'], 'security risks' => ['id' => 'risiko keamanan', 'pos' => '(n)']]],
                8 => ['vocab' => ['integrate' => ['id' => 'mengintegrasikan', 'pos' => '(v)'], 'effective strategy' => ['id' => 'strategi efektif', 'pos' => '(n)'], 'AI technology' => ['id' => 'teknologi AI', 'pos' => '(n)'], 'curriculum' => ['id' => 'kurikulum', 'pos' => '(n)']]],
                9 => ['vocab' => ['evaluate' => ['id' => 'mengevaluasi', 'pos' => '(v)'], 'employee performance' => ['id' => 'kinerja karyawan', 'pos' => '(n)'], '360-degree assessment' => ['id' => 'penilaian 360 derajat', 'pos' => '(n)']]],
                10 => ['vocab' => ['use' => ['id' => 'menggunakan', 'pos' => '(v)'], 'chemical substance' => ['id' => 'bahan kimia', 'pos' => '(n)'], 'unstable' => ['id' => 'tidak stabil', 'pos' => '(adj)'], 'room temperature' => ['id' => 'suhu ruangan', 'pos' => '(n)']]],
                11 => ['vocab' => ['strive / attempt' => ['id' => 'berupaya', 'pos' => '(v)'], 'minimize' => ['id' => 'meminimalisir', 'pos' => '(v)'], 'bias' => ['id' => 'bias', 'pos' => '(n)'], 'sampling' => ['id' => 'pengambilan sampel', 'pos' => '(n)']]],
                12 => ['vocab' => ['ensure' => ['id' => 'memastikan', 'pos' => '(v)'], 'control variables' => ['id' => 'variabel kontrol', 'pos' => '(n)'], 'consistent results' => ['id' => 'hasil konsisten', 'pos' => '(n)']]],
                13 => ['vocab' => ['explain' => ['id' => 'menjelaskan', 'pos' => '(v)'], 'difficult' => ['id' => 'sulit', 'pos' => '(adj)'], 'advanced mathematical model' => ['id' => 'model matematika tingkat lanjut', 'pos' => '(n)']]],
                14 => ['vocab' => ['publish' => ['id' => 'mempublikasikan', 'pos' => '(v)'], 'plan' => ['id' => 'berencana', 'pos' => '(v)'], 'research team' => ['id' => 'tim riset', 'pos' => '(n)'], 'reputable journal' => ['id' => 'jurnal bereputasi', 'pos' => '(n)']]],
                15 => ['vocab' => ['facilitate' => ['id' => 'memfasilitasi', 'pos' => '(v)'], 'educational institution' => ['id' => 'institusi pendidikan', 'pos' => '(n)'], 'talent development' => ['id' => 'pengembangan bakat', 'pos' => '(n)']]],
            ],
            6 => [
                1 => ['vocab' => ['isolate' => ['id' => 'mengisolasi', 'pos' => '(v)'], 'chemical compound' => ['id' => 'senyawa kimia', 'pos' => '(n)'], 'plant extract' => ['id' => 'ekstrak tumbuhan', 'pos' => '(n)'], 'last month' => ['id' => 'bulan lalu', 'pos' => '(adv)']]],
                2 => ['vocab' => ['divide' => ['id' => 'membelah diri', 'pos' => '(v)'], 'final mitosis phase' => ['id' => 'fase mitosis terakhir', 'pos' => '(n)'], 'yesterday' => ['id' => 'kemarin', 'pos' => '(adv)']]],
                3 => ['vocab' => ['release' => ['id' => 'melepaskan', 'pos' => '(v)'], 'exothermic reaction' => ['id' => 'reaksi eksotermik', 'pos' => '(n)'], 'heat energy' => ['id' => 'energi panas', 'pos' => '(n)']]],
                4 => ['vocab' => ['refract' => ['id' => 'membiaskan', 'pos' => '(v)'], 'prism medium' => ['id' => 'medium prisma', 'pos' => '(n)'], 'last week' => ['id' => 'minggu lalu', 'pos' => '(adv)']]],
                5 => ['vocab' => ['absorb' => ['id' => 'menyerap', 'pos' => '(v)'], 'forest ecosystem' => ['id' => 'ekosistem hutan', 'pos' => '(n)'], 'carbon dioxide' => ['id' => 'karbon dioksida', 'pos' => '(n)']]],
                6 => ['vocab' => ['provide' => ['id' => 'memberikan', 'pos' => '(v)'], 'research subjects' => ['id' => 'subjek penelitian', 'pos' => '(n)'], 'valid quantitative data' => ['id' => 'data kuantitatif valid', 'pos' => '(n)']]],
                7 => ['vocab' => ['predict' => ['id' => 'memprediksi', 'pos' => '(v)'], 'simulation model' => ['id' => 'model simulasi', 'pos' => '(n)'], 'global temperature rise' => ['id' => 'peningkatan suhu global', 'pos' => '(n)']]],
                8 => ['vocab' => ['bind to' => ['id' => 'berikatan dengan', 'pos' => '(v)'], 'protein receptor' => ['id' => 'reseptor protein', 'pos' => '(n)'], 'incubation process' => ['id' => 'proses inkubasi', 'pos' => '(n)']]],
                9 => ['vocab' => ['discover' => ['id' => 'menemukan', 'pos' => '(v)'], 'geologists' => ['id' => 'para geolog', 'pos' => '(n)'], 'sedimentary rock' => ['id' => 'batuan sedimen', 'pos' => '(n)'], 'excavation site' => ['id' => 'situs penggalian', 'pos' => '(n)']]],
                10 => ['vocab' => ['integrate' => ['id' => 'mengintegrasikan', 'pos' => '(v)'], 'AI technology' => ['id' => 'teknologi AI', 'pos' => '(n)'], 'a year ago' => ['id' => 'setahun yang lalu', 'pos' => '(adv)']]],
                11 => ['vocab' => ['submit' => ['id' => 'mengirimkan / mengumpulkan', 'pos' => '(v)'], 'project proposal' => ['id' => 'proposal proyek', 'pos' => '(n)'], 'on time' => ['id' => 'tepat waktu', 'pos' => '(adv)']]],
                12 => ['vocab' => ['hold / organize' => ['id' => 'mengadakan', 'pos' => '(v)'], 'international seminar' => ['id' => 'seminar internasional', 'pos' => '(n)'], 'last year' => ['id' => 'tahun lalu', 'pos' => '(adv)']]],
                13 => ['vocab' => ['take medicine' => ['id' => 'meminum obat', 'pos' => '(v)'], 'prescribed dosage' => ['id' => 'dosis yang dianjurkan', 'pos' => '(n)'], 'last night' => ['id' => 'tadi malam', 'pos' => '(adv)']]],
                14 => ['vocab' => ['experience' => ['id' => 'mengalami', 'pos' => '(v)'], 'technical glitch' => ['id' => 'gangguan teknis', 'pos' => '(n)'], 'for two full hours' => ['id' => 'selama 2 jam penuh', 'pos' => '(adv)']]],
                15 => ['vocab' => ['win' => ['id' => 'memenangkan', 'pos' => '(v)'], 'lawyer' => ['id' => 'pengacara', 'pos' => '(n)'], 'case' => ['id' => 'kasus', 'pos' => '(n)'], 'long trial' => ['id' => 'persidangan panjang', 'pos' => '(n)']]],
                16 => ['vocab' => ['study' => ['id' => 'mempelajari', 'pos' => '(v)'], 'research methodology' => ['id' => 'metodologi penelitian', 'pos' => '(n)'], 'last weekend' => ['id' => 'akhir pekan lalu', 'pos' => '(adv)']]],
                17 => ['vocab' => ['rebrand' => ['id' => 'mengubah citra merek', 'pos' => '(v)'], 'completely' => ['id' => 'secara total', 'pos' => '(adv)'], 'previous year' => ['id' => 'tahun sebelumnya', 'pos' => '(n)']]],
                18 => ['vocab' => ['complete' => ['id' => 'menyelesaikan', 'pos' => '(v)'], 'contractor' => ['id' => 'kontraktor', 'pos' => '(n)'], 'bridge construction' => ['id' => 'pembangunan jembatan', 'pos' => '(n)'], 'ahead of schedule' => ['id' => 'sebelum jadwal', 'pos' => '(adv)']]],
                19 => ['vocab' => ['achieve' => ['id' => 'mencapai', 'pos' => '(v)'], 'target score' => ['id' => 'target skor', 'pos' => '(n)'], 'last month' => ['id' => 'bulan lalu', 'pos' => '(adv)']]],
                20 => ['vocab' => ['applaud / appreciate' => ['id' => 'mengapresiasi / tepuk tangan', 'pos' => '(v)'], 'audience' => ['id' => 'para penonton', 'pos' => '(n)'], 'presentation' => ['id' => 'presentasi', 'pos' => '(n)']]],
            ],
            7 => [
                1 => ['vocab' => ['audit report' => ['id' => 'laporan audit', 'pos' => '(n)'], 'available' => ['id' => 'tersedia', 'pos' => '(adj)'], 'this morning' => ['id' => 'pagi tadi', 'pos' => '(adv)']]],
                2 => ['vocab' => ['input' => ['id' => 'menginput / memasukkan', 'pos' => '(v)'], 'raw survey data' => ['id' => 'data mentah survei', 'pos' => '(n)'], 'research assistant' => ['id' => 'asisten peneliti', 'pos' => '(n)']]],
                3 => ['vocab' => ['debate participant' => ['id' => 'peserta debat', 'pos' => '(n)'], 'logical' => ['id' => 'logis', 'pos' => '(adj)'], 'low score' => ['id' => 'nilai rendah', 'pos' => '(n)']]],
                4 => ['vocab' => ['distribute' => ['id' => 'menyalurkan', 'pos' => '(v)'], 'social aid funds' => ['id' => 'dana bantuan sosial', 'pos' => '(n)'], 'affected residents' => ['id' => 'warga terdampak', 'pos' => '(n)']]],
                5 => ['vocab' => ['machine maintenance' => ['id' => 'pemeliharaan mesin', 'pos' => '(n)'], 'in accordance with' => ['id' => 'sesuai dengan', 'pos' => '(prep)'], 'standard operating procedures' => ['id' => 'SOP', 'pos' => '(n)']]],
                6 => ['vocab' => ['sign' => ['id' => 'menandatangani', 'pos' => '(v)'], 'board decree' => ['id' => 'surat keputusan direksi', 'pos' => '(n)'], 'president director' => ['id' => 'direktur utama', 'pos' => '(n)']]],
                7 => ['vocab' => ['air quality' => ['id' => 'kualitas udara', 'pos' => '(n)'], 'bad' => ['id' => 'buruk', 'pos' => '(adj)'], 'gas leak' => ['id' => 'kebocoran gas', 'pos' => '(n)']]],
                8 => ['vocab' => ['detect' => ['id' => 'mendeteksi', 'pos' => '(v)'], 'communication signal' => ['id' => 'sinyal komunikasi', 'pos' => '(n)'], 'transmitter tower' => ['id' => 'menara pemancar', 'pos' => '(n)']]],
                9 => ['vocab' => ['popular' => ['id' => 'populer', 'pos' => '(adj)'], 'new laboratory plan' => ['id' => 'rencana lab baru', 'pos' => '(n)'], 'senior students' => ['id' => 'mahasiswa angkatan lama', 'pos' => '(n)']]],
                10 => ['vocab' => ['control' => ['id' => 'mengontrol', 'pos' => '(v)'], 'research variables' => ['id' => 'variabel penelitian', 'pos' => '(n)'], 'biased' => ['id' => 'bias', 'pos' => '(adj)']]],
                11 => ['vocab' => ['present' => ['id' => 'hadir', 'pos' => '(adj)'], 'makeup exam session' => ['id' => 'sesi ujian susulan', 'pos' => '(n)'], 'last week' => ['id' => 'minggu lalu', 'pos' => '(adv)']]],
                12 => ['vocab' => ['update' => ['id' => 'memperbarui', 'pos' => '(v)'], 'digital library' => ['id' => 'perpustakaan digital', 'pos' => '(n)'], 'semester break' => ['id' => 'libur semester', 'pos' => '(n)']]],
                13 => ['vocab' => ['conclusion' => ['id' => 'kesimpulan', 'pos' => '(n)'], 'relevant' => ['id' => 'relevan', 'pos' => '(adj)'], 'statistical data' => ['id' => 'data statistik', 'pos' => '(n)']]],
                14 => ['vocab' => ['find' => ['id' => 'menemukan', 'pos' => '(v)'], 'contract violation evidence' => ['id' => 'bukti pelanggaran kontrak', 'pos' => '(n)'], 'legal team' => ['id' => 'tim hukum', 'pos' => '(n)']]],
                15 => ['vocab' => ['courtroom atmosphere' => ['id' => 'atmosfer ruang sidang', 'pos' => '(n)'], 'conducive' => ['id' => 'kondusif', 'pos' => '(adj)'], 'dispute decision' => ['id' => 'keputusan sengketa', 'pos' => '(n)']]],
            ],
            8 => [
                1 => ['vocab' => ['publish' => ['id' => 'mempublikasikan', 'pos' => '(v)'], 'confidential data' => ['id' => 'data rahasia', 'pos' => '(n)'], 'publicly' => ['id' => 'secara terbuka', 'pos' => '(adv)']]],
                2 => ['vocab' => ['submit' => ['id' => 'mengumpulkan', 'pos' => '(v)'], 'assignment on time' => ['id' => 'tugas tepat waktu', 'pos' => '(n)']]],
                3 => ['vocab' => ['detect' => ['id' => 'mendeteksi', 'pos' => '(v)'], 'security system' => ['id' => 'sistem keamanan', 'pos' => '(n)'], 'intrusion' => ['id' => 'intrusi', 'pos' => '(n)']]],
                4 => ['vocab' => ['attend' => ['id' => 'menghadiri', 'pos' => '(v)'], 'weekly coordination meeting' => ['id' => 'rapat koordinasi mingguan', 'pos' => '(n)']]],
                5 => ['vocab' => ['support' => ['id' => 'mendukung', 'pos' => '(v)'], 'policy change proposal' => ['id' => 'usulan perubahan kebijakan', 'pos' => '(n)']]],
                6 => ['vocab' => ['operate' => ['id' => 'beroperasi', 'pos' => '(v)'], 'main engine' => ['id' => 'mesin utama', 'pos' => '(n)'], 'during repair' => ['id' => 'selama perbaikan', 'pos' => '(adv)']]],
                7 => ['vocab' => ['increase / raise' => ['id' => 'menaikkan', 'pos' => '(v)'], 'government' => ['id' => 'pemerintah', 'pos' => '(n)'], 'basic commodity prices' => ['id' => 'harga komoditas pokok', 'pos' => '(n)']]],
                8 => ['vocab' => ['show' => ['id' => 'menunjukkan', 'pos' => '(v)'], 'temperature sensor' => ['id' => 'sensor suhu', 'pos' => '(n)'], 'significant change' => ['id' => 'perubahan signifikan', 'pos' => '(n)']]],
                9 => ['vocab' => ['sign' => ['id' => 'menandatangani', 'pos' => '(v)'], 'delegates' => ['id' => 'para delegasi', 'pos' => '(n)'], 'memorandum of understanding' => ['id' => 'nota kesepahaman', 'pos' => '(n)']]],
                10 => ['vocab' => ['support' => ['id' => 'mendukung', 'pos' => '(v)'], 'application' => ['id' => 'aplikasi', 'pos' => '(n)'], 'large file format' => ['id' => 'format file besar', 'pos' => '(n)']]],
                11 => ['vocab' => ['provide' => ['id' => 'memberikan', 'pos' => '(v)'], 'research subject' => ['id' => 'subjek penelitian', 'pos' => '(n)'], 'consistent response' => ['id' => 'respons konsisten', 'pos' => '(n)']]],
                12 => ['vocab' => ['overhaul' => ['id' => 'merombak', 'pos' => '(v)'], 'technical team' => ['id' => 'tim teknis', 'pos' => '(n)'], 'database architecture' => ['id' => 'arsitektur basis data', 'pos' => '(n)']]],
                13 => ['vocab' => ['share' => ['id' => 'membagikan', 'pos' => '(v)'], 'committee members' => ['id' => 'anggota komite', 'pos' => '(n)'], 'internal documents' => ['id' => 'dokumen internal', 'pos' => '(n)']]],
                14 => ['vocab' => ['shine' => ['id' => 'bersinar terik', 'pos' => '(v)'], 'mountain region' => ['id' => 'wilayah pegunungan', 'pos' => '(n)']]],
                15 => ['vocab' => ['consider' => ['id' => 'mempertimbangkan', 'pos' => '(v)'], 'management' => ['id' => 'manajemen', 'pos' => '(n)'], 'salary increase' => ['id' => 'kenaikan gaji', 'pos' => '(n)']]],
                16 => ['vocab' => ['approve' => ['id' => 'menyetujui', 'pos' => '(v)'], 'expert panel' => ['id' => 'panel ahli', 'pos' => '(n)'], 'proposed methodology' => ['id' => 'metodologi yang diajukan', 'pos' => '(n)']]],
                17 => ['vocab' => ['recognize' => ['id' => 'mengenali', 'pos' => '(v)'], 'software' => ['id' => 'perangkat lunak', 'pos' => '(n)'], 'unregistered fingerprint' => ['id' => 'sidik jari belum terdaftar', 'pos' => '(n)']]],
                18 => ['vocab' => ['provide' => ['id' => 'memberikan', 'pos' => '(v)'], 'bank' => ['id' => 'pihak bank', 'pos' => '(n)'], 'adequate collateral' => ['id' => 'jaminan memadai', 'pos' => '(n)']]],
                19 => ['vocab' => ['include / cite' => ['id' => 'mencantumkan', 'pos' => '(v)'], 'author' => ['id' => 'penulis', 'pos' => '(n)'], 'complete bibliography' => ['id' => 'daftar pustaka lengkap', 'pos' => '(n)']]],
                20 => ['vocab' => ['cover' => ['id' => 'menjamin / menanggung', 'pos' => '(v)'], 'insurance scheme' => ['id' => 'skema asuransi', 'pos' => '(n)'], 'congenital disease' => ['id' => 'penyakit bawaan', 'pos' => '(n)']]],
            ],
            default => [],
        };

        $questions = $this->introductoryMeetingQuestions($meeting);
        $questionRecords = collect($this->introductoryMeetingQuestionRecords($meeting))->keyBy('question_number');
        $meetingCatalog = $this->introductoryMeetingCatalog();
        $topic = (string) ($meetingCatalog[$meeting - 1]['topic'] ?? 'Grammar');
        $resolvedHelpers = [];

        foreach ($questions as $index => $question) {
            $questionNumber = $index + 1;
            $recordExample = null;
            try {
                $recordExample = $record?->example;
            } catch (\Throwable $e) {
                $recordExample = null;
            }

            if (!is_array($recordExample)) {
                $recordExample = null;
            }

            if (is_array($recordExample) && (!isset($recordExample['id']) || !isset($recordExample['en']))) {
                $recordExample = null;
            }

            if ($recordExample === null) {
                try {
                    if ($record?->example_id || $record?->example_en) {
                        $recordExample = [
                            'id' => (string) ($record?->example_id ?? ''),
                            'en' => (string) ($record?->example_en ?? ''),
                        ];
                    }
                } catch (\Throwable $e) {}
            }

            $recordVocab = [];
            try {
                $recordVocab = $this->normalizeIntroductoryHelperVocab($record?->vocab);
            } catch (\Throwable $e) {}

            $presetHelper = $presetHelpers[$questionNumber] ?? null;
            $fallbackHelper = [
                'example' => $this->introductoryMeetingStructureExample($meeting, (string) $question),
                'vocab' => [
                    'topic focus' => ['id' => $topic, 'pos' => '(hint)'],
                    'sentence pattern' => ['id' => 'Perhatikan subjek + predikat + objek/keterangan.', 'pos' => '(tip)'],
                ],
            ];

            $resolvedHelpers[$questionNumber] = [
                'example' => $recordExample
                    ?? ($presetHelper['example'] ?? null)
                    ?? $fallbackHelper['example'],
                'vocab' => !empty($recordVocab)
                    ? $recordVocab
                    : (!empty($presetHelper['vocab']) ? $presetHelper['vocab'] : $fallbackHelper['vocab']),
            ];
        }

        return $resolvedHelpers;
    }

    private function normalizeIntroductoryHelperVocab(mixed $vocab): array
    {
        if (is_string($vocab)) {
            $decoded = json_decode($vocab, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $vocab = $decoded;
            }
        }

        if (!is_array($vocab)) {
            return [];
        }

        $normalized = [];

        foreach ($vocab as $term => $value) {
            $termKey = is_string($term) ? $term : (string) $term;

            if (is_array($value)) {
                $normalized[$termKey] = [
                    'id' => (string) ($value['id'] ?? ''),
                    'pos' => (string) ($value['pos'] ?? '(n)'),
                ];
                continue;
            }

            $normalized[$termKey] = [
                'id' => (string) $value,
                'pos' => '(n)',
            ];
        }

        return $normalized;
    }

    private function introductoryMeetingStructureExample(int $meeting, string $question): array
    {
        $pattern = $this->introductoryMeetingStructurePattern($meeting);
        $focus = $this->introductoryMeetingQuestionFocus($question);

        return [
            'id' => 'Fokus soal: "' . $focus . '". Pola: ' . $pattern['id'],
            'en' => 'Question focus: "' . $focus . '". Pattern: ' . $pattern['en'],
        ];
    }

    private function introductoryMeetingQuestionFocus(string $question): string
    {
        $cleaned = preg_replace('/[^\p{L}\p{N}\s-]/u', '', $question) ?? '';
        $cleaned = trim((string) preg_replace('/\s+/u', ' ', $cleaned));

        if ($cleaned === '') {
            return 'kalimat ini';
        }

        $words = preg_split('/\s+/u', $cleaned) ?: [];
        $focusWords = array_slice($words, 0, 6);

        return implode(' ', $focusWords) . (count($words) > 6 ? ' ...' : '');
    }

    private function introductoryMeetingStructurePattern(int $meeting): array
    {
        return match ($meeting) {
            3 => [
                'id' => 'S + to be (am/is/are) + adjective/noun + complement.',
                'en' => 'S + to be (am/is/are) + adjective/noun + complement.',
            ],
            4 => [
                'id' => 'S + was/were + V3 (+ by + agent) + time marker.',
                'en' => 'S + was/were + V3 (+ by + agent) + time marker.',
            ],
            5 => [
                'id' => 'S + to be + noun/adjective + to-infinitive phrase.',
                'en' => 'S + to be + noun/adjective + to-infinitive phrase.',
            ],
            6 => [
                'id' => 'S + V2 + O + past time expression.',
                'en' => 'S + V2 + O + past time expression.',
            ],
            7 => [
                'id' => 'S + was/were not + complement (Simple Past negative).',
                'en' => 'S + was/were not + complement (Simple Past negative).',
            ],
            8 => [
                'id' => 'S + did not + V1 + O + time marker.',
                'en' => 'S + did not + V1 + O + time marker.',
            ],
            9 => [
                'id' => 'S + do/does/did not + V1 + O (mixed tense accuracy).',
                'en' => 'S + do/does/did not + V1 + O (mixed tense accuracy).',
            ],
            10 => [
                'id' => 'Pronoun agreement: subject/object/possessive in one sentence.',
                'en' => 'Pronoun agreement: subject/object/possessive in one sentence.',
            ],
            11 => [
                'id' => 'Irregular verbs: V1 -> V2 -> V3, lalu terapkan ke kalimat.',
                'en' => 'Irregular verbs: V1 -> V2 -> V3, then apply to the sentence.',
            ],
            12 => [
                'id' => 'S + am/is/are + V-ing + complement.',
                'en' => 'S + am/is/are + V-ing + complement.',
            ],
            13 => [
                'id' => 'S + has/have + V3 + complement (Present Perfect).',
                'en' => 'S + has/have + V3 + complement (Present Perfect).',
            ],
            14 => [
                'id' => 'S + has/have not + V3 + complement.',
                'en' => 'S + has/have not + V3 + complement.',
            ],
            15 => [
                'id' => 'S + modal + V1 + O (can/should/must/etc.).',
                'en' => 'S + modal + V1 + O (can/should/must/etc.).',
            ],
            16 => [
                'id' => 'Gerund as subject/object: V-ing + ...',
                'en' => 'Gerund as subject/object: V-ing + ...',
            ],
            17 => [
                'id' => 'Complex transitive/ditransitive: S + V + IO + DO.',
                'en' => 'Complex transitive/ditransitive: S + V + IO + DO.',
            ],
            18 => [
                'id' => 'Review: past/present/perfect/modal patterns in one set.',
                'en' => 'Review: past/present/perfect/modal patterns in one set.',
            ],
            19 => [
                'id' => 'Examination pattern: pilih tense dan struktur paling tepat.',
                'en' => 'Examination pattern: choose the most appropriate tense and structure.',
            ],
            20 => [
                'id' => 'Final review: pastikan agreement, tense, dan word order.',
                'en' => 'Final review: ensure agreement, tense, and word order.',
            ],
            default => [
                'id' => 'Gunakan pola kalimat sesuai topik pertemuan ini.',
                'en' => 'Use the sentence pattern that matches this meeting topic.',
            ],
        };
    }

    private function introductoryMeetingAnswerKeys(int $meeting): array
    {
        return match ($meeting) {
            1 => [
                1 => 'I wake up at 6 a.m. every day.',
                2 => 'My father works in an office from Monday to Friday.',
                3 => 'The sun rises in the east and sets in the west.',
                4 => 'My cat likes to drink fresh milk.',
                5 => 'They live in a big and beautiful house.',
                6 => 'My younger sister studies English every night.',
                7 => 'We always eat dinner together at 7 p.m.',
                8 => 'She cooks delicious food for our family.',
                9 => 'Water freezes at zero degrees Celsius.',
                10 => 'The students go to school by bus every morning.',
                11 => 'This bakery opens at 8 a.m. every day.',
                12 => 'He speaks English very fluently.',
                13 => 'We read books in the library every Saturday.',
                14 => 'My mother buys fresh vegetables at the traditional market.',
                15 => 'Birds sing in the trees every morning.',
            ],
            2 => [
                1 => 'This letter is sent by the secretary every morning.',
                2 => 'That car is washed by my father every Sunday.',
                3 => 'This bedroom is cleaned by mother every day.',
                4 => 'Trash is thrown into the dustbin every afternoon.',
                5 => 'Hot coffee is served in this cafe every day.',
                6 => 'The flowers are watered by the gardener every morning.',
                7 => 'The shop door is locked by the owner at 9 p.m.',
                8 => 'The books are arranged neatly on the library shelves.',
                9 => 'The bread is baked by the chef every morning.',
                10 => 'This food is prepared for the invited guests.',
                11 => 'Dirty clothes are washed using a washing machine.',
                12 => 'English is used in many countries in the world.',
                13 => 'The room lights are turned off before sleeping.',
                14 => 'The daily report is written by the administrative staff.',
                15 => 'This package is delivered by the courier to our house.',
            ],
            3 => [
                1 => 'She is a friendly and kind teacher.',
                2 => 'We are students at a junior high school.',
                3 => 'My father is a doctor at the city hospital.',
                4 => 'Today the weather is very sunny and warm.',
                5 => 'They are very happy after hearing the good news.',
                6 => 'This book is very interesting and useful for readers.',
                7 => 'That cat is very cute and obedient.',
                8 => 'Our new house is clean, comfortable, and spacious.',
                9 => 'He is a famous singer in our country.',
                10 => 'This city is very beautiful and quiet at night.',
                11 => 'This food is very delicious and healthy for the body.',
                12 => 'I am proud to be part of this team.',
                13 => 'Our school library is very clean and neat.',
                14 => 'This coffee is very hot, please be careful.',
                15 => 'These new shoes are very light and comfortable to wear.',
            ],
            4 => [
                1 => 'She is a doctor and she works at a hospital.',
                2 => 'We are diligent students and we study every day.',
                3 => 'This house is very big, but it has only two rooms.',
                4 => 'My father is very busy because he manages a bakery.',
                5 => 'That cat is very hungry and it eats fresh fish.',
                6 => 'This park is beautiful and many people visit every afternoon.',
                7 => 'This book is very good and presents many interesting stories.',
                8 => 'He is a soccer player and he practices every morning.',
                9 => 'The food in this restaurant is delicious and the price is very cheap.',
                10 => 'I am a college student and I go to campus by bus.',
                11 => 'This city is very crowded and has many shopping centers.',
                12 => 'My mother is friendly and all neighbors like her.',
                13 => 'This computer is new and runs very fast.',
                14 => 'This building is very tall and has twenty floors.',
                15 => 'They are good friends and always help each other.',
            ],
            5 => [
                1 => 'I want to buy a new book at the bookstore.',
                2 => 'She studies hard to pass tomorrow\'s exam.',
                3 => 'We plan to take a vacation to Bali next month.',
                4 => 'He promises to come on time tomorrow morning.',
                5 => 'My sibling decided to continue studying in this city.',
                6 => 'It is very important to drink enough water every day.',
                7 => 'They hope to win tomorrow\'s soccer match.',
                8 => 'My mother goes to the market to buy fresh fruits.',
                9 => 'He refuses to sell his old car.',
                10 => 'We are here to help you complete the task.',
                11 => 'It is very easy to make this delicious banana cake.',
                12 => 'She tries to fix her sibling\'s bicycle.',
                13 => 'Our manager agrees to hold a meeting at 10 a.m.',
                14 => 'Children like to walk around in the park every afternoon.',
                15 => 'It is not easy to learn a foreign language quickly.',
            ],
            6 => [
                1 => 'I visited my grandmother in the village last week.',
                2 => 'He bought a new car two days ago.',
                3 => 'We watched a very exciting movie at the cinema last night.',
                4 => 'My mother cooked delicious chicken soup this morning.',
                5 => 'They played soccer in the field yesterday afternoon.',
                6 => 'She wrote a letter to her friend yesterday.',
                7 => 'Heavy rain fell all night yesterday.',
                8 => 'My father drove a car to the office this morning.',
                9 => 'We finished our group task two hours ago.',
                10 => 'He lost his wallet at the market yesterday.',
                11 => 'The students studied a new chapter in yesterday\'s lesson.',
                12 => 'That shop closed at 8 p.m. yesterday.',
                13 => 'She gave me a birthday gift last week.',
                14 => 'We woke up early at 5 a.m. this morning.',
                15 => 'They arrived at the train station on time yesterday.',
            ],
            7 => [
                1 => 'This old house was built by my grandfather in 1990.',
                2 => 'My bicycle was repaired by uncle yesterday afternoon.',
                3 => 'This birthday cake was made by my mother this morning.',
                4 => 'Yesterday the weather was very cold and windy.',
                5 => 'They were very tired after walking far yesterday.',
                6 => 'This letter was sent by the secretary last week.',
                7 => 'That annual report was completed by the team yesterday.',
                8 => 'He was a smart student when he was little.',
                9 => 'This school building was established ten years ago.',
                10 => 'We were very happy to attend that event yesterday.',
                11 => 'My house key was found under the table this morning.',
                12 => 'She was my classmate when in elementary school.',
                13 => 'This storybook was written by a famous author last year.',
                14 => 'The gate was locked by the guard at 10 p.m. yesterday.',
                15 => 'Yesterday\'s exam was very difficult for the students.',
            ],
            8 => [
                1 => 'I do not drink coffee every morning.',
                2 => 'He did not go to the office by bus yesterday.',
                3 => 'We did not watch television last night.',
                4 => 'She does not like spicy food.',
                5 => 'They did not come to my birthday party yesterday.',
                6 => 'My younger sibling does not play computer games every day.',
                7 => 'My father did not buy a new car last month.',
                8 => 'We did not find the lost key yesterday.',
                9 => 'He did not do his homework last night.',
                10 => 'This bakery does not open on Sundays.',
                11 => 'The students did not understand the teacher\'s explanation yesterday.',
                12 => 'She did not call me this morning.',
                13 => 'We did not live in this big city five years ago.',
                14 => 'That cat does not eat salted fish.',
                15 => 'They did not finish that project on time last week.',
            ],
            9 => [
                1 => 'I live in Jakarta now, but I lived in Bandung last year.',
                2 => 'She bakes cakes every week and she made a delicious cake yesterday.',
                3 => 'Do you study English every day?',
                4 => 'Did they visit the museum yesterday afternoon?',
                5 => 'My father usually takes the train, but he drove a car yesterday.',
                6 => 'We do not like cold weather today.',
                7 => 'Did he buy a new book at the shop yesterday?',
                8 => 'Why did you come late to school this morning?',
                9 => 'This shop opens at 8 a.m. every day, but yesterday it opened at 9 a.m.',
                10 => 'Did your mother cook breakfast this morning?',
                11 => 'She is very diligent and she read three books last week.',
                12 => 'We watched an exciting movie last night and we really liked it.',
                13 => 'Where did you live when you were little?',
                14 => 'He does not work today because he is sick.',
                15 => 'When did they complete their homework yesterday?',
            ],
            10 => [
                1 => 'She gave her book to me yesterday.',
                2 => 'We invited them to our house last week.',
                3 => 'This is my bag and that bag is yours.',
                4 => 'He called her last night.',
                5 => 'This car is theirs and that car is ours.',
                6 => 'My mother cooks delicious food for us every day.',
                7 => 'Is this your pencil or his pencil?',
                8 => 'They helped me complete my task yesterday.',
                9 => 'This cat is cute and its fur is very soft.',
                10 => 'She lost her wallet and we helped her look for it.',
                11 => 'This house is his, not mine.',
                12 => 'I brought your book and you brought my book.',
                13 => 'Our teacher gave us a lot of good advice.',
                14 => 'These shoes are very comfortable and I really like them.',
                15 => 'He borrowed my bicycle and he returned it yesterday.',
            ],
            11 => [
                1 => 'He brought that important letter to the office yesterday.',
                2 => 'We found a small cat in front of the house yesterday afternoon.',
                3 => 'They built a new house in this city last year.',
                4 => 'I bought two storybooks at the bookstore yesterday.',
                5 => 'A strong wind blew at the beach last night.',
                6 => 'She wrote a letter to her friend in ten minutes.',
                7 => 'We knew the answer to that question after discussing.',
                8 => 'My father gave a new bicycle gift to my sibling yesterday.',
                9 => 'He caught the ball very fast yesterday.',
                10 => 'She drank two glasses of fresh water after running.',
                11 => 'The doctor took the patient\'s blood sample yesterday morning.',
                12 => 'Our team made a delicious banana cake last month.',
                13 => 'They came from another city to attend our event.',
                14 => 'That glass fell and broke this morning.',
                15 => 'I heard that happy news from mother this afternoon.',
            ],
            12 => [
                1 => 'I am reading a textbook in the room now.',
                2 => 'She is cooking lunch in the kitchen.',
                3 => 'They are playing basketball on the court right now.',
                4 => 'That car is being washed by my uncle in front of the house.',
                5 => 'The bedroom is being cleaned by mother now.',
                6 => 'Are you listening to music now?',
                7 => 'He is not working because he is on vacation.',
                8 => 'My sibling is happy now.',
                9 => 'The bread is being baked by the chef in the kitchen.',
                10 => 'The children are studying English together with their teacher.',
                11 => 'Is that house being painted by the workers now?',
                12 => 'The weather is very cold and rain is falling outside.',
                13 => 'I am waiting for the bus at the bus stop now.',
                14 => 'The daily report is being written by the staff at the office.',
                15 => 'They are enjoying dinner together with family.',
            ],
            13 => [
                1 => 'I have lived in this city for five years.',
                2 => 'She has finished her homework.',
                3 => 'We have not eaten lunch today.',
                4 => 'They have visited Bali twice.',
                5 => 'My father has not bought that new car.',
                6 => 'Have you read this storybook?',
                7 => 'He has worked at this company since 2020.',
                8 => 'We have never met that famous singer.',
                9 => 'The students have submitted their group task.',
                10 => 'Has she called you today?',
                11 => 'I have never seen such a beautiful view before.',
                12 => 'The rain has stopped and the sun is starting to shine.',
                13 => 'They have not paid this month\'s electricity bill.',
                14 => 'He has lost his key since yesterday.',
                15 => 'We have watched that interesting movie at the cinema.',
            ],
            14 => [
                1 => 'I study English every day, and I have studied for two years.',
                2 => 'She works at this bank now, and she has worked here since 2021.',
                3 => 'Have you ever visited the national museum in Jakarta?',
                4 => 'We have completed our project and we feel very happy.',
                5 => 'My father drives a car every morning, but yesterday he took the bus.',
                6 => 'This shop opens every day, but it has not opened this morning.',
                7 => 'Has he sent that email to the manager?',
                8 => 'They usually eat dinner at 7, but they have eaten dinner at 6 earlier.',
                9 => 'That cat is sleeping on the sofa now because it has eaten a lot.',
                10 => 'I have not received a reply letter from my friend.',
                11 => 'She is very smart and she has won two writing competitions.',
                12 => 'We always help our neighbors when they need help.',
                13 => 'Have they paid the exam registration fee?',
                14 => 'Rain fell very heavily yesterday, but today the weather is very sunny.',
                15 => 'He has never ridden a motorcycle before.',
            ],
            15 => [
                1 => 'You must obey traffic rules when driving.',
                2 => 'She can speak three foreign languages fluently.',
                3 => 'Students should read textbooks before the exam begins.',
                4 => 'May I borrow your pen for a moment?',
                5 => 'You must not litter here.',
                6 => 'We can finish this task on time if we work together.',
                7 => 'He must bring a passport when going abroad.',
                8 => 'You should rest if you feel tired.',
                9 => 'May I open this room window?',
                10 => 'Children must not play on busy main roads.',
                11 => 'She may arrive late because of traffic.',
                12 => 'We must maintain the cleanliness of our home environment.',
                13 => 'You should not eat food that is too spicy.',
                14 => 'Can you help me carry this heavy bag?',
                15 => 'Every motorcycle rider must use a helmet for safety.',
            ],
            16 => [
                1 => 'Reading books every day can increase our knowledge.',
                2 => 'She really likes cooking delicious food for her family.',
                3 => 'Swimming in the pool is my favorite sport.',
                4 => 'We enjoy listening to relaxing music in the afternoon.',
                5 => 'He stopped smoking for his body\'s health.',
                6 => 'Learning a foreign language takes time and patience.',
                7 => 'My mother avoids eating food containing a lot of sugar.',
                8 => 'Walking in the park in the morning is very refreshing for the body.',
                9 => 'They finished cleaning the classroom ten minutes ago.',
                10 => 'She practices dancing every Saturday afternoon.',
                11 => 'Writing storybooks is my younger sister\'s hobby.',
                12 => 'I do not mind waiting for you in front of the library.',
                13 => 'Riding a bicycle in mountainous areas is very fun.',
                14 => 'He suggested ordering food online.',
                15 => 'Keeping hands clean is very important before eating.',
            ],
            17 => [
                1 => 'Father gave me a new bicycle on my birthday.',
                2 => 'She sent her friend a birthday gift.',
                3 => 'The teacher showed us a world map picture in front of the class.',
                4 => 'Mother bought my sibling a beautiful red dress.',
                5 => 'He lent me his favorite storybook.',
                6 => 'I wrote my grandmother a greeting letter.',
                7 => 'Uncle brought us a lot of fresh fruits from the village.',
                8 => 'The client paid our company the service fee on time.',
                9 => 'She taught the children an easy English song.',
                10 => 'My friend brought me a cup of hot tea.',
                11 => 'He told us a very exciting adventure story.',
                12 => 'I ordered my cousin a bowl of delicious meatballs.',
                13 => 'They offered the guests fresh cold drinks.',
                14 => 'Mother baked us sweet chocolate bread.',
                15 => 'She showed me how to make a banana cake.',
            ],
            18 => [
                1 => 'I wake up at 6 a.m. every day and read a book.',
                2 => 'This letter was sent by the secretary yesterday afternoon.',
                3 => 'She is a teacher and she teaches English.',
                4 => 'We want to buy fresh fruits at the market.',
                5 => 'My father bought a new car last week.',
                6 => 'He did not go to the office yesterday because he was sick.',
                7 => 'Have you finished your homework?',
                8 => 'You must obey school rules for the common good.',
                9 => 'Swimming in the sea is a very fun activity.',
                10 => 'My mother bought my sibling a new toy.',
                11 => 'That car is being washed by uncle in front of the house.',
                12 => 'She gave her book to me this morning.',
                13 => 'We have lived in this house for ten years.',
                14 => 'He does not drink hot coffee every morning.',
                15 => 'It is very important to maintain our body\'s health.',
            ],
            19 => [
                1 => 'The sun rises in the east every morning.',
                2 => 'This book was written by a famous author last year.',
                3 => 'She is very friendly and everyone likes her.',
                4 => 'We plan to visit Bali next month.',
                5 => 'He bought new shoes two days ago.',
                6 => 'I did not watch a movie at the cinema last night.',
                7 => 'Have they paid this month\'s school fee?',
                8 => 'You should drink enough water every day.',
                9 => 'Reading books in the library is my favorite hobby.',
                10 => 'Father gave me a new watch yesterday.',
                11 => 'This bedroom is being cleaned by mother now.',
                12 => 'This is my bag and that bag is yours.',
                13 => 'He has worked at this restaurant for three years.',
                14 => 'They did not live in this small town five years ago.',
                15 => 'Learning a foreign language requires regular practice.',
            ],
            20 => [
                1 => 'The earth orbits the sun every year.',
                2 => 'Water is the main source of life for all humans.',
                3 => 'Plastic waste is recycled in modern factories.',
                4 => 'The students strive to get good grades.',
                5 => 'He found his old key yesterday.',
                6 => 'That new house was built by builders last month.',
                7 => 'I do not believe in that fake story.',
                8 => 'They did not complete that task on time yesterday.',
                9 => 'This storybook is hers, not ours.',
                10 => 'She wrote a daily report this morning.',
                11 => 'We are studying English together in class.',
                12 => 'I have not finished reading the last chapter of this book.',
                13 => 'Everyone must obey traffic rules.',
                14 => 'Collecting plastic waste at the beach really helps the environment.',
                15 => 'The teacher gave the students a very clear explanation.',
            ],
            default => [],
        };
    }

    private function introductoryMeetingParagraph(int $meeting): ?array
    {
        return match ($meeting) {
            3 => [
                'id' => 'Keluarga kami memiliki rumah baru di kota. Rumah ini sangat bersih, nyaman, dan luas. Ayah saya adalah seorang dokter dan beliau sangat sibuk di rumah sakit setiap hari. Ibu saya adalah seorang guru yang ramah dan baik hati. Kami semua sangat bahagia tinggal di rumah baru ini.',
                'en' => 'Our family has a new house in the city. This house is very clean, comfortable, and spacious. My father is a doctor and he is very busy at the hospital every day. My mother is a friendly and kind teacher. We are all very happy living in this new house.',
                'vocab' => [
                    'new house' => ['id' => 'rumah baru', 'pos' => '(n)'],
                    'comfortable' => ['id' => 'nyaman', 'pos' => '(adj)'],
                    'spacious' => ['id' => 'luas', 'pos' => '(adj)'],
                    'friendly' => ['id' => 'ramah', 'pos' => '(adj)'],
                    'happy' => ['id' => 'bahagia', 'pos' => '(adj)'],
                ],
            ],
            13 => [
                'id' => 'Saya telah tinggal di kota ini selama lima tahun. Saya suka tinggal di sini karena kotanya sangat indah dan tenang. Teman saya telah mengunjungi kota ini sebanyak dua kali. Kami sudah mengunjungi banyak tempat menarik bersama-sama. Kami sangat bahagia karena kami telah belajar banyak hal baru di kota ini.',
                'en' => 'I have lived in this city for five years. I like living here because the city is very beautiful and quiet. My friend has visited this city twice. We have visited many interesting places together. We are very happy because we have learned many new things in this city.',
                'vocab' => [
                    'have lived' => ['id' => 'telah tinggal', 'pos' => '(v)'],
                    'beautiful' => ['id' => 'indah', 'pos' => '(adj)'],
                    'has visited' => ['id' => 'telah mengunjungi', 'pos' => '(v)'],
                    'interesting places' => ['id' => 'tempat menarik', 'pos' => '(n)'],
                    'have learned' => ['id' => 'telah belajar', 'pos' => '(v)'],
                ],
            ],
            20 => [
                'id' => 'Setiap hari, banyak orang bekerja dan belajar untuk mencapai cita-cita mereka. Belajar bahasa asing membutuhkan waktu, kesabaran, dan latihan yang teratur. Anak-anak pergi ke sekolah naik bus setiap pagi dengan gembira. Ibu membelikan adik saya buku cerita baru kemarin. Menjaga kebersihan lingkungan rumah sangat penting untuk kesehatan keluarga kita.',
                'en' => 'Every day, many people work and study to achieve their goals. Learning a foreign language requires time, patience, and regular practice. Children go to school by bus every morning happily. Mother bought my sibling a new storybook yesterday. Maintaining the cleanliness of our home environment is very important for our family\'s health.',
                'vocab' => [
                    'achieve goals' => ['id' => 'mencapai cita-cita', 'pos' => '(v)'],
                    'foreign language' => ['id' => 'bahasa asing', 'pos' => '(n)'],
                    'regular practice' => ['id' => 'latihan teratur', 'pos' => '(n)'],
                    'storybook' => ['id' => 'buku cerita', 'pos' => '(n)'],
                    'cleanliness' => ['id' => 'kebersihan', 'pos' => '(n)'],
                ],
            ],
            default => null,
        };
    }

    private function resolveIntroductoryMeetingParagraph(int $meeting): array
    {
        $fallbackParagraph = $this->introductoryMeetingParagraph($meeting);

        if ($fallbackParagraph === null) {
            return [
                'paragraphData' => null,
                'editorData' => [
                    'db_id' => null,
                    'id' => '',
                    'en' => '',
                ],
            ];
        }

        $record = null;
        try {
            $query = GrammarQuestion::where('meeting_number', $meeting);
            if ($this->grammarQuestionsHasSectionColumn()) {
                $query->where('section', $this->introductoryMeetingParagraphSection($meeting));
            } else {
                $query->where('question_number', 999);
            }
            $record = $query->orderByDesc('id')->first();
        } catch (\Throwable $e) {
            $record = null;
        }

        $resolvedParagraph = [
            'id' => $record?->question_text ?? $fallbackParagraph['id'],
            'en' => $record?->correct_answer ?? $fallbackParagraph['en'],
            'vocab' => $fallbackParagraph['vocab'] ?? [],
        ];

        return [
            'paragraphData' => $resolvedParagraph,
            'editorData' => [
                'db_id' => $record?->id,
                'id' => $resolvedParagraph['id'],
                'en' => $resolvedParagraph['en'],
            ],
        ];
    }

    private function introductoryMeetingParagraphSection(int $meeting): string
    {
        return 'introductory_' . $meeting . '_paragraph';
    }

    private function evaluateIntroductorySentenceAnswer(string $userAnswer, string $correctAnswer): array
    {
        $bestScore = 0.0;
        $bestFormattedAnswer = '';
        $bestVariant = trim($correctAnswer);

        foreach (explode('|', $correctAnswer) as $variant) {
            $variant = trim($variant);
            if ($variant === '') {
                continue;
            }

            $cleanUser = strtolower(rtrim($userAnswer, '.!'));
            $cleanCorrect = strtolower(rtrim($variant, '.!'));

            $percent = 0;
            similar_text($cleanUser, $cleanCorrect, $percent);
            $questionScore = round($percent / 10, 1);

            if ($questionScore >= $bestScore) {
                $bestScore = $questionScore;
                $bestVariant = $variant;
                $bestFormattedAnswer = $this->formatWordMatchDiff(
                    preg_split('/\s+/', trim($userAnswer), -1, PREG_SPLIT_NO_EMPTY) ?: [],
                    preg_split('/\s+/', trim($variant), -1, PREG_SPLIT_NO_EMPTY) ?: [],
                );
            }
        }

        return [max(0, $bestScore), $bestFormattedAnswer, $bestVariant];
    }

    private function evaluateIntroductoryParagraphAnswer(string $userAnswer, string $correctAnswer): array
    {
        $correctWords = preg_split('/\s+/', trim($correctAnswer), -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $userWords = preg_split('/\s+/', trim($userAnswer), -1, PREG_SPLIT_NO_EMPTY) ?: [];

        $matchCount = 0;
        foreach ($userWords as $userWord) {
            foreach ($correctWords as $correctWord) {
                if (strtolower(rtrim($userWord, '.!,')) === strtolower(rtrim($correctWord, '.!,'))) {
                    $matchCount++;
                    break;
                }
            }
        }

        $maxScore = 20;
        $score = 0;
        if (count($correctWords) > 0) {
            $score = round(($matchCount / count($correctWords)) * $maxScore);
        }

        return [
            'score' => $score,
            'max_score' => $maxScore,
            'formatted_answer' => $this->formatWordMatchDiff($userWords, $correctWords),
            'correct_answer' => $correctAnswer,
        ];
    }

    private function buildComplexityTrackMeetings(): array
    {
        $complexityMeetings = $this->complexityMeetingCatalog();
        $meetings = [];

        foreach ($complexityMeetings as $index => $complexityMeeting) {
            $displayNumber = $index + 1;
            $sourceMeetingNumber = $displayNumber + 10;

            $meetings[] = [
                'title' => 'Meeting ' . $displayNumber,
                'source_meeting_number' => $sourceMeetingNumber,
                'topic' => $complexityMeeting['topic'],
                'description' => 'Latihan terarah untuk topik ' . strtolower($complexityMeeting['topic']) . '.',
                'route_name' => 'assignments.grammar-writing.complexity.meeting',
                'route_parameters' => ['meeting' => $displayNumber],
                'available' => true,
            ];
        }

        return $meetings;
    }

    public function complexityMeetingCatalog(): array
    {
        return [
            ['topic' => 'Silang - silang tenses'],
            ['topic' => 'Latihan penerapan tenses'],
            ['topic' => 'To Infinitive & Gerund'],
            ['topic' => 'Comparative, superlative, positive degree'],
            ['topic' => 'Parallel Structures'],
            ['topic' => 'Adverbial Clause'],
            ['topic' => 'Adjective Clause - RPS / RPO'],
            ['topic' => 'Adjective Clause RPP, RA'],
            ['topic' => 'Noun Clause'],
            ['topic' => 'Exam'],
        ];
    }

    private function buildMappedTrackMeetings(int $startMeetingNumber, int $endMeetingNumber, int $displayStartNumber = 1): array
    {
        $meetingTopics = $this->meetingTopics();
        $meetings = [];
        $displayNumber = $displayStartNumber;

        foreach (range($startMeetingNumber, $endMeetingNumber) as $meetingNumber) {
            $routeName = 'assignments.grammar-writing.meeting' . $meetingNumber;

            $meetings[] = [
                'title' => 'Meeting ' . $displayNumber,
                'source_meeting_number' => $meetingNumber,
                'topic' => $meetingTopics[$meetingNumber] ?? 'Grammar Exercises',
                'description' => 'Latihan terarah untuk topik ' . ($meetingTopics[$meetingNumber] ?? 'Grammar Exercises') . '.',
                'route_name' => $routeName,
                'available' => Route::has($routeName),
            ];

            $displayNumber++;
        }

        return $meetings;
    }

    public function buildProficiencyTrackMeetings(): array
    {
        $topics = [
            'Suffixes',
            'Reducing',
            'Abridgement and omitting',
            'Negative Inversion',
            'Fronting',
            'Cleft sentences',
            'Emphatic structures',
            'Nominalization',
            'Conditional sentences',
            'Exam',
        ];

        $meetings = [];

        foreach ($topics as $index => $topic) {
            $meetings[] = [
                'title' => 'Meeting ' . ($index + 1),
                'source_meeting_number' => $index + 1,
                'topic' => $topic,
                'description' => 'Roadmap proficiency untuk mengasah materi ' . strtolower($topic) . '.',
                'route_name' => 'assignments.grammar-writing.proficiency.meeting',
                'route_parameters' => ['meeting' => $index + 1],
                'available' => true,
                'focus_points' => $this->proficiencyFocusPoints($index + 1),
            ];
        }

        return $meetings;
    }

    private function proficiencyFocusPoints(int $meeting): array
    {
        return match ($meeting) {
            1 => ['Memahami penggunaan akhiran kata (Suffixes)', 'Mengidentifikasi jenis kata berdasarkan suffix'],
            2 => ['Meringkas klausa (Reducing clause)', 'Menggunakan participle untuk reducing'],
            3 => ['Penyederhanaan kalimat kompleks (Abridgement)', 'Mencegah pemborosan kata'],
            4 => ['Menghilangkan kata yang tidak perlu (Omitting)', 'Meningkatkan efisiensi kalimat'],
            5 => ['Menyusun kalimat pembalikan (Inversion)', 'Menggunakan inversion untuk penekanan (emphasis)'],
            6 => ['Menggunakan Appositives untuk memberi informasi tambahan', 'Memahami posisi koma pada appositives'],
            7 => ['Membedakan penggunaan adjective dan adverb', 'Menempatkan modifier dengan tepat'],
            8 => ['Menempatkan elemen di awal kalimat (Fronting)', 'Memberi variasi struktur kalimat'],
            9 => ['Membuat kalimat terbelah (Cleft Sentence) untuk penekanan', 'Menggunakan pola It is... that/who'],
            10 => ['Membedakan berbagai tipe pengandaian (Conditional sentences)', 'Menguasai mixed conditionals'],
            default => [],
        };
    }

    private function meetingTopics(): array
    {
        return [
            1 => 'Pronoun',
            2 => 'Tenses',
            3 => 'Menentukan Tenses',
            4 => 'Modal & Semi modal & Part of Speech',
            5 => 'Negative Sentences',
            6 => 'Verb Palsu (Gerund & To Infininitive)',
            7 => 'Noun Phrase',
            8 => 'Prepositional Phrase',
            9 => 'Writing Structure 1',
            10 => 'Comparative, Superlative, & Positive Degree',
            11 => 'FANBOYS',
            12 => 'Adverbial Clause',
            13 => 'Adjective Clause RPO',
            14 => 'Adjective Clause RPS',
            15 => 'Adjective Clause RPP & RA',
            16 => 'Writing Structure 2',
            17 => 'Noun Clause',
            18 => 'Reducing & Participle',
            19 => 'Adverb of Sentences, Verb, Adjective, and Adverb',
            20 => 'Writing Structure 3',
        ];
    }

    /**
     * Resolve the promo test config for a grammar meeting - previously this defaulted
     * is_free_tier to 1 (public) whenever the meeting still had its generic auto-seeded
     * "Meeting N" title, which meant every real Fast Track/Complexity/Introductory/
     * Proficiency course meeting was unintentionally exposed publicly regardless of the
     * actual is_free_tier column. Now it strictly respects the stored flag, defaulting to
     * gated when there's no matching row or it isn't explicitly marked free-tier.
     */
    private function resolveGrammarMeetingPromoConfig(int $meeting): ?object
    {
        $grammarProgramIds = \App\Models\Program::where('slug', 'like', '%grammar%')->pluck('id')->toArray();

        $testConfig = \Illuminate\Support\Facades\DB::table('meetings')
            ->whereIn('program_id', array_unique($grammarProgramIds))
            ->where('meeting_number', $meeting)
            ->first();

        if (!$testConfig || !$testConfig->is_free_tier) {
            return null;
        }

        if (($testConfig->promo_start && \Carbon\Carbon::parse($testConfig->promo_start)->isFuture())
            || ($testConfig->promo_deadline && \Carbon\Carbon::parse($testConfig->promo_deadline)->isPast())) {
            return null;
        }

        return $testConfig;
    }

    public function grammarWritingIntroductoryMeetingPromo(\Illuminate\Http\Request $request, int $meeting)
    {
        $testConfig = $this->resolveGrammarMeetingPromoConfig($meeting);

        if (!$testConfig) {
            return view('promo.expired');
        }

        $response = $this->grammarWritingIntroductoryMeeting($meeting, true);

        if ($response instanceof \Illuminate\View\View) {
            $data = $response->getData();
            $data['testId'] = $testConfig->id;
            $data['type'] = 'grammar';
            $data['test'] = $testConfig;
            return view('promo.grammar', $data);
        }

        return $response;
    }

    public function grammarWritingIntroductoryMeetingSubmitPromo(\Illuminate\Http\Request $request, int $meeting)
    {
        $testConfig = $this->resolveGrammarMeetingPromoConfig($meeting);

        if (!$testConfig) {
            return view('promo.expired');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
        ]);

        $response = $this->grammarWritingIntroductoryMeetingSubmit($request, $meeting);

        if ($response instanceof \Illuminate\View\View) {
            $data = $response->getData();
            $score = $data['score'] ?? 0;
            $results = $data['results'] ?? [];
            $paragraphResult = $data['paragraphResult'] ?? null;
            
            $aiFeedback = [
                'overall_band_score' => $score,
                'overall_comment' => "Your grammar score is " . $score . " / 100.",
                'results' => $results,
                'paragraphResult' => $paragraphResult
            ];

            $leadId = \Illuminate\Support\Facades\DB::table('free_test_submissions')->insertGetId([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'whatsapp_number' => $validated['whatsapp_number'] ?? null,
                'test_type' => 'grammar',
                'estimated_band_score' => $score,
                'ai_raw_json_feedback' => json_encode($aiFeedback),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            event(new \App\Events\PromoTestCompleted($leadId, $validated['whatsapp_number'] ?? null, $aiFeedback));

            $data['testId'] = $testConfig->id;
            return view('promo.grammar', $data);
        }

        return $response;
    }

    /**
     * Generic AI proxy for the client-side "AI Generator" (question generation,
     * answer explanation, lesson explanation) on the Grammar Writing practice
     * pages. The prompt itself is built client-side (topic-specific rules,
     * knowledge-base context, etc. - none of that is sensitive), but the
     * actual provider call must happen server-side so the API key is never
     * exposed in page source, and so it benefits from the full multi-provider
     * fallback chain instead of a single hardcoded Groq key shared by every
     * student (which was the direct cause of students hitting Groq's shared
     * daily token quota and seeing a raw rate-limit error).
     */
    public function aiProxy(Request $request)
    {
        $validated = $request->validate([
            'prompt' => 'required|string',
            'json_mode' => 'nullable|boolean',
            'temperature' => 'nullable|numeric|min:0|max:2',
        ]);

        $providers = ['groq', 'sambanova', 'cerebras', 'deepinfra', 'mistral', 'siliconflow', 'gemini', 'openrouter', 'openai'];

        $result = \App\Services\MultiProviderAiClient::chat(
            $providers,
            'You are a helpful assistant.',
            $validated['prompt'],
            [
                'groq_feature' => 'writing',
                'max_tokens' => 8192,
                'temperature' => $validated['temperature'] ?? 0.5,
                'json_mode' => (bool) ($validated['json_mode'] ?? false),
                // Default per-attempt timeout is 60s; with up to 9 providers x multiple
                // keys x multiple models tried sequentially on failure, this call could
                // otherwise take minutes before the frontend's 100s abort even fires.
                'timeout' => 20,
            ]
        );

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Sistem AI sedang bermasalah. Silakan coba lagi dalam beberapa saat.',
            ], 503);
        }

        return response()->json([
            'success' => true,
            'content' => $result['content'],
        ]);
    }

    /**
     * "Lesson Explanation" toolbar content for a grammar topic. Scoped
     * counterpart to aiProxy() above (which stays generic for the toolbar's
     * other features) - this one only accepts a topic name and builds the
     * markdown-formatting prompt itself, replacing the toolbar's previous
     * direct browser->Groq fetch with a hardcoded API key exposed in page
     * source (also why formatting was unreliable: that shared key was
     * frequently rate-limited, so markdown instructions weren't consistently
     * honored). Mirrored by GrammarPromoTestController::explainLesson() for
     * the public/no-auth promo pages using the same toolbar partial.
     */
    public function explainLessonTopic(Request $request)
    {
        $validated = $request->validate([
            'topic' => 'required|string|max:255',
        ]);

        $systemPrompt = 'Anda adalah instruktur tata bahasa Inggris (Grammar) ahli. Tugas Anda menyajikan ringkasan materi grammar dalam format Markdown yang sangat rapi, terstruktur, mudah dipelajari, dan visual.';
        $userPrompt = "Tolong berikan penjelasan materi lengkap dan ringkas untuk topik grammar: **{$validated['topic']}**.

FORMAT MATERI YANG HARUS DIIKUTI:

##  Ringkasan Konsep Dasar
Jelaskan secara singkat apa itu topik ini, fungsi utamanya, dan kapan digunakan dalam bahasa Indonesia yang ramah & mudah dimengerti.

---

##  Pembagian & Rumus Lengkap
Bagi materi ke dalam sub-topik yang jelas (misalnya: Verbal, Nominal, Passive, atau aturan khusus). Untuk setiap sub-topik gunakan format:

### 🔹 [Nama Sub-Topik / Bentuk]
- **Fungsi / Penggunaan:** Jelaskan kapan bentuk ini digunakan.
- ** Rumus:**
  - `(+) [Rumus Positif]`
  - `(-) [Rumus Negatif]`
  - `(?) [Rumus Tanya]`
- ** Contoh Kalimat:**
  - 🇬🇧 *English sentence here with **key verb** in bold*
    🇮🇩 *(Artinya dalam bahasa Indonesia)*
  - 🇬🇧 *Another English example*
    🇮🇩 *(Artinya dalam bahasa Indonesia)*

---

##  Tips Penting & Kesalahan Umum (Common Mistakes)
- Berikan 2-3 poin tips praktis atau kesalahan yang sering dilakukan siswa beserta perbaikannya ( Salah vs  Benar).";

        $providers = ['sambanova', 'groq', 'cerebras', 'siliconflow', 'gemini', 'openai'];
        $result = \App\Services\MultiProviderAiClient::chat($providers, $systemPrompt, $userPrompt, [
            'groq_feature' => 'writing',
            'max_tokens' => 2048,
            'temperature' => 0.5,
            // We want raw Markdown prose back, not a JSON object - chat()'s
            // json_mode defaults to true, which forces response_format:
            // json_object and made several providers reject the request
            // outright (400) since the prompt/response isn't JSON-shaped.
            'json_mode' => false,
        ]);

        if (!$result) {
            $fallbackContent = $this->getFallbackLessonExplanationContent($validated['topic']);
            return response()->json(['success' => true, 'content' => $fallbackContent]);
        }

        return response()->json(['success' => true, 'content' => $result['content']]);
    }

    public function fastTrackBookPdf(\Illuminate\Http\Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $isAdminOrTeacher = $user && ($user->isAdmin() || $user->isTeacher());

        if (!$isAdminOrTeacher && $user?->isStudent()) {
            $enrolledSlugs = $this->resolveGrammarEnrolledSlugs($user);
            if (!in_array('fast-track-grammar-for-writing', $enrolledSlugs, true)) {
                return redirect()->route('assignments.grammar-writing.classes')
                    ->with('error', 'Anda tidak memiliki akses ke kelas Fast Track Grammar for Writing.');
            }
        }

        $bookBuilder = app(\App\Application\GrammarWriting\BuildGrammarWritingFastTrackBookData::class);
        $bookMeetings = $bookBuilder->handle();

        $data = [
            'trackTitle' => 'Fast Track Grammar for Writing',
            'bookMeetings' => $bookMeetings,
            'generatedAt' => now()->translatedFormat('d F Y'),
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('assignments.grammar-writing.book-pdf', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Buku_Panduan_Fast_Track_Grammar_for_Writing.pdf');
    }

}
