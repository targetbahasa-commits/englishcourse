<?php

namespace App\Services;

class SelfStudySimplePresentData
{
    /**
     * Get the complete Simple Present Verbal package.
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
            'banner_title' => 'Simple Present Tense: Verbal Sentences',
            'banner_subtitle' => 'Kuasai konstruksi kalimat verbal Simple Present mulai dari subjek I, You, We, They & Benda Jamak (+ V1) hingga He, She, It & Benda Tunggal (+ V1/Vs/es) dalam 8 sub-lesson komprehensif.',
            'banner_badge' => 'MODULE 1.2 VERBAL FORMS',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 1.2
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Konsep Dasar: Kalimat Verbal Simple Present Tense',
            'concept_summary' => 'Kalimat verbal adalah kalimat yang predikat utamanya berupa kata kerja aksi (Action Verb) atau kata kerja keadaan (Stative Verb). Dalam Simple Present Tense, bentuk kata kerja ditentukan oleh jenis subjeknya: apakah subjeknya termasuk kelompok (I, You, We, They, dan Benda Jamak) atau kelompok orang ketiga tunggal (He, She, It, dan Benda Tunggal).',
            'rules' => [
                [
                    'rule_title' => '1. Kelompok Subjek I, You, We, They & Benda Jamak (Plural)',
                    'rule_formula' => 'Subject (I / You / We / They / Plural Nouns) + Verb 1 (Base Form) + Object / Complement',
                    'rule_description' => 'Subjek jamak dan kata ganti I, You, We, They selalu menggunakan bentuk dasar kata kerja (V1) TANPA akhiran -s atau -es. Dilarang menyisipkan to be (am/are) sebelum kata kerja.',
                    'examples' => [
                        [
                            'subject' => 'Subjek "I"',
                            'en' => 'I read a storybook every night before bed.',
                            'id' => 'Saya membaca buku cerita setiap malam sebelum tidur.',
                            'note' => 'Subjek "I" selalu berpasangan dengan Verb 1 dasar "read" tanpa tambahan -s atau -es.'
                        ],
                        [
                            'subject' => 'Subjek "You"',
                            'en' => 'You clean your room every weekend.',
                            'id' => 'Kamu membersihkan kamarmu setiap akhir pekan.',
                            'note' => 'Subjek "You" berpasangan dengan Verb 1 dasar "clean" tanpa akhiran -s.'
                        ],
                        [
                            'subject' => 'Subjek "We"',
                            'en' => 'We walk to school together every morning.',
                            'id' => 'Kami berjalan kaki ke sekolah bersama setiap pagi.',
                            'note' => 'Subjek "We" wajib menggunakan Verb 1 dasar "walk" (bukan "walks" dan bukan "are walk").'
                        ],
                        [
                            'subject' => 'Subjek "They"',
                            'en' => 'They play football in the park on Sundays.',
                            'id' => 'Mereka bermain sepak bola di taman setiap hari Minggu.',
                            'note' => 'Subjek "They" berpasangan dengan Verb 1 dasar "play" tanpa akhiran -s.'
                        ],
                        [
                            'subject' => 'Benda Jamak (Plural Nouns)',
                            'en' => 'My friends visit the library every week.',
                            'id' => 'Teman-temanku mengunjungi perpustakaan setiap minggu.',
                            'note' => 'Subjek jamak "My friends" berbentuk plural noun, sehingga kata kerjanya adalah Verb 1 murni tanpa -s: "visit".'
                        ],
                    ],
                ],
                [
                    'rule_title' => '2. Kelompok Subjek He, She, It & Benda Tunggal',
                    'rule_formula' => 'Subject (He / She / It / Singular Nouns) + Verb 1 + (-s / -es / -ies) + Object / Complement',
                    'rule_description' => 'Subjek orang ketiga tunggal (He, She, It), nama orang tunggal, dan benda tunggal WAJIB menambahkan akhiran -s, -es, atau -ies pada kata kerjanya.',
                    'examples' => [
                        [
                            'subject' => 'Subjek "He"',
                            'en' => 'He plays basketball after school.',
                            'id' => 'Dia (laki-laki) bermain basket setelah sekolah.',
                            'note' => 'Subjek orang ketiga tunggal "He" wajib menambahkan akhiran -s pada verba: "plays".'
                        ],
                        [
                            'subject' => 'Subjek "She"',
                            'en' => 'She teaches art at the elementary school.',
                            'id' => 'Dia (perempuan) mengajar seni di sekolah dasar.',
                            'note' => 'Verba berakhiran fonem sibilan "-ch" ("teach") wajib ditambah akhiran -es: "teaches".'
                        ],
                        [
                            'subject' => 'Subjek "It"',
                            'en' => 'It rains a lot during this season.',
                            'id' => 'Hujan sering turun selama musim ini.',
                            'note' => 'Subjek "It" berpasangan dengan verba standar + -s: "rains".'
                        ],
                        [
                            'subject' => 'Benda Tunggal (Singular Noun)',
                            'en' => 'The bakery opens at seven every morning.',
                            'id' => 'Toko roti itu buka pukul tujuh setiap pagi.',
                            'note' => 'Subjek benda tunggal "The bakery" berpasangan dengan verba berakhiran -s: "opens".'
                        ],
                        [
                            'subject' => 'Nama Orang (Singular)',
                            'en' => 'Maya brushes her teeth twice a day.',
                            'id' => 'Maya menggosok giginya dua kali sehari.',
                            'note' => 'Nama tunggal "Maya" diperlakukan sebagai He/She, sehingga verba ditambah -es: "brushes".'
                        ],
                    ],
                ],
                [
                    'rule_title' => '3. Bentuk Negatif Kalimat Verbal',
                    'rule_formula' => 'Plural / I/You/We/They + DO NOT (don\'t) + Verb 1 | Singular / He/She/It + DOES NOT (doesn\'t) + Verb 1',
                    'rule_description' => 'Kalimat verbal dinegatifkan dengan bantuan auxiliary "do not" atau "does not". Setelah do/does not, kata kerja UTAMA SELALU kembali ke bentuk dasar V1 tanpa -s/-es.',
                    'examples' => [
                        [
                            'subject' => 'Subjek I, You, We, They & Jamak (DO NOT)',
                            'en' => 'We do not eat meat on Fridays.',
                            'id' => 'Kami tidak makan daging setiap hari Jumat.',
                            'note' => 'Subjek jamak / We menggunakan auxiliary "do not" diikuti bentuk dasar Verb 1 "eat".'
                        ],
                        [
                            'subject' => 'Subjek He, She, It & Tunggal (DOES NOT)',
                            'en' => 'My brother does not like spicy food.',
                            'id' => 'Kakakku tidak suka makanan pedas.',
                            'note' => 'Subjek tunggal "My brother" menggunakan auxiliary "does not", dan verba kembali ke bentuk murni "like" tanpa -s.'
                        ],
                    ],
                ],
                [
                    'rule_title' => '4. Bentuk Tanya (Interrogative)',
                    'rule_formula' => 'Do + (I/You/We/They/Plural) + Verb 1? | Does + (He/She/It/Singular) + Verb 1?',
                    'rule_description' => 'Tempatkan Do atau Does di awal kalimat tanya atau tepat setelah kata tanya WH (What, Why, How). Kata kerja kembali ke bentuk dasar V1.',
                    'examples' => [
                        [
                            'subject' => 'Subjek I, You, We, They & Jamak (DO)',
                            'en' => 'Do your friends like playing video games?',
                            'id' => 'Apakah teman-temanmu suka bermain gim video?',
                            'note' => 'Kalimat tanya diawali "Do" untuk subjek jamak "your friends", diikuti Verb 1 dasar "like".'
                        ],
                        [
                            'subject' => 'Subjek He, She, It & Tunggal (DOES)',
                            'en' => 'Does this bus stop near the mall?',
                            'id' => 'Apakah bus ini berhenti dekat mal?',
                            'note' => 'Diawali "Does" untuk subjek tunggal "this bus", dan verba utama tetap Verb 1 "stop" tanpa -s.'
                        ],
                    ],
                ],
                [
                    'rule_title' => '5. Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                    'rule_formula' => 'Konsonan + y ➔ -ies | Ch/Sh/Ss/X/O ➔ -es | Verba Standar ➔ -s',
                    'rule_description' => 'Penambahan akhiran orang ketiga tunggal mengikuti aturan ejaan fonetis bahasa Inggris standar.',
                    'examples' => [
                        [
                            'subject' => 'Konsonan + Y ➔ -IES',
                            'en' => 'She studies English every evening.',
                            'id' => 'Dia belajar Bahasa Inggris setiap sore.',
                            'note' => 'Kata kerja "study" berakhiran konsonan + y, berubah menjadi "-ies" ("studies") untuk subjek tunggal.'
                        ],
                        [
                            'subject' => 'Akhiran Ch, Sh, Ss, X, O ➔ -ES',
                            'en' => 'My father washes the car every Saturday.',
                            'id' => 'Ayahku mencuci mobil setiap hari Sabtu.',
                            'note' => 'Verba berakhiran "-sh" ("wash") mendapat tambahan "-es" ("washes").'
                        ],
                        [
                            'subject' => 'Verba Standar ➔ -S',
                            'en' => 'The train arrives at nine o\'clock.',
                            'id' => 'Kereta itu tiba pukul sembilan.',
                            'note' => 'Verba standar ("arrive") cukup ditambah "-s" ("arrives").'
                        ],
                    ],
                ],
                [
                    'rule_title' => '6. Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                    'rule_formula' => 'Subject + Adverb of Frequency (always, usually, often) + Verb 1 / V-s + Object',
                    'rule_description' => 'Adverbia frekuensi diletakkan tepat sebelum kata kerja utama dalam kalimat verbal tunggal.',
                    'examples' => [
                        [
                            'subject' => 'Subjek Jamak + Adverb of Frequency',
                            'en' => 'My parents always check my homework.',
                            'id' => 'Orang tuaku selalu memeriksa PR-ku.',
                            'note' => 'Adverb "always" diletakkan tepat sebelum kata kerja utama Verb 1 "check".'
                        ],
                        [
                            'subject' => 'Subjek Tunggal + Adverb of Frequency',
                            'en' => 'Our teacher often gives us a pop quiz.',
                            'id' => 'Guru kami sering memberikan kuis dadakan.',
                            'note' => 'Adverb "often" diletakkan sebelum kata kerja berakhiran -s: "gives".'
                        ],
                    ],
                ],
                [
                    'rule_title' => '7. Stative Verbs dalam Simple Present',
                    'rule_formula' => 'Subject + Stative Verb (understand, believe, belong, contain) + Object / Complement',
                    'rule_description' => 'Stative verbs menyatakan kondisi mental, persepsi, atau hubungan permanen dan tidak digunakan dalam continuous tense.',
                    'examples' => [
                        [
                            'subject' => 'Verba Kognisi & Persepsi',
                            'en' => 'I understand this math problem now.',
                            'id' => 'Aku memahami soal matematika ini sekarang.',
                            'note' => 'Stative verb "understand" menyatakan status kognitif dan tidak boleh berbentuk continuous (*am understanding).'
                        ],
                        [
                            'subject' => 'Verba Hubungan & Isi',
                            'en' => 'This box contains my old toys.',
                            'id' => 'Kotak ini berisi mainan lamaku.',
                            'note' => 'Stative verb "contain" menyatakan isi dalam bentuk Present tunggal: "contains".'
                        ],
                    ],
                ],
                [
                    'rule_title' => '8. Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                    'rule_formula' => 'BENAR: Subject + Verb 1 (-s/-es) | SALAH: Subject + is/are + Verb 1',
                    'rule_description' => 'Hilangkan to be (am/is/are) yang tidak diperlukan di depan kata kerja verbal murni.',
                    'examples' => [
                        [
                            'subject' => 'Bentuk Jamak (BENAR vs SALAH)',
                            'en' => 'My classmates like playing badminton. (NOT: My classmates are like)',
                            'id' => 'Teman sekelasku suka bermain bulu tangkis.',
                            'note' => 'Gunakan langsung Verb 1 "like" tanpa menyisipkan auxiliary "are".'
                        ],
                        [
                            'subject' => 'Bentuk Tunggal (BENAR vs SALAH)',
                            'en' => 'My mother cooks dinner every night. (NOT: My mother is cooks)',
                            'id' => 'Ibuku memasak makan malam setiap malam.',
                            'note' => 'Gunakan langsung verba "cooks" tanpa menyisipkan auxiliary "is".'
                        ],
                    ],
                ],
            ],
            'contrast_table' => [
                'headers' => ['Parameter Subjek', 'Kelompok I, You, We, They & Benda Jamak', 'Kelompok He, She, It & Benda Tunggal'],
                'rows' => [
                    ['Contoh Subjek', 'I, you, we, they, friends, students, parents', 'He, she, it, a student, the teacher, my sister'],
                    ['Afirmatif (+)', 'Subject + Verb 1 (e.g., play, watch)', 'Subject + Verb 1 + s/es/ies (e.g., plays, watches)'],
                    ['Negatif (-)', 'Subject + DO NOT + Verb 1', 'Subject + DOES NOT + Verb 1 (tanpa -s/-es)'],
                    ['Interrogatif (?)', 'DO + Subject + Verb 1 ... ?', 'DOES + Subject + Verb 1 ... ?'],
                    ['Kesalahan Fatal', 'They are play (SALAH ➔ Double Predicate)', 'He does not plays (SALAH ➔ Dobel -s)'],
                ],
            ],
            'common_pitfalls' => [
                [
                    'incorrect' => 'My father is cooks dinner every night.',
                    'correct' => 'My father cooks dinner every night.',
                    'explanation' => 'Kesalahan double predicate: jangan menyisipkan "is" sebelum kata kerja verbal "cooks".'
                ],
                [
                    'incorrect' => 'My sister study every evening.',
                    'correct' => 'My sister studies every evening.',
                    'explanation' => '"My sister" adalah subjek tunggal, sehingga wajib menggunakan kata kerja berakhiran -ies: "studies".'
                ],
                [
                    'incorrect' => 'My brother does not likes spicy food.',
                    'correct' => 'My brother does not like spicy food.',
                    'explanation' => 'Setelah auxiliary "does not", kata kerja utama harus kembali ke Verb 1 dasar ("like"), bukan "likes".'
                ],
                [
                    'incorrect' => 'My friends plays football every Sunday.',
                    'correct' => 'My friends play football every Sunday.',
                    'explanation' => 'Subjek jamak "My friends" berpasangan dengan Verb 1 dasar ("play"), bukan bentuk -s.'
                ],
            ],
            'exam_tips' => [
                'Selalu cari subjek inti (Head Noun). Hiraukan frasa preposisi di antara subjek dan kata kerja.',
                'Kata benda jamak tak beraturan tetap memakai Verb 1 dasar: children play, people like, men run.',
                'Perhatikan ejaan akhiran: study ➔ studies, watch ➔ watches, play ➔ plays.',
                'Gunakan Simple Present Verbal untuk kebiasaan sehari-hari dan fakta umum (misal: jadwal, rutinitas, kesukaan).'
            ],
        ];
    }

    /**
     * Get the 8 structured sub-lessons with 10 exercises each (80 exercises total).
     */
    public static function getSubLessons(): array
    {
        return [
            // ==========================================
            // SUB-LESSON 1: Subjek I, You, We, They & Benda Jamak + V1
            // ==========================================
            [
                'id' => 'verbal-plural-v1',
                'name' => 'Subjek I, You, We, They & Benda Jamak + V1',
                'code' => '1.2.1',
                'concept_title' => 'Kalimat Verbal dengan Subjek I, You, We, They, dan Kata Benda Jamak',
                'concept_description' => 'Subjek orang pertama (I, We), orang kedua (You), orang ketiga jamak (They), serta seluruh kata benda jamak (misalnya: kids, friends, dogs, students) menggunakan bentuk dasar kata kerja (Verb 1) tanpa akhiran -s atau -es. Dilarang menyisipkan to be (am/are) sebelum Verb 1.',
                'formula' => 'S (I / You / We / They / Plural Nouns) + Verb 1 (Base Form) + Object / Complement',
                'rules' => [
                    'Gunakan Verb 1 dasar murni tanpa tambahan -s atau -es.',
                    'Dilarang melakukan double predicate seperti "We are play" ➔ wajib "We play".',
                    'Kata benda jamak tak beraturan seperti "children", "people" wajib berpasangan dengan Verb 1 dasar.',
                    'Frasa subjek jamak gabungan dengan "and" (misal: "My mom and dad") memerlukan Verb 1 dasar.'
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'sub_lesson' => 'Subjek I, You, We, They & Benda Jamak + V1',
                        'id_sentence' => 'Para tetangga mengamati burung-burung di taman setiap minggu.',
                        'target_word' => 'watch (V1)',
                        'options' => [
                            'The neighbors watch the birds in the park every week.',
                            'The neighbors watches the birds in the park every week.',
                            'The neighbors are watch the birds in the park every week.',
                            'The neighbors is watch the birds in the park every week.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "The neighbors" adalah benda jamak (plural noun), sehingga kata kerja yang digunakan adalah Verb 1 murni tanpa -s: "watch". Opsi "watches" salah untuk jamak, dan "are watch" adalah double predicate.',
                        'vocab' => [
                            'neighbors' => ['id' => 'para tetangga', 'pos' => '(n)'],
                            'watch' => ['id' => 'mengamati', 'pos' => '(v)'],
                            'birds' => ['id' => 'burung-burung', 'pos' => '(n)'],
                            'every week' => ['id' => 'setiap minggu', 'pos' => '(adv phr)'],
                        ],
                        'example' => [
                            'id' => 'Para siswa mengamati tanaman di kebun sekolah.',
                            'en' => 'The students observe the plants in the school garden.'
                        ]
                    ],
                    [
                        'id' => 2,
                        'sub_lesson' => 'Subjek I, You, We, They & Benda Jamak + V1',
                        'id_sentence' => 'Kami mengumpulkan daun-daun kering dari lima pohon berbeda untuk prakarya.',
                        'target_word' => 'collect (V1)',
                        'options' => [
                            'We collect dry leaves from five different trees for our craft project.',
                            'We collects dry leaves from five different trees for our craft project.',
                            'We are collect dry leaves from five different trees for our craft project.',
                            'We collecting dry leaves from five different trees for our craft project.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "We" wajib berpasangan dengan Verb 1 dasar "collect". Opsi "collects" salah karena -s hanya untuk orang ketiga tunggal.',
                        'vocab' => [
                            'collect' => ['id' => 'mengumpulkan', 'pos' => '(v)'],
                            'dry leaves' => ['id' => 'daun-daun kering', 'pos' => '(n)'],
                            'different trees' => ['id' => 'pohon berbeda', 'pos' => '(n)'],
                            'craft project' => ['id' => 'proyek prakarya', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Kami memeriksa tas sekolah dengan teliti setiap pagi.',
                            'en' => 'We check our school bags carefully every morning.'
                        ]
                    ],
                    [
                        'id' => 3,
                        'sub_lesson' => 'Subjek I, You, We, They & Benda Jamak + V1',
                        'id_sentence' => 'Nilai-nilai ujian ini menunjukkan peningkatan yang bagus dari bulan lalu.',
                        'target_word' => 'show (V1 - Plural)',
                        'options' => [
                            'These exam scores show a good improvement from last month.',
                            'These exam scores shows a good improvement from last month.',
                            'These exam scores is show a good improvement from last month.',
                            'These exam scores are shows a good improvement from last month.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "These exam scores" berbentuk jamak, sehingga predikatnya adalah Verb 1 jamak "show".',
                        'vocab' => [
                            'exam scores' => ['id' => 'nilai ujian', 'pos' => '(n)'],
                            'show' => ['id' => 'menunjukkan', 'pos' => '(v)'],
                            'good improvement' => ['id' => 'peningkatan bagus', 'pos' => '(n)'],
                            'last month' => ['id' => 'bulan lalu', 'pos' => '(adv phr)'],
                        ],
                        'example' => [
                            'id' => 'Angka-angka ini mengonfirmasi bahwa latihan kita berhasil.',
                            'en' => 'These numbers confirm that our practice is working.'
                        ]
                    ],
                    [
                        'id' => 4,
                        'sub_lesson' => 'Subjek I, You, We, They & Benda Jamak + V1',
                        'id_sentence' => 'Mereka membagikan foto liburan di media sosial setiap bulan.',
                        'target_word' => 'share (V1)',
                        'options' => [
                            'They share vacation photos on social media every month.',
                            'They shares vacation photos on social media every month.',
                            'They are share vacation photos on social media every month.',
                            'They sharing vacation photos on social media every month.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "They" berpasangan dengan Verb 1 dasar "share" tanpa akhiran -es.',
                        'vocab' => [
                            'share' => ['id' => 'membagikan', 'pos' => '(v)'],
                            'vacation photos' => ['id' => 'foto liburan', 'pos' => '(n)'],
                            'social media' => ['id' => 'media sosial', 'pos' => '(n)'],
                            'every month' => ['id' => 'setiap bulan', 'pos' => '(adv phr)'],
                        ],
                        'example' => [
                            'id' => 'Mereka mengunggah video baru setiap minggu.',
                            'en' => 'They post a new video every week.'
                        ]
                    ],
                    [
                        'id' => 5,
                        'sub_lesson' => 'Subjek I, You, We, They & Benda Jamak + V1',
                        'id_sentence' => 'Banyak sekolah dasar menawarkan kelas musik gratis bagi murid-murid baru.',
                        'target_word' => 'offer (V1)',
                        'options' => [
                            'Many elementary schools offer free music classes to new students.',
                            'Many elementary schools offers free music classes to new students.',
                            'Many elementary schools is offer free music classes to new students.',
                            'Many elementary schools are offer free music classes to new students.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "schools" berbentuk jamak (plural), maka verba yang benar adalah "offer" (V1).',
                        'vocab' => [
                            'elementary schools' => ['id' => 'sekolah dasar', 'pos' => '(n)'],
                            'offer' => ['id' => 'menawarkan', 'pos' => '(v)'],
                            'free music classes' => ['id' => 'kelas musik gratis', 'pos' => '(n)'],
                            'new students' => ['id' => 'murid baru', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Perpustakaan menyediakan buku cerita untuk anak-anak.',
                            'en' => 'Libraries provide storybooks for children.'
                        ]
                    ],
                    [
                        'id' => 6,
                        'sub_lesson' => 'Subjek I, You, We, They & Benda Jamak + V1',
                        'id_sentence' => 'Saya berpendapat bahwa olahraga memegang peranan penting dalam hidup sehat.',
                        'target_word' => 'believe (V1)',
                        'options' => [
                            'I believe that exercise plays an important role in a healthy life.',
                            'I believes that exercise plays an important role in a healthy life.',
                            'I am believe that exercise plays an important role in a healthy life.',
                            'I believing that exercise plays an important role in a healthy life.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "I" selalu menggunakan kata kerja dasar Verb 1 ("believe"), bukan "believes" dan bukan "am believe".',
                        'vocab' => [
                            'believe' => ['id' => 'berpendapat / percaya', 'pos' => '(v)'],
                            'exercise' => ['id' => 'olahraga', 'pos' => '(n)'],
                            'important role' => ['id' => 'peranan penting', 'pos' => '(n)'],
                            'healthy life' => ['id' => 'hidup sehat', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Saya pikir membaca buku membantu kita belajar kata baru.',
                            'en' => 'I think reading books helps us learn new words.'
                        ]
                    ],
                    [
                        'id' => 7,
                        'sub_lesson' => 'Subjek I, You, We, They & Benda Jamak + V1',
                        'id_sentence' => 'Kedua tim itu bermain dengan semangat dalam pertandingan final.',
                        'target_word' => 'play (V1)',
                        'options' => [
                            'Both teams play with enthusiasm in the final match.',
                            'Both teams plays with enthusiasm in the final match.',
                            'Both teams is play with enthusiasm in the final match.',
                            'Both teams are plays with enthusiasm in the final match.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "Both teams" adalah jamak (dua tim), sehingga verba yang tepat adalah "play" (Verb 1).',
                        'vocab' => [
                            'both teams' => ['id' => 'kedua tim', 'pos' => '(n)'],
                            'play' => ['id' => 'bermain', 'pos' => '(v)'],
                            'enthusiasm' => ['id' => 'semangat', 'pos' => '(n)'],
                            'final match' => ['id' => 'pertandingan final', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Kakak dan adik berbagi mainan setiap sore.',
                            'en' => 'Brother and sister share toys every afternoon.'
                        ]
                    ],
                    [
                        'id' => 8,
                        'sub_lesson' => 'Subjek I, You, We, They & Benda Jamak + V1',
                        'id_sentence' => 'Kamu tahu bahwa aturan baru ini berlaku untuk semua anggota klub.',
                        'target_word' => 'apply (V1)',
                        'options' => [
                            'You know that these new rules apply to all club members.',
                            'You knows that these new rules applies to all club members.',
                            'You are know that these new rules is apply to all club members.',
                            'You knowing that these new rules applying to all club members.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "You" berpasangan dengan "know" (V1), dan subjek jamak "rules" berpasangan dengan "apply" (V1).',
                        'vocab' => [
                            'know' => ['id' => 'tahu', 'pos' => '(v)'],
                            'new rules' => ['id' => 'aturan baru', 'pos' => '(n)'],
                            'apply to' => ['id' => 'berlaku untuk', 'pos' => '(v phr)'],
                            'club members' => ['id' => 'anggota klub', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Kamu lihat bahwa aturan itu melindungi semua pemain.',
                            'en' => 'You see that the rules protect all the players.'
                        ]
                    ],
                    [
                        'id' => 9,
                        'sub_lesson' => 'Subjek I, You, We, They & Benda Jamak + V1',
                        'id_sentence' => 'Keluarga-keluarga di kompleks itu menghasilkan banyak sampah daur ulang setiap minggu.',
                        'target_word' => 'produce (V1)',
                        'options' => [
                            'Families in the complex produce a lot of recyclable waste every week.',
                            'Families in the complex produces a lot of recyclable waste every week.',
                            'Families in the complex are produce a lot of recyclable waste every week.',
                            'Families in the complex is producing a lot of recyclable waste every week.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Families" berbentuk jamak, sehingga membutuhkan Verb 1 "produce" tanpa -s.',
                        'vocab' => [
                            'families' => ['id' => 'keluarga-keluarga', 'pos' => '(n)'],
                            'produce' => ['id' => 'menghasilkan', 'pos' => '(v)'],
                            'recyclable waste' => ['id' => 'sampah daur ulang', 'pos' => '(n)'],
                            'every week' => ['id' => 'setiap minggu', 'pos' => '(adv phr)'],
                        ],
                        'example' => [
                            'id' => 'Pabrik-pabrik roti itu membuat ratusan roti setiap hari.',
                            'en' => 'The bakeries make hundreds of loaves every day.'
                        ]
                    ],
                    [
                        'id' => 10,
                        'sub_lesson' => 'Subjek I, You, We, They & Benda Jamak + V1',
                        'id_sentence' => 'Kipas angin dan jendela terbuka menyejukkan ruangan kami saat musim panas.',
                        'target_word' => 'cool (V1 - Compound Subject)',
                        'options' => [
                            'A fan and an open window cool our room during summer.',
                            'A fan and an open window cools our room during summer.',
                            'A fan and an open window are cool our room during summer.',
                            'A fan and an open window is cool our room during summer.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Dua subjek yang digabungkan kata sambung "and" membentuk compound subject jamak, sehingga memerlukan Verb 1 "cool".',
                        'vocab' => [
                            'fan' => ['id' => 'kipas angin', 'pos' => '(n)'],
                            'open window' => ['id' => 'jendela terbuka', 'pos' => '(n)'],
                            'cool' => ['id' => 'menyejukkan', 'pos' => '(v)'],
                            'summer' => ['id' => 'musim panas', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Buku dan musik membantu aku rileks setelah sekolah.',
                            'en' => 'Books and music help me relax after school.'
                        ]
                    ],
                ],
            ],

            // ==========================================
            // SUB-LESSON 2: Subjek He, She, It & Benda Tunggal + V1/Vs/es
            // ==========================================
            [
                'id' => 'verbal-singular-vses',
                'name' => 'Subjek He, She, It & Benda Tunggal + V1/Vs/es',
                'code' => '1.2.2',
                'concept_title' => 'Kalimat Verbal dengan Subjek He, She, It, dan Kata Benda Tunggal',
                'concept_description' => 'Subjek orang ketiga tunggal (He, She, It), nama orang tunggal, kata benda tunggal (the teacher, the dog, the bus), serta kata benda tak dapat dihitung (misalnya: water, money, homework) menambahkan akhiran -s, -es, atau -ies pada kata kerja utama (Verb 1). Aturan ini penting dalam tata bahasa Inggris sehari-hari.',
                'formula' => 'S (He / She / It / Singular & Uncountable Nouns) + Verb 1(-s / -es / -ies) + Object / Complement',
                'rules' => [
                    'Wajib menambahkan akhiran -s/-es pada kata kerja jika subjeknya tunggal atau uncountable.',
                    'Kata kerja berakhiran -ch, -sh, -s, -x, -z, dan -o ditambah -es (misal: watches, fixes, goes).',
                    'Kata kerja berakhiran konsonan + y berubah menjadi -ies (misal: carries, tries, flies).',
                    'Uncountable nouns (uang/money, air/water, pekerjaan rumah/homework) berstatus singular dan wajib mengambil verba berakhiran -s/-es.',
                    'Dilarang melakukan double predicate seperti "She is cooks" ➔ WAJIB "She cooks".'
                ],
                'exercises' => [
                    [
                        'id' => 11,
                        'sub_lesson' => 'Subjek He, She, It & Benda Tunggal + V1/Vs/es',
                        'id_sentence' => 'Kakakku memeriksa kembali jadwal pelajarannya setiap malam.',
                        'target_word' => 'verifies (V1 + -ies)',
                        'options' => [
                            'My sister verifies her class schedule every night.',
                            'My sister verify her class schedule every night.',
                            'My sister is verifies her class schedule every night.',
                            'My sister are verify her class schedule every night.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "My sister" adalah orang ketiga tunggal (she), sehingga kata kerja "verify" (konsonan + y) berubah menjadi "verifies".',
                        'vocab' => [
                            'sister' => ['id' => 'kakak perempuan', 'pos' => '(n)'],
                            'verify' => ['id' => 'memeriksa kembali', 'pos' => '(v)'],
                            'class schedule' => ['id' => 'jadwal pelajaran', 'pos' => '(n)'],
                            'every night' => ['id' => 'setiap malam', 'pos' => '(adv phr)'],
                        ],
                        'example' => [
                            'id' => 'Guru itu memastikan jawaban kita benar.',
                            'en' => 'The teacher confirms that our answers are correct.'
                        ]
                    ],
                    [
                        'id' => 12,
                        'sub_lesson' => 'Subjek He, She, It & Benda Tunggal + V1/Vs/es',
                        'id_sentence' => 'Cuaca cerah menunjukkan hari yang bagus untuk piknik.',
                        'target_word' => 'shows (V1 + -s - Uncountable Subject)',
                        'options' => [
                            'Sunny weather shows a good day for a picnic.',
                            'Sunny weather show a good day for a picnic.',
                            'Sunny weather is shows a good day for a picnic.',
                            'Sunny weather are show a good day for a picnic.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Weather" adalah uncountable noun (bersifat tunggal), sehingga kata kerjanya wajib berakhiran -s: "shows".',
                        'vocab' => [
                            'sunny weather' => ['id' => 'cuaca cerah', 'pos' => '(n)'],
                            'show' => ['id' => 'menunjukkan', 'pos' => '(v)'],
                            'good day' => ['id' => 'hari yang bagus', 'pos' => '(n)'],
                            'picnic' => ['id' => 'piknik', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Berita terbaru menunjukkan perbaikan cuaca besok.',
                            'en' => 'The latest news indicates better weather tomorrow.'
                        ]
                    ],
                    [
                        'id' => 13,
                        'sub_lesson' => 'Subjek He, She, It & Benda Tunggal + V1/Vs/es',
                        'id_sentence' => 'Aturan sekolah yang baru ini melindungi hak-hak semua murid.',
                        'target_word' => 'protects (V1 + -s)',
                        'options' => [
                            'This new school rule protects the rights of all students.',
                            'This new school rule protect the rights of all students.',
                            'This new school rule is protects the rights of all students.',
                            'This new school rule are protect the rights of all students.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"This new school rule" adalah singular noun, sehingga predikat verbalnya wajib berakhiran -s: "protects".',
                        'vocab' => [
                            'school rule' => ['id' => 'aturan sekolah', 'pos' => '(n)'],
                            'protect' => ['id' => 'melindungi', 'pos' => '(v)'],
                            'rights' => ['id' => 'hak-hak', 'pos' => '(n)'],
                            'all students' => ['id' => 'semua murid', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Kebijakan baru mengharuskan semua murid memakai helm bersepeda.',
                            'en' => 'The new policy requires all students to wear a bicycle helmet.'
                        ]
                    ],
                    [
                        'id' => 14,
                        'sub_lesson' => 'Subjek He, She, It & Benda Tunggal + V1/Vs/es',
                        'id_sentence' => 'Mesin cuci itu memproses pakaian kotor dalam waktu satu jam.',
                        'target_word' => 'processes (V1 + -es)',
                        'options' => [
                            'The washing machine processes the dirty clothes in one hour.',
                            'The washing machine process the dirty clothes in one hour.',
                            'The washing machine is processes the dirty clothes in one hour.',
                            'The washing machine are process the dirty clothes in one hour.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja "process" berakhiran huruf ganda -ss. Untuk subjek tunggal "The washing machine", imbuhannya adalah -es: "processes".',
                        'vocab' => [
                            'washing machine' => ['id' => 'mesin cuci', 'pos' => '(n)'],
                            'process' => ['id' => 'memproses', 'pos' => '(v)'],
                            'dirty clothes' => ['id' => 'pakaian kotor', 'pos' => '(n)'],
                            'one hour' => ['id' => 'satu jam', 'pos' => '(adv phr)'],
                        ],
                        'example' => [
                            'id' => 'Komputer sekolah itu mengakses situs pembelajaran.',
                            'en' => 'The school computer accesses the learning website.'
                        ]
                    ],
                    [
                        'id' => 15,
                        'sub_lesson' => 'Subjek He, She, It & Benda Tunggal + V1/Vs/es',
                        'id_sentence' => 'Pelatih tim itu mengkritik kurangnya latihan sebelum pertandingan.',
                        'target_word' => 'criticizes (V1 + -s)',
                        'options' => [
                            'The team coach criticizes the lack of practice before the match.',
                            'The team coach criticize the lack of practice before the match.',
                            'The team coach is criticizes the lack of practice before the match.',
                            'The team coach are criticize the lack of practice before the match.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "The team coach" (orang ketiga tunggal) membutuhkan verba berakhiran -s: "criticizes".',
                        'vocab' => [
                            'team coach' => ['id' => 'pelatih tim', 'pos' => '(n)'],
                            'criticize' => ['id' => 'mengkritik', 'pos' => '(v)'],
                            'lack of practice' => ['id' => 'kurangnya latihan', 'pos' => '(n)'],
                            'match' => ['id' => 'pertandingan', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Kritikus film itu meneliti alur cerita film baru.',
                            'en' => 'The film critic examines the plot of the new movie.'
                        ]
                    ],
                    [
                        'id' => 16,
                        'sub_lesson' => 'Subjek He, She, It & Benda Tunggal + V1/Vs/es',
                        'id_sentence' => 'Anak kucing itu mengalami perubahan besar setelah divaksin.',
                        'target_word' => 'undergoes (V1 + -es / akhiran -o)',
                        'options' => [
                            'The kitten undergoes a big change after getting vaccinated.',
                            'The kitten undergo a big change after getting vaccinated.',
                            'The kitten is undergoes a big change after getting vaccinated.',
                            'The kitten are undergo a big change after getting vaccinated.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja "undergo" berakhiran huruf vokal -o, sehingga subjek tunggal "The kitten" wajib menambahkan -es: "undergoes".',
                        'vocab' => [
                            'kitten' => ['id' => 'anak kucing', 'pos' => '(n)'],
                            'undergo' => ['id' => 'mengalami', 'pos' => '(v)'],
                            'big change' => ['id' => 'perubahan besar', 'pos' => '(n)'],
                            'vaccinated' => ['id' => 'divaksin', 'pos' => '(adj)'],
                        ],
                        'example' => [
                            'id' => 'Tanaman itu mengalami pertumbuhan pesat saat musim hujan.',
                            'en' => 'The plant undergoes rapid growth during the rainy season.'
                        ]
                    ],
                    [
                        'id' => 17,
                        'sub_lesson' => 'Subjek He, She, It & Benda Tunggal + V1/Vs/es',
                        'id_sentence' => 'Buku cerita ini merangkum petualangan seru selama satu tahun.',
                        'target_word' => 'summarizes (V1 + -s)',
                        'options' => [
                            'This storybook summarizes an exciting adventure over one year.',
                            'This storybook summarize an exciting adventure over one year.',
                            'This storybook is summarizes an exciting adventure over one year.',
                            'This storybook are summarize an exciting adventure over one year.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"This storybook" adalah singular noun, sehingga memerlukan kata kerja tunggal "summarizes".',
                        'vocab' => [
                            'storybook' => ['id' => 'buku cerita', 'pos' => '(n)'],
                            'summarize' => ['id' => 'merangkum', 'pos' => '(v)'],
                            'exciting adventure' => ['id' => 'petualangan seru', 'pos' => '(n)'],
                            'one year' => ['id' => 'satu tahun', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Halaman pertama merangkum tujuan utama cerita.',
                            'en' => 'The first page summarizes the main goal of the story.'
                        ]
                    ],
                    [
                        'id' => 18,
                        'sub_lesson' => 'Subjek He, She, It & Benda Tunggal + V1/Vs/es',
                        'id_sentence' => 'Toko buku itu mengalokasikan sudut khusus untuk buku anak-anak.',
                        'target_word' => 'allocates (V1 + -s)',
                        'options' => [
                            'The bookstore allocates a special corner for children\'s books.',
                            'The bookstore allocate a special corner for children\'s books.',
                            'The bookstore is allocates a special corner for children\'s books.',
                            'The bookstore are allocate a special corner for children\'s books.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "bookstore" berbentuk tunggal (it), sehingga verba yang tepat adalah "allocates".',
                        'vocab' => [
                            'bookstore' => ['id' => 'toko buku', 'pos' => '(n)'],
                            'allocate' => ['id' => 'mengalokasikan', 'pos' => '(v)'],
                            'special corner' => ['id' => 'sudut khusus', 'pos' => '(n)'],
                            'children\'s books' => ['id' => 'buku anak-anak', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Sekolah itu menyediakan ruang khusus untuk olahraga.',
                            'en' => 'The school provides a special room for sports.'
                        ]
                    ],
                    [
                        'id' => 19,
                        'sub_lesson' => 'Subjek He, She, It & Benda Tunggal + V1/Vs/es',
                        'id_sentence' => 'Buku pelajaran ini menjelaskan siklus air dengan gambar yang jelas.',
                        'target_word' => 'explains (V1 + -s)',
                        'options' => [
                            'This textbook explains the water cycle with clear pictures.',
                            'This textbook explain the water cycle with clear pictures.',
                            'This textbook is explains the water cycle with clear pictures.',
                            'This textbook are explain the water cycle with clear pictures.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Head noun kalimat adalah "This textbook" (singular). Kata kerja yang berpasangan adalah "explains".',
                        'vocab' => [
                            'textbook' => ['id' => 'buku pelajaran', 'pos' => '(n)'],
                            'explain' => ['id' => 'menjelaskan', 'pos' => '(v)'],
                            'water cycle' => ['id' => 'siklus air', 'pos' => '(n)'],
                            'clear pictures' => ['id' => 'gambar yang jelas', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Diagram ini menjelaskan bagaimana tumbuhan tumbuh.',
                            'en' => 'This diagram shows how plants grow.'
                        ]
                    ],
                    [
                        'id' => 20,
                        'sub_lesson' => 'Subjek He, She, It & Benda Tunggal + V1/Vs/es',
                        'id_sentence' => 'Setiap anggota kelompok membawa ide unik ke dalam diskusi tugas.',
                        'target_word' => 'brings (V1 + -s - "Each" Subject)',
                        'options' => [
                            'Each group member brings a unique idea to the assignment discussion.',
                            'Each group member bring a unique idea to the assignment discussion.',
                            'Each group member are bring a unique idea to the assignment discussion.',
                            'Each group member is brings a unique idea to the assignment discussion.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek yang diawali "Each" atau "Every" selalu berstatus singular (tunggal) dan wajib berpasangan dengan Verb berakhiran -s: "brings".',
                        'vocab' => [
                            'each group member' => ['id' => 'setiap anggota kelompok', 'pos' => '(n)'],
                            'bring' => ['id' => 'membawa', 'pos' => '(v)'],
                            'unique idea' => ['id' => 'ide unik', 'pos' => '(n)'],
                            'assignment discussion' => ['id' => 'diskusi tugas', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Setiap peserta lomba menyerahkan kartu pendaftaran.',
                            'en' => 'Every contestant submits a registration card.'
                        ]
                    ],
                ],
            ],

            // ==========================================
            // SUB-LESSON 3: Bentuk Negatif Kalimat Verbal (Do not vs. Does not + V1)
            // ==========================================
            [
                'id' => 'verbal-negative-forms',
                'name' => 'Bentuk Negatif Verbal (Do not vs. Does not + V1)',
                'code' => '1.2.3',
                'concept_title' => 'Pembentukan Kalimat Negatif Verbal dengan Auxiliary Do not & Does not',
                'concept_description' => 'Kalimat verbal tidak dapat dinegatifkan hanya dengan menyisipkan kata "not" langsung pada kata kerja. Wajib menggunakan kata kerja bantu (auxiliary verb): "do not" (don\'t) untuk subjek I, You, We, They, dan Benda Jamak; serta "does not" (doesn\'t) untuk subjek He, She, It, dan Benda Tunggal. Yang paling krusial: setelah "does not", kata kerja utama SELALU kembali ke bentuk dasar V1 tanpa akhiran -s/-es.',
                'formula' => 'Plural / I, You, We, They + DO NOT + Verb 1 | Singular / He, She, It + DOES NOT + Verb 1 (tanpa -s/-es)',
                'rules' => [
                    'Gunakan "do not" untuk subjek I, you, we, they, dan benda jamak.',
                    'Gunakan "does not" untuk subjek he, she, it, dan benda tunggal / uncountable.',
                    'Setelah "does not", kata kerja utama WAJIB kembali ke bentuk dasar Verb 1 murni (TIDAK BOLEH "does not shows" ➔ WAJIB "does not show").',
                    'Dilarang menggunakan to be seperti "is not show" atau "are not agree" untuk menyangkal kalimat verbal.'
                ],
                'exercises' => [
                    [
                        'id' => 21,
                        'sub_lesson' => 'Bentuk Negatif Verbal (Do not vs. Does not + V1)',
                        'id_sentence' => 'Nilai-nilai ujian terbaru tidak mendukung klaim bahwa kelas kami malas.',
                        'target_word' => 'do not support (Plural)',
                        'options' => [
                            'The latest exam scores do not support the claim that our class is lazy.',
                            'The latest exam scores does not supports the claim that our class is lazy.',
                            'The latest exam scores are not support the claim that our class is lazy.',
                            'The latest exam scores is not support the claim that our class is lazy.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata "scores" adalah plural (jamak), sehingga bentuk negatif verbal yang tepat adalah "do not support". Opsi "are not support" salah karena double predicate.',
                        'vocab' => [
                            'exam scores' => ['id' => 'nilai ujian', 'pos' => '(n)'],
                            'do not support' => ['id' => 'tidak mendukung', 'pos' => '(v phr)'],
                            'claim' => ['id' => 'klaim / pernyataan', 'pos' => '(n)'],
                            'lazy' => ['id' => 'malas', 'pos' => '(adj)'],
                        ],
                        'example' => [
                            'id' => 'Hasil tes kami tidak menunjukkan masalah apa pun.',
                            'en' => 'Our test results do not show any problems.'
                        ]
                    ],
                    [
                        'id' => 22,
                        'sub_lesson' => 'Bentuk Negatif Verbal (Do not vs. Does not + V1)',
                        'id_sentence' => 'Kepala sekolah tidak menyetujui rencana membatalkan karyawisata.',
                        'target_word' => 'does not approve (Singular Subject)',
                        'options' => [
                            'The principal does not approve the plan to cancel the field trip.',
                            'The principal does not approves the plan to cancel the field trip.',
                            'The principal is not approve the plan to cancel the field trip.',
                            'The principal do not approve the plan to cancel the field trip.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "The principal" (tunggal) menggunakan "does not", dan verba utama kembali ke bentuk dasar "approve" tanpa -s.',
                        'vocab' => [
                            'principal' => ['id' => 'kepala sekolah', 'pos' => '(n)'],
                            'does not approve' => ['id' => 'tidak menyetujui', 'pos' => '(v phr)'],
                            'cancel' => ['id' => 'membatalkan', 'pos' => '(v)'],
                            'field trip' => ['id' => 'karyawisata', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Petugas perpustakaan tidak membolehkan makanan di dalam.',
                            'en' => 'The librarian does not allow food inside.'
                        ]
                    ],
                    [
                        'id' => 23,
                        'sub_lesson' => 'Bentuk Negatif Verbal (Do not vs. Does not + V1)',
                        'id_sentence' => 'Kami tidak mengabaikan masukan dari teman sekelompok saat mengerjakan tugas.',
                        'target_word' => 'do not ignore (Subject "We")',
                        'options' => [
                            'We do not ignore our group members\' input while doing the assignment.',
                            'We does not ignore our group members\' input while doing the assignment.',
                            'We are not ignore our group members\' input while doing the assignment.',
                            'We do not ignores our group members\' input while doing the assignment.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "We" berpasangan dengan auxiliary "do not" diikuti Verb 1 dasar "ignore".',
                        'vocab' => [
                            'ignore' => ['id' => 'mengabaikan', 'pos' => '(v)'],
                            'group members' => ['id' => 'teman sekelompok', 'pos' => '(n)'],
                            'input' => ['id' => 'masukan', 'pos' => '(n)'],
                            'assignment' => ['id' => 'tugas', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Kami tidak membenarkan kecurangan dalam bentuk apa pun.',
                            'en' => 'We do not condone cheating in any form.'
                        ]
                    ],
                    [
                        'id' => 24,
                        'sub_lesson' => 'Bentuk Negatif Verbal (Do not vs. Does not + V1)',
                        'id_sentence' => 'Payung murah ini tidak menjamin perlindungan penuh saat hujan deras.',
                        'target_word' => 'does not guarantee (Singular Subject)',
                        'options' => [
                            'This cheap umbrella does not guarantee full protection during heavy rain.',
                            'This cheap umbrella does not guarantees full protection during heavy rain.',
                            'This cheap umbrella is not guarantee full protection during heavy rain.',
                            'This cheap umbrella do not guarantee full protection during heavy rain.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "This cheap umbrella" mengambil auxiliary "does not" dan kata kerja murni "guarantee" tanpa akhiran -s.',
                        'vocab' => [
                            'cheap umbrella' => ['id' => 'payung murah', 'pos' => '(n)'],
                            'does not guarantee' => ['id' => 'tidak menjamin', 'pos' => '(v phr)'],
                            'full protection' => ['id' => 'perlindungan penuh', 'pos' => '(n)'],
                            'heavy rain' => ['id' => 'hujan deras', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Permainan ini tidak memerlukan baterai tambahan.',
                            'en' => 'This game does not require extra batteries.'
                        ]
                    ],
                    [
                        'id' => 25,
                        'sub_lesson' => 'Bentuk Negatif Verbal (Do not vs. Does not + V1)',
                        'id_sentence' => 'Sebagian besar anak di sekolah kami tidak mempercayai cerita hantu itu.',
                        'target_word' => 'do not believe (Plural Subject)',
                        'options' => [
                            'Most kids at our school do not believe that ghost story.',
                            'Most kids at our school does not believe that ghost story.',
                            'Most kids at our school are not believe that ghost story.',
                            'Most kids at our school do not believes that ghost story.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Most kids" adalah plural (jamak), sehingga bentuk negatifnya menggunakan "do not believe".',
                        'vocab' => [
                            'kids' => ['id' => 'anak-anak', 'pos' => '(n)'],
                            'do not believe' => ['id' => 'tidak mempercayai', 'pos' => '(v phr)'],
                            'ghost story' => ['id' => 'cerita hantu', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Banyak siswa tidak menyadari jadwal ujian sudah diumumkan.',
                            'en' => 'Many students do not realize the exam schedule has been announced.'
                        ]
                    ],
                    [
                        'id' => 26,
                        'sub_lesson' => 'Bentuk Negatif Verbal (Do not vs. Does not + V1)',
                        'id_sentence' => 'Informasi di kemasan ini tidak membuktikan bahwa produknya aman.',
                        'target_word' => 'does not prove (Uncountable Subject)',
                        'options' => [
                            'The information on this package does not prove that the product is safe.',
                            'The information on this package does not proves that the product is safe.',
                            'The information on this package is not prove that the product is safe.',
                            'The information on this package do not prove that the product is safe.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Information" adalah kata benda tak dapat dihitung (uncountable noun / tunggal), sehingga auxiliary yang tepat adalah "does not" dan verba dasarnya adalah "prove" (tanpa -s).',
                        'vocab' => [
                            'information' => ['id' => 'informasi', 'pos' => '(n)'],
                            'package' => ['id' => 'kemasan', 'pos' => '(n)'],
                            'does not prove' => ['id' => 'tidak membuktikan', 'pos' => '(v phr)'],
                            'safe' => ['id' => 'aman', 'pos' => '(adj)'],
                        ],
                        'example' => [
                            'id' => 'Petunjuk ini tidak membenarkan penggunaan dosis berlebih.',
                            'en' => 'This instruction does not justify an excessive dose.'
                        ]
                    ],
                    [
                        'id' => 27,
                        'sub_lesson' => 'Bentuk Negatif Verbal (Do not vs. Does not + V1)',
                        'id_sentence' => 'Tiket masuk taman hiburan ini tidak mencakup wahana air.',
                        'target_word' => 'does not include (Singular Subject)',
                        'options' => [
                            'This amusement park ticket does not include the water rides.',
                            'This amusement park ticket does not includes the water rides.',
                            'This amusement park ticket is not include the water rides.',
                            'This amusement park ticket do not include the water rides.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "ticket" berbentuk tunggal, maka bentuk negatifnya adalah "does not include".',
                        'vocab' => [
                            'amusement park' => ['id' => 'taman hiburan', 'pos' => '(n)'],
                            'ticket' => ['id' => 'tiket', 'pos' => '(n)'],
                            'does not include' => ['id' => 'tidak mencakup', 'pos' => '(v phr)'],
                            'water rides' => ['id' => 'wahana air', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Paket makanan ini tidak termasuk minuman.',
                            'en' => 'This meal package does not contain a drink.'
                        ]
                    ],
                    [
                        'id' => 28,
                        'sub_lesson' => 'Bentuk Negatif Verbal (Do not vs. Does not + V1)',
                        'id_sentence' => 'Peserta lomba tidak mengungkapkan nama asli mereka kepada panitia.',
                        'target_word' => 'do not reveal (Plural Subject)',
                        'options' => [
                            'The contest participants do not reveal their real names to the committee.',
                            'The contest participants does not reveal their real names to the committee.',
                            'The contest participants are not reveal their real names to the committee.',
                            'The contest participants do not reveals their real names to the committee.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "participants" berbentuk jamak, sehingga memerlukan "do not reveal" (Verb 1).',
                        'vocab' => [
                            'contest participants' => ['id' => 'peserta lomba', 'pos' => '(n)'],
                            'do not reveal' => ['id' => 'tidak mengungkapkan', 'pos' => '(v phr)'],
                            'real names' => ['id' => 'nama asli', 'pos' => '(n)'],
                            'committee' => ['id' => 'panitia', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Para pemenang tidak membagikan alamat rumah mereka.',
                            'en' => 'The winners do not share their home addresses.'
                        ]
                    ],
                    [
                        'id' => 29,
                        'sub_lesson' => 'Bentuk Negatif Verbal (Do not vs. Does not + V1)',
                        'id_sentence' => 'Ramalan cuaca ini tidak memperhitungkan kemungkinan angin kencang.',
                        'target_word' => 'does not account for (Singular Subject)',
                        'options' => [
                            'This weather forecast does not account for possible strong winds.',
                            'This weather forecast does not accounts for possible strong winds.',
                            'This weather forecast is not account for possible strong winds.',
                            'This weather forecast do not account for possible strong winds.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "This weather forecast" (tunggal) menggunakan "does not account for".',
                        'vocab' => [
                            'weather forecast' => ['id' => 'ramalan cuaca', 'pos' => '(n)'],
                            'account for' => ['id' => 'memperhitungkan', 'pos' => '(v phr)'],
                            'strong winds' => ['id' => 'angin kencang', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Peta ini tidak memperhitungkan jalan yang baru dibangun.',
                            'en' => 'This map does not consider the newly built road.'
                        ]
                    ],
                    [
                        'id' => 30,
                        'sub_lesson' => 'Bentuk Negatif Verbal (Do not vs. Does not + V1)',
                        'id_sentence' => 'Saya tidak meragukan kejujuran sahabatku.',
                        'target_word' => 'do not question (Subject "I")',
                        'options' => [
                            'I do not question my best friend\'s honesty.',
                            'I does not question my best friend\'s honesty.',
                            'I am not question my best friend\'s honesty.',
                            'I do not questions my best friend\'s honesty.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "I" selalu dinegatifkan dengan "do not" diikuti verba dasar "question".',
                        'vocab' => [
                            'question' => ['id' => 'meragukan / mempertanyakan', 'pos' => '(v)'],
                            'best friend' => ['id' => 'sahabat', 'pos' => '(n)'],
                            'honesty' => ['id' => 'kejujuran', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Saya tidak menentang keputusan ketua kelas.',
                            'en' => 'I do not oppose the class leader\'s decision.'
                        ]
                    ],
                ],
            ],

            // ==========================================
            // SUB-LESSON 4: Bentuk Tanya / Interrogatif Verbal (Do & Does + S + V1)
            // ==========================================
            [
                'id' => 'verbal-interrogative-forms',
                'name' => 'Bentuk Tanya Verbal (Do & Does + Subject + V1)',
                'code' => '1.2.4',
                'concept_title' => 'Pembentukan Kalimat Tanya Verbal dalam Simple Present Tense',
                'concept_description' => 'Kalimat tanya verbal Simple Present dibentuk dengan menempatkan kata kerja bantu (auxiliary verb) Do atau Does di depan subjek. Untuk subjek I, You, We, They, dan Benda Jamak, gunakan DO. Untuk subjek He, She, It, dan Benda Tunggal, gunakan DOES. Setelah subjek, kata kerja utama WAJIB berbentuk Verb 1 dasar (infinitive tanpa to dan tanpa -s/-es). Formula yang sama berlaku untuk pertanyaan informasi dengan kata tanya WH (What, Why, How, Which).',
                'formula' => 'Do + (I/You/We/They/Plural) + Verb 1 + ... ? | Does + (He/She/It/Singular) + Verb 1 + ... ?',
                'rules' => [
                    'Gunakan Do untuk subjek jamak dan I/You/We/They.',
                    'Gunakan Does untuk subjek tunggal dan He/She/It.',
                    'Kata kerja utama selalu kembali ke bentuk Verb 1 dasar tanpa -s/-es ("Does she like it?", BUKAN "Does she likes it?").',
                    'Jika menggunakan Question Words (What, Where, Why, How), susunannya adalah: WH-Word + Do/Does + Subject + Verb 1.',
                    'Dilarang menggunakan to be seperti "Is he play football?" ➔ WAJIB "Does he play football?".'
                ],
                'exercises' => [
                    [
                        'id' => 31,
                        'sub_lesson' => 'Bentuk Tanya Verbal (Do & Does + Subject + V1)',
                        'id_sentence' => 'Apakah perpustakaan ini meminjamkan buku komik?',
                        'target_word' => 'Does this library lend (Singular Question)',
                        'options' => [
                            'Does this library lend comic books?',
                            'Does this library lends comic books?',
                            'Is this library lend comic books?',
                            'Do this library lend comic books?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "this library" adalah tunggal, maka menggunakan auxiliary "Does". Verba utama harus kembali ke V1 "lend" tanpa akhiran -s.',
                        'vocab' => [
                            'library' => ['id' => 'perpustakaan', 'pos' => '(n)'],
                            'lend' => ['id' => 'meminjamkan', 'pos' => '(v)'],
                            'comic books' => ['id' => 'buku komik', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Apakah toko ini menjual perlengkapan sekolah?',
                            'en' => 'Does this shop sell school supplies?'
                        ]
                    ],
                    [
                        'id' => 32,
                        'sub_lesson' => 'Bentuk Tanya Verbal (Do & Does + Subject + V1)',
                        'id_sentence' => 'Apakah teman-temanmu suka bermain layang-layang di sore hari?',
                        'target_word' => 'Do your friends enjoy (Plural Question)',
                        'options' => [
                            'Do your friends enjoy flying kites in the afternoon?',
                            'Does your friends enjoy flying kites in the afternoon?',
                            'Are your friends enjoy flying kites in the afternoon?',
                            'Do your friends enjoys flying kites in the afternoon?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "your friends" adalah jamak (plural), sehingga kata bantu tanya yang tepat adalah "Do", diikuti Verb 1 dasar "enjoy".',
                        'vocab' => [
                            'friends' => ['id' => 'teman-teman', 'pos' => '(n)'],
                            'enjoy' => ['id' => 'suka / menikmati', 'pos' => '(v)'],
                            'flying kites' => ['id' => 'bermain layang-layang', 'pos' => '(v phr)'],
                            'afternoon' => ['id' => 'sore hari', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Apakah tetangga kita setuju dengan jadwal kerja bakti ini?',
                            'en' => 'Do our neighbors agree with this cleanup schedule?'
                        ]
                    ],
                    [
                        'id' => 33,
                        'sub_lesson' => 'Bentuk Tanya Verbal (Do & Does + Subject + V1)',
                        'id_sentence' => 'Bagaimana aplikasi ini mendeteksi kesalahan ejaan dalam tulisan kita?',
                        'target_word' => 'How does this app detect (WH- Question)',
                        'options' => [
                            'How does this app detect spelling mistakes in our writing?',
                            'How does this app detects spelling mistakes in our writing?',
                            'How is this app detect spelling mistakes in our writing?',
                            'How do this app detect spelling mistakes in our writing?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Pada kalimat tanya WH dengan subjek tunggal "app", urutan yang benar adalah: How + does + Subject + Verb 1 ("detect").',
                        'vocab' => [
                            'app' => ['id' => 'aplikasi', 'pos' => '(n)'],
                            'detect' => ['id' => 'mendeteksi', 'pos' => '(v)'],
                            'spelling mistakes' => ['id' => 'kesalahan ejaan', 'pos' => '(n)'],
                            'writing' => ['id' => 'tulisan', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Bagaimana mesin ini memotong rumput dengan rapi?',
                            'en' => 'How does this machine trim the grass neatly?'
                        ]
                    ],
                    [
                        'id' => 34,
                        'sub_lesson' => 'Bentuk Tanya Verbal (Do & Does + Subject + V1)',
                        'id_sentence' => 'Mengapa banyak orang di desa kami menanam padi setiap musim hujan?',
                        'target_word' => 'Why do people grow (WH- Plural)',
                        'options' => [
                            'Why do many people in our village grow rice every rainy season?',
                            'Why does many people in our village grow rice every rainy season?',
                            'Why are many people in our village grow rice every rainy season?',
                            'Why do many people in our village grows rice every rainy season?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "people" adalah jamak, maka kata bantu tanya adalah "do", diikuti Verb 1 "grow".',
                        'vocab' => [
                            'village' => ['id' => 'desa', 'pos' => '(n)'],
                            'grow' => ['id' => 'menanam', 'pos' => '(v)'],
                            'rice' => ['id' => 'padi', 'pos' => '(n)'],
                            'rainy season' => ['id' => 'musim hujan', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Mengapa banyak keluarga memelihara ayam di halaman?',
                            'en' => 'Why do many families keep chickens in the yard?'
                        ]
                    ],
                    [
                        'id' => 35,
                        'sub_lesson' => 'Bentuk Tanya Verbal (Do & Does + Subject + V1)',
                        'id_sentence' => 'Apakah cerita ini mendukung pesan moral yang diajarkan guru?',
                        'target_word' => 'Does this story support',
                        'options' => [
                            'Does this story support the moral lesson taught by the teacher?',
                            'Does this story supports the moral lesson taught by the teacher?',
                            'Is this story support the moral lesson taught by the teacher?',
                            'Do this story support the moral lesson taught by the teacher?'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"This story" adalah subjek tunggal, maka kata bantu tanya yang tepat adalah "Does", dan verb-nya "support" (tanpa -s).',
                        'vocab' => [
                            'story' => ['id' => 'cerita', 'pos' => '(n)'],
                            'support' => ['id' => 'mendukung', 'pos' => '(v)'],
                            'moral lesson' => ['id' => 'pesan moral', 'pos' => '(n)'],
                            'taught' => ['id' => 'diajarkan', 'pos' => '(v, past participle)'],
                        ],
                        'example' => [
                            'id' => 'Apakah hasil ini membuktikan tebakan kita benar?',
                            'en' => 'Does this result prove our guess correct?'
                        ]
                    ],
                    [
                        'id' => 36,
                        'sub_lesson' => 'Bentuk Tanya Verbal (Do & Does + Subject + V1)',
                        'id_sentence' => 'Berapa banyak air yang digunakan oleh kolam renang ini setiap hari?',
                        'target_word' => 'How much water does this pool use',
                        'options' => [
                            'How much water does this pool use every day?',
                            'How much water does this pool uses every day?',
                            'How much water is this pool use every day?',
                            'How much water do this pool use every day?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "pool" adalah tunggal, sehingga menggunakan "does ... use" (Verb 1).',
                        'vocab' => [
                            'water' => ['id' => 'air', 'pos' => '(n)'],
                            'pool' => ['id' => 'kolam renang', 'pos' => '(n)'],
                            'use' => ['id' => 'menggunakan', 'pos' => '(v)'],
                            'every day' => ['id' => 'setiap hari', 'pos' => '(adv phr)'],
                        ],
                        'example' => [
                            'id' => 'Berapa banyak listrik yang dipakai oleh kipas pendingin itu?',
                            'en' => 'How much electricity does that cooling fan require?'
                        ]
                    ],
                    [
                        'id' => 37,
                        'sub_lesson' => 'Bentuk Tanya Verbal (Do & Does + Subject + V1)',
                        'id_sentence' => 'Apakah kamu mengakui kesalahan dalam jawaban terakhirmu?',
                        'target_word' => 'Do you acknowledge (Subject "You")',
                        'options' => [
                            'Do you acknowledge the mistake in your last answer?',
                            'Does you acknowledge the mistake in your last answer?',
                            'Are you acknowledge the mistake in your last answer?',
                            'Do you acknowledges the mistake in your last answer?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "You" berpasangan dengan kata bantu tanya "Do", diikuti Verb 1 dasar "acknowledge".',
                        'vocab' => [
                            'acknowledge' => ['id' => 'mengakui', 'pos' => '(v)'],
                            'mistake' => ['id' => 'kesalahan', 'pos' => '(n)'],
                            'last answer' => ['id' => 'jawaban terakhir', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Apakah kamu setuju dengan hasil undian ini?',
                            'en' => 'Do you agree with this lottery result?'
                        ]
                    ],
                    [
                        'id' => 38,
                        'sub_lesson' => 'Bentuk Tanya Verbal (Do & Does + Subject + V1)',
                        'id_sentence' => 'Apakah aturan baru ini berlaku untuk semua anggota klub basket?',
                        'target_word' => 'Does this new rule apply',
                        'options' => [
                            'Does this new rule apply to all basketball club members?',
                            'Does this new rule applies to all basketball club members?',
                            'Is this new rule apply to all basketball club members?',
                            'Do this new rule apply to all basketball club members?'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"Rule" adalah singular, sehingga wajib menggunakan "Does" dan verba "apply" (V1).',
                        'vocab' => [
                            'new rule' => ['id' => 'aturan baru', 'pos' => '(n)'],
                            'apply to' => ['id' => 'berlaku untuk', 'pos' => '(v phr)'],
                            'basketball club members' => ['id' => 'anggota klub basket', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Apakah jadwal ini berlaku bagi seluruh murid kelas lima?',
                            'en' => 'Does this schedule apply to all fifth graders?'
                        ]
                    ],
                    [
                        'id' => 39,
                        'sub_lesson' => 'Bentuk Tanya Verbal (Do & Does + Subject + V1)',
                        'id_sentence' => 'Hal apa saja yang memicu keributan di antara kedua kucing itu?',
                        'target_word' => 'What things trigger (Subject Question - Plural)',
                        'options' => [
                            'What things trigger the commotion between the two cats?',
                            'What things triggers the commotion between the two cats?',
                            'What things does trigger the commotion between the two cats?',
                            'What things is trigger the commotion between the two cats?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Ketika kata tanya menanyakan subjek langsung berupa nomina jamak ("What things"), kata kerja langsung menggunakan Verb 1 jamak "trigger" tanpa auxiliary do/does tambahan.',
                        'vocab' => [
                            'things' => ['id' => 'hal-hal', 'pos' => '(n)'],
                            'trigger' => ['id' => 'memicu', 'pos' => '(v)'],
                            'commotion' => ['id' => 'keributan', 'pos' => '(n)'],
                            'cats' => ['id' => 'kucing-kucing', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Hal apa yang mempengaruhi suasana hati adikmu?',
                            'en' => 'What things influence your little sibling\'s mood?'
                        ]
                    ],
                    [
                        'id' => 40,
                        'sub_lesson' => 'Bentuk Tanya Verbal (Do & Does + Subject + V1)',
                        'id_sentence' => 'Apakah para siswa memahami petunjuk keselamatan di kolam renang?',
                        'target_word' => 'Do students understand',
                        'options' => [
                            'Do students understand the safety rules at the swimming pool?',
                            'Does students understand the safety rules at the swimming pool?',
                            'Are students understand the safety rules at the swimming pool?',
                            'Do students understands the safety rules at the swimming pool?'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "students" adalah plural, sehingga menggunakan auxiliary "Do" + Verb 1 "understand".',
                        'vocab' => [
                            'students' => ['id' => 'para siswa', 'pos' => '(n)'],
                            'understand' => ['id' => 'memahami', 'pos' => '(v)'],
                            'safety rules' => ['id' => 'aturan keselamatan', 'pos' => '(n)'],
                            'swimming pool' => ['id' => 'kolam renang', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Apakah para peserta mengikuti peraturan lomba?',
                            'en' => 'Do the contestants follow the competition rules?'
                        ]
                    ],
                ],
            ],

            // ==========================================
            // SUB-LESSON 5: Aturan Ejaan Akhiran Verba (-s, -es, -ies)
            // ==========================================
            [
                'id' => 'verbal-spelling-rules',
                'name' => 'Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                'code' => '1.2.5',
                'concept_title' => 'Aturan Ejaan Penambahan Akhiran -s, -es, dan -ies pada Kata Kerja',
                'concept_description' => 'Penambahan akhiran pada kata kerja orang ketiga tunggal (He, She, It, Singular Nouns) mengikuti aturan ejaan dasar bahasa Inggris: (1) Kata kerja berakhiran desis (-ch, -sh, -ss, -x, -z) dan vokal -o ditambah -es (watch ➔ watches, wash ➔ washes, go ➔ goes); (2) Kata kerja berakhiran konsonan + y berubah menjadi -ies (carry ➔ carries, study ➔ studies); (3) Kata kerja berakhiran vokal + y cukup ditambah -s saja (play ➔ plays, stay ➔ stays); (4) Kata kerja tak beraturan khusus: have ➔ has.',
                'formula' => 'Consonant + y ➔ -ies | Desis (-ch/-sh/-ss/-x/-o) ➔ -es | Vowel + y ➔ -s | Other Verbs ➔ -s',
                'rules' => [
                    'Verba berakhiran konsonan + y wajib diubah menjadi -ies (cry ➔ cries, try ➔ tries).',
                    'Verba berakhiran vokal + y TIDAK BOLEH diubah jadi -ies, cukup ditambah -s (play ➔ plays, buy ➔ buys).',
                    'Verba berakhiran bunyi desis (-s, -ss, -sh, -ch, -x) dan vokal -o wajib ditambah -es agar dapat diucapkan (kiss ➔ kisses, brush ➔ brushes).',
                    'Bentuk kepemilikan kata kerja have berubah menjadi "has" untuk subjek tunggal.'
                ],
                'exercises' => [
                    [
                        'id' => 41,
                        'sub_lesson' => 'Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                        'id_sentence' => 'Ayah menerapkan aturan baru untuk waktu bermain gawai.',
                        'target_word' => 'applies (consonant + y -> -ies)',
                        'options' => [
                            'Dad applies a new rule for screen time.',
                            'Dad applys a new rule for screen time.',
                            'Dad apply a new rule for screen time.',
                            'Dad is applies a new rule for screen time.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja "apply" berakhiran konsonan \'l\' + \'y\'. Aturan ejaannya adalah mengubah \'y\' menjadi \'ies\': "applies". Bentuk "applys" salah secara ejaan.',
                        'vocab' => [
                            'dad' => ['id' => 'ayah', 'pos' => '(n)'],
                            'apply' => ['id' => 'menerapkan', 'pos' => '(v)'],
                            'new rule' => ['id' => 'aturan baru', 'pos' => '(n)'],
                            'screen time' => ['id' => 'waktu bermain gawai', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Pelatih mengubah strategi tim sebelum pertandingan.',
                            'en' => 'The coach modifies the team strategy before the match.'
                        ]
                    ],
                    [
                        'id' => 42,
                        'sub_lesson' => 'Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                        'id_sentence' => 'Peta ini menyampaikan rute tercepat menuju taman kota.',
                        'target_word' => 'conveys (vowel + y -> -s)',
                        'options' => [
                            'This map conveys the fastest route to the city park.',
                            'This map conveies the fastest route to the city park.',
                            'This map convey the fastest route to the city park.',
                            'This map is conveys the fastest route to the city park.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja "convey" berakhiran vokal \'e\' + \'y\'. Oleh karena itu, cukup menambahkan akhiran -s saja ("conveys"). Jangan diubah menjadi "conveies".',
                        'vocab' => [
                            'map' => ['id' => 'peta', 'pos' => '(n)'],
                            'convey' => ['id' => 'menyampaikan', 'pos' => '(v)'],
                            'fastest route' => ['id' => 'rute tercepat', 'pos' => '(n)'],
                            'city park' => ['id' => 'taman kota', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Papan tulis itu menampilkan jadwal pelajaran hari ini.',
                            'en' => 'The whiteboard displays today\'s class schedule.'
                        ]
                    ],
                    [
                        'id' => 43,
                        'sub_lesson' => 'Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                        'id_sentence' => 'Juri lomba menilai kerapian dan kreativitas setiap gambar.',
                        'target_word' => 'assesses (ending in -ss -> +es)',
                        'options' => [
                            'The contest judge assesses the neatness and creativity of each drawing.',
                            'The contest judge assesss the neatness and creativity of each drawing.',
                            'The contest judge assess the neatness and creativity of each drawing.',
                            'The contest judge is assesses the neatness and creativity of each drawing.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja "assess" berakhiran konsonan desis -ss, sehingga wajib ditambah -es: "assesses". Penulisan "assesss" dengan 3 huruf \'s\' salah.',
                        'vocab' => [
                            'contest judge' => ['id' => 'juri lomba', 'pos' => '(n)'],
                            'assess' => ['id' => 'menilai', 'pos' => '(v)'],
                            'neatness' => ['id' => 'kerapian', 'pos' => '(n)'],
                            'drawing' => ['id' => 'gambar', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Guru itu membahas setiap jawaban yang salah.',
                            'en' => 'The teacher discusses each wrong answer.'
                        ]
                    ],
                    [
                        'id' => 44,
                        'sub_lesson' => 'Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                        'id_sentence' => 'Balon itu melepaskan udara perlahan saat ditekan.',
                        'target_word' => 'releases (ending in -se -> +s)',
                        'options' => [
                            'The balloon releases air slowly when squeezed.',
                            'The balloon releasees air slowly when squeezed.',
                            'The balloon release air slowly when squeezed.',
                            'The balloon is releases air slowly when squeezed.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja "release" sudah berakhiran huruf vokal \'e\', sehingga cukup ditambahkan huruf \'s\' saja: "releases".',
                        'vocab' => [
                            'balloon' => ['id' => 'balon', 'pos' => '(n)'],
                            'release' => ['id' => 'melepaskan', 'pos' => '(v)'],
                            'air' => ['id' => 'udara', 'pos' => '(n)'],
                            'squeezed' => ['id' => 'ditekan', 'pos' => '(v, past participle)'],
                        ],
                        'example' => [
                            'id' => 'Kompor itu menghasilkan panas yang tinggi.',
                            'en' => 'The stove produces intense heat.'
                        ]
                    ],
                    [
                        'id' => 45,
                        'sub_lesson' => 'Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                        'id_sentence' => 'Hujan yang terus-menerus mengurangi semangat bermain di luar.',
                        'target_word' => 'diminishes (ending in -sh -> +es)',
                        'options' => [
                            'The constant rain diminishes our excitement to play outside.',
                            'The constant rain diminishs our excitement to play outside.',
                            'The constant rain diminish our excitement to play outside.',
                            'The constant rain is diminishes our excitement to play outside.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja "diminish" berakhiran -sh. Untuk subjek tunggal "rain", imbuhannya adalah -es: "diminishes".',
                        'vocab' => [
                            'constant rain' => ['id' => 'hujan terus-menerus', 'pos' => '(n)'],
                            'diminish' => ['id' => 'mengurangi', 'pos' => '(v)'],
                            'excitement' => ['id' => 'semangat', 'pos' => '(n)'],
                            'play outside' => ['id' => 'bermain di luar', 'pos' => '(v phr)'],
                        ],
                        'example' => [
                            'id' => 'Pemangkasan ranting memusnahkan sarang semut di pohon.',
                            'en' => 'Pruning the branches extinguishes the ant colony in the tree.'
                        ]
                    ],
                    [
                        'id' => 46,
                        'sub_lesson' => 'Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                        'id_sentence' => 'Pustakawan sekolah kami memiliki wewenang untuk memperpanjang masa pinjam buku.',
                        'target_word' => 'has (irregular form of have)',
                        'options' => [
                            'Our school librarian has the authority to extend book loans.',
                            'Our school librarian haves the authority to extend book loans.',
                            'Our school librarian have the authority to extend book loans.',
                            'Our school librarian is has the authority to extend book loans.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja "have" memiliki bentuk orang ketiga tunggal khusus tak beraturan, yaitu "has", bukan "haves".',
                        'vocab' => [
                            'librarian' => ['id' => 'pustakawan', 'pos' => '(n)'],
                            'has' => ['id' => 'memiliki', 'pos' => '(v)'],
                            'authority' => ['id' => 'wewenang', 'pos' => '(n)'],
                            'book loans' => ['id' => 'masa pinjam buku', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Sekolah kami memiliki lapangan basket baru.',
                            'en' => 'Our school has a new basketball court.'
                        ]
                    ],
                    [
                        'id' => 47,
                        'sub_lesson' => 'Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                        'id_sentence' => 'Aplikasi game ini mendeteksi dan memperbaiki kesalahan secara otomatis.',
                        'target_word' => 'fixes (ending in -x -> +es)',
                        'options' => [
                            'This game app fixes glitches automatically.',
                            'This game app fixs glitches automatically.',
                            'This game app fix glitches automatically.',
                            'This game app is fixes glitches automatically.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja "fix" berakhiran konsonan -x. Untuk subjek tunggal "app", tambahkan -es: "fixes".',
                        'vocab' => [
                            'game app' => ['id' => 'aplikasi game', 'pos' => '(n)'],
                            'fix' => ['id' => 'memperbaiki', 'pos' => '(v)'],
                            'glitches' => ['id' => 'kesalahan kecil', 'pos' => '(n)'],
                            'automatically' => ['id' => 'secara otomatis', 'pos' => '(adv)'],
                        ],
                        'example' => [
                            'id' => 'Program komputer itu mencampurkan dua warna cat.',
                            'en' => 'The app mixes two paint colors.'
                        ]
                    ],
                    [
                        'id' => 48,
                        'sub_lesson' => 'Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                        'id_sentence' => 'Petunjuk ini mengidentifikasi tiga langkah penting sebelum memasak.',
                        'target_word' => 'identifies (consonant + y -> -ies)',
                        'options' => [
                            'This guide identifies three important steps before cooking.',
                            'This guide identifys three important steps before cooking.',
                            'This guide identify three important steps before cooking.',
                            'This guide is identifies three important steps before cooking.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"identify" berakhiran konsonan \'f\' + \'y\'. Huruf \'y\' berubah menjadi \'ies\': "identifies".',
                        'vocab' => [
                            'guide' => ['id' => 'petunjuk', 'pos' => '(n)'],
                            'identify' => ['id' => 'mengidentifikasi', 'pos' => '(v)'],
                            'important steps' => ['id' => 'langkah penting', 'pos' => '(n)'],
                            'before cooking' => ['id' => 'sebelum memasak', 'pos' => '(adv phr)'],
                        ],
                        'example' => [
                            'id' => 'Penjelasan ini memperjelas perbedaan antara dua kata.',
                            'en' => 'This explanation clarifies the difference between two words.'
                        ]
                    ],
                    [
                        'id' => 49,
                        'sub_lesson' => 'Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                        'id_sentence' => 'Pelajaran baru ini menekankan kerja sama dan berbagi tugas.',
                        'target_word' => 'emphasizes (ending in -ze -> +s)',
                        'options' => [
                            'This new lesson emphasizes teamwork and sharing tasks.',
                            'This new lesson emphasizees teamwork and sharing tasks.',
                            'This new lesson emphasize teamwork and sharing tasks.',
                            'This new lesson is emphasizes teamwork and sharing tasks.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Verba berakhiran -ze seperti "emphasize" hanya ditambah huruf \'s\': "emphasizes".',
                        'vocab' => [
                            'lesson' => ['id' => 'pelajaran', 'pos' => '(n)'],
                            'emphasize' => ['id' => 'menekankan', 'pos' => '(v)'],
                            'teamwork' => ['id' => 'kerja sama', 'pos' => '(n)'],
                            'sharing tasks' => ['id' => 'berbagi tugas', 'pos' => '(v phr)'],
                        ],
                        'example' => [
                            'id' => 'Pelatih kami memprioritaskan kedisiplinan waktu.',
                            'en' => 'Our coach prioritizes punctuality.'
                        ]
                    ],
                    [
                        'id' => 50,
                        'sub_lesson' => 'Kaidah Ejaan Akhiran Verba (-s, -es, -ies)',
                        'id_sentence' => 'Pelari itu mencapai garis finis setelah berjuang keras.',
                        'target_word' => 'reaches (ending in -ch -> +es)',
                        'options' => [
                            'The runner reaches the finish line after a hard fight.',
                            'The runner reachs the finish line after a hard fight.',
                            'The runner reach the finish line after a hard fight.',
                            'The runner is reaches the finish line after a hard fight.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"reach" berakhiran bunyi desis -ch, sehingga ditambah -es: "reaches".',
                        'vocab' => [
                            'runner' => ['id' => 'pelari', 'pos' => '(n)'],
                            'reach' => ['id' => 'mencapai', 'pos' => '(v)'],
                            'finish line' => ['id' => 'garis finis', 'pos' => '(n)'],
                            'hard fight' => ['id' => 'perjuangan keras', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Perahu itu menyentuh tepi danau dengan lembut.',
                            'en' => 'The boat touches the lake\'s edge gently.'
                        ]
                    ],
                ],
            ],

            // ==========================================
            // SUB-LESSON 6: Adverbs of Frequency & Penanda Waktu Kalimat Verbal
            // ==========================================
            [
                'id' => 'verbal-adverbs-frequency',
                'name' => 'Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                'code' => '1.2.6',
                'concept_title' => 'Posisi dan Fungsi Adverb of Frequency dalam Kalimat Verbal',
                'concept_description' => 'Dalam kalimat verbal Simple Present, Adverbs of Frequency (always, usually, often, sometimes, rarely, never) diletakkan TEPAT SEBELUM kata kerja utama (Verb 1). Posisi ini berbeda dengan kalimat nominal di mana adverb berada setelah to be. Sementara itu, keterangan waktu spesifik (daily, every weekend) diletakkan di akhir atau awal kalimat.',
                'formula' => 'Subject + [always / usually / often / rarely / never] + Verb 1(s/es) + Object',
                'rules' => [
                    'Adverb of frequency berada di antara Subjek dan Kata Kerja Utama (misal: "My dad always cooks breakfast", BUKAN "My dad cooks breakfast always").',
                    'Jika terdapat auxiliary verb (do/does), adverb diletakkan setelah auxiliary (misal: "They do not always agree").',
                    'Never dan rarely sudah bermakna negatif, jangan digabungkan dengan "not" (Double Negative).',
                    'Keterangan waktu berulang seperti "every day", "every weekend" umumnya menempati posisi akhir kalimat.'
                ],
                'exercises' => [
                    [
                        'id' => 51,
                        'sub_lesson' => 'Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                        'id_sentence' => 'Ibu secara rutin memeriksa kembali tugas rumah kami.',
                        'target_word' => 'regularly checks',
                        'options' => [
                            'Mom regularly checks our homework.',
                            'Mom checks regularly our homework.',
                            'Mom is regularly check our homework.',
                            'Mom regularly check our homework.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "Mom" adalah singular, dan adverb "regularly" ditempatkan tepat sebelum kata kerja utama: "regularly checks".',
                        'vocab' => [
                            'mom' => ['id' => 'ibu', 'pos' => '(n)'],
                            'regularly' => ['id' => 'secara rutin', 'pos' => '(adv)'],
                            'check' => ['id' => 'memeriksa', 'pos' => '(v)'],
                            'homework' => ['id' => 'tugas rumah', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Guru itu selalu mengecek tugas murid-muridnya.',
                            'en' => 'The teacher always checks her students\' assignments.'
                        ]
                    ],
                    [
                        'id' => 52,
                        'sub_lesson' => 'Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                        'id_sentence' => 'Anak-anak di kelas kami sering kali melihat burung di luar jendela.',
                        'target_word' => 'frequently see',
                        'options' => [
                            'The kids in our class frequently see birds outside the window.',
                            'The kids in our class see frequently birds outside the window.',
                            'The kids in our class frequently sees birds outside the window.',
                            'The kids in our class are frequently see birds outside the window.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "kids" mengambil Verb 1 jamak "see", didahului adverb "frequently": "frequently see".',
                        'vocab' => [
                            'frequently' => ['id' => 'sering kali', 'pos' => '(adv)'],
                            'see' => ['id' => 'melihat', 'pos' => '(v)'],
                            'outside' => ['id' => 'di luar', 'pos' => '(adv)'],
                        ],
                        'example' => [
                            'id' => 'Para tetangga sering mendengar musik dari rumah sebelah.',
                            'en' => 'The neighbors often hear music from next door.'
                        ]
                    ],
                    [
                        'id' => 53,
                        'sub_lesson' => 'Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                        'id_sentence' => 'Perpustakaan kecil itu jarang menerima sumbangan buku baru.',
                        'target_word' => 'seldom receives (Negative adverb + singular verb)',
                        'options' => [
                            'The small library seldom receives new book donations.',
                            'The small library receives seldom new book donations.',
                            'The small library does not seldom receive new book donations.',
                            'The small library seldom receive new book donations.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "library" (tunggal) mengambil "receives", didahului adverb negatif "seldom". Jangan menambahkan "does not" karena akan menjadi double negative.',
                        'vocab' => [
                            'library' => ['id' => 'perpustakaan', 'pos' => '(n)'],
                            'seldom' => ['id' => 'jarang', 'pos' => '(adv)'],
                            'receives' => ['id' => 'menerima', 'pos' => '(v)'],
                            'donations' => ['id' => 'sumbangan', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Kucing liar itu jarang muncul di siang hari.',
                            'en' => 'The stray cat rarely appears during the day.'
                        ]
                    ],
                    [
                        'id' => 54,
                        'sub_lesson' => 'Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                        'id_sentence' => 'Jam weker itu memperbarui alarmnya setiap lima belas menit.',
                        'target_word' => 'updates ... every fifteen minutes',
                        'options' => [
                            'The alarm clock updates its snooze timer every fifteen minutes.',
                            'The alarm clock every fifteen minutes updates its snooze timer.',
                            'The alarm clock update its snooze timer every fifteen minutes.',
                            'The alarm clock is updates its snooze timer every fifteen minutes.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "clock" berpasangan dengan "updates", dan frasa waktu "every fifteen minutes" diletakkan di akhir klausa.',
                        'vocab' => [
                            'alarm clock' => ['id' => 'jam weker', 'pos' => '(n)'],
                            'updates' => ['id' => 'memperbarui', 'pos' => '(v)'],
                            'snooze timer' => ['id' => 'waktu tunda alarm', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Toko itu merilis diskon baru setiap bulan.',
                            'en' => 'The store releases new discounts monthly.'
                        ]
                    ],
                    [
                        'id' => 55,
                        'sub_lesson' => 'Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                        'id_sentence' => 'Anak yang jujur tidak pernah berbohong demi menghindari hukuman.',
                        'target_word' => 'never lies (Singular + Never)',
                        'options' => [
                            'An honest child never lies to avoid punishment.',
                            'An honest child does not never lie to avoid punishment.',
                            'An honest child never lie to avoid punishment.',
                            'An honest child is never lies to avoid punishment.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata "never" diletakkan sebelum kata kerja "lies" (subjek tunggal "child"). Hindari "does not never" (double negative).',
                        'vocab' => [
                            'honest child' => ['id' => 'anak yang jujur', 'pos' => '(n)'],
                            'never' => ['id' => 'tidak pernah', 'pos' => '(adv)'],
                            'lie' => ['id' => 'berbohong', 'pos' => '(v)'],
                            'punishment' => ['id' => 'hukuman', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Pemain yang baik tidak pernah menyontek saat ujian.',
                            'en' => 'A good student never cheats on exams.'
                        ]
                    ],
                    [
                        'id' => 56,
                        'sub_lesson' => 'Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                        'id_sentence' => 'Sekolah kami biasanya menerbitkan buletin untuk seluruh orang tua.',
                        'target_word' => 'usually issues',
                        'options' => [
                            'Our school usually issues a newsletter for all parents.',
                            'Our school issues usually a newsletter for all parents.',
                            'Our school usually issue a newsletter for all parents.',
                            'Our school is usually issues a newsletter for all parents.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "school" adalah singular noun, sehingga menggunakan "usually issues".',
                        'vocab' => [
                            'school' => ['id' => 'sekolah', 'pos' => '(n)'],
                            'usually' => ['id' => 'biasanya', 'pos' => '(adv)'],
                            'issue' => ['id' => 'menerbitkan', 'pos' => '(v)'],
                            'parents' => ['id' => 'orang tua', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Kelurahan biasanya mengadakan kerja bakti untuk warga.',
                            'en' => 'The neighborhood usually hosts a cleanup day for residents.'
                        ]
                    ],
                    [
                        'id' => 57,
                        'sub_lesson' => 'Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                        'id_sentence' => 'Kedua sekolah itu terkadang berkolaborasi dalam proyek seni bersama.',
                        'target_word' => 'sometimes collaborate (Plural Subject)',
                        'options' => [
                            'Both schools sometimes collaborate on a joint art project.',
                            'Both schools sometimes collaborates on a joint art project.',
                            'Both schools collaborate sometimes on a joint art project.',
                            'Both schools are sometimes collaborate on a joint art project.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "Both schools" membutuhkan kata kerja jamak "collaborate" didahului adverb "sometimes".',
                        'vocab' => [
                            'schools' => ['id' => 'sekolah-sekolah', 'pos' => '(n)'],
                            'sometimes' => ['id' => 'terkadang', 'pos' => '(adv)'],
                            'collaborate' => ['id' => 'berkolaborasi', 'pos' => '(v)'],
                            'joint art project' => ['id' => 'proyek seni bersama', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Kakak dan temannya terkadang belajar bersama di sore hari.',
                            'en' => 'My sister and her friend sometimes study together in the afternoon.'
                        ]
                    ],
                    [
                        'id' => 58,
                        'sub_lesson' => 'Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                        'id_sentence' => 'Murid-murid kelas enam umumnya menghadiri perkemahan sekolah setiap tahun.',
                        'target_word' => 'generally attend ... annually',
                        'options' => [
                            'Sixth-grade students generally attend a school camp annually.',
                            'Sixth-grade students attend generally a school camp annually.',
                            'Sixth-grade students generally attends a school camp annually.',
                            'Sixth-grade students are generally attend a school camp annually.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek jamak "students" berpasangan dengan "generally attend", dengan adverbial waktu "annually" di posisi akhir.',
                        'vocab' => [
                            'sixth-grade students' => ['id' => 'murid kelas enam', 'pos' => '(n)'],
                            'generally' => ['id' => 'umumnya', 'pos' => '(adv)'],
                            'attend' => ['id' => 'menghadiri', 'pos' => '(v)'],
                            'annually' => ['id' => 'setiap tahun', 'pos' => '(adv)'],
                        ],
                        'example' => [
                            'id' => 'Para guru umumnya mengadakan rapat setiap semester.',
                            'en' => 'Teachers generally hold a meeting each semester.'
                        ]
                    ],
                    [
                        'id' => 59,
                        'sub_lesson' => 'Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                        'id_sentence' => 'Belajar dengan terburu-buru jarang membuahkan hasil ujian yang bagus.',
                        'target_word' => 'rarely yields',
                        'options' => [
                            'Hasty studying rarely yields good exam results.',
                            'Hasty studying yields rarely good exam results.',
                            'Hasty studying does not rarely yield good exam results.',
                            'Hasty studying rarely yield good exam results.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek tunggal "studying" mengambil verba "yields", didahului adverb negatif "rarely".',
                        'vocab' => [
                            'hasty studying' => ['id' => 'belajar terburu-buru', 'pos' => '(n)'],
                            'rarely' => ['id' => 'jarang', 'pos' => '(adv)'],
                            'yield' => ['id' => 'membuahkan', 'pos' => '(v)'],
                            'exam results' => ['id' => 'hasil ujian', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Berlatih sehari sebelum lomba jarang menghasilkan kemenangan.',
                            'en' => 'Practicing one day before a contest rarely brings victory.'
                        ]
                    ],
                    [
                        'id' => 60,
                        'sub_lesson' => 'Adverbs of Frequency & Penanda Waktu Kalimat Verbal',
                        'id_sentence' => 'Kakak selalu memeriksa kembali tas sekolahnya dengan teliti.',
                        'target_word' => 'always checks',
                        'options' => [
                            'My sister always checks her school bag carefully.',
                            'My sister checks always her school bag carefully.',
                            'My sister always check her school bag carefully.',
                            'My sister is always checks her school bag carefully.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"My sister" (tunggal) mengambil "always checks".',
                        'vocab' => [
                            'sister' => ['id' => 'kakak perempuan', 'pos' => '(n)'],
                            'always' => ['id' => 'selalu', 'pos' => '(adv)'],
                            'check' => ['id' => 'memeriksa', 'pos' => '(v)'],
                            'carefully' => ['id' => 'dengan teliti', 'pos' => '(adv)'],
                        ],
                        'example' => [
                            'id' => 'Petugas keamanan selalu memeriksa tiket pengunjung.',
                            'en' => 'The security guard always checks visitors\' tickets.'
                        ]
                    ],
                ],
            ],

            // ==========================================
            // SUB-LESSON 7: Stative Verbs dalam Simple Present Akademik
            // ==========================================
            [
                'id' => 'verbal-stative-verbs',
                'name' => 'Stative Verbs dalam Simple Present Sehari-hari',
                'code' => '1.2.7',
                'concept_title' => 'Penggunaan Stative Verbs (Verba Keadaan & Pikiran) dalam Kalimat Sehari-hari',
                'concept_description' => 'Stative verbs adalah kata kerja yang menggambarkan keadaan (state of being), proses pikiran, kepemilikan, atau perasaan yang bersifat tetap. Contoh: know, believe, contain, like, want, own. Stative verbs TIDAK PERNAH digunakan dalam bentuk Continuous (-ing) dan wajib menggunakan Simple Present.',
                'formula' => 'Subject + Stative Verb 1(s/es) + Complement (TIDAK BOLEH dalam bentuk -ing)',
                'rules' => [
                    'Stative verbs dilarang digunakan dalam bentuk Present Continuous (Dilarang "She is knowing the answer" ➔ WAJIB "She knows the answer").',
                    'Verba kepemilikan (have, own, contain, belong) selalu menggunakan Simple Present.',
                    'Verba perasaan dan pikiran (understand, believe, like, want) wajib berstatus Simple Present.',
                    'Perhatikan subjek tunggal tetap menambahkan -s/-es pada stative verbs (misal: "The box contains", BUKAN "The box contain").'
                ],
                'stative_categories' => [
                    [
                        'category' => 'Kognisi & Proses Pikiran (Mental States & Cognition)',
                        'badge' => 'Kognisi',
                        'verbs' => [
                            ['en' => 'know', 'id' => 'mengetahui'],
                            ['en' => 'understand', 'id' => 'memahami'],
                            ['en' => 'believe', 'id' => 'meyakini / percaya'],
                            ['en' => 'recognize', 'id' => 'mengakui / mengenali'],
                            ['en' => 'realize', 'id' => 'menyadari'],
                            ['en' => 'remember', 'id' => 'mengingat'],
                            ['en' => 'forget', 'id' => 'melupakan'],
                            ['en' => 'doubt', 'id' => 'meragukan'],
                            ['en' => 'imply', 'id' => 'menyiratkan'],
                            ['en' => 'infer', 'id' => 'menyimpulkan'],
                            ['en' => 'mean', 'id' => 'berarti / bermakna'],
                            ['en' => 'assume', 'id' => 'berasumsi'],
                        ]
                    ],
                    [
                        'category' => 'Kepemilikan & Komposisi (Possession & Composition)',
                        'badge' => 'Komposisi',
                        'verbs' => [
                            ['en' => 'contain', 'id' => 'berisi / memuat'],
                            ['en' => 'consist of', 'id' => 'terdiri dari'],
                            ['en' => 'comprise', 'id' => 'mencakup / meliputi'],
                            ['en' => 'possess', 'id' => 'memiliki (formal)'],
                            ['en' => 'belong to', 'id' => 'milik / kepunyaan'],
                            ['en' => 'own', 'id' => 'memiliki'],
                            ['en' => 'include', 'id' => 'mencakup / termasuk'],
                            ['en' => 'lack', 'id' => 'kekurangan / tidak punya'],
                        ]
                    ],
                    [
                        'category' => 'Emosi, Sikap & Kebutuhan (Emotions, Attitudes & Desires)',
                        'badge' => 'Sikap',
                        'verbs' => [
                            ['en' => 'prefer', 'id' => 'lebih memilih'],
                            ['en' => 'appreciate', 'id' => 'mengapresiasi / menghargai'],
                            ['en' => 'need', 'id' => 'membutuhkan'],
                            ['en' => 'want', 'id' => 'menginginkan'],
                            ['en' => 'desire', 'id' => 'menghendaki'],
                            ['en' => 'value', 'id' => 'menilai / menghargai'],
                            ['en' => 'dislike', 'id' => 'tidak menyukai'],
                        ]
                    ],
                    [
                        'category' => 'Indra, Keberadaan & Relasi (State, Senses & Relation)',
                        'badge' => 'Relasi',
                        'verbs' => [
                            ['en' => 'seem', 'id' => 'tampaknya'],
                            ['en' => 'appear', 'id' => 'terlihat / tampak'],
                            ['en' => 'resemble', 'id' => 'menyerupai / mirip'],
                            ['en' => 'exist', 'id' => 'eksis / ada'],
                            ['en' => 'depend on', 'id' => 'bergantung pada'],
                            ['en' => 'matter', 'id' => 'berpengaruh / penting'],
                            ['en' => 'fit / suit', 'id' => 'cocok / sesuai'],
                            ['en' => 'cost', 'id' => 'berharga / memakan biaya'],
                        ]
                    ]
                ],
                'exercises' => [
                    [
                        'id' => 61,
                        'sub_lesson' => 'Stative Verbs dalam Simple Present Akademik',
                        'id_sentence' => 'Kotak bekal ini berisi sayur, nasi, dan buah segar.',
                        'target_word' => 'contains (Stative verb of composition)',
                        'options' => [
                            'This lunchbox contains vegetables, rice, and fresh fruit.',
                            'This lunchbox is containing vegetables, rice, and fresh fruit.',
                            'This lunchbox contain vegetables, rice, and fresh fruit.',
                            'This lunchbox are contain vegetables, rice, and fresh fruit.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja "contain" adalah stative verb yang tidak boleh digunakan dalam bentuk progressive "is containing". Subjek tunggal "lunchbox" berpasangan dengan "contains".',
                        'vocab' => [
                            'lunchbox' => ['id' => 'kotak bekal', 'pos' => '(n)'],
                            'contain' => ['id' => 'berisi', 'pos' => '(v)'],
                            'vegetables' => ['id' => 'sayur', 'pos' => '(n)'],
                            'fresh fruit' => ['id' => 'buah segar', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Tas ini memuat buku dan alat tulisku.',
                            'en' => 'This bag contains my books and stationery.'
                        ]
                    ],
                    [
                        'id' => 62,
                        'sub_lesson' => 'Stative Verbs dalam Simple Present Akademik',
                        'id_sentence' => 'Tim sepak bola kami terdiri dari sebelas pemain.',
                        'target_word' => 'consists of (Stative verb)',
                        'options' => [
                            'Our football team consists of eleven players.',
                            'Our football team is consisting of eleven players.',
                            'Our football team consist of eleven players.',
                            'Our football team are consisting of eleven players.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"consist of" adalah stative verb yang wajib berbentuk Simple Present ("consists of" untuk subjek tunggal "team"), bukan "is consisting of".',
                        'vocab' => [
                            'football team' => ['id' => 'tim sepak bola', 'pos' => '(n)'],
                            'consist of' => ['id' => 'terdiri dari', 'pos' => '(v phr)'],
                            'players' => ['id' => 'pemain', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Kelompok belajar kami terdiri atas lima siswa.',
                            'en' => 'Our study group consists of five students.'
                        ]
                    ],
                    [
                        'id' => 63,
                        'sub_lesson' => 'Stative Verbs dalam Simple Present Akademik',
                        'id_sentence' => 'Banyak anak meyakini bahwa makan sayur membuat tubuh kuat.',
                        'target_word' => 'believe (Stative verb of belief/cognition)',
                        'options' => [
                            'Many children believe that eating vegetables makes the body strong.',
                            'Many children are believing that eating vegetables makes the body strong.',
                            'Many children believes that eating vegetables makes the body strong.',
                            'Many children is believe that eating vegetables makes the body strong.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"believe" adalah stative verb (kata kerja keyakinan/kognisi) yang tidak lazim dalam bentuk continuous ("are believing"). Subjek jamak "children" menggunakan Verb 1 "believe".',
                        'vocab' => [
                            'children' => ['id' => 'anak-anak', 'pos' => '(n)'],
                            'believe' => ['id' => 'meyakini / percaya', 'pos' => '(v)'],
                            'eating vegetables' => ['id' => 'makan sayur', 'pos' => '(v phr)'],
                            'strong' => ['id' => 'kuat', 'pos' => '(adj)'],
                        ],
                        'example' => [
                            'id' => 'Para orang tua meyakini bahwa membaca buku baik untuk anak.',
                            'en' => 'Parents believe that reading books is good for children.'
                        ]
                    ],
                    [
                        'id' => 64,
                        'sub_lesson' => 'Stative Verbs dalam Simple Present Akademik',
                        'id_sentence' => 'Hasil kuis ini menunjukkan penurunan nilai di kelas kami.',
                        'target_word' => 'indicates (Stative reporting verb)',
                        'options' => [
                            'This quiz result indicates a drop in our class scores.',
                            'This quiz result is indicating a drop in our class scores.',
                            'This quiz result indicate a drop in our class scores.',
                            'This quiz result are indicate a drop in our class scores.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja pelaporan hasil seperti "indicates", "shows" menggunakan Simple Present untuk menyatakan fakta temuan.',
                        'vocab' => [
                            'quiz result' => ['id' => 'hasil kuis', 'pos' => '(n)'],
                            'indicate' => ['id' => 'menunjukkan', 'pos' => '(v)'],
                            'drop' => ['id' => 'penurunan', 'pos' => '(n)'],
                            'class scores' => ['id' => 'nilai kelas', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Catatan cuaca ini menunjukkan kenaikan suhu bulan ini.',
                            'en' => 'This weather record indicates a rise in temperature this month.'
                        ]
                    ],
                    [
                        'id' => 65,
                        'sub_lesson' => 'Stative Verbs dalam Simple Present Akademik',
                        'id_sentence' => 'Sekolah kami memiliki peralatan olahraga yang memadai.',
                        'target_word' => 'possesses (Stative verb of possession)',
                        'options' => [
                            'Our school possesses adequate sports equipment.',
                            'Our school is possessing adequate sports equipment.',
                            'Our school possess adequate sports equipment.',
                            'Our school are possess adequate sports equipment.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"possess" adalah stative verb kepemilikan yang tidak memakai bentuk continuous "is possessing". Subjek tunggal "school" mengambil akhiran -es: "possesses".',
                        'vocab' => [
                            'school' => ['id' => 'sekolah', 'pos' => '(n)'],
                            'possess' => ['id' => 'memiliki', 'pos' => '(v)'],
                            'adequate' => ['id' => 'memadai', 'pos' => '(adj)'],
                            'sports equipment' => ['id' => 'peralatan olahraga', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Taman kota itu memiliki area bermain anak yang luas.',
                            'en' => 'The city park possesses a large children\'s play area.'
                        ]
                    ],
                    [
                        'id' => 66,
                        'sub_lesson' => 'Stative Verbs dalam Simple Present Akademik',
                        'id_sentence' => 'Kakak memahami mengapa adiknya menangis.',
                        'target_word' => 'understands (Stative verb of mental state)',
                        'options' => [
                            'My older sister understands why her little sibling is crying.',
                            'My older sister is understanding why her little sibling is crying.',
                            'My older sister understand why her little sibling is crying.',
                            'My older sister are understand why her little sibling is crying.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"understand" adalah kata kerja pemahaman mental (stative). Bentuk continuous "is understanding" salah secara tata bahasa baku.',
                        'vocab' => [
                            'older sister' => ['id' => 'kakak perempuan', 'pos' => '(n)'],
                            'understand' => ['id' => 'memahami', 'pos' => '(v)'],
                            'little sibling' => ['id' => 'adik', 'pos' => '(n)'],
                            'crying' => ['id' => 'menangis', 'pos' => '(v)'],
                        ],
                        'example' => [
                            'id' => 'Murid-murid memahami aturan di dalam kelas.',
                            'en' => 'The students understand the classroom rules.'
                        ]
                    ],
                    [
                        'id' => 67,
                        'sub_lesson' => 'Stative Verbs dalam Simple Present Akademik',
                        'id_sentence' => 'Anak kucing itu sangat menyerupai induknya.',
                        'target_word' => 'resembles (Stative verb of relation)',
                        'options' => [
                            'The kitten closely resembles its mother.',
                            'The kitten is closely resembling its mother.',
                            'The kitten closely resemble its mother.',
                            'The kitten are resemble its mother.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"resemble" (menyerupai) adalah stative verb yang tidak boleh digunakan dalam bentuk -ing. Subjek tunggal "kitten" berpasangan dengan "resembles".',
                        'vocab' => [
                            'kitten' => ['id' => 'anak kucing', 'pos' => '(n)'],
                            'resemble' => ['id' => 'menyerupai', 'pos' => '(v)'],
                            'mother' => ['id' => 'induk', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Gambar ini menyerupai lukisan terkenal itu.',
                            'en' => 'This picture resembles the famous painting.'
                        ]
                    ],
                    [
                        'id' => 68,
                        'sub_lesson' => 'Stative Verbs dalam Simple Present Akademik',
                        'id_sentence' => 'Teman-temanku meragukan bahwa aku bisa berenang seratus meter.',
                        'target_word' => 'doubt (Stative verb of doubt)',
                        'options' => [
                            'My friends doubt that I can swim one hundred meters.',
                            'My friends are doubting that I can swim one hundred meters.',
                            'My friends doubts that I can swim one hundred meters.',
                            'My friends is doubt that I can swim one hundred meters.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"doubt" adalah kata kerja mental keraguan (stative verb). Subjek jamak "friends" mengambil bentuk dasar "doubt", bukan continuous.',
                        'vocab' => [
                            'friends' => ['id' => 'teman-teman', 'pos' => '(n)'],
                            'doubt' => ['id' => 'meragukan', 'pos' => '(v)'],
                            'swim' => ['id' => 'berenang', 'pos' => '(v)'],
                        ],
                        'example' => [
                            'id' => 'Beberapa teman sekelas meragukan kemenangan tim kami.',
                            'en' => 'Some classmates doubt our team\'s chances of winning.'
                        ]
                    ],
                    [
                        'id' => 69,
                        'sub_lesson' => 'Stative Verbs dalam Simple Present Akademik',
                        'id_sentence' => 'Nilai ujiannya yang bagus menyiratkan bahwa ia belajar dengan giat.',
                        'target_word' => 'implies (Stative reporting verb)',
                        'options' => [
                            'His good exam score implies that he studied hard.',
                            'His good exam score is implying that he studied hard.',
                            'His good exam score imply that he studied hard.',
                            'His good exam score are imply that he studied hard.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"imply" (menyiratkan) adalah stative verb yang berakhiran konsonan \'l\' + \'y\'. Untuk subjek tunggal "score", ejaannya menjadi "implies".',
                        'vocab' => [
                            'exam score' => ['id' => 'nilai ujian', 'pos' => '(n)'],
                            'imply' => ['id' => 'menyiratkan', 'pos' => '(v)'],
                            'studied hard' => ['id' => 'belajar dengan giat', 'pos' => '(v phr)'],
                        ],
                        'example' => [
                            'id' => 'Senyuman kakak menyiratkan bahwa ia senang.',
                            'en' => 'My sister\'s smile implies that she is happy.'
                        ]
                    ],
                    [
                        'id' => 70,
                        'sub_lesson' => 'Stative Verbs dalam Simple Present Akademik',
                        'id_sentence' => 'Seluruh sekolah mengakui usaha keras tim olimpiade sains kami.',
                        'target_word' => 'recognizes (Stative verb of perception)',
                        'options' => [
                            'The whole school recognizes our science team\'s hard work.',
                            'The whole school is recognizing our science team\'s hard work.',
                            'The whole school recognize our science team\'s hard work.',
                            'The whole school are recognize our science team\'s hard work.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "school" (tunggal) mengambil stative verb "recognizes". Hindari bentuk continuous "is recognizing".',
                        'vocab' => [
                            'whole school' => ['id' => 'seluruh sekolah', 'pos' => '(n)'],
                            'recognize' => ['id' => 'mengakui', 'pos' => '(v)'],
                            'hard work' => ['id' => 'usaha keras', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Pelatih mengakui kemajuan seluruh anggota tim.',
                            'en' => 'The coach recognizes the whole team\'s progress.'
                        ]
                    ],
                ],
            ],

            // ==========================================
            // SUB-LESSON 8: Koreksi Kesalahan Umum: Eliminasi Double Predicate
            // ==========================================
            [
                'id' => 'verbal-error-correction',
                'name' => 'Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                'code' => '1.2.8',
                'concept_title' => 'Identifikasi dan Eliminasi Double Predicate & Subject-Verb Mismatches',
                'concept_description' => 'Salah satu kesalahan paling sering muncul dalam kalimat verbal sehari-hari adalah "Double Predicate", yaitu menyisipkan to be (is, am, are) sebelum kata kerja verbal (seperti "He is explains", "We are agree", "She is likes"). Kesalahan kedua adalah kegagalan menyelaraskan akhiran -s pada subjek tunggal atau salah menambahkan -s pada subjek jamak.',
                'formula' => 'BENAR: Subject + Verb 1(-s/-es) | SALAH MUTLAK: Subject + [is/am/are] + Verb 1',
                'rules' => [
                    'Dilarang keras menggabungkan to be (is/are) dengan Verb 1 dasar (e.g., "is explains" ➔ SALAH! Seharusnya "explains").',
                    'Kata "agree", "disagree", "like", "depend" adalah VERBA MURNI, bukan kata sifat. Tulis "I agree", bukan "I am agree".',
                    'Periksa kembali subjek uncountable (homework, money, water) agar tidak tertukar antara jamak dan tunggal.',
                    'Setelah modal auxiliaries (can, will, should, must), kata kerja selalu kembali ke V1 dasar murni tanpa -s.'
                ],
                'exercises' => [
                    [
                        'id' => 71,
                        'sub_lesson' => 'Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                        'id_sentence' => 'Banyak murid setuju bahwa istirahat lebih lama membuat kelas lebih fokus.',
                        'target_word' => 'agree (Verba murni, BUKAN "are agree")',
                        'options' => [
                            'Many students agree that a longer break helps the class focus better.',
                            'Many students are agree that a longer break helps the class focus better.',
                            'Many students agrees that a longer break helps the class focus better.',
                            'Many students is agree that a longer break helps the class focus better.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"agree" adalah kata kerja verbal murni, bukan kata sifat. Penutur Indonesia sering salah menulis "are agree". Bentuk yang benar untuk subjek jamak "students" adalah "agree".',
                        'vocab' => [
                            'students' => ['id' => 'murid-murid', 'pos' => '(n)'],
                            'agree' => ['id' => 'setuju (verba murni)', 'pos' => '(v)'],
                            'longer break' => ['id' => 'istirahat lebih lama', 'pos' => '(n)'],
                            'focus' => ['id' => 'fokus', 'pos' => '(v)'],
                        ],
                        'example' => [
                            'id' => 'Teman-teman setuju dengan rencana piknik akhir pekan ini.',
                            'en' => 'My friends agree with this weekend\'s picnic plan.'
                        ]
                    ],
                    [
                        'id' => 72,
                        'sub_lesson' => 'Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                        'id_sentence' => 'Aturan baru perpustakaan ini menjamin ketenangan bagi semua pengunjung.',
                        'target_word' => 'ensures (BUKAN "is ensures")',
                        'options' => [
                            'This new library rule ensures quietness for all visitors.',
                            'This new library rule is ensures quietness for all visitors.',
                            'This new library rule are ensure quietness for all visitors.',
                            'This new library rule ensure quietness for all visitors.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "rule" adalah tunggal. Predikat kalimat adalah verba murni "ensures". Menyisipkan "is" ("is ensures") adalah kesalahan fatal double predicate.',
                        'vocab' => [
                            'library rule' => ['id' => 'aturan perpustakaan', 'pos' => '(n)'],
                            'ensure' => ['id' => 'menjamin', 'pos' => '(v)'],
                            'quietness' => ['id' => 'ketenangan', 'pos' => '(n)'],
                            'visitors' => ['id' => 'pengunjung', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Aturan sekolah menjamin keselamatan semua murid.',
                            'en' => 'The school policy ensures all students\' safety.'
                        ]
                    ],
                    [
                        'id' => 73,
                        'sub_lesson' => 'Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                        'id_sentence' => 'Keberhasilan kebun sekolah ini bergantung pada penyiraman rutin.',
                        'target_word' => 'depends on (BUKAN "is depends on")',
                        'options' => [
                            'The success of the school garden depends on regular watering.',
                            'The success of the school garden is depends on regular watering.',
                            'The success of the school garden depend on regular watering.',
                            'The success of the school garden are depends on regular watering.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"depend on" adalah kata kerja verbal. Subjek inti kalimat adalah "The success" (singular), sehingga bentuk yang benar adalah "depends on", tanpa "is".',
                        'vocab' => [
                            'success' => ['id' => 'keberhasilan', 'pos' => '(n)'],
                            'depend on' => ['id' => 'bergantung pada (verba)', 'pos' => '(v phr)'],
                            'regular watering' => ['id' => 'penyiraman rutin', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Hasil panen bergantung pada curah hujan musiman.',
                            'en' => 'The harvest depends on seasonal rainfall.'
                        ]
                    ],
                    [
                        'id' => 74,
                        'sub_lesson' => 'Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                        'id_sentence' => 'Sebagian besar anggota kelas menolak usulan mengganti jadwal olahraga.',
                        'target_word' => 'oppose (BUKAN "are oppose")',
                        'options' => [
                            'Most class members oppose the plan to change the sports schedule.',
                            'Most class members are oppose the plan to change the sports schedule.',
                            'Most class members opposes the plan to change the sports schedule.',
                            'Most class members is oppose the plan to change the sports schedule.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek mengacu pada anggota kelas jamak ("class members"), verba verbal murni adalah "oppose". Jangan tambahkan "are".',
                        'vocab' => [
                            'class members' => ['id' => 'anggota kelas', 'pos' => '(n)'],
                            'oppose' => ['id' => 'menolak (verba)', 'pos' => '(v)'],
                            'sports schedule' => ['id' => 'jadwal olahraga', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Para tetangga menentang rencana membangun pagar tinggi.',
                            'en' => 'The neighbors oppose building a tall fence.'
                        ]
                    ],
                    [
                        'id' => 75,
                        'sub_lesson' => 'Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                        'id_sentence' => 'Jejak kaki di pasir membuktikan bahwa seekor kucing melintas semalam.',
                        'target_word' => 'proves (Uncountable Subject, BUKAN "is proves")',
                        'options' => [
                            'The footprint evidence proves that a cat passed by last night.',
                            'The footprint evidence is proves that a cat passed by last night.',
                            'The footprint evidence prove that a cat passed by last night.',
                            'The footprint evidence are proves that a cat passed by last night.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"evidence" adalah uncountable noun (tunggal), maka kata kerjanya adalah "proves". Dilarang menyisipkan "is proves".',
                        'vocab' => [
                            'footprint evidence' => ['id' => 'bukti jejak kaki', 'pos' => '(n)'],
                            'prove' => ['id' => 'membuktikan', 'pos' => '(v)'],
                            'passed by' => ['id' => 'melintas', 'pos' => '(v phr)'],
                        ],
                        'example' => [
                            'id' => 'Catatan sekolah membuktikan tidak ada kesalahan nilai.',
                            'en' => 'The school record proves there is no scoring error.'
                        ]
                    ],
                    [
                        'id' => 76,
                        'sub_lesson' => 'Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                        'id_sentence' => 'Nilai ujian kelas kami menggambarkan kemajuan belajar selama semester ini.',
                        'target_word' => 'illustrate (Plural Subject, BUKAN "illustrates")',
                        'options' => [
                            'Our class exam scores illustrate learning progress this semester.',
                            'Our class exam scores illustrates learning progress this semester.',
                            'Our class exam scores is illustrate learning progress this semester.',
                            'Our class exam scores are illustrates learning progress this semester.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"scores" berbentuk jamak (plural noun), sehingga menggunakan "illustrate" tanpa akhiran -s.',
                        'vocab' => [
                            'exam scores' => ['id' => 'nilai ujian', 'pos' => '(n)'],
                            'illustrate' => ['id' => 'menggambarkan', 'pos' => '(v)'],
                            'learning progress' => ['id' => 'kemajuan belajar', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Grafik ini menggambarkan perbedaan tinggi badan siswa.',
                            'en' => 'This chart illustrates differences in students\' height.'
                        ]
                    ],
                    [
                        'id' => 77,
                        'sub_lesson' => 'Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                        'id_sentence' => 'Belajar kelompok memfasilitasi pertukaran ide antar murid.',
                        'target_word' => 'facilitates (Singular Subject, BUKAN "is facilitates")',
                        'options' => [
                            'Group study facilitates idea exchange among students.',
                            'Group study is facilitates idea exchange among students.',
                            'Group study facilitate idea exchange among students.',
                            'Group study are facilitate idea exchange among students.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "Group study" adalah tunggal. Kata kerja verbal murninya adalah "facilitates" tanpa imbuhan to be.',
                        'vocab' => [
                            'group study' => ['id' => 'belajar kelompok', 'pos' => '(n)'],
                            'facilitate' => ['id' => 'memfasilitasi', 'pos' => '(v)'],
                            'idea exchange' => ['id' => 'pertukaran ide', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Aplikasi ini memfasilitasi komunikasi antara guru dan orang tua.',
                            'en' => 'This app facilitates communication between teachers and parents.'
                        ]
                    ],
                    [
                        'id' => 78,
                        'sub_lesson' => 'Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                        'id_sentence' => 'Kedua kakak beradik itu tidak setuju mengenai film apa yang akan ditonton.',
                        'target_word' => 'disagree (BUKAN "are disagree")',
                        'options' => [
                            'Both siblings disagree about which movie to watch.',
                            'Both siblings are disagree about which movie to watch.',
                            'Both siblings disagrees about which movie to watch.',
                            'Both siblings is disagree about which movie to watch.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '"disagree" adalah kata kerja verbal murni (bukan adjective). Subjek jamak "Both siblings" mengambil "disagree" tanpa "are".',
                        'vocab' => [
                            'siblings' => ['id' => 'kakak beradik', 'pos' => '(n)'],
                            'disagree' => ['id' => 'tidak setuju', 'pos' => '(v)'],
                            'which movie' => ['id' => 'film apa', 'pos' => '(n phr)'],
                        ],
                        'example' => [
                            'id' => 'Kedua teman itu tidak sependapat mengenai aturan permainan.',
                            'en' => 'The two friends disagree about the game rules.'
                        ]
                    ],
                    [
                        'id' => 79,
                        'sub_lesson' => 'Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                        'id_sentence' => 'Jadwal piket kelas ini mengalokasikan tugas untuk setiap murid.',
                        'target_word' => 'allocates (BUKAN "is allocates")',
                        'options' => [
                            'This class duty roster allocates a task for every student.',
                            'This class duty roster is allocates a task for every student.',
                            'This class duty roster allocate a task for every student.',
                            'This class duty roster are allocate a task for every student.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "roster" adalah singular noun, sehingga menggunakan "allocates" tanpa menyisipkan "is".',
                        'vocab' => [
                            'duty roster' => ['id' => 'jadwal piket', 'pos' => '(n)'],
                            'allocate' => ['id' => 'mengalokasikan', 'pos' => '(v)'],
                            'task' => ['id' => 'tugas', 'pos' => '(n)'],
                        ],
                        'example' => [
                            'id' => 'Guru mengalokasikan waktu istirahat untuk setiap kelompok.',
                            'en' => 'The teacher allocates break time for each group.'
                        ]
                    ],
                    [
                        'id' => 80,
                        'sub_lesson' => 'Koreksi Kesalahan Fatal: Eliminasi Double Predicate',
                        'id_sentence' => 'Buku pelajaran ini menjelaskan konsep pecahan dengan sangat gamblang.',
                        'target_word' => 'explains (BUKAN "is explains")',
                        'options' => [
                            'This textbook explains the concept of fractions very clearly.',
                            'This textbook is explains the concept of fractions very clearly.',
                            'This textbook explain the concept of fractions very clearly.',
                            'This textbook are explain the concept of fractions very clearly.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Subjek "textbook" adalah tunggal. Kata kerja verbal yang tepat adalah "explains" (tanpa "is").',
                        'vocab' => [
                            'textbook' => ['id' => 'buku pelajaran', 'pos' => '(n)'],
                            'explain' => ['id' => 'menjelaskan', 'pos' => '(v)'],
                            'fractions' => ['id' => 'pecahan', 'pos' => '(n)'],
                            'clearly' => ['id' => 'dengan gamblang / jelas', 'pos' => '(adv)'],
                        ],
                        'example' => [
                            'id' => 'Diagram ini menjelaskan asal-usul pelangi.',
                            'en' => 'This diagram explains how rainbows form.'
                        ]
                    ],
                ],
            ],
        ];
    }
}
