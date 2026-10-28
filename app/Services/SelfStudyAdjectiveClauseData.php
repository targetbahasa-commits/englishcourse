<?php

namespace App\Services;

class SelfStudyAdjectiveClauseData
{
    /**
     * Get the complete Adjective Clause package (Module 3.2).
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
            'banner_title' => 'Adjective Clause (Relative Clause): Academic Description & Precision',
            'banner_subtitle' => 'Kuasai arsitektur klausa relatif dalam diskursus ilmiah: Pronomina relatif subjek dan objek (who vs whom vs which vs that), pronomina relatif kepemilikan \'whose\' untuk manusia dan entitas institusional/benda, pembedaan esensial Defining (restrictive) vs Non-defining (non-restrictive) clauses beserta kaidah koma mutlak, adverbia relatif tempat dan waktu (where, when, in which), serta integrasi preposisi depan formal (pied-piping: to whom, under which, by means of which).',
            'banner_badge' => 'MODULE 3.2 ADJECTIVE CLAUSE (RELATIVE CLAUSE)',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 3.2
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Panduan Komprehensif Klausa Adjektiva (Relative Clause)',
            'concept_summary' => 'Klausa Adjektiva (Relative Clause) adalah klausa dependen yang berfungsi memodifikasi atau memberikan informasi spesifik mengenai kata benda atau frasa benda pendahulu (antecedent). Dalam penulisan akademis tingkat tinggi (IELTS Band 8-9), klausa relatif memungkinkan penulis menyisipkan definisi teknis, deskripsi variabel, dan spesifikasi metodologi secara padat dan terstruktur tanpa memecah kesinambungan gagasan. Penguasaan topik ini mencakup: (1) Menentukan pronomina relatif yang tepat berdasarkan peran gramatikal (who, whom, which, that); (2) Membedakan secara presisi antara Defining Clause (tanpa koma) dan Non-Defining Clause (wajib diapit koma); (3) Larangan mutlak memakai \'that\' dalam Non-Defining Clause setelah tanda koma; (4) Menggunakan \'whose\' untuk menyatakan kepemilikan baik pada manusia maupun institusi/benda; serta (5) Menerapkan pola formal penempatan preposisi di depan pronomina relatif (preposition + whom/which).',
            'rules' => [
                [
                    'rule_title' => '1. Perbedaan Subjek \'Who\' vs Objek \'Whom\'',
                    'rule_formula' => 'Person Subject: Noun + who + Verb | Person Object: Noun + whom + Subject + Verb',
                    'rule_description' => 'Gunakan \'who\' jika pronomina relatif adalah pelaku tindakan dalam klausanya. Gunakan \'whom\' dalam register formal jika pronomina relatif adalah objek penderita yang menerima tindakan dari subjek lain.',
                    'examples' => [
                        [
                            'en' => 'The surgeon who performed the operation was commended.',
                            'id' => 'Ahli bedah yang melakukan operasi tersebut dipuji.',
                            'note' => '\'who\' bertindak sebagai subjek dari verba \'performed\'.'
                        ],
                        [
                            'en' => 'The surgeon whom the hospital board recruited has extensive experience.',
                            'id' => 'Ahli bedah yang direkrut oleh dewan rumah sakit memiliki pengalaman luas.',
                            'note' => '\'whom\' adalah objek dari tindakan dewan rumah sakit (recruited).'
                        ]
                    ]
                ],
                [
                    'rule_title' => '2. Kaidah Koma Defining vs Non-Defining Clauses',
                    'rule_formula' => 'Defining (Esensial): TANPA KOMA | Non-Defining (Ekstra): WAJIB DIAPIT DUA KOMA (dan TIDAK boleh memakai \'that\')',
                    'rule_description' => 'Defining clause membatasi identitas spesifik dari kata benda umum (tanpa koma). Non-defining clause memberikan informasi tambahan pada kata benda yang sudah teridentifikasi spesifik/unik (wajib diapit dua koma dan tidak boleh memakai \'that\').',
                    'examples' => [
                        [
                            'en' => 'Substances that decompose rapidly are environmentally safe.',
                            'id' => 'Zat yang terurai cepat aman bagi lingkungan.',
                            'note' => 'Defining: hanya zat tertentu yang dimaksud (tanpa koma).'
                        ],
                        [
                            'en' => 'Plutonium, which decomposes very slowly, poses environmental hazards.',
                            'id' => 'Plutonium, yang terurai sangat lambat, menimbulkan bahaya lingkungan.',
                            'note' => 'Non-defining: Plutonium adalah nama zat unik (wajib koma, pakai \'which\').'
                        ]
                    ]
                ],
                [
                    'rule_title' => '3. Kepemilikan Universal dengan \'Whose\'',
                    'rule_formula' => 'Noun (Person / Organization / Object) + whose + Noun (tanpa artikel) + Verb...',
                    'rule_description' => '\'Whose\' digunakan secara luas dalam penulisan ilmiah untuk menyatakan kepemilikan, baik pada manusia (*the researcher whose study...*) maupun institusi atau objek (*the company whose revenue fell...*). Jangan pernah gunakan kontraksi *who\'s* untuk kepemilikan.',
                    'examples' => [
                        [
                            'en' => 'The enterprise whose patents expired faced intense competition.',
                            'id' => 'Perusahaan yang patennya kedaluwarsa menghadapi persaingan ketat.',
                            'note' => '\'whose patents\' menyatakan paten milik perusahaan.'
                        ]
                    ]
                ],
                [
                    'rule_title' => '4. Penempatan Preposisi Terikat di Depan (Pied-Piping)',
                    'rule_formula' => 'Noun + [Preposition] + [which / whom] + Subject + Verb... (BUKAN *prep + that* atau *prep + who*)',
                    'rule_description' => 'Dalam ragam formal akademik, preposisi ditempatkan tepat sebelum kata ganti relatif (to whom, in which, by which, under which) daripada dibiarkan menggantung di akhir klausa.',
                    'examples' => [
                        [
                            'en' => 'The treaty under which tariffs were lowered took effect last month.',
                            'id' => 'Traktat di bawah naungan mana tarif diturunkan mulai berlaku bulan lalu.',
                            'note' => 'Pola berlaras tinggi: \'under which\' menggantikan \'which... under\'.'
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
                'id' => 'relative-pronouns-subject-object',
                'name' => '3.2.1 Relative Pronoun Subject & Object (Who, Whom, Which, That)',
                'code' => '3.2.1',
                'concept_title' => 'Pronomina Relatif Subjek & Objek (Subject & Object Relative Pronouns)',
                'concept_description' => 'Klausa adjektiva (Relative Clause) memodifikasi kata benda atau frasa benda pendahulu (antecedent). Pemilihan kata ganti relatif ditentukan oleh jenis anteseden (manusia vs benda/konsep) dan posisi gramatikalnya dalam klausa relatif. (1) Anteseden manusia: gunakan \'who\' jika berfungsi sebagai subjek klausa relatif, dan \'whom\' jika berfungsi sebagai objek kata kerja atau preposisi. (2) Anteseden benda/konsep: gunakan \'which\' atau \'that\'.',
                'description' => 'Klausa adjektiva (Relative Clause) memodifikasi kata benda atau frasa benda pendahulu (antecedent). Pemilihan kata ganti relatif ditentukan oleh jenis anteseden (manusia vs benda/konsep) dan posisi gramatikalnya dalam klausa relatif. (1) Anteseden manusia: gunakan \'who\' jika berfungsi sebagai subjek klausa relatif, dan \'whom\' jika berfungsi sebagai objek kata kerja atau preposisi. (2) Anteseden benda/konsep: gunakan \'which\' atau \'that\'.',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-emerald-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-emerald-500/25 text-emerald-300 border border-emerald-500/50 font-mono">RELATIVE PRONOUNS</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Who (Orang-Subjek), Whom (Orang-Objek), Which (Benda)</span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
        <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600">
            <span class="text-xs font-bold text-emerald-300 block mb-1">1. Orang sebagai Subjek</span>
            <code class="text-xs font-mono text-emerald-300 block bg-slate-950 p-1.5 rounded border border-emerald-500/40">Person + WHO + Verb</code>
            <span class="text-xs text-white italic block mt-1">researchers who conduct</span>
        </div>
        <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600">
            <span class="text-xs font-bold text-sky-300 block mb-1">2. Orang sebagai Objek</span>
            <code class="text-xs font-mono text-sky-300 block bg-slate-950 p-1.5 rounded border border-sky-500/40">Person + WHOM + S + V</code>
            <span class="text-xs text-white italic block mt-1">participants whom we surveyed</span>
        </div>
        <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600">
            <span class="text-xs font-bold text-amber-300 block mb-1">3. Benda / Konsep</span>
            <code class="text-xs font-mono text-amber-300 block bg-slate-950 p-1.5 rounded border border-amber-500/40">Thing + WHICH / THAT + V</code>
            <span class="text-xs text-white italic block mt-1">the policy which protects</span>
        </div>
    </div>
</div>
HTML,
                'rules' => [
                    'Gunakan \'who\' jika kata ganti tersebut bertindak sebagai subjek klausa relatif (langsung diikuti kata kerja).',
                    'Gunakan \'whom\' jika kata ganti tersebut bertindak sebagai objek dalam klausa relatif (diikuti subjek baru + kata kerja).',
                    'Gunakan \'which\' atau \'that\' untuk merujuk pada benda mati, ide abstrak, variabel penelitian, atau hewan.',
                    'Jangan pernah menggunakan \'what\' sebagai kata ganti relatif yang memodifikasi kata benda (contoh salah: *the book what I read*).',
                    'Pastikan kesesuaian jumlah (Subject-Verb Agreement) antara kata benda anteseden dengan kata kerja di dalam klausa \'who\' atau \'which\'.',
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'id_sentence' => 'Para insinyur yang merancang arsitektur mikroprosesor baru tersebut dianugerahi penghargaan inovasi internasional.',
                        'target_word' => 'The engineers who designed the new microprocessor architecture were awarded the international innovation prize (Noun Person + who + Verb)',
                        'vocab' => [
                            ['en' => 'the engineers who designed the new microprocessor architecture', 'id' => 'para insinyur yang merancang arsitektur mikroprosesor baru'],
                            ['en' => 'were awarded the international innovation prize', 'id' => 'dianugerahi penghargaan inovasi internasional'],
                        ],
                        'options' => [
                            'The engineers who designed the new microprocessor architecture were awarded the international innovation prize.',
                            'The engineers whom designed the new microprocessor architecture were awarded the international innovation prize.',
                            'The engineers which designed the new microprocessor architecture were awarded the international innovation prize.',
                            'The engineers what designed the new microprocessor architecture were awarded the international innovation prize.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The engineers\' adalah manusia dan bertindak sebagai subjek bagi kata kerja \'designed\', sehingga wajib menggunakan relative pronoun \'who\'.',
                    ],
                    [
                        'id' => 2,
                        'id_sentence' => 'Kandidat yang diwawancarai oleh panel seleksi kemarin memiliki kualifikasi doktoral dalam bidang kecerdasan buatan.',
                        'target_word' => 'The candidate whom the selection panel interviewed yesterday possesses doctoral qualifications in artificial intelligence (Noun Person + whom + Subject + Verb)',
                        'vocab' => [
                            ['en' => 'the candidate whom the selection panel interviewed yesterday', 'id' => 'kandidat yang diwawancarai oleh panel seleksi kemarin'],
                            ['en' => 'possesses doctoral qualifications in artificial intelligence', 'id' => 'memiliki kualifikasi doktoral dalam kecerdasan buatan'],
                        ],
                        'options' => [
                            'The candidate whom the selection panel interviewed yesterday possesses doctoral qualifications in artificial intelligence.',
                            'The candidate who the selection panel interviewed yesterday possesses doctoral qualifications in artificial intelligence.',
                            'The candidate which the selection panel interviewed yesterday possesses doctoral qualifications in artificial intelligence.',
                            'The candidate whose the selection panel interviewed yesterday possesses doctoral qualifications in artificial intelligence.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The candidate\' adalah objek penderita dari tindakan yang dilakukan oleh subjek klausa relatif (\'the selection panel interviewed...\'), sehingga dalam register akademik baku digunakan \'whom\'.',
                    ],
                    [
                        'id' => 3,
                        'id_sentence' => 'Katalis kimia yang mempercepat laju reaksi hidrokarbon telah dipatenkan oleh laboratorium penelitian.',
                        'target_word' => 'The chemical catalyst that accelerates the hydrocarbon reaction rate has been patented by the research laboratory (Noun Thing + that + Verb)',
                        'vocab' => [
                            ['en' => 'the chemical catalyst that accelerates the hydrocarbon reaction rate', 'id' => 'katalis kimia yang mempercepat laju reaksi hidrokarbon'],
                            ['en' => 'has been patented by the research laboratory', 'id' => 'telah dipatenkan oleh laboratorium penelitian'],
                        ],
                        'options' => [
                            'The chemical catalyst that accelerates the hydrocarbon reaction rate has been patented by the research laboratory.',
                            'The chemical catalyst who accelerates the hydrocarbon reaction rate has been patented by the research laboratory.',
                            'The chemical catalyst what accelerates the hydrocarbon reaction rate has been patented by the research laboratory.',
                            'The chemical catalyst whom accelerates the hydrocarbon reaction rate has been patented by the research laboratory.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The chemical catalyst\' adalah benda/senyawa kimia (non-human), sehingga wajib menggunakan \'that\' atau \'which\', bukan \'who\' atau \'what\'.',
                    ],
                    [
                        'id' => 4,
                        'id_sentence' => 'Para partisipan yang menyelesaikan seluruh kuesioner menerima kompensasi finansial secara langsung.',
                        'target_word' => 'Participants who completed the entire questionnaire received direct financial compensation (Participants + who + Verb)',
                        'vocab' => [
                            ['en' => 'participants who completed the entire questionnaire', 'id' => 'partisipan yang menyelesaikan seluruh kuesioner'],
                            ['en' => 'received direct financial compensation', 'id' => 'menerima kompensasi finansial langsung'],
                        ],
                        'options' => [
                            'Participants who completed the entire questionnaire received direct financial compensation.',
                            'Participants whom completed the entire questionnaire received direct financial compensation.',
                            'Participants which completed the entire questionnaire received direct financial compensation.',
                            'Participants whose completed the entire questionnaire received direct financial compensation.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Participants\' adalah orang yang melakukan tindakan \'completed\', sehingga menggunakan subjek relatif \'who\'.',
                    ],
                    [
                        'id' => 5,
                        'id_sentence' => 'Pakar ekonomi yang dikonsultasikan oleh kementerian keuangan merekomendasikan kenaikan rasio pajak secara bertahap.',
                        'target_word' => 'The economist whom the finance ministry consulted recommended an incremental increase in the tax ratio (Noun + whom + S + V)',
                        'vocab' => [
                            ['en' => 'the economist whom the finance ministry consulted', 'id' => 'pakar ekonomi yang dikonsultasikan oleh kementerian keuangan'],
                            ['en' => 'recommended an incremental increase in the tax ratio', 'id' => 'merekomendasikan kenaikan bertahap rasio pajak'],
                        ],
                        'options' => [
                            'The economist whom the finance ministry consulted recommended an incremental increase in the tax ratio.',
                            'The economist which the finance ministry consulted recommended an incremental increase in the tax ratio.',
                            'The economist whose the finance ministry consulted recommended an incremental increase in the tax ratio.',
                            'The economist what the finance ministry consulted recommended an incremental increase in the tax ratio.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The economist\' adalah manusia dan berstatus objek dari \'the finance ministry consulted [him]\', sehingga bentuk formalnya adalah \'whom\'.',
                    ],
                    [
                        'id' => 6,
                        'id_sentence' => 'Algoritma kompresi data yang dikembangkan oleh tim perangkat lunak tersebut mengurangi beban server hingga empat puluh persen.',
                        'target_word' => 'The data compression algorithm that the software team developed reduced server load by forty percent (Noun + that + S + V)',
                        'vocab' => [
                            ['en' => 'the data compression algorithm that the software team developed', 'id' => 'algoritma kompresi data yang dikembangkan tim perangkat lunak'],
                            ['en' => 'reduced server load by forty percent', 'id' => 'mengurangi beban server hingga empat puluh persen'],
                        ],
                        'options' => [
                            'The data compression algorithm that the software team developed reduced server load by forty percent.',
                            'The data compression algorithm whom the software team developed reduced server load by forty percent.',
                            'The data compression algorithm what the software team developed reduced server load by forty percent.',
                            'The data compression algorithm who the software team developed reduced server load by forty percent.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Algorithm\' adalah entitas non-human, sehingga \'that\' (atau \'which\') adalah pilihan kata ganti yang tepat.',
                    ],
                    [
                        'id' => 7,
                        'id_sentence' => 'Para mahasiswa yang tidak mengumpulkan esai mereka tepat waktu akan dikenai pengurangan nilai sebesar lima persen per hari.',
                        'target_word' => 'Students who fail to submit their essays on time will incur a grade deduction of five percent per day (Students + who + fail)',
                        'vocab' => [
                            ['en' => 'students who fail to submit their essays on time', 'id' => 'mahasiswa yang gagal mengumpulkan esai tepat waktu'],
                            ['en' => 'will incur a grade deduction of five percent per day', 'id' => 'akan dikenai pengurangan nilai lima persen per hari'],
                        ],
                        'options' => [
                            'Students who fail to submit their essays on time will incur a grade deduction of five percent per day.',
                            'Students whom fail to submit their essays on time will incur a grade deduction of five percent per day.',
                            'Students which fail to submit their essays on time will incur a grade deduction of five percent per day.',
                            'Students whose fail to submit their essays on time will incur a grade deduction of five percent per day.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Students\' adalah manusia sebagai subjek verba \'fail\', wajib menggunakan \'who\'.',
                    ],
                    [
                        'id' => 8,
                        'id_sentence' => 'Instrumen spektrometri yang dibeli tahun lalu memerlukan pemeliharaan rutin setiap tiga bulan.',
                        'target_word' => 'The spectrometry instrument which was purchased last year requires routine maintenance every three months (Instrument + which + was purchased)',
                        'vocab' => [
                            ['en' => 'the spectrometry instrument which was purchased last year', 'id' => 'instrumen spektrometri yang dibeli tahun lalu'],
                            ['en' => 'requires routine maintenance every three months', 'id' => 'memerlukan pemeliharaan rutin setiap tiga bulan'],
                        ],
                        'options' => [
                            'The spectrometry instrument which was purchased last year requires routine maintenance every three months.',
                            'The spectrometry instrument who was purchased last year requires routine maintenance every three months.',
                            'The spectrometry instrument whom was purchased last year requires routine maintenance every three months.',
                            'The spectrometry instrument whose was purchased last year requires routine maintenance every three months.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The spectrometry instrument\' adalah peralatan teknis (benda), sehingga \'which\' adalah kata ganti relatif subjek yang benar.',
                    ],
                    [
                        'id' => 9,
                        'id_sentence' => 'Para ahli bedah saraf yang memimpin operasi pemisahan kembar siam tersebut mengadakan konferensi pers pagi ini.',
                        'target_word' => 'The neurosurgeons who led the conjoined twins separation surgery held a press briefing this morning (Neurosurgeons + who + led)',
                        'vocab' => [
                            ['en' => 'the neurosurgeons who led the conjoined twins separation surgery', 'id' => 'para ahli bedah saraf yang memimpin operasi pemisahan kembar siam'],
                            ['en' => 'held a press briefing this morning', 'id' => 'mengadakan konferensi pers pagi ini'],
                        ],
                        'options' => [
                            'The neurosurgeons who led the conjoined twins separation surgery held a press briefing this morning.',
                            'The neurosurgeons whom led the conjoined twins separation surgery held a press briefing this morning.',
                            'The neurosurgeons which led the conjoined twins separation surgery held a press briefing this morning.',
                            'The neurosurgeons what led the conjoined twins separation surgery held a press briefing this morning.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Neurosurgeons\' adalah pelaku/subjek dari kata kerja \'led\', memerlukan \'who\'.',
                    ],
                    [
                        'id' => 10,
                        'id_sentence' => 'Kebijakan fiskal yang diusulkan oleh dewan penasihat ekonomi memicu perdebatan sengit di parlemen.',
                        'target_word' => 'The fiscal policy that the economic advisory council proposed triggered intense debate in parliament (Policy + that + S + V)',
                        'vocab' => [
                            ['en' => 'the fiscal policy that the economic advisory council proposed', 'id' => 'kebijakan fiskal yang diusulkan dewan penasihat ekonomi'],
                            ['en' => 'triggered intense debate in parliament', 'id' => 'memicu perdebatan sengit di parlemen'],
                        ],
                        'options' => [
                            'The fiscal policy that the economic advisory council proposed triggered intense debate in parliament.',
                            'The fiscal policy whom the economic advisory council proposed triggered intense debate in parliament.',
                            'The fiscal policy who the economic advisory council proposed triggered intense debate in parliament.',
                            'The fiscal policy what the economic advisory council proposed triggered intense debate in parliament.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The fiscal policy\' adalah konsep abstrak non-manusia, sehingga \'that\' (atau \'which\') adalah kata ganti yang tepat.',
                    ],
                ]
            ],
            [
                'id' => 'relative-pronouns-possession-whose',
                'name' => '3.2.2 Relative Pronoun of Possession (Whose for People, Institutions, & Entities)',
                'code' => '3.2.2',
                'concept_title' => 'Pronomina Relatif Kepemilikan (Possessive Relative \'Whose\')',
                'concept_description' => '\'Whose\' adalah satu-satunya pronomina relatif yang menyatakan hubungan kepemilikan (possessive) dalam bahasa Inggris. Dalam penulisan modern dan register akademik formal, \'whose\' tidak hanya digunakan untuk manusia (misalnya: *the professor whose research...*), melainkan juga secara luas dan sah digunakan untuk merujuk pada organisasi, institusi, negara, perusahaan, bahkan benda atau konsep (misalnya: *the company whose shares plummeted* atau *the experiment whose outcome was inconclusive*).',
                'description' => '\'Whose\' adalah satu-satunya pronomina relatif yang menyatakan hubungan kepemilikan (possessive) dalam bahasa Inggris. Dalam penulisan modern dan register akademik formal, \'whose\' tidak hanya digunakan untuk manusia (misalnya: *the professor whose research...*), melainkan juga secara luas dan sah digunakan untuk merujuk pada organisasi, institusi, negara, perusahaan, bahkan benda atau konsep (misalnya: *the company whose shares plummeted* atau *the experiment whose outcome was inconclusive*).',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-amber-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-amber-500/25 text-amber-300 border border-amber-500/50 font-mono">POSSESSION: WHOSE</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Kepemilikan Orang, Institusi, atau Benda</span>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1.5">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-amber-300 uppercase tracking-wide flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-400"></span> Rumus Kepemilikan
            </span>
            <code class="text-xs font-mono font-bold text-emerald-300 bg-slate-950 px-2.5 py-1 rounded border border-emerald-500/40">Noun + WHOSE + Noun (Milik) + Predicate</code>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-emerald-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">Countries whose economies depend on oil face severe transition risks.</span>
        </div>
    </div>
</div>
HTML,
                'rules' => [
                    '\'Whose\' selalu diikuti langsung oleh kata benda tanpa artikel (contoh: *whose methodology*, BUKAN *whose the methodology*).',
                    '\'Whose\' dapat menggantikan \'of which\' untuk entitas non-manusia agar kalimat lebih ringkas dan alami dalam register ilmiah.',
                    'Jangan pernah menyamakan \'whose\' (kepemilikan) dengan kontraksi \'who\'s\' (= who is / who has).',
                    'Kata benda setelah \'whose\' dapat berfungsi sebagai subjek maupun objek di dalam klausa relatif.',
                ],
                'exercises' => [
                    [
                        'id' => 11,
                        'id_sentence' => 'Universitas yang fakultas kedokterannya menduduki peringkat sepuluh besar dunia tersebut menerima ribuan aplikasi internasional.',
                        'target_word' => 'The university whose medical faculty ranks among the world\'s top ten receives thousands of international applications (University + whose + medical faculty)',
                        'vocab' => [
                            ['en' => 'the university whose medical faculty ranks among the world\'s top ten', 'id' => 'universitas yang fakultas kedokterannya menduduki peringkat sepuluh besar dunia'],
                            ['en' => 'receives thousands of international applications', 'id' => 'menerima ribuan aplikasi internasional'],
                        ],
                        'options' => [
                            'The university whose medical faculty ranks among the world\'s top ten receives thousands of international applications.',
                            'The university who\'s medical faculty ranks among the world\'s top ten receives thousands of international applications.',
                            'The university of which medical faculty ranks among the world\'s top ten receives thousands of international applications.',
                            'The university which medical faculty ranks among the world\'s top ten receives thousands of international applications.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Whose\' digunakan untuk kepemilikan institusional (\'whose medical faculty\'). \'Who\'s\' adalah kontraksi dari \'who is\', bukan kata ganti kepemilikan.',
                    ],
                    [
                        'id' => 12,
                        'id_sentence' => 'Peneliti yang hipotesisnya terbukti akurat dalam uji coba lapangan mempresentasikan makalahnya di simposium Jenewa.',
                        'target_word' => 'The researcher whose hypothesis was validated in field trials presented her paper at the Geneva symposium (Researcher + whose + hypothesis)',
                        'vocab' => [
                            ['en' => 'the researcher whose hypothesis was validated in field trials', 'id' => 'peneliti yang hipotesisnya divalidasi dalam uji lapangan'],
                            ['en' => 'presented her paper at the Geneva symposium', 'id' => 'mempresentasikan makalahnya di simposium Jenewa'],
                        ],
                        'options' => [
                            'The researcher whose hypothesis was validated in field trials presented her paper at the Geneva symposium.',
                            'The researcher who\'s hypothesis was validated in field trials presented her paper at the Geneva symposium.',
                            'The researcher whom hypothesis was validated in field trials presented her paper at the Geneva symposium.',
                            'The researcher which hypothesis was validated in field trials presented her paper at the Geneva symposium.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Whose hypothesis\' menggantikan frasa kepemilikan \'the researcher\'s hypothesis\'.',
                    ],
                    [
                        'id' => 13,
                        'id_sentence' => 'Perusahaan farmasi yang paten obatnya kedaluwarsa tahun depan sedang mengembangkan tiga molekul baru.',
                        'target_word' => 'The pharmaceutical company whose drug patent expires next year is developing three new chemical entities (Company + whose + drug patent)',
                        'vocab' => [
                            ['en' => 'the pharmaceutical company whose drug patent expires next year', 'id' => 'perusahaan farmasi yang paten obatnya kedaluwarsa tahun depan'],
                            ['en' => 'is developing three new chemical entities', 'id' => 'sedang mengembangkan tiga entitas kimia baru'],
                        ],
                        'options' => [
                            'The pharmaceutical company whose drug patent expires next year is developing three new chemical entities.',
                            'The pharmaceutical company which drug patent expires next year is developing three new chemical entities.',
                            'The pharmaceutical company that drug patent expires next year is developing three new chemical entities.',
                            'The pharmaceutical company who\'s drug patent expires next year is developing three new chemical entities.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Whose\' sah digunakan untuk perusahaan non-manusia untuk menyatakan kepemilikan (\'whose drug patent\').',
                    ],
                    [
                        'id' => 14,
                        'id_sentence' => 'Negara-negara yang emisi gas rumah kacanya melampaui kuota yang disepakati akan menghadapi sanksi perdagangan karbon.',
                        'target_word' => 'Countries whose greenhouse gas emissions exceed agreed quotas will face carbon trade sanctions (Countries + whose + emissions)',
                        'vocab' => [
                            ['en' => 'countries whose greenhouse gas emissions exceed agreed quotas', 'id' => 'negara-negara yang emisi gas rumah kacanya melampaui kuota yang disepakati'],
                            ['en' => 'will face carbon trade sanctions', 'id' => 'akan menghadapi sanksi perdagangan karbon'],
                        ],
                        'options' => [
                            'Countries whose greenhouse gas emissions exceed agreed quotas will face carbon trade sanctions.',
                            'Countries which greenhouse gas emissions exceed agreed quotas will face carbon trade sanctions.',
                            'Countries who\'s greenhouse gas emissions exceed agreed quotas will face carbon trade sanctions.',
                            'Countries that greenhouse gas emissions exceed agreed quotas will face carbon trade sanctions.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Whose\' menerangkan kepemilikan emisi dari negara-negara (\'countries\' greenhouse gas emissions\').',
                    ],
                    [
                        'id' => 15,
                        'id_sentence' => 'Pasien yang riwayat medisnya menunjukkan alergi terhadap penisilin diberi resep antibiotik alternatif.',
                        'target_word' => 'Patients whose medical records indicate penicillin allergies were prescribed alternative broad-spectrum antibiotics (Patients + whose + medical records)',
                        'vocab' => [
                            ['en' => 'patients whose medical records indicate penicillin allergies', 'id' => 'pasien yang rekam medisnya mengindikasikan alergi penisilin'],
                            ['en' => 'were prescribed alternative broad-spectrum antibiotics', 'id' => 'diberi resep antibiotik spektrum luas alternatif'],
                        ],
                        'options' => [
                            'Patients whose medical records indicate penicillin allergies were prescribed alternative broad-spectrum antibiotics.',
                            'Patients whom medical records indicate penicillin allergies were prescribed alternative broad-spectrum antibiotics.',
                            'Patients who\'s medical records indicate penicillin allergies were prescribed alternative broad-spectrum antibiotics.',
                            'Patients which medical records indicate penicillin allergies were prescribed alternative broad-spectrum antibiotics.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Whose medical records\' menyatakan rekam medis milik pasien (\'the patients\' medical records\').',
                    ],
                    [
                        'id' => 16,
                        'id_sentence' => 'Studi klinis yang protokol metodologinya telah ditinjau secara ketat memperoleh pendanaan dari yayasan sains nasional.',
                        'target_word' => 'The clinical study whose methodological protocol was rigorously peer-reviewed received grants from the national science foundation (Study + whose + protocol)',
                        'vocab' => [
                            ['en' => 'the clinical study whose methodological protocol was rigorously peer-reviewed', 'id' => 'studi klinis yang protokol metodologinya ditinjau sejawat secara ketat'],
                            ['en' => 'received grants from the national science foundation', 'id' => 'menerima hibah dari yayasan sains nasional'],
                        ],
                        'options' => [
                            'The clinical study whose methodological protocol was rigorously peer-reviewed received grants from the national science foundation.',
                            'The clinical study of which the methodological protocol was rigorously peer-reviewed received grants from the national science foundation.',
                            'The clinical study which methodological protocol was rigorously peer-reviewed received grants from the national science foundation.',
                            'The clinical study that methodological protocol was rigorously peer-reviewed received grants from the national science foundation.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Whose\' digunakan secara elegan pada entitas penelitian (\'whose methodological protocol\').',
                    ],
                    [
                        'id' => 17,
                        'id_sentence' => 'Penulis yang artikelnya paling banyak disitasi dalam jurnal tersebut diundang sebagai pembicara kunci.',
                        'target_word' => 'The author whose article was most cited in the journal was invited as a keynote speaker (Author + whose + article)',
                        'vocab' => [
                            ['en' => 'the author whose article was most cited in the journal', 'id' => 'penulis yang artikelnya paling banyak disitasi di jurnal'],
                            ['en' => 'was invited as a keynote speaker', 'id' => 'diundang sebagai pembicara utama'],
                        ],
                        'options' => [
                            'The author whose article was most cited in the journal was invited as a keynote speaker.',
                            'The author whom article was most cited in the journal was invited as a keynote speaker.',
                            'The author who\'s article was most cited in the journal was invited as a keynote speaker.',
                            'The author which article was most cited in the journal was invited as a keynote speaker.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Bentuk kepemilikan artikel oleh penulis dinyatakan dengan \'whose article\'.',
                    ],
                    [
                        'id' => 18,
                        'id_sentence' => 'Bangunan bersejarah yang fondasi batunya terkikis oleh banjir bandang sedang menjalani restorasi struktural intensif.',
                        'target_word' => 'The historic building whose stone foundation was eroded by flash floods is undergoing intensive structural restoration (Building + whose + foundation)',
                        'vocab' => [
                            ['en' => 'the historic building whose stone foundation was eroded by flash floods', 'id' => 'bangunan bersejarah yang fondasi batunya terkikis banjir bandang'],
                            ['en' => 'is undergoing intensive structural restoration', 'id' => 'sedang menjalani restorasi struktural intensif'],
                        ],
                        'options' => [
                            'The historic building whose stone foundation was eroded by flash floods is undergoing intensive structural restoration.',
                            'The historic building which stone foundation was eroded by flash floods is undergoing intensive structural restoration.',
                            'The historic building who\'s stone foundation was eroded by flash floods is undergoing intensive structural restoration.',
                            'The historic building that stone foundation was eroded by flash floods is undergoing intensive structural restoration.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kepemilikan komponen fisik sebuah bangunan dinyatakan dengan \'whose stone foundation\'.',
                    ],
                    [
                        'id' => 19,
                        'id_sentence' => 'Organisasi nirlaba yang laporan transparansinya diaudit oleh firma independen menerima sertifikasi akuntabilitas publik.',
                        'target_word' => 'The non-profit organization whose transparency report was audited by an independent firm received public accountability certification (Organization + whose + report)',
                        'vocab' => [
                            ['en' => 'the non-profit organization whose transparency report was audited by an independent firm', 'id' => 'organisasi nirlaba yang laporan transparansinya diaudit firma independen'],
                            ['en' => 'received public accountability certification', 'id' => 'menerima sertifikasi akuntabilitas publik'],
                        ],
                        'options' => [
                            'The non-profit organization whose transparency report was audited by an independent firm received public accountability certification.',
                            'The non-profit organization which transparency report was audited by an independent firm received public accountability certification.',
                            'The non-profit organization who\'s transparency report was audited by an independent firm received public accountability certification.',
                            'The non-profit organization that transparency report was audited by an independent firm received public accountability certification.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Whose\' menerangkan laporan milik organisasi non-profit.',
                    ],
                    [
                        'id' => 20,
                        'id_sentence' => 'Pasien yang tekanan darahnya melebihi ambang batas aman tidak diperkenankan mengikuti prosedur bedah elektif.',
                        'target_word' => 'Patients whose blood pressure exceeds safe physiological thresholds are not permitted to undergo elective surgical procedures (Patients + whose + blood pressure)',
                        'vocab' => [
                            ['en' => 'patients whose blood pressure exceeds safe physiological thresholds', 'id' => 'pasien yang tekanan darahnya melampaui ambang batas fisiologis aman'],
                            ['en' => 'are not permitted to undergo elective surgical procedures', 'id' => 'tidak diizinkan menjalani prosedur bedah elektif'],
                        ],
                        'options' => [
                            'Patients whose blood pressure exceeds safe physiological thresholds are not permitted to undergo elective surgical procedures.',
                            'Patients whom blood pressure exceeds safe physiological thresholds are not permitted to undergo elective surgical procedures.',
                            'Patients who\'s blood pressure exceeds safe physiological thresholds are not permitted to undergo elective surgical procedures.',
                            'Patients which blood pressure exceeds safe physiological thresholds are not permitted to undergo elective surgical procedures.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Whose blood pressure\' menyatakan tekanan darah milik pasien.',
                    ],
                ]
            ],
            [
                'id' => 'defining-vs-non-defining-relative-clauses',
                'name' => '3.2.3 Defining vs Non-Defining Relative Clauses (Essential Identification vs Supplementary Info, Comma Rules)',
                'code' => '3.2.3',
                'concept_title' => 'Klausa Relatif Pembatas vs Penjelas (Defining vs Non-Defining)',
                'concept_description' => 'Perbedaan antara Defining (Restrictive) dan Non-Defining (Non-Restrictive) relative clauses adalah salah satu kaidah paling krusial dalam penulisan akademis berlaras tinggi. (1) Defining Clause membatasi dan mengidentifikasi secara esensial kata benda yang dibicarakan; TANPA tanda koma; dapat menggunakan \'that\' atau \'which\'. (2) Non-Defining Clause memberikan informasi tambahan/ekstra tentang kata benda yang sudah teridentifikasi spesifik (nama orang, nama tempat, istilah unik); WAJIB diapit dua tanda koma; TIDAK PERNAH boleh menggunakan kata \'that\' (hanya \'which\', \'who\', \'whom\', \'whose\').',
                'description' => 'Perbedaan antara Defining (Restrictive) dan Non-Defining (Non-Restrictive) relative clauses adalah salah satu kaidah paling krusial dalam penulisan akademis berlaras tinggi. (1) Defining Clause membatasi dan mengidentifikasi secara esensial kata benda yang dibicarakan; TANPA tanda koma; dapat menggunakan \'that\' atau \'which\'. (2) Non-Defining Clause memberikan informasi tambahan/ekstra tentang kata benda yang sudah teridentifikasi spesifik (nama orang, nama tempat, istilah unik); WAJIB diapit dua tanda koma; TIDAK PERNAH boleh menggunakan kata \'that\' (hanya \'which\', \'who\', \'whom\', \'whose\').',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-indigo-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-indigo-500/25 text-indigo-300 border border-indigo-500/50 font-mono">DEFINING VS NON-DEFINING</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Kaidah Koma &amp; Penggunaan <em>That</em></span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
        <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1">
            <div class="text-xs font-black text-emerald-300 uppercase tracking-wide">1. Defining (Tanpa Koma)</div>
            <code class="text-xs font-mono font-bold text-emerald-200 block bg-slate-950 p-2 rounded border border-emerald-500/40">
                Noun + [who / which / that] + V
            </code>
            <div class="text-xs text-white pt-1">
                Informasi penting esensial. Boleh menggunakan <strong>that</strong>.
            </div>
        </div>

        <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1">
            <div class="text-xs font-black text-rose-300 uppercase tracking-wide">2. Non-Defining (Wajib Koma)</div>
            <code class="text-xs font-mono font-bold text-rose-200 block bg-slate-950 p-2 rounded border border-rose-500/40">
                Specific Noun, + [who / which] + V, + ...
            </code>
            <div class="text-xs text-white pt-1">
                Informasi tambahan. <strong class="text-amber-300">[DILARANG MENGGUNAKAN 'THAT']</strong>
            </div>
        </div>
    </div>
</div>
HTML,
                'rules' => [
                    'Non-Defining Clause memberikan informasi opsional; hapus klausanya dan kalimat utama tetap memiliki makna lengkap yang jelas.',
                    'Tanda koma WAJIB mengapit Non-Defining Clause (koma sebelum relative pronoun dan koma setelah akhir klausa jika di tengah kalimat).',
                    'Kata \'that\' TIDAK PERNAH digunakan dalam Non-Defining Clause setelah tanda koma (contoh salah: *The Amazon rainforest, that covers millions of hectares,...*).',
                    'Defining Clause tidak menggunakan koma karena informasinya penting untuk mempersempit identitas subjek.',
                ],
                'exercises' => [
                    [
                        'id' => 21,
                        'id_sentence' => 'Hutan hujan Amazon, yang mencakup jutaan kilometer persegi di Amerika Selatan, menghasilkan persentase oksigen global yang signifikan.',
                        'target_word' => 'The Amazon rainforest, which spans millions of square kilometers across South America, generates a significant percentage (Non-defining: , which..., )',
                        'vocab' => [
                            ['en' => 'the Amazon rainforest, which spans millions of square kilometers across South America', 'id' => 'hutan hujan Amazon, yang membentang jutaan kilometer persegi di Amerika Selatan'],
                            ['en' => 'generates a significant percentage of global oxygen', 'id' => 'menghasilkan persentase oksigen global yang signifikan'],
                        ],
                        'options' => [
                            'The Amazon rainforest, which spans millions of square kilometers across South America, generates a significant percentage of global oxygen.',
                            'The Amazon rainforest, that spans millions of square kilometers across South America, generates a significant percentage of global oxygen.',
                            'The Amazon rainforest which spans millions of square kilometers across South America generates a significant percentage of global oxygen.',
                            'The Amazon rainforest, which spans millions of square kilometers across South America generates a significant percentage of global oxygen.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The Amazon rainforest\' adalah nama geografis unik spesifik (sudah jelas identitasnya), sehingga klausanya adalah non-defining (wajib diapit dua koma dan memakai \'which\', tidak boleh \'that\').',
                    ],
                    [
                        'id' => 22,
                        'id_sentence' => 'Sampel air yang mengandung konsentrasi timbal melebihi lima bagian per miliar segera dibuang secara aman.',
                        'target_word' => 'Water samples that contain lead concentrations exceeding five parts per billion are promptly disposed of safely (Defining: that, no commas)',
                        'vocab' => [
                            ['en' => 'water samples that contain lead concentrations exceeding five parts per billion', 'id' => 'sampel air yang mengandung konsentrasi timbal melebihi lima bagian per miliar'],
                            ['en' => 'are promptly disposed of safely', 'id' => 'segera dibuang secara aman'],
                        ],
                        'options' => [
                            'Water samples that contain lead concentrations exceeding five parts per billion are promptly disposed of safely.',
                            'Water samples, that contain lead concentrations exceeding five parts per billion, are promptly disposed of safely.',
                            'Water samples, which contain lead concentrations exceeding five parts per billion, are promptly disposed of safely.',
                            'Water samples which contain lead concentrations exceeding five parts per billion, are promptly disposed of safely.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa ini mendefinisikan sampel air mana yang dibuang (hanya yang mengandung timbal di atas 5 ppb), bukan semua sampel air. Ini adalah defining clause, sehingga TIDAK boleh menggunakan tanda koma.',
                    ],
                    [
                        'id' => 23,
                        'id_sentence' => 'Albert Einstein, yang merumuskan teori relativitas umum pada awal abad kedua puluh, merevolusi fisika modern.',
                        'target_word' => 'Albert Einstein, who formulated the theory of general relativity in the early twentieth century, revolutionized modern physics (Non-defining: , who..., )',
                        'vocab' => [
                            ['en' => 'Albert Einstein, who formulated the theory of general relativity in the early twentieth century', 'id' => 'Albert Einstein, yang merumuskan teori relativitas umum pada awal abad kedua puluh'],
                            ['en' => 'revolutionized modern physics', 'id' => 'merevolusi fisika modern'],
                        ],
                        'options' => [
                            'Albert Einstein, who formulated the theory of general relativity in the early twentieth century, revolutionized modern physics.',
                            'Albert Einstein who formulated the theory of general relativity in the early twentieth century revolutionized modern physics.',
                            'Albert Einstein, that formulated the theory of general relativity in the early twentieth century, revolutionized modern physics.',
                            'Albert Einstein, who formulated the theory of general relativity in the early twentieth century revolutionized modern physics.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Albert Einstein\' adalah nama orang yang sudah pasti identitasnya (proper noun). Keterangan prestasinya adalah informasi tambahan (non-defining), sehingga wajib diapit dua koma dan memakai \'who\' (bukan \'that\').',
                    ],
                    [
                        'id' => 24,
                        'id_sentence' => 'Hanya perusahaan yang menerapkan standar audit keberlanjutan yang berhak menerima insentif pajak hijau dari kementerian.',
                        'target_word' => 'Only enterprises that implement sustainability auditing standards are eligible to receive green tax incentives from the ministry (Defining: that without commas)',
                        'vocab' => [
                            ['en' => 'only enterprises that implement sustainability auditing standards', 'id' => 'hanya perusahaan yang menerapkan standar audit keberlanjutan'],
                            ['en' => 'are eligible to receive green tax incentives from the ministry', 'id' => 'berhak menerima insentif pajak hijau dari kementerian'],
                        ],
                        'options' => [
                            'Only enterprises that implement sustainability auditing standards are eligible to receive green tax incentives from the ministry.',
                            'Only enterprises, that implement sustainability auditing standards, are eligible to receive green tax incentives from the ministry.',
                            'Only enterprises, which implement sustainability auditing standards, are eligible to receive green tax incentives from the ministry.',
                            'Only enterprises which implement sustainability auditing standards, are eligible to receive green tax incentives from the ministry.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata pembatas \'Only\' menegaskan bahwa klausa ini adalah defining clause esensial. Tidak boleh ada tanda koma yang memisahkannya.',
                    ],
                    [
                        'id' => 25,
                        'id_sentence' => 'Protokol Kyoto, yang diadopsi pada tahun 1997, mewajibkan negara-negara industri untuk mengurangi emisi gas rumah kaca.',
                        'target_word' => 'The Kyoto Protocol, which was adopted in 1997, committed industrialized nations to reducing greenhouse gas emissions (Non-defining: , which..., )',
                        'vocab' => [
                            ['en' => 'the Kyoto Protocol, which was adopted in 1997', 'id' => 'Protokol Kyoto, yang diadopsi pada tahun 1997'],
                            ['en' => 'committed industrialized nations to reducing greenhouse gas emissions', 'id' => 'mewajibkan negara terindustrialisasi untuk mengurangi emisi gas rumah kaca'],
                        ],
                        'options' => [
                            'The Kyoto Protocol, which was adopted in 1997, committed industrialized nations to reducing greenhouse gas emissions.',
                            'The Kyoto Protocol, that was adopted in 1997, committed industrialized nations to reducing greenhouse gas emissions.',
                            'The Kyoto Protocol which was adopted in 1997 committed industrialized nations to reducing greenhouse gas emissions.',
                            'The Kyoto Protocol, which was adopted in 1997 committed industrialized nations to reducing greenhouse gas emissions.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Sebagai nama dokumen traktat spesifik, \'The Kyoto Protocol\' diterangkan oleh non-defining clause yang diapit dua koma dengan kata hubung \'which\'.',
                    ],
                    [
                        'id' => 26,
                        'id_sentence' => 'Pasien yang menunjukkan gejala klinis sindrom pernapasan akut harus segera diisolasi di ruang bertekanan negatif.',
                        'target_word' => 'Patients who exhibit clinical symptoms of acute respiratory syndrome must be isolated immediately in negative-pressure rooms (Defining: who, no commas)',
                        'vocab' => [
                            ['en' => 'patients who exhibit clinical symptoms of acute respiratory syndrome', 'id' => 'pasien yang menunjukkan gejala klinis sindrom pernapasan akut'],
                            ['en' => 'must be isolated immediately in negative-pressure rooms', 'id' => 'harus segera diisolasi di ruang bertekanan negatif'],
                        ],
                        'options' => [
                            'Patients who exhibit clinical symptoms of acute respiratory syndrome must be isolated immediately in negative-pressure rooms.',
                            'Patients, who exhibit clinical symptoms of acute respiratory syndrome, must be isolated immediately in negative-pressure rooms.',
                            'Patients, that exhibit clinical symptoms of acute respiratory syndrome, must be isolated immediately in negative-pressure rooms.',
                            'Patients which exhibit clinical symptoms of acute respiratory syndrome must be isolated immediately in negative-pressure rooms.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Jika kita mengapit klausa ini dengan koma, artinya *semua* pasien harus diisolasi. Karena hanya pasien dengan gejala spesifik yang diisolasi, ini adalah defining clause tanpa koma.',
                    ],
                    [
                        'id' => 27,
                        'id_sentence' => 'Teleskop Luar Angkasa James Webb, yang diluncurkan pada Desember 2021, telah mentransmisikan citra inframerah terjauh dari alam semesta awal.',
                        'target_word' => 'The James Webb Space Telescope, which was launched in December 2021, has transmitted the deepest infrared images of the early universe (Non-defining: , which..., )',
                        'vocab' => [
                            ['en' => 'the James Webb Space Telescope, which was launched in December 2021', 'id' => 'Teleskop Luar Angkasa James Webb, yang diluncurkan pada Desember 2021'],
                            ['en' => 'has transmitted the deepest infrared images of the early universe', 'id' => 'telah mentransmisikan citra inframerah terdalam dari alam semesta awal'],
                        ],
                        'options' => [
                            'The James Webb Space Telescope, which was launched in December 2021, has transmitted the deepest infrared images of the early universe.',
                            'The James Webb Space Telescope, that was launched in December 2021, has transmitted the deepest infrared images of the early universe.',
                            'The James Webb Space Telescope which was launched in December 2021 has transmitted the deepest infrared images of the early universe.',
                            'The James Webb Space Telescope, which was launched in December 2021 has transmitted the deepest infrared images of the early universe.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Nama instrumen unik spesifik memerlukan non-defining relative clause berapit dua tanda koma (\'which was launched in December 2021,\').',
                    ],
                    [
                        'id' => 28,
                        'id_sentence' => 'Setiap dokumen hukum yang belum dilegalisasi oleh notaris publik akan ditolak oleh pihak imigrasi.',
                        'target_word' => 'Any legal document that has not been notarized by a public notary will be rejected by immigration authorities (Defining: that without commas)',
                        'vocab' => [
                            ['en' => 'any legal document that has not been notarized by a public notary', 'id' => 'setiap dokumen hukum yang belum dilegalisasi notaris publik'],
                            ['en' => 'will be rejected by immigration authorities', 'id' => 'akan ditolak oleh otoritas imigrasi'],
                        ],
                        'options' => [
                            'Any legal document that has not been notarized by a public notary will be rejected by immigration authorities.',
                            'Any legal document, that has not been notarized by a public notary, will be rejected by immigration authorities.',
                            'Any legal document, which has not been notarized by a public notary, will be rejected by immigration authorities.',
                            'Any legal document which has not been notarized by a public notary, will be rejected by immigration authorities.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Any legal document\' adalah kata benda umum tak tentu yang membutuhkan defining clause pembatas tanpa koma.',
                    ],
                    [
                        'id' => 29,
                        'id_sentence' => 'Kota Kopenhagen, yang bertujuan mencapai netralitas karbon penuh pada tahun 2025, telah menginvestasikan miliaran dolar dalam infrastruktur sepeda.',
                        'target_word' => 'The city of Copenhagen, which aims to achieve full carbon neutrality by 2025, has invested billions of dollars in cycling infrastructure (Non-defining: , which..., )',
                        'vocab' => [
                            ['en' => 'the city of Copenhagen, which aims to achieve full carbon neutrality by 2025', 'id' => 'kota Kopenhagen, yang bertujuan mencapai netralitas karbon penuh pada 2025'],
                            ['en' => 'has invested billions of dollars in cycling infrastructure', 'id' => 'telah menginvestasikan miliaran dolar dalam infrastruktur sepeda'],
                        ],
                        'options' => [
                            'The city of Copenhagen, which aims to achieve full carbon neutrality by 2025, has invested billions of dollars in cycling infrastructure.',
                            'The city of Copenhagen, that aims to achieve full carbon neutrality by 2025, has invested billions of dollars in cycling infrastructure.',
                            'The city of Copenhagen which aims to achieve full carbon neutrality by 2025 has invested billions of dollars in cycling infrastructure.',
                            'The city of Copenhagen, which aims to achieve full carbon neutrality by 2025 has invested billions of dollars in cycling infrastructure.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Nama kota adalah entitas spesifik yang diterangkan oleh non-defining clause (wajib diapit koma, menggunakan \'which\', bukan \'that\').',
                    ],
                    [
                        'id' => 30,
                        'id_sentence' => 'Teori ilmiah yang tidak dapat diuji secara empiris melalui observasi berulang tidak dapat dianggap sebagai sains yang valid.',
                        'target_word' => 'A scientific theory that cannot be empirically tested through repeatable observations cannot be regarded as valid science (Defining: that, no commas)',
                        'vocab' => [
                            ['en' => 'a scientific theory that cannot be empirically tested through repeatable observations', 'id' => 'teori ilmiah yang tidak dapat diuji secara empiris melalui observasi berulang'],
                            ['en' => 'cannot be regarded as valid science', 'id' => 'tidak dapat dianggap sebagai sains yang valid'],
                        ],
                        'options' => [
                            'A scientific theory that cannot be empirically tested through repeatable observations cannot be regarded as valid science.',
                            'A scientific theory, that cannot be empirically tested through repeatable observations, cannot be regarded as valid science.',
                            'A scientific theory, which cannot be empirically tested through repeatable observations, cannot be regarded as valid science.',
                            'A scientific theory which cannot be empirically tested through repeatable observations, cannot be regarded as valid science.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Klausa relatif ini membatasi kategori teori mana yang dimaksud (definisi esensial), sehingga tidak boleh menggunakan tanda koma pemisah.',
                    ],
                ]
            ],
            [
                'id' => 'relative-adverbs-where-when',
                'name' => '3.2.4 Relative Adverbs of Place & Time (Where, When, In Which, At Which)',
                'code' => '3.2.4',
                'concept_title' => 'Adverbia Relatif Tempat & Waktu (Where, When, In Which, At Which)',
                'concept_description' => 'Klausa relatif tempat dan waktu dapat dibentuk menggunakan kata keterangan relatif (relative adverbs): \'where\' (merujuk pada lokasi fisik atau metaforis) dan \'when\' (merujuk pada titik atau periode waktu). Dalam penulisan akademik berlaras tinggi, \'where\' sering kali dapat digantikan oleh konstruksi formal \'in which\', \'at which\', atau \'through which\' untuk menghindari kerancuan antara lokasi fisik murni dan konteks abstrak.',
                'description' => 'Klausa relatif tempat dan waktu dapat dibentuk menggunakan kata keterangan relatif (relative adverbs): \'where\' (merujuk pada lokasi fisik atau metaforis) dan \'when\' (merujuk pada titik atau periode waktu). Dalam penulisan akademik berlaras tinggi, \'where\' sering kali dapat digantikan oleh konstruksi formal \'in which\', \'at which\', atau \'through which\' untuk menghindari kerancuan antara lokasi fisik murni dan konteks abstrak.',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-emerald-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-emerald-500/25 text-emerald-300 border border-emerald-500/50 font-mono">RELATIVE ADVERBS</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Where (Tempat) &amp; When (Waktu)</span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
        <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1">
            <div class="text-xs font-black text-emerald-300 uppercase tracking-wide">Tempat: Where / In which</div>
            <code class="text-xs font-mono font-bold text-emerald-200 block bg-slate-950 p-2 rounded border border-emerald-500/40">
                Noun (Place) + WHERE + S + V
            </code>
            <div class="text-xs text-white pt-1 font-mono italic">
                the lab where scientists run trials
            </div>
        </div>

        <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1">
            <div class="text-xs font-black text-sky-300 uppercase tracking-wide">Waktu: When / During which</div>
            <code class="text-xs font-mono font-bold text-sky-200 block bg-slate-950 p-2 rounded border border-sky-500/40">
                Noun (Time) + WHEN + S + V
            </code>
            <div class="text-xs text-white pt-1 font-mono italic">
                the decade when technology exploded
            </div>
        </div>
    </div>
</div>
HTML,
                'rules' => [
                    'Gunakan \'where\' HANYA jika kata benda pendahulu menyatakan lokasi tempat sesuatu terjadi (memiliki makna \'in that place\').',
                    'Jangan gunakan \'where\' jika kata benda tempat tersebut bertindak sebagai subjek atau objek langsung dari kata kerja (gunakan \'which\' atau \'that\'; contoh: *The laboratory which we visited* - BUKAN *where we visited*).',
                    '\'In which\' adalah padanan register formal untuk \'where\' dalam konteks akademis (misalnya: *the framework in which decisions are made*).',
                    '\'When\' digunakan untuk merujuk pada waktu, dan setara dengan \'during which\' atau \'at which\'.',
                ],
                'exercises' => [
                    [
                        'id' => 31,
                        'id_sentence' => 'Laboratorium tempat para ilmuwan menguji senyawa antivirus baru tersebut dilengkapi dengan biosafety level empat.',
                        'target_word' => 'The laboratory where the scientists tested the new antiviral compound is equipped with biosafety level four containment (Laboratory + where + S + V)',
                        'vocab' => [
                            ['en' => 'the laboratory where the scientists tested the new antiviral compound', 'id' => 'laboratorium tempat para ilmuwan menguji senyawa antivirus baru'],
                            ['en' => 'is equipped with biosafety level four containment', 'id' => 'dilengkapi dengan penahanan biosafety level empat'],
                        ],
                        'options' => [
                            'The laboratory where the scientists tested the new antiviral compound is equipped with biosafety level four containment.',
                            'The laboratory which the scientists tested the new antiviral compound is equipped with biosafety level four containment.',
                            'The laboratory that the scientists tested the new antiviral compound is equipped with biosafety level four containment.',
                            'The laboratory where that the scientists tested the new antiviral compound is equipped with biosafety level four containment.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The laboratory\' adalah tempat terjadinya pengujian (\'in that laboratory\'), sehingga kata hubung relatif yang tepat adalah \'where\' (atau \'in which\').',
                    ],
                    [
                        'id' => 32,
                        'id_sentence' => 'Tahun 2020 adalah periode ketika pandemi global melumpuhkan rantai pasokan manufaktur internasional.',
                        'target_word' => 'The year 2020 was a period when the global pandemic paralyzed international manufacturing supply chains (period + when + S + V)',
                        'vocab' => [
                            ['en' => 'the year 2020 was a period when the global pandemic paralyzed international manufacturing supply chains', 'id' => 'tahun 2020 adalah periode ketika pandemi global melumpuhkan rantai pasok manufaktur internasional'],
                        ],
                        'options' => [
                            'The year 2020 was a period when the global pandemic paralyzed international manufacturing supply chains.',
                            'The year 2020 was a period where the global pandemic paralyzed international manufacturing supply chains.',
                            'The year 2020 was a period which the global pandemic paralyzed international manufacturing supply chains.',
                            'The year 2020 was a period that the global pandemic paralyzed international manufacturing supply chains.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Period\' merujuk pada waktu kronologis, sehingga relative adverb yang tepat adalah \'when\' (bukan \'where\').',
                    ],
                    [
                        'id' => 33,
                        'id_sentence' => 'Rumah sakit yang dikunjungi oleh delegasi menteri kesehatan kemarin memiliki unit gawat darurat tercanggih di kawasan ini.',
                        'target_word' => 'The hospital which the health ministerial delegation visited yesterday possesses the most advanced emergency department in the region (Hospital + which + S + visited)',
                        'vocab' => [
                            ['en' => 'the hospital which the health ministerial delegation visited yesterday', 'id' => 'rumah sakit yang dikunjungi oleh delegasi menteri kesehatan kemarin'],
                            ['en' => 'possesses the most advanced emergency department in the region', 'id' => 'memiliki unit gawat darurat paling mutakhir di kawasan ini'],
                        ],
                        'options' => [
                            'The hospital which the health ministerial delegation visited yesterday possesses the most advanced emergency department in the region.',
                            'The hospital where the health ministerial delegation visited yesterday possesses the most advanced emergency department in the region.',
                            'The hospital in which the health ministerial delegation visited yesterday possesses the most advanced emergency department in the region.',
                            'The hospital where that the health ministerial delegation visited yesterday possesses the most advanced emergency department in the region.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The hospital\' di sini adalah objek penderita langsung dari kata kerja transitif \'visited\' (\'they visited the hospital\', BUKAN \'they visited in the hospital\'). Oleh karena itu, wajib menggunakan \'which\' atau \'that\', bukan \'where\'.',
                    ],
                    [
                        'id' => 34,
                        'id_sentence' => 'Lingkungan digital tempat anak-anak berinteraksi setiap hari harus dilindungi dari paparan algoritma manipulatif.',
                        'target_word' => 'The digital environment in which children interact daily must be shielded from predatory algorithmic exposure (environment + in which + S + V)',
                        'vocab' => [
                            ['en' => 'the digital environment in which children interact daily', 'id' => 'lingkungan digital tempat anak-anak berinteraksi setiap hari'],
                            ['en' => 'must be shielded from predatory algorithmic exposure', 'id' => 'harus dilindungi dari paparan algoritma manipulatif'],
                        ],
                        'options' => [
                            'The digital environment in which children interact daily must be shielded from predatory algorithmic exposure.',
                            'The digital environment which children interact daily must be shielded from predatory algorithmic exposure.',
                            'The digital environment that children interact daily must be shielded from predatory algorithmic exposure.',
                            'The digital environment where in children interact daily must be shielded from predatory algorithmic exposure.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Frasa \'in which\' secara formal dan tepat menggantikan \'where\' untuk lingkungan/konteks abstrak (\'interact in that environment\').',
                    ],
                    [
                        'id' => 35,
                        'id_sentence' => 'Ada saat-saat kritis ketika keputusan klinis harus dibuat dalam hitungan detik untuk menyelamatkan nyawa pasien.',
                        'target_word' => 'There are critical moments when clinical decisions must be executed within seconds to preserve patient viability (moments + when + S + V)',
                        'vocab' => [
                            ['en' => 'there are critical moments when clinical decisions must be executed within seconds', 'id' => 'ada saat-saat kritis ketika keputusan klinis harus dieksekusi dalam hitungan detik'],
                            ['en' => 'to preserve patient viability', 'id' => 'untuk mempertahankan kelangsungan hidup pasien'],
                        ],
                        'options' => [
                            'There are critical moments when clinical decisions must be executed within seconds to preserve patient viability.',
                            'There are critical moments where clinical decisions must be executed within seconds to preserve patient viability.',
                            'There are critical moments which clinical decisions must be executed within seconds to preserve patient viability.',
                            'There are critical moments that clinical decisions must be executed within seconds to preserve patient viability.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Critical moments\' adalah anteseden penanda waktu, sehingga membutuhkan kata hubung \'when\'.',
                    ],
                    [
                        'id' => 36,
                        'id_sentence' => 'Ekosistem terumbu karang tempat ikan-ikan karang berkembang biak terancam parah oleh kenaikan suhu laut.',
                        'target_word' => 'Coral reef ecosystems where pelagic fish spawn are severely threatened by rising oceanic temperatures (ecosystems + where + S + V)',
                        'vocab' => [
                            ['en' => 'coral reef ecosystems where pelagic fish spawn', 'id' => 'ekosistem terumbu karang tempat ikan pelagis memijah'],
                            ['en' => 'are severely threatened by rising oceanic temperatures', 'id' => 'terancam parah oleh kenaikan suhu laut'],
                        ],
                        'options' => [
                            'Coral reef ecosystems where pelagic fish spawn are severely threatened by rising oceanic temperatures.',
                            'Coral reef ecosystems which pelagic fish spawn are severely threatened by rising oceanic temperatures.',
                            'Coral reef ecosystems that pelagic fish spawn are severely threatened by rising oceanic temperatures.',
                            'Coral reef ecosystems where that pelagic fish spawn are severely threatened by rising oceanic temperatures.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Coral reef ecosystems\' berfungsi sebagai habitat spasial tempat ikan memijah (\'spawn in these ecosystems\'), sehingga memerlukan relative adverb \'where\'.',
                    ],
                    [
                        'id' => 37,
                        'id_sentence' => 'Dekade terakhir adalah masa ketika teknologi energi terbarukan mencapai paritas biaya dengan bahan bakar fosil.',
                        'target_word' => 'The past decade was a period during which renewable energy technologies achieved cost parity with fossil fuels (period + during which + S + V)',
                        'vocab' => [
                            ['en' => 'the past decade was a period during which renewable energy technologies achieved cost parity', 'id' => 'dekade lalu adalah periode di mana teknologi energi terbarukan mencapai paritas biaya'],
                            ['en' => 'with fossil fuels', 'id' => 'dengan bahan bakar fosil'],
                        ],
                        'options' => [
                            'The past decade was a period during which renewable energy technologies achieved cost parity with fossil fuels.',
                            'The past decade was a period where renewable energy technologies achieved cost parity with fossil fuels.',
                            'The past decade was a period which renewable energy technologies achieved cost parity with fossil fuels.',
                            'The past decade was a period that renewable energy technologies achieved cost parity with fossil fuels.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'During which\' adalah bentuk preposisional berlaras tinggi yang setara dengan \'when\' untuk merujuk pada rentang waktu sepuluh tahun (\'during that decade\').',
                    ],
                    [
                        'id' => 38,
                        'id_sentence' => 'Kawasan industri tempat pabrik baterai tersebut dibangun menerima subsidi infrastruktur dari pemerintah pusat.',
                        'target_word' => 'The industrial park where the battery manufacturing facility was erected received municipal infrastructure subsidies (park + where + S + V)',
                        'vocab' => [
                            ['en' => 'the industrial park where the battery manufacturing facility was erected', 'id' => 'kawasan industri tempat fasilitas manufaktur baterai didirikan'],
                            ['en' => 'received municipal infrastructure subsidies', 'id' => 'menerima subsidi infrastruktur kota'],
                        ],
                        'options' => [
                            'The industrial park where the battery manufacturing facility was erected received municipal infrastructure subsidies.',
                            'The industrial park which the battery manufacturing facility was erected received municipal infrastructure subsidies.',
                            'The industrial park that the battery manufacturing facility was erected received municipal infrastructure subsidies.',
                            'The industrial park where that the battery manufacturing facility was erected received municipal infrastructure subsidies.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The industrial park\' adalah lokasi fisik terjadinya pendirian pabrik, membutuhkan \'where\'.',
                    ],
                    [
                        'id' => 39,
                        'id_sentence' => 'Fasilitas riset nuklir yang kita survei bulan lalu telah memperoleh lisensi operasi penuh.',
                        'target_word' => 'The nuclear research facility that we surveyed last month has obtained its full operating license (Facility + that + we surveyed)',
                        'vocab' => [
                            ['en' => 'the nuclear research facility that we surveyed last month', 'id' => 'fasilitas riset nuklir yang kita survei bulan lalu'],
                            ['en' => 'has obtained its full operating license', 'id' => 'telah memperoleh lisensi operasi penuh'],
                        ],
                        'options' => [
                            'The nuclear research facility that we surveyed last month has obtained its full operating license.',
                            'The nuclear research facility where we surveyed last month has obtained its full operating license.',
                            'The nuclear research facility in which we surveyed last month has obtained its full operating license.',
                            'The nuclear research facility where that we surveyed last month has obtained its full operating license.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Facility\' adalah objek langsung dari kata kerja \'surveyed\' (\'we surveyed the facility\'), sehingga harus menggunakan \'that\' atau \'which\', BUKAN \'where\'.',
                    ],
                    [
                        'id' => 40,
                        'id_sentence' => 'Titik dalam kurva reaksi di mana konversi reaktan mencapai ekuilibrium disebut sebagai titik jenuh.',
                        'target_word' => 'The point in the reaction curve at which reactant conversion reaches equilibrium is designated as the saturation threshold (point + at which + S + V)',
                        'vocab' => [
                            ['en' => 'the point in the reaction curve at which reactant conversion reaches equilibrium', 'id' => 'titik dalam kurva reaksi di mana konversi reaktan mencapai kesetimbangan'],
                            ['en' => 'is designated as the saturation threshold', 'id' => 'ditetapkan sebagai ambang batas kejenuhan'],
                        ],
                        'options' => [
                            'The point in the reaction curve at which reactant conversion reaches equilibrium is designated as the saturation threshold.',
                            'The point in the reaction curve which reactant conversion reaches equilibrium is designated as the saturation threshold.',
                            'The point in the reaction curve that reactant conversion reaches equilibrium is designated as the saturation threshold.',
                            'The point in the reaction curve where in reactant conversion reaches equilibrium is designated as the saturation threshold.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Frasa \'point\' berpasangan dengan preposisi \'at\', sehingga bentuk relatif formalnya adalah \'at which\'.',
                    ],
                ]
            ],
            [
                'id' => 'preposition-plus-relative-pronoun',
                'name' => '3.2.5 Preposition + Relative Pronoun (To Whom, In Which, Under Which, By Means Of Which)',
                'code' => '3.2.5',
                'concept_title' => 'Preposisi Terikat + Pronomina Relatif (Pied-Piping Architecture)',
                'concept_description' => 'Dalam penulisan esai formal dan jurnal internasional (IELTS Band 8-9), membiarkan preposisi tergantung di akhir kalimat (preposition stranding, misal: *the policy which we agreed on*) dipandang kurang formal. Konstruksi elegan menempatkan preposisi tepat di depan pronomina relatif: \'in which\', \'to whom\', \'for which\', \'under which\', \'by means of which\', atau \'through which\'. Kaidah mutlak: kata \'that\' dan \'who\' TIDAK PERNAH boleh diletakkan langsung setelah preposisi (hanya \'which\' dan \'whom\' yang sah).',
                'description' => 'Dalam penulisan esai formal dan jurnal internasional (IELTS Band 8-9), membiarkan preposisi tergantung di akhir kalimat (preposition stranding, misal: *the policy which we agreed on*) dipandang kurang formal. Konstruksi elegan menempatkan preposisi tepat di depan pronomina relatif: \'in which\', \'to whom\', \'for which\', \'under which\', \'by means of which\', atau \'through which\'. Kaidah mutlak: kata \'that\' dan \'who\' TIDAK PERNAH boleh diletakkan langsung setelah preposisi (hanya \'which\' dan \'whom\' yang sah).',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-purple-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-purple-500/25 text-purple-300 border border-purple-500/50 font-mono">PREPOSITION + RELATIVE PRONOUN</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Preposisi di Depan Klausa (Formal Academic Prose)</span>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3 border border-slate-600 space-y-1.5">
        <div class="flex items-center justify-between gap-2 flex-wrap">
            <span class="text-xs font-black text-purple-300 uppercase tracking-wide flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-purple-400"></span> Pola Formal
            </span>
            <code class="text-xs font-mono font-bold text-purple-300 bg-slate-950 px-2.5 py-1 rounded border border-purple-500/40">Noun + [Preposition] + [which / whom] + S + V</code>
        </div>
        <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
            <span class="text-purple-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">The framework on which this research is built remains robust.</span>
        </div>
        <div class="text-xs text-white pl-3 border-l-2 border-amber-400">
            <span class="text-emerald-300 font-bold">✓ Benar:</span> <em>on which</em> &nbsp;|&nbsp; <span class="text-rose-300 font-bold">✗ Salah:</span> <span class="line-through">on that</span> ('that' tidak boleh didahului preposisi!)
        </div>
    </div>
</div>
HTML,
                'rules' => [
                    'Gunakan \'Preposition + whom\' untuk manusia (contoh: *the ambassador to whom the letter was addressed*). Jangan pernah memakai *to who* atau *to that*.',
                    'Gunakan \'Preposition + which\' untuk benda atau konsep (contoh: *the framework under which regulations apply*). Jangan pernah memakai *under that*.',
                    'Pilih preposisi yang sesuai dengan kata kerja, kata sifat, atau kata benda pembentuknya (contoh: depend ON -> *upon which*, contribute TO -> *to which*).',
                    'Konstruksi ini tidak menggunakan tanda koma jika berfungsi sebagai defining clause.',
                ],
                'exercises' => [
                    [
                        'id' => 41,
                        'id_sentence' => 'Kerangka regulasi di bawah naungan mana uji klinis tersebut dilakukan mematuhi deklarasi etika medis internasional.',
                        'target_word' => 'The regulatory framework under which the clinical trial was conducted adheres to the international medical ethics declaration (under which + Passive Clause)',
                        'vocab' => [
                            ['en' => 'the regulatory framework under which the clinical trial was conducted', 'id' => 'kerangka regulasi di bawah naungan mana uji klinis dilakukan'],
                            ['en' => 'adheres to the international medical ethics declaration', 'id' => 'mematuhi deklarasi etika medis internasional'],
                        ],
                        'options' => [
                            'The regulatory framework under which the clinical trial was conducted adheres to the international medical ethics declaration.',
                            'The regulatory framework under that the clinical trial was conducted adheres to the international medical ethics declaration.',
                            'The regulatory framework which the clinical trial was conducted adheres to the international medical ethics declaration.',
                            'The regulatory framework under where the clinical trial was conducted adheres to the international medical ethics declaration.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Preposisi \'under\' harus dipasangkan dengan \'which\' (\'under which\'). Bentuk *under that* atau *under where* adalah salah gramatikal.',
                    ],
                    [
                        'id' => 42,
                        'id_sentence' => 'Duta besar kepada siapa surat resmi permohonan ekstradisi diserahkan berjanji akan memprosesnya secepat mungkin.',
                        'target_word' => 'The ambassador to whom the formal extradition request was submitted promised to expedite the review process (to whom + Passive Clause)',
                        'vocab' => [
                            ['en' => 'the ambassador to whom the formal extradition request was submitted', 'id' => 'duta besar kepada siapa permintaan ekstradisi resmi diajukan'],
                            ['en' => 'promised to expedite the review process', 'id' => 'berjanji untuk mempercepat proses peninjauan'],
                        ],
                        'options' => [
                            'The ambassador to whom the formal extradition request was submitted promised to expedite the review process.',
                            'The ambassador to who the formal extradition request was submitted promised to expedite the review process.',
                            'The ambassador to that the formal extradition request was submitted promised to expedite the review process.',
                            'The ambassador who the formal extradition request was submitted promised to expedite the review process.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Setelah preposisi \'to\', rujukan manusia wajib menggunakan bentuk objek \'whom\' (\'to whom\'). *To who* atau *to that* melanggar kaidah gramatikal baku.',
                    ],
                    [
                        'id' => 43,
                        'id_sentence' => 'Mekanisme biologis melalui mana sel kanker mengembangkan resistensi obat masih menjadi subjek penelitian intensif.',
                        'target_word' => 'The biological mechanism through which malignant cells develop drug resistance remains the subject of intensive investigation (through which + S + V)',
                        'vocab' => [
                            ['en' => 'the biological mechanism through which malignant cells develop drug resistance', 'id' => 'mekanisme biologis melalui mana sel ganas mengembangkan resistensi obat'],
                            ['en' => 'remains the subject of intensive investigation', 'id' => 'tetap menjadi subjek investigasi intensif'],
                        ],
                        'options' => [
                            'The biological mechanism through which malignant cells develop drug resistance remains the subject of intensive investigation.',
                            'The biological mechanism through that malignant cells develop drug resistance remains the subject of intensive investigation.',
                            'The biological mechanism which malignant cells develop drug resistance remains the subject of intensive investigation.',
                            'The biological mechanism through where malignant cells develop drug resistance remains the subject of intensive investigation.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Through which\' menerangkan saluran/cara terjadinya resistensi. Preposisi tidak pernah boleh mendahului \'that\'.',
                    ],
                    [
                        'id' => 44,
                        'id_sentence' => 'Prinsip-prinsip etika yang di atasnya tata kelola korporasi dibangun harus dihormati oleh seluruh jajaran manajemen.',
                        'target_word' => 'The ethical principles upon which good corporate governance is established must be upheld by all tiers of leadership (upon which + Passive Clause)',
                        'vocab' => [
                            ['en' => 'the ethical principles upon which good corporate governance is established', 'id' => 'prinsip etika yang di atasnya tata kelola korporasi yang baik dibangun'],
                            ['en' => 'must be upheld by all tiers of leadership', 'id' => 'harus ditegakkan oleh seluruh tingkatan kepemimpinan'],
                        ],
                        'options' => [
                            'The ethical principles upon which good corporate governance is established must be upheld by all tiers of leadership.',
                            'The ethical principles upon that good corporate governance is established must be upheld by all tiers of leadership.',
                            'The ethical principles which good corporate governance is established must be upheld by all tiers of leadership.',
                            'The ethical principles upon where good corporate governance is established must be upheld by all tiers of leadership.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Frasa \'established upon\' dipindahkan ke depan klausa relatif menjadi \'upon which\' dalam register formal tinggi.',
                    ],
                    [
                        'id' => 45,
                        'id_sentence' => 'Instrumen keuangan dengan sarana mana risiko volatilitas mata uang dilindung nilai dikenal sebagai kontrak berjangka valuta asing.',
                        'target_word' => 'The financial instrument by means of which foreign exchange volatility is hedged is termed a forward currency contract (by means of which + S + V)',
                        'vocab' => [
                            ['en' => 'the financial instrument by means of which foreign exchange volatility is hedged', 'id' => 'instrumen keuangan dengan sarana mana volatilitas valuta asing dilindung nilai'],
                            ['en' => 'is termed a forward currency contract', 'id' => 'disebut sebagai kontrak valuta forward'],
                        ],
                        'options' => [
                            'The financial instrument by means of which foreign exchange volatility is hedged is termed a forward currency contract.',
                            'The financial instrument by means of that foreign exchange volatility is hedged is termed a forward currency contract.',
                            'The financial instrument which foreign exchange volatility is hedged is termed a forward currency contract.',
                            'The financial instrument by means which foreign exchange volatility is hedged is termed a forward currency contract.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'By means of which\' adalah konstruksi preposisi majemuk berlaras tinggi yang diikuti klausa pasif.',
                    ],
                    [
                        'id' => 46,
                        'id_sentence' => 'Para saksi mata dari siapa keterangan forensik diperoleh telah ditempatkan di bawah perlindungan kepolisian federal.',
                        'target_word' => 'The key witnesses from whom forensic testimony was obtained have been placed under federal protective custody (from whom + Passive Clause)',
                        'vocab' => [
                            ['en' => 'the key witnesses from whom forensic testimony was obtained', 'id' => 'saksi kunci dari siapa kesaksian forensik diperoleh'],
                            ['en' => 'have been placed under federal protective custody', 'id' => 'telah ditempatkan di bawah tahanan perlindungan federal'],
                        ],
                        'options' => [
                            'The key witnesses from whom forensic testimony was obtained have been placed under federal protective custody.',
                            'The key witnesses from who forensic testimony was obtained have been placed under federal protective custody.',
                            'The key witnesses from that forensic testimony was obtained have been placed under federal protective custody.',
                            'The key witnesses whom forensic testimony was obtained have been placed under federal protective custody.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Preposisi \'from\' dipasangkan dengan rujukan manusia \'whom\' (\'from whom\').',
                    ],
                    [
                        'id' => 47,
                        'id_sentence' => 'Tingkat suku bunga pada besaran mana pinjaman antarbank ditransaksikan dipantau secara ketat oleh dewan moneter.',
                        'target_word' => 'The interest rate at which interbank lending is transacted is closely monitored by the monetary board (at which + Passive Clause)',
                        'vocab' => [
                            ['en' => 'the interest rate at which interbank lending is transacted', 'id' => 'suku bunga pada besaran mana pinjaman antarbank ditransaksikan'],
                            ['en' => 'is closely monitored by the monetary board', 'id' => 'dipantau secara ketat oleh dewan moneter'],
                        ],
                        'options' => [
                            'The interest rate at which interbank lending is transacted is closely monitored by the monetary board.',
                            'The interest rate at that interbank lending is transacted is closely monitored by the monetary board.',
                            'The interest rate which interbank lending is transacted is closely monitored by the monetary board.',
                            'The interest rate at where interbank lending is transacted is closely monitored by the monetary board.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata \'rate\' (tarif/suku bunga) selalu berpasangan dengan preposisi \'at\', membentuk \'at which\'.',
                    ],
                    [
                        'id' => 48,
                        'id_sentence' => 'Kondisi batas di mana persamaan diferensial tersebut berlaku telah diverifikasi melalui simulasi numerik.',
                        'target_word' => 'The boundary conditions under which the differential equation holds valid were verified via numerical simulation (under which + S + V)',
                        'vocab' => [
                            ['en' => 'the boundary conditions under which the differential equation holds valid', 'id' => 'kondisi batas di bawah mana persamaan diferensial bernilai valid'],
                            ['en' => 'were verified via numerical simulation', 'id' => 'diverifikasi melalui simulasi numerik'],
                        ],
                        'options' => [
                            'The boundary conditions under which the differential equation holds valid were verified via numerical simulation.',
                            'The boundary conditions under that the differential equation holds valid were verified via numerical simulation.',
                            'The boundary conditions which the differential equation holds valid were verified via numerical simulation.',
                            'The boundary conditions under where the differential equation holds valid were verified via numerical simulation.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Under which\' merujuk pada kondisi-kondisi batas yang melingkupi validitas formula.',
                    ],
                    [
                        'id' => 49,
                        'id_sentence' => 'Para akademisi senior terhadap kontribusi ilmiah siapa kita sangat berutang budi diabadikan dalam aula kehormatan universitas.',
                        'target_word' => 'The senior scholars to whose scholarly contributions we owe immense gratitude are commemorated in the university hall of fame (to whose + Noun)',
                        'vocab' => [
                            ['en' => 'the senior scholars to whose scholarly contributions we owe immense gratitude', 'id' => 'para sarjana senior terhadap kontribusi ilmiah siapa kita berutang rasa terima kasih besar'],
                            ['en' => 'are commemorated in the university hall of fame', 'id' => 'diabadikan dalam aula kehormatan universitas'],
                        ],
                        'options' => [
                            'The senior scholars to whose scholarly contributions we owe immense gratitude are commemorated in the university hall of fame.',
                            'The senior scholars to whom scholarly contributions we owe immense gratitude are commemorated in the university hall of fame.',
                            'The senior scholars to who\'s scholarly contributions we owe immense gratitude are commemorated in the university hall of fame.',
                            'The senior scholars to which scholarly contributions we owe immense gratitude are commemorated in the university hall of fame.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Preposisi \'to\' mendahului frasa kepemilikan \'whose scholarly contributions\' (\'owe gratitude to their contributions\').',
                    ],
                    [
                        'id' => 50,
                        'id_sentence' => 'Tingkat keparahan polusi udara sejauh mana kesehatan pernapasan terancam telah melampaui standar aman Organisasi Kesehatan Dunia.',
                        'target_word' => 'The extent of air pollution to which respiratory health is compromised has surpassed World Health Organization safe thresholds (to which + S + is compromised)',
                        'vocab' => [
                            ['en' => 'the extent of air pollution to which respiratory health is compromised', 'id' => 'tingkat polusi udara sejauh mana kesehatan pernapasan terganggu'],
                            ['en' => 'has surpassed World Health Organization safe thresholds', 'id' => 'telah melampaui ambang batas aman WHO'],
                        ],
                        'options' => [
                            'The extent of air pollution to which respiratory health is compromised has surpassed World Health Organization safe thresholds.',
                            'The extent of air pollution to that respiratory health is compromised has surpassed World Health Organization safe thresholds.',
                            'The extent of air pollution which respiratory health is compromised has surpassed World Health Organization safe thresholds.',
                            'The extent of air pollution at which respiratory health is compromised has surpassed World Health Organization safe thresholds.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Frasa \'the extent\' idiomatis berpasangan dengan preposisi \'to\' (\'to that extent\'), sehingga konstruksi relatifnya adalah \'to which\'.',
                    ],
                ]
            ],
        ];
    }
}
