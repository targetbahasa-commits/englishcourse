<?php

namespace App\Services;

class SelfStudySimplePresentNominalPassiveData
{
    /**
     * Get the complete Simple Present: Nominal, Passive, & Form Contrasts package.
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
            'banner_title' => 'Simple Present: Nominal, Passive, & Verbal vs Nominal vs Passive',
            'banner_subtitle' => 'Kuasai kalimat Nominal Simple Present, kalimat Pasif, serta perbedaan kalimat Verbal vs Nominal vs Passive untuk menulis dan berbicara bahasa Inggris dengan benar.',
            'banner_badge' => 'MODULE 1.3 NOMINAL & PASSIVE',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 1.3
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Tiga Pola Kalimat Simple Present',
            'concept_summary' => 'Setiap kalimat Simple Present Tense termasuk ke dalam salah satu dari tiga pola: (1) Kalimat Verbal (Subjek melakukan aksi: S + V1), (2) Kalimat Nominal (Subjek menyatakan status atau sifat: S + to be + Complement), dan (3) Kalimat Pasif (Subjek dikenai tindakan: S + to be + V3). Menguasai perbedaan ketiganya membantu menghindari kesalahan umum seperti double predicate ("is goes") dan kalimat pasif yang tidak lengkap ("food cooked").',
            'rules' => [
                [
                    'rule_title' => '1. Kalimat Nominal Simple Present (Status & Sifat)',
                    'rule_formula' => 'Subject + to be (am / is / are) + Complement (Noun Phrase / Adjective / Prepositional Phrase)',
                    'rule_description' => 'Digunakan saat kalimat TIDAK memiliki kata kerja aksi, melainkan menerangkan status atau sifat subjek. Subjek jamak (They, We, You, Plural Nouns) menggunakan ARE; subjek tunggal (He, She, It, Singular & Uncountable Nouns) menggunakan IS; subjek I menggunakan AM.',
                    'examples' => [
                        [
                            'en' => 'My mother is a kind teacher.',
                            'id' => 'Ibu saya adalah guru yang baik hati.',
                            'note' => 'Predikat adalah linking verb "is" diikuti Noun Phrase pelengkap.'
                        ],
                    ],
                ],
                [
                    'rule_title' => '2. Kalimat Nominal Negatif & Interogatif',
                    'rule_formula' => 'Negatif: Subject + am/is/are + not + Complement | Tanya: Is/Are + Subject + Complement?',
                    'rule_description' => 'Kalimat nominal TIDAK BOLEH menggunakan auxiliary do/does! Cukup sisipkan kata "not" tepat setelah to be untuk kalimat negatif, atau pindahkan to be ke awal kalimat untuk kalimat tanya.',
                    'examples' => [
                        [
                            'en' => 'This soup is not too spicy for the children.',
                            'id' => 'Sup ini tidak terlalu pedas untuk anak-anak.',
                            'note' => 'Gunakan "is not too spicy", BUKAN "do not spicy".'
                        ],
                    ],
                ],
                [
                    'rule_title' => '3. Kalimat Pasif Simple Present (Fokus pada Objek)',
                    'rule_formula' => 'Subject (Penerima Aksi) + to be (is / are) + Past Participle (Verb 3) (+ by Agent)',
                    'rule_description' => 'Digunakan ketika kita ingin menonjolkan apa yang terjadi pada sesuatu, bukan siapa yang melakukannya. Gunakan ARE + V3 untuk subjek jamak, dan IS + V3 untuk subjek tunggal/uncountable.',
                    'examples' => [
                        [
                            'en' => 'Fresh bread is baked every morning at that bakery.',
                            'id' => 'Roti segar dipanggang setiap pagi di toko roti itu.',
                            'note' => 'Subjek "bread" (tunggal) menerima tindakan "dipanggang", sehingga menggunakan "is baked".'
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Sub-lesson content for Topic 1.3 (8 parts, 10 exercises each)
     */
    public static function getSubLessons(): array
    {
        return [
            [
                'id' => 'nominal-plural',
                'name' => 'Simple Present Nominal: Subjek I, You, We, They & Benda Jamak (+ am/are)',
                'code' => '1.3.1',
                'concept_title' => 'Kalimat Nominal Simple Present dengan Subjek I, You, We, They, dan Plural Nouns',
                'concept_description' => 'Kalimat nominal menyatakan identitas, status, sifat, atau lokasi subjek tanpa kata kerja aksi. Untuk subjek jamak (They, We, You, Plural Nouns: my parents, the students, my friends), predikat wajib berupa to be \'are\' diikuti pelengkap (Complement: Noun Phrase, Adjective, atau Prepositional Phrase). Untuk subjek \'I\', gunakan to be \'am\'.',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-emerald-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-emerald-500/25 text-emerald-300 border border-emerald-500/50 font-mono tracking-wider">SIMPLE PRESENT NOMINAL</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Subjek I, You, We, They &amp; Benda Jamak (+ am/are)</span>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3.5 border border-slate-600 space-y-3">
        <!-- Pola 1: Khusus Subjek I -->
        <div class="space-y-1">
            <div class="flex items-center justify-between gap-2 flex-wrap">
                <span class="text-xs font-black text-sky-300 uppercase tracking-wide flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-sky-400"></span> [1] Khusus Subjek "I" (To Be: AM)
                </span>
            </div>
            <code class="text-xs sm:text-sm font-mono font-bold text-sky-300 bg-slate-950 px-3 py-1.5 rounded-lg border border-sky-500/40 block">I + AM + Complement (Noun / Adjective / Adverbial)</code>
            <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
                <span class="text-sky-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">I am confident with our preparation today.</span>
            </div>
            <div class="text-xs text-white pl-3 border-l-2 border-sky-400">
                (Saya percaya diri dengan persiapan kami hari ini.)
            </div>
        </div>

        <!-- Pola 2: Subjek You, We, They & Benda Jamak -->
        <div class="space-y-1 pt-2.5 border-t border-slate-700/60">
            <div class="flex items-center justify-between gap-2 flex-wrap">
                <span class="text-xs font-black text-emerald-300 uppercase tracking-wide flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span> [2] Subjek You, We, They &amp; Benda Jamak (To Be: ARE)
                </span>
            </div>
            <code class="text-xs sm:text-sm font-mono font-bold text-emerald-300 bg-slate-950 px-3 py-1.5 rounded-lg border border-emerald-500/40 block">S (You / We / They / Plural Nouns) + ARE + Complement</code>
            <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
                <span class="text-emerald-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">My two younger brothers are noisy every morning before leaving for school.</span>
            </div>
            <div class="text-xs text-white pl-3 border-l-2 border-emerald-400">
                (Kedua adik laki-laki saya sangat ribut setiap pagi sebelum berangkat sekolah.)
            </div>
        </div>
    </div>

    <!-- Kaidah Utama -->
    <div class="text-xs text-white pl-3 border-l-2 border-amber-400 bg-amber-950/40 p-2.5 rounded-r-lg">
        <strong class="text-amber-300 uppercase">[KAIDAH UTAMA]:</strong> Subjek <strong>I</strong> wajib berpasangan dengan <strong>am</strong>. Subjek <strong>You / We / They / Jamak</strong> wajib berpasangan dengan <strong>are</strong>. Jangan pernah menyisipkan kata kerja aksi dasar setelah to be (misal: <em>They are study</em> ➔ SALAH MUTLAK).
    </div>
</div>
HTML,
                'rules' => [
                    'Subjek jamak wajib menggunakan to be \'are\'.',
                    'Subjek \'I\' menggunakan to be \'am\'.',
                    'Dilarang memasukkan kata kerja aksi setelah to be (e.g., \'They are study\' adalah salah).',
                    'Kata sifat (Adjective) dan frasa kata benda (Noun Phrase) setelah to be berfungsi sebagai Subject Complement.',
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'id_sentence' => 'Kedua adik laki-laki saya sangat ribut setiap pagi sebelum berangkat sekolah.',
                        'target_word' => 'are (Linking Verb)',
                        'vocab' => [
                            'my two younger brothers' => [
                                'id' => 'kedua adik laki-laki saya',
                                'pos' => '(n phr)',
                            ],
                            'noisy' => [
                                'id' => 'ribut',
                                'pos' => '(adj)',
                            ],
                            'before leaving for school' => [
                                'id' => 'sebelum berangkat sekolah',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'My two younger brothers are noisy every morning before leaving for school.',
                            'My two younger brothers is noisy every morning before leaving for school.',
                            'My two younger brothers noisy every morning before leaving for school.',
                            'My two younger brothers are being noisy every morning before leaving for school.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'My two younger brothers\' adalah jamak (plural). Oleh karena itu, linking verb to be yang benar adalah \'are\', diikuti kata sifat pelengkap \'noisy\'.',
                    ],
                    [
                        'id' => 2,
                        'id_sentence' => 'Teman-teman sekelas saya sangat ramah kepada murid baru.',
                        'target_word' => 'are (Linking Verb)',
                        'vocab' => [
                            'my classmates' => [
                                'id' => 'teman-teman sekelas saya',
                                'pos' => '(n)',
                            ],
                            'friendly' => [
                                'id' => 'ramah',
                                'pos' => '(adj)',
                            ],
                            'new student' => [
                                'id' => 'murid baru',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'My classmates are very friendly to the new student.',
                            'My classmates is very friendly to the new student.',
                            'My classmates friendly to the new student.',
                            'My classmates are be very friendly to the new student.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjeknya adalah \'My classmates\' (jamak). Kalimat nominal yang menerangkan sifat subjek (\'friendly\' = Adjective) wajib menggunakan to be \'are\'.',
                    ],
                    [
                        'id' => 3,
                        'id_sentence' => 'Kami sangat bersemangat untuk acara piknik keluarga akhir pekan ini.',
                        'target_word' => 'are (Linking Verb)',
                        'vocab' => [
                            'we' => [
                                'id' => 'kami',
                                'pos' => '(pron)',
                            ],
                            'excited about' => [
                                'id' => 'bersemangat untuk',
                                'pos' => '(adj phr)',
                            ],
                            'family picnic' => [
                                'id' => 'piknik keluarga',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'We are very excited about this weekend\'s family picnic.',
                            'We is very excited about this weekend\'s family picnic.',
                            'We very excited about this weekend\'s family picnic.',
                            'We are be very excited about this weekend\'s family picnic.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'We\' selalu berpasangan dengan linking verb \'are\' sebelum komplemen kata sifat \'excited\'.',
                    ],
                    [
                        'id' => 4,
                        'id_sentence' => 'Pemain-pemain tim sepak bola sekolah kami bertanggung jawab atas peralatan latihan mereka sendiri.',
                        'target_word' => 'are (Linking Verb)',
                        'vocab' => [
                            'the players' => [
                                'id' => 'para pemain',
                                'pos' => '(n)',
                            ],
                            'responsible for' => [
                                'id' => 'bertanggung jawab atas',
                                'pos' => '(adj phr)',
                            ],
                            'training equipment' => [
                                'id' => 'peralatan latihan',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The players on our school football team are responsible for their own training equipment.',
                            'The players on our school football team is responsible for their own training equipment.',
                            'The players on our school football team responsible for their own training equipment.',
                            'The players on our school football team are being responsible for their own training equipment.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'The players\' adalah plural noun. Predikat nominal wajib menggunakan \'are responsible\'.',
                    ],
                    [
                        'id' => 5,
                        'id_sentence' => 'Saya yakin bahwa resep kue ini akan berhasil kalau kita mengikuti setiap langkahnya.',
                        'target_word' => 'am (Linking Verb)',
                        'vocab' => [
                            'I' => [
                                'id' => 'saya',
                                'pos' => '(pron)',
                            ],
                            'confident that' => [
                                'id' => 'yakin bahwa',
                                'pos' => '(adj)',
                            ],
                            'cake recipe' => [
                                'id' => 'resep kue',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'I am confident that this cake recipe will work if we follow every step.',
                            'I is confident that this cake recipe will work if we follow every step.',
                            'I are confident that this cake recipe will work if we follow every step.',
                            'I confident that this cake recipe will work if we follow every step.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek orang pertama tunggal \'I\' wajib menggunakan to be \'am\': \'I am confident\'.',
                    ],
                    [
                        'id' => 6,
                        'id_sentence' => 'Taman bermain dekat rumah kami sangat ramai setiap sore setelah sekolah.',
                        'target_word' => 'are (Linking Verb)',
                        'vocab' => [
                            'the playgrounds' => [
                                'id' => 'taman-taman bermain',
                                'pos' => '(n)',
                            ],
                            'crowded' => [
                                'id' => 'ramai',
                                'pos' => '(adj)',
                            ],
                            'every afternoon' => [
                                'id' => 'setiap sore',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'The playgrounds near our house are crowded every afternoon after school.',
                            'The playgrounds near our house is crowded every afternoon after school.',
                            'The playgrounds near our house crowded every afternoon after school.',
                            'The playgrounds near our house are be crowded every afternoon after school.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'The playgrounds\' menggunakan to be \'are\' diikuti kata sifat \'crowded\'.',
                    ],
                    [
                        'id' => 7,
                        'id_sentence' => 'Kedua novel itu sangat menarik dan cocok untuk tugas membaca liburan saya.',
                        'target_word' => 'are (Linking Verb)',
                        'vocab' => [
                            'the two novels' => [
                                'id' => 'kedua novel itu',
                                'pos' => '(n)',
                            ],
                            'interesting' => [
                                'id' => 'menarik',
                                'pos' => '(adj)',
                            ],
                            'holiday reading' => [
                                'id' => 'bacaan liburan',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The two novels are interesting and perfect for my holiday reading assignment.',
                            'The two novels is interesting and perfect for my holiday reading assignment.',
                            'The two novels interesting and perfect for my holiday reading assignment.',
                            'The two novels are be interesting and perfect for my holiday reading assignment.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'The two novels\' adalah jamak. To be yang tepat adalah \'are\'.',
                    ],
                    [
                        'id' => 8,
                        'id_sentence' => 'Tetangga-tetangga di sekitar rumah kami selalu ramah dan suka membantu.',
                        'target_word' => 'are (Linking Verb)',
                        'vocab' => [
                            'our neighbors' => [
                                'id' => 'tetangga-tetangga kami',
                                'pos' => '(n)',
                            ],
                            'friendly and helpful' => [
                                'id' => 'ramah dan suka membantu',
                                'pos' => '(adj phr)',
                            ],
                            'around our house' => [
                                'id' => 'di sekitar rumah kami',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'Our neighbors around the house are always friendly and helpful.',
                            'Our neighbors around the house is always friendly and helpful.',
                            'Our neighbors around the house always friendly and helpful.',
                            'Our neighbors around the house are be always friendly and helpful.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'Our neighbors\' berpasangan dengan \'are ... friendly\'.',
                    ],
                    [
                        'id' => 9,
                        'id_sentence' => 'Jadwal kereta dari stasiun kota tersedia di papan pengumuman dan aplikasi ponsel.',
                        'target_word' => 'are (Linking Verb)',
                        'vocab' => [
                            'the train schedules' => [
                                'id' => 'jadwal-jadwal kereta',
                                'pos' => '(n plural)',
                            ],
                            'available' => [
                                'id' => 'tersedia',
                                'pos' => '(adj)',
                            ],
                            'announcement board' => [
                                'id' => 'papan pengumuman',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The train schedules from the city station are available on the announcement board and the mobile app.',
                            'The train schedules from the city station is available on the announcement board and the mobile app.',
                            'The train schedules from the city station available on the announcement board and the mobile app.',
                            'The train schedules from the city station are be available on the announcement board and the mobile app.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Schedules\' adalah kata benda jamak, sehingga to be yang tepat adalah \'are available\'.',
                    ],
                    [
                        'id' => 10,
                        'id_sentence' => 'Kamu memenuhi syarat untuk mengikuti lomba renang tingkat sekolah tahun ini.',
                        'target_word' => 'are (Linking Verb)',
                        'vocab' => [
                            'you' => [
                                'id' => 'kamu',
                                'pos' => '(pron)',
                            ],
                            'eligible to join' => [
                                'id' => 'memenuhi syarat untuk mengikuti',
                                'pos' => '(adj phr)',
                            ],
                            'school swimming competition' => [
                                'id' => 'lomba renang tingkat sekolah',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'You are eligible to join this year\'s school swimming competition.',
                            'You is eligible to join this year\'s school swimming competition.',
                            'You eligible to join this year\'s school swimming competition.',
                            'You are be eligible to join this year\'s school swimming competition.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'You\' selalu menggunakan to be \'are\': \'You are eligible\'.',
                    ],
                ],
            ],
            [
                'id' => 'nominal-singular',
                'name' => 'Simple Present Nominal: Subjek He, She, It & Benda Tunggal/Uncountable (+ is)',
                'code' => '1.3.2',
                'concept_title' => 'Kalimat Nominal Simple Present dengan Subjek He, She, It, dan Uncountable Nouns',
                'concept_description' => 'Ketika subjek berupa orang ketiga tunggal (He, She, It), nama benda tunggal (a book, the kitchen), atau kata benda tak dapat dihitung (uncountable nouns: homework, rice, weather, music), to be yang digunakan mutlak \'is\'.',
                'formula' => 'Subject (He / She / It / Singular Noun / Uncountable Noun) + is + Complement (Noun / Adjective / Prepositional Phrase)',
                'rules' => [
                    'Subjek orang ketiga tunggal dan benda tunggal selalu menggunakan \'is\'.',
                    'Uncountable nouns (homework, rice, weather) berstatus tunggal ➔ wajib menggunakan \'is\'.',
                    'Gerund dan klausa yang bertindak sebagai subjek juga menggunakan \'is\'.',
                    'Jangan sekali-kali menyisipkan kata kerja dasar setelah \'is\' (e.g., \'My sister is cooks\' adalah salah).',
                ],
                'exercises' => [
                    [
                        'id' => 11,
                        'id_sentence' => 'Pekerjaan rumah dari guru matematika sangat banyak minggu ini.',
                        'target_word' => 'is (Linking Verb)',
                        'vocab' => [
                            'homework' => [
                                'id' => 'pekerjaan rumah',
                                'pos' => '(n uncountable)',
                            ],
                            'a lot' => [
                                'id' => 'sangat banyak',
                                'pos' => '(adj phr)',
                            ],
                            'this week' => [
                                'id' => 'minggu ini',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'Our math teacher\'s homework is a lot this week.',
                            'Our math teacher\'s homework are a lot this week.',
                            'Our math teacher\'s homework a lot this week.',
                            'Our math teacher\'s homework is be a lot this week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Homework\' adalah uncountable noun (tunggal). Linking verb yang benar adalah \'is\' diikuti pelengkap \'a lot\'.',
                    ],
                    [
                        'id' => 12,
                        'id_sentence' => 'Cuaca di pegunungan sangat dingin pada pagi hari.',
                        'target_word' => 'is (Linking Verb)',
                        'vocab' => [
                            'the weather' => [
                                'id' => 'cuaca',
                                'pos' => '(n uncountable)',
                            ],
                            'cold' => [
                                'id' => 'dingin',
                                'pos' => '(adj)',
                            ],
                            'in the mountains' => [
                                'id' => 'di pegunungan',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'The weather in the mountains is very cold in the morning.',
                            'The weather in the mountains are very cold in the morning.',
                            'The weather in the mountains very cold in the morning.',
                            'The weather in the mountains is be very cold in the morning.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The weather\' adalah uncountable noun. Verb yang tepat adalah \'is cold\'.',
                    ],
                    [
                        'id' => 13,
                        'id_sentence' => 'Kakak perempuan saya pandai memasak masakan Italia.',
                        'target_word' => 'is (Linking Verb)',
                        'vocab' => [
                            'my older sister' => [
                                'id' => 'kakak perempuan saya',
                                'pos' => '(n singular)',
                            ],
                            'good at' => [
                                'id' => 'pandai dalam',
                                'pos' => '(adj phr)',
                            ],
                            'cooking Italian food' => [
                                'id' => 'memasak masakan Italia',
                                'pos' => '(gerund phr)',
                            ],
                        ],
                        'options' => [
                            'My older sister is good at cooking Italian food.',
                            'My older sister are good at cooking Italian food.',
                            'My older sister good at cooking Italian food.',
                            'My older sister is be good at cooking Italian food.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek orang ketiga tunggal \'My older sister\' menggunakan to be \'is\' diikuti kata sifat \'good at\'.',
                    ],
                    [
                        'id' => 14,
                        'id_sentence' => 'Nasi goreng buatan ibu saya selalu lezat dan harum.',
                        'target_word' => 'is (Linking Verb)',
                        'vocab' => [
                            'fried rice' => [
                                'id' => 'nasi goreng',
                                'pos' => '(n)',
                            ],
                            'delicious and fragrant' => [
                                'id' => 'lezat dan harum',
                                'pos' => '(adj phr)',
                            ],
                            'made by my mother' => [
                                'id' => 'buatan ibu saya',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'My mother\'s fried rice is always delicious and fragrant.',
                            'My mother\'s fried rice are always delicious and fragrant.',
                            'My mother\'s fried rice always delicious and fragrant.',
                            'My mother\'s fried rice is be always delicious and fragrant.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Fried rice\' diperlakukan sebagai kata benda tunggal. To be yang tepat adalah \'is delicious\'.',
                    ],
                    [
                        'id' => 15,
                        'id_sentence' => 'Kucing tetangga saya sangat lincah dan suka bermain di halaman.',
                        'target_word' => 'is (Linking Verb)',
                        'vocab' => [
                            'my neighbor\'s cat' => [
                                'id' => 'kucing tetangga saya',
                                'pos' => '(n singular)',
                            ],
                            'playful' => [
                                'id' => 'lincah',
                                'pos' => '(adj)',
                            ],
                            'in the yard' => [
                                'id' => 'di halaman',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'My neighbor\'s cat is very playful in the yard.',
                            'My neighbor\'s cat are very playful in the yard.',
                            'My neighbor\'s cat very playful in the yard.',
                            'My neighbor\'s cat is be very playful in the yard.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'My neighbor\'s cat\' selalu menggunakan \'is\': \'is playful\'.',
                    ],
                    [
                        'id' => 16,
                        'id_sentence' => 'Musik yang diputar di kafe itu sangat menenangkan.',
                        'target_word' => 'is (Linking Verb)',
                        'vocab' => [
                            'music' => [
                                'id' => 'musik',
                                'pos' => '(n uncountable)',
                            ],
                            'relaxing' => [
                                'id' => 'menenangkan',
                                'pos' => '(adj)',
                            ],
                            'at that cafe' => [
                                'id' => 'di kafe itu',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'The music at that cafe is very relaxing.',
                            'The music at that cafe are very relaxing.',
                            'The music at that cafe very relaxing.',
                            'The music at that cafe is be very relaxing.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Music\' adalah uncountable noun, sehingga menggunakan \'is relaxing\'.',
                    ],
                    [
                        'id' => 17,
                        'id_sentence' => 'Adik laki-laki saya masih terlalu kecil untuk naik sepeda sendirian.',
                        'target_word' => 'is (Linking Verb)',
                        'vocab' => [
                            'my little brother' => [
                                'id' => 'adik laki-laki saya',
                                'pos' => '(n singular)',
                            ],
                            'too small' => [
                                'id' => 'terlalu kecil',
                                'pos' => '(adj phr)',
                            ],
                            'ride a bicycle alone' => [
                                'id' => 'naik sepeda sendirian',
                                'pos' => '(v phr)',
                            ],
                        ],
                        'options' => [
                            'My little brother is still too small to ride a bicycle alone.',
                            'My little brother are still too small to ride a bicycle alone.',
                            'My little brother still too small to ride a bicycle alone.',
                            'My little brother is be still too small to ride a bicycle alone.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'My little brother\' tunggal, sehingga memakai \'is still too small\'.',
                    ],
                    [
                        'id' => 18,
                        'id_sentence' => 'Informasi tentang jadwal ujian tersedia di papan pengumuman sekolah.',
                        'target_word' => 'is (Linking Verb)',
                        'vocab' => [
                            'information' => [
                                'id' => 'informasi',
                                'pos' => '(n uncountable)',
                            ],
                            'available' => [
                                'id' => 'tersedia',
                                'pos' => '(adj)',
                            ],
                            'school announcement board' => [
                                'id' => 'papan pengumuman sekolah',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Information about the exam schedule is available on the school announcement board.',
                            'Information about the exam schedule are available on the school announcement board.',
                            'Information about the exam schedule available on the school announcement board.',
                            'Information about the exam schedule is be available on the school announcement board.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Information\' adalah uncountable noun. Verb yang tepat adalah \'is available\'.',
                    ],
                    [
                        'id' => 19,
                        'id_sentence' => 'Toko buku dekat sekolah kami buka sampai jam sembilan malam.',
                        'target_word' => 'is (Linking Verb)',
                        'vocab' => [
                            'the bookstore' => [
                                'id' => 'toko buku',
                                'pos' => '(n singular)',
                            ],
                            'open until' => [
                                'id' => 'buka sampai',
                                'pos' => '(adj phr)',
                            ],
                            'near our school' => [
                                'id' => 'dekat sekolah kami',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'The bookstore near our school is open until nine in the evening.',
                            'The bookstore near our school are open until nine in the evening.',
                            'The bookstore near our school open until nine in the evening.',
                            'The bookstore near our school is be open until nine in the evening.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'The bookstore\' menggunakan \'is open\'.',
                    ],
                    [
                        'id' => 20,
                        'id_sentence' => 'Kamu sangat beruntung mendapat tiket konser itu.',
                        'target_word' => 'are (Linking Verb)',
                        'vocab' => [
                            'you' => [
                                'id' => 'kamu',
                                'pos' => '(pron)',
                            ],
                            'lucky to get' => [
                                'id' => 'beruntung mendapat',
                                'pos' => '(adj phr)',
                            ],
                            'concert ticket' => [
                                'id' => 'tiket konser',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'You are very lucky to get that concert ticket.',
                            'You is very lucky to get that concert ticket.',
                            'You very lucky to get that concert ticket.',
                            'You are be very lucky to get that concert ticket.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Catatan: subjek \'You\' selalu memakai \'are\', meski sub-lesson ini berfokus pada \'is\' untuk subjek tunggal lainnya di atas.',
                    ],
                ],
            ],
            [
                'id' => 'nominal-negative-interrogative',
                'name' => 'Simple Present Nominal: Bentuk Negatif & Interogatif (am/is/are not & Is/Are...?)',
                'code' => '1.3.3',
                'concept_title' => 'Pola Negasi dan Kalimat Tanya pada Kalimat Nominal Simple Present',
                'concept_description' => 'Kalimat nominal disangkal HANYA dengan menyisipkan partikel negasi \'not\' setelah to be: \'is not\' (isn\'t), \'are not\' (aren\'t), atau \'am not\'. Kalimat nominal TIDAK PERNAH menggunakan auxiliary \'do not\' atau \'does not\'. Untuk membentuk kalimat tanya, pindahkan to be ke posisi sebelum subjek.',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-emerald-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-emerald-500/25 text-emerald-300 border border-emerald-500/50 font-mono tracking-wider">SIMPLE PRESENT NOMINAL</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Bentuk Negatif &amp; Interogatif (am/is/are not &amp; Is/Are...?)</span>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3.5 border border-slate-600 space-y-3.5">
        <!-- [1] Bentuk Negatif -->
        <div class="space-y-1.5">
            <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                <span class="text-xs font-black text-rose-300 uppercase tracking-wide">[1] BENTUK NEGATIF (NOT)</span>
            </div>
            <code class="text-xs sm:text-sm font-mono font-bold text-rose-300 bg-slate-950 px-3 py-1.5 rounded-lg border border-rose-500/40 block">Subject + IS / AM / ARE + NOT + Complement</code>
            <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
                <span class="text-rose-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">This soup is not too spicy for the children.</span>
            </div>
            <div class="text-xs text-white pl-3 border-l-2 border-rose-400">
                (Sup ini tidak terlalu pedas untuk anak-anak.)
            </div>
        </div>

        <!-- [2] Bentuk Interogatif: Yes/No Question -->
        <div class="space-y-1.5 pt-2 border-t border-slate-700/60">
            <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-sky-400"></span>
                <span class="text-xs font-black text-sky-300 uppercase tracking-wide">[2] INTEROGATIF: YES/NO QUESTION</span>
            </div>
            <code class="text-xs sm:text-sm font-mono font-bold text-sky-300 bg-slate-950 px-3 py-1.5 rounded-lg border border-sky-500/40 block">IS / ARE / AM + Subject + Complement...?</code>
            <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
                <span class="text-sky-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">Are you ready for tomorrow's basketball match?</span>
            </div>
            <div class="text-xs text-white pl-3 border-l-2 border-sky-400">
                (Apakah kalian siap untuk pertandingan basket besok sore?)
            </div>
        </div>

        <!-- [3] Bentuk Interogatif: WH- Question -->
        <div class="space-y-1.5 pt-2 border-t border-slate-700/60">
            <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                <span class="text-xs font-black text-amber-300 uppercase tracking-wide">[3] INTEROGATIF: WH- QUESTIONS (INFORMASI)</span>
            </div>
            <code class="text-xs sm:text-sm font-mono font-bold text-amber-300 bg-slate-950 px-3 py-1.5 rounded-lg border border-amber-500/40 block">WH- Word (Why / Where / What / How) + IS / ARE + Subject + Complement...?</code>
            <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
                <span class="text-amber-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">Why is the classroom door always locked during recess?</span>
            </div>
            <div class="text-xs text-white pl-3 border-l-2 border-amber-400">
                (Mengapa pintu kelas selalu terkunci saat jam istirahat?)
            </div>
        </div>
    </div>

    <!-- Kaidah Utama -->
    <div class="text-xs text-white pl-3 border-l-2 border-amber-400 bg-amber-950/40 p-2.5 rounded-r-lg">
        <strong class="text-amber-300 uppercase">[KAIDAH UTAMA]:</strong> Kalimat nominal disangkal dengan <strong>to be + not</strong> (dilarang menggunakan do/does not). Pada pertanyaan Yes/No, to be ditempatkan sebelum subjek. Pada pertanyaan WH-, kata tanya berada di paling depan diikuti to be sebelum subjek.
    </div>
</div>
HTML,
                'rules' => [
                    'Dilarang menggunakan do not / does not pada kalimat nominal (e.g., \'The soup does not spicy\' adalah SALAH).',
                    'Gunakan \'is not\' atau \'are not\' diikuti Adjective, Noun, atau Prepositional Phrase.',
                    'Kalimat tanya yes/no diawali dengan \'Is\' atau \'Are\' sebelum subjek.',
                    'Kalimat tanya informasi (WH-questions) meletakkan WH-word sebelum to be (e.g., \'Why is the shop closed?\').',
                ],
                'exercises' => [
                    [
                        'id' => 21,
                        'id_sentence' => 'Sup ini tidak terlalu pedas untuk anak-anak.',
                        'target_word' => 'is not (Negative Nominal)',
                        'vocab' => [
                            'this soup' => [
                                'id' => 'sup ini',
                                'pos' => '(n singular)',
                            ],
                            'too spicy for' => [
                                'id' => 'terlalu pedas untuk',
                                'pos' => '(adj phr)',
                            ],
                            'the children' => [
                                'id' => 'anak-anak',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'This soup is not too spicy for the children.',
                            'This soup does not spicy for the children.',
                            'This soup are not too spicy for the children.',
                            'This soup do not spicy for the children.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata \'spicy\' adalah kata sifat (Adjective). Karena subjek \'soup\' tunggal, bentuk negasi yang benar adalah \'is not spicy\', BUKAN \'does not\'.',
                    ],
                    [
                        'id' => 22,
                        'id_sentence' => 'Kedua sepatu itu tidak cukup nyaman untuk lari jarak jauh.',
                        'target_word' => 'are not (Negative Nominal)',
                        'vocab' => [
                            'the two shoes' => [
                                'id' => 'kedua sepatu itu',
                                'pos' => '(n plural)',
                            ],
                            'comfortable enough for' => [
                                'id' => 'cukup nyaman untuk',
                                'pos' => '(adj phr)',
                            ],
                            'long-distance running' => [
                                'id' => 'lari jarak jauh',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The two shoes are not comfortable enough for long-distance running.',
                            'The two shoes does not comfortable enough for long-distance running.',
                            'The two shoes is not comfortable enough for long-distance running.',
                            'The two shoes do not comfortable enough for long-distance running.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The two shoes\' adalah subjek jamak. Karena predikatnya kata sifat (\'comfortable\'), bentuk negasi wajib memakai to be: \'are not comfortable\'.',
                    ],
                    [
                        'id' => 23,
                        'id_sentence' => 'Apakah perpustakaan sekolah buka pada hari Sabtu?',
                        'target_word' => 'Is (Interrogative To Be)',
                        'vocab' => [
                            'the school library' => [
                                'id' => 'perpustakaan sekolah',
                                'pos' => '(n singular)',
                            ],
                            'open' => [
                                'id' => 'buka',
                                'pos' => '(adj)',
                            ],
                            'on Saturdays' => [
                                'id' => 'pada hari Sabtu',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'Is the school library open on Saturdays?',
                            'Does the school library open on Saturdays?',
                            'Are the school library open on Saturdays?',
                            'Do the school library open on Saturdays?',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Open\' adalah kata sifat, dan subjek \'library\' tunggal, sehingga kalimat tanya yang benar memindahkan \'Is\' ke depan subjek.',
                    ],
                    [
                        'id' => 24,
                        'id_sentence' => 'Apakah buah-buahan ini cukup segar untuk dijadikan jus?',
                        'target_word' => 'Are (Interrogative To Be)',
                        'vocab' => [
                            'these fruits' => [
                                'id' => 'buah-buahan ini',
                                'pos' => '(n plural)',
                            ],
                            'fresh enough for' => [
                                'id' => 'cukup segar untuk',
                                'pos' => '(adj phr)',
                            ],
                            'making juice' => [
                                'id' => 'dijadikan jus',
                                'pos' => '(gerund phr)',
                            ],
                        ],
                        'options' => [
                            'Are these fruits fresh enough for making juice?',
                            'Do these fruits fresh enough for making juice?',
                            'Is these fruits fresh enough for making juice?',
                            'Does these fruits fresh enough for making juice?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'these fruits\' jamak, sehingga kalimat tanya menggunakan \'Are\' sebelum subjek.',
                    ],
                    [
                        'id' => 25,
                        'id_sentence' => 'Saya tidak yakin dengan jawaban nomor lima di ujian tadi.',
                        'target_word' => 'am not (Negative Nominal)',
                        'vocab' => [
                            'I' => [
                                'id' => 'saya',
                                'pos' => '(pron)',
                            ],
                            'sure about' => [
                                'id' => 'yakin dengan',
                                'pos' => '(adj phr)',
                            ],
                            'number five on the test' => [
                                'id' => 'jawaban nomor lima di ujian',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'I am not sure about number five on the test.',
                            'I do not sure about number five on the test.',
                            'I is not sure about number five on the test.',
                            'I does not sure about number five on the test.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'I\' menggunakan \'am not\' untuk bentuk negatif nominal.',
                    ],
                    [
                        'id' => 26,
                        'id_sentence' => 'Mengapa pintu kelas selalu terkunci saat jam istirahat?',
                        'target_word' => 'Is (Interrogative WH-)',
                        'vocab' => [
                            'the classroom door' => [
                                'id' => 'pintu kelas',
                                'pos' => '(n singular)',
                            ],
                            'always locked' => [
                                'id' => 'selalu terkunci',
                                'pos' => '(adj phr)',
                            ],
                            'during recess' => [
                                'id' => 'saat jam istirahat',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'Why is the classroom door always locked during recess?',
                            'Why does the classroom door always locked during recess?',
                            'Why are the classroom door always locked during recess?',
                            'Why do the classroom door always locked during recess?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'WH-question dengan predikat nominal (\'locked\' sebagai kata sifat) menggunakan \'Why is\' karena subjeknya tunggal.',
                    ],
                    [
                        'id' => 27,
                        'id_sentence' => 'Pekerjaan rumah ini tidak sesulit yang kami kira sebelumnya.',
                        'target_word' => 'is not (Negative Nominal)',
                        'vocab' => [
                            'this homework' => [
                                'id' => 'pekerjaan rumah ini',
                                'pos' => '(n uncountable)',
                            ],
                            'as difficult as' => [
                                'id' => 'sesulit',
                                'pos' => '(adj phr)',
                            ],
                            'we thought' => [
                                'id' => 'yang kami kira',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'This homework is not as difficult as we thought.',
                            'This homework does not difficult as we thought.',
                            'This homework are not as difficult as we thought.',
                            'This homework do not difficult as we thought.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Homework\' bersifat tunggal (uncountable), sehingga negasinya adalah \'is not as difficult\'.',
                    ],
                    [
                        'id' => 28,
                        'id_sentence' => 'Apakah kalian siap untuk pertandingan basket besok sore?',
                        'target_word' => 'Are (Interrogative To Be)',
                        'vocab' => [
                            'you (plural)' => [
                                'id' => 'kalian',
                                'pos' => '(pron)',
                            ],
                            'ready for' => [
                                'id' => 'siap untuk',
                                'pos' => '(adj phr)',
                            ],
                            'basketball match' => [
                                'id' => 'pertandingan basket',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Are you ready for tomorrow\'s basketball match?',
                            'Do you ready for tomorrow\'s basketball match?',
                            'Is you ready for tomorrow\'s basketball match?',
                            'Does you ready for tomorrow\'s basketball match?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'you\' (jamak/kalian) menggunakan \'Are\' untuk kalimat tanya.',
                    ],
                    [
                        'id' => 29,
                        'id_sentence' => 'Jalan menuju rumah nenek tidak terlalu jauh dari sini.',
                        'target_word' => 'is not (Negative Nominal)',
                        'vocab' => [
                            'the road' => [
                                'id' => 'jalan',
                                'pos' => '(n singular)',
                            ],
                            'too far from' => [
                                'id' => 'terlalu jauh dari',
                                'pos' => '(adj phr)',
                            ],
                            'grandmother\'s house' => [
                                'id' => 'rumah nenek',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The road to grandmother\'s house is not too far from here.',
                            'The road to grandmother\'s house does not far from here.',
                            'The road to grandmother\'s house are not too far from here.',
                            'The road to grandmother\'s house do not far from here.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'The road\' tunggal, sehingga negasinya \'is not too far\'.',
                    ],
                    [
                        'id' => 30,
                        'id_sentence' => 'Mengapa kue-kue ini tidak semanis yang biasa ibu buat?',
                        'target_word' => 'Why are...not (Interrogative Negative)',
                        'vocab' => [
                            'these cookies' => [
                                'id' => 'kue-kue ini',
                                'pos' => '(n plural)',
                            ],
                            'as sweet as' => [
                                'id' => 'semanis',
                                'pos' => '(adj phr)',
                            ],
                            'mom usually makes' => [
                                'id' => 'yang biasa ibu buat',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'Why are these cookies not as sweet as the ones mom usually makes?',
                            'Why do these cookies not as sweet as the ones mom usually makes?',
                            'Why is these cookies not as sweet as the ones mom usually makes?',
                            'Why does these cookies not as sweet as the ones mom usually makes?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'these cookies\' dengan predikat nominal menggunakan \'Why are ... not\'.',
                    ],
                ],
            ],
            [
                'id' => 'passive-plural',
                'name' => 'Simple Present Passive: Subjek Jamak & I/You/We/They (+ are/am + V3)',
                'code' => '1.3.4',
                'concept_title' => 'Kalimat Pasif Simple Present untuk Subjek Jamak (are + Past Participle)',
                'concept_description' => 'Kalimat pasif berfokus pada apa yang dialami oleh objek penerima aksi, bukan siapa yang melakukan aksi. Konstruksi pasif sering kita temukan dalam percakapan dan tulisan sehari-hari, misalnya untuk menjelaskan kebiasaan rutin di rumah atau di sekolah. Rumus pasif Simple Present untuk subjek jamak adalah: Subjek Jamak + ARE + Verb 3 (Past Participle).',
                'formula' => 'Subject (Plural Nouns / They / We / You) + ARE + Verb 3 (Past Participle) (+ by Agent)',
                'rules' => [
                    'Subjek jamak wajib menggunakan auxiliary \'are\' sebelum Verb 3.',
                    'Verb harus selalu berupa Past Participle (Verb 3) seperti washed, cooked, cleaned, collected.',
                    'Pelaku aksi (+ by Agent) bersifat opsional dan sering dihilangkan bila sudah jelas dari konteks.',
                    'Jangan lupa menyisipkan \'are\' (menulis \'The dishes washed every night\' tanpa auxiliary adalah kalimat yang tidak lengkap).',
                ],
                'exercises' => [
                    [
                        'id' => 31,
                        'id_sentence' => 'Piring-piring dicuci setiap malam setelah makan malam selesai.',
                        'target_word' => 'are washed (Passive Verb)',
                        'vocab' => [
                            'the dishes' => [
                                'id' => 'piring-piring',
                                'pos' => '(n plural)',
                            ],
                            'washed' => [
                                'id' => 'dicuci',
                                'pos' => '(v3)',
                            ],
                            'after dinner' => [
                                'id' => 'setelah makan malam',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'The dishes are washed every night after dinner is finished.',
                            'The dishes wash every night after dinner is finished.',
                            'The dishes is washed every night after dinner is finished.',
                            'The dishes are wash every night after dinner is finished.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek penerima aksi adalah \'The dishes\' (jamak). Bentuk pasif Simple Present yang benar adalah \'are washed\' (to be \'are\' + Verb 3).',
                    ],
                    [
                        'id' => 32,
                        'id_sentence' => 'Tanaman-tanaman di kebun disiram setiap pagi sebelum sekolah.',
                        'target_word' => 'are watered (Passive Verb)',
                        'vocab' => [
                            'the plants' => [
                                'id' => 'tanaman-tanaman',
                                'pos' => '(n plural)',
                            ],
                            'watered' => [
                                'id' => 'disiram',
                                'pos' => '(v3)',
                            ],
                            'before school' => [
                                'id' => 'sebelum sekolah',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'The plants in the garden are watered every morning before school.',
                            'The plants in the garden water every morning before school.',
                            'The plants in the garden is watered every morning before school.',
                            'The plants in the garden are water every morning before school.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Plants\' adalah kata benda jamak. Kalimat pasif membutuhkan \'are watered\'.',
                    ],
                    [
                        'id' => 33,
                        'id_sentence' => 'Mainan-mainan dirapikan oleh anak-anak sebelum tidur setiap malam.',
                        'target_word' => 'are put away (Passive Verb)',
                        'vocab' => [
                            'the toys' => [
                                'id' => 'mainan-mainan',
                                'pos' => '(n plural)',
                            ],
                            'put away' => [
                                'id' => 'dirapikan',
                                'pos' => '(v3)',
                            ],
                            'before bedtime' => [
                                'id' => 'sebelum tidur',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'The toys are put away by the children before bedtime every night.',
                            'The toys put away by the children before bedtime every night.',
                            'The toys is put away by the children before bedtime every night.',
                            'The toys are putting away by the children before bedtime every night.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'The toys\' (jamak) dengan agen \'by the children\'. Bentuk pasif yang benar: \'are put away\'.',
                    ],
                    [
                        'id' => 34,
                        'id_sentence' => 'Kami diundang ke pesta ulang tahun sepupu kami setiap tahun.',
                        'target_word' => 'are invited (Passive Verb)',
                        'vocab' => [
                            'we' => [
                                'id' => 'kami',
                                'pos' => '(pron)',
                            ],
                            'invited' => [
                                'id' => 'diundang',
                                'pos' => '(v3)',
                            ],
                            'birthday party' => [
                                'id' => 'pesta ulang tahun',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'We are invited to our cousin\'s birthday party every year.',
                            'We invite to our cousin\'s birthday party every year.',
                            'We is invited to our cousin\'s birthday party every year.',
                            'We are invite to our cousin\'s birthday party every year.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'We\' selalu memakai \'are\' dalam bentuk pasif: \'are invited\'.',
                    ],
                    [
                        'id' => 35,
                        'id_sentence' => 'Buku-buku perpustakaan dikembalikan tepat waktu oleh para siswa.',
                        'target_word' => 'are returned (Passive Verb)',
                        'vocab' => [
                            'the library books' => [
                                'id' => 'buku-buku perpustakaan',
                                'pos' => '(n plural)',
                            ],
                            'returned' => [
                                'id' => 'dikembalikan',
                                'pos' => '(v3)',
                            ],
                            'on time' => [
                                'id' => 'tepat waktu',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'The library books are returned on time by the students.',
                            'The library books return on time by the students.',
                            'The library books is returned on time by the students.',
                            'The library books are return on time by the students.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'The library books\' menggunakan \'are returned\'.',
                    ],
                    [
                        'id' => 36,
                        'id_sentence' => 'Pakaian kotor dikumpulkan setiap hari Minggu untuk dicuci.',
                        'target_word' => 'are collected (Passive Verb)',
                        'vocab' => [
                            'dirty clothes' => [
                                'id' => 'pakaian kotor',
                                'pos' => '(n plural)',
                            ],
                            'collected' => [
                                'id' => 'dikumpulkan',
                                'pos' => '(v3)',
                            ],
                            'to be washed' => [
                                'id' => 'untuk dicuci',
                                'pos' => '(inf phr)',
                            ],
                        ],
                        'options' => [
                            'Dirty clothes are collected every Sunday to be washed.',
                            'Dirty clothes collect every Sunday to be washed.',
                            'Dirty clothes is collected every Sunday to be washed.',
                            'Dirty clothes are collect every Sunday to be washed.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Clothes\' adalah kata benda jamak, sehingga memakai \'are collected\'.',
                    ],
                    [
                        'id' => 37,
                        'id_sentence' => 'Kalian diizinkan membawa bekal makan siang sendiri ke sekolah.',
                        'target_word' => 'are allowed (Passive Verb)',
                        'vocab' => [
                            'you (plural)' => [
                                'id' => 'kalian',
                                'pos' => '(pron)',
                            ],
                            'allowed to' => [
                                'id' => 'diizinkan untuk',
                                'pos' => '(v3 phr)',
                            ],
                            'bring a packed lunch' => [
                                'id' => 'membawa bekal makan siang',
                                'pos' => '(v phr)',
                            ],
                        ],
                        'options' => [
                            'You are allowed to bring your own packed lunch to school.',
                            'You allow to bring your own packed lunch to school.',
                            'You is allowed to bring your own packed lunch to school.',
                            'You are allow to bring your own packed lunch to school.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'You\' (kalian) menggunakan bentuk pasif \'are allowed\'.',
                    ],
                    [
                        'id' => 38,
                        'id_sentence' => 'Sepeda-sepeda itu diparkir rapi di depan gerbang sekolah.',
                        'target_word' => 'are parked (Passive Verb)',
                        'vocab' => [
                            'the bicycles' => [
                                'id' => 'sepeda-sepeda itu',
                                'pos' => '(n plural)',
                            ],
                            'parked neatly' => [
                                'id' => 'diparkir rapi',
                                'pos' => '(v3 phr)',
                            ],
                            'school gate' => [
                                'id' => 'gerbang sekolah',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'The bicycles are parked neatly in front of the school gate.',
                            'The bicycles park neatly in front of the school gate.',
                            'The bicycles is parked neatly in front of the school gate.',
                            'The bicycles are park neatly in front of the school gate.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'The bicycles\' memakai \'are parked\'.',
                    ],
                    [
                        'id' => 39,
                        'id_sentence' => 'Kami diajarkan untuk selalu jujur dan disiplin oleh orang tua kami.',
                        'target_word' => 'are taught (Passive Verb)',
                        'vocab' => [
                            'we' => [
                                'id' => 'kami',
                                'pos' => '(pron)',
                            ],
                            'taught to' => [
                                'id' => 'diajarkan untuk',
                                'pos' => '(v3 phr)',
                            ],
                            'honest and disciplined' => [
                                'id' => 'jujur dan disiplin',
                                'pos' => '(adj phr)',
                            ],
                        ],
                        'options' => [
                            'We are taught to always be honest and disciplined by our parents.',
                            'We teach to always be honest and disciplined by our parents.',
                            'We is taught to always be honest and disciplined by our parents.',
                            'We are teach to always be honest and disciplined by our parents.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'We\' menggunakan bentuk pasif \'are taught\'.',
                    ],
                    [
                        'id' => 40,
                        'id_sentence' => 'Keranjang sampah dikosongkan dua kali seminggu oleh petugas kebersihan.',
                        'target_word' => 'are emptied (Passive Verb)',
                        'vocab' => [
                            'the trash bins' => [
                                'id' => 'keranjang sampah',
                                'pos' => '(n plural)',
                            ],
                            'emptied' => [
                                'id' => 'dikosongkan',
                                'pos' => '(v3)',
                            ],
                            'twice a week' => [
                                'id' => 'dua kali seminggu',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'The trash bins are emptied twice a week by the cleaning staff.',
                            'The trash bins empty twice a week by the cleaning staff.',
                            'The trash bins is emptied twice a week by the cleaning staff.',
                            'The trash bins are empty twice a week by the cleaning staff.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'The trash bins\' menggunakan \'are emptied\'.',
                    ],
                ],
            ],
            [
                'id' => 'passive-singular',
                'name' => 'Simple Present Passive: Subjek Tunggal & Uncountable (+ is + V3)',
                'code' => '1.3.5',
                'concept_title' => 'Kalimat Pasif Simple Present untuk Subjek Tunggal (is + Past Participle)',
                'concept_description' => 'Ketika subjek penerima aksi berupa orang/benda tunggal atau kata benda tak dapat dihitung, auxiliary pasif yang digunakan adalah \'is\'. Rumus: Subjek Tunggal + IS + Verb 3.',
                'formula' => 'Subject (He / She / It / Singular Noun / Uncountable Noun) + is + Verb 3 (Past Participle) (+ by Agent)',
                'rules' => [
                    'Subjek tunggal wajib menggunakan auxiliary \'is\' sebelum Verb 3.',
                    'Uncountable nouns (rice, bread, milk) termasuk kategori tunggal ➔ gunakan \'is\'.',
                    'Jangan menghilangkan \'is\' (menulis \'The floor swept every morning\' tanpa auxiliary adalah kalimat yang tidak lengkap).',
                    'Jangan menambahkan \'be\' dua kali (e.g., \'is be cleaned\' adalah salah).',
                ],
                'exercises' => [
                    [
                        'id' => 41,
                        'id_sentence' => 'Lantai rumah disapu setiap pagi oleh kakak saya.',
                        'target_word' => 'is swept (Passive Verb)',
                        'vocab' => [
                            'the floor' => [
                                'id' => 'lantai',
                                'pos' => '(n singular)',
                            ],
                            'swept' => [
                                'id' => 'disapu',
                                'pos' => '(v3)',
                            ],
                            'every morning' => [
                                'id' => 'setiap pagi',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'The floor is swept every morning by my older sister.',
                            'The floor sweeps every morning by my older sister.',
                            'The floor are swept every morning by my older sister.',
                            'The floor is sweep every morning by my older sister.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'The floor\' tunggal, sehingga memakai \'is swept\'.',
                    ],
                    [
                        'id' => 42,
                        'id_sentence' => 'Nasi dimasak dengan rice cooker setiap hari di rumah kami.',
                        'target_word' => 'is cooked (Passive Verb)',
                        'vocab' => [
                            'rice' => [
                                'id' => 'nasi',
                                'pos' => '(n uncountable)',
                            ],
                            'cooked' => [
                                'id' => 'dimasak',
                                'pos' => '(v3)',
                            ],
                            'with a rice cooker' => [
                                'id' => 'dengan rice cooker',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'Rice is cooked with a rice cooker every day in our house.',
                            'Rice cooks with a rice cooker every day in our house.',
                            'Rice are cooked with a rice cooker every day in our house.',
                            'Rice is cook with a rice cooker every day in our house.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Rice\' adalah uncountable noun (tunggal), sehingga memakai \'is cooked\'.',
                    ],
                    [
                        'id' => 43,
                        'id_sentence' => 'Jendela kamar dibersihkan sebulan sekali oleh petugas apartemen.',
                        'target_word' => 'is cleaned (Passive Verb)',
                        'vocab' => [
                            'the bedroom window' => [
                                'id' => 'jendela kamar',
                                'pos' => '(n singular)',
                            ],
                            'cleaned' => [
                                'id' => 'dibersihkan',
                                'pos' => '(v3)',
                            ],
                            'once a month' => [
                                'id' => 'sebulan sekali',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'The bedroom window is cleaned once a month by the apartment staff.',
                            'The bedroom window cleans once a month by the apartment staff.',
                            'The bedroom window are cleaned once a month by the apartment staff.',
                            'The bedroom window is clean once a month by the apartment staff.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'The bedroom window\' tunggal, sehingga \'is cleaned\'.',
                    ],
                    [
                        'id' => 44,
                        'id_sentence' => 'Roti ini dipanggang setiap pagi di toko roti dekat rumah saya.',
                        'target_word' => 'is baked (Passive Verb)',
                        'vocab' => [
                            'this bread' => [
                                'id' => 'roti ini',
                                'pos' => '(n uncountable)',
                            ],
                            'baked' => [
                                'id' => 'dipanggang',
                                'pos' => '(v3)',
                            ],
                            'near my house' => [
                                'id' => 'dekat rumah saya',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'This bread is baked every morning at the bakery near my house.',
                            'This bread bakes every morning at the bakery near my house.',
                            'This bread are baked every morning at the bakery near my house.',
                            'This bread is bake every morning at the bakery near my house.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Bread\' bersifat uncountable (tunggal), sehingga memakai \'is baked\'.',
                    ],
                    [
                        'id' => 45,
                        'id_sentence' => 'Ia dipuji oleh gurunya karena rajin mengerjakan tugas.',
                        'target_word' => 'is praised (Passive Verb)',
                        'vocab' => [
                            'she' => [
                                'id' => 'ia (perempuan)',
                                'pos' => '(pron)',
                            ],
                            'praised' => [
                                'id' => 'dipuji',
                                'pos' => '(v3)',
                            ],
                            'for being diligent' => [
                                'id' => 'karena rajin',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'She is praised by her teacher for being diligent with her assignments.',
                            'She praises by her teacher for being diligent with her assignments.',
                            'She are praised by her teacher for being diligent with her assignments.',
                            'She is praise by her teacher for being diligent with her assignments.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'She\' tunggal, sehingga menggunakan \'is praised\'.',
                    ],
                    [
                        'id' => 46,
                        'id_sentence' => 'Susu ini disimpan di kulkas agar tetap segar.',
                        'target_word' => 'is stored (Passive Verb)',
                        'vocab' => [
                            'this milk' => [
                                'id' => 'susu ini',
                                'pos' => '(n uncountable)',
                            ],
                            'stored' => [
                                'id' => 'disimpan',
                                'pos' => '(v3)',
                            ],
                            'to stay fresh' => [
                                'id' => 'agar tetap segar',
                                'pos' => '(inf phr)',
                            ],
                        ],
                        'options' => [
                            'This milk is stored in the fridge to stay fresh.',
                            'This milk stores in the fridge to stay fresh.',
                            'This milk are stored in the fridge to stay fresh.',
                            'This milk is store in the fridge to stay fresh.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Milk\' adalah uncountable noun, sehingga menggunakan \'is stored\'.',
                    ],
                    [
                        'id' => 47,
                        'id_sentence' => 'Pekerjaan rumahnya diperiksa setiap malam oleh ayahnya.',
                        'target_word' => 'is checked (Passive Verb)',
                        'vocab' => [
                            'his homework' => [
                                'id' => 'pekerjaan rumahnya',
                                'pos' => '(n uncountable)',
                            ],
                            'checked' => [
                                'id' => 'diperiksa',
                                'pos' => '(v3)',
                            ],
                            'by his father' => [
                                'id' => 'oleh ayahnya',
                                'pos' => '(agent)',
                            ],
                        ],
                        'options' => [
                            'His homework is checked every night by his father.',
                            'His homework checks every night by his father.',
                            'His homework are checked every night by his father.',
                            'His homework is check every night by his father.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Homework\' tunggal, sehingga memakai \'is checked\'.',
                    ],
                    [
                        'id' => 48,
                        'id_sentence' => 'Pintu toko dikunci pada pukul sepuluh malam setiap hari.',
                        'target_word' => 'is locked (Passive Verb)',
                        'vocab' => [
                            'the shop door' => [
                                'id' => 'pintu toko',
                                'pos' => '(n singular)',
                            ],
                            'locked' => [
                                'id' => 'dikunci',
                                'pos' => '(v3)',
                            ],
                            'at ten at night' => [
                                'id' => 'pada pukul sepuluh malam',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'The shop door is locked at ten at night every day.',
                            'The shop door locks at ten at night every day.',
                            'The shop door are locked at ten at night every day.',
                            'The shop door is lock at ten at night every day.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'The shop door\' memakai \'is locked\'.',
                    ],
                    [
                        'id' => 49,
                        'id_sentence' => 'Ia diundang ke pesta pernikahan sepupunya bulan depan.',
                        'target_word' => 'is invited (Passive Verb)',
                        'vocab' => [
                            'he' => [
                                'id' => 'ia (laki-laki)',
                                'pos' => '(pron)',
                            ],
                            'invited' => [
                                'id' => 'diundang',
                                'pos' => '(v3)',
                            ],
                            'cousin\'s wedding' => [
                                'id' => 'pesta pernikahan sepupu',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'He is invited to his cousin\'s wedding next month.',
                            'He invites to his cousin\'s wedding next month.',
                            'He are invited to his cousin\'s wedding next month.',
                            'He is invite to his cousin\'s wedding next month.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'He\' tunggal, sehingga memakai \'is invited\'.',
                    ],
                    [
                        'id' => 50,
                        'id_sentence' => 'Mobil ayah dicuci setiap akhir pekan di garasi rumah.',
                        'target_word' => 'is washed (Passive Verb)',
                        'vocab' => [
                            'dad\'s car' => [
                                'id' => 'mobil ayah',
                                'pos' => '(n singular)',
                            ],
                            'washed' => [
                                'id' => 'dicuci',
                                'pos' => '(v3)',
                            ],
                            'in the garage' => [
                                'id' => 'di garasi',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'Dad\'s car is washed every weekend in the garage.',
                            'Dad\'s car washes every weekend in the garage.',
                            'Dad\'s car are washed every weekend in the garage.',
                            'Dad\'s car is wash every weekend in the garage.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'Dad\'s car\' memakai \'is washed\'.',
                    ],
                ],
            ],
            [
                'id' => 'passive-negative-interrogative',
                'name' => 'Simple Present Passive: Bentuk Negatif & Interogatif (is/are not + V3 & Is/Are... V3?)',
                'code' => '1.3.6',
                'concept_title' => 'Pola Negasi dan Kalimat Tanya pada Kalimat Pasif Simple Present',
                'concept_description' => 'Kalimat pasif disangkal dengan menyisipkan \'not\' setelah to be, sebelum Verb 3: \'is not + V3\' atau \'are not + V3\'. Kalimat tanya dibentuk dengan memindahkan to be ke depan subjek, diikuti Verb 3.',
                'formula' => <<<'HTML'
<div class="space-y-3 text-left">
    <div class="flex items-center gap-2 pb-2 border-b border-emerald-500/40">
        <span class="px-2 py-0.5 rounded text-[11px] font-black bg-emerald-500/25 text-emerald-300 border border-emerald-500/50 font-mono tracking-wider">SIMPLE PRESENT PASSIVE</span>
        <span class="text-xs sm:text-sm font-extrabold text-white">Bentuk Negatif &amp; Interogatif (is/are not + V3 &amp; Is/Are... V3?)</span>
    </div>

    <div class="rounded-xl bg-slate-900/90 p-3.5 border border-slate-600 space-y-3.5">
        <!-- [1] Bentuk Negatif Pasif -->
        <div class="space-y-1.5">
            <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                <span class="text-xs font-black text-rose-300 uppercase tracking-wide">[1] BENTUK NEGATIF PASIF</span>
            </div>
            <code class="text-xs sm:text-sm font-mono font-bold text-rose-300 bg-slate-950 px-3 py-1.5 rounded-lg border border-rose-500/40 block">Subject + IS / ARE + NOT + Verb 3 (Past Participle)</code>
            <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
                <span class="text-rose-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">The dining table is not cleaned yet after breakfast.</span>
            </div>
            <div class="text-xs text-white pl-3 border-l-2 border-rose-400">
                (Meja makan belum dibersihkan setelah sarapan tadi.)
            </div>
        </div>

        <!-- [2] Bentuk Interogatif Pasif: Yes/No Question -->
        <div class="space-y-1.5 pt-2 border-t border-slate-700/60">
            <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-sky-400"></span>
                <span class="text-xs font-black text-sky-300 uppercase tracking-wide">[2] INTEROGATIF PASIF: YES/NO QUESTION</span>
            </div>
            <code class="text-xs sm:text-sm font-mono font-bold text-sky-300 bg-slate-950 px-3 py-1.5 rounded-lg border border-sky-500/40 block">IS / ARE + Subject + Verb 3 (Past Participle)...?</code>
            <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
                <span class="text-sky-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">Is dad's car washed every weekend in the garage?</span>
            </div>
            <div class="text-xs text-white pl-3 border-l-2 border-sky-400">
                (Apakah mobil ayah dicuci setiap akhir pekan di garasi?)
            </div>
        </div>

        <!-- [3] Bentuk Interogatif Pasif: WH- Question -->
        <div class="space-y-1.5 pt-2 border-t border-slate-700/60">
            <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                <span class="text-xs font-black text-amber-300 uppercase tracking-wide">[3] INTEROGATIF PASIF: WH- QUESTIONS</span>
            </div>
            <code class="text-xs sm:text-sm font-mono font-bold text-amber-300 bg-slate-950 px-3 py-1.5 rounded-lg border border-amber-500/40 block">WH- Word (Why / Where / How) + IS / ARE + Subject + Verb 3...?</code>
            <div class="text-xs sm:text-sm text-white font-mono pt-0.5">
                <span class="text-amber-400 font-bold not-italic">Contoh:</span> <span class="italic text-white">Why is the library closed on public holidays?</span>
            </div>
            <div class="text-xs text-white pl-3 border-l-2 border-amber-400">
                (Mengapa perpustakaan ditutup pada hari libur nasional?)
            </div>
        </div>
    </div>

    <!-- Kaidah Utama -->
    <div class="text-xs text-white pl-3 border-l-2 border-amber-400 bg-amber-950/40 p-2.5 rounded-r-lg">
        <strong class="text-amber-300 uppercase">[KAIDAH UTAMA]:</strong> Kalimat pasif disangkal dengan <strong>to be + not + Verb 3</strong> (dilarang menggunakan do/does not). Pada kalimat tanya Yes/No pasif, to be ditempatkan di depan subjek diikuti Verb 3. Pada pertanyaan WH- pasif, kata tanya diletakkan paling awal.
    </div>
</div>
HTML,
                'rules' => [
                    'Bentuk negatif pasif selalu: to be + not + Verb 3.',
                    'Bentuk tanya pasif selalu: to be + Subject + Verb 3?',
                    'Jangan gunakan do/does pada kalimat pasif (e.g., \'does not cleaned\' adalah salah).',
                    'Pastikan Verb 3 tetap digunakan meski kalimat berbentuk negatif atau tanya.',
                ],
                'exercises' => [
                    [
                        'id' => 51,
                        'id_sentence' => 'Meja makan belum dibersihkan setelah sarapan tadi.',
                        'target_word' => 'is not cleaned (Negative Passive)',
                        'vocab' => [
                            'the dining table' => [
                                'id' => 'meja makan',
                                'pos' => '(n singular)',
                            ],
                            'not cleaned yet' => [
                                'id' => 'belum dibersihkan',
                                'pos' => '(v3 phr)',
                            ],
                            'after breakfast' => [
                                'id' => 'setelah sarapan',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'The dining table is not cleaned yet after breakfast.',
                            'The dining table does not cleaned yet after breakfast.',
                            'The dining table are not cleaned yet after breakfast.',
                            'The dining table not is cleaned yet after breakfast.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'The dining table\' menggunakan negasi pasif \'is not cleaned\'.',
                    ],
                    [
                        'id' => 52,
                        'id_sentence' => 'Apakah pintu depan sudah dikunci malam ini?',
                        'target_word' => 'Is...locked (Interrogative Passive)',
                        'vocab' => [
                            'the front door' => [
                                'id' => 'pintu depan',
                                'pos' => '(n singular)',
                            ],
                            'locked' => [
                                'id' => 'dikunci',
                                'pos' => '(v3)',
                            ],
                            'tonight' => [
                                'id' => 'malam ini',
                                'pos' => '(adv)',
                            ],
                        ],
                        'options' => [
                            'Is the front door locked tonight?',
                            'Does the front door locked tonight?',
                            'Are the front door locked tonight?',
                            'Do the front door locked tonight?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'the front door\' dengan kalimat tanya pasif menggunakan \'Is\'.',
                    ],
                    [
                        'id' => 53,
                        'id_sentence' => 'Buku-buku ini tidak disusun berdasarkan abjad di rak perpustakaan.',
                        'target_word' => 'are not arranged (Negative Passive)',
                        'vocab' => [
                            'these books' => [
                                'id' => 'buku-buku ini',
                                'pos' => '(n plural)',
                            ],
                            'not arranged' => [
                                'id' => 'tidak disusun',
                                'pos' => '(v3 phr)',
                            ],
                            'alphabetically' => [
                                'id' => 'berdasarkan abjad',
                                'pos' => '(adv)',
                            ],
                        ],
                        'options' => [
                            'These books are not arranged alphabetically on the library shelf.',
                            'These books does not arranged alphabetically on the library shelf.',
                            'These books is not arranged alphabetically on the library shelf.',
                            'These books do not arranged alphabetically on the library shelf.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'these books\' menggunakan negasi pasif \'are not arranged\'.',
                    ],
                    [
                        'id' => 54,
                        'id_sentence' => 'Apakah tamu-tamu itu diizinkan membawa hewan peliharaan ke hotel?',
                        'target_word' => 'Are...allowed (Interrogative Passive)',
                        'vocab' => [
                            'the guests' => [
                                'id' => 'tamu-tamu',
                                'pos' => '(n plural)',
                            ],
                            'allowed to' => [
                                'id' => 'diizinkan untuk',
                                'pos' => '(v3 phr)',
                            ],
                            'bring pets' => [
                                'id' => 'membawa hewan peliharaan',
                                'pos' => '(v phr)',
                            ],
                        ],
                        'options' => [
                            'Are the guests allowed to bring pets to the hotel?',
                            'Do the guests allowed to bring pets to the hotel?',
                            'Is the guests allowed to bring pets to the hotel?',
                            'Does the guests allowed to bring pets to the hotel?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'the guests\' dengan kalimat tanya pasif menggunakan \'Are\'.',
                    ],
                    [
                        'id' => 55,
                        'id_sentence' => 'Lampu di koridor sekolah belum diperbaiki sejak minggu lalu.',
                        'target_word' => 'is not fixed (Negative Passive)',
                        'vocab' => [
                            'the hallway light' => [
                                'id' => 'lampu koridor',
                                'pos' => '(n singular)',
                            ],
                            'not fixed yet' => [
                                'id' => 'belum diperbaiki',
                                'pos' => '(v3 phr)',
                            ],
                            'since last week' => [
                                'id' => 'sejak minggu lalu',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'The hallway light is not fixed yet since last week.',
                            'The hallway light does not fixed yet since last week.',
                            'The hallway light are not fixed yet since last week.',
                            'The hallway light not is fixed yet since last week.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'The hallway light\' memakai negasi pasif \'is not fixed\'.',
                    ],
                    [
                        'id' => 56,
                        'id_sentence' => 'Mengapa surat ini belum dikirim ke alamat yang benar?',
                        'target_word' => 'Why is...not sent (Interrogative Negative Passive)',
                        'vocab' => [
                            'this letter' => [
                                'id' => 'surat ini',
                                'pos' => '(n singular)',
                            ],
                            'not sent' => [
                                'id' => 'belum dikirim',
                                'pos' => '(v3 phr)',
                            ],
                            'correct address' => [
                                'id' => 'alamat yang benar',
                                'pos' => '(n)',
                            ],
                        ],
                        'options' => [
                            'Why is this letter not sent to the correct address?',
                            'Why does this letter not sent to the correct address?',
                            'Why are this letter not sent to the correct address?',
                            'Why do this letter not sent to the correct address?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'this letter\' menggunakan \'Why is ... not sent\'.',
                    ],
                    [
                        'id' => 57,
                        'id_sentence' => 'Kursi-kursi di aula belum disusun untuk acara nanti malam.',
                        'target_word' => 'are not arranged (Negative Passive)',
                        'vocab' => [
                            'the chairs' => [
                                'id' => 'kursi-kursi',
                                'pos' => '(n plural)',
                            ],
                            'not arranged yet' => [
                                'id' => 'belum disusun',
                                'pos' => '(v3 phr)',
                            ],
                            'for tonight\'s event' => [
                                'id' => 'untuk acara nanti malam',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'The chairs in the hall are not arranged yet for tonight\'s event.',
                            'The chairs in the hall does not arranged yet for tonight\'s event.',
                            'The chairs in the hall is not arranged yet for tonight\'s event.',
                            'The chairs in the hall do not arranged yet for tonight\'s event.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'The chairs\' memakai negasi pasif \'are not arranged\'.',
                    ],
                    [
                        'id' => 58,
                        'id_sentence' => 'Apakah hadiah ulang tahun itu sudah dibungkus dengan rapi?',
                        'target_word' => 'Is...wrapped (Interrogative Passive)',
                        'vocab' => [
                            'the birthday present' => [
                                'id' => 'hadiah ulang tahun',
                                'pos' => '(n singular)',
                            ],
                            'wrapped neatly' => [
                                'id' => 'dibungkus rapi',
                                'pos' => '(v3 phr)',
                            ],
                            'already' => [
                                'id' => 'sudah',
                                'pos' => '(adv)',
                            ],
                        ],
                        'options' => [
                            'Is the birthday present wrapped neatly already?',
                            'Does the birthday present wrapped neatly already?',
                            'Are the birthday present wrapped neatly already?',
                            'Do the birthday present wrapped neatly already?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'the birthday present\' menggunakan \'Is\' dalam kalimat tanya pasif.',
                    ],
                    [
                        'id' => 59,
                        'id_sentence' => 'Baju-baju itu tidak disetrika sebelum dimasukkan ke lemari.',
                        'target_word' => 'are not ironed (Negative Passive)',
                        'vocab' => [
                            'those clothes' => [
                                'id' => 'baju-baju itu',
                                'pos' => '(n plural)',
                            ],
                            'not ironed' => [
                                'id' => 'tidak disetrika',
                                'pos' => '(v3 phr)',
                            ],
                            'before being put away' => [
                                'id' => 'sebelum dimasukkan ke lemari',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'Those clothes are not ironed before being put away.',
                            'Those clothes does not ironed before being put away.',
                            'Those clothes is not ironed before being put away.',
                            'Those clothes do not ironed before being put away.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak \'Those clothes\' memakai negasi pasif \'are not ironed\'.',
                    ],
                    [
                        'id' => 60,
                        'id_sentence' => 'Kapan biasanya pintu gerbang sekolah dibuka setiap pagi?',
                        'target_word' => 'When is...opened (Interrogative Passive)',
                        'vocab' => [
                            'the school gate' => [
                                'id' => 'gerbang sekolah',
                                'pos' => '(n singular)',
                            ],
                            'opened' => [
                                'id' => 'dibuka',
                                'pos' => '(v3)',
                            ],
                            'usually' => [
                                'id' => 'biasanya',
                                'pos' => '(adv)',
                            ],
                        ],
                        'options' => [
                            'When is the school gate usually opened every morning?',
                            'When does the school gate usually opened every morning?',
                            'When are the school gate usually opened every morning?',
                            'When do the school gate usually opened every morning?',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'the school gate\' menggunakan \'When is ... opened\'.',
                    ],
                ],
            ],
            [
                'id' => 'verbal-vs-nominal',
                'name' => 'Verbal vs Nominal: Membedakan Aksi vs Status & Eliminasi Double Predicate',
                'code' => '1.3.7',
                'concept_title' => 'Membedakan Kalimat Verbal vs Nominal dan Menghapus Double Predicate',
                'concept_description' => 'Kunci utama ketepatan tata bahasa Inggris adalah membedakan kapan menggunakan Kalimat Verbal murni (Aksi: Subjek + V1 TANPA to be) dan kapan menggunakan Kalimat Nominal (Status/Sifat: Subjek + to be + Adjective/Noun). Kesalahan penutur Indonesia paling umum adalah: (1) Menyisipkan \'is/are\' sebelum kata kerja aksi (e.g., \'My father is cooks\' -> SALAH), atau (2) Menghilangkan to be sebelum kata sifat (e.g., \'The food delicious\' -> SALAH).',
                'formula' => 'Verbal: Subject + Verb 1 (-s/-es) [DILARANG ADA TO BE] vs Nominal: Subject + to be + Adj / Noun [WAJIB TO BE]',
                'rules' => [
                    'Jika kata kerja inti adalah AKSI (cook, clean, play, walk) ➔ GUNAKAN VERBAL MURNI (jangan tambahkan is/am/are).',
                    'Jika kata berikutnya adalah KATA SIFAT (delicious, tired, busy, kind) ➔ GUNAKAN NOMINAL (wajib tambahkan is/am/are).',
                    'Waspadai kata kerja yang sering tertukar: \'The movie starts\' (verbal), bukan \'The movie is starts\'.',
                    'Bentuk negatif verbal memakai \'do/does not + V1\'; bentuk negatif nominal memakai \'is/are not + Adjective\'.',
                ],
                'exercises' => [
                    [
                        'id' => 61,
                        'id_sentence' => 'Ayah saya memasak sarapan untuk kami setiap pagi.',
                        'target_word' => 'cooks (Verbal Verb)',
                        'vocab' => [
                            'my father' => [
                                'id' => 'ayah saya',
                                'pos' => '(n singular)',
                            ],
                            'cooks' => [
                                'id' => 'memasak (aksi)',
                                'pos' => '(v)',
                            ],
                            'breakfast for us' => [
                                'id' => 'sarapan untuk kami',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'My father cooks breakfast for us every morning.',
                            'My father is cooks breakfast for us every morning.',
                            'My father is cook breakfast for us every morning.',
                            'My father cooking breakfast for us every morning.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kalimat ini adalah Kalimat Verbal murni dengan predikat aksi \'cooks\' (subjek tunggal \'father\'). DILARANG menyisipkan to be \'is\' (\'is cooks\' adalah double predicate).',
                    ],
                    [
                        'id' => 62,
                        'id_sentence' => 'Masakan buatan nenek saya sangat lezat dan selalu habis dimakan.',
                        'target_word' => 'is delicious (Nominal Predicate)',
                        'vocab' => [
                            'grandmother\'s cooking' => [
                                'id' => 'masakan buatan nenek',
                                'pos' => '(n singular)',
                            ],
                            'delicious' => [
                                'id' => 'lezat (kata sifat)',
                                'pos' => '(adj)',
                            ],
                            'always finished' => [
                                'id' => 'selalu habis',
                                'pos' => '(adj phr)',
                            ],
                        ],
                        'options' => [
                            'My grandmother\'s cooking is delicious and always finished right away.',
                            'My grandmother\'s cooking delicious and always finished right away.',
                            'My grandmother\'s cooking does delicious and always finished right away.',
                            'My grandmother\'s cooking is delicate and always finished right away.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata \'delicious\' adalah kata sifat (Adjective). Kalimat nominal WAJIB menyertakan to be \'is\' sebelum kata sifat. Menghilangkan \'is\' menghasilkan klausa yang tidak lengkap.',
                    ],
                    [
                        'id' => 63,
                        'id_sentence' => 'Guru kami menjelaskan pelajaran dengan sangat jelas dan sabar.',
                        'target_word' => 'explains (Verbal Verb)',
                        'vocab' => [
                            'our teacher' => [
                                'id' => 'guru kami',
                                'pos' => '(n singular)',
                            ],
                            'explains' => [
                                'id' => 'menjelaskan (aksi)',
                                'pos' => '(v)',
                            ],
                            'clearly and patiently' => [
                                'id' => 'dengan jelas dan sabar',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'Our teacher explains the lesson very clearly and patiently.',
                            'Our teacher is explains the lesson very clearly and patiently.',
                            'Our teacher is explain the lesson very clearly and patiently.',
                            'Our teacher does explains the lesson very clearly and patiently.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Explains\' adalah aksi verbal murni dengan subjek tunggal. Tidak boleh ditambahkan \'is\' sebelum \'explains\'.',
                    ],
                    [
                        'id' => 64,
                        'id_sentence' => 'Jalan menuju sekolah kami sangat ramai pada jam berangkat sekolah.',
                        'target_word' => 'is busy (Nominal Predicate)',
                        'vocab' => [
                            'the road to our school' => [
                                'id' => 'jalan menuju sekolah kami',
                                'pos' => '(n singular)',
                            ],
                            'busy' => [
                                'id' => 'ramai/sibuk (kata sifat)',
                                'pos' => '(adj)',
                            ],
                            'during rush hour' => [
                                'id' => 'pada jam berangkat',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'The road to our school is busy during rush hour.',
                            'The road to our school busy during rush hour.',
                            'The road to our school does busy during rush hour.',
                            'The road to our school are busy during rush hour.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Busy\' adalah kata sifat, sehingga wajib menggunakan \'is\' karena subjeknya tunggal.',
                    ],
                    [
                        'id' => 65,
                        'id_sentence' => 'Petugas perpustakaan membantu siswa mencari buku setiap hari.',
                        'target_word' => 'helps (Verbal Verb)',
                        'vocab' => [
                            'the librarian' => [
                                'id' => 'petugas perpustakaan',
                                'pos' => '(n singular)',
                            ],
                            'helps' => [
                                'id' => 'membantu (aksi)',
                                'pos' => '(v)',
                            ],
                            'find books' => [
                                'id' => 'mencari buku',
                                'pos' => '(v phr)',
                            ],
                        ],
                        'options' => [
                            'The librarian helps students find books every day.',
                            'The librarian is helps students find books every day.',
                            'The librarian is help students find books every day.',
                            'The librarian helping students find books every day.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Helps\' adalah kalimat verbal murni; tidak boleh disisipkan \'is\' sebelum kata kerja aksi.',
                    ],
                    [
                        'id' => 66,
                        'id_sentence' => 'Kami lelah setelah berjalan kaki pulang dari sekolah.',
                        'target_word' => 'are tired (Nominal Predicate)',
                        'vocab' => [
                            'we' => [
                                'id' => 'kami',
                                'pos' => '(pron)',
                            ],
                            'tired' => [
                                'id' => 'lelah (kata sifat)',
                                'pos' => '(adj)',
                            ],
                            'walking home' => [
                                'id' => 'berjalan kaki pulang',
                                'pos' => '(gerund phr)',
                            ],
                        ],
                        'options' => [
                            'We are tired after walking home from school.',
                            'We tired after walking home from school.',
                            'We does tired after walking home from school.',
                            'We is tired after walking home from school.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'We\' (jamak) dengan kata sifat \'tired\' wajib memakai \'are\'.',
                    ],
                    [
                        'id' => 67,
                        'id_sentence' => 'Pak Budi mengantar anaknya ke sekolah setiap pagi dengan motor.',
                        'target_word' => 'takes (Verbal Verb)',
                        'vocab' => [
                            'Mr. Budi' => [
                                'id' => 'Pak Budi',
                                'pos' => '(n singular)',
                            ],
                            'takes' => [
                                'id' => 'mengantar (aksi)',
                                'pos' => '(v)',
                            ],
                            'by motorbike' => [
                                'id' => 'dengan motor',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'Mr. Budi takes his son to school every morning by motorbike.',
                            'Mr. Budi is takes his son to school every morning by motorbike.',
                            'Mr. Budi is take his son to school every morning by motorbike.',
                            'Mr. Budi taking his son to school every morning by motorbike.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Takes\' adalah kalimat verbal murni dengan subjek tunggal, tanpa to be.',
                    ],
                    [
                        'id' => 68,
                        'id_sentence' => 'Film yang kami tonton semalam sangat seru dan mengharukan.',
                        'target_word' => 'is exciting (Nominal Predicate)',
                        'vocab' => [
                            'the movie' => [
                                'id' => 'film itu',
                                'pos' => '(n singular)',
                            ],
                            'exciting and touching' => [
                                'id' => 'seru dan mengharukan',
                                'pos' => '(adj phr)',
                            ],
                            'that we watched' => [
                                'id' => 'yang kami tonton',
                                'pos' => '(clause)',
                            ],
                        ],
                        'options' => [
                            'The movie that we watched last night is exciting and touching.',
                            'The movie that we watched last night exciting and touching.',
                            'The movie that we watched last night does exciting and touching.',
                            'The movie that we watched last night are exciting and touching.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Exciting\' adalah kata sifat, sehingga wajib memakai \'is\' untuk subjek tunggal \'the movie\'.',
                    ],
                    [
                        'id' => 69,
                        'id_sentence' => 'Pedagang di pasar menjual sayur dan buah segar setiap pagi.',
                        'target_word' => 'sells (Verbal Verb)',
                        'vocab' => [
                            'the vendor' => [
                                'id' => 'pedagang',
                                'pos' => '(n singular)',
                            ],
                            'sells' => [
                                'id' => 'menjual (aksi)',
                                'pos' => '(v)',
                            ],
                            'fresh vegetables and fruit' => [
                                'id' => 'sayur dan buah segar',
                                'pos' => '(n phr)',
                            ],
                        ],
                        'options' => [
                            'The vendor at the market sells fresh vegetables and fruit every morning.',
                            'The vendor at the market is sells fresh vegetables and fruit every morning.',
                            'The vendor at the market is sell fresh vegetables and fruit every morning.',
                            'The vendor at the market selling fresh vegetables and fruit every morning.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Sells\' adalah kalimat verbal murni, tanpa to be, dengan subjek tunggal.',
                    ],
                    [
                        'id' => 70,
                        'id_sentence' => 'Ruang kelas kami bersih dan rapi setiap pagi sebelum pelajaran dimulai.',
                        'target_word' => 'is clean (Nominal Predicate)',
                        'vocab' => [
                            'our classroom' => [
                                'id' => 'ruang kelas kami',
                                'pos' => '(n singular)',
                            ],
                            'clean and tidy' => [
                                'id' => 'bersih dan rapi',
                                'pos' => '(adj phr)',
                            ],
                            'before lessons begin' => [
                                'id' => 'sebelum pelajaran dimulai',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'Our classroom is clean and tidy every morning before lessons begin.',
                            'Our classroom clean and tidy every morning before lessons begin.',
                            'Our classroom does clean and tidy every morning before lessons begin.',
                            'Our classroom are clean and tidy every morning before lessons begin.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'Our classroom\' dengan kata sifat \'clean and tidy\' wajib memakai \'is\'.',
                    ],
                ],
            ],
            [
                'id' => 'verbal-nominal-passive-comparison',
                'name' => 'Verbal vs Nominal vs Passive: Komparasi Lengkap 3 Struktur Kalimat',
                'code' => '1.3.8',
                'concept_title' => 'Sintesis Komparatif: Membedakan Kalimat Verbal, Nominal, dan Pasif',
                'concept_description' => 'Seorang penulis dan pembicara bahasa Inggris yang baik mampu secara sadar memilih antara: (1) Kalimat Verbal untuk menonjolkan aksi aktif pelaku (e.g., \'My mother bakes a cake\'), (2) Kalimat Nominal untuk menerangkan status atau sifat (e.g., \'The cake is delicious\'), dan (3) Kalimat Pasif untuk menonjolkan apa yang terjadi pada objek (e.g., \'The cake is shared with the neighbors\'). Sub-lesson ini menguji kemampuan Anda memilih dan menyusun ketiga struktur secara presisi tanpa salah bentuk.',
                'formula' => 'Verbal: S + V1 (-s/-es) | Nominal: S + is/are + Adj/Noun | Passive: S + is/are + V3',
                'rules' => [
                    'Tentukan fokus: Aksi Pelaku (Verbal), Sifat/Status (Nominal), atau Penerima Aksi (Pasif).',
                    'Ingat pembeda utama to be: Verbal = NO to be; Nominal = to be + Adj/Noun; Passive = to be + V3.',
                    'Jangan rancu antara Adjective pelengkap nominal dengan Past Participle pasif.',
                    'Gunakan variasi ketiga bentuk kalimat ini dalam satu paragraf untuk menghasilkan tulisan yang lebih hidup.',
                ],
                'exercises' => [
                    [
                        'id' => 71,
                        'id_sentence' => 'Ibu saya membuat kue ulang tahun (Verbal), rasanya manis (Nominal), dan dibagikan kepada tetangga (Pasif).',
                        'target_word' => 'bakes | is sweet | is shared',
                        'vocab' => [
                            'bakes' => [
                                'id' => 'membuat (Verbal)',
                                'pos' => '(v)',
                            ],
                            'is sweet' => [
                                'id' => 'manis (Nominal)',
                                'pos' => '(v+adj)',
                            ],
                            'is shared' => [
                                'id' => 'dibagikan (Pasif)',
                                'pos' => '(v passive)',
                            ],
                        ],
                        'options' => [
                            'My mother bakes a birthday cake, it is sweet, and it is shared with the neighbors.',
                            'My mother is bakes a birthday cake, is sweet, and shared with the neighbors.',
                            'My mother bakes a birthday cake, sweet, and is share with the neighbors.',
                            'My mother is baked a birthday cake, is sweet, and is shared with the neighbors.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kombinasi tepat: Klausa 1 Verbal (\'bakes\' tanpa to be), Klausa 2 Nominal (\'is sweet\'), Klausa 3 Pasif (\'is shared\' to be + V3).',
                    ],
                    [
                        'id' => 72,
                        'id_sentence' => 'Petugas kebersihan menyapu jalan setiap pagi untuk menjaga kebersihan kota.',
                        'target_word' => 'sweeps (Verbal Active)',
                        'vocab' => [
                            'the street cleaner' => [
                                'id' => 'petugas kebersihan (pelaku aksi)',
                                'pos' => '(n singular)',
                            ],
                            'sweeps' => [
                                'id' => 'menyapu (aksi aktif)',
                                'pos' => '(v)',
                            ],
                            'to keep the city clean' => [
                                'id' => 'untuk menjaga kebersihan kota',
                                'pos' => '(inf phr)',
                            ],
                        ],
                        'options' => [
                            'The street cleaner sweeps the road every morning to keep the city clean.',
                            'The street cleaner is sweeps the road every morning to keep the city clean.',
                            'The street cleaner is swept the road every morning to keep the city clean.',
                            'The street cleaner sweep the road every morning to keep the city clean.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'The street cleaner\' adalah PELAKU aksi aktif. Bentuk kalimat yang benar adalah Verbal Aktif: \'sweeps\' (bukan pasif \'is swept\' dan bukan double predicate \'is sweeps\').',
                    ],
                    [
                        'id' => 73,
                        'id_sentence' => 'Jalan itu disapu oleh petugas kebersihan setiap pagi.',
                        'target_word' => 'is swept (Passive Verb)',
                        'vocab' => [
                            'the road' => [
                                'id' => 'jalan itu (penerima aksi)',
                                'pos' => '(n singular)',
                            ],
                            'is swept' => [
                                'id' => 'disapu (pasif)',
                                'pos' => '(v passive)',
                            ],
                            'by the street cleaner' => [
                                'id' => 'oleh petugas kebersihan',
                                'pos' => '(agent)',
                            ],
                        ],
                        'options' => [
                            'The road is swept by the street cleaner every morning.',
                            'The road sweeps by the street cleaner every morning.',
                            'The road is sweep by the street cleaner every morning.',
                            'The road are swept by the street cleaner every morning.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Di sini fokusnya adalah objek \'The road\' sebagai penerima aksi, sehingga digunakan bentuk Pasif: \'is swept\'.',
                    ],
                    [
                        'id' => 74,
                        'id_sentence' => 'Jalan yang baru disapu itu terlihat sangat bersih dan rapi.',
                        'target_word' => 'looks clean (Nominal Predicate)',
                        'vocab' => [
                            'the newly swept road' => [
                                'id' => 'jalan yang baru disapu',
                                'pos' => '(n singular)',
                            ],
                            'looks clean and tidy' => [
                                'id' => 'terlihat bersih dan rapi',
                                'pos' => '(adj phr)',
                            ],
                        ],
                        'options' => [
                            'The newly swept road looks very clean and tidy.',
                            'The newly swept road is looks very clean and tidy.',
                            'The newly swept road look very clean and tidy.',
                            'The newly swept road are looks very clean and tidy.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Looks\' di sini berfungsi seperti linking verb nominal (menyatakan status/penampilan), dipakai langsung tanpa to be tambahan karena \'looks\' sendiri sudah berperan sebagai predikatnya.',
                    ],
                    [
                        'id' => 75,
                        'id_sentence' => 'Toko itu menjual alat tulis murah untuk siswa (Verbal), harganya terjangkau (Nominal), dan dikunjungi banyak orang (Pasif).',
                        'target_word' => 'sells | is affordable | is visited',
                        'vocab' => [
                            'sells' => [
                                'id' => 'menjual (Verbal)',
                                'pos' => '(v)',
                            ],
                            'is affordable' => [
                                'id' => 'terjangkau (Nominal)',
                                'pos' => '(v+adj)',
                            ],
                            'is visited' => [
                                'id' => 'dikunjungi (Pasif)',
                                'pos' => '(v passive)',
                            ],
                        ],
                        'options' => [
                            'That shop sells cheap stationery for students, it is affordable, and it is visited by many people.',
                            'That shop is sells cheap stationery for students, affordable, and visited by many people.',
                            'That shop sells cheap stationery for students, is affordable, and is visit by many people.',
                            'That shop is sell cheap stationery for students, is affordable, and is visited by many people.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kombinasi tepat: Verbal (\'sells\'), Nominal (\'is affordable\'), Passive (\'is visited\').',
                    ],
                    [
                        'id' => 76,
                        'id_sentence' => 'Supir bus itu mengemudikan bus sekolah dengan sangat hati-hati.',
                        'target_word' => 'drives (Verbal Active)',
                        'vocab' => [
                            'the bus driver' => [
                                'id' => 'supir bus (pelaku aksi)',
                                'pos' => '(n singular)',
                            ],
                            'drives' => [
                                'id' => 'mengemudikan (aksi aktif)',
                                'pos' => '(v)',
                            ],
                            'very carefully' => [
                                'id' => 'dengan sangat hati-hati',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'The bus driver drives the school bus very carefully.',
                            'The bus driver is drives the school bus very carefully.',
                            'The bus driver is driven the school bus very carefully.',
                            'The bus driver drive the school bus very carefully.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'The bus driver\' adalah pelaku aksi aktif, sehingga memakai Verbal Aktif \'drives\'.',
                    ],
                    [
                        'id' => 77,
                        'id_sentence' => 'Bus sekolah itu dikemudikan dengan sangat hati-hati oleh supirnya.',
                        'target_word' => 'is driven (Passive Verb)',
                        'vocab' => [
                            'the school bus' => [
                                'id' => 'bus sekolah (penerima aksi)',
                                'pos' => '(n singular)',
                            ],
                            'is driven' => [
                                'id' => 'dikemudikan (pasif)',
                                'pos' => '(v passive)',
                            ],
                            'by its driver' => [
                                'id' => 'oleh supirnya',
                                'pos' => '(agent)',
                            ],
                        ],
                        'options' => [
                            'The school bus is driven very carefully by its driver.',
                            'The school bus drives very carefully by its driver.',
                            'The school bus is drive very carefully by its driver.',
                            'The school bus are driven very carefully by its driver.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Fokus pada objek \'The school bus\', sehingga digunakan bentuk Pasif: \'is driven\'.',
                    ],
                    [
                        'id' => 78,
                        'id_sentence' => 'Perpustakaan sekolah kami tenang dan nyaman untuk belajar.',
                        'target_word' => 'is quiet (Nominal Predicate)',
                        'vocab' => [
                            'our school library' => [
                                'id' => 'perpustakaan sekolah kami',
                                'pos' => '(n singular)',
                            ],
                            'quiet and comfortable' => [
                                'id' => 'tenang dan nyaman',
                                'pos' => '(adj phr)',
                            ],
                            'for studying' => [
                                'id' => 'untuk belajar',
                                'pos' => '(inf phr)',
                            ],
                        ],
                        'options' => [
                            'Our school library is quiet and comfortable for studying.',
                            'Our school library quiet and comfortable for studying.',
                            'Our school library does quiet and comfortable for studying.',
                            'Our school library are quiet and comfortable for studying.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal \'Our school library\' dengan kata sifat \'quiet\' wajib memakai \'is\'.',
                    ],
                    [
                        'id' => 79,
                        'id_sentence' => 'Petani menanam padi di sawah pada musim hujan.',
                        'target_word' => 'plants (Verbal Active)',
                        'vocab' => [
                            'the farmer' => [
                                'id' => 'petani (pelaku aksi)',
                                'pos' => '(n singular)',
                            ],
                            'plants' => [
                                'id' => 'menanam (aksi aktif)',
                                'pos' => '(v)',
                            ],
                            'during the rainy season' => [
                                'id' => 'pada musim hujan',
                                'pos' => '(adv phr)',
                            ],
                        ],
                        'options' => [
                            'The farmer plants rice in the field during the rainy season.',
                            'The farmer is plants rice in the field during the rainy season.',
                            'The farmer is planted rice in the field during the rainy season.',
                            'The farmer plant rice in the field during the rainy season.',
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek \'The farmer\' adalah pelaku aksi aktif, memakai Verbal Aktif \'plants\'.',
                    ],
                    [
                        'id' => 80,
                        'id_sentence' => 'Padi itu ditanam oleh petani di sawah pada musim hujan.',
                        'target_word' => 'is planted (Passive Verb)',
                        'vocab' => [
                            'the rice' => [
                                'id' => 'padi itu (penerima aksi)',
                                'pos' => '(n uncountable)',
                            ],
                            'is planted' => [
                                'id' => 'ditanam (pasif)',
                                'pos' => '(v passive)',
                            ],
                            'by the farmer' => [
                                'id' => 'oleh petani',
                                'pos' => '(agent)',
                            ],
                        ],
                        'options' => [
                            'The rice is planted by the farmer in the field during the rainy season.',
                            'The rice plants by the farmer in the field during the rainy season.',
                            'The rice is plant by the farmer in the field during the rainy season.',
                            'The rice are planted by the farmer in the field during the rainy season.',
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Rice\' bersifat uncountable (tunggal) dan di sini berperan sebagai penerima aksi, sehingga digunakan bentuk Pasif: \'is planted\'.',
                    ],
                ],
            ],
        ];
    }
}
