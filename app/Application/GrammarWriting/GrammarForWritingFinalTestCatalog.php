<?php

namespace App\Application\GrammarWriting;

class GrammarForWritingFinalTestCatalog
{
    public function getData(?string $variant = null): array
    {
        return match ($variant) {
            'introductory' => $this->getIntroductoryData(),
            'complexity' => $this->getComplexityData(),
            'proficiency' => $this->getProficiencyData(),
            default => $this->getFastTrackData(),
        };
    }

    public function getIntroductoryData(): array
    {
        $p1_id = 'Setiap hari, jutaan siswa di seluruh dunia menggunakan platform pembelajaran digital untuk meningkatkan keterampilan bahasa Inggris mereka. Metode belajar modern ini sangat efektif karena materi interaktif disediakan oleh guru-guru berpengalaman tanpa batasan geografis. Siswa yang termotivasi selalu berlatih secara konsisten agar mereka dapat menguasai komunikasi internasional dengan percaya diri. Oleh karena itu, institusi pendidikan harus menyediakan fasilitas internet yang stabil bagi semua peserta didik.';
        $p1_en = 'Every day, millions of students around the world use digital learning platforms to improve their English skills. This modern learning method is very effective because interactive materials are provided by experienced teachers without geographical boundaries. Motivated students always practice consistently so that they can master international communication with confidence. Therefore, educational institutions must provide stable internet facilities for all learners.';

        $p2_id = 'Tahun lalu, banyak sekolah tidak menyelenggarakan kegiatan belajar tatap muka karena renovasi gedung besar-besaran dilakukan selama enam bulan. Para guru mengembangkan modul pembelajaran mandiri baru, dan perpustakaan digital dibangun dengan sukses untuk mendukung kebutuhan literasi siswa. Banyak murid yang awalnya merasa kesulitan akhirnya berhasil menyelesaikan ujian akhir dengan nilai yang memuaskan. Pengalaman tersebut mengajarkan kita bahwa adaptasi yang cepat dan kerja keras selalu membawa perubahan positif dalam pendidikan.';
        $p2_en = 'Last year, many schools did not organize face-to-face learning activities because major building renovations were conducted for six months. Teachers developed new independent learning modules, and a digital library was successfully built to support students\' literacy needs. Many students who initially felt difficulties finally succeeded in completing the final examination with satisfactory scores. That experience taught us that rapid adaptation and hard work always bring positive change in education.';

        $p3_id = 'Hingga saat ini, program pelatihan intensif ini telah membantu ribuan pembelajar mencapai kemajuan akademik yang luar biasa. Membaca artikel ilmiah dan menulis esai pendek secara teratur adalah kebiasaan penting yang memberikan siswa banyak manfaat berharga. Para tutor telah memberikan umpan balik yang konstruktif kepada setiap peserta untuk memperbaiki kesalahan tata bahasa mereka. Dengan mempraktikkan keterampilan ini secara berkelanjutan, para lulusan dapat membuka peluang karier yang cemerlang di kancah global.';
        $p3_en = 'Up to now, this intensive training program has helped thousands of learners achieve extraordinary academic progress. Reading scientific articles and writing short essays regularly are essential habits that give students many valuable benefits. Tutors have provided constructive feedback to every participant to correct their grammatical errors. By practicing these skills continuously, graduates can open bright career opportunities in the global arena.';

        $p1_vocab = [
            'Digital learning platforms' => ['id' => 'Platform pembelajaran digital', 'pos' => '(n)'],
            'Improve' => ['id' => 'Meningkatkan', 'pos' => '(v)'],
            'Effective' => ['id' => 'Efektif', 'pos' => '(adj)'],
            'Interactive materials' => ['id' => 'Materi interaktif', 'pos' => '(n)'],
            'Geographical boundaries' => ['id' => 'Batasan geografis', 'pos' => '(n)'],
            'Consistently' => ['id' => 'Secara konsisten', 'pos' => '(adv)'],
            'International communication' => ['id' => 'Komunikasi internasional', 'pos' => '(n)'],
            'Educational institutions' => ['id' => 'Institusi pendidikan', 'pos' => '(n)'],
            'Stable internet facilities' => ['id' => 'Fasilitas internet yang stabil', 'pos' => '(n)'],
        ];

        $p2_vocab = [
            'Face-to-face learning' => ['id' => 'Pembelajaran tatap muka', 'pos' => '(n)'],
            'Major building renovations' => ['id' => 'Renovasi gedung besar-besaran', 'pos' => '(n)'],
            'Independent learning modules' => ['id' => 'Modul pembelajaran mandiri', 'pos' => '(n)'],
            'Digital library' => ['id' => 'Perpustakaan digital', 'pos' => '(n)'],
            'Literacy needs' => ['id' => 'Kebutuhan literasi', 'pos' => '(n)'],
            'Initially' => ['id' => 'Pada awalnya', 'pos' => '(adv)'],
            'Satisfactory scores' => ['id' => 'Nilai yang memuaskan', 'pos' => '(n)'],
            'Rapid adaptation' => ['id' => 'Adaptasi yang cepat', 'pos' => '(n)'],
            'Positive change' => ['id' => 'Perubahan positif', 'pos' => '(n)'],
        ];

        $p3_vocab = [
            'Intensive training program' => ['id' => 'Program pelatihan intensif', 'pos' => '(n)'],
            'Extraordinary academic progress' => ['id' => 'Kemajuan akademik yang luar biasa', 'pos' => '(n)'],
            'Scientific articles' => ['id' => 'Artikel ilmiah', 'pos' => '(n)'],
            'Essential habits' => ['id' => 'Kebiasaan penting', 'pos' => '(n)'],
            'Valuable benefits' => ['id' => 'Manfaat berharga', 'pos' => '(n)'],
            'Constructive feedback' => ['id' => 'Umpan balik yang konstruktif', 'pos' => '(n)'],
            'Grammatical errors' => ['id' => 'Kesalahan tata bahasa', 'pos' => '(n)'],
            'Continuously' => ['id' => 'Secara berkelanjutan', 'pos' => '(adv)'],
            'Bright career opportunities' => ['id' => 'Peluang karier yang cemerlang', 'pos' => '(n)'],
            'Global arena' => ['id' => 'Kancah global', 'pos' => '(n)'],
        ];

        return [
            'track_title' => 'Grammar for Writing Introductory',
            'duration_minutes' => 45,
            'summary_badge' => 'Summary Modul Introductory (A2 - Pre-Intermediate)',
            'description' => 'Ujian akhir komprehensif penerjemahan naskah esai (3 paragraf) yang menguji penguasaan tata bahasa dasar: Simple Present (verbal, nominal, pasif), Simple Past (verbal, pasif, negatif), Present Perfect, To Infinitive, Gerund, Modals, dan Noun Phrase.',
            'full_text_id' => $p1_id . "\n\n" . $p2_id . "\n\n" . $p3_id,
            'full_text_en' => $p1_en . "\n\n" . $p2_en . "\n\n" . $p3_en,
            'modules_covered' => [
                [
                    'num' => 1,
                    'tag' => 'M1 & M2',
                    'name' => 'Simple Present Verbal & Nominal',
                    'color' => 'blue',
                    'regex' => '/\b(use|uses|is|are|practice|practices|master|masters)\b/i',
                    'description' => 'Pola dasar Simple Present aktif dan nominal (use digital platforms, is very effective).',
                ],
                [
                    'num' => 2,
                    'tag' => 'M1b',
                    'name' => 'Simple Present Passive Voice',
                    'color' => 'indigo',
                    'regex' => '/\b(is|are)\s+(provided|supported|used|required)\b/i',
                    'description' => 'Konstruksi pasif present (are provided by experienced teachers).',
                ],
                [
                    'num' => 3,
                    'tag' => 'M3b & M4a',
                    'name' => 'Simple Past Verbal & Irregular Verbs',
                    'color' => 'rose',
                    'regex' => '/\b(developed|felt|taught|succeeded|built)\b/i',
                    'description' => 'Penggunaan kata kerja lampau bentuk kedua / irregular verbs (developed, taught us, built).',
                ],
                [
                    'num' => 4,
                    'tag' => 'M4',
                    'name' => 'Simple Past Passive & Negative',
                    'color' => 'amber',
                    'regex' => '/\b(was|were)\s+([a-z]+ed|built)\b|\bdid not\s+[a-z]+/i',
                    'description' => 'Pola kalimat pasif lampau dan bentuk negatif lampau (were conducted, did not organize).',
                ],
                [
                    'num' => 5,
                    'tag' => 'M5',
                    'name' => 'Pronouns & Subject/Object References',
                    'color' => 'purple',
                    'regex' => '/\b(they|their|us|them|our)\b/i',
                    'description' => 'Ketepatan penggunaan kata ganti subjek, objek, dan kepemilikan.',
                ],
                [
                    'num' => 6,
                    'tag' => 'M7',
                    'name' => 'Present Perfect Tense',
                    'color' => 'emerald',
                    'regex' => '/\b(has|have)\s+([a-z]+ed|provided|helped|opened)\b/i',
                    'description' => 'Present perfect untuk aksi lampau dengan hasil kini (has helped thousands, have provided).',
                ],
                [
                    'num' => 7,
                    'tag' => 'M8a',
                    'name' => 'Modal Auxiliaries (can, must, should)',
                    'color' => 'teal',
                    'regex' => '/\b(can|must|should|may)\s+[a-z]+/i',
                    'description' => 'Kata kerja bantu modal (can master, must provide, can open).',
                ],
                [
                    'num' => 8,
                    'tag' => 'M3a & M8b',
                    'name' => 'To Infinitive & Gerunds',
                    'color' => 'sky',
                    'regex' => '/\bto\s+(improve|support|correct|open)\b|\b(reading|writing|practicing)\b/i',
                    'description' => 'To infinitive tujuan (to improve) dan gerund sebagai subjek / setelah preposisi (Reading..., by practicing).',
                ],
                [
                    'num' => 9,
                    'tag' => 'M9',
                    'name' => 'Complex Ditransitive Structures',
                    'color' => 'violet',
                    'regex' => '/\b(give|gives|gave|taught|provided)\s+[a-z\s]+\s+(feedback|benefits|change|lessons)\b/i',
                    'description' => 'Pola kata kerja dengan objek ganda (give students many valuable benefits).',
                ],
                [
                    'num' => 10,
                    'tag' => 'M9b & M10',
                    'name' => 'Noun Phrases & Conjunctions',
                    'color' => 'cyan',
                    'regex' => '/\b(so that|because|therefore)\b|\b[a-z]+\s+(platforms|modules|library|facilities|opportunities)\b/i',
                    'description' => 'Penyusunan frasa kata benda dan kata hubung dasar (so that, because, therefore).',
                ],
            ],
            'paragraphs' => [
                1 => [
                    'id' => 1,
                    'title' => 'Teknologi Pendidikan dan Pembelajaran Digital',
                    'focus' => 'Simple Present (M1), Passive Voice (M1b), To Infinitive (M3a), Modal must (M8a)',
                    'text_id' => $p1_id,
                    'text_en' => $p1_en,
                    'vocab' => $p1_vocab,
                    'grammar_targets' => [
                        [
                            'name' => 'Simple Present Verbal & Adverb of Frequency',
                            'pattern' => '/\b(use|uses|practice|practices)\b.*\b(consistently|always|every day)\b|\bevery day\b/i',
                            'hint' => 'Target: "use digital learning platforms", "always practice consistently"',
                            'weight' => 30,
                        ],
                        [
                            'name' => 'Present Passive Voice (are provided by...)',
                            'pattern' => '/\b(is|are)\s+provided\s+by\b/i',
                            'hint' => 'Target: "...materials are provided by experienced teachers..."',
                            'weight' => 25,
                        ],
                        [
                            'name' => 'To Infinitive of Purpose (to improve...)',
                            'pattern' => '/\bto\s+improve\b/i',
                            'hint' => 'Target: "...to improve their English skills."',
                            'weight' => 25,
                        ],
                        [
                            'name' => 'Conjunctions & Modals (so that they can..., must provide...)',
                            'pattern' => '/\bso that\s+they\s+can\b|\bmust\s+provide\b/i',
                            'hint' => 'Target: "so that they can master...", "must provide stable internet facilities"',
                            'weight' => 20,
                        ],
                    ],
                ],
                2 => [
                    'id' => 2,
                    'title' => 'Pengalaman Belajar dan Perubahan Pendidikan',
                    'focus' => 'Simple Past (M3b), Past Passive (M4a), Negative Past (M4b), Irregular Verbs (M6a)',
                    'text_id' => $p2_id,
                    'text_en' => $p2_en,
                    'vocab' => $p2_vocab,
                    'grammar_targets' => [
                        [
                            'name' => 'Past Negative (did not organize...)',
                            'pattern' => '/\bdid not\s+organize\b/i',
                            'hint' => 'Target: "...did not organize face-to-face learning activities..."',
                            'weight' => 30,
                        ],
                        [
                            'name' => 'Past Passive Voice (were conducted..., was built...)',
                            'pattern' => '/\bwere\s+conducted\b|\bwas\s+(successfully\s+)?built\b/i',
                            'hint' => 'Target: "renovations were conducted", "digital library was successfully built"',
                            'weight' => 25,
                        ],
                        [
                            'name' => 'Simple Past Irregular/Regular Verbs (developed, felt, taught)',
                            'pattern' => '/\b(developed|taught|succeeded)\b/i',
                            'hint' => 'Target: "Teachers developed new modules", "That experience taught us"',
                            'weight' => 25,
                        ],
                        [
                            'name' => 'Relative Clause & Prepositional Phrases',
                            'pattern' => '/\bwho\s+(initially\s+)?felt\b|\bfor\s+six\s+months\b/i',
                            'hint' => 'Target: "students who initially felt difficulties", "for six months"',
                            'weight' => 20,
                        ],
                    ],
                ],
                3 => [
                    'id' => 3,
                    'title' => 'Pencapaian Siswa dan Peluang Masa Depan',
                    'focus' => 'Present Perfect (M7), Gerund as Subject (M8b), Ditransitive (M9), By + Gerund (M8b)',
                    'text_id' => $p3_id,
                    'text_en' => $p3_en,
                    'vocab' => $p3_vocab,
                    'grammar_targets' => [
                        [
                            'name' => 'Present Perfect (has helped..., have provided...)',
                            'pattern' => '/\bhas\s+helped\b|\bhave\s+provided\b/i',
                            'hint' => 'Target: "has helped thousands of learners", "Tutors have provided constructive feedback"',
                            'weight' => 30,
                        ],
                        [
                            'name' => 'Gerund as Subject (Reading... and writing...)',
                            'pattern' => '/\breading\s+[a-z\s]+\s+and\s+writing\s+[a-z\s]+\s+are\b/i',
                            'hint' => 'Target: "Reading scientific articles and writing short essays regularly are essential habits..."',
                            'weight' => 25,
                        ],
                        [
                            'name' => 'Complex Ditransitive (give students many valuable benefits)',
                            'pattern' => '/\bgive\s+students\s+many\s+valuable\s+benefits\b/i',
                            'hint' => 'Target: "...habits that give students many valuable benefits."',
                            'weight' => 25,
                        ],
                        [
                            'name' => 'Preposition + Gerund & Modal (By practicing..., can open...)',
                            'pattern' => '/\bby\s+practicing\b|\bcan\s+open\b/i',
                            'hint' => 'Target: "By practicing these skills continuously, graduates can open bright career opportunities"',
                            'weight' => 20,
                        ],
                    ],
                ],
            ],
            'combined_vocab' => array_merge($p1_vocab, $p2_vocab, $p3_vocab),
            'collocations' => [],
            'idioms' => [],
        ];
    }

