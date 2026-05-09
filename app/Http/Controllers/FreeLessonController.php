<?php

namespace App\Http\Controllers;

use App\Application\FreeLesson\SaveLessonProgress;
use App\Application\FreeLesson\VocabularyDataProvider;
use Illuminate\Http\Request;

class FreeLessonController extends Controller
{
    public function __construct(
        private readonly VocabularyDataProvider $provider,
        private readonly SaveLessonProgress $saveLessonProgress,
    ) {}
    public function index()
    {
        $freeLessons = [
            [
                'id' => 'a1',
                'title' => 'Vocabulary A1',
                'description' => 'Essential vocabulary for absolute beginners. 20 topics covering everyday situations.',
                'image' => 'https://via.placeholder.com/400x200?text=A1+Vocabulary',
                'color' => 'blue',
                'route' => route('vocabulary-a1')
            ],
            [
                'id' => 'a2',
                'title' => 'Vocabulary A2',
                'description' => 'Elementary vocabulary to expand your daily communication skills.',
                'image' => 'https://via.placeholder.com/400x200?text=A2+Vocabulary',
                'color' => 'green',
                'route' => route('vocabulary-a2')
            ],
            [
                'id' => 'b1',
                'title' => 'Vocabulary B1',
                'description' => 'Intermediate vocabulary for more complex conversations.',
                'image' => 'https://via.placeholder.com/400x200?text=B1+Vocabulary',
                'color' => 'purple',
                'route' => route('vocabulary-b1')
            ],
            [
                'id' => 'b2',
                'title' => 'Vocabulary B2',
                'description' => 'Upper-intermediate vocabulary for professional fluency.',
                'image' => 'https://via.placeholder.com/400x200?text=B2+Vocabulary',
                'color' => 'orange',
                'route' => route('vocabulary-b2')
            ],
        [
                'id' => 'c1',
                'title' => 'Vocabulary C1',
                'description' => 'Advanced vocabulary for near-native proficiency.',
                'image' => 'https://via.placeholder.com/400x200?text=C1+Vocabulary',
                'color' => 'red',
                'route' => route('vocabulary-c1')
            ],
            // --- New Modules ---
            [
                'id' => 'verbs',
                'title' => 'Verbs (A1-C1)',
                'description' => 'Master English verbs across 5 proficiency levels.',
                'image' => 'https://via.placeholder.com/400x200?text=Verbs',
                'color' => 'teal',
                'route' => route('vocabulary-verb')
            ],
            [
                'id' => 'adjectives',
                'title' => 'Adjectives (A1-C1)',
                'description' => 'Descriptive words to enhance your expression.',
                'image' => 'https://via.placeholder.com/400x200?text=Adjectives',
                'color' => 'yellow',
                'route' => route('vocabulary-adjective')
            ],
            [
                'id' => 'adverbs',
                'title' => 'Adverbs (A1-C1)',
                'description' => 'Add nuance to your verbs and adjectives.',
                'image' => 'https://via.placeholder.com/400x200?text=Adverbs',
                'color' => 'indigo',
                'route' => route('vocabulary-adverb')
            ],
            [
                'id' => 'expressions',
                'title' => 'English Expressions',
                'description' => 'Common expressions for natural conversation.',
                'image' => 'https://via.placeholder.com/400x200?text=Expressions',
                'color' => 'cyan',
                'route' => route('english-expression')
            ],
             [
                'id' => 'idioms',
                'title' => 'English Idioms',
                'description' => 'Learn idioms to sound like a native speaker.',
                'image' => 'https://via.placeholder.com/400x200?text=Idioms',
                'color' => 'pink',
                'route' => route('idioms')
            ],
             [
                'id' => 'phrasal-verbs',
                'title' => 'Phrasal Verbs',
                'description' => 'Essential phrasal verbs for fluency.',
                'image' => 'https://via.placeholder.com/400x200?text=Phrasal+Verbs',
                'color' => 'orange',
                'route' => route('phrasal-verbs')
            ],
             [
                'id' => 'irregular-verbs',
                'title' => 'Irregular Verbs',
                'description' => 'Complete list of irregular verbs.',
                'image' => 'https://via.placeholder.com/400x200?text=Irregular+Verbs',
                'color' => 'purple',
                'route' => route('irregular-verbs')
            ]
        ];

        return view('free_lesson.index', compact('freeLessons'));
    }

    public function vocabularyA1()
    {
        $topics = $this->provider->getTopicsForLevel('A1');
        return view('vocabulary-a1', compact('topics'));
    }

