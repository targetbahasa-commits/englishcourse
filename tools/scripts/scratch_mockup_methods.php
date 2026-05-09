    public function toeflItpMockupPackage($package)
    {
        // Only package 1 is available for now
        if ($package != 1) {
            return redirect()->route('assignments.toefl-itp.mockup')
                ->with('error', 'Paket ini belum tersedia.');
        }

        // Fetch Section 1: Listening Part A questions (Questions 1-30)
        $listeningPartA = \App\Models\ToeflMockupQuestion::where('section', 'listening')
            ->where('part', 'A')
            ->orderBy('question_number')
            ->get();

        // Fetch Section 1: Listening Part B questions (Questions 31-37)
        $listeningPartB = \App\Models\ToeflMockupQuestion::where('section', 'listening')
            ->where('part', 'B')
            ->orderBy('question_number')
            ->get();

        // Fetch Section 1: Listening Part C questions (Questions 38-50)
        $listeningPartC = \App\Models\ToeflMockupQuestion::where('section', 'listening')
            ->where('part', 'C')
            ->orderBy('question_number')
            ->get();

        // Fetch Section 2: Structure questions (Questions 1-15)
        $structureQuestions = \App\Models\ToeflMockupQuestion::where('section', 'structure')
            ->where('part', 'Structure')
            ->orderBy('question_number')
            ->get();

        // Fetch Section 2: Written Expression questions (Questions 16-30)
        $writtenQuestions = \App\Models\ToeflMockupQuestion::where('section', 'structure')
            ->where('part', 'Written Expression')
            ->orderBy('question_number')
            ->get();

        // Fetch Section 3: Reading passages with questions for Package 1
        $readingPassages = [];
        $readingPassagesData = \App\Models\ToeflReadingPassage::with(['questions' => function($query) {
                $query->orderBy('question_number');
            }])
            ->where('package_number', 1)
            ->orderBy('passage_number')
            ->get();
        
        if ($readingPassagesData->isEmpty()) {
            // Fallback: Create passages from reading questions with correct passage content
            $readingQuestions = \App\Models\ToeflMockupQuestion::where('section', 'reading')
                ->orderBy('question_number')
                ->get()
                ->keyBy('question_number');

            // Correct passage content and question ranges per passage
            $passageDefinitions = [
                1 => [
                    'range'   => [1, 9],
                    'title'   => 'Questions 1-9',
                    'content' => '<div class="toefl-passage-text"><p class="toefl-passage-paragraph">Romantic music of the nineteenth century differed greatly from the classical music of the eighteenth century. Classical music was primarily concerned with strict form and style. Romantic composers, however, wanted to express their feelings and thoughts through music. Their music was less structured than the music of the classicists; its goal was to fill the listener with emotion, with thoughts of beauty, wonder, and nature, and with poetry.</p></div>',
                    'line_markers' => ['Line', '(5)'],
                ],
                2 => [
                    'range'   => [10, 19],
                    'title'   => 'Questions 10-19',
                    'content' => '<div class="toefl-passage-text"><p class="toefl-passage-paragraph">Passage 2 text here...</p></div>',
                    'line_markers' => ['Line', '(5)', '(10)', '(15)'],
                ],
                3 => [
                    'range'   => [20, 29],
                    'title'   => 'Questions 20-29',
                    'content' => '<div class="toefl-passage-text"><p class="toefl-passage-paragraph">Passage 3 text here...</p></div>',
                    'line_markers' => ['Line', '(5)', '(10)', '(15)'],
                ],
                4 => [
                    'range'   => [30, 39],
                    'title'   => 'Questions 30-39',
                    'content' => '<div class="toefl-passage-text"><p class="toefl-passage-paragraph">Passage 4 text here...</p></div>',
                    'line_markers' => ['Line', '(5)', '(10)', '(15)'],
                ],
                5 => [
                    'range'   => [40, 50],
                    'title'   => 'Questions 40-50',
                    'content' => '<div class="toefl-passage-text"><p class="toefl-passage-paragraph">Passage 5 text here...</p></div>',
                    'line_markers' => ['Line', '(5)', '(10)', '(15)'],
                ],
            ];

            foreach ($passageDefinitions as $pNum => $def) {
                // Get questions in this range
                $qs = $readingQuestions->filter(function($q) use ($def) {
                    return $q->question_number >= $def['range'][0] && $q->question_number <= $def['range'][1];
                })->values();
                
                $readingPassages[] = [
                    'passage_number' => $pNum,
                    'section_title' => $def['title'],
                    'content' => $def['content'],
                    'line_markers' => $def['line_markers'],
                    'questions' => $qs->map(function($q) {
                        return [
                            'id'              => $q->id,
                            'question_number' => $q->question_number,
                            'question_text'   => $q->question_text,
                            'option_a'        => $q->option_a,
                            'option_b'        => $q->option_b,
                            'option_c'        => $q->option_c,
                            'option_d'        => $q->option_d,
                            'correct_answer'  => $q->correct_answer,
                        ];
                    })->toArray(),
                ];
            }
        } else {
            // Use database passages
            foreach ($readingPassagesData as $passage) {
                $questions = $passage->questions;
                $startQ = $questions->first()->question_number ?? 1;
                $endQ = $questions->last()->question_number ?? 10;
                
                $readingPassages[] = [
                    'passage_number' => $passage->passage_number,
                    'section_title' => "Questions {$startQ}-{$endQ}",
                    'content' => $passage->content,
                    'line_markers' => ['Line', '(5)', '(10)', '(15)', '(20)', '(25)', '(30)'],
                    'questions' => $questions->map(function($q) {
                        return [
                            'id' => $q->id,
                            'question_number' => $q->question_number,
                            'question_text' => $q->question_text,
                            'option_a' => $q->option_a,
                            'option_b' => $q->option_b,
                            'option_c' => $q->option_c,
                            'option_d' => $q->option_d,
                            'correct_answer' => $q->correct_answer,
                        ];
                    })->toArray()
                ];
            }
        }
        
        $readingQuestions = \App\Models\ToeflMockupQuestion::where('section', 'reading')
            ->orderBy('question_number')
            ->get();

        // For backward compatibility with audio player
        $listeningQuestions = $listeningPartA;

        $packageMode = true;
        $packageNumber = $package;
        $isFullMockTest = true;

        return view('assignments.toefl-itp.mockup', compact('listeningPartA', 'listeningPartB', 'listeningPartC', 'listeningQuestions', 'structureQuestions', 'writtenQuestions', 'readingQuestions', 'readingPassages', 'packageMode', 'packageNumber', 'isFullMockTest'));
    }

    public function submitToeflItpMockup(Request $request, $package)
    {
        $answers = $request->input('answers', []);
        $questions = \App\Models\ToeflMockupQuestion::where('package_number', $package)->get()->keyBy('id');
        
        $rawScores = ['listening' => 0, 'structure' => 0, 'reading' => 0];
        $correctMap = [];
        
        foreach ($questions as $id => $q) {
            $correctMap[$id] = $q->correct_answer;
            if (isset($answers[$id]) && strtoupper(trim($answers[$id])) === strtoupper($q->correct_answer)) {
                $rawScores[$q->section]++;
            }
        }
        
        $scaledListening = $this->convertToeflScore('listening', $rawScores['listening']);
        $scaledStructure = $this->convertToeflScore('structure', $rawScores['structure']);
        $scaledReading = $this->convertToeflScore('reading', $rawScores['reading']);
        
        $totalScore = round(($scaledListening + $scaledStructure + $scaledReading) * 10 / 3);
        
        if (Auth::check() && Auth::user()->isStudent()) {
            \App\Models\ToeflMockupResult::create([
                'user_id' => Auth::id(),
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'package_number' => $package,
                'listening_correct' => $rawScores['listening'],
                'structure_correct' => $rawScores['structure'],
                'reading_correct' => $rawScores['reading'],
                'listening_score' => $scaledListening,
                'structure_score' => $scaledStructure,
                'reading_score' => $scaledReading,
                'total_score' => $totalScore,
                'answers_data' => $answers,
            ]);
        }
        
        return response()->json([
            'success' => true,
            'rawScores' => $rawScores,
            'scaledScores' => [
                'listening' => $scaledListening,
                'structure' => $scaledStructure,
                'reading' => $scaledReading
            ],
            'totalScore' => $totalScore,
            'correctMap' => $correctMap
        ]);
    }

    private function convertToeflScore($section, $rawScore)
    {
        // Standard TOEFL PBT conversion tables (Approximation)
        $listeningTable = [
            50=>68, 49=>67, 48=>66, 47=>65, 46=>63, 45=>62, 44=>61, 43=>60, 42=>59, 41=>58, 40=>57,
            39=>57, 38=>56, 37=>55, 36=>54, 35=>54, 34=>53, 33=>52, 32=>52, 31=>51, 30=>51, 29=>50, 
            28=>49, 27=>49, 26=>48, 25=>48, 24=>47, 23=>47, 22=>46, 21=>45, 20=>45, 19=>44, 18=>43, 
            17=>42, 16=>41, 15=>41, 14=>39, 13=>38, 12=>37, 11=>35, 10=>33, 9=>32, 8=>32, 7=>31, 
            6=>30, 5=>29, 4=>28, 3=>27, 2=>26, 1=>25, 0=>24
        ];
        
        $structureTable = [
            40=>68, 39=>67, 38=>65, 37=>63, 36=>61, 35=>60, 34=>58, 33=>57, 32=>56, 31=>55, 30=>54,
            29=>53, 28=>52, 27=>51, 26=>50, 25=>49, 24=>48, 23=>47, 22=>46, 21=>45, 20=>44, 19=>43,
            18=>43, 17=>42, 16=>40, 15=>40, 14=>38, 13=>37, 12=>36, 11=>35, 10=>33, 9=>31, 8=>29,
            7=>27, 6=>26, 5=>25, 4=>23, 3=>22, 2=>21, 1=>20, 0=>20
        ];
        
        $readingTable = [
            50=>67, 49=>66, 48=>65, 47=>63, 46=>61, 45=>60, 44=>59, 43=>58, 42=>57, 41=>56, 40=>55,
            39=>54, 38=>54, 37=>53, 36=>52, 35=>52, 34=>51, 33=>50, 32=>49, 31=>48, 30=>48, 29=>47,
            28=>46, 27=>46, 26=>45, 25=>44, 24=>43, 23=>43, 22=>42, 21=>41, 20=>40, 19=>39, 18=>38,
            17=>37, 16=>36, 15=>35, 14=>34, 13=>32, 12=>31, 11=>30, 10=>29, 9=>28, 8=>28, 7=>27,
            6=>26, 5=>25, 4=>24, 3=>23, 2=>23, 1=>22, 0=>21
        ];

        if ($section === 'listening') return $listeningTable[$rawScore] ?? 24;
        if ($section === 'structure') return $structureTable[$rawScore] ?? 20;
        if ($section === 'reading') return $readingTable[$rawScore] ?? 21;
        
        return 31;
    }
