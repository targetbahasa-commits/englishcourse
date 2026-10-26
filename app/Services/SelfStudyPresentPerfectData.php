<?php

namespace App\Services;

class SelfStudyPresentPerfectData
{
    /**
     * Get the complete Present Perfect Tense (Verbal, Nominal, Passive) package.
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
            'banner_title' => 'Present Perfect Tense (Verbal, Nominal, Passive)',
            'banner_subtitle' => 'Kuasai cara menceritakan hal yang baru saja terjadi (have/has + V3), kondisi yang masih berlangsung (have/has been + Adj/Noun), hal yang telah dilakukan oleh orang lain (have/has been + V3), penanda durasi (since/for), serta perbedaannya dengan Simple Past.',
            'banner_badge' => 'MODULE 1.10 PRESENT PERFECT TENSE',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 1.10
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Panduan Lengkap Present Perfect Tense',
            'concept_summary' => 'Present Perfect Tense adalah salah satu tense paling penting dalam bahasa Inggris sehari-hari. Fungsinya adalah menghubungkan sesuatu yang terjadi di masa lalu dengan keadaannya sekarang. Tense ini sering dipakai untuk menceritakan hal yang baru saja selesai, pengalaman hidup, dan kondisi yang masih berlangsung sampai saat ini.',
            'rules' => [
                [
                    'rule_title' => '1. Bentuk Verbal Aktif: Hal yang Baru Terjadi',
                    'rule_formula' => 'Subject + have/has + Verb 3 (Past Participle) + Object',
                    'rule_description' => 'Gunakan "has + V3" untuk subjek tunggal orang ketiga (he, she, it, my brother) dan "have + V3" untuk subjek jamak (we, they, my parents) serta I/you. Jangan pernah menyelipkan to be (was/is) di depan V3 aktif.',
                    'examples' => [
                        [
                            'en' => 'My sister has cleaned her room.',
                            'id' => 'Kakak perempuan saya telah membersihkan kamarnya.',
                            'note' => 'Subjek tunggal "My sister" menggunakan auxiliary "has" + V3 "cleaned".'
                        ]
                    ]
                ],
                [
                    'rule_title' => '2. Bentuk Nominal: Keadaan yang Masih Berlangsung',
                    'rule_formula' => 'Subject + have/has been + Adjective / Noun Phrase / Prepositional Phrase',
                    'rule_description' => 'Menyatakan keadaan atau sifat yang dimulai di masa lampau dan masih berlanjut hingga saat ini. Kata "been" wajib hadir sebagai bentuk Participle dari to be.',
                    'examples' => [
                        [
                            'en' => 'The weather has been very hot this week.',
                            'id' => 'Cuaca telah sangat panas minggu ini.',
                            'note' => '"has been very hot" menunjukkan keadaan yang masih berlangsung sampai sekarang.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '3. Bentuk Pasif: Apa yang Telah Dilakukan',
                    'rule_formula' => 'Subject + have/has been + Verb 3 (Past Participle)',
                    'rule_description' => 'Fokus kalimat dialihkan ke sesuatu yang dikerjakan, bukan ke siapa yang mengerjakan. Bedakan dengan Continuous Pasif (is/are being + V3): Present Perfect Pasif selalu menggunakan "been", bukan "being".',
                    'examples' => [
                        [
                            'en' => 'The front door has been locked.',
                            'id' => 'Pintu depan telah dikunci.',
                            'note' => '"has been locked" fokus pada pintunya, bukan siapa yang mengunci.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '4. Penanda Waktu: For vs Since vs Over the Past',
                    'rule_formula' => 'SINCE + Titik Awal Waktu | FOR + Durasi | OVER THE PAST + Periode',
                    'rule_description' => 'Gunakan "since" untuk titik awal waktu (since 2015, since Monday). Gunakan "for" untuk rentang durasi (for three years, for a week). Frasa "over the past/last [periode]" merujuk pada rentang masa lalu hingga kini.',
                    'examples' => [
                        [
                            'en' => 'He has lived in this city since 2015.',
                            'id' => 'Dia telah tinggal di kota ini sejak tahun 2015.',
                            'note' => '"since" menandai titik awal waktu, yaitu tahun 2015.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '5. Present Perfect vs Simple Past',
                    'rule_formula' => 'Simple Past: Waktu Pasti (in 2020, last year) | Present Perfect: Masih Berkaitan dengan Sekarang',
                    'rule_description' => 'Jika ada waktu lampau yang spesifik disebutkan (misal: "in 2019", "last year"), gunakan Simple Past. Jika merujuk pada sesuatu yang masih berkaitan/berlangsung hingga sekarang ("ever since", "so far"), gunakan Present Perfect.',
                    'examples' => [
                        [
                            'en' => 'She graduated in 2019, and she has worked at her father\'s shop ever since.',
                            'id' => 'Dia lulus sekolah pada tahun 2019, dan sejak itu dia telah bekerja di toko ayahnya.',
                            'note' => 'Klausa pertama memakai Simple Past (waktu pasti), klausa kedua memakai Present Perfect ("ever since").'
                        ]
                    ]
                ],
                [
                    'rule_title' => '6. Bentuk Negatif & Pertanyaan',
                    'rule_formula' => 'Negative: Subject + have/has + not + (yet) + V3 / been V3 | Question: Have/Has + S + V3?',
                    'rule_description' => 'Untuk kalimat negatif, sisipkan "not" setelah have/has. Kata "yet" sering ditambahkan di akhir kalimat untuk menegaskan bahwa sesuatu belum terjadi. Untuk kalimat tanya, letakkan Have/Has di awal kalimat sebelum subjek.',
                    'examples' => [
                        [
                            'en' => 'I have not finished my homework yet.',
                            'id' => 'Saya belum menyelesaikan pekerjaan rumah saya.',
                            'note' => '"have not finished ... yet" menyatakan sesuatu yang belum selesai.'
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
                'id' => 'present-perfect-verbal',
                'name' => '1.10.1 Present Perfect Verbal: Things That Have Just Happened',
                'code' => '1.10.1',
                'concept_title' => 'Present Perfect Verbal: Hal yang Baru Terjadi',
                'concept_description' => "Present Perfect Verbal digunakan untuk menceritakan tindakan yang telah terjadi di masa lalu namun hasilnya masih terasa atau berlaku sekarang. Dibentuk dengan auxiliary 'have' (untuk I/you/we/they/jamak) atau 'has' (untuk he/she/it/tunggal) diikuti Past Participle (V3). Jangan gunakan to be (am/is/are/was/were) di depan V3 aktif.",
                'description' => "Present Perfect Verbal digunakan untuk menceritakan tindakan yang telah terjadi di masa lalu namun hasilnya masih terasa atau berlaku sekarang. Dibentuk dengan auxiliary 'have' (untuk I/you/we/they/jamak) atau 'has' (untuk he/she/it/tunggal) diikuti Past Participle (V3). Jangan gunakan to be (am/is/are/was/were) di depan V3 aktif.",
                'formula' => 'Subject + have/has + Verb 3 (Past Participle) + Object / Complement',
                'rules' => [
                    "Gunakan 'has + V3' untuk subjek orang ketiga tunggal (my sister, he, the team).",
                    "Gunakan 'have + V3' untuk subjek jamak (they, my parents) dan subjek 'I/we/you'.",
                    'Verba wajib berbentuk Past Participle / V3 (misal: cleaned, finished, painted, learned).',
                    'Jangan menambahkan to be was/is sebelum have/has atau sebelum V3 aktif.',
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'id_sentence' => 'Kakak perempuan saya telah membersihkan kamarnya.',
                        'target_word' => 'has cleaned (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'older sister', 'id' => 'kakak perempuan'],
                            ['en' => 'cleaned', 'id' => 'membersihkan'],
                            ['en' => 'room', 'id' => 'kamar'],
                        ],
                        'options' => [
                            'My older sister has cleaned her room.',
                            'My older sister have cleaned her room.',
                            'My older sister has clean her room.',
                            'My older sister is cleaned her room.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'My older sister' memakai auxiliary 'has' diikuti Past Participle (V3) 'cleaned'.",
                    ],
                    [
                        'id' => 2,
                        'id_sentence' => 'Saya telah menyelesaikan pekerjaan rumah saya.',
                        'target_word' => 'have finished (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'finished', 'id' => 'menyelesaikan'],
                            ['en' => 'homework', 'id' => 'pekerjaan rumah'],
                            ['en' => 'already', 'id' => 'sudah'],
                        ],
                        'options' => [
                            'I have finished my homework.',
                            'I has finished my homework.',
                            'I have finish my homework.',
                            'I am finished my homework.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek 'I' selalu memakai auxiliary 'have', bukan 'has'.",
                    ],
                    [
                        'id' => 3,
                        'id_sentence' => 'Mereka telah mengecat pagar rumah kami.',
                        'target_word' => 'have painted (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'painted', 'id' => 'mengecat'],
                            ['en' => 'fence', 'id' => 'pagar'],
                            ['en' => 'our house', 'id' => 'rumah kami'],
                        ],
                        'options' => [
                            'They have painted our fence.',
                            'They has painted our fence.',
                            'They have paint our fence.',
                            'They are painted our fence.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'They' membutuhkan auxiliary 'have' + V3 'painted'.",
                    ],
                    [
                        'id' => 4,
                        'id_sentence' => 'Dia (perempuan) telah belajar berenang.',
                        'target_word' => 'has learned (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'learned', 'id' => 'belajar'],
                            ['en' => 'to swim', 'id' => 'berenang'],
                            ['en' => 'finally', 'id' => 'akhirnya'],
                        ],
                        'options' => [
                            'She has learned to swim.',
                            'She have learned to swim.',
                            'She has learn to swim.',
                            'She is learned to swim.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'She' memakai 'has' + V3 'learned'.",
                    ],
                    [
                        'id' => 5,
                        'id_sentence' => 'Kami telah menonton film itu tiga kali.',
                        'target_word' => 'have watched (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'watched', 'id' => 'menonton'],
                            ['en' => 'that movie', 'id' => 'film itu'],
                            ['en' => 'three times', 'id' => 'tiga kali'],
                        ],
                        'options' => [
                            'We have watched that movie three times.',
                            'We has watched that movie three times.',
                            'We have watch that movie three times.',
                            'We was watched that movie three times.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'We' memakai 'have watched'.",
                    ],
                    [
                        'id' => 6,
                        'id_sentence' => 'Dia (laki-laki) telah kehilangan kuncinya lagi.',
                        'target_word' => 'has lost (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'lost', 'id' => 'kehilangan'],
                            ['en' => 'keys', 'id' => 'kunci'],
                            ['en' => 'again', 'id' => 'lagi'],
                        ],
                        'options' => [
                            'He has lost his keys again.',
                            'He have lost his keys again.',
                            'He has lose his keys again.',
                            'He is lost his keys again.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'He' memakai 'has lost'.",
                    ],
                    [
                        'id' => 7,
                        'id_sentence' => 'Orang tua saya telah membeli mobil baru.',
                        'target_word' => 'have bought (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'parents', 'id' => 'orang tua'],
                            ['en' => 'bought', 'id' => 'membeli'],
                            ['en' => 'a new car', 'id' => 'mobil baru'],
                        ],
                        'options' => [
                            'My parents have bought a new car.',
                            'My parents has bought a new car.',
                            'My parents have buy a new car.',
                            'My parents were bought a new car.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'My parents' memakai 'have bought'.",
                    ],
                    [
                        'id' => 8,
                        'id_sentence' => 'Anak-anak itu telah memakan semua kuenya.',
                        'target_word' => 'have eaten (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'children', 'id' => 'anak-anak'],
                            ['en' => 'eaten', 'id' => 'memakan'],
                            ['en' => 'all the cookies', 'id' => 'semua kue'],
                        ],
                        'options' => [
                            'The children have eaten all the cookies.',
                            'The children has eaten all the cookies.',
                            'The children have eat all the cookies.',
                            'The children are eaten all the cookies.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'The children' memakai 'have eaten'.",
                    ],
                    [
                        'id' => 9,
                        'id_sentence' => 'Kakak laki-laki saya telah memperbaiki sepedanya.',
                        'target_word' => 'has fixed (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'older brother', 'id' => 'kakak laki-laki'],
                            ['en' => 'fixed', 'id' => 'memperbaiki'],
                            ['en' => 'bicycle', 'id' => 'sepeda'],
                        ],
                        'options' => [
                            'My older brother has fixed his bicycle.',
                            'My older brother have fixed his bicycle.',
                            'My older brother has fix his bicycle.',
                            'My older brother is fixed his bicycle.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'My older brother' memakai 'has fixed'.",
                    ],
                    [
                        'id' => 10,
                        'id_sentence' => 'Tim kami telah memenangkan pertandingan itu.',
                        'target_word' => 'has won (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'team', 'id' => 'tim'],
                            ['en' => 'won', 'id' => 'memenangkan'],
                            ['en' => 'the match', 'id' => 'pertandingan'],
                        ],
                        'options' => [
                            'Our team has won the match.',
                            'Our team have won the match.',
                            'Our team has win the match.',
                            'Our team was won the match.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Team' dianggap sebagai subjek tunggal, sehingga memakai 'has won'.",
                    ],
                ]
            ],
            [
                'id' => 'present-perfect-nominal',
                'name' => '1.10.2 Present Perfect Nominal: Describing Ongoing Conditions',
                'code' => '1.10.2',
                'concept_title' => 'Present Perfect Nominal: Menjelaskan Keadaan yang Masih Berlangsung',
                'concept_description' => "Present Perfect Nominal digunakan untuk menyatakan keadaan, sifat, atau status yang telah dimulai di masa lalu dan terus berlanjut hingga saat ini. Pola rumusnya menggunakan auxiliary 'have/has' diikuti 'been' dan pelengkap (Adjective, Noun, atau Prepositional Phrase). Jangan pernah meniadakan kata 'been' pada kalimat nominal.",
                'description' => "Present Perfect Nominal digunakan untuk menyatakan keadaan, sifat, atau status yang telah dimulai di masa lalu dan terus berlanjut hingga saat ini. Pola rumusnya menggunakan auxiliary 'have/has' diikuti 'been' dan pelengkap (Adjective, Noun, atau Prepositional Phrase). Jangan pernah meniadakan kata 'been' pada kalimat nominal.",
                'formula' => 'Subject + have/has + been + Adjective / Noun Phrase / Prepositional Phrase',
                'rules' => [
                    "Pola nominal wajib menyertakan 'been' setelah have/has (have been / has been).",
                    'Pelengkap berupa kata sifat (adjective), kata benda (noun), atau frasa keterangan.',
                    'Dilarang menggunakan V1 atau V2 murni setelah have/has been dalam kalimat nominal.',
                    'Menunjukkan kelanjutan status dari masa lampau hingga saat kalimat diucapkan.',
                ],
                'exercises' => [
                    [
                        'id' => 11,
                        'id_sentence' => 'Cuaca telah sangat panas minggu ini.',
                        'target_word' => 'has been (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'weather', 'id' => 'cuaca'],
                            ['en' => 'very hot', 'id' => 'sangat panas'],
                            ['en' => 'this week', 'id' => 'minggu ini'],
                        ],
                        'options' => [
                            'The weather has been very hot this week.',
                            'The weather have been very hot this week.',
                            'The weather has hot this week.',
                            'The weather was been very hot this week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The weather' memerlukan 'has been' sebelum adjective 'hot'.",
                    ],
                    [
                        'id' => 12,
                        'id_sentence' => 'Dia telah menjadi guru di sekolah ini selama lima tahun.',
                        'target_word' => 'has been a teacher (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'teacher', 'id' => 'guru'],
                            ['en' => 'school', 'id' => 'sekolah'],
                            ['en' => 'for five years', 'id' => 'selama lima tahun'],
                        ],
                        'options' => [
                            'She has been a teacher at this school for five years.',
                            'She have been a teacher at this school for five years.',
                            'She has a teacher at this school for five years.',
                            'She is being a teacher at this school for five years.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'She' memakai 'has been' diikuti noun phrase 'a teacher'.",
                    ],
                    [
                        'id' => 13,
                        'id_sentence' => 'Kondisi jalan di desa kami telah buruk selama berbulan-bulan.',
                        'target_word' => 'have been bad (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'road conditions', 'id' => 'kondisi jalan'],
                            ['en' => 'village', 'id' => 'desa'],
                            ['en' => 'for months', 'id' => 'selama berbulan-bulan'],
                        ],
                        'options' => [
                            'The road conditions in our village have been bad for months.',
                            'The road conditions in our village has been bad for months.',
                            'The road conditions in our village have bad for months.',
                            'The road conditions in our village had been bad for months.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'conditions' memakai 'have been bad'.",
                    ],
                    [
                        'id' => 14,
                        'id_sentence' => 'Kakek saya telah menjadi petani sepanjang hidupnya.',
                        'target_word' => 'has been a farmer (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'grandfather', 'id' => 'kakek'],
                            ['en' => 'farmer', 'id' => 'petani'],
                            ['en' => 'his whole life', 'id' => 'sepanjang hidupnya'],
                        ],
                        'options' => [
                            'My grandfather has been a farmer his whole life.',
                            'My grandfather have been a farmer his whole life.',
                            'My grandfather has a farmer his whole life.',
                            'My grandfather is being a farmer his whole life.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'My grandfather' memakai 'has been' diikuti noun phrase 'a farmer'.",
                    ],
                    [
                        'id' => 15,
                        'id_sentence' => 'Harga sayuran telah mahal sejak musim hujan dimulai.',
                        'target_word' => 'have been expensive (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'vegetable prices', 'id' => 'harga sayuran'],
                            ['en' => 'expensive', 'id' => 'mahal'],
                            ['en' => 'rainy season', 'id' => 'musim hujan'],
                        ],
                        'options' => [
                            'Vegetable prices have been expensive since the rainy season started.',
                            'Vegetable prices has been expensive since the rainy season started.',
                            'Vegetable prices have expensive since the rainy season started.',
                            'Vegetable prices were been expensive since the rainy season started.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'Vegetable prices' memakai 'have been expensive'.",
                    ],
                    [
                        'id' => 16,
                        'id_sentence' => 'Paman saya telah sakit selama seminggu terakhir.',
                        'target_word' => 'has been sick (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'uncle', 'id' => 'paman'],
                            ['en' => 'sick', 'id' => 'sakit'],
                            ['en' => 'the past week', 'id' => 'seminggu terakhir'],
                        ],
                        'options' => [
                            'My uncle has been sick for the past week.',
                            'My uncle have been sick for the past week.',
                            'My uncle has sick for the past week.',
                            'My uncle is been sick for the past week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'My uncle' memakai 'has been sick'.",
                    ],
                    [
                        'id' => 17,
                        'id_sentence' => 'Kedua anjing itu telah ramah kepada semua tamu.',
                        'target_word' => 'have been friendly (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'both dogs', 'id' => 'kedua anjing'],
                            ['en' => 'friendly', 'id' => 'ramah'],
                            ['en' => 'every guest', 'id' => 'setiap tamu'],
                        ],
                        'options' => [
                            'Both dogs have been friendly to every guest.',
                            'Both dogs has been friendly to every guest.',
                            'Both dogs have friendly to every guest.',
                            'Both dogs are been friendly to every guest.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'Both dogs' memakai 'have been friendly'.",
                    ],
                    [
                        'id' => 18,
                        'id_sentence' => 'Musik telah menjadi minat utamanya sejak kecil.',
                        'target_word' => 'has been his main interest (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'music', 'id' => 'musik'],
                            ['en' => 'main interest', 'id' => 'minat utama'],
                            ['en' => 'since childhood', 'id' => 'sejak kecil'],
                        ],
                        'options' => [
                            'Music has been his main interest since childhood.',
                            'Music have been his main interest since childhood.',
                            'Music has a main interest since childhood.',
                            'Music was been his main interest since childhood.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Music' adalah subjek tunggal, sehingga memakai 'has been'.",
                    ],
                    [
                        'id' => 19,
                        'id_sentence' => 'Taman itu telah bebas dari sampah selama tiga bulan berturut-turut.',
                        'target_word' => 'has been free from (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'park', 'id' => 'taman'],
                            ['en' => 'free from litter', 'id' => 'bebas dari sampah'],
                            ['en' => 'three consecutive months', 'id' => 'tiga bulan berturut-turut'],
                        ],
                        'options' => [
                            'The park has been free from litter for three consecutive months.',
                            'The park have been free from litter for three consecutive months.',
                            'The park has free from litter for three consecutive months.',
                            'The park were free from litter for three consecutive months.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The park' memakai 'has been free from'.",
                    ],
                    [
                        'id' => 20,
                        'id_sentence' => 'Latihan rutin pagi hari telah sangat membantu bagi kesehatannya.',
                        'target_word' => 'has been very helpful (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'morning exercise', 'id' => 'latihan pagi hari'],
                            ['en' => 'very helpful', 'id' => 'sangat membantu'],
                            ['en' => 'her health', 'id' => 'kesehatannya'],
                        ],
                        'options' => [
                            'Morning exercise has been very helpful for her health.',
                            'Morning exercise have been very helpful for her health.',
                            'Morning exercise has helpful for her health.',
                            'Morning exercise is been very helpful for her health.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'Morning exercise' memakai 'has been very helpful'.",
                    ],
                ]
            ],
            [
                'id' => 'present-perfect-passive',
                'name' => '1.10.3 Present Perfect Passive: Describing What Has Been Done',
                'code' => '1.10.3',
                'concept_title' => 'Present Perfect Pasif: Menjelaskan Hal yang Telah Dilakukan',
                'concept_description' => "Present Perfect Pasif digunakan ketika kita ingin menonjolkan apa yang telah dikerjakan, tanpa harus menyebutkan siapa yang mengerjakannya. Rumusnya menggunakan 'have/has been' diikuti Past Participle (V3).",
                'description' => "Present Perfect Pasif digunakan ketika kita ingin menonjolkan apa yang telah dikerjakan, tanpa harus menyebutkan siapa yang mengerjakannya. Rumusnya menggunakan 'have/has been' diikuti Past Participle (V3).",
                'formula' => 'Subject (Penerima Aksi) + have/has + been + Verb 3 (Past Participle) + (by Pelaku)',
                'rules' => [
                    'Struktur wajib: have/has + been + Past Participle (V3).',
                    "Jangan tertukar dengan Continuous Pasif (is/are being + V3); perfect pasif selalu menggunakan 'been', bukan 'being'.",
                    'Verba umum: locked, washed, painted, sent, planted, cleaned.',
                    "Subjek jamak memakai 'have been + V3', subjek tunggal memakai 'has been + V3'.",
                ],
                'exercises' => [
                    [
                        'id' => 21,
                        'id_sentence' => 'Pintu depan telah dikunci sejak tadi malam.',
                        'target_word' => 'has been locked (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'front door', 'id' => 'pintu depan'],
                            ['en' => 'locked', 'id' => 'dikunci'],
                            ['en' => 'since last night', 'id' => 'sejak tadi malam'],
                        ],
                        'options' => [
                            'The front door has been locked since last night.',
                            'The front door have been locked since last night.',
                            'The front door has being locked since last night.',
                            'The front door has locked since last night.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek pasif tunggal 'The front door' memerlukan 'has been locked'. Opsi C salah memakai 'being'.",
                    ],
                    [
                        'id' => 22,
                        'id_sentence' => 'Semua piring telah dicuci oleh adik saya.',
                        'target_word' => 'have been washed (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'dishes', 'id' => 'piring'],
                            ['en' => 'washed', 'id' => 'dicuci'],
                            ['en' => 'younger sibling', 'id' => 'adik'],
                        ],
                        'options' => [
                            'All the dishes have been washed by my younger sibling.',
                            'All the dishes has been washed by my younger sibling.',
                            'All the dishes have being washed by my younger sibling.',
                            'All the dishes have washed by my younger sibling.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'dishes' memakai 'have been washed'.",
                    ],
                    [
                        'id' => 23,
                        'id_sentence' => 'Rumah itu telah dicat ulang tahun ini.',
                        'target_word' => 'has been repainted (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'house', 'id' => 'rumah'],
                            ['en' => 'repainted', 'id' => 'dicat ulang'],
                            ['en' => 'this year', 'id' => 'tahun ini'],
                        ],
                        'options' => [
                            'The house has been repainted this year.',
                            'The house have been repainted this year.',
                            'The house has being repainted this year.',
                            'The house was repainted this year already.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The house' memakai 'has been repainted'.",
                    ],
                    [
                        'id' => 24,
                        'id_sentence' => 'Surat itu telah dikirim pagi ini.',
                        'target_word' => 'has been sent (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'letter', 'id' => 'surat'],
                            ['en' => 'sent', 'id' => 'dikirim'],
                            ['en' => 'this morning', 'id' => 'pagi ini'],
                        ],
                        'options' => [
                            'The letter has been sent this morning.',
                            'The letter have been sent this morning.',
                            'The letter has being sent this morning.',
                            'The letter has sent this morning.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The letter' memakai 'has been sent'.",
                    ],
                    [
                        'id' => 25,
                        'id_sentence' => 'Banyak pohon telah ditanam di taman kota.',
                        'target_word' => 'have been planted (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'trees', 'id' => 'pohon'],
                            ['en' => 'planted', 'id' => 'ditanam'],
                            ['en' => 'city park', 'id' => 'taman kota'],
                        ],
                        'options' => [
                            'Many trees have been planted in the city park.',
                            'Many trees has been planted in the city park.',
                            'Many trees have being planted in the city park.',
                            'Many trees have plant in the city park.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'Many trees' memakai 'have been planted'.",
                    ],
                    [
                        'id' => 26,
                        'id_sentence' => 'Kue ulang tahun itu telah dipotong oleh ibu.',
                        'target_word' => 'has been cut (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'birthday cake', 'id' => 'kue ulang tahun'],
                            ['en' => 'cut', 'id' => 'dipotong'],
                            ['en' => 'mother', 'id' => 'ibu'],
                        ],
                        'options' => [
                            'The birthday cake has been cut by mother.',
                            'The birthday cake have been cut by mother.',
                            'The birthday cake has being cut by mother.',
                            'The birthday cake has cut by mother.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The birthday cake' memakai 'has been cut'.",
                    ],
                    [
                        'id' => 27,
                        'id_sentence' => 'Jendela-jendela itu telah dibersihkan minggu ini.',
                        'target_word' => 'have been cleaned (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'windows', 'id' => 'jendela'],
                            ['en' => 'cleaned', 'id' => 'dibersihkan'],
                            ['en' => 'this week', 'id' => 'minggu ini'],
                        ],
                        'options' => [
                            'The windows have been cleaned this week.',
                            'The windows has been cleaned this week.',
                            'The windows have being cleaned this week.',
                            'The windows have clean this week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'The windows' memakai 'have been cleaned'.",
                    ],
                    [
                        'id' => 28,
                        'id_sentence' => 'Laporan sekolah saya telah ditandatangani oleh ayah.',
                        'target_word' => 'has been signed (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'school report', 'id' => 'laporan sekolah'],
                            ['en' => 'signed', 'id' => 'ditandatangani'],
                            ['en' => 'father', 'id' => 'ayah'],
                        ],
                        'options' => [
                            'My school report has been signed by my father.',
                            'My school report have been signed by my father.',
                            'My school report has being signed by my father.',
                            'My school report has sign by my father.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'My school report' memakai 'has been signed'.",
                    ],
                    [
                        'id' => 29,
                        'id_sentence' => 'Beberapa mainan telah disumbangkan ke panti asuhan.',
                        'target_word' => 'have been donated (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'toys', 'id' => 'mainan'],
                            ['en' => 'donated', 'id' => 'disumbangkan'],
                            ['en' => 'orphanage', 'id' => 'panti asuhan'],
                        ],
                        'options' => [
                            'Several toys have been donated to the orphanage.',
                            'Several toys has been donated to the orphanage.',
                            'Several toys have being donated to the orphanage.',
                            'Several toys have donate to the orphanage.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'Several toys' memakai 'have been donated'.",
                    ],
                    [
                        'id' => 30,
                        'id_sentence' => 'Meja makan itu telah dirapikan untuk tamu.',
                        'target_word' => 'has been tidied (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'dining table', 'id' => 'meja makan'],
                            ['en' => 'tidied', 'id' => 'dirapikan'],
                            ['en' => 'guests', 'id' => 'tamu'],
                        ],
                        'options' => [
                            'The dining table has been tidied for the guests.',
                            'The dining table have been tidied for the guests.',
                            'The dining table has being tidied for the guests.',
                            'The dining table has tidy for the guests.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The dining table' memakai 'has been tidied'.",
                    ],
                ]
            ],
            [
                'id' => 'duration-markers-for-since',
                'name' => '1.10.4 Duration Markers: For vs Since vs Over the Past',
                'code' => '1.10.4',
                'concept_title' => 'Penanda Durasi: For, Since, & Over the Past',
                'concept_description' => "Present Perfect sering dipadukan dengan penanda waktu untuk menunjukkan rentang kontinuitas. Gunakan 'since' jika merujuk pada titik awal waktu spesifik (since 2015, since Monday). Gunakan 'for' untuk total durasi (for five years, for a week). Gunakan 'over the past/last...' untuk merangkum perkembangan terkini.",
                'description' => "Present Perfect sering dipadukan dengan penanda waktu untuk menunjukkan rentang kontinuitas. Gunakan 'since' jika merujuk pada titik awal waktu spesifik (since 2015, since Monday). Gunakan 'for' untuk total durasi (for five years, for a week). Gunakan 'over the past/last...' untuk merangkum perkembangan terkini.",
                'formula' => 'Subject + have/has + V3/been + FOR (durasi) / SINCE (titik awal) / OVER THE PAST (periode)',
                'rules' => [
                    "'Since' + titik awal waktu (misal: since 2015, since Monday, since I was a child).",
                    "'For' + durasi waktu (misal: for three years, for a week, for a long time).",
                    "'Over / In the past [jumlah] years' merujuk kurun waktu lampau hingga sekarang dan memakai Present Perfect.",
                    "Jangan gunakan Simple Past dengan 'since' jika kalimat merujuk pada kondisi yang berlanjut hingga kini.",
                ],
                'exercises' => [
                    [
                        'id' => 31,
                        'id_sentence' => 'Dia telah tinggal di kota ini sejak tahun 2015.',
                        'target_word' => 'has lived ... since (Duration Marker: Since)',
                        'vocab' => [
                            ['en' => 'lived', 'id' => 'tinggal'],
                            ['en' => 'this city', 'id' => 'kota ini'],
                            ['en' => 'since 2015', 'id' => 'sejak tahun 2015'],
                        ],
                        'options' => [
                            'He has lived in this city since 2015.',
                            'He has lived in this city for 2015.',
                            'He lived in this city since 2015.',
                            'He have lived in this city since 2015.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Titik awal waktu ('2015') memakai 'since', subjek tunggal 'He' memakai 'has lived'.",
                    ],
                    [
                        'id' => 32,
                        'id_sentence' => 'Saya telah belajar bahasa Inggris selama tiga tahun.',
                        'target_word' => 'have studied ... for (Duration Marker: For)',
                        'vocab' => [
                            ['en' => 'studied', 'id' => 'belajar'],
                            ['en' => 'English', 'id' => 'bahasa Inggris'],
                            ['en' => 'three years', 'id' => 'tiga tahun'],
                        ],
                        'options' => [
                            'I have studied English for three years.',
                            'I have studied English since three years.',
                            'I studied English for three years currently.',
                            'I has studied English for three years.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Durasi waktu ('three years') memakai 'for', subjek 'I' memakai 'have'.",
                    ],
                    [
                        'id' => 33,
                        'id_sentence' => 'Selama lima tahun terakhir, keluarga kami telah pindah tiga kali.',
                        'target_word' => 'has moved ... over the past five years (Time Frame Marker)',
                        'vocab' => [
                            ['en' => 'our family', 'id' => 'keluarga kami'],
                            ['en' => 'moved', 'id' => 'pindah'],
                            ['en' => 'over the past five years', 'id' => 'selama lima tahun terakhir'],
                        ],
                        'options' => [
                            'Over the past five years, our family has moved three times.',
                            'Over the past five years, our family moved three times already.',
                            'Over the past five years, our family have moved three times.',
                            'Over the past five years, our family is moving three times.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Over the past five years' menghubungkan masa lalu ke sekarang sehingga memakai Present Perfect 'has moved'.",
                    ],
                    [
                        'id' => 34,
                        'id_sentence' => 'Mereka telah menjadi tetangga kami sejak saya masih kecil.',
                        'target_word' => 'have been ... since (Duration Marker: Since + Clause)',
                        'vocab' => [
                            ['en' => 'neighbors', 'id' => 'tetangga'],
                            ['en' => 'since I was a child', 'id' => 'sejak saya masih kecil'],
                            ['en' => 'they', 'id' => 'mereka'],
                        ],
                        'options' => [
                            'They have been our neighbors since I was a child.',
                            'They have been our neighbors for I was a child.',
                            'They were our neighbors since I was a child.',
                            'They has been our neighbors since I was a child.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa awal waktu ('since I was a child') dipakai bersama Present Perfect 'have been'.",
                    ],
                    [
                        'id' => 35,
                        'id_sentence' => 'Nenek saya telah memasak untuk keluarga besar selama empat puluh tahun.',
                        'target_word' => 'has cooked ... for (Duration Marker: For)',
                        'vocab' => [
                            ['en' => 'grandmother', 'id' => 'nenek'],
                            ['en' => 'cooked', 'id' => 'memasak'],
                            ['en' => 'forty years', 'id' => 'empat puluh tahun'],
                        ],
                        'options' => [
                            'My grandmother has cooked for the whole family for forty years.',
                            'My grandmother has cooked for the whole family since forty years.',
                            'My grandmother have cooked for the whole family for forty years.',
                            'My grandmother cooked for the whole family for forty years now.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Durasi total ('forty years') memakai 'for', dengan subjek tunggal 'has cooked'.",
                    ],
                    [
                        'id' => 36,
                        'id_sentence' => 'Dalam beberapa bulan terakhir, harga beras telah naik.',
                        'target_word' => 'has risen ... in recent months (Time Frame Marker)',
                        'vocab' => [
                            ['en' => 'price of rice', 'id' => 'harga beras'],
                            ['en' => 'risen', 'id' => 'naik'],
                            ['en' => 'in recent months', 'id' => 'dalam beberapa bulan terakhir'],
                        ],
                        'options' => [
                            'In recent months, the price of rice has risen.',
                            'In recent months, the price of rice rose already.',
                            'In recent months, the price of rice have risen.',
                            'In recent months, the price of rice is rising yesterday.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'In recent months' adalah penanda waktu baku untuk Present Perfect 'has risen'.",
                    ],
                    [
                        'id' => 37,
                        'id_sentence' => 'Perjanjian sewa rumah itu telah berlaku sejak awal bulan ini.',
                        'target_word' => 'has been in effect since (Nominal + Since)',
                        'vocab' => [
                            ['en' => 'rental agreement', 'id' => 'perjanjian sewa'],
                            ['en' => 'in effect', 'id' => 'berlaku'],
                            ['en' => 'the beginning of this month', 'id' => 'awal bulan ini'],
                        ],
                        'options' => [
                            'The house rental agreement has been in effect since the beginning of this month.',
                            'The house rental agreement has been in effect for the beginning of this month.',
                            'The house rental agreement was in effect since the beginning of this month.',
                            'The house rental agreement have been in effect since the beginning of this month.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Titik waktu spesifik memakai 'since', dipadukan dengan Present Perfect Nominal 'has been in effect'.",
                    ],
                    [
                        'id' => 38,
                        'id_sentence' => 'Keluarga itu telah tinggal di desa ini selama tiga generasi.',
                        'target_word' => 'has lived ... for (Duration Marker: For)',
                        'vocab' => [
                            ['en' => 'family', 'id' => 'keluarga'],
                            ['en' => 'village', 'id' => 'desa'],
                            ['en' => 'three generations', 'id' => 'tiga generasi'],
                        ],
                        'options' => [
                            'The family has lived in this village for three generations.',
                            'The family has lived in this village since three generations.',
                            'The family have lived in this village for three generations.',
                            'The family lived in this village for three generations now.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Durasi jamak ('three generations') memakai 'for', dengan subjek tunggal 'has lived'.",
                    ],
                    [
                        'id' => 39,
                        'id_sentence' => 'Sejak pindah ke apartemen baru, dia telah merasa lebih bahagia.',
                        'target_word' => 'has felt ... since (Since + Noun Phrase)',
                        'vocab' => [
                            ['en' => 'moving to', 'id' => 'pindah ke'],
                            ['en' => 'felt happier', 'id' => 'merasa lebih bahagia'],
                            ['en' => 'new apartment', 'id' => 'apartemen baru'],
                        ],
                        'options' => [
                            'Since moving to the new apartment, she has felt happier.',
                            'For moving to the new apartment, she has felt happier.',
                            'Since moving to the new apartment, she felt happier.',
                            'Since moving to the new apartment, she have felt happier.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Since' menandai titik awal perubahan, subjek tunggal 'she' memakai 'has felt'.",
                    ],
                    [
                        'id' => 40,
                        'id_sentence' => 'Selama satu dekade terakhir, kota ini telah berubah banyak.',
                        'target_word' => 'has changed ... over the last decade (Time Frame Marker)',
                        'vocab' => [
                            ['en' => 'this town', 'id' => 'kota ini'],
                            ['en' => 'changed a lot', 'id' => 'berubah banyak'],
                            ['en' => 'over the last decade', 'id' => 'selama satu dekade terakhir'],
                        ],
                        'options' => [
                            'Over the last decade, this town has changed a lot.',
                            'Over the last decade, this town changed a lot yesterday.',
                            'Over the last decade, this town have changed a lot.',
                            'Over the last decade, this town is changed a lot.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Over the last decade' adalah penanda waktu rentang ke masa kini yang memakai Present Perfect 'has changed'.",
                    ],
                ]
            ],
            [
                'id' => 'present-perfect-vs-simple-past',
                'name' => '1.10.5 Present Perfect vs Simple Past',
                'code' => '1.10.5',
                'concept_title' => 'Present Perfect vs Simple Past: Waktu Pasti vs Masih Berkaitan dengan Sekarang',
                'concept_description' => 'Membedakan peristiwa yang terjadi di waktu pasti di masa lalu (Simple Past: in 2019, last year, yesterday) dengan peristiwa yang hasilnya masih berkaitan dengan sekarang (Present Perfect: ever since, so far, recently). Menggabungkan kedua tense ini dengan tepat adalah kunci bercerita yang jelas.',
                'description' => 'Membedakan peristiwa yang terjadi di waktu pasti di masa lalu (Simple Past: in 2019, last year, yesterday) dengan peristiwa yang hasilnya masih berkaitan dengan sekarang (Present Perfect: ever since, so far, recently). Menggabungkan kedua tense ini dengan tepat adalah kunci bercerita yang jelas.',
                'formula' => 'Waktu Pasti: S + V2 (Penanda Waktu) | Masih Berkaitan: S + have/has + V3',
                'rules' => [
                    'Waktu pasti di masa lalu (in 2020, two years ago, last month) memakai Simple Past V2.',
                    'Waktu tidak pasti atau masih berlanjut (ever since, so far, recently) memakai Present Perfect.',
                    'Jangan mencampur penanda waktu pasti dengan Present Perfect dalam satu klausa yang sama.',
                    'Pola umum: ceritakan kejadian lampau dengan Simple Past, lalu hubungkan dengan dampaknya sekarang memakai Present Perfect.',
                ],
                'exercises' => [
                    [
                        'id' => 41,
                        'id_sentence' => 'Dia lulus sekolah pada tahun 2019, dan sejak itu dia telah bekerja di toko ayahnya.',
                        'target_word' => 'graduated ... has worked (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'graduated', 'id' => 'lulus sekolah'],
                            ['en' => 'ever since', 'id' => 'sejak itu'],
                            ['en' => "father's shop", 'id' => 'toko ayahnya'],
                        ],
                        'options' => [
                            "She graduated in 2019, and she has worked at her father's shop ever since.",
                            "She has graduated in 2019, and she worked at her father's shop ever since.",
                            "She graduated in 2019, and she work at her father's shop ever since.",
                            "She has graduated in 2019, and she has worked at her father's shop ever since.",
                        ],
                        'correct_index' => 0,
                        'explanation' => "'in 2019' adalah waktu pasti, maka memakai Simple Past 'graduated'. 'ever since' memakai Present Perfect 'has worked'.",
                    ],
                    [
                        'id' => 42,
                        'id_sentence' => 'Kami pindah ke rumah ini dua tahun lalu, dan kami telah menyukainya sejak saat itu.',
                        'target_word' => 'moved ... have loved (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'moved', 'id' => 'pindah'],
                            ['en' => 'two years ago', 'id' => 'dua tahun lalu'],
                            ['en' => 'ever since', 'id' => 'sejak saat itu'],
                        ],
                        'options' => [
                            'We moved into this house two years ago, and we have loved it ever since.',
                            'We have moved into this house two years ago, and we loved it ever since.',
                            'We moved into this house two years ago, and we loved it ever since.',
                            'We moved into this house two years ago, and we has loved it ever since.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'two years ago' memakai Simple Past 'moved'. 'ever since' memakai Present Perfect 'have loved'.",
                    ],
                    [
                        'id' => 43,
                        'id_sentence' => 'Ayah membeli mobil itu pada tahun 2018, dan mobil itu telah berjalan dengan baik sejak saat itu.',
                        'target_word' => 'bought ... has run (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'bought', 'id' => 'membeli'],
                            ['en' => 'in 2018', 'id' => 'pada tahun 2018'],
                            ['en' => 'run well', 'id' => 'berjalan dengan baik'],
                        ],
                        'options' => [
                            'Father bought that car in 2018, and it has run well ever since.',
                            'Father has bought that car in 2018, and it run well ever since.',
                            'Father bought that car in 2018, and it run well ever since.',
                            'Father bought that car in 2018, and it have run well ever since.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'in 2018' memakai Simple Past 'bought', subjek tunggal 'it' memakai Present Perfect 'has run'.",
                    ],
                    [
                        'id' => 44,
                        'id_sentence' => 'Dia bertemu sahabatnya di sekolah dasar, dan mereka telah berteman sejak saat itu.',
                        'target_word' => 'met ... have been (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'met', 'id' => 'bertemu'],
                            ['en' => 'best friend', 'id' => 'sahabat'],
                            ['en' => 'elementary school', 'id' => 'sekolah dasar'],
                        ],
                        'options' => [
                            'She met her best friend in elementary school, and they have been friends ever since.',
                            'She has met her best friend in elementary school, and they have been friends ever since.',
                            'She met her best friend in elementary school, and they were friends ever since.',
                            'She met her best friend in elementary school, and they has been friends ever since.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'met...in elementary school' adalah Simple Past, 'ever since' memakai Present Perfect 'have been'.",
                    ],
                    [
                        'id' => 45,
                        'id_sentence' => 'Kakek saya pensiun pada tahun 2010, namun dia tetap sibuk berkebun sejak itu.',
                        'target_word' => 'retired ... has stayed (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'retired', 'id' => 'pensiun'],
                            ['en' => 'in 2010', 'id' => 'pada tahun 2010'],
                            ['en' => 'stayed busy gardening', 'id' => 'tetap sibuk berkebun'],
                        ],
                        'options' => [
                            'My grandfather retired in 2010, but he has stayed busy gardening since then.',
                            'My grandfather has retired in 2010, but he stayed busy gardening since then.',
                            'My grandfather retired in 2010, but he stayed busy gardening since then.',
                            'My grandfather retired in 2010, but he have stayed busy gardening since then.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'in 2010' memakai Simple Past 'retired'. 'since then' memakai Present Perfect 'has stayed'.",
                    ],
                    [
                        'id' => 46,
                        'id_sentence' => 'Toko itu dibuka tahun lalu, dan toko itu telah ramai pengunjung sejak saat itu.',
                        'target_word' => 'opened ... has been (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'opened', 'id' => 'dibuka'],
                            ['en' => 'last year', 'id' => 'tahun lalu'],
                            ['en' => 'busy', 'id' => 'ramai'],
                        ],
                        'options' => [
                            'The shop opened last year, and it has been busy ever since.',
                            'The shop has opened last year, and it was busy ever since.',
                            'The shop opened last year, and it was busy ever since.',
                            'The shop opened last year, and it have been busy ever since.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'opened last year' adalah Simple Past, 'ever since' memakai Present Perfect 'has been'.",
                    ],
                    [
                        'id' => 47,
                        'id_sentence' => 'Saya belajar memasak nasi goreng minggu lalu, dan sekarang saya telah memasaknya lima kali.',
                        'target_word' => 'learned ... have cooked (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'learned', 'id' => 'belajar'],
                            ['en' => 'last week', 'id' => 'minggu lalu'],
                            ['en' => 'five times', 'id' => 'lima kali'],
                        ],
                        'options' => [
                            'I learned to cook fried rice last week, and I have cooked it five times since then.',
                            'I have learned to cook fried rice last week, and I cooked it five times since then.',
                            'I learned to cook fried rice last week, and I cooked it five times since then.',
                            'I learned to cook fried rice last week, and I has cooked it five times since then.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'last week' memakai Simple Past 'learned', subjek 'I' memakai Present Perfect 'have cooked'.",
                    ],
                    [
                        'id' => 48,
                        'id_sentence' => 'Mereka menikah sepuluh tahun yang lalu, dan mereka telah tinggal di kota yang sama sejak saat itu.',
                        'target_word' => 'got married ... have lived (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'got married', 'id' => 'menikah'],
                            ['en' => 'ten years ago', 'id' => 'sepuluh tahun lalu'],
                            ['en' => 'the same city', 'id' => 'kota yang sama'],
                        ],
                        'options' => [
                            'They got married ten years ago, and they have lived in the same city ever since.',
                            'They have got married ten years ago, and they lived in the same city ever since.',
                            'They got married ten years ago, and they lived in the same city ever since.',
                            'They got married ten years ago, and they has lived in the same city ever since.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'ten years ago' memakai Simple Past 'got married', subjek jamak 'they' memakai Present Perfect 'have lived'.",
                    ],
                    [
                        'id' => 49,
                        'id_sentence' => 'Dia mulai bekerja di sini bulan lalu, dan dia sudah belajar banyak hal baru sejauh ini.',
                        'target_word' => 'started ... has learned (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'started', 'id' => 'mulai'],
                            ['en' => 'last month', 'id' => 'bulan lalu'],
                            ['en' => 'so far', 'id' => 'sejauh ini'],
                        ],
                        'options' => [
                            'She started working here last month, and she has learned many new things so far.',
                            'She has started working here last month, and she learned many new things so far.',
                            'She started working here last month, and she learned many new things so far.',
                            'She started working here last month, and she have learned many new things so far.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'last month' memakai Simple Past 'started', subjek tunggal 'she' memakai Present Perfect 'has learned'.",
                    ],
                    [
                        'id' => 50,
                        'id_sentence' => 'Kami mengunjungi pantai itu musim panas lalu, dan kami telah merencanakan untuk kembali sejak saat itu.',
                        'target_word' => 'visited ... have planned (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'visited', 'id' => 'mengunjungi'],
                            ['en' => 'last summer', 'id' => 'musim panas lalu'],
                            ['en' => 'planned to go back', 'id' => 'merencanakan untuk kembali'],
                        ],
                        'options' => [
                            'We visited that beach last summer, and we have planned to go back ever since.',
                            'We have visited that beach last summer, and we planned to go back ever since.',
                            'We visited that beach last summer, and we planned to go back ever since.',
                            'We visited that beach last summer, and we has planned to go back ever since.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'last summer' memakai Simple Past 'visited', subjek jamak 'we' memakai Present Perfect 'have planned'.",
                    ],
                ]
            ],
            [
                'id' => 'present-perfect-negative-interrogative',
                'name' => '1.10.6 Present Perfect Negative & Interrogative',
                'code' => '1.10.6',
                'concept_title' => 'Present Perfect Negatif & Interogatif',
                'concept_description' => "Bentuk negatif Present Perfect (have/has not + V3 / been V3) digunakan untuk menyatakan sesuatu yang belum terjadi. Bentuk interogatif (Have/Has + Subject + V3?) digunakan untuk bertanya apakah sesuatu sudah terjadi atau belum.",
                'description' => "Bentuk negatif Present Perfect (have/has not + V3 / been V3) digunakan untuk menyatakan sesuatu yang belum terjadi. Bentuk interogatif (Have/Has + Subject + V3?) digunakan untuk bertanya apakah sesuatu sudah terjadi atau belum.",
                'formula' => 'Negatif: Subject + have/has + NOT + (yet) + V3 / been V3 | Tanya: Have/Has + S + V3?',
                'rules' => [
                    "Sisipkan 'not' di antara auxiliary have/has dan V3 atau been (has not finished, have not been fixed).",
                    "Kata 'yet' sering ditambahkan di akhir kalimat negatif untuk menegaskan sesuatu belum terjadi.",
                    'Untuk kalimat tanya, letakkan Have atau Has di awal sebelum subjek.',
                    "Jangan gunakan don't/doesn't untuk membentuk Present Perfect negatif.",
                ],
                'exercises' => [
                    [
                        'id' => 51,
                        'id_sentence' => 'Saya belum menyelesaikan pekerjaan rumah saya.',
                        'target_word' => 'have not finished (Negative Verbal)',
                        'vocab' => [
                            ['en' => 'have not finished', 'id' => 'belum menyelesaikan'],
                            ['en' => 'homework', 'id' => 'pekerjaan rumah'],
                            ['en' => 'yet', 'id' => 'belum (di akhir kalimat)'],
                        ],
                        'options' => [
                            'I have not finished my homework yet.',
                            'I has not finished my homework yet.',
                            'I do not have finished my homework yet.',
                            'I have not finish my homework yet.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek 'I' memakai 'have not finished', dan 'yet' diletakkan di akhir kalimat.",
                    ],
                    [
                        'id' => 52,
                        'id_sentence' => 'Dia (perempuan) belum pernah mengunjungi Bali.',
                        'target_word' => 'has never visited (Negative with Never)',
                        'vocab' => [
                            ['en' => 'never visited', 'id' => 'belum pernah mengunjungi'],
                            ['en' => 'Bali', 'id' => 'Bali'],
                            ['en' => 'she', 'id' => 'dia'],
                        ],
                        'options' => [
                            'She has never visited Bali.',
                            'She have never visited Bali.',
                            'She did not never visited Bali.',
                            'She has never visit Bali.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'She' memakai 'has never visited'.",
                    ],
                    [
                        'id' => 53,
                        'id_sentence' => 'Mereka belum membersihkan kamar mereka.',
                        'target_word' => 'have not cleaned (Negative Verbal)',
                        'vocab' => [
                            ['en' => 'have not cleaned', 'id' => 'belum membersihkan'],
                            ['en' => 'their room', 'id' => 'kamar mereka'],
                            ['en' => 'they', 'id' => 'mereka'],
                        ],
                        'options' => [
                            'They have not cleaned their room.',
                            'They has not cleaned their room.',
                            'They do not have cleaned their room.',
                            'They have not clean their room.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'They' memakai 'have not cleaned'.",
                    ],
                    [
                        'id' => 54,
                        'id_sentence' => 'Kucing kami belum makan sejak pagi.',
                        'target_word' => 'has not eaten (Negative Verbal)',
                        'vocab' => [
                            ['en' => 'has not eaten', 'id' => 'belum makan'],
                            ['en' => 'our cat', 'id' => 'kucing kami'],
                            ['en' => 'since morning', 'id' => 'sejak pagi'],
                        ],
                        'options' => [
                            'Our cat has not eaten since this morning.',
                            'Our cat have not eaten since this morning.',
                            'Our cat does not have eaten since this morning.',
                            'Our cat has not eat since this morning.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'Our cat' memakai 'has not eaten'.",
                    ],
                    [
                        'id' => 55,
                        'id_sentence' => 'Saya belum pernah mencoba makanan itu sebelumnya.',
                        'target_word' => 'have never tried (Negative with Never)',
                        'vocab' => [
                            ['en' => 'never tried', 'id' => 'belum pernah mencoba'],
                            ['en' => 'that food', 'id' => 'makanan itu'],
                            ['en' => 'before', 'id' => 'sebelumnya'],
                        ],
                        'options' => [
                            'I have never tried that food before.',
                            'I has never tried that food before.',
                            'I did not never tried that food before.',
                            'I have never try that food before.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek 'I' memakai 'have never tried'.",
                    ],
                    [
                        'id' => 56,
                        'id_sentence' => 'Apakah kamu sudah menyelesaikan tugasmu?',
                        'target_word' => 'Have ... finished (Interrogative Verbal)',
                        'vocab' => [
                            ['en' => 'finished', 'id' => 'menyelesaikan'],
                            ['en' => 'assignment', 'id' => 'tugas'],
                            ['en' => 'you', 'id' => 'kamu'],
                        ],
                        'options' => [
                            'Have you finished your assignment?',
                            'Has you finished your assignment?',
                            'Did you have finished your assignment?',
                            'Have you finish your assignment?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek 'you' diawali 'Have' + Subject + V3 'finished'.",
                    ],
                    [
                        'id' => 57,
                        'id_sentence' => 'Apakah dia (perempuan) pernah pergi ke luar negeri?',
                        'target_word' => 'Has ... ever traveled (Interrogative with Ever)',
                        'vocab' => [
                            ['en' => 'ever traveled', 'id' => 'pernah pergi'],
                            ['en' => 'abroad', 'id' => 'ke luar negeri'],
                            ['en' => 'she', 'id' => 'dia'],
                        ],
                        'options' => [
                            'Has she ever traveled abroad?',
                            'Have she ever traveled abroad?',
                            'Did she ever travel abroad before?',
                            'Has she ever travel abroad?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'she' diawali dengan 'Has' + Subject + V3 'traveled'.",
                    ],
                    [
                        'id' => 58,
                        'id_sentence' => 'Apakah mereka sudah makan siang?',
                        'target_word' => 'Have ... had ... yet (Interrogative with Yet)',
                        'vocab' => [
                            ['en' => 'had lunch', 'id' => 'makan siang'],
                            ['en' => 'yet', 'id' => 'sudah/belum'],
                            ['en' => 'they', 'id' => 'mereka'],
                        ],
                        'options' => [
                            'Have they had lunch yet?',
                            'Has they had lunch yet?',
                            'Did they have lunch yet?',
                            'Have they have lunch yet?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'they' diawali 'Have' + Subject + V3 'had', dengan 'yet' di akhir.",
                    ],
                    [
                        'id' => 59,
                        'id_sentence' => 'Apakah kucingmu pernah menangkap tikus?',
                        'target_word' => 'Has ... ever caught (Interrogative with Ever)',
                        'vocab' => [
                            ['en' => 'ever caught', 'id' => 'pernah menangkap'],
                            ['en' => 'a mouse', 'id' => 'tikus'],
                            ['en' => 'your cat', 'id' => 'kucingmu'],
                        ],
                        'options' => [
                            'Has your cat ever caught a mouse?',
                            'Have your cat ever caught a mouse?',
                            'Did your cat ever caught a mouse?',
                            'Has your cat ever catch a mouse?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'your cat' diawali 'Has' + Subject + V3 'caught'.",
                    ],
                    [
                        'id' => 60,
                        'id_sentence' => 'Apakah kalian sudah membeli tiketnya?',
                        'target_word' => 'Have ... bought ... yet (Interrogative with Yet)',
                        'vocab' => [
                            ['en' => 'bought', 'id' => 'membeli'],
                            ['en' => 'the tickets', 'id' => 'tiketnya'],
                            ['en' => 'yet', 'id' => 'sudah/belum'],
                        ],
                        'options' => [
                            'Have you bought the tickets yet?',
                            'Has you bought the tickets yet?',
                            'Did you bought the tickets yet?',
                            'Have you buy the tickets yet?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek 'you' diawali 'Have' + Subject + V3 'bought', dengan 'yet' di akhir.",
                    ],
                ]
            ],
            [
                'id' => 'adverbs-already-yet-just-recently',
                'name' => '1.10.7 Positioning Key Adverbs: Already, Yet, Just, Recently, Ever, Never',
                'code' => '1.10.7',
                'concept_title' => 'Penempatan Adverbia: Already, Just, Recently, Yet, Never',
                'concept_description' => 'Penempatan adverbia (already, just, recently, never, ever, so far) di posisi yang tepat sangat memengaruhi kejelasan kalimat Present Perfect. Adverbia ini biasanya diletakkan tepat di antara auxiliary (have/has) dan main verb (V3).',
                'description' => 'Penempatan adverbia (already, just, recently, never, ever, so far) di posisi yang tepat sangat memengaruhi kejelasan kalimat Present Perfect. Adverbia ini biasanya diletakkan tepat di antara auxiliary (have/has) dan main verb (V3).',
                'formula' => 'Subject + have/has + ALREADY / JUST / RECENTLY / NEVER + Verb 3 (Past Participle)',
                'rules' => [
                    "'Just' diletakkan di antara have/has dan V3 untuk menyatakan tindakan yang baru saja terjadi.",
                    "'Already' diletakkan di antara have/has dan V3 untuk menegaskan sesuatu sudah selesai.",
                    "'Recently' dapat diletakkan di antara have/has dan V3, atau di awal kalimat.",
                    "'Never' diletakkan di antara have/has dan V3 untuk menyatakan tidak pernah sama sekali.",
                    "'Yet' diletakkan di akhir kalimat negatif atau kalimat tanya.",
                ],
                'exercises' => [
                    [
                        'id' => 61,
                        'id_sentence' => 'Saya baru saja menyelesaikan pekerjaan rumah saya.',
                        'target_word' => 'have just finished (Adverb Placement: Just)',
                        'vocab' => [
                            ['en' => 'just finished', 'id' => 'baru saja menyelesaikan'],
                            ['en' => 'homework', 'id' => 'pekerjaan rumah'],
                            ['en' => 'I', 'id' => 'saya'],
                        ],
                        'options' => [
                            'I have just finished my homework.',
                            'I just have finished my homework.',
                            'I have finished just my homework.',
                            'I has just finished my homework.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Adverbia 'just' disisipkan tepat di antara auxiliary 'have' dan V3 'finished'.",
                    ],
                    [
                        'id' => 62,
                        'id_sentence' => 'Dia (perempuan) sudah mengerjakan tugasnya lebih awal.',
                        'target_word' => 'has already done (Adverb Placement: Already)',
                        'vocab' => [
                            ['en' => 'already done', 'id' => 'sudah mengerjakan'],
                            ['en' => 'assignment', 'id' => 'tugas'],
                            ['en' => 'early', 'id' => 'lebih awal'],
                        ],
                        'options' => [
                            'She has already done her assignment.',
                            'She already has done her assignment.',
                            'She has done already her assignment.',
                            'She have already done her assignment.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'has already done' adalah posisi standar untuk adverbia 'already'.",
                    ],
                    [
                        'id' => 63,
                        'id_sentence' => 'Kami baru-baru ini mengunjungi nenek kami.',
                        'target_word' => 'have recently visited (Adverb Placement: Recently)',
                        'vocab' => [
                            ['en' => 'recently visited', 'id' => 'baru-baru ini mengunjungi'],
                            ['en' => 'grandmother', 'id' => 'nenek'],
                            ['en' => 'we', 'id' => 'kami'],
                        ],
                        'options' => [
                            'We have recently visited our grandmother.',
                            'We has recently visited our grandmother.',
                            'We recently have visit our grandmother.',
                            'We have visited recently our grandmother in the village.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'We' memakai 'have recently visited'.",
                    ],
                    [
                        'id' => 64,
                        'id_sentence' => 'Anjing itu belum pernah menggigit siapa pun.',
                        'target_word' => 'has never bitten (Adverb Placement: Never)',
                        'vocab' => [
                            ['en' => 'never bitten', 'id' => 'belum pernah menggigit'],
                            ['en' => 'anyone', 'id' => 'siapa pun'],
                            ['en' => 'dog', 'id' => 'anjing'],
                        ],
                        'options' => [
                            'That dog has never bitten anyone.',
                            'That dog have never bitten anyone.',
                            'That dog never has bitten anyone.',
                            'That dog has bitten never anyone.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'That dog' memakai 'has never bitten'.",
                    ],
                    [
                        'id' => 65,
                        'id_sentence' => 'Sejauh ini, saya telah membaca tiga buku bulan ini.',
                        'target_word' => 'have read ... so far (Adverbial Fronting: So far)',
                        'vocab' => [
                            ['en' => 'so far', 'id' => 'sejauh ini'],
                            ['en' => 'read three books', 'id' => 'membaca tiga buku'],
                            ['en' => 'this month', 'id' => 'bulan ini'],
                        ],
                        'options' => [
                            'So far, I have read three books this month.',
                            'So far, I has read three books this month.',
                            'So far, I read three books this month yesterday.',
                            'So far, I have reading three books this month.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'So far' dipadukan dengan Present Perfect 'have read'.",
                    ],
                    [
                        'id' => 66,
                        'id_sentence' => 'Sekolah belum mengumumkan jadwal liburan.',
                        'target_word' => 'has not yet announced (Adverb Placement: Yet)',
                        'vocab' => [
                            ['en' => 'not yet announced', 'id' => 'belum mengumumkan'],
                            ['en' => 'holiday schedule', 'id' => 'jadwal liburan'],
                            ['en' => 'school', 'id' => 'sekolah'],
                        ],
                        'options' => [
                            'The school has not yet announced the holiday schedule.',
                            'The school have not yet announced the holiday schedule.',
                            'The school has not announced yet the holiday schedule.',
                            'The school does not yet announced the holiday schedule.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The school' memakai pola 'has not yet announced'.",
                    ],
                    [
                        'id' => 67,
                        'id_sentence' => 'Ibu baru saja memasak makan malam.',
                        'target_word' => 'has just cooked (Adverb Placement: Just)',
                        'vocab' => [
                            ['en' => 'just cooked', 'id' => 'baru saja memasak'],
                            ['en' => 'dinner', 'id' => 'makan malam'],
                            ['en' => 'mother', 'id' => 'ibu'],
                        ],
                        'options' => [
                            'Mother has just cooked dinner.',
                            'Mother have just cooked dinner.',
                            'Mother just has cooked dinner.',
                            'Mother has cooked just dinner.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'Mother' memakai 'has just cooked'.",
                    ],
                    [
                        'id' => 68,
                        'id_sentence' => 'Toko itu sudah mengeluarkan diskon besar.',
                        'target_word' => 'has already offered (Adverb Placement: Already)',
                        'vocab' => [
                            ['en' => 'already offered', 'id' => 'sudah mengeluarkan'],
                            ['en' => 'a big discount', 'id' => 'diskon besar'],
                            ['en' => 'shop', 'id' => 'toko'],
                        ],
                        'options' => [
                            'The shop has already offered a big discount.',
                            'The shop have already offered a big discount.',
                            'The shop already has offered a big discount.',
                            'The shop has offered already a big discount.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The shop' memakai 'has already offered'.",
                    ],
                    [
                        'id' => 69,
                        'id_sentence' => 'Beberapa teman saya baru-baru ini pindah ke kota ini.',
                        'target_word' => 'have recently moved (Adverb Placement: Recently)',
                        'vocab' => [
                            ['en' => 'recently moved', 'id' => 'baru-baru ini pindah'],
                            ['en' => 'some of my friends', 'id' => 'beberapa teman saya'],
                            ['en' => 'this city', 'id' => 'kota ini'],
                        ],
                        'options' => [
                            'Some of my friends have recently moved to this city.',
                            'Some of my friends has recently moved to this city.',
                            'Some of my friends have moved recently to this city last week.',
                            'Some of my friends recently have move to this city.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'Some of my friends' memakai 'have recently moved'.",
                    ],
                    [
                        'id' => 70,
                        'id_sentence' => 'Apakah kamu pernah menonton pertunjukan itu?',
                        'target_word' => 'Have you ever watched (Interrogative with Ever)',
                        'vocab' => [
                            ['en' => 'ever watched', 'id' => 'pernah menonton'],
                            ['en' => 'that show', 'id' => 'pertunjukan itu'],
                            ['en' => 'you', 'id' => 'kamu'],
                        ],
                        'options' => [
                            'Have you ever watched that show?',
                            'Did you ever watched that show?',
                            'Have you watched ever that show?',
                            'Has you ever watched that show?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pola baku pertanyaan pengalaman adalah 'Have you ever' + V3 'watched'.",
                    ],
                ]
            ],
            [
                'id' => 'literature-review-synthesis',
                'name' => '1.10.8 Comprehensive Synthesis: Combining Verbal, Nominal & Passive Forms',
                'code' => '1.10.8',
                'concept_title' => 'Sintesis Komprehensif: Menggabungkan Bentuk Verbal, Nominal & Pasif',
                'concept_description' => 'Menggabungkan bentuk verbal, nominal, dan pasif Present Perfect dalam satu cerita sehari-hari yang utuh. Melatih kemampuan merangkai dua klausa Present Perfect secara alami, misalnya saat menceritakan perubahan di rumah, sekolah, atau lingkungan sekitar.',
                'description' => 'Menggabungkan bentuk verbal, nominal, dan pasif Present Perfect dalam satu cerita sehari-hari yang utuh. Melatih kemampuan merangkai dua klausa Present Perfect secara alami, misalnya saat menceritakan perubahan di rumah, sekolah, atau lingkungan sekitar.',
                'formula' => 'Klausa Present Perfect 1 (Verbal/Nominal/Pasif) + Klausa Present Perfect 2 (Verbal/Nominal/Pasif)',
                'rules' => [
                    "Gunakan Present Perfect pasif untuk menonjolkan hasil kerja ('The road has been repaired...').",
                    "Gunakan Present Perfect aktif untuk menonjolkan siapa yang melakukannya ('...residents have started exercising there').",
                    'Jaga konsistensi have/has sesuai subjek di setiap klausa, meskipun digabung dalam satu kalimat.',
                    'Pastikan keselarasan gramatikal (Subject-Verb Agreement) terjaga di kedua klausa.',
                ],
                'exercises' => [
                    [
                        'id' => 71,
                        'id_sentence' => 'Rumah kami telah dicat ulang, dan rumah itu telah terlihat sangat indah sejak saat itu.',
                        'target_word' => 'has been repainted ... has looked (Passive + Nominal Synthesis)',
                        'vocab' => [
                            ['en' => 'repainted', 'id' => 'dicat ulang'],
                            ['en' => 'looked beautiful', 'id' => 'terlihat indah'],
                            ['en' => 'our house', 'id' => 'rumah kami'],
                        ],
                        'options' => [
                            'Our house has been repainted, and it has looked very beautiful ever since.',
                            'Our house have been repainted, and it has looked very beautiful ever since.',
                            'Our house has been repainted, and it have looked very beautiful ever since.',
                            'Our house was repainted, and it has looked very beautiful ever since already.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kedua klausa memakai subjek tunggal 'it/house', sehingga memakai 'has been repainted' dan 'has looked'.",
                    ],
                    [
                        'id' => 72,
                        'id_sentence' => 'Dia (perempuan) telah belajar memasak, dan masakannya telah menjadi sangat enak.',
                        'target_word' => 'has learned ... has become (Verbal + Nominal Synthesis)',
                        'vocab' => [
                            ['en' => 'learned to cook', 'id' => 'belajar memasak'],
                            ['en' => 'become very tasty', 'id' => 'menjadi sangat enak'],
                            ['en' => 'her food', 'id' => 'masakannya'],
                        ],
                        'options' => [
                            'She has learned to cook, and her food has become very tasty.',
                            'She have learned to cook, and her food has become very tasty.',
                            'She has learned to cook, and her food have become very tasty.',
                            'She has learn to cook, and her food has become very tasty.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kedua subjek tunggal ('She' dan 'her food') memakai 'has'.",
                    ],
                    [
                        'id' => 73,
                        'id_sentence' => 'Banyak buku telah disumbangkan ke perpustakaan sekolah, dan perpustakaan itu telah menjadi lebih ramai.',
                        'target_word' => 'have been donated ... has become (Passive + Nominal Synthesis)',
                        'vocab' => [
                            ['en' => 'donated', 'id' => 'disumbangkan'],
                            ['en' => 'school library', 'id' => 'perpustakaan sekolah'],
                            ['en' => 'become busier', 'id' => 'menjadi lebih ramai'],
                        ],
                        'options' => [
                            'Many books have been donated to the school library, and it has become busier.',
                            'Many books has been donated to the school library, and it has become busier.',
                            'Many books have been donated to the school library, and it have become busier.',
                            'Many books have being donated to the school library, and it has become busier.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'books' (jamak) memakai 'have been donated', 'it/library' (tunggal) memakai 'has become'.",
                    ],
                    [
                        'id' => 74,
                        'id_sentence' => 'Kami telah menanam banyak sayuran, dan kebun kami telah terlihat sangat hijau.',
                        'target_word' => 'have planted ... has looked (Verbal + Nominal Synthesis)',
                        'vocab' => [
                            ['en' => 'planted', 'id' => 'menanam'],
                            ['en' => 'vegetables', 'id' => 'sayuran'],
                            ['en' => 'looked very green', 'id' => 'terlihat sangat hijau'],
                        ],
                        'options' => [
                            'We have planted many vegetables, and our garden has looked very green.',
                            'We has planted many vegetables, and our garden has looked very green.',
                            'We have planted many vegetables, and our garden have looked very green.',
                            'We have plant many vegetables, and our garden has looked very green.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'We' memakai 'have planted', subjek tunggal 'our garden' memakai 'has looked'.",
                    ],
                    [
                        'id' => 75,
                        'id_sentence' => 'Jalan desa itu telah diperbaiki, dan perjalanan ke sekolah telah menjadi lebih cepat.',
                        'target_word' => 'has been repaired ... has become (Passive + Nominal Synthesis)',
                        'vocab' => [
                            ['en' => 'repaired', 'id' => 'diperbaiki'],
                            ['en' => 'village road', 'id' => 'jalan desa'],
                            ['en' => 'become faster', 'id' => 'menjadi lebih cepat'],
                        ],
                        'options' => [
                            'The village road has been repaired, and the trip to school has become faster.',
                            'The village road have been repaired, and the trip to school has become faster.',
                            'The village road has been repaired, and the trip to school have become faster.',
                            'The village road was repaired, and the trip to school has become faster recently last year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kedua subjek tunggal ('road' dan 'trip') memakai 'has'.",
                    ],
                    [
                        'id' => 76,
                        'id_sentence' => 'Adik saya telah belajar bermain gitar, dan dia telah tampil di tiga acara sekolah.',
                        'target_word' => 'has learned ... has performed (Dual Verbal Synthesis)',
                        'vocab' => [
                            ['en' => 'learned to play guitar', 'id' => 'belajar bermain gitar'],
                            ['en' => 'performed', 'id' => 'tampil'],
                            ['en' => 'school events', 'id' => 'acara sekolah'],
                        ],
                        'options' => [
                            'My younger sibling has learned to play guitar, and they have performed at three school events.',
                            'My younger sibling have learned to play guitar, and they have performed at three school events.',
                            'My younger sibling has learned to play guitar, and they has performed at three school events.',
                            'My younger sibling has learn to play guitar, and they have performed at three school events.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'My younger sibling' (tunggal) memakai 'has learned', 'they' (jamak) memakai 'have performed'.",
                    ],
                    [
                        'id' => 77,
                        'id_sentence' => 'Taman kota telah dibersihkan, dan warga telah mulai berolahraga di sana setiap pagi.',
                        'target_word' => 'has been cleaned ... have started (Passive + Verbal Synthesis)',
                        'vocab' => [
                            ['en' => 'cleaned', 'id' => 'dibersihkan'],
                            ['en' => 'city park', 'id' => 'taman kota'],
                            ['en' => 'started exercising', 'id' => 'mulai berolahraga'],
                        ],
                        'options' => [
                            'The city park has been cleaned, and residents have started exercising there every morning.',
                            'The city park have been cleaned, and residents have started exercising there every morning.',
                            'The city park has been cleaned, and residents has started exercising there every morning.',
                            'The city park has being cleaned, and residents have started exercising there every morning.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'The city park' (tunggal) memakai 'has been cleaned', 'residents' (jamak) memakai 'have started'.",
                    ],
                    [
                        'id' => 78,
                        'id_sentence' => 'Harga buah-buahan telah naik, namun pasar tradisional telah tetap ramai pembeli.',
                        'target_word' => 'have risen ... has stayed (Verbal + Nominal Synthesis)',
                        'vocab' => [
                            ['en' => 'risen', 'id' => 'naik'],
                            ['en' => 'fruit prices', 'id' => 'harga buah-buahan'],
                            ['en' => 'stayed busy', 'id' => 'tetap ramai'],
                        ],
                        'options' => [
                            'Fruit prices have risen, but the traditional market has still been busy with buyers.',
                            'Fruit prices has risen, but the traditional market has still been busy with buyers.',
                            'Fruit prices have risen, but the traditional market have still been busy with buyers.',
                            'Fruit prices have rise, but the traditional market has still been busy with buyers.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Fruit prices' (jamak) memakai 'have risen', 'the traditional market' (tunggal) memakai 'has...been'.",
                    ],
                    [
                        'id' => 79,
                        'id_sentence' => 'Keluarga itu telah pindah ke rumah baru, dan rumah lama mereka telah dijual ke tetangga.',
                        'target_word' => 'has moved ... has been sold (Verbal + Passive Synthesis)',
                        'vocab' => [
                            ['en' => 'moved', 'id' => 'pindah'],
                            ['en' => 'new house', 'id' => 'rumah baru'],
                            ['en' => 'sold', 'id' => 'dijual'],
                        ],
                        'options' => [
                            'The family has moved to a new house, and their old house has been sold to a neighbor.',
                            'The family have moved to a new house, and their old house has been sold to a neighbor.',
                            'The family has moved to a new house, and their old house have been sold to a neighbor.',
                            'The family has moved to a new house, and their old house has being sold to a neighbor.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kedua subjek tunggal ('family' dan 'old house') memakai 'has'.",
                    ],
                    [
                        'id' => 80,
                        'id_sentence' => 'Sekolah kami telah mengadakan banyak acara tahun ini, dan semua acara itu telah berjalan lancar.',
                        'target_word' => 'has held ... have gone (Verbal + Nominal Synthesis)',
                        'vocab' => [
                            ['en' => 'held', 'id' => 'mengadakan'],
                            ['en' => 'many events', 'id' => 'banyak acara'],
                            ['en' => 'gone smoothly', 'id' => 'berjalan lancar'],
                        ],
                        'options' => [
                            'Our school has held many events this year, and all of them have gone smoothly.',
                            'Our school have held many events this year, and all of them have gone smoothly.',
                            'Our school has held many events this year, and all of them has gone smoothly.',
                            'Our school has hold many events this year, and all of them have gone smoothly.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Our school' (tunggal) memakai 'has held', 'all of them' (jamak) memakai 'have gone'.",
                    ],
                ]
            ],
        ];
    }
}