    public function getComplexityData(): array
    {
        $p1_id = 'Meskipun kota-kota modern berkembang lebih pesat daripada wilayah pedesaan di sekitarnya, pertumbuhan penduduk yang tidak terkendali menciptakan persoalan lingkungan yang semakin rumit. Tata kota yang baik harus mengintegrasikan ruang terbuka hijau dan sistem transportasi massal yang ramah lingkungan agar kualitas hidup masyarakat perkotaan meningkat secara signifikan. Para arsitek yang merancang gedung perkantoran ramah energi berusaha keras untuk mengurangi konsumsi listrik dan meminimalkan jejak karbon. Baik pemerintah daerah maupun sektor swasta harus bekerja sama untuk mewujudkan pembangunan berkelanjutan yang adil bagi seluruh warga.';
        $p1_en = 'Although modern cities are expanding more rapidly than the surrounding rural areas, uncontrolled population growth creates increasingly complicated environmental problems. Proper urban planning must integrate green open spaces and environmentally friendly mass transit systems so that the quality of life of urban residents improves significantly. Architects who design energy-friendly office buildings strive hard to reduce electricity consumption and minimize the carbon footprint. Both local governments and the private sector must work together to realize sustainable development that is equitable for all citizens.';

        $p2_id = 'Penggunaan platform digital tidak hanya memfasilitasi pertukaran informasi secara instan, tetapi juga memengaruhi interaksi psikologis generasi muda di era kontemporer. Para psikolog klinis yang rekomendasinya dipercaya oleh banyak institusi pendidikan menegaskan bahwa remaja yang kesehatan mentalnya terganggu oleh perundungan siber memerlukan bimbingan emosional yang intensif. Para peneliti sedang menyelidiki apakah paparan layar yang berlebihan secara langsung berkaitan dengan penurunan daya konsentrasi siswa di sekolah. Mereka yang para orang tuanya membatasi waktu gawai terbukti menunjukkan prestasi akademik yang jauh lebih stabil.';
        $p2_en = 'The use of digital platforms not only facilitates the instant exchange of information, but also influences the psychological interactions of the younger generation in the contemporary era. Clinical psychologists whose recommendations are trusted by many educational institutions emphasize that teenagers whose mental health is impaired by cyberbullying require intensive emotional guidance. Researchers are currently investigating whether excessive screen exposure is directly linked to the decline of students\' concentration spans in schools. Those whose parents restrict device usage have been proven to demonstrate substantially more stable academic performance.';

        $p3_id = 'Karena globalisasi terus mengikis batas-batas kultural, pelestarian warisan tradisi lokal menjadi salah satu prioritas terpenting bagi generasi penerus. Museum bersejarah dan situs purbakala tempat masyarakat belajar mengenai peradaban masa lampau harus dilindungi dari kerusakan fisik maupun komersialisasi berlebihan. Para budayawan menjelaskan mengapa kearifan lokal merupakan fondasi utama yang mendasari apa yang membuat identitas nasional dapat bertahan kokoh. Dengan mendokumentasikan tradisi lisan melalui teknologi arsip digital, generasi muda dapat memastikan bahwa nilai-nilai luhur nenek moyang tidak akan pernah terlupakan.';
        $p3_en = 'Since globalization continues to erode cultural boundaries, the preservation of local traditional heritage has become one of the most vital priorities for future generations. Historical museums and ancient sites where communities learn about past civilizations must be protected from physical damage as well as excessive commercialization. Cultural experts explain why indigenous wisdom is the primary foundation underlying what makes national identity endure firmly. By documenting oral traditions through digital archival technology, younger generations can ensure that the noble values of their ancestors will never be forgotten.';

        $p1_vocab = [
            'Surrounding rural areas' => ['id' => 'Wilayah pedesaan di sekitarnya', 'pos' => '(n)'],
            'Uncontrolled population growth' => ['id' => 'Pertumbuhan penduduk tidak terkendali', 'pos' => '(n)'],
            'Proper urban planning' => ['id' => 'Tata kota yang baik', 'pos' => '(n)'],
            'Green open spaces' => ['id' => 'Ruang terbuka hijau', 'pos' => '(n)'],
            'Mass transit systems' => ['id' => 'Sistem transportasi massal', 'pos' => '(n)'],
            'Urban residents' => ['id' => 'Masyarakat perkotaan', 'pos' => '(n)'],
            'Energy-friendly' => ['id' => 'Ramah energi', 'pos' => '(adj)'],
            'Electricity consumption' => ['id' => 'Konsumsi listrik', 'pos' => '(n)'],
            'Carbon footprint' => ['id' => 'Jejak karbon', 'pos' => '(n)'],
            'Equitable' => ['id' => 'Adil / merata', 'pos' => '(adj)'],
        ];

        $p2_vocab = [
            'Instant exchange of information' => ['id' => 'Pertukaran informasi instan', 'pos' => '(n)'],
            'Contemporary era' => ['id' => 'Era kontemporer', 'pos' => '(n)'],
            'Clinical psychologists' => ['id' => 'Para psikolog klinis', 'pos' => '(n)'],
            'Impaired' => ['id' => 'Terganggu / rusak', 'pos' => '(adj)'],
            'Cyberbullying' => ['id' => 'Perundungan siber', 'pos' => '(n)'],
            'Intensive emotional guidance' => ['id' => 'Bimbingan emosional intensif', 'pos' => '(n)'],
            'Excessive screen exposure' => ['id' => 'Paparan layar berlebihan', 'pos' => '(n)'],
            'Concentration span' => ['id' => 'Daya konsentrasi', 'pos' => '(n)'],
            'Device usage' => ['id' => 'Penggunaan gawai', 'pos' => '(n)'],
            'Substantially more stable' => ['id' => 'Jauh lebih stabil', 'pos' => '(adj)'],
        ];

        $p3_vocab = [
            'Cultural boundaries' => ['id' => 'Batas-batas kultural', 'pos' => '(n)'],
            'Traditional heritage' => ['id' => 'Warisan tradisi', 'pos' => '(n)'],
            'Future generations' => ['id' => 'Generasi penerus', 'pos' => '(n)'],
            'Ancient sites' => ['id' => 'Situs purbakala', 'pos' => '(n)'],
            'Past civilizations' => ['id' => 'Peradaban masa lampau', 'pos' => '(n)'],
            'Excessive commercialization' => ['id' => 'Komersialisasi berlebihan', 'pos' => '(n)'],
            'Indigenous wisdom' => ['id' => 'Kearifan lokal', 'pos' => '(n)'],
            'Underlying' => ['id' => 'Mendasari', 'pos' => '(v/adj)'],
            'Oral traditions' => ['id' => 'Tradisi lisan', 'pos' => '(n)'],
            'Noble values' => ['id' => 'Nilai-nilai luhur', 'pos' => '(n)'],
        ];

        return [
            'track_title' => 'Grammar for Writing Complexity',
            'duration_minutes' => 45,
            'summary_badge' => 'Summary Modul Complexity (B1+ - Intermediate)',
            'description' => 'Ujian akhir komprehensif penerjemahan naskah esai (3 paragraf terpadu) yang menguji penguasaan klausa kompleks: Silang-Silang Tenses, Degree of Comparison, Parallel Structures, Adverbial Clauses (Time, Reason, Contrast, Condition), Adjective Clauses (RPS, RPO, RPP whose, RA where/why), dan Noun Clauses.',
            'full_text_id' => $p1_id . "\n\n" . $p2_id . "\n\n" . $p3_id,
            'full_text_en' => $p1_en . "\n\n" . $p2_en . "\n\n" . $p3_en,
            'modules_covered' => [
                [
                    'num' => 1,
                    'tag' => 'M1 & M2',
                    'name' => 'Silang-Silang Tenses dalam Kalimat Kompleks',
                    'color' => 'blue',
                    'regex' => '/\b(are expanding|creates|improves|strive|has become)\b/i',
                    'description' => 'Harmonisasi tenses dalam klausa bertingkat (present continuous, simple present, present perfect).',
                ],
                [
                    'num' => 2,
                    'tag' => 'M3',
                    'name' => 'To Infinitive & Gerunds dalam Kalimat Kompleks',
                    'color' => 'indigo',
                    'regex' => '/\b(to reduce|to realize|by documenting|to minimize)\b/i',
                    'description' => 'Penggunaan infinitive dan gerund untuk fungsi komplemen dan tujuan.',
                ],
                [
                    'num' => 3,
                    'tag' => 'M4',
                    'name' => 'Degree of Comparison (Comparative & Superlative)',
                    'color' => 'rose',
                    'regex' => '/\b(more rapidly than|more complicated|more stable|most vital|most)\b/i',
                    'description' => 'Konstruksi perbandingan komparatif dan superlatif (more rapidly than, most vital priorities).',
                ],
                [
                    'num' => 4,
                    'tag' => 'M5',
                    'name' => 'Parallel Structures (Both... and / Not only... but also)',
                    'color' => 'amber',
                    'regex' => '/\b(both\s+[a-z\s]+\s+and|not only\s+[a-z\s]+\s+but also)\b/i',
                    'description' => 'Struktur berpasangan paralel (Both local governments and..., not only facilitates... but also).',
                ],
                [
                    'num' => 5,
                    'tag' => 'M6a',
                    'name' => 'Adverbial Clause of Contrast (Although...)',
                    'color' => 'purple',
                    'regex' => '/\balthough\s+[a-z\s]+,/i',
                    'description' => 'Klausa pertentangan di awal kalimat (Although modern cities are expanding...).',
                ],
                [
                    'num' => 6,
                    'tag' => 'M6b',
                    'name' => 'Adverbial Clause of Reason & Purpose (Since..., so that...)',
                    'color' => 'emerald',
                    'regex' => '/\bsince\s+[a-z\s]+,|\bso that\s+[a-z\s]+\s+(improves|can)\b/i',
                    'description' => 'Klausa alasan dan tujuan (Since globalization continues..., so that quality of life improves).',
                ],
                [
                    'num' => 7,
                    'tag' => 'M7',
                    'name' => 'Adjective Clause - RPS (who / that sebagai subjek)',
                    'color' => 'teal',
                    'regex' => '/\b(who design|that is equitable|which creates)\b/i',
                    'description' => 'Klausa relatif subjek (Architects who design..., development that is equitable).',
                ],
                [
                    'num' => 8,
                    'tag' => 'M8a',
                    'name' => 'Adjective Clause - RPP (whose)',
                    'color' => 'sky',
                    'regex' => '/\bwhose\s+(recommendations|mental health|parents)\b/i',
                    'description' => 'Klausa kepemilikan whose (whose recommendations are trusted, whose mental health is impaired).',
                ],
                [
                    'num' => 9,
                    'tag' => 'M8b',
                    'name' => 'Adjective Clause - RA (where / why)',
                    'color' => 'violet',
                    'regex' => '/\b(where\s+communities\s+learn|explain\s+why)\b/i',
                    'description' => 'Relative adverb tempat dan alasan (sites where communities learn, explain why wisdom is...).',
                ],
                [
                    'num' => 10,
                    'tag' => 'M9',
                    'name' => 'Noun Clause (Whether / What / That)',
                    'color' => 'cyan',
                    'regex' => '/\b(whether\s+excessive|what\s+makes|that\s+the\s+noble|emphasize\s+that)\b/i',
                    'description' => 'Klausa kata benda sebagai objek dan komplemen (investigating whether..., what makes national identity endure).',
                ],
            ],
            'paragraphs' => [
                1 => [
                    'id' => 1,
                    'title' => 'Pertumbuhan Urbanisasi dan Tata Kota Berkelanjutan',
                    'focus' => 'Adverbial Clause of Contrast (M6a), Comparative Degree (M4), RPS (M7), Parallel Both...and (M5)',
                    'text_id' => $p1_id,
                    'text_en' => $p1_en,
                    'vocab' => $p1_vocab,
                    'grammar_targets' => [
                        [
                            'name' => 'Adverbial Clause of Contrast (Although...) & Comparative',
                            'pattern' => '/\balthough\s+[a-z\s]+\s+more\s+rapidly\s+than\b/i',
                            'hint' => 'Target: "Although modern cities are expanding more rapidly than..."',
                            'weight' => 30,
                        ],
                        [
                            'name' => 'Adverbial Clause of Purpose (so that [clause])',
                            'pattern' => '/\bso that\s+[a-z\s]+\s+(improves|can)\b/i',
                            'hint' => 'Target: "...so that the quality of life of urban residents improves significantly."',
                            'weight' => 25,
                        ],
                        [
                            'name' => 'Adjective Clause RPS (Architects who design...)',
                            'pattern' => '/\barchitects\s+who\s+design\b/i',
                            'hint' => 'Target: "Architects who design energy-friendly office buildings..."',
                            'weight' => 25,
                        ],
                        [
                            'name' => 'Parallel Structure (Both... and...) & Relative Clause (that is...)',
                            'pattern' => '/\bboth\s+local\s+governments\s+and\s+the\s+private\s+sector\b|\bthat\s+is\s+equitable\b/i',
                            'hint' => 'Target: "Both local governments and the private sector...", "that is equitable for all citizens"',
                            'weight' => 20,
                        ],
                    ],
                ],
                2 => [
                    'id' => 2,
                    'title' => 'Media Sosial, Kesehatan Mental, dan Etika Digital',
                    'focus' => 'Parallel Not only... but also (M5), RPP whose (M8a), Noun Clause whether (M9), Comparative (M4)',
                    'text_id' => $p2_id,
                    'text_en' => $p2_en,
                    'vocab' => $p2_vocab,
                    'grammar_targets' => [
                        [
                            'name' => 'Parallel Structure (not only facilitates..., but also influences...)',
                            'pattern' => '/\bnot only\s+facilitates\b.*\bbut\s+also\s+influences\b/i',
                            'hint' => 'Target: "...not only facilitates the instant exchange..., but also influences..."',
                            'weight' => 30,
                        ],
                        [
                            'name' => 'Adjective Clause RPP (whose recommendations..., whose mental health...)',
                            'pattern' => '/\bwhose\s+(recommendations|mental health|parents)\b/i',
                            'hint' => 'Target: "psychologists whose recommendations...", "teenagers whose mental health is impaired"',
                            'weight' => 25,
                        ],
                        [
                            'name' => 'Noun Clause as Object (investigating whether [clause])',
                            'pattern' => '/\b(investigating|investigate)\s+whether\b/i',
                            'hint' => 'Target: "...investigating whether excessive screen exposure is directly linked..."',
                            'weight' => 25,
                        ],
                        [
                            'name' => 'Comparative Degree with Modifier (substantially more stable)',
                            'pattern' => '/\b(substantially|much|far)\s+more\s+stable\b/i',
                            'hint' => 'Target: "...demonstrate substantially more stable academic performance."',
                            'weight' => 20,
                        ],
                    ],
                ],
                3 => [
                    'id' => 3,
                    'title' => 'Pelestarian Warisan Tradisi dan Kearifan Lokal',
                    'focus' => 'Adverbial Clause of Reason Since (M6b), Relative Adverbs where & why (M8b), Noun Clause what (M9)',
                    'text_id' => $p3_id,
                    'text_en' => $p3_en,
                    'vocab' => $p3_vocab,
                    'grammar_targets' => [
                        [
                            'name' => 'Initial Adverbial Clause of Reason (Since globalization continues...)',
                            'pattern' => '/\bsince\s+globalization\s+continues\s+to\s+erode\b/i',
                            'hint' => 'Target: "Since globalization continues to erode cultural boundaries,..."',
                            'weight' => 30,
                        ],
                        [
                            'name' => 'Relative Adverb of Place (sites where communities learn...)',
                            'pattern' => '/\b(sites|museums)\s+where\s+communities\s+learn\b/i',
                            'hint' => 'Target: "...ancient sites where communities learn about past civilizations..."',
                            'weight' => 25,
                        ],
                        [
                            'name' => 'Relative Adverb of Reason & Noun Clause (explain why... what makes...)',
                            'pattern' => '/\bexplain\s+why\b.*\bwhat\s+makes\b/i',
                            'hint' => 'Target: "...explain why indigenous wisdom is the primary foundation underlying what makes..."',
                            'weight' => 25,
                        ],
                        [
                            'name' => 'Noun Clause with That & Passive (ensure that... will never be forgotten)',
                            'pattern' => '/\bensure\s+that\b.*\bwill\s+never\s+be\s+forgotten\b/i',
                            'hint' => 'Target: "...ensure that the noble values of their ancestors will never be forgotten."',
                            'weight' => 20,
                        ],
                    ],
                ],
            ],
            'combined_vocab' => array_merge($p1_vocab, $p2_vocab, $p3_vocab),
            'collocations' => [],
            'idioms' => [],
        ];
    }

