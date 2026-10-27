<?php

namespace App\Http\Controllers;

use App\Models\IeltsWritingMeeting;
use App\Models\SatReadingWritingMeeting;
use App\Models\SatMathMeeting;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SelfStudyClassController extends Controller
{
    /**
     * 'A' (everyday A1-A2-to-B1-B2) or 'B' (B1-C2 advanced), resolved once in
     * player() from the student's self-study grammar placement result and
     * read by getSampleScenarios()/getNetAcadScenarios() for every topic in
     * the curriculum, so it doesn't need threading through buildCurriculum()'s
     * many per-topic calls.
     */
    protected string $selfStudyMode = 'A';

    /**
     * Display a listing of Self-Study Classes.
     */
    public function index(Request $request)
    {
        $task1Count = IeltsWritingMeeting::where('task_type', 1)->count();
        $task2Count = IeltsWritingMeeting::where('task_type', 2)->count();
        
        $satRwCount = class_exists(SatReadingWritingMeeting::class) ? SatReadingWritingMeeting::count() : 0;
        $satMathCount = class_exists(SatMathMeeting::class) ? SatMathMeeting::count() : 0;
        $satTotal = $satRwCount + $satMathCount;

        $selfStudyCards = [
            [
                'id' => 'grammar-for-writing',
                'title' => 'Grammar for Writing',
                'subtitle' => 'Academic & Professional Syntax Mastery (Single Sentence → Polish)',
                'description' => 'Pendalaman struktur tata bahasa Inggris akademik secara sistematis: Single Sentence Foundations → Phrasal Expansion → Clause Subordination → Stylistic Precision.',
                'tag' => 'Grammar & Structure',
                'route' => route('self-study-classes.player', ['course' => 'grammar-for-writing']),
                'icon' => 'document-text',
                'color' => 'blue',
                'gradient' => 'from-blue-500 via-indigo-600 to-indigo-700',
                'accent' => 'text-blue-600',
                'light_bg' => 'bg-blue-50',
                'badge_bg' => 'bg-blue-100 text-blue-800',
                'stats_label' => '27 Topik / 4 Modul',
                'highlights' => ['Foundations to Stylistic Polish', 'Academic & Scientific Syntax', 'Comparative Sentence Drills'],
            ],
            [
                'id' => 'ielts-writing-task-1',
                'title' => 'IELTS Writing Academic Task 1',
                'subtitle' => 'Visual Report Writing (Minimal 150 Kata)',
                'description' => 'Latihan mandiri menganalisis dan mendeskripsikan data visual grafik batang, garis, tabel, diagram proses, serta peta sesuai standar band score IELTS.',
                'tag' => 'Academic Report',
                'route' => route('self-study-classes.player', ['course' => 'ielts-writing-task-1']),
                'icon' => 'chart-bar',
                'color' => 'teal',
                'gradient' => 'from-teal-500 via-emerald-600 to-teal-700',
                'accent' => 'text-teal-600',
                'light_bg' => 'bg-teal-50',
                'badge_bg' => 'bg-teal-100 text-teal-800',
                'stats_label' => $task1Count . ' Latihan Materi',
                'highlights' => ['Line Graph & Bar Chart', 'Tables & Pie Charts', 'Process & Map Comparisons'],
            ],
            [
                'id' => 'ielts-writing-task-2',
                'title' => 'IELTS Writing Academic Task 2',
                'subtitle' => 'Formal Essay Writing (Minimal 250 Kata)',
                'description' => 'Latihan menulis esai argumentatif formal dengan berbagai tipe pertanyaan: Agree/Disagree, Discussion, Problem-Solution, dan Advantage-Disadvantage.',
                'tag' => 'Academic Essay',
                'route' => route('self-study-classes.player', ['course' => 'ielts-writing-task-2']),
                'icon' => 'pencil-alt',
                'color' => 'orange',
                'gradient' => 'from-amber-500 via-orange-600 to-rose-600',
                'accent' => 'text-orange-600',
                'light_bg' => 'bg-orange-50',
                'badge_bg' => 'bg-orange-100 text-orange-800',
                'stats_label' => $task2Count . ' Topik Esai',
                'highlights' => ['Opinion & Discussion Essays', 'Problem & Solution Analysis', 'Automated AI Scoring & Feedback'],
            ],
            [
                'id' => 'sat-prep',
                'title' => 'Digital SAT Preparation',
                'subtitle' => 'Reading & Writing + Math Modules',
                'description' => 'Latihan mandiri persiapan ujian Digital SAT lengkap dengan modul Reading & Writing serta Math dengan sistem evaluasi terstruktur.',
                'tag' => 'College Prep',
                'route' => route('self-study-classes.player', ['course' => 'sat-prep']),
                'icon' => 'academic-cap',
                'color' => 'purple',
                'gradient' => 'from-purple-600 via-indigo-600 to-violet-700',
                'accent' => 'text-purple-600',
                'light_bg' => 'bg-purple-50',
                'badge_bg' => 'bg-purple-100 text-purple-800',
                'stats_label' => ($satTotal > 0 ? $satTotal : 15) . ' Practice Sets',
                'highlights' => ['Reading & Writing Modules', 'Math Practice Sets', 'Interactive Timer & Scoring'],
            ],
        ];

        return view('self-study-class.index', compact('selfStudyCards'));
    }

    /**
     * Display the NetAcad-style LMS course player.
     */
    public function player(Request $request, string $course, $module = null, $topic = null)
    {
        if ($course === 'grammar-for-writing') {
            $modeOverride = auth()->user()?->self_study_grammar_mode_override;

            if ($modeOverride) {
                // Admin-forced mode (see Admin > Mode Self-Study Grammar) skips the
                // placement test entirely - the student goes straight into the course.
                $this->selfStudyMode = $modeOverride;
            } else {
                $packageId = \App\Models\Setting::where('key', 'self_study_grammar_placement_package_id')->value('value');

                $placementResult = $packageId
                    ? \App\Models\GrammarPlacementResult::where('user_id', auth()->id())
                        ->where('grammar_placement_package_id', $packageId)
                        ->latest('id')
                        ->first()
                    : null;

                if (!$placementResult) {
                    return redirect()->route('self-study-classes.placement.show');
                }

                $this->selfStudyMode = app(\App\Application\GrammarPlacement\ResolveSelfStudyGrammarMode::class)
                    ->resolve((float) $placementResult->percentage);
            }
        }

        $curriculum = $this->buildCurriculum($course);

        // Determine active module and topic
        $activeModuleKey = $module ?? array_key_first($curriculum['modules']);
        if (!isset($curriculum['modules'][$activeModuleKey])) {
            $activeModuleKey = array_key_first($curriculum['modules']);
        }

        $activeModule = $curriculum['modules'][$activeModuleKey];
        $activeTopicKey = $topic ?? array_key_first($activeModule['topics']);
        if (!isset($activeModule['topics'][$activeTopicKey])) {
            $activeTopicKey = array_key_first($activeModule['topics']);
        }

        $activeTopic = $activeModule['topics'][$activeTopicKey];

        // Flat list for next / prev navigation
        $flatTopics = [];
        foreach ($curriculum['modules'] as $mKey => $m) {
            foreach ($m['topics'] as $tKey => $t) {
                $flatTopics[] = [
                    'module_key' => $mKey,
                    'topic_key' => $tKey,
                    'title' => $t['title'],
                    'code' => $t['code'] ?? ($m['number'] . '.' . (array_search($tKey, array_keys($m['topics'])) + 1)),
                ];
            }
        }

        $currentIndex = 0;
        foreach ($flatTopics as $idx => $item) {
            if ($item['module_key'] === $activeModuleKey && $item['topic_key'] === $activeTopicKey) {
                $currentIndex = $idx;
                break;
            }
        }

        $prevTopic = $currentIndex > 0 ? $flatTopics[$currentIndex - 1] : null;
        $nextTopic = $currentIndex < count($flatTopics) - 1 ? $flatTopics[$currentIndex + 1] : null;

        // Persisted in the database (not the PHP session) so progress survives
        // session expiry and is available consistently across browsers/devices
        // for the same account, instead of silently reverting to stale/blank
        // content whenever the session lapses.
        $draft = auth()->check()
            ? \App\Models\SelfStudyDraft::where('user_id', auth()->id())
                ->where('course', $course)
                ->where('module', $activeModuleKey)
                ->where('topic', $activeTopicKey)
                ->first()
            : null;
        $draftAnswers = $draft->answers ?? [];
        $draftSubmitted = $draft->submitted ?? [];

        $isAdmin = auth()->check() && (
            (method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin()) ||
            in_array(strtolower(auth()->user()->role ?? ''), ['admin', 'superadmin'])
        );

        $videoPrefix = "self_study_video_{$course}_{$activeModuleKey}_{$activeTopicKey}_";
        $savedVideosRaw = Setting::where('key', 'like', "{$videoPrefix}%")->get();
        $videos = [];
        foreach ($savedVideosRaw as $settingItem) {
            $sublessonKey = substr($settingItem->key, strlen($videoPrefix));
            $decoded = json_decode($settingItem->value, true);
            if ($decoded && is_array($decoded)) {
                $videos[$sublessonKey] = $decoded;
            }
        }

        return view('self-study-class.player', compact(
            'course',
            'curriculum',
            'activeModuleKey',
            'activeModule',
            'activeTopicKey',
            'activeTopic',
            'flatTopics',
            'prevTopic',
            'nextTopic',
            'draftAnswers',
            'draftSubmitted',
            'videos',
            'isAdmin'
        ));
    }

    /**
     * Parse video URL (YouTube, Vimeo, Google Drive, direct MP4) into an embeddable format.
     */
    public static function parseVideoEmbedUrl(?string $url): ?array
    {
        if (empty($url)) {
            return null;
        }

        $url = trim($url);

        // If an iframe tag was pasted, extract src attribute
        if (preg_match('/<iframe.*?src=["\']([^"\']+)["\']/i', $url, $m)) {
            $url = trim($m[1]);
        }

        // 1. YouTube (standard, embed, shorts, youtu.be)
        if (preg_match('/(?:youtube\.com\/(?:watch\?(?:.*&)?v=|embed\/|v\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/i', $url, $matches)) {
            $videoId = $matches[1];

            $startSeconds = 0;
            if (preg_match('/[?&](?:t|start)=([0-9hms]+)/i', $url, $timeMatch)) {
                $rawTime = $timeMatch[1];
                if (is_numeric($rawTime)) {
                    $startSeconds = (int)$rawTime;
                } else {
                    $secs = 0;
                    if (preg_match('/(\d+)h/i', $rawTime, $h)) $secs += (int)$h[1] * 3600;
                    if (preg_match('/(\d+)m/i', $rawTime, $m)) $secs += (int)$m[1] * 60;
                    if (preg_match('/(\d+)s/i', $rawTime, $s)) $secs += (int)$s[1];
                    $startSeconds = $secs;
                }
            }

            $embedUrl = "https://www.youtube-nocookie.com/embed/{$videoId}?rel=0";
            if ($startSeconds > 0) {
                $embedUrl .= "&start={$startSeconds}";
            }

            return [
                'type' => 'youtube',
                'video_id' => $videoId,
                'embed_url' => $embedUrl,
                'original_url' => $url,
            ];
        }

        // 2. Google Drive
        if (preg_match('/drive\.google\.com\/(?:file\/d\/|open\?id=)([a-zA-Z0-9_-]+)/i', $url, $matches)) {
            $fileId = $matches[1];
            return [
                'type' => 'google_drive',
                'video_id' => $fileId,
                'embed_url' => "https://drive.google.com/file/d/{$fileId}/preview",
                'original_url' => $url,
            ];
        }

        // 3. Vimeo
        if (preg_match('/(?:vimeo\.com\/(?:video\/)?|player\.vimeo\.com\/video\/)([0-9]+)/i', $url, $matches)) {
            $vimeoId = $matches[1];
            return [
                'type' => 'vimeo',
                'video_id' => $vimeoId,
                'embed_url' => "https://player.vimeo.com/video/{$vimeoId}?dnt=1",
                'original_url' => $url,
            ];
        }

        // 4. Direct video file (.mp4, .webm, .ogg)
        if (preg_match('/\.(mp4|webm|ogg)($|\?)/i', $url)) {
            return [
                'type' => 'direct',
                'video_id' => null,
                'embed_url' => $url,
                'original_url' => $url,
            ];
        }

        return null;
    }

    /**
     * Save or delete an explanation video attached to a self-study lesson or sublesson.
     */
    public function saveVideo(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        $isAdmin = $user && (
            (method_exists($user, 'isAdmin') && $user->isAdmin()) ||
            in_array(strtolower($user->role ?? ''), ['admin', 'superadmin'])
        );

        if (!$isAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Fitur ini hanya dapat diakses oleh Admin.'
            ], 403);
        }

        $course = $request->input('course', 'grammar-for-writing');
        $module = $request->input('module', 'm1');
        $topic = $request->input('topic', 't1');
        $sublesson = trim($request->input('sublesson', ''));
        $action = $request->input('action', 'save');

        if (empty($sublesson)) {
            return response()->json([
                'success' => false,
                'message' => 'Sub-materi tidak valid.'
            ], 422);
        }

        $key = "self_study_video_{$course}_{$module}_{$topic}_{$sublesson}";
        $existingSetting = Setting::where('key', $key)->first();
        $existingData = $existingSetting ? json_decode($existingSetting->value, true) : null;

        if ($action === 'delete') {
            if ($existingData && !empty($existingData['file_path'])) {
                Storage::disk('public')->delete($existingData['file_path']);
            }
            if ($existingSetting) {
                $existingSetting->delete();
            }
            return response()->json([
                'success' => true,
                'action' => 'delete',
                'sublesson' => $sublesson,
                'message' => 'Video penjelasan berhasil dihapus.',
            ]);
        }

        $title = trim($request->input('title', ''));
        $parsed = null;

        // Check if an uploaded video file was submitted
        if ($request->hasFile('video_file')) {
            $file = $request->file('video_file');

            if (!$file->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Upload file video gagal atau file rusak.'
                ], 422);
            }

            $allowedExtensions = ['mp4', 'webm', 'mov', 'ogg', 'mkv', 'm4v'];
            $ext = strtolower($file->getClientOriginalExtension());
            if (!in_array($ext, $allowedExtensions)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format file tidak didukung. Mohon upload video berformat MP4, WebM, MOV, atau OGG.'
                ], 422);
            }

            // Remove previous local video file if replacing
            if ($existingData && !empty($existingData['file_path'])) {
                Storage::disk('public')->delete($existingData['file_path']);
            }

            $originalBase = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $cleanName = Str::slug($originalBase);
            if (empty($cleanName)) {
                $cleanName = 'video_' . str_replace('.', '_', $sublesson);
            }
            $filename = "{$cleanName}_" . time() . '.' . $ext;

            $storedPath = $file->storeAs('self-study-videos', $filename, 'public');
            $assetUrl = asset('storage/' . $storedPath);

            $parsed = [
                'type' => 'direct',
                'video_id' => null,
                'embed_url' => $assetUrl,
                'original_url' => $assetUrl,
                'file_path' => $storedPath,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
            ];

            if (empty($title)) {
                $title = ucwords(str_replace(['-', '_'], ' ', $originalBase));
            }
        } elseif ($request->filled('url')) {
            $url = trim($request->input('url', ''));
            $parsed = self::parseVideoEmbedUrl($url);
            if (!$parsed) {
                return response()->json([
                    'success' => false,
                    'message' => 'URL video tidak valid atau tidak didukung. Mohon masukkan tautan YouTube, Google Drive, Vimeo, atau tautan file video (.mp4).'
                ], 422);
            }

            // If switching from a local uploaded file to an external URL, delete previous file
            if ($existingData && !empty($existingData['file_path'])) {
                Storage::disk('public')->delete($existingData['file_path']);
            }
        } elseif ($existingData && !empty($existingData['embed_url'])) {
            // Updating metadata (such as title) of an already existing video without re-uploading
            $parsed = $existingData;
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Mohon pilih file video untuk diunggah atau masukkan tautan URL video.'
            ], 422);
        }

        $parsed['title'] = $title;
        $parsed['updated_at'] = now()->toIso8601String();
        $parsed['updated_by'] = $user->name ?? $user->email ?? 'Admin';

        Setting::updateOrCreate(
            ['key' => $key],
            [
                'value' => json_encode($parsed),
                'type' => 'json',
            ]
        );

        return response()->json([
            'success' => true,
            'action' => 'save',
            'sublesson' => $sublesson,
            'video' => $parsed,
            'message' => 'Video penjelasan materi berhasil disimpan.',
        ]);
    }

    /**
     * Save in-progress answers and submitted states for the course player (Autosave).
     */
    public function saveDraft(Request $request): \Illuminate\Http\JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $course = $request->input('course', 'grammar-for-writing');
        $module = $request->input('module', 'm1');
        $topic = $request->input('topic', 't1');
        $answers = $request->input('answers', []);
        $submitted = $request->input('submitted', []);

        \App\Models\SelfStudyDraft::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'course' => $course,
                'module' => $module,
                'topic' => $topic,
            ],
            [
                'answers' => is_array($answers) ? $answers : [],
                'submitted' => is_array($submitted) ? $submitted : [],
            ]
        );

        return response()->json(['success' => true]);
    }

    /**
     * Grade a student's free-text translation against the official model answer
     * using an LLM, instead of a brittle exact/substring string match. This lets
     * grammatically-correct paraphrases and synonyms (e.g. "rural areas" vs the
     * key's "rural regions") be accepted instead of being marked "Kurang Tepat".
     */
    public function gradeTranslation(Request $request): \Illuminate\Http\JsonResponse
    {
        $source = trim((string) $request->input('source', ''));
        $userAnswer = trim((string) $request->input('user_answer', ''));
        $modelAnswer = trim((string) $request->input('model_answer', ''));

        if ($source === '' || $userAnswer === '' || $modelAnswer === '') {
            return response()->json(['correct' => null, 'feedback' => null]);
        }

        $systemPrompt = <<<PROMPT
Anda adalah penilai otomatis untuk latihan menerjemahkan kalimat Bahasa Indonesia ke Bahasa Inggris akademik formal.

Tugas Anda: nilai apakah JAWABAN SISWA adalah terjemahan yang dapat diterima dari KALIMAT SUMBER, dengan JAWABAN MODEL sebagai referensi (bukan satu-satunya jawaban yang sah).

Anggap jawaban siswa BENAR jika:
- Maknanya setara dengan kalimat sumber dan jawaban model, walau memakai sinonim, struktur kalimat, atau urutan kata yang berbeda dari jawaban model.
- Tata bahasanya benar (subject-verb agreement, tenses, preposisi, bentuk/kelas kata yang sesuai).
- Register-nya tetap akademik/formal.

Anggap jawaban siswa SALAH jika:
- Mengubah, menghilangkan, atau menambah makna penting dari kalimat sumber.
- Terdapat kesalahan tata bahasa Inggris.
- Kelas kata (part of speech) yang diuji digunakan secara keliru.

Balas HANYA dengan JSON valid persis seperti ini, tanpa teks lain:
{"correct": true, "feedback": "penjelasan singkat dalam Bahasa Indonesia (maksimal 1 kalimat) kenapa jawaban diterima atau ditolak"}
PROMPT;

        $userContent = "Kalimat sumber (Indonesia): \"{$source}\"\n"
            . "Jawaban model resmi: \"{$modelAnswer}\"\n"
            . "Jawaban siswa: \"{$userAnswer}\"\n\n"
            . "Nilai jawaban siswa sesuai instruksi di atas.";

        try {
            $result = \App\Services\MultiProviderAiClient::chatJson(
                ['groq', 'sambanova', 'siliconflow', 'cerebras', 'deepinfra', 'gemini', 'openrouter', 'openai'],
                $systemPrompt,
                $userContent,
                [
                    'groq_feature' => 'general',
                    'max_tokens' => 300,
                    'temperature' => 0.2,
                ]
            );
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('gradeTranslation AI call failed: ' . $e->getMessage());
            $result = null;
        }

        if (!$result || !array_key_exists('correct', $result)) {
            // AI unavailable: let the client keep its own (stricter) string-match verdict
            // rather than silently failing the student.
            return response()->json(['correct' => null, 'feedback' => null]);
        }

        return response()->json([
            'correct' => (bool) $result['correct'],
            'feedback' => is_string($result['feedback'] ?? null) ? $result['feedback'] : null,
        ]);
    }

    /**
     * Build structured curriculum data for the player.
     */
    protected function buildCurriculum(string $course): array
    {
        switch ($course) {
            case 'grammar-for-writing':
                return [
                    'course_id' => 'grammar-for-writing',
                    'title' => 'Grammar for Writing',
                    'subtitle' => 'Program latihan tatabahasa berfokuskan pembinaan ayat bahasa Inggeris dari peringkat asas sehingga mahir untuk penulisan esei, tugasan akademik, TOEFL, dan IELTS.',
                    'badge' => 'Academic & Professional Syntax Mastery',
                    'modules' => [
                        'm1' => [
                            'number' => '1',
                            'title' => 'Modul 1: Introductory Grammar Foundations',
                            'objective' => 'Membina ayat tunggal yang betul, menguasai keselarasan subjek dan kata kerja (Subject-Verb Agreement), membezakan bentuk ayat verbal, nominal, dan pasif, serta menguasai seluruh ragam tenses dasar penulisan.',
                            'progress' => 100,
                            'topics' => [
                                't1' => [
                                    'code' => '1.1',
                                    'title' => 'Parts of Speech & Sentence Basics',
                                    'status' => 'completed',
                                    'questions_count' => '80',
                                    'scenarios' => $this->getSampleScenarios('grammar-1', 'Parts of Speech & Sentence Basics', [
                                        'theory' => 'Pengenalan kelas kata utama: Noun, Verb, Adjective, Adverb, Preposition; Struktur asas ayat: Subjek + Kata Kerja + Objek / Pelengkap (S + V + O/C); Mengenal pasti inti subjek dan kata kerja bagi mengelak ayat tergantung (sentence fragments).',
                                        'writing_application' => 'Mengenal pasti inti klausa dan mengeliminasi fragmen kalimat dalam penulisan ilmiah.',
                                        'drill_specs' => '8 sub-lessons (80 progressive translation & identification drills).',
                                    ]),
                                ],
                                't2' => [
                                    'code' => '1.2',
                                    'title' => 'Simple Present Tense: Verbal Sentences',
                                    'status' => 'completed',
                                    'questions_count' => '80',
                                    'scenarios' => $this->getSampleScenarios('grammar-2', 'Simple Present Tense: Verbal Sentences', [
                                        'theory' => 'Pola ayat kata kerja aktif (Base Form / V1 vs -s/-es); Peraturan Subject-Verb Agreement untuk subjek tunggal dan jamak; Penggunaan Present Tense untuk fakta umum, definisi, dan hujah asas.',
                                        'writing_application' => 'Membina premis fakta umum dan hujah asas tanpa kesalahan persetujuan subjek-kata kerja.',
                                        'drill_specs' => '8 sub-lessons (80 active verbal translation and conjugation drills).',
                                    ]),
                                ],
                                't3' => [
                                    'code' => '1.3',
                                    'title' => 'Simple Present: Nominal, Passive, & Verbal vs Nominal vs Passive',
                                    'status' => 'completed',
                                    'questions_count' => '80',
                                    'scenarios' => $this->getSampleScenarios('grammar-3', 'Simple Present: Nominal, Passive, & Verbal vs Nominal vs Passive', [
                                        'theory' => 'Pola ayat nominal: Subject + am/is/are + Complement (Noun/Adjective/Prepositional Phrase); Pola ayat pasif: Subject + am/is/are + Verb 3 (Past Participle); Perbandingan sintaksis membezakan verbal, nominal, dan pasif bagi mengelakkan kesalahan struktur lazim (This data is show / The report is explain).',
                                        'writing_application' => 'Membezakan penggunaan bentuk verbal, nominal, dan pasif secara tepat.',
                                        'drill_specs' => '8 sub-lessons (80 progressive comparative translation drills).',
                                    ]),
                                ],
                                't4' => [
                                    'code' => '1.4',
                                    'title' => 'Simple Present: Negative & Questions',
                                    'status' => 'completed',
                                    'questions_count' => '80',
                                    'scenarios' => $this->getSampleScenarios('grammar-m1-t4', 'Simple Present: Negative & Questions', [
                                        'theory' => 'Pembentukan ayat negatif menggunakan do/does not + V1 dan am/is/are + not; Menyusun soalan Yes/No dan soalan WH- dengan susunan kata kerja bantu yang tepat.',
                                        'writing_application' => 'Menyatakan penyangkalan hipotesis dan memformulasi soalan kajian ilmiah.',
                                        'drill_specs' => '8 sub-lessons (80 progressive negative & question translation drills).',
                                    ]),
                                ],
                                't5' => [
                                    'code' => '1.5',
                                    'title' => 'Prepositional Phrase (101)',
                                    'status' => 'completed',
                                    'questions_count' => '80',
                                    'scenarios' => $this->getSampleScenarios('grammar-m1-t5', 'Prepositional Phrase (101)', [
                                        'theory' => 'Pola asas: Kata sendi nama + Kata nama (in, on, at, by, with, for, under, through); Menambah keterangan masa, tempat, dan cara di hujung ayat secara tepat.',
                                        'writing_application' => 'Menetapkan parameter eksperimen dan perincian konteks pada klausa dasar.',
                                        'drill_specs' => '8 sub-lessons (80 progressive prepositional phrase translation drills).',
                                    ]),
                                ],
                                't6' => [
                                    'code' => '1.6',
                                    'title' => 'Verbals: To-Infinitive & Gerund (101)',
                                    'status' => 'completed',
                                    'questions_count' => '80',
                                    'scenarios' => $this->getSampleScenarios('grammar-m1-t6', 'Verbals: To-Infinitive & Gerund (101)', [
                                        'theory' => 'Pola kata kerja yang diikuti to-infinitive (want to, decide to, attempt to); Pola kata kerja yang diikuti gerund / V-ing (avoid doing, suggest making, consider using); Infinitif tujuan dan preposisi + gerund.',
                                        'writing_application' => 'Menerangkan tujuan kajian dan kaedah prosedur tanpa menimbulkan predikat berganda.',
                                        'drill_specs' => '8 sub-lessons (80 progressive infinitive & gerund translation drills).',
                                    ]),
                                ],
                                't7' => [
                                    'code' => '1.7',
                                    'title' => 'Modal Auxiliaries',
                                    'status' => 'completed',
                                    'questions_count' => '80',
                                    'scenarios' => $this->getSampleScenarios('grammar-m1-t7', 'Modal Auxiliaries', [
                                        'theory' => 'Penggunaan kata kerja bantu modal: can, could, must, should, will, may, might; Menggunakan modal untuk menyatakan keupayaan, cadangan, kewajipan, dan tahap kepastian (hedging).',
                                        'writing_application' => 'Mengawal darjah kepastian hujah ilmiah untuk mengekalkan objektiviti penulisan.',
                                        'drill_specs' => '8 sub-lessons (80 progressive modal auxiliary translation drills).',
                                    ]),
                                ],
                                't8' => [
                                    'code' => '1.8',
                                    'title' => 'Simple Past Tense (Verbal, Nominal, Passive)',
                                    'status' => 'completed',
                                    'questions_count' => '80',
                                    'scenarios' => $this->getSampleScenarios('grammar-m1-t8', 'Simple Past Tense (Verbal, Nominal, Passive)', [
                                        'theory' => 'Pola kalimat lampau aktif (V2 regular & irregular); Pola kalimat nominal lampau (was/were + Complement); Pola kalimat pasif lampau (was/were + V3); Pelaporan metodologi dan peristiwa eksperimen yang telah selesai.',
                                        'writing_application' => 'Menulis laporan metodologi eksperimen, tinjauan riwayat studi, dan deskripsi data lampau.',
                                        'drill_specs' => '8 sub-lessons (80 progressive past tense translation drills).',
                                    ]),
                                ],
                                't9' => [
                                    'code' => '1.9',
                                    'title' => 'Present Continuous Tense (Verbal & Passive)',
                                    'status' => 'completed',
                                    'questions_count' => '80',
                                    'scenarios' => $this->getSampleScenarios('grammar-m1-t9', 'Present Continuous Tense (Verbal & Passive)', [
                                        'theory' => 'Pola aktif kontemporer (am/is/are + V-ing); Pola pasif proses sedang berlangsung (am/is/are + being + V3); Melaporkan pergeseran tren data dan fenomena yang sedang berkembang; Kontras situasi temporer vs permanen; Pengecualian stative verbs.',
                                        'writing_application' => 'Melaporkan tren pergeseran data kontemporer, proses operasional pasif yang sedang berjalan, dan fenomena dinamis yang sedang berlangsung.',
                                        'drill_specs' => '8 sub-lessons (80 progressive present continuous active and passive trend drills).',
                                    ]),
                                ],
                                't10' => [
                                    'code' => '1.10',
                                    'title' => 'Present Perfect Tense (Verbal, Nominal, Passive)',
                                    'status' => 'completed',
                                    'questions_count' => '80',
                                    'scenarios' => $this->getSampleScenarios('grammar-m1-t10', 'Present Perfect Tense (Verbal, Nominal, Passive)', [
                                        'theory' => 'Pola aktif (have/has + V3); Pola nominal (have/has been + Complement); Pola pasif (have/has been + V3); Penanda durasi (since, for, over the past years); Kontras waktu definitif vs relevansi masa kini; Perumusan celah riset (research gaps).',
                                        'writing_application' => 'Menjembatani tinjauan pustaka (Literature Review), mendokumentasikan pencapaian terkini riset, dan merumuskan celah penelitian ilmiah.',
                                        'drill_specs' => '8 sub-lessons (80 progressive present perfect verbal, nominal, passive, and literature review drills).',
                                    ]),
                                ],
                                't11' => [
                                    'code' => '1.11',
                                    'title' => 'Simple Future Tense (Will & Be Going To: Verbal, Nominal, Passive)',
                                    'status' => 'completed',
                                    'questions_count' => '80',
                                    'scenarios' => $this->getSampleScenarios('grammar-m1-t11', 'Simple Future Tense (Will & Be Going To: Verbal, Nominal, Passive)', [
                                        'theory' => 'Pola aktif (will + V1 / be going to + V1); Pola nominal (will be + Complement); Pola pasif (will be + V3); Proyeksi masa depan, prediksi berbasis bukti empiris, dan aturan ketat klausa waktu (No Future in Time Clauses).',
                                        'writing_application' => 'Merumuskan proyeksi dampak, rekomendasi riset masa depan, rencana metodologi, dan implikasi kebijakan jangka panjang.',
                                        'drill_specs' => '8 sub-lessons (80 progressive simple future verbal, nominal, passive, and time clause drills).',
                                    ]),
                                ],
                                't12' => [
                                    'code' => '1.12',
                                    'title' => 'Past Continuous & Past Perfect Tenses (Timeline Sequencing)',
                                    'status' => 'completed',
                                    'questions_count' => '80',
                                    'scenarios' => $this->getSampleScenarios('grammar-m1-t12', 'Past Continuous & Past Perfect Tenses (Timeline Sequencing)', [
                                        'theory' => 'Past Continuous (was/were + V-ing) untuk aksi simultan lampau; Past Continuous Pasif (was/were being + V3); Past Perfect (had + V3 / had been + V3) untuk peristiwa pendahulu (antecedent events); Past Perfect Continuous (had been + V-ing); Penghubung waktu linimasa (by the time, prior to, once, when, while).',
                                        'writing_application' => 'Mengatur kronologi peristiwa, latar belakang urutan waktu eksperimen, aksi simultan masa lampau, dan peristiwa pendahulu tanpa kerancuan linimasa dalam laporan penelitian.',
                                        'drill_specs' => '8 sub-lessons (80 progressive past continuous, past perfect, and timeline sequencing drills).',
                                    ]),
                                ],
                            ],
                        ],
                        'm2' => [
                            'number' => '2',
                            'title' => 'Modul 2: Fast Track Structural Grammar',
                            'objective' => 'Mengembangkan maklumat dalam ayat tunggal melalui frasa tambahan, menggabungkan ayat majmuk setara (compound sentences), dan membina perbandingan data.',
                            'progress' => 100,
                            'topics' => [
                                't1' => [
                                    'code' => '2.1',
                                    'title' => 'Tenses Cross-Reference & Translation Drills',
                                    'status' => 'completed',
                                    'questions_count' => '80',
                                    'scenarios' => $this->getSampleScenarios('grammar-m2-t1', 'Tenses Cross-Reference & Translation Drills', [
                                        'theory' => 'Koordinasi tenses lintas struktur dan wacana: General Truths vs Specific Empirical Findings; Literature Review Synthesis (Present Perfect vs Simple Past); Procedural Chronology (Past Passive vs Continuous Passive); Results Presentation (Simple Present untuk visual displays vs Simple Past untuk data); Discussion & Hedged Claims; Conclusion & Future Outlook; Cross-Clausal Harmony; dan Sintesis Perenggan Multi-Tenses.',
                                        'writing_application' => 'Mengekalkan konsistensi kronologi dan transisi tenses yang logis dalam perenggan akademik, laporan metodologi, tinjauan pustaka, dan kesimpulan esai.',
                                        'drill_specs' => '8 sub-lessons (80 progressive tense cross-reference and academic discourse translation drills).',
                                    ]),
                                ],
                                't2' => [
                                    'code' => '2.2',
                                    'title' => 'Prepositional Phrase (102)',
                                    'status' => 'completed',
                                    'questions_count' => '80',
                                    'scenarios' => $this->getSampleScenarios('grammar-m2-t2', 'Prepositional Phrase (102)', [
                                        'theory' => 'Arsitektur frasa preposisi tingkat lanjut: Compound Prepositions of Scope (in terms of, with regard to, with respect to); Evidential & Methodological Attribution (according to, on the basis of, in accordance with); Causality & Contingency (as a result of, on account of, by virtue of, in view of); Purpose & Agency (for the purpose of + V-ing, by means of, on behalf of); Concession & Contrast (notwithstanding, contrary to, regardless of); Addition & Substitution (in addition to + V-ing, in lieu of); Prepositional Fronting, Locative Inversion, dan tanda baca koma presisi.',
                                        'writing_application' => 'Membangun pembuka kalimat (fronting) yang bervariasi, memadatkan argumen sebab-akibat dan atribusi tanpa subordinasi berbelit, serta menguasai inversi lokasi dalam wacana akademik.',
                                        'drill_specs' => '8 sub-lessons (80 progressive complex prepositional phrase and syntactic fronting drills).',
                                    ]),
                                ],
                                't3' => [
                                    'code' => '2.3',
                                    'title' => 'Gerund & To-Infinitive (102)',
                                    'status' => 'completed',
                                    'questions_count' => '80',
                                    'scenarios' => $this->getSampleScenarios('grammar-m2-t3', 'Gerund & To-Infinitive (102)', [
                                        'theory' => 'Konstruksi verbal akademik tingkat lanjut: Gerund sebagai subjek abstrak (Subject Nominalization) dengan singular agreement; Pelaku gerund berkasus posesif formal (the ministry\'s implementing); Passive Gerunds (being + V3) & Perfect Gerunds (having + V3); Passive Infinitives (to be + V3) & Perfect Infinitives (to have + V3); Variasi Dummy \'It\' vs Gerund Subject; Kolokasi khusus preposisi \'to\' + Gerund (committed to, key to, with a view to); serta Eliminasi Dangling Modifiers.',
                                        'writing_application' => 'Menyatakan prosedur abstrak sebagai subjek kalimat secara impersonal, menyelaraskan agen logis pada frasa pembuka, dan menguasai komplementasi verbal pasif serta perfek dalam naskah ilmiah.',
                                        'drill_specs' => '8 sub-lessons (80 progressive advanced gerund, infinitive, and verbal complementation drills).',
                                    ]),
                                ],
                                't4' => [
                                    'code' => '2.4',
                                    'title' => 'Noun Phrase',
                                    'status' => 'completed',
                                    'questions_count' => '80',
                                    'scenarios' => $this->getSampleScenarios('grammar-m2-t4', 'Noun Phrase', [
                                        'theory' => 'Arsitektur frasa nomina akademik tingkat lanjut: Urutan pre-modifiers (OSASCOMP); Noun Adjuncts berkategori tunggal (data collection, resource allocation); Post-modifiers frasa preposisi berlapis dengan keselarasan subjek sejati (True Head Noun Agreement); Reduksi partisipial aktif (V-ing) dan pasif (V3); Komplemen to-infinitive pada nomina abstrak; Presisi tanda koma aposisi (appositives); serta Heavy Subject Nominalization untuk publikasi ilmiah.',
                                        'writing_application' => 'Memadatkan informasi secara leksikal (lexical density), menghilangkan kata ganti subjektif melalui nominalisasi tindakan, dan menyusun subjek dan objek kalimat kompleks secara presisi dalam naskah ilmiah.',
                                        'drill_specs' => '8 sub-lessons (80 progressive academic noun phrase, modifier hierarchy, participial reduction, and nominal density drills).',
                                    ]),
                                ],
                                't5' => [
                                    'code' => '2.5',
                                    'title' => 'Coordinating Conjunctions (FANBOYS) & Compound Sentences',
                                    'status' => 'completed',
                                    'questions_count' => '80',
                                    'scenarios' => $this->getSampleScenarios('grammar-m2-t5', 'Coordinating Conjunctions (FANBOYS) & Compound Sentences', [
                                        'theory' => 'Penggabungan klausa independen dengan 7 kata hubung koordinatif FANBOYS (For, And, Nor, But, Or, Yet, So); Aturan tanda koma wajib sebelum koordinasi klausa independen; Inversi subjek-auxiliary wajib setelah kata hubung negatif \'Nor\'; Kontras langsung \'But\' vs paradoks \'Yet\'; Kausalitas \'For\' (alasan formal) dan \'So\' (konsekuensi); Eliminasi kesalahan fatal Comma Splice dan Run-on Sentences; Integrasi titik koma (semicolon) dan conjunctive adverbs (; however, / ; therefore,); serta kesimetrisan paralelisme sintaksis.',
                                        'writing_application' => 'Membangun kalimat majmuk setara yang kompleks dan seimbang, menghindari comma splices dalam esai akademik, dan memperkaya jangkauan sintaksis (syntactic variety) dalam naskah ilmiah.',
                                        'drill_specs' => '8 sub-lessons (80 progressive coordinate clauses, FANBOYS architecture, nor inversion, comma splice elimination, and transitional adverb drills).',
                                    ]),
                                ],
                                't6' => [
                                    'code' => '2.6',
                                    'title' => 'Comparison (Degree of Comparison)',
                                    'status' => 'completed',
                                    'questions_count' => '80',
                                    'scenarios' => $this->getSampleScenarios('grammar-m2-t6', 'Comparison (Degree of Comparison)', [
                                        'theory' => 'Seluruh spektrum perbandingan: Positive Degree (as... as), Comparative (-er/more than), Superlative (the most), Double Degree (The more..., the more...), Multiple Comparison (twice as... as), Modifiers in Comparison (significantly higher), dan Quantifier Comparison (fewer vs less).',
                                        'writing_application' => 'Melaporkan perbandingan tren data dan analisis statistik (IELTS Writing Task 1).',
                                        'drill_specs' => '8 sub-lessons (80 progressive comparison and data reporting translation drills).',
                                    ]),
                                ],
                            ],
                        ],
                        'm3' => [
                            'number' => '3',
                            'title' => 'Modul 3: Complexity in Academic Writing',
                            'objective' => 'Menyusun ayat majmuk bertingkat (complex sentences) dengan menghubungkan klausa utama dan klausa bergantung (subordinate clauses) secara tersusun.',
                            'progress' => 0,
                            'topics' => [
                                't1' => [
                                    'code' => '3.1',
                                    'title' => 'Adverbial Clause',
                                    'status' => 'pending',
                                    'questions_count' => '10',
                                    'scenarios' => $this->getSampleScenarios('grammar-m3-t1', 'Adverbial Clause', [
                                        'theory' => 'Klausa sebab dan akibat (because, since, as); Klausa pertentangan dan konsesi (although, even though, while, whereas); Klausa syarat dan masa (if, unless, when, before, after); Perbezaan kata hubung klausa (because, although) dengan frasa sendi nama (because of, despite).',
                                        'writing_application' => 'Membina hujah bersyarat, sebab-akibat, dan konsesi secara berstruktur.',
                                        'drill_specs' => '10 adverbial clause subordination drills.',
                                    ]),
                                ],
                                't2' => [
                                    'code' => '3.2',
                                    'title' => 'Adjective Clause (Relative Clause)',
                                    'status' => 'pending',
                                    'questions_count' => '10',
                                    'scenarios' => $this->getSampleScenarios('grammar-m3-t2', 'Adjective Clause (Relative Clause)', [
                                        'theory' => 'Penggunaan kata ganti relatif: who, whom, which, that, whose, where; Perbezaan klausa yang memerlukan tanda koma (non-defining) dan tanpa koma (defining); Menghuraikan istilah teknikal atau subjek ayat secara langsung tanpa memecahkan ayat.',
                                        'writing_application' => 'Menjelaskan terminologi khusus tanpa memecah kesinambungan ayat utama.',
                                        'drill_specs' => '10 relative clause embedding drills.',
                                    ]),
                                ],
                                't3' => [
                                    'code' => '3.3',
                                    'title' => 'Noun Clause',
                                    'status' => 'pending',
                                    'questions_count' => '10',
                                    'scenarios' => $this->getSampleScenarios('grammar-m3-t3', 'Noun Clause', [
                                        'theory' => 'Klausa kata nama bermula dengan perkataan that selepas kata kerja penyataan (shows that, suggests that, believes that); Klausa kata nama berasaskan perkataan soal (what, how, whether, why) sebagai subjek atau objek ayat; Pola subjek pengenalan umum: It is clear that... / It is important that....',
                                        'writing_application' => 'Memaparkan pandangan pakar dan merumuskan kesimpulan analisis secara formal.',
                                        'drill_specs' => '10 reporting verb and noun clause drills.',
                                    ]),
                                ],
                                't4' => [
                                    'code' => '3.4',
                                    'title' => 'Complex Sentence Synthesizing & Diagnostic Test',
                                    'status' => 'pending',
                                    'questions_count' => '20',
                                    'scenarios' => $this->getSampleScenarios('grammar-m3-t4', 'Complex Sentence Synthesizing & Diagnostic Test', [
                                        'theory' => 'Teknik menyusun dan menggabungkan beberapa klausa pendek menjadi satu ayat panjang yang gramatis dan terkawal; Ujian diagnostik dan semakan kefahaman struktur klausa subordinat.',
                                        'writing_application' => 'Menggabungkan beberapa klausa menjadi ayat akademik yang kukuh tanpa fragmentasi.',
                                        'drill_specs' => '20 complex sentence synthesis and diagnostic items.',
                                    ]),
                                ],
                            ],
                        ],
                        'm4' => [
                            'number' => '4',
                            'title' => 'Modul 4: Proficiency & Stylistic Precision',
                            'objective' => 'Memperkemas gaya penulisan agar lebih padat (concise), matang, dan bervariasi dengan meringkaskan klausa serta menggunakan susunan ayat lanjutan.',
                            'progress' => 0,
                            'topics' => [
                                't1' => [
                                    'code' => '4.1',
                                    'title' => 'Peringkasan Ayat (Abridgement & Omitting)',
                                    'status' => 'pending',
                                    'questions_count' => '10',
                                    'scenarios' => $this->getSampleScenarios('grammar-m4-t1', 'Peringkasan Ayat (Abridgement & Omitting)', [
                                        'theory' => 'Meringkaskan Adjective Clause menjadi frasa berimbuhan aktif (-ing) atau pasif (-ed); Meringkaskan Adverbial Clause masa dan sebab untuk mengurangkan pengulangan perkataan yang meleret.',
                                        'writing_application' => 'Menghapuskan lewah kata (wordiness) dalam abstrak dan ringkasan eksekutif.',
                                        'drill_specs' => '10 clause reduction & participle drills.',
                                    ]),
                                ],
                                't2' => [
                                    'code' => '4.2',
                                    'title' => 'Inversion (Susunan Ayat Terbalik)',
                                    'status' => 'pending',
                                    'questions_count' => '10',
                                    'scenarios' => $this->getSampleScenarios('grammar-m4-t2', 'Inversion (Susunan Ayat Terbalik)', [
                                        'theory' => 'Membalikkan kedudukan subjek dan kata kerja bantu selepas ungkapan negatif atau terhad di hadapan ayat (Not only... but also, Rarely, Seldom, Under no circumstances); Memberi penegasan gaya penulisan formal (rhetorical emphasis).',
                                        'writing_application' => 'Menambah penekanan retorikal formal pada hasil penemuan utama.',
                                        'drill_specs' => '10 negative inversion drills.',
                                    ]),
                                ],
                                't3' => [
                                    'code' => '4.3',
                                    'title' => 'Appositives & Hyphen in Noun Phrase',
                                    'status' => 'pending',
                                    'questions_count' => '10',
                                    'scenarios' => $this->getSampleScenarios('grammar-m4-t3', 'Appositives & Hyphen in Noun Phrase', [
                                        'theory' => 'Menggunakan frasa penerang kata nama di antara dua tanda koma (Appositives); Penggunaan tanda sempang (hyphen) untuk kata sifat majmuk di hadapan kata nama (contoh: well-known method, full-time student).',
                                        'writing_application' => 'Menyisipkan definisi terminologi secara ringkas ke dalam kedudukan subjek.',
                                        'drill_specs' => '10 appositive and compound modifier drills.',
                                    ]),
                                ],
                                't4' => [
                                    'code' => '4.4',
                                    'title' => 'Fronting & Cleft Sentences',
                                    'status' => 'pending',
                                    'questions_count' => '10',
                                    'scenarios' => $this->getSampleScenarios('grammar-m4-t4', 'Fronting & Cleft Sentences', [
                                        'theory' => 'Menukar kedudukan elemen ayat ke hadapan (Fronting) untuk memfokuskan maklumat penting; Membina ayat penekanan: It is/was... that... dan What... is/was....',
                                        'writing_application' => 'Mengarahkan fokus pembaca pada variabel utama atau hujah paling penting.',
                                        'drill_specs' => '10 cleft sentence and fronting drills.',
                                    ]),
                                ],
                                't5' => [
                                    'code' => '4.5',
                                    'title' => 'Advanced Conditionals & Subjunctive Mood',
                                    'status' => 'pending',
                                    'questions_count' => '10',
                                    'scenarios' => $this->getSampleScenarios('grammar-m4-t5', 'Advanced Conditionals & Subjunctive Mood', [
                                        'theory' => 'Ayat pengandaian tanpa if menggunakan susunan songsang (Were it not for..., Had we known...); Bentuk cadangan dan ketetapan formal (Subjunctive: demand that, recommend that [base verb]).',
                                        'writing_application' => 'Merumuskan senario andaian lanjutan dan ketetapan cadangan formal.',
                                        'drill_specs' => '10 inverted conditional and subjunctive drills.',
                                    ]),
                                ],
                                't6' => [
                                    'code' => '4.6',
                                    'title' => 'Advanced Conjunctions & Object Complements',
                                    'status' => 'pending',
                                    'questions_count' => '10',
                                    'scenarios' => $this->getSampleScenarios('grammar-m4-t6', 'Advanced Conjunctions & Object Complements', [
                                        'theory' => 'Penggunaan kata kerja bersama pelengkap objek (make something possible, consider the result valid); Penggunaan kata hubung lanjutan dalam penulisan formal (insofar as, albeit, notwithstanding).',
                                        'writing_application' => 'Menyatakan penilaian canggih dengan penggunaan kata yang padat.',
                                        'drill_specs' => '10 object complement and advanced conjunction drills.',
                                    ]),
                                ],
                                't7' => [
                                    'code' => '4.7',
                                    'title' => 'Final Writing Review & Comprehensive Assessment',
                                    'status' => 'pending',
                                    'questions_count' => '20',
                                    'scenarios' => $this->getSampleScenarios('grammar-m4-t7', 'Final Writing Review & Comprehensive Assessment', [
                                        'theory' => 'Semakan menyeluruh dan aplikasi praktikal seluruh struktur ayat dalam penghasilan teks esei penuh atau ringkasan akademik.',
                                        'writing_application' => 'Aplikasi bersepadu seluruh kemahiran tatabahasa dalam penulisan akademik lengkap.',
                                        'drill_specs' => 'Capstone: Comprehensive writing assessment.',
                                    ]),
                                ],
                            ],
                        ],
                    ],
                ];

            case 'ielts-writing-task-1':
                return [
                    'course_id' => 'ielts-writing-task-1',
                    'title' => 'IELTS Writing Academic Task 1',
                    'subtitle' => 'Data Synthesis, Trend Analysis & Visual Report Mastery',
                    'badge' => 'Band 7.0 - 9.0 Strategy',
                    'modules' => [
                        'm1' => [
                            'number' => '1',
                            'title' => 'Module 1: Dynamic Data & Trend Description',
                            'progress' => 100,
                            'topics' => [
                                't1' => [
                                    'code' => '1.1',
                                    'title' => 'Line Graphs: Describing Fluctuation, Plateau & Surges',
                                    'status' => 'completed',
                                    'questions_count' => '6',
                                    'scenarios' => $this->getNetAcadScenarios('Line Graph Trend Synthesis'),
                                ],
                                't2' => [
                                    'code' => '1.2',
                                    'title' => 'Bar Charts over Time: Comparative Chronology',
                                    'status' => 'completed',
                                    'questions_count' => '5',
                                    'scenarios' => $this->getSampleScenarios('ielts-t1-bar'),
                                ],
                            ],
                        ],
                        'm2' => [
                            'number' => '2',
                            'title' => 'Module 2: Static Comparison & Proportions',
                            'progress' => 80,
                            'topics' => [
                                't1' => [
                                    'code' => '2.1',
                                    'title' => 'Pie Charts & Sector Breakdown Strategy',
                                    'status' => 'completed',
                                    'questions_count' => '5',
                                    'scenarios' => $this->getSampleScenarios('ielts-t1-pie'),
                                ],
                                't2' => [
                                    'code' => '2.2',
                                    'title' => 'Complex Tables: Grouping Key Figures into Paragraphs',
                                    'status' => 'active',
                                    'questions_count' => '7',
                                    'scenarios' => $this->getNetAcadScenarios('Table Data Prioritisation'),
                                ],
                            ],
                        ],
                        'm3' => [
                            'number' => '3',
                            'title' => 'Module 3: Process Diagrams & Maps',
                            'progress' => 30,
                            'topics' => [
                                't1' => [
                                    'code' => '3.1',
                                    'title' => 'Natural & Man-Made Process Diagrams',
                                    'status' => 'pending',
                                    'questions_count' => '6',
                                    'scenarios' => $this->getSampleScenarios('ielts-t1-process'),
                                ],
                                't2' => [
                                    'code' => '3.2',
                                    'title' => 'Urban Redevelopment & Map Comparison',
                                    'status' => 'pending',
                                    'questions_count' => '6',
                                    'scenarios' => $this->getSampleScenarios('ielts-t1-map'),
                                ],
                            ],
                        ],
                    ],
                ];

            case 'ielts-writing-task-2':
                return [
                    'course_id' => 'ielts-writing-task-2',
                    'title' => 'IELTS Writing Academic Task 2',
                    'subtitle' => 'Coherent Argumentation & High-Band Essay Structure',
                    'badge' => 'Band 7.0 - 9.0 Strategy',
                    'modules' => [
                        'm1' => [
                            'number' => '1',
                            'title' => 'Module 1: Opinion & Agree/Disagree Essays',
                            'progress' => 100,
                            'topics' => [
                                't1' => [
                                    'code' => '1.1',
                                    'title' => 'Thesis Statements & One-Sided vs Balanced Positions',
                                    'status' => 'completed',
                                    'questions_count' => '5',
                                    'scenarios' => $this->getNetAcadScenarios('Agree/Disagree Thesis Design'),
                                ],
                                't2' => [
                                    'code' => '1.2',
                                    'title' => 'Topic Sentences and Counter-Argument Refutation',
                                    'status' => 'completed',
                                    'questions_count' => '6',
                                    'scenarios' => $this->getSampleScenarios('ielts-t2-counter'),
                                ],
                            ],
                        ],
                        'm2' => [
                            'number' => '2',
                            'title' => 'Module 2: Discussion Essays (Discuss Both Views)',
                            'progress' => 60,
                            'topics' => [
                                't1' => [
                                    'code' => '2.1',
                                    'title' => 'Objective Exposition of View A vs View B',
                                    'status' => 'active',
                                    'questions_count' => '6',
                                    'scenarios' => $this->getNetAcadScenarios('Discussion Essay Objectivity'),
                                ],
                                't2' => [
                                    'code' => '2.2',
                                    'title' => 'Integrating Writer Stance Across All Paragraphs',
                                    'status' => 'pending',
                                    'questions_count' => '5',
                                    'scenarios' => $this->getSampleScenarios('ielts-t2-stance'),
                                ],
                            ],
                        ],
                        'm3' => [
                            'number' => '3',
                            'title' => 'Module 3: Problem, Cause & Solution Essays',
                            'progress' => 20,
                            'topics' => [
                                't1' => [
                                    'code' => '3.1',
                                    'title' => 'Root Cause Analysis & Concrete Interventions',
                                    'status' => 'pending',
                                    'questions_count' => '6',
                                    'scenarios' => $this->getSampleScenarios('ielts-t2-problem'),
                                ],
                            ],
                        ],
                    ],
                ];

            case 'sat-prep':
            default:
                return [
                    'course_id' => 'sat-prep',
                    'title' => 'Digital SAT Preparation',
                    'subtitle' => 'Reading, Writing & Math Adaptive Test Practice',
                    'badge' => 'College Board Prep',
                    'modules' => [
                        'm1' => [
                            'number' => '1',
                            'title' => 'Module 1: Reading & Writing - Craft & Structure',
                            'progress' => 100,
                            'topics' => [
                                't1' => [
                                    'code' => '1.1',
                                    'title' => 'Words in Context: Precise Vocabulary in Academic Passages',
                                    'status' => 'completed',
                                    'questions_count' => '8',
                                    'scenarios' => $this->getNetAcadScenarios('SAT Vocabulary in Context'),
                                ],
                                't2' => [
                                    'code' => '1.2',
                                    'title' => 'Text Structure & Cross-Text Connections',
                                    'status' => 'completed',
                                    'questions_count' => '6',
                                    'scenarios' => $this->getSampleScenarios('sat-structure'),
                                ],
                            ],
                        ],
                        'm2' => [
                            'number' => '2',
                            'title' => 'Module 2: Standard English Conventions',
                            'progress' => 75,
                            'topics' => [
                                't1' => [
                                    'code' => '2.1',
                                    'title' => 'Boundaries: Commas, Semicolons & Dashes in Complex Sentences',
                                    'status' => 'active',
                                    'questions_count' => '7',
                                    'scenarios' => $this->getNetAcadScenarios('SAT Punctuation Boundaries'),
                                ],
                                't2' => [
                                    'code' => '2.2',
                                    'title' => 'Form, Structure, and Sense: Modifier Placement',
                                    'status' => 'pending',
                                    'questions_count' => '6',
                                    'scenarios' => $this->getSampleScenarios('sat-modifiers'),
                                ],
                            ],
                        ],
                        'm3' => [
                            'number' => '3',
                            'title' => 'Module 3: Math - Algebra & Advanced Mathematics',
                            'progress' => 40,
                            'topics' => [
                                't1' => [
                                    'code' => '3.1',
                                    'title' => 'Linear Equations, Systems & Inequalities',
                                    'status' => 'pending',
                                    'questions_count' => '8',
                                    'scenarios' => $this->getSampleScenarios('sat-linear'),
                                ],
                                't2' => [
                                    'code' => '3.2',
                                    'title' => 'Nonlinear Functions, Quadratics & Exponentials',
                                    'status' => 'pending',
                                    'questions_count' => '8',
                                    'scenarios' => $this->getSampleScenarios('sat-nonlinear'),
                                ],
                            ],
                        ],
                    ],
                ];
        }
    }

    /**
     * Provide realistic scenarios and study guides modeled on NetAcad learning modules.
     */
    protected function getNetAcadScenarios(string $topicTitle): array
    {
        return app(\App\Services\SelfStudyContentService::class)->getTopicPackage($topicTitle, $topicTitle, [], $this->selfStudyMode);
    }

    /**
     * Get scenario exercises and study guides for topics.
     */
    protected function getSampleScenarios(string $seed, string $topicTitle = '', array $meta = []): array
    {
        return app(\App\Services\SelfStudyContentService::class)->getTopicPackage($seed, $topicTitle, $meta, $this->selfStudyMode);
    }
}
