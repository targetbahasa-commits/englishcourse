<?php

namespace App\Http\Controllers;

use App\Application\IeltsSpeaking\GetIeltsSpeakingTopics;
use App\Application\IeltsSpeaking\GetAllIeltsSpeakingTopics;
use App\Application\IeltsShared\IeltsBatchResolver;
use App\Application\IeltsShared\IeltsTopicPhraseBank;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Application\IeltsSpeaking\IeltsSpeakingFeedbackService;
use App\Application\IeltsSpeaking\SpeakingVocabularyProvider;
use App\Http\Controllers\Concerns\HandlesToeflBatchSelection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IeltsSpeakingController extends Controller
{
    use HandlesAssignmentAccess;
    use HandlesToeflBatchSelection;

    private function attachAudioUrls(array &$topic)
    {
        if (isset($topic['questions']) && is_array($topic['questions'])) {
            $topic['audio_urls'] = array_map(function($q) {
                if (empty(trim($q))) return null;
                $text = trim(preg_replace('/\s+/', ' ', $q));
                return asset('storage/audio/ielts/speaking/' . md5($text) . '.wav');
            }, $topic['questions']);
        }
    }

    public function __construct(
        private readonly GetIeltsSpeakingTopics $getIeltsSpeakingTopics,
        private readonly GetAllIeltsSpeakingTopics $getAllIeltsSpeakingTopics,
        private readonly IeltsBatchResolver $ieltsBatchResolver,
        private readonly IeltsTopicPhraseBank $ieltsTopicPhraseBank,
        private readonly SpeakingVocabularyProvider $speakingVocab,
        private readonly IeltsSpeakingFeedbackService $feedbackService,
    )
    {
        $this->registerAssignmentAccessMiddleware();
    }

    public function practiceIndex()
    {
        return view('assignments.ielts.speaking.practice-index');
    }

    public function practiceIndexPart(int $part)
    {
        if ($part === 1) {
            $topics = $this->getIeltsSpeakingTopics->part1Practice();
            return view('assignments.ielts.speaking.part1', compact('topics'));
        }

        if ($part === 2) {
            $topics = $this->getIeltsSpeakingTopics->part2();
            return view('assignments.ielts.speaking.part2', compact('topics'));
        }

        if ($part === 3) {
            $topics = $this->getIeltsSpeakingTopics->part3();
            return view('assignments.ielts.speaking.part3', compact('topics'));
        }

        return redirect()->route('assignments.ielts-academic.speaking.practice.index')
            ->with('error', 'Invalid speaking part selected');
    }
    
    public function index(Request $request)
    {
        if ($request->has('part')) {
            if ($request->part == 1) {
                $topics = $this->getIeltsSpeakingTopics->part1();
                return view('assignments.ielts.speaking.part1', compact('topics'));
            }

            if ($request->part == 2) {
                $topics = $this->getIeltsSpeakingTopics->part2();
                return view('assignments.ielts.speaking.part2', compact('topics'));
            }

            if ($request->part == 3) {
                $topics = $this->getIeltsSpeakingTopics->part3();
                return view('assignments.ielts.speaking.part3', compact('topics'));
            }
        }

        $lessons = collect($this->getAllIeltsSpeakingTopics->getAllOrdered())
            ->map(function ($topic) {
                return is_object($topic) && method_exists($topic, 'toArray')
                    ? $topic->toArray()
                    : (array) $topic;
            });

        $meetings = collect([]);
    $batchProgram = $this->ieltsBatchResolver->resolveBatchProgramForIelts(Auth::user());
        $selectedClassPeriod = $this->resolveSelectedClassPeriodForProgram($batchProgram);

        return view('assignments.ielts.speaking.index', compact('meetings', 'lessons', 'batchProgram', 'selectedClassPeriod'));
    }

    public function practice(Request $request)
    {
        $slug = $request->query('topic');
        $subtopicSlug = $request->query('subtopic');

        if (false) {
        } else {
            if (str_contains(strtolower($slug), 'lesson')) {
                $dbTopic = $this->getAllIeltsSpeakingTopics->findBySlug($slug);
                if ($dbTopic) {
                    $topic = $dbTopic->toArray();
                    $user = Auth::user();
                    $isAdmin = $user && method_exists($user, 'isAdmin')
                        ? (bool) call_user_func([$user, 'isAdmin'])
                        : false;
                    $isTeacher = $user && method_exists($user, 'isTeacher')
                        ? (bool) call_user_func([$user, 'isTeacher'])
                        : false;
                    $isPrivilegedUser = $isAdmin || $isTeacher;

                    if ($topic['is_locked'] && !$isPrivilegedUser) {
                        return redirect()->route('assignments.ielts-academic.speaking.index')->with('error', 'This topic is currently locked.');
                    }
                } else {
                    $topic = null;
                }
            } else {
                $topicsPart1 = collect($this->getIeltsSpeakingTopics->part1());
                $topicsPart2 = collect($this->getIeltsSpeakingTopics->part2());

                $topic = $topicsPart1->firstWhere('slug', $slug);
                if (!$topic) {
                    $topic = $topicsPart2->firstWhere('slug', $slug);
                    if ($topic) {
                        if ($request->query('part') == 3) {
                            $topic['part'] = 3;
                            if (isset($topic['part3_questions'])) {
                                $topic['questions'] = $topic['part3_questions'];
                            }
                            if (isset($topic['part3_idioms'])) {
                                $topic['idioms'] = $topic['part3_idioms'];
                            }
                            if (isset($topic['part3_collocations'])) {
                                $topic['collocations'] = $topic['part3_collocations'];
                            }
                        } else {
                            $topic['part'] = 2;
                        }
                    }
                }
            }
        }
        if (!$topic) {
            return redirect()->route('assignments.ielts-academic.speaking.index', ['part' => 1])
                ->with('error', 'Topic not found');
        }

        if (isset($topic['subtopics']) && is_array($topic['subtopics'])) {
            if (!$subtopicSlug) {
                return view('assignments.ielts.speaking.topic_selection', compact('topic'));
            }

            $subtopic = collect($topic['subtopics'])->firstWhere('slug', $subtopicSlug);

            if ($subtopic) {
                $topic['parent_title'] = $topic['title'];
                $topic['title'] = $subtopic['title'];
                $topic['questions'] = $subtopic['questions'];

                $idioms = $subtopic['idioms'] ?? [];
                $collocations = $subtopic['collocations'] ?? [];
                $advanced_adjectives = $subtopic['advanced_adjectives'] ?? [];
                $advanced_adverbs = $subtopic['advanced_adverbs'] ?? [];
                $advanced_verbs = $subtopic['advanced_verbs'] ?? [];

                $this->attachAudioUrls($topic);

                \Illuminate\Support\Facades\Log::info('IELTS PRACTICE TOPIC DEBUG:', ['slug' => $slug, 'subtopic' => $subtopicSlug, 'topic_questions' => $topic['questions'] ?? 'NULL']);

                if (isset($topic['part']) && $topic['part'] == 2) {
                    return view('assignments.ielts.speaking.part2_practice', compact('topic', 'idioms', 'collocations', 'advanced_adjectives', 'advanced_adverbs', 'advanced_verbs'));
                }

                return view('assignments.ielts.speaking.practice', compact('topic', 'idioms', 'collocations', 'advanced_adjectives', 'advanced_adverbs', 'advanced_verbs'));
            }
        }

        $idioms = $topic['idioms'] ?? [];
        $collocations = $topic['collocations'] ?? [];
        $advanced_adjectives = $topic['advanced_adjectives'] ?? [];
        $advanced_adverbs = $topic['advanced_adverbs'] ?? [];
        $advanced_verbs = $topic['advanced_verbs'] ?? [];

        $topicSlug = $subtopicSlug ?? $slug;

        if (empty($idioms)) {
            $idioms = $this->ieltsTopicPhraseBank->idiomsFor((string) $topicSlug);
        }
        if (empty($collocations)) {
            $collocations = $this->ieltsTopicPhraseBank->collocationsFor((string) $topicSlug);
        }
        if (empty($advanced_adjectives)) {
            $advanced_adjectives = $this->speakingVocab->getAdvancedAdjectivesForTopic($topicSlug);
        }
        if (empty($advanced_adverbs)) {
            $advanced_adverbs = $this->speakingVocab->getAdvancedAdverbsForTopic($topicSlug);
        }
        if (empty($advanced_verbs)) {
            $advanced_verbs = $this->speakingVocab->getAdvancedVerbsForTopic($topicSlug);
        }

        \Illuminate\Support\Facades\Log::info('IELTS PRACTICE DATA RESOLVED:', [
            'slug' => $slug,
            'has_topic_verbs' => !empty($topic['advanced_verbs']),
            'final_verbs_count' => count($advanced_verbs)
        ]);

        \Illuminate\Support\Facades\Log::info('IELTS PRACTICE FINAL DATA:', [
            'slug' => $slug,
            'idioms_sample' => !empty($idioms) ? $idioms[0]['phrase'] : 'NONE',
            'collocations_sample' => !empty($collocations) ? $collocations[0]['phrase'] : 'NONE',
            'advanced_adjectives_sample' => !empty($advanced_adjectives) ? $advanced_adjectives[0]['phrase'] : 'NONE',
            'advanced_adverbs_sample' => !empty($advanced_adverbs) ? $advanced_adverbs[0]['phrase'] : 'NONE',
            'advanced_verbs_sample' => !empty($advanced_verbs) ? 'PRESENT' : 'NONE'
        ]);

        $this->attachAudioUrls($topic);

        if (isset($topic['part']) && $topic['part'] == 2) {
            return view('assignments.ielts.speaking.part2_practice', compact('topic', 'idioms', 'collocations', 'advanced_adjectives', 'advanced_adverbs', 'advanced_verbs'));
        }

        return view('assignments.ielts.speaking.practice', compact('topic', 'idioms', 'collocations', 'advanced_adjectives', 'advanced_adverbs', 'advanced_verbs'));
    }

    public function grade(Request $request)
    {
        $request->validate([
            'audio_blobs' => 'required',
        ]);

        $audioUrls = [];
        if ($request->hasFile('audio_blobs')) {
            $files = $request->file('audio_blobs');
            $speakingUploadPath = $this->ensureSpeakingUploadDirectory();

            foreach ($files as $index => $file) {
                $filename = 'speaking_' . time() . '_' . $index . '.webm';
                $file->move($speakingUploadPath, $filename);
                $audioUrls[$index] = asset($this->speakingUploadDirectory() . '/' . $filename);
            }
        }

        $submittedTranscripts = $request->input('transcripts', []);

        $transcriptsData = [
            [
                'question' => 'Are you a student or do you have a job?',
                'answer' => $submittedTranscripts[0] ?? '(No answer recorded)',
                'audio_url' => $audioUrls[0] ?? null
            ],
            [
                'question' => 'What do you like most about your studies/job?',
                'answer' => $submittedTranscripts[1] ?? '(No answer recorded)',
                'audio_url' => $audioUrls[1] ?? null
            ],
            [
                'question' => 'Is there anything you dislike about it?',
                'answer' => $submittedTranscripts[2] ?? '(No answer recorded)',
                'audio_url' => $audioUrls[2] ?? null
            ],
            [
                'question' => 'What are your future plans for your career/education?',
                'answer' => $submittedTranscripts[3] ?? '(No answer recorded)',
                'audio_url' => $audioUrls[3] ?? null
            ]
        ];

        $ollama = new OllamaController();
        $aiResult = $ollama->gradeSpeaking($transcriptsData);

        if ($aiResult) {
            $result = $aiResult;
            $result['transcripts'] = $transcriptsData;
        } else {
            $result = [
                'overall_score' => 6.5,
                'categories' => [
                    'fluency_coherence' => [
                        'score' => 6.0,
                        'feedback' => 'Penilaian AI gagal (Offline). Ini adalah nilai estimasi. Cek koneksi server AI Anda.'
                    ],
                    'lexical_resource' => ['score' => 6.5, 'feedback' => '...'],
                    'grammatical_range' => ['score' => 6.5, 'feedback' => '...'],
                    'pronunciation' => ['score' => 6.5, 'feedback' => '...']
                ],
                'general_feedback' => 'Maaf, layanan AI sedang sibuk. Jawaban Anda telah tersimpan namun penilaian detail belum tersedia.',
                'transcripts' => $transcriptsData
            ];
        }

        session(['speaking_evaluation_result' => $result]);

        return response()->json([
            'status' => 'success',
            'redirect_url' => route('assignments.ielts-academic.speaking.evaluation', ['topic' => 'work-or-studies'])
        ]);
    }

    public function evaluation(Request $request)
    {
        $result = session('speaking_evaluation_result');

        if (!$result) {
            return redirect()->route('assignments.ielts-academic.speaking.index', ['part' => 1])->with('error', 'No evaluation results found.');
        }

        $topic = [
            'title' => 'Work or Studies',
            'slug' => 'work-or-studies'
        ];

        return view('assignments.ielts.speaking.evaluation', compact('result', 'topic'));
    }

    public function upgradeLexical(Request $request)
    {
        sleep(1);
        $transcripts = $request->input('transcripts', []);
        $topic = $request->input('topic', 'general');

        $fullText = '';
        foreach ($transcripts as $transcript) {
            $fullText .= strtolower($transcript['answer'] ?? '') . ' ';
        }

        $vocabMap = $this->speakingVocab->getAdvancedVocabForTopic((string) $topic);
        $improvements = [];

        foreach ($vocabMap as $simple => $data) {
            if (str_contains($fullText, " $simple ") || str_contains($fullText, " $simple.") || str_contains($fullText, " $simple,")) {
                $improvements[] = [
                    'original' => $simple,
                    'improved' => $data[0],
                    'explanation' => $data[1]
                ];
            }
        }

        if (empty($improvements)) {
            $count = 0;
            foreach ($vocabMap as $simple => $data) {
                $improvements[] = [
                    'original' => $simple,
                    'improved' => $data[0],
                    'explanation' => '(Saran) ' . $data[1]
                ];
                $count++;
                if ($count >= 5) {
                    break;
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'improvements' => array_slice($improvements, 0, 5)
        ]);
    }

    public function suggestCollocations(Request $request)
    {
        sleep(1);
        $topic = $request->input('topic', 'general');

        $collocationsRaw = $this->ieltsTopicPhraseBank->collocationsFor((string) $topic);
        $idiomsRaw = $this->ieltsTopicPhraseBank->idiomsFor((string) $topic);

        $suggestions = [];

        foreach ($idiomsRaw as $item) {
            $suggestions[] = [
                'term' => $item['phrase'],
                'type' => 'Idiom',
                'definition' => $item['meaning'],
                'example' => $item['example']
            ];
        }

        foreach ($collocationsRaw as $item) {
            $suggestions[] = [
                'term' => $item['phrase'],
                'type' => 'Collocation',
                'definition' => $item['meaning'],
                'example' => $item['example']
            ];
        }

        return response()->json([
            'status' => 'success',
            'collocations' => $suggestions
        ]);
    }

    public function checkGrammar(Request $request)
    {
        sleep(1);

        return response()->json([
            'status' => 'success',
            'errors' => $this->feedbackService->grammarErrors(),
        ]);
    }

    public function upgradeGrammar(Request $request)
    {
        sleep(1);

        $transcripts = $request->input('transcripts', []);
        $topic = $request->input('topic', 'general');

        return response()->json([
            'status' => 'success',
            'upgrades' => $this->feedbackService->grammarUpgrades($transcripts, $topic),
        ]);
    }

    public function modelAnswer(Request $request)
    {
        sleep(1);

        $transcripts = $request->input('transcripts', []);

        return response()->json([
            'status' => 'success',
            'model_answers' => $this->feedbackService->modelAnswers($transcripts),
        ]);
    }

    public function analyzePronunciation(Request $request)
    {
        sleep(1);

        return response()->json([
            'status' => 'success',
            'analysis' => $this->feedbackService->pronunciationAnalysis(),
        ]);
    }

    public function analyzeFluency(Request $request)
    {
        sleep(2);

        return response()->json([
            'status' => 'success',
            'analysis' => $this->feedbackService->fluencyAnalysis(),
        ]);
    }

}