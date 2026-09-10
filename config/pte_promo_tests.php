<?php

return [
    'speaking_writing' => [
        [
            'id' => 1,
            'title' => 'PTE Speaking & Writing Promo Test 1',
            'type' => 'pte_speaking_writing',
            'is_free_tier' => true,
            'promo_start' => null,
            'promo_deadline' => null,
            'questions' => [
                'read_aloud' => [
                    'text' => 'Climate change represents one of the most pressing global challenges of the twenty-first century. Rapid industrialization and deforestation have led to an unprecedented rise in greenhouse gas emissions, altering weather patterns and threatening biodiversity across all continents.',
                    'prep_time' => 35,
                    'record_time' => 40
                ],
                'repeat_sentence' => [
                    'text' => 'The university library provides quiet study areas and digital research databases for all enrolled students.',
                    'audio' => null
                ],
                'describe_image' => [
                    'title' => 'Global Renewable Energy Adoption Rates (2015-2025)',
                    'image' => '/images/practice/honey_production_process.png',
                    'type' => 'chart',
                    'prep_time' => 25,
                    'record_time' => 40
                ],
                'retell_lecture' => [
                    'title' => 'Urban Architecture and Sustainable City Planning',
                    'transcript' => 'Modern urban architecture must prioritize sustainability by integrating green roofs, solar power systems, and efficient public transportation networks to minimize carbon footprints in growing metropolitan regions.',
                    'prep_time' => 10,
                    'record_time' => 40
                ],
                'summarize_written_text' => [
                    'passage' => 'Artificial intelligence is revolutionizing modern healthcare systems worldwide. By analyzing vast medical datasets, AI algorithms can assist physicians in diagnosing complex diseases with higher precision and speed than traditional methods. Furthermore, predictive modeling allows hospitals to optimize resource allocation and personalize patient treatment plans. However, ethical concerns regarding data privacy and algorithmic bias remain critical topics of ongoing regulatory debate.',
                    'word_limit' => '5-75 words',
                    'time_limit' => 600
                ],
                'write_essay' => [
                    'topic' => 'Some educators believe that online learning will completely replace traditional classroom education in the near future. To what extent do you agree or disagree with this view? Support your argument with relevant examples.',
                    'word_limit' => '200-300 words',
                    'time_limit' => 1200
                ]
            ]
        ],
        [
            'id' => 2,
            'title' => 'PTE Speaking & Writing Promo Test 2',
            'type' => 'pte_speaking_writing',
            'is_free_tier' => true,
            'promo_start' => null,
            'promo_deadline' => null,
            'questions' => [
                'read_aloud' => [
                    'text' => 'Scientific research indicates that regular physical activity combined with a balanced nutritional intake significantly enhances cognitive performance and emotional resilience. Modern sedentary lifestyles frequently undermine these fundamental health principles.',
                    'prep_time' => 35,
                    'record_time' => 40
                ],
                'repeat_sentence' => [
                    'text' => 'All undergraduate students must submit their final thesis proposal before the end of the academic semester.',
                    'audio' => null
                ],
                'describe_image' => [
                    'title' => 'Mobile Application Download Trends (2020-2026)',
                    'image' => '/images/practice/tea_processing_flowchart.png',
                    'type' => 'flowchart',
                    'prep_time' => 25,
                    'record_time' => 40
                ],
                'retell_lecture' => [
                    'title' => 'Marine Ecosystem Conservation',
                    'transcript' => 'Ocean conservation initiatives play a vital role in maintaining global climate stability. Protecting coral reefs and reducing plastic pollution are essential strategies for preserving marine biodiversity.',
                    'prep_time' => 10,
                    'record_time' => 40
                ],
                'summarize_written_text' => [
                    'passage' => 'International tourism has expanded exponentially over the past few decades, becoming a vital economic driver for many developing nations. Foreign visitor spending creates employment opportunities, generates tax revenues, and stimulates local infrastructure development. Nevertheless, uncontrolled tourism growth often leads to environmental degradation, cultural commercialization, and strain on public utilities.',
                    'word_limit' => '5-75 words',
                    'time_limit' => 600
                ],
                'write_essay' => [
                    'topic' => 'Governments allocate substantial public funds towards space exploration programs. Is space exploration a wise investment of financial resources, or should national budgets prioritize addressing immediate Earth-bound challenges?',
                    'word_limit' => '200-300 words',
                    'time_limit' => 1200
                ]
            ]
        ]
    ],
    'reading' => [
        [
            'id' => 1,
            'title' => 'PTE Reading Promo Test 1',
            'type' => 'pte_reading',
            'is_free_tier' => true,
            'promo_start' => null,
            'promo_deadline' => null,
            'questions' => [
                'rw_fib' => [
                    'passage' => 'Recent archaeological excavations in Central America have [uncovered] remarkable remnants of ancient urban planning. Historians originally believed these early settlements were small rural communities; however, high-resolution satellite LiDAR scanning revealed vast, [interconnected] networks of causeways, reservoirs, and agricultural terraces.',
                    'options' => [
                        ['uncovered', 'hidden', 'forgotten', 'destroyed'],
                        ['interconnected', 'separated', 'isolated', 'fragmented']
                    ]
                ],
                'reorder' => [
                    'paragraphs' => [
                        'A solar panel converts sunlight directly into electrical energy through the photovoltaic effect.',
                        'This electrical current can then be stored in high-capacity lithium-ion batteries or supplied directly to the grid.',
                        'As solar cell efficiency improves, adoption rates across residential and industrial sectors continue to surge globally.',
                        'Consequently, solar technology has become one of the cheapest forms of clean energy generation available today.'
                    ],
                    'correct_order' => [0, 1, 3, 2]
                ],
                'reading_fib' => [
                    'passage' => 'Cognitive psychologists study memory [retention] by measuring how information is encoded, stored, and retrieved. Effective study strategies like spaced repetition significantly enhance long-term memory [consolidation].',
                    'drag_words' => ['retention', 'consolidation', 'distraction', 'suppression']
                ]
            ]
        ],
        [
            'id' => 2,
            'title' => 'PTE Reading Promo Test 2',
            'type' => 'pte_reading',
            'is_free_tier' => true,
            'promo_start' => null,
            'promo_deadline' => null,
            'questions' => [
                'rw_fib' => [
                    'passage' => 'The global transition toward renewable energy requires significant technological [innovation] in battery storage. Engineers are developing sodium-ion alternatives to mitigate reliance on lithium, which faces severe supply chain [constraints].',
                    'options' => [
                        ['innovation', 'stagnation', 'reduction', 'neglect'],
                        ['constraints', 'expansions', 'freedoms', 'surpluses']
                    ]
                ],
                'reorder' => [
                    'paragraphs' => [
                        'Deep-sea exploration relies on autonomous underwater vehicles capable of withstanding extreme pressure.',
                        'These specialized submersible probes carry advanced optical cameras and environmental sensors to ocean trenches.',
                        'Scientists analyze the captured sensory data to discover previously unknown hydrothermal vent species.',
                        'Such discoveries broaden our understanding of extremophile organisms and early biological evolution.'
                    ],
                    'correct_order' => [0, 1, 2, 3]
                ]
            ]
        ]
    ],
    'listening' => [
        [
            'id' => 1,
            'title' => 'PTE Listening Promo Test 1',
            'type' => 'pte_listening',
            'is_free_tier' => true,
            'promo_start' => null,
            'promo_deadline' => null,
            'questions' => [
                'sst' => [
                    'transcript' => 'Economic globalization has reshaped global supply chains over recent decades. While international trade agreements have reduced tariffs and spurred economic growth in emerging markets, recent geopolitical tensions have prompted many nations to re-evaluate supply chain resilience and nearshoring strategies.',
                    'prompt' => 'Summarize the spoken text in 50-70 words.',
                    'word_limit' => '50-70 words',
                    'time_limit' => 600
                ],
                'wfd' => [
                    'sentences' => [
                        'Extensive scientific research demonstrates that adequate sleep enhances memory consolidation.',
                        'The deadline for university scholarship applications has been extended until next Friday.',
                        'All incoming students must attend the orientation session in the main auditorium.'
                    ]
                ]
            ]
        ],
        [
            'id' => 2,
            'title' => 'PTE Listening Promo Test 2',
            'type' => 'pte_listening',
            'is_free_tier' => true,
            'promo_start' => null,
            'promo_deadline' => null,
            'questions' => [
                'sst' => [
                    'transcript' => 'Advances in artificial intelligence and machine learning are transforming biotechnology. Researchers are utilizing computational protein folding models to accelerate drug discovery, reducing the time required to design therapeutic molecules from years to months.',
                    'prompt' => 'Summarize the spoken text in 50-70 words.',
                    'word_limit' => '50-70 words',
                    'time_limit' => 600
                ],
                'wfd' => [
                    'sentences' => [
                        'Digital technology continues to transform modern agricultural production techniques.',
                        'Faculty members are encouraged to submit their research proposals before the end of term.'
                    ]
                ]
            ]
        ]
    ]
];
