<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IeltsWritingMeeting;
use App\Models\IeltsSpeakingTopic;
use App\Models\ToeflListeningMeeting;
use App\Models\ToeflStructureMeeting;
use App\Models\ToeflReadingMeeting;

class AdminPromoTestController extends Controller
{
    public function previewWriting()
    {
        $submission = \Illuminate\Support\Facades\DB::table('free_test_submissions')->where('test_type', 'like', 'writing%')->latest('id')->first();
        if (!$submission) return back()->with('error', 'Belum ada submission Writing untuk dipreview.');
        $test_id = $submission->test_id ?? 1;
        return redirect()->route('promo.test.result', ['type' => $submission->test_type, 'id' => $test_id, 'submission_id' => $submission->id]);
    }

    public function previewSpeaking(\Illuminate\Http\Request $request)
    {
        $submission = \Illuminate\Support\Facades\DB::table('free_test_submissions')->where('test_type', 'like', 'speaking%')->latest('id')->first();
        if (!$submission) return back()->with('error', 'Belum ada submission Speaking untuk dipreview.');
        $test_id = $submission->test_id ?? 1;
        return redirect()->route('promo.test.result', ['type' => $submission->test_type, 'id' => $test_id, 'submission_id' => $submission->id] + $request->query());
    }

    public function previewToefl()
    {
        $result = \Illuminate\Support\Facades\DB::table('free_test_results')->latest('id')->first();
        if (!$result) return back()->with('error', 'Belum ada hasil evaluasi TOEFL untuk dipreview.');
        return redirect()->route('free-test.result', ['id' => $result->id]);
    }

    public function index()
    {
        $writingTests = IeltsWritingMeeting::where('category', 'practice')->where('title', 'NOT LIKE', '%General%')->orderBy('id', 'desc')->get();
        $writingGeneralTests = IeltsWritingMeeting::where('category', 'practice')->where('title', 'LIKE', '%General%')->orderBy('id', 'desc')->get();
        $speakingTests = IeltsSpeakingTopic::where('title', 'NOT LIKE', '%lesson%')->where('slug', 'NOT LIKE', '%lesson%')->orderBy('id', 'desc')->get();
        
        $toeflCondition = function($q) {
            $q->where('meeting_number', '>', 50)
              ->orWhere('title', 'LIKE', '%Paket%')
              ->orWhere('title', 'LIKE', '%Test%')
              ->orWhere('title', 'LIKE', '%Practice%')
              ->orWhere('title', 'LIKE', '%Mockup%');
        };

        $toeflListening = ToeflListeningMeeting::where($toeflCondition)->orderBy('id', 'desc')->get()->map(function($i){ $i->toefl_type = 'listening'; return $i; });
        $toeflStructure = ToeflStructureMeeting::where($toeflCondition)->orderBy('id', 'desc')->get()->map(function($i){ $i->toefl_type = 'structure'; return $i; });
        $toeflReading = ToeflReadingMeeting::where($toeflCondition)->orderBy('id', 'desc')->get()->map(function($i){ $i->toefl_type = 'reading'; return $i; });

        $listeningProgram = \App\Models\Program::where('slug', 'ielts-academic-listening')->first();
        $listeningTests = $listeningProgram ? \App\Models\Meeting::where('program_id', $listeningProgram->id)->orderBy('meeting_number')->get() : collect();

        $readingGeneralProgram = \App\Models\Program::where('slug', 'ielts-general')->first();
        $readingGeneralTests = $readingGeneralProgram ? \App\Models\Meeting::where('program_id', $readingGeneralProgram->id)->orderBy('meeting_number')->get() : collect();

        $readingAcademicProgram = \App\Models\Program::where('slug', 'ielts-academic-reading')->first();
        $readingAcademicTests = $readingAcademicProgram ? \App\Models\Meeting::where('program_id', $readingAcademicProgram->id)->orderBy('meeting_number')->get() : collect();

        $grammarPrograms = \App\Models\Program::where('slug', 'like', '%grammar%')->get();
        $grammarTests = \App\Models\Meeting::whereIn('program_id', $grammarPrograms->pluck('id'))->orderBy('program_id')->orderBy('meeting_number')->get();

        $grammarPracticeTopics = \App\Models\GrammarTopic::withCount('questions')->orderBy('order')->get();

        $pteSpeakingWritingTypes = array_map(function($item) {
            $item['slug'] = 'speaking_writing_' . $item['id'];
            $item['count'] = count($item['questions']);
            $item['category'] = 'speaking_writing';
            $item['route'] = route('promo.test.pte.speaking-writing.show', ['id' => $item['id']]);
            return $item;
        }, config('pte_promo_tests.speaking_writing', []));

        $pteReadingTypes = array_map(function($item) {
            $item['slug'] = 'reading_' . $item['id'];
            $item['count'] = count($item['questions']);
            $item['category'] = 'reading';
            $item['route'] = route('promo.test.pte.reading.show', ['id' => $item['id']]);
            return $item;
        }, config('pte_promo_tests.reading', []));

        $pteListeningTypes = array_map(function($item) {
            $item['slug'] = 'listening_' . $item['id'];
            $item['count'] = count($item['questions']);
            $item['category'] = 'listening';
            $item['route'] = route('promo.test.pte.listening.show', ['id' => $item['id']]);
            return $item;
        }, config('pte_promo_tests.listening', []));

        return view('admin.promo-tests.index', compact(
            'writingTests', 'writingGeneralTests', 'speakingTests',
            'toeflListening', 'toeflStructure', 'toeflReading',
            'listeningTests', 'readingGeneralTests', 'readingAcademicTests', 'grammarTests', 'grammarPracticeTopics',
            'pteSpeakingWritingTypes', 'pteReadingTypes', 'pteListeningTypes'
        ));
    }

