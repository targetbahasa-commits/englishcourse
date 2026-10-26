<?php

namespace App\Services;

class SelfStudySimpleFutureData
{
    /**
     * Get the complete Simple Future Tense (Will & Be Going To: Verbal, Nominal, Passive) package.
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
            'banner_title' => 'Simple Future Tense (Will & Be Going To: Verbal, Nominal, Passive)',
            'banner_subtitle' => 'Kuasai cara menyatakan rencana, prediksi, janji, dan kondisi masa depan sehari-hari dengan "will" dan "be going to", termasuk bentuk nominal, bentuk pasif, dan aturan larangan "will" dalam klausa waktu.',
            'banner_badge' => 'MODULE 1.11 SIMPLE FUTURE TENSE',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 1.11
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Panduan Lengkap Simple Future Tense: Rencana, Prediksi, & Janji Sehari-hari',
            'concept_summary' => 'Simple Future Tense digunakan untuk menyatakan rencana, prediksi, janji, dan kondisi di masa depan dalam percakapan sehari-hari. Kita perlu membedakan antara "will" (keputusan spontan, janji, prediksi umum), "be going to" (rencana yang sudah dipikirkan atau prediksi berdasarkan bukti nyata saat ini), bentuk nominal ("will be"), bentuk pasif ("will be + V3"), dan aturan penting: tidak boleh memakai "will" di dalam anak kalimat waktu.',
            'rules' => [
                [
                    'rule_title' => '1. Simple Future Verbal Aktif: Will + Verb 1 (Base Form)',
                    'rule_formula' => 'Subject + will + Verb 1 (Bare Infinitive) + Object',
                    'rule_description' => 'Gunakan "will + V1" untuk seluruh subjek tunggal dan jamak saat membuat janji atau prediksi umum. Kata kerja setelah "will" wajib berbentuk dasar tanpa akhiran -s, -ed, atau -ing.',
                    'examples' => [
                        [
                            'en' => 'I will call you tonight.',
                            'id' => 'Saya akan menelepon kamu malam ini.',
                            'note' => '"will" langsung diikuti kata kerja dasar murni "call".'
                        ]
                    ]
                ],
                [
                    'rule_title' => '2. Prediksi Berbasis Bukti Nyata: Be Going To + V1',
                    'rule_formula' => 'Subject + am/is/are + going to + Verb 1 (Base Form)',
                    'rule_description' => 'Gunakan "be going to" jika ada bukti nyata saat ini yang mengindikasikan suatu kepastian hasil, atau jika suatu rencana sudah dipikirkan/diputuskan sebelumnya.',
                    'examples' => [
                        [
                            'en' => 'Look at those dark clouds, it is going to rain.',
                            'id' => 'Lihat awan gelap itu, sepertinya akan hujan.',
                            'note' => 'Didukung oleh bukti nyata yang terlihat saat ini ("those dark clouds").'
                        ]
                    ]
                ],
                [
                    'rule_title' => '3. Bentuk Nominal Masa Depan: Will Be & Be Going To Be',
                    'rule_formula' => 'Subject + will be / is/are going to be + Adjective / Noun Phrase / Prepositional Phrase',
                    'rule_description' => 'Menyatakan status, sifat, atau kondisi subjek di masa mendatang. Kata "be" wajib hadir sebelum kata sifat, nomina, atau preposisi.',
                    'examples' => [
                        [
                            'en' => 'The weather will be cold tomorrow.',
                            'id' => 'Cuaca akan dingin besok.',
                            'note' => 'Dilarang meniadakan "be" (*will cold adalah SALAH).'
                        ]
                    ]
                ],
                [
                    'rule_title' => '4. Bentuk Pasif Masa Depan: Will Be + Verb 3 (Past Participle)',
                    'rule_formula' => 'Passive Subject + will be + Verb 3 (Past Participle) + (by Agent)',
                    'rule_description' => 'Digunakan ketika fokus kalimat ada pada sesuatu yang akan dikenai tindakan, bukan pada pelaku tindakannya.',
                    'examples' => [
                        [
                            'en' => 'The cake will be baked by Grandma this afternoon.',
                            'id' => 'Kue itu akan dipanggang oleh Nenek sore ini.',
                            'note' => '"will be baked" memaparkan tindakan yang akan dikenakan pada kue.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '5. Aturan Larangan "Will" dalam Klausa Waktu (No Future in Time Clauses)',
                    'rule_formula' => 'Time Conjunction (When/Once/As soon as/Before) + S + Verb 1/V-s (Simple Present), Main Clause (will + V1)',
                    'rule_description' => 'Anak kalimat yang diawali konjungsi waktu (when, as soon as, once, before, after, until) atau syarat (if, unless) DILARANG menggunakan "will". Gunakan Simple Present di anak kalimat, dan letakkan "will" hanya di induk kalimat.',
                    'examples' => [
                        [
                            'en' => 'When it stops raining, we will go outside.',
                            'id' => 'Ketika hujan berhenti, kita akan pergi keluar.',
                            'note' => 'Gunakan "stops" (Simple Present), BUKAN *will stop.'
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
                'id' => 'future-verbal-will',
                'name' => "1.11.1 Simple Future Verbal with 'Will': Everyday Plans & Promises",
                'code' => '1.11.1',
                'concept_title' => 'Simple Future Verbal (Will): Rencana & Janji Sehari-hari',
                'concept_description' => "Simple Future Verbal dengan modal auxiliary 'will' digunakan untuk membuat janji, menyampaikan keputusan spontan, dan menyatakan prediksi umum dalam percakapan sehari-hari. Strukturnya tidak bergantung pada subjek tunggal atau jamak: selalu gunakan 'will' diikuti kata kerja dasar murni (Bare Infinitive / V1) tanpa akhiran -s, -ed, atau -ing.",
                'description' => "Simple Future Verbal dengan modal auxiliary 'will' digunakan untuk membuat janji, menyampaikan keputusan spontan, dan menyatakan prediksi umum dalam percakapan sehari-hari. Strukturnya tidak bergantung pada subjek tunggal atau jamak: selalu gunakan 'will' diikuti kata kerja dasar murni (Bare Infinitive / V1) tanpa akhiran -s, -ed, atau -ing.",
                'formula' => 'Subject + will + Verb 1 (Base Form) + Object / Complement',
                'rules' => [
                    "Gunakan 'will + V1' untuk seluruh jenis subjek, baik tunggal (my mom, this app) maupun jamak (my friends, the students).",
                    "Kata kerja setelah 'will' wajib berbentuk dasar (Bare Infinitive): will call, will help, will visit.",
                    'Dilarang menambahkan to be sebelum V1 aktif (*will is help, *will to visit adalah SALAH).',
                    "Dalam percakapan santai boleh dipendekkan jadi 'I'll', 'we'll', tapi dalam latihan menulis, tulis secara utuh 'I will' dan 'we will'.",
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'id_sentence' => 'Ibu akan menelepon kamu malam ini untuk menanyakan kabar.',
                        'target_word' => 'will call (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'Mom', 'id' => 'Ibu'],
                            ['en' => 'call you tonight', 'id' => 'menelepon kamu malam ini'],
                            ['en' => 'ask how you are', 'id' => 'menanyakan kabar'],
                        ],
                        'options' => [
                            'Mom will call you tonight to ask how you are.',
                            'Mom will calls you tonight to ask how you are.',
                            'Mom will to call you tonight to ask how you are.',
                            'Mom is will call you tonight to ask how you are.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Setelah modal auxiliary 'will', kata kerja wajib berbentuk dasar (Bare Infinitive) 'call' tanpa akhiran -s atau partikel 'to'.",
                    ],
                    [
                        'id' => 2,
                        'id_sentence' => 'Teman-temanku akan mengunjungi nenek di kampung bulan depan.',
                        'target_word' => 'will visit (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'my friends', 'id' => 'teman-temanku'],
                            ['en' => 'visit grandma in the village', 'id' => 'mengunjungi nenek di kampung'],
                            ['en' => 'next month', 'id' => 'bulan depan'],
                        ],
                        'options' => [
                            'My friends will visit grandma in the village next month.',
                            'My friends will visits grandma in the village next month.',
                            'My friends will visited grandma in the village next month.',
                            'My friends are will visit grandma in the village next month.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'friends' dipadukan dengan modal 'will' + V1 'visit'. Pilihan C salah menggunakan V2.",
                    ],
                    [
                        'id' => 3,
                        'id_sentence' => 'Aplikasi cuaca baru ini akan memprediksi hujan dengan lebih akurat.',
                        'target_word' => 'will predict (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'new weather app', 'id' => 'aplikasi cuaca baru'],
                            ['en' => 'predict rain', 'id' => 'memprediksi hujan'],
                            ['en' => 'more accurately', 'id' => 'dengan lebih akurat'],
                        ],
                        'options' => [
                            'This new weather app will predict rain more accurately.',
                            'This new weather app will predicts rain more accurately.',
                            'This new weather app will predicting rain more accurately.',
                            'This new weather app will be predict rain more accurately.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Modal 'will' langsung diikuti V1 murni 'predict'. Bentuk 'will predicts' melanggar aturan modal.",
                    ],
                    [
                        'id' => 4,
                        'id_sentence' => 'Program membaca yang diusulkan sekolah akan mendorong minat baca siswa.',
                        'target_word' => 'will encourage (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'proposed reading program', 'id' => 'program membaca yang diusulkan'],
                            ['en' => 'encourage reading interest', 'id' => 'mendorong minat baca'],
                            ['en' => 'students', 'id' => 'siswa'],
                        ],
                        'options' => [
                            "The school's proposed reading program will encourage students' reading interest.",
                            "The school's proposed reading program will encourages students' reading interest.",
                            "The school's proposed reading program will encouraged students' reading interest.",
                            "The school's proposed reading program is will encourage students' reading interest.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will encourage' adalah konstruksi verbal aktif masa depan yang benar; tidak boleh ditambah to be 'is' di depannya.",
                    ],
                    [
                        'id' => 5,
                        'id_sentence' => 'Guru akan menyelidiki penyebab kebisingan yang terjadi di kelas tadi pagi.',
                        'target_word' => 'will investigate (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'teacher', 'id' => 'guru'],
                            ['en' => 'investigate the cause', 'id' => 'menyelidiki penyebab'],
                            ['en' => 'noise in class', 'id' => 'kebisingan di kelas'],
                        ],
                        'options' => [
                            'The teacher will investigate the cause of the noise in class this morning.',
                            'The teacher will investigates the cause of the noise in class this morning.',
                            'The teacher will to investigate the cause of the noise in class this morning.',
                            'The teacher will investigating the cause of the noise in class this morning.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will investigate' menggunakan bentuk dasar setelah modal 'will'.",
                    ],
                    [
                        'id' => 6,
                        'id_sentence' => 'Pemerintah kota akan memperluas taman bermain agar anak-anak punya lebih banyak ruang.',
                        'target_word' => 'will expand (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'city government', 'id' => 'pemerintah kota'],
                            ['en' => 'expand the playground', 'id' => 'memperluas taman bermain'],
                            ['en' => 'more space', 'id' => 'lebih banyak ruang'],
                        ],
                        'options' => [
                            'The city government will expand the playground so children have more space.',
                            'The city government will expands the playground so children have more space.',
                            'The city government will expanded the playground so children have more space.',
                            'The city government will to expand the playground so children have more space.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Bentuk dasar 'expand' wajib digunakan setelah 'will'.",
                    ],
                    [
                        'id' => 7,
                        'id_sentence' => 'Hujan deras akan mengancam acara piknik sekolah besok pagi.',
                        'target_word' => 'will threaten (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'heavy rain', 'id' => 'hujan deras'],
                            ['en' => 'threaten the school picnic', 'id' => 'mengancam acara piknik sekolah'],
                            ['en' => 'tomorrow morning', 'id' => 'besok pagi'],
                        ],
                        'options' => [
                            "Heavy rain will threaten tomorrow morning's school picnic.",
                            "Heavy rain will threatens tomorrow morning's school picnic.",
                            "Heavy rain will threatened tomorrow morning's school picnic.",
                            "Heavy rain is will threaten tomorrow morning's school picnic.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will threaten' memaparkan prediksi masa depan dengan kata kerja dasar.",
                    ],
                    [
                        'id' => 8,
                        'id_sentence' => 'Sekolah akan memperkenalkan kelas melukis baru bagi siswa tahun depan.',
                        'target_word' => 'will introduce (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'school', 'id' => 'sekolah'],
                            ['en' => 'introduce a new painting class', 'id' => 'memperkenalkan kelas melukis baru'],
                            ['en' => 'next year', 'id' => 'tahun depan'],
                        ],
                        'options' => [
                            'The school will introduce a new painting class for students next year.',
                            'The school will introduces a new painting class for students next year.',
                            'The school will introduced a new painting class for students next year.',
                            'The school will to introduce a new painting class for students next year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The school' diikuti modal 'will' + V1 'introduce'.",
                    ],
                    [
                        'id' => 9,
                        'id_sentence' => 'Kebiasaan menabung akan menurunkan pengeluaran bulanan keluarga kami.',
                        'target_word' => 'will decrease (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'habit of saving', 'id' => 'kebiasaan menabung'],
                            ['en' => 'decrease monthly expenses', 'id' => 'menurunkan pengeluaran bulanan'],
                            ['en' => 'our family', 'id' => 'keluarga kami'],
                        ],
                        'options' => [
                            "The habit of saving will decrease our family's monthly expenses.",
                            "The habit of saving will decreases our family's monthly expenses.",
                            "The habit of saving will decreased our family's monthly expenses.",
                            "The habit of saving is will decrease our family's monthly expenses.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek frase panjang 'The habit of saving' berpredikat 'will decrease'.",
                    ],
                    [
                        'id' => 10,
                        'id_sentence' => 'Ayah memperkirakan bahwa cuaca akan membaik pada hari Minggu.',
                        'target_word' => 'will improve (Future Verbal with Will)',
                        'vocab' => [
                            ['en' => 'Dad predicts', 'id' => 'Ayah memperkirakan'],
                            ['en' => 'weather', 'id' => 'cuaca'],
                            ['en' => 'improve', 'id' => 'membaik'],
                        ],
                        'options' => [
                            'Dad predicts that the weather will improve on Sunday.',
                            'Dad predicts that the weather will improves on Sunday.',
                            'Dad predicts that the weather will improved on Sunday.',
                            'Dad predicts that the weather will to improve on Sunday.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa prediksi menggunakan modal masa depan 'will improve'.",
                    ],
                ]
            ],
            [
                'id' => 'future-be-going-to',
                'name' => "1.11.2 Simple Future with 'Be Going To': Evidence-Based Predictions & Pre-Planned Activities",
                'code' => '1.11.2',
                'concept_title' => 'Simple Future (Be Going To): Prediksi Berbasis Bukti & Rencana Matang',
                'concept_description' => "Konstruksi 'be going to' digunakan ketika ada bukti nyata saat ini (seperti awan gelap, tanda-tanda yang terlihat) yang mengarah kuat pada hasil masa depan, atau ketika suatu kegiatan sudah direncanakan sebelumnya. Auxiliary 'be' diselaraskan dengan subjek (is / am / are) diikuti 'going to' dan kata kerja dasar (V1).",
                'description' => "Konstruksi 'be going to' digunakan ketika ada bukti nyata saat ini (seperti awan gelap, tanda-tanda yang terlihat) yang mengarah kuat pada hasil masa depan, atau ketika suatu kegiatan sudah direncanakan sebelumnya. Auxiliary 'be' diselaraskan dengan subjek (is / am / are) diikuti 'going to' dan kata kerja dasar (V1).",
                'formula' => 'Subject + am/is/are + going to + Verb 1 (Base Form) + Object',
                'rules' => [
                    "Selaraskan to be dengan subjek: 'is going to' (tunggal), 'are going to' (jamak), 'am going to' (I).",
                    "Setelah 'going to', kata kerja wajib berbentuk dasar V1 murni (Bare Infinitive).",
                    "Gunakan 'be going to' saat ada bukti nyata saat ini (misal: 'Look at those clouds, it is going to rain').",
                    'Jangan menghilangkan to be (*They going to visit adalah SALAH).',
                ],
                'exercises' => [
                    [
                        'id' => 11,
                        'id_sentence' => 'Lihat awan gelap itu, sepertinya akan hujan deras sebentar lagi.',
                        'target_word' => 'is going to rain (Evidence-Based Prediction)',
                        'vocab' => [
                            ['en' => 'look at those dark clouds', 'id' => 'lihat awan gelap itu'],
                            ['en' => 'going to rain heavily', 'id' => 'akan hujan deras'],
                            ['en' => 'soon', 'id' => 'sebentar lagi'],
                        ],
                        'options' => [
                            'Look at those dark clouds, it is going to rain heavily soon.',
                            'Look at those dark clouds, it are going to rain heavily soon.',
                            'Look at those dark clouds, it is going to raining heavily soon.',
                            'Look at those dark clouds, it going to rain heavily soon.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'it' memerlukan to be 'is' + 'going to rain'. Ada bukti nyata ('those dark clouds') yang mendasari prediksi.",
                    ],
                    [
                        'id' => 12,
                        'id_sentence' => 'Melihat ombak yang semakin tinggi, air laut tampaknya akan naik dengan cepat.',
                        'target_word' => 'is going to rise (Evidence-Based Prediction)',
                        'vocab' => [
                            ['en' => 'the waves getting higher', 'id' => 'ombak yang semakin tinggi'],
                            ['en' => 'sea level', 'id' => 'air laut'],
                            ['en' => 'rise quickly', 'id' => 'naik dengan cepat'],
                        ],
                        'options' => [
                            'Given the waves getting higher, the sea level is going to rise quickly.',
                            'Given the waves getting higher, the sea level are going to rise quickly.',
                            'Given the waves getting higher, the sea level is going to rising quickly.',
                            'Given the waves getting higher, the sea level going to rise quickly.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'the sea level' berpasangan dengan 'is going to rise'.",
                    ],
                    [
                        'id' => 13,
                        'id_sentence' => 'Sekolah kami akan membuka perpustakaan baru pada semester depan.',
                        'target_word' => 'is going to open (Pre-Planned Activity)',
                        'vocab' => [
                            ['en' => 'our school', 'id' => 'sekolah kami'],
                            ['en' => 'open a new library', 'id' => 'membuka perpustakaan baru'],
                            ['en' => 'next semester', 'id' => 'semester depan'],
                        ],
                        'options' => [
                            'Our school is going to open a new library next semester.',
                            'Our school are going to open a new library next semester.',
                            'Our school is going to opens a new library next semester.',
                            'Our school is going to opened a new library next semester.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Rencana sekolah yang sudah dipersiapkan memakai 'is going to open' dengan kata kerja dasar 'open'.",
                    ],
                    [
                        'id' => 14,
                        'id_sentence' => 'Melihat ban sepedanya kempis, Kakak akan menambalnya sebelum berangkat sekolah.',
                        'target_word' => 'is going to patch (Evidence-Based Action)',
                        'vocab' => [
                            ['en' => 'notices the flat tire', 'id' => 'melihat ban kempis'],
                            ['en' => 'my brother', 'id' => 'Kakak'],
                            ['en' => 'patch it', 'id' => 'menambalnya'],
                        ],
                        'options' => [
                            'Noticing the flat tire, my brother is going to patch it before school.',
                            'Noticing the flat tire, my brother are going to patch it before school.',
                            'Noticing the flat tire, my brother is going to patching it before school.',
                            'Noticing the flat tire, my brother going to patch it before school.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'my brother' berpasangan dengan 'is going to patch'.",
                    ],
                    [
                        'id' => 15,
                        'id_sentence' => 'Melihat kulkas yang hampir kosong, kami akan menghadapi masalah belanja minggu ini.',
                        'target_word' => 'is going to face (Evidence-Based Prediction)',
                        'vocab' => [
                            ['en' => 'the fridge being almost empty', 'id' => 'kulkas yang hampir kosong'],
                            ['en' => 'our family', 'id' => 'keluarga kami'],
                            ['en' => 'face a shopping problem', 'id' => 'menghadapi masalah belanja'],
                        ],
                        'options' => [
                            'With the fridge almost empty, our family is going to face a shopping problem this week.',
                            'With the fridge almost empty, our family are going to face a shopping problem this week.',
                            'With the fridge almost empty, our family is going to facing a shopping problem this week.',
                            'With the fridge almost empty, our family going to face a shopping problem this week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'our family' menggunakan 'is going to face'.",
                    ],
                    [
                        'id' => 16,
                        'id_sentence' => 'Panitia kelas akan meninjau kembali rencana acara pada rapat minggu depan.',
                        'target_word' => 'is going to review (Pre-Planned Activity)',
                        'vocab' => [
                            ['en' => 'class committee', 'id' => 'panitia kelas'],
                            ['en' => 'review the event plan', 'id' => 'meninjau kembali rencana acara'],
                            ['en' => "next week's meeting", 'id' => 'rapat minggu depan'],
                        ],
                        'options' => [
                            "The class committee is going to review the event plan at next week's meeting.",
                            "The class committee are going to review the event plan at next week's meeting.",
                            "The class committee is going to reviewing the event plan at next week's meeting.",
                            "The class committee going to review the event plan at next week's meeting.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "Collective noun 'The class committee' sebagai entitas tunggal memakai 'is going to review'.",
                    ],
                    [
                        'id' => 17,
                        'id_sentence' => 'Karena persediaan air di rumah menipis, kami akan membeli galon isi ulang sore ini.',
                        'target_word' => 'are going to buy (Evidence-Based Action)',
                        'vocab' => [
                            ['en' => 'water supply running low', 'id' => 'persediaan air menipis'],
                            ['en' => 'we', 'id' => 'kami'],
                            ['en' => 'buy refill gallons', 'id' => 'membeli galon isi ulang'],
                        ],
                        'options' => [
                            'Because the water supply is running low, we are going to buy refill gallons this afternoon.',
                            'Because the water supply is running low, we is going to buy refill gallons this afternoon.',
                            'Because the water supply is running low, we are going to buying refill gallons this afternoon.',
                            'Because the water supply is running low, we going to buy refill gallons this afternoon.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'we' berpasangan dengan 'are going to buy'.",
                    ],
                    [
                        'id' => 18,
                        'id_sentence' => 'Kelompok belajar kami akan mempresentasikan hasil proyek pada minggu depan.',
                        'target_word' => 'is going to present (Pre-Planned Schedule)',
                        'vocab' => [
                            ['en' => 'our study group', 'id' => 'kelompok belajar kami'],
                            ['en' => 'present the project results', 'id' => 'mempresentasikan hasil proyek'],
                            ['en' => 'next week', 'id' => 'minggu depan'],
                        ],
                        'options' => [
                            'Our study group is going to present the project results next week.',
                            'Our study group are going to present the project results next week.',
                            'Our study group is going to presents the project results next week.',
                            'Our study group going to present the project results next week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'Our study group' mengambil 'is going to present'.",
                    ],
                    [
                        'id' => 19,
                        'id_sentence' => 'Melihat tanaman yang mulai layu, kebun kami akan mengalami kerugian jika tidak segera disiram.',
                        'target_word' => 'is going to suffer (Evidence-Based Prediction)',
                        'vocab' => [
                            ['en' => 'the wilting plants', 'id' => 'tanaman yang layu'],
                            ['en' => 'our garden', 'id' => 'kebun kami'],
                            ['en' => 'suffer damage', 'id' => 'mengalami kerugian'],
                        ],
                        'options' => [
                            'Given the wilting plants, our garden is going to suffer damage unless we water it soon.',
                            'Given the wilting plants, our garden are going to suffer damage unless we water it soon.',
                            'Given the wilting plants, our garden is going to suffering damage unless we water it soon.',
                            'Given the wilting plants, our garden going to suffer damage unless we water it soon.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'garden' adalah subjek tunggal, maka to be yang benar adalah 'is going to suffer'.",
                    ],
                    [
                        'id' => 20,
                        'id_sentence' => 'Petugas keamanan sekolah akan memperbarui jadwal piket untuk mencegah kelalaian.',
                        'target_word' => 'are going to update (Pre-Planned Action)',
                        'vocab' => [
                            ['en' => 'school security staff', 'id' => 'petugas keamanan sekolah'],
                            ['en' => 'update the duty schedule', 'id' => 'memperbarui jadwal piket'],
                            ['en' => 'prevent oversights', 'id' => 'mencegah kelalaian'],
                        ],
                        'options' => [
                            'The school security staff are going to update the duty schedule to prevent oversights.',
                            'The school security staff is going to update the duty schedule to prevent oversights.',
                            'The school security staff are going to updating the duty schedule to prevent oversights.',
                            'The school security staff going to update the duty schedule to prevent oversights.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'The school security staff' membutuhkan 'are going to update'.",
                    ],
                ]
            ],
            [
                'id' => 'future-nominal',
                'name' => "1.11.3 Simple Future Nominal: Future States & Conditions ('Will Be' & 'Be Going To Be')",
                'code' => '1.11.3',
                'concept_title' => 'Simple Future Nominal: Menjelaskan Status & Kondisi Masa Depan',
                'concept_description' => "Dalam percakapan sehari-hari, kita sering kali perlu memperkirakan status, peran, atau sifat sesuatu di masa depan. Simple Future Nominal dibentuk dengan meletakkan 'be' setelah modal 'will' (will be) atau setelah 'going to' (is/are going to be) diikuti pelengkap (Adjective, Noun Phrase, atau Prepositional Phrase). Jangan pernah meniadakan kata 'be' pada kalimat nominal masa depan.",
                'description' => "Dalam percakapan sehari-hari, kita sering kali perlu memperkirakan status, peran, atau sifat sesuatu di masa depan. Simple Future Nominal dibentuk dengan meletakkan 'be' setelah modal 'will' (will be) atau setelah 'going to' (is/are going to be) diikuti pelengkap (Adjective, Noun Phrase, atau Prepositional Phrase). Jangan pernah meniadakan kata 'be' pada kalimat nominal masa depan.",
                'formula' => 'Subject + will be / is/are going to be + Adjective / Noun Phrase / Prepositional Phrase',
                'rules' => [
                    "Bentuk baku nominal: 'will be + Complement' atau 'is/are going to be + Complement'.",
                    'Pelengkap (Complement) dapat berupa kata sifat (happy, ready), frasa nomina (a doctor), atau preposisi (at home).',
                    "Dilarang keras meniadakan 'be' (*will happy adalah KESALAHAN BESAR).",
                    'Dilarang menggunakan to be lain setelah will (*will is, *will was).',
                ],
                'exercises' => [
                    [
                        'id' => 21,
                        'id_sentence' => 'Cuaca akan dingin besok, jadi bawalah jaket.',
                        'target_word' => 'will be cold (Future Nominal)',
                        'vocab' => [
                            ['en' => 'weather', 'id' => 'cuaca'],
                            ['en' => 'cold', 'id' => 'dingin'],
                            ['en' => 'bring a jacket', 'id' => 'bawalah jaket'],
                        ],
                        'options' => [
                            'The weather will be cold tomorrow, so bring a jacket.',
                            'The weather will cold tomorrow, so bring a jacket.',
                            'The weather will is cold tomorrow, so bring a jacket.',
                            'The weather will being cold tomorrow, so bring a jacket.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Setelah modal 'will', kita wajib menyertakan kata kerja bantu 'be' sebelum adjective 'cold' ('will be cold').",
                    ],
                    [
                        'id' => 22,
                        'id_sentence' => 'Kakakku akan menjadi guru setelah lulus kuliah tahun depan.',
                        'target_word' => 'will be a teacher (Future Nominal)',
                        'vocab' => [
                            ['en' => 'my older sister', 'id' => 'kakakku'],
                            ['en' => 'a teacher', 'id' => 'guru'],
                            ['en' => 'after graduating', 'id' => 'setelah lulus kuliah'],
                        ],
                        'options' => [
                            'My older sister will be a teacher after graduating next year.',
                            'My older sister will a teacher after graduating next year.',
                            'My older sister will is a teacher after graduating next year.',
                            'My older sister will being a teacher after graduating next year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Diperlukan 'will be' sebelum noun phrase 'a teacher'.",
                    ],
                    [
                        'id' => 23,
                        'id_sentence' => 'Jalanan diperkirakan akan lebih ramai akibat libur panjang.',
                        'target_word' => 'are going to be busier (Future Nominal with Be Going To)',
                        'vocab' => [
                            ['en' => 'the streets', 'id' => 'jalanan'],
                            ['en' => 'busier', 'id' => 'lebih ramai'],
                            ['en' => 'long holiday', 'id' => 'libur panjang'],
                        ],
                        'options' => [
                            'The streets are going to be busier because of the long holiday.',
                            'The streets is going to be busier because of the long holiday.',
                            'The streets are going to busier because of the long holiday.',
                            'The streets are going to being busier because of the long holiday.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'streets' membutuhkan 'are going to be' diikuti adjective 'busier'.",
                    ],
                    [
                        'id' => 24,
                        'id_sentence' => 'Aturan perpustakaan yang baru akan berlaku mulai awal bulan depan.',
                        'target_word' => 'will be in effect (Future Nominal with Prepositional Phrase)',
                        'vocab' => [
                            ['en' => 'new library rule', 'id' => 'aturan perpustakaan yang baru'],
                            ['en' => 'in effect', 'id' => 'berlaku'],
                            ['en' => 'beginning of next month', 'id' => 'awal bulan depan'],
                        ],
                        'options' => [
                            'The new library rule will be in effect starting next month.',
                            'The new library rule will in effect starting next month.',
                            'The new library rule will are in effect starting next month.',
                            'The new library rule will being in effect starting next month.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Frasa preposisional 'in effect' memerlukan 'will be'.",
                    ],
                    [
                        'id' => 25,
                        'id_sentence' => 'Harga tiket bioskop akan lebih murah pada hari biasa.',
                        'target_word' => 'will be cheaper (Future Nominal)',
                        'vocab' => [
                            ['en' => 'movie ticket price', 'id' => 'harga tiket bioskop'],
                            ['en' => 'cheaper', 'id' => 'lebih murah'],
                            ['en' => 'on weekdays', 'id' => 'pada hari biasa'],
                        ],
                        'options' => [
                            'The movie ticket price will be cheaper on weekdays.',
                            'The movie ticket price will cheaper on weekdays.',
                            'The movie ticket price will are cheaper on weekdays.',
                            'The movie ticket price will being cheaper on weekdays.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kalimat nominal masa depan wajib menggunakan 'will be' sebelum komparatif 'cheaper'.",
                    ],
                    [
                        'id' => 26,
                        'id_sentence' => 'Acara pentas seni ini akan menjadi kesempatan emas bagi para siswa berbakat.',
                        'target_word' => 'is going to be a golden opportunity (Future Nominal with Be Going To)',
                        'vocab' => [
                            ['en' => 'this talent show', 'id' => 'acara pentas seni ini'],
                            ['en' => 'golden opportunity', 'id' => 'kesempatan emas'],
                            ['en' => 'talented students', 'id' => 'siswa berbakat'],
                        ],
                        'options' => [
                            'This talent show is going to be a golden opportunity for talented students.',
                            'This talent show are going to be a golden opportunity for talented students.',
                            'This talent show is going to a golden opportunity for talented students.',
                            'This talent show going to be a golden opportunity for talented students.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'This talent show' dipadukan dengan 'is going to be a golden opportunity'.",
                    ],
                    [
                        'id' => 27,
                        'id_sentence' => 'Kerja sama tim akan sangat penting untuk memenangkan lomba cerdas cermat.',
                        'target_word' => 'will be very important (Future Nominal)',
                        'vocab' => [
                            ['en' => 'teamwork', 'id' => 'kerja sama tim'],
                            ['en' => 'very important', 'id' => 'sangat penting'],
                            ['en' => 'winning the quiz competition', 'id' => 'memenangkan lomba cerdas cermat'],
                        ],
                        'options' => [
                            'Teamwork will be very important for winning the quiz competition.',
                            'Teamwork will very important for winning the quiz competition.',
                            'Teamwork will is very important for winning the quiz competition.',
                            'Teamwork will being very important for winning the quiz competition.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will be very important' adalah struktur nominal masa depan yang baku.",
                    ],
                    [
                        'id' => 28,
                        'id_sentence' => 'Hasil ujian ini akan berguna untuk mengukur kemajuan belajar kalian.',
                        'target_word' => 'will be useful (Future Nominal)',
                        'vocab' => [
                            ['en' => 'this exam result', 'id' => 'hasil ujian ini'],
                            ['en' => 'useful', 'id' => 'berguna'],
                            ['en' => 'measuring your progress', 'id' => 'mengukur kemajuan belajar kalian'],
                        ],
                        'options' => [
                            'This exam result will be useful for measuring your progress.',
                            'This exam result will useful for measuring your progress.',
                            'This exam result will are useful for measuring your progress.',
                            'This exam result will being useful for measuring your progress.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Diperlukan 'will be' sebelum kata sifat 'useful'.",
                    ],
                    [
                        'id' => 29,
                        'id_sentence' => 'Kedua siswa itu akan menjadi perwakilan sekolah dalam lomba debat kota.',
                        'target_word' => 'are going to be representatives (Future Nominal with Be Going To)',
                        'vocab' => [
                            ['en' => 'the two students', 'id' => 'kedua siswa itu'],
                            ['en' => 'representatives', 'id' => 'perwakilan'],
                            ['en' => 'city debate competition', 'id' => 'lomba debat kota'],
                        ],
                        'options' => [
                            'The two students are going to be representatives in the city debate competition.',
                            'The two students is going to be representatives in the city debate competition.',
                            'The two students are going to representatives in the city debate competition.',
                            'The two students are going to being representatives in the city debate competition.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'students' mengambil 'are going to be'.",
                    ],
                    [
                        'id' => 30,
                        'id_sentence' => 'Rumah kami akan rentan kebanjiran jika selokan tidak segera dibersihkan.',
                        'target_word' => 'will be vulnerable (Future Nominal)',
                        'vocab' => [
                            ['en' => 'our house', 'id' => 'rumah kami'],
                            ['en' => 'vulnerable to flooding', 'id' => 'rentan kebanjiran'],
                            ['en' => 'the drain is not cleaned', 'id' => 'selokan tidak dibersihkan'],
                        ],
                        'options' => [
                            'Our house will be vulnerable to flooding if the drain is not cleaned soon.',
                            'Our house will vulnerable to flooding if the drain is not cleaned soon.',
                            'Our house will is vulnerable to flooding if the drain is not cleaned soon.',
                            'Our house will being vulnerable to flooding if the drain is not cleaned soon.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will be vulnerable' menggabungkan modal 'will' dengan 'be' dan adjective 'vulnerable'.",
                    ],
                ]
            ],
            [
                'id' => 'future-passive',
                'name' => '1.11.4 Simple Future Passive: Everyday Plans & Household Procedures',
                'code' => '1.11.4',
                'concept_title' => 'Simple Future Pasif: Rencana & Kegiatan Rumah Tangga Sehari-hari',
                'concept_description' => "Simple Future Pasif digunakan ketika fokus kalimat ada pada sesuatu atau seseorang yang akan dikenai suatu tindakan di masa depan, bukan pada siapa yang melakukannya (misal: 'the cake will be baked', 'the room will be cleaned'). Rumusnya menggunakan 'will be' diikuti Past Participle (V3).",
                'description' => "Simple Future Pasif digunakan ketika fokus kalimat ada pada sesuatu atau seseorang yang akan dikenai suatu tindakan di masa depan, bukan pada siapa yang melakukannya (misal: 'the cake will be baked', 'the room will be cleaned'). Rumusnya menggunakan 'will be' diikuti Past Participle (V3).",
                'formula' => 'Subject (Patient) + will be / is/are going to be + Verb 3 (Past Participle) + (by Agent)',
                'rules' => [
                    'Rumus utama: will be + Verb 3 (Past Participle).',
                    'Jangan tertukar dengan Future Continuous aktif (will be + V-ing); bentuk pasif WAJIB berakhiran V3 (will be cleaned, bukan will be cleaning).',
                    "Dalam bentuk 'be going to', rumusnya adalah 'is/are going to be + V3'.",
                    'Bentuk pasif cocok dipakai saat kita ingin menekankan objek yang menerima tindakan, bukan pelakunya.',
                ],
                'exercises' => [
                    [
                        'id' => 31,
                        'id_sentence' => 'Kue itu akan dipanggang oleh Nenek sore ini untuk acara ulang tahun.',
                        'target_word' => 'will be baked (Future Passive)',
                        'vocab' => [
                            ['en' => 'the cake', 'id' => 'kue itu'],
                            ['en' => 'baked by Grandma', 'id' => 'dipanggang oleh Nenek'],
                            ['en' => 'birthday party', 'id' => 'acara ulang tahun'],
                        ],
                        'options' => [
                            'The cake will be baked by Grandma this afternoon for the birthday party.',
                            'The cake will bake by Grandma this afternoon for the birthday party.',
                            'The cake will be bake by Grandma this afternoon for the birthday party.',
                            'The cake will being baked by Grandma this afternoon for the birthday party.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek pasif 'The cake' memerlukan 'will be' diikuti bentuk V3 'baked'. Opsi B aktif ('akan memanggang').",
                    ],
                    [
                        'id' => 32,
                        'id_sentence' => 'Kamar tidurku akan dibersihkan sebelum tamu datang akhir pekan ini.',
                        'target_word' => 'will be cleaned (Future Passive)',
                        'vocab' => [
                            ['en' => 'my bedroom', 'id' => 'kamar tidurku'],
                            ['en' => 'cleaned', 'id' => 'dibersihkan'],
                            ['en' => 'before the guests arrive', 'id' => 'sebelum tamu datang'],
                        ],
                        'options' => [
                            'My bedroom will be cleaned before the guests arrive this weekend.',
                            'My bedroom will clean before the guests arrive this weekend.',
                            'My bedroom will be clean before the guests arrive this weekend.',
                            'My bedroom will being cleaned before the guests arrive this weekend.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Bentuk pasif masa depan yang tepat adalah 'will be cleaned' (will be + V3).",
                    ],
                    [
                        'id' => 33,
                        'id_sentence' => 'Sepeda baru itu akan dikirim ke rumah kami pekan depan.',
                        'target_word' => 'is going to be delivered (Future Passive with Be Going To)',
                        'vocab' => [
                            ['en' => 'the new bicycle', 'id' => 'sepeda baru itu'],
                            ['en' => 'delivered to our house', 'id' => 'dikirim ke rumah kami'],
                            ['en' => 'next week', 'id' => 'pekan depan'],
                        ],
                        'options' => [
                            'The new bicycle is going to be delivered to our house next week.',
                            'The new bicycle are going to be delivered to our house next week.',
                            'The new bicycle is going to be deliver to our house next week.',
                            'The new bicycle is going to being delivered to our house next week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The new bicycle' dipadukan dengan 'is going to be delivered' (is going to be + V3).",
                    ],
                    [
                        'id' => 34,
                        'id_sentence' => 'Hadiah ulang tahun itu akan diserahkan kepada pemenang di akhir acara.',
                        'target_word' => 'will be presented (Future Passive)',
                        'vocab' => [
                            ['en' => 'the birthday prize', 'id' => 'hadiah ulang tahun itu'],
                            ['en' => 'presented to the winner', 'id' => 'diserahkan kepada pemenang'],
                            ['en' => 'at the end of the event', 'id' => 'di akhir acara'],
                        ],
                        'options' => [
                            'The birthday prize will be presented to the winner at the end of the event.',
                            'The birthday prize will present to the winner at the end of the event.',
                            'The birthday prize will be present to the winner at the end of the event.',
                            'The birthday prize will being presented to the winner at the end of the event.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek 'The birthday prize' dikenai aksi penyerahan sehingga memerlukan 'will be presented'.",
                    ],
                    [
                        'id' => 35,
                        'id_sentence' => 'Aturan kelas yang baru akan diterapkan mulai minggu depan.',
                        'target_word' => 'will be applied (Future Passive)',
                        'vocab' => [
                            ['en' => 'the new classroom rules', 'id' => 'aturan kelas yang baru'],
                            ['en' => 'applied', 'id' => 'diterapkan'],
                            ['en' => 'starting next week', 'id' => 'mulai minggu depan'],
                        ],
                        'options' => [
                            'The new classroom rules will be applied starting next week.',
                            'The new classroom rules will apply starting next week.',
                            'The new classroom rules will be apply starting next week.',
                            'The new classroom rules are will be applied starting next week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will be applied' adalah pola pasif masa depan yang benar.",
                    ],
                    [
                        'id' => 36,
                        'id_sentence' => 'Uang tabungan kelas akan diperiksa oleh bendahara setiap akhir bulan.',
                        'target_word' => 'will be checked (Future Passive)',
                        'vocab' => [
                            ['en' => 'the class savings', 'id' => 'uang tabungan kelas'],
                            ['en' => 'checked by the treasurer', 'id' => 'diperiksa oleh bendahara'],
                        ],
                        'options' => [
                            'The class savings will be checked by the treasurer every month-end.',
                            'The class savings will check by the treasurer every month-end.',
                            'The class savings will be check by the treasurer every month-end.',
                            'The class savings is will be checked by the treasurer every month-end.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Bentuk pasif 'will be checked' (will be + V3).",
                    ],
                    [
                        'id' => 37,
                        'id_sentence' => 'Pos ronda baru akan dibangun di ujung jalan kompleks kami.',
                        'target_word' => 'is going to be built (Future Passive with Be Going To)',
                        'vocab' => [
                            ['en' => 'new neighborhood watch post', 'id' => 'pos ronda baru'],
                            ['en' => 'built', 'id' => 'dibangun'],
                            ['en' => 'at the end of our street', 'id' => 'di ujung jalan kompleks kami'],
                        ],
                        'options' => [
                            'A new neighborhood watch post is going to be built at the end of our street.',
                            'A new neighborhood watch post are going to be built at the end of our street.',
                            'A new neighborhood watch post is going to be build at the end of our street.',
                            'A new neighborhood watch post going to be built at the end of our street.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'post' mengambil pasif 'is going to be built'.",
                    ],
                    [
                        'id' => 38,
                        'id_sentence' => 'Hasil ujian akhir akan dinilai melalui dua kali pemeriksaan.',
                        'target_word' => 'will be graded (Future Passive)',
                        'vocab' => [
                            ['en' => 'final exam results', 'id' => 'hasil ujian akhir'],
                            ['en' => 'graded', 'id' => 'dinilai'],
                            ['en' => 'two rounds of checking', 'id' => 'dua kali pemeriksaan'],
                        ],
                        'options' => [
                            'Final exam results will be graded through two rounds of checking.',
                            'Final exam results will grade through two rounds of checking.',
                            'Final exam results will be grade through two rounds of checking.',
                            'Final exam results will being graded through two rounds of checking.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will be graded' menyajikan rencana pasif yang jelas.",
                    ],
                    [
                        'id' => 39,
                        'id_sentence' => 'Dana kas kelas tambahan akan dialokasikan untuk acara perpisahan.',
                        'target_word' => 'will be allocated (Future Passive)',
                        'vocab' => [
                            ['en' => 'extra class fund', 'id' => 'dana kas kelas tambahan'],
                            ['en' => 'allocated', 'id' => 'dialokasikan'],
                            ['en' => 'farewell event', 'id' => 'acara perpisahan'],
                        ],
                        'options' => [
                            'The extra class fund will be allocated for the farewell event.',
                            'The extra class fund will allocate for the farewell event.',
                            'The extra class fund will be allocate for the farewell event.',
                            'The extra class fund will being allocated for the farewell event.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek pasif 'fund' memerlukan 'will be allocated'.",
                    ],
                    [
                        'id' => 40,
                        'id_sentence' => 'Para peserta lomba akan diberitahu mengenai hasil penilaian melalui pesan singkat.',
                        'target_word' => 'will be notified (Future Passive)',
                        'vocab' => [
                            ['en' => 'competition participants', 'id' => 'peserta lomba'],
                            ['en' => 'notified', 'id' => 'diberitahu'],
                            ['en' => 'through a text message', 'id' => 'melalui pesan singkat'],
                        ],
                        'options' => [
                            'Competition participants will be notified of the results through a text message.',
                            'Competition participants will notify of the results through a text message.',
                            'Competition participants will be notify of the results through a text message.',
                            'Competition participants are will be notified of the results through a text message.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will be notified' (will be + V3) menyatakan bahwa peserta akan menerima pemberitahuan (pasif).",
                    ],
                ]
            ],
            [
                'id' => 'future-aspect-distinctions',
                'name' => "1.11.5 'Will' vs 'Be Going To' vs Present Continuous for Future Plans",
                'code' => '1.11.5',
                'concept_title' => "Nuansa Masa Depan: 'Will' vs 'Be Going To' vs Present Continuous",
                'concept_description' => "Kita perlu membedakan tiga cara menyatakan masa depan: (1) 'Will' untuk janji, keputusan spontan, dan prediksi umum tanpa bukti langsung; (2) 'Be Going To' untuk prediksi berbasis tanda/bukti nyata saat ini atau niat yang sudah dipikirkan; dan (3) 'Present Continuous' (is/are + V-ing) untuk acara atau janji yang sudah terjadwal pasti di kalender.",
                'description' => "Kita perlu membedakan tiga cara menyatakan masa depan: (1) 'Will' untuk janji, keputusan spontan, dan prediksi umum tanpa bukti langsung; (2) 'Be Going To' untuk prediksi berbasis tanda/bukti nyata saat ini atau niat yang sudah dipikirkan; dan (3) 'Present Continuous' (is/are + V-ing) untuk acara atau janji yang sudah terjadwal pasti di kalender.",
                'formula' => 'Will (Promises/Predictions) | Be Going To (Evidence/Intention) | Present Continuous (Scheduled Events)',
                'rules' => [
                    "Gunakan Present Continuous untuk jadwal pasti yang sudah punya tanggal/waktu tertentu ('We are meeting tomorrow at 10 AM').",
                    "Gunakan 'be going to' bila ada bukti nyata saat ini yang mengindikasikan hasil ('Look at the sky, it is going to rain').",
                    "Gunakan 'will' untuk janji, keputusan spontan, atau prediksi umum ('This will make you happy').",
                    "Hindari penggunaan 'will' pada anak kalimat penunjuk waktu (Time Clauses: when, as soon as, before).",
                ],
                'exercises' => [
                    [
                        'id' => 41,
                        'id_sentence' => 'Sekolah mengadakan acara pentas seni pada hari Senin depan di aula utama.',
                        'target_word' => 'is holding next Monday (Present Continuous for Fixed Arrangement)',
                        'vocab' => [
                            ['en' => 'school', 'id' => 'sekolah'],
                            ['en' => 'talent show', 'id' => 'acara pentas seni'],
                            ['en' => 'main hall', 'id' => 'aula utama'],
                        ],
                        'options' => [
                            'The school is holding the talent show next Monday in the main hall.',
                            'The school will to hold the talent show next Monday in the main hall.',
                            'The school is going to held the talent show next Monday in the main hall.',
                            'The school holds will the talent show next Monday in the main hall.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Untuk agenda terjadwal pasti dengan waktu dan lokasi tertentu ('next Monday in the main hall'), Present Continuous ('is holding') adalah ekspresi yang paling alami.",
                    ],
                    [
                        'id' => 42,
                        'id_sentence' => 'Jika kamu belajar dengan rajin, nilai ujianmu akan meningkat.',
                        'target_word' => 'will improve (Conditional Future Consequence)',
                        'vocab' => [
                            ['en' => 'study hard', 'id' => 'belajar dengan rajin'],
                            ['en' => 'exam score', 'id' => 'nilai ujian'],
                            ['en' => 'improve', 'id' => 'meningkat'],
                        ],
                        'options' => [
                            'If you study hard, your exam score will improve.',
                            'If you study hard, your exam score is improving next week.',
                            'If you study hard, your exam score will improves.',
                            'If you study hard, your exam score is going to improved.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Konsekuensi logis masa depan dalam klausa pengandaian (First Conditional) wajib menggunakan modal 'will + V1' ('will improve').",
                    ],
                    [
                        'id' => 43,
                        'id_sentence' => 'Melihat langit yang semakin gelap, sepertinya hujan akan turun sore ini.',
                        'target_word' => 'is going to fall (Evidence-Based Prediction)',
                        'vocab' => [
                            ['en' => 'darkening sky', 'id' => 'langit yang semakin gelap'],
                            ['en' => 'rain', 'id' => 'hujan'],
                            ['en' => 'fall this afternoon', 'id' => 'turun sore ini'],
                        ],
                        'options' => [
                            'Looking at the darkening sky, rain is going to fall this afternoon.',
                            'Looking at the darkening sky, rain will falling this afternoon.',
                            'Looking at the darkening sky, rain is going to fallen this afternoon.',
                            'Looking at the darkening sky, rain falls will this afternoon.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Prediksi yang didasarkan pada bukti nyata saat ini ('the darkening sky') paling tepat menggunakan 'is going to fall'.",
                    ],
                    [
                        'id' => 44,
                        'id_sentence' => 'Panitia mengumumkan daftar pemenang lomba menggambar pada tanggal lima belas.',
                        'target_word' => 'is announcing on the 15th (Scheduled Arrangement)',
                        'vocab' => [
                            ['en' => 'committee', 'id' => 'panitia'],
                            ['en' => 'drawing competition winners', 'id' => 'pemenang lomba menggambar'],
                            ['en' => 'on the 15th', 'id' => 'pada tanggal 15'],
                        ],
                        'options' => [
                            'The committee is announcing the drawing competition winners on the 15th.',
                            'The committee will to announce the drawing competition winners on the 15th.',
                            'The committee is going to announced the drawing competition winners on the 15th.',
                            'The committee announcing will the drawing competition winners on the 15th.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Jadwal pengumuman resmi ('on the 15th') secara efektif dinyatakan dengan Present Continuous 'is announcing'.",
                    ],
                    [
                        'id' => 45,
                        'id_sentence' => 'Kami berjanji bahwa rahasiamu akan tetap aman bersama kami.',
                        'target_word' => 'will remain (Formal Promise)',
                        'vocab' => [
                            ['en' => 'promise', 'id' => 'berjanji'],
                            ['en' => 'your secret', 'id' => 'rahasiamu'],
                            ['en' => 'remain safe', 'id' => 'tetap aman'],
                        ],
                        'options' => [
                            'We promise that your secret will remain safe with us.',
                            'We promise that your secret are remaining safe with us.',
                            'We promise that your secret will to remain safe with us.',
                            'We promise that your secret is going to remaining safe with us.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Janji formal (promise, guarantee) selalu menggunakan 'will + V1' ('will remain').",
                    ],
                    [
                        'id' => 46,
                        'id_sentence' => 'Grafik nilai menunjukkan bahwa rata-rata kelas akan melampaui target tahun ini.',
                        'target_word' => 'is going to exceed (Chart Evidence)',
                        'vocab' => [
                            ['en' => 'the score chart shows', 'id' => 'grafik nilai menunjukkan'],
                            ['en' => 'class average', 'id' => 'rata-rata kelas'],
                            ['en' => 'exceed the target', 'id' => 'melampaui target'],
                        ],
                        'options' => [
                            'The score chart shows that the class average is going to exceed the target this year.',
                            'The score chart shows that the class average are going to exceed the target this year.',
                            'The score chart shows that the class average is going to exceeding the target this year.',
                            'The score chart shows that the class average will to exceed the target this year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Data tren visual yang terlihat ('the score chart shows') lazim dilaporkan dengan 'is going to exceed' (subjek tunggal 'average').",
                    ],
                    [
                        'id' => 47,
                        'id_sentence' => 'Pak Guru memimpin rombongan karyawisata ke kebun binatang hari Kamis ini.',
                        'target_word' => 'is leading on Thursday (Definite Trip Arrangement)',
                        'vocab' => [
                            ['en' => 'lead the field trip group', 'id' => 'memimpin rombongan karyawisata'],
                            ['en' => 'this Thursday', 'id' => 'hari Kamis ini'],
                        ],
                        'options' => [
                            'Mr. Guru is leading the field trip group to the zoo this coming Thursday.',
                            'Mr. Guru will to lead the field trip group to the zoo this coming Thursday.',
                            'Mr. Guru is going to led the field trip group to the zoo this coming Thursday.',
                            'Mr. Guru will leading the field trip group to the zoo this coming Thursday.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Rencana perjalanan dengan tanggal pasti ('this coming Thursday') diekspresikan dengan Present Continuous 'is leading'.",
                    ],
                    [
                        'id' => 48,
                        'id_sentence' => 'Berolahraga setiap pagi akan membuat tubuhmu lebih bugar.',
                        'target_word' => 'will make (General Prediction)',
                        'vocab' => [
                            ['en' => 'exercising every morning', 'id' => 'berolahraga setiap pagi'],
                            ['en' => 'make your body fitter', 'id' => 'membuat tubuhmu lebih bugar'],
                        ],
                        'options' => [
                            'Exercising every morning will make your body fitter.',
                            'Exercising every morning will makes your body fitter.',
                            'Exercising every morning is making your body fitter next week.',
                            'Exercising every morning will to make your body fitter.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Prediksi umum tentang manfaat suatu kebiasaan diungkapkan dengan modal 'will make'.",
                    ],
                    [
                        'id' => 49,
                        'id_sentence' => 'Melihat antrean yang semakin panjang, kasir akan membuka loket tambahan.',
                        'target_word' => 'is going to open (Evidence-Based Action)',
                        'vocab' => [
                            ['en' => 'the growing queue', 'id' => 'antrean yang semakin panjang'],
                            ['en' => 'cashier', 'id' => 'kasir'],
                            ['en' => 'open an extra counter', 'id' => 'membuka loket tambahan'],
                        ],
                        'options' => [
                            'Judging by the growing queue, the cashier is going to open an extra counter.',
                            'Judging by the growing queue, the cashier are going to open an extra counter.',
                            'Judging by the growing queue, the cashier is going to opening an extra counter.',
                            'Judging by the growing queue, the cashier will to open an extra counter.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Tindakan yang didasari bukti nyata ('Judging by the growing queue...') menggunakan 'is going to open'.",
                    ],
                    [
                        'id' => 50,
                        'id_sentence' => 'Teman-teman sekelas menandatangani kartu ucapan untuk wali kelas besok pagi.',
                        'target_word' => 'are signing tomorrow (Scheduled Class Activity)',
                        'vocab' => [
                            ['en' => 'classmates', 'id' => 'teman-teman sekelas'],
                            ['en' => 'greeting card', 'id' => 'kartu ucapan'],
                            ['en' => 'homeroom teacher', 'id' => 'wali kelas'],
                        ],
                        'options' => [
                            'Classmates are signing the greeting card for the homeroom teacher tomorrow morning.',
                            'Classmates will to sign the greeting card for the homeroom teacher tomorrow morning.',
                            'Classmates are going to signed the greeting card for the homeroom teacher tomorrow morning.',
                            'Classmates will signing the greeting card for the homeroom teacher tomorrow morning.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Jadwal kegiatan kelas yang sudah ditetapkan ('tomorrow morning') memakai Present Continuous 'are signing'.",
                    ],
                ]
            ],
            [
                'id' => 'future-negative-interrogative',
                'name' => '1.11.6 Simple Future Negative & Interrogative: Denying Plans & Asking About the Future',
                'code' => '1.11.6',
                'concept_title' => 'Simple Future Negatif & Interogatif: Menyangkal Rencana & Bertanya Tentang Masa Depan',
                'concept_description' => "Bentuk negatif Simple Future ('will not' / 'is/are not going to') digunakan untuk menyangkal suatu rencana atau menolak melakukan sesuatu di masa depan. Bentuk interogatif ('Will + Subject + V1...?' atau 'Is/Are + Subject + going to...?') digunakan untuk menanyakan rencana atau prediksi orang lain.",
                'description' => "Bentuk negatif Simple Future ('will not' / 'is/are not going to') digunakan untuk menyangkal suatu rencana atau menolak melakukan sesuatu di masa depan. Bentuk interogatif ('Will + Subject + V1...?' atau 'Is/Are + Subject + going to...?') digunakan untuk menanyakan rencana atau prediksi orang lain.",
                'formula' => 'Negative: Subject + will NOT + V1 / be Adj/V3 | Interrogative: Will + Subject + V1 / be V3?',
                'rules' => [
                    "Bentuk negatif: 'will not + V1' atau 'will not be + V3/Adj'. Boleh disingkat 'won't' dalam percakapan santai.",
                    "Untuk bentuk 'be going to' negatif: 'is/are not going to + V1'.",
                    "Kalimat tanya dimulai dengan modal 'Will' atau to be 'Is/Are' diikuti subjek dan verba bentuk dasar.",
                    'Dilarang menggunakan do/does not sebelum will (*does not will come adalah SALAH).',
                ],
                'exercises' => [
                    [
                        'id' => 51,
                        'id_sentence' => 'Resep masakan baru ini tidak akan membuat dapur menjadi berantakan.',
                        'target_word' => 'will not make (Negative Verbal with Will)',
                        'vocab' => [
                            ['en' => 'new recipe', 'id' => 'resep masakan baru'],
                            ['en' => 'make a mess', 'id' => 'membuat berantakan'],
                        ],
                        'options' => [
                            'This new recipe will not make the kitchen messy.',
                            'This new recipe will not makes the kitchen messy.',
                            'This new recipe does not will make the kitchen messy.',
                            'This new recipe will not to make the kitchen messy.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Bentuk negatif modal adalah 'will not' diikuti kata kerja dasar murni 'make'.",
                    ],
                    [
                        'id' => 52,
                        'id_sentence' => 'Mainan itu tidak akan disimpan di luar ruangan agar tidak rusak karena hujan.',
                        'target_word' => 'will not be stored (Negative Passive)',
                        'vocab' => [
                            ['en' => 'the toys', 'id' => 'mainan itu'],
                            ['en' => 'stored outdoors', 'id' => 'disimpan di luar ruangan'],
                            ['en' => 'damaged by rain', 'id' => 'rusak karena hujan'],
                        ],
                        'options' => [
                            'The toys will not be stored outdoors so they are not damaged by rain.',
                            'The toys will not stored outdoors so they are not damaged by rain.',
                            'The toys will not be store outdoors so they are not damaged by rain.',
                            'The toys do not will be stored outdoors so they are not damaged by rain.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pola pasif negatif masa depan adalah 'will not be' + V3 'stored'.",
                    ],
                    [
                        'id' => 53,
                        'id_sentence' => 'Apakah tim sepak bola sekolah kita akan mengalahkan tim dari sekolah sebelah?',
                        'target_word' => 'Will ... beat (Interrogative Verbal)',
                        'vocab' => [
                            ['en' => "our school's football team", 'id' => 'tim sepak bola sekolah kita'],
                            ['en' => 'beat', 'id' => 'mengalahkan'],
                            ['en' => 'the team from the other school', 'id' => 'tim dari sekolah sebelah'],
                        ],
                        'options' => [
                            "Will our school's football team beat the team from the other school?",
                            "Will our school's football team beats the team from the other school?",
                            "Does our school's football team will beat the team from the other school?",
                            "Will our school's football team to beat the team from the other school?",
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pertanyaan masa depan diawali 'Will' + Subject + V1 'beat'.",
                    ],
                    [
                        'id' => 54,
                        'id_sentence' => 'Kenaikan harga yang kecil ini tidak akan menghalangi kami untuk tetap berbelanja di sini.',
                        'target_word' => 'will not stop (Negative Verbal)',
                        'vocab' => [
                            ['en' => 'this small price increase', 'id' => 'kenaikan harga yang kecil ini'],
                            ['en' => 'stop us from shopping here', 'id' => 'menghalangi kami berbelanja di sini'],
                        ],
                        'options' => [
                            'This small price increase will not stop us from shopping here.',
                            'This small price increase will not stops us from shopping here.',
                            'This small price increase does not will stop us from shopping here.',
                            'This small price increase will not to stop us from shopping here.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'will not stop' memaparkan penyangkalan dampak secara lugas.",
                    ],
                    [
                        'id' => 55,
                        'id_sentence' => 'Apakah acara kelas akan diadakan di halaman sekolah atau di aula?',
                        'target_word' => 'Will ... be held (Interrogative Passive)',
                        'vocab' => [
                            ['en' => 'class event', 'id' => 'acara kelas'],
                            ['en' => 'held', 'id' => 'diadakan'],
                            ['en' => 'school yard or the hall', 'id' => 'halaman sekolah atau aula'],
                        ],
                        'options' => [
                            'Will the class event be held in the school yard or the hall?',
                            'Will the class event hold in the school yard or the hall?',
                            'Will the class event be hold in the school yard or the hall?',
                            'Is the class event will be held in the school yard or the hall?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pertanyaan pasif masa depan menggunakan struktur: 'Will' + Subject + 'be' + V3 ('be held').",
                    ],
                    [
                        'id' => 56,
                        'id_sentence' => 'Sekolah kami tidak akan mengurangi jam istirahat tahun ajaran depan.',
                        'target_word' => 'is not going to reduce (Negative with Be Going To)',
                        'vocab' => [
                            ['en' => 'our school', 'id' => 'sekolah kami'],
                            ['en' => 'reduce break time', 'id' => 'mengurangi jam istirahat'],
                            ['en' => 'next school year', 'id' => 'tahun ajaran depan'],
                        ],
                        'options' => [
                            'Our school is not going to reduce break time next school year.',
                            'Our school are not going to reduce break time next school year.',
                            'Our school is not going to reducing break time next school year.',
                            'Our school not is going to reduce break time next school year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'Our school' berpasangan dengan 'is not going to reduce'.",
                    ],
                    [
                        'id' => 57,
                        'id_sentence' => 'Apakah musim kemarau tahun ini akan mengubah jadwal tanam para petani?',
                        'target_word' => 'Will ... change (Interrogative Verbal)',
                        'vocab' => [
                            ['en' => "this year's dry season", 'id' => 'musim kemarau tahun ini'],
                            ['en' => "change the farmers' planting schedule", 'id' => 'mengubah jadwal tanam petani'],
                        ],
                        'options' => [
                            "Will this year's dry season change the farmers' planting schedule?",
                            "Will this year's dry season changes the farmers' planting schedule?",
                            "Does this year's dry season will change the farmers' planting schedule?",
                            "Will this year's dry season to change the farmers' planting schedule?",
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Will' diletakkan di depan subjek 'this year's dry season' dan diikuti V1 'change'.",
                    ],
                    [
                        'id' => 58,
                        'id_sentence' => 'Nomor telepon pribadi siswa tidak akan dibagikan kepada pihak luar tanpa izin orang tua.',
                        'target_word' => 'will not be shared (Negative Passive)',
                        'vocab' => [
                            ["en" => "students' personal phone numbers", "id" => "nomor telepon pribadi siswa"],
                            ['en' => 'shared with outsiders', 'id' => 'dibagikan kepada pihak luar'],
                            ["en" => "parents' permission", "id" => "izin orang tua"],
                        ],
                        'options' => [
                            "Students' personal phone numbers will not be shared with outsiders without parents' permission.",
                            "Students' personal phone numbers will not shared with outsiders without parents' permission.",
                            "Students' personal phone numbers will not be share with outsiders without parents' permission.",
                            "Students' personal phone numbers do not will be shared with outsiders without parents' permission.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pola pasif negatif 'will not be shared' (will not be + V3).",
                    ],
                    [
                        'id' => 59,
                        'id_sentence' => 'Buku pelajaran lama tidak akan dipakai lagi setelah kurikulum baru diterapkan.',
                        'target_word' => 'are not going to be used (Negative Passive with Be Going To)',
                        'vocab' => [
                            ['en' => 'old textbooks', 'id' => 'buku pelajaran lama'],
                            ['en' => 'used', 'id' => 'dipakai'],
                            ['en' => 'new curriculum', 'id' => 'kurikulum baru'],
                        ],
                        'options' => [
                            'Old textbooks are not going to be used once the new curriculum is applied.',
                            'Old textbooks is not going to be used once the new curriculum is applied.',
                            'Old textbooks are not going to be use once the new curriculum is applied.',
                            'Old textbooks are not going to used once the new curriculum is applied.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'textbooks' memakai 'are not going to be used'.",
                    ],
                    [
                        'id' => 60,
                        'id_sentence' => 'Apakah resep baru ini akan memberikan rasa yang lebih enak dari sebelumnya?',
                        'target_word' => 'Will ... give (Interrogative Verbal)',
                        'vocab' => [
                            ['en' => 'this new recipe', 'id' => 'resep baru ini'],
                            ['en' => 'tastier flavor', 'id' => 'rasa yang lebih enak'],
                            ['en' => 'than before', 'id' => 'dari sebelumnya'],
                        ],
                        'options' => [
                            'Will this new recipe give a tastier flavor than before?',
                            'Will this new recipe gives a tastier flavor than before?',
                            'Does this new recipe will give a tastier flavor than before?',
                            'Will this new recipe to give a tastier flavor than before?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Will' + Subject ('this new recipe') + V1 ('give').",
                    ],
                ]
            ],
            [
                'id' => 'future-time-clauses',
                'name' => "1.11.7 Future Time Clauses: The 'No Future in Time Clauses' Rule",
                'code' => '1.11.7',
                'concept_title' => "Klausa Waktu Masa Depan: Aturan Larangan 'Will' dalam Time Clauses",
                'concept_description' => "Salah satu aturan penting dalam Bahasa Inggris adalah: anak kalimat yang diawali konjungsi waktu (when, as soon as, once, after, before, until) atau syarat (if, unless) DILARANG menggunakan kata kerja masa depan ('will' atau 'be going to'). Anak kalimat tersebut WAJIB menggunakan Simple Present Tense (V1/V-s), meskipun maknanya merujuk ke masa depan. Bentuk Simple Future ('will') hanya diletakkan pada induk kalimat (Main Clause).",
                'description' => "Salah satu aturan penting dalam Bahasa Inggris adalah: anak kalimat yang diawali konjungsi waktu (when, as soon as, once, after, before, until) atau syarat (if, unless) DILARANG menggunakan kata kerja masa depan ('will' atau 'be going to'). Anak kalimat tersebut WAJIB menggunakan Simple Present Tense (V1/V-s), meskipun maknanya merujuk ke masa depan. Bentuk Simple Future ('will') hanya diletakkan pada induk kalimat (Main Clause).",
                'formula' => 'Time Conjunction (When/Once/As soon as) + Subject + Verb 1/V-s (Simple Present), Subject + will + V1',
                'rules' => [
                    "Dilarang menggunakan 'will' dalam klausa yang diawali: when, as soon as, once, after, before, until, if, unless (*When it will stop raining adalah KESALAHAN).",
                    'Gunakan Simple Present (V1 atau V-s) di dalam anak kalimat waktu.',
                    "Gunakan 'will + V1' atau 'will be + V3' di dalam induk kalimat (Main Clause).",
                    'Jika anak kalimat diletakkan di awal, wajib dipisahkan dengan tanda koma sebelum induk kalimat.',
                ],
                'exercises' => [
                    [
                        'id' => 61,
                        'id_sentence' => 'Ketika hujan berhenti, kami akan pergi bermain di taman.',
                        'target_word' => 'stops ... will go (Time Clause Rule)',
                        'vocab' => [
                            ['en' => 'rain stops', 'id' => 'hujan berhenti'],
                            ['en' => 'go play in the park', 'id' => 'pergi bermain di taman'],
                        ],
                        'options' => [
                            'When it stops raining, we will go play in the park.',
                            'When it will stop raining, we will go play in the park.',
                            'When it stops raining, we go will play in the park.',
                            'When it is going to stop raining, we will go play in the park.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa waktu yang diawali 'When' wajib menggunakan Simple Present ('stops'), bukan 'will stop'. Modal 'will' hanya ada pada induk kalimat ('will go').",
                    ],
                    [
                        'id' => 62,
                        'id_sentence' => 'Segera setelah PR selesai dikerjakan, kami akan menonton film bersama.',
                        'target_word' => 'is finished ... will watch (Passive Time Clause)',
                        'vocab' => [
                            ['en' => 'as soon as', 'id' => 'segera setelah'],
                            ['en' => 'homework is finished', 'id' => 'PR selesai dikerjakan'],
                            ['en' => 'watch a movie together', 'id' => 'menonton film bersama'],
                        ],
                        'options' => [
                            'As soon as the homework is finished, we will watch a movie together.',
                            'As soon as the homework will be finished, we will watch a movie together.',
                            'As soon as the homework is finished, we watch will a movie together.',
                            'As soon as the homework will finish, we will watch a movie together.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Setelah konjungsi 'As soon as', gunakan Simple Present Pasif ('is finished'), bukan 'will be finished'.",
                    ],
                    [
                        'id' => 63,
                        'id_sentence' => 'Setelah Ibu menyetujui rencana itu, kami akan mulai mempersiapkan pesta.',
                        'target_word' => 'approves ... will start (Time Clause Rule)',
                        'vocab' => [
                            ['en' => 'Mom approves', 'id' => 'Ibu menyetujui'],
                            ['en' => 'the plan', 'id' => 'rencana itu'],
                            ['en' => 'start preparing the party', 'id' => 'mulai mempersiapkan pesta'],
                        ],
                        'options' => [
                            'Once Mom approves the plan, we will start preparing the party.',
                            'Once Mom will approve the plan, we will start preparing the party.',
                            'Once Mom approves the plan, we start will preparing the party.',
                            'Once Mom will approves the plan, we will start preparing the party.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa waktu 'Once...' wajib memakai Simple Present 'approves'. Induk kalimat memakai 'will start'.",
                    ],
                    [
                        'id' => 64,
                        'id_sentence' => 'Ayah tidak akan mengizinkan kami pergi sebelum tugas rumah selesai dikerjakan.',
                        'target_word' => 'will not allow ... is finished (Before Time Clause)',
                        'vocab' => [
                            ['en' => 'allow us to go', 'id' => 'mengizinkan kami pergi'],
                            ['en' => 'chores are finished', 'id' => 'tugas rumah selesai'],
                        ],
                        'options' => [
                            'Dad will not allow us to go before the chores are finished.',
                            'Dad will not allow us to go before the chores will be finished.',
                            'Dad does not allow us to go before the chores will be finished.',
                            'Dad will not to allow us to go before the chores are finished.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Setelah konjungsi 'before', kata kerja wajib Simple Present 'are finished' (subjek jamak 'chores').",
                    ],
                    [
                        'id' => 65,
                        'id_sentence' => 'Jika kue ini terbukti enak, resepnya akan dibagikan kepada semua tetangga.',
                        'target_word' => 'proves ... will be shared (Conditional + Passive Future)',
                        'vocab' => [
                            ['en' => 'proves delicious', 'id' => 'terbukti enak'],
                            ['en' => 'shared with all the neighbors', 'id' => 'dibagikan kepada semua tetangga'],
                        ],
                        'options' => [
                            'If this cake proves delicious, the recipe will be shared with all the neighbors.',
                            'If this cake will prove delicious, the recipe will be shared with all the neighbors.',
                            'If this cake proves delicious, the recipe will shared with all the neighbors.',
                            'If this cake is will prove delicious, the recipe will be shared with all the neighbors.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa 'If' menggunakan Simple Present 'proves', sedangkan induk kalimat menggunakan pasif masa depan 'will be shared'.",
                    ],
                    [
                        'id' => 66,
                        'id_sentence' => 'Kecuali jika izin orang tua diperoleh minggu ini, karyawisata akan dibatalkan sementara.',
                        'target_word' => 'is obtained ... will be canceled (Unless Clause)',
                        'vocab' => [
                            ["en" => "unless parents' permission is obtained", "id" => "kecuali izin orang tua diperoleh"],
                            ['en' => 'field trip', 'id' => 'karyawisata'],
                            ['en' => 'canceled', 'id' => 'dibatalkan'],
                        ],
                        'options' => [
                            "Unless parents' permission is obtained this week, the field trip will be canceled temporarily.",
                            "Unless parents' permission will be obtained this week, the field trip will be canceled temporarily.",
                            "Unless parents' permission is obtained this week, the field trip is canceled will temporarily.",
                            "Unless parents' permission will obtain this week, the field trip will be canceled temporarily.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa 'Unless' menggunakan Simple Present Pasif 'is obtained'. Induk kalimat menggunakan 'will be canceled'.",
                    ],
                    [
                        'id' => 67,
                        'id_sentence' => 'Setelah adik-adik mengenali semua huruf, mereka akan mulai belajar membaca kata.',
                        'target_word' => 'recognize ... will start (After Time Clause)',
                        'vocab' => [
                            ['en' => 'my younger siblings recognize', 'id' => 'adik-adik mengenali'],
                            ['en' => 'all the letters', 'id' => 'semua huruf'],
                            ['en' => 'start reading words', 'id' => 'mulai belajar membaca kata'],
                        ],
                        'options' => [
                            'After my younger siblings recognize all the letters, they will start reading words.',
                            'After my younger siblings will recognize all the letters, they will start reading words.',
                            'After my younger siblings recognize all the letters, they start will reading words.',
                            'After my younger siblings will to recognize all the letters, they will start reading words.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Setelah 'After', gunakan Simple Present 'recognize' (subjek jamak 'siblings').",
                    ],
                    [
                        'id' => 68,
                        'id_sentence' => 'Kami akan menunda jalan-jalan sampai cuaca kembali cerah.',
                        'target_word' => 'will postpone ... returns (Until Time Clause)',
                        'vocab' => [
                            ['en' => 'our walk', 'id' => 'jalan-jalan kami'],
                            ['en' => 'weather returns to sunny', 'id' => 'cuaca kembali cerah'],
                        ],
                        'options' => [
                            'We will postpone our walk until the weather returns to sunny.',
                            'We will postpone our walk until the weather will return to sunny.',
                            'We postpone will our walk until the weather returns to sunny.',
                            'We will to postpone our walk until the weather returns to sunny.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa setelah 'until' wajib menggunakan Simple Present tunggal 'returns', bukan 'will return'.",
                    ],
                    [
                        'id' => 69,
                        'id_sentence' => 'Begitu kue selesai dipanggang, kita akan langsung menghiasnya.',
                        'target_word' => 'is baked ... will decorate (As soon as Time Clause)',
                        'vocab' => [
                            ['en' => 'cake is baked', 'id' => 'kue selesai dipanggang'],
                            ['en' => 'decorate it right away', 'id' => 'langsung menghiasnya'],
                        ],
                        'options' => [
                            'As soon as the cake is baked, we will decorate it right away.',
                            'As soon as the cake will be baked, we will decorate it right away.',
                            'As soon as the cake is baked, we decorate will it right away.',
                            'As soon as the cake will bake, we will decorate it right away.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'As soon as' + Simple Present Pasif tunggal 'is baked', diikuti induk kalimat 'will decorate'.",
                    ],
                    [
                        'id' => 70,
                        'id_sentence' => 'Jika kamu rajin berlatih setiap hari, kemampuan bermain gitarmu akan meningkat pesat.',
                        'target_word' => 'practice ... will improve (Conditional Clause)',
                        'vocab' => [
                            ['en' => 'practice diligently every day', 'id' => 'rajin berlatih setiap hari'],
                            ['en' => 'your guitar skills', 'id' => 'kemampuan bermain gitarmu'],
                            ['en' => 'improve rapidly', 'id' => 'meningkat pesat'],
                        ],
                        'options' => [
                            'If you practice diligently every day, your guitar skills will improve rapidly.',
                            'If you will practice diligently every day, your guitar skills will improve rapidly.',
                            'If you practice diligently every day, your guitar skills improve will rapidly.',
                            'If you are going to practice diligently every day, your guitar skills will improve rapidly.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa 'If' menggunakan Simple Present 'practice', dan induk kalimat menggunakan 'will improve'.",
                    ],
                ]
            ],
            [
                'id' => 'future-weekend-roadmap-synthesis',
                'name' => '1.11.8 Comprehensive Synthesis: Planning a Weekend Family Event',
                'code' => '1.11.8',
                'concept_title' => 'Sintesis Komprehensif: Merencanakan Acara Keluarga Akhir Pekan',
                'concept_description' => "Menggabungkan seluruh variasi Simple Future (aktif 'will', bukti 'be going to', bentuk nominal, bentuk pasif, dan aturan klausa waktu) ke dalam cerita sehari-hari yang runtut, seperti merencanakan acara keluarga, pesta ulang tahun, atau kegiatan akhir pekan.",
                'description' => "Menggabungkan seluruh variasi Simple Future (aktif 'will', bukti 'be going to', bentuk nominal, bentuk pasif, dan aturan klausa waktu) ke dalam cerita sehari-hari yang runtut, seperti merencanakan acara keluarga, pesta ulang tahun, atau kegiatan akhir pekan.",
                'formula' => 'Synthesized Everyday Future Narrative: Time/Condition Clause + Passive Future Plan + Direct Projection',
                'rules' => [
                    "Gunakan Simple Present dalam anak kalimat bersyarat/waktu ('Once the guests arrive...').",
                    "Gunakan Future Passive untuk hal yang sudah direncanakan ('...the food will be prepared').",
                    "Gunakan Future Active untuk akibat langsung ('...which will make everyone happy').",
                    'Jaga konsistensi logika waktu dan keselarasan subjek-verba di seluruh kalimat majemuk.',
                ],
                'exercises' => [
                    [
                        'id' => 71,
                        'id_sentence' => 'Begitu semua tamu tiba, makanan akan dihidangkan, yang akan membuat semua orang senang.',
                        'target_word' => 'arrive ... will be served ... will make (Everyday Event Synthesis)',
                        'vocab' => [
                            ['en' => 'all the guests arrive', 'id' => 'semua tamu tiba'],
                            ['en' => 'the food will be served', 'id' => 'makanan akan dihidangkan'],
                            ['en' => 'will make everyone happy', 'id' => 'akan membuat semua orang senang'],
                        ],
                        'options' => [
                            'Once all the guests arrive, the food will be served, which will make everyone happy.',
                            'Once all the guests will arrive, the food will be served, which will make everyone happy.',
                            'Once all the guests arrive, the food will serve, which will make everyone happy.',
                            'Once all the guests will arrive, the food will serve, which will make everyone happy.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa 'Once' menggunakan Simple Present 'arrive'. Induk kalimat menggunakan Future Pasif 'will be served', dilanjutkan relative clause aktif 'which will make'.",
                    ],
                    [
                        'id' => 72,
                        'id_sentence' => 'Jika cuaca tetap cerah, kita akan makan di halaman, dan suasananya akan menjadi lebih meriah.',
                        'target_word' => 'stays ... will eat ... will be (Conditional Future Synthesis)',
                        'vocab' => [
                            ['en' => 'weather stays sunny', 'id' => 'cuaca tetap cerah'],
                            ['en' => 'we will eat in the yard', 'id' => 'kita akan makan di halaman'],
                            ['en' => 'will be livelier', 'id' => 'akan menjadi lebih meriah'],
                        ],
                        'options' => [
                            'If the weather stays sunny, we will eat in the yard, and the mood will be livelier.',
                            'If the weather will stay sunny, we will eat in the yard, and the mood will be livelier.',
                            'If the weather stays sunny, we will eats in the yard, and the mood will are livelier.',
                            'If the weather stays sunny, we will eat in the yard, and the mood will being livelier.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa syarat memakai Simple Present 'stays', diikuti dua klausa masa depan: aktif 'will eat' dan nominal 'will be livelier'.",
                    ],
                    [
                        'id' => 73,
                        'id_sentence' => 'Ibu memperkirakan bahwa kue tiga susun itu akan siap sebelum tamu pertama datang.',
                        'target_word' => 'will be ready (Future Nominal Projection)',
                        'vocab' => [
                            ['en' => 'Mom anticipates', 'id' => 'Ibu memperkirakan'],
                            ['en' => 'three-tier cake', 'id' => 'kue tiga susun'],
                            ['en' => 'ready before the first guest arrives', 'id' => 'siap sebelum tamu pertama datang'],
                        ],
                        'options' => [
                            'Mom anticipates that the three-tier cake will be ready before the first guest arrives.',
                            'Mom anticipates that the three-tier cake will ready before the first guest arrives.',
                            'Mom anticipates that the three-tier cake will are ready before the first guest arrives.',
                            'Mom anticipates that the three-tier cake will to be ready before the first guest arrives.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Diperlukan 'will be ready' sebelum adjective 'ready'.",
                    ],
                    [
                        'id' => 74,
                        'id_sentence' => 'Sebelum acara dimulai, semua kursi akan ditata ulang secara rapi oleh panitia.',
                        'target_word' => 'begins ... will be rearranged (Time Clause with Passive Main)',
                        'vocab' => [
                            ['en' => 'event begins', 'id' => 'acara dimulai'],
                            ['en' => 'all the chairs', 'id' => 'semua kursi'],
                            ['en' => 'rearranged neatly', 'id' => 'ditata ulang secara rapi'],
                        ],
                        'options' => [
                            'Before the event begins, all the chairs will be rearranged neatly by the committee.',
                            'Before the event will begin, all the chairs will be rearranged neatly by the committee.',
                            'Before the event begins, all the chairs will rearrange neatly by the committee.',
                            'Before the event will begins, all the chairs will being rearranged neatly by the committee.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Before' + Simple Present tunggal 'begins', disusul Future Pasif 'will be rearranged'.",
                    ],
                    [
                        'id' => 75,
                        'id_sentence' => 'Karena langit tampak mendung, tenda cadangan akan dipasang untuk berjaga-jaga.',
                        'target_word' => 'is going to be set up (Evidence-Based Passive)',
                        'vocab' => [
                            ['en' => 'sky looks cloudy', 'id' => 'langit tampak mendung'],
                            ['en' => 'backup tent', 'id' => 'tenda cadangan'],
                            ['en' => 'set up just in case', 'id' => 'dipasang untuk berjaga-jaga'],
                        ],
                        'options' => [
                            'Because the sky looks cloudy, a backup tent is going to be set up just in case.',
                            'Because the sky looks cloudy, a backup tent are going to be set up just in case.',
                            'Because the sky looks cloudy, a backup tent is going to be setting up just in case.',
                            'Because the sky looks cloudy, a backup tent going to be set up just in case.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Keputusan berbasis bukti nyata yang terlihat ('the sky looks cloudy') menggunakan pasif tunggal 'is going to be set up'.",
                    ],
                    [
                        'id' => 76,
                        'id_sentence' => 'Ketika musik mulai diputar, para tamu akan segera menari, yang akan membuat suasana makin seru.',
                        'target_word' => 'starts ... will dance ... will make (Event Multi-Clause)',
                        'vocab' => [
                            ['en' => 'music starts playing', 'id' => 'musik mulai diputar'],
                            ['en' => 'guests will dance', 'id' => 'tamu akan menari'],
                            ['en' => 'will make the mood more exciting', 'id' => 'akan membuat suasana makin seru'],
                        ],
                        'options' => [
                            'When the music starts playing, the guests will dance, which will make the mood more exciting.',
                            'When the music will start playing, the guests will dance, which will make the mood more exciting.',
                            'When the music starts playing, the guests will dances, which will make the mood more exciting.',
                            'When the music starts playing, the guests will dance, which making will the mood more exciting.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa 'When' menggunakan Simple Present Pasif 'starts', induk kalimat memakai 'will dance', dan relative clause hasil memakai 'which will make'.",
                    ],
                    [
                        'id' => 77,
                        'id_sentence' => 'Meskipun persiapannya akan melelahkan, melihat semua orang bahagia akan sepadan dengan usaha kami.',
                        'target_word' => 'will be tiring ... will be worth (Dual Future Contrast)',
                        'vocab' => [
                            ['en' => 'the preparation', 'id' => 'persiapannya'],
                            ['en' => 'tiring', 'id' => 'melelahkan'],
                            ['en' => 'seeing everyone happy', 'id' => 'melihat semua orang bahagia'],
                            ['en' => 'worth our effort', 'id' => 'sepadan dengan usaha kami'],
                        ],
                        'options' => [
                            'Although the preparation will be tiring, seeing everyone happy will be worth our effort.',
                            'Although the preparation will tiring, seeing everyone happy will be worth our effort.',
                            'Although the preparation will are tiring, seeing everyone happy will be worth our effort.',
                            'Although the preparation will being tiring, seeing everyone happy will be worth our effort.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa konsesi memakai nominal masa depan 'will be tiring', disusul klausa utama nominal 'will be worth'.",
                    ],
                    [
                        'id' => 78,
                        'id_sentence' => 'Setelah lagu ulang tahun selesai dinyanyikan, lilin di kue akan ditiup bersama-sama.',
                        'target_word' => 'is sung ... will be blown out (Event Milestone Synthesis)',
                        'vocab' => [
                            ['en' => 'birthday song is sung', 'id' => 'lagu ulang tahun dinyanyikan'],
                            ['en' => 'candles on the cake', 'id' => 'lilin di kue'],
                            ['en' => 'blown out together', 'id' => 'ditiup bersama-sama'],
                        ],
                        'options' => [
                            'After the birthday song is sung, the candles on the cake will be blown out together.',
                            'After the birthday song will be sung, the candles on the cake will be blown out together.',
                            'After the birthday song is sung, the candles on the cake will blow out together.',
                            'After the birthday song will sung, the candles on the cake will be blown out together.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'After' + Simple Present Pasif 'is sung', diikuti Future Pasif 'will be blown out'.",
                    ],
                    [
                        'id' => 79,
                        'id_sentence' => 'Jika hujan tidak berhenti sampai sore, acara akan dipindahkan ke dalam rumah dan semua orang akan tetap senang.',
                        'target_word' => 'does not stop ... will be moved ... will be (Triple Future Clause)',
                        'vocab' => [
                            ['en' => 'rain does not stop by evening', 'id' => 'hujan tidak berhenti sampai sore'],
                            ['en' => 'the event will be moved indoors', 'id' => 'acara akan dipindahkan ke dalam rumah'],
                            ['en' => 'everyone will still be happy', 'id' => 'semua orang akan tetap senang'],
                        ],
                        'options' => [
                            'If the rain does not stop by evening, the event will be moved indoors and everyone will still be happy.',
                            'If the rain will not stop by evening, the event will be moved indoors and everyone will still be happy.',
                            'If the rain does not stop by evening, the event will moved indoors and everyone will still happy.',
                            'If the rain does not stop by evening, the event will be moved indoors and everyone will still being happy.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa 'If' memakai Simple Present negatif 'does not stop'. Induk kalimat memadukan pasif 'will be moved' dan nominal 'will be happy'.",
                    ],
                    [
                        'id' => 80,
                        'id_sentence' => 'Jadwal acara ini menegaskan bahwa pesta akan menjadi kenangan yang indah segera setelah semua tamu pulang dengan selamat.',
                        'target_word' => 'will be ... as soon as ... get home (Event Plan Climax)',
                        'vocab' => [
                            ['en' => 'this event schedule confirms', 'id' => 'jadwal acara ini menegaskan'],
                            ['en' => 'a beautiful memory', 'id' => 'kenangan yang indah'],
                            ['en' => 'all the guests get home safely', 'id' => 'semua tamu pulang dengan selamat'],
                        ],
                        'options' => [
                            'This event schedule confirms that the party will be a beautiful memory as soon as all the guests get home safely.',
                            'This event schedule confirms that the party will be a beautiful memory as soon as all the guests will get home safely.',
                            'This event schedule confirms that the party will a beautiful memory as soon as all the guests get home safely.',
                            'This event schedule confirms that the party will is a beautiful memory as soon as all the guests get home safely.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa komplemen memakai Future Nominal 'will be a beautiful memory', disusul klausa waktu 'as soon as' dengan Simple Present jamak 'get home'.",
                    ],
                ]
            ],
        ];
    }
}
