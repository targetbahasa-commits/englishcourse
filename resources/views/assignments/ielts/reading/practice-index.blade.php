@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">Reading Practice Tests</h1>
                        <p class="text-gray-500 mt-1">Full-length IELTS Academic Reading practice. 📖</p>
                    </div>
                </div>
                <a href="{{ route('assignments.ielts-academic') }}"
                   class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back
                </a>
            </div>
        </div>

        <!-- Practice Tests Grid -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Full Practice Tests</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @php
                    $tests = [
                        1 => [
                            'title'          => 'Practice Test 1',
                            'passages'       => ['Andrea Palladio', 'The future never dies?', 'Pottery production in ancient Akrotiri'],
                            'question_types' => ['true_false_not_given', 'short_answer', 'yes_no_not_given', 'summary_completion', 'multiple_choice', 'matching_sentence_endings'],
                            'gradient'       => 'linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%)',
                            'btn_color'      => '#5b21b6',
                            'icon_color'     => '#7c3aed',
                            'available'      => true,
                            'material_id'    => 1,
                        ],
                        2 => [
                            'title'          => 'Practice Test 2',
                            'passages'       => ['The Cacao: a Sweet History', 'Cosmetics in Ancient Past', 'The Secrets of Persuasion'],
                            'question_types' => ['matching_paragraph_information', 'true_false', 'summary_completion', 'multiple_choice', 'matching_sentence_endings'],
                            'gradient'       => 'linear-gradient(135deg, #0d9488 0%, #0891b2 100%)',
                            'btn_color'      => '#0d7377',
                            'icon_color'     => '#0d9488',
                            'available'      => true,
                            'material_id'    => 2,
                        ],
                        3 => [
                            'title'          => 'Practice Test 3',
                            'passages'       => ['Bondi Beach', 'Antarctica – in from the cold?', 'Talc Powder'],
                            'question_types' => ['true_false', 'short_answer_group', 'summary_completion', 'matching_paragraph_information', 'matching_sentence_endings', 'multiple_choice'],
                            'gradient'       => 'linear-gradient(135deg, #f59e0b 0%, #ef4444 100%)',
                            'btn_color'      => '#d97706',
                            'icon_color'     => '#f59e0b',
                            'available'      => true,
                            'material_id'    => 3,
                        ],
                        4 => [
                            'title'          => 'Practice Test 4',
                            'passages'       => ['Voyage of Going: beyond the blue line', 'Memory and Age', 'Facial expression 1'],
                            'question_types' => ['true_false', 'summary_completion', 'short_answer_group', 'multiple_choice', 'matching_sentence_endings', 'matching_paragraph_information'],
                            'gradient'       => 'linear-gradient(135deg, #2563eb 0%, #7c3aed 100%)',
                            'btn_color'      => '#1d4ed8',
                            'icon_color'     => '#2563eb',
                            'available'      => true,
                            'material_id'    => 4,
                        ],
                        5 => [
                            'title'          => 'Practice Test 5',
                            'passages'       => ['World Ecotourism in the developing countries', 'Smell and Memory', 'The Persuaders'],
                            'question_types' => ['matching_sentence_endings', 'summary_completion', 'multiple_choice', 'matching_paragraph_information'],
                            'gradient'       => 'linear-gradient(135deg, #ec4899 0%, #f43f5e 100%)',
                            'btn_color'      => '#db2777',
                            'icon_color'     => '#ec4899',
                            'available'      => true,
                            'material_id'    => 5,
                        ],
                        6 => [
                            'title'          => 'Practice Test 6',
                            'passages'       => ['Rainwater Harvesting', 'Mammoth kill 2', 'Language Strategy in Multinational Company'],
                            'question_types' => ['sentence_completion', 'true_false_not_given', 'matching_features', 'summary_completion', 'multiple_choice'],
                            'gradient'       => 'linear-gradient(135deg, #10b981 0%, #047857 100%)',
                            'btn_color'      => '#059669',
                            'icon_color'     => '#10b981',
                            'available'      => true,
                            'material_id'    => 6,
                        ],
                        7 => [
                            'title'          => 'Practice Test 7',
                            'passages'       => ['New Agriculture in Oregon, US', 'WHAT COOKBOOKS REALLY TEACH US', 'Learning lessons from the past'],
                            'question_types' => ['matching_features', 'yes_no_not_given', 'summary_completion', 'matching_paragraph_information', 'multiple_choice', 'matching_sentence_endings'],
                            'gradient'       => 'linear-gradient(135deg, #f97316 0%, #be123c 100%)',
                            'btn_color'      => '#c2410c',
                            'icon_color'     => '#ea580c',
                            'available'      => true,
                            'material_id'    => 7,
                        ],
                        8 => [
                            'title'          => 'Practice Test 8',
                            'passages'       => ['Otter', 'BIRD MIGRATION 2', 'Communicating Conflict!'],
                            'question_types' => ['matching_paragraph_information', 'short_answer_group', 'matching_headings', 'multiple_choice', 'sentence_completion', 'true_false_not_given'],
                            'gradient'       => 'linear-gradient(135deg, #84cc16 0%, #16a34a 100%)',
                            'btn_color'      => '#4ade80',
                            'icon_color'     => '#65a30d',
                            'available'      => true,
                            'material_id'    => 8,
                        ],
                        9 => [
                            'title'          => 'Practice Test 9',
                            'passages'       => ['Natural Pesticide in India', 'Is Graffiti Art or Crime?', 'The concept of childhood in the western countries'],
                            'question_types' => ['true_false_not_given', 'summary_completion', 'short_answer_group', 'matching_paragraph_information', 'multiple_choice_multiple'],
                            'gradient'       => 'linear-gradient(135deg, #6366f1 0%, #4338ca 100%)',
                            'btn_color'      => '#4f46e5',
                            'icon_color'     => '#4338ca',
                            'available'      => true,
                            'material_id'    => 9,
                        ],
                        10 => [
                            'title'          => 'Practice Test 10',
                            'passages'       => ['Copy your neighbour', 'European Heat Wave', 'E-training'],
                            'question_types' => ['matching_paragraph_information', 'true_false_not_given', 'multiple_choice', 'short_answer_group', 'summary_completion', 'matching_headings', 'multiple_choice_multiple'],
                            'gradient'       => 'linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%)',
                            'btn_color'      => '#0284c7',
                            'icon_color'     => '#0ea5e9',
                            'available'      => true,
                            'material_id'    => 10,
                        ],
                        11 => [
                            'title'          => 'Practice Test 11',
                            'passages'       => ['decibel Hell', 'TV Addiction 1', 'Communication in science'],
                            'question_types' => ['matching_paragraph_information', 'true_false_not_given', 'multiple_choice', 'short_answer_group', 'summary_completion', 'matching_headings', 'multiple_choice_multiple'],
                            'gradient'       => 'linear-gradient(135deg, #ec4899 0%, #f43f5e 100%)', // Using a new gradient, e.g., from Test 5
                            'btn_color'      => '#db2777', // Using a new btn_color, e.g., from Test 5
                            'icon_color'     => '#ec4899', // Using a new icon_color, e.g., from Test 5
                            'available'      => true,
                            'material_id'    => 11,
                        ],
                        12 => [
                            'title'          => 'Practice Test 12',
                            'passages'       => ['Food for thought 2', 'Biodiversity', 'Soviet’s New Working Week'],
                            'question_types' => ['matching_headings', 'short_answer_group', 'multiple_choice', 'true_false_not_given', 'summary_completion'],
                            'gradient'       => 'linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%)', // Purple gradient
                            'btn_color'      => '#7c3aed',
                            'icon_color'     => '#6d28d9',
                            'available'      => true,
                            'material_id'    => 12,
                        ],
                        13 => [
                            'title'          => 'Practice Test 13',
                            'passages'       => ['Learning By Examples', 'Tasmanian Tiger', 'Music: Language We All Speak'],
                            'question_types' => ['matching_paragraph_information', 'true_false_not_given', 'summary_completion', 'matching_features', 'multiple_choice', 'matching_headings'],
                            'gradient'       => 'linear-gradient(135deg, #14b8a6 0%, #0f766e 100%)', // Teal gradient
                            'btn_color'      => '#0d9488',
                            'icon_color'     => '#0f766e',
                            'available'      => true,
                            'material_id'    => 13,
                        ],
                        14 => [
                            'title'          => 'Practice Test 14',
                            'passages'       => ['Dirty river but clean water', 'Seed Hunting', 'The significant role of mother tongue language in education'],
                            'question_types' => ['true_false_not_given', 'summary_completion', 'multiple_choice_multiple', 'multiple_choice', 'yes_no_not_given'],
                            'gradient'       => 'linear-gradient(135deg, #f59e0b 0%, #b45309 100%)', // Amber gradient
                            'btn_color'      => '#d97706',
                            'icon_color'     => '#b45309',
                            'available'      => true,
                            'material_id'    => 14,
                        ],
                        15 => [
                            'title'          => 'Practice Test 15',
                            'passages'       => ['Bamboo, A Wonder Plant', 'Activities for Children', 'Save Endangered Language'],
                            'question_types' => ['matching_paragraph_information', 'matching_features', 'short_answer', 'true_false_not_given', 'multiple_choice', 'matching_headings'],
                            'gradient'       => 'linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%)', // Violet gradient
                            'btn_color'      => '#7c3aed',
                            'icon_color'     => '#6d28d9',
                            'available'      => true,
                            'material_id'    => 15,
                        ],
                        16 => [
                            'title'          => 'Practice Test 16',
                            'passages'       => ['LEISURE TIME IN AMERICA', 'RECLAIMING THE NIGHT', 'THE DRINKING OF WINE'],
                            'question_types' => ['matching_headings', 'multiple_choice', 'matching_paragraph_information', 'summary_completion', 'matching_features'],
                            'gradient'       => 'linear-gradient(135deg, #ec4899 0%, #be185d 100%)', // Pink gradient
                            'btn_color'      => '#db2777',
                            'icon_color'     => '#be185d',
                            'available'      => true,
                            'material_id'    => 16,
                        ],
                        17 => [
                            'title'          => 'Practice Test 17',
                            'passages'       => ['LONGAEVA: Ancient Bristlecone Pine', 'Corporate Social Responsibility', 'The Exploration of Mars'],
                            'question_types' => ['matching_paragraph_information', 'multiple_choice', 'summary_completion', 'matching_headings', 'matching_features', 'true_false_not_given'],
                            'gradient'       => 'linear-gradient(135deg, #14b8a6 0%, #0f766e 100%)', // Teal gradient
                            'btn_color'      => '#0d9488',
                            'icon_color'     => '#0f766e',
                            'available'      => true,
                            'material_id'    => 17,
                        ],
                        18 => [
                            'title'          => 'Practice Test 18',
                            'passages'       => ['California’s age of Megafires', 'Ancient Storytelling', 'Paper of Computer?'],
                            'question_types' => ['summary_completion', 'multiple_choice', 'true_false_not_given', 'matching_paragraph_information', 'matching_features', 'short_answer_group', 'matching_headings'],
                            'gradient'       => 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)', // Amber gradient
                            'btn_color'      => '#f59e0b',
                            'icon_color'     => '#d97706',
                            'available'      => true,
                            'material_id'    => 18,
                        ],
                        19 => [
                            'title'          => 'Practice Test 19',
                            'passages'       => ['What are you laughing at?', 'Leaf-Cutting Ants and Fungus', 'Assessing the risk'],
                            'question_types' => ['matching_features', 'summary_completion', 'true_false_not_given', 'matching_paragraph_information', 'multiple_choice'],
                            'gradient'       => 'linear-gradient(135deg, #10b981 0%, #047857 100%)', // Emerald gradient
                            'btn_color'      => '#10b981',
                            'icon_color'     => '#047857',
                            'available'      => true,
                            'material_id'    => 19,
                        ],
                        20 => [
                            'title'          => 'Practice Test 20',
                            'passages'       => ['SOSUS: Listening to the Ocean', 'Left-handed or Right-handed', 'The Power of Nothing'],
                            'question_types' => ['true_false_not_given', 'matching_paragraph_information', 'multiple_choice', 'matching_features', 'yes_no_not_given'],
                            'gradient'       => 'linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%)', // Violet gradient
                            'btn_color'      => '#8b5cf6',
                            'icon_color'     => '#6d28d9',
                            'available'      => true,
                            'material_id'    => 20,
                        ]
                    ];
                @endphp

                @foreach($tests as $num => $test)
                    @php
                        $hasAnswerKey = in_array((int) ($test['material_id'] ?? 0), $answerKeyMaterialIds ?? [], true);
                    @endphp
                    <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col {{ !$test['available'] ? 'opacity-60' : 'hover:-translate-y-1' }} transform">

                        <!-- Card Top Banner -->
                        <div style="background: {{ $test['gradient'] }}" class="p-6 relative">
                            @if($test['available'])
                                <div class="absolute top-4 right-4 flex flex-col items-end gap-2">
                                    <span class="px-3 py-1 bg-white/25 text-white backdrop-blur-sm rounded-full text-xs font-bold uppercase tracking-wide border border-white/40 shadow-sm">
                                        PRACTICE
                                    </span>
                                    @if(auth()->check() && auth()->user()->isAdmin())
                                        <span class="px-3 py-1.5 rounded-full text-xs font-semibold border shadow-sm whitespace-nowrap {{ $hasAnswerKey ? 'bg-emerald-50 text-emerald-900 border-emerald-300' : 'bg-rose-50 text-rose-900 border-rose-300' }}">
                                            {{ $hasAnswerKey ? '✓ Kunci Ditambahkan' : '✕ Belum Ada Kunci' }}
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span class="absolute top-4 right-4 px-3 py-1 bg-white/20 text-white rounded-full text-xs font-bold uppercase tracking-wide border border-white/30">
                                    COMING SOON
                                </span>
                            @endif

                            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-md mb-4">
                                <svg style="color: {{ $test['icon_color'] }}" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            @php
                                $formatType = function($type) {
                                    $labels = [
                                        'true_false' => 'True/False',
                                        'short_answer_group' => 'Short Answer',
                                        'yes_no_not_given' => 'Y/N/Not Given',
                                        'summary_completion' => 'Summary Cpl.',
                                        'multiple_choice' => 'Multiple Choice',
                                        'matching_sentence_endings' => 'Matching Sentences',
                                        'matching_paragraph_information' => 'Matching Paragraphs',
                                        'sentence_completion' => 'Sentence Cpl.',
                                        'true_false_not_given' => 'T/F/Not Given',
                                        'matching_features' => 'Matching Features',
                                    ];
                                    return $labels[$type] ?? ucwords(str_replace('_', ' ', $type));
                                };
                            @endphp
                            <h3 class="text-white text-xl font-bold">{{ $test['title'] }}</h3>
                            <p class="text-white/80 text-sm mt-1">3 passages · 40 questions · 60 min</p>

                            @if(isset($test['question_types']) && count($test['question_types']) > 0)
                                <div class="mt-3 flex flex-wrap items-center gap-1">
                                    @foreach($test['question_types'] as $index => $type)
                                        <span class="text-[10px] text-white/80 uppercase tracking-wider font-medium">{{ $formatType($type) }}</span>
                                        @if($index < count($test['question_types']) - 1)
                                            <span class="text-white/40 font-bold mx-0.5">·</span>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 flex flex-col flex-1">
                            <ul class="space-y-2 mb-6 flex-1">
                                @foreach($test['passages'] as $i => $passageTitle)
                                    <li class="flex items-center gap-2 text-sm text-gray-600">
                                        <span class="flex-none w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center text-xs font-bold text-gray-500">{{ $i + 1 }}</span>
                                        {{ $passageTitle }}
                                    </li>
                                @endforeach
                            </ul>

                            @if($test['available'] && $test['material_id'])
                                <a href="{{ route('assignments.ielts-academic.reading.material', $test['material_id']) }}"
                                   style="background-color: {{ $test['btn_color'] }}"
                                   class="block w-full py-3 text-white text-center rounded-xl font-bold transition shadow hover:shadow-md active:scale-95 hover:opacity-90">
                                    @if(!empty($isClassEnded) && Auth::user()->isStudent())
                                        Kerjakan Ulang ↺
                                    @else
                                        Start Practice →
                                    @endif
                                </a>
                            @else
                                <button disabled
                                        class="block w-full py-3 bg-gray-200 text-gray-400 text-center rounded-xl font-bold cursor-not-allowed">
                                    Coming Soon
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

    </div>
</div>
@endsection