    public function getProficiencyData(): array
    {
        $p1_id = 'Jarang sekali para filsuf dan ilmuwan kognitif memperdebatkan sebuah lompatan teknologi dengan begitu intensif sebagaimana yang kita saksikan dalam akselerasi komputasi kuantum dan kecerdasan artifisial terkini. Telah menyaksikan otomatisasi sistemik merambah domain kreatif yang sebelumnya dianggap eksklusif milik manusia, para akademisi kini mempertanyakan hakikat sejati dari kesadaran sintetis. Adalah kemampuan untuk berempati moral dan refleksi filosofis mendalam yang membedakan akal budi manusia dari jaringan syaraf tiruan yang paling canggih sekalipun. Sekiranya regulasi etika global tidak segera diselaraskan, konsekuensi dari otonomi algoritmik yang tak terkontrol dapat mendestabilisasi fondasi hukum peradaban kita.';
        $p1_en = 'Rarely have philosophers and cognitive scientists debated a technological leap so intensively as what we witness in the recent acceleration of quantum computing and artificial intelligence. Having witnessed systemic automation encroach upon creative domains previously considered exclusively human, academics now question the veritable essence of synthetic consciousness. It is the capacity for moral empathy and profound philosophical reflection that distinguishes human intellect from even the most sophisticated artificial neural networks. Were global ethical regulations not to be harmonized promptly, the consequences of uncontrolled algorithmic autonomy could destabilize the juridical foundations of our civilization.';

        $p2_id = 'Yang paling menonjol di antara risiko sistemik makroekonomi saat ini adalah eskalasi utang berdaulat yang membebani kapasitas fiskal negara-negara berkembang. Seandainya bank sentral mengantisipasi tekanan inflasi global ini lebih awal, pengetatan moneter yang begitu agresif tentu tidak akan memicu kepanikan di pasar modal internasional. Struktur perekonomian kontemporer memang benar-benar memberikan tekanan disproporsional terhadap populasi yang rentan secara ekonomi. Apa yang dituntut oleh komunitas moneter internasional saat ini bukanlah semata-mata suntikan likuiditas darurat, melainkan restrukturisasi komprehensif atas arsitektur perbankan multilateral.';
        $p2_en = 'Prominent among current macroeconomic systemic risks is the escalation of sovereign debt burdening the fiscal capacity of developing economies. Had central banks anticipated these global inflationary pressures earlier, such aggressive monetary tightening certainly would not have triggered panic in international capital markets. Contemporary economic structures do indeed exert disproportionate pressure on economically vulnerable populations. What the international monetary community currently demands is not merely emergency liquidity injections, but rather a comprehensive restructuring of the multilateral banking architecture.';

        $p3_id = 'Dalam kondisi apa pun, komersialisasi ruang angkasa tidak boleh mengabaikan prinsip pelestarian orbit bumi yang berkelanjutan dari bahaya puing-puing satelit yang kian menumpuk. Didorong oleh ambisi geopolitik dan potensi penambangan asteroid bernilai triliunan dolar, ekspedisi luar angkasa kini bertransformasi menjadi arena kompetisi korporasi transnasional. Yang mendorong eksplorasi antariksa pada hakikatnya adalah dahaga primordial manusia akan penemuan ilmiah dan pemahaman atas asal-usul alam semesta. Hanya dengan menegakkan traktat kosmologis yang mengikat secara universal, komunitas global dapat menjamin bahwa luar angkasa tetap menjadi warisan bersama umat manusia.';
        $p3_en = 'Under no circumstances should the commercialization of outer space disregard the principles of sustainable orbital preservation against the hazard of increasingly accumulating satellite debris. Propelled by geopolitical ambitions and the multi-trillion-dollar potential of asteroid mining, space expeditions have now transformed into an arena of transnational corporate competition. What drives space exploration fundamentally is humanity\'s primordial thirst for scientific discovery and comprehension of the origins of the cosmos. Only by enforcing a universally binding cosmological treaty can the global community guarantee that outer space remains the common heritage of all mankind.';

        $p1_vocab = [
            'Cognitive scientists' => ['id' => 'Ilmuwan kognitif', 'pos' => '(n)'],
            'Technological leap' => ['id' => 'Lompatan teknologi', 'pos' => '(n)'],
            'Acceleration of quantum computing' => ['id' => 'Akselerasi komputasi kuantum', 'pos' => '(n)'],
            'Systemic automation' => ['id' => 'Otomatisasi sistemik', 'pos' => '(n)'],
            'Encroach upon' => ['id' => 'Merambah / melanggar batas', 'pos' => '(v)'],
            'Veritable essence' => ['id' => 'Hakikat sejati', 'pos' => '(n)'],
            'Synthetic consciousness' => ['id' => 'Kesadaran sintetis', 'pos' => '(n)'],
            'Moral empathy' => ['id' => 'Empati moral', 'pos' => '(n)'],
            'Artificial neural networks' => ['id' => 'Jaringan syaraf tiruan', 'pos' => '(n)'],
            'Harmonized promptly' => ['id' => 'Diselaraskan dengan segera', 'pos' => '(v)'],
            'Algorithmic autonomy' => ['id' => 'Otonomi algoritmik', 'pos' => '(n)'],
            'Juridical foundations' => ['id' => 'Fondasi hukum', 'pos' => '(n)'],
        ];

        $p2_vocab = [
            'Macroeconomic systemic risks' => ['id' => 'Risiko sistemik makroekonomi', 'pos' => '(n)'],
            'Sovereign debt' => ['id' => 'Utang berdaulat / utang negara', 'pos' => '(n)'],
            'Fiscal capacity' => ['id' => 'Kapasitas fiskal', 'pos' => '(n)'],
            'Inflationary pressures' => ['id' => 'Tekanan inflasi', 'pos' => '(n)'],
            'Monetary tightening' => ['id' => 'Pengetatan moneter', 'pos' => '(n)'],
            'Capital markets' => ['id' => 'Pasar modal', 'pos' => '(n)'],
            'Disproportionate pressure' => ['id' => 'Tekanan disproporsional', 'pos' => '(n)'],
            'Vulnerable populations' => ['id' => 'Populasi yang rentan', 'pos' => '(n)'],
            'Liquidity injections' => ['id' => 'Suntikan likuiditas', 'pos' => '(n)'],
            'Multilateral banking architecture' => ['id' => 'Arsitektur perbankan multilateral', 'pos' => '(n)'],
        ];

        $p3_vocab = [
            'Outer space commercialization' => ['id' => 'Komersialisasi ruang angkasa', 'pos' => '(n)'],
            'Orbital preservation' => ['id' => 'Pelestarian orbit', 'pos' => '(n)'],
            'Satellite debris' => ['id' => 'Puing-puing satelit', 'pos' => '(n)'],
            'Propelled by' => ['id' => 'Didorong oleh', 'pos' => '(participle)'],
            'Geopolitical ambitions' => ['id' => 'Ambisi geopolitik', 'pos' => '(n)'],
            'Asteroid mining' => ['id' => 'Penambangan asteroid', 'pos' => '(n)'],
            'Transnational corporate competition' => ['id' => 'Kompetisi korporasi transnasional', 'pos' => '(n)'],
            'Primordial thirst' => ['id' => 'Dahaga primordial / mendasar', 'pos' => '(n)'],
            'Origins of the cosmos' => ['id' => 'Asal-usul alam semesta', 'pos' => '(n)'],
            'Universally binding treaty' => ['id' => 'Traktat yang mengikat universal', 'pos' => '(n)'],
            'Common heritage of mankind' => ['id' => 'Warisan bersama umat manusia', 'pos' => '(n)'],
        ];

        return [
            'track_title' => 'Grammar for Writing Proficiency',
            'duration_minutes' => 45,
            'summary_badge' => 'Summary Modul Proficiency (C1 - C2 Advanced Mastery)',
            'description' => 'Ujian akhir komprehensif tingkat mahir berupa penerjemahan naskah ilmiah/akademik terpadu (3 paragraf) yang menguji struktur tingkat tinggi: Negative Inversion, Fronting, Cleft Sentences, Emphatic Structures, Nominalization, Reduced Participles, dan Inverted Conditionals.',
            'full_text_id' => $p1_id . "\n\n" . $p2_id . "\n\n" . $p3_id,
            'full_text_en' => $p1_en . "\n\n" . $p2_en . "\n\n" . $p3_en,
            'modules_covered' => [
                [
                    'num' => 1,
                    'tag' => 'M1',
                    'name' => 'Suffixes & Academic Morphological Derivation',
                    'color' => 'blue',
                    'regex' => '/\b[a-z]+(tion|ity|ment|ence|ance|ical|ible|able)\b/i',
                    'description' => 'Derivasi morfologis akademik (acceleration, consciousness, destabilize, juridical).',
                ],
                [
                    'num' => 2,
                    'tag' => 'M2',
                    'name' => 'Reduced Participle Clauses (-ing & -ed)',
                    'color' => 'indigo',
                    'regex' => '/\b(having witnessed|propelled by|previously considered)\b/i',
                    'description' => 'Klausa partisipial tereduksi (Having witnessed systemic automation..., Propelled by...).',
                ],
                [
                    'num' => 3,
                    'tag' => 'M3',
                    'name' => 'Abridgement, Ellipsis & Omission of Clauses',
                    'color' => 'rose',
                    'regex' => '/\b(previously considered|where delayed|burdening the fiscal)\b/i',
                    'description' => 'Abridgement dan ellipsis klausa untuk kepadatan sintaksis akademik.',
                ],
                [
                    'num' => 4,
                    'tag' => 'M4',
                    'name' => 'Negative Inversion (Rarely have..., Under no circumstances should...)',
                    'color' => 'amber',
                    'regex' => '/\b((rarely|seldom|scarcely)\s+(have|has|had|did)|under no circumstances\s+(should|must|can))\b/i',
                    'description' => 'Inversi pola kalimat negatif untuk penekanan retorika formal C1-C2.',
                ],
                [
                    'num' => 5,
                    'tag' => 'M5',
                    'name' => 'Fronting (Prominent among..., Only by...)',
                    'color' => 'purple',
                    'regex' => '/\b(prominent among|only by\s+[a-z]+ing)\b/i',
                    'description' => 'Fronting unsur adjektiva / preposisi untuk fokus informasi tematik.',
                ],
                [
                    'num' => 6,
                    'tag' => 'M6',
                    'name' => 'Cleft Sentences (It-cleft & Wh-cleft)',
                    'color' => 'emerald',
                    'regex' => '/\b(it is\s+[a-z\s]+\s+that|what\s+[a-z\s]+\s+(is|demands|drives))\b/i',
                    'description' => 'Konstruksi Cleft (It is the capacity... that distinguishes..., What the community demands is...).',
                ],
                [
                    'num' => 7,
                    'tag' => 'M7',
                    'name' => 'Emphatic Structures (Do-support & Lexical intensifiers)',
                    'color' => 'teal',
                    'regex' => '/\bdo\s+indeed\s+exert\b|\bveritable\s+essence\b/i',
                    'description' => 'Penekanan verba emotif/akademik (do indeed exert disproportionate pressure).',
                ],
                [
                    'num' => 8,
                    'tag' => 'M8',
                    'name' => 'Nominalization (High Informational Density)',
                    'color' => 'sky',
                    'regex' => '/\b(the escalation of sovereign debt|the commercialization of outer space)\b/i',
                    'description' => 'Nominalisasi kepadatan leksikal abstrak.',
                ],
                [
                    'num' => 9,
                    'tag' => 'M9a',
                    'name' => 'Inverted Conditionals (Had central banks..., Were regulations...)',
                    'color' => 'violet',
                    'regex' => '/\b(had\s+[a-z\s]+\s+(anticipated|intervened|not)|were\s+[a-z\s]+\s+(not to be|to be))\b/i',
                    'description' => 'Kondisional inversi tingkat tinggi tanpa if (Had central banks anticipated..., Were global regulations...).',
                ],
                [
                    'num' => 10,
                    'tag' => 'M10',
                    'name' => 'Restricting Inversion & Syntactic Integration',
                    'color' => 'cyan',
                    'regex' => '/\bonly by\s+[a-z\s]+can\s+the\s+global\s+community\b/i',
                    'description' => 'Sintesis sintaksis kompleks (Only by enforcing... can the global community guarantee...).',
                ],
            ],
            'paragraphs' => [
                1 => [
                    'id' => 1,
                    'title' => 'Epistemologi Kecerdasan Buatan dan Batasan Kognisi',
                    'focus' => 'Negative Inversion (M4), Participle Reduction (M2), It-Cleft (M6), Inverted Conditional (M9)',
                    'text_id' => $p1_id,
                    'text_en' => $p1_en,
                    'vocab' => $p1_vocab,
                    'grammar_targets' => [
                        [
                            'name' => 'Negative Inversion (Rarely have philosophers...)',
                            'pattern' => '/\brarely\s+have\s+(philosophers|cognitive)/i',
                            'hint' => 'Target: "Rarely have philosophers and cognitive scientists debated..."',
                            'weight' => 30,
                        ],
                        [
                            'name' => 'Perfect Participle Clause (Having witnessed...)',
                            'pattern' => '/\bhaving\s+witnessed\b/i',
                            'hint' => 'Target: "Having witnessed systemic automation encroach upon creative domains..."',
                            'weight' => 25,
                        ],
                        [
                            'name' => 'It-Cleft Sentence (It is the capacity for... that distinguishes...)',
                            'pattern' => '/\bit\s+is\s+the\s+capacity\s+for\b.*\bthat\s+distinguishes\b/i',
                            'hint' => 'Target: "It is the capacity for moral empathy... that distinguishes human intellect..."',
                            'weight' => 25,
                        ],
                        [
                            'name' => 'Inverted Conditional (Were global regulations not to be...)',
                            'pattern' => '/\bwere\s+global\s+ethical\s+regulations\s+not\s+to\s+be\b/i',
                            'hint' => 'Target: "Were global ethical regulations not to be harmonized promptly,..."',
                            'weight' => 20,
                        ],
                    ],
                ],
                2 => [
                    'id' => 2,
                    'title' => 'Risiko Utang Makroekonomi dan Reformasi Perbankan',
                    'focus' => 'Adjective Fronting (M5), Past Inverted Conditional (M9), Emphatic Do (M7), Wh-Cleft (M6)',
                    'text_id' => $p2_id,
                    'text_en' => $p2_en,
                    'vocab' => $p2_vocab,
                    'grammar_targets' => [
                        [
                            'name' => 'Adjective / Predicate Fronting (Prominent among... is...)',
                            'pattern' => '/\bprominent\s+among\b.*\bis\s+the\s+escalation\b/i',
                            'hint' => 'Target: "Prominent among current macroeconomic systemic risks is the escalation of sovereign debt..."',
                            'weight' => 30,
                        ],
                        [
                            'name' => 'Past Inverted Conditional (Had central banks anticipated...)',
                            'pattern' => '/\bhad\s+central\s+banks\s+anticipated\b/i',
                            'hint' => 'Target: "Had central banks anticipated these global inflationary pressures earlier,..."',
                            'weight' => 25,
                        ],
                        [
                            'name' => 'Emphatic Structure (do indeed exert...)',
                            'pattern' => '/\bdo\s+indeed\s+exert\b/i',
                            'hint' => 'Target: "...do indeed exert disproportionate pressure on economically vulnerable populations."',
                            'weight' => 25,
                        ],
                        [
                            'name' => 'Wh-Cleft Sentence (What the community demands is...)',
                            'pattern' => '/\bwhat\s+the\s+international\s+monetary\s+community\b.*\bis\b/i',
                            'hint' => 'Target: "What the international monetary community currently demands is not merely..., but rather..."',
                            'weight' => 20,
                        ],
                    ],
                ],
                3 => [
                    'id' => 3,
                    'title' => 'Tata Kelola Antariksa dan Warisan Bersama Manusia',
                    'focus' => 'Negative Inversion (M4), Passive Participle (M2), Wh-Cleft (M6), Only by Inversion (M10)',
                    'text_id' => $p3_id,
                    'text_en' => $p3_en,
                    'vocab' => $p3_vocab,
                    'grammar_targets' => [
                        [
                            'name' => 'Negative Inversion (Under no circumstances should...)',
                            'pattern' => '/\bunder\s+no\s+circumstances\s+should\b/i',
                            'hint' => 'Target: "Under no circumstances should the commercialization of outer space disregard..."',
                            'weight' => 30,
                        ],
                        [
                            'name' => 'Past Participle Clause (Propelled by...)',
                            'pattern' => '/\bpropelled\s+by\b/i',
                            'hint' => 'Target: "Propelled by geopolitical ambitions and the multi-trillion-dollar potential..."',
                            'weight' => 25,
                        ],
                        [
                            'name' => 'Wh-Cleft Sentence (What drives space exploration is...)',
                            'pattern' => '/\bwhat\s+drives\s+space\s+exploration\b.*\bis\b/i',
                            'hint' => 'Target: "What drives space exploration fundamentally is humanity\'s primordial thirst..."',
                            'weight' => 25,
                        ],
                        [
                            'name' => 'Restricting Inversion (Only by enforcing... can the community guarantee)',
                            'pattern' => '/\bonly\s+by\s+enforcing\b.*\bcan\s+the\s+global\s+community\s+guarantee\b/i',
                            'hint' => 'Target: "Only by enforcing a universally binding cosmological treaty can the global community guarantee..."',
                            'weight' => 20,
                        ],
                    ],
                ],
            ],
            'combined_vocab' => array_merge($p1_vocab, $p2_vocab, $p3_vocab),
            'collocations' => [],
            'idioms' => [],
        ];
    }

    public function getFastTrackData(): array
    {
        $p1_id = 'Meskipun industrialisasi modern telah mendorong pertumbuhan ekonomi global secara dramatis, eksploitasi bahan bakar fosil yang berlebihan telah memicu degradasi biosfer yang belum pernah terjadi sebelumnya. Para ilmuwan iklim menegaskan bahwa pemanasan global bukan hanya sekadar fluktuasi siklus alami, melainkan ancaman eksistensial yang memerlukan dekarbonisasi mendesak. Jarang sekali komunitas internasional menghadapi krisis lingkungan yang begitu kompleks di mana keterlambatan tindakan dapat menyebabkan titik kritis iklim yang ireversibel. Oleh karena itu, pemerintah harus mengalokasikan investasi strategis untuk mempercepat adopsi teknologi energi terbarukan, dan sektor swasta harus mentransformasikan model operasional industri mereka agar emisi karbon dapat ditekan secara signifikan.';
        $p1_en = 'Although modern industrialization has driven global economic growth dramatically, the excessive exploitation of fossil fuels has triggered unprecedented biosphere degradation. Climate scientists emphasize that global warming is not merely a natural cyclical fluctuation, but an existential threat that requires urgent decarbonization. Rarely has the international community confronted such a complex environmental crisis where delayed action could trigger irreversible climate tipping points. Therefore, governments must allocate strategic investments to accelerate the adoption of renewable energy technologies, and the private sector must transform their industrial operational models so that carbon emissions can be significantly reduced.';

        $p2_id = 'Semakin canggih sistem kecerdasan buatan berkembang, semakin mendalam pengaruhnya dalam merevolusi metodologi penelitian biomedis kontemporer. Dengan memanfaatkan algoritma pembelajaran mesin tingkat lanjut, para peneliti kedokteran yang laboratoriumnya dilengkapi dengan superkomputer kuantum dapat memprediksi struktur pelipatan protein secara jauh lebih akurat daripada metode konvensional. Bahwa rekayasa genetika berbasis CRISPR menawarkan potensi kuratif luar biasa bagi penyakit herediter langka merupakan terobosan ilmiah yang paling revolusioner di abad kedua puluh satu. Namun, komisi bioetika internasional memusatkan pengawasan ketat pada bagaimana teknologi penyuntingan genom ini diterapkan untuk mencegah modifikasi eugenika yang tidak etis pada embrio manusia.';
        $p2_en = 'The more sophisticated artificial intelligence systems become, the more profound their influence in revolutionizing contemporary biomedical research methodologies. By utilizing advanced machine learning algorithms, medical researchers whose laboratories are equipped with quantum supercomputers can predict protein folding structures substantially more accurately than conventional methods. That CRISPR-based genetic engineering offers extraordinary curative potential for rare hereditary diseases is the most revolutionary scientific breakthrough in the twenty-first century. However, international bioethics commissions concentrate strict oversight on how this genome editing technology is applied in order to prevent unethical eugenic modifications in human embryos.';

        $p3_id = 'Dalam lanskap ekonomi pascapandemi yang dinamis, negara-negara berkembang menghadapi tantangan ganda antara mempertahankan stabilitas makroekonomi dan mendanai infrastruktur hijau. Tidak hanya beban utang luar negeri membatasi ruang fiskal nasional, tetapi fluktuasi suku bunga global juga memperlambat laju investasi asing langsung. Lembaga multilateral, ketika merancang paket bantuan finansial, harus memastikan apakah mekanisme restrukturisasi utang selaras dengan target pembangunan berkelanjutan. Para ekonom yang rekomendasinya diakui secara global berpendapat bahwa kolaborasi strategis antara institusi perbankan dan otoritas moneter merupakan faktor penentu utama yang menjelaskan mengapa pemulihan ekonomi dapat bertahan lama.';
        $p3_en = 'In the dynamic post-pandemic economic landscape, developing nations confront the dual challenge of maintaining macroeconomic stability and financing green infrastructure. Not only do external debt burdens constrain national fiscal space, but global interest rate fluctuations also decelerate the pace of foreign direct investment. Multilateral institutions, while designing financial assistance packages, must ascertain whether debt restructuring mechanisms align with sustainable development goals. Economists whose recommendations are globally recognized argue that strategic collaboration between banking institutions and monetary authorities is the primary decisive factor explaining why economic recovery can endure sustainably.';

        $p1_vocab = [
            'Modern industrialization' => ['id' => 'Industrialisasi modern', 'pos' => '(n)'],
            'Excessive exploitation' => ['id' => 'Eksploitasi berlebihan', 'pos' => '(n)'],
            'Fossil fuels' => ['id' => 'Bahan bakar fosil', 'pos' => '(n)'],
            'Unprecedented' => ['id' => 'Belum pernah terjadi sebelumnya', 'pos' => '(adj)'],
            'Biosphere degradation' => ['id' => 'Degradasi biosfer', 'pos' => '(n)'],
            'Climate scientists' => ['id' => 'Para ilmuwan iklim', 'pos' => '(n)'],
            'Existential threat' => ['id' => 'Ancaman eksistensial', 'pos' => '(n)'],
            'Urgent decarbonization' => ['id' => 'Dekarbonisasi mendesak', 'pos' => '(n)'],
            'Confront' => ['id' => 'Menghadapi', 'pos' => '(v)'],
            'Irreversible tipping points' => ['id' => 'Titik kritis ireversibel', 'pos' => '(n)'],
            'Strategic investments' => ['id' => 'Investasi strategis', 'pos' => '(n)'],
            'Renewable energy technologies' => ['id' => 'Teknologi energi terbarukan', 'pos' => '(n)'],
            'Significantly reduced' => ['id' => 'Ditekan secara signifikan', 'pos' => '(v)'],
        ];

        $p2_vocab = [
            'Sophisticated' => ['id' => 'Canggih', 'pos' => '(adj)'],
            'Profound influence' => ['id' => 'Pengaruh mendalam', 'pos' => '(n)'],
            'Revolutionize' => ['id' => 'Merevolusi', 'pos' => '(v)'],
            'Biomedical research methodologies' => ['id' => 'Metodologi penelitian biomedis', 'pos' => '(n)'],
            'Machine learning algorithms' => ['id' => 'Algoritma machine learning', 'pos' => '(n)'],
            'Quantum supercomputers' => ['id' => 'Superkomputer kuantum', 'pos' => '(n)'],
            'Protein folding structures' => ['id' => 'Struktur pelipatan protein', 'pos' => '(n)'],
            'Curative potential' => ['id' => 'Potensi kuratif / penyembuhan', 'pos' => '(n)'],
            'Hereditary diseases' => ['id' => 'Penyakit herediter / genetik', 'pos' => '(n)'],
            'Breakthrough' => ['id' => 'Terobosan', 'pos' => '(n)'],
            'Bioethics commissions' => ['id' => 'Komisi bioetika', 'pos' => '(n)'],
            'Genome editing technology' => ['id' => 'Teknologi penyuntingan genom', 'pos' => '(n)'],
            'Eugenic modifications' => ['id' => 'Modifikasi eugenika', 'pos' => '(n)'],
            'Human embryos' => ['id' => 'Embrio manusia', 'pos' => '(n)'],
        ];

        $p3_vocab = [
            'Post-pandemic economic landscape' => ['id' => 'Lanskap ekonomi pascapandemi', 'pos' => '(n)'],
            'Developing nations' => ['id' => 'Negara-negara berkembang', 'pos' => '(n)'],
            'Dual challenge' => ['id' => 'Tantangan ganda', 'pos' => '(n)'],
            'Macroeconomic stability' => ['id' => 'Stabilitas makroekonomi', 'pos' => '(n)'],
            'Green infrastructure' => ['id' => 'Infrastruktur hijau', 'pos' => '(n)'],
            'External debt burdens' => ['id' => 'Beban utang luar negeri', 'pos' => '(n)'],
            'Constrain fiscal space' => ['id' => 'Membatasi ruang fiskal', 'pos' => '(v)'],
            'Decelerate the pace' => ['id' => 'Memperlambat laju', 'pos' => '(v)'],
            'Foreign direct investment' => ['id' => 'Investasi asing langsung', 'pos' => '(n)'],
            'Multilateral institutions' => ['id' => 'Lembaga multilateral', 'pos' => '(n)'],
            'Ascertain' => ['id' => 'Memastikan', 'pos' => '(v)'],
            'Debt restructuring mechanisms' => ['id' => 'Mekanisme restrukturisasi utang', 'pos' => '(n)'],
            'Sustainable development goals' => ['id' => 'Target pembangunan berkelanjutan', 'pos' => '(n)'],
            'Globally recognized' => ['id' => 'Diakui secara global', 'pos' => '(adj)'],
            'Primary decisive factor' => ['id' => 'Faktor penentu utama', 'pos' => '(n)'],
            'Endure sustainably' => ['id' => 'Bertahan lama / berkelanjutan', 'pos' => '(v)'],
        ];

        return [
            'track_title' => 'Grammar for Writing Fast Track',
            'duration_minutes' => 45,
            'summary_badge' => 'Summary 10 Pertemuan Fast Track',
            'description' => 'Ujian akhir komprehensif berupa penerjemahan 1 naskah artikel utuh (3 paragraf terpadu) yang merangkum seluruh kaidah grammar dari 10 pertemuan Fast Track.',
            'full_text_id' => $p1_id . "\n\n" . $p2_id . "\n\n" . $p3_id,
            'full_text_en' => $p1_en . "\n\n" . $p2_en . "\n\n" . $p3_en,
            'modules_covered' => [
                ['num' => 1, 'name' => 'Tenses Basic & Silang-Silang', 'tag' => 'M1 & M2', 'color' => 'blue', 'regex' => '/\b(has|have)\s+([a-z]+ed|driven|triggered|confronted|become|offered)\b/i', 'description' => 'Penggunaan Present Perfect tense secara presisi.'],
                ['num' => 2, 'name' => 'Modal Auxiliaries & Certainty', 'tag' => 'M3', 'color' => 'indigo', 'regex' => '/\b(must|should|could|might|may)\s+[a-z]+/i', 'description' => 'Modal auxiliary verbs (must allocate, must transform).'],
                ['num' => 3, 'name' => 'Negative Sentences & Inversion', 'tag' => 'M4', 'color' => 'rose', 'regex' => '/\b(rarely|seldom|scarcely)\s+(has|have|had|do|did)\b|\bnot only\s+(do|does|did|are|is)\b/i', 'description' => 'Inversi pola kalimat untuk penekanan formal.'],
                ['num' => 4, 'name' => 'To Infinitive & Gerunds', 'tag' => 'M5', 'color' => 'amber', 'regex' => '/\b(by|in)\s+([a-z]+ing)\b|\b(in order to|to)\s+(predict|prevent|accelerate)\b/i', 'description' => 'Preposisi diikuti gerund dan infinitive tujuan.'],
                ['num' => 5, 'name' => 'Noun Phrase & Comparison Degree', 'tag' => 'M6', 'color' => 'purple', 'regex' => '/\bthe\s+(more|less|greater|higher)\b.*,\s*the\s+(more|less|greater|profound)\b/i', 'description' => 'Struktur perbandingan korelatif ganda.'],
                ['num' => 6, 'name' => 'FANBOYS & Adverbial Clauses (3 Posisi)', 'tag' => 'M7', 'color' => 'emerald', 'regex' => '/^(although|while|even though)\b|,\s*(while|when|although)\s+[a-z\s]+,|\bso that\b/i', 'description' => 'Klausa adverbia di berbagai posisi.'],
                ['num' => 7, 'name' => 'Adjective Clause (RPS & RPO)', 'tag' => 'M8', 'color' => 'teal', 'regex' => '/\b(that|which)\s+(requires|offers|leads|triggers|demands)\b|\bwhere\s+[a-z]+/i', 'description' => 'Klausa relatif subjek dan objek.'],
                ['num' => 8, 'name' => 'Adjective Clause (RPP whose & RA)', 'tag' => 'M9', 'color' => 'sky', 'regex' => '/\bwhose\s+[a-z]+\s+(are|is|were)\b|\bwhy\s+[a-z]+/i', 'description' => 'Kepemilikan whose dan relative adverb why.'],
                ['num' => 9, 'name' => 'Noun Clause (4 Variasi Posisi)', 'tag' => 'M10', 'color' => 'violet', 'regex' => '/^that\s+[a-z\s]+\s+is\b|\bwhether\s+[a-z]+/i', 'description' => 'Noun clause sebagai subjek dan objek.'],
                ['num' => 10, 'name' => 'Prepositional Phrase (Adj & Adv)', 'tag' => 'M10', 'color' => 'cyan', 'regex' => '/^in the dynamic|\bbetween\s+[a-z\s]+and\b/i', 'description' => 'Frasa preposisi pembuka dan penjelas.'],
            ],
            'paragraphs' => [
                1 => [
                    'id' => 1,
                    'title' => 'Transisi Energi Global dan Krisis Ekologis',
                    'focus' => 'Tenses (M1/M2), Modal (M3), Negative Inversion (M4), Adverbial Clause (M7), RPS (M8)',
                    'text_id' => $p1_id,
                    'text_en' => $p1_en,
                    'vocab' => $p1_vocab,
                ],
                2 => [
                    'id' => 2,
                    'title' => 'Revolusi Kecerdasan Buatan dan Rekayasa Biomedis',
                    'focus' => 'Gerund & Infinitive (M5), Double Comparative (M6), RPP whose (M9), Noun Clause (M10)',
                    'text_id' => $p2_id,
                    'text_en' => $p2_en,
                    'vocab' => $p2_vocab,
                ],
                3 => [
                    'id' => 3,
                    'title' => 'Arsitektur Ekonomi Global dan Pembangunan Berkelanjutan',
                    'focus' => 'Negative Inversion (M4), Noun Phrase (M6), Middle Adv Clause (M7), RA why (M9), Prep Phrase (M10)',
                    'text_id' => $p3_id,
                    'text_en' => $p3_en,
                    'vocab' => $p3_vocab,
                ],
            ],
            'combined_vocab' => array_merge($p1_vocab, $p2_vocab, $p3_vocab),
            'collocations' => [],
            'idioms' => [],
        ];
    }
}
