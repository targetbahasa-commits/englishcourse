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
            'banner_subtitle' => 'Kuasai cara menceritakan hal yang baru saja terjadi (have/has + V3), kondisi yang masih berlangsung (have/has been + Adj/Noun), hal yang telah dilakukan oleh orang lain (have/has been + V3), penanda durasi (since/for), serta perbedaannya dengan Simple Past -- pada konteks pekerjaan, perjalanan, dan kehidupan sehari-hari yang lebih kompleks.',
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
            'concept_summary' => 'Present Perfect Tense adalah salah satu tense paling penting dalam komunikasi kerja dan kehidupan sehari-hari. Fungsinya adalah menghubungkan sesuatu yang terjadi di masa lalu dengan keadaannya sekarang. Tense ini sering dipakai untuk melaporkan perkembangan terbaru, pengalaman profesional, dan kondisi yang masih berlangsung sampai saat ini.',
            'rules' => [
                [
                    'rule_title' => '1. Bentuk Verbal Aktif: Hal yang Baru Terjadi',
                    'rule_formula' => 'Subject + have/has + Verb 3 (Past Participle) + Object',
                    'rule_description' => 'Gunakan "has + V3" untuk subjek tunggal orang ketiga (he, she, it, the manager) dan "have + V3" untuk subjek jamak (we, they, the clients) serta I/you. Jangan pernah menyelipkan to be (was/is) di depan V3 aktif.',
                    'examples' => [
                        [
                            'en' => 'The supplier has confirmed the delivery schedule for next week.',
                            'id' => 'Pemasok telah mengonfirmasi jadwal pengiriman untuk minggu depan.',
                            'note' => 'Subjek tunggal "The supplier" menggunakan auxiliary "has" + V3 "confirmed".'
                        ]
                    ]
                ],
                [
                    'rule_title' => '2. Bentuk Nominal: Keadaan yang Masih Berlangsung',
                    'rule_formula' => 'Subject + have/has been + Adjective / Noun Phrase / Prepositional Phrase',
                    'rule_description' => 'Menyatakan keadaan atau sifat yang dimulai di masa lampau dan masih berlanjut hingga saat ini. Kata "been" wajib hadir sebagai bentuk Participle dari to be.',
                    'examples' => [
                        [
                            'en' => 'Demand for the product has been unusually high this quarter.',
                            'id' => 'Permintaan untuk produk itu telah luar biasa tinggi kuartal ini.',
                            'note' => '"has been unusually high" menunjukkan keadaan yang masih berlangsung sampai sekarang.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '3. Bentuk Pasif: Apa yang Telah Dilakukan',
                    'rule_formula' => 'Subject + have/has been + Verb 3 (Past Participle)',
                    'rule_description' => 'Fokus kalimat dialihkan ke sesuatu yang dikerjakan, bukan ke siapa yang mengerjakan. Bedakan dengan Continuous Pasif (is/are being + V3): Present Perfect Pasif selalu menggunakan "been", bukan "being".',
                    'examples' => [
                        [
                            'en' => 'The contract has been reviewed by the legal team.',
                            'id' => 'Kontrak itu telah ditinjau oleh tim hukum.',
                            'note' => '"has been reviewed" fokus pada kontraknya, bukan siapa yang meninjau.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '4. Penanda Waktu: For vs Since vs Over the Past',
                    'rule_formula' => 'SINCE + Titik Awal Waktu | FOR + Durasi | OVER THE PAST + Periode',
                    'rule_description' => 'Gunakan "since" untuk titik awal waktu (since 2015, since Monday). Gunakan "for" untuk rentang durasi (for three years, for a week). Frasa "over the past/last [periode]" merujuk pada rentang masa lalu hingga kini.',
                    'examples' => [
                        [
                            'en' => 'She has managed this branch since the company expanded into this region.',
                            'id' => 'Dia telah mengelola cabang ini sejak perusahaan berekspansi ke wilayah ini.',
                            'note' => '"since" menandai titik awal waktu berupa sebuah peristiwa, bukan hanya tahun.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '5. Present Perfect vs Simple Past',
                    'rule_formula' => 'Simple Past: Waktu Pasti (in 2020, last year) | Present Perfect: Masih Berkaitan dengan Sekarang',
                    'rule_description' => 'Jika ada waktu lampau yang spesifik disebutkan (misal: "in 2019", "last quarter"), gunakan Simple Past. Jika merujuk pada sesuatu yang masih berkaitan/berlangsung hingga sekarang ("ever since", "so far"), gunakan Present Perfect.',
                    'examples' => [
                        [
                            'en' => 'She joined the firm in 2019, and she has led the marketing team ever since.',
                            'id' => 'Dia bergabung dengan perusahaan pada tahun 2019, dan sejak itu dia telah memimpin tim pemasaran.',
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
                            'en' => 'The vendor has not responded to our inquiry yet.',
                            'id' => 'Vendor itu belum merespons pertanyaan kami.',
                            'note' => '"have not responded ... yet" menyatakan sesuatu yang belum selesai.'
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
                    "Gunakan 'has + V3' untuk subjek orang ketiga tunggal (the manager, he, the team).",
                    "Gunakan 'have + V3' untuk subjek jamak (they, the clients) dan subjek 'I/we/you'.",
                    'Verba wajib berbentuk Past Participle / V3 (misal: confirmed, resolved, updated, submitted).',
                    'Jangan menambahkan to be was/is sebelum have/has atau sebelum V3 aktif.',
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'id_sentence' => 'Manajer kami telah mengonfirmasi jadwal rapat untuk hari Kamis.',
                        'target_word' => 'has confirmed (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'manager', 'id' => 'manajer'],
                            ['en' => 'confirmed', 'id' => 'mengonfirmasi'],
                            ['en' => 'meeting schedule', 'id' => 'jadwal rapat'],
                        ],
                        'options' => [
                            'Our manager has confirmed the meeting schedule for Thursday.',
                            'Our manager have confirmed the meeting schedule for Thursday.',
                            'Our manager has confirm the meeting schedule for Thursday.',
                            'Our manager is confirmed the meeting schedule for Thursday.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'Our manager' memakai auxiliary 'has' diikuti Past Participle (V3) 'confirmed'.",
                    ],
                    [
                        'id' => 2,
                        'id_sentence' => 'Saya telah menyelesaikan laporan keuangan bulan ini.',
                        'target_word' => 'have completed (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'completed', 'id' => 'menyelesaikan'],
                            ['en' => 'financial report', 'id' => 'laporan keuangan'],
                            ['en' => 'already', 'id' => 'sudah'],
                        ],
                        'options' => [
                            'I have completed this month\'s financial report.',
                            'I has completed this month\'s financial report.',
                            'I have complete this month\'s financial report.',
                            'I am completed this month\'s financial report.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek 'I' selalu memakai auxiliary 'have', bukan 'has'.",
                    ],
                    [
                        'id' => 3,
                        'id_sentence' => 'Mereka telah memperbarui situs web perusahaan.',
                        'target_word' => 'have updated (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'updated', 'id' => 'memperbarui'],
                            ['en' => 'company website', 'id' => 'situs web perusahaan'],
                            ['en' => 'recently', 'id' => 'baru-baru ini'],
                        ],
                        'options' => [
                            'They have updated the company website.',
                            'They has updated the company website.',
                            'They have update the company website.',
                            'They are updated the company website.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'They' membutuhkan auxiliary 'have' + V3 'updated'.",
                    ],
                    [
                        'id' => 4,
                        'id_sentence' => 'Dia (perempuan) telah belajar mengoperasikan perangkat lunak akuntansi baru.',
                        'target_word' => 'has learned (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'learned', 'id' => 'belajar'],
                            ['en' => 'to operate', 'id' => 'mengoperasikan'],
                            ['en' => 'new accounting software', 'id' => 'perangkat lunak akuntansi baru'],
                        ],
                        'options' => [
                            'She has learned to operate the new accounting software.',
                            'She have learned to operate the new accounting software.',
                            'She has learn to operate the new accounting software.',
                            'She is learned to operate the new accounting software.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'She' memakai 'has' + V3 'learned'.",
                    ],
                    [
                        'id' => 5,
                        'id_sentence' => 'Kami telah meninjau proposal itu tiga kali.',
                        'target_word' => 'have reviewed (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'reviewed', 'id' => 'meninjau'],
                            ['en' => 'proposal', 'id' => 'proposal'],
                            ['en' => 'three times', 'id' => 'tiga kali'],
                        ],
                        'options' => [
                            'We have reviewed the proposal three times.',
                            'We has reviewed the proposal three times.',
                            'We have review the proposal three times.',
                            'We was reviewed the proposal three times.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'We' memakai 'have reviewed'.",
                    ],
                    [
                        'id' => 6,
                        'id_sentence' => 'Dia (laki-laki) telah kehilangan akses ke akun perusahaannya lagi.',
                        'target_word' => 'has lost (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'lost', 'id' => 'kehilangan'],
                            ['en' => 'access', 'id' => 'akses'],
                            ['en' => 'company account', 'id' => 'akun perusahaan'],
                        ],
                        'options' => [
                            'He has lost access to his company account again.',
                            'He have lost access to his company account again.',
                            'He has lose access to his company account again.',
                            'He is lost access to his company account again.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'He' memakai 'has lost'.",
                    ],
                    [
                        'id' => 7,
                        'id_sentence' => 'Klien kami telah membeli lisensi tahunan untuk layanan kami.',
                        'target_word' => 'have purchased (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'clients', 'id' => 'klien'],
                            ['en' => 'purchased', 'id' => 'membeli'],
                            ['en' => 'annual license', 'id' => 'lisensi tahunan'],
                        ],
                        'options' => [
                            'Our clients have purchased an annual license for our service.',
                            'Our clients has purchased an annual license for our service.',
                            'Our clients have purchase an annual license for our service.',
                            'Our clients were purchased an annual license for our service.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'Our clients' memakai 'have purchased'.",
                    ],
                    [
                        'id' => 8,
                        'id_sentence' => 'Tim pemasaran telah meluncurkan kampanye barunya.',
                        'target_word' => 'has launched (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'marketing team', 'id' => 'tim pemasaran'],
                            ['en' => 'launched', 'id' => 'meluncurkan'],
                            ['en' => 'new campaign', 'id' => 'kampanye baru'],
                        ],
                        'options' => [
                            'The marketing team has launched its new campaign.',
                            'The marketing team have launched its new campaign.',
                            'The marketing team have launch its new campaign.',
                            'The marketing team are launched its new campaign.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Team' dianggap subjek tunggal, sehingga memakai 'has launched'.",
                    ],
                    [
                        'id' => 9,
                        'id_sentence' => 'Kolega saya telah memperbaiki kesalahan dalam kode program itu.',
                        'target_word' => 'has fixed (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'colleague', 'id' => 'kolega'],
                            ['en' => 'fixed', 'id' => 'memperbaiki'],
                            ['en' => 'bug in the code', 'id' => 'kesalahan dalam kode'],
                        ],
                        'options' => [
                            'My colleague has fixed the bug in the code.',
                            'My colleague have fixed the bug in the code.',
                            'My colleague has fix the bug in the code.',
                            'My colleague is fixed the bug in the code.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'My colleague' memakai 'has fixed'.",
                    ],
                    [
                        'id' => 10,
                        'id_sentence' => 'Tim kami telah memenangkan proyek itu melawan tiga pesaing.',
                        'target_word' => 'has won (Present Perfect Verbal)',
                        'vocab' => [
                            ['en' => 'team', 'id' => 'tim'],
                            ['en' => 'won', 'id' => 'memenangkan'],
                            ['en' => 'competitors', 'id' => 'pesaing'],
                        ],
                        'options' => [
                            'Our team has won the project against three competitors.',
                            'Our team have won the project against three competitors.',
                            'Our team has win the project against three competitors.',
                            'Our team was won the project against three competitors.',
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
                        'id_sentence' => 'Permintaan untuk produk itu telah sangat tinggi kuartal ini.',
                        'target_word' => 'has been (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'demand', 'id' => 'permintaan'],
                            ['en' => 'very high', 'id' => 'sangat tinggi'],
                            ['en' => 'this quarter', 'id' => 'kuartal ini'],
                        ],
                        'options' => [
                            'Demand for the product has been very high this quarter.',
                            'Demand for the product have been very high this quarter.',
                            'Demand for the product has high this quarter.',
                            'Demand for the product was been very high this quarter.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'Demand' memerlukan 'has been' sebelum adjective 'high'.",
                    ],
                    [
                        'id' => 12,
                        'id_sentence' => 'Dia telah menjadi manajer cabang ini selama lima tahun.',
                        'target_word' => 'has been the manager (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'manager', 'id' => 'manajer'],
                            ['en' => 'branch', 'id' => 'cabang'],
                            ['en' => 'for five years', 'id' => 'selama lima tahun'],
                        ],
                        'options' => [
                            'She has been the manager of this branch for five years.',
                            'She have been the manager of this branch for five years.',
                            'She has a manager of this branch for five years.',
                            'She is being the manager of this branch for five years.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'She' memakai 'has been' diikuti noun phrase 'the manager'.",
                    ],
                    [
                        'id' => 13,
                        'id_sentence' => 'Jaringan internet di kantor kami telah tidak stabil selama berbulan-bulan.',
                        'target_word' => 'has been unstable (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'internet connection', 'id' => 'jaringan internet'],
                            ['en' => 'unstable', 'id' => 'tidak stabil'],
                            ['en' => 'for months', 'id' => 'selama berbulan-bulan'],
                        ],
                        'options' => [
                            'The internet connection in our office has been unstable for months.',
                            'The internet connection in our office have been unstable for months.',
                            'The internet connection in our office has unstable for months.',
                            'The internet connection in our office had been unstable for months.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'connection' memakai 'has been unstable'.",
                    ],
                    [
                        'id' => 14,
                        'id_sentence' => 'Ayah saya telah menjadi wiraswasta sepanjang kariernya.',
                        'target_word' => 'has been self-employed (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'father', 'id' => 'ayah'],
                            ['en' => 'self-employed', 'id' => 'wiraswasta'],
                            ['en' => 'throughout his career', 'id' => 'sepanjang kariernya'],
                        ],
                        'options' => [
                            'My father has been self-employed throughout his career.',
                            'My father have been self-employed throughout his career.',
                            'My father has a self-employed throughout his career.',
                            'My father is being self-employed throughout his career.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'My father' memakai 'has been' diikuti adjective 'self-employed'.",
                    ],
                    [
                        'id' => 15,
                        'id_sentence' => 'Harga bahan baku telah mahal sejak awal tahun ini.',
                        'target_word' => 'have been expensive (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'raw material prices', 'id' => 'harga bahan baku'],
                            ['en' => 'expensive', 'id' => 'mahal'],
                            ['en' => 'since the start of this year', 'id' => 'sejak awal tahun ini'],
                        ],
                        'options' => [
                            'Raw material prices have been expensive since the start of this year.',
                            'Raw material prices has been expensive since the start of this year.',
                            'Raw material prices have expensive since the start of this year.',
                            'Raw material prices were been expensive since the start of this year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'prices' memakai 'have been expensive'.",
                    ],
                    [
                        'id' => 16,
                        'id_sentence' => 'Pemasok kami telah tidak responsif selama seminggu terakhir.',
                        'target_word' => 'has been unresponsive (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'supplier', 'id' => 'pemasok'],
                            ['en' => 'unresponsive', 'id' => 'tidak responsif'],
                            ['en' => 'the past week', 'id' => 'seminggu terakhir'],
                        ],
                        'options' => [
                            'Our supplier has been unresponsive for the past week.',
                            'Our supplier have been unresponsive for the past week.',
                            'Our supplier has unresponsive for the past week.',
                            'Our supplier is been unresponsive for the past week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'Our supplier' memakai 'has been unresponsive'.",
                    ],
                    [
                        'id' => 17,
                        'id_sentence' => 'Kedua kandidat itu telah sangat profesional sepanjang proses wawancara.',
                        'target_word' => 'have been professional (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'both candidates', 'id' => 'kedua kandidat'],
                            ['en' => 'professional', 'id' => 'profesional'],
                            ['en' => 'throughout the interview process', 'id' => 'sepanjang proses wawancara'],
                        ],
                        'options' => [
                            'Both candidates have been very professional throughout the interview process.',
                            'Both candidates has been very professional throughout the interview process.',
                            'Both candidates have professional throughout the interview process.',
                            'Both candidates are been very professional throughout the interview process.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'Both candidates' memakai 'have been professional'.",
                    ],
                    [
                        'id' => 18,
                        'id_sentence' => 'Pemasaran digital telah menjadi prioritas utama perusahaan sejak pandemi.',
                        'target_word' => 'has been a top priority (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'digital marketing', 'id' => 'pemasaran digital'],
                            ['en' => 'top priority', 'id' => 'prioritas utama'],
                            ['en' => 'since the pandemic', 'id' => 'sejak pandemi'],
                        ],
                        'options' => [
                            'Digital marketing has been a top priority for the company since the pandemic.',
                            'Digital marketing have been a top priority for the company since the pandemic.',
                            'Digital marketing has a top priority for the company since the pandemic.',
                            'Digital marketing was been a top priority for the company since the pandemic.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Digital marketing' adalah subjek tunggal, sehingga memakai 'has been'.",
                    ],
                    [
                        'id' => 19,
                        'id_sentence' => 'Gudang itu telah bebas dari keterlambatan pengiriman selama tiga bulan berturut-turut.',
                        'target_word' => 'has been free from (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'warehouse', 'id' => 'gudang'],
                            ['en' => 'free from shipping delays', 'id' => 'bebas dari keterlambatan pengiriman'],
                            ['en' => 'three consecutive months', 'id' => 'tiga bulan berturut-turut'],
                        ],
                        'options' => [
                            'The warehouse has been free from shipping delays for three consecutive months.',
                            'The warehouse have been free from shipping delays for three consecutive months.',
                            'The warehouse has free from shipping delays for three consecutive months.',
                            'The warehouse were free from shipping delays for three consecutive months.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The warehouse' memakai 'has been free from'.",
                    ],
                    [
                        'id' => 20,
                        'id_sentence' => 'Jadwal kerja fleksibel telah sangat membantu bagi produktivitas tim.',
                        'target_word' => 'has been very helpful (Present Perfect Nominal)',
                        'vocab' => [
                            ['en' => 'flexible work schedule', 'id' => 'jadwal kerja fleksibel'],
                            ['en' => 'very helpful', 'id' => 'sangat membantu'],
                            ['en' => 'team productivity', 'id' => 'produktivitas tim'],
                        ],
                        'options' => [
                            'The flexible work schedule has been very helpful for team productivity.',
                            'The flexible work schedule have been very helpful for team productivity.',
                            'The flexible work schedule has helpful for team productivity.',
                            'The flexible work schedule is been very helpful for team productivity.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The flexible work schedule' memakai 'has been very helpful'.",
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
                    'Verba umum: reviewed, approved, processed, shipped, installed, signed.',
                    "Subjek jamak memakai 'have been + V3', subjek tunggal memakai 'has been + V3'.",
                ],
                'exercises' => [
                    [
                        'id' => 21,
                        'id_sentence' => 'Kontrak itu telah ditinjau sejak kemarin malam.',
                        'target_word' => 'has been reviewed (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'contract', 'id' => 'kontrak'],
                            ['en' => 'reviewed', 'id' => 'ditinjau'],
                            ['en' => 'since last night', 'id' => 'sejak kemarin malam'],
                        ],
                        'options' => [
                            'The contract has been reviewed since last night.',
                            'The contract have been reviewed since last night.',
                            'The contract has being reviewed since last night.',
                            'The contract has reviewed since last night.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek pasif tunggal 'The contract' memerlukan 'has been reviewed'. Opsi C salah memakai 'being'.",
                    ],
                    [
                        'id' => 22,
                        'id_sentence' => 'Semua faktur telah diproses oleh departemen keuangan.',
                        'target_word' => 'have been processed (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'invoices', 'id' => 'faktur'],
                            ['en' => 'processed', 'id' => 'diproses'],
                            ['en' => 'finance department', 'id' => 'departemen keuangan'],
                        ],
                        'options' => [
                            'All the invoices have been processed by the finance department.',
                            'All the invoices has been processed by the finance department.',
                            'All the invoices have being processed by the finance department.',
                            'All the invoices have processed by the finance department.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'invoices' memakai 'have been processed'.",
                    ],
                    [
                        'id' => 23,
                        'id_sentence' => 'Gedung kantor itu telah direnovasi tahun ini.',
                        'target_word' => 'has been renovated (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'office building', 'id' => 'gedung kantor'],
                            ['en' => 'renovated', 'id' => 'direnovasi'],
                            ['en' => 'this year', 'id' => 'tahun ini'],
                        ],
                        'options' => [
                            'The office building has been renovated this year.',
                            'The office building have been renovated this year.',
                            'The office building has being renovated this year.',
                            'The office building was renovated this year already.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The office building' memakai 'has been renovated'.",
                    ],
                    [
                        'id' => 24,
                        'id_sentence' => 'Proposal itu telah dikirim pagi ini.',
                        'target_word' => 'has been sent (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'proposal', 'id' => 'proposal'],
                            ['en' => 'sent', 'id' => 'dikirim'],
                            ['en' => 'this morning', 'id' => 'pagi ini'],
                        ],
                        'options' => [
                            'The proposal has been sent this morning.',
                            'The proposal have been sent this morning.',
                            'The proposal has being sent this morning.',
                            'The proposal has sent this morning.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The proposal' memakai 'has been sent'.",
                    ],
                    [
                        'id' => 25,
                        'id_sentence' => 'Banyak paket telah dikirimkan ke pelanggan di luar kota.',
                        'target_word' => 'have been shipped (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'packages', 'id' => 'paket'],
                            ['en' => 'shipped', 'id' => 'dikirimkan'],
                            ['en' => 'out-of-town customers', 'id' => 'pelanggan di luar kota'],
                        ],
                        'options' => [
                            'Many packages have been shipped to out-of-town customers.',
                            'Many packages has been shipped to out-of-town customers.',
                            'Many packages have being shipped to out-of-town customers.',
                            'Many packages have ship to out-of-town customers.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'Many packages' memakai 'have been shipped'.",
                    ],
                    [
                        'id' => 26,
                        'id_sentence' => 'Perangkat lunak baru itu telah dipasang oleh tim IT.',
                        'target_word' => 'has been installed (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'new software', 'id' => 'perangkat lunak baru'],
                            ['en' => 'installed', 'id' => 'dipasang'],
                            ['en' => 'IT team', 'id' => 'tim IT'],
                        ],
                        'options' => [
                            'The new software has been installed by the IT team.',
                            'The new software have been installed by the IT team.',
                            'The new software has being installed by the IT team.',
                            'The new software has install by the IT team.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The new software' memakai 'has been installed'.",
                    ],
                    [
                        'id' => 27,
                        'id_sentence' => 'Ruang rapat itu telah dibersihkan minggu ini.',
                        'target_word' => 'have been cleaned (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'meeting rooms', 'id' => 'ruang rapat'],
                            ['en' => 'cleaned', 'id' => 'dibersihkan'],
                            ['en' => 'this week', 'id' => 'minggu ini'],
                        ],
                        'options' => [
                            'The meeting rooms have been cleaned this week.',
                            'The meeting rooms has been cleaned this week.',
                            'The meeting rooms have being cleaned this week.',
                            'The meeting rooms have clean this week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'The meeting rooms' memakai 'have been cleaned'.",
                    ],
                    [
                        'id' => 28,
                        'id_sentence' => 'Perjanjian kerja sama saya telah ditandatangani oleh direktur.',
                        'target_word' => 'has been signed (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'partnership agreement', 'id' => 'perjanjian kerja sama'],
                            ['en' => 'signed', 'id' => 'ditandatangani'],
                            ['en' => 'director', 'id' => 'direktur'],
                        ],
                        'options' => [
                            'My partnership agreement has been signed by the director.',
                            'My partnership agreement have been signed by the director.',
                            'My partnership agreement has being signed by the director.',
                            'My partnership agreement has sign by the director.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'My partnership agreement' memakai 'has been signed'.",
                    ],
                    [
                        'id' => 29,
                        'id_sentence' => 'Beberapa laptop lama telah disumbangkan ke sekolah setempat.',
                        'target_word' => 'have been donated (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'old laptops', 'id' => 'laptop lama'],
                            ['en' => 'donated', 'id' => 'disumbangkan'],
                            ['en' => 'local school', 'id' => 'sekolah setempat'],
                        ],
                        'options' => [
                            'Several old laptops have been donated to the local school.',
                            'Several old laptops has been donated to the local school.',
                            'Several old laptops have being donated to the local school.',
                            'Several old laptops have donate to the local school.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'Several old laptops' memakai 'have been donated'.",
                    ],
                    [
                        'id' => 30,
                        'id_sentence' => 'Ruang pamer itu telah dirapikan untuk tamu yang akan datang.',
                        'target_word' => 'has been tidied (Present Perfect Passive)',
                        'vocab' => [
                            ['en' => 'showroom', 'id' => 'ruang pamer'],
                            ['en' => 'tidied', 'id' => 'dirapikan'],
                            ['en' => 'incoming guests', 'id' => 'tamu yang akan datang'],
                        ],
                        'options' => [
                            'The showroom has been tidied for the incoming guests.',
                            'The showroom have been tidied for the incoming guests.',
                            'The showroom has being tidied for the incoming guests.',
                            'The showroom has tidy for the incoming guests.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The showroom' memakai 'has been tidied'.",
                    ],
                ]
            ],
            [
                'id' => 'duration-markers-for-since',
                'name' => '1.10.4 Duration Markers: For vs Since vs Over the Past',
                'code' => '1.10.4',
                'concept_title' => 'Penanda Durasi: For, Since, & Over the Past',
                'concept_description' => "Present Perfect sering dipadukan dengan penanda waktu untuk menunjukkan rentang kontinuitas. Gunakan 'since' jika merujuk pada titik awal waktu spesifik (since 2015, since the merger). Gunakan 'for' untuk total durasi (for five years, for a week). Gunakan 'over the past/last...' untuk merangkum perkembangan terkini.",
                'description' => "Present Perfect sering dipadukan dengan penanda waktu untuk menunjukkan rentang kontinuitas. Gunakan 'since' jika merujuk pada titik awal waktu spesifik (since 2015, since the merger). Gunakan 'for' untuk total durasi (for five years, for a week). Gunakan 'over the past/last...' untuk merangkum perkembangan terkini.",
                'formula' => 'Subject + have/has + V3/been + FOR (durasi) / SINCE (titik awal) / OVER THE PAST (periode)',
                'rules' => [
                    "'Since' + titik awal waktu (misal: since 2015, since Monday, since the merger).",
                    "'For' + durasi waktu (misal: for three years, for a week, for a long time).",
                    "'Over / In the past [jumlah] years' merujuk kurun waktu lampau hingga sekarang dan memakai Present Perfect.",
                    "Jangan gunakan Simple Past dengan 'since' jika kalimat merujuk pada kondisi yang berlanjut hingga kini.",
                ],
                'exercises' => [
                    [
                        'id' => 31,
                        'id_sentence' => 'Dia telah mengelola cabang ini sejak tahun 2015.',
                        'target_word' => 'has managed ... since (Duration Marker: Since)',
                        'vocab' => [
                            ['en' => 'managed', 'id' => 'mengelola'],
                            ['en' => 'this branch', 'id' => 'cabang ini'],
                            ['en' => 'since 2015', 'id' => 'sejak tahun 2015'],
                        ],
                        'options' => [
                            'He has managed this branch since 2015.',
                            'He has managed this branch for 2015.',
                            'He managed this branch since 2015.',
                            'He have managed this branch since 2015.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Titik awal waktu ('2015') memakai 'since', subjek tunggal 'He' memakai 'has managed'.",
                    ],
                    [
                        'id' => 32,
                        'id_sentence' => 'Saya telah bekerja di bidang pemasaran digital selama tiga tahun.',
                        'target_word' => 'have worked ... for (Duration Marker: For)',
                        'vocab' => [
                            ['en' => 'worked', 'id' => 'bekerja'],
                            ['en' => 'digital marketing', 'id' => 'pemasaran digital'],
                            ['en' => 'three years', 'id' => 'tiga tahun'],
                        ],
                        'options' => [
                            'I have worked in digital marketing for three years.',
                            'I have worked in digital marketing since three years.',
                            'I worked in digital marketing for three years currently.',
                            'I has worked in digital marketing for three years.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Durasi waktu ('three years') memakai 'for', subjek 'I' memakai 'have'.",
                    ],
                    [
                        'id' => 33,
                        'id_sentence' => 'Selama lima tahun terakhir, perusahaan kami telah berekspansi tiga kali.',
                        'target_word' => 'has expanded ... over the past five years (Time Frame Marker)',
                        'vocab' => [
                            ['en' => 'our company', 'id' => 'perusahaan kami'],
                            ['en' => 'expanded', 'id' => 'berekspansi'],
                            ['en' => 'over the past five years', 'id' => 'selama lima tahun terakhir'],
                        ],
                        'options' => [
                            'Over the past five years, our company has expanded three times.',
                            'Over the past five years, our company expanded three times already.',
                            'Over the past five years, our company have expanded three times.',
                            'Over the past five years, our company is expanding three times.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Over the past five years' menghubungkan masa lalu ke sekarang sehingga memakai Present Perfect 'has expanded'.",
                    ],
                    [
                        'id' => 34,
                        'id_sentence' => 'Mereka telah menjadi mitra bisnis kami sejak perusahaan ini didirikan.',
                        'target_word' => 'have been ... since (Duration Marker: Since + Clause)',
                        'vocab' => [
                            ['en' => 'business partners', 'id' => 'mitra bisnis'],
                            ['en' => 'since this company was founded', 'id' => 'sejak perusahaan ini didirikan'],
                            ['en' => 'they', 'id' => 'mereka'],
                        ],
                        'options' => [
                            'They have been our business partners since this company was founded.',
                            'They have been our business partners for this company was founded.',
                            'They were our business partners since this company was founded.',
                            'They has been our business partners since this company was founded.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Klausa awal waktu ('since this company was founded') dipakai bersama Present Perfect 'have been'.",
                    ],
                    [
                        'id' => 35,
                        'id_sentence' => 'Supervisor saya telah mengelola tim ini selama empat puluh bulan.',
                        'target_word' => 'has managed ... for (Duration Marker: For)',
                        'vocab' => [
                            ['en' => 'supervisor', 'id' => 'supervisor'],
                            ['en' => 'managed', 'id' => 'mengelola'],
                            ['en' => 'forty months', 'id' => 'empat puluh bulan'],
                        ],
                        'options' => [
                            'My supervisor has managed this team for forty months.',
                            'My supervisor has managed this team since forty months.',
                            'My supervisor have managed this team for forty months.',
                            'My supervisor managed this team for forty months now.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Durasi total ('forty months') memakai 'for', dengan subjek tunggal 'has managed'.",
                    ],
                    [
                        'id' => 36,
                        'id_sentence' => 'Dalam beberapa bulan terakhir, biaya operasional telah meningkat.',
                        'target_word' => 'has risen ... in recent months (Time Frame Marker)',
                        'vocab' => [
                            ['en' => 'operating costs', 'id' => 'biaya operasional'],
                            ['en' => 'risen', 'id' => 'meningkat'],
                            ['en' => 'in recent months', 'id' => 'dalam beberapa bulan terakhir'],
                        ],
                        'options' => [
                            'In recent months, operating costs have risen.',
                            'In recent months, operating costs rose already.',
                            'In recent months, operating costs has risen.',
                            'In recent months, operating costs is rising yesterday.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'operating costs' memakai 'have risen', dipadukan dengan penanda 'in recent months'.",
                    ],
                    [
                        'id' => 37,
                        'id_sentence' => 'Kesepakatan sewa kantor itu telah berlaku sejak awal bulan ini.',
                        'target_word' => 'has been in effect since (Nominal + Since)',
                        'vocab' => [
                            ['en' => 'office lease agreement', 'id' => 'kesepakatan sewa kantor'],
                            ['en' => 'in effect', 'id' => 'berlaku'],
                            ['en' => 'the beginning of this month', 'id' => 'awal bulan ini'],
                        ],
                        'options' => [
                            'The office lease agreement has been in effect since the beginning of this month.',
                            'The office lease agreement has been in effect for the beginning of this month.',
                            'The office lease agreement was in effect since the beginning of this month.',
                            'The office lease agreement have been in effect since the beginning of this month.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Titik waktu spesifik memakai 'since', dipadukan dengan Present Perfect Nominal 'has been in effect'.",
                    ],
                    [
                        'id' => 38,
                        'id_sentence' => 'Perusahaan itu telah beroperasi di kota ini selama tiga dekade.',
                        'target_word' => 'has operated ... for (Duration Marker: For)',
                        'vocab' => [
                            ['en' => 'company', 'id' => 'perusahaan'],
                            ['en' => 'operated', 'id' => 'beroperasi'],
                            ['en' => 'three decades', 'id' => 'tiga dekade'],
                        ],
                        'options' => [
                            'The company has operated in this city for three decades.',
                            'The company has operated in this city since three decades.',
                            'The company have operated in this city for three decades.',
                            'The company operated in this city for three decades now.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Durasi ('three decades') memakai 'for', dengan subjek tunggal 'has operated'.",
                    ],
                    [
                        'id' => 39,
                        'id_sentence' => 'Sejak beralih ke kantor baru, produktivitas tim telah meningkat.',
                        'target_word' => 'has increased ... since (Since + Noun Phrase)',
                        'vocab' => [
                            ['en' => 'switching to', 'id' => 'beralih ke'],
                            ['en' => 'increased', 'id' => 'meningkat'],
                            ['en' => 'new office', 'id' => 'kantor baru'],
                        ],
                        'options' => [
                            'Since switching to the new office, team productivity has increased.',
                            'For switching to the new office, team productivity has increased.',
                            'Since switching to the new office, team productivity increased.',
                            'Since switching to the new office, team productivity have increased.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Since' menandai titik awal perubahan, subjek tunggal 'productivity' memakai 'has increased'.",
                    ],
                    [
                        'id' => 40,
                        'id_sentence' => 'Selama satu dekade terakhir, industri ini telah berubah banyak.',
                        'target_word' => 'has changed ... over the last decade (Time Frame Marker)',
                        'vocab' => [
                            ['en' => 'this industry', 'id' => 'industri ini'],
                            ['en' => 'changed a lot', 'id' => 'berubah banyak'],
                            ['en' => 'over the last decade', 'id' => 'selama satu dekade terakhir'],
                        ],
                        'options' => [
                            'Over the last decade, this industry has changed a lot.',
                            'Over the last decade, this industry changed a lot yesterday.',
                            'Over the last decade, this industry have changed a lot.',
                            'Over the last decade, this industry is changed a lot.',
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
                'concept_description' => 'Membedakan peristiwa yang terjadi di waktu pasti di masa lalu (Simple Past: in 2019, last quarter, yesterday) dengan peristiwa yang hasilnya masih berkaitan dengan sekarang (Present Perfect: ever since, so far, recently). Menggabungkan kedua tense ini dengan tepat adalah kunci melaporkan perkembangan yang jelas.',
                'description' => 'Membedakan peristiwa yang terjadi di waktu pasti di masa lalu (Simple Past: in 2019, last quarter, yesterday) dengan peristiwa yang hasilnya masih berkaitan dengan sekarang (Present Perfect: ever since, so far, recently). Menggabungkan kedua tense ini dengan tepat adalah kunci melaporkan perkembangan yang jelas.',
                'formula' => 'Waktu Pasti: S + V2 (Penanda Waktu) | Masih Berkaitan: S + have/has + V3',
                'rules' => [
                    'Waktu pasti di masa lalu (in 2020, two years ago, last quarter) memakai Simple Past V2.',
                    'Waktu tidak pasti atau masih berlanjut (ever since, so far, recently) memakai Present Perfect.',
                    'Jangan mencampur penanda waktu pasti dengan Present Perfect dalam satu klausa yang sama.',
                    'Pola umum: ceritakan kejadian lampau dengan Simple Past, lalu hubungkan dengan dampaknya sekarang memakai Present Perfect.',
                ],
                'exercises' => [
                    [
                        'id' => 41,
                        'id_sentence' => 'Dia bergabung dengan perusahaan pada tahun 2019, dan sejak itu dia telah memimpin tim pemasaran.',
                        'target_word' => 'joined ... has led (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'joined', 'id' => 'bergabung'],
                            ['en' => 'ever since', 'id' => 'sejak itu'],
                            ['en' => 'marketing team', 'id' => 'tim pemasaran'],
                        ],
                        'options' => [
                            'She joined the company in 2019, and she has led the marketing team ever since.',
                            'She has joined the company in 2019, and she led the marketing team ever since.',
                            'She joined the company in 2019, and she lead the marketing team ever since.',
                            'She has joined the company in 2019, and she has led the marketing team ever since.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'in 2019' adalah waktu pasti, maka memakai Simple Past 'joined'. 'ever since' memakai Present Perfect 'has led'.",
                    ],
                    [
                        'id' => 42,
                        'id_sentence' => 'Kami pindah ke kantor ini dua tahun lalu, dan kami telah menyukainya sejak saat itu.',
                        'target_word' => 'moved ... have loved (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'moved', 'id' => 'pindah'],
                            ['en' => 'two years ago', 'id' => 'dua tahun lalu'],
                            ['en' => 'ever since', 'id' => 'sejak saat itu'],
                        ],
                        'options' => [
                            'We moved into this office two years ago, and we have loved it ever since.',
                            'We have moved into this office two years ago, and we loved it ever since.',
                            'We moved into this office two years ago, and we loved it ever since.',
                            'We moved into this office two years ago, and we has loved it ever since.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'two years ago' memakai Simple Past 'moved'. 'ever since' memakai Present Perfect 'have loved'.",
                    ],
                    [
                        'id' => 43,
                        'id_sentence' => 'Perusahaan membeli mesin itu pada tahun 2018, dan mesin itu telah berjalan dengan baik sejak saat itu.',
                        'target_word' => 'bought ... has run (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'bought', 'id' => 'membeli'],
                            ['en' => 'in 2018', 'id' => 'pada tahun 2018'],
                            ['en' => 'run well', 'id' => 'berjalan dengan baik'],
                        ],
                        'options' => [
                            'The company bought that machine in 2018, and it has run well ever since.',
                            'The company has bought that machine in 2018, and it run well ever since.',
                            'The company bought that machine in 2018, and it run well ever since.',
                            'The company bought that machine in 2018, and it have run well ever since.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'in 2018' memakai Simple Past 'bought', subjek tunggal 'it' memakai Present Perfect 'has run'.",
                    ],
                    [
                        'id' => 44,
                        'id_sentence' => 'Dia bertemu mitra bisnisnya di sebuah konferensi, dan mereka telah bekerja sama sejak saat itu.',
                        'target_word' => 'met ... have worked (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'met', 'id' => 'bertemu'],
                            ['en' => 'business partner', 'id' => 'mitra bisnis'],
                            ['en' => 'conference', 'id' => 'konferensi'],
                        ],
                        'options' => [
                            'She met her business partner at a conference, and they have worked together ever since.',
                            'She has met her business partner at a conference, and they have worked together ever since.',
                            'She met her business partner at a conference, and they were working together ever since.',
                            'She met her business partner at a conference, and they has worked together ever since.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'met...at a conference' adalah Simple Past, 'ever since' memakai Present Perfect 'have worked'.",
                    ],
                    [
                        'id' => 45,
                        'id_sentence' => 'Direktur kami pensiun pada tahun 2010, namun dia tetap aktif sebagai konsultan sejak itu.',
                        'target_word' => 'retired ... has stayed (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'retired', 'id' => 'pensiun'],
                            ['en' => 'in 2010', 'id' => 'pada tahun 2010'],
                            ['en' => 'stayed active as a consultant', 'id' => 'tetap aktif sebagai konsultan'],
                        ],
                        'options' => [
                            'Our director retired in 2010, but he has stayed active as a consultant since then.',
                            'Our director has retired in 2010, but he stayed active as a consultant since then.',
                            'Our director retired in 2010, but he stayed active as a consultant since then.',
                            'Our director retired in 2010, but he have stayed active as a consultant since then.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'in 2010' memakai Simple Past 'retired'. 'since then' memakai Present Perfect 'has stayed'.",
                    ],
                    [
                        'id' => 46,
                        'id_sentence' => 'Toko itu dibuka tahun lalu, dan toko itu telah ramai pelanggan sejak saat itu.',
                        'target_word' => 'opened ... has been (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'opened', 'id' => 'dibuka'],
                            ['en' => 'last year', 'id' => 'tahun lalu'],
                            ['en' => 'busy', 'id' => 'ramai'],
                        ],
                        'options' => [
                            'The store opened last year, and it has been busy with customers ever since.',
                            'The store has opened last year, and it was busy with customers ever since.',
                            'The store opened last year, and it was busy with customers ever since.',
                            'The store opened last year, and it have been busy with customers ever since.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'opened last year' adalah Simple Past, 'ever since' memakai Present Perfect 'has been'.",
                    ],
                    [
                        'id' => 47,
                        'id_sentence' => 'Saya belajar menggunakan perangkat lunak itu minggu lalu, dan sekarang saya telah memakainya lima kali.',
                        'target_word' => 'learned ... have used (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'learned', 'id' => 'belajar'],
                            ['en' => 'last week', 'id' => 'minggu lalu'],
                            ['en' => 'five times', 'id' => 'lima kali'],
                        ],
                        'options' => [
                            'I learned to use that software last week, and I have used it five times since then.',
                            'I have learned to use that software last week, and I used it five times since then.',
                            'I learned to use that software last week, and I used it five times since then.',
                            'I learned to use that software last week, and I has used it five times since then.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'last week' memakai Simple Past 'learned', subjek 'I' memakai Present Perfect 'have used'.",
                    ],
                    [
                        'id' => 48,
                        'id_sentence' => 'Mereka menandatangani kontrak itu sepuluh bulan yang lalu, dan mereka telah bekerja sama dengan baik sejak saat itu.',
                        'target_word' => 'signed ... have collaborated (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'signed', 'id' => 'menandatangani'],
                            ['en' => 'ten months ago', 'id' => 'sepuluh bulan lalu'],
                            ['en' => 'collaborated well', 'id' => 'bekerja sama dengan baik'],
                        ],
                        'options' => [
                            'They signed the contract ten months ago, and they have collaborated well ever since.',
                            'They have signed the contract ten months ago, and they collaborated well ever since.',
                            'They signed the contract ten months ago, and they collaborated well ever since.',
                            'They signed the contract ten months ago, and they has collaborated well ever since.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'ten months ago' memakai Simple Past 'signed', subjek jamak 'they' memakai Present Perfect 'have collaborated'.",
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
                        'id_sentence' => 'Kami mengunjungi pemasok itu musim panas lalu, dan kami telah berencana untuk kembali sejak saat itu.',
                        'target_word' => 'visited ... have planned (Past vs Perfect)',
                        'vocab' => [
                            ['en' => 'visited', 'id' => 'mengunjungi'],
                            ['en' => 'last summer', 'id' => 'musim panas lalu'],
                            ['en' => 'planned to go back', 'id' => 'berencana untuk kembali'],
                        ],
                        'options' => [
                            'We visited that supplier last summer, and we have planned to go back ever since.',
                            'We have visited that supplier last summer, and we planned to go back ever since.',
                            'We visited that supplier last summer, and we planned to go back ever since.',
                            'We visited that supplier last summer, and we has planned to go back ever since.',
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
                    "Sisipkan 'not' di antara auxiliary have/has dan V3 atau been (has not responded, have not been approved).",
                    "Kata 'yet' sering ditambahkan di akhir kalimat negatif untuk menegaskan sesuatu belum terjadi.",
                    'Untuk kalimat tanya, letakkan Have atau Has di awal sebelum subjek.',
                    "Jangan gunakan don't/doesn't untuk membentuk Present Perfect negatif.",
                ],
                'exercises' => [
                    [
                        'id' => 51,
                        'id_sentence' => 'Vendor itu belum merespons pertanyaan kami.',
                        'target_word' => 'has not responded (Negative Verbal)',
                        'vocab' => [
                            ['en' => 'has not responded', 'id' => 'belum merespons'],
                            ['en' => 'inquiry', 'id' => 'pertanyaan'],
                            ['en' => 'vendor', 'id' => 'vendor'],
                        ],
                        'options' => [
                            'The vendor has not responded to our inquiry yet.',
                            'The vendor have not responded to our inquiry yet.',
                            'The vendor does not have responded to our inquiry yet.',
                            'The vendor has not respond to our inquiry yet.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The vendor' memakai 'has not responded', dan 'yet' diletakkan di akhir kalimat.",
                    ],
                    [
                        'id' => 52,
                        'id_sentence' => 'Dia (perempuan) belum pernah mengunjungi kantor cabang di Surabaya.',
                        'target_word' => 'has never visited (Negative with Never)',
                        'vocab' => [
                            ['en' => 'never visited', 'id' => 'belum pernah mengunjungi'],
                            ['en' => 'branch office', 'id' => 'kantor cabang'],
                            ['en' => 'she', 'id' => 'dia'],
                        ],
                        'options' => [
                            'She has never visited the branch office in Surabaya.',
                            'She have never visited the branch office in Surabaya.',
                            'She did not never visited the branch office in Surabaya.',
                            'She has never visit the branch office in Surabaya.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'She' memakai 'has never visited'.",
                    ],
                    [
                        'id' => 53,
                        'id_sentence' => 'Mereka belum menyelesaikan audit tahunan.',
                        'target_word' => 'have not completed (Negative Verbal)',
                        'vocab' => [
                            ['en' => 'have not completed', 'id' => 'belum menyelesaikan'],
                            ['en' => 'annual audit', 'id' => 'audit tahunan'],
                            ['en' => 'they', 'id' => 'mereka'],
                        ],
                        'options' => [
                            'They have not completed the annual audit.',
                            'They has not completed the annual audit.',
                            'They do not have completed the annual audit.',
                            'They have not complete the annual audit.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'They' memakai 'have not completed'.",
                    ],
                    [
                        'id' => 54,
                        'id_sentence' => 'Sistem kami belum diperbarui sejak pagi.',
                        'target_word' => 'has not been updated (Negative Passive)',
                        'vocab' => [
                            ['en' => 'has not been updated', 'id' => 'belum diperbarui'],
                            ['en' => 'our system', 'id' => 'sistem kami'],
                            ['en' => 'since morning', 'id' => 'sejak pagi'],
                        ],
                        'options' => [
                            'Our system has not been updated since this morning.',
                            'Our system have not been updated since this morning.',
                            'Our system does not have updated since this morning.',
                            'Our system has not updated since this morning.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'Our system' memakai 'has not been updated'.",
                    ],
                    [
                        'id' => 55,
                        'id_sentence' => 'Saya belum pernah mencoba perangkat lunak itu sebelumnya.',
                        'target_word' => 'have never tried (Negative with Never)',
                        'vocab' => [
                            ['en' => 'never tried', 'id' => 'belum pernah mencoba'],
                            ['en' => 'that software', 'id' => 'perangkat lunak itu'],
                            ['en' => 'before', 'id' => 'sebelumnya'],
                        ],
                        'options' => [
                            'I have never tried that software before.',
                            'I has never tried that software before.',
                            'I did not never tried that software before.',
                            'I have never try that software before.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek 'I' memakai 'have never tried'.",
                    ],
                    [
                        'id' => 56,
                        'id_sentence' => 'Apakah kamu sudah menyelesaikan presentasimu?',
                        'target_word' => 'Have ... finished (Interrogative Verbal)',
                        'vocab' => [
                            ['en' => 'finished', 'id' => 'menyelesaikan'],
                            ['en' => 'presentation', 'id' => 'presentasi'],
                            ['en' => 'you', 'id' => 'kamu'],
                        ],
                        'options' => [
                            'Have you finished your presentation?',
                            'Has you finished your presentation?',
                            'Did you have finished your presentation?',
                            'Have you finish your presentation?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek 'you' diawali 'Have' + Subject + V3 'finished'.",
                    ],
                    [
                        'id' => 57,
                        'id_sentence' => 'Apakah dia (perempuan) pernah bekerja di luar negeri?',
                        'target_word' => 'Has ... ever worked (Interrogative with Ever)',
                        'vocab' => [
                            ['en' => 'ever worked', 'id' => 'pernah bekerja'],
                            ['en' => 'abroad', 'id' => 'di luar negeri'],
                            ['en' => 'she', 'id' => 'dia'],
                        ],
                        'options' => [
                            'Has she ever worked abroad?',
                            'Have she ever worked abroad?',
                            'Did she ever work abroad before?',
                            'Has she ever work abroad?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'she' diawali dengan 'Has' + Subject + V3 'worked'.",
                    ],
                    [
                        'id' => 58,
                        'id_sentence' => 'Apakah mereka sudah mengirimkan kontraknya?',
                        'target_word' => 'Have ... sent ... yet (Interrogative with Yet)',
                        'vocab' => [
                            ['en' => 'sent', 'id' => 'mengirimkan'],
                            ['en' => 'yet', 'id' => 'sudah/belum'],
                            ['en' => 'they', 'id' => 'mereka'],
                        ],
                        'options' => [
                            'Have they sent the contract yet?',
                            'Has they sent the contract yet?',
                            'Did they send the contract yet?',
                            'Have they have sent the contract yet?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'they' diawali 'Have' + Subject + V3 'sent', dengan 'yet' di akhir.",
                    ],
                    [
                        'id' => 59,
                        'id_sentence' => 'Apakah supervisormu pernah menyetujui anggaran sebesar itu?',
                        'target_word' => 'Has ... ever approved (Interrogative with Ever)',
                        'vocab' => [
                            ['en' => 'ever approved', 'id' => 'pernah menyetujui'],
                            ['en' => 'a budget that large', 'id' => 'anggaran sebesar itu'],
                            ['en' => 'your supervisor', 'id' => 'supervisormu'],
                        ],
                        'options' => [
                            'Has your supervisor ever approved a budget that large?',
                            'Have your supervisor ever approved a budget that large?',
                            'Did your supervisor ever approved a budget that large?',
                            'Has your supervisor ever approve a budget that large?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'your supervisor' diawali 'Has' + Subject + V3 'approved'.",
                    ],
                    [
                        'id' => 60,
                        'id_sentence' => 'Apakah kalian sudah membeli lisensinya?',
                        'target_word' => 'Have ... bought ... yet (Interrogative with Yet)',
                        'vocab' => [
                            ['en' => 'bought', 'id' => 'membeli'],
                            ['en' => 'the license', 'id' => 'lisensinya'],
                            ['en' => 'yet', 'id' => 'sudah/belum'],
                        ],
                        'options' => [
                            'Have you bought the license yet?',
                            'Has you bought the license yet?',
                            'Did you bought the license yet?',
                            'Have you buy the license yet?',
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
                        'id_sentence' => 'Saya baru saja menyelesaikan laporan mingguan saya.',
                        'target_word' => 'have just finished (Adverb Placement: Just)',
                        'vocab' => [
                            ['en' => 'just finished', 'id' => 'baru saja menyelesaikan'],
                            ['en' => 'weekly report', 'id' => 'laporan mingguan'],
                            ['en' => 'I', 'id' => 'saya'],
                        ],
                        'options' => [
                            'I have just finished my weekly report.',
                            'I just have finished my weekly report.',
                            'I have finished just my weekly report.',
                            'I has just finished my weekly report.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Adverbia 'just' disisipkan tepat di antara auxiliary 'have' dan V3 'finished'.",
                    ],
                    [
                        'id' => 62,
                        'id_sentence' => 'Dia (perempuan) sudah mengirimkan undangannya lebih awal.',
                        'target_word' => 'has already sent (Adverb Placement: Already)',
                        'vocab' => [
                            ['en' => 'already sent', 'id' => 'sudah mengirimkan'],
                            ['en' => 'invitations', 'id' => 'undangan'],
                            ['en' => 'early', 'id' => 'lebih awal'],
                        ],
                        'options' => [
                            'She has already sent the invitations.',
                            'She already has sent the invitations.',
                            'She has sent already the invitations.',
                            'She have already sent the invitations.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'has already sent' adalah posisi standar untuk adverbia 'already'.",
                    ],
                    [
                        'id' => 63,
                        'id_sentence' => 'Kami baru-baru ini mengunjungi fasilitas pabrik yang baru.',
                        'target_word' => 'have recently visited (Adverb Placement: Recently)',
                        'vocab' => [
                            ['en' => 'recently visited', 'id' => 'baru-baru ini mengunjungi'],
                            ['en' => 'new factory facility', 'id' => 'fasilitas pabrik yang baru'],
                            ['en' => 'we', 'id' => 'kami'],
                        ],
                        'options' => [
                            'We have recently visited the new factory facility.',
                            'We has recently visited the new factory facility.',
                            'We recently have visit the new factory facility.',
                            'We have visited recently the new factory facility.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'We' memakai 'have recently visited'.",
                    ],
                    [
                        'id' => 64,
                        'id_sentence' => 'Pemasok itu belum pernah mengecewakan kami.',
                        'target_word' => 'has never disappointed (Adverb Placement: Never)',
                        'vocab' => [
                            ['en' => 'never disappointed', 'id' => 'belum pernah mengecewakan'],
                            ['en' => 'us', 'id' => 'kami'],
                            ['en' => 'supplier', 'id' => 'pemasok'],
                        ],
                        'options' => [
                            'That supplier has never disappointed us.',
                            'That supplier have never disappointed us.',
                            'That supplier never has disappointed us.',
                            'That supplier has disappointed never us.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'That supplier' memakai 'has never disappointed'.",
                    ],
                    [
                        'id' => 65,
                        'id_sentence' => 'Sejauh ini, saya telah membaca tiga laporan pasar bulan ini.',
                        'target_word' => 'have read ... so far (Adverbial Fronting: So far)',
                        'vocab' => [
                            ['en' => 'so far', 'id' => 'sejauh ini'],
                            ['en' => 'read three market reports', 'id' => 'membaca tiga laporan pasar'],
                            ['en' => 'this month', 'id' => 'bulan ini'],
                        ],
                        'options' => [
                            'So far, I have read three market reports this month.',
                            'So far, I has read three market reports this month.',
                            'So far, I read three market reports this month yesterday.',
                            'So far, I have reading three market reports this month.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'So far' dipadukan dengan Present Perfect 'have read'.",
                    ],
                    [
                        'id' => 66,
                        'id_sentence' => 'Perusahaan belum mengumumkan jadwal peluncurannya.',
                        'target_word' => 'has not yet announced (Adverb Placement: Yet)',
                        'vocab' => [
                            ['en' => 'not yet announced', 'id' => 'belum mengumumkan'],
                            ['en' => 'launch schedule', 'id' => 'jadwal peluncuran'],
                            ['en' => 'company', 'id' => 'perusahaan'],
                        ],
                        'options' => [
                            'The company has not yet announced the launch schedule.',
                            'The company have not yet announced the launch schedule.',
                            'The company has not announced yet the launch schedule.',
                            'The company does not yet announced the launch schedule.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The company' memakai pola 'has not yet announced'.",
                    ],
                    [
                        'id' => 67,
                        'id_sentence' => 'Direktur baru saja menyetujui proposal itu.',
                        'target_word' => 'has just approved (Adverb Placement: Just)',
                        'vocab' => [
                            ['en' => 'just approved', 'id' => 'baru saja menyetujui'],
                            ['en' => 'proposal', 'id' => 'proposal'],
                            ['en' => 'director', 'id' => 'direktur'],
                        ],
                        'options' => [
                            'The director has just approved the proposal.',
                            'The director have just approved the proposal.',
                            'The director just has approved the proposal.',
                            'The director has approved just the proposal.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The director' memakai 'has just approved'.",
                    ],
                    [
                        'id' => 68,
                        'id_sentence' => 'Toko itu sudah mengeluarkan penawaran spesial.',
                        'target_word' => 'has already offered (Adverb Placement: Already)',
                        'vocab' => [
                            ['en' => 'already offered', 'id' => 'sudah mengeluarkan'],
                            ['en' => 'a special offer', 'id' => 'penawaran spesial'],
                            ['en' => 'shop', 'id' => 'toko'],
                        ],
                        'options' => [
                            'The shop has already offered a special deal.',
                            'The shop have already offered a special deal.',
                            'The shop already has offered a special deal.',
                            'The shop has offered already a special deal.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'The shop' memakai 'has already offered'.",
                    ],
                    [
                        'id' => 69,
                        'id_sentence' => 'Beberapa rekan kerja saya baru-baru ini pindah ke departemen lain.',
                        'target_word' => 'have recently moved (Adverb Placement: Recently)',
                        'vocab' => [
                            ['en' => 'recently moved', 'id' => 'baru-baru ini pindah'],
                            ['en' => 'some of my coworkers', 'id' => 'beberapa rekan kerja saya'],
                            ['en' => 'another department', 'id' => 'departemen lain'],
                        ],
                        'options' => [
                            'Some of my coworkers have recently moved to another department.',
                            'Some of my coworkers has recently moved to another department.',
                            'Some of my coworkers have moved recently to another department last week.',
                            'Some of my coworkers recently have move to another department.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'Some of my coworkers' memakai 'have recently moved'.",
                    ],
                    [
                        'id' => 70,
                        'id_sentence' => 'Apakah kamu pernah menegosiasikan kontrak sebesar itu?',
                        'target_word' => 'Have you ever negotiated (Interrogative with Ever)',
                        'vocab' => [
                            ['en' => 'ever negotiated', 'id' => 'pernah menegosiasikan'],
                            ['en' => 'a contract that large', 'id' => 'kontrak sebesar itu'],
                            ['en' => 'you', 'id' => 'kamu'],
                        ],
                        'options' => [
                            'Have you ever negotiated a contract that large?',
                            'Did you ever negotiated a contract that large?',
                            'Have you negotiated ever a contract that large?',
                            'Has you ever negotiated a contract that large?',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Pola baku pertanyaan pengalaman adalah 'Have you ever' + V3 'negotiated'.",
                    ],
                ]
            ],
            [
                'id' => 'literature-review-synthesis',
                'name' => '1.10.8 Comprehensive Synthesis: Combining Verbal, Nominal & Passive Forms',
                'code' => '1.10.8',
                'concept_title' => 'Sintesis Komprehensif: Menggabungkan Bentuk Verbal, Nominal & Pasif',
                'concept_description' => 'Menggabungkan bentuk verbal, nominal, dan pasif Present Perfect dalam satu laporan sehari-hari yang utuh. Melatih kemampuan merangkai dua klausa Present Perfect secara alami, misalnya saat melaporkan perubahan di kantor, proyek, atau lingkungan bisnis sekitar.',
                'description' => 'Menggabungkan bentuk verbal, nominal, dan pasif Present Perfect dalam satu laporan sehari-hari yang utuh. Melatih kemampuan merangkai dua klausa Present Perfect secara alami, misalnya saat melaporkan perubahan di kantor, proyek, atau lingkungan bisnis sekitar.',
                'formula' => 'Klausa Present Perfect 1 (Verbal/Nominal/Pasif) + Klausa Present Perfect 2 (Verbal/Nominal/Pasif)',
                'rules' => [
                    "Gunakan Present Perfect pasif untuk menonjolkan hasil kerja ('The office has been renovated...').",
                    "Gunakan Present Perfect aktif untuk menonjolkan siapa yang melakukannya ('...staff have started using the new space').",
                    'Jaga konsistensi have/has sesuai subjek di setiap klausa, meskipun digabung dalam satu kalimat.',
                    'Pastikan keselarasan gramatikal (Subject-Verb Agreement) terjaga di kedua klausa.',
                ],
                'exercises' => [
                    [
                        'id' => 71,
                        'id_sentence' => 'Kantor kami telah direnovasi, dan kantor itu telah terlihat sangat modern sejak saat itu.',
                        'target_word' => 'has been renovated ... has looked (Passive + Nominal Synthesis)',
                        'vocab' => [
                            ['en' => 'renovated', 'id' => 'direnovasi'],
                            ['en' => 'looked modern', 'id' => 'terlihat modern'],
                            ['en' => 'our office', 'id' => 'kantor kami'],
                        ],
                        'options' => [
                            'Our office has been renovated, and it has looked very modern ever since.',
                            'Our office have been renovated, and it has looked very modern ever since.',
                            'Our office has been renovated, and it have looked very modern ever since.',
                            'Our office was renovated, and it has looked very modern ever since already.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kedua klausa memakai subjek tunggal 'it/office', sehingga memakai 'has been renovated' dan 'has looked'.",
                    ],
                    [
                        'id' => 72,
                        'id_sentence' => 'Dia (perempuan) telah belajar negosiasi, dan kesepakatan yang dia buat telah menjadi lebih menguntungkan.',
                        'target_word' => 'has learned ... has become (Verbal + Nominal Synthesis)',
                        'vocab' => [
                            ['en' => 'learned negotiation', 'id' => 'belajar negosiasi'],
                            ['en' => 'become more profitable', 'id' => 'menjadi lebih menguntungkan'],
                            ['en' => 'her deals', 'id' => 'kesepakatannya'],
                        ],
                        'options' => [
                            'She has learned negotiation, and her deals has become more profitable.',
                            'She have learned negotiation, and her deals has become more profitable.',
                            'She has learned negotiation, and her deals have become more profitable.',
                            'She has learn negotiation, and her deals has become more profitable.',
                        ],
                        'correct_index' => 2,
                        'explanation' => "Subjek tunggal 'She' memakai 'has learned', subjek jamak 'her deals' memakai 'have become'.",
                    ],
                    [
                        'id' => 73,
                        'id_sentence' => 'Banyak dokumen telah diunggah ke sistem perusahaan, dan sistem itu telah menjadi lebih terorganisir.',
                        'target_word' => 'have been uploaded ... has become (Passive + Nominal Synthesis)',
                        'vocab' => [
                            ['en' => 'uploaded', 'id' => 'diunggah'],
                            ['en' => 'company system', 'id' => 'sistem perusahaan'],
                            ['en' => 'become more organized', 'id' => 'menjadi lebih terorganisir'],
                        ],
                        'options' => [
                            'Many documents have been uploaded to the company system, and it has become more organized.',
                            'Many documents has been uploaded to the company system, and it has become more organized.',
                            'Many documents have been uploaded to the company system, and it have become more organized.',
                            'Many documents have being uploaded to the company system, and it has become more organized.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'documents' (jamak) memakai 'have been uploaded', 'it/system' (tunggal) memakai 'has become'.",
                    ],
                    [
                        'id' => 74,
                        'id_sentence' => 'Kami telah merekrut banyak staf baru, dan tim kami telah terlihat jauh lebih kuat.',
                        'target_word' => 'have hired ... has looked (Verbal + Nominal Synthesis)',
                        'vocab' => [
                            ['en' => 'hired', 'id' => 'merekrut'],
                            ['en' => 'new staff', 'id' => 'staf baru'],
                            ['en' => 'looked much stronger', 'id' => 'terlihat jauh lebih kuat'],
                        ],
                        'options' => [
                            'We have hired many new staff, and our team has looked much stronger.',
                            'We has hired many new staff, and our team has looked much stronger.',
                            'We have hired many new staff, and our team have looked much stronger.',
                            'We have hire many new staff, and our team has looked much stronger.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek jamak 'We' memakai 'have hired', subjek tunggal 'our team' memakai 'has looked'.",
                    ],
                    [
                        'id' => 75,
                        'id_sentence' => 'Jalur produksi itu telah diperbaiki, dan waktu pengiriman telah menjadi lebih cepat.',
                        'target_word' => 'has been repaired ... has become (Passive + Nominal Synthesis)',
                        'vocab' => [
                            ['en' => 'repaired', 'id' => 'diperbaiki'],
                            ['en' => 'production line', 'id' => 'jalur produksi'],
                            ['en' => 'become faster', 'id' => 'menjadi lebih cepat'],
                        ],
                        'options' => [
                            'The production line has been repaired, and delivery time has become faster.',
                            'The production line have been repaired, and delivery time has become faster.',
                            'The production line has been repaired, and delivery time have become faster.',
                            'The production line was repaired, and delivery time has become faster recently last year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kedua subjek tunggal ('line' dan 'delivery time') memakai 'has'.",
                    ],
                    [
                        'id' => 76,
                        'id_sentence' => 'Rekan kerja saya telah belajar memimpin rapat, dan dia telah tampil di tiga presentasi klien.',
                        'target_word' => 'has learned ... has presented (Dual Verbal Synthesis)',
                        'vocab' => [
                            ['en' => 'learned to lead meetings', 'id' => 'belajar memimpin rapat'],
                            ['en' => 'presented', 'id' => 'tampil'],
                            ['en' => 'client presentations', 'id' => 'presentasi klien'],
                        ],
                        'options' => [
                            'My coworker has learned to lead meetings, and she has presented at three client presentations.',
                            'My coworker have learned to lead meetings, and she has presented at three client presentations.',
                            'My coworker has learned to lead meetings, and she has present at three client presentations.',
                            'My coworker has learn to lead meetings, and she has presented at three client presentations.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Subjek tunggal 'My coworker/she' memakai 'has learned' dan 'has presented' secara konsisten.",
                    ],
                    [
                        'id' => 77,
                        'id_sentence' => 'Lobi kantor telah dibersihkan, dan karyawan telah mulai menggunakan ruang itu untuk istirahat.',
                        'target_word' => 'has been cleaned ... have started (Passive + Verbal Synthesis)',
                        'vocab' => [
                            ['en' => 'cleaned', 'id' => 'dibersihkan'],
                            ['en' => 'office lobby', 'id' => 'lobi kantor'],
                            ['en' => 'started using', 'id' => 'mulai menggunakan'],
                        ],
                        'options' => [
                            'The office lobby has been cleaned, and employees have started using the space for breaks.',
                            'The office lobby have been cleaned, and employees have started using the space for breaks.',
                            'The office lobby has been cleaned, and employees has started using the space for breaks.',
                            'The office lobby has being cleaned, and employees have started using the space for breaks.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'The office lobby' (tunggal) memakai 'has been cleaned', 'employees' (jamak) memakai 'have started'.",
                    ],
                    [
                        'id' => 78,
                        'id_sentence' => 'Biaya pengiriman telah naik, namun pesanan daring tetap tinggi.',
                        'target_word' => 'have risen ... has stayed (Verbal + Nominal Synthesis)',
                        'vocab' => [
                            ['en' => 'risen', 'id' => 'naik'],
                            ['en' => 'shipping costs', 'id' => 'biaya pengiriman'],
                            ['en' => 'stayed high', 'id' => 'tetap tinggi'],
                        ],
                        'options' => [
                            'Shipping costs have risen, but online orders has still been high.',
                            'Shipping costs has risen, but online orders has still been high.',
                            'Shipping costs have risen, but online orders have still been high.',
                            'Shipping costs have rise, but online orders has still been high.',
                        ],
                        'correct_index' => 2,
                        'explanation' => "'Shipping costs' (jamak) memakai 'have risen', 'online orders' (jamak) memakai 'have...been'.",
                    ],
                    [
                        'id' => 79,
                        'id_sentence' => 'Perusahaan itu telah pindah ke kantor baru, dan kantor lama mereka telah disewakan ke penyewa lain.',
                        'target_word' => 'has moved ... has been leased (Verbal + Passive Synthesis)',
                        'vocab' => [
                            ['en' => 'moved', 'id' => 'pindah'],
                            ['en' => 'new office', 'id' => 'kantor baru'],
                            ['en' => 'leased', 'id' => 'disewakan'],
                        ],
                        'options' => [
                            'The company has moved to a new office, and their old office has been leased to another tenant.',
                            'The company have moved to a new office, and their old office has been leased to another tenant.',
                            'The company has moved to a new office, and their old office have been leased to another tenant.',
                            'The company has moved to a new office, and their old office has being leased to another tenant.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "Kedua subjek tunggal ('company' dan 'old office') memakai 'has'.",
                    ],
                    [
                        'id' => 80,
                        'id_sentence' => 'Perusahaan kami telah menyelenggarakan banyak acara tahun ini, dan semua acara itu telah berjalan lancar.',
                        'target_word' => 'has held ... have gone (Verbal + Nominal Synthesis)',
                        'vocab' => [
                            ['en' => 'held', 'id' => 'menyelenggarakan'],
                            ['en' => 'many events', 'id' => 'banyak acara'],
                            ['en' => 'gone smoothly', 'id' => 'berjalan lancar'],
                        ],
                        'options' => [
                            'Our company has held many events this year, and all of them have gone smoothly.',
                            'Our company have held many events this year, and all of them have gone smoothly.',
                            'Our company has held many events this year, and all of them has gone smoothly.',
                            'Our company has hold many events this year, and all of them have gone smoothly.',
                        ],
                        'correct_index' => 0,
                        'explanation' => "'Our company' (tunggal) memakai 'has held', 'all of them' (jamak) memakai 'have gone'.",
                    ],
                ]
            ],
        ];
    }
}