    public function updateWriting(Request $request, $id)
    {
        $meeting = IeltsWritingMeeting::findOrFail($id);
        
        $meeting->update([
            'title' => $request->title ?: $meeting->title,
            'prompt' => $request->prompt ?: $meeting->prompt,
            'is_free_tier' => $request->has('is_free_tier'),
            'test_type' => $request->test_type,
            'system_prompt_override' => $request->system_prompt_override,
            'graph_data_json' => $request->graph_data_json,
            'promo_start' => $request->promo_start,
            'promo_deadline' => $request->promo_deadline,
        ]);

        return back()->with('success', 'Promo settings for Writing Test updated successfully.');
    }

    public function storeWriting(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'prompt' => 'required|string',
            'test_type' => 'required|string'
        ]);

        $maxMeetingNumber = IeltsWritingMeeting::max('meeting_number') ?? 0;

        IeltsWritingMeeting::create([
            'title' => $request->title,
            'prompt' => $request->prompt,
            'test_type' => $request->test_type,
            'task_type' => str_contains($request->test_type, 't2') ? 2 : 1,
            'category' => 'practice',
            'meeting_number' => $maxMeetingNumber + 1,
            'is_free_tier' => $request->has('is_free_tier'),
        ]);

        return back()->with('success', 'New Writing Test created successfully.');
    }

    public function destroyWriting($id)
    {
        IeltsWritingMeeting::findOrFail($id)->delete();
        return back()->with('success', 'Writing Test deleted successfully.');
    }

    public function updateSpeaking(Request $request, $id)
    {
        $topic = IeltsSpeakingTopic::findOrFail($id);
        
        $topic->update([
            'title' => $request->title ?: $topic->title,
            'questions' => $request->questions ?: $topic->questions,
            'is_free_tier' => $request->has('is_free_tier'),
            'test_type' => $request->test_type,
            'system_prompt_override' => $request->system_prompt_override,
            'promo_start' => $request->promo_start,
            'promo_deadline' => $request->promo_deadline,
        ]);

        return back()->with('success', 'Promo settings for Speaking Topic updated successfully.');
    }

    public function renderSpeaking($id)
    {
        $scriptPath = base_path('storage/app/scripts/batch_prerender_unified.py');
        $logPath = storage_path('logs/prerender.log');
        // Run in background using exec
        $command = "python3 " . escapeshellarg($scriptPath) . " " . escapeshellarg($id) . " >> " . escapeshellarg($logPath) . " 2>&1 &";
        exec($command);

        return back()->with('success', 'Rendering started in the background. It will take ~5-10 minutes. Please check the website later.');
    }

    public function updateColab(Request $request)
    {
        $request->validate(['colab_url' => 'nullable|url']);
        $path = base_path('.env');
        
        if (file_exists($path)) {
            $url = $request->colab_url ? rtrim($request->colab_url, '/') : '';
            $env = file_get_contents($path);
            
            if (str_contains($env, 'SADTALKER_API_URL=')) {
                $env = preg_replace('/^SADTALKER_API_URL=.*$/m', 'SADTALKER_API_URL=' . $url, $env);
            } else {
                $env .= "\nSADTALKER_API_URL=" . $url . "\n";
            }
            file_put_contents($path, $env);
        }

        return back()->with('success', 'Colab API Link updated successfully!');
    }

    public function updatePteTestSettings(Request $request, $category, $id)
    {
        $request->validate([
            'promo_start' => 'nullable|date',
            'promo_deadline' => 'nullable|date',
        ]);

        if (!in_array($category, ['speaking_writing', 'reading', 'listening'], true)) {
            abort(404);
        }

        $configPath = config_path('pte_promo_tests.php');
        $config = require $configPath;

        $found = false;
        foreach ($config[$category] as &$item) {
            if ((string) $item['id'] === (string) $id) {
                $item['is_free_tier'] = $request->has('is_free_tier');
                $item['promo_start'] = $request->input('promo_start') ?: null;
                $item['promo_deadline'] = $request->input('promo_deadline') ?: null;
                $found = true;
                break;
            }
        }
        unset($item);

        if (!$found) {
            return back()->with('error', 'PTE promo test not found.');
        }

        file_put_contents($configPath, "<?php\n\nreturn " . var_export($config, true) . ";\n");

        return back()->with('success', 'Promo settings for PTE test updated successfully.');
    }

    public function storePteSpeakingWriting(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'read_aloud_text' => 'required|string',
            'read_aloud_prep' => 'nullable|integer|min:1',
            'read_aloud_record' => 'nullable|integer|min:1',
            'repeat_sentence_text' => 'required|string',
            'describe_image_title' => 'required|string|max:255',
            'describe_image_image' => 'required|string|max:500',
            'describe_image_type' => 'nullable|string|max:50',
            'describe_image_prep' => 'nullable|integer|min:1',
            'describe_image_record' => 'nullable|integer|min:1',
            'retell_lecture_title' => 'required|string|max:255',
            'retell_lecture_transcript' => 'required|string',
            'retell_lecture_prep' => 'nullable|integer|min:1',
            'retell_lecture_record' => 'nullable|integer|min:1',
            'summarize_written_text_passage' => 'required|string',
            'summarize_written_text_word_limit' => 'nullable|string|max:50',
            'summarize_written_text_time_limit' => 'nullable|integer|min:1',
            'write_essay_topic' => 'required|string',
            'write_essay_word_limit' => 'nullable|string|max:50',
            'write_essay_time_limit' => 'nullable|integer|min:1',
        ]);

        $entry = [
            'title' => $validated['title'],
            'type' => 'pte_speaking_writing',
            'is_free_tier' => $request->has('is_free_tier'),
            'promo_start' => null,
            'promo_deadline' => null,
            'questions' => [
                'read_aloud' => [
                    'text' => $validated['read_aloud_text'],
                    'prep_time' => (int) ($validated['read_aloud_prep'] ?? 35),
                    'record_time' => (int) ($validated['read_aloud_record'] ?? 40),
                ],
                'repeat_sentence' => [
                    'text' => $validated['repeat_sentence_text'],
                    'audio' => null,
                ],
                'describe_image' => [
                    'title' => $validated['describe_image_title'],
                    'image' => $validated['describe_image_image'],
                    'type' => ($validated['describe_image_type'] ?? null) ?: 'chart',
                    'prep_time' => (int) ($validated['describe_image_prep'] ?? 25),
                    'record_time' => (int) ($validated['describe_image_record'] ?? 40),
                ],
                'retell_lecture' => [
                    'title' => $validated['retell_lecture_title'],
                    'transcript' => $validated['retell_lecture_transcript'],
                    'prep_time' => (int) ($validated['retell_lecture_prep'] ?? 10),
                    'record_time' => (int) ($validated['retell_lecture_record'] ?? 40),
                ],
                'summarize_written_text' => [
                    'passage' => $validated['summarize_written_text_passage'],
                    'word_limit' => ($validated['summarize_written_text_word_limit'] ?? null) ?: '5-75 words',
                    'time_limit' => (int) ($validated['summarize_written_text_time_limit'] ?? 600),
                ],
                'write_essay' => [
                    'topic' => $validated['write_essay_topic'],
                    'word_limit' => ($validated['write_essay_word_limit'] ?? null) ?: '200-300 words',
                    'time_limit' => (int) ($validated['write_essay_time_limit'] ?? 1200),
                ],
            ],
        ];

        $this->appendPteTest('speaking_writing', $entry);

        return back()->with('success', 'New PTE Speaking & Writing promo test created successfully.');
    }

    public function storePteReading(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'rw_fib_passage' => 'required|string',
            'rw_fib_options' => 'required|string',
            'reorder_paragraphs' => 'required|string',
            'reading_fib_passage' => 'required|string',
            'reading_fib_distractors' => 'nullable|string',
        ]);

        $rwOptions = array_values(array_filter(array_map(function ($line) {
            return array_values(array_filter(array_map('trim', explode(',', $line))));
        }, preg_split('/\r\n|\r|\n/', trim($validated['rw_fib_options'])))));

        $paragraphs = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', trim($validated['reorder_paragraphs'])))));
        $correctOrder = range(0, count($paragraphs) - 1);
        $shuffledIndexes = $correctOrder;
        shuffle($shuffledIndexes);
        $shuffledParagraphs = array_map(fn ($i) => $paragraphs[$i], $shuffledIndexes);
        $correctOrderInShuffled = array_map(fn ($originalIndex) => array_search($originalIndex, $shuffledIndexes), $correctOrder);

        preg_match_all('/\[(.*?)\]/', $validated['reading_fib_passage'], $matches);
        $correctFibWords = $matches[1] ?? [];
        $distractors = array_values(array_filter(array_map('trim', explode(',', $validated['reading_fib_distractors'] ?? ''))));
        $dragWords = array_values(array_unique(array_merge($correctFibWords, $distractors)));
        shuffle($dragWords);

        $entry = [
            'title' => $validated['title'],
            'type' => 'pte_reading',
            'is_free_tier' => $request->has('is_free_tier'),
            'promo_start' => null,
            'promo_deadline' => null,
            'questions' => [
                'rw_fib' => [
                    'passage' => $validated['rw_fib_passage'],
                    'options' => $rwOptions,
                ],
                'reorder' => [
                    'paragraphs' => $shuffledParagraphs,
                    'correct_order' => $correctOrderInShuffled,
                ],
                'reading_fib' => [
                    'passage' => $validated['reading_fib_passage'],
                    'drag_words' => $dragWords,
                ],
            ],
        ];

        $this->appendPteTest('reading', $entry);

        return back()->with('success', 'New PTE Reading promo test created successfully.');
    }

    public function storePteListening(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'sst_transcript' => 'required|string',
            'sst_prompt' => 'nullable|string|max:255',
            'sst_word_limit' => 'nullable|string|max:50',
            'sst_time_limit' => 'nullable|integer|min:1',
            'wfd_sentences' => 'required|string',
        ]);

        $sentences = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', trim($validated['wfd_sentences'])))));

        $entry = [
            'title' => $validated['title'],
            'type' => 'pte_listening',
            'is_free_tier' => $request->has('is_free_tier'),
            'promo_start' => null,
            'promo_deadline' => null,
            'questions' => [
                'sst' => [
                    'transcript' => $validated['sst_transcript'],
                    'prompt' => ($validated['sst_prompt'] ?? null) ?: 'Summarize the spoken text in 50-70 words.',
                    'word_limit' => ($validated['sst_word_limit'] ?? null) ?: '50-70 words',
                    'time_limit' => (int) ($validated['sst_time_limit'] ?? 600),
                ],
                'wfd' => [
                    'sentences' => $sentences,
                ],
            ],
        ];

        $this->appendPteTest('listening', $entry);

        return back()->with('success', 'New PTE Listening promo test created successfully.');
    }

    private function appendPteTest(string $category, array $entry): void
    {
        $configPath = config_path('pte_promo_tests.php');
        $config = require $configPath;

        $maxId = 0;
        foreach ($config[$category] as $item) {
            $maxId = max($maxId, (int) $item['id']);
        }
        $entry = ['id' => $maxId + 1] + $entry;

        $config[$category][] = $entry;

        file_put_contents($configPath, "<?php\n\nreturn " . var_export($config, true) . ";\n");
    }

    public function storeSpeaking(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'questions' => 'required|string',
        ]);

        IeltsSpeakingTopic::create([
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title) . '-' . time(),
            'questions' => $request->questions,
            'is_free_tier' => $request->has('is_free_tier'),
        ]);

        return back()->with('success', 'New Speaking Topic created successfully.');
    }

    public function destroySpeaking($id)
    {
        IeltsSpeakingTopic::findOrFail($id)->delete();
        return back()->with('success', 'Speaking Topic deleted successfully.');
    }

    public function updateListening(Request $request, $id)
    {
        $meeting = \App\Models\Meeting::findOrFail($id);
        $meeting->update([
            'is_free_tier' => $request->has('is_free_tier'),
            'promo_start' => $request->promo_start,
            'promo_deadline' => $request->promo_deadline,
        ]);
        return back()->with('success', 'Promo settings for IELTS Listening updated successfully.');
    }

    public function updateGrammar(Request $request, $id)
    {
        $meeting = \App\Models\Meeting::findOrFail($id);
        $meeting->update([
            'is_free_tier' => $request->has('is_free_tier'),
            'promo_start' => $request->promo_start,
            'promo_deadline' => $request->promo_deadline,
        ]);
        return back()->with('success', 'Promo settings for Grammar Test updated successfully.');
    }

    public function updateGrammarPracticeTopic(Request $request, $id)
    {
        $topic = \App\Models\GrammarTopic::findOrFail($id);
        $topic->update([
            'is_free_tier' => $request->has('is_free_tier'),
            'promo_start' => $request->promo_start ?: null,
            'promo_deadline' => $request->promo_deadline ?: null,
        ]);
        return back()->with('success', 'Promo settings for Grammar Practice topic updated successfully.');
    }

    public function storeGrammarPracticeTopic(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'nullable|string',
        ]);

        $maxOrder = \App\Models\GrammarTopic::max('order') ?? 0;

        \App\Models\GrammarTopic::create([
            'title' => $validated['title'],
            'desc' => $validated['desc'] ?? '',
            'order' => $maxOrder + 1,
            'is_free_tier' => $request->has('is_free_tier'),
        ]);

        return back()->with('success', 'New Grammar Practice topic created. Add its questions from the Grammar Practice admin page, then enable it as promo here.');
    }

    /**
     * Standalone question editor for a Promo Test grammar topic - deliberately
     * separate from GrammarWritingAdminController's assignments-namespaced
     * practice page (which requires auth/verified and lives under the real
     * paid-course access system), so editing promo content here can't be
     * affected by, or accidentally affect, the role/access rules for the real
     * assignments used by students and guests.
     */
    public function grammarQuestionsEditor($topicId)
    {
        $topic = \App\Models\GrammarTopic::findOrFail($topicId);
        $questions = $topic->questions()->orderBy('order')->get();

        // Suggestions for the AI Generator's "Topik Materi" field - the titles of
        // all existing Promo Test grammar topics, so admin gets quick-pick options
        // without losing the ability to type any material freely.
        $materialTopicSuggestions = \App\Models\GrammarTopic::orderBy('order')->pluck('title')->unique()->values();

        return view('admin.promo-tests.grammar-questions', compact('topic', 'questions', 'materialTopicSuggestions'));
    }

    public function storeGrammarQuestion(Request $request, $topicId)
    {
        $topic = \App\Models\GrammarTopic::findOrFail($topicId);

        $request->validate([
            'type' => 'required|in:sentence,paragraph',
            'cefr_level' => 'nullable|in:A1,A2,B1,B2,C1',
            'question_id' => 'required|string',
            'answer_en' => 'required|string',
            'vocab_helper' => 'nullable|string',
            'example' => 'nullable|string',
        ]);

        $order = $topic->questions()->max('order') + 1;

        $topic->questions()->create([
            'type' => $request->type,
            'cefr_level' => $request->cefr_level ?: null,
            'question_id' => $request->question_id,
            'answer_en' => $request->answer_en,
            'vocab_helper' => $request->vocab_helper ? json_decode($request->vocab_helper, true) : null,
            'example' => $request->example ? json_decode($request->example, true) : null,
            'order' => $order,
        ]);

        return back()->with('success', 'Soal berhasil ditambahkan.');
    }

    public function updateGrammarQuestion(Request $request, $questionId)
    {
        $question = \App\Models\GrammarTopicQuestion::findOrFail($questionId);

        $request->validate([
            'cefr_level' => 'nullable|in:A1,A2,B1,B2,C1',
            'question_id' => 'required|string',
            'answer_en' => 'required|string',
            'vocab_helper' => 'nullable|string',
            'example' => 'nullable|string',
        ]);

        $question->update([
            'cefr_level' => $request->cefr_level ?: null,
            'question_id' => $request->question_id,
            'answer_en' => $request->answer_en,
            'vocab_helper' => $request->vocab_helper ? json_decode($request->vocab_helper, true) : null,
            'example' => $request->example ? json_decode($request->example, true) : null,
        ]);

        return back()->with('success', 'Soal berhasil diperbarui.');
    }

    public function destroyGrammarQuestion($questionId)
    {
        \App\Models\GrammarTopicQuestion::findOrFail($questionId)->delete();

        return back()->with('success', 'Soal berhasil dihapus.');
    }

    /**
     * AI-generate a batch of practice sentences for a Promo Test grammar topic.
     * Free-text topic (not a fixed checklist) so admin can target any material,
     * plus a CEFR level and theme/context. Returns a preview only - nothing is
     * saved until the admin reviews and confirms via bulkStoreGrammarQuestion().
     * Kept entirely within the promo-tests admin flow (own prompt, own AI call)
     * rather than reusing the assignments module's ai-proxy route.
     */
    public function generateGrammarQuestions(Request $request, $topicId)
    {
        $topic = \App\Models\GrammarTopic::findOrFail($topicId);

        $validated = $request->validate([
            'material_topic' => 'required|string|max:255',
            'levels' => 'required|array|min:1',
            'levels.*' => 'in:A1,A2,B1,B2,C1',
            'theme' => 'required|string|max:255',
            'count' => 'nullable|integer|min:1|max:20',
        ]);

        $count = (int) ($validated['count'] ?? 10);
        $materialTopic = $validated['material_topic'];
        $levels = array_values($validated['levels']);
        $levelsStr = implode(', ', $levels);
        $theme = $validated['theme'];

        $systemPrompt = 'Anda adalah instruktur grammar bahasa Inggris yang sangat ketat dan presisi. Selalu keluarkan JSON murni tanpa markdown.';
        $userPrompt = <<<PROMPT
TUGAS: Buatkan TEPAT {$count} butir kalimat latihan terjemahan (Bahasa Indonesia -> Bahasa Inggris) untuk topik grammar "{$topic->title}", dengan fokus materi spesifik: "{$materialTopic}".

ATURAN:
1. JUMLAH SOAL: WAJIB menghasilkan TEPAT {$count} kalimat. Tidak boleh kurang dan tidak boleh lebih dari {$count}.
2. LEVEL CEFR: Distribusikan {$count} kalimat SEMERATA MUNGKIN di antara level berikut: {$levelsStr}. Sesuaikan kompleksitas kosakata & struktur kalimat masing-masing kalimat dengan levelnya sendiri (level lebih tinggi = kosakata & struktur lebih kompleks).
3. Setiap kalimat WAJIB menyertakan properti "level" berisi SALAH SATU dari: {$levelsStr}, sesuai level kalimat tersebut.
4. Tema/konteks pembahasan kalimat: {$theme}.
5. Setiap kalimat WAJIB menunjukkan struktur grammar/materi "{$materialTopic}" secara eksplisit dan konsisten, di semua level.
7. Setiap butir soal WAJIB menyertakan "vocab_helper" (kosa kata bantuan) berupa objek kata/frasa penting bahasa Inggris sebagai key, beserta objek "id" (arti bahasa Indonesia) dan "pos" (part of speech, contoh: "v", "n", "adj", "adv").
8. ATURAN KOSA KATA BANTUAN (vocab_helper):
   - WAJIB HANYA memberikan BENTUK DASAR / VERB 1 (base form) jika kata kerja.
   - DILARANG KERAS memberikan rumus grammar, bentuk konjugasi tenses, atau kalimat pasif dalam vocab_helper (CONTOH SALAH: "is built", "was written", "has completed", "are cleaned").
   - CONTOH BENAR: gunakan "build" (bukan "is built"), "write" (bukan "is written"), "lead" (bukan "is led"), "teach" (bukan "is taught"), "audit" (bukan "is audited").
9. Hindari pengulangan kata/pola yang sama persis di setiap kalimat.
10. DILARANG KERAS menggunakan teks placeholder atau dummy seperti "Kalimat 1". Properti "id" HARUS berisi kalimat soal Bahasa Indonesia sebenarnya yang utuh.

FORMAT OUTPUT (JSON murni tanpa markdown, berisi tepat {$count} items):
{
  "sentences": [
    {
      "id": "Buku itu ditulis oleh seorang penulis terkenal",
      "en": "The book is written by a famous author",
      "level": "B2",
      "vocab_helper": {
        "write": {"id": "menulis", "pos": "v"},
        "author": {"id": "penulis", "pos": "n"},
        "famous": {"id": "terkenal", "pos": "adj"}
      }
    }
  ]
}
PROMPT;

        $providers = ['groq', 'sambanova', 'cerebras', 'deepinfra', 'mistral', 'siliconflow', 'gemini', 'openrouter', 'openai'];

        $decoded = \App\Services\MultiProviderAiClient::chatJson($providers, $systemPrompt, $userPrompt, [
            'groq_feature' => 'writing',
            'max_tokens' => 4096,
            'temperature' => 0.6,
            // Default per-attempt timeout is 60s; with up to 9 providers x multiple
            // keys x multiple models tried sequentially, a run of failures could
            // otherwise take several minutes with the UI showing no feedback.
            // Fail over faster so the frontend's 45s abort rarely fires first.
            'timeout' => 15,
        ]);

        if (!$decoded || !isset($decoded['sentences']) || !is_array($decoded['sentences']) || empty($decoded['sentences'])) {
            return response()->json(['success' => false, 'message' => 'Sistem AI sedang bermasalah atau mengembalikan format tidak lengkap. Silakan coba lagi.'], 503);
        }

        $sentences = array_values(array_filter(array_map(function ($s) use ($levels) {
            $id = trim((string) ($s['id'] ?? ''));
            $en = trim((string) ($s['en'] ?? ''));
            $level = trim((string) ($s['level'] ?? ''));
            $vocabHelper = (isset($s['vocab_helper']) && is_array($s['vocab_helper'])) ? $s['vocab_helper'] : null;
            if (!$id || !$en) {
                return null;
            }
            // Defensive fallback: if the AI omitted/invented an invalid level,
            // assign it round-robin from the requested levels rather than
            // dropping an otherwise-valid sentence.
            if (!in_array($level, $levels, true)) {
                $level = $levels[0];
            }
            return ['id' => $id, 'en' => $en, 'level' => $level, 'vocab_helper' => $vocabHelper];
        }, $decoded['sentences'])));

        // Strictly enforce the exact requested count
        $sentences = array_slice($sentences, 0, $count);

        if (empty($sentences)) {
            return response()->json(['success' => false, 'message' => 'AI tidak mengembalikan kalimat yang valid. Silakan coba lagi.'], 503);
        }

        return response()->json(['success' => true, 'sentences' => $sentences]);
    }

    /**
     * Persist admin-reviewed AI-generated sentences as real GrammarTopicQuestion
     * rows, after the preview step in generateGrammarQuestions().
     */
    public function bulkStoreGrammarQuestions(Request $request, $topicId)
    {
        $topic = \App\Models\GrammarTopic::findOrFail($topicId);

        $validated = $request->validate([
            'sentences' => 'required|array|min:1',
            'sentences.*.id' => 'required|string',
            'sentences.*.en' => 'required|string',
            'sentences.*.level' => 'nullable|in:A1,A2,B1,B2,C1',
            'sentences.*.vocab_helper' => 'nullable|array',
            'replace_existing' => 'nullable|boolean',
        ]);

        $replace = (bool) ($request->input('replace_existing', false));
        if ($replace) {
            $topic->questions()->delete();
            $order = 0;
        } else {
            $order = $topic->questions()->max('order') ?? 0;
        }

        foreach ($validated['sentences'] as $s) {
            $order++;
            $topic->questions()->create([
                'type' => 'sentence',
                'cefr_level' => $s['level'] ?? null,
                'question_id' => $s['id'],
                'answer_en' => $s['en'],
                'vocab_helper' => $s['vocab_helper'] ?? null,
                'order' => $order,
            ]);
        }

        $count = count($validated['sentences']);
        return response()->json([
            'success' => true,
            'message' => "{$count} soal berhasil disimpan ke bank soal."
        ]);
    }

    /**
     * Delete all questions for this topic in one action.
     */
    public function clearGrammarQuestions($topicId)
    {
        $topic = \App\Models\GrammarTopic::findOrFail($topicId);
        $topic->questions()->delete();

        return back()->with('success', 'Semua soal pada topik ini berhasil dikosongkan.');
    }

    public function updateReadingGeneral(Request $request, $id)
    {
        $meeting = \App\Models\Meeting::findOrFail($id);
        $meeting->update([
            'is_free_tier' => $request->has('is_free_tier'),
            'promo_start' => $request->promo_start,
            'promo_deadline' => $request->promo_deadline,
        ]);
        return back()->with('success', 'Promo settings for IELTS Reading General updated successfully.');
    }

    public function updateReadingAcademic(Request $request, $id)
    {
        $meeting = \App\Models\Meeting::findOrFail($id);
        $meeting->update([
            'is_free_tier' => $request->has('is_free_tier'),
            'promo_start' => $request->promo_start,
            'promo_deadline' => $request->promo_deadline,
        ]);
        return back()->with('success', 'Promo settings for IELTS Reading Academic updated successfully.');
    }

    public function updateToeflListening(Request $request, $id)
    {
        $meeting = ToeflListeningMeeting::findOrFail($id);
        $meeting->update([
            'is_free_tier' => $request->has('is_free_tier'),
            'promo_start' => $request->promo_start,
            'promo_deadline' => $request->promo_deadline,
        ]);
        return back()->with('success', 'Promo settings for TOEFL Listening updated successfully.');
    }

    public function updateToeflStructure(Request $request, $id)
    {
        $meeting = ToeflStructureMeeting::findOrFail($id);
        $meeting->update([
            'is_free_tier' => $request->has('is_free_tier'),
            'promo_start' => $request->promo_start,
            'promo_deadline' => $request->promo_deadline,
        ]);
        return back()->with('success', 'Promo settings for TOEFL Structure updated successfully.');
    }

    public function updateToeflReading(Request $request, $id)
    {
        $meeting = ToeflReadingMeeting::findOrFail($id);
        $meeting->update([
            'title' => $request->title ?: $meeting->title,
            'is_free_tier' => $request->has('is_free_tier'),
            'promo_start' => $request->promo_start,
            'promo_deadline' => $request->promo_deadline,
        ]);
        return back()->with('success', 'Promo settings for TOEFL Reading updated successfully.');
    }

    public function bulkUpdate(Request $request)
    {
        $tests = $request->tests;
        $action = $request->action;

        if (!$tests || !is_array($tests) || count($tests) === 0) {
            return back()->with('error', 'No tests selected.');
        }

        $is_free_tier = $action === 'activate' ? 1 : 0;

        foreach ($tests as $test) {
            $id = $test['id'] ?? null;
            $type = $test['type'] ?? null;
            if (!$id || !$type) continue;

            switch ($type) {
                case 'writing':
                case 'writing_general':
                    IeltsWritingMeeting::where('id', $id)->update(['is_free_tier' => $is_free_tier]);
                    break;
                case 'speaking':
                    IeltsSpeakingTopic::where('id', $id)->update(['is_free_tier' => $is_free_tier]);
                    break;
                case 'ielts_listening':
                    \App\Models\Meeting::where('id', $id)->update(['is_free_tier' => $is_free_tier]);
                    break;
                case 'ielts_reading_general':
                    \App\Models\Meeting::where('id', $id)->update(['is_free_tier' => $is_free_tier]);
                    break;
                case 'ielts_reading_academic':
                    \App\Models\Meeting::where('id', $id)->update(['is_free_tier' => $is_free_tier]);
                    break;
                case 'toefl_listening':
                    ToeflListeningMeeting::where('id', $id)->update(['is_free_tier' => $is_free_tier]);
                    break;
                case 'toefl_structure':
                    ToeflStructureMeeting::where('id', $id)->update(['is_free_tier' => $is_free_tier]);
                    break;
                case 'toefl_reading':
                    ToeflReadingMeeting::where('id', $id)->update(['is_free_tier' => $is_free_tier]);
                    break;
            }
        }

        return back()->with('success', 'Bulk ' . $action . ' applied successfully.');
    }
}
