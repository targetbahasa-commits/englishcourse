<?php

namespace App\Services;

class SelfStudyAdverbialClauseData
{
    /**
     * Get the complete Adverbial Clause package (Module 3.1).
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
            'banner_title' => 'Adverbial Clause: Academic Subordination & Logic Architecture',
            'banner_subtitle' => 'Kuasai konstruksi klausa adverbial bertingkat dalam penulisan ilmiah & esai IELTS Academic: Klausa kausalitas (because, since, as, given that) vs preposisi kausal (because of, due to, owing to), klausa konsesi dan kontras (although, even though, while, whereas) vs preposisi kontras (despite, in spite of), klausa waktu dan sekuens (when, while, once, before, after, until), klausa syarat (if, unless, provided that, as long as), klausa tujuan & akibat (so that, in order that, so... that, such... that), serta mekanika penempatan klausa dan eliminasi comma splices.',
            'banner_badge' => 'MODULE 3.1 ADVERBIAL CLAUSE',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 3.1
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Panduan Komprehensif Klausa Adverbial (Adverbial Clause)',
            'concept_summary' => 'Klausa Adverbial (Adverbial Clause) adalah klausa terikat (dependent clause) yang diawali oleh konjungsi subordinatif (subordinating conjunction) dan berfungsi memodifikasi kata kerja, kata sifat, atau klausa utama secara keseluruhan. Dalam penulisan akademis berbobot tinggi (IELTS Band 8-9), klausa adverbial adalah pilar utama pembentukan kalimat majemuk bertingkat (complex sentences) untuk mengekspresikan relasi logika: sebab-akibat, konsesi/pertentangan, temporal/waktu, syarat/kondisi, dan tujuan/dampak. Penguasaan topik ini mencakup: (1) Membedakan kata hubung klausa (membutuhkan S + V) dari frasa preposisi (membutuhkan Noun Phrase/Gerund); (2) Menghindari kesalahan fatal Comma Splice dan Sentence Fragments; (3) Menghindari pemakaian modal \'will\' pada klausa waktu dan syarat masa depan; (4) Memahami aturan tanda baca koma wajib pada klausa depan (fronted clause); serta (5) Menerapkan pola konsesi register formal.',
            'rules' => [
                [
                    'rule_title' => '1. Subordinating Conjunction vs Prepositional Phrase',
                    'rule_formula' => '[Because / Although / Since / While] + S + V | [Because of / Despite / In spite of / Due to] + Noun Phrase / Gerund',
                    'rule_description' => 'Konjungsi subordinatif WAJIB diikuti klausa lengkap berpredikat (S + V). Preposisi WAJIB diikuti frasa kata benda atau gerund (-ing). Jangan pernah menaruh kata kerja finitis langsung setelah \'despite\' atau \'because of\'.',
                    'examples' => [
                        [
                            'en' => 'Although operational expenditures rose significantly, profit margins remained robust.',
                            'id' => 'Meskipun pengeluaran operasional naik signifikan, margin laba tetap kuat.',
                            'note' => '\'Although\' diikuti klausa utuh (S + V).'
                        ],
                        [
                            'en' => 'Despite rising operational expenditures, profit margins remained robust.',
                            'id' => 'Terlepas dari kenaikan pengeluaran operasional, margin laba tetap kuat.',
                            'note' => '\'Despite\' diikuti gerund phrase tanpa kata kerja bantu.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '2. Aturan Koma pada Penempatan Klausa (Clause Positioning)',
                    'rule_formula' => 'Klausa Depan: [Subordinate Clause], [Main Clause]. | Klausa Belakang: [Main Clause] [Subordinate Clause].',
                    'rule_description' => 'Jika klausa adverbial diletakkan di depan kalimat, tanda koma WAJIB diletakkan di akhir klausa tersebut sebelum klausa utama. Jika diletakkan di belakang, tanda koma umumnya TIDAK digunakan (kecuali klausa kontras ekstrem seperti \'whereas\').',
                    'examples' => [
                        [
                            'en' => 'Because global supply chains experienced disruptions, the delivery timeline was delayed.',
                            'id' => 'Karena rantai pasok global mengalami gangguan, jadwal pengiriman tertunda.',
                            'note' => 'Klausa depan mewajibkan koma setelah \'disruptions\'.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '3. Larangan Modal \'Will\' dalam Klausa Waktu & Syarat Masa Depan',
                    'rule_formula' => '[When / Once / As soon as / If / Unless] + Subject + Present Simple, [Subject + will + Verb]',
                    'rule_description' => 'Klausa adverbial waktu dan syarat yang merujuk pada masa depan TIDAK PERNAH menggunakan modal \'will\' atau \'shall\'; gunakan Simple Present sebagai penggantinya.',
                    'examples' => [
                        [
                            'en' => 'Once the regulatory authority approves the dossier, distribution will commence.',
                            'id' => 'Begitu otoritas regulasi menyetujui dokumen tersebut, distribusi akan dimulai.',
                            'note' => 'Bentuk baku: \'approves\' (BUKAN *will approve*).'
                        ]
                    ]
                ],
                [
                    'rule_title' => '4. Prinsip Negatif Tunggal pada \'Unless\'',
                    'rule_formula' => 'Unless + Subject + Positive Verb... (= If + Subject + Negative Verb)',
                    'rule_description' => '\'Unless\' sudah bermakna \'if not\'. Jangan menambahkan negasi \'not\' ke dalam predikat klausa unless karena akan menghasilkan kerancuan logika (double negative).',
                    'examples' => [
                        [
                            'en' => 'Unless emissions are curtailed rapidly, catastrophic warming cannot be averted.',
                            'id' => 'Kecuali jika emisi dipangkas cepat, pemanasan katastrofik tidak dapat dicegah.',
                            'note' => 'Gunakan predikat positif \'are curtailed\'.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '5. Perbedaan Konstruksi Hasil: \'So... that\' vs \'Such... that\'',
                    'rule_formula' => 'so + Adjective / Adverb + that | such + (a/an) + (Adjective) Noun + that',
                    'rule_description' => 'Gunakan \'so\' bila diikuti kata sifat atau kata keterangan tunggal. Gunakan \'such\' bila terdapat kata benda (baik tunggal, jamak, maupun tak dapat dihitung).',
                    'examples' => [
                        [
                            'en' => 'The volatility was so intense that trading was halted.',
                            'id' => 'Volatilitasnya sedemikian intens sehingga perdagangan dihentikan.',
                            'note' => '\'intense\' adalah kata sifat tunggal -> gunakan \'so\'.'
                        ],
                        [
                            'en' => 'It was such intense volatility that trading was halted.',
                            'id' => 'Itu merupakan volatilitas yang sedemikian intens sehingga perdagangan dihentikan.',
                            'note' => 'Terdapat kata benda \'volatility\' -> gunakan \'such\'.'
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Complete sub-lessons with exercises.
     */
    public static function getSubLessons(): array
    {
        return [
            [
                'id' => 'cause-reason-clauses',
                'name' => '3.1.1 Cause & Reason Clauses (because, since, as, given that vs because of, due to)',
                'code' => '3.1.1',
                'concept_title' => 'Klausa Sebab & Alasan (Cause & Reason Subordination)',
                'concept_description' => 'Klausa adverbial sebab-akibat menghubungkan alasan logis dengan hasil pada klausa utama. Kata hubung subordinatif klausa (because, since, as, given that) WAJIB diikuti klausa lengkap berpredikat (Subject + Verb). Sebaliknya, ungkapan preposisional (because of, due to, owing to, as a result of) WAJIB diikuti frasa benda (Noun Phrase) atau gerund (-ing), BUKAN klausa berkata kerja mandiri.',
                'description' => 'Klausa adverbial sebab-akibat menghubungkan alasan logis dengan hasil pada klausa utama. Kata hubung subordinatif klausa (because, since, as, given that) WAJIB diikuti klausa lengkap berpredikat (Subject + Verb). Sebaliknya, ungkapan preposisional (because of, due to, owing to, as a result of) WAJIB diikuti frasa benda (Noun Phrase) atau gerund (-ing), BUKAN klausa berkata kerja mandiri.',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-emerald-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-emerald-500/25 text-emerald-300 border border-emerald-500/50 font-mono">CAUSE &amp; EFFECT</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Klausa Sebab-Akibat (<em>Because, Since, As, Given that</em>)</span>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1.5">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-amber-300 uppercase tracking-wide flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-400"></span> [1] Posisi Awal (Wajib Koma)
            </span>
            <code class="text-xs font-mono font-bold text-emerald-300 bg-slate-950 px-2.5 py-1 rounded border border-emerald-500/40">[Because / Given that + S + V], [Main Clause]</code>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-emerald-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">Given that fossil fuels are finite, governments must subsidize renewable energy.</span>
        </div>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1.5">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-sky-300 uppercase tracking-wide flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-sky-400"></span> [2] Posisi Belakang (Tanpa Koma)
            </span>
            <code class="text-xs font-mono font-bold text-sky-300 bg-slate-950 px-2.5 py-1 rounded border border-sky-500/40">[Main Clause] + because / since + [S + V]</code>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-sky-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">Public support plummeted because the administration failed to explain the tax policy.</span>
        </div>
    </div>
</div>
HTML,
                'rules' => [
                    'Gunakan \'because\', \'since\', \'as\', atau \'given that\' jika diikuti klausa utuh (memiliki subjek dan kata kerja finitis).',
                    'Gunakan \'because of\', \'due to\', \'owing to\', atau \'on account of\' jika diikuti kata benda (noun/noun phrase) atau gerund.',
                    '\'Due to\' secara gramatikal paling tepat mengikuti to-be atau kata benda (adjectival predicate), sedangkan \'because of\' memodifikasi kata kerja (adverbial predicate).',
                    'Jika klausa sebab diletakkan di awal kalimat (fronted clause), tanda koma WAJIB diletakkan di akhir klausa tersebut sebelum klausa utama.',
                    'Jangan pernah menggabungkan kata hubung klausa dengan preposisi ganda (misalnya: *because of because* atau *since due to*).',
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'id_sentence' => 'Karena biaya logistik global meningkat tajam tahun lalu, perusahaan terpaksa menyesuaikan harga jual produknya.',
                        'target_word' => 'Because global logistics costs escalated sharply last year, the firm was forced to adjust (Because + Clause)',
                        'vocab' => [
                            ['en' => 'global logistics costs escalated sharply', 'id' => 'biaya logistik global meningkat tajam'],
                            ['en' => 'the firm was forced to adjust retail prices', 'id' => 'perusahaan terpaksa menyesuaikan harga jual produk'],
                        ],
                        'options' => [
                            'Because global logistics costs escalated sharply last year, the firm was forced to adjust the retail prices of its products.',
                            'Because of global logistics costs escalated sharply last year, the firm was forced to adjust the retail prices of its products.',
                            'Because global logistics costs escalated sharply last year the firm was forced to adjust the retail prices of its products.',
                            'Due to global logistics costs escalated sharply last year, the firm was forced to adjust the retail prices of its products.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bagian alasan memiliki subjek \'global logistics costs\' dan predikat kata kerja \'escalated\' (klausa lengkap), sehingga wajib menggunakan subordinating conjunction \'Because\' (bukan preposisi \'Because of\' atau \'Due to\') serta koma di akhir klausa depan.',
                    ],
                    [
                        'id' => 2,
                        'id_sentence' => 'Proyek konstruksi tersebut mengalami keterlambatan yang signifikan karena penurunan anggaran yang tidak terduga.',
                        'target_word' => 'The construction project experienced significant delays because of an unforeseen budget reduction (because of + Noun Phrase)',
                        'vocab' => [
                            ['en' => 'the construction project experienced significant delays', 'id' => 'proyek konstruksi tersebut mengalami keterlambatan yang signifikan'],
                            ['en' => 'an unforeseen budget reduction', 'id' => 'penurunan anggaran yang tidak terduga'],
                        ],
                        'options' => [
                            'The construction project experienced significant delays because of an unforeseen budget reduction.',
                            'The construction project experienced significant delays because an unforeseen budget reduction.',
                            'The construction project experienced significant delays since an unforeseen budget reduction.',
                            'The construction project experienced significant delays due an unforeseen budget reduction.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'An unforeseen budget reduction\' adalah frasa benda (Noun Phrase) tanpa kata kerja finitis, sehingga membutuhkan prepositional phrase \'because of\' (bukan conjunction \'because\' atau \'since\').',
                    ],
                    [
                        'id' => 3,
                        'id_sentence' => 'Mengingat bahwa permintaan pasar terhadap kendaraan listrik terus meningkat, pabrikan memperluas fasilitas produksinya.',
                        'target_word' => 'Given that market demand for electric vehicles continues to rise, the manufacturer is expanding (Given that + Clause)',
                        'vocab' => [
                            ['en' => 'market demand for electric vehicles continues to rise', 'id' => 'permintaan pasar terhadap kendaraan listrik terus meningkat'],
                            ['en' => 'the manufacturer is expanding its production facilities', 'id' => 'pabrikan memperluas fasilitas produksinya'],
                        ],
                        'options' => [
                            'Given that market demand for electric vehicles continues to rise, the manufacturer is expanding its production facilities.',
                            'Given market demand for electric vehicles continues to rise, the manufacturer is expanding its production facilities.',
                            'Given that market demand for electric vehicles continues to rise the manufacturer is expanding its production facilities.',
                            'Owing to market demand for electric vehicles continues to rise, the manufacturer is expanding its production facilities.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Given that\' adalah konjungsi subordinatif register akademik formal yang diikuti klausa lengkap (Subject + Verb). Koma wajib memisahkan klausa penjelas di depan.',
                    ],
                    [
                        'id' => 4,
                        'id_sentence' => 'Karena data survei tidak lengkap, para peneliti tidak dapat menarik kesimpulan yang definitif.',
                        'target_word' => 'Since the survey data were incomplete, the researchers were unable to draw definitive conclusions (Since + Clause)',
                        'vocab' => [
                            ['en' => 'the survey data were incomplete', 'id' => 'data survei tidak lengkap'],
                            ['en' => 'the researchers were unable to draw definitive conclusions', 'id' => 'para peneliti tidak dapat menarik kesimpulan definitif'],
                        ],
                        'options' => [
                            'Since the survey data were incomplete, the researchers were unable to draw definitive conclusions.',
                            'Since of the survey data were incomplete, the researchers were unable to draw definitive conclusions.',
                            'Because the survey data incomplete, the researchers were unable to draw definitive conclusions.',
                            'Due to the survey data were incomplete, the researchers were unable to draw definitive conclusions.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Since\' berfungsi sebagai konjungsi kausal yang diikuti klausa lengkap (\'the survey data were incomplete\').',
                    ],
                    [
                        'id' => 5,
                        'id_sentence' => 'Kegagalan sensor suhu terutama disebabkan oleh paparan kelembapan ekstrem yang berkepanjangan.',
                        'target_word' => 'The failure of the temperature sensor was primarily due to prolonged exposure to extreme humidity (be + due to + Noun Phrase)',
                        'vocab' => [
                            ['en' => 'the failure of the temperature sensor', 'id' => 'kegagalan sensor suhu'],
                            ['en' => 'prolonged exposure to extreme humidity', 'id' => 'paparan kelembapan ekstrem yang berkepanjangan'],
                        ],
                        'options' => [
                            'The failure of the temperature sensor was primarily due to prolonged exposure to extreme humidity.',
                            'The failure of the temperature sensor was primarily because prolonged exposure to extreme humidity.',
                            'The failure of the temperature sensor was primarily owing prolonged exposure to extreme humidity.',
                            'The failure of the temperature sensor was primarily since prolonged exposure to extreme humidity.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Setelah kata kerja penghubung \'was\' (predicate adjective position), \'due to\' adalah konstruksi yang paling baku di ranah akademik formal untuk memodifikasi frasa benda.',
                    ],
                    [
                        'id' => 6,
                        'id_sentence' => 'Karena kebijakan moneter diperketat secara bertahap, laju inflasi mulai mereda pada kuartal ketiga.',
                        'target_word' => 'As monetary policy was tightened incrementally, the inflation rate began to subside (As + Clause)',
                        'vocab' => [
                            ['en' => 'monetary policy was tightened incrementally', 'id' => 'kebijakan moneter diperketat secara bertahap'],
                            ['en' => 'the inflation rate began to subside in the third quarter', 'id' => 'laju inflasi mulai mereda pada kuartal ketiga'],
                        ],
                        'options' => [
                            'As monetary policy was tightened incrementally, the inflation rate began to subside in the third quarter.',
                            'As because monetary policy was tightened incrementally, the inflation rate began to subside in the third quarter.',
                            'As monetary policy was tightened incrementally the inflation rate began to subside in the third quarter.',
                            'Owing to monetary policy was tightened incrementally, the inflation rate began to subside in the third quarter.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'As\' berfungsi sebagai kata hubung kausal yang menghubungkan proses perubahan bertahap dengan hasil, diikuti klausa pasif lengkap dan koma pemisah.',
                    ],
                    [
                        'id' => 7,
                        'id_sentence' => 'Hasil eksperimen tidak valid akibat kontaminasi silang di dalam wadah reaksi.',
                        'target_word' => 'The experimental results were invalid owing to cross-contamination within the reaction vessel (owing to + Noun Phrase)',
                        'vocab' => [
                            ['en' => 'the experimental results were invalid', 'id' => 'hasil eksperimen tidak valid'],
                            ['en' => 'cross-contamination within the reaction vessel', 'id' => 'kontaminasi silang di dalam wadah reaksi'],
                        ],
                        'options' => [
                            'The experimental results were invalid owing to cross-contamination within the reaction vessel.',
                            'The experimental results were invalid owing cross-contamination within the reaction vessel.',
                            'The experimental results were invalid because cross-contamination within the reaction vessel.',
                            'The experimental results were invalid since cross-contamination within the reaction vessel.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Owing to\' adalah frasa preposisi berlaras tinggi yang diikuti oleh frasa benda (\'cross-contamination within the reaction vessel\').',
                    ],
                    [
                        'id' => 8,
                        'id_sentence' => 'Karena sistem automasi baru memangkas waktu pemrosesan transaksi, kepuasan nasabah meningkat pesat.',
                        'target_word' => 'Because the new automation system reduced transaction processing times, customer satisfaction rose (Because + Clause)',
                        'vocab' => [
                            ['en' => 'the new automation system reduced transaction processing times', 'id' => 'sistem automasi baru memangkas waktu pemrosesan transaksi'],
                            ['en' => 'customer satisfaction rose considerably', 'id' => 'kepuasan nasabah meningkat pesat'],
                        ],
                        'options' => [
                            'Because the new automation system reduced transaction processing times, customer satisfaction rose considerably.',
                            'Because of the new automation system reduced transaction processing times, customer satisfaction rose considerably.',
                            'Due to the new automation system reduced transaction processing times, customer satisfaction rose considerably.',
                            'Since the new automation system reduced transaction processing times customer satisfaction rose considerably.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa alasan memiliki subjek \'the new automation system\' dan kata kerja transitif \'reduced\', sehingga memerlukan konjungsi klausa \'Because\' dengan tanda koma sebelum klausa utama.',
                    ],
                    [
                        'id' => 9,
                        'id_sentence' => 'Penerbangan internasional dibatalkan karena abu vulkanik pekat yang menyelimuti wilayah udara.',
                        'target_word' => 'International flights were cancelled on account of dense volcanic ash blanketing the airspace (on account of + Noun Phrase)',
                        'vocab' => [
                            ['en' => 'international flights were cancelled', 'id' => 'penerbangan internasional dibatalkan'],
                            ['en' => 'dense volcanic ash blanketing the airspace', 'id' => 'abu vulkanik pekat yang menyelimuti wilayah udara'],
                        ],
                        'options' => [
                            'International flights were cancelled on account of dense volcanic ash blanketing the airspace.',
                            'International flights were cancelled on account dense volcanic ash blanketing the airspace.',
                            'International flights were cancelled because dense volcanic ash blanketing the airspace.',
                            'International flights were cancelled since dense volcanic ash blanketing the airspace.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'On account of\' adalah bentuk preposisional yang sinonim dengan \'because of\' dan diikuti oleh noun phrase termodifikasi partisip (\'dense volcanic ash blanketing the airspace\').',
                    ],
                    [
                        'id' => 10,
                        'id_sentence' => 'Karena kedua variabel berkorelasi kuat dalam analisis regresi, hipotesis awal diterima oleh tim penguji.',
                        'target_word' => 'Since both variables correlated strongly in the regression analysis, the initial hypothesis was accepted (Since + Clause)',
                        'vocab' => [
                            ['en' => 'both variables correlated strongly in the regression analysis', 'id' => 'kedua variabel berkorelasi kuat dalam analisis regresi'],
                            ['en' => 'the initial hypothesis was accepted by the review panel', 'id' => 'hipotesis awal diterima oleh tim penguji'],
                        ],
                        'options' => [
                            'Since both variables correlated strongly in the regression analysis, the initial hypothesis was accepted by the review panel.',
                            'Due to both variables correlated strongly in the regression analysis, the initial hypothesis was accepted by the review panel.',
                            'Because of both variables correlated strongly in the regression analysis, the initial hypothesis was accepted by the review panel.',
                            'Since both variables correlated strongly in the regression analysis the initial hypothesis was accepted by the review panel.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Since\' mengawali klausa subordinat lengkap berpredikat \'correlated strongly\', dan dipisahkan dengan tanda koma dari klausa utama.',
                    ],
                ]
            ],
            [
                'id' => 'concession-contrast-clauses',
                'name' => '3.1.2 Concession & Contrast Clauses (although, even though, while, whereas vs despite)',
                'code' => '3.1.2',
                'concept_title' => 'Klausa Konsesi & Pertentangan (Concession & Contrast Subordination)',
                'concept_description' => 'Klausa konsesi mengakui kebenaran suatu fakta atau hambatan, namun menegaskan bahwa klausa utama tetap terjadi atau bernilai benar (lawan dari ekspektasi wajar). Subordinating conjunctions (although, even though, though, while, whereas) menghubungkan klausa penuh (S + V). Sebaliknya, preposisi kontras (despite, in spite of, regardless of, notwithstanding) HANYA diikuti oleh frasa benda (Noun Phrase) atau gerund.',
                'description' => 'Klausa konsesi mengakui kebenaran suatu fakta atau hambatan, namun menegaskan bahwa klausa utama tetap terjadi atau bernilai benar (lawan dari ekspektasi wajar). Subordinating conjunctions (although, even though, though, while, whereas) menghubungkan klausa penuh (S + V). Sebaliknya, preposisi kontras (despite, in spite of, regardless of, notwithstanding) HANYA diikuti oleh frasa benda (Noun Phrase) atau gerund.',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-indigo-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-indigo-500/25 text-indigo-300 border border-indigo-500/50 font-mono">CONCESSION &amp; CONTRAST</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Klausa Konsesi (<em>Although, Even though, While, Whereas</em>)</span>
    </div>

    <div class="px-3 py-1.5 rounded-lg bg-rose-950/70 border border-rose-400 text-xs text-white flex items-center gap-2">
        <span class="font-black text-rose-300 uppercase tracking-wider">[LARANGAN FATAL]</span>
        <span>Jangan menggabungkan <strong>Although</strong> dan <strong>but</strong> dalam satu kalimat!</span>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1.5">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-amber-300 uppercase tracking-wide flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-400"></span> Pola Kalimat
            </span>
            <code class="text-xs font-mono font-bold text-emerald-300 bg-slate-950 px-2.5 py-1 rounded border border-emerald-500/40">[Although / Even though + S + V], [Main Clause]</code>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-emerald-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">Although the inflation rate surged, employment figures remained stable.</span>
        </div>
        <div class="text-xs text-white pl-3 border-l-2 border-emerald-400">
            <span class="text-emerald-300 font-bold">✓ Benar:</span> Although the rate surged, employment remained stable. &nbsp;|&nbsp; <span class="text-rose-300 font-bold">✗ Salah:</span> <span class="line-through">Although ... but ...</span>
        </div>
    </div>
</div>
HTML,
                'rules' => [
                    'Gunakan \'Although\' atau \'Even though\' jika diikuti klausa utuh berpredikat (S + V).',
                    'Gunakan \'Despite\' atau \'In spite of\' jika diikuti kata benda atau gerund (V-ing). \'Despite\' TIDAK boleh diikuti kata \'of\' (*despite of* adalah kesalahan fatal).',
                    'Jangan pernah menggabungkan \'Although\' dengan \'But\' dalam satu kalimat (Double Conjunction error: *Although A, but B* adalah salah).',
                    '\'While\' dan \'Whereas\' digunakan untuk membandingkan dua subjek atau situasi yang berlawanan secara paralel.',
                    'Jika ingin menggunakan \'Despite\' di depan klausa utuh, wajib menambahkan frasa \'the fact that\' (contoh: *Despite the fact that inflation rose...*).',
                ],
                'exercises' => [
                    [
                        'id' => 11,
                        'id_sentence' => 'Meskipun biaya awal instalasi panel surya relatif mahal, penghematan energi jangka panjangnya sangat substansial.',
                        'target_word' => 'Although the initial installation cost of solar panels is relatively high, the long-term energy savings are (Although + Clause)',
                        'vocab' => [
                            ['en' => 'the initial installation cost of solar panels is relatively high', 'id' => 'biaya awal instalasi panel surya relatif mahal'],
                            ['en' => 'the long-term energy savings are substantial', 'id' => 'penghematan energi jangka panjangnya sangat substansial'],
                        ],
                        'options' => [
                            'Although the initial installation cost of solar panels is relatively high, the long-term energy savings are substantial.',
                            'Despite the initial installation cost of solar panels is relatively high, the long-term energy savings are substantial.',
                            'Although the initial installation cost of solar panels is relatively high, but the long-term energy savings are substantial.',
                            'In spite of the initial installation cost of solar panels is relatively high, the long-term energy savings are substantial.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Although\' menghubungkan klausa penuh (Subject \'cost\' + Verb \'is\'). Pilihan \'Despite\' salah karena diikuti klausa utuh; pilihan \'but\' salah karena double conjunction.',
                    ],
                    [
                        'id' => 12,
                        'id_sentence' => 'Terlepas dari volatilitas pasar saham yang tinggi, dana pensiun berhasil mencatatkan imbal hasil yang positif.',
                        'target_word' => 'Despite high stock market volatility, the pension fund managed to generate positive returns (Despite + Noun Phrase)',
                        'vocab' => [
                            ['en' => 'high stock market volatility', 'id' => 'volatilitas pasar saham yang tinggi'],
                            ['en' => 'the pension fund managed to generate positive returns', 'id' => 'dana pensiun berhasil mencatatkan imbal hasil positif'],
                        ],
                        'options' => [
                            'Despite high stock market volatility, the pension fund managed to generate positive returns.',
                            'Despite of high stock market volatility, the pension fund managed to generate positive returns.',
                            'Although high stock market volatility, the pension fund managed to generate positive returns.',
                            'Even though high stock market volatility, the pension fund managed to generate positive returns.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'High stock market volatility\' adalah noun phrase tanpa predikat. \'Despite\' digunakan tanpa \'of\'. (\'Although\' dan \'Even though\' butuh klausa utuh).',
                    ],
                    [
                        'id' => 13,
                        'id_sentence' => 'Sementara negara-negara berkembang berfokus pada perluasan akses internet, negara-negara maju memprioritaskan keamanan siber.',
                        'target_word' => 'While developing nations focus on expanding internet access, advanced economies prioritize cybersecurity (While + Contrast Clause)',
                        'vocab' => [
                            ['en' => 'developing nations focus on expanding internet access', 'id' => 'negara berkembang berfokus pada perluasan akses internet'],
                            ['en' => 'advanced economies prioritize cybersecurity infrastructure', 'id' => 'negara maju memprioritaskan infrastruktur keamanan siber'],
                        ],
                        'options' => [
                            'While developing nations focus on expanding internet access, advanced economies prioritize cybersecurity infrastructure.',
                            'Whereas developing nations focus on expanding internet access advanced economies prioritize cybersecurity infrastructure.',
                            'Despite developing nations focus on expanding internet access, advanced economies prioritize cybersecurity infrastructure.',
                            'In spite developing nations focus on expanding internet access, advanced economies prioritize cybersecurity infrastructure.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'While\' mengekspresikan perbandingan kontras langsung antara dua entitas, diikuti klausa lengkap dan dipisahkan tanda koma.',
                    ],
                    [
                        'id' => 14,
                        'id_sentence' => 'Meskipun menghadapi pembatasan pasokan bahan baku, pabrik otomotif tersebut melampaui target kuartalannya.',
                        'target_word' => 'In spite of facing raw material supply constraints, the automotive plant surpassed its quarterly targets (In spite of + Gerund Phrase)',
                        'vocab' => [
                            ['en' => 'facing raw material supply constraints', 'id' => 'menghadapi pembatasan pasokan bahan baku'],
                            ['en' => 'the automotive plant surpassed its quarterly targets', 'id' => 'pabrik otomotif tersebut melampaui target kuartalannya'],
                        ],
                        'options' => [
                            'In spite of facing raw material supply constraints, the automotive plant surpassed its quarterly targets.',
                            'In spite facing raw material supply constraints, the automotive plant surpassed its quarterly targets.',
                            'Although facing of raw material supply constraints, the automotive plant surpassed its quarterly targets.',
                            'Despite of facing raw material supply constraints, the automotive plant surpassed its quarterly targets.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'In spite of\' (wajib lengkap 3 kata) diikuti gerund phrase (\'facing... constraints\'). Pilihan \'Despite of\' adalah salah gramatikal.',
                    ],
                    [
                        'id' => 15,
                        'id_sentence' => 'Meskipun faktanya tingkat suku bunga dinaikkan tiga kali, pinjaman perumahan tetap diminati konsumen.',
                        'target_word' => 'Despite the fact that interest rates were raised three times, mortgage borrowing remained robust (Despite the fact that + Clause)',
                        'vocab' => [
                            ['en' => 'interest rates were raised three times', 'id' => 'tingkat suku bunga dinaikkan tiga kali'],
                            ['en' => 'mortgage borrowing remained robust among consumers', 'id' => 'pinjaman perumahan tetap diminati konsumen'],
                        ],
                        'options' => [
                            'Despite the fact that interest rates were raised three times, mortgage borrowing remained robust among consumers.',
                            'Despite interest rates were raised three times, mortgage borrowing remained robust among consumers.',
                            'In spite the fact that interest rates were raised three times, mortgage borrowing remained robust among consumers.',
                            'Although the fact that interest rates were raised three times, mortgage borrowing remained robust among consumers.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Pola \'Despite the fact that\' memungkinkan preposisi \'despite\' untuk diikuti oleh klausa utuh (S + V) dalam ragam tulisan akademik formal.',
                    ],
                    [
                        'id' => 16,
                        'id_sentence' => 'Sedangkan sektor manufaktur mengalami kontraksi ringan, sektor jasa tumbuh sebesar empat persen.',
                        'target_word' => 'Whereas the manufacturing sector experienced a slight contraction, the services sector expanded by four percent (Whereas + Clause)',
                        'vocab' => [
                            ['en' => 'the manufacturing sector experienced a slight contraction', 'id' => 'sektor manufaktur mengalami kontraksi ringan'],
                            ['en' => 'the services sector expanded by four percent', 'id' => 'sektor jasa tumbuh sebesar empat persen'],
                        ],
                        'options' => [
                            'Whereas the manufacturing sector experienced a slight contraction, the services sector expanded by four percent.',
                            'Whereas of the manufacturing sector experienced a slight contraction, the services sector expanded by four percent.',
                            'Despite the manufacturing sector experienced a slight contraction, the services sector expanded by four percent.',
                            'While the manufacturing sector contraction, the services sector expanded by four percent.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Whereas\' secara formal menyejajarkan dua perbandingan klausal akademis dengan klausa mandiri yang dipisahkan oleh tanda koma.',
                    ],
                    [
                        'id' => 17,
                        'id_sentence' => 'Meskipun para astronom memperingatkan adanya badai matahari, satelit komunikasi tidak mengalami gangguan serius.',
                        'target_word' => 'Even though astronomers had warned of solar storms, communications satellites suffered no severe disruptions (Even though + Clause)',
                        'vocab' => [
                            ['en' => 'astronomers had warned of solar storms', 'id' => 'para astronom memperingatkan adanya badai matahari'],
                            ['en' => 'communications satellites suffered no severe disruptions', 'id' => 'satelit komunikasi tidak mengalami gangguan serius'],
                        ],
                        'options' => [
                            'Even though astronomers had warned of solar storms, communications satellites suffered no severe disruptions.',
                            'Even though astronomers had warned of solar storms, but communications satellites suffered no severe disruptions.',
                            'Despite astronomers had warned of solar storms, communications satellites suffered no severe disruptions.',
                            'In spite of astronomers had warned of solar storms, communications satellites suffered no severe disruptions.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Even though\' memberikan penekanan konsesi yang lebih kuat daripada \'although\', dan tidak boleh digabungkan dengan kata sambung \'but\'.',
                    ],
                    [
                        'id' => 18,
                        'id_sentence' => 'Terlepas dari skeptisisme awal dari para pengulas, teori baru tersebut terbukti konsisten dengan temuan empiris.',
                        'target_word' => 'Notwithstanding initial skepticism from peer reviewers, the new theory proved consistent with empirical findings (Notwithstanding + Noun Phrase)',
                        'vocab' => [
                            ['en' => 'initial skepticism from peer reviewers', 'id' => 'skeptisisme awal dari para pengulas sejawat'],
                            ['en' => 'the new theory proved consistent with empirical findings', 'id' => 'teori baru tersebut terbukti konsisten dengan temuan empiris'],
                        ],
                        'options' => [
                            'Notwithstanding initial skepticism from peer reviewers, the new theory proved consistent with empirical findings.',
                            'Notwithstanding of initial skepticism from peer reviewers, the new theory proved consistent with empirical findings.',
                            'Although initial skepticism from peer reviewers, the new theory proved consistent with empirical findings.',
                            'While initial skepticism from peer reviewers, the new theory proved consistent with empirical findings.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Notwithstanding\' adalah preposisi formal tingkat lanjut yang bermakna sama dengan \'despite\', diikuti langsung oleh noun phrase tanpa \'of\'.',
                    ],
                    [
                        'id' => 19,
                        'id_sentence' => 'Meskipun algoritma baru ini sangat akurat, algoritma tersebut membutuhkan daya komputasi yang jauh lebih besar.',
                        'target_word' => 'Although this new algorithm is exceptionally accurate, it requires considerably more computational power (Although + Clause)',
                        'vocab' => [
                            ['en' => 'this new algorithm is exceptionally accurate', 'id' => 'algoritma baru ini sangat akurat'],
                            ['en' => 'it requires considerably more computational power', 'id' => 'ia membutuhkan daya komputasi yang jauh lebih besar'],
                        ],
                        'options' => [
                            'Although this new algorithm is exceptionally accurate, it requires considerably more computational power.',
                            'Although this new algorithm is exceptionally accurate, however it requires considerably more computational power.',
                            'Despite this new algorithm is exceptionally accurate, it requires considerably more computational power.',
                            'In spite this new algorithm is exceptionally accurate, it requires considerably more computational power.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa \'Although...\' tidak boleh diikuti konjungsi \'however\' dalam kalimat yang sama.',
                    ],
                    [
                        'id' => 20,
                        'id_sentence' => 'Kendati mengalami kekurangan staf teknis yang parah, departemen teknik berhasil menyelesaikan pemeliharaan tepat waktu.',
                        'target_word' => 'Despite severe technical staffing shortages, the engineering department completed maintenance on schedule (Despite + Noun Phrase)',
                        'vocab' => [
                            ['en' => 'severe technical staffing shortages', 'id' => 'kekurangan staf teknis yang parah'],
                            ['en' => 'the engineering department completed maintenance on schedule', 'id' => 'departemen teknik menyelesaikan pemeliharaan tepat waktu'],
                        ],
                        'options' => [
                            'Despite severe technical staffing shortages, the engineering department completed maintenance on schedule.',
                            'Despite of severe technical staffing shortages, the engineering department completed maintenance on schedule.',
                            'Even though severe technical staffing shortages, the engineering department completed maintenance on schedule.',
                            'While severe technical staffing shortages, the engineering department completed maintenance on schedule.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Severe technical staffing shortages\' adalah noun phrase majemuk, sehingga tepat dipasangkan dengan preposisi \'Despite\'.',
                    ],
                ]
            ],
            [
                'id' => 'time-sequence-clauses',
                'name' => '3.1.3 Time & Sequence Clauses (when, while, as soon as, once, before, after, until)',
                'code' => '3.1.3',
                'concept_title' => 'Klausa Waktu & Kronologi (Time & Sequence Subordination)',
                'concept_description' => 'Klausa adverbial waktu menunjukkan kapan suatu peristiwa terjadi dalam kaitan dengan klausa utama (sebelum, sesudah, saat, atau hingga). Konjungsi waktu yang dominan dalam tulisan akademis meliputi: when, while, as, before, after, once, as soon as, and until. Aturan gramatikal penting: klausa adverbial waktu untuk konteks masa depan TIDAK PERNAH menggunakan modal \'will\' atau \'shall\', melainkan menggunakan Present Simple.',
                'description' => 'Klausa adverbial waktu menunjukkan kapan suatu peristiwa terjadi dalam kaitan dengan klausa utama (sebelum, sesudah, saat, atau hingga). Konjungsi waktu yang dominan dalam tulisan akademis meliputi: when, while, as, before, after, once, as soon as, and until. Aturan gramatikal penting: klausa adverbial waktu untuk konteks masa depan TIDAK PERNAH menggunakan modal \'will\' atau \'shall\', melainkan menggunakan Present Simple.',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-emerald-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-emerald-500/25 text-emerald-300 border border-emerald-500/50 font-mono">TIME &amp; SEQUENCE</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Klausa Waktu (<em>When, While, As soon as, Once, Before, After</em>)</span>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1.5">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-amber-300 uppercase tracking-wide flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-400"></span> Pola Waktu
            </span>
            <code class="text-xs font-mono font-bold text-emerald-300 bg-slate-950 px-2.5 py-1 rounded border border-emerald-500/40">[Once / As soon as + S + V], [Main Clause]</code>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-emerald-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">Once the algorithm validates the transaction, funds are transferred automatically.</span>
        </div>
    </div>
</div>
HTML,
                'rules' => [
                    'Dalam konteks masa depan, gunakan Present Simple dalam klausa waktu (contoh: *Once the system arrives (bukan *will arrive*), the technicians will install it*).',
                    '\'While\' dan \'As\' menunjukkan dua peristiwa yang berlangsung bersamaan (simultaneous action).',
                    '\'Once\' bermakna \'segera setelah / begitu\' (as soon as) dan mengindikasikan prasyarat waktu yang telah tuntas.',
                    '\'Until\' mengindikasikan batas akhir keberlanjutan suatu keadaan (hingga titik waktu tertentu).',
                    'Koma wajib digunakan jika klausa waktu berada di depan kalimat.',
                ],
                'exercises' => [
                    [
                        'id' => 21,
                        'id_sentence' => 'Begitu dewan komisaris menyetujui anggaran tahunan, departemen riset akan meluncurkan proyek eksplorasi tersebut.',
                        'target_word' => 'Once the board of directors approves the annual budget, the research department will launch (Once + Present Simple, will + Verb)',
                        'vocab' => [
                            ['en' => 'the board of directors approves the annual budget', 'id' => 'dewan komisaris menyetujui anggaran tahunan'],
                            ['en' => 'the research department will launch the exploration project', 'id' => 'departemen riset akan meluncurkan proyek eksplorasi'],
                        ],
                        'options' => [
                            'Once the board of directors approves the annual budget, the research department will launch the exploration project.',
                            'Once the board of directors will approve the annual budget, the research department will launch the exploration project.',
                            'Once the board of directors approves the annual budget the research department will launch the exploration project.',
                            'As soon the board of directors approves the annual budget, the research department will launch the exploration project.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa waktu yang diawali \'Once\' merujuk masa depan harus menggunakan Present Tense (\'approves\'), bukan \'will approve\'.',
                    ],
                    [
                        'id' => 22,
                        'id_sentence' => 'Sebelum para ilmuwan mempublikasikan temuan mereka, mereka memverifikasi integritas dataset melalui tinjauan sejawat independen.',
                        'target_word' => 'Before the scientists published their findings, they verified the integrity of the dataset through independent peer review (Before + Past Simple, Past Simple)',
                        'vocab' => [
                            ['en' => 'the scientists published their findings', 'id' => 'para ilmuwan mempublikasikan temuan mereka'],
                            ['en' => 'they verified the integrity of the dataset through independent peer review', 'id' => 'mereka memverifikasi integritas dataset melalui tinjauan sejawat independen'],
                        ],
                        'options' => [
                            'Before the scientists published their findings, they verified the integrity of the dataset through independent peer review.',
                            'Before the scientists published their findings they verified the integrity of the dataset through independent peer review.',
                            'Before that the scientists published their findings, they verified the integrity of the dataset through independent peer review.',
                            'Prior the scientists published their findings, they verified the integrity of the dataset through independent peer review.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Before\' adalah subordinating conjunction waktu yang menghubungkan dua aksi lampau terurut, dipisahkan koma.',
                    ],
                    [
                        'id' => 23,
                        'id_sentence' => 'Sementara para analis meninjau transaksi keuangan, sistem audit mendeteksi beberapa anomali berisiko tinggi.',
                        'target_word' => 'While analysts were reviewing the financial transactions, the auditing system detected several high-risk anomalies (While + Past Continuous, Past Simple)',
                        'vocab' => [
                            ['en' => 'analysts were reviewing the financial transactions', 'id' => 'para analis sedang meninjau transaksi keuangan'],
                            ['en' => 'the auditing system detected several high-risk anomalies', 'id' => 'sistem audit mendeteksi beberapa anomali berisiko tinggi'],
                        ],
                        'options' => [
                            'While analysts were reviewing the financial transactions, the auditing system detected several high-risk anomalies.',
                            'During analysts were reviewing the financial transactions, the auditing system detected several high-risk anomalies.',
                            'While analysts were reviewing the financial transactions the auditing system detected several high-risk anomalies.',
                            'While of analysts were reviewing the financial transactions, the auditing system detected several high-risk anomalies.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'While\' diikuti klausa utuh berpredikat continuous (\'were reviewing\'). \'During\' adalah preposisi dan tidak boleh diikuti klausa.',
                    ],
                    [
                        'id' => 24,
                        'id_sentence' => 'Eksperimen kimia tersebut harus dipantau terus-menerus sampai suhu larutan stabil pada 25 derajat Celsius.',
                        'target_word' => 'The chemical experiment must be monitored continuously until the temperature of the solution stabilizes at 25 degrees Celsius (until + Present Simple)',
                        'vocab' => [
                            ['en' => 'the chemical experiment must be monitored continuously', 'id' => 'eksperimen kimia tersebut harus dipantau terus-menerus'],
                            ['en' => 'the temperature of the solution stabilizes at 25 degrees Celsius', 'id' => 'suhu larutan stabil pada 25 derajat Celsius'],
                        ],
                        'options' => [
                            'The chemical experiment must be monitored continuously until the temperature of the solution stabilizes at 25 degrees Celsius.',
                            'The chemical experiment must be monitored continuously until the temperature of the solution will stabilize at 25 degrees Celsius.',
                            'The chemical experiment must be monitored continuously, until the temperature of the solution stabilizes at 25 degrees Celsius.',
                            'The chemical experiment must be monitored continuously up to the temperature of the solution stabilizes at 25 degrees Celsius.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Until\' mengawali klausa waktu di posisi belakang (tanpa tanda koma), dan menggunakan kata kerja bentuk sekarang (\'stabilizes\') bukan \'will stabilize\'.',
                    ],
                    [
                        'id' => 25,
                        'id_sentence' => 'Segera setelah peringatan dini gempa bumi dibunyikan, sistem keamanan otomatis memutus pasokan gas kota.',
                        'target_word' => 'As soon as the earthquake early warning sounded, automatic safety valves shut off the municipal gas supply (As soon as + Past Simple)',
                        'vocab' => [
                            ['en' => 'the earthquake early warning sounded', 'id' => 'peringatan dini gempa bumi dibunyikan'],
                            ['en' => 'automatic safety valves shut off the municipal gas supply', 'id' => 'katup pengaman otomatis memutus pasokan gas kota'],
                        ],
                        'options' => [
                            'As soon as the earthquake early warning sounded, automatic safety valves shut off the municipal gas supply.',
                            'As soon the earthquake early warning sounded, automatic safety valves shut off the municipal gas supply.',
                            'As soon as the earthquake early warning sounded automatic safety valves shut off the municipal gas supply.',
                            'Soon as the earthquake early warning sounded, automatic safety valves shut off the municipal gas supply.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Frasa subordinasi waktu yang baku adalah \'As soon as\', diikuti klausa lampau dan tanda koma sebelum klausa utama.',
                    ],
                    [
                        'id' => 26,
                        'id_sentence' => 'Setelah vaksin baru menunjukkan efikasi tinggi dalam uji klinis fase tiga, badan pengawas obat menyetujui penggunaannya secara darurat.',
                        'target_word' => 'After the new vaccine demonstrated high efficacy in phase three clinical trials, the regulatory agency approved its emergency use (After + Past Simple)',
                        'vocab' => [
                            ['en' => 'the new vaccine demonstrated high efficacy in phase three clinical trials', 'id' => 'vaksin baru menunjukkan efikasi tinggi dalam uji klinis fase tiga'],
                            ['en' => 'the regulatory agency approved its emergency use', 'id' => 'badan pengawas obat menyetujui penggunaannya secara darurat'],
                        ],
                        'options' => [
                            'After the new vaccine demonstrated high efficacy in phase three clinical trials, the regulatory agency approved its emergency use.',
                            'After the new vaccine demonstrated high efficacy in phase three clinical trials the regulatory agency approved its emergency use.',
                            'After that the new vaccine demonstrated high efficacy in phase three clinical trials, the regulatory agency approved its emergency use.',
                            'Following the new vaccine demonstrated high efficacy in phase three clinical trials, the regulatory agency approved its emergency use.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'After\' mengawali klausa waktu (S + V) di awal kalimat, sehingga membutuhkan koma pemisah.',
                    ],
                    [
                        'id' => 27,
                        'id_sentence' => 'Ketika instrumen penelitian dikalibrasi ulang oleh teknisi berlisensi, deviasi pengukuran berkurang hingga di bawah satu persen.',
                        'target_word' => 'When the research instruments were recalibrated by certified technicians, measurement deviations decreased to below one percent (When + Past Passive)',
                        'vocab' => [
                            ['en' => 'the research instruments were recalibrated by certified technicians', 'id' => 'instrumen penelitian dikalibrasi ulang oleh teknisi bersertifikat'],
                            ['en' => 'measurement deviations decreased to below one percent', 'id' => 'deviasi pengukuran berkurang hingga di bawah satu persen'],
                        ],
                        'options' => [
                            'When the research instruments were recalibrated by certified technicians, measurement deviations decreased to below one percent.',
                            'When the research instruments recalibrated by certified technicians, measurement deviations decreased to below one percent.',
                            'When the research instruments were recalibrated by certified technicians measurement deviations decreased to below one percent.',
                            'At the research instruments were recalibrated by certified technicians, measurement deviations decreased to below one percent.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'When\' menghubungkan kejadian spesifik di masa lampau dalam bentuk pasif (\'were recalibrated\') dengan koma pemisah.',
                    ],
                    [
                        'id' => 28,
                        'id_sentence' => 'Begitu perjanjian perdagangan bilateral mulai berlaku, tarif impor untuk peralatan medis akan dihapuskan sepenuhnya.',
                        'target_word' => 'Once the bilateral trade agreement enters into force, import tariffs on medical equipment will be entirely eliminated (Once + Present Simple, will be + V3)',
                        'vocab' => [
                            ['en' => 'the bilateral trade agreement enters into force', 'id' => 'perjanjian perdagangan bilateral mulai berlaku'],
                            ['en' => 'import tariffs on medical equipment will be entirely eliminated', 'id' => 'tarif impor untuk peralatan medis akan dihapuskan sepenuhnya'],
                        ],
                        'options' => [
                            'Once the bilateral trade agreement enters into force, import tariffs on medical equipment will be entirely eliminated.',
                            'Once the bilateral trade agreement will enter into force, import tariffs on medical equipment will be entirely eliminated.',
                            'Once the bilateral trade agreement entered into force, import tariffs on medical equipment will be entirely eliminated.',
                            'As soon the bilateral trade agreement enters into force, import tariffs on medical equipment will be entirely eliminated.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa subordinat waktu yang dipimpin \'Once\' memakai Simple Present (\'enters\') untuk memicu kejadian masa depan (\'will be eliminated\').',
                    ],
                    [
                        'id' => 29,
                        'id_sentence' => 'Seiring bertambahnya usia populasi di negara maju, pengeluaran publik untuk layanan kesehatan meningkat secara proporsional.',
                        'target_word' => 'As the population ages in developed nations, public healthcare expenditures increase proportionally (As + Clause of Parallel Progression)',
                        'vocab' => [
                            ['en' => 'the population ages in developed nations', 'id' => 'populasi menua di negara maju'],
                            ['en' => 'public healthcare expenditures increase proportionally', 'id' => 'pengeluaran layanan kesehatan publik meningkat secara proporsional'],
                        ],
                        'options' => [
                            'As the population ages in developed nations, public healthcare expenditures increase proportionally.',
                            'As the population aging in developed nations, public healthcare expenditures increase proportionally.',
                            'While of the population ages in developed nations, public healthcare expenditures increase proportionally.',
                            'During the population ages in developed nations, public healthcare expenditures increase proportionally.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'As\' dalam konteks ini menunjukkan perkembangan dua fenomena yang berjalan beriringan (parallel progression), diikuti klausa lengkap berpredikat.',
                    ],
                    [
                        'id' => 30,
                        'id_sentence' => 'Pemerintah tidak akan mencabut pembatasan perjalanan sebelum rasio vaksinasi nasional melampaui delapan puluh persen.',
                        'target_word' => 'The government will not lift travel restrictions until the national vaccination ratio exceeds eighty percent (will not + until + Present Simple)',
                        'vocab' => [
                            ['en' => 'the government will not lift travel restrictions', 'id' => 'pemerintah tidak akan mencabut pembatasan perjalanan'],
                            ['en' => 'the national vaccination ratio exceeds eighty percent', 'id' => 'rasio vaksinasi nasional melampaui delapan puluh persen'],
                        ],
                        'options' => [
                            'The government will not lift travel restrictions until the national vaccination ratio exceeds eighty percent.',
                            'The government will not lift travel restrictions until the national vaccination ratio will exceed eighty percent.',
                            'The government will not lift travel restrictions before the national vaccination ratio will exceed eighty percent.',
                            'The government will not lift travel restrictions, until the national vaccination ratio exceeds eighty percent.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Struktur \'not... until\' menandakan bahwa tindakan tidak akan dilakukan sebelum suatu titik waktu tercapai, dengan kata kerja bentuk sekarang (\'exceeds\') tanpa koma di posisi belakang.',
                    ],
                ]
            ],
            [
                'id' => 'condition-contingency-clauses',
                'name' => '3.1.4 Condition & Contingency Clauses (if, unless, provided that, as long as)',
                'code' => '3.1.4',
                'concept_title' => 'Klausa Syarat & Kontingensi (Condition & Contingency Subordination)',
                'concept_description' => 'Klausa syarat menetapkan prasyarat yang harus dipenuhi agar klausa utama dapat terjadi. Kata hubung subordinatif mencakup: if (jika), unless (jika tidak / kecuali jika), provided that / providing that (asalkan / dengan syarat bahwa), as long as / so long as (selama), dan in the event that (dalam hal terjadi). Catatan krusial: \'unless\' sudah mengandung makna negatif (= if... not), sehingga kata kerja di dalamnya tidak boleh dinegasikan lagi (hindari double negative).',
                'description' => 'Klausa syarat menetapkan prasyarat yang harus dipenuhi agar klausa utama dapat terjadi. Kata hubung subordinatif mencakup: if (jika), unless (jika tidak / kecuali jika), provided that / providing that (asalkan / dengan syarat bahwa), as long as / so long as (selama), dan in the event that (dalam hal terjadi). Catatan krusial: \'unless\' sudah mengandung makna negatif (= if... not), sehingga kata kerja di dalamnya tidak boleh dinegasikan lagi (hindari double negative).',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-sky-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-sky-500/25 text-sky-300 border border-sky-500/50 font-mono">CONDITION</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Klausa Kondisi (<em>If, Unless, Provided that, As long as</em>)</span>
    </div>

    <div class="px-3 py-1.5 rounded-lg bg-amber-950/70 border border-amber-400 text-xs text-white flex items-center gap-2">
        <span class="font-black text-amber-300 uppercase tracking-wider">[KAIDAH UNLESS]</span>
        <span><strong>Unless</strong> = <em>If not</em>. Jangan menambahkan kata <em>not</em> lagi di dalam anak klausa unless!</span>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1.5">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-sky-300 uppercase tracking-wide flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-sky-400"></span> Pola Kondisi
            </span>
            <code class="text-xs font-mono font-bold text-sky-300 bg-slate-950 px-2.5 py-1 rounded border border-sky-500/40">[Unless / Provided that + S + V], [Main Clause]</code>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-sky-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">Unless governments enforce stricter caps, global temperatures will rise.</span>
        </div>
    </div>
</div>
HTML,
                'rules' => [
                    '\'Unless\' setara dengan \'If... not\'. Jangan gunakan kata kerja negatif setelah unless (contoh yang salah: *unless you do not study*).',
                    '\'Provided that\' adalah bentuk kondisional register formal yang lazim digunakan dalam dokumen legal, kontrak bisnis, dan esai akademik.',
                    'Klausa syarat merujuk masa depan menggunakan pola Present Tense di dalam klausa \'if\' dan Modal (will/can/may) pada klausa utama.',
                    'Koma wajib digunakan jika klausa syarat diletakkan di depan.',
                ],
                'exercises' => [
                    [
                        'id' => 31,
                        'id_sentence' => 'Kecuali jika emisi karbon global dikurangi secara drastis dalam dekade ini, kenaikan suhu global akan melampaui batas kritis.',
                        'target_word' => 'Unless global carbon emissions are drastically curtailed within this decade, global temperature rise will exceed critical thresholds (Unless + Positive Passive)',
                        'vocab' => [
                            ['en' => 'global carbon emissions are drastically curtailed within this decade', 'id' => 'emisi karbon global dikurangi secara drastis dalam dekade ini'],
                            ['en' => 'global temperature rise will exceed critical thresholds', 'id' => 'kenaikan suhu global akan melampaui ambang batas kritis'],
                        ],
                        'options' => [
                            'Unless global carbon emissions are drastically curtailed within this decade, global temperature rise will exceed critical thresholds.',
                            'Unless global carbon emissions are not drastically curtailed within this decade, global temperature rise will exceed critical thresholds.',
                            'Unless global carbon emissions will be drastically curtailed within this decade, global temperature rise will exceed critical thresholds.',
                            'If global carbon emissions are drastically curtailed within this decade, global temperature rise will exceed critical thresholds.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Unless\' bermakna \'if not\'. Predikat di dalamnya harus berbentuk positif (\'are drastically curtailed\'). Menambahkan \'not\' menghasilkan double negative yang salah secara logika.',
                    ],
                    [
                        'id' => 32,
                        'id_sentence' => 'Komite etik akan menyetujui uji klinis tersebut asalkan keselamatan pasien terjamin secara ketat.',
                        'target_word' => 'The ethics committee will approve the clinical trial provided that patient safety is rigorously guaranteed (provided that + Clause)',
                        'vocab' => [
                            ['en' => 'the ethics committee will approve the clinical trial', 'id' => 'komite etik akan menyetujui uji klinis tersebut'],
                            ['en' => 'patient safety is rigorously guaranteed', 'id' => 'keselamatan pasien terjamin secara ketat'],
                        ],
                        'options' => [
                            'The ethics committee will approve the clinical trial provided that patient safety is rigorously guaranteed.',
                            'The ethics committee will approve the clinical trial provided patient safety will be rigorously guaranteed.',
                            'The ethics committee will approve the clinical trial, provided that patient safety is rigorously guaranteed.',
                            'The ethics committee will approve the clinical trial unless patient safety is rigorously guaranteed.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Provided that\' memperkenalkan klausul prasyarat formal di posisi belakang tanpa tanda koma.',
                    ],
                    [
                        'id' => 33,
                        'id_sentence' => 'Selama inflasi tetap berada dalam rentang target bank sentral, suku bunga acuan kemungkinan besar tidak akan dinaikkan.',
                        'target_word' => 'As long as inflation remains within the central bank\'s target range, the benchmark interest rate is unlikely to be raised (As long as + Present Simple)',
                        'vocab' => [
                            ['en' => 'inflation remains within the central bank\'s target range', 'id' => 'inflasi tetap berada dalam rentang target bank sentral'],
                            ['en' => 'the benchmark interest rate is unlikely to be raised', 'id' => 'suku bunga acuan kemungkinan besar tidak akan dinaikkan'],
                        ],
                        'options' => [
                            'As long as inflation remains within the central bank\'s target range, the benchmark interest rate is unlikely to be raised.',
                            'As long as inflation will remain within the central bank\'s target range, the benchmark interest rate is unlikely to be raised.',
                            'As long as inflation remains within the central bank\'s target range the benchmark interest rate is unlikely to be raised.',
                            'So long inflation remains within the central bank\'s target range, the benchmark interest rate is unlikely to be raised.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'As long as\' menyatakan kondisi durasional, diikuti Simple Present (\'remains\') dan koma pemisah.',
                    ],
                    [
                        'id' => 34,
                        'id_sentence' => 'Jika metodologi penelitian tidak dijelaskan secara transparan, penelitian tersebut tidak dapat direplikasi oleh ilmuwan lain.',
                        'target_word' => 'If the research methodology is not transparently articulated, the study cannot be replicated by other scientists (If + not)',
                        'vocab' => [
                            ['en' => 'the research methodology is not transparently articulated', 'id' => 'metodologi penelitian tidak diartikulasikan secara transparan'],
                            ['en' => 'the study cannot be replicated by other scientists', 'id' => 'penelitian tersebut tidak dapat direplikasi oleh ilmuwan lain'],
                        ],
                        'options' => [
                            'If the research methodology is not transparently articulated, the study cannot be replicated by other scientists.',
                            'Unless the research methodology is not transparently articulated, the study cannot be replicated by other scientists.',
                            'If the research methodology will not be transparently articulated, the study cannot be replicated by other scientists.',
                            'If the research methodology is not transparently articulated the study cannot be replicated by other scientists.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kondisional negatif standar menggunakan \'If... not\' dengan koma setelah klausa depan.',
                    ],
                    [
                        'id' => 35,
                        'id_sentence' => 'Dalam hal terjadi kegagalan sistem pendingin reaktor, generator darurat akan menyala secara otomatis dalam tiga detik.',
                        'target_word' => 'In the event that the reactor cooling system fails, emergency generators will activate automatically within three seconds (In the event that + Clause)',
                        'vocab' => [
                            ['en' => 'the reactor cooling system fails', 'id' => 'sistem pendingin reaktor mengalami kegagalan'],
                            ['en' => 'emergency generators will activate automatically within three seconds', 'id' => 'generator darurat akan aktif secara otomatis dalam tiga detik'],
                        ],
                        'options' => [
                            'In the event that the reactor cooling system fails, emergency generators will activate automatically within three seconds.',
                            'In the event of the reactor cooling system fails, emergency generators will activate automatically within three seconds.',
                            'In the event that the reactor cooling system will fail, emergency generators will activate automatically within three seconds.',
                            'In the event the reactor cooling system fails emergency generators will activate automatically within three seconds.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'In the event that\' adalah varian formal dari \'if\' untuk klausa kontingensi lengkap (S + V) dalam penulisan teknis dan protokol.',
                    ],
                    [
                        'id' => 36,
                        'id_sentence' => 'Perusahaan rintisan tersebut dapat mempertahankan pertumbuhannya asalkan mereka berhasil mendapatkan pendanaan seri B.',
                        'target_word' => 'The startup can sustain its growth on condition that it secures Series B venture financing (on condition that + Clause)',
                        'vocab' => [
                            ['en' => 'the startup can sustain its growth', 'id' => 'perusahaan rintisan tersebut dapat mempertahankan pertumbuhannya'],
                            ['en' => 'it secures Series B venture financing', 'id' => 'ia mengamankan pendanaan ventura seri B'],
                        ],
                        'options' => [
                            'The startup can sustain its growth on condition that it secures Series B venture financing.',
                            'The startup can sustain its growth on condition that it will secure Series B venture financing.',
                            'The startup can sustain its growth on condition it secured Series B venture financing.',
                            'The startup can sustain its growth, on condition that it secures Series B venture financing.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'On condition that\' memperkenalkan syarat esensial tanpa koma di posisi akhir kalimat, menggunakan Simple Present (\'secures\').',
                    ],
                    [
                        'id' => 37,
                        'id_sentence' => 'Kecuali bila ada bukti baru yang tidak terbantahkan, keputusan pengadilan banding tidak dapat diubah.',
                        'target_word' => 'Unless compelling new evidence is presented, the appellate court\'s verdict cannot be overturned (Unless + Passive Clause)',
                        'vocab' => [
                            ['en' => 'compelling new evidence is presented', 'id' => 'bukti baru yang meyakinkan diajukan'],
                            ['en' => 'the appellate court\'s verdict cannot be overturned', 'id' => 'putusan pengadilan banding tidak dapat dibatalkan'],
                        ],
                        'options' => [
                            'Unless compelling new evidence is presented, the appellate court\'s verdict cannot be overturned.',
                            'Unless compelling new evidence is not presented, the appellate court\'s verdict cannot be overturned.',
                            'Unless compelling new evidence will be presented, the appellate court\'s verdict cannot be overturned.',
                            'If compelling new evidence is presented, the appellate court\'s verdict cannot be overturned.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Unless\' sudah mengekspresikan kondisi pengecualian; predikat harus positif (\'is presented\').',
                    ],
                    [
                        'id' => 38,
                        'id_sentence' => 'Jika harga minyak mentah melonjak melewati seratus dolar per barel, biaya transportasi maskapai penerbangan akan membengkak secara signifikan.',
                        'target_word' => 'If crude oil prices surge past one hundred dollars per barrel, airline operating costs will escalate significantly (If + Present, will + Verb)',
                        'vocab' => [
                            ['en' => 'crude oil prices surge past one hundred dollars per barrel', 'id' => 'harga minyak mentah melonjak melewati seratus dolar per barel'],
                            ['en' => 'airline operating costs will escalate significantly', 'id' => 'biaya operasional maskapai penerbangan akan membengkak secara signifikan'],
                        ],
                        'options' => [
                            'If crude oil prices surge past one hundred dollars per barrel, airline operating costs will escalate significantly.',
                            'If crude oil prices will surge past one hundred dollars per barrel, airline operating costs will escalate significantly.',
                            'If crude oil prices surge past one hundred dollars per barrel airline operating costs will escalate significantly.',
                            'Provided crude oil prices surge past one hundred dollars per barrel airline operating costs will escalate significantly.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kondisional tipe pertama (real conditional) menuntut Simple Present dalam klausa \'if\' dan koma pemisah.',
                    ],
                    [
                        'id' => 39,
                        'id_sentence' => 'Universitas akan memperpanjang batas waktu pengumpulan tugas akhir asalkan mahasiswa mengajukan surat keterangan medis resmi.',
                        'target_word' => 'The university will extend the thesis submission deadline providing that students submit an official medical certificate (providing that + Clause)',
                        'vocab' => [
                            ['en' => 'the university will extend the thesis submission deadline', 'id' => 'universitas akan memperpanjang tenggat pengumpulan tesis'],
                            ['en' => 'students submit an official medical certificate', 'id' => 'mahasiswa mengumpulkan sertifikat medis resmi'],
                        ],
                        'options' => [
                            'The university will extend the thesis submission deadline providing that students submit an official medical certificate.',
                            'The university will extend the thesis submission deadline providing that students will submit an official medical certificate.',
                            'The university will extend the thesis submission deadline, providing that students submit an official medical certificate.',
                            'The university will extend the thesis submission deadline unless students submit an official medical certificate.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Providing that\' adalah varian dari \'provided that\' yang berfungsi sebagai konjungsi syarat formal.',
                    ],
                    [
                        'id' => 40,
                        'id_sentence' => 'Kecuali jika reformasi perpajakan yang komprehensif segera diundangkan, defisit anggaran negara akan terus melebar.',
                        'target_word' => 'Unless comprehensive fiscal reforms are enacted promptly, the national budget deficit will continue to widen (Unless + Passive Clause)',
                        'vocab' => [
                            ['en' => 'comprehensive fiscal reforms are enacted promptly', 'id' => 'reformasi fiskal yang komprehensif segera diundangkan'],
                            ['en' => 'the national budget deficit will continue to widen', 'id' => 'defisit anggaran nasional akan terus melebar'],
                        ],
                        'options' => [
                            'Unless comprehensive fiscal reforms are enacted promptly, the national budget deficit will continue to widen.',
                            'Unless comprehensive fiscal reforms are not enacted promptly, the national budget deficit will continue to widen.',
                            'Unless comprehensive fiscal reforms will be enacted promptly, the national budget deficit will continue to widen.',
                            'If comprehensive fiscal reforms are enacted promptly, the national budget deficit will continue to widen.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Unless\' dipasangkan dengan klausa pasif afirmatif (\'are enacted promptly\') untuk menyatakan konsekuensi negatif jika prasyarat tidak terpenuhi.',
                    ],
                ]
            ],
            [
                'id' => 'purpose-result-clauses',
                'name' => '3.1.5 Purpose & Result Clauses (so that, in order that, so... that, such... that)',
                'code' => '3.1.5',
                'concept_title' => 'Klausa Tujuan & Akibat (Purpose & Result Subordination)',
                'concept_description' => 'Klausa tujuan (Purpose) menerangkan niat atau objektif dilakukannya suatu tindakan utama, umumnya diperkenalkan oleh \'so that\' atau \'in order that\' dan diikuti oleh modal auxiliary (can, could, may, might). Sebaliknya, klausa akibat (Result) menerangkan dampak intensitas dari suatu kualitas atau kuantitas, dibentuk melalui konstruksi korelasi \'so + adjective/adverb + that\' atau \'such + (adjective) noun + that\'.',
                'description' => 'Klausa tujuan (Purpose) menerangkan niat atau objektif dilakukannya suatu tindakan utama, umumnya diperkenalkan oleh \'so that\' atau \'in order that\' dan diikuti oleh modal auxiliary (can, could, may, might). Sebaliknya, klausa akibat (Result) menerangkan dampak intensitas dari suatu kualitas atau kuantitas, dibentuk melalui konstruksi korelasi \'so + adjective/adverb + that\' atau \'such + (adjective) noun + that\'.',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-purple-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-purple-500/25 text-purple-300 border border-purple-500/50 font-mono">PURPOSE &amp; RESULT</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Klausa Tujuan &amp; Hasil (<em>So that, In order that, Such...that</em>)</span>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1.5">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-purple-300 uppercase tracking-wide flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-purple-400"></span> [1] Purpose (Tujuan)
            </span>
            <code class="text-xs font-mono font-bold text-purple-300 bg-slate-950 px-2.5 py-1 rounded border border-purple-500/40">[Main Clause] + so that + S + [modal] + V</code>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-purple-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">The parameters were recalibrated so that accuracy could be preserved.</span>
        </div>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1.5">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-amber-300 uppercase tracking-wide flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-400"></span> [2] Result (Hasil): So / Such ... that
            </span>
            <code class="text-xs font-mono font-bold text-amber-300 bg-slate-950 px-2.5 py-1 rounded border border-amber-500/40">so + [Adj/Adv] + that &nbsp;|&nbsp; such + [Noun Phrase] + that</code>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-amber-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">The disruption was so severe that all operations halted.</span>
        </div>
    </div>
</div>
HTML,
                'rules' => [
                    'Gunakan \'so that\' atau \'in order that\' untuk menyatakan tujuan; klausa ini hampir selalu menyertakan modal (can/could/may/might/would).',
                    '\'In order that\' lebih formal daripada \'so that\' dalam penulisan ilmiah.',
                    'Gunakan \'so + adjective + that\' jika yang ditekankan adalah kata sifat tunggal (contoh: *so severe that...*).',
                    'Gunakan \'such + (a/an) + adjective + noun + that\' jika terdapat kata benda (contoh: *such a severe storm that...* atau *such severe storms that...*).',
                    'Jangan keliru antara \'so that\' (tujuan: \'agar/supaya\') dengan koordinatif \', so\' (konsekuensi: \'sehingga/karena itu\').',
                ],
                'exercises' => [
                    [
                        'id' => 41,
                        'id_sentence' => 'Pemerintah kota menerapkan zona emisi rendah agar kualitas udara perkotaan dapat membaik secara terukur.',
                        'target_word' => 'The municipal government implemented a low-emission zone so that urban air quality could improve measurably (so that + Subject + could + Verb)',
                        'vocab' => [
                            ['en' => 'the municipal government implemented a low-emission zone', 'id' => 'pemerintah kota menerapkan zona emisi rendah'],
                            ['en' => 'urban air quality could improve measurably', 'id' => 'kualitas udara perkotaan dapat membaik secara terukur'],
                        ],
                        'options' => [
                            'The municipal government implemented a low-emission zone so that urban air quality could improve measurably.',
                            'The municipal government implemented a low-emission zone so urban air quality could improve measurably.',
                            'The municipal government implemented a low-emission zone in order urban air quality could improve measurably.',
                            'The municipal government implemented a low-emission zone so that to improve urban air quality.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'So that\' mengawali klausa tujuan berpredikat modal (\'could improve\'). Untuk bentuk infinitif, gunakan \'in order to improve\', bukan \'so that to\'.',
                    ],
                    [
                        'id' => 42,
                        'id_sentence' => 'Gelombang panas tersebut sedemikian parahnya sehingga jaringan listrik mengalami pemadaman bergilir di beberapa wilayah.',
                        'target_word' => 'The heatwave was so severe that the electrical grid experienced rolling blackouts across multiple regions (so + adjective + that)',
                        'vocab' => [
                            ['en' => 'the heatwave was so severe', 'id' => 'gelombang panas tersebut sedemikian parahnya'],
                            ['en' => 'the electrical grid experienced rolling blackouts across multiple regions', 'id' => 'jaringan listrik mengalami pemadaman bergilir di beberapa wilayah'],
                        ],
                        'options' => [
                            'The heatwave was so severe that the electrical grid experienced rolling blackouts across multiple regions.',
                            'The heatwave was such severe that the electrical grid experienced rolling blackouts across multiple regions.',
                            'The heatwave was too severe that the electrical grid experienced rolling blackouts across multiple regions.',
                            'The heatwave was very severe that the electrical grid experienced rolling blackouts across multiple regions.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Severe\' adalah kata sifat tanpa kata benda setelahnya, sehingga harus menggunakan konstruksi intensitas \'so + adjective + that\' (bukan \'such\').',
                    ],
                    [
                        'id' => 43,
                        'id_sentence' => 'Protokol keamanan diperketat sedemikian rupa agar personel yang tidak berwenang tidak dapat mengakses server data sensitif.',
                        'target_word' => 'Security protocols were tightened in order that unauthorized personnel might not access sensitive data servers (in order that + modal + Verb)',
                        'vocab' => [
                            ['en' => 'security protocols were tightened', 'id' => 'protokol keamanan diperketat'],
                            ['en' => 'unauthorized personnel might not access sensitive data servers', 'id' => 'personel yang tidak berwenang tidak dapat mengakses server data sensitif'],
                        ],
                        'options' => [
                            'Security protocols were tightened in order that unauthorized personnel might not access sensitive data servers.',
                            'Security protocols were tightened in order to unauthorized personnel might not access sensitive data servers.',
                            'Security protocols were tightened in order that unauthorized personnel not access sensitive data servers.',
                            'Security protocols were tightened so unauthorized personnel to not access sensitive data servers.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'In order that\' adalah konjungsi tujuan formal yang mewajibkan klausa penuh dengan modal auxiliary (\'might not access\').',
                    ],
                    [
                        'id' => 44,
                        'id_sentence' => 'Itu merupakan kegagalan mekanis yang sedemikian rumitnya sehingga tim insinyur membutuhkan waktu berminggu-minggu untuk mengidentifikasi penyebabnya.',
                        'target_word' => 'It was such a complex mechanical failure that the engineering team required weeks to identify its root cause (such + a + adjective + noun + that)',
                        'vocab' => [
                            ['en' => 'such a complex mechanical failure', 'id' => 'kegagalan mekanis yang sedemikian rumitnya'],
                            ['en' => 'the engineering team required weeks to identify its root cause', 'id' => 'tim insinyur membutuhkan waktu berminggu-minggu untuk mengidentifikasi akar penyebabnya'],
                        ],
                        'options' => [
                            'It was such a complex mechanical failure that the engineering team required weeks to identify its root cause.',
                            'It was so complex mechanical failure that the engineering team required weeks to identify its root cause.',
                            'It was so a complex mechanical failure that the engineering team required weeks to identify its root cause.',
                            'It was such complex mechanical failure that the engineering team required weeks to identify its root cause.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Terdapat kata benda tunggal yang dapat dihitung (\'failure\') yang dimodifikasi oleh kata sifat (\'complex\'), sehingga memerlukan pola \'such + a + adjective + noun + that\'.',
                    ],
                    [
                        'id' => 45,
                        'id_sentence' => 'Perangkat lunak analitik diperbarui secara berkala agar para peneliti dapat memproses volume data besar secara efisien.',
                        'target_word' => 'The analytics software is updated periodically so that researchers may process massive volumes of data efficiently (so that + may + Verb)',
                        'vocab' => [
                            ['en' => 'the analytics software is updated periodically', 'id' => 'perangkat lunak analitik diperbarui secara berkala'],
                            ['en' => 'researchers may process massive volumes of data efficiently', 'id' => 'para peneliti dapat memproses volume data besar secara efisien'],
                        ],
                        'options' => [
                            'The analytics software is updated periodically so that researchers may process massive volumes of data efficiently.',
                            'The analytics software is updated periodically so that to process massive volumes of data efficiently.',
                            'The analytics software is updated periodically in order researchers may process massive volumes of data efficiently.',
                            'The analytics software is updated periodically, so that researchers may process massive volumes of data efficiently.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'So that\' menghubungkan tindakan dengan tujuan di posisi belakang tanpa tanda koma.',
                    ],
                    [
                        'id' => 46,
                        'id_sentence' => 'Tekanan uap di dalam bejana reaktor naik sedemikian cepatnya sehingga katup pengaman darurat terbuka secara otomatis.',
                        'target_word' => 'Vapor pressure inside the reactor vessel escalated so rapidly that emergency relief valves discharged automatically (so + adverb + that)',
                        'vocab' => [
                            ['en' => 'vapor pressure inside the reactor vessel escalated so rapidly', 'id' => 'tekanan uap di dalam bejana reaktor naik sedemikian cepatnya'],
                            ['en' => 'emergency relief valves discharged automatically', 'id' => 'katup pengaman darurat terbuka secara otomatis'],
                        ],
                        'options' => [
                            'Vapor pressure inside the reactor vessel escalated so rapidly that emergency relief valves discharged automatically.',
                            'Vapor pressure inside the reactor vessel escalated such rapidly that emergency relief valves discharged automatically.',
                            'Vapor pressure inside the reactor vessel escalated too rapidly that emergency relief valves discharged automatically.',
                            'Vapor pressure inside the reactor vessel escalated very rapidly that emergency relief valves discharged automatically.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Rapidly\' adalah kata keterangan (adverb), sehingga harus menggunakan konstruksi intensitas \'so + adverb + that\'.',
                    ],
                    [
                        'id' => 47,
                        'id_sentence' => 'Sampel biologis dibekukan dalam nitrogen cair dengan maksud agar struktur selulernya tetap utuh sempurna.',
                        'target_word' => 'The biological specimens were frozen in liquid nitrogen in order that cellular structures would remain fully intact (in order that + would + Verb)',
                        'vocab' => [
                            ['en' => 'the biological specimens were frozen in liquid nitrogen', 'id' => 'sampel biologis dibekukan dalam nitrogen cair'],
                            ['en' => 'cellular structures would remain fully intact', 'id' => 'struktur selulernya tetap utuh sempurna'],
                        ],
                        'options' => [
                            'The biological specimens were frozen in liquid nitrogen in order that cellular structures would remain fully intact.',
                            'The biological specimens were frozen in liquid nitrogen in order to cellular structures would remain fully intact.',
                            'The biological specimens were frozen in liquid nitrogen so that to maintain cellular structures fully intact.',
                            'The biological specimens were frozen in liquid nitrogen, in order that cellular structures would remain fully intact.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'In order that\' diikuti oleh klausa tujuan utuh dengan modal lampau \'would remain\'.',
                    ],
                    [
                        'id' => 48,
                        'id_sentence' => 'Kecelakaan industri tersebut menimbulkan polusi yang sedemikian luasnya sehingga pemerintah menyatakan keadaan darurat lingkungan.',
                        'target_word' => 'The industrial accident generated such widespread pollution that the government declared an environmental state of emergency (such + adjective + uncountable noun + that)',
                        'vocab' => [
                            ['en' => 'such widespread pollution', 'id' => 'polusi yang sedemikian luasnya'],
                            ['en' => 'the government declared an environmental state of emergency', 'id' => 'pemerintah menyatakan keadaan darurat lingkungan'],
                        ],
                        'options' => [
                            'The industrial accident generated such widespread pollution that the government declared an environmental state of emergency.',
                            'The industrial accident generated so widespread pollution that the government declared an environmental state of emergency.',
                            'The industrial accident generated such a widespread pollution that the government declared an environmental state of emergency.',
                            'The industrial accident generated too widespread pollution that the government declared an environmental state of emergency.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Pollution\' adalah uncountable noun; maka pola yang benar adalah \'such + adjective + uncountable noun + that\' (tanpa artikel \'a\').',
                    ],
                    [
                        'id' => 49,
                        'id_sentence' => 'Data cadangan dienkripsi dengan protokol militer agar integritas informasi tetap terjamin jika terjadi pelanggaran jaringan.',
                        'target_word' => 'Backup datasets were encrypted using military-grade protocols so that information integrity would be preserved in the event of a breach (so that + would be + V3)',
                        'vocab' => [
                            ['en' => 'backup datasets were encrypted using military-grade protocols', 'id' => 'dataset cadangan dienkripsi dengan protokol militer'],
                            ['en' => 'information integrity would be preserved in the event of a breach', 'id' => 'integritas informasi tetap terjamin jika terjadi pembobolan'],
                        ],
                        'options' => [
                            'Backup datasets were encrypted using military-grade protocols so that information integrity would be preserved in the event of a breach.',
                            'Backup datasets were encrypted using military-grade protocols in order information integrity would be preserved in the event of a breach.',
                            'Backup datasets were encrypted using military-grade protocols, so that information integrity would be preserved in the event of a breach.',
                            'Backup datasets were encrypted using military-grade protocols so information integrity to be preserved in the event of a breach.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'So that\' memimpin klausa tujuan pasif berpredikat modal \'would be preserved\'.',
                    ],
                    [
                        'id' => 50,
                        'id_sentence' => 'Pasar obligasi mengalami kerugian yang sedemikian besarnya sehingga regulator keuangan menghentikan perdagangan sementara.',
                        'target_word' => 'The bond market suffered such substantial losses that financial regulators temporarily halted trading (such + adjective + plural noun + that)',
                        'vocab' => [
                            ['en' => 'such substantial losses', 'id' => 'kerugian yang sedemikian besarnya'],
                            ['en' => 'financial regulators temporarily halted trading', 'id' => 'regulator keuangan menghentikan perdagangan sementara'],
                        ],
                        'options' => [
                            'The bond market suffered such substantial losses that financial regulators temporarily halted trading.',
                            'The bond market suffered so substantial losses that financial regulators temporarily halted trading.',
                            'The bond market suffered such a substantial losses that financial regulators temporarily halted trading.',
                            'The bond market suffered too substantial losses that financial regulators temporarily halted trading.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Losses\' adalah kata benda jamak (plural noun); gunakan \'such + adjective + plural noun + that\' tanpa artikel.',
                    ],
                ]
            ],
            [
                'id' => 'clause-positioning-punctuation',
                'name' => '3.1.6 Clause Positioning & Punctuation (Fronted vs End Position, Comma Splice Elimination)',
                'code' => '3.1.6',
                'concept_title' => 'Penempatan Klausa & Tanda Baca (Clause Placement & Comma Mechanics)',
                'concept_description' => 'Posisi klausa adverbial menentukan aliran retorika dan tanda baca kalimat majemuk bertingkat. (1) Jika klausa adverbial diletakkan di DEPAN (fronted position), tanda koma WAJIB disematkan di akhir klausa tersebut sebelum klausa utama. (2) Jika diletakkan di BELAKANG klausa utama (end position), secara umum TIDAK menggunakan koma, kecuali klausa pertentangan tegas seperti \'whereas\' atau \'while\'. Memahami pemisahan ini mutlak untuk mencegah kesalahan fatal Comma Splice dan Run-on.',
                'description' => 'Posisi klausa adverbial menentukan aliran retorika dan tanda baca kalimat majemuk bertingkat. (1) Jika klausa adverbial diletakkan di DEPAN (fronted position), tanda koma WAJIB disematkan di akhir klausa tersebut sebelum klausa utama. (2) Jika diletakkan di BELAKANG klausa utama (end position), secara umum TIDAK menggunakan koma, kecuali klausa pertentangan tegas seperti \'whereas\' atau \'while\'. Memahami pemisahan ini mutlak untuk mencegah kesalahan fatal Comma Splice dan Run-on.',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-emerald-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-emerald-500/25 text-emerald-300 border border-emerald-500/50 font-mono">PUNCTUATION &amp; FLOW</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Kaidah Tanda Koma pada Klausa Adverbia</span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
        <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1">
            <div class="text-xs font-black text-emerald-300 uppercase tracking-wide">✓ Posisi Depan (Wajib Koma)</div>
            <code class="text-xs font-mono font-bold text-emerald-200 block bg-slate-950 p-2 rounded border border-emerald-500/40">
                [Anak Klausa, S + V], [Kalimat Utama].
            </code>
            <div class="text-xs text-white pt-1 italic font-mono">
                While GDP expanded, median household income declined.
            </div>
        </div>

        <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1">
            <div class="text-xs font-black text-sky-300 uppercase tracking-wide">✓ Posisi Belakang (Tanpa Koma)</div>
            <code class="text-xs font-mono font-bold text-sky-200 block bg-slate-950 p-2 rounded border border-sky-500/40">
                [Kalimat Utama] [Anak Klausa, S + V].
            </code>
            <div class="text-xs text-white pt-1 italic font-mono">
                Median income declined while GDP expanded.
            </div>
        </div>
    </div>
</div>
HTML,
                'rules' => [
                    'Koma WAJIB digunakan jika klausa subordinat mendahului klausa utama (Fronted Adverbial Clause).',
                    'Koma umumnya TIDAK digunakan jika klausa subordinat mengikuti klausa utama (End-position), khususnya pada klausa waktu, syarat, alasan, dan tujuan.',
                    'Klausa \'whereas\' dan \'while\' yang menunjukkan kontras kuat tetap boleh menggunakan koma di posisi belakang untuk memperjelas batas ide.',
                    'Jangan pernah memisahkan subjek dari kata kerjanya sendiri dengan satu koma sembarangan.',
                    'Hindari Comma Splice: jangan menggunakan tanda koma untuk menggabungkan dua klausa independen tanpa kata hubung subordinatif atau koordinatif.',
                ],
                'exercises' => [
                    [
                        'id' => 51,
                        'id_sentence' => 'Meskipun kebijakan pembatasan mobilitas menuai protes publik pada awalnya, kebijakan tersebut terbukti efektif menekan kurva penularan virus.',
                        'target_word' => 'Although the mobility restriction policy sparked public protests initially, it proved effective in flattening the viral transmission curve (Fronted Clause + Comma)',
                        'vocab' => [
                            ['en' => 'the mobility restriction policy sparked public protests initially', 'id' => 'kebijakan pembatasan mobilitas memicu protes publik pada awalnya'],
                            ['en' => 'it proved effective in flattening the viral transmission curve', 'id' => 'ia terbukti efektif menekan kurva transmisi virus'],
                        ],
                        'options' => [
                            'Although the mobility restriction policy sparked public protests initially, it proved effective in flattening the viral transmission curve.',
                            'Although the mobility restriction policy sparked public protests initially it proved effective in flattening the viral transmission curve.',
                            'The mobility restriction policy sparked public protests initially, it proved effective in flattening the viral transmission curve.',
                            'Although the mobility restriction policy sparked public protests initially; it proved effective in flattening the viral transmission curve.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa subordinat konsesi diletakkan di awal kalimat, sehingga tanda koma wajib ditempatkan setelah \'initially\'. Pilihan 3 adalah comma splice.',
                    ],
                    [
                        'id' => 52,
                        'id_sentence' => 'Indeks harga saham gabungan pulih dengan cepat karena investor asing kembali menyuntikkan modal ke pasar domestik.',
                        'target_word' => 'The composite stock price index recovered rapidly because foreign investors reinjected capital into the domestic market (End-position Clause without Comma)',
                        'vocab' => [
                            ['en' => 'the composite stock price index recovered rapidly', 'id' => 'indeks harga saham gabungan pulih dengan cepat'],
                            ['en' => 'foreign investors reinjected capital into the domestic market', 'id' => 'investor asing kembali menyuntikkan modal ke pasar domestik'],
                        ],
                        'options' => [
                            'The composite stock price index recovered rapidly because foreign investors reinjected capital into the domestic market.',
                            'The composite stock price index recovered rapidly, because foreign investors reinjected capital into the domestic market.',
                            'The composite stock price index recovered rapidly; because foreign investors reinjected capital into the domestic market.',
                            'Because foreign investors reinjected capital into the domestic market the composite stock price index recovered rapidly.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Ketika klausa \'because\' berada di posisi belakang kalimat (end position), tanda koma umumnya tidak digunakan dalam bahasa Inggris standar.',
                    ],
                    [
                        'id' => 53,
                        'id_sentence' => 'Ketika volume lalu lintas mencapai puncaknya pada pukul delapan pagi, emisi partikulat mikro di persimpangan jalan meningkat tajam.',
                        'target_word' => 'When traffic volume reaches its peak at eight in the morning, particulate matter emissions at the intersection increase sharply (Fronted When-clause + Comma)',
                        'vocab' => [
                            ['en' => 'traffic volume reaches its peak at eight in the morning', 'id' => 'volume lalu lintas mencapai puncaknya pada pukul delapan pagi'],
                            ['en' => 'particulate matter emissions at the intersection increase sharply', 'id' => 'emisi materi partikulat di persimpangan jalan meningkat tajam'],
                        ],
                        'options' => [
                            'When traffic volume reaches its peak at eight in the morning, particulate matter emissions at the intersection increase sharply.',
                            'When traffic volume reaches its peak at eight in the morning particulate matter emissions at the intersection increase sharply.',
                            'Traffic volume reaches its peak at eight in the morning, particulate matter emissions at the intersection increase sharply.',
                            'When traffic volume reaches its peak at eight in the morning; particulate matter emissions at the intersection increase sharply.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa adverbial waktu di awal kalimat (\'When traffic volume...\') wajib diakhiri dengan tanda koma sebelum klausa utama.',
                    ],
                    [
                        'id' => 54,
                        'id_sentence' => 'Model kecerdasan buatan tersebut menghasilkan luaran yang bias karena dataset pelatihannya tidak merepresentasikan demografi yang beragam.',
                        'target_word' => 'The artificial intelligence model produced biased outputs since its training dataset failed to represent diverse demographics (End-position Since-clause)',
                        'vocab' => [
                            ['en' => 'the artificial intelligence model produced biased outputs', 'id' => 'model kecerdasan buatan tersebut menghasilkan luaran yang bias'],
                            ['en' => 'its training dataset failed to represent diverse demographics', 'id' => 'dataset pelatihannya gagal merepresentasikan demografi yang beragam'],
                        ],
                        'options' => [
                            'The artificial intelligence model produced biased outputs since its training dataset failed to represent diverse demographics.',
                            'The artificial intelligence model produced biased outputs, since its training dataset failed to represent diverse demographics.',
                            'The artificial intelligence model produced biased outputs; since its training dataset failed to represent diverse demographics.',
                            'Since its training dataset failed to represent diverse demographics the artificial intelligence model produced biased outputs.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa kausal \'since\' di akhir kalimat menyatu secara mulus dengan klausa utama tanpa memerlukan tanda koma.',
                    ],
                    [
                        'id' => 55,
                        'id_sentence' => 'Jika regulator tidak segera menetapkan pedoman yang jelas, ketidakpastian hukum akan menghambat investasi swasta.',
                        'target_word' => 'If regulators do not promptly establish clear guidelines, legal uncertainty will stifle private investment (Fronted If-clause + Comma)',
                        'vocab' => [
                            ['en' => 'regulators do not promptly establish clear guidelines', 'id' => 'regulator tidak segera menetapkan pedoman yang jelas'],
                            ['en' => 'legal uncertainty will stifle private investment', 'id' => 'ketidakpastian hukum akan menghambat investasi swasta'],
                        ],
                        'options' => [
                            'If regulators do not promptly establish clear guidelines, legal uncertainty will stifle private investment.',
                            'If regulators do not promptly establish clear guidelines legal uncertainty will stifle private investment.',
                            'Regulators do not promptly establish clear guidelines, legal uncertainty will stifle private investment.',
                            'If regulators do not promptly establish clear guidelines; legal uncertainty will stifle private investment.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa kondisional \'If\' di posisi depan kalimat memerlukan tanda koma di ujungnya untuk mencegah ambiguitas sintaksis.',
                    ],
                    [
                        'id' => 56,
                        'id_sentence' => 'Eksperimen tetap dilanjutkan hingga larutan menunjukkan perubahan warna yang konsisten.',
                        'target_word' => 'The titration procedure was continued until the chemical indicator displayed a consistent color shift (End-position Until-clause)',
                        'vocab' => [
                            ['en' => 'the titration procedure was continued', 'id' => 'prosedur titrasi tetap dilanjutkan'],
                            ['en' => 'the chemical indicator displayed a consistent color shift', 'id' => 'indikator kimiawi menunjukkan perubahan warna yang konsisten'],
                        ],
                        'options' => [
                            'The titration procedure was continued until the chemical indicator displayed a consistent color shift.',
                            'The titration procedure was continued, until the chemical indicator displayed a consistent color shift.',
                            'The titration procedure was continued; until the chemical indicator displayed a consistent color shift.',
                            'Until the chemical indicator displayed a consistent color shift the titration procedure was continued.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa waktu \'until\' di belakang klausa utama tidak memakai tanda koma.',
                    ],
                    [
                        'id' => 57,
                        'id_sentence' => 'Meskipun beberapa departemen mencatatkan penghematan anggaran, pengeluaran agregat korporasi tetap melampaui proyeksi awal.',
                        'target_word' => 'Even though several departments recorded budgetary savings, aggregate corporate expenditure still exceeded original projections (Fronted Even though + Comma)',
                        'vocab' => [
                            ['en' => 'several departments recorded budgetary savings', 'id' => 'beberapa departemen mencatatkan penghematan anggaran'],
                            ['en' => 'aggregate corporate expenditure still exceeded original projections', 'id' => 'pengeluaran korporasi agregat tetap melampaui proyeksi awal'],
                        ],
                        'options' => [
                            'Even though several departments recorded budgetary savings, aggregate corporate expenditure still exceeded original projections.',
                            'Even though several departments recorded budgetary savings aggregate corporate expenditure still exceeded original projections.',
                            'Several departments recorded budgetary savings, aggregate corporate expenditure still exceeded original projections.',
                            'Even though several departments recorded budgetary savings; aggregate corporate expenditure still exceeded original projections.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Even though\' mengawali klausa konsesi di depan kalimat; tanda koma wajib ditempatkan setelah klausa subordinat tersebut.',
                    ],
                    [
                        'id' => 58,
                        'id_sentence' => 'Karyawan wajib mengenakan alat pelindung diri lengkap agar risiko kecelakaan kerja di area pengecoran dapat diminimalkan.',
                        'target_word' => 'Employees must wear full personal protective equipment so that occupational hazard risks in the foundry area are minimized (End-position So that-clause)',
                        'vocab' => [
                            ['en' => 'employees must wear full personal protective equipment', 'id' => 'karyawan wajib mengenakan alat pelindung diri lengkap'],
                            ['en' => 'occupational hazard risks in the foundry area are minimized', 'id' => 'risiko bahaya kerja di area pengecoran diminimalkan'],
                        ],
                        'options' => [
                            'Employees must wear full personal protective equipment so that occupational hazard risks in the foundry area are minimized.',
                            'Employees must wear full personal protective equipment, so that occupational hazard risks in the foundry area are minimized.',
                            'Employees must wear full personal protective equipment; so that occupational hazard risks in the foundry area are minimized.',
                            'So that occupational hazard risks in the foundry area are minimized employees must wear full personal protective equipment.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa tujuan \'so that\' di posisi belakang tidak memerlukan tanda koma.',
                    ],
                    [
                        'id' => 59,
                        'id_sentence' => 'Setelah sampel darah disentrifugasi selama sepuluh menit, lapisan plasma dipisahkan secara steril ke dalam tabung terpisah.',
                        'target_word' => 'After the blood specimens were centrifuged for ten minutes, the plasma layer was aseptically transferred into separate vials (Fronted After-clause + Comma)',
                        'vocab' => [
                            ['en' => 'the blood specimens were centrifuged for ten minutes', 'id' => 'spesimen darah disentrifugasi selama sepuluh menit'],
                            ['en' => 'the plasma layer was aseptically transferred into separate vials', 'id' => 'lapisan plasma dipindahkan secara steril ke dalam vial terpisah'],
                        ],
                        'options' => [
                            'After the blood specimens were centrifuged for ten minutes, the plasma layer was aseptically transferred into separate vials.',
                            'After the blood specimens were centrifuged for ten minutes the plasma layer was aseptically transferred into separate vials.',
                            'The blood specimens were centrifuged for ten minutes, the plasma layer was aseptically transferred into separate vials.',
                            'After that the blood specimens were centrifuged for ten minutes, the plasma layer was aseptically transferred into separate vials.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa waktu \'After...\' di depan kalimat mewajibkan tanda koma tepat sebelum subjek klausa utama (\'the plasma layer\').',
                    ],
                    [
                        'id' => 60,
                        'id_sentence' => 'Kendaraan otonom tersebut mengerem mendadak karena sensor lidar mendeteksi pejalan kaki yang menyeberang di luar jalur penyeberangan.',
                        'target_word' => 'The autonomous vehicle braked abruptly as its lidar sensor detected an unsanctioned pedestrian crossing (End-position As-clause)',
                        'vocab' => [
                            ['en' => 'the autonomous vehicle braked abruptly', 'id' => 'kendaraan otonom tersebut mengerem secara mendadak'],
                            ['en' => 'its lidar sensor detected an unsanctioned pedestrian crossing', 'id' => 'sensor lidar mendeteksi penyeberangan pejalan kaki tanpa izin'],
                        ],
                        'options' => [
                            'The autonomous vehicle braked abruptly as its lidar sensor detected an unsanctioned pedestrian crossing.',
                            'The autonomous vehicle braked abruptly, as its lidar sensor detected an unsanctioned pedestrian crossing.',
                            'The autonomous vehicle braked abruptly; as its lidar sensor detected an unsanctioned pedestrian crossing.',
                            'As its lidar sensor detected an unsanctioned pedestrian crossing the autonomous vehicle braked abruptly.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa kausal/waktu \'as\' di akhir kalimat menyatu tanpa koma.',
                    ],
                ]
            ],
        ];
    }
}
