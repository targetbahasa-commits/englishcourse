<?php

namespace App\Services;

class SelfStudyPresentContinuousData
{
    /**
     * Get the complete Present Continuous Tense (Verbal & Passive) package.
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
            'banner_title' => 'Present Continuous Tense (Verbal & Passive)',
            'banner_subtitle' => 'Kuasai cara menyatakan hal yang sedang terjadi sekarang (is/are + V-ing), hal yang sedang dikerjakan orang lain (is/are being + V3), perbedaan kebiasaan rutin vs kejadian sementara, serta kata kerja yang tidak boleh memakai bentuk -ing.',
            'banner_badge' => 'MODULE 1.9 PRESENT CONTINUOUS TENSE',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 1.9
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Panduan Lengkap Present Continuous Tense: Bentuk Verbal & Pasif',
            'concept_summary' => 'Present Continuous Tense dipakai untuk menyatakan hal yang sedang terjadi sekarang, tepat pada saat kita berbicara, atau hal sementara yang sedang berlangsung dalam periode belakangan ini. Dua pola utamanya adalah Bentuk Verbal Aktif (is/am/are + V-ing), untuk subjek yang melakukan sesuatu, dan Bentuk Pasif (is/am/are + being + V3), untuk sesuatu yang sedang dikerjakan oleh orang lain.',
            'rules' => [
                [
                    'rule_title' => '1. Bentuk Verbal Aktif: Hal yang Sedang Terjadi Sekarang',
                    'rule_formula' => 'Subject + am/is/are + Verb-ing + Pelengkap',
                    'rule_description' => 'Digunakan ketika subjek sedang melakukan sesuatu tepat saat ini. "is" untuk subjek tunggal (he, she, it, nama benda tunggal), "are" untuk subjek jamak (they, we, nama benda jamak), dan "am" untuk subjek I.',
                    'examples' => [
                        [
                            'en' => 'My sister is washing the dishes in the kitchen.',
                            'id' => 'Kakak perempuan saya sedang mencuci piring di dapur.',
                            'note' => 'Subjek tunggal "My sister" menggunakan to be "is" + V-ing "washing".'
                        ]
                    ]
                ],
                [
                    'rule_title' => '2. Menjelaskan Sesuatu yang Sedang Berubah',
                    'rule_formula' => 'Subject + is/are + kata kerja perubahan (-ing)',
                    'rule_description' => 'Kata kerja perubahan seperti get, grow, change, improve, increase, dan decrease dipadukan dengan continuous tense untuk menggambarkan sesuatu yang sedang berlangsung dan belum selesai.',
                    'examples' => [
                        [
                            'en' => 'The weather is getting colder this week.',
                            'id' => 'Cuaca sedang menjadi lebih dingin minggu ini.',
                            'note' => 'Menunjukkan perubahan yang sedang berlangsung, belum berakhir.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '3. Bentuk Pasif: Sesuatu yang Sedang Dikerjakan (is/are + being + V3)',
                    'rule_formula' => 'Subject (penerima) + am/is/are + being + Verb 3 (Past Participle)',
                    'rule_description' => 'Dipakai saat fokus kalimat adalah benda atau orang yang SEDANG dikerjakan/diurus, bukan siapa yang mengerjakannya. Kata "being" wajib ada di antara to be dan V3.',
                    'examples' => [
                        [
                            'en' => 'Dinner is being cooked right now.',
                            'id' => 'Makan malam sedang dimasak sekarang.',
                            'note' => 'Bandingkan: "is cooked" (fakta biasa) vs "is being cooked" (sedang berlangsung sekarang).'
                        ]
                    ]
                ],
                [
                    'rule_title' => '4. Kebiasaan Rutin (Simple Present) vs Kejadian Sementara (Continuous)',
                    'rule_formula' => 'Rutin: Subject + V1/V-s | Sementara: Subject + is/are + V-ing',
                    'rule_description' => 'Gunakan Simple Present untuk kebiasaan atau fakta sehari-hari. Gunakan Present Continuous bila hal itu hanya terjadi sekarang/hari ini/minggu ini, biasanya ditandai kata seperti "today, right now, this week, at the moment".',
                    'examples' => [
                        [
                            'en' => 'She usually walks to school, but today she is taking the bus.',
                            'id' => 'Dia biasanya berjalan kaki ke sekolah, tapi hari ini dia naik bus.',
                            'note' => '"usually walks" = kebiasaan, "is taking" = kejadian khusus hari ini.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '5. Kata Kerja yang Tidak Boleh Memakai Bentuk -ing (Stative Verbs)',
                    'rule_formula' => 'Subject + Stative Verb (bentuk Simple Present)',
                    'rule_description' => 'Kata kerja yang menyatakan perasaan, pikiran, kepemilikan, atau isi (misalnya: understand, believe, have, like, want, need, know, contain, belong) TIDAK memakai bentuk -ing, walaupun maknanya tentang "sekarang".',
                    'examples' => [
                        [
                            'en' => 'I understand the lesson now. (BUKAN: I am understanding the lesson now.)',
                            'id' => 'Saya mengerti pelajaran ini sekarang.',
                            'note' => '"understand" adalah kata kerja perasaan/pikiran, tidak punya bentuk -ing.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '6. Bentuk Negatif & Pertanyaan',
                    'rule_formula' => 'Negatif: Subject + is/are not + V-ing | Tanya: Is/Are + Subject + V-ing?',
                    'rule_description' => 'Untuk kalimat negatif, letakkan "not" tepat setelah to be (is not / are not). Untuk kalimat tanya, pindahkan to be ke depan kalimat, sebelum subjek.',
                    'examples' => [
                        [
                            'en' => 'The children are not sleeping yet.',
                            'id' => 'Anak-anak belum sedang tidur.',
                            'note' => 'Bentuk negatif: are + not + V-ing.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '7. Kata Keterangan Waktu Bersama Continuous Tense',
                    'rule_formula' => 'right now, at the moment, today, currently, these days',
                    'rule_description' => 'Kata keterangan waktu ini biasa diletakkan di antara to be dan kata kerja utama (misalnya: "is currently reading") atau di awal kalimat ("Right now, she is cooking...") untuk memperjelas bahwa hal itu terjadi saat ini.',
                    'examples' => [
                        [
                            'en' => 'Right now, Dad is fixing the bicycle in the garage.',
                            'id' => 'Sekarang, Ayah sedang memperbaiki sepeda di garasi.',
                            'note' => '"Right now" diletakkan di awal kalimat untuk menegaskan waktu kejadian.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '8. Menggabungkan Dua Kejadian yang Sedang Berlangsung Bersamaan',
                    'rule_formula' => 'While/Because/As + Klausa 1 (Continuous) + Koma + Klausa 2 (Continuous)',
                    'rule_description' => 'Gunakan kata sambung seperti "while" (sementara/selagi) atau "because"/"as" (karena) untuk menghubungkan dua hal yang sedang terjadi pada waktu yang sama.',
                    'examples' => [
                        [
                            'en' => 'While Mom is cooking, Dad is setting the table.',
                            'id' => 'Sementara Ibu sedang memasak, Ayah sedang menyiapkan meja makan.',
                            'note' => 'Dua klausa continuous digabung dengan "while" karena terjadi bersamaan.'
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
            // Sub-Lesson 1.9.1
            [
                'id' => 'present-continuous-verbal',
                'name' => '1.9.1 Present Continuous Verbal: Hal yang Sedang Terjadi Sekarang',
                'code' => '1.9.1',
                'concept_title' => 'Present Continuous Verbal: Hal yang Sedang Terjadi Sekarang',
                'concept_description' => 'Present Continuous Verbal digunakan untuk menyatakan sesuatu yang sedang aktif dilakukan subjek tepat saat ini. Bentuknya adalah to be (am/is/are) yang sesuai dengan subjek, diikuti kata kerja berakhiran -ing.',
                'description' => 'Present Continuous Verbal digunakan untuk menyatakan sesuatu yang sedang aktif dilakukan subjek tepat saat ini. Bentuknya adalah to be (am/is/are) yang sesuai dengan subjek, diikuti kata kerja berakhiran -ing.',
                'formula' => 'Subject + am/is/are + Verb-ing + Objek / Keterangan',
                'rules' => [
                    'Gunakan "is" untuk subjek tunggal (he, she, it, nama benda tunggal).',
                    'Gunakan "are" untuk subjek jamak (they, we, nama benda jamak).',
                    'Gunakan "am" untuk subjek "I".',
                    'Pastikan selalu ada to be sebelum V-ing; menghilangkan to be adalah kesalahan.'
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'id_sentence' => 'Kakak laki-laki saya sedang mencuci mobil di halaman depan.',
                        'target_word' => 'is washing (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'older brother', 'id' => 'kakak laki-laki'],
                            ['en' => 'front yard', 'id' => 'halaman depan'],
                            ['en' => 'washing the car', 'id' => 'mencuci mobil']
                        ],
                        'options' => [
                            'My older brother is washing the car in the front yard.',
                            'My older brother are washing the car in the front yard.',
                            'My older brother is wash the car in the front yard.',
                            'My older brother washing the car in the front yard.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "My older brother" membutuhkan to be "is" diikuti V-ing "washing".'
                    ],
                    [
                        'id' => 2,
                        'id_sentence' => 'Ibu saya sedang memasak nasi goreng untuk sarapan.',
                        'target_word' => 'is cooking (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'my mother', 'id' => 'ibu saya'],
                            ['en' => 'fried rice', 'id' => 'nasi goreng'],
                            ['en' => 'breakfast', 'id' => 'sarapan']
                        ],
                        'options' => [
                            'My mother is cooking fried rice for breakfast.',
                            'My mother are cooking fried rice for breakfast.',
                            'My mother is cook fried rice for breakfast.',
                            'My mother cooking fried rice for breakfast.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "My mother" berpasangan dengan "is cooking".'
                    ],
                    [
                        'id' => 3,
                        'id_sentence' => 'Guru itu sedang menjelaskan pelajaran matematika kepada murid-muridnya.',
                        'target_word' => 'is explaining (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'teacher', 'id' => 'guru'],
                            ['en' => 'math lesson', 'id' => 'pelajaran matematika'],
                            ['en' => 'students', 'id' => 'murid-murid']
                        ],
                        'options' => [
                            'The teacher is explaining the math lesson to her students.',
                            'The teacher are explaining the math lesson to her students.',
                            'The teacher is explained the math lesson to her students.',
                            'The teacher explaining the math lesson to her students.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "The teacher" berpasangan dengan "is" + V-ing "explaining".'
                    ],
                    [
                        'id' => 4,
                        'id_sentence' => 'Anak-anak sedang bermain bola di taman dekat rumah.',
                        'target_word' => 'are playing (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'children', 'id' => 'anak-anak'],
                            ['en' => 'playing ball', 'id' => 'bermain bola'],
                            ['en' => 'park', 'id' => 'taman']
                        ],
                        'options' => [
                            'The children are playing ball at the park near the house.',
                            'The children is playing ball at the park near the house.',
                            'The children are play ball at the park near the house.',
                            'The children playing ball at the park near the house.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "The children" membutuhkan to be jamak "are" sebelum "playing".'
                    ],
                    [
                        'id' => 5,
                        'id_sentence' => 'Dokter itu sedang memeriksa seorang pasien di ruang praktiknya.',
                        'target_word' => 'is examining (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'doctor', 'id' => 'dokter'],
                            ['en' => 'patient', 'id' => 'pasien'],
                            ['en' => 'examining', 'id' => 'memeriksa']
                        ],
                        'options' => [
                            'The doctor is examining a patient in her office.',
                            'The doctor are examining a patient in her office.',
                            'The doctor is examine a patient in her office.',
                            'The doctor has examining a patient in her office.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"The doctor" adalah subjek tunggal, maka bentuk yang tepat adalah "is examining".'
                    ],
                    [
                        'id' => 6,
                        'id_sentence' => 'Teman-teman saya sedang mengerjakan tugas kelompok di perpustakaan.',
                        'target_word' => 'are doing (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'my friends', 'id' => 'teman-teman saya'],
                            ['en' => 'group assignment', 'id' => 'tugas kelompok'],
                            ['en' => 'library', 'id' => 'perpustakaan']
                        ],
                        'options' => [
                            'My friends are doing a group assignment at the library.',
                            'My friends is doing a group assignment at the library.',
                            'My friends are does a group assignment at the library.',
                            'My friends were doing a group assignment at the library.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "My friends" berpasangan dengan "are doing". Pilihan "were" salah karena merujuk masa lampau.'
                    ],
                    [
                        'id' => 7,
                        'id_sentence' => 'Pak RT sedang mengatur jadwal kerja bakti untuk warga.',
                        'target_word' => 'is arranging (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'neighborhood head', 'id' => 'pak RT'],
                            ['en' => 'community clean-up', 'id' => 'kerja bakti'],
                            ['en' => 'residents', 'id' => 'warga']
                        ],
                        'options' => [
                            'The neighborhood head is arranging the clean-up schedule for the residents.',
                            'The neighborhood head are arranging the clean-up schedule for the residents.',
                            'The neighborhood head is arrange the clean-up schedule for the residents.',
                            'The neighborhood head arranging the clean-up schedule for the residents.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "The neighborhood head" memerlukan "is" + "arranging".'
                    ],
                    [
                        'id' => 8,
                        'id_sentence' => 'Nenek sedang menanam bunga di belakang rumah.',
                        'target_word' => 'is planting (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'grandmother', 'id' => 'nenek'],
                            ['en' => 'planting flowers', 'id' => 'menanam bunga'],
                            ['en' => 'backyard', 'id' => 'belakang rumah']
                        ],
                        'options' => [
                            'Grandmother is planting flowers in the backyard.',
                            'Grandmother are planting flowers in the backyard.',
                            'Grandmother is plant flowers in the backyard.',
                            'Grandmother being planting flowers in the backyard.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "Grandmother" menggunakan "is" + V-ing "planting".'
                    ],
                    [
                        'id' => 9,
                        'id_sentence' => 'Beberapa nelayan sedang mencatat hasil tangkapan ikan hari ini.',
                        'target_word' => 'are recording (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'fishermen', 'id' => 'nelayan'],
                            ['en' => 'catch of the day', 'id' => 'hasil tangkapan'],
                            ['en' => 'recording', 'id' => 'mencatat']
                        ],
                        'options' => [
                            'Some fishermen are recording today\'s catch.',
                            'Some fishermen is recording today\'s catch.',
                            'Some fishermen are recorded today\'s catch.',
                            'Some fishermen recording today\'s catch.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Fishermen" (jamak) berpasangan dengan "are recording".'
                    ],
                    [
                        'id' => 10,
                        'id_sentence' => 'Petugas perpustakaan sedang menata buku-buku baru di rak.',
                        'target_word' => 'is arranging (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'librarian', 'id' => 'petugas perpustakaan'],
                            ['en' => 'new books', 'id' => 'buku-buku baru'],
                            ['en' => 'shelf', 'id' => 'rak']
                        ],
                        'options' => [
                            'The librarian is arranging the new books on the shelf.',
                            'The librarian are arranging the new books on the shelf.',
                            'The librarian is arrange the new books on the shelf.',
                            'The librarian arranging the new books on the shelf.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "The librarian" mengambil to be "is" + V-ing "arranging".'
                    ],
                ]
            ],

            // Sub-Lesson 1.9.2
            [
                'id' => 'continuous-trends-changes',
                'name' => '1.9.2 Menjelaskan Sesuatu yang Sedang Berubah',
                'code' => '1.9.2',
                'concept_title' => 'Menjelaskan Sesuatu yang Sedang Berubah',
                'concept_description' => 'Present Continuous juga dipakai dengan kata kerja perubahan untuk menggambarkan sesuatu yang sedang berlangsung dan belum selesai, misalnya cuaca, harga, atau pertumbuhan.',
                'description' => 'Present Continuous juga dipakai dengan kata kerja perubahan untuk menggambarkan sesuatu yang sedang berlangsung dan belum selesai, misalnya cuaca, harga, atau pertumbuhan.',
                'formula' => 'Subject + is/are + kata kerja perubahan (-ing) + Keterangan',
                'rules' => [
                    'Kata kerja perubahan yang umum: get, grow, change, improve, increase, decrease, rise, fall.',
                    'Perhatikan inti subjek untuk menentukan to be yang tepat.',
                    'Bisa dipadukan dengan kata seperti "slowly, quickly, more and more" untuk memperjelas.'
                ],
                'exercises' => [
                    [
                        'id' => 11,
                        'id_sentence' => 'Harga sayuran di pasar sedang naik akhir-akhir ini.',
                        'target_word' => 'is rising (Trend of Change)',
                        'vocab' => [
                            ['en' => 'vegetable prices', 'id' => 'harga sayuran'],
                            ['en' => 'market', 'id' => 'pasar'],
                            ['en' => 'rising', 'id' => 'naik']
                        ],
                        'options' => [
                            'Vegetable prices at the market are rising these days.',
                            'Vegetable prices at the market is rising these days.',
                            'Vegetable prices at the market are rise these days.',
                            'Vegetable prices at the market rising these days.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "prices" berbentuk jamak, sehingga memerlukan "are rising".'
                    ],
                    [
                        'id' => 12,
                        'id_sentence' => 'Adik saya sedang tumbuh semakin tinggi setiap bulan.',
                        'target_word' => 'is growing (Trend of Change)',
                        'vocab' => [
                            ['en' => 'younger sibling', 'id' => 'adik'],
                            ['en' => 'growing taller', 'id' => 'tumbuh semakin tinggi'],
                            ['en' => 'every month', 'id' => 'setiap bulan']
                        ],
                        'options' => [
                            'My younger sibling is growing taller every month.',
                            'My younger sibling are growing taller every month.',
                            'My younger sibling is grow taller every month.',
                            'My younger sibling growing taller every month.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "My younger sibling" berpasangan dengan "is growing".'
                    ],
                    [
                        'id' => 13,
                        'id_sentence' => 'Nilai bahasa Inggris Rani sedang membaik setelah ia rajin belajar.',
                        'target_word' => 'is improving (Trend of Change)',
                        'vocab' => [
                            ['en' => 'English grade', 'id' => 'nilai bahasa Inggris'],
                            ['en' => 'improving', 'id' => 'membaik'],
                            ['en' => 'studying diligently', 'id' => 'rajin belajar']
                        ],
                        'options' => [
                            'Rani\'s English grade is improving because she studies diligently.',
                            'Rani\'s English grade are improving because she studies diligently.',
                            'Rani\'s English grade is improve because she studies diligently.',
                            'Rani\'s English grade improving because she studies diligently.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Rani\'s English grade" adalah subjek tunggal, sehingga menggunakan "is improving".'
                    ],
                    [
                        'id' => 14,
                        'id_sentence' => 'Cuaca di kota kami sedang menjadi lebih dingin minggu ini.',
                        'target_word' => 'is getting (Trend of Change)',
                        'vocab' => [
                            ['en' => 'weather', 'id' => 'cuaca'],
                            ['en' => 'getting colder', 'id' => 'menjadi lebih dingin'],
                            ['en' => 'this week', 'id' => 'minggu ini']
                        ],
                        'options' => [
                            'The weather in our city is getting colder this week.',
                            'The weather in our city are getting colder this week.',
                            'The weather in our city is get colder this week.',
                            'The weather in our city getting colder this week.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"The weather" adalah subjek tunggal, maka bentuknya "is getting colder".'
                    ],
                    [
                        'id' => 15,
                        'id_sentence' => 'Jalan di depan rumah kami sedang semakin ramai setiap sore.',
                        'target_word' => 'is getting (Trend of Change)',
                        'vocab' => [
                            ['en' => 'street', 'id' => 'jalan'],
                            ['en' => 'getting busier', 'id' => 'semakin ramai'],
                            ['en' => 'every afternoon', 'id' => 'setiap sore']
                        ],
                        'options' => [
                            'The street in front of our house is getting busier every afternoon.',
                            'The street in front of our house are getting busier every afternoon.',
                            'The street in front of our house is get busier every afternoon.',
                            'The street in front of our house getting busier every afternoon.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"The street" tunggal, sehingga menggunakan "is getting busier".'
                    ],
                    [
                        'id' => 16,
                        'id_sentence' => 'Minat anak-anak terhadap sepak bola sedang meningkat di sekolah kami.',
                        'target_word' => 'is increasing (Trend of Change)',
                        'vocab' => [
                            ['en' => 'interest', 'id' => 'minat'],
                            ['en' => 'football', 'id' => 'sepak bola'],
                            ['en' => 'increasing', 'id' => 'meningkat']
                        ],
                        'options' => [
                            'Children\'s interest in football is increasing at our school.',
                            'Children\'s interest in football are increasing at our school.',
                            'Children\'s interest in football is increase at our school.',
                            'Children\'s interest in football increasing at our school.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Inti subjek adalah "interest" (tunggal), bukan "football", maka bentuknya "is increasing".'
                    ],
                    [
                        'id' => 17,
                        'id_sentence' => 'Pohon mangga di kebun kami sedang bertambah besar setiap tahun.',
                        'target_word' => 'is growing (Trend of Change)',
                        'vocab' => [
                            ['en' => 'mango tree', 'id' => 'pohon mangga'],
                            ['en' => 'garden', 'id' => 'kebun'],
                            ['en' => 'every year', 'id' => 'setiap tahun']
                        ],
                        'options' => [
                            'The mango tree in our garden is growing bigger every year.',
                            'The mango tree in our garden are growing bigger every year.',
                            'The mango tree in our garden is grow bigger every year.',
                            'The mango tree in our garden growing bigger every year.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"The mango tree" (tunggal) berpasangan dengan "is growing".'
                    ],
                    [
                        'id' => 18,
                        'id_sentence' => 'Jumlah murid di kelas kami sedang berkurang setelah liburan.',
                        'target_word' => 'is decreasing (Trend of Change)',
                        'vocab' => [
                            ['en' => 'number of students', 'id' => 'jumlah murid'],
                            ['en' => 'decreasing', 'id' => 'berkurang'],
                            ['en' => 'after the holiday', 'id' => 'setelah liburan']
                        ],
                        'options' => [
                            'The number of students in our class is decreasing after the holiday.',
                            'The number of students in our class are decreasing after the holiday.',
                            'The number of students in our class is decrease after the holiday.',
                            'The number of students in our class decreasing after the holiday.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"The number" adalah inti subjek tunggal, maka "is decreasing".'
                    ],
                    [
                        'id' => 19,
                        'id_sentence' => 'Kemampuan memasak Budi sedang berkembang setelah mengikuti kelas kuliner.',
                        'target_word' => 'is developing (Trend of Change)',
                        'vocab' => [
                            ['en' => 'cooking skills', 'id' => 'kemampuan memasak'],
                            ['en' => 'developing', 'id' => 'berkembang'],
                            ['en' => 'cooking class', 'id' => 'kelas kuliner']
                        ],
                        'options' => [
                            'Budi\'s cooking skills are developing after joining a cooking class.',
                            'Budi\'s cooking skills is developing after joining a cooking class.',
                            'Budi\'s cooking skills are develop after joining a cooking class.',
                            'Budi\'s cooking skills developing after joining a cooking class.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Skills" berbentuk jamak, sehingga "are developing".'
                    ],
                    [
                        'id' => 20,
                        'id_sentence' => 'Lalu lintas di sekitar sekolah sedang berkurang sejak ada jalur sepeda baru.',
                        'target_word' => 'is decreasing (Trend of Change)',
                        'vocab' => [
                            ['en' => 'traffic', 'id' => 'lalu lintas'],
                            ['en' => 'decreasing', 'id' => 'berkurang'],
                            ['en' => 'new bike lane', 'id' => 'jalur sepeda baru']
                        ],
                        'options' => [
                            'Traffic around the school is decreasing since the new bike lane opened.',
                            'Traffic around the school are decreasing since the new bike lane opened.',
                            'Traffic around the school is decrease since the new bike lane opened.',
                            'Traffic around the school decreasing since the new bike lane opened.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Traffic" adalah kata benda tak terhitung tunggal, sehingga "is decreasing".'
                    ],
                ]
            ],

            // Sub-Lesson 1.9.3
            [
                'id' => 'present-continuous-passive',
                'name' => '1.9.3 Present Continuous Passive: Sesuatu yang Sedang Dikerjakan',
                'code' => '1.9.3',
                'concept_title' => 'Present Continuous Passive: Sesuatu yang Sedang Dikerjakan',
                'concept_description' => 'Bentuk pasif continuous dipakai saat fokus kalimat adalah benda yang sedang dikerjakan atau diurus, tanpa perlu menyebut siapa pelakunya. Kata "being" wajib ada di antara to be dan V3.',
                'description' => 'Bentuk pasif continuous dipakai saat fokus kalimat adalah benda yang sedang dikerjakan atau diurus, tanpa perlu menyebut siapa pelakunya. Kata "being" wajib ada di antara to be dan V3.',
                'formula' => 'Subject (penerima) + am/is/are + being + Verb 3 (Past Participle) + (by Pelaku)',
                'rules' => [
                    'Rumus wajib: to be (am/is/are) + being + Past Participle (V3).',
                    'Jangan tertukar dengan Present Perfect Passive (have/has been + V3); continuous pasif selalu memakai "being", bukan "been".',
                    'Subjek jamak memakai "are being + V3", subjek tunggal memakai "is being + V3".'
                ],
                'exercises' => [
                    [
                        'id' => 21,
                        'id_sentence' => 'Makan malam sedang dimasak di dapur sekarang.',
                        'target_word' => 'is being cooked (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'dinner', 'id' => 'makan malam'],
                            ['en' => 'cooked', 'id' => 'dimasak'],
                            ['en' => 'kitchen', 'id' => 'dapur']
                        ],
                        'options' => [
                            'Dinner is being cooked in the kitchen right now.',
                            'Dinner is cooking in the kitchen right now.',
                            'Dinner are being cooked in the kitchen right now.',
                            'Dinner is been cooked in the kitchen right now.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek pasif tunggal "Dinner" membutuhkan "is" + "being" + V3 "cooked". Bentuk "been" hanya untuk perfect tense.'
                    ],
                    [
                        'id' => 22,
                        'id_sentence' => 'Mobil ayah sedang dicuci oleh tukang cuci mobil langganan.',
                        'target_word' => 'is being washed (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'father\'s car', 'id' => 'mobil ayah'],
                            ['en' => 'washed', 'id' => 'dicuci'],
                            ['en' => 'regular car washer', 'id' => 'tukang cuci mobil langganan']
                        ],
                        'options' => [
                            'Father\'s car is being washed by the regular car washer.',
                            'Father\'s car are being washed by the regular car washer.',
                            'Father\'s car is washing by the regular car washer.',
                            'Father\'s car is been washed by the regular car washer.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "Father\'s car" memerlukan "is being washed".'
                    ],
                    [
                        'id' => 23,
                        'id_sentence' => 'Kue ulang tahun sedang dihias oleh kakak di dapur.',
                        'target_word' => 'is being decorated (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'birthday cake', 'id' => 'kue ulang tahun'],
                            ['en' => 'decorated', 'id' => 'dihias'],
                            ['en' => 'kitchen', 'id' => 'dapur']
                        ],
                        'options' => [
                            'The birthday cake is being decorated by my sister in the kitchen.',
                            'The birthday cake are being decorate by my sister in the kitchen.',
                            'The birthday cake is decorating by my sister in the kitchen.',
                            'The birthday cake being decorated by my sister in the kitchen.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "The birthday cake" membutuhkan "is being decorated".'
                    ],
                    [
                        'id' => 24,
                        'id_sentence' => 'Sepeda yang rusak sedang diperbaiki di bengkel dekat rumah.',
                        'target_word' => 'is being repaired (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'broken bicycle', 'id' => 'sepeda yang rusak'],
                            ['en' => 'repaired', 'id' => 'diperbaiki'],
                            ['en' => 'repair shop', 'id' => 'bengkel']
                        ],
                        'options' => [
                            'The broken bicycle is being repaired at the shop near the house.',
                            'The broken bicycle are being repaired at the shop near the house.',
                            'The broken bicycle is repairing at the shop near the house.',
                            'The broken bicycle has being repaired at the shop near the house.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "bicycle" adalah tunggal dan menerima tindakan, sehingga memerlukan "is being repaired".'
                    ],
                    [
                        'id' => 25,
                        'id_sentence' => 'Ruang tamu sedang dibersihkan sebelum tamu datang.',
                        'target_word' => 'is being cleaned (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'living room', 'id' => 'ruang tamu'],
                            ['en' => 'cleaned', 'id' => 'dibersihkan'],
                            ['en' => 'guests', 'id' => 'tamu']
                        ],
                        'options' => [
                            'The living room is being cleaned before the guests arrive.',
                            'The living room are being cleaned before the guests arrive.',
                            'The living room is cleaning before the guests arrive.',
                            'The living room being cleaned before the guests arrive.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"The living room" tunggal, sehingga rumusnya adalah "is being cleaned".'
                    ],
                    [
                        'id' => 26,
                        'id_sentence' => 'Pekerjaan rumah matematika sedang diperiksa oleh guru kelas.',
                        'target_word' => 'is being checked (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'math homework', 'id' => 'pekerjaan rumah matematika'],
                            ['en' => 'checked', 'id' => 'diperiksa'],
                            ['en' => 'classroom teacher', 'id' => 'guru kelas']
                        ],
                        'options' => [
                            'The math homework is being checked by the classroom teacher.',
                            'The math homework are being checked by the classroom teacher.',
                            'The math homework is checking by the classroom teacher.',
                            'The math homework has been check by the classroom teacher.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "The math homework" berpasangan dengan "is being checked".'
                    ],
                    [
                        'id' => 27,
                        'id_sentence' => 'Tanaman di balkon sedang disiram oleh Bibi setiap pagi.',
                        'target_word' => 'are being watered (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'plants', 'id' => 'tanaman'],
                            ['en' => 'balcony', 'id' => 'balkon'],
                            ['en' => 'watered', 'id' => 'disiram']
                        ],
                        'options' => [
                            'The plants on the balcony are being watered by Aunt every morning.',
                            'The plants on the balcony is being watered by Aunt every morning.',
                            'The plants on the balcony are watering by Aunt every morning.',
                            'The plants on the balcony being watered by Aunt every morning.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "plants" (jamak) dipadukan dengan pola pasif continuous "are being watered".'
                    ],
                    [
                        'id' => 28,
                        'id_sentence' => 'Masalah pada komputer sekolah sedang diselidiki oleh teknisi.',
                        'target_word' => 'is being checked (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'problem', 'id' => 'masalah'],
                            ['en' => 'school computer', 'id' => 'komputer sekolah'],
                            ['en' => 'technician', 'id' => 'teknisi']
                        ],
                        'options' => [
                            'The problem with the school computer is being checked by the technician.',
                            'The problem with the school computer are being checked by the technician.',
                            'The problem with the school computer is checking by the technician.',
                            'The problem with the school computer being checked by the technician.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek utama "The problem" adalah tunggal, sehingga memerlukan "is being checked".'
                    ],
                    [
                        'id' => 29,
                        'id_sentence' => 'Buku cerita baru sedang dibaca keras-keras oleh guru untuk murid kelas satu.',
                        'target_word' => 'is being read (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'new storybook', 'id' => 'buku cerita baru'],
                            ['en' => 'read aloud', 'id' => 'dibaca keras-keras'],
                            ['en' => 'first-grade students', 'id' => 'murid kelas satu']
                        ],
                        'options' => [
                            'The new storybook is being read aloud to the first-grade students.',
                            'The new storybook are being read aloud to the first-grade students.',
                            'The new storybook is reading aloud to the first-grade students.',
                            'The new storybook being read aloud to the first-grade students.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "storybook" (tunggal) membutuhkan "is being read".'
                    ],
                    [
                        'id' => 30,
                        'id_sentence' => 'Jendela kamar sedang diperbaiki karena engselnya patah.',
                        'target_word' => 'is being fixed (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'bedroom window', 'id' => 'jendela kamar'],
                            ['en' => 'fixed', 'id' => 'diperbaiki'],
                            ['en' => 'broken hinge', 'id' => 'engsel yang patah']
                        ],
                        'options' => [
                            'The bedroom window is being fixed because the hinge is broken.',
                            'The bedroom window are being fixed because the hinge is broken.',
                            'The bedroom window is fixing because the hinge is broken.',
                            'The bedroom window has being fixed because the hinge is broken.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "window" (tunggal) membutuhkan "is being fixed".'
                    ],
                ]
            ],

            // Sub-Lesson 1.9.4
            [
                'id' => 'temporary-vs-permanent',
                'name' => '1.9.4 Kebiasaan Rutin vs Kejadian Sementara',
                'code' => '1.9.4',
                'concept_title' => 'Kebiasaan Rutin vs Kejadian Sementara (Continuous vs Simple Present)',
                'concept_description' => 'Membedakan kebiasaan sehari-hari (Simple Present) dengan hal yang hanya terjadi sekarang/hari ini saja (Present Continuous).',
                'description' => 'Membedakan kebiasaan sehari-hari (Simple Present) dengan hal yang hanya terjadi sekarang/hari ini saja (Present Continuous).',
                'formula' => 'Rutin: S + V1/V-s | Sementara: S + is/are + V-ing',
                'rules' => [
                    'Gunakan Simple Present untuk kebiasaan rutin (usually, every day, every week).',
                    'Gunakan Present Continuous untuk kejadian khusus sekarang (today, right now, this week).',
                    'Penanda waktu transisional: currently, at the moment, for now, this time.'
                ],
                'exercises' => [
                    [
                        'id' => 31,
                        'id_sentence' => 'Ayah biasanya berangkat kerja naik motor, tetapi hari ini ia sedang menyetir mobil.',
                        'target_word' => 'usually rides ... is driving (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'father', 'id' => 'ayah'],
                            ['en' => 'usually rides a motorbike', 'id' => 'biasanya naik motor'],
                            ['en' => 'driving a car', 'id' => 'menyetir mobil']
                        ],
                        'options' => [
                            'Father usually rides a motorbike to work, but today he is driving a car.',
                            'Father is usually riding a motorbike to work, but today he drives a car.',
                            'Father usually ride a motorbike to work, but today he is driving a car.',
                            'Father usually rides a motorbike to work, but today he driving a car.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kebiasaan rutin memakai Simple Present ("usually rides"), sedangkan kejadian khusus hari ini memakai Present Continuous ("is driving").'
                    ],
                    [
                        'id' => 32,
                        'id_sentence' => 'Guru itu biasanya mengajar dua kelas setiap hari, tetapi minggu ini ia sedang membimbing lomba sains.',
                        'target_word' => 'teaches ... is coaching (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'teacher', 'id' => 'guru'],
                            ['en' => 'two classes', 'id' => 'dua kelas'],
                            ['en' => 'science competition', 'id' => 'lomba sains']
                        ],
                        'options' => [
                            'The teacher teaches two classes every day, but this week she is coaching a science competition.',
                            'The teacher is teaching two classes every day, but this week she coaches a science competition.',
                            'The teacher teach two classes every day, but this week she is coaching a science competition.',
                            'The teacher teaches two classes every day, but this week she coaching a science competition.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kebiasaan harian ("every day") memakai "teaches", sedangkan kegiatan khusus minggu ini ("this week") memakai "is coaching".'
                    ],
                    [
                        'id' => 33,
                        'id_sentence' => 'Sungai itu biasanya mengalir dengan tenang, tapi sekarang sedang meluap karena hujan deras.',
                        'target_word' => 'flows ... is overflowing (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'flows calmly', 'id' => 'mengalir dengan tenang'],
                            ['en' => 'overflowing', 'id' => 'meluap'],
                            ['en' => 'heavy rain', 'id' => 'hujan deras']
                        ],
                        'options' => [
                            'The river usually flows calmly, but now it is overflowing because of heavy rain.',
                            'The river is usually flowing calmly, but now it overflows because of heavy rain.',
                            'The river usually flow calmly, but now it is overflowing because of heavy rain.',
                            'The river usually flows calmly, but now it overflowing because of heavy rain.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Keadaan biasa dinyatakan dengan "usually flows", sedangkan keadaan sesaat memakai "is overflowing".'
                    ],
                    [
                        'id' => 34,
                        'id_sentence' => 'Toko itu biasanya menjual roti dan kue, tapi minggu ini mereka sedang menjual pernak-pernik lebaran.',
                        'target_word' => 'sells ... is selling (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'shop', 'id' => 'toko'],
                            ['en' => 'bread and cakes', 'id' => 'roti dan kue'],
                            ['en' => 'Eid decorations', 'id' => 'pernak-pernik lebaran']
                        ],
                        'options' => [
                            'The shop usually sells bread and cakes, but this week it is selling Eid decorations.',
                            'The shop is usually selling bread and cakes, but this week it sells Eid decorations.',
                            'The shop usually sell bread and cakes, but this week it is selling Eid decorations.',
                            'The shop usually sells bread and cakes, but this week it selling Eid decorations.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Rutinitas toko ("usually sells") dikontraskan dengan penjualan khusus minggu ini ("is selling").'
                    ],
                    [
                        'id' => 35,
                        'id_sentence' => 'Perpustakaan sekolah biasanya tutup pukul empat sore, tapi hari ini mereka sedang buka sampai malam untuk ujian.',
                        'target_word' => 'closes ... is staying (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'school library', 'id' => 'perpustakaan sekolah'],
                            ['en' => 'closes', 'id' => 'tutup'],
                            ['en' => 'staying open', 'id' => 'tetap buka']
                        ],
                        'options' => [
                            'The school library usually closes at four, but today it is staying open until night for exams.',
                            'The school library is usually closing at four, but today it stays open until night for exams.',
                            'The school library usually close at four, but today it is staying open until night for exams.',
                            'The school library usually closes at four, but today it staying open until night for exams.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Jadwal rutin ("usually closes") memakai Simple Present, sedangkan penyesuaian khusus hari ini ("today") memakai "is staying".'
                    ],
                    [
                        'id' => 36,
                        'id_sentence' => 'Kebanyakan anak di kelas kami biasanya membawa bekal, tetapi hari ini mereka sedang mencoba kantin baru.',
                        'target_word' => 'bring ... are trying (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'most children', 'id' => 'kebanyakan anak'],
                            ['en' => 'bring lunch boxes', 'id' => 'membawa bekal'],
                            ['en' => 'new canteen', 'id' => 'kantin baru']
                        ],
                        'options' => [
                            'Most children in our class usually bring lunch boxes, but today they are trying the new canteen.',
                            'Most children in our class are usually bringing lunch boxes, but today they try the new canteen.',
                            'Most children in our class usually brings lunch boxes, but today they are trying the new canteen.',
                            'Most children in our class usually bring lunch boxes, but today they trying the new canteen.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kebiasaan umum memakai Simple Present "bring", sedangkan percobaan khusus hari ini memakai Present Continuous "are trying".'
                    ],
                    [
                        'id' => 37,
                        'id_sentence' => 'Kipas angin di ruang kelas biasanya bekerja otomatis, tetapi sekarang penjaga sekolah sedang menyalakannya secara manual.',
                        'target_word' => 'works ... is turning (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'classroom fan', 'id' => 'kipas angin kelas'],
                            ['en' => 'works automatically', 'id' => 'bekerja otomatis'],
                            ['en' => 'school caretaker', 'id' => 'penjaga sekolah']
                        ],
                        'options' => [
                            'The classroom fan usually works automatically, but now the caretaker is turning it on manually.',
                            'The classroom fan is usually working automatically, but now the caretaker turns it on manually.',
                            'The classroom fan usually work automatically, but now the caretaker is turning it on manually.',
                            'The classroom fan usually works automatically, but now the caretaker turning it on manually.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Usually works" menunjukkan cara kerja biasa, sedangkan "is turning" mendeskripsikan tindakan manual sekarang.'
                    ],
                    [
                        'id' => 38,
                        'id_sentence' => 'Burung-burung itu biasanya bersarang di pohon besar, tetapi musim ini mereka sedang singgah di taman kami.',
                        'target_word' => 'nest ... are staying (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'birds', 'id' => 'burung-burung'],
                            ['en' => 'nest', 'id' => 'bersarang'],
                            ['en' => 'our garden', 'id' => 'taman kami']
                        ],
                        'options' => [
                            'The birds usually nest in the big tree, but this season they are staying in our garden.',
                            'The birds are usually nesting in the big tree, but this season they stay in our garden.',
                            'The birds usually nests in the big tree, but this season they are staying in our garden.',
                            'The birds usually nest in the big tree, but this season they staying in our garden.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kebiasaan musiman memakai "nest", sedangkan persinggahan sementara memakai "are staying".'
                    ],
                    [
                        'id' => 39,
                        'id_sentence' => 'Warung itu biasanya menyediakan menu lokal saja, tetapi saat ini mereka sedang mencoba menu baru dari luar daerah.',
                        'target_word' => 'offers ... is trying (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'food stall', 'id' => 'warung'],
                            ['en' => 'local menu', 'id' => 'menu lokal'],
                            ['en' => 'new menu', 'id' => 'menu baru']
                        ],
                        'options' => [
                            'The food stall usually offers only local dishes, but it is currently trying a new menu from out of town.',
                            'The food stall is usually offering only local dishes, but it currently tries a new menu from out of town.',
                            'The food stall usually offer only local dishes, but it is currently trying a new menu from out of town.',
                            'The food stall usually offers only local dishes, but it currently trying a new menu from out of town.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Usually offers" (kebiasaan) dikontraskan dengan "is currently trying" (percobaan sementara).'
                    ],
                    [
                        'id' => 40,
                        'id_sentence' => 'Jadwal les renang biasanya berlangsung dua jam, tapi pelatih sedang memperbarui jadwal untuk bulan depan.',
                        'target_word' => 'lasts ... is updating (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'swimming lesson schedule', 'id' => 'jadwal les renang'],
                            ['en' => 'lasts', 'id' => 'berlangsung'],
                            ['en' => 'coach', 'id' => 'pelatih']
                        ],
                        'options' => [
                            'The swimming lesson schedule usually lasts two hours, but the coach is updating it for next month.',
                            'The swimming lesson schedule is usually lasting two hours, but the coach updates it for next month.',
                            'The swimming lesson schedule usually last two hours, but the coach is updating it for next month.',
                            'The swimming lesson schedule usually lasts two hours, but the coach updating it for next month.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Jadwal rutin memakai Simple Present "lasts", sementara proses pembaruan saat ini memakai "is updating".'
                    ],
                ]
            ],

            // Sub-Lesson 1.9.5
            [
                'id' => 'stative-verbs-exception',
                'name' => '1.9.5 Kata Kerja yang Tidak Boleh Memakai Bentuk -ing',
                'code' => '1.9.5',
                'concept_title' => 'Kata Kerja yang Tidak Boleh Memakai Bentuk -ing (Stative Verbs)',
                'concept_description' => 'Stative verbs adalah kata kerja yang menyatakan perasaan, pikiran, kepemilikan, atau isi. Kata kerja ini TIDAK boleh memakai bentuk -ing meskipun artinya tentang sekarang, karena bukan tindakan fisik yang sedang berlangsung.',
                'description' => 'Stative verbs adalah kata kerja yang menyatakan perasaan, pikiran, kepemilikan, atau isi. Kata kerja ini TIDAK boleh memakai bentuk -ing meskipun artinya tentang sekarang, karena bukan tindakan fisik yang sedang berlangsung.',
                'formula' => 'Subject + Stative Verb (bentuk Simple Present) + Objek/Pelengkap',
                'rules' => [
                    'Kata kerja pikiran/pendapat: understand, believe, know, doubt (Salah: *is understanding, *are believing).',
                    'Kata kerja kepemilikan/isi: have, contain, belong, need, lack (Salah: *is containing, *is needing).',
                    'Beberapa kata seperti "think" bisa memakai -ing jika artinya "sedang memikirkan/menimbang", bukan "berpendapat".'
                ],
                'exercises' => [
                    [
                        'id' => 41,
                        'id_sentence' => 'Saya mengerti penjelasan guru tentang pecahan sekarang.',
                        'target_word' => 'understand (Stative Verb: Cognition)',
                        'vocab' => [
                            ['en' => 'understand', 'id' => 'mengerti'],
                            ['en' => 'teacher\'s explanation', 'id' => 'penjelasan guru'],
                            ['en' => 'fractions', 'id' => 'pecahan']
                        ],
                        'options' => [
                            'I understand the teacher\'s explanation about fractions now.',
                            'I am understanding the teacher\'s explanation about fractions now.',
                            'I understands the teacher\'s explanation about fractions now.',
                            'I am understand the teacher\'s explanation about fractions now.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Understand" adalah kata kerja pikiran dan tidak memakai bentuk -ing.'
                    ],
                    [
                        'id' => 42,
                        'id_sentence' => 'Kotak ini berisi mainan lama milik kakak saya.',
                        'target_word' => 'contains (Stative Verb: Content)',
                        'vocab' => [
                            ['en' => 'box', 'id' => 'kotak'],
                            ['en' => 'contains', 'id' => 'berisi'],
                            ['en' => 'old toys', 'id' => 'mainan lama']
                        ],
                        'options' => [
                            'This box contains my older sibling\'s old toys.',
                            'This box is containing my older sibling\'s old toys.',
                            'This box contain my older sibling\'s old toys.',
                            'This box is contained my older sibling\'s old toys.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Contain" adalah stative verb yang menyatakan isi; bentuk "is containing" salah.'
                    ],
                    [
                        'id' => 43,
                        'id_sentence' => 'Kami membutuhkan lebih banyak waktu untuk menyelesaikan proyek ini.',
                        'target_word' => 'need (Stative Verb: Need)',
                        'vocab' => [
                            ['en' => 'need', 'id' => 'membutuhkan'],
                            ['en' => 'more time', 'id' => 'lebih banyak waktu'],
                            ['en' => 'finish the project', 'id' => 'menyelesaikan proyek']
                        ],
                        'options' => [
                            'We need more time to finish this project.',
                            'We are needing more time to finish this project.',
                            'We needs more time to finish this project.',
                            'We are need more time to finish this project.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Need" adalah stative verb yang tidak berbentuk continuous (*are needing).'
                    ],
                    [
                        'id' => 44,
                        'id_sentence' => 'Rencana piknik itu kelihatannya bagus, tetapi kami sedang mempertimbangkan apakah cuaca akan mendukung.',
                        'target_word' => 'seems ... are considering (Stative vs Dynamic Meaning)',
                        'vocab' => [
                            ['en' => 'picnic plan', 'id' => 'rencana piknik'],
                            ['en' => 'seems good', 'id' => 'kelihatannya bagus'],
                            ['en' => 'considering', 'id' => 'mempertimbangkan']
                        ],
                        'options' => [
                            'The picnic plan seems good, but we are considering whether the weather will cooperate.',
                            'The picnic plan is seeming good, but we consider whether the weather will cooperate.',
                            'The picnic plan seems good, but we consider currently whether the weather will cooperate.',
                            'The picnic plan is seeming good, but we are considering whether the weather will cooperate.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Seem" adalah stative verb murni (tidak boleh *is seeming), sedangkan "consider" dalam arti sedang menimbang boleh memakai continuous ("are considering").'
                    ],
                    [
                        'id' => 45,
                        'id_sentence' => 'Keluarga itu belum memiliki kulkas baru sejak yang lama rusak.',
                        'target_word' => 'does not have (Stative Verb: Possession)',
                        'vocab' => [
                            ['en' => 'family', 'id' => 'keluarga'],
                            ['en' => 'does not have', 'id' => 'belum memiliki'],
                            ['en' => 'new refrigerator', 'id' => 'kulkas baru']
                        ],
                        'options' => [
                            'The family does not have a new refrigerator since the old one broke.',
                            'The family is not having a new refrigerator since the old one broke.',
                            'The family do not have a new refrigerator since the old one broke.',
                            'The family are not having a new refrigerator since the old one broke.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Have" yang bermakna memiliki adalah stative verb ("does not have", bukan *is not having).'
                    ],
                    [
                        'id' => 46,
                        'id_sentence' => 'Sepupu saya memiliki sepeda baru berwarna biru.',
                        'target_word' => 'has (Stative Verb: Possession)',
                        'vocab' => [
                            ['en' => 'cousin', 'id' => 'sepupu'],
                            ['en' => 'has', 'id' => 'memiliki'],
                            ['en' => 'blue bicycle', 'id' => 'sepeda biru']
                        ],
                        'options' => [
                            'My cousin has a new blue bicycle.',
                            'My cousin is having a new blue bicycle.',
                            'My cousin have a new blue bicycle.',
                            'My cousin is have a new blue bicycle.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Have" bermakna memiliki adalah stative verb, memakai bentuk Simple Present "has", bukan *is having.'
                    ],
                    [
                        'id' => 47,
                        'id_sentence' => 'Resep kue ini terdiri dari lima bahan sederhana.',
                        'target_word' => 'consists of (Stative Verb: Composition)',
                        'vocab' => [
                            ['en' => 'cake recipe', 'id' => 'resep kue'],
                            ['en' => 'consists of', 'id' => 'terdiri dari'],
                            ['en' => 'simple ingredients', 'id' => 'bahan sederhana']
                        ],
                        'options' => [
                            'This cake recipe consists of five simple ingredients.',
                            'This cake recipe is consisting of five simple ingredients.',
                            'This cake recipe consist of five simple ingredients.',
                            'This cake recipe is consisted of five simple ingredients.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Frasa "consist of" selalu stative (*is consisting of dan *is consisted of adalah kesalahan).'
                    ],
                    [
                        'id' => 48,
                        'id_sentence' => 'Kakak percaya bahwa adik bisa memenangkan lomba menggambar itu.',
                        'target_word' => 'believes (Stative Verb: Belief)',
                        'vocab' => [
                            ['en' => 'older sibling', 'id' => 'kakak'],
                            ['en' => 'believes', 'id' => 'percaya'],
                            ['en' => 'drawing competition', 'id' => 'lomba menggambar']
                        ],
                        'options' => [
                            'My older sibling believes that my younger sibling can win the drawing competition.',
                            'My older sibling is believing that my younger sibling can win the drawing competition.',
                            'My older sibling believe that my younger sibling can win the drawing competition.',
                            'My older sibling are believing that my younger sibling can win the drawing competition.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Believe" adalah stative verb dan tidak berbentuk continuous (*is believing).'
                    ],
                    [
                        'id' => 49,
                        'id_sentence' => 'Buku itu memiliki sampul berwarna merah cerah.',
                        'target_word' => 'has (Stative Verb: Attribute)',
                        'vocab' => [
                            ['en' => 'book', 'id' => 'buku'],
                            ['en' => 'has', 'id' => 'memiliki'],
                            ['en' => 'bright red cover', 'id' => 'sampul merah cerah']
                        ],
                        'options' => [
                            'The book has a bright red cover.',
                            'The book is having a bright red cover.',
                            'The book have a bright red cover.',
                            'The book is have a bright red cover.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Have" bermakna ciri fisik adalah stative verb ("has", bukan *is having).'
                    ],
                    [
                        'id' => 50,
                        'id_sentence' => 'Saya ragu apakah hujan akan berhenti sebelum sore.',
                        'target_word' => 'doubt (Stative Verb: Mental State)',
                        'vocab' => [
                            ['en' => 'doubt', 'id' => 'ragu'],
                            ['en' => 'stop', 'id' => 'berhenti'],
                            ['en' => 'before afternoon', 'id' => 'sebelum sore']
                        ],
                        'options' => [
                            'I doubt the rain will stop before afternoon.',
                            'I am doubting the rain will stop before afternoon.',
                            'I doubts the rain will stop before afternoon.',
                            'I am doubt the rain will stop before afternoon.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Doubt" adalah stative verb yang menyatakan keraguan, memakai bentuk Simple Present, bukan *am doubting.'
                    ],
                ]
            ],

            // Sub-Lesson 1.9.6
            [
                'id' => 'continuous-negative-interrogative',
                'name' => '1.9.6 Bentuk Negatif & Pertanyaan Present Continuous',
                'code' => '1.9.6',
                'concept_title' => 'Bentuk Negatif & Pertanyaan Present Continuous',
                'concept_description' => 'Dipakai untuk menyatakan bahwa sesuatu TIDAK sedang terjadi sekarang, atau untuk menanyakan apakah sesuatu sedang terjadi.',
                'description' => 'Dipakai untuk menyatakan bahwa sesuatu TIDAK sedang terjadi sekarang, atau untuk menanyakan apakah sesuatu sedang terjadi.',
                'formula' => 'Negatif: S + is/are + NOT + V-ing / being V3 | Tanya: Is/Are + S + V-ing?',
                'rules' => [
                    'Pada kalimat verbal negatif, sisipkan "not" tepat setelah to be (is not cooking, are not playing).',
                    'Pada kalimat pasif negatif, letakkan "not" sebelum "being" (is not being washed).',
                    'Pada kalimat tanya, pindahkan to be ke posisi paling depan sebelum subjek (Is she cooking...?).'
                ],
                'exercises' => [
                    [
                        'id' => 51,
                        'id_sentence' => 'Anak-anak belum sedang tidur meskipun sudah jam sembilan malam.',
                        'target_word' => 'are not sleeping (Negative Verbal)',
                        'vocab' => [
                            ['en' => 'children', 'id' => 'anak-anak'],
                            ['en' => 'sleeping', 'id' => 'tidur'],
                            ['en' => 'nine at night', 'id' => 'jam sembilan malam']
                        ],
                        'options' => [
                            'The children are not sleeping even though it is already nine at night.',
                            'The children does not sleeping even though it is already nine at night.',
                            'The children is not sleeping even though it is already nine at night.',
                            'The children not sleeping even though it is already nine at night.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk negatif Present Continuous dibentuk dengan meletakkan "not" setelah auxiliary: "are not sleeping".'
                    ],
                    [
                        'id' => 52,
                        'id_sentence' => 'Baju-baju itu tidak sedang dicuci hari ini karena mesin cuci rusak.',
                        'target_word' => 'are not being washed (Negative Passive)',
                        'vocab' => [
                            ['en' => 'clothes', 'id' => 'baju-baju'],
                            ['en' => 'washed', 'id' => 'dicuci'],
                            ['en' => 'washing machine', 'id' => 'mesin cuci']
                        ],
                        'options' => [
                            'The clothes are not being washed today because the washing machine is broken.',
                            'The clothes are not washing today because the washing machine is broken.',
                            'The clothes does not being washed today because the washing machine is broken.',
                            'The clothes are not been washed today because the washing machine is broken.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Pola negatif pasif continuous adalah "are not being" + V3 "washed".'
                    ],
                    [
                        'id' => 53,
                        'id_sentence' => 'Murid-murid tidak sedang mengerjakan ulangan selama jam istirahat.',
                        'target_word' => 'are not doing (Negative Verbal)',
                        'vocab' => [
                            ['en' => 'students', 'id' => 'murid-murid'],
                            ['en' => 'test', 'id' => 'ulangan'],
                            ['en' => 'break time', 'id' => 'jam istirahat']
                        ],
                        'options' => [
                            'The students are not doing a test during break time.',
                            'The students is not doing a test during break time.',
                            'The students do not doing a test during break time.',
                            'The students are not do a test during break time.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "The students" mengambil "are not doing".'
                    ],
                    [
                        'id' => 54,
                        'id_sentence' => 'Apakah Ibu sedang memasak sup ayam untuk makan malam?',
                        'target_word' => 'Is ... cooking (Interrogative Verbal)',
                        'vocab' => [
                            ['en' => 'cooking', 'id' => 'memasak'],
                            ['en' => 'chicken soup', 'id' => 'sup ayam'],
                            ['en' => 'dinner', 'id' => 'makan malam']
                        ],
                        'options' => [
                            'Is Mom cooking chicken soup for dinner?',
                            'Does Mom cooking chicken soup for dinner?',
                            'Are Mom cooking chicken soup for dinner?',
                            'Is Mom cook chicken soup for dinner?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "Mom" diawali auxiliary "Is" + V-ing "cooking".'
                    ],
                    [
                        'id' => 55,
                        'id_sentence' => 'Toko itu tidak sedang buka hari Minggu ini.',
                        'target_word' => 'is not opening (Negative Verbal)',
                        'vocab' => [
                            ['en' => 'shop', 'id' => 'toko'],
                            ['en' => 'opening', 'id' => 'buka'],
                            ['en' => 'this Sunday', 'id' => 'hari Minggu ini']
                        ],
                        'options' => [
                            'The shop is not opening this Sunday.',
                            'The shop are not opening this Sunday.',
                            'The shop does not opening this Sunday.',
                            'The shop not is opening this Sunday.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "The shop" membutuhkan "is not opening".'
                    ],
                    [
                        'id' => 56,
                        'id_sentence' => 'Mainan-mainan itu tidak sedang dipajang di toko karena sedang dibersihkan.',
                        'target_word' => 'are not being displayed (Negative Passive)',
                        'vocab' => [
                            ['en' => 'toys', 'id' => 'mainan-mainan'],
                            ['en' => 'displayed', 'id' => 'dipajang'],
                            ['en' => 'cleaned', 'id' => 'dibersihkan']
                        ],
                        'options' => [
                            'The toys are not being displayed in the shop because they are being cleaned.',
                            'The toys is not being displayed in the shop because they are being cleaned.',
                            'The toys are not displaying in the shop because they are being cleaned.',
                            'The toys do not being displayed in the shop because they are being cleaned.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "The toys" memerlukan bentuk pasif negatif: "are not being displayed".'
                    ],
                    [
                        'id' => 57,
                        'id_sentence' => 'Apakah anak-anak sedang mengganti baju untuk pergi ke sekolah?',
                        'target_word' => 'Are ... changing (Interrogative Verbal)',
                        'vocab' => [
                            ['en' => 'children', 'id' => 'anak-anak'],
                            ['en' => 'changing clothes', 'id' => 'mengganti baju'],
                            ['en' => 'school', 'id' => 'sekolah']
                        ],
                        'options' => [
                            'Are the children changing clothes to go to school?',
                            'Is the children changing clothes to go to school?',
                            'Do the children changing clothes to go to school?',
                            'Are the children change clothes to go to school?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "the children" diawali oleh auxiliary "Are" + V-ing "changing".'
                    ],
                    [
                        'id' => 58,
                        'id_sentence' => 'Hujan belum berhenti meskipun sudah sore.',
                        'target_word' => 'is not stopping (Negative Verbal)',
                        'vocab' => [
                            ['en' => 'rain', 'id' => 'hujan'],
                            ['en' => 'stopping', 'id' => 'berhenti'],
                            ['en' => 'afternoon', 'id' => 'sore']
                        ],
                        'options' => [
                            'The rain is not stopping even though it is already afternoon.',
                            'The rain are not stopping even though it is already afternoon.',
                            'The rain does not stopping even though it is already afternoon.',
                            'The rain is not stop even though it is already afternoon.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "The rain" tunggal, sehingga bentuk negatif continuous yang tepat adalah "is not stopping".'
                    ],
                    [
                        'id' => 59,
                        'id_sentence' => 'Pesan itu tidak sedang dikirim karena sinyal internet lemah.',
                        'target_word' => 'is not being sent (Negative Passive)',
                        'vocab' => [
                            ['en' => 'message', 'id' => 'pesan'],
                            ['en' => 'sent', 'id' => 'dikirim'],
                            ['en' => 'weak internet signal', 'id' => 'sinyal internet lemah']
                        ],
                        'options' => [
                            'The message is not being sent because the internet signal is weak.',
                            'The message are not being sent because the internet signal is weak.',
                            'The message is not sending because the internet signal is weak.',
                            'The message does not being sent because the internet signal is weak.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "message" dalam bentuk pasif negatif continuous membutuhkan "is not being sent".'
                    ],
                    [
                        'id' => 60,
                        'id_sentence' => 'Apakah latihan menari yang baru menunjukkan hasil yang bagus untuk tim sekolah?',
                        'target_word' => 'Is ... showing (Interrogative Verbal)',
                        'vocab' => [
                            ['en' => 'new dance practice', 'id' => 'latihan menari yang baru'],
                            ['en' => 'good results', 'id' => 'hasil yang bagus'],
                            ['en' => 'school team', 'id' => 'tim sekolah']
                        ],
                        'options' => [
                            'Is the new dance practice showing good results for the school team?',
                            'Does the new dance practice showing good results for the school team?',
                            'Are the new dance practice showing good results for the school team?',
                            'Is the new dance practice show good results for the school team?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "the new dance practice" diawali to be "Is" + V-ing "showing".'
                    ],
                ]
            ],

            // Sub-Lesson 1.9.7
            [
                'id' => 'time-adverbs-continuous',
                'name' => '1.9.7 Kata Keterangan Waktu Bersama Continuous Tense',
                'code' => '1.9.7',
                'concept_title' => 'Kata Keterangan Waktu Bersama Continuous Tense',
                'concept_description' => 'Memperkaya kalimat continuous dengan kata keterangan waktu seperti right now, at the moment, today, currently, untuk memperjelas bahwa sesuatu sedang terjadi saat ini.',
                'description' => 'Memperkaya kalimat continuous dengan kata keterangan waktu seperti right now, at the moment, today, currently, untuk memperjelas bahwa sesuatu sedang terjadi saat ini.',
                'formula' => 'Keterangan Waktu + Koma + Subject + is/are + V-ing',
                'rules' => [
                    'Kata keterangan waktu sering disisipkan di antara to be dan kata kerja utama (misalnya: "is currently reading").',
                    'Kata keterangan waktu juga bisa diletakkan di depan kalimat, diikuti tanda koma ("Right now, she is...").',
                    'Pastikan kata keterangan waktu sesuai dengan maksud "sedang terjadi sekarang" (right now, at the moment, today).'
                ],
                'exercises' => [
                    [
                        'id' => 61,
                        'id_sentence' => 'Sekarang, Ayah sedang memperbaiki sepeda di garasi.',
                        'target_word' => 'Right now, ... is fixing (Adverbial Placement)',
                        'vocab' => [
                            ['en' => 'right now', 'id' => 'sekarang'],
                            ['en' => 'fixing', 'id' => 'memperbaiki'],
                            ['en' => 'garage', 'id' => 'garasi']
                        ],
                        'options' => [
                            'Right now, Dad is fixing the bicycle in the garage.',
                            'Right now, Dad is fixing the bicycle in the garage is.',
                            'Right now, Dad are fixing the bicycle in the garage.',
                            'Right now, Dad fixing the bicycle in the garage.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Right now" di awal kalimat dipadukan dengan klausa Present Continuous tunggal "Dad is fixing".'
                    ],
                    [
                        'id' => 62,
                        'id_sentence' => 'Saat ini, murid-murid sedang berlatih menyanyi untuk pentas seni.',
                        'target_word' => 'At the moment, ... are practicing (Adverbial Phrase)',
                        'vocab' => [
                            ['en' => 'at the moment', 'id' => 'saat ini'],
                            ['en' => 'practicing singing', 'id' => 'berlatih menyanyi'],
                            ['en' => 'art performance', 'id' => 'pentas seni']
                        ],
                        'options' => [
                            'At the moment, the students are practicing singing for the art performance.',
                            'At the moment, the students is practicing singing for the art performance.',
                            'At the moment, the students are practice singing for the art performance.',
                            'At the moment, the students practicing singing for the art performance.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Frasa "At the moment" mengawali kalimat, diikuti subjek jamak "the students are practicing".'
                    ],
                    [
                        'id' => 63,
                        'id_sentence' => 'Hari ini, kami sedang membersihkan seluruh rumah untuk menyambut tamu.',
                        'target_word' => 'Today, ... are cleaning (Adverbial Placement)',
                        'vocab' => [
                            ['en' => 'today', 'id' => 'hari ini'],
                            ['en' => 'cleaning', 'id' => 'membersihkan'],
                            ['en' => 'welcoming guests', 'id' => 'menyambut tamu']
                        ],
                        'options' => [
                            'Today, we are cleaning the whole house to welcome guests.',
                            'Today, we is cleaning the whole house to welcome guests.',
                            'Today, we are clean the whole house to welcome guests.',
                            'Today, we cleaning the whole house to welcome guests.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Today" di awal kalimat diikuti subjek jamak "we are cleaning".'
                    ],
                    [
                        'id' => 64,
                        'id_sentence' => 'Sekarang ini, harga buah-buahan sedang turun di pasar tradisional.',
                        'target_word' => 'These days, ... is dropping (Adverbial Placement)',
                        'vocab' => [
                            ['en' => 'these days', 'id' => 'sekarang ini'],
                            ['en' => 'dropping', 'id' => 'turun'],
                            ['en' => 'traditional market', 'id' => 'pasar tradisional']
                        ],
                        'options' => [
                            'These days, the price of fruit is dropping at the traditional market.',
                            'These days, the price of fruit are dropping at the traditional market.',
                            'These days, the price of fruit is drop at the traditional market.',
                            'These days, the price of fruit dropping at the traditional market.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Inti subjek "the price" (tunggal) berpasangan dengan "is dropping".'
                    ],
                    [
                        'id' => 65,
                        'id_sentence' => 'Pak Guru saat ini sedang menandai hasil ulangan di ruang guru.',
                        'target_word' => 'is currently marking (Adverbial Between Auxiliary & Verb)',
                        'vocab' => [
                            ['en' => 'currently', 'id' => 'saat ini'],
                            ['en' => 'marking', 'id' => 'menandai'],
                            ['en' => 'teachers\' room', 'id' => 'ruang guru']
                        ],
                        'options' => [
                            'The teacher is currently marking the test results in the teachers\' room.',
                            'The teacher currently is marking the test results in the teachers\' room.',
                            'The teacher is currently mark the test results in the teachers\' room.',
                            'The teacher currently marking the test results in the teachers\' room.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata keterangan "currently" diletakkan di antara to be "is" dan kata kerja utama "marking".'
                    ],
                    [
                        'id' => 66,
                        'id_sentence' => 'Pada waktu seperti ini, keluarga-keluarga biasanya sedang berkumpul untuk makan malam.',
                        'target_word' => 'At this time, ... are gathering (Adverbial Phrase)',
                        'vocab' => [
                            ['en' => 'at this time', 'id' => 'pada waktu seperti ini'],
                            ['en' => 'gathering', 'id' => 'berkumpul'],
                            ['en' => 'dinner', 'id' => 'makan malam']
                        ],
                        'options' => [
                            'At this time, families are usually gathering for dinner.',
                            'At this time, families is usually gathering for dinner.',
                            'At this time, families are usually gather for dinner.',
                            'At this time, families usually gathering for dinner.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Frasa "At this time" mengawali kalimat, diikuti subjek jamak "families are gathering".'
                    ],
                    [
                        'id' => 67,
                        'id_sentence' => 'Tetangga kami sekarang sedang mengecat pagar rumahnya warna hijau.',
                        'target_word' => 'is now painting (Adverbial Between Auxiliary & Verb)',
                        'vocab' => [
                            ['en' => 'now', 'id' => 'sekarang'],
                            ['en' => 'painting', 'id' => 'mengecat'],
                            ['en' => 'fence', 'id' => 'pagar']
                        ],
                        'options' => [
                            'Our neighbor is now painting their fence green.',
                            'Our neighbor now is painting their fence green.',
                            'Our neighbor is now paint their fence green.',
                            'Our neighbor now painting their fence green.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata "now" diletakkan setelah to be "is", sebelum kata kerja utama "painting".'
                    ],
                    [
                        'id' => 68,
                        'id_sentence' => 'Minggu ini, para pedagang sedang menjual lebih banyak payung karena musim hujan.',
                        'target_word' => 'This week, ... are selling (Adverbial Placement)',
                        'vocab' => [
                            ['en' => 'this week', 'id' => 'minggu ini'],
                            ['en' => 'selling', 'id' => 'menjual'],
                            ['en' => 'rainy season', 'id' => 'musim hujan']
                        ],
                        'options' => [
                            'This week, the vendors are selling more umbrellas because of the rainy season.',
                            'This week, the vendors is selling more umbrellas because of the rainy season.',
                            'This week, the vendors are sell more umbrellas because of the rainy season.',
                            'This week, the vendors selling more umbrellas because of the rainy season.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"This week" di awal kalimat diikuti subjek jamak "the vendors are selling".'
                    ],
                    [
                        'id' => 69,
                        'id_sentence' => 'Saat ini, kakek sedang beristirahat setelah berjalan pagi.',
                        'target_word' => 'is currently resting (Adverbial Between Auxiliary & Verb)',
                        'vocab' => [
                            ['en' => 'currently', 'id' => 'saat ini'],
                            ['en' => 'resting', 'id' => 'beristirahat'],
                            ['en' => 'morning walk', 'id' => 'berjalan pagi']
                        ],
                        'options' => [
                            'Grandfather is currently resting after his morning walk.',
                            'Grandfather currently is resting after his morning walk.',
                            'Grandfather is currently rest after his morning walk.',
                            'Grandfather currently resting after his morning walk.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Currently" diletakkan di antara "is" dan "resting".'
                    ],
                    [
                        'id' => 70,
                        'id_sentence' => 'Bulan ini, sekolah kami sedang mengumpulkan donasi buku untuk perpustakaan desa.',
                        'target_word' => 'This month, ... is collecting (Adverbial Placement)',
                        'vocab' => [
                            ['en' => 'this month', 'id' => 'bulan ini'],
                            ['en' => 'collecting', 'id' => 'mengumpulkan'],
                            ['en' => 'village library', 'id' => 'perpustakaan desa']
                        ],
                        'options' => [
                            'This month, our school is collecting book donations for the village library.',
                            'This month, our school are collecting book donations for the village library.',
                            'This month, our school is collect book donations for the village library.',
                            'This month, our school collecting book donations for the village library.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"This month" di awal kalimat diikuti subjek tunggal "our school is collecting".'
                    ],
                ]
            ],

            // Sub-Lesson 1.9.8
            [
                'id' => 'continuous-synthesis',
                'name' => '1.9.8 Menggabungkan Dua Kejadian yang Terjadi Bersamaan',
                'code' => '1.9.8',
                'concept_title' => 'Menggabungkan Dua Kejadian yang Terjadi Bersamaan',
                'concept_description' => 'Menggabungkan dua klausa Present Continuous dengan kata sambung seperti while, because, as, dan although untuk menjelaskan dua hal yang sedang terjadi pada waktu yang sama.',
                'description' => 'Menggabungkan dua klausa Present Continuous dengan kata sambung seperti while, because, as, dan although untuk menjelaskan dua hal yang sedang terjadi pada waktu yang sama.',
                'formula' => 'Kata Sambung (While/Because/As) + Klausa 1 (Continuous) + Koma + Klausa 2 (Continuous)',
                'rules' => [
                    'Gunakan "while" atau "although" untuk membandingkan dua hal yang terjadi bersamaan.',
                    'Gunakan "because" atau "as" untuk menghubungkan sebab-akibat yang sedang berlangsung.',
                    'Jaga agar subjek dan to be tetap sesuai (cocok/agreement) di setiap klausa.'
                ],
                'exercises' => [
                    [
                        'id' => 71,
                        'id_sentence' => 'Sementara Ibu sedang memasak, Ayah sedang menyiapkan meja makan.',
                        'target_word' => 'is cooking ... is setting (Simultaneous Actions)',
                        'vocab' => [
                            ['en' => 'cooking', 'id' => 'memasak'],
                            ['en' => 'setting the table', 'id' => 'menyiapkan meja makan']
                        ],
                        'options' => [
                            'While Mom is cooking, Dad is setting the table.',
                            'While Mom cooks, Dad sets the table.',
                            'While Mom are cooking, Dad are setting the table.',
                            'While Mom is cooking, Dad setting the table.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Dua kejadian yang berlangsung bersamaan dinyatakan dengan klausa kontras Present Continuous: "is cooking" dan "is setting".'
                    ],
                    [
                        'id' => 72,
                        'id_sentence' => 'Kue sedang dipanggang di oven, sementara susu cokelat sedang dibuat di dapur.',
                        'target_word' => 'is being baked ... is being made (Dual Continuous Passive)',
                        'vocab' => [
                            ['en' => 'cake', 'id' => 'kue'],
                            ['en' => 'baked', 'id' => 'dipanggang'],
                            ['en' => 'chocolate milk', 'id' => 'susu cokelat']
                        ],
                        'options' => [
                            'The cake is being baked in the oven, while the chocolate milk is being made in the kitchen.',
                            'The cake is baking in the oven, while the chocolate milk is making in the kitchen.',
                            'The cake are being baked in the oven, while the chocolate milk are being made in the kitchen.',
                            'The cake is being bake in the oven, while the chocolate milk is being make in the kitchen.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kedua klausa memerlukan pasif continuous tunggal: "is being baked" dan "is being made".'
                    ],
                    [
                        'id' => 73,
                        'id_sentence' => 'Karena hujan sedang turun deras, anak-anak sedang bermain di dalam rumah.',
                        'target_word' => 'is pouring ... are playing (Causal Continuous)',
                        'vocab' => [
                            ['en' => 'pouring rain', 'id' => 'hujan turun deras'],
                            ['en' => 'playing indoors', 'id' => 'bermain di dalam rumah']
                        ],
                        'options' => [
                            'Because it is pouring rain, the children are playing indoors.',
                            'Because it are pouring rain, the children are playing indoors.',
                            'Because it is pour rain, the children is playing indoors.',
                            'Because it pouring rain, the children playing indoors.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa sebab "it is pouring" dan klausa akibat "the children are playing" keduanya memakai Present Continuous.'
                    ],
                    [
                        'id' => 74,
                        'id_sentence' => 'Sementara kakak sedang mengerjakan PR, adik sedang menonton kartun di ruang tamu.',
                        'target_word' => 'is doing ... is watching (Simultaneous Actions)',
                        'vocab' => [
                            ['en' => 'doing homework', 'id' => 'mengerjakan PR'],
                            ['en' => 'watching cartoons', 'id' => 'menonton kartun']
                        ],
                        'options' => [
                            'While the older sibling is doing homework, the younger sibling is watching cartoons in the living room.',
                            'While the older sibling does homework, the younger sibling watches cartoons in the living room.',
                            'While the older sibling are doing homework, the younger sibling are watching cartoons in the living room.',
                            'While the older sibling is doing homework, the younger sibling watching cartoons in the living room.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa pertama dan kedua sama-sama memakai bentuk Present Continuous tunggal.'
                    ],
                    [
                        'id' => 75,
                        'id_sentence' => 'Pohon-pohon di halaman sekolah sedang tumbuh subur karena para siswa rajin menyiramnya setiap pagi.',
                        'target_word' => 'are growing ... are watering (Causal Continuous)',
                        'vocab' => [
                            ['en' => 'trees', 'id' => 'pohon-pohon'],
                            ['en' => 'growing well', 'id' => 'tumbuh subur'],
                            ['en' => 'watering', 'id' => 'menyiram']
                        ],
                        'options' => [
                            'The trees in the schoolyard are growing well because the students are watering them every morning.',
                            'The trees in the schoolyard is growing well because the students is watering them every morning.',
                            'The trees in the schoolyard are grown well because the students are watered them every morning.',
                            'The trees in the schoolyard growing well because the students watering them every morning.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "trees" berpasangan dengan "are growing", dan subjek jamak "students" berpasangan dengan "are watering".'
                    ],
                    [
                        'id' => 76,
                        'id_sentence' => 'Lampu jalan baru sedang dipasang, sehingga keamanan di gang kami sedang membaik.',
                        'target_word' => 'are being installed ... is improving (Passive to Active Result)',
                        'vocab' => [
                            ['en' => 'new streetlights', 'id' => 'lampu jalan baru'],
                            ['en' => 'installed', 'id' => 'dipasang'],
                            ['en' => 'alley safety', 'id' => 'keamanan di gang']
                        ],
                        'options' => [
                            'New streetlights are being installed, so safety in our alley is improving.',
                            'New streetlights is being installed, so safety in our alley are improving.',
                            'New streetlights are installing, so safety in our alley is improving.',
                            'New streetlights are being installed, so safety in our alley improving.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa pertama memakai pasif continuous jamak "are being installed", klausa kedua memakai aktif tunggal "is improving".'
                    ],
                    [
                        'id' => 77,
                        'id_sentence' => 'Seiring banyak keluarga pindah ke kota, desa kami sedang menjadi semakin sepi.',
                        'target_word' => 'are moving ... is becoming (Socioeconomic-style but Everyday Transition)',
                        'vocab' => [
                            ['en' => 'families', 'id' => 'keluarga-keluarga'],
                            ['en' => 'moving', 'id' => 'pindah'],
                            ['en' => 'becoming quieter', 'id' => 'menjadi semakin sepi']
                        ],
                        'options' => [
                            'As many families are moving to the city, our village is becoming quieter.',
                            'As many families is moving to the city, our village are becoming quieter.',
                            'As many families are moved to the city, our village are become quieter.',
                            'As many families moving to the city, our village becoming quieter.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "families" memakai "are moving", subjek tunggal "village" memakai "is becoming".'
                    ],
                    [
                        'id' => 78,
                        'id_sentence' => 'Jalan di depan rumah sedang diperbaiki pemerintah daerah, sementara warga sedang memasang rambu sementara.',
                        'target_word' => 'is being repaired ... are putting',
                        'vocab' => [
                            ['en' => 'road', 'id' => 'jalan'],
                            ['en' => 'repaired', 'id' => 'diperbaiki'],
                            ['en' => 'temporary signs', 'id' => 'rambu sementara']
                        ],
                        'options' => [
                            'The road in front of the house is being repaired by the local government, while residents are putting up temporary signs.',
                            'The road in front of the house is repairing by the local government, while residents are putting up temporary signs.',
                            'The road in front of the house are being repaired by the local government, while residents is putting up temporary signs.',
                            'The road in front of the house is being repaired by the local government, while residents putting up temporary signs.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa pertama memakai pasif tunggal "is being repaired", klausa kedua memakai aktif jamak "are putting".'
                    ],
                    [
                        'id' => 79,
                        'id_sentence' => 'Kebiasaan belanja keluarga kami sedang berubah karena kami sedang mencoba berhemat.',
                        'target_word' => 'is changing ... are trying (Everyday Cause and Effect)',
                        'vocab' => [
                            ['en' => 'shopping habits', 'id' => 'kebiasaan belanja'],
                            ['en' => 'changing', 'id' => 'berubah'],
                            ['en' => 'saving money', 'id' => 'berhemat']
                        ],
                        'options' => [
                            'Our family\'s shopping habits are changing because we are trying to save money.',
                            'Our family\'s shopping habits is changing because we is trying to save money.',
                            'Our family\'s shopping habits are changed because we are tried to save money.',
                            'Our family\'s shopping habits changing because we trying to save money.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Habits" (jamak) dan "we" (jamak) keduanya memakai subjek jamak: "are changing" dan "are trying".'
                    ],
                    [
                        'id' => 80,
                        'id_sentence' => 'Meskipun paman sedang sibuk bekerja, ia tetap sedang membantu adik belajar lewat telepon.',
                        'target_word' => 'is working ... is helping (Contrast with Although)',
                        'vocab' => [
                            ['en' => 'working', 'id' => 'bekerja'],
                            ['en' => 'helping', 'id' => 'membantu'],
                            ['en' => 'over the phone', 'id' => 'lewat telepon']
                        ],
                        'options' => [
                            'Although Uncle is busy working, he is still helping my younger sibling study over the phone.',
                            'Although Uncle is busy working, he still helps my younger sibling study over the phone.',
                            'Although Uncle are busy working, he are still helping my younger sibling study over the phone.',
                            'Although Uncle is busy work, he is still help my younger sibling study over the phone.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kedua klausa memakai Present Continuous tunggal: "is working" dan "is helping".'
                    ],
                ]
            ],
        ];
    }
}
