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
            'banner_subtitle' => 'Kuasai cara menyatakan hal yang sedang berlangsung saat ini (is/are + V-ing), proses yang sedang dikerjakan pihak lain (is/are being + V3), kontras rutinitas vs situasi sementara, serta kata kerja yang tidak boleh memakai bentuk -ing.',
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
            'concept_summary' => 'Present Continuous Tense dipakai untuk menyatakan hal yang sedang berlangsung saat ini, tepat pada saat kita berbicara, atau situasi sementara yang sedang berjalan dalam periode belakangan ini. Dua pola utamanya adalah Bentuk Verbal Aktif (is/am/are + V-ing), untuk subjek yang sedang melakukan sesuatu, dan Bentuk Pasif (is/am/are + being + V3), untuk sesuatu yang sedang dikerjakan oleh pihak lain.',
            'rules' => [
                [
                    'rule_title' => '1. Bentuk Verbal Aktif: Hal yang Sedang Berlangsung Sekarang',
                    'rule_formula' => 'Subject + am/is/are + Verb-ing + Pelengkap',
                    'rule_description' => 'Digunakan ketika subjek sedang melakukan sesuatu tepat saat ini. "is" untuk subjek tunggal, "are" untuk subjek jamak, dan "am" untuk subjek I.',
                    'examples' => [
                        [
                            'en' => 'The technician is currently repairing the printer in the office.',
                            'id' => 'Teknisi itu sedang memperbaiki printer di kantor.',
                            'note' => 'Subjek tunggal "The technician" menggunakan to be "is" + V-ing "repairing".'
                        ]
                    ]
                ],
                [
                    'rule_title' => '2. Menjelaskan Sesuatu yang Sedang Berubah',
                    'rule_formula' => 'Subject + is/are + kata kerja perubahan (-ing)',
                    'rule_description' => 'Kata kerja perubahan seperti get, grow, change, improve, increase, dan decrease dipadukan dengan continuous tense untuk menggambarkan sesuatu yang sedang berlangsung dan belum selesai.',
                    'examples' => [
                        [
                            'en' => 'Sales are steadily increasing this month.',
                            'id' => 'Penjualan terus meningkat secara stabil bulan ini.',
                            'note' => 'Menunjukkan perubahan yang sedang berlangsung, belum berakhir.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '3. Bentuk Pasif: Sesuatu yang Sedang Dikerjakan (is/are + being + V3)',
                    'rule_formula' => 'Subject (penerima) + am/is/are + being + Verb 3 (Past Participle)',
                    'rule_description' => 'Dipakai saat fokus kalimat adalah benda atau proses yang SEDANG dikerjakan/diurus, bukan siapa yang mengerjakannya. Kata "being" wajib ada di antara to be dan V3.',
                    'examples' => [
                        [
                            'en' => 'The new policy is being reviewed by the management team right now.',
                            'id' => 'Kebijakan baru itu sedang ditinjau oleh tim manajemen sekarang.',
                            'note' => 'Bandingkan: "is reviewed" (fakta biasa) vs "is being reviewed" (sedang berlangsung sekarang).'
                        ]
                    ]
                ],
                [
                    'rule_title' => '4. Kebiasaan Rutin (Simple Present) vs Situasi Sementara (Continuous)',
                    'rule_formula' => 'Rutin: Subject + V1/V-s | Sementara: Subject + is/are + V-ing',
                    'rule_description' => 'Gunakan Simple Present untuk kebiasaan atau fakta sehari-hari. Gunakan Present Continuous bila hal itu hanya berlaku sekarang/hari ini/minggu ini, biasanya ditandai kata seperti "today, right now, this week, at the moment".',
                    'examples' => [
                        [
                            'en' => 'She usually commutes by train, but this week she is driving to work.',
                            'id' => 'Dia biasanya naik kereta, tapi minggu ini dia berkendara ke kantor.',
                            'note' => '"usually commutes" = kebiasaan, "is driving" = situasi khusus minggu ini.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '5. Kata Kerja yang Tidak Boleh Memakai Bentuk -ing (Stative Verbs)',
                    'rule_formula' => 'Subject + Stative Verb (bentuk Simple Present)',
                    'rule_description' => 'Kata kerja yang menyatakan perasaan, pikiran, kepemilikan, atau isi (misalnya: understand, believe, have, like, want, need, know, contain, belong) TIDAK memakai bentuk -ing, walaupun maknanya tentang "sekarang".',
                    'examples' => [
                        [
                            'en' => 'I understand the proposal now. (BUKAN: I am understanding the proposal now.)',
                            'id' => 'Saya memahami proposal itu sekarang.',
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
                            'en' => 'The vendors are not responding to the new regulation yet.',
                            'id' => 'Para pedagang belum menanggapi peraturan baru itu.',
                            'note' => 'Bentuk negatif: are + not + V-ing.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '7. Kata Keterangan Waktu Bersama Continuous Tense',
                    'rule_formula' => 'right now, at the moment, today, currently, these days',
                    'rule_description' => 'Kata keterangan waktu ini biasa diletakkan di antara to be dan kata kerja utama (misalnya: "is currently reviewing") atau di awal kalimat ("Right now, the team is...") untuk memperjelas bahwa hal itu berlaku saat ini.',
                    'examples' => [
                        [
                            'en' => 'Right now, the maintenance crew is inspecting the elevator.',
                            'id' => 'Sekarang, tim perawatan sedang memeriksa lift.',
                            'note' => '"Right now" diletakkan di awal kalimat untuk menegaskan waktu kejadian.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '8. Menggabungkan Dua Kejadian yang Sedang Berlangsung Bersamaan',
                    'rule_formula' => 'While/Because/As + Klausa 1 (Continuous) + Koma + Klausa 2 (Continuous)',
                    'rule_description' => 'Gunakan kata sambung seperti "while" (sementara/selagi) atau "because"/"as" (karena) untuk menghubungkan dua hal yang sedang berlangsung pada waktu yang sama.',
                    'examples' => [
                        [
                            'en' => 'While the contractor is renovating the lobby, the staff are working from the second floor.',
                            'id' => 'Sementara kontraktor sedang merenovasi lobi, staf sedang bekerja di lantai dua.',
                            'note' => 'Dua klausa continuous digabung dengan "while" karena berlangsung bersamaan.'
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
                'name' => '1.9.1 Present Continuous Verbal: Hal yang Sedang Berlangsung Sekarang',
                'code' => '1.9.1',
                'concept_title' => 'Present Continuous Verbal: Hal yang Sedang Berlangsung Sekarang',
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
                        'id_sentence' => 'Teknisi itu sedang memperbaiki printer kantor yang macet sejak pagi.',
                        'target_word' => 'is repairing (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'technician', 'id' => 'teknisi'],
                            ['en' => 'office printer', 'id' => 'printer kantor'],
                            ['en' => 'repairing', 'id' => 'memperbaiki']
                        ],
                        'options' => [
                            'The technician is repairing the office printer that has been jammed since morning.',
                            'The technician are repairing the office printer that has been jammed since morning.',
                            'The technician is repair the office printer that has been jammed since morning.',
                            'The technician repairing the office printer that has been jammed since morning.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "The technician" membutuhkan to be "is" diikuti V-ing "repairing".'
                    ],
                    [
                        'id' => 2,
                        'id_sentence' => 'Manajer proyek sedang menyusun anggaran untuk kuartal berikutnya.',
                        'target_word' => 'is preparing (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'project manager', 'id' => 'manajer proyek'],
                            ['en' => 'budget', 'id' => 'anggaran'],
                            ['en' => 'next quarter', 'id' => 'kuartal berikutnya']
                        ],
                        'options' => [
                            'The project manager is preparing the budget for next quarter.',
                            'The project manager are preparing the budget for next quarter.',
                            'The project manager is prepare the budget for next quarter.',
                            'The project manager preparing the budget for next quarter.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "The project manager" berpasangan dengan "is preparing".'
                    ],
                    [
                        'id' => 3,
                        'id_sentence' => 'Instruktur itu sedang menjelaskan prosedur keselamatan kepada karyawan baru.',
                        'target_word' => 'is explaining (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'instructor', 'id' => 'instruktur'],
                            ['en' => 'safety procedure', 'id' => 'prosedur keselamatan'],
                            ['en' => 'new employees', 'id' => 'karyawan baru']
                        ],
                        'options' => [
                            'The instructor is explaining the safety procedure to the new employees.',
                            'The instructor are explaining the safety procedure to the new employees.',
                            'The instructor is explained the safety procedure to the new employees.',
                            'The instructor explaining the safety procedure to the new employees.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "The instructor" berpasangan dengan "is" + V-ing "explaining".'
                    ],
                    [
                        'id' => 4,
                        'id_sentence' => 'Para relawan sedang mendistribusikan bantuan di daerah yang terdampak banjir.',
                        'target_word' => 'are distributing (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'volunteers', 'id' => 'relawan'],
                            ['en' => 'distributing aid', 'id' => 'mendistribusikan bantuan'],
                            ['en' => 'flood-affected area', 'id' => 'daerah terdampak banjir']
                        ],
                        'options' => [
                            'The volunteers are distributing aid in the flood-affected area.',
                            'The volunteers is distributing aid in the flood-affected area.',
                            'The volunteers are distribute aid in the flood-affected area.',
                            'The volunteers distributing aid in the flood-affected area.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "The volunteers" membutuhkan to be jamak "are" sebelum "distributing".'
                    ],
                    [
                        'id' => 5,
                        'id_sentence' => 'Dokter itu sedang memeriksa seorang pasien di klinik rawat jalan.',
                        'target_word' => 'is examining (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'doctor', 'id' => 'dokter'],
                            ['en' => 'outpatient clinic', 'id' => 'klinik rawat jalan'],
                            ['en' => 'examining', 'id' => 'memeriksa']
                        ],
                        'options' => [
                            'The doctor is examining a patient at the outpatient clinic.',
                            'The doctor are examining a patient at the outpatient clinic.',
                            'The doctor is examine a patient at the outpatient clinic.',
                            'The doctor has examining a patient at the outpatient clinic.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"The doctor" adalah subjek tunggal, maka bentuk yang tepat adalah "is examining".'
                    ],
                    [
                        'id' => 6,
                        'id_sentence' => 'Tim pemasaran sedang mengerjakan proposal untuk klien baru.',
                        'target_word' => 'is working (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'marketing team', 'id' => 'tim pemasaran'],
                            ['en' => 'proposal', 'id' => 'proposal'],
                            ['en' => 'new client', 'id' => 'klien baru']
                        ],
                        'options' => [
                            'The marketing team is working on a proposal for a new client.',
                            'The marketing team are working on a proposal for a new client.',
                            'The marketing team are works on a proposal for a new client.',
                            'The marketing team were working on a proposal for a new client.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Team" diperlakukan sebagai subjek tunggal dalam konteks ini, sehingga menggunakan "is working". Pilihan "were" salah karena merujuk masa lampau.'
                    ],
                    [
                        'id' => 7,
                        'id_sentence' => 'Ketua RW sedang mengatur jadwal kerja bakti untuk warga kompleks.',
                        'target_word' => 'is arranging (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'neighborhood head', 'id' => 'ketua RW'],
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
                        'id_sentence' => 'Arsitek itu sedang merancang tata letak baru untuk ruang kantor.',
                        'target_word' => 'is designing (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'architect', 'id' => 'arsitek'],
                            ['en' => 'designing', 'id' => 'merancang'],
                            ['en' => 'office layout', 'id' => 'tata letak kantor']
                        ],
                        'options' => [
                            'The architect is designing a new layout for the office space.',
                            'The architect are designing a new layout for the office space.',
                            'The architect is design a new layout for the office space.',
                            'The architect being designing a new layout for the office space.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "The architect" menggunakan "is" + V-ing "designing".'
                    ],
                    [
                        'id' => 9,
                        'id_sentence' => 'Beberapa nelayan sedang mencatat hasil tangkapan untuk laporan koperasi.',
                        'target_word' => 'are recording (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'fishermen', 'id' => 'nelayan'],
                            ['en' => 'catch', 'id' => 'hasil tangkapan'],
                            ['en' => 'cooperative report', 'id' => 'laporan koperasi']
                        ],
                        'options' => [
                            'Some fishermen are recording the catch for the cooperative report.',
                            'Some fishermen is recording the catch for the cooperative report.',
                            'Some fishermen are recorded the catch for the cooperative report.',
                            'Some fishermen recording the catch for the cooperative report.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Fishermen" (jamak) berpasangan dengan "are recording".'
                    ],
                    [
                        'id' => 10,
                        'id_sentence' => 'Petugas perpustakaan sedang menata koleksi buku terbaru di rak referensi.',
                        'target_word' => 'is arranging (Present Continuous Verbal)',
                        'vocab' => [
                            ['en' => 'librarian', 'id' => 'petugas perpustakaan'],
                            ['en' => 'latest collection', 'id' => 'koleksi terbaru'],
                            ['en' => 'reference shelf', 'id' => 'rak referensi']
                        ],
                        'options' => [
                            'The librarian is arranging the latest collection on the reference shelf.',
                            'The librarian are arranging the latest collection on the reference shelf.',
                            'The librarian is arrange the latest collection on the reference shelf.',
                            'The librarian arranging the latest collection on the reference shelf.'
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
                'concept_description' => 'Present Continuous juga dipakai dengan kata kerja perubahan untuk menggambarkan sesuatu yang sedang berlangsung dan belum selesai, misalnya tren pasar, biaya, atau pertumbuhan suatu usaha.',
                'description' => 'Present Continuous juga dipakai dengan kata kerja perubahan untuk menggambarkan sesuatu yang sedang berlangsung dan belum selesai, misalnya tren pasar, biaya, atau pertumbuhan suatu usaha.',
                'formula' => 'Subject + is/are + kata kerja perubahan (-ing) + Keterangan',
                'rules' => [
                    'Kata kerja perubahan yang umum: get, grow, change, improve, increase, decrease, rise, fall, expand.',
                    'Perhatikan inti subjek untuk menentukan to be yang tepat.',
                    'Bisa dipadukan dengan kata seperti "steadily, gradually, more and more" untuk memperjelas.'
                ],
                'exercises' => [
                    [
                        'id' => 11,
                        'id_sentence' => 'Harga bahan bangunan sedang naik akhir-akhir ini karena permintaan tinggi.',
                        'target_word' => 'is rising (Trend of Change)',
                        'vocab' => [
                            ['en' => 'construction materials', 'id' => 'bahan bangunan'],
                            ['en' => 'rising', 'id' => 'naik'],
                            ['en' => 'high demand', 'id' => 'permintaan tinggi']
                        ],
                        'options' => [
                            'The price of construction materials is rising these days due to high demand.',
                            'The price of construction materials are rising these days due to high demand.',
                            'The price of construction materials is rise these days due to high demand.',
                            'The price of construction materials rising these days due to high demand.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Inti subjek "price" (tunggal), sehingga memerlukan "is rising".'
                    ],
                    [
                        'id' => 12,
                        'id_sentence' => 'Perusahaan itu sedang berkembang pesat setelah membuka cabang baru.',
                        'target_word' => 'is growing (Trend of Change)',
                        'vocab' => [
                            ['en' => 'company', 'id' => 'perusahaan'],
                            ['en' => 'growing rapidly', 'id' => 'berkembang pesat'],
                            ['en' => 'new branch', 'id' => 'cabang baru']
                        ],
                        'options' => [
                            'The company is growing rapidly after opening a new branch.',
                            'The company are growing rapidly after opening a new branch.',
                            'The company is grow rapidly after opening a new branch.',
                            'The company growing rapidly after opening a new branch.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "The company" berpasangan dengan "is growing".'
                    ],
                    [
                        'id' => 13,
                        'id_sentence' => 'Kinerja tim penjualan sedang membaik setelah pelatihan intensif bulan lalu.',
                        'target_word' => 'is improving (Trend of Change)',
                        'vocab' => [
                            ['en' => 'sales team performance', 'id' => 'kinerja tim penjualan'],
                            ['en' => 'improving', 'id' => 'membaik'],
                            ['en' => 'intensive training', 'id' => 'pelatihan intensif']
                        ],
                        'options' => [
                            'The sales team\'s performance is improving after the intensive training last month.',
                            'The sales team\'s performance are improving after the intensive training last month.',
                            'The sales team\'s performance is improve after the intensive training last month.',
                            'The sales team\'s performance improving after the intensive training last month.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"The sales team\'s performance" adalah subjek tunggal, sehingga menggunakan "is improving".'
                    ],
                    [
                        'id' => 14,
                        'id_sentence' => 'Suhu di gudang penyimpanan sedang menjadi lebih stabil setelah perbaikan AC.',
                        'target_word' => 'is getting (Trend of Change)',
                        'vocab' => [
                            ['en' => 'storage warehouse', 'id' => 'gudang penyimpanan'],
                            ['en' => 'getting more stable', 'id' => 'menjadi lebih stabil'],
                            ['en' => 'air conditioner repair', 'id' => 'perbaikan AC']
                        ],
                        'options' => [
                            'The temperature in the storage warehouse is getting more stable after the air conditioner repair.',
                            'The temperature in the storage warehouse are getting more stable after the air conditioner repair.',
                            'The temperature in the storage warehouse is get more stable after the air conditioner repair.',
                            'The temperature in the storage warehouse getting more stable after the air conditioner repair.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"The temperature" adalah subjek tunggal, maka bentuknya "is getting more stable".'
                    ],
                    [
                        'id' => 15,
                        'id_sentence' => 'Lalu lintas di sekitar kawasan industri sedang semakin padat setiap sore.',
                        'target_word' => 'is getting (Trend of Change)',
                        'vocab' => [
                            ['en' => 'traffic', 'id' => 'lalu lintas'],
                            ['en' => 'getting busier', 'id' => 'semakin padat'],
                            ['en' => 'industrial area', 'id' => 'kawasan industri']
                        ],
                        'options' => [
                            'Traffic around the industrial area is getting busier every afternoon.',
                            'Traffic around the industrial area are getting busier every afternoon.',
                            'Traffic around the industrial area is get busier every afternoon.',
                            'Traffic around the industrial area getting busier every afternoon.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Traffic" tunggal (uncountable), sehingga menggunakan "is getting busier".'
                    ],
                    [
                        'id' => 16,
                        'id_sentence' => 'Minat masyarakat terhadap produk lokal sedang meningkat tahun ini.',
                        'target_word' => 'is increasing (Trend of Change)',
                        'vocab' => [
                            ['en' => 'public interest', 'id' => 'minat masyarakat'],
                            ['en' => 'local products', 'id' => 'produk lokal'],
                            ['en' => 'increasing', 'id' => 'meningkat']
                        ],
                        'options' => [
                            'Public interest in local products is increasing this year.',
                            'Public interest in local products are increasing this year.',
                            'Public interest in local products is increase this year.',
                            'Public interest in local products increasing this year.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Inti subjek adalah "interest" (tunggal), bukan "products", maka bentuknya "is increasing".'
                    ],
                    [
                        'id' => 17,
                        'id_sentence' => 'Jaringan distribusi perusahaan itu sedang bertambah luas setiap tahun.',
                        'target_word' => 'is expanding (Trend of Change)',
                        'vocab' => [
                            ['en' => 'distribution network', 'id' => 'jaringan distribusi'],
                            ['en' => 'expanding', 'id' => 'bertambah luas'],
                            ['en' => 'every year', 'id' => 'setiap tahun']
                        ],
                        'options' => [
                            'The company\'s distribution network is expanding every year.',
                            'The company\'s distribution network are expanding every year.',
                            'The company\'s distribution network is expand every year.',
                            'The company\'s distribution network expanding every year.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"The distribution network" (tunggal) berpasangan dengan "is expanding".'
                    ],
                    [
                        'id' => 18,
                        'id_sentence' => 'Jumlah pelanggan di cabang kami sedang berkurang sejak penutupan jalan utama.',
                        'target_word' => 'is decreasing (Trend of Change)',
                        'vocab' => [
                            ['en' => 'number of customers', 'id' => 'jumlah pelanggan'],
                            ['en' => 'decreasing', 'id' => 'berkurang'],
                            ['en' => 'main road closure', 'id' => 'penutupan jalan utama']
                        ],
                        'options' => [
                            'The number of customers at our branch is decreasing since the main road closure.',
                            'The number of customers at our branch are decreasing since the main road closure.',
                            'The number of customers at our branch is decrease since the main road closure.',
                            'The number of customers at our branch decreasing since the main road closure.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"The number" adalah inti subjek tunggal, maka "is decreasing".'
                    ],
                    [
                        'id' => 19,
                        'id_sentence' => 'Kemampuan negosiasi Budi sedang berkembang setelah mengikuti pelatihan kepemimpinan.',
                        'target_word' => 'are developing (Trend of Change)',
                        'vocab' => [
                            ['en' => 'negotiation skills', 'id' => 'kemampuan negosiasi'],
                            ['en' => 'developing', 'id' => 'berkembang'],
                            ['en' => 'leadership training', 'id' => 'pelatihan kepemimpinan']
                        ],
                        'options' => [
                            'Budi\'s negotiation skills are developing after joining the leadership training.',
                            'Budi\'s negotiation skills is developing after joining the leadership training.',
                            'Budi\'s negotiation skills are develop after joining the leadership training.',
                            'Budi\'s negotiation skills developing after joining the leadership training.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Skills" berbentuk jamak, sehingga "are developing".'
                    ],
                    [
                        'id' => 20,
                        'id_sentence' => 'Keluhan pelanggan sedang berkurang sejak sistem layanan daring diperbarui.',
                        'target_word' => 'are decreasing (Trend of Change)',
                        'vocab' => [
                            ['en' => 'customer complaints', 'id' => 'keluhan pelanggan'],
                            ['en' => 'decreasing', 'id' => 'berkurang'],
                            ['en' => 'online service system', 'id' => 'sistem layanan daring']
                        ],
                        'options' => [
                            'Customer complaints are decreasing since the online service system was updated.',
                            'Customer complaints is decreasing since the online service system was updated.',
                            'Customer complaints is decrease since the online service system was updated.',
                            'Customer complaints decreasing since the online service system was updated.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Complaints" adalah kata benda jamak, sehingga "are decreasing".'
                    ],
                ]
            ],

            // Sub-Lesson 1.9.3
            [
                'id' => 'present-continuous-passive',
                'name' => '1.9.3 Present Continuous Passive: Sesuatu yang Sedang Dikerjakan',
                'code' => '1.9.3',
                'concept_title' => 'Present Continuous Passive: Sesuatu yang Sedang Dikerjakan',
                'concept_description' => 'Bentuk pasif continuous dipakai saat fokus kalimat adalah hal yang sedang dikerjakan atau diurus, tanpa perlu menyebut siapa pelakunya di awal. Kata "being" wajib ada di antara to be dan V3.',
                'description' => 'Bentuk pasif continuous dipakai saat fokus kalimat adalah hal yang sedang dikerjakan atau diurus, tanpa perlu menyebut siapa pelakunya di awal. Kata "being" wajib ada di antara to be dan V3.',
                'formula' => 'Subject (penerima) + am/is/are + being + Verb 3 (Past Participle) + (by Pelaku)',
                'rules' => [
                    'Rumus wajib: to be (am/is/are) + being + Past Participle (V3).',
                    'Jangan tertukar dengan Present Perfect Passive (have/has been + V3); continuous pasif selalu memakai "being", bukan "been".',
                    'Subjek jamak memakai "are being + V3", subjek tunggal memakai "is being + V3".'
                ],
                'exercises' => [
                    [
                        'id' => 21,
                        'id_sentence' => 'Laporan keuangan tahunan sedang disusun oleh tim akuntansi sekarang.',
                        'target_word' => 'is being prepared (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'annual financial report', 'id' => 'laporan keuangan tahunan'],
                            ['en' => 'prepared', 'id' => 'disusun'],
                            ['en' => 'accounting team', 'id' => 'tim akuntansi']
                        ],
                        'options' => [
                            'The annual financial report is being prepared by the accounting team right now.',
                            'The annual financial report is preparing by the accounting team right now.',
                            'The annual financial report are being prepared by the accounting team right now.',
                            'The annual financial report is been prepared by the accounting team right now.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek pasif tunggal "The annual financial report" membutuhkan "is" + "being" + V3 "prepared". Bentuk "been" hanya untuk perfect tense.'
                    ],
                    [
                        'id' => 22,
                        'id_sentence' => 'Kendaraan operasional kantor sedang diservis oleh bengkel rekanan.',
                        'target_word' => 'is being serviced (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'office operational vehicle', 'id' => 'kendaraan operasional kantor'],
                            ['en' => 'serviced', 'id' => 'diservis'],
                            ['en' => 'partner workshop', 'id' => 'bengkel rekanan']
                        ],
                        'options' => [
                            'The office\'s operational vehicle is being serviced by the partner workshop.',
                            'The office\'s operational vehicle are being serviced by the partner workshop.',
                            'The office\'s operational vehicle is servicing by the partner workshop.',
                            'The office\'s operational vehicle is been serviced by the partner workshop.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "The operational vehicle" memerlukan "is being serviced".'
                    ],
                    [
                        'id' => 23,
                        'id_sentence' => 'Dekorasi acara perusahaan sedang dipasang oleh tim event organizer.',
                        'target_word' => 'is being set up (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'company event decoration', 'id' => 'dekorasi acara perusahaan'],
                            ['en' => 'set up', 'id' => 'dipasang'],
                            ['en' => 'event organizer team', 'id' => 'tim event organizer']
                        ],
                        'options' => [
                            'The decoration for the company event is being set up by the event organizer team.',
                            'The decoration for the company event are being set up by the event organizer team.',
                            'The decoration for the company event is setting up by the event organizer team.',
                            'The decoration for the company event being set up by the event organizer team.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "The decoration" membutuhkan "is being set up".'
                    ],
                    [
                        'id' => 24,
                        'id_sentence' => 'Jalur sepeda yang rusak sedang diperbaiki oleh dinas pekerjaan umum.',
                        'target_word' => 'is being repaired (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'damaged bike lane', 'id' => 'jalur sepeda yang rusak'],
                            ['en' => 'repaired', 'id' => 'diperbaiki'],
                            ['en' => 'public works department', 'id' => 'dinas pekerjaan umum']
                        ],
                        'options' => [
                            'The damaged bike lane is being repaired by the public works department.',
                            'The damaged bike lane are being repaired by the public works department.',
                            'The damaged bike lane is repairing by the public works department.',
                            'The damaged bike lane has being repaired by the public works department.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "bike lane" adalah tunggal dan menerima tindakan, sehingga memerlukan "is being repaired".'
                    ],
                    [
                        'id' => 25,
                        'id_sentence' => 'Ruang pertemuan sedang dirapikan sebelum rapat pemegang saham dimulai.',
                        'target_word' => 'is being tidied (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'meeting room', 'id' => 'ruang pertemuan'],
                            ['en' => 'tidied', 'id' => 'dirapikan'],
                            ['en' => 'shareholders meeting', 'id' => 'rapat pemegang saham']
                        ],
                        'options' => [
                            'The meeting room is being tidied before the shareholders meeting begins.',
                            'The meeting room are being tidied before the shareholders meeting begins.',
                            'The meeting room is tidying before the shareholders meeting begins.',
                            'The meeting room being tidied before the shareholders meeting begins.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"The meeting room" tunggal, sehingga rumusnya adalah "is being tidied".'
                    ],
                    [
                        'id' => 26,
                        'id_sentence' => 'Berkas lamaran kerja sedang diperiksa oleh tim sumber daya manusia.',
                        'target_word' => 'are being reviewed (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'job application documents', 'id' => 'berkas lamaran kerja'],
                            ['en' => 'reviewed', 'id' => 'diperiksa'],
                            ['en' => 'human resources team', 'id' => 'tim sumber daya manusia']
                        ],
                        'options' => [
                            'The job application documents are being reviewed by the human resources team.',
                            'The job application documents is being reviewed by the human resources team.',
                            'The job application documents are reviewing by the human resources team.',
                            'The job application documents has been review by the human resources team.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "The documents" berpasangan dengan "are being reviewed".'
                    ],
                    [
                        'id' => 27,
                        'id_sentence' => 'Tanaman di area resepsionis sedang disiram oleh petugas kebersihan setiap pagi.',
                        'target_word' => 'are being watered (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'plants', 'id' => 'tanaman'],
                            ['en' => 'reception area', 'id' => 'area resepsionis'],
                            ['en' => 'watered', 'id' => 'disiram']
                        ],
                        'options' => [
                            'The plants in the reception area are being watered by the cleaning staff every morning.',
                            'The plants in the reception area is being watered by the cleaning staff every morning.',
                            'The plants in the reception area are watering by the cleaning staff every morning.',
                            'The plants in the reception area being watered by the cleaning staff every morning.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "plants" (jamak) dipadukan dengan pola pasif continuous "are being watered".'
                    ],
                    [
                        'id' => 28,
                        'id_sentence' => 'Gangguan pada server perusahaan sedang ditangani oleh tim IT.',
                        'target_word' => 'is being handled (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'problem', 'id' => 'gangguan'],
                            ['en' => 'company server', 'id' => 'server perusahaan'],
                            ['en' => 'IT team', 'id' => 'tim IT']
                        ],
                        'options' => [
                            'The problem with the company server is being handled by the IT team.',
                            'The problem with the company server are being handled by the IT team.',
                            'The problem with the company server is handling by the IT team.',
                            'The problem with the company server being handled by the IT team.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek utama "The problem" adalah tunggal, sehingga memerlukan "is being handled".'
                    ],
                    [
                        'id' => 29,
                        'id_sentence' => 'Materi pelatihan baru sedang disampaikan secara daring kepada seluruh staf.',
                        'target_word' => 'is being delivered (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'new training material', 'id' => 'materi pelatihan baru'],
                            ['en' => 'delivered', 'id' => 'disampaikan'],
                            ['en' => 'all staff', 'id' => 'seluruh staf']
                        ],
                        'options' => [
                            'The new training material is being delivered online to all staff.',
                            'The new training material are being delivered online to all staff.',
                            'The new training material is delivering online to all staff.',
                            'The new training material being delivered online to all staff.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "material" (tunggal) membutuhkan "is being delivered".'
                    ],
                    [
                        'id' => 30,
                        'id_sentence' => 'Atap gudang sedang diperbaiki karena kerusakan akibat badai minggu lalu.',
                        'target_word' => 'is being fixed (Present Continuous Passive)',
                        'vocab' => [
                            ['en' => 'warehouse roof', 'id' => 'atap gudang'],
                            ['en' => 'fixed', 'id' => 'diperbaiki'],
                            ['en' => 'storm damage', 'id' => 'kerusakan akibat badai']
                        ],
                        'options' => [
                            'The warehouse roof is being fixed because of the storm damage last week.',
                            'The warehouse roof are being fixed because of the storm damage last week.',
                            'The warehouse roof is fixing because of the storm damage last week.',
                            'The warehouse roof has being fixed because of the storm damage last week.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "roof" (tunggal) membutuhkan "is being fixed".'
                    ],
                ]
            ],

            // Sub-Lesson 1.9.4
            [
                'id' => 'temporary-vs-permanent',
                'name' => '1.9.4 Kebiasaan Rutin vs Situasi Sementara',
                'code' => '1.9.4',
                'concept_title' => 'Kebiasaan Rutin vs Situasi Sementara (Continuous vs Simple Present)',
                'concept_description' => 'Membedakan kebiasaan sehari-hari (Simple Present) dengan hal yang hanya berlaku sekarang/hari ini saja (Present Continuous).',
                'description' => 'Membedakan kebiasaan sehari-hari (Simple Present) dengan hal yang hanya berlaku sekarang/hari ini saja (Present Continuous).',
                'formula' => 'Rutin: S + V1/V-s | Sementara: S + is/are + V-ing',
                'rules' => [
                    'Gunakan Simple Present untuk kebiasaan rutin (usually, every day, every week).',
                    'Gunakan Present Continuous untuk situasi khusus sekarang (today, right now, this week).',
                    'Penanda waktu transisional: currently, at the moment, for now, this time.'
                ],
                'exercises' => [
                    [
                        'id' => 31,
                        'id_sentence' => 'Manajer biasanya berangkat kerja naik mobil pribadi, tetapi hari ini ia sedang menggunakan transportasi umum.',
                        'target_word' => 'usually drives ... is using (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'manager', 'id' => 'manajer'],
                            ['en' => 'usually drives', 'id' => 'biasanya berkendara'],
                            ['en' => 'public transport', 'id' => 'transportasi umum']
                        ],
                        'options' => [
                            'The manager usually drives to work, but today he is using public transport.',
                            'The manager is usually driving to work, but today he uses public transport.',
                            'The manager usually drive to work, but today he is using public transport.',
                            'The manager usually drives to work, but today he using public transport.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kebiasaan rutin memakai Simple Present ("usually drives"), sedangkan situasi khusus hari ini memakai Present Continuous ("is using").'
                    ],
                    [
                        'id' => 32,
                        'id_sentence' => 'Pelatih itu biasanya melatih dua kelompok setiap hari, tetapi minggu ini ia sedang membimbing tim untuk kejuaraan daerah.',
                        'target_word' => 'trains ... is coaching (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'coach', 'id' => 'pelatih'],
                            ['en' => 'two groups', 'id' => 'dua kelompok'],
                            ['en' => 'regional championship', 'id' => 'kejuaraan daerah']
                        ],
                        'options' => [
                            'The coach trains two groups every day, but this week he is coaching the team for the regional championship.',
                            'The coach is training two groups every day, but this week he coaches the team for the regional championship.',
                            'The coach train two groups every day, but this week he is coaching the team for the regional championship.',
                            'The coach trains two groups every day, but this week he coaching the team for the regional championship.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kebiasaan harian ("every day") memakai "trains", sedangkan kegiatan khusus minggu ini ("this week") memakai "is coaching".'
                    ],
                    [
                        'id' => 33,
                        'id_sentence' => 'Jalur produksi itu biasanya berjalan lancar, tapi sekarang sedang terhambat karena masalah pasokan bahan baku.',
                        'target_word' => 'runs ... is facing (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'runs smoothly', 'id' => 'berjalan lancar'],
                            ['en' => 'facing', 'id' => 'menghadapi'],
                            ['en' => 'raw material supply', 'id' => 'pasokan bahan baku']
                        ],
                        'options' => [
                            'The production line usually runs smoothly, but now it is facing a problem with the raw material supply.',
                            'The production line is usually running smoothly, but now it faces a problem with the raw material supply.',
                            'The production line usually run smoothly, but now it is facing a problem with the raw material supply.',
                            'The production line usually runs smoothly, but now it facing a problem with the raw material supply.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Keadaan biasa dinyatakan dengan "usually runs", sedangkan keadaan sesaat memakai "is facing".'
                    ],
                    [
                        'id' => 34,
                        'id_sentence' => 'Toko itu biasanya menjual perlengkapan kantor, tapi minggu ini mereka sedang menjual peralatan musim hujan.',
                        'target_word' => 'sells ... is selling (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'shop', 'id' => 'toko'],
                            ['en' => 'office supplies', 'id' => 'perlengkapan kantor'],
                            ['en' => 'rainy-season gear', 'id' => 'peralatan musim hujan']
                        ],
                        'options' => [
                            'The shop usually sells office supplies, but this week it is selling rainy-season gear.',
                            'The shop is usually selling office supplies, but this week it sells rainy-season gear.',
                            'The shop usually sell office supplies, but this week it is selling rainy-season gear.',
                            'The shop usually sells office supplies, but this week it selling rainy-season gear.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Rutinitas toko ("usually sells") dikontraskan dengan penjualan khusus minggu ini ("is selling").'
                    ],
                    [
                        'id' => 35,
                        'id_sentence' => 'Kantor cabang biasanya tutup pukul lima sore, tapi hari ini mereka sedang tetap buka untuk audit tahunan.',
                        'target_word' => 'closes ... is staying (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'branch office', 'id' => 'kantor cabang'],
                            ['en' => 'closes', 'id' => 'tutup'],
                            ['en' => 'annual audit', 'id' => 'audit tahunan']
                        ],
                        'options' => [
                            'The branch office usually closes at five, but today it is staying open for the annual audit.',
                            'The branch office is usually closing at five, but today it stays open for the annual audit.',
                            'The branch office usually close at five, but today it is staying open for the annual audit.',
                            'The branch office usually closes at five, but today it staying open for the annual audit.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Jadwal rutin ("usually closes") memakai Simple Present, sedangkan penyesuaian khusus hari ini ("today") memakai "is staying".'
                    ],
                    [
                        'id' => 36,
                        'id_sentence' => 'Sebagian besar staf biasanya makan siang di kantin, tetapi hari ini mereka sedang mencoba restoran baru di seberang jalan.',
                        'target_word' => 'eat ... are trying (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'most staff', 'id' => 'sebagian besar staf'],
                            ['en' => 'eat at the canteen', 'id' => 'makan di kantin'],
                            ['en' => 'new restaurant', 'id' => 'restoran baru']
                        ],
                        'options' => [
                            'Most staff usually eat at the canteen, but today they are trying the new restaurant across the street.',
                            'Most staff are usually eating at the canteen, but today they try the new restaurant across the street.',
                            'Most staff usually eats at the canteen, but today they are trying the new restaurant across the street.',
                            'Most staff usually eat at the canteen, but today they trying the new restaurant across the street.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kebiasaan umum memakai Simple Present "eat", sedangkan percobaan khusus hari ini memakai Present Continuous "are trying".'
                    ],
                    [
                        'id' => 37,
                        'id_sentence' => 'Sistem pendingin ruang server biasanya bekerja otomatis, tetapi sekarang petugas sedang menyesuaikannya secara manual.',
                        'target_word' => 'works ... is adjusting (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'server room cooling system', 'id' => 'sistem pendingin ruang server'],
                            ['en' => 'works automatically', 'id' => 'bekerja otomatis'],
                            ['en' => 'technician', 'id' => 'petugas']
                        ],
                        'options' => [
                            'The server room cooling system usually works automatically, but now the technician is adjusting it manually.',
                            'The server room cooling system is usually working automatically, but now the technician adjusts it manually.',
                            'The server room cooling system usually work automatically, but now the technician is adjusting it manually.',
                            'The server room cooling system usually works automatically, but now the technician adjusting it manually.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Usually works" menunjukkan cara kerja biasa, sedangkan "is adjusting" mendeskripsikan tindakan manual sekarang.'
                    ],
                    [
                        'id' => 38,
                        'id_sentence' => 'Pengiriman barang biasanya tiba tepat waktu, tetapi minggu ini mereka sedang mengalami keterlambatan akibat cuaca buruk.',
                        'target_word' => 'arrives ... is experiencing (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'shipment', 'id' => 'pengiriman barang'],
                            ['en' => 'arrives on time', 'id' => 'tiba tepat waktu'],
                            ['en' => 'experiencing delays', 'id' => 'mengalami keterlambatan']
                        ],
                        'options' => [
                            'The shipment usually arrives on time, but this week it is experiencing delays due to bad weather.',
                            'The shipment is usually arriving on time, but this week it experiences delays due to bad weather.',
                            'The shipment usually arrive on time, but this week it is experiencing delays due to bad weather.',
                            'The shipment usually arrives on time, but this week it experiencing delays due to bad weather.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kebiasaan pengiriman memakai "arrives", sedangkan hambatan sementara memakai "is experiencing".'
                    ],
                    [
                        'id' => 39,
                        'id_sentence' => 'Warung itu biasanya hanya menyediakan menu lokal, tetapi saat ini mereka sedang mencoba menu baru untuk menarik pelanggan.',
                        'target_word' => 'offers ... is trying (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'food stall', 'id' => 'warung'],
                            ['en' => 'local menu', 'id' => 'menu lokal'],
                            ['en' => 'new menu', 'id' => 'menu baru']
                        ],
                        'options' => [
                            'The food stall usually offers only local dishes, but it is currently trying a new menu to attract customers.',
                            'The food stall is usually offering only local dishes, but it currently tries a new menu to attract customers.',
                            'The food stall usually offer only local dishes, but it is currently trying a new menu to attract customers.',
                            'The food stall usually offers only local dishes, but it currently trying a new menu to attract customers.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Usually offers" (kebiasaan) dikontraskan dengan "is currently trying" (percobaan sementara).'
                    ],
                    [
                        'id' => 40,
                        'id_sentence' => 'Jadwal pelatihan biasanya berlangsung dua jam, tapi fasilitator sedang memperbarui jadwal untuk bulan depan.',
                        'target_word' => 'lasts ... is updating (Aspect Contrast)',
                        'vocab' => [
                            ['en' => 'training schedule', 'id' => 'jadwal pelatihan'],
                            ['en' => 'lasts', 'id' => 'berlangsung'],
                            ['en' => 'facilitator', 'id' => 'fasilitator']
                        ],
                        'options' => [
                            'The training schedule usually lasts two hours, but the facilitator is updating it for next month.',
                            'The training schedule is usually lasting two hours, but the facilitator updates it for next month.',
                            'The training schedule usually last two hours, but the facilitator is updating it for next month.',
                            'The training schedule usually lasts two hours, but the facilitator updating it for next month.'
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
                        'id_sentence' => 'Saya memahami penjelasan manajer tentang target penjualan sekarang.',
                        'target_word' => 'understand (Stative Verb: Cognition)',
                        'vocab' => [
                            ['en' => 'understand', 'id' => 'memahami'],
                            ['en' => 'manager\'s explanation', 'id' => 'penjelasan manajer'],
                            ['en' => 'sales target', 'id' => 'target penjualan']
                        ],
                        'options' => [
                            'I understand the manager\'s explanation about the sales target now.',
                            'I am understanding the manager\'s explanation about the sales target now.',
                            'I understands the manager\'s explanation about the sales target now.',
                            'I am understand the manager\'s explanation about the sales target now.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Understand" adalah kata kerja pikiran dan tidak memakai bentuk -ing.'
                    ],
                    [
                        'id' => 42,
                        'id_sentence' => 'Paket ini berisi dokumen penting untuk klien baru.',
                        'target_word' => 'contains (Stative Verb: Content)',
                        'vocab' => [
                            ['en' => 'package', 'id' => 'paket'],
                            ['en' => 'contains', 'id' => 'berisi'],
                            ['en' => 'important documents', 'id' => 'dokumen penting']
                        ],
                        'options' => [
                            'This package contains important documents for the new client.',
                            'This package is containing important documents for the new client.',
                            'This package contain important documents for the new client.',
                            'This package is contained important documents for the new client.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Contain" adalah stative verb yang menyatakan isi; bentuk "is containing" salah.'
                    ],
                    [
                        'id' => 43,
                        'id_sentence' => 'Kami membutuhkan persetujuan tambahan untuk menyelesaikan kontrak ini.',
                        'target_word' => 'need (Stative Verb: Need)',
                        'vocab' => [
                            ['en' => 'need', 'id' => 'membutuhkan'],
                            ['en' => 'additional approval', 'id' => 'persetujuan tambahan'],
                            ['en' => 'finalize the contract', 'id' => 'menyelesaikan kontrak']
                        ],
                        'options' => [
                            'We need additional approval to finalize this contract.',
                            'We are needing additional approval to finalize this contract.',
                            'We needs additional approval to finalize this contract.',
                            'We are need additional approval to finalize this contract.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Need" adalah stative verb yang tidak berbentuk continuous (*are needing).'
                    ],
                    [
                        'id' => 44,
                        'id_sentence' => 'Rencana ekspansi itu kelihatannya menjanjikan, tetapi kami sedang mempertimbangkan apakah anggaran mencukupi.',
                        'target_word' => 'seems ... are considering (Stative vs Dynamic Meaning)',
                        'vocab' => [
                            ['en' => 'expansion plan', 'id' => 'rencana ekspansi'],
                            ['en' => 'seems promising', 'id' => 'kelihatannya menjanjikan'],
                            ['en' => 'considering', 'id' => 'mempertimbangkan']
                        ],
                        'options' => [
                            'The expansion plan seems promising, but we are considering whether the budget is sufficient.',
                            'The expansion plan is seeming promising, but we consider whether the budget is sufficient.',
                            'The expansion plan seems promising, but we consider currently whether the budget is sufficient.',
                            'The expansion plan is seeming promising, but we are considering whether the budget is sufficient.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Seem" adalah stative verb murni (tidak boleh *is seeming), sedangkan "consider" dalam arti sedang menimbang boleh memakai continuous ("are considering").'
                    ],
                    [
                        'id' => 45,
                        'id_sentence' => 'Departemen itu belum memiliki anggaran tambahan sejak proyek sebelumnya ditutup.',
                        'target_word' => 'does not have (Stative Verb: Possession)',
                        'vocab' => [
                            ['en' => 'department', 'id' => 'departemen'],
                            ['en' => 'does not have', 'id' => 'belum memiliki'],
                            ['en' => 'additional budget', 'id' => 'anggaran tambahan']
                        ],
                        'options' => [
                            'The department does not have an additional budget since the previous project closed.',
                            'The department is not having an additional budget since the previous project closed.',
                            'The department do not have an additional budget since the previous project closed.',
                            'The department are not having an additional budget since the previous project closed.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Have" yang bermakna memiliki adalah stative verb ("does not have", bukan *is not having).'
                    ],
                    [
                        'id' => 46,
                        'id_sentence' => 'Klien kami memiliki beberapa persyaratan khusus untuk proyek ini.',
                        'target_word' => 'has (Stative Verb: Possession)',
                        'vocab' => [
                            ['en' => 'client', 'id' => 'klien'],
                            ['en' => 'has', 'id' => 'memiliki'],
                            ['en' => 'special requirements', 'id' => 'persyaratan khusus']
                        ],
                        'options' => [
                            'Our client has several special requirements for this project.',
                            'Our client is having several special requirements for this project.',
                            'Our client have several special requirements for this project.',
                            'Our client is have several special requirements for this project.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Have" bermakna memiliki adalah stative verb, memakai bentuk Simple Present "has", bukan *is having.'
                    ],
                    [
                        'id' => 47,
                        'id_sentence' => 'Paket layanan ini terdiri dari tiga tahap utama.',
                        'target_word' => 'consists of (Stative Verb: Composition)',
                        'vocab' => [
                            ['en' => 'service package', 'id' => 'paket layanan'],
                            ['en' => 'consists of', 'id' => 'terdiri dari'],
                            ['en' => 'three main phases', 'id' => 'tiga tahap utama']
                        ],
                        'options' => [
                            'This service package consists of three main phases.',
                            'This service package is consisting of three main phases.',
                            'This service package consist of three main phases.',
                            'This service package is consisted of three main phases.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Frasa "consist of" selalu stative (*is consisting of dan *is consisted of adalah kesalahan).'
                    ],
                    [
                        'id' => 48,
                        'id_sentence' => 'Direktur percaya bahwa tim pemasaran bisa mencapai target tahun ini.',
                        'target_word' => 'believes (Stative Verb: Belief)',
                        'vocab' => [
                            ['en' => 'director', 'id' => 'direktur'],
                            ['en' => 'believes', 'id' => 'percaya'],
                            ['en' => 'marketing team', 'id' => 'tim pemasaran']
                        ],
                        'options' => [
                            'The director believes that the marketing team can reach the target this year.',
                            'The director is believing that the marketing team can reach the target this year.',
                            'The director believe that the marketing team can reach the target this year.',
                            'The director are believing that the marketing team can reach the target this year.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Believe" adalah stative verb dan tidak berbentuk continuous (*is believing).'
                    ],
                    [
                        'id' => 49,
                        'id_sentence' => 'Gedung baru itu memiliki fasilitas parkir yang luas.',
                        'target_word' => 'has (Stative Verb: Attribute)',
                        'vocab' => [
                            ['en' => 'new building', 'id' => 'gedung baru'],
                            ['en' => 'has', 'id' => 'memiliki'],
                            ['en' => 'spacious parking facility', 'id' => 'fasilitas parkir yang luas']
                        ],
                        'options' => [
                            'The new building has a spacious parking facility.',
                            'The new building is having a spacious parking facility.',
                            'The new building have a spacious parking facility.',
                            'The new building is have a spacious parking facility.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Have" bermakna ciri fisik adalah stative verb ("has", bukan *is having).'
                    ],
                    [
                        'id' => 50,
                        'id_sentence' => 'Saya ragu apakah vendor itu akan mengirimkan barang sebelum tenggat waktu.',
                        'target_word' => 'doubt (Stative Verb: Mental State)',
                        'vocab' => [
                            ['en' => 'doubt', 'id' => 'ragu'],
                            ['en' => 'vendor', 'id' => 'vendor'],
                            ['en' => 'before the deadline', 'id' => 'sebelum tenggat waktu']
                        ],
                        'options' => [
                            'I doubt the vendor will deliver the goods before the deadline.',
                            'I am doubting the vendor will deliver the goods before the deadline.',
                            'I doubts the vendor will deliver the goods before the deadline.',
                            'I am doubt the vendor will deliver the goods before the deadline.'
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
                'concept_description' => 'Dipakai untuk menyatakan bahwa sesuatu TIDAK sedang berlangsung sekarang, atau untuk menanyakan apakah sesuatu sedang berlangsung.',
                'description' => 'Dipakai untuk menyatakan bahwa sesuatu TIDAK sedang berlangsung sekarang, atau untuk menanyakan apakah sesuatu sedang berlangsung.',
                'formula' => 'Negatif: S + is/are + NOT + V-ing / being V3 | Tanya: Is/Are + S + V-ing?',
                'rules' => [
                    'Pada kalimat verbal negatif, sisipkan "not" tepat setelah to be (is not cooking, are not playing).',
                    'Pada kalimat pasif negatif, letakkan "not" sebelum "being" (is not being processed).',
                    'Pada kalimat tanya, pindahkan to be ke posisi paling depan sebelum subjek (Is she preparing...?).'
                ],
                'exercises' => [
                    [
                        'id' => 51,
                        'id_sentence' => 'Vendor itu belum sedang merespons permintaan penawaran kami sejak kemarin.',
                        'target_word' => 'is not responding (Negative Verbal)',
                        'vocab' => [
                            ['en' => 'vendor', 'id' => 'vendor'],
                            ['en' => 'responding', 'id' => 'merespons'],
                            ['en' => 'price quotation request', 'id' => 'permintaan penawaran']
                        ],
                        'options' => [
                            'The vendor is not responding to our price quotation request since yesterday.',
                            'The vendor does not responding to our price quotation request since yesterday.',
                            'The vendor are not responding to our price quotation request since yesterday.',
                            'The vendor not responding to our price quotation request since yesterday.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk negatif Present Continuous dibentuk dengan meletakkan "not" setelah auxiliary: "is not responding".'
                    ],
                    [
                        'id' => 52,
                        'id_sentence' => 'Pesanan itu tidak sedang diproses hari ini karena sistem sedang pemeliharaan.',
                        'target_word' => 'is not being processed (Negative Passive)',
                        'vocab' => [
                            ['en' => 'order', 'id' => 'pesanan'],
                            ['en' => 'processed', 'id' => 'diproses'],
                            ['en' => 'system maintenance', 'id' => 'pemeliharaan sistem']
                        ],
                        'options' => [
                            'The order is not being processed today because the system is under maintenance.',
                            'The order is not processing today because the system is under maintenance.',
                            'The order does not being processed today because the system is under maintenance.',
                            'The order is not been processed today because the system is under maintenance.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Pola negatif pasif continuous adalah "is not being" + V3 "processed".'
                    ],
                    [
                        'id' => 53,
                        'id_sentence' => 'Para peserta tidak sedang mengisi survei kepuasan selama sesi istirahat.',
                        'target_word' => 'are not filling (Negative Verbal)',
                        'vocab' => [
                            ['en' => 'participants', 'id' => 'peserta'],
                            ['en' => 'satisfaction survey', 'id' => 'survei kepuasan'],
                            ['en' => 'break session', 'id' => 'sesi istirahat']
                        ],
                        'options' => [
                            'The participants are not filling out the satisfaction survey during the break session.',
                            'The participants is not filling out the satisfaction survey during the break session.',
                            'The participants do not filling out the satisfaction survey during the break session.',
                            'The participants are not fill out the satisfaction survey during the break session.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "The participants" mengambil "are not filling".'
                    ],
                    [
                        'id' => 54,
                        'id_sentence' => 'Apakah supervisor sedang meninjau laporan kinerja bulanan?',
                        'target_word' => 'Is ... reviewing (Interrogative Verbal)',
                        'vocab' => [
                            ['en' => 'reviewing', 'id' => 'meninjau'],
                            ['en' => 'monthly performance report', 'id' => 'laporan kinerja bulanan']
                        ],
                        'options' => [
                            'Is the supervisor reviewing the monthly performance report?',
                            'Does the supervisor reviewing the monthly performance report?',
                            'Are the supervisor reviewing the monthly performance report?',
                            'Is the supervisor review the monthly performance report?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "the supervisor" diawali auxiliary "Is" + V-ing "reviewing".'
                    ],
                    [
                        'id' => 55,
                        'id_sentence' => 'Cabang itu tidak sedang beroperasi penuh akhir pekan ini karena renovasi.',
                        'target_word' => 'is not operating (Negative Verbal)',
                        'vocab' => [
                            ['en' => 'branch', 'id' => 'cabang'],
                            ['en' => 'operating', 'id' => 'beroperasi'],
                            ['en' => 'renovation', 'id' => 'renovasi']
                        ],
                        'options' => [
                            'The branch is not operating at full capacity this weekend because of renovation.',
                            'The branch are not operating at full capacity this weekend because of renovation.',
                            'The branch does not operating at full capacity this weekend because of renovation.',
                            'The branch not is operating at full capacity this weekend because of renovation.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "The branch" membutuhkan "is not operating".'
                    ],
                    [
                        'id' => 56,
                        'id_sentence' => 'Produk baru itu tidak sedang dipajang di etalase karena masih menunggu persetujuan desain.',
                        'target_word' => 'is not being displayed (Negative Passive)',
                        'vocab' => [
                            ['en' => 'new product', 'id' => 'produk baru'],
                            ['en' => 'displayed', 'id' => 'dipajang'],
                            ['en' => 'design approval', 'id' => 'persetujuan desain']
                        ],
                        'options' => [
                            'The new product is not being displayed in the showcase because it is still awaiting design approval.',
                            'The new product are not being displayed in the showcase because it is still awaiting design approval.',
                            'The new product is not displaying in the showcase because it is still awaiting design approval.',
                            'The new product does not being displayed in the showcase because it is still awaiting design approval.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "The new product" memerlukan bentuk pasif negatif: "is not being displayed".'
                    ],
                    [
                        'id' => 57,
                        'id_sentence' => 'Apakah tim pengembang sedang menguji fitur pembayaran yang baru?',
                        'target_word' => 'Is ... testing (Interrogative Verbal)',
                        'vocab' => [
                            ['en' => 'development team', 'id' => 'tim pengembang'],
                            ['en' => 'testing', 'id' => 'menguji'],
                            ['en' => 'new payment feature', 'id' => 'fitur pembayaran baru']
                        ],
                        'options' => [
                            'Is the development team testing the new payment feature?',
                            'Does the development team testing the new payment feature?',
                            'Are the development team testing the new payment feature?',
                            'Is the development team test the new payment feature?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "the development team" diawali oleh auxiliary "Is" + V-ing "testing".'
                    ],
                    [
                        'id' => 58,
                        'id_sentence' => 'Masalah konektivitas internet belum teratasi meskipun teknisi sudah dipanggil.',
                        'target_word' => 'is not resolving (Negative Verbal)',
                        'vocab' => [
                            ['en' => 'internet connectivity issue', 'id' => 'masalah konektivitas internet'],
                            ['en' => 'resolving', 'id' => 'teratasi'],
                            ['en' => 'technician', 'id' => 'teknisi']
                        ],
                        'options' => [
                            'The internet connectivity issue is not resolving even though a technician has been called.',
                            'The internet connectivity issue are not resolving even though a technician has been called.',
                            'The internet connectivity issue does not resolving even though a technician has been called.',
                            'The internet connectivity issue is not resolve even though a technician has been called.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "The issue" tunggal, sehingga bentuk negatif continuous yang tepat adalah "is not resolving".'
                    ],
                    [
                        'id' => 59,
                        'id_sentence' => 'Invoice itu tidak sedang dikirim karena menunggu persetujuan akhir dari manajer keuangan.',
                        'target_word' => 'is not being sent (Negative Passive)',
                        'vocab' => [
                            ['en' => 'invoice', 'id' => 'invoice'],
                            ['en' => 'sent', 'id' => 'dikirim'],
                            ['en' => 'finance manager', 'id' => 'manajer keuangan']
                        ],
                        'options' => [
                            'The invoice is not being sent because it is waiting for final approval from the finance manager.',
                            'The invoice are not being sent because it is waiting for final approval from the finance manager.',
                            'The invoice is not sending because it is waiting for final approval from the finance manager.',
                            'The invoice does not being sent because it is waiting for final approval from the finance manager.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "invoice" dalam bentuk pasif negatif continuous membutuhkan "is not being sent".'
                    ],
                    [
                        'id' => 60,
                        'id_sentence' => 'Apakah strategi pemasaran yang baru menunjukkan hasil yang bagus untuk kuartal ini?',
                        'target_word' => 'Is ... showing (Interrogative Verbal)',
                        'vocab' => [
                            ['en' => 'new marketing strategy', 'id' => 'strategi pemasaran baru'],
                            ['en' => 'good results', 'id' => 'hasil yang bagus'],
                            ['en' => 'this quarter', 'id' => 'kuartal ini']
                        ],
                        'options' => [
                            'Is the new marketing strategy showing good results this quarter?',
                            'Does the new marketing strategy showing good results this quarter?',
                            'Are the new marketing strategy showing good results this quarter?',
                            'Is the new marketing strategy show good results this quarter?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "the new marketing strategy" diawali to be "Is" + V-ing "showing".'
                    ],
                ]
            ],

            // Sub-Lesson 1.9.7
            [
                'id' => 'time-adverbs-continuous',
                'name' => '1.9.7 Kata Keterangan Waktu Bersama Continuous Tense',
                'code' => '1.9.7',
                'concept_title' => 'Kata Keterangan Waktu Bersama Continuous Tense',
                'concept_description' => 'Memperkaya kalimat continuous dengan kata keterangan waktu seperti right now, at the moment, today, currently, untuk memperjelas bahwa sesuatu sedang berlangsung saat ini.',
                'description' => 'Memperkaya kalimat continuous dengan kata keterangan waktu seperti right now, at the moment, today, currently, untuk memperjelas bahwa sesuatu sedang berlangsung saat ini.',
                'formula' => 'Keterangan Waktu + Koma + Subject + is/are + V-ing',
                'rules' => [
                    'Kata keterangan waktu sering disisipkan di antara to be dan kata kerja utama (misalnya: "is currently reviewing").',
                    'Kata keterangan waktu juga bisa diletakkan di depan kalimat, diikuti tanda koma ("Right now, the team is...").',
                    'Pastikan kata keterangan waktu sesuai dengan maksud "sedang berlangsung sekarang" (right now, at the moment, today).'
                ],
                'exercises' => [
                    [
                        'id' => 61,
                        'id_sentence' => 'Sekarang, tim perawatan sedang memeriksa lift gedung utama.',
                        'target_word' => 'Right now, ... is inspecting (Adverbial Placement)',
                        'vocab' => [
                            ['en' => 'right now', 'id' => 'sekarang'],
                            ['en' => 'inspecting', 'id' => 'memeriksa'],
                            ['en' => 'main building elevator', 'id' => 'lift gedung utama']
                        ],
                        'options' => [
                            'Right now, the maintenance team is inspecting the main building elevator.',
                            'Right now, the maintenance team is inspecting the main building elevator is.',
                            'Right now, the maintenance team are inspecting the main building elevator.',
                            'Right now, the maintenance team inspecting the main building elevator.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Right now" di awal kalimat dipadukan dengan klausa Present Continuous tunggal "the team is inspecting".'
                    ],
                    [
                        'id' => 62,
                        'id_sentence' => 'Saat ini, para peserta sedang berlatih presentasi untuk sesi penutupan.',
                        'target_word' => 'At the moment, ... are practicing (Adverbial Phrase)',
                        'vocab' => [
                            ['en' => 'at the moment', 'id' => 'saat ini'],
                            ['en' => 'practicing', 'id' => 'berlatih'],
                            ['en' => 'closing session', 'id' => 'sesi penutupan']
                        ],
                        'options' => [
                            'At the moment, the participants are practicing their presentations for the closing session.',
                            'At the moment, the participants is practicing their presentations for the closing session.',
                            'At the moment, the participants are practice their presentations for the closing session.',
                            'At the moment, the participants practicing their presentations for the closing session.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Frasa "At the moment" mengawali kalimat, diikuti subjek jamak "the participants are practicing".'
                    ],
                    [
                        'id' => 63,
                        'id_sentence' => 'Hari ini, kami sedang mempersiapkan seluruh ruangan untuk kunjungan investor.',
                        'target_word' => 'Today, ... are preparing (Adverbial Placement)',
                        'vocab' => [
                            ['en' => 'today', 'id' => 'hari ini'],
                            ['en' => 'preparing', 'id' => 'mempersiapkan'],
                            ['en' => 'investor visit', 'id' => 'kunjungan investor']
                        ],
                        'options' => [
                            'Today, we are preparing the whole room for the investor visit.',
                            'Today, we is preparing the whole room for the investor visit.',
                            'Today, we are prepare the whole room for the investor visit.',
                            'Today, we preparing the whole room for the investor visit.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Today" di awal kalimat diikuti subjek jamak "we are preparing".'
                    ],
                    [
                        'id' => 64,
                        'id_sentence' => 'Sekarang ini, biaya pengiriman internasional sedang turun karena promosi musiman.',
                        'target_word' => 'These days, ... is dropping (Adverbial Placement)',
                        'vocab' => [
                            ['en' => 'these days', 'id' => 'sekarang ini'],
                            ['en' => 'dropping', 'id' => 'turun'],
                            ['en' => 'seasonal promotion', 'id' => 'promosi musiman']
                        ],
                        'options' => [
                            'These days, the cost of international shipping is dropping because of a seasonal promotion.',
                            'These days, the cost of international shipping are dropping because of a seasonal promotion.',
                            'These days, the cost of international shipping is drop because of a seasonal promotion.',
                            'These days, the cost of international shipping dropping because of a seasonal promotion.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Inti subjek "the cost" (tunggal) berpasangan dengan "is dropping".'
                    ],
                    [
                        'id' => 65,
                        'id_sentence' => 'Supervisor saat ini sedang menandai hasil evaluasi di ruang rapat.',
                        'target_word' => 'is currently marking (Adverbial Between Auxiliary & Verb)',
                        'vocab' => [
                            ['en' => 'currently', 'id' => 'saat ini'],
                            ['en' => 'marking', 'id' => 'menandai'],
                            ['en' => 'meeting room', 'id' => 'ruang rapat']
                        ],
                        'options' => [
                            'The supervisor is currently marking the evaluation results in the meeting room.',
                            'The supervisor currently is marking the evaluation results in the meeting room.',
                            'The supervisor is currently mark the evaluation results in the meeting room.',
                            'The supervisor currently marking the evaluation results in the meeting room.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata keterangan "currently" diletakkan di antara to be "is" dan kata kerja utama "marking".'
                    ],
                    [
                        'id' => 66,
                        'id_sentence' => 'Pada waktu seperti ini, divisi operasional biasanya sedang menyusun laporan mingguan.',
                        'target_word' => 'At this time, ... is compiling (Adverbial Phrase)',
                        'vocab' => [
                            ['en' => 'at this time', 'id' => 'pada waktu seperti ini'],
                            ['en' => 'compiling', 'id' => 'menyusun'],
                            ['en' => 'weekly report', 'id' => 'laporan mingguan']
                        ],
                        'options' => [
                            'At this time, the operations division is usually compiling the weekly report.',
                            'At this time, the operations division are usually compiling the weekly report.',
                            'At this time, the operations division is usually compile the weekly report.',
                            'At this time, the operations division usually compiling the weekly report.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Frasa "At this time" mengawali kalimat, diikuti subjek tunggal "the operations division is compiling".'
                    ],
                    [
                        'id' => 67,
                        'id_sentence' => 'Vendor kami sekarang sedang menguji kualitas sampel produk terbaru.',
                        'target_word' => 'is now testing (Adverbial Between Auxiliary & Verb)',
                        'vocab' => [
                            ['en' => 'now', 'id' => 'sekarang'],
                            ['en' => 'testing', 'id' => 'menguji'],
                            ['en' => 'latest product sample', 'id' => 'sampel produk terbaru']
                        ],
                        'options' => [
                            'Our vendor is now testing the quality of the latest product sample.',
                            'Our vendor now is testing the quality of the latest product sample.',
                            'Our vendor is now test the quality of the latest product sample.',
                            'Our vendor now testing the quality of the latest product sample.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata "now" diletakkan setelah to be "is", sebelum kata kerja utama "testing".'
                    ],
                    [
                        'id' => 68,
                        'id_sentence' => 'Minggu ini, para pemasok sedang mengirim lebih banyak stok karena permintaan meningkat.',
                        'target_word' => 'This week, ... are sending (Adverbial Placement)',
                        'vocab' => [
                            ['en' => 'this week', 'id' => 'minggu ini'],
                            ['en' => 'sending', 'id' => 'mengirim'],
                            ['en' => 'increased demand', 'id' => 'permintaan meningkat']
                        ],
                        'options' => [
                            'This week, the suppliers are sending more stock because of increased demand.',
                            'This week, the suppliers is sending more stock because of increased demand.',
                            'This week, the suppliers are send more stock because of increased demand.',
                            'This week, the suppliers sending more stock because of increased demand.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"This week" di awal kalimat diikuti subjek jamak "the suppliers are sending".'
                    ],
                    [
                        'id' => 69,
                        'id_sentence' => 'Saat ini, konsultan sedang beristirahat sebelum sesi presentasi berikutnya.',
                        'target_word' => 'is currently resting (Adverbial Between Auxiliary & Verb)',
                        'vocab' => [
                            ['en' => 'currently', 'id' => 'saat ini'],
                            ['en' => 'resting', 'id' => 'beristirahat'],
                            ['en' => 'next presentation session', 'id' => 'sesi presentasi berikutnya']
                        ],
                        'options' => [
                            'The consultant is currently resting before the next presentation session.',
                            'The consultant currently is resting before the next presentation session.',
                            'The consultant is currently rest before the next presentation session.',
                            'The consultant currently resting before the next presentation session.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Currently" diletakkan di antara "is" dan "resting".'
                    ],
                    [
                        'id' => 70,
                        'id_sentence' => 'Bulan ini, perusahaan kami sedang mengumpulkan umpan balik pelanggan untuk evaluasi tahunan.',
                        'target_word' => 'This month, ... is collecting (Adverbial Placement)',
                        'vocab' => [
                            ['en' => 'this month', 'id' => 'bulan ini'],
                            ['en' => 'collecting', 'id' => 'mengumpulkan'],
                            ['en' => 'annual evaluation', 'id' => 'evaluasi tahunan']
                        ],
                        'options' => [
                            'This month, our company is collecting customer feedback for the annual evaluation.',
                            'This month, our company are collecting customer feedback for the annual evaluation.',
                            'This month, our company is collect customer feedback for the annual evaluation.',
                            'This month, our company collecting customer feedback for the annual evaluation.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"This month" di awal kalimat diikuti subjek tunggal "our company is collecting".'
                    ],
                ]
            ],

            // Sub-Lesson 1.9.8
            [
                'id' => 'continuous-synthesis',
                'name' => '1.9.8 Menggabungkan Dua Kejadian yang Berlangsung Bersamaan',
                'code' => '1.9.8',
                'concept_title' => 'Menggabungkan Dua Kejadian yang Berlangsung Bersamaan',
                'concept_description' => 'Menggabungkan dua klausa Present Continuous dengan kata sambung seperti while, because, as, dan although untuk menjelaskan dua hal yang sedang berlangsung pada waktu yang sama.',
                'description' => 'Menggabungkan dua klausa Present Continuous dengan kata sambung seperti while, because, as, dan although untuk menjelaskan dua hal yang sedang berlangsung pada waktu yang sama.',
                'formula' => 'Kata Sambung (While/Because/As) + Klausa 1 (Continuous) + Koma + Klausa 2 (Continuous)',
                'rules' => [
                    'Gunakan "while" atau "although" untuk membandingkan dua hal yang berlangsung bersamaan.',
                    'Gunakan "because" atau "as" untuk menghubungkan sebab-akibat yang sedang berlangsung.',
                    'Jaga agar subjek dan to be tetap sesuai (cocok/agreement) di setiap klausa.'
                ],
                'exercises' => [
                    [
                        'id' => 71,
                        'id_sentence' => 'Sementara tim desain sedang merancang kemasan baru, tim produksi sedang menyiapkan lini perakitan.',
                        'target_word' => 'is designing ... is preparing (Simultaneous Actions)',
                        'vocab' => [
                            ['en' => 'designing', 'id' => 'merancang'],
                            ['en' => 'preparing the assembly line', 'id' => 'menyiapkan lini perakitan']
                        ],
                        'options' => [
                            'While the design team is designing the new packaging, the production team is preparing the assembly line.',
                            'While the design team designs the new packaging, the production team prepares the assembly line.',
                            'While the design team are designing the new packaging, the production team are preparing the assembly line.',
                            'While the design team is designing the new packaging, the production team preparing the assembly line.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Dua kejadian yang berlangsung bersamaan dinyatakan dengan klausa kontras Present Continuous: "is designing" dan "is preparing".'
                    ],
                    [
                        'id' => 72,
                        'id_sentence' => 'Kontrak sedang ditinjau oleh bagian hukum, sementara faktur sedang disiapkan oleh bagian keuangan.',
                        'target_word' => 'is being reviewed ... is being prepared (Dual Continuous Passive)',
                        'vocab' => [
                            ['en' => 'contract', 'id' => 'kontrak'],
                            ['en' => 'reviewed', 'id' => 'ditinjau'],
                            ['en' => 'invoice', 'id' => 'faktur']
                        ],
                        'options' => [
                            'The contract is being reviewed by the legal department, while the invoice is being prepared by the finance department.',
                            'The contract is reviewing by the legal department, while the invoice is preparing by the finance department.',
                            'The contract are being reviewed by the legal department, while the invoice are being prepared by the finance department.',
                            'The contract is being review by the legal department, while the invoice is being prepare by the finance department.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kedua klausa memerlukan pasif continuous tunggal: "is being reviewed" dan "is being prepared".'
                    ],
                    [
                        'id' => 73,
                        'id_sentence' => 'Karena permintaan sedang melonjak, pabrik sedang menambah jam operasional produksi.',
                        'target_word' => 'is surging ... is extending (Causal Continuous)',
                        'vocab' => [
                            ['en' => 'surging demand', 'id' => 'permintaan melonjak'],
                            ['en' => 'extending production hours', 'id' => 'menambah jam operasional produksi']
                        ],
                        'options' => [
                            'Because demand is surging, the factory is extending its production hours.',
                            'Because demand are surging, the factory are extending its production hours.',
                            'Because demand is surge, the factory is extending its production hours.',
                            'Because demand surging, the factory extending its production hours.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa sebab "demand is surging" dan klausa akibat "the factory is extending" keduanya memakai Present Continuous.'
                    ],
                    [
                        'id' => 74,
                        'id_sentence' => 'Sementara satu tim sedang menangani keluhan pelanggan, tim lain sedang menyiapkan kampanye promosi baru.',
                        'target_word' => 'is handling ... is preparing (Simultaneous Actions)',
                        'vocab' => [
                            ['en' => 'handling complaints', 'id' => 'menangani keluhan'],
                            ['en' => 'preparing a promotional campaign', 'id' => 'menyiapkan kampanye promosi']
                        ],
                        'options' => [
                            'While one team is handling customer complaints, the other team is preparing a new promotional campaign.',
                            'While one team handles customer complaints, the other team prepares a new promotional campaign.',
                            'While one team are handling customer complaints, the other team are preparing a new promotional campaign.',
                            'While one team is handling customer complaints, the other team preparing a new promotional campaign.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa pertama dan kedua sama-sama memakai bentuk Present Continuous tunggal.'
                    ],
                    [
                        'id' => 75,
                        'id_sentence' => 'Penjualan daring sedang tumbuh pesat karena tim pemasaran rutin memperbarui konten media sosial.',
                        'target_word' => 'are growing ... is updating (Causal Continuous)',
                        'vocab' => [
                            ['en' => 'online sales', 'id' => 'penjualan daring'],
                            ['en' => 'growing rapidly', 'id' => 'tumbuh pesat'],
                            ['en' => 'updating content', 'id' => 'memperbarui konten']
                        ],
                        'options' => [
                            'Online sales are growing rapidly because the marketing team is regularly updating the social media content.',
                            'Online sales is growing rapidly because the marketing team are regularly updating the social media content.',
                            'Online sales are grown rapidly because the marketing team are updated the social media content.',
                            'Online sales growing rapidly because the marketing team updating the social media content.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "sales" berpasangan dengan "are growing", dan subjek tunggal "the marketing team" berpasangan dengan "is updating".'
                    ],
                    [
                        'id' => 76,
                        'id_sentence' => 'Sistem keamanan baru sedang dipasang, sehingga risiko kebocoran data sedang menurun.',
                        'target_word' => 'is being installed ... is decreasing (Passive to Active Result)',
                        'vocab' => [
                            ['en' => 'new security system', 'id' => 'sistem keamanan baru'],
                            ['en' => 'installed', 'id' => 'dipasang'],
                            ['en' => 'risk of data leaks', 'id' => 'risiko kebocoran data']
                        ],
                        'options' => [
                            'The new security system is being installed, so the risk of data leaks is decreasing.',
                            'The new security system is being installed, so the risk of data leaks are decreasing.',
                            'The new security system is installing, so the risk of data leaks is decreasing.',
                            'The new security system is being installed, so the risk of data leaks decreasing.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa pertama memakai pasif continuous tunggal "is being installed", klausa kedua memakai aktif tunggal "is decreasing".'
                    ],
                    [
                        'id' => 77,
                        'id_sentence' => 'Seiring semakin banyak perusahaan beralih ke kerja jarak jauh, kebutuhan ruang kantor fisik sedang menurun.',
                        'target_word' => 'are shifting ... is declining (Business Transition)',
                        'vocab' => [
                            ['en' => 'companies', 'id' => 'perusahaan'],
                            ['en' => 'shifting to remote work', 'id' => 'beralih ke kerja jarak jauh'],
                            ['en' => 'declining', 'id' => 'menurun']
                        ],
                        'options' => [
                            'As more companies are shifting to remote work, the demand for physical office space is declining.',
                            'As more companies is shifting to remote work, the demand for physical office space are declining.',
                            'As more companies are shifted to remote work, the demand for physical office space are declined.',
                            'As more companies shifting to remote work, the demand for physical office space declining.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "companies" memakai "are shifting", subjek tunggal "demand" memakai "is declining".'
                    ],
                    [
                        'id' => 78,
                        'id_sentence' => 'Jalan akses gudang sedang diperbaiki oleh kontraktor, sementara staf gudang sedang memasang rute sementara.',
                        'target_word' => 'is being repaired ... are setting up',
                        'vocab' => [
                            ['en' => 'warehouse access road', 'id' => 'jalan akses gudang'],
                            ['en' => 'repaired', 'id' => 'diperbaiki'],
                            ['en' => 'temporary route', 'id' => 'rute sementara']
                        ],
                        'options' => [
                            'The warehouse access road is being repaired by the contractor, while the warehouse staff are setting up a temporary route.',
                            'The warehouse access road is repairing by the contractor, while the warehouse staff are setting up a temporary route.',
                            'The warehouse access road are being repaired by the contractor, while the warehouse staff is setting up a temporary route.',
                            'The warehouse access road is being repaired by the contractor, while the warehouse staff setting up a temporary route.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa pertama memakai pasif tunggal "is being repaired", klausa kedua memakai aktif jamak "are setting up".'
                    ],
                    [
                        'id' => 79,
                        'id_sentence' => 'Kebiasaan belanja pelanggan kami sedang berubah karena mereka sedang beralih ke pembayaran digital.',
                        'target_word' => 'are changing ... are switching (Everyday Cause and Effect)',
                        'vocab' => [
                            ['en' => 'customer shopping habits', 'id' => 'kebiasaan belanja pelanggan'],
                            ['en' => 'changing', 'id' => 'berubah'],
                            ['en' => 'switching to digital payments', 'id' => 'beralih ke pembayaran digital']
                        ],
                        'options' => [
                            'Our customers\' shopping habits are changing because they are switching to digital payments.',
                            'Our customers\' shopping habits is changing because they is switching to digital payments.',
                            'Our customers\' shopping habits are changed because they are switched to digital payments.',
                            'Our customers\' shopping habits changing because they switching to digital payments.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Habits" (jamak) dan "they" (jamak) keduanya memakai subjek jamak: "are changing" dan "are switching".'
                    ],
                    [
                        'id' => 80,
                        'id_sentence' => 'Meskipun manajer sedang sibuk dengan rapat, ia tetap sedang membalas pesan mendesak dari klien.',
                        'target_word' => 'is working ... is replying (Contrast with Although)',
                        'vocab' => [
                            ['en' => 'busy with meetings', 'id' => 'sibuk dengan rapat'],
                            ['en' => 'replying', 'id' => 'membalas'],
                            ['en' => 'urgent message', 'id' => 'pesan mendesak']
                        ],
                        'options' => [
                            'Although the manager is busy with meetings, he is still replying to an urgent message from a client.',
                            'Although the manager is busy with meetings, he still replies to an urgent message from a client.',
                            'Although the manager are busy with meetings, he are still replying to an urgent message from a client.',
                            'Although the manager is busy meetings, he is still reply to an urgent message from a client.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kedua klausa memakai Present Continuous tunggal: "is working/is busy" dan "is replying".'
                    ],
                ]
            ],
        ];
    }
}