    public function topic($id)
    {
        $data = $this->provider->getVocabularyForTopic('A1', $id);
        $progress = null;
        return view('vocabulary-topic-detail', [
            'title'        => $data['title'],
            'vocabularies' => $data['vocabularies'],
            'level'        => 'A1',
            'topicId'      => $id,
            'progress'     => $progress,
        ]);
    }

    // --- Level Views ---

    public function vocabularyA2()
    {
        $topics = $this->provider->getTopicsForLevel('A2');
        return view('vocabulary-a2', compact('topics'));
    }

    public function vocabularyB1()
    {
        $topics = $this->provider->getTopicsForLevel('B1');
        return view('vocabulary-b1', compact('topics'));
    }

    public function vocabularyB2()
    {
        $topics = $this->provider->getTopicsForLevel('B2');
        return view('vocabulary-b2', compact('topics'));
    }

    public function vocabularyC1()
    {
        $topics = $this->provider->getTopicsForLevel('C1');
        return view('vocabulary-c1', compact('topics'));
    }

    // --- Topic Details ---

    public function topicA2($id)
    {
        return $this->showTopicView('A2', $id);
    }

    public function topicB1($id)
    {
        return $this->showTopicView('B1', $id);
    }

    public function topicB2($id)
    {
        return $this->showTopicView('B2', $id);
    }

    public function topicC1($id)
    {
        return $this->showTopicView('C1', $id);
    }

    // --- Parts of Speech: Verbs ---

    public function vocabularyVerb()
    {
        $levels = $this->provider->getMockLevels('verb');
        return view('vocabulary-verb', compact('levels'));
    }

    public function vocabularyVerbLevel($level)
    {
        $title = 'Verbs ' . strtoupper($level);
        $jsonPath = storage_path('app/' . strtolower($level) . '_verbs.json');
        $vocabularies = [];
        if (file_exists($jsonPath)) {
            $vocabularies = json_decode(file_get_contents($jsonPath), true) ?? [];
        } else {
            $vocabularies = $this->provider->getMockVocabularies(strtoupper($level), 'all_verbs');
        }
        return view('vocabulary-verb-detail', [
            'title'           => $title,
            'vocabularies'    => $vocabularies,
            'level'           => $level,
            'progress'        => null,
            'total_questions' => count($vocabularies),
        ]);
    }

    // --- Parts of Speech: Adjectives ---

    public function vocabularyAdjective()
    {
        $levels = $this->provider->getMockLevels('adjective');
        return view('vocabulary-adjective', compact('levels'));
    }

    public function vocabularyAdjectiveLevel($level)
    {
        $title = 'Adjectives ' . strtoupper($level);
        $jsonPath = storage_path('app/' . strtolower($level) . '_adjectives.json');
        $vocabularies = [];
        if (file_exists($jsonPath)) {
            $vocabularies = json_decode(file_get_contents($jsonPath), true) ?? [];
        } else {
            $vocabularies = $this->provider->getMockVocabularies(strtoupper($level), 'all_adjectives');
        }
        return view('vocabulary-adjective-detail', [
            'title'           => $title,
            'vocabularies'    => $vocabularies,
            'level'           => $level,
            'progress'        => null,
            'total_questions' => count($vocabularies),
        ]);
    }

    // --- Parts of Speech: Adverbs ---

    public function vocabularyAdverb()
    {
        $levels = $this->provider->getMockLevels('adverb');
        return view('vocabulary-adverb', compact('levels'));
    }

    public function vocabularyAdverbLevel($level)
    {
        $title = 'Adverbs ' . strtoupper($level);
        $jsonPath = storage_path('app/' . strtolower($level) . '_adverbs.json');
        $vocabularies = [];
        if (file_exists($jsonPath)) {
            $vocabularies = json_decode(file_get_contents($jsonPath), true) ?? [];
        } else {
            $vocabularies = $this->provider->getMockVocabularies(strtoupper($level), 'all_adverbs');
        }
        return view('vocabulary-adverb-detail', [
            'title'           => $title,
            'vocabularies'    => $vocabularies,
            'level'           => $level,
            'progress'        => null,
            'total_questions' => count($vocabularies),
        ]);
    }

    // --- English Expressions ---

    public function englishExpression()
    {
        $levels = $this->provider->getMockLevels3('expression');
        return view('english-expression', compact('levels'));
    }

