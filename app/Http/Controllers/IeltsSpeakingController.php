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

        $isMockResult = false;
        if ($slug && str_ends_with($slug, '/result')) {
            $isMockResult = true;
            $slug = str_replace('/result', '', $slug);
            $request->query->set('topic', $slug);
        }

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

        if ($isMockResult) {
            $topicId = $topic['id'] ?? 0;
            $partNum = $topic['part'] ?? 1;
            
            $mockFilePart = storage_path('app/mock_eval_' . $topicId . '_part_' . $partNum . '.json');
            $mockFileDefault = storage_path('app/mock_eval_' . $topicId . '.json');
            
            if (file_exists($mockFilePart)) {
                $aiFeedback = json_decode(file_get_contents($mockFilePart), true);
            } elseif (file_exists($mockFileDefault)) {
                $aiFeedback = json_decode(file_get_contents($mockFileDefault), true);
            } else {
                // Fallback to submission 17 if no mock file exists
                $submission = \Illuminate\Support\Facades\DB::table('free_test_submissions')->where('id', 17)->first();
                $aiFeedback = $submission ? json_decode($submission->ai_raw_json_feedback, true) : [];
            }
            
            $type = 'speaking';
            $id = $topic['id'] ?? 0;
            $submission_id = 9999;
            $submission = null;
            $q = is_string($topic['questions']) ? json_decode($topic['questions'], true) : $topic['questions'];
            $prompt = is_array($q) ? implode(' ', $q) : ($topic['questions'] ?? '');
            
            return view('promo.result', compact('type', 'id', 'submission_id', 'submission', 'aiFeedback', 'prompt'));
        }

        if (isset($topic['part']) && $topic['part'] == 2) {
            return view('assignments.ielts.speaking.part2_practice', compact('topic', 'idioms', 'collocations', 'advanced_adjectives', 'advanced_adverbs', 'advanced_verbs'));
        }

        return view('assignments.ielts.speaking.practice', compact('topic', 'idioms', 'collocations', 'advanced_adjectives', 'advanced_adverbs', 'advanced_verbs'));
    }

    public function grade(Request $request)
    {
        set_time_limit(300); // Prevent PHP from timing out during Whisper + API calls
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
        $submittedQuestions = $request->input('questions', []);

        $transcriptsData = [];
        
        foreach ($submittedQuestions as $index => $questionText) {
            $transcriptsData[] = [
                'question' => $questionText,
                'answer' => $submittedTranscripts[$index] ?? '(No answer recorded)',
                'audio_url' => $audioUrls[$index] ?? null
            ];
        }

        $topicSlug = $request->input('topic', 'speaking-practice');
        $part = (int) $request->input('part', 1);
        $topicTitle = $request->input('topic_title', $topicSlug);

        // Check if any valid audio was submitted
        $hasAudio = count(array_filter($audioUrls)) > 0;

        $hasSpeech = false;
        foreach ($submittedTranscripts as $t) {
            if (trim($t) !== '' && trim($t) !== '(No answer recorded)') {
                $hasSpeech = true;
                break;
            }
        }

        if (!$hasAudio || !$hasSpeech) {
            $result = [
                'overall_score' => 0.0,
                'categories' => [
                    'fluency_coherence' => ['score' => 0.0, 'feedback' => 'Anda tidak memberikan jawaban atau rekaman audio kosong.'],
                    'lexical_resource' => ['score' => 0.0, 'feedback' => 'Anda tidak memberikan jawaban atau rekaman audio kosong.'],
                    'grammatical_range' => ['score' => 0.0, 'feedback' => 'Anda tidak memberikan jawaban atau rekaman audio kosong.'],
                    'pronunciation' => ['score' => 0.0, 'feedback' => 'Anda tidak memberikan jawaban atau rekaman audio kosong.']
                ],
                'general_feedback' => 'Tidak ada audio atau jawaban yang terekam. Anda mendapatkan nilai 0 karena tidak ada jawaban yang dapat dievaluasi.',
                'transcripts' => $transcriptsData
            ];

            session([
                'speaking_evaluation_result' => $result,
                'speaking_evaluation_topic_title' => $topicTitle,
                'speaking_evaluation_topic_slug' => $topicSlug,
                'speaking_evaluation_part' => $part,
            ]);

            return response()->json([
                'status' => 'success',
                'redirect_url' => route('assignments.ielts-academic.speaking.evaluation', ['topic' => $topicSlug])
            ]);
        }

        
        $ai = new \App\Http\Controllers\AiController();
        $aiResult = $ai->gradeSpeaking($transcriptsData, $part, $topicTitle);

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

        session([
            'speaking_evaluation_result' => $result,
            'speaking_evaluation_topic_title' => $topicTitle,
            'speaking_evaluation_topic_slug' => $topicSlug,
            'speaking_evaluation_part' => $part,
        ]);

        return response()->json([
            'status' => 'success',
            'redirect_url' => route('assignments.ielts-academic.speaking.evaluation', ['topic' => $topicSlug])
        ]);
    }

    
    public function evaluationPreview(Request $request, $part, $id)
    {
        $bandScore = 0.0;
        
        $mockDetail = [
            [
                'question' => 'Do you currently work or study?',
                'description' => 'Tidak ada jawaban yang terekam.', 
                'kutipan' => '-', 
                'perbaikan' => '-'
            ]
        ];
        
        $dummyResult = [
            'overall_score' => $bandScore,
            'categories' => [
                'fluency_coherence' => [
                    'score' => $bandScore,
                    'feedback' => 'Anda tidak memberikan jawaban atau rekaman audio kosong.',
                    'details' => $mockDetail
                ],
                'lexical_resource' => [
                    'score' => $bandScore,
                    'feedback' => 'Anda tidak memberikan jawaban atau rekaman audio kosong.',
                    'details' => $mockDetail
                ],
                'grammatical_range' => [
                    'score' => $bandScore,
                    'feedback' => 'Anda tidak memberikan jawaban atau rekaman audio kosong.',
                    'details' => $mockDetail
                ],
                'pronunciation' => [
                    'score' => $bandScore,
                    'feedback' => 'Anda tidak memberikan jawaban atau rekaman audio kosong.',
                    'details' => $mockDetail
                ]
            ],
            'general_feedback' => 'Ini adalah submission offline (tanpa rekaman suara asli). Karena tidak ada suara yang direkam, maka Band Score yang diberikan adalah 0. Tambahkan ?b=online di URL untuk melihat simulasi evaluasi AI.',
            'transcripts' => [
                [
                    'question' => 'Do you currently work or study?',
                    'answer' => '(No answer recorded)',
                    'audio_url' => ''
                ]
            ]
        ];

        $topic = [
            'title' => 'Speaking Practice (Admin Preview)',
            'slug' => 'speaking-practice-preview',
            'part' => $part,
            'id' => $id,
        ];

        if ($request->query('b') === 'online') {
            $transcriptsData = [
                [
                    'question' => 'Do you currently work or study?',
                    'answer' => 'I am currently a student at a university in Jakarta. I am studying computer science and I really enjoy programming. It has been a passion of mine since high school.',
                    'audio_url' => ''
                ],
                [
                    'question' => 'Why did you choose that subject?',
                    'answer' => 'I chose it because I have always been fascinated by computers. The ability to create software that can solve real-world problems is very exciting to me, and there are many career opportunities.',
                    'audio_url' => ''
                ]
            ];
            
            $ai = new \App\Http\Controllers\AiController();
            $aiResult = $ai->gradeSpeaking($transcriptsData, $part, $topic['title']);
            
            if ($aiResult) {
                $result = $aiResult;
                $result['transcripts'] = $transcriptsData;
            } else {
                $result = $dummyResult;
                $result['general_feedback'] = 'AI Evaluation failed. Displaying offline dummy data instead.';
            }
        } else {
            $result = $dummyResult;
        }

        return view('assignments.ielts.speaking.evaluation', compact('result', 'topic'));
    }

    public function evaluation(Request $request)
    {
        $result = session('speaking_evaluation_result');

        if (!$result) {
            return redirect()->route('assignments.ielts-academic.speaking.index', ['part' => 1])->with('error', 'No evaluation results found.');
        }

        $topic = [
            'title' => session('speaking_evaluation_topic_title', 'Speaking Practice'),
            'slug' => session('speaking_evaluation_topic_slug', 'speaking-practice'),
            'part' => session('speaking_evaluation_part', 1),
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
                if ($count >= 15) {
                    break;
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'improvements' => array_slice($improvements, 0, 15)
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
        $transcripts = $request->input('transcripts', []);

        $ai = new \App\Http\Controllers\AiController();
        $errors = $ai->checkGrammar($transcripts);

        if (empty($errors)) {
            $errors = $this->feedbackService->grammarErrors();
        }

        return response()->json([
            'status' => 'success',
            'errors' => $errors,
        ]);
    }

    public function upgradeGrammar(Request $request)
    {
        $transcripts = $request->input('transcripts', []);

        $ai = new \App\Http\Controllers\AiController();
        $upgrades = $ai->upgradeGrammar($transcripts);

        if (empty($upgrades)) {
            $upgrades = $this->feedbackService->grammarUpgrades($transcripts, 'general');
        }

        return response()->json([
            'status' => 'success',
            'upgrades' => $upgrades,
        ]);
    }

    public function modelAnswer(Request $request)
    {
        $transcripts = $request->input('transcripts', []);

        $ai = new \App\Http\Controllers\AiController();
        $modelAnswers = $ai->generateModelAnswers($transcripts);

        if (empty($modelAnswers)) {
            $modelAnswers = $this->feedbackService->modelAnswers($transcripts); // Fallback to mock data if AI fails
        }

        return response()->json([
            'status' => 'success',
            'model_answers' => $modelAnswers,
        ]);
    }

    public function analyzePronunciation(Request $request)
    {
        $transcripts = $request->input('transcripts', []);

        $ai = new \App\Http\Controllers\AiController();
        $analysis = $ai->analyzePronunciation($transcripts);

        if (empty($analysis)) {
            $analysis = $this->feedbackService->pronunciationAnalysis();
        }

        return response()->json([
            'status' => 'success',
            'analysis' => $analysis,
        ]);
    }

    public function analyzeFluency(Request $request)
    {
        $transcripts = $request->input('transcripts', []);

        $ai = new \App\Http\Controllers\AiController();
        $analysis = $ai->analyzeFluency($transcripts);

        if (empty($analysis)) {
            $analysis = $this->feedbackService->fluencyAnalysis(); // Fallback to mock data
        }

        return response()->json([
            'status' => 'success',
            'analysis' => $analysis,
        ]);
    }

    private function ensureSpeakingUploadDirectory()
    {
        $path = public_path($this->speakingUploadDirectory());
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        return $path;
    }

    private function speakingUploadDirectory()
    {
        return 'uploads/ielts_speaking';
    }

}