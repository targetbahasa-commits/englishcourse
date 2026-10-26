<?php

namespace App\Services;

class SelfStudyPastContinuousPastPerfectData
{
    /**
     * Get the complete Past Continuous & Past Perfect Tenses (Timeline Sequencing) package.
     */
    public static function getPackage(): array
    {
        $subLessons = self::getSubLessons();
        $questions = [];

        foreach ($subLessons as $sl) {
            foreach ($sl['exercises'] as $ex) {
                $questions[] = [
                    'number' => (string) $ex['id'],
                    'prompt' => $ex['id_sentence'],
                    'options' => $ex['options'],
                    'correct_index' => $ex['correct_index'],
                    'explanation' => $ex['explanation'],
                    'sub_lesson' => $sl['name'],
                    'target_word' => $ex['target_word'] ?? '',
                    'vocab' => $ex['vocab'] ?? [],
                    'example' => $ex['example'] ?? null,
                ];
            }
        }

        return [
            'banner_title' => 'Past Continuous & Past Perfect Tenses (Timeline Sequencing)',
            'banner_subtitle' => 'Kuasai cara mengatur linimasa cerita sehari-hari: aksi simultan lampau (was/were + V-ing), kegiatan pasif yang sedang berjalan (was/were being + V3), peristiwa pendahulu (had + V3), kondisi sebelum suatu momen (had been + Adj/Noun), durasi berkelanjutan (had been + V-ing), dan penghubung waktu (by the time, prior to).',
            'banner_badge' => 'MODULE 1.12 TIMELINE SEQUENCING',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 1.12
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Panduan Lengkap Past Continuous & Past Perfect: Menguasai Linimasa Cerita',
            'concept_summary' => 'Saat menceritakan kejadian sehari-hari, kerancuan urutan waktu bisa membuat cerita sulit dipahami. Bab ini menggabungkan seluruh ragam tenses masa lampau untuk menciptakan linimasa yang jelas: (1) Past Continuous (was/were + V-ing) untuk aksi yang sedang berlangsung di latar belakang; (2) Past Perfect (had + V3) untuk menandai peristiwa yang selesai lebih awal dari peristiwa lampau lainnya (The Earlier Past); dan (3) Past Perfect Continuous (had been + V-ing) untuk menegaskan durasi suatu kegiatan sebelum peristiwa lain terjadi.',
            'rules' => [
                [
                    'rule_title' => '1. Past Continuous: Latar Belakang & Aksi Simultan (Was/Were + V-ing)',
                    'rule_formula' => 'Subject + was/were + Verb-ing + while / when + Clause',
                    'rule_description' => 'Gunakan "was + V-ing" untuk subjek tunggal dan "were + V-ing" untuk subjek jamak saat menggambarkan peristiwa latar belakang yang sedang berlangsung ketika peristiwa interupsi (Simple Past) terjadi.',
                    'examples' => [
                        [
                            'en' => 'While we were watching the movie, the power suddenly went out.',
                            'id' => 'Ketika kami sedang menonton film, listrik tiba-tiba padam.',
                            'note' => '"were watching" (sedang menonton) disela oleh peristiwa seketika "went out".'
                        ]
                    ]
                ],
                [
                    'rule_title' => '2. Past Continuous Pasif: Sesuatu Sedang Dikerjakan (Was/Were Being + V3)',
                    'rule_formula' => 'Passive Subject + was/were + being + Verb 3 (Past Participle)',
                    'rule_description' => 'Fokus kalimat dialihkan ke sesuatu yang sedang dikenai tindakan di masa lampau. Sisipan partikel "being" wajib hadir untuk menandai progresivitas pasif lampau.',
                    'examples' => [
                        [
                            'en' => 'The cake was being baked when the power suddenly went out.',
                            'id' => 'Kue itu sedang dipanggang ketika listrik tiba-tiba padam.',
                            'note' => '"was being baked" adalah bentuk pasif continuous tunggal yang tepat.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '3. Past Perfect: Menandai Peristiwa yang Terjadi Lebih Dulu (Had + V3)',
                    'rule_formula' => 'Subject + had + Verb 3 (Past Participle) + before / prior to + Simple Past Clause',
                    'rule_description' => 'Bila terdapat dua aksi masa lalu, aksi yang selesai lebih awal WAJIB menggunakan Past Perfect "had + V3", sedangkan aksi yang terjadi belakangan menggunakan Simple Past V2.',
                    'examples' => [
                        [
                            'en' => 'I had finished my homework before Mom came home.',
                            'id' => 'Saya telah menyelesaikan PR sebelum Ibu pulang ke rumah.',
                            'note' => 'Menyelesaikan PR ("had finished") selesai sebelum Ibu pulang ("came home").'
                        ]
                    ]
                ],
                [
                    'rule_title' => '4. Past Perfect Nominal & Pasif: Had Been + Complement / V3',
                    'rule_formula' => 'Nominal: had been + Adj/Noun | Pasif: had been + Verb 3',
                    'rule_description' => 'Menyatakan status sebelum suatu momen, atau sesuatu yang telah selesai dikerjakan terhadap objek sebelum titik tolak pengamatan lampau tercapai.',
                    'examples' => [
                        [
                            'en' => 'The room had been cleaned before the guests arrived.',
                            'id' => 'Ruangan telah dibersihkan sebelum tamu tiba.',
                            'note' => '"had been cleaned" menegaskan ruangan sudah bersih sebelum tamu datang ("arrived").'
                        ]
                    ]
                ],
                [
                    'rule_title' => '5. Aturan Konjungsi Linimasa: By the time, Prior to, Once',
                    'rule_formula' => 'By the time + S + V2 (Past), S + had + V3 / had been V3',
                    'rule_description' => 'Frasa "By the time" diikuti Simple Past mewajibkan induk kalimat menggunakan Past Perfect. Preposisi "Prior to" diikuti Gerund atau Noun Phrase.',
                    'examples' => [
                        [
                            'en' => 'By the time we arrived at the party, most of the food had already been eaten.',
                            'id' => 'Menjelang saat kami tiba di pesta, sebagian besar makanan telah habis dimakan.',
                            'note' => '"had already been eaten" terjadi mendahului kedatangan kami ("arrived").'
                        ]
                    ]
                ],
                [
                    'rule_title' => '6. Past Perfect Continuous: Penekanan Durasi Lampau (Had Been + V-ing)',
                    'rule_formula' => 'Subject + had been + Verb-ing + duration (for/since) + before / when Clause',
                    'rule_description' => 'Digunakan saat kita ingin menonjolkan proses yang sudah berlangsung cukup lama sebelum suatu peristiwa terjadi di masa lalu.',
                    'examples' => [
                        [
                            'en' => 'It had been raining for hours before the flood happened.',
                            'id' => 'Hujan telah turun selama berjam-jam sebelum banjir terjadi.',
                            'note' => '"had been raining ... for hours" menekankan durasi hujan sebelum banjir.'
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Complete 8 sub-lessons with 10 questions each (80 questions total).
     */
    public static function getSubLessons(): array
    {
        return [
            [
                'id' => 'past-continuous-verbal',
                'name' => '1.12.1 Past Continuous: Simultaneous Actions & Ongoing Background Events',
                'code' => '1.12.1',
                'concept_title' => 'Past Continuous: Tindakan Simultan & Peristiwa Latar Belakang Lampau',
                'concept_description' => 'Past Continuous Tense (was/were + V-ing) digunakan dalam cerita sehari-hari untuk menggambarkan peristiwa yang sedang berlangsung sebagai latar belakang (background event) ketika suatu peristiwa lain terjadi (interrupted action), atau dua aktivitas yang berlangsung secara bersamaan di masa lampau (simultaneous actions).',
                'description' => 'Past Continuous Tense (was/were + V-ing) digunakan dalam cerita sehari-hari untuk menggambarkan peristiwa yang sedang berlangsung sebagai latar belakang (background event) ketika suatu peristiwa lain terjadi (interrupted action), atau dua aktivitas yang berlangsung secara bersamaan di masa lampau (simultaneous actions).',
                'formula' => 'Subject + was/were + Verb-ing + while / when + Clause',
                'rules' => [
                    "Gunakan 'was + V-ing' untuk subjek tunggal (I, he, she, it, singular noun: my brother, the dog).",
                    "Gunakan 'were + V-ing' untuk subjek jamak (they, we, plural nouns: my friends, the kids).",
                    "Gunakan 'while' untuk mengawali klausa yang sedang berlangsung (While the rice was cooking...).",
                    "Gunakan 'when' untuk mengawali peristiwa interupsi yang biasanya berbentuk Simple Past (When the phone rang...).",
                    'Dilarang menggunakan to be present (is/are) untuk peristiwa masa lampau.',
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'id_sentence' => 'Ketika kami sedang menonton film, listrik tiba-tiba padam.',
                        'target_word' => 'were watching ... went out (Background Action + Interruption)',
                        'vocab' => [
                            ['en' => 'we', 'id' => 'kami'],
                            ['en' => 'watching the movie', 'id' => 'menonton film'],
                            ['en' => 'power suddenly went out', 'id' => 'listrik tiba-tiba padam'],
                        ],
                        'options' => [
                            'While we were watching the movie, the power suddenly went out.',
                            'While we was watching the movie, the power suddenly went out.',
                            'While we were watch the movie, the power suddenly went out.',
                            'While we were watching the movie, the power was gone out.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'we' berpasangan dengan 'were watching'. Peristiwa interupsi yang tiba-tiba terjadi menggunakan Simple Past aktif 'went out'.",
                    ],
                    [
                        'id' => 2,
                        'id_sentence' => 'Nenek sedang merajut syal saat telepon berdering.',
                        'target_word' => 'was knitting ... rang (Interrupted Past Action)',
                        'vocab' => [
                            ['en' => 'grandma', 'id' => 'nenek'],
                            ['en' => 'knitting a scarf', 'id' => 'merajut syal'],
                            ['en' => 'the phone rang', 'id' => 'telepon berdering'],
                        ],
                        'options' => [
                            'Grandma was knitting a scarf when the phone rang.',
                            'Grandma were knitting a scarf when the phone rang.',
                            'Grandma was knit a scarf when the phone rang.',
                            'Grandma was knitting a scarf when the phone was rung.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'Grandma' berpasangan dengan 'was knitting', sedangkan klausa 'when' memakai Simple Past aktif 'rang'.",
                    ],
                    [
                        'id' => 3,
                        'id_sentence' => 'Sementara dokter sedang memeriksa pasien, perawat menyiapkan obat.',
                        'target_word' => 'was examining ... prepared (Simultaneous Actions)',
                        'vocab' => [
                            ['en' => 'the doctor', 'id' => 'dokter'],
                            ['en' => 'examining the patient', 'id' => 'memeriksa pasien'],
                            ['en' => 'nurse prepared the medicine', 'id' => 'perawat menyiapkan obat'],
                        ],
                        'options' => [
                            'While the doctor was examining the patient, the nurse prepared the medicine.',
                            'While the doctor were examining the patient, the nurse prepared the medicine.',
                            'While the doctor was examine the patient, the nurse prepared the medicine.',
                            'While the doctor was examining the patient, the nurse was prepared the medicine.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'the doctor' (tunggal) memakai 'was examining', diikuti klausa 'prepared' Simple Past aktif.",
                    ],
                    [
                        'id' => 4,
                        'id_sentence' => 'Pada saat gempa terjadi, murid-murid sedang mengerjakan ujian di kelas.',
                        'target_word' => 'were taking (Past Continuous Background)',
                        'vocab' => [
                            ['en' => 'earthquake struck', 'id' => 'gempa terjadi'],
                            ['en' => 'the students', 'id' => 'murid-murid'],
                            ['en' => 'taking the exam', 'id' => 'mengerjakan ujian'],
                        ],
                        'options' => [
                            'At the moment the earthquake struck, the students were taking an exam in class.',
                            'At the moment the earthquake struck, the students was taking an exam in class.',
                            'At the moment the earthquake struck, the students were take an exam in class.',
                            'At the moment the earthquake struck, the students had taking an exam in class.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'the students' berpasangan dengan 'were taking' sebagai aktivitas yang sedang berlangsung di momen tertentu lampau.",
                    ],
                    [
                        'id' => 5,
                        'id_sentence' => 'Sepanjang pagi itu, hujan sedang turun secara perlahan di luar jendela.',
                        'target_word' => 'was falling (Past Continuous Gradual)',
                        'vocab' => [
                            ['en' => 'that whole morning', 'id' => 'sepanjang pagi itu'],
                            ['en' => 'rain', 'id' => 'hujan'],
                            ['en' => 'falling slowly', 'id' => 'turun secara perlahan'],
                        ],
                        'options' => [
                            'That whole morning, rain was falling slowly outside the window.',
                            'That whole morning, rain were falling slowly outside the window.',
                            'That whole morning, rain was fall slowly outside the window.',
                            'That whole morning, rain falling was slowly outside the window.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek 'rain' adalah uncountable singular, sehingga membutuhkan 'was falling'.",
                    ],
                    [
                        'id' => 6,
                        'id_sentence' => 'Sementara Kakak sedang mencuci piring, aku menyapu lantai dapur.',
                        'target_word' => 'was washing ... swept (Parallel Household Chores)',
                        'vocab' => [
                            ['en' => 'my sister', 'id' => 'Kakak'],
                            ['en' => 'washing the dishes', 'id' => 'mencuci piring'],
                            ['en' => 'swept the kitchen floor', 'id' => 'menyapu lantai dapur'],
                        ],
                        'options' => [
                            'While my sister was washing the dishes, I swept the kitchen floor.',
                            'While my sister were washing the dishes, I swept the kitchen floor.',
                            'While my sister was wash the dishes, I swept the kitchen floor.',
                            'While my sister was washing the dishes, I was swept the kitchen floor.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'my sister' (tunggal) memakai 'was washing', dikontraskan dengan tindakan saya 'swept'.",
                    ],
                    [
                        'id' => 7,
                        'id_sentence' => 'Tukang kebun sedang menyiram bunga saat mereka menemukan sarang burung.',
                        'target_word' => 'were watering ... found (Continuous + Simple Past Discovery)',
                        'vocab' => [
                            ['en' => 'the gardeners', 'id' => 'tukang kebun'],
                            ['en' => 'watering the flowers', 'id' => 'menyiram bunga'],
                            ["en" => "a bird's nest", "id" => "sarang burung"],
                        ],
                        'options' => [
                            "The gardeners were watering the flowers when they found a bird's nest.",
                            "The gardeners was watering the flowers when they found a bird's nest.",
                            "The gardeners were water the flowers when they found a bird's nest.",
                            "The gardeners were watering the flowers when they were found a bird's nest.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "'The gardeners were watering' (latar belakang jamak) disela oleh temuan 'when they found'.",
                    ],
                    [
                        'id' => 8,
                        'id_sentence' => 'Ketika balon sedang ditiup, udara di dalamnya tiba-tiba mengembang terlalu cepat.',
                        'target_word' => 'was being blown up ... expanded (Process + Sharp Result)',
                        'vocab' => [
                            ['en' => 'balloon was being blown up', 'id' => 'balon sedang ditiup'],
                            ['en' => 'air inside it', 'id' => 'udara di dalamnya'],
                            ['en' => 'expanded too fast', 'id' => 'mengembang terlalu cepat'],
                        ],
                        'options' => [
                            'As the balloon was being blown up, the air inside it expanded too quickly.',
                            'As the balloon were being blown up, the air inside it expanded too quickly.',
                            'As the balloon was blown up, the air inside it expanded too quickly.',
                            'As the balloon was being blown up, the air inside it was expanded too quickly.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'balloon' mengambil 'was being blown up', sedangkan klausa hasil memakai 'expanded' aktif.",
                    ],
                    [
                        'id' => 9,
                        'id_sentence' => 'Sementara Ayah sedang mencuci mobil, tetangga kami menyapa dari seberang jalan.',
                        'target_word' => 'was washing ... waved (Background + Greeting)',
                        'vocab' => [
                            ['en' => 'Dad was washing', 'id' => 'Ayah sedang mencuci'],
                            ['en' => 'the car', 'id' => 'mobil'],
                            ['en' => 'our neighbor waved', 'id' => 'tetangga kami menyapa'],
                        ],
                        'options' => [
                            'While Dad was washing the car, our neighbor waved from across the street.',
                            'While Dad was washing the car, our neighbor was waved from across the street.',
                            'While Dad were washing the car, our neighbor waved from across the street.',
                            'While Dad was wash the car, our neighbor waved from across the street.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Dad was washing' (tunggal) dipadukan dengan sapaan tetangga 'waved'.",
                    ],
                    [
                        'id' => 10,
                        'id_sentence' => 'Panitia kelas sedang mendiskusikan rencana darmawisata ketika pengumuman libur mendadak dirilis.',
                        'target_word' => 'was discussing ... was released (Continuous Active + Past Passive)',
                        'vocab' => [
                            ['en' => 'class committee was discussing', 'id' => 'panitia kelas sedang mendiskusikan'],
                            ['en' => 'the field trip plan', 'id' => 'rencana darmawisata'],
                            ['en' => 'sudden holiday announcement was released', 'id' => 'pengumuman libur mendadak dirilis'],
                        ],
                        'options' => [
                            'The class committee was discussing the field trip plan when the sudden holiday announcement was released.',
                            'The class committee were discussing the field trip plan when the sudden holiday announcement was released.',
                            'The class committee was discuss the field trip plan when the sudden holiday announcement was released.',
                            'The class committee was discussing the field trip plan when the sudden holiday announcement released.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'The class committee was discussing' (kolektif tunggal) disela oleh peristiwa pasif lampau 'was released'.",
                    ],
                ]
            ],
            [
                'id' => 'past-continuous-passive',
                'name' => '1.12.2 Past Continuous Passive: Everyday Activities in Progress',
                'code' => '1.12.2',
                'concept_title' => 'Past Continuous Pasif: Kegiatan Sehari-hari yang Sedang Dikerjakan',
                'concept_description' => "Past Continuous Pasif digunakan untuk menceritakan sesuatu yang sedang aktif dikerjakan terhadap suatu objek pada saat tertentu di masa lalu. Rumusnya menggunakan 'was/were' diikuti partikel 'being' dan Past Participle (V3). Bentuk ini cocok dipakai ketika kita ingin menekankan objek yang sedang menerima tindakan, bukan siapa yang melakukannya.",
                'description' => "Past Continuous Pasif digunakan untuk menceritakan sesuatu yang sedang aktif dikerjakan terhadap suatu objek pada saat tertentu di masa lalu. Rumusnya menggunakan 'was/were' diikuti partikel 'being' dan Past Participle (V3). Bentuk ini cocok dipakai ketika kita ingin menekankan objek yang sedang menerima tindakan, bukan siapa yang melakukannya.",
                'formula' => 'Subject (Patient) + was/were + being + Verb 3 (Past Participle) + (by Agent)',
                'rules' => [
                    "Gunakan 'was being + V3' untuk subjek tunggal (the cake, the room, the car).",
                    "Gunakan 'were being + V3' untuk subjek jamak (the dishes, the toys, the clothes).",
                    "Partikel 'being' wajib hadir untuk menunjukkan progresivitas tindakan lampau.",
                    "Jangan tertukar dengan Past Perfect Pasif (had been + V3); continuous pasif selalu memakai 'being'.",
                ],
                'exercises' => [
                    [
                        'id' => 11,
                        'id_sentence' => 'Baju-baju sedang dijemur di halaman ketika hujan tiba-tiba turun.',
                        'target_word' => 'were being dried (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'the clothes', 'id' => 'baju-baju'],
                            ['en' => 'dried in the yard', 'id' => 'dijemur di halaman'],
                            ['en' => 'rain suddenly fell', 'id' => 'hujan tiba-tiba turun'],
                        ],
                        'options' => [
                            'The clothes were being dried in the yard when rain suddenly fell.',
                            'The clothes was being dried in the yard when rain suddenly fell.',
                            'The clothes were been dried in the yard when rain suddenly fell.',
                            'The clothes were drying in the yard when rain suddenly fell.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek pasif jamak 'clothes' membutuhkan 'were being dried'. Pilihan C salah memakai 'been' (untuk perfect), dan D aktif ('sedang mengering').",
                    ],
                    [
                        'id' => 12,
                        'id_sentence' => 'Pagar baru sedang dipasang di rumah kami saat tukangnya tiba-tiba sakit perut.',
                        'target_word' => 'was being installed (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'new fence', 'id' => 'pagar baru'],
                            ['en' => 'installed', 'id' => 'dipasang'],
                            ['en' => 'worker suddenly had a stomachache', 'id' => 'tukangnya tiba-tiba sakit perut'],
                        ],
                        'options' => [
                            'A new fence was being installed at our house when the worker suddenly had a stomachache.',
                            'A new fence were being installed at our house when the worker suddenly had a stomachache.',
                            'A new fence was been installed at our house when the worker suddenly had a stomachache.',
                            'A new fence was installing at our house when the worker suddenly had a stomachache.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'A fence' memerlukan 'was being installed'.",
                    ],
                    [
                        'id' => 13,
                        'id_sentence' => 'Nasi sedang dimasak di dapur ketika aliran listrik terputus.',
                        'target_word' => 'was being cooked (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'rice', 'id' => 'nasi'],
                            ['en' => 'cooked in the kitchen', 'id' => 'dimasak di dapur'],
                            ['en' => 'power went out', 'id' => 'aliran listrik terputus'],
                        ],
                        'options' => [
                            'The rice was being cooked in the kitchen when the power went out.',
                            'The rice were being cooked in the kitchen when the power went out.',
                            'The rice was been cooked in the kitchen when the power went out.',
                            'The rice was cooking in the kitchen when the power went out.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'rice' berpasangan dengan 'was being cooked'.",
                    ],
                    [
                        'id' => 14,
                        'id_sentence' => 'Hadiah-hadiah ulang tahun sedang dibungkus di kamar Kakak sebelum tamu-tamu datang.',
                        'target_word' => 'were being wrapped (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'the birthday presents', 'id' => 'hadiah-hadiah ulang tahun'],
                            ['en' => 'wrapped in my sister\'s room', 'id' => 'dibungkus di kamar Kakak'],
                            ['en' => 'before the guests came', 'id' => 'sebelum tamu-tamu datang'],
                        ],
                        'options' => [
                            "The birthday presents were being wrapped in my sister's room before the guests came.",
                            "The birthday presents was being wrapped in my sister's room before the guests came.",
                            "The birthday presents were been wrapped in my sister's room before the guests came.",
                            "The birthday presents were wrapping in my sister's room before the guests came.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek pasif jamak 'presents' membutuhkan 'were being wrapped'.",
                    ],
                    [
                        'id' => 15,
                        'id_sentence' => 'Mobil tua itu sedang diperbaiki ketika montirnya menemukan masalah lain.',
                        'target_word' => 'was being repaired (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'the old car', 'id' => 'mobil tua itu'],
                            ['en' => 'repaired', 'id' => 'diperbaiki'],
                            ['en' => 'mechanic found another problem', 'id' => 'montir menemukan masalah lain'],
                        ],
                        'options' => [
                            'The old car was being repaired when the mechanic found another problem.',
                            'The old car were being repaired when the mechanic found another problem.',
                            'The old car was been repaired when the mechanic found another problem.',
                            'The old car was repairing when the mechanic found another problem.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'car' berpasangan dengan 'was being repaired'.",
                    ],
                    [
                        'id' => 16,
                        'id_sentence' => 'Kue-kue kering sedang disusun di dalam toples saat Lebaran hampir tiba.',
                        'target_word' => 'were being arranged (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'the cookies', 'id' => 'kue-kue kering'],
                            ['en' => 'arranged in the jars', 'id' => 'disusun di dalam toples'],
                            ['en' => 'Eid was almost here', 'id' => 'Lebaran hampir tiba'],
                        ],
                        'options' => [
                            'The cookies were being arranged in the jars as Eid was almost here.',
                            'The cookies was being arranged in the jars as Eid was almost here.',
                            'The cookies were been arranged in the jars as Eid was almost here.',
                            'The cookies were arranging in the jars as Eid was almost here.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'cookies' dipadukan dengan 'were being arranged'.",
                    ],
                    [
                        'id' => 17,
                        'id_sentence' => 'Pipa air di rumah kami sedang diperbaiki ketika gempa susulan mengguncang wilayah itu.',
                        'target_word' => 'was being fixed (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'the water pipe', 'id' => 'pipa air'],
                            ['en' => 'fixed', 'id' => 'diperbaiki'],
                            ['en' => 'aftershock rattled the area', 'id' => 'gempa susulan mengguncang wilayah'],
                        ],
                        'options' => [
                            'The water pipe at our house was being fixed when a minor aftershock rattled the area.',
                            'The water pipe at our house were being fixed when a minor aftershock rattled the area.',
                            'The water pipe at our house was been fixed when a minor aftershock rattled the area.',
                            'The water pipe at our house was fixing when a minor aftershock rattled the area.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'pipe' membutuhkan 'was being fixed'.",
                    ],
                    [
                        'id' => 18,
                        'id_sentence' => 'Undangan pesta sedang dibagikan ke tetangga saat hujan deras mulai turun.',
                        'target_word' => 'were being handed out (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'the party invitations', 'id' => 'undangan pesta'],
                            ['en' => 'handed out to the neighbors', 'id' => 'dibagikan ke tetangga'],
                            ['en' => 'heavy rain started falling', 'id' => 'hujan deras mulai turun'],
                        ],
                        'options' => [
                            'The party invitations were being handed out to the neighbors when heavy rain started falling.',
                            'The party invitations was being handed out to the neighbors when heavy rain started falling.',
                            'The party invitations were been handed out to the neighbors when heavy rain started falling.',
                            'The party invitations were handing out to the neighbors when heavy rain started falling.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'invitations' memerlukan 'were being handed out'.",
                    ],
                    [
                        'id' => 19,
                        'id_sentence' => 'Kue itu sedang dipanggang di dalam oven ketika listrik tiba-tiba padam.',
                        'target_word' => 'was being baked (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'cake', 'id' => 'kue'],
                            ['en' => 'baked in the oven', 'id' => 'dipanggang di dalam oven'],
                            ['en' => 'power suddenly went out', 'id' => 'listrik tiba-tiba padam'],
                        ],
                        'options' => [
                            'The cake was being baked in the oven when the power suddenly went out.',
                            'The cake were being baked in the oven when the power suddenly went out.',
                            'The cake was been baked in the oven when the power suddenly went out.',
                            'The cake was baking in the oven when the power suddenly went out.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'cake' dipadukan dengan 'was being baked'.",
                    ],
                    [
                        'id' => 20,
                        'id_sentence' => 'Buku-buku perpustakaan sedang ditata ulang ketika rak bukunya tiba-tiba roboh.',
                        'target_word' => 'were being rearranged (Past Continuous Passive)',
                        'vocab' => [
                            ['en' => 'library books', 'id' => 'buku-buku perpustakaan'],
                            ['en' => 'rearranged', 'id' => 'ditata ulang'],
                            ['en' => 'bookshelf suddenly collapsed', 'id' => 'rak bukunya tiba-tiba roboh'],
                        ],
                        'options' => [
                            'The library books were being rearranged when the bookshelf suddenly collapsed.',
                            'The library books was being rearranged when the bookshelf suddenly collapsed.',
                            'The library books were been rearranged when the bookshelf suddenly collapsed.',
                            'The library books were rearranging when the bookshelf suddenly collapsed.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'books' berpasangan dengan 'were being rearranged'.",
                    ],
                ]
            ],
            [
                'id' => 'past-perfect-verbal',
                'name' => '1.12.3 Past Perfect Verbal: Establishing Earlier Actions (The Earlier Past)',
                'code' => '1.12.3',
                'concept_title' => 'Past Perfect Verbal: Peristiwa yang Terjadi Lebih Dulu dalam Linimasa Lampau',
                'concept_description' => "Past Perfect Verbal (had + V3) digunakan ketika ada DUA peristiwa yang sama-sama terjadi di masa lalu, dan kita harus menegaskan secara eksplisit bahwa tindakan A telah selesai sepenuhnya SEBELUM tindakan B terjadi. Tense ini dinamakan 'The Earlier Past' atau masa lalu yang lebih lampau. Tidak bergantung pada subjek tunggal/jamak: semua subjek menggunakan 'had + V3'.",
                'description' => "Past Perfect Verbal (had + V3) digunakan ketika ada DUA peristiwa yang sama-sama terjadi di masa lalu, dan kita harus menegaskan secara eksplisit bahwa tindakan A telah selesai sepenuhnya SEBELUM tindakan B terjadi. Tense ini dinamakan 'The Earlier Past' atau masa lalu yang lebih lampau. Tidak bergantung pada subjek tunggal/jamak: semua subjek menggunakan 'had + V3'.",
                'formula' => 'Subject + had + Verb 3 (Past Participle) + before / prior to + Simple Past Clause',
                'rules' => [
                    "Gunakan 'had + V3' untuk tindakan pertama yang terjadi lebih awal.",
                    'Gunakan Simple Past (V2) untuk tindakan kedua yang terjadi kemudian.',
                    "Semua subjek (tunggal maupun jamak) menggunakan auxiliary yang sama: 'had'.",
                    "Dilarang menggunakan 'had + V3' sendirian tanpa adanya titik tolak masa lampau (Past Point of Reference) dalam konteks kalimat.",
                ],
                'exercises' => [
                    [
                        'id' => 21,
                        'id_sentence' => 'Aku telah menyelesaikan PR sebelum Ibu pulang ke rumah.',
                        'target_word' => 'had finished ... came (Earlier Past vs Past)',
                        'vocab' => [
                            ['en' => 'I had finished', 'id' => 'aku telah menyelesaikan'],
                            ['en' => 'my homework', 'id' => 'PR'],
                            ['en' => 'Mom came home', 'id' => 'Ibu pulang ke rumah'],
                        ],
                        'options' => [
                            'I had finished my homework before Mom came home.',
                            'I has finished my homework before Mom came home.',
                            'I finished my homework before Mom had come home.',
                            'I had finish my homework before Mom came home.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Tindakan menyelesaikan PR terjadi lebih dulu ('had finished') sebelum Ibu pulang ('came' Simple Past).",
                    ],
                    [
                        'id' => 22,
                        'id_sentence' => 'Sebelum mengundang teman-temannya, Kakak telah membersihkan seluruh rumah.',
                        'target_word' => 'had cleaned ... invited (Earlier Action)',
                        'vocab' => [
                            ['en' => 'cleaned the whole house', 'id' => 'membersihkan seluruh rumah'],
                            ['en' => 'invited her friends', 'id' => 'mengundang teman-temannya'],
                        ],
                        'options' => [
                            'Before inviting her friends over, my sister had cleaned the whole house.',
                            'Before inviting her friends over, my sister has cleaned the whole house.',
                            'Before inviting her friends over, my sister had clean the whole house.',
                            'Before inviting her friends over, my sister have cleaned the whole house back then.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pembersihan rumah mendahului undangan lampau, sehingga wajib menggunakan Past Perfect 'had cleaned'.",
                    ],
                    [
                        'id' => 23,
                        'id_sentence' => 'Adik telah makan es krim selama lima menit sebelum ia mulai sakit perut.',
                        'target_word' => 'had eaten ... started (Earlier Past Sequence)',
                        'vocab' => [
                            ['en' => 'my little brother had eaten ice cream', 'id' => 'adik telah makan es krim'],
                            ['en' => 'for five minutes', 'id' => 'selama lima menit'],
                            ['en' => 'started having a stomachache', 'id' => 'mulai sakit perut'],
                        ],
                        'options' => [
                            'My little brother had eaten ice cream for five minutes before he started having a stomachache.',
                            'My little brother has eaten ice cream for five minutes before he started having a stomachache.',
                            'My little brother ate ice cream for five minutes before he had started having a stomachache.',
                            'My little brother had ate ice cream for five minutes before he started having a stomachache.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Tindakan makan es krim ('had eaten') mendahului rasa sakit perut ('started'). Past Participle dari eat adalah 'eaten', bukan 'ate'.",
                    ],
                    [
                        'id' => 24,
                        'id_sentence' => 'Toko itu telah menarik kembali mainan itu sebelum petugas keamanan mengeluarkan larangan resmi.',
                        'target_word' => 'had recalled ... issued (Prior Action)',
                        'vocab' => [
                            ['en' => 'recalled the toy', 'id' => 'menarik kembali mainan'],
                            ['en' => 'safety officer issued', 'id' => 'petugas keamanan mengeluarkan'],
                            ['en' => 'official ban', 'id' => 'larangan resmi'],
                        ],
                        'options' => [
                            'The store had recalled the toy before the safety officer issued an official ban.',
                            'The store has recalled the toy before the safety officer issued an official ban.',
                            'The store recalled the toy before the safety officer had issued an official ban.',
                            'The store had recall the toy before the safety officer issued an official ban.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Penarikan mainan mendahului larangan resmi: 'had recalled' disusul 'issued'.",
                    ],
                    [
                        'id' => 25,
                        'id_sentence' => 'Menjelang usia sepuluh tahun, aku telah membaca seluruh seri buku itu tiga kali.',
                        'target_word' => 'had read (Completed Before Past Milestone)',
                        'vocab' => [
                            ['en' => 'by the age of ten', 'id' => 'menjelang usia sepuluh tahun'],
                            ['en' => 'had read the whole book series', 'id' => 'telah membaca seluruh seri buku'],
                            ['en' => 'three times', 'id' => 'tiga kali'],
                        ],
                        'options' => [
                            'By the age of ten, I had read the whole book series three times.',
                            'By the age of ten, I has read the whole book series three times.',
                            'By the age of ten, I read the whole book series three times.',
                            'By the age of ten, I was read the whole book series three times.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Frasa batas waktu lampau 'By the age of ten' mewajibkan Past Perfect 'had read'.",
                    ],
                    [
                        'id' => 26,
                        'id_sentence' => 'Adik-adik telah membuat tiga gambar berbeda sebelum memilih yang terbaik untuk lomba.',
                        'target_word' => 'had made ... chose (Sequential Decision)',
                        'vocab' => [
                            ['en' => 'my siblings had made', 'id' => 'adik-adik telah membuat'],
                            ['en' => 'three different drawings', 'id' => 'tiga gambar berbeda'],
                            ['en' => 'chose the best one for the contest', 'id' => 'memilih yang terbaik untuk lomba'],
                        ],
                        'options' => [
                            'My siblings had made three different drawings before choosing the best one for the contest.',
                            'My siblings has made three different drawings before choosing the best one for the contest.',
                            'My siblings made three different drawings before they had chosen the best one for the contest.',
                            'My siblings had make three different drawings before choosing the best one for the contest.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pembuatan ketiga gambar selesai lebih dahulu ('had made') sebelum pemilihan gambar terbaik.",
                    ],
                    [
                        'id' => 27,
                        'id_sentence' => 'Ketika juri mulai menilai, panitia telah menyusun semua karya peserta dengan rapi.',
                        'target_word' => 'had arranged ... began (Past Perfect with When)',
                        'vocab' => [
                            ['en' => 'judges began scoring', 'id' => 'juri mulai menilai'],
                            ['en' => 'the committee had arranged', 'id' => 'panitia telah menyusun'],
                            ["en" => "all the participants' artwork", "id" => "semua karya peserta"],
                        ],
                        'options' => [
                            "When the judges began scoring, the committee had arranged all the participants' artwork neatly.",
                            "When the judges began scoring, the committee has arranged all the participants' artwork neatly.",
                            "When the judges had begun scoring, the committee arranged all the participants' artwork neatly.",
                            "When the judges began scoring, the committee was arranged all the participants' artwork neatly.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "Penyusunan karya selesai sebelum juri mulai menilai: 'had arranged' + 'began'.",
                    ],
                    [
                        'id' => 28,
                        'id_sentence' => 'Jumlah anggota klub baca itu telah bertambah dua kali lipat sebelum perpustakaan baru dibuka.',
                        'target_word' => 'had doubled ... was opened (Past Perfect + Past Passive)',
                        'vocab' => [
                            ['en' => 'book club membership had doubled', 'id' => 'anggota klub baca telah bertambah dua kali lipat'],
                            ['en' => 'new library was opened', 'id' => 'perpustakaan baru dibuka'],
                        ],
                        'options' => [
                            'The book club membership had doubled before the new library was opened.',
                            'The book club membership has doubled before the new library was opened.',
                            'The book club membership doubled before the new library had opened.',
                            'The book club membership had double before the new library was opened.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pertambahan anggota terjadi lebih dahulu ('had doubled') sebelum perpustakaan dibuka ('was opened').",
                    ],
                    [
                        'id' => 29,
                        'id_sentence' => 'Setelah kami telah mengumpulkan daun-daun kering, kami membuat kerajinan tangan dari daun itu.',
                        'target_word' => 'had collected ... made (After + Past Perfect)',
                        'vocab' => [
                            ['en' => 'had collected dry leaves', 'id' => 'telah mengumpulkan daun-daun kering'],
                            ['en' => 'made handicrafts from the leaves', 'id' => 'membuat kerajinan tangan dari daun'],
                        ],
                        'options' => [
                            'After we had collected the dry leaves, we made handicrafts from them.',
                            'After we has collected the dry leaves, we made handicrafts from them.',
                            'After we collected the dry leaves, we had made handicrafts from them.',
                            'After we were collected the dry leaves, we made handicrafts from them.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pengumpulan daun selesai terlebih dahulu ('had collected'), baru kemudian membuat kerajinan ('made').",
                    ],
                    [
                        'id' => 30,
                        'id_sentence' => 'Ibu telah mencicipi sup itu tiga kali sebelum menambahkan garam lagi.',
                        'target_word' => 'had tasted ... added (Repeated Past Action Before Mark)',
                        'vocab' => [
                            ['en' => 'had tasted the soup', 'id' => 'telah mencicipi sup'],
                            ['en' => 'three times', 'id' => 'tiga kali'],
                            ['en' => 'added more salt', 'id' => 'menambahkan garam lagi'],
                        ],
                        'options' => [
                            'Mom had tasted the soup three times before adding more salt.',
                            'Mom has tasted the soup three times before adding more salt.',
                            'Mom tasted the soup three times before adding more salt had been.',
                            'Mom had taste the soup three times before adding more salt.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Mencicipi 3 kali selesai lebih dahulu ('had tasted') sebelum menambahkan garam.",
                    ],
                ]
            ],
            [
                'id' => 'past-perfect-nominal',
                'name' => '1.12.4 Past Perfect Nominal: States & Conditions Before a Past Moment',
                'code' => '1.12.4',
                'concept_title' => 'Past Perfect Nominal: Keadaan & Sifat Sebelum Suatu Momen Lampau',
                'concept_description' => "Past Perfect Nominal (had been + Adjective / Noun / Prepositional Phrase) digunakan untuk menyatakan keadaan, status, atau sifat subjek yang telah berlangsung selama kurun waktu tertentu SEBELUM titik waktu masa lalu tertentu tiba. Kata 'been' wajib disisipkan setelah 'had'.",
                'description' => "Past Perfect Nominal (had been + Adjective / Noun / Prepositional Phrase) digunakan untuk menyatakan keadaan, status, atau sifat subjek yang telah berlangsung selama kurun waktu tertentu SEBELUM titik waktu masa lalu tertentu tiba. Kata 'been' wajib disisipkan setelah 'had'.",
                'formula' => 'Subject + had been + Adjective / Noun Phrase / Prepositional Phrase + before / when Clause',
                'rules' => [
                    'Pola rumus baku: Subject + had been + Complement.',
                    "Semua jenis subjek (tunggal dan jamak) menggunakan 'had been'.",
                    'Menunjukkan kondisi lampau yang bertahan hingga suatu momen interupsi masa lampau terjadi.',
                    "Dilarang meniadakan 'been' (*The patient had sick adalah SALAH BESAR).",
                ],
                'exercises' => [
                    [
                        'id' => 31,
                        'id_sentence' => 'Adik telah demam selama tiga hari sebelum dibawa ke dokter.',
                        'target_word' => 'had been feverish (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'my little brother had been feverish', 'id' => 'adik telah demam'],
                            ['en' => 'for three days', 'id' => 'selama tiga hari'],
                            ['en' => 'taken to the doctor', 'id' => 'dibawa ke dokter'],
                        ],
                        'options' => [
                            'My little brother had been feverish for three days before being taken to the doctor.',
                            'My little brother has been feverish for three days before being taken to the doctor.',
                            'My little brother had feverish for three days before being taken to the doctor.',
                            'My little brother was been feverish for three days before being taken to the doctor.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kondisi demam berlangsung sebelum dibawa ke dokter, sehingga wajib 'had been feverish'. Opsi C salah karena menghilangkan 'been'.",
                    ],
                    [
                        'id' => 32,
                        'id_sentence' => 'Halaman belakang rumah kami telah menjadi kebun bunga selama bertahun-tahun sebelum kami pindah rumah.',
                        'target_word' => 'had been a flower garden (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'our backyard had been', 'id' => 'halaman belakang kami telah menjadi'],
                            ['en' => 'a flower garden', 'id' => 'kebun bunga'],
                            ['en' => 'we moved houses', 'id' => 'kami pindah rumah'],
                        ],
                        'options' => [
                            'Our backyard had been a flower garden for years before we moved houses.',
                            'Our backyard has been a flower garden for years before we moved houses.',
                            'Our backyard was been a flower garden for years before we moved houses.',
                            'Our backyard had a flower garden for years before we moved houses.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Status kebun bunga mendahului kepindahan lampau: 'had been a flower garden'.",
                    ],
                    [
                        'id' => 33,
                        'id_sentence' => 'Kedua sepeda itu telah dalam kondisi baik sebelum ban belakangnya kempis.',
                        'target_word' => 'had been in good condition (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'both bicycles had been in good condition', 'id' => 'kedua sepeda telah dalam kondisi baik'],
                            ['en' => 'back tire went flat', 'id' => 'ban belakangnya kempis'],
                        ],
                        'options' => [
                            'Both bicycles had been in good condition before the back tire went flat.',
                            'Both bicycles have been in good condition before the back tire went flat.',
                            'Both bicycles had in good condition before the back tire went flat.',
                            'Both bicycles were been in good condition before the back tire went flat.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'bicycles' menggunakan 'had been in good condition' sebelum ban kempis ('went flat').",
                    ],
                    [
                        'id' => 34,
                        'id_sentence' => 'Paman telah menjadi ketua RT selama sepuluh tahun ketika ia memutuskan untuk berhenti.',
                        'target_word' => 'had been the neighborhood head (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'had been the neighborhood head', 'id' => 'telah menjadi ketua RT'],
                            ['en' => 'for ten years', 'id' => 'selama sepuluh tahun'],
                            ['en' => 'decided to step down', 'id' => 'memutuskan untuk berhenti'],
                        ],
                        'options' => [
                            'My uncle had been the neighborhood head for ten years when he decided to step down.',
                            'My uncle has been the neighborhood head for ten years when he decided to step down.',
                            'My uncle was been the neighborhood head for ten years when he decided to step down.',
                            'My uncle had the neighborhood head for ten years when he decided to step down.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Jabatan selama 10 tahun tersebut berlangsung sebelum keputusan berhenti lampau ('decided'): 'had been the neighborhood head'.",
                    ],
                    [
                        'id' => 35,
                        'id_sentence' => 'Suasana kelas telah ribut selama beberapa menit sebelum guru masuk.',
                        'target_word' => 'had been noisy (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'classroom had been noisy', 'id' => 'kelas telah ribut'],
                            ['en' => 'for a few minutes', 'id' => 'selama beberapa menit'],
                            ['en' => 'the teacher walked in', 'id' => 'guru masuk'],
                        ],
                        'options' => [
                            'The classroom had been noisy for a few minutes before the teacher walked in.',
                            'The classroom have been noisy for a few minutes before the teacher walked in.',
                            'The classroom had noisy for a few minutes before the teacher walked in.',
                            'The classroom were been noisy for a few minutes before the teacher walked in.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kondisi ribut ('had been noisy') mendahului masuknya guru lampau ('walked in').",
                    ],
                    [
                        'id' => 36,
                        'id_sentence' => 'Jadwal pelajaran itu telah berlaku selama satu semester sebelum diganti dengan yang baru.',
                        'target_word' => 'had been in effect (Past Perfect Nominal with Prepositional Phrase)',
                        'vocab' => [
                            ['en' => 'class schedule had been in effect', 'id' => 'jadwal pelajaran telah berlaku'],
                            ['en' => 'for one semester', 'id' => 'selama satu semester'],
                            ['en' => 'replaced with a new one', 'id' => 'diganti dengan yang baru'],
                        ],
                        'options' => [
                            'The class schedule had been in effect for one semester before it was replaced with a new one.',
                            'The class schedule has been in effect for one semester before it was replaced with a new one.',
                            'The class schedule had in effect for one semester before it was replaced with a new one.',
                            'The class schedule was in effect for one semester before it had replaced with a new one.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Frasa 'in effect' memerlukan 'had been' untuk menyatakan masa berlaku sebelum penggantian lampau.",
                    ],
                    [
                        'id' => 37,
                        'id_sentence' => 'Harga buah-buahan telah mahal sebelum panen raya tiba.',
                        'target_word' => 'had been expensive (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'fruit prices had been expensive', 'id' => 'harga buah telah mahal'],
                            ['en' => 'the big harvest arrived', 'id' => 'panen raya tiba'],
                        ],
                        'options' => [
                            'Fruit prices had been expensive for several weeks before the big harvest arrived.',
                            'Fruit prices has been expensive for several weeks before the big harvest arrived.',
                            'Fruit prices had expensive for several weeks before the big harvest arrived.',
                            'Fruit prices were been expensive for several weeks before the big harvest arrived.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kondisi harga mahal mendahului tibanya panen raya lampau: 'had been expensive'.",
                    ],
                    [
                        'id' => 38,
                        'id_sentence' => 'Para pelari telah dalam keadaan lapar selama dua jam sebelum garis finish terlihat.',
                        'target_word' => 'had been hungry (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'the runners had been hungry', 'id' => 'para pelari telah lapar'],
                            ['en' => 'for two hours', 'id' => 'selama dua jam'],
                            ['en' => 'the finish line came into view', 'id' => 'garis finish terlihat'],
                        ],
                        'options' => [
                            'The runners had been hungry for two hours before the finish line came into view.',
                            'The runners have been hungry for two hours before the finish line came into view.',
                            'The runners had hungry for two hours before the finish line came into view.',
                            'The runners were been hungry for two hours before the finish line came into view.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'runners' berpasangan dengan 'had been hungry'.",
                    ],
                    [
                        'id' => 39,
                        'id_sentence' => 'Taman bermain itu telah ramai sepanjang hari ketika kami memutuskan untuk pulang.',
                        'target_word' => 'had been crowded (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'playground had been crowded', 'id' => 'taman bermain telah ramai'],
                            ['en' => 'all day', 'id' => 'sepanjang hari'],
                            ['en' => 'we decided to go home', 'id' => 'kami memutuskan untuk pulang'],
                        ],
                        'options' => [
                            'The playground had been crowded all day when we decided to go home.',
                            'The playground has been crowded all day when we decided to go home.',
                            'The playground had crowded all day when we decided to go home.',
                            'The playground was been crowded all day when we decided to go home.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Status ramai sepanjang hari mendahului keputusan pulang lampau: 'had been crowded'.",
                    ],
                    [
                        'id' => 40,
                        'id_sentence' => 'Nilai ulangan kelas kami telah sangat bagus sebelum ujian akhir diumumkan.',
                        'target_word' => 'had been excellent (Past Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'our class test scores had been excellent', 'id' => 'nilai ulangan kelas kami telah bagus'],
                            ['en' => 'the final exam was announced', 'id' => 'ujian akhir diumumkan'],
                        ],
                        'options' => [
                            "Our class's test scores had been excellent before the final exam was announced.",
                            "Our class's test scores have been excellent before the final exam was announced.",
                            "Our class's test scores had excellent before the final exam was announced.",
                            "Our class's test scores were been excellent before the final exam was announced.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Our class's test scores had been excellent' mendahului momen pengumuman pasif lampau 'was announced'.",
                    ],
                ]
            ],
            [
                'id' => 'past-perfect-passive',
                'name' => '1.12.5 Past Perfect Passive: Things Completed Before a Past Moment',
                'code' => '1.12.5',
                'concept_title' => 'Past Perfect Pasif: Sesuatu yang Sudah Selesai Sebelum Suatu Momen Lampau',
                'concept_description' => 'Past Perfect Pasif (had been + V3) digunakan ketika subjek kalimat menerima tindakan yang telah tuntas dilakukan sebelum peristiwa masa lampau lainnya terjadi. Cocok dipakai untuk menegaskan bahwa sesuatu sudah selesai dikerjakan sebelum momen penting berikutnya tiba.',
                'description' => 'Past Perfect Pasif (had been + V3) digunakan ketika subjek kalimat menerima tindakan yang telah tuntas dilakukan sebelum peristiwa masa lampau lainnya terjadi. Cocok dipakai untuk menegaskan bahwa sesuatu sudah selesai dikerjakan sebelum momen penting berikutnya tiba.',
                'formula' => 'Subject (Patient) + had been + Verb 3 (Past Participle) + before / prior to + Simple Past Clause',
                'rules' => [
                    'Rumus baku: Subject + had been + Past Participle (V3).',
                    'Jangan tertukar dengan Past Continuous Pasif (was/were being + V3) atau Present Perfect Pasif (have/has been + V3).',
                    "Berlaku sama untuk subjek tunggal dan jamak ('had been + V3').",
                    'Menegaskan bahwa sesuatu sudah selesai dikerjakan sebelum peristiwa berikutnya dimulai.',
                ],
                'exercises' => [
                    [
                        'id' => 41,
                        'id_sentence' => 'Ruangan itu telah dibersihkan oleh petugas sebelum acara dimulai.',
                        'target_word' => 'had been cleaned ... started (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'room had been cleaned', 'id' => 'ruangan telah dibersihkan'],
                            ['en' => 'staff', 'id' => 'petugas'],
                            ['en' => 'event started', 'id' => 'acara dimulai'],
                        ],
                        'options' => [
                            'The room had been cleaned by the staff before the event started.',
                            'The room has been cleaned by the staff before the event started.',
                            'The room was being cleaned by the staff before the event started.',
                            'The room had cleaned by the staff before the event started.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pembersihan ruangan terjadi dan selesai terlebih dahulu ('had been cleaned') sebelum acara dimulai ('started'). Opsi D salah karena bermakna aktif.",
                    ],
                    [
                        'id' => 42,
                        'id_sentence' => 'Semua jendela telah ditutup rapat sebelum badai tiba.',
                        'target_word' => 'had been shut ... arrived (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'all the windows had been shut', 'id' => 'semua jendela telah ditutup'],
                            ['en' => 'tightly', 'id' => 'rapat'],
                            ['en' => 'storm arrived', 'id' => 'badai tiba'],
                        ],
                        'options' => [
                            'All the windows had been shut tightly before the storm arrived.',
                            'All the windows have been shut tightly before the storm arrived.',
                            'All the windows had being shut tightly before the storm arrived.',
                            'All the windows were shut tightly before the storm had arrived.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Penutupan jendela selesai lebih awal ('had been shut') mendahului kedatangan badai ('arrived').",
                    ],
                    [
                        'id' => 43,
                        'id_sentence' => 'Cerita itu telah diceritakan berkali-kali sebelum nenek menuliskannya di buku hariannya.',
                        'target_word' => 'had been told (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'story had been told', 'id' => 'cerita telah diceritakan'],
                            ['en' => 'many times', 'id' => 'berkali-kali'],
                            ['en' => 'grandma wrote it in her diary', 'id' => 'nenek menuliskannya di buku hariannya'],
                        ],
                        'options' => [
                            'The story had been told many times before grandma wrote it in her diary.',
                            'The story has been told many times before grandma wrote it in her diary.',
                            'The story was being told many times before grandma wrote it in her diary.',
                            'The story had told many times before grandma wrote it in her diary.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'The story had been told' (pasif masa lalu lebih lampau) mendahului tindakan menuliskannya ('wrote').",
                    ],
                    [
                        'id' => 44,
                        'id_sentence' => 'Surat itu telah dilipat rapi sebelum dimasukkan ke dalam amplop.',
                        'target_word' => 'had been folded ... was put (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'letter had been folded', 'id' => 'surat telah dilipat'],
                            ['en' => 'neatly', 'id' => 'rapi'],
                            ['en' => 'put into the envelope', 'id' => 'dimasukkan ke dalam amplop'],
                        ],
                        'options' => [
                            'The letter had been folded neatly before it was put into the envelope.',
                            'The letter has been folded neatly before it was put into the envelope.',
                            'The letter had folded neatly before it was put into the envelope.',
                            'The letter had being folded neatly before it was put into the envelope.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pelipatan surat terjadi lebih awal ('had been folded') sebelum dimasukkan ke amplop ('was put').",
                    ],
                    [
                        'id' => 45,
                        'id_sentence' => 'Uang jajan kami telah dibagi rata sebelum minggu itu berakhir.',
                        'target_word' => 'had been divided (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'our pocket money', 'id' => 'uang jajan kami'],
                            ['en' => 'divided equally', 'id' => 'dibagi rata'],
                            ['en' => 'the week ended', 'id' => 'minggu itu berakhir'],
                        ],
                        'options' => [
                            'Our pocket money had been divided equally before the week ended.',
                            'Our pocket money have been divided equally before the week ended.',
                            'Our pocket money was being divided equally before the week ended.',
                            'Our pocket money had divided equally before the week ended.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek pasif 'pocket money' berpasangan dengan 'had been divided'.",
                    ],
                    [
                        'id' => 46,
                        'id_sentence' => 'Dua puluh undangan telah dikirim sebelum pesta itu dibatalkan sementara.',
                        'target_word' => 'had been sent ... was canceled (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'twenty invitations had been sent', 'id' => '20 undangan telah dikirim'],
                            ['en' => 'party was temporarily canceled', 'id' => 'pesta dibatalkan sementara'],
                        ],
                        'options' => [
                            'Twenty invitations had been sent before the party was temporarily canceled.',
                            'Twenty invitations have been sent before the party was temporarily canceled.',
                            'Twenty invitations were being sent before the party was temporarily canceled.',
                            'Twenty invitations had sent before the party was temporarily canceled.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pengiriman 20 undangan selesai mendahului pembatalan pesta lampau: 'had been sent'.",
                    ],
                    [
                        'id' => 47,
                        'id_sentence' => 'Alat-alat masak telah dicuci bersih sebelum masakan kedua dimulai.',
                        'target_word' => 'had been washed (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'cooking utensils had been washed', 'id' => 'alat-alat masak telah dicuci'],
                            ['en' => 'thoroughly', 'id' => 'bersih'],
                            ['en' => 'second round of cooking began', 'id' => 'masakan kedua dimulai'],
                        ],
                        'options' => [
                            'The cooking utensils had been washed thoroughly before the second round of cooking began.',
                            'The cooking utensils have been washed thoroughly before the second round of cooking began.',
                            'The cooking utensils was being washed thoroughly before the second round of cooking began.',
                            'The cooking utensils had washed thoroughly before the second round of cooking began.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pencucian selesai mendahului masakan kedua: 'had been washed'.",
                    ],
                    [
                        'id' => 48,
                        'id_sentence' => 'Lampu jalan baru telah dipasang di desa itu setahun sebelum banjir besar melanda.',
                        'target_word' => 'had been installed (Past Perfect Passive with Time Gap)',
                        'vocab' => [
                            ['en' => 'new street lamp had been installed', 'id' => 'lampu jalan baru telah dipasang'],
                            ['en' => 'one year before', 'id' => 'setahun sebelumnya'],
                            ['en' => 'big flood struck', 'id' => 'banjir besar melanda'],
                        ],
                        'options' => [
                            'A new street lamp had been installed in the village a year before the big flood struck.',
                            'A new street lamp has been installed in the village a year before the big flood struck.',
                            'A new street lamp was being installed in the village a year before the big flood struck.',
                            'A new street lamp had installed in the village a year before the big flood struck.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pemasangan lampu selesai setahun sebelum banjir lampau terjadi: 'had been installed'.",
                    ],
                    [
                        'id' => 49,
                        'id_sentence' => 'Daftar nama peserta telah diperiksa oleh guru sebelum dibagikan kepada orang tua.',
                        'target_word' => 'had been checked ... was shared (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'participant list had been checked', 'id' => 'daftar nama peserta telah diperiksa'],
                            ['en' => 'teacher', 'id' => 'guru'],
                            ['en' => 'shared with the parents', 'id' => 'dibagikan kepada orang tua'],
                        ],
                        'options' => [
                            'The participant list had been checked by the teacher before it was shared with the parents.',
                            'The participant list has been checked by the teacher before it was shared with the parents.',
                            'The participant list had checked by the teacher before it was shared with the parents.',
                            'The participant list was being checked by the teacher before it was shared with the parents.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pemeriksaan daftar tuntas sebelum dibagikan: 'had been checked'.",
                    ],
                    [
                        'id' => 50,
                        'id_sentence' => 'Jadwal piket kelas telah disetujui oleh wali kelas sebelum liburan dimulai.',
                        'target_word' => 'had been approved (Past Perfect Passive)',
                        'vocab' => [
                            ['en' => 'class duty schedule had been approved', 'id' => 'jadwal piket kelas telah disetujui'],
                            ['en' => 'homeroom teacher', 'id' => 'wali kelas'],
                            ['en' => 'the holiday began', 'id' => 'liburan dimulai'],
                        ],
                        'options' => [
                            'The class duty schedule had been approved by the homeroom teacher before the holiday began.',
                            'The class duty schedule has been approved by the homeroom teacher before the holiday began.',
                            'The class duty schedule had approved by the homeroom teacher before the holiday began.',
                            'The class duty schedule was being approved by the homeroom teacher before the holiday began.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Persetujuan jadwal diselesaikan sebelum liburan mulai: 'had been approved'.",
                    ],
                ]
            ],
            [
                'id' => 'timeline-connectors-sequencing',
                'name' => '1.12.6 Timeline Connectors & Conjunctions: By the time, Prior to, Once, When, While',
                'code' => '1.12.6',
                'concept_title' => 'Penghubung Linimasa: By the time, Prior to, When, While',
                'concept_description' => "Menyusun cerita yang runtut membutuhkan konjungsi waktu yang tepat. Pola 'By the time + Simple Past, Subject + Past Perfect' menandai bahwa tindakan telah selesai sebelum batas waktu tercapai. Sebaliknya, 'While + Past Continuous' menandai durasi simultan. Memilih tenses yang selaras dengan kata hubung adalah kunci cerita yang jelas.",
                'description' => "Menyusun cerita yang runtut membutuhkan konjungsi waktu yang tepat. Pola 'By the time + Simple Past, Subject + Past Perfect' menandai bahwa tindakan telah selesai sebelum batas waktu tercapai. Sebaliknya, 'While + Past Continuous' menandai durasi simultan. Memilih tenses yang selaras dengan kata hubung adalah kunci cerita yang jelas.",
                'formula' => 'By the time + S + V2 (Past), S + had + V3 / had been V3 | While + S + was/were V-ing, S + V2',
                'rules' => [
                    "'By the time' + Simple Past mensyaratkan induk kalimat berbentuk Past Perfect ('By the time we arrived, the food had been eaten').",
                    "'Prior to' adalah frasa formal yang diikuti Noun Phrase atau Gerund V-ing ('Prior to leaving, we had packed everything').",
                    "'While' mengawali klausa berdurasi sedang berlangsung (Past Continuous).",
                    "'Once' sebagai konjungsi lampau menghubungkan aksi tuntas dengan aksi berikutnya.",
                ],
                'exercises' => [
                    [
                        'id' => 51,
                        'id_sentence' => 'Menjelang saat kami tiba di pesta, sebagian besar makanan telah habis dimakan.',
                        'target_word' => 'By the time ... had been eaten (Timeline Connector: By the time)',
                        'vocab' => [
                            ['en' => 'by the time we arrived', 'id' => 'menjelang saat kami tiba'],
                            ['en' => 'had already been eaten', 'id' => 'telah habis dimakan'],
                        ],
                        'options' => [
                            'By the time we arrived at the party, most of the food had already been eaten.',
                            'By the time we arrived at the party, most of the food has already been eaten.',
                            'By the time we had arrived at the party, most of the food was already eaten.',
                            'By the time we arrived at the party, most of the food was already being eaten so far.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pola baku 'By the time + Simple Past ('arrived')' mewajibkan induk kalimat menggunakan Past Perfect ('had been eaten').",
                    ],
                    [
                        'id' => 52,
                        'id_sentence' => 'Sebelum berangkat berkemah, kami telah mengepak semua perlengkapan.',
                        'target_word' => 'Prior to leaving ... had packed (Prepositional Connectors)',
                        'vocab' => [
                            ['en' => 'prior to leaving for camp', 'id' => 'sebelum berangkat berkemah'],
                            ['en' => 'had packed all the gear', 'id' => 'telah mengepak semua perlengkapan'],
                        ],
                        'options' => [
                            'Prior to leaving for camp, we had packed all the gear.',
                            'Prior to leaving for camp, we has packed all the gear.',
                            'Prior to leaving for camp, we packed had all the gear.',
                            'Prior to leaving for camp, we have packed all the gear back then.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Frasa 'Prior to leaving' mendahului tindakan lampau, sehingga induk kalimat memakai 'had packed'.",
                    ],
                    [
                        'id' => 53,
                        'id_sentence' => 'Menjelang usia tujuh tahun, aku telah belajar berenang dan bersepeda.',
                        'target_word' => 'By the age of seven ... had learned (Timeline Milestone)',
                        'vocab' => [
                            ['en' => 'by the age of seven', 'id' => 'menjelang usia tujuh tahun'],
                            ['en' => 'had learned to swim and ride a bike', 'id' => 'telah belajar berenang dan bersepeda'],
                        ],
                        'options' => [
                            'By the age of seven, I had learned to swim and ride a bike.',
                            'By the age of seven, I has learned to swim and ride a bike.',
                            'By the age of seven, I learned had to swim and ride a bike.',
                            'By the age of seven, I have learned to swim and ride a bike back then.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Batas waktu lampau 'By the age of seven' mewajibkan Past Perfect 'had learned'.",
                    ],
                    [
                        'id' => 54,
                        'id_sentence' => 'Sementara Ayah sedang memeriksa angka-angka itu, Ibu mengumumkan hasil undian keluarga.',
                        'target_word' => 'While ... was checking ... announced (Simultaneous vs Interruption)',
                        'vocab' => [
                            ['en' => 'Dad was checking', 'id' => 'Ayah sedang memeriksa'],
                            ['en' => 'the numbers', 'id' => 'angka-angka'],
                            ['en' => 'Mom announced the family raffle result', 'id' => 'Ibu mengumumkan hasil undian keluarga'],
                        ],
                        'options' => [
                            'While Dad was checking the numbers, Mom announced the family raffle result.',
                            'While Dad were checking the numbers, Mom announced the family raffle result.',
                            'While Dad was check the numbers, Mom announced the family raffle result.',
                            'While Dad was checking the numbers, Mom was announced the family raffle result.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'While' + Past Continuous tunggal 'was checking', disela oleh tindakan 'announced'.",
                    ],
                    [
                        'id' => 55,
                        'id_sentence' => 'Menjelang saat laporan nilai dibagikan, aku telah merevisi tugasku sebanyak dua kali.',
                        'target_word' => 'By the time ... had revised (By the time Sequence)',
                        'vocab' => [
                            ['en' => 'by the time report cards were shared', 'id' => 'menjelang saat laporan nilai dibagikan'],
                            ['en' => 'had revised my assignment twice', 'id' => 'telah merevisi tugasku dua kali'],
                        ],
                        'options' => [
                            'By the time the report cards were shared, I had revised my assignment twice.',
                            'By the time the report cards were shared, I has revised my assignment twice.',
                            'By the time the report cards had been shared, I revised my assignment twice.',
                            'By the time the report cards were shared, I revised had my assignment twice.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'By the time' + Simple Past Pasif ('were shared'), induk kalimat memakai Past Perfect 'had revised'.",
                    ],
                    [
                        'id' => 56,
                        'id_sentence' => 'Sebelum ujian praktik dilakukan, kami telah berlatih bermain pianika di rumah.',
                        'target_word' => 'Prior to taking ... had practiced (Prior to + Gerund)',
                        'vocab' => [
                            ['en' => 'prior to taking the practical exam', 'id' => 'sebelum melakukan ujian praktik'],
                            ['en' => 'had practiced playing the melodica at home', 'id' => 'telah berlatih bermain pianika di rumah'],
                        ],
                        'options' => [
                            'Prior to taking the practical exam, we had practiced playing the melodica at home.',
                            'Prior to taking the practical exam, we has practiced playing the melodica at home.',
                            'Prior to taking the practical exam, we had practice playing the melodica at home.',
                            'Prior to taking the practical exam, we have practiced playing the melodica at home back then.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Latihan selesai lebih dulu sebelum ujian praktik: 'had practiced'.",
                    ],
                    [
                        'id' => 57,
                        'id_sentence' => 'Begitu Ayah menyetujui rencana itu, kami segera memesan tiket untuk liburan.',
                        'target_word' => 'Once ... approved ... ordered (Immediate Sequence with Once)',
                        'vocab' => [
                            ['en' => 'once Dad approved the plan', 'id' => 'begitu Ayah menyetujui rencana'],
                            ['en' => 'we ordered tickets for the holiday', 'id' => 'kami memesan tiket untuk liburan'],
                        ],
                        'options' => [
                            'Once Dad approved the plan, we ordered tickets for the holiday.',
                            'Once Dad had approved the plan, we orders tickets for the holiday.',
                            'Once Dad approved the plan, we were ordered tickets for the holiday.',
                            'Once Dad will approve the plan, we ordered tickets for the holiday.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Dua tindakan berurutan langsung yang saling terkait cepat di masa lalu menggunakan Simple Past: 'approved' disusul 'ordered'.",
                    ],
                    [
                        'id' => 58,
                        'id_sentence' => 'Menjelang akhir tahun itu, kebiasaan menabung telah mengubah pola belanja keluarga kami secara signifikan.',
                        'target_word' => 'By the end of ... had changed (Milestone Past Perfect)',
                        'vocab' => [
                            ['en' => 'by the end of that year', 'id' => 'menjelang akhir tahun itu'],
                            ['en' => 'habit of saving had changed', 'id' => 'kebiasaan menabung telah mengubah'],
                            ["en" => "our family's spending pattern", "id" => "pola belanja keluarga kami"],
                        ],
                        'options' => [
                            "By the end of that year, the habit of saving had changed our family's spending pattern significantly.",
                            "By the end of that year, the habit of saving has changed our family's spending pattern significantly.",
                            "By the end of that year, the habit of saving changed had our family's spending pattern significantly.",
                            "By the end of that year, the habit of saving was changed our family's spending pattern significantly.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "'By the end of that year' adalah penanda waktu pembatas masa lampau yang mewajibkan 'had changed'.",
                    ],
                    [
                        'id' => 59,
                        'id_sentence' => 'Sementara kue-kue sedang dibagikan, anak-anak terus bermain di halaman.',
                        'target_word' => 'While ... were being handed out ... kept playing (Simultaneous Ongoing Passive + Active)',
                        'vocab' => [
                            ['en' => 'cookies were being handed out', 'id' => 'kue-kue sedang dibagikan'],
                            ['en' => 'children kept playing in the yard', 'id' => 'anak-anak terus bermain di halaman'],
                        ],
                        'options' => [
                            'While the cookies were being handed out, the children kept playing in the yard.',
                            'While the cookies was being handed out, the children kept playing in the yard.',
                            'While the cookies were been handed out, the children kept playing in the yard.',
                            'While the cookies were handing out, the children kept playing in the yard.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa 'While' memakai pasif continuous jamak 'were being handed out', diiringi aksi utama 'kept playing'.",
                    ],
                    [
                        'id' => 60,
                        'id_sentence' => 'Sebelum wali kelas memutuskan pemenang, kedua kelompok telah mencapai skor seri.',
                        'target_word' => 'Before the teacher decided ... had reached (Earlier Past Agreement)',
                        'vocab' => [
                            ['en' => 'homeroom teacher decided the winner', 'id' => 'wali kelas memutuskan pemenang'],
                            ['en' => 'both groups had reached a tied score', 'id' => 'kedua kelompok telah mencapai skor seri'],
                        ],
                        'options' => [
                            'Before the homeroom teacher decided the winner, both groups had reached a tied score.',
                            'Before the homeroom teacher decided the winner, both groups has reached a tied score.',
                            'Before the homeroom teacher had decided the winner, both groups reached a tied score.',
                            'Before the homeroom teacher decided the winner, both groups reached had a tied score.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Skor seri tercapai lebih dahulu ('had reached') sebelum guru memutuskan ('decided').",
                    ],
                ]
            ],
            [
                'id' => 'past-perfect-continuous',
                'name' => '1.12.7 Past Perfect Continuous: Ongoing Duration Before a Past Event',
                'code' => '1.12.7',
                'concept_title' => 'Past Perfect Continuous: Durasi Tindakan Lampau Sebelum Terjadinya Peristiwa Lain',
                'concept_description' => "Past Perfect Continuous (had been + Verb-ing) digunakan untuk menekankan lamanya durasi suatu tindakan yang sedang berlangsung dan berakumulasi di masa lalu sebelum titik waktu atau peristiwa lampau lainnya terjadi. Tense ini sangat umum untuk menyoroti berapa lama sesuatu sudah berlangsung sebelum suatu kejadian terjadi ('It had been raining for hours before the flood happened').",
                'description' => "Past Perfect Continuous (had been + Verb-ing) digunakan untuk menekankan lamanya durasi suatu tindakan yang sedang berlangsung dan berakumulasi di masa lalu sebelum titik waktu atau peristiwa lampau lainnya terjadi. Tense ini sangat umum untuk menyoroti berapa lama sesuatu sudah berlangsung sebelum suatu kejadian terjadi ('It had been raining for hours before the flood happened').",
                'formula' => 'Subject + had been + Verb-ing + for/since (duration) + before / when + Simple Past Clause',
                'rules' => [
                    'Rumus baku: Subject + had been + Verb-ing + duration marker (for two hours, for days).',
                    "Berlaku seragam untuk seluruh subjek tunggal dan jamak ('had been + V-ing').",
                    'Menekankan durasi proses yang sedang berjalan hingga disela atau dihentikan oleh peristiwa lampau (Simple Past).',
                    'Jangan gunakan stative verbs dalam bentuk continuous (*had been knowing adalah SALAH; gunakan Past Perfect simple: had known).',
                ],
                'exercises' => [
                    [
                        'id' => 61,
                        'id_sentence' => 'Hujan telah turun selama berjam-jam sebelum banjir terjadi.',
                        'target_word' => 'had been raining ... happened (Durative Pre-Past Action)',
                        'vocab' => [
                            ['en' => 'had been raining', 'id' => 'telah turun hujan (berdurasi)'],
                            ['en' => 'for hours', 'id' => 'selama berjam-jam'],
                            ['en' => 'the flood happened', 'id' => 'banjir terjadi'],
                        ],
                        'options' => [
                            'It had been raining for hours before the flood happened.',
                            'It have been raining for hours before the flood happened.',
                            'It was raining for hours before the flood happened.',
                            'It had raining for hours before the flood happened.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Untuk menekankan proses hujan berdurasi panjang ('for hours') yang mendahului banjir lampau ('happened'), gunakan Past Perfect Continuous 'had been raining'.",
                    ],
                    [
                        'id' => 62,
                        'id_sentence' => 'Mesin cuci itu telah mengeluarkan bunyi aneh selama berjam-jam sebelum akhirnya rusak total.',
                        'target_word' => 'had been making ... broke (Continuous Accumulation Before Failure)',
                        'vocab' => [
                            ['en' => 'washing machine had been making', 'id' => 'mesin cuci telah mengeluarkan bunyi'],
                            ['en' => 'for hours', 'id' => 'selama berjam-jam'],
                            ['en' => 'finally broke down', 'id' => 'akhirnya rusak total'],
                        ],
                        'options' => [
                            'The washing machine had been making a strange noise for hours before it finally broke down.',
                            'The washing machine has been making a strange noise for hours before it finally broke down.',
                            'The washing machine was making a strange noise for hours before it finally broke down.',
                            'The washing machine had making a strange noise for hours before it finally broke down.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Bunyi aneh telah berlangsung akumulatif selama berjam-jam sebelum rusak: 'had been making'.",
                    ],
                    [
                        'id' => 63,
                        'id_sentence' => 'Keluarga itu telah tinggal di rumah itu selama bertahun-tahun sebelum mereka pindah ke kota lain.',
                        'target_word' => 'had been living ... moved (Durative Residence Before Event)',
                        'vocab' => [
                            ['en' => 'had been living', 'id' => 'telah tinggal'],
                            ['en' => 'for years', 'id' => 'selama bertahun-tahun'],
                            ['en' => 'moved to another city', 'id' => 'pindah ke kota lain'],
                        ],
                        'options' => [
                            'The family had been living in that house for years before they moved to another city.',
                            'The family has been living in that house for years before they moved to another city.',
                            'The family was living in that house for years before they moved to another city.',
                            'The family had living in that house for years before they moved to another city.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Tempat tinggal bertahun-tahun mendahului kepindahan lampau: 'had been living'.",
                    ],
                    [
                        'id' => 64,
                        'id_sentence' => 'Petani telah memantau kondisi sawah selama berminggu-minggu sebelum musim panen tiba.',
                        'target_word' => 'had been monitoring ... arrived (Monitoring Duration)',
                        'vocab' => [
                            ['en' => 'farmers had been monitoring', 'id' => 'petani telah memantau'],
                            ['en' => 'for weeks', 'id' => 'selama berminggu-minggu'],
                            ['en' => 'harvest season arrived', 'id' => 'musim panen tiba'],
                        ],
                        'options' => [
                            'Farmers had been monitoring the rice fields for weeks before the harvest season arrived.',
                            'Farmers have been monitoring the rice fields for weeks before the harvest season arrived.',
                            'Farmers were monitoring the rice fields for weeks before the harvest season arrived.',
                            'Farmers had monitoring the rice fields for weeks before the harvest season arrived.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Aktivitas pemantauan berdurasi minggu-minggu sebelum musim panen lampau: 'had been monitoring'.",
                    ],
                    [
                        'id' => 65,
                        'id_sentence' => 'Suhu air di dalam panci telah meningkat secara stabil selama tiga puluh menit sebelum mencapai titik didih.',
                        'target_word' => 'had been rising ... reached (Thermal Rise Duration)',
                        'vocab' => [
                            ['en' => 'water temperature had been rising', 'id' => 'suhu air telah meningkat'],
                            ['en' => 'steadily for thirty minutes', 'id' => 'secara stabil selama 30 menit'],
                            ['en' => 'reached boiling point', 'id' => 'mencapai titik didih'],
                        ],
                        'options' => [
                            'The water temperature in the pot had been rising steadily for thirty minutes before reaching boiling point.',
                            'The water temperature in the pot has been rising steadily for thirty minutes before reaching boiling point.',
                            'The water temperature in the pot was rising steadily for thirty minutes before reaching boiling point.',
                            'The water temperature in the pot had rising steadily for thirty minutes before reaching boiling point.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'had been rising steadily for thirty minutes' menekankan durasi kenaikan suhu sebelum batas didih tercapai.",
                    ],
                    [
                        'id' => 66,
                        'id_sentence' => 'Kakak telah memperingatkan tentang rem sepeda yang aus selama berbulan-bulan sebelum akhirnya rem itu benar-benar blong.',
                        'target_word' => 'had been warning ... failed (Warning Duration)',
                        'vocab' => [
                            ['en' => 'my brother had been warning', 'id' => 'kakak telah memperingatkan'],
                            ['en' => 'worn-out brakes for months', 'id' => 'rem yang aus selama berbulan-bulan'],
                            ['en' => 'finally failed completely', 'id' => 'akhirnya benar-benar blong'],
                        ],
                        'options' => [
                            'My brother had been warning about the worn-out brakes for months before they finally failed completely.',
                            'My brother have been warning about the worn-out brakes for months before they finally failed completely.',
                            'My brother was warning about the worn-out brakes for months before they finally failed completely.',
                            'My brother had warning about the worn-out brakes for months before they finally failed completely.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'had been warning ... for months' melukiskan peringatan berkelanjutan sebelum rem blong.",
                    ],
                    [
                        'id' => 67,
                        'id_sentence' => 'Komputer itu telah menyala tanpa henti selama lima hari sebelum tiba-tiba mati sendiri.',
                        'target_word' => 'had been running ... shut down (Continuous Operation Before Shutdown)',
                        'vocab' => [
                            ['en' => 'computer had been running', 'id' => 'komputer telah menyala'],
                            ['en' => 'nonstop for five days', 'id' => 'tanpa henti selama lima hari'],
                            ['en' => 'suddenly shut down by itself', 'id' => 'tiba-tiba mati sendiri'],
                        ],
                        'options' => [
                            'The computer had been running nonstop for five days before it suddenly shut down by itself.',
                            'The computer has been running nonstop for five days before it suddenly shut down by itself.',
                            'The computer was running nonstop for five days before it suddenly shut down by itself.',
                            'The computer had running nonstop for five days before it suddenly shut down by itself.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Durasi operasi 5 hari tanpa henti diungkapkan dengan 'had been running'.",
                    ],
                    [
                        'id' => 68,
                        'id_sentence' => 'Kami telah menunggu bus selama empat puluh menit ketika akhirnya bus itu datang.',
                        'target_word' => 'had been waiting ... finally came (Waiting Duration Before Arrival)',
                        'vocab' => [
                            ['en' => 'we had been waiting for the bus', 'id' => 'kami telah menunggu bus'],
                            ['en' => 'for forty minutes', 'id' => 'selama 40 menit'],
                            ['en' => 'it finally came', 'id' => 'bus itu akhirnya datang'],
                        ],
                        'options' => [
                            'We had been waiting for the bus for forty minutes when it finally came.',
                            'We has been waiting for the bus for forty minutes when it finally came.',
                            'We were waiting for the bus for forty minutes when it finally came.',
                            'We had waiting for the bus for forty minutes when it finally came.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Durasi menunggu sebelum bus datang lampau: 'had been waiting'.",
                    ],
                    [
                        'id' => 69,
                        'id_sentence' => 'Kedua sahabat itu telah mengobrol sepanjang malam sebelum mereka akhirnya tertidur.',
                        'target_word' => 'had been chatting ... fell asleep (Overnight Chat Duration)',
                        'vocab' => [
                            ['en' => 'the two best friends had been chatting', 'id' => 'kedua sahabat telah mengobrol'],
                            ['en' => 'all night', 'id' => 'sepanjang malam'],
                            ['en' => 'finally fell asleep', 'id' => 'akhirnya tertidur'],
                        ],
                        'options' => [
                            'The two best friends had been chatting all night before they finally fell asleep.',
                            'The two best friends have been chatting all night before they finally fell asleep.',
                            'The two best friends were chatting all night before they finally fell asleep.',
                            'The two best friends had chatting all night before they finally fell asleep.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'had been chatting ... all night' menekankan proses mengobrol berjam-jam sebelum akhirnya tertidur.",
                    ],
                    [
                        'id' => 70,
                        'id_sentence' => 'Air sungai itu telah meluap selama dua jam sebelum tanggul darurat akhirnya jebol.',
                        'target_word' => 'had been overflowing ... breached (Water Level Duration)',
                        'vocab' => [
                            ['en' => 'river had been overflowing', 'id' => 'air sungai telah meluap'],
                            ['en' => 'for two hours', 'id' => 'selama dua jam'],
                            ['en' => 'emergency levee breached', 'id' => 'tanggul darurat jebol'],
                        ],
                        'options' => [
                            'The river had been overflowing for two hours before the emergency levee finally breached.',
                            'The river has been overflowing for two hours before the emergency levee finally breached.',
                            'The river was overflowing for two hours before the emergency levee finally breached.',
                            'The river had overflowing for two hours before the emergency levee finally breached.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Durasi luapan 2 jam sebelum tanggul jebol: 'had been overflowing'.",
                    ],
                ]
            ],
            [
                'id' => 'timeline-full-story-synthesis',
                'name' => '1.12.8 Comprehensive Synthesis: Combining Three Past Tenses in One Story',
                'code' => '1.12.8',
                'concept_title' => 'Sintesis Lengkap: Menggabungkan Tiga Bentuk Waktu Lampau dalam Satu Cerita',
                'concept_description' => 'Menggabungkan Simple Past, Past Continuous, dan Past Perfect (aktif maupun pasif) ke dalam satu cerita sehari-hari yang runtut dan mudah dipahami, seperti menceritakan piknik keluarga, acara sekolah, atau kegiatan sehari-hari. Latihan ini melatih kemampuan menyusun urutan kejadian: apa yang sudah terjadi lebih dulu, apa yang sedang berlangsung, dan apa peristiwa utamanya.',
                'description' => 'Menggabungkan Simple Past, Past Continuous, dan Past Perfect (aktif maupun pasif) ke dalam satu cerita sehari-hari yang runtut dan mudah dipahami, seperti menceritakan piknik keluarga, acara sekolah, atau kegiatan sehari-hari. Latihan ini melatih kemampuan menyusun urutan kejadian: apa yang sudah terjadi lebih dulu, apa yang sedang berlangsung, dan apa peristiwa utamanya.',
                'formula' => 'Gabungan Tiga Waktu: Latar Belakang (Past Continuous) + Kejadian Sebelumnya (Past Perfect) + Peristiwa Utama (Simple Past)',
                'rules' => [
                    "Gunakan Past Perfect untuk kejadian yang sudah selesai sebelum kejadian lain di masa lalu ('After the plates had been washed...').",
                    "Gunakan Past Continuous untuk kegiatan yang sedang berlangsung ('...while Dad was grilling fish...').",
                    "Gunakan Simple Past untuk kejadian utama atau titik waktu tertentu ('...Mom set the table...').",
                    'Jaga urutan cerita tetap jelas agar pembaca mudah mengikuti apa yang terjadi lebih dulu dan apa yang terjadi kemudian.',
                ],
                'exercises' => [
                    [
                        'id' => 71,
                        'id_sentence' => 'Setelah piring-piring telah dicuci dan dikeringkan, Ibu menata meja sementara Ayah sedang memanggang ikan di halaman.',
                        'target_word' => 'had been washed ... set ... was grilling (Multi-Tense Sequence)',
                        'vocab' => [
                            ['en' => 'had been washed and dried', 'id' => 'telah dicuci dan dikeringkan'],
                            ['en' => 'set the table', 'id' => 'menata meja'],
                            ['en' => 'Dad was grilling fish', 'id' => 'Ayah sedang memanggang ikan'],
                        ],
                        'options' => [
                            'After the plates had been washed and dried, Mom set the table while Dad was grilling fish in the yard.',
                            'After the plates have been washed and dried, Mom set the table while Dad was grilling fish in the yard.',
                            'After the plates had been washed and dried, Mom set the table while Dad grilled fish in the yard.',
                            'After the plates were washed and dried, Mom had set the table while Dad was grilling fish in the yard.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kombinasi 3 lapisan waktu: Persiapan awal yang selesai ('had been washed'), tindakan utama ('set'), dan latar simultan yang sedang berlangsung ('was grilling').",
                    ],
                    [
                        'id' => 72,
                        'id_sentence' => 'Meskipun Kakak telah mencoba sepatu barunya beberapa kali di rumah, lecet kecil muncul saat ia sedang mengikuti lomba lari.',
                        'target_word' => 'had tried ... appeared ... was running (Everyday Story Narrative)',
                        'vocab' => [
                            ['en' => 'had tried on her new shoes', 'id' => 'telah mencoba sepatu barunya'],
                            ['en' => 'a small blister appeared', 'id' => 'lecet kecil muncul'],
                            ['en' => 'was running in the race', 'id' => 'sedang mengikuti lomba lari'],
                        ],
                        'options' => [
                            'Although my sister had tried on her new shoes several times at home, a small blister appeared while she was running in the race.',
                            'Although my sister have tried on her new shoes several times at home, a small blister appeared while she was running in the race.',
                            'Although my sister had tried on her new shoes several times at home, a small blister was appeared while she was running in the race.',
                            'Although my sister tried on her new shoes several times at home, a small blister appeared while she ran in the race.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Percobaan awal selesai ('had tried'), lecet tiba-tiba muncul ('appeared'), saat lomba sedang berlangsung ('was running').",
                    ],
                    [
                        'id' => 73,
                        'id_sentence' => 'Sebelum aturan sekolah yang baru diberlakukan, murid-murid telah membawa ponsel ke kelas tanpa izin.',
                        'target_word' => 'was enacted ... had been bringing (Past Passive Boundary + Past Perfect Continuous)',
                        'vocab' => [
                            ['en' => 'new school rule was enacted', 'id' => 'aturan sekolah baru diberlakukan'],
                            ['en' => 'had been bringing phones to class', 'id' => 'telah membawa ponsel ke kelas'],
                            ['en' => 'without permission', 'id' => 'tanpa izin'],
                        ],
                        'options' => [
                            'Before the new school rule was enacted, students had been bringing phones to class without permission.',
                            'Before the new school rule has been enacted, students had been bringing phones to class without permission.',
                            'Before the new school rule was enacted, students have been bringing phones to class without permission.',
                            'Before the new school rule was enacted, students were bringing phones to class without permission so far.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Penetapan aturan pasif ('was enacted') didahului oleh kebiasaan berdurasi lama ('had been bringing').",
                    ],
                    [
                        'id' => 74,
                        'id_sentence' => 'Ketika Paman tiba di lokasi kemah, keluarga telah mendirikan semua tenda sementara anak-anak sedang mengumpulkan kayu bakar.',
                        'target_word' => 'arrived ... had set up ... were collecting (Cohesive Everyday Timeline)',
                        'vocab' => [
                            ['en' => 'Uncle arrived', 'id' => 'Paman tiba'],
                            ['en' => 'had set up all the tents', 'id' => 'telah mendirikan semua tenda'],
                            ['en' => 'children were collecting firewood', 'id' => 'anak-anak sedang mengumpulkan kayu bakar'],
                        ],
                        'options' => [
                            'When Uncle arrived at the campsite, the family had set up all the tents while the children were collecting firewood.',
                            'When Uncle arrived at the campsite, the family has set up all the tents while the children were collecting firewood.',
                            'When Uncle had arrived at the campsite, the family set up all the tents while the children were collecting firewood.',
                            'When Uncle arrived at the campsite, the family were set up all the tents while the children were collecting firewood.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kedatangan ('arrived') menjumpai pendirian tenda yang sudah tuntas ('had set up') dan pengumpulan kayu yang masih berlangsung ('were collecting').",
                    ],
                    [
                        'id' => 75,
                        'id_sentence' => 'Karena penjualan kue awal telah menunjukkan hasil yang bagus, panitia menyetujui stan tambahan sementara meja-meja sedang disiapkan.',
                        'target_word' => 'had shown ... approved ... were being set up (Everyday Event Planning)',
                        'vocab' => [
                            ['en' => 'had shown good results', 'id' => 'telah menunjukkan hasil yang bagus'],
                            ['en' => 'committee approved an extra stall', 'id' => 'panitia menyetujui stan tambahan'],
                            ['en' => 'tables were being set up', 'id' => 'meja-meja sedang disiapkan'],
                        ],
                        'options' => [
                            'Because the early cake sales had shown good results, the committee approved an extra stall while the tables were being set up.',
                            'Because the early cake sales has shown good results, the committee approved an extra stall while the tables were being set up.',
                            'Because the early cake sales had shown good results, the committee had approved an extra stall while the tables were set up.',
                            'Because the early cake sales showed good results, the committee approved an extra stall while the tables was being set up.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Bukti penjualan sudah ada lebih dahulu ('had shown'), persetujuan dikeluarkan ('approved'), sementara meja pasif sedang disiapkan ('were being set up').",
                    ],
                    [
                        'id' => 76,
                        'id_sentence' => 'Menjelang pertunjukan dimulai, para guru telah memastikan bahwa semua anak yang sedang mereka hitung sudah berada di tempat duduknya.',
                        'target_word' => 'began ... had confirmed ... were counting (Multi-Layer Everyday Narrative)',
                        'vocab' => [
                            ['en' => 'show began', 'id' => 'pertunjukan dimulai'],
                            ['en' => 'had confirmed', 'id' => 'telah memastikan'],
                            ['en' => 'children they were counting', 'id' => 'anak-anak yang sedang mereka hitung'],
                            ['en' => 'already in their seats', 'id' => 'sudah berada di tempat duduknya'],
                        ],
                        'options' => [
                            'By the time the show began, the teachers had confirmed that all the children they were counting were already in their seats.',
                            'By the time the show began, the teachers has confirmed that all the children they were counting were already in their seats.',
                            'By the time the show had begun, the teachers confirmed that all the children they were counting were already in their seats.',
                            'By the time the show began, the teachers had confirmed that all the children they counted was already in their seats.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'By the time' + Simple Past ('began'), induk kalimat Past Perfect ('had confirmed'), memuat anak kalimat penghitungan yang sedang berlangsung ('were counting').",
                    ],
                    [
                        'id' => 77,
                        'id_sentence' => 'Setelah Adik telah diperiksa oleh dokter, dokter mendiagnosis flu biasa saat Adik sedang beristirahat di sofa.',
                        'target_word' => 'had been examined ... diagnosed ... was resting (Everyday Doctor Visit Sequence)',
                        'vocab' => [
                            ['en' => 'had been examined by the doctor', 'id' => 'telah diperiksa oleh dokter'],
                            ['en' => 'doctor diagnosed a common cold', 'id' => 'dokter mendiagnosis flu biasa'],
                            ['en' => 'was resting on the sofa', 'id' => 'sedang beristirahat di sofa'],
                        ],
                        'options' => [
                            'After my little brother had been examined by the doctor, the doctor diagnosed a common cold while he was resting on the sofa.',
                            'After my little brother has been examined by the doctor, the doctor diagnosed a common cold while he was resting on the sofa.',
                            'After my little brother had been examined by the doctor, the doctor was diagnosed a common cold while he was resting on the sofa.',
                            'After my little brother was examined by the doctor, the doctor had diagnosed a common cold while he was resting on the sofa.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pemeriksaan selesai lebih dulu ('had been examined'), diagnosis ditegakkan ('diagnosed'), saat adik sedang beristirahat ('was resting').",
                    ],
                    [
                        'id' => 78,
                        'id_sentence' => 'Jumlah kucing liar di taman itu telah berkurang selama bertahun-tahun sebelum warga memberlakukan program adopsi kucing.',
                        'target_word' => 'had been dwindling ... started (Everyday Trend Sequence)',
                        'vocab' => [
                            ['en' => 'number of stray cats had been dwindling', 'id' => 'jumlah kucing liar telah berkurang'],
                            ['en' => 'for years', 'id' => 'selama bertahun-tahun'],
                            ['en' => 'residents started a cat adoption program', 'id' => 'warga memberlakukan program adopsi kucing'],
                        ],
                        'options' => [
                            'The number of stray cats in the park had been dwindling for years before the residents started a cat adoption program.',
                            'The number of stray cats in the park has been dwindling for years before the residents started a cat adoption program.',
                            'The number of stray cats in the park was dwindling for years before the residents had started a cat adoption program.',
                            'The number of stray cats in the park had dwindling for years before the residents started a cat adoption program.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pengurangan berdurasi panjang sebelum tindakan lampau: 'had been dwindling'.",
                    ],
                    [
                        'id' => 79,
                        'id_sentence' => 'Ketika rapat kelas selesai, panitia telah menyelesaikan daftar belanja sementara dua siswa sedang menulis undangan.',
                        'target_word' => 'concluded ... had finalized ... were writing (Everyday Committee Sequence)',
                        'vocab' => [
                            ['en' => 'class meeting concluded', 'id' => 'rapat kelas selesai'],
                            ['en' => 'had finalized the shopping list', 'id' => 'telah menyelesaikan daftar belanja'],
                            ['en' => 'two students were writing invitations', 'id' => 'dua siswa sedang menulis undangan'],
                        ],
                        'options' => [
                            'When the class meeting concluded, the committee had finalized the shopping list while two students were writing invitations.',
                            'When the class meeting concluded, the committee has finalized the shopping list while two students were writing invitations.',
                            'When the class meeting had concluded, the committee finalized the shopping list while two students were writing invitations.',
                            'When the class meeting concluded, the committee had finalized the shopping list while two students wrote invitations.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'concluded' (titik waktu lampau) mendapati daftar belanja telah selesai ('had finalized') dan undangan sedang ditulis ('were writing').",
                    ],
                    [
                        'id' => 80,
                        'id_sentence' => 'Laporan akhir mengonfirmasi bahwa panitia telah memeriksa semua daftar sebelum formulir diserahkan, yang memastikan bahwa seluruh persiapan telah mematuhi aturan sekolah.',
                        'target_word' => 'confirmed ... had checked ... was submitted ... complied (Everyday Preparation Climax)',
                        'vocab' => [
                            ['en' => 'final report confirmed', 'id' => 'laporan akhir mengonfirmasi'],
                            ['en' => 'had checked every list', 'id' => 'telah memeriksa semua daftar'],
                            ['en' => 'form was submitted', 'id' => 'formulir diserahkan'],
                            ['en' => 'complied with school rules', 'id' => 'mematuhi aturan sekolah'],
                        ],
                        'options' => [
                            'The final report confirmed that the committee had checked every list before the form was submitted, ensuring that all preparations complied with school rules.',
                            'The final report confirmed that the committee have checked every list before the form was submitted, ensuring that all preparations complied with school rules.',
                            'The final report had confirmed that the committee checked every list before the form was submitted, ensuring that all preparations complied with school rules.',
                            'The final report confirmed that the committee had checked every list before the form was submitted, ensuring that all preparations has complied with school rules.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Sintesis linimasa multi-klausa: Laporan mengonfirmasi ('confirmed') bahwa panitia telah memeriksa lebih dulu ('had checked') sebelum formulir diserahkan ('was submitted') dan memastikan persiapan mematuhi ('complied').",
                    ],
                ]
            ],
        ];
    }
}