    public function englishExpressionLevel($level)
    {
        $title = 'English Expressions (' . ucfirst($level) . ')';
        $levelLower = strtolower($level);
        $filePath = storage_path("app/{$levelLower}_expressions.json");
        if (file_exists($filePath)) {
            $expressions = json_decode(file_get_contents($filePath), true);
        } else {
            $expressions = $this->provider->getMockExpressions(ucfirst($level));
        }
        return view('expression-detail', [
            'title'           => $title,
            'expressions'     => $expressions,
            'level'           => ucfirst($level),
            'progress'        => null,
            'total_questions' => count($expressions),
        ]);
    }

    // --- Idioms ---

    public function idioms()
    {
        $levels = $this->provider->getMockLevels3('idiom');
        return view('idioms', compact('levels'));
    }

    public function idiomsLevel($level)
    {
        $title = 'English Idioms (' . ucfirst($level) . ')';
        $levelLower = strtolower($level);
        $filePath = storage_path("app/{$levelLower}_idioms.json");
        if (file_exists($filePath)) {
            $idioms = json_decode(file_get_contents($filePath), true);
        } else {
            $idioms = $this->provider->getMockIdioms(ucfirst($level));
        }
        return view('idioms-detail', [
            'title'           => $title,
            'idioms'          => $idioms,
            'level'           => ucfirst($level),
            'progress'        => null,
            'total_questions' => count($idioms),
        ]);
    }

    // --- Phrasal Verbs ---

    public function phrasalVerbs()
    {
        $levels = $this->provider->getMockLevels3('phrasal verb');
        return view('phrasal-verbs', compact('levels'));
    }

    public function phrasalVerbsLevel($level)
    {
        $title = 'Phrasal Verbs (' . ucfirst($level) . ')';
        $levelLower = strtolower($level);
        $filePath = storage_path("app/{$levelLower}_phrasal_verbs.json");
        $phrasalVerbs = [];
        if (file_exists($filePath)) {
            $phrasalVerbs = json_decode(file_get_contents($filePath), true);
        } else {
            $phrasalVerbs = $this->provider->getMockPhrasalVerbs(ucfirst($level));
        }
        return view('phrasal-verbs-detail', [
            'title'           => $title,
            'phrasalVerbs'    => $phrasalVerbs,
            'level'           => ucfirst($level),
            'progress'        => null,
            'total_questions' => count($phrasalVerbs),
        ]);
    }

    // --- Irregular Verbs ---
    public function irregularVerbs()
    {
        $title = "Irregular Verbs Mastery";
        $vocabularies = [];
        $filePath = storage_path('app/irregular_verbs.json');
        
        if (file_exists($filePath)) {
            $vocabularies = json_decode(file_get_contents($filePath), true);
        } else {
            // Fallback just in case
            $vocabularies = [
                ['base' => 'Be', 'past' => 'Was/Were', 'participle' => 'Been', 'translation' => 'Adalah', 'example' => 'I was there.'],
                ['base' => 'Become', 'past' => 'Became', 'participle' => 'Become', 'translation' => 'Menjadi', 'example' => 'She became a doctor.'],
                ['base' => 'Begin', 'past' => 'Began', 'participle' => 'Begun', 'translation' => 'Memulai', 'example' => 'The show began at 8.'],
                ['base' => 'Break', 'past' => 'Broke', 'participle' => 'Broken', 'translation' => 'Mematahkan', 'example' => 'He broke the glass.'],
                ['base' => 'Bring', 'past' => 'Brought', 'participle' => 'Brought', 'translation' => 'Membawa', 'example' => 'I brought a gift.']
            ];
        }
        
        $progress = null;
        if (auth()->check()) {
            $progress = \App\Models\FreeLessonProgress::where('user_id', auth()->id())
                ->where('lesson_slug', 'irregular-verbs')
                ->first();
        }

        return view('irregular-verbs', [
            'title' => $title,
            'vocabularies' => $vocabularies,
            'progress' => $progress
        ]);
    }

    public function saveProgress(Request $request)
    {
        $request->validate([
            'lesson_slug'     => 'required|string',
            'score'           => 'required|numeric',
            'total_questions' => 'required|integer',
        ]);

        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $progress = $this->saveLessonProgress->handle(
            auth()->id(),
            $request->lesson_slug,
            (float) $request->score,
            (int) $request->total_questions,
        );

        return response()->json(['success' => true, 'progress' => $progress]);
    }

    private function showTopicView(string $level, string $id)
    {
        $data = $this->provider->getVocabularyForTopic($level, $id);
        return view('vocabulary-topic-detail', [
            'title'        => $data['title'],
            'vocabularies' => $data['vocabularies'],
            'level'        => $level,
            'topicId'      => $id,
            'progress'     => null,
        ]);
    }
}