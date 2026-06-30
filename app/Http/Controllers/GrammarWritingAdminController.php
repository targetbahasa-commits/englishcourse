<?php

namespace App\Http\Controllers;

use App\Application\GrammarWriting\BuildGrammarWritingIndexData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting2ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting6ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting10ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting11ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting12ViewData;
use App\Application\GrammarWriting\Concerns\ScoresWordMatchAnswers;
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

class GrammarWritingAdminController extends Controller
{
    use ScoresWordMatchAnswers;
    use HasProficiencyMeetingContent;

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

    public function grammarWritingClasses()
    {
        $user = Auth::user();
        $enrolledSlugs = $this->resolveGrammarEnrolledSlugs($user instanceof \App\Models\User ? $user : null);
        $isAdminOrTeacher = $user && ($user->isAdmin() || $user->isTeacher());

        $accessIntroductory = $isAdminOrTeacher || in_array('introductory-grammar-for-writing', $enrolledSlugs);
        $accessComplexity   = $isAdminOrTeacher || in_array('complexity-grammar-for-writing', $enrolledSlugs);
        $accessProficiency  = $isAdminOrTeacher || in_array('proficiency-grammar-for-writing', $enrolledSlugs);
        $accessFastTrack    = $isAdminOrTeacher || in_array('fast-track-grammar-for-writing', $enrolledSlugs);

        return view('assignments.grammar-writing-classes', compact(
            'accessIntroductory', 'accessComplexity', 'accessProficiency', 'accessFastTrack', 'isAdminOrTeacher'
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

        foreach ($questions as $idx => $q) {
            if ($q->type === 'sentence') {
                $userAns = $userAnswers['sentences'][$idx] ?? '';
                $eval = $this->evaluateAnswer($userAns, $q->answer_en);
                $results['sentences'][$idx] = $eval;
                $totalScore += $eval['score'];
            } else {
                $userAns = $userAnswers['paragraph'] ?? '';
                $eval = $this->evaluateAnswer($userAns, $q->answer_en);
                $results['paragraph'] = $eval;
                $totalScore += $eval['score'];
            }
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

        // Fast Track is its own standalone track — but it grants access to All Grammar Practice.
        $access = [
            'introductory' => $isAdminOrTeacher || in_array('introductory-grammar-for-writing', $enrolledSlugs),
            'complexity'   => $isAdminOrTeacher || in_array('complexity-grammar-for-writing', $enrolledSlugs),
            'proficiency'  => $isAdminOrTeacher || in_array('proficiency-grammar-for-writing', $enrolledSlugs),
        ];
        $access['all'] = $isAdminOrTeacher || in_array('fast-track-grammar-for-writing', $enrolledSlugs);

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
            
            $availableTopics = $introAvailable->merge($complexityAvailable)->merge($proficiencyAvailable)->unique()->values();
            
            $introTopics = collect();
        }
        
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

    public function grammarWritingTrack(string $track, BuildGrammarWritingIndexData $buildGrammarWritingIndexData)
    {
        $trackData = $this->grammarWritingTracks()[$track] ?? null;

        abort_if($trackData === null, 404);

        $user = Auth::user();
        $isAdminOrTeacher = $user && ($user->isAdmin() || $user->isTeacher());

        // Students may only access the track they are enrolled in.
        if (!$isAdminOrTeacher && $user?->isStudent()) {
            $enrolledSlugs = $this->resolveGrammarEnrolledSlugs($user);
            if (!in_array($trackData['program_slug'], $enrolledSlugs, true)) {
                return redirect()->route('assignments.grammar-writing.classes')
                    ->with('error', 'Anda tidak memiliki akses ke track ini. Silakan daftar program yang sesuai.');
            }
        }

        $indexData = $buildGrammarWritingIndexData->handle(
            $user,
            $trackData['program_slug']
        );

        return view('assignments.grammar-writing-track', array_merge(
            $indexData,
            [
                'track' => $track,
                'trackData' => $trackData,
            ]
        ));
    }

    public function grammarWritingIntroductoryMeeting(int $meeting)
    {
        $user = Auth::user();
        $isAdminOrTeacher = $user && ($user->isAdmin() || $user->isTeacher());

        if (!$isAdminOrTeacher && $user?->isStudent()) {
            $enrolledSlugs = $this->resolveGrammarEnrolledSlugs($user);
            if (!in_array('introductory-grammar-for-writing', $enrolledSlugs, true)) {
                return redirect()->route('assignments.grammar-writing.classes')
                    ->with('error', 'Anda tidak memiliki akses ke kelas Introductory Grammar for Writing.');
            }
        }

        $introductoryMeetings = $this->introductoryMeetingCatalog();
        $meetingData = $introductoryMeetings[$meeting - 1] ?? null;

        abort_if($meetingData === null, 404);

        $resolvedMeetingContent = $this->resolveIntroductoryMeetingContent($meeting);
        $resolvedParagraphContent = $this->resolveIntroductoryMeetingParagraph($meeting);

        return view('assignments.grammar-writing-introductory-meeting', [
            'meetingNumber' => $meeting,
            'meetingLabel' => $meetingData['label'],
            'topic' => $meetingData['topic'],
            'trackTitle' => 'Introductory Grammar for Writing',
            'questions' => $resolvedMeetingContent['questions'],
            'questionHelpers' => $this->introductoryMeetingQuestionHelpers($meeting),
            'cheatSheet' => $this->introductoryMeetingCheatSheet($meeting),
            'questionEditorData' => $resolvedMeetingContent['editorData'],
            'submitted' => false,
            'score' => null,
            'results' => [],
            'userAnswers' => [],
            'meeting11Answers' => [],
            'paragraphData' => $resolvedParagraphContent['paragraphData'],
            'paragraphEditorData' => $resolvedParagraphContent['editorData'],
            'userParagraphAnswer' => '',
            'paragraphResult' => null,
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

        $results = [];
        $totalScore = 0;
        $gradedQuestionCount = 0;

        foreach ($questions as $index => $questionText) {
            $questionNumber = $index + 1;
            $userAnswer = trim((string) ($userAnswers[$questionNumber] ?? ''));
            $correctAnswer = trim((string) ($answerKeys[$questionNumber] ?? ''));

            $questionScore = 0;
            $formattedAnswer = '';

            if ($correctAnswer !== '') {
                [$questionScore, $formattedAnswer, $correctAnswer] = $this->evaluateIntroductorySentenceAnswer($userAnswer, $correctAnswer);
                $totalScore += $questionScore;
                $gradedQuestionCount++;
            }

            $results[$questionNumber] = [
                'user_answer' => $userAnswer,
                'formatted_answer' => $formattedAnswer,
                'score' => $questionScore,
                'correct_answer' => $correctAnswer,
            ];
        }

        $paragraphResult = null;
        $maxRawScore = $gradedQuestionCount * 10;

        if ($paragraphData !== null && !empty($paragraphData['en'])) {
            $paragraphResult = $this->evaluateIntroductoryParagraphAnswer($userParagraphAnswer, (string) $paragraphData['en']);
            $totalScore += $paragraphResult['score'];
            $maxRawScore += $paragraphResult['max_score'];
        }

        $finalScore = $maxRawScore > 0 ? round(($totalScore / $maxRawScore) * 100, 1) : 0;

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
        return redirect()->route('assignments.grammar-writing.introductory.meeting', ['meeting' => $meeting]);
    }

    public function grammarWritingComplexityMeeting(
        int $meeting,
        BuildGrammarWritingMeeting2ViewData $buildGrammarWritingMeeting2ViewData,
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

        if ($meeting === 1) {
            return view('assignments.grammar-writing.meeting2', array_merge(
                $buildGrammarWritingMeeting2ViewData->handle(
                    $grammarWritingDataRepository->meeting2Tenses,
                    $grammarWritingDataRepository->meeting2TenseExamples,
                    $grammarWritingDataRepository->meeting2Vocabularies,
                ),
                [
                    'backRoute' => route('assignments.grammar-writing.track', 'complexity'),
                ]
            ));
        }

        if ($meeting === 3) {
            return view('assignments.grammar-writing.meeting6', array_merge(
                $buildGrammarWritingMeeting6ViewData->handle(),
                [
                    'backRoute' => route('assignments.grammar-writing.track', 'complexity'),
                ]
            ));
        }

        if ($meeting === 4) {
            return view('assignments.grammar-writing.meeting10', array_merge(
                $buildGrammarWritingMeeting10ViewData->handle(
                    $grammarWritingDataRepository->meeting10Paragraph,
                    $grammarWritingDataRepository->meeting10Examples,
                ),
                [
                    'backRoute' => route('assignments.grammar-writing.track', 'complexity'),
                ]
            ));
        }

        if ($meeting === 5) {
            return view('assignments.grammar-writing.meeting11', array_merge(
                $buildGrammarWritingMeeting11ViewData->handle(
                    $grammarWritingDataRepository->meeting11Questions,
                    $grammarWritingDataRepository->meeting11Paragraph,
                ),
                [
                    'backRoute' => route('assignments.grammar-writing.track', 'complexity'),
                ]
            ));
        }

        if ($meeting === 6) {
            return view('assignments.grammar-writing.meeting12', array_merge(
                $buildGrammarWritingMeeting12ViewData->handle(
                    $grammarWritingDataRepository->meeting12Questions,
                    $grammarWritingDataRepository->meeting12Paragraph,
                ),
                [
                    'backRoute' => route('assignments.grammar-writing.track', 'complexity'),
                ]
            ));
        }

        if ($meeting === 7) {
            $questions = [
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
            ];

            return view('assignments.grammar-writing-complexity-meeting', [
                'meetingNumber' => $meeting,
                'topic' => 'Adjective Clause - RPS & RPO',
                'trackTitle' => 'Complexity Grammar for Writing',
                'questions' => $questions,
            ]);
        }

        if ($meeting === 8) {
            $questions = [
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
            ];

            return view('assignments.grammar-writing-complexity-meeting', [
                'meetingNumber' => $meeting,
                'topic' => 'Adjective Clause RPP & RA',
                'trackTitle' => 'Complexity Grammar for Writing',
                'questions' => $questions,
            ]);
        }

        if ($meeting === 9) {
            $questions = [
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
            ];

            return view('assignments.grammar-writing-complexity-meeting', [
                'meetingNumber' => $meeting,
                'topic' => 'Noun Clause',
                'trackTitle' => 'Complexity Grammar for Writing',
                'questions' => $questions,
            ]);
        }

        $complexityMeetings = $this->complexityMeetingCatalog();
        $meetingData = $complexityMeetings[$meeting - 1] ?? null;

        abort_if($meeting < 1 || $meeting > 10, 404);
        abort_if($meetingData === null, 404);

        // Special for meeting 2
        if ($meeting === 2) {
            $questions = [
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
            ];
            $questionHelpers = $this->complexityMeeting2QuestionHelpers();
            return view('assignments.grammar-writing-complexity-meeting', [
                'meetingNumber' => $meeting,
                'topic' => $meetingData['topic'],
                'trackTitle' => 'Complexity Grammar for Writing',
                'questions' => $questions,
                'questionHelpers' => $questionHelpers,
            ]);
        }

        return view('assignments.grammar-writing-complexity-meeting', [
            'meetingNumber' => $meeting,
            'topic' => $meetingData['topic'],
            'trackTitle' => 'Complexity Grammar for Writing',
        ]);
    }

    private function complexityMeeting2QuestionHelpers(): array
    {
        return [
            1 => ['example' => ['id' => 'Seluruh dokumen telah diverifikasi oleh tim audit internal.', 'en' => 'All documents have been verified by the internal audit team.'], 'vocab' => ['verified' => ['id' => 'terverifikasi', 'pos' => '(v3)'], 'strict process' => ['id' => 'proses ketat', 'pos' => '(n)']]],
            2 => ['example' => ['id' => 'Para peneliti sedang memetakan area pesisir secara detail.', 'en' => 'Researchers are mapping the coastal area in detail.'], 'vocab' => ['mapping' => ['id' => 'pemetaan', 'pos' => '(n)'], 'coastal area' => ['id' => 'wilayah pesisir', 'pos' => '(n)']]],
            3 => ['example' => ['id' => 'Karakteristik geologis daerah ini sangat berbeda.', 'en' => 'The geological characteristics of this region are very different.'], 'vocab' => ['geomorphology' => ['id' => 'geomorfologi', 'pos' => '(n)'], 'mountainous' => ['id' => 'pegunungan', 'pos' => '(adj)']]],
            4 => ['example' => ['id' => 'Peradaban kuno membangun kanal irigasi di area kering.', 'en' => 'Ancient civilizations built irrigation canals in arid areas.'], 'vocab' => ['civilization' => ['id' => 'peradaban', 'pos' => '(n)'], 'arid' => ['id' => 'gersang', 'pos' => '(adj)']]],
            5 => ['example' => ['id' => 'Setiap komponen sistem harus berada dalam keseimbangan.', 'en' => 'Each system component must remain in balance.'], 'vocab' => ['element' => ['id' => 'elemen', 'pos' => '(n)'], 'balanced' => ['id' => 'seimbang', 'pos' => '(adj)']]],
            6 => ['example' => ['id' => 'Strategi mitigasi sedang ditinjau oleh lembaga terkait.', 'en' => 'The mitigation strategy is being reviewed by the relevant institution.'], 'vocab' => ['mitigation' => ['id' => 'mitigasi', 'pos' => '(n)'], 'reviewed' => ['id' => 'ditinjau', 'pos' => '(v3)']]],
            7 => ['example' => ['id' => 'Ilmuwan itu menjadi tokoh penting dalam fisika modern.', 'en' => 'That scientist became a key figure in modern physics.'], 'vocab' => ['scientist' => ['id' => 'ilmuwan', 'pos' => '(n)'], 'central figure' => ['id' => 'figur sentral', 'pos' => '(n)']]],
            8 => ['example' => ['id' => 'Fotosintesis mengubah energi cahaya menjadi energi kimia.', 'en' => 'Photosynthesis converts light energy into chemical energy.'], 'vocab' => ['photosynthesis' => ['id' => 'fotosintesis', 'pos' => '(n)'], 'converts' => ['id' => 'mengonversi', 'pos' => '(v1)']]],
            9 => ['example' => ['id' => 'Struktur administrasi pada era itu tidak terlalu kaku.', 'en' => 'The administrative structure in that era was not too rigid.'], 'vocab' => ['bureaucratic structure' => ['id' => 'struktur birokrasi', 'pos' => '(n)'], 'rigid' => ['id' => 'kaku', 'pos' => '(adj)']]],
            10 => ['example' => ['id' => 'Naskah bersejarah dikirim ke museum untuk digitalisasi.', 'en' => 'The historical manuscript was sent to the museum for digitization.'], 'vocab' => ['manuscript' => ['id' => 'naskah', 'pos' => '(n)'], 'digital preservation' => ['id' => 'preservasi digital', 'pos' => '(n)']]],
            11 => ['example' => ['id' => 'Analisis spektrum membantu menentukan unsur bintang.', 'en' => 'Spectrum analysis helps determine stellar elements.'], 'vocab' => ['spectrum analysis' => ['id' => 'analisis spektrum', 'pos' => '(n)'], 'composition' => ['id' => 'komposisi', 'pos' => '(n)']]],
            12 => ['example' => ['id' => 'Arsitek membangun fondasi antigempa untuk gedung utama.', 'en' => 'Architects built an earthquake-resistant foundation for the main building.'], 'vocab' => ['foundation' => ['id' => 'fondasi', 'pos' => '(n)'], 'earthquake-resistant' => ['id' => 'tahan guncangan', 'pos' => '(adj)']]],
            13 => ['example' => ['id' => 'Atmosfer planet itu berada dalam fase transisi ekstrem.', 'en' => 'That planet atmosphere is in an extreme transition phase.'], 'vocab' => ['atmosphere' => ['id' => 'atmosfer', 'pos' => '(n)'], 'transition phase' => ['id' => 'tahap transisi', 'pos' => '(n)']]],
            14 => ['example' => ['id' => 'Kebijakan dekarbonisasi wajib diterapkan oleh setiap negara.', 'en' => 'Decarbonization policies must be implemented by every country.'], 'vocab' => ['decarbonization' => ['id' => 'dekarbonisasi', 'pos' => '(n)'], 'implemented' => ['id' => 'diimplementasikan', 'pos' => '(v3)']]],
            15 => ['example' => ['id' => 'Tim arkeolog menemukan permukiman neolitikum saat ekskavasi.', 'en' => 'The archaeologist team discovered a Neolithic settlement during excavation.'], 'vocab' => ['archaeologist' => ['id' => 'arkeolog', 'pos' => '(n)'], 'excavation' => ['id' => 'ekskavasi', 'pos' => '(n)']]],
        ];
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

        $meetings = $this->buildProficiencyTrackMeetings();
        $meetingData = $meetings[$meeting - 1] ?? null;

        abort_if($meetingData === null, 404);

        $resolvedMeetingContent = $this->resolveProficiencyMeetingContent($meeting);
        $resolvedParagraphContent = $this->resolveProficiencyMeetingParagraph($meeting);

        return view('assignments.grammar-writing-proficiency-meeting', [
            'meetingNumber' => $meeting,
            'meetingLabel' => 'Meeting ' . $meeting,
            'topic' => $meetingData['topic'],
            'meetingData' => $meetingData,
            'trackTitle' => 'Proficiency Grammar for Writing',
            'questions' => $resolvedMeetingContent['questions'],
            'questionHelpers' => [],
            'questionEditorData' => $resolvedMeetingContent['editorData'],
            'submitted' => false,
            'score' => null,
            'results' => [],
            'userAnswers' => [],
            'paragraphData' => $resolvedParagraphContent['paragraphData'],
            'paragraphEditorData' => $resolvedParagraphContent['editorData'],
            'userParagraphAnswer' => '',
            'paragraphResult' => null,
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

        $results = [];
        $totalScore = 0;
        $gradedQuestionCount = 0;

        foreach ($questions as $index => $questionText) {
            $questionNumber = $index + 1;
            $userAnswer = trim((string) ($userAnswers[$questionNumber] ?? ''));
            $correctAnswer = trim((string) ($answerKeys[$questionNumber] ?? ''));

            $questionScore = 0;
            $formattedAnswer = '';

            if ($correctAnswer !== '') {
                [$questionScore, $formattedAnswer, $correctAnswer] = $this->evaluateIntroductorySentenceAnswer($userAnswer, $correctAnswer);
                $totalScore += $questionScore;
                $gradedQuestionCount++;
            }

            $results[$questionNumber] = [
                'user_answer' => $userAnswer,
                'formatted_answer' => $formattedAnswer,
                'score' => $questionScore,
                'correct_answer' => $correctAnswer,
            ];
        }

        $paragraphResult = null;
        $maxRawScore = $gradedQuestionCount * 10;

        if ($paragraphData !== null && !empty($paragraphData['en'])) {
            $paragraphResult = $this->evaluateIntroductoryParagraphAnswer($userParagraphAnswer, (string) $paragraphData['en']);
            $totalScore += $paragraphResult['score'];
            $maxRawScore += $paragraphResult['max_score'];
        }

        $finalScore = $maxRawScore > 0 ? round(($totalScore / $maxRawScore) * 100, 1) : 0;

        return view('assignments.grammar-writing-proficiency-meeting', [
            'meetingNumber' => $meeting,
            'meetingLabel' => 'Meeting ' . $meeting,
            'topic' => $meetingData['topic'],
            'meetingData' => $meetingData,
            'trackTitle' => 'Proficiency Grammar for Writing',
            'questions' => $questions,
            'questionHelpers' => [],
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
        return redirect()->route('assignments.grammar-writing.proficiency.meeting', ['meeting' => $meeting]);
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

    private function proficiencyMeetingQuestionRecords(int $meeting): array
    {
        return GrammarQuestion::where('meeting_number', $meeting)
            ->where('section', 'proficiency_' . $meeting)
            ->orderBy('question_number')
            ->get()
            ->all();
    }

    private function resolveProficiencyMeetingParagraph(int $meeting): array
    {
        $fallbackParagraphs = $this->proficiencyMeetingParagraphs($meeting);
        $paragraphData = empty($fallbackParagraphs) ? null : $fallbackParagraphs;
        
        $record = GrammarQuestion::where('meeting_number', $meeting)
            ->where('section', 'proficiency_paragraph_' . $meeting)
            ->first();

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

    public function grammarWriting(BuildGrammarWritingIndexData $buildGrammarWritingIndexData)
    {
        return $this->grammarWritingTrack('fast-track', $buildGrammarWritingIndexData);
    }

    public function updatePeriod(UpdateGrammarWritingPeriodRequest $request, ManageGrammarWritingMeetings $manageGrammarWritingMeetings)
    {
        $this->requireGrammarWritingAdminOrTeacher();

        $result = $manageGrammarWritingMeetings->updateActivePeriod(
            $request->period(),
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

            $record = GrammarQuestion::where('meeting_number', $meeting)
                ->where('section', $section)
                ->where('question_number', $questionNumber)
                ->first();

            if ($record) {
                $record->update(['question_text' => $line]);
            } else {
                GrammarQuestion::create([
                    'meeting_number' => $meeting,
                    'question_number' => $questionNumber,
                    'section' => $section,
                    'question_text' => $line,
                    'correct_answer' => '',
                ]);
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
                'summary' => '10 focused meetings dari struktur dasar hingga persiapan examination.',
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
            6 => 'Comparative, superlative, positive degree & Parallel Structures',
            7 => 'Adverbial Clause',
            8 => 'Adjective Clause - RPS / RPP',
            9 => 'Adjective Clause RPP, RA',
            10 => 'Noun Clause',
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
            ];
        }

        return $meetings;
    }

    private function buildIntroductoryTrackMeetings(): array
    {
        $introductoryMeetings = array_slice($this->introductoryMeetingCatalog(), 0, 10);
        $meetings = [];

        foreach ($introductoryMeetings as $index => $introductoryMeeting) {
            $meetingNumber = $index + 1;

            $meetings[] = [
                'title' => 'Meeting ' . $meetingNumber,
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
            ['label' => '7a', 'topic' => 'Present Perfect & Negative'],
            ['label' => '7b', 'topic' => 'Review Simple Present - Present Perfect'],
            ['label' => '8a', 'topic' => 'Modal'],
            ['label' => '8b', 'topic' => 'Gerund'],
            ['label' => '9a', 'topic' => 'Complex Ditransitive'],
            ['label' => '9b', 'topic' => 'Review'],
            ['label' => '10a', 'topic' => 'Examination'],
            ['label' => '10b', 'topic' => 'Final Review and Reflection'],
        ];
    }

    private function introductoryMeetingCheatSheet(int $meeting): ?array
    {
        if ($meeting === 3) {
            return [
                'Simple Present Nominal' => [
                    'I + <span class="font-bold">am</span>',
                    'You/ We/ They/ Benda Jamak + <span class="font-bold">are</span>',
                    'He/ She/ It/ Benda Tunggal + <span class="font-bold">is</span>'
                ]
            ];
        }
        
        return null;
    }

    private function introductoryMeetingQuestions(int $meeting): array
    {
        return match ($meeting) {
            1 => [
                'Bumi berputar pada porosnya setiap dua puluh empat jam.',
                'Mahasiswa tingkat akhir berdiskusidengan dewan dekanat setiap bulan.',
                'Siswa-siswa berdiskusi tentang teori ekonomi di dalam kelas.',
                'Air mendidih pada suhu seratus derajat Celsius.',
                'Setiap warga negara berhak mendapatkan pendidikan yang layak.',
                'Program beasiswa itu bertujuan meningkatkan kualitas sumber daya manusia.',
                'Para peneliti bekerja secara intensif di laboratorium pusat.',
                'Teori ini berfokus pada dampak sosial dari teknologi digital.',
                'Masyarakat lokal berpartisipasi dalam program pelestarian hutan.',
                'Data statistik tersebut berasal dari survei penduduk.',
                'Ekosistem sungai bergantung pada kebersihan aliran hulu.',
                'Setiap individu bertanggung jawab atas kelestarian lingkungan sekitar.',
                'Hasil penelitian ini berbeda dengan hipotesis awal para pakar.',
                'Proses belajar-mengajar berlangsung dari pagi hingga sore hari.',
                'Banyak spesies burung bermigrasi ke arah selatan saat musim dingin tiba.',
            ],
            2 => [
                'Data penelitian dianalisis secara mendalam di dalam database pusat untuk memastikan tingkat akurasi yang tinggi.',
                'Hipotesis tersebut diuji melalui serangkaian eksperimen di bawah kondisi laboratorium yang ketat.',
                'Fenomena alam ini diklasifikasikan sebagai perubahan iklim signifikan di sepanjang wilayah kutub utara.',
                'Sumber daya alam dikelola secara berkelanjutan di seluruh zona konservasi nasional demi kepentingan generasi mendatang.',
                'Teori-teori sosiologi diterapkan di dalam studi kasus masyarakat perkotaan untuk memahami perilaku modern.',
                'Artikel ilmiah ditinjau oleh para ahli di balik sistem peninjauan tertutup sebelum diterbitkan dalam jurnal internasional.',
                'Informasi sensitif dilindungi di dalam server dengan protokol keamanan yang sangat canggih.',
                'Pencapaian mahasiswa dievaluasi di seluruh departemen universitas berdasarkan kriteria penilaian yang objektif.',
                'Kontribusi besar diberikan oleh lembaga penelitian di luar batas negara asal mereka dalam pengembangan vaksin baru.',
                'Prosedur operasional dipatuhi oleh seluruh staf di setiap lini produksi demi menjaga standar keselamatan kerja.',
                'Kebijakan akademik disusun oleh senat universitas di tingkat pusat guna meningkatkan standar mutu pendidikan tinggi.',
                'Sampel tanah diambil dari berbagai lokasi penelitian di lapangan untuk diuji kandungan mineralnya secara periodik.',
                'Anggaran tahunan dialokasikan secara transparan oleh manajemen fakultas bagi pengembangan infrastruktur laboratorium digital.',
                'Paradigma baru diperkenalkan di dalam kurikulum sains terpadu sebagai respon terhadap kemajuan teknologi kecerdasan buatan.',
                'Kesimpulan penelitian ditarik berdasarkan bukti-bukti empiris di akhir laporan untuk memberikan rekomendasi yang valid.',
            ],
            12 => [
                'Tim peneliti sedang melakukan observasi lapangan di ekosistem hutan hujan tropis.',
                'Data statistik tersebut sedang dianalisis oleh para ahli guna memastikan validitasnya.',
                'Saat ini, kondisi ekonomi global sedang tidak stabil akibat fluktuasi harga komoditas.',
                'Mahasiswa tingkat akhir sedang menyusun tesis mereka di perpustakaan pusat.',
                'Kebijakan privasi baru perusahaan sedang disosialisasikan kepada seluruh pengguna layanan digital.',
                'Manajer proyek sedang sibuk mempersiapkan dokumen audit untuk pertemuan besok pagi.',
                'Para ilmuwan sedang mencari solusi alternatif untuk mengatasi krisis energi dunia.',
                'Proposal pembangunan laboratorium sedang ditinjau kembali oleh dewan direksi universitas.',
                'Atmosfer di ruang sidang sedang sangat kondusif selama proses pemaparan argumen berlangsung.',
                'Pemerintah sedang mengimplementasikan program digitalisasi untuk seluruh instansi pelayanan publik.',
                'Sampel tanah dari area tambang sedang diuji di laboratorium independen.',
                'Variabel penelitian ini sedang tidak konsisten sehingga memerlukan penyesuaian metodologi.',
                'Panel ahli sedang mendiskusikan dampak jangka panjang dari perubahan iklim.',
                'Laporan keuangan tahunan sedang diperiksa secara menyeluruh oleh tim audit eksternal.',
                'Tingkat efisiensi mesin utama sedang berada pada posisi optimal setelah dilakukan pemeliharaan berkala.',
            ],
            3 => [
                'Partikel mikroplastik berbahaya bagi kesehatan biota laut.',
                'Strategi konservasi energi efektif untuk mengurangi beban konsumsi listrik.',
                'Lapisan ozon sangat rentan terhadap polutan kimia tertentu.',
                'Mitigasi bencana adalah prioritas utama dalam perencanaan tata wilayah.',
                'Data penelitian ini akurat untuk mendukung hipotesis awal yang diajukan.',
            ],
            4 => [
                'Limbah industri dikelola secara profesional untuk mencegah polusi sungai.',
                'Keamanan siber adalah prioritas utama bagi perusahaan teknologi besar.',
                'Pemerintah pusat mengalokasikan dana khusus untuk pelestarian hutan lindung.',
                'Data statistik tersebut cukup relevan dengan kondisi lapangan saat ini.',
                'Bahasa Inggris digunakan sebagai alat komunikasi utama dalam forum global.',
                'Teknologi modern mempermudah komunikasi jarak jauh antar individu.',
                'Akses pendidikan berkualitas adalah hak asasi bagi setiap warga negara.',
                'Laporan tahunan tersebut diperiksa oleh dewan direksi setiap akhir bulan.',
                'Para ilmuwan melakukan observasi berkala terhadap perubahan iklim.',
                'Saya sangat optimis mengenai keberhasilan kolaborasi internasional ini.',
                'Aturan baru tersebut diterapkan secara serentak di seluruh cabang.',
                'Sektor pariwisata memberikan kontribusi besar bagi pendapatan daerah.',
                'Metodologi penelitian ini sangat akurat dalam memprediksi pasar.',
                'Berbagai jenis obat-obatan diproduksi di laboratorium nasional.',
                'Matahari memancarkan radiasi ultraviolet yang memengaruhi atmosfer.',
                'Stabilitas ekonomi sangat krusial untuk pertumbuhan jangka panjang.',
                'Keputusan strategis ini diambil berdasarkan analisis data mendalam.',
                'Perusahaan ini menerapkan standar etika kerja yang sangat ketat.',
                'Keanekaragaman budaya kita sangat dikagumi oleh masyarakat dunia.',
                'Sistem AI canggih memproses jutaan informasi dalam hitungan detik.',
            ],
            5 => [
                'Tujuan dari penelitian ini adalah untuk menganalisis dampak urbanisasi terhadap kualitas udara.',
                'Para ilmuwan membutuhkan data tambahan untuk memvalidasi hipotesis mereka.',
                'Sangat krusial bagi pemerintah untuk mengimplementasikan kebijakan ekonomi yang berkelanjutan.',
                'Metode ini digunakan untuk mengukur tingkat efisiensi energi dalam sistem manufaktur.',
                'Peneliti tersebut merupakan orang pertama yang mengidentifikasi kaitan antara genetika dan pola tidur.',
                'Penting bagi mahasiswa untuk mengutip sumber asli guna menghindari plagiarisme.',
                'Dewan etik memutuskan untuk menolak proposal eksperimen tersebut karena risiko keamanan.',
                'Strategi yang efektif adalah untuk mengintegrasikan teknologi AI ke dalam kurikulum sekolah.',
                'Cara paling akurat untuk mengevaluasi kinerja karyawan adalah melalui penilaian 360 derajat.',
                'Bahan kimia ini terlalu tidak stabil untuk digunakan dalam kondisi suhu ruangan.',
                'Kami berupaya untuk meminimalisir bias dalam pengambilan sampel data.',
                'Variabel kontrol disiapkan untuk memastikan bahwa hasil eksperimen tetap konsisten.',
                'Fenomena ini sangat sulit untuk dijelaskan tanpa menggunakan model matematika tingkat lanjut.',
                'Tim riset berencana untuk mempublikasikan temuan mereka di jurnal internasional bereputasi.',
                'Institusi pendidikan berkewajiban untuk memfasilitasi pengembangan bakat setiap peserta didik.',
            ],
            6 => [
                'Peneliti mengisolasi senyawa kimia tersebut dari ekstrak tumbuhan bulan lalu.',
                'Sel tersebut membelah diri pada fase mitosis terakhir dalam pengamatan kemarin.',
                'Reaksi eksotermik melepaskan sejumlah besar energi panas selama durasi eksperimen.',
                'Cahaya terbiaskan secara signifikan di medium prisma pada pengujian minggu lalu.',
                'Ekosistem hutan menyerap karbon dioksida dalam jumlah besar sepanjang dekade terakhir.',
                'Subjek penelitian memberikan data kuantitatif yang valid setelah sesi wawancara selesai.',
                'Model simulasi memprediksi peningkatan suhu global pada akhir tahun lalu.',
                'Molekul tersebut berikatan dengan reseptor protein pada permukaan sel selama proses inkubasi.',
                'Geolog menemukan formasi batuan sedimen yang unik di situs penggalian bulan kemarin.',
                'Proyek ini mengintegrasikan teknologi kecerdasan buatan dalam sistem operasionalnya setahun yang lalu.',
                'Saya mengirimkan proposal proyek itu tepat waktu kemarin sore.',
                'Organisasi tersebut mengadakan seminar internasional tahun lalu.',
                'Pasien meminum obat sesuai dosis yang dianjurkan dokter tadi malam.',
                'Sistem mengalami gangguan teknis selama dua jam penuh.',
                'Pengacara memenangkan kasus tersebut setelah persidangan yang panjang.',
                'Mahasiswa mempelajari metodologi penelitian di perpustakaan akhir pekan lalu.',
                'Perusahaan mengubah citra merek mereka secara total tahun sebelumnya.',
                'Kontraktor menyelesaikan pembangunan jembatan itu sebelum jadwal yang ditentukan.',
                'Saya mencapai target skor IELTS yang saya inginkan bulan lalu.',
                'Para penonton memberikan apresiasi yang meriah setelah presentasi selesai.',
            ],
            7 => [
                'Laporan audit tersebut tidak tersedia di meja manajer saat rapat dimulai pagi tadi.',
                'Data mentah hasil survei tidak diinput ke dalam sistem oleh asisten peneliti kemarin.',
                'Argumen yang disampaikan oleh peserta debat tidak logis sehingga juri memberikan nilai rendah.',
                'Dana bantuan sosial tidak disalurkan kepada warga yang terdampak bencana pada bulan lalu.',
                'Prosedur pemeliharaan mesin tidak sesuai dengan standar operasional prosedur (SOP) yang berlaku saat itu.',
                'Surat keputusan dewan direksi tidak ditandatangani oleh direktur utama karena adanya kekeliruan data.',
                'Kualitas udara di sekitar pabrik tidak buruk sebelum terjadi kebocoran gas pada malam hari.',
                'Sinyal komunikasi tidak terdeteksi oleh menara pemancar selama badai berlangsung dua hari lalu.',
                'Rencana pembangunan laboratorium baru tidak populer di kalangan mahasiswa angkatan lama.',
                'Variabel penelitian tidak dikontrol dengan ketat sehingga hasil eksperimen menjadi bias.',
                'Mahasiswa tersebut tidak hadir dalam sesi ujian susulan yang diadakan minggu lalu.',
                'Fasilitas perpustakaan digital tidak diperbarui oleh tim IT selama masa libur semester.',
                'Kesimpulan dalam naskah tersebut tidak relevan dengan data statistik yang disajikan penulis.',
                'Bukti-bukti pelanggaran kontrak tidak ditemukan oleh tim hukum selama proses investigasi.',
                'Atmosfer di ruang sidang tidak kondusif saat pengumuman keputusan sengketa lahan tersebut.',
            ],
            8 => [
                'Perusahaan tidak mempublikasikan data rahasia itu secara terbuka kepada publik tahun lalu.',
                'Mahasiswa tersebut tidak mengumpulkan tugas tepat waktu sesuai instruksi kemarin.',
                'Sistem keamanan tidak mendeteksi intrusi saat kejadian berlangsung.',
                'Dia tidak menghadiri rapat koordinasi mingguan departemen pagi tadi.',
                'Kami tidak mendukung usulan perubahan kebijakan.',
                'Mesin utama tidak beroperasi selama proses perbaikan berlangsung minggu lalu.',
                'Pemerintah tidak menaikkan harga komoditas pokok pada bulan ini.',
                'Sensor suhu tidak menunjukkan perubahan yang signifikan dalam eksperimen kemarin.',
                'Para delegasi tidak menandatangani nota kesepahaman itu pada pertemuan sebelumnya.',
                'Aplikasi ini tidak mendukung format file dengan ukuran yang sangat besar.',
                'Subjek penelitian tidak memberikan respons yang konsisten terhadap stimulus.',
                'Tim teknis tidak merombak arsitektur basis data secara keseluruhan pada proyek terakhir.',
                'Anggota komite tidak membagikan dokumen internal kepada pihak luar.',
                'Matahari tidak bersinar terik di wilayah pegunungan itu sepanjang hari kemarin.',
                'Pihak manajemen tidak mempertimbangkan usulan kenaikan gaji tahun ini.',
                'Panel ahli tidak menyetujui metodologi penelitian yang diajukan bulan lalu.',
                'Perangkat lunak ini tidak mengenali sidik jari yang belum terdaftar dalam sistem.',
                'Pihak bank tidak memberikan pinjaman modal tanpa adanya jaminan yang memadai.',
                'Penulis tidak mencantumkan daftar pustaka yang lengkap pada akhir naskah jurnalnya.',
                'Skema asuransi tersebut tidak menjamin biaya pengobatan untuk penyakit bawaan.',
            ],
            9 => [
                'Peneliti itu mempublikasikan jurnal ilmiahnya setiap tahun.',
                'Mereka tidak menghadiri konferensi internasional di Tokyo bulan lalu.',
                'Apakah pemerintah menyediakan dana yang cukup untuk penelitian ini?',
                'Laboratorium ini dilengkapi dengan peralatan medis yang sangat canggih.',
                'Cuaca di daerah pegunungan itu sangat dingin kemarin pagi.',
                'Mahasiswa tidak menyerahkan tugas akhirnya tepat waktu minggu lalu.',
                'Apakah buku-buku referensi tersebut tersedia di perpustakaan kampus?',
                'Tim teknis menyelesaikan perbaikan server utama dua hari yang lalu.',
                'Proyek infrastruktur ini sangat penting bagi pertumbuhan ekonomi negara.',
                'Laporan keuangan perusahaan tidak diaudit oleh pihak eksternal tahun lalu.',
                'Mengapa harga bahan pokok selalu meningkat setiap tahun?',
                'Seminar nasional itu diadakan di gedung utama universitas kemarin.',
                'Keputusan manajer tidak memuaskan banyak karyawan di departemen tersebut.',
                'Sistem keamanan baru ini lebih efisien daripada sistem yang lama.',
                'Apakah dia (laki-laki) menyetujui proposal anggaran yang diajukan minggu lalu?',
                'Banyak spesies hewan kehilangan habitat aslinya karena penebangan hutan liar.',
                'Para peserta pelatihan sangat antusias selama sesi diskusi kemarin sore.',
                'Kebijakan baru tersebut tidak diimplementasikan secara menyeluruh oleh semua cabang.',
                'Ilmuwan sering kali membutuhkan waktu bertahun-tahun untuk menemukan vaksin baru.',
                'Kapan CEO mengumumkan rencana ekspansi bisnis perusahaan?',
            ],
            10 => [
                'Dia (perempuan) mempublikasikan artikel ilmiah nya di jurnal internasional bulan lalu.',
                'Kami menganalisis data tersebut guna memahami dampak nya terhadap ekonomi nasional.',
                'Saya memberikan instruksi kepada mereka sebelum eksperimen dimulai kemarin.',
                'Hipotesis ini adalah milik kita, dan kita harus mempertahankan nya dalam diskusi.',
                'Mereka mempresentasikan temuan mereka di hadapan dewan profesor pagi tadi.',
                'Institusi ini melindungi hak milik intelektual nya melalui prosedur hukum yang ketat.',
                'Kamu menyerahkan laporan akhir mu kepada dia (laki-laki) dua hari yang lalu.',
                'Keberhasilan proyek ini adalah milik mereka sepenuhnya.',
                'Dia (laki-laki) mengundang saya untuk bergabung dalam tim riset nya tahun lalu.',
                'Kalian harus memvalidasi sumber referensi kalian sebelum menulis kesimpulan.',
                'Dia (perempuan) adalah mentor saya, dan saya sangat menghormati ia.',
                'Kami menemukan artefak itu dan membawa nya ke laboratorium pusat kemarin.',
                'Keputusan mengenai beasiswa tersebut adalah milik dia (perempuan).',
                'Mereka tidak mendukung usulan kami selama rapat koordinasi kemarin.',
                'Saya menyimpan salinan dokumen itu karena dokumen tersebut adalah milik saya.',
            ],
            13 => [
                'Para ilmuwan telah melakukan berbagai eksperimen untuk membuktikan teori gravitasi terbaru.',
                'Data statistik mengenai pertumbuhan ekonomi belum dikumpulkan oleh tim peneliti.',
                'Universitas telah menjadi pusat inovasi teknologi selama dua dekade terakhir.',
                'Teori evolusi telah dibahas secara mendalam dalam jurnal ilmiah internasional.',
                'Mahasiswa tingkat akhir belum menyerahkan draf skripsi mereka ke dosen pembimbing.',
                'Kurikulum pendidikan tinggi telah mengalami perubahan besar untuk menyesuaikan kebutuhan industri.',
                'Hasil uji laboratorium telah diverifikasi oleh dewan pakar independen.',
                'Sistem perpustakaan digital sudah tidak aktif sejak pemeliharaan server minggu lalu.',
                'Banyak referensi buku klasik telah digantikan oleh sumber informasi digital yang lebih mutakhir.',
                'Profesor itu belum memberikan nilai ujian semester kepada para mahasiswa.',
                'Fenomena lubang hitam telah menjadi fokus utama dalam penelitian astrofisika tahun ini.',
                'Metode pembelajaran berbasis proyek telah terbukti efektif meningkatkan kreativitas siswa.',
                'Anggaran untuk penelitian medis belum dialokasikan sepenuhnya oleh kementerian terkait.',
                'Makalah ilmiah tersebut sudah pernah dipublikasikan di konferensi tingkat dunia.',
                'Para arkeolog telah menemukan prasasti kuno yang menjelaskan sejarah peradaban Mesopotamia.',
            ],
            14 => [
                'Institusi ini berupaya untuk meningkatkan standar keamanan data pada semua platform digitalnya.',
                'Tim auditor telah menyelesaikan pemeriksaan menyeluruh terhadap laporan keuangan kuartal ketiga.',
                'Para ilmuwan menemukan bukti baru mengenai perubahan iklim selama ekspedisi tahun lalu.',
                'Saat ini, dewan direksi sedang mendiskusikan strategi ekspansi pasar ke wilayah Asia Tenggara.',
                'Pemerintah mengeluarkan regulasi baru untuk mengatur penggunaan kecerdasan buatan di sektor publik.',
                'Peneliti tersebut membutuhkan waktu tambahan untuk memvalidasi hasil eksperimen laboratoriumnya.',
                'Kami sudah mengirimkan proposal kerja sama teknis kepada mitra strategis di luar negeri.',
                'Sistem keamanan mendeteksi adanya upaya intrusi ilegal pada jaringan utama malam tadi.',
                'Manajer proyek sedang memantau progres pembangunan infrastruktur secara real-time.',
                'Perusahaan memutuskan untuk menunda peluncuran produk baru hingga kondisi pasar stabil.',
                'Analisis statistik ini menunjukkan korelasi positif antara motivasi kerja dan produktivitas karyawan.',
                'Panel ahli telah menerbitkan pedoman etika terbaru bagi para praktisi medis.',
                'Mahasiswa itu gagal untuk menyerahkan draf tesisnya sebelum tenggat waktu yang ditentukan.',
                'Banyak perusahaan besar berinvestasi pada teknologi ramah lingkungan sepanjang tahun 2025.',
                'Otoritas bandara sedang memperketat prosedur pemeriksaan dokumen bagi penumpang internasional.',
                'Dia telah bekerja sebagai konsultan hukum senior selama lebih dari satu dekade.',
                'Setiap departemen wajib untuk menyusun laporan evaluasi kinerja secara periodik.',
                'Krisis ekonomi global mempengaruhi daya beli masyarakat secara signifikan pada dekade lalu.',
                'Tim teknis sedang memperbaiki kerusakan pada modul komunikasi satelit pusat.',
                'Inovasi ini bertujuan untuk mengurangi ketergantungan industri pada bahan bakar fosil.',
            ],
            15 => [
                'Tim peneliti harus melakukan validasi data secara berkala.',
                'Instrumen laboratorium ini dapat mendeteksi partikel mikro dalam air.',
                'Setiap mahasiswa wajib mengikuti seminar proposal pada semester ini.',
                'Teori sosiologi tersebut mungkin relevan dengan fenomena urbanisasi saat ini.',
                'Pihak dekanat akan menerbitkan surat keputusan mengenai beasiswa prestasi.',
                'Hasil observasi lapangan seharusnya menunjukkan pola distribusi spesies yang akurat.',
                'Penulis sebaiknya menyertakan daftar pustaka dalam format terbaru.',
                'Variabel kontrol mesti terjaga stabil selama proses eksperimen.',
                'Diskusi ilmiah ini bisa jadi memicu inovasi teknologi baru.',
                'Pemerintah bakal mengalokasikan dana riset untuk pengembangan vaksin.',
                'Setiap artikel jurnal harus melewati proses tinjauan sejawat.',
                'Penggunaan sumber energi terbarukan bisa mengurangi emisi gas rumah kaca.',
                'Dosen pembimbing hendaknya memberikan arahan teknis mengenai metodologi.',
                'Analisis statistik ini akan memperkuat argumen utama dalam disertasi.',
                'Protokol keamanan data wajib diterapkan di seluruh basis data universitas.',
            ],
            17 => [
                'Profesor itu membiarkan para mahasiswa menggunakan kalkulator selama ujian berlangsung.',
                'Manajer membuat asistennya menulis ulang laporan tahunan tersebut.',
                'Saya mendengar dewan direksi mendiskusikan rencana merger perusahaan tadi pagi.',
                'Pihak universitas meminta para ahli meninjau kurikulum baru tersebut.',
                'Kami melihat tim riset mengambil sampel air dari sungai yang tercemar.',
                'Orang tua itu membiarkan anak-anaknya memilih jalur pendidikan mereka sendiri.',
                'Guru memperhatikan para siswa mengerjakan tugas eksperimen di laboratorium.',
                'Dia membuat kliennya menandatangani kontrak kerja sama tersebut kemarin.',
                'Saya merasakan gedung itu bergetar saat mesin utama dinyalakan.',
                'Atasan meminta staf IT memperbaiki gangguan pada server pusat.',
                'Jangan biarkan kesalahan kecil merusak seluruh hasil penelitian ini.',
                'Kami mendengar pemimpin proyek mengumumkan pembatalan rapat koordinasi.',
                'Peneliti memperhatikan sel tersebut membelah diri di bawah mikroskop.',
                'Kebijakan baru ini membuat masyarakat mempertanyakan transparansi pemerintah.',
                'Saya melihat dia menyerahkan dokumen rahasia itu kepada pihak berwenang.',
            ],
            11 => [
                'V1: Blow (isi Verb 2 dan Verb 3).',
                'V1: Buy (isi Verb 2 dan Verb 3).',
                'V1: Bring (isi Verb 2 dan Verb 3).',
                'V1: Break (isi Verb 2 dan Verb 3).',
                'V1: Build (isi Verb 2 dan Verb 3).',
                'V1: Catch (isi Verb 2 dan Verb 3).',
                'V1: Come (isi Verb 2 dan Verb 3).',
                'V1: Cut (isi Verb 2 dan Verb 3).',
                'V1: Do (isi Verb 2 dan Verb 3).',
                'V1: Drink (isi Verb 2 dan Verb 3).',
                'V1: Eat (isi Verb 2 dan Verb 3).',
                'V1: Forget (isi Verb 2 dan Verb 3).',
                'V1: Get (isi Verb 2 dan Verb 3).',
                'V1: Give (isi Verb 2 dan Verb 3).',
                'V1: Hear (isi Verb 2 dan Verb 3).',
                'V1: Keep (isi Verb 2 dan Verb 3).',
                'V1: Know (isi Verb 2 dan Verb 3).',
                'V1: Learn (isi Verb 2 dan Verb 3).',
                'V1: Make (isi Verb 2 dan Verb 3).',
                'V1: Put (isi Verb 2 dan Verb 3).',
                'V1: Read (isi Verb 2 dan Verb 3).',
                'V1: Say (isi Verb 2 dan Verb 3).',
                'V1: Run (isi Verb 2 dan Verb 3).',
                'V1: Sing (isi Verb 2 dan Verb 3).',
                'V1: Sit (isi Verb 2 dan Verb 3).',
                'V1: Sleep (isi Verb 2 dan Verb 3).',
                'V1: Speak (isi Verb 2 dan Verb 3).',
                'V1: Stand (isi Verb 2 dan Verb 3).',
                'V1: Take (isi Verb 2 dan Verb 3).',
                'V1: Wake (isi Verb 2 dan Verb 3).',
                'V1: Understand (isi Verb 2 dan Verb 3).',
                'V1: Write (isi Verb 2 dan Verb 3).',
                'Tim peneliti menemukan anomali pada data statistik setelah melakukan observasi selama tiga bulan.',
                'Penulis menulis draf pertama naskah jurnal tersebut dalam waktu kurang dari satu minggu.',
                'Para delegasi meninggalkan ruangan sidang setelah kesepakatan diplomatik tercapai.',
                'Perusahaan memilih untuk melakukan restrukturisasi organisasi guna meningkatkan efisiensi.',
                'Pemerintah menaikkan anggaran pendidikan sebesar sepuluh persen pada tahun fiskal lalu.',
                'Mahasiswa tersebut memahami konsep termodinamika setelah mengikuti kursus intensif.',
                'Kami melihat adanya peningkatan signifikan dalam partisipasi publik selama survei berlangsung.',
                'Ketua komite memberikan pidato pembukaan yang sangat inspiratif di konferensi internasional.',
                'Arsitek tersebut membangun model prototipe gedung dengan menggunakan teknologi cetak tiga dimensi.',
                'Data mentah tersebut disimpan di dalam server yang sangat aman untuk mencegah kebocoran informasi.',
                'Dia menjadi koordinator proyek karena memiliki pengalaman luas di bidang manajemen risiko.',
                'Panel ahli mengetahui adanya kesalahan dalam metodologi penelitian sebelum publikasi dilakukan.',
                'Tim audit melakukan pemeriksaan menyeluruh terhadap laporan keuangan perusahaan minggu lalu.',
                'Sistem keamanan menangkap aktivitas mencurigakan di dalam jaringan komputer universitas.',
                'Analisis ini menunjukkan bahwa pertumbuhan ekonomi global telah melambat secara bertahap.',
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
        return GrammarQuestion::where('meeting_number', $meeting)
            ->where('section', $this->introductoryMeetingSection($meeting))
            ->orderBy('question_number')
            ->get()
            ->all();
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
                        'rotates' => ['id' => 'berputar', 'pos' => '(v1)'],
                        'axis' => ['id' => 'poros', 'pos' => '(n)'],
                    ],
                ],
                2 => [
                    'example' => ['id' => 'Para dosen berdiskusi dengan rektor setiap minggu.', 'en' => 'The lecturers discuss with the rector every week.'],
                    'vocab' => [
                        'final-year students' => ['id' => 'mahasiswa tingkat akhir', 'pos' => '(n)'],
                        'dean board' => ['id' => 'dewan dekanat', 'pos' => '(n)'],
                    ],
                ],
                3 => [
                    'example' => ['id' => 'Murid-murid membahas isu lingkungan di kelas.', 'en' => 'The students discuss environmental issues in class.'],
                    'vocab' => [
                        'economic theory' => ['id' => 'teori ekonomi', 'pos' => '(n)'],
                        'classroom' => ['id' => 'ruang kelas', 'pos' => '(n)'],
                    ],
                ],
                4 => [
                    'example' => ['id' => 'Es mencair pada suhu nol derajat Celsius.', 'en' => 'Ice melts at zero degrees Celsius.'],
                    'vocab' => [
                        'boils' => ['id' => 'mendidih', 'pos' => '(v1)'],
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
                        'scholarship program' => ['id' => 'program beasiswa', 'pos' => '(n)'],
                        'aims' => ['id' => 'bertujuan', 'pos' => '(v1)'],
                    ],
                ],
                7 => [
                    'example' => ['id' => 'Para ilmuwan bekerja rutin di pusat riset nasional.', 'en' => 'The scientists work regularly at the national research center.'],
                    'vocab' => [
                        'researchers' => ['id' => 'para peneliti', 'pos' => '(n)'],
                        'central laboratory' => ['id' => 'laboratorium pusat', 'pos' => '(n)'],
                    ],
                ],
                8 => [
                    'example' => ['id' => 'Kajian ini berfokus pada pengaruh media sosial.', 'en' => 'This study focuses on the influence of social media.'],
                    'vocab' => [
                        'focuses on' => ['id' => 'berfokus pada', 'pos' => '(v1)'],
                        'social impact' => ['id' => 'dampak sosial', 'pos' => '(n)'],
                    ],
                ],
                9 => [
                    'example' => ['id' => 'Warga desa berpartisipasi dalam program kebersihan sungai.', 'en' => 'Village residents participate in the river-cleaning program.'],
                    'vocab' => [
                        'local community' => ['id' => 'masyarakat lokal', 'pos' => '(n)'],
                        'forest conservation' => ['id' => 'pelestarian hutan', 'pos' => '(n)'],
                    ],
                ],
                10 => [
                    'example' => ['id' => 'Data ekonomi ini berasal dari laporan tahunan pemerintah.', 'en' => 'This economic data comes from the government\'s annual report.'],
                    'vocab' => [
                        'statistical data' => ['id' => 'data statistik', 'pos' => '(n)'],
                        'population survey' => ['id' => 'survei penduduk', 'pos' => '(n)'],
                    ],
                ],
                11 => [
                    'example' => ['id' => 'Kualitas air laut bergantung pada kebersihan pantai.', 'en' => 'Sea water quality depends on beach cleanliness.'],
                    'vocab' => [
                        'depends on' => ['id' => 'bergantung pada', 'pos' => '(v1)'],
                        'upstream flows' => ['id' => 'aliran hulu', 'pos' => '(n)'],
                    ],
                ],
                12 => [
                    'example' => ['id' => 'Setiap siswa bertanggung jawab atas kebersihan kelas.', 'en' => 'Every student is responsible for classroom cleanliness.'],
                    'vocab' => [
                        'is responsible for' => ['id' => 'bertanggung jawab atas', 'pos' => '(v1)'],
                        'environmental sustainability' => ['id' => 'kelestarian lingkungan', 'pos' => '(n)'],
                    ],
                ],
                13 => [
                    'example' => ['id' => 'Temuan terbaru berbeda dari prediksi sebelumnya.', 'en' => 'The latest findings differ from the previous prediction.'],
                    'vocab' => [
                        'research results' => ['id' => 'hasil penelitian', 'pos' => '(n)'],
                        'initial hypothesis' => ['id' => 'hipotesis awal', 'pos' => '(n)'],
                    ],
                ],
                14 => [
                    'example' => ['id' => 'Kegiatan pelatihan berlangsung dari siang sampai malam.', 'en' => 'The training session runs from noon to evening.'],
                    'vocab' => [
                        'teaching and learning process' => ['id' => 'proses belajar-mengajar', 'pos' => '(n)'],
                        'runs' => ['id' => 'berlangsung', 'pos' => '(v1)'],
                    ],
                ],
                15 => [
                    'example' => ['id' => 'Sebagian ikan bergerak ke perairan hangat saat cuaca dingin.', 'en' => 'Some fish move to warmer waters during cold weather.'],
                    'vocab' => [
                        'migrate' => ['id' => 'bermigrasi', 'pos' => '(v1)'],
                        'south' => ['id' => 'ke arah selatan', 'pos' => '(adv)'],
                    ],
                ],
            ],
            2 => [
                1 => [
                    'example' => ['id' => 'Laporan keuangan dianalisis secara rinci di pusat data nasional.', 'en' => 'The financial report is analyzed in detail in the national data center.'],
                    'vocab' => [
                        'research data' => ['id' => 'data penelitian', 'pos' => '(n)'],
                        'central database' => ['id' => 'database pusat', 'pos' => '(n)'],
                    ],
                ],
                2 => [
                    'example' => ['id' => 'Teori baru diuji di bawah pengawasan ketat para peneliti.', 'en' => 'The new theory is tested under strict supervision by researchers.'],
                    'vocab' => [
                        'hypothesis' => ['id' => 'hipotesis', 'pos' => '(n)'],
                        'strict laboratory conditions' => ['id' => 'kondisi laboratorium yang ketat', 'pos' => '(n)'],
                    ],
                ],
                3 => [
                    'example' => ['id' => 'Peristiwa cuaca ini diklasifikasikan sebagai anomali musiman.', 'en' => 'This weather event is classified as a seasonal anomaly.'],
                    'vocab' => [
                        'classified as' => ['id' => 'diklasifikasikan sebagai', 'pos' => '(v3)'],
                        'significant climate change' => ['id' => 'perubahan iklim signifikan', 'pos' => '(n)'],
                    ],
                ],
                4 => [
                    'example' => ['id' => 'Hutan lindung dikelola secara terpadu untuk menjaga keanekaragaman hayati.', 'en' => 'Protected forests are managed in an integrated way to preserve biodiversity.'],
                    'vocab' => [
                        'natural resources' => ['id' => 'sumber daya alam', 'pos' => '(n)'],
                        'sustainably' => ['id' => 'secara berkelanjutan', 'pos' => '(adv)'],
                    ],
                ],
                5 => [
                    'example' => ['id' => 'Konsep antropologi diterapkan dalam penelitian sosial kontemporer.', 'en' => 'Anthropological concepts are applied in contemporary social research.'],
                    'vocab' => [
                        'sociological theories' => ['id' => 'teori-teori sosiologi', 'pos' => '(n)'],
                        'urban community case studies' => ['id' => 'studi kasus masyarakat perkotaan', 'pos' => '(n)'],
                    ],
                ],
                6 => [
                    'example' => ['id' => 'Manuskrip ilmiah ditinjau sebelum dipublikasikan secara resmi.', 'en' => 'Scientific manuscripts are reviewed before being officially published.'],
                    'vocab' => [
                        'reviewed by experts' => ['id' => 'ditinjau oleh para ahli', 'pos' => '(v3)'],
                        'closed review system' => ['id' => 'sistem peninjauan tertutup', 'pos' => '(n)'],
                    ],
                ],
                7 => [
                    'example' => ['id' => 'Dokumen rahasia dilindungi oleh sistem enkripsi berlapis.', 'en' => 'Confidential documents are protected by a layered encryption system.'],
                    'vocab' => [
                        'sensitive information' => ['id' => 'informasi sensitif', 'pos' => '(n)'],
                        'encrypted servers' => ['id' => 'server terenkripsi', 'pos' => '(n)'],
                    ],
                ],
                8 => [
                    'example' => ['id' => 'Kinerja siswa dinilai berdasarkan indikator akademik yang jelas.', 'en' => 'Student performance is evaluated based on clear academic indicators.'],
                    'vocab' => [
                        'student achievement' => ['id' => 'pencapaian mahasiswa', 'pos' => '(n)'],
                        'objective assessment criteria' => ['id' => 'kriteria penilaian yang objektif', 'pos' => '(n)'],
                    ],
                ],
                9 => [
                    'example' => ['id' => 'Bantuan logistik diberikan oleh organisasi internasional selama krisis.', 'en' => 'Logistical support is provided by international organizations during crises.'],
                    'vocab' => [
                        'major contributions' => ['id' => 'kontribusi besar', 'pos' => '(n)'],
                        'research institutions' => ['id' => 'lembaga penelitian', 'pos' => '(n)'],
                    ],
                ],
                10 => [
                    'example' => ['id' => 'Aturan keselamatan dipatuhi oleh operator di area kerja berisiko tinggi.', 'en' => 'Safety regulations are followed by operators in high-risk work areas.'],
                    'vocab' => [
                        'operational procedures' => ['id' => 'prosedur operasional', 'pos' => '(n)'],
                        'production line' => ['id' => 'lini produksi', 'pos' => '(n)'],
                    ],
                ],
                11 => [
                    'example' => ['id' => 'Peraturan baru disusun oleh komite akademik pusat.', 'en' => 'New regulations are formulated by the central academic committee.'],
                    'vocab' => [
                        'academic policies' => ['id' => 'kebijakan akademik', 'pos' => '(n)'],
                        'university senate' => ['id' => 'senat universitas', 'pos' => '(n)'],
                    ],
                ],
                12 => [
                    'example' => ['id' => 'Sampel air diambil dari beberapa titik sungai untuk analisis kualitas.', 'en' => 'Water samples are taken from several river points for quality analysis.'],
                    'vocab' => [
                        'soil samples' => ['id' => 'sampel tanah', 'pos' => '(n)'],
                        'mineral content' => ['id' => 'kandungan mineral', 'pos' => '(n)'],
                    ],
                ],
                13 => [
                    'example' => ['id' => 'Dana proyek dialokasikan secara terbuka untuk fasilitas penelitian modern.', 'en' => 'Project funds are allocated transparently for modern research facilities.'],
                    'vocab' => [
                        'annual budget' => ['id' => 'anggaran tahunan', 'pos' => '(n)'],
                        'faculty management' => ['id' => 'manajemen fakultas', 'pos' => '(n)'],
                    ],
                ],
                14 => [
                    'example' => ['id' => 'Model pembelajaran baru diperkenalkan dalam program lintas disiplin.', 'en' => 'A new learning model is introduced in an interdisciplinary program.'],
                    'vocab' => [
                        'new paradigm' => ['id' => 'paradigma baru', 'pos' => '(n)'],
                        'integrated science curriculum' => ['id' => 'kurikulum sains terpadu', 'pos' => '(n)'],
                    ],
                ],
                15 => [
                    'example' => ['id' => 'Kesimpulan akhir ditarik dari data lapangan yang konsisten.', 'en' => 'Final conclusions are drawn from consistent field data.'],
                    'vocab' => [
                        'research conclusions' => ['id' => 'kesimpulan penelitian', 'pos' => '(n)'],
                        'empirical evidence' => ['id' => 'bukti empiris', 'pos' => '(n)'],
                    ],
                ],
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
            $record = $questionRecords->get($questionNumber);
            $recordExample = $record?->example;

            if (!is_array($recordExample)) {
                $recordExample = null;
            }

            if (is_array($recordExample) && (!isset($recordExample['id']) || !isset($recordExample['en']))) {
                $recordExample = null;
            }

            if ($recordExample === null && ($record?->example_id || $record?->example_en)) {
                $recordExample = [
                    'id' => (string) ($record?->example_id ?? ''),
                    'en' => (string) ($record?->example_en ?? ''),
                ];
            }

            $recordVocab = $this->normalizeIntroductoryHelperVocab($record?->vocab);

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
                1 => 'The earth rotates on its axis every twenty-four hours.',
                2 => 'Final-year students discuss with the dean board every month.',
                3 => 'The students discuss economic theory in class.',
                4 => 'Water boils at one hundred degrees Celsius.',
                5 => 'Every citizen has the right to proper education.',
                6 => 'The scholarship program aims to improve the quality of human resources.',
                7 => 'The researchers work intensively in the central laboratory.',
                8 => 'This theory focuses on the social impact of digital technology.',
                9 => 'The local community participates in the forest conservation program.',
                10 => 'The statistical data comes from the population survey.',
                11 => 'The river ecosystem depends on the cleanliness of upstream flows.',
                12 => 'Every individual is responsible for the sustainability of the surrounding environment.',
                13 => 'The research results differ from the experts\' initial hypothesis.',
                14 => 'The teaching and learning process runs from morning to afternoon.',
                15 => 'Many bird species migrate south when winter arrives.',
            ],
            2 => [
                1 => 'Research data are analyzed in depth in the central database to ensure a high level of accuracy.',
                2 => 'The hypothesis is tested through a series of experiments under strict laboratory conditions.',
                3 => 'This natural phenomenon is classified as significant climate change across the Arctic region.',
                4 => 'Natural resources are managed sustainably throughout national conservation zones for the benefit of future generations.',
                5 => 'Sociological theories are applied in urban community case studies to understand modern behavior.',
                6 => 'Scientific articles are reviewed by experts behind a closed review system before being published in international journals.',
                7 => 'Sensitive information is protected in servers with highly advanced security protocols.',
                8 => 'Student achievement is evaluated across all university departments based on objective assessment criteria.',
                9 => 'Major contributions are made by research institutions beyond their home countries in the development of new vaccines.',
                10 => 'Operational procedures are followed by all staff on every production line to maintain workplace safety standards.',
                11 => 'Academic policies are formulated by the university senate at the central level to improve higher education quality standards.',
                12 => 'Soil samples are taken from various field research locations to be tested for their mineral content periodically.',
                13 => 'The annual budget is allocated transparently by faculty management for the development of digital laboratory infrastructure.',
                14 => 'A new paradigm is introduced in the integrated science curriculum in response to advances in artificial intelligence technology.',
                15 => 'Research conclusions are drawn based on empirical evidence at the end of the report to provide valid recommendations.',
            ],
            3 => [
                1 => 'Carbon emissions are a major factor in the phenomenon of global warming.',
                2 => 'The availability of clean water is a crucial challenge for urban populations.',
                3 => 'Biodiversity is very important for maintaining ecosystem stability.',
                4 => 'Solar panel technology is currently efficient for large-scale use.',
                5 => 'Deforestation is a major cause of the loss of natural habitats in various regions.',
                6 => 'Microplastic particles are harmful to the health of marine biota.',
                7 => 'Energy conservation strategies are effective in reducing the burden of electricity consumption.',
                8 => 'The ozone layer is highly vulnerable to certain chemical pollutants.',
                9 => 'Disaster mitigation is a top priority in regional spatial planning.',
                10 => 'This research data is accurate enough to support the initial proposed hypothesis.',
            ],
            4 => [
                1 => 'Industrial waste is managed professionally to prevent river pollution.',
                2 => 'Cybersecurity is a top priority for major technology companies.',
                3 => 'The central government allocates special funds for the preservation of protected forests.',
                4 => 'The statistical data is quite relevant to current field conditions.',
                5 => 'English is used as the primary communication tool in global forums.',
                6 => 'Modern technology facilitates long-distance communication between individuals.',
                7 => 'Access to quality education is a fundamental right for every citizen.',
                8 => 'The annual report is reviewed by the board of directors at the end of each month.',
                9 => 'Scientists conduct periodic observations of climate change.',
                10 => 'I am very optimistic about the success of this international collaboration.',
                11 => 'The new regulation is implemented simultaneously across all branches.',
                12 => 'The tourism sector makes a major contribution to regional income.',
                13 => 'This research methodology is highly accurate in predicting the market.',
                14 => 'Various types of medicines are produced in the national laboratory.',
                15 => 'The sun emits ultraviolet radiation that affects the atmosphere.',
                16 => 'Economic stability is very crucial for long-term growth.',
                17 => 'This strategic decision is made based on in-depth data analysis.',
                18 => 'This company implements very strict work ethics standards.',
                19 => 'Our cultural diversity is greatly admired by people around the world.',
                20 => 'An advanced AI system processes millions of pieces of information in seconds.',
            ],
            5 => [
                1 => 'The objective of this research is to analyze the impact of urbanization on air quality.',
                2 => 'Scientists need additional data to validate their hypothesis.',
                3 => 'It is very crucial for the government to implement sustainable economic policies.',
                4 => 'This method is used to measure the level of energy efficiency in manufacturing systems.',
                5 => 'The researcher is the first person to identify the link between genetics and sleep patterns.',
                6 => 'It is important for students to cite original sources in order to avoid plagiarism.',
                7 => 'The ethics board decided to reject the experimental proposal due to security risks.',
                8 => 'An effective strategy is to integrate AI technology into the school curriculum.',
                9 => 'The most accurate way to evaluate employee performance is through a 360-degree assessment.',
                10 => 'This chemical is too unstable to be used under room temperature conditions.',
                11 => 'We strive to minimize bias in data sampling.',
                12 => 'Control variables are prepared to ensure that experimental results remain consistent.',
                13 => 'This phenomenon is very difficult to explain without using advanced mathematical models.',
                14 => 'The research team plans to publish their findings in a reputable international journal.',
                15 => 'Educational institutions are obliged to facilitate the development of each learner\'s talents.',
            ],
            6 => [
                1 => 'The researcher isolated the chemical compound from the plant extract last month.',
                2 => 'The cell divided during the final mitosis phase in yesterday\'s observation.',
                3 => 'The exothermic reaction released a large amount of heat energy during the experiment.',
                4 => 'Light was significantly refracted when passing through the prism medium in last week\'s test.',
                5 => 'The forest ecosystem absorbed large amounts of carbon dioxide throughout the last decade.',
                6 => 'The research subject provided valid quantitative data after the interview session ended.',
                7 => 'The simulation model predicted an increase in global temperature at the end of last year.',
                8 => 'The molecule bonded with protein receptors on the cell surface during the incubation process.',
                9 => 'The geologist found a unique sedimentary rock formation at the excavation site last month.',
                10 => 'This project integrated artificial intelligence technology into its operational system a year ago.',
                11 => 'I submitted the project proposal on time yesterday afternoon.',
                12 => 'The organization held an international seminar last year.',
                13 => 'The patient took the medicine according to the dosage recommended by the doctor last night.',
                14 => 'The system experienced technical disruptions for a full two hours.',
                15 => 'The lawyer won the case after a lengthy trial.',
                16 => 'The student studied research methodology in the library last weekend.',
                17 => 'The company completely changed its brand image the previous year.',
                18 => 'The contractor completed the bridge construction before the scheduled deadline.',
                19 => 'I achieved the IELTS score target that I wanted last month.',
                20 => 'The audience gave enthusiastic appreciation after the presentation ended.',
            ],
            7 => [
                1 => 'The audit report was not available on the manager\'s desk when the meeting started this morning.',
                2 => 'The raw survey data were not entered into the system by the research assistant yesterday.',
                3 => 'The argument presented by the debate participant was not logical, so the judges gave a low score.',
                4 => 'Social aid funds were not distributed to residents affected by the disaster last month.',
                5 => 'The machine maintenance procedure was not in accordance with the applicable standard operating procedure (SOP) at that time.',
                6 => 'The board of directors\' decree was not signed by the president director due to data inaccuracies.',
                7 => 'The air quality around the factory was not bad before the gas leak occurred at night.',
                8 => 'The communication signal was not detected by the transmitter tower during the storm two days ago.',
                9 => 'The plan to build a new laboratory was not popular among senior students.',
                10 => 'The research variables were not tightly controlled, so the experimental results became biased.',
                11 => 'The student did not attend the make-up exam session held last week.',
                12 => 'The digital library facilities were not updated by the IT team during the semester break.',
                13 => 'The conclusion in the manuscript was not relevant to the statistical data presented by the author.',
                14 => 'Evidence of contract violations was not found by the legal team during the investigation process.',
                15 => 'The atmosphere in the courtroom was not conducive during the announcement of the land dispute decision.',
            ],
            8 => [
                1 => 'The company did not publish the confidential data openly to the public last year.',
                2 => 'The student did not submit the assignment on time according to yesterday\'s instructions.',
                3 => 'The security system did not detect the intrusion during the incident.',
                4 => 'He did not attend the department\'s weekly coordination meeting this morning.',
                5 => 'We do not support the proposed policy change.',
                6 => 'The main machine did not operate during the repair process last week.',
                7 => 'The government did not increase staple commodity prices this month.',
                8 => 'The temperature sensor did not show significant changes in yesterday\'s experiment.',
                9 => 'The delegates did not sign the memorandum of understanding at the previous meeting.',
                10 => 'This application does not support file formats with very large sizes.',
                11 => 'The research subjects did not give consistent responses to the stimulus.',
                12 => 'The technical team did not overhaul the database architecture entirely in the last project.',
                13 => 'Committee members did not share internal documents with external parties.',
                14 => 'The sun did not shine intensely in the mountainous area throughout yesterday.',
                15 => 'Management did not consider the salary increase proposal this year.',
                16 => 'The panel of experts did not approve the proposed research methodology last month.',
                17 => 'This software does not recognize fingerprints that have not been registered in the system.',
                18 => 'The bank did not provide capital loans without adequate collateral.',
                19 => 'The author did not include a complete bibliography at the end of the journal manuscript.',
                20 => 'The insurance scheme does not cover treatment costs for congenital diseases.',
            ],
            9 => [
                1 => 'The researcher publishes his scientific journal every year.',
                2 => 'They did not attend the international conference in Tokyo last month.',
                3 => 'Does the government provide enough funding for this research?',
                4 => 'This laboratory is equipped with very advanced medical equipment.',
                5 => 'The weather in the mountainous area was very cold yesterday morning.',
                6 => 'The students did not submit their final assignments on time last week.',
                7 => 'Are those reference books available in the campus library?',
                8 => 'The technical team completed the main server repair two days ago.',
                9 => 'This infrastructure project is very important for the country\'s economic growth.',
                10 => 'The company\'s financial report was not audited by an external party last year.',
                11 => 'Why do basic commodity prices always increase every year?',
                12 => 'The national seminar was held in the main university building yesterday.',
                13 => 'The manager\'s decision did not satisfy many employees in the department.',
                14 => 'This new security system is more efficient than the old system.',
                15 => 'Did he approve the budget proposal submitted last week?',
                16 => 'Many animal species lose their natural habitats due to illegal logging.',
                17 => 'The training participants were very enthusiastic during the discussion session yesterday afternoon.',
                18 => 'The new policy was not implemented thoroughly by all branches.',
                19 => 'Scientists often need years to discover a new vaccine.',
                20 => 'When did the CEO announce the company\'s business expansion plan?',
            ],
            10 => [
                1 => 'She published her scientific article in an international journal last month.',
                2 => 'We analyzed the data to understand its impact on the national economy.',
                3 => 'I gave instructions to them before the experiment began yesterday.',
                4 => 'This hypothesis is ours, and we must defend it in the discussion.',
                5 => 'They presented their findings before the board of professors this morning.',
                6 => 'This institution protects its intellectual property rights through strict legal procedures.',
                7 => 'You submitted your final report to him two days ago.',
                8 => 'The success of this project is entirely theirs.',
                9 => 'He invited me to join his research team last year.',
                10 => 'You all must validate your references before writing the conclusion.',
                11 => 'She is my mentor, and I respect her very much.',
                12 => 'We found the artifact and brought it to the central laboratory yesterday.',
                13 => 'The decision regarding the scholarship is hers.',
                14 => 'They did not support our proposal during yesterday\'s coordination meeting.',
                15 => 'I kept a copy of the document because the document is mine.',
            ],
            11 => [
                1 => 'blew, blown|blew blown|blew / blown',
                2 => 'bought, bought|bought bought|bought / bought',
                3 => 'brought, brought|brought brought|brought / brought',
                4 => 'broke, broken|broke broken|broke / broken',
                5 => 'built, built|built built|built / built',
                6 => 'caught, caught|caught caught|caught / caught',
                7 => 'came, come|came come|came / come',
                8 => 'cut, cut|cut cut|cut / cut',
                9 => 'did, done|did done|did / done',
                10 => 'drank, drunk|drank drunk|drank / drunk',
                11 => 'ate, eaten|ate eaten|ate / eaten',
                12 => 'forgot, forgotten|forgot forgotten|forgot / forgotten',
                13 => 'got, got|got gotten|got got|got / got|got / gotten',
                14 => 'gave, given|gave given|gave / given',
                15 => 'heard, heard|heard heard|heard / heard',
                16 => 'kept, kept|kept kept|kept / kept',
                17 => 'knew, known|knew known|knew / known',
                18 => 'learned, learned|learnt, learnt|learned learned|learnt learnt|learned / learned|learnt / learnt',
                19 => 'made, made|made made|made / made',
                20 => 'put, put|put put|put / put',
                21 => 'read, read|read read|read / read',
                22 => 'said, said|said said|said / said',
                23 => 'ran, run|ran run|ran / run',
                24 => 'sang, sung|sang sung|sang / sung',
                25 => 'sat, sat|sat sat|sat / sat',
                26 => 'slept, slept|slept slept|slept / slept',
                27 => 'spoke, spoken|spoke spoken|spoke / spoken',
                28 => 'stood, stood|stood stood|stood / stood',
                29 => 'took, taken|took taken|took / taken',
                30 => 'woke, woken|woke woken|woke / woken',
                31 => 'understood, understood|understood understood|understood / understood',
                32 => 'wrote, written|wrote written|wrote / written',
                33 => 'The research team found anomalies in the statistical data after conducting observations for three months.',
                34 => 'The author wrote the first draft of the journal manuscript in less than one week.',
                35 => 'The delegates left the courtroom after a diplomatic agreement was reached.',
                36 => 'The company chose to carry out organizational restructuring to improve efficiency.',
                37 => 'The government increased the education budget by ten percent in the last fiscal year.',
                38 => 'The student understood the concept of thermodynamics after attending an intensive course.',
                39 => 'We observed a significant increase in public participation during the survey.',
                40 => 'The committee chair delivered a very inspiring opening speech at the international conference.',
                41 => 'The architect built a prototype building model using three-dimensional printing technology.',
                42 => 'The raw data was stored on a highly secure server to prevent information leakage.',
                43 => 'He became the project coordinator because he had extensive experience in risk management.',
                44 => 'The panel of experts identified errors in the research methodology before publication.',
                45 => 'The audit team conducted a thorough examination of the company\'s financial report last week.',
                46 => 'The security system detected suspicious activity within the university\'s computer network.',
                47 => 'This analysis shows that global economic growth has gradually slowed down.',
            ],
            13 => [
                1 => 'Scientists have conducted various experiments to prove the latest theory of gravity.',
                2 => 'Statistical data on economic growth has not yet been collected by the research team.',
                3 => 'The university has become a center of technological innovation for the past two decades.',
                4 => 'The theory of evolution has been discussed in depth in international scientific journals.',
                5 => 'Final-year students have not yet submitted their thesis drafts to their supervisors.',
                6 => 'The higher education curriculum has undergone major changes to adapt to industry needs.',
                7 => 'The laboratory test results have been verified by an independent panel of experts.',
                8 => 'The digital library system has been inactive since the server maintenance last week.',
                9 => 'Many classic book references have been replaced by more up-to-date digital information sources.',
                10 => 'The professor has not yet given semester exam grades to the students.',
                11 => 'The black hole phenomenon has become the main focus of astrophysics research this year.',
                12 => 'Project-based learning methods have been proven effective in enhancing student creativity.',
                13 => 'The budget for medical research has not yet been fully allocated by the relevant ministry.',
                14 => 'The scientific paper has previously been published at a world-class conference.',
                15 => 'The archaeologists have discovered an ancient inscription that explains the history of Mesopotamian civilization.',
            ],
            14 => [
                1 => 'This institution is making efforts to improve data security standards across all its digital platforms.',
                2 => 'The audit team has completed a thorough examination of the third-quarter financial report.',
                3 => 'Scientists found new evidence regarding climate change during last year\'s expedition.',
                4 => 'At present, the board of directors is discussing a market expansion strategy for the Southeast Asian region.',
                5 => 'The government issued new regulations to govern the use of artificial intelligence in the public sector.',
                6 => 'The researcher needs additional time to validate the results of the laboratory experiment.',
                7 => 'We have sent a technical cooperation proposal to strategic partners abroad.',
                8 => 'The security system detected an attempt of illegal intrusion into the main network last night.',
                9 => 'The project manager is monitoring the progress of infrastructure development in real time.',
                10 => 'The company decided to postpone the launch of its new product until market conditions stabilize.',
                11 => 'This statistical analysis shows a positive correlation between work motivation and employee productivity.',
                12 => 'The expert panel has published the latest ethical guidelines for medical practitioners.',
                13 => 'The student failed to submit the thesis draft before the specified deadline.',
                14 => 'Many large companies invested in environmentally friendly technology throughout 2025.',
                15 => 'Airport authorities are tightening document inspection procedures for international passengers.',
                16 => 'She has worked as a senior legal consultant for more than a decade.',
                17 => 'Each department is required to prepare a periodic performance evaluation report.',
                18 => 'The global economic crisis significantly affected people\'s purchasing power in the past decade.',
                19 => 'The technical team is fixing damage in the central satellite communication module.',
                20 => 'This innovation aims to reduce the industry\'s dependence on fossil fuels.',
            ],
            15 => [
                1 => 'The research team must perform data validation periodically.',
                2 => 'This laboratory instrument can detect micro particles in water.',
                3 => 'Every student is required to attend the proposal seminar this semester.',
                4 => 'The sociological theory may be relevant to the current urbanization phenomenon.',
                5 => 'The dean\'s office will issue a decision letter regarding the achievement scholarship.',
                6 => 'The field observation results should show an accurate species distribution pattern.',
                7 => 'The author should include a bibliography in the latest format.',
                8 => 'The control variables must remain stable during the experimental process.',
                9 => 'This scientific discussion could trigger new technological innovations.',
                10 => 'The government will allocate research funds for vaccine development.',
                11 => 'Every journal article must go through the peer-review process.',
                12 => 'The use of renewable energy sources can reduce greenhouse gas emissions.',
                13 => 'The supervising lecturer should provide technical guidance on methodology.',
                14 => 'This statistical analysis will strengthen the main argument in the dissertation.',
                15 => 'Data security protocols must be implemented across all university databases.',
            ],
            17 => [
                1 => 'The professor let the students use calculators during the exam.',
                2 => 'The manager made his assistant rewrite the annual report.',
                3 => 'I heard the board of directors discussing the company merger plan this morning.',
                4 => 'The university asked the experts to review the new curriculum.',
                5 => 'We saw the research team collecting water samples from the contaminated river.',
                6 => 'The parents let their children choose their own educational paths.',
                7 => 'The teacher watched the students doing experimental tasks in the laboratory.',
                8 => 'She made her client sign the cooperation agreement yesterday.',
                9 => 'I felt the building vibrate when the main machine was turned on.',
                10 => 'The supervisor asked the IT staff to fix the server disruption.',
                11 => 'Do not let small errors destroy all the results of this research.',
                12 => 'We heard the project leader announce the cancellation of the coordination meeting.',
                13 => 'The researcher watched the cell divide under the microscope.',
                14 => 'This new policy makes people question the government\'s transparency.',
                15 => 'I saw him submit the confidential document to the authorities.',
            ],
            default => [],
        };
    }

    private function introductoryMeetingParagraph(int $meeting): ?array
    {
        return match ($meeting) {
            3 => [
                'id' => 'Dalam konteks keberlanjutan lingkungan, emisi karbon adalah faktor utama dalam fenomena pemanasan global, sementara ketersediaan air bersih merupakan tantangan krusial bagi populasi urban. Keanekaragaman hayati sangat penting untuk menjaga stabilitas ekosistem, namun deforestasi adalah penyebab utama hilangnya habitat alami di berbagai wilayah. Selain itu, teknologi panel surya saat ini efisien untuk penggunaan skala besar, dan strategi konservasi energi efektif untuk mengurangi beban konsumsi listrik. Di sisi lain, partikel mikroplastik berbahaya bagi kesehatan biota laut, dan lapisan ozon sangat rentan terhadap polutan kimia tertentu. Oleh karena itu, mitigasi bencana adalah prioritas utama dalam perencanaan tata wilayah yang didukung oleh data penelitian yang akurat untuk menguji hipotesis awal yang diajukan.',
                'en' => 'In the context of environmental sustainability, carbon emissions are a major factor in the phenomenon of global warming, while the availability of clean water is a crucial challenge for urban populations. Biodiversity is very important for maintaining ecosystem stability, but deforestation is a major cause of the loss of natural habitats in various regions. In addition, solar panel technology is currently efficient for large-scale use, and energy conservation strategies are effective in reducing the burden of electricity consumption. On the other hand, microplastic particles are harmful to the health of marine biota, and the ozone layer is highly vulnerable to certain chemical pollutants. Therefore, disaster mitigation is a top priority in regional spatial planning, supported by accurate research data to test the initial proposed hypothesis.',
                'vocab' => [
                    'carbon emissions' => ['id' => 'emisi karbon', 'pos' => '(n)'],
                    'clean water availability' => ['id' => 'ketersediaan air bersih', 'pos' => '(n)'],
                    'biodiversity' => ['id' => 'keanekaragaman hayati', 'pos' => '(n)'],
                    'deforestation' => ['id' => 'deforestasi', 'pos' => '(n)'],
                    'disaster mitigation' => ['id' => 'mitigasi bencana', 'pos' => '(n)'],
                ],
            ],
            13 => [
                'id' => 'Energi terbarukan adalah solusi utama untuk mengatasi krisis iklim global yang kian memburuk. Saat ini, banyak negara sedang membangun ladang panel surya berskala besar di area gurun untuk menangkap energi matahari. Teknologi canggih ini dianggap lebih ramah lingkungan dibandingkan dengan pembakaran bahan bakar fosil. Para ilmuwan telah menemukan cara yang lebih efisien untuk menyimpan energi tersebut di dalam baterai raksasa. Sayangnya, biaya operasional untuk perawatan fasilitas ini telah menjadi kendala bagi beberapa negara berkembang. Oleh karena itu, para ahli sedang meneliti metode baru agar harga teknologi hijau tetap terjangkau. Fasilitas penelitian di berbagai universitas sedang ditingkatkan demi mempercepat penemuan material baru yang lebih murah. Sekarang, masyarakat memahami pentingnya beralih ke energi bersih demi kesehatan bumi di masa depan. Upaya besar ini telah memberikan dampak positif bagi penurunan emisi karbon dunia dalam beberapa tahun terakhir.',
                'en' => 'Renewable energy is the main solution to address the increasingly worsening global climate crisis. Currently, many countries are building large-scale solar panel farms in desert areas to capture solar energy. This advanced technology is considered more environmentally friendly compared to burning fossil fuels. Scientists have discovered more efficient ways to store this energy in giant batteries. Unfortunately, the operational costs for maintaining these facilities have become an obstacle for several developing countries. Therefore, experts are researching new methods to keep green technology prices affordable. Research facilities at various universities are being upgraded to accelerate the discovery of newer and cheaper materials. Now, society understands the importance of switching to clean energy for the health of the earth in the future. This great effort has had a positive impact on reducing global carbon emissions in recent years.',
                'vocab' => [
                    'renewable energy' => ['id' => 'energi terbarukan', 'pos' => '(n)'],
                    'solar panel farms' => ['id' => 'ladang panel surya', 'pos' => '(n)'],
                    'fossil fuels' => ['id' => 'bahan bakar fosil', 'pos' => '(n)'],
                    'operational costs' => ['id' => 'biaya operasional', 'pos' => '(n)'],
                    'carbon emissions' => ['id' => 'emisi karbon', 'pos' => '(n)'],
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

        $record = GrammarQuestion::where('meeting_number', $meeting)
            ->where('section', $this->introductoryMeetingParagraphSection($meeting))
            ->orderByDesc('id')
            ->first();

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
            ['topic' => 'Adjective Clause - RPS & RPO'],
            ['topic' => 'Adjective Clause RPP & RA'],
            ['topic' => 'Noun Clause'],
            ['topic' => 'Examination'],
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
            'Abridgement',
            'Omitting',
            'Inversion',
            'Appositives',
            'Adjective & Adverb',
            'Fronting',
            'Clef Sentence',
            'Conditional Sentences',
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

    public function grammarWritingIntroductoryMeetingPromo(\Illuminate\Http\Request $request, int $meeting)
    {
        $testConfig = \Illuminate\Support\Facades\DB::table('meetings')
            ->where('program_id', 4) // Grammar
            ->where('meeting_number', $meeting)
            ->first();

        if (!$testConfig) {
            return redirect()->route('index');
        }

        if (!$testConfig->is_free_tier || 
            ($testConfig->promo_start && \Carbon\Carbon::parse($testConfig->promo_start)->isFuture()) || 
            ($testConfig->promo_deadline && \Carbon\Carbon::parse($testConfig->promo_deadline)->isPast())) {
            return view('promo.expired');
        }

        $response = $this->grammarWritingIntroductoryMeeting($meeting);
        
        if ($response instanceof \Illuminate\View\View) {
            $data = $response->getData();
            $data['testId'] = $testConfig->id;
            return view('promo.grammar', $data);
        }
        
        return $response;
    }

    public function grammarWritingIntroductoryMeetingSubmitPromo(\Illuminate\Http\Request $request, int $meeting)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
        ]);

        $testConfig = \Illuminate\Support\Facades\DB::table('meetings')
            ->where('program_id', 4)
            ->where('meeting_number', $meeting)
            ->first();

        if (!$testConfig) {
            return redirect()->route('index');
        }

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

}
