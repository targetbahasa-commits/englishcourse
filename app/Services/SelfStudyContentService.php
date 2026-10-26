<?php

namespace App\Services;

class SelfStudyContentService
{
    /**
     * Get the full package containing Study Guide and Practice Questions for a given topic seed.
     */
    public function getTopicPackage(string $seed, string $topicTitle = '', array $meta = []): array
    {
        return match ($seed) {
            'grammar-1' => $this->getPartsOfSpeechPackage(),
            'grammar-2' => $this->getSimplePresentPackage(),
            'grammar-3' => $this->getSubjectVerbAgreementPackage(),
            'grammar-m1-t4' => $this->getPresentNegativeInterrogativePackage(),
            'grammar-m1-t5' => $this->getCorePrepositionalPhrasesPackage(),
            'grammar-m1-t6' => $this->getVerbalsInfinitivesGerundsPackage(),
            'grammar-m1-t7' => $this->getModalAuxiliariesPackage(),
            'grammar-m1-t8' => $this->getSimplePastPackage(),
            'grammar-m1-t9' => $this->getPresentContinuousPackage(),
            'grammar-m1-t10' => $this->getPresentPerfectPackage(),
            'grammar-m1-t11' => $this->getSimpleFuturePackage(),
            'grammar-m1-t12' => $this->getPastContinuousPastPerfectPackage(),
            'grammar-m2-t1' => $this->getTensesCrossReferencePackage(),
            'grammar-m2-t2' => $this->getPrepositionalPhrase102Package(),
            'grammar-m2-t3' => $this->getGerundInfinitive102Package(),
            'grammar-m2-t4' => $this->getNounPhrasePackage(),
            'grammar-m2-t5' => $this->getCompoundSentencesFanboysPackage(),
            'grammar-m2-t6' => $this->getComparisonDegreePackage(),
            'grammar-4' => $this->getPassiveVoicePackage(),
            'grammar-5' => $this->getAspectDistinctionsPackage(),
            'grammar-complexity-1', 'grammar-m3-t5' => $this->getSubordinationPackage(),
            'grammar-complexity-2', 'grammar-m3-t3' => $this->getRelativeClausesPackage(),
            'grammar-complexity-3', 'grammar-m3-t1', 'Concession Clauses & Transition Logic' => $this->getConcessionClausesPackage(),
            'grammar-complexity-4', 'grammar-m4-t3' => $this->getNominalisationPackage(),
            'grammar-proficiency-1', 'grammar-m4-t1' => $this->getParticipleReductionPackage(),
            'grammar-proficiency-2', 'grammar-m4-t2' => $this->getInversionPackage(),
            default => $this->getGenericPackage($seed, $topicTitle, $meta),
        };
    }

    /**
     * 1.1 Parts of Speech & Word Class Identification
     */
    protected function getPartsOfSpeechPackage(): array
    {
$subLessonsData = [
            [
                'id' => 'noun',
                'name' => 'Noun (Nomina / Kata Benda)',
                'code' => '1.1.1',
                'concept_title' => 'Noun (Nomina): Mengenal Kata Benda',
                'concept_description' => 'Noun adalah kata yang menamai orang, tempat, benda, hewan, atau perasaan (misal: sister, school, book, cat, happiness). Noun biasa muncul sebagai subjek (pelaku) atau objek (yang dikenai perbuatan) dalam sebuah kalimat.',
                'formula' => 'Root + (-tion, -ment, -ness, -ity, -ship) ➔ Noun',
                'rules' => [
                    'Noun dapat menjadi subjek (di awal kalimat) atau objek (setelah kata kerja) dalam sebuah kalimat.',
                    'Banyak noun dibentuk dari kata kerja atau kata sifat dengan akhiran -tion, -ment, -ness, -ity (misal: decide -> decision, happy -> happiness).',
                    'Countable noun (book, friend) bisa dihitung dan punya bentuk jamak (-s); uncountable noun (water, help) biasanya tidak memakai -s.',
                    'Dua noun bisa digabung untuk menyebut satu benda/konsep (misal: water bottle, school bag).'
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'sub_lesson' => 'Noun',
                        'id_sentence' => 'Kedatangan kakak dari luar negeri membuat kami sangat bahagia.',
                        'target_word' => 'arrival (Noun)',
                        'options' => [
                            'The arrival of my brother from abroad made us very happy.',
                            'The arrive of my brother from abroad made us very happy.',
                            'The arriving of my brother from abroad made us very happy.',
                            'The arrivally of my brother from abroad made us very happy.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata \'arrival\' (Noun) tepat setelah artikel \'the\' dan berfungsi sebagai subjek kalimat. \'Arrive\' adalah verb, dan \'arrivally\' bukan kata yang benar.'
                    ],
                    [
                        'id' => 2,
                        'sub_lesson' => 'Noun',
                        'id_sentence' => 'Kebaikan guru itu disukai oleh semua murid.',
                        'target_word' => 'kindness (Noun)',
                        'options' => [
                            'The kindness of that teacher is loved by all the students.',
                            'The kind of that teacher is loved by all the students.',
                            'The kindly of that teacher is loved by all the students.',
                            'The kindful of that teacher is loved by all the students.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Setelah \'the\', kita memerlukan kata benda \'kindness\' (Noun) sebagai inti frasa nomina. \'Kind\' adalah adjective dan \'kindly\' adalah adverb.'
                    ],
                    [
                        'id' => 3,
                        'sub_lesson' => 'Noun',
                        'id_sentence' => 'Kebahagiaan keluarga itu terlihat jelas di foto pernikahan.',
                        'target_word' => 'happiness (Noun)',
                        'options' => [
                            'The happiness of that family is clear in the wedding photo.',
                            'The happy of that family is clear in the wedding photo.',
                            'The happily of that family is clear in the wedding photo.',
                            'The happyful of that family is clear in the wedding photo.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Frasa subjek \'The ...\' membutuhkan head noun \'happiness\'. \'Happy\' adalah adjective dan \'happily\' adalah adverb.'
                    ],
                    [
                        'id' => 4,
                        'sub_lesson' => 'Noun',
                        'id_sentence' => 'Keputusan ayah untuk pindah kota mengejutkan semua orang.',
                        'target_word' => 'decision (Noun)',
                        'options' => [
                            'Father\'s decision to move to a new city surprised everyone.',
                            'Father\'s decide to move to a new city surprised everyone.',
                            'Father\'s decisive to move to a new city surprised everyone.',
                            'Father\'s decisively to move to a new city surprised everyone.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Decision\' adalah Noun yang berfungsi sebagai subjek kalimat. \'Decide\' adalah verb.'
                    ],
                    [
                        'id' => 5,
                        'sub_lesson' => 'Noun',
                        'id_sentence' => 'Gerakan tari tradisional itu sangat indah untuk ditonton.',
                        'target_word' => 'movement (Noun)',
                        'options' => [
                            'The movement of the traditional dance is very beautiful to watch.',
                            'The move of the traditional dance is very beautiful to watch.',
                            'The moving of the traditional dance is very beautiful to watch.',
                            'The movingly of the traditional dance is very beautiful to watch.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Posisi subjek kalimat membutuhkan noun \'movement\'. \'Move\' adalah verb dan \'movingly\' adalah adverb.'
                    ],
                    [
                        'id' => 6,
                        'sub_lesson' => 'Noun',
                        'id_sentence' => 'Persahabatan mereka sudah terjalin sejak sekolah dasar.',
                        'target_word' => 'friendship (Noun)',
                        'options' => [
                            'Their friendship has lasted since elementary school.',
                            'Their friend has lasted since elementary school.',
                            'Their friendly has lasted since elementary school.',
                            'Their friendlily has lasted since elementary school.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Friendship\' adalah bentuk noun turunan dari \'friend\' yang berarti hubungan pertemanan.'
                    ],
                    [
                        'id' => 7,
                        'sub_lesson' => 'Noun',
                        'id_sentence' => 'Keindahan pemandangan gunung itu membuat kami terpesona.',
                        'target_word' => 'beauty (Noun)',
                        'options' => [
                            'The beauty of the mountain view amazed us.',
                            'The beautiful of the mountain view amazed us.',
                            'The beautifully of the mountain view amazed us.',
                            'The beautify of the mountain view amazed us.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Setelah \'the\', dibutuhkan noun \'beauty\'. \'Beautiful\' adalah adjective dan \'beautifully\' adalah adverb.'
                    ],
                    [
                        'id' => 8,
                        'sub_lesson' => 'Noun',
                        'id_sentence' => 'Keselamatan anak-anak adalah prioritas utama orang tua.',
                        'target_word' => 'safety (Noun)',
                        'options' => [
                            'The safety of children is parents\' top priority.',
                            'The safe of children is parents\' top priority.',
                            'The safely of children is parents\' top priority.',
                            'The safeness of children is parents\' top priority.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Safety\' adalah Noun yang bertindak sebagai subjek kalimat. \'Safe\' adalah adjective.'
                    ],
                    [
                        'id' => 9,
                        'sub_lesson' => 'Noun',
                        'id_sentence' => 'Pertumbuhan tanaman ini sangat cepat setelah disiram setiap hari.',
                        'target_word' => 'growth (Noun)',
                        'options' => [
                            'The growth of this plant is very fast after being watered every day.',
                            'The grow of this plant is very fast after being watered every day.',
                            'The growing of this plant is very fast after being watered every day.',
                            'The growthly of this plant is very fast after being watered every day.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Growth\' adalah Noun yang berfungsi sebagai subjek kalimat.'
                    ],
                    [
                        'id' => 10,
                        'sub_lesson' => 'Noun',
                        'id_sentence' => 'Bantuan tetangga sangat berarti saat keluarga kami pindah rumah.',
                        'target_word' => 'help (Noun)',
                        'options' => [
                            'The neighbor\'s help meant a lot when our family moved house.',
                            'The neighbor\'s helpful meant a lot when our family moved house.',
                            'The neighbor\'s helpfully meant a lot when our family moved house.',
                            'The neighbor\'s helping meant a lot when our family moved house.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Help\' di sini berfungsi sebagai Noun (bantuan), bukan verb, dan menjadi subjek kalimat.'
                    ]
                ]
            ],
            [
                'id' => 'pronoun',
                'name' => 'Pronoun (Pronomina / Kata Ganti)',
                'code' => '1.1.2',
                'concept_title' => 'Pronoun (Pronomina): Mengenal Kata Ganti',
                'concept_description' => 'Pronoun menggantikan kata benda (noun) supaya kalimat tidak mengulang-ulang nama yang sama (misal: ganti \'my sister\' dengan \'she\'). Pastikan kata ganti sesuai dengan kata benda yang digantikannya, baik jumlahnya (tunggal/jamak) maupun jenisnya (orang/benda).',
                'formula' => 'Personal (she, it) | Relative (which, who, whom) | Demonstrative (this, these) | Indefinite (each, neither)',
                'rules' => [
                    'Kata ganti harus cocok dengan kata benda yang digantikannya, baik jumlah (tunggal/jamak) maupun jenisnya.',
                    'Pastikan jelas kata benda mana yang dirujuk oleh \'this\' atau \'it\' supaya tidak membingungkan pembaca.',
                    'Relative Pronoun: \'who\' untuk orang sebagai subjek, \'whom\' untuk objek, \'which\' untuk benda, dan \'that\' untuk orang atau benda.',
                    'Pada pola \'Neither A nor B\', kata ganti mengikuti B (kata benda yang paling dekat).'
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'sub_lesson' => 'Pronoun',
                        'id_sentence' => 'Baik kakak maupun adikku tidak membawa payung mereka.',
                        'target_word' => 'their (Pronoun)',
                        'options' => [
                            'Neither my brother nor my sister brought their umbrella.',
                            'Neither my brother nor my sister brought his umbrella.',
                            'Neither my brother nor my sister brought its umbrella.',
                            'Neither my brother nor my sister brought them umbrella.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Pada pola \'Neither... nor...\', kata ganti kepemilikan menyesuaikan dengan kata benda terdekat (\'my sister\') sehingga menggunakan \'their\' untuk kedua orang tersebut.'
                    ],
                    [
                        'id' => 2,
                        'sub_lesson' => 'Pronoun',
                        'id_sentence' => 'Murid-murid yang datang tepat waktu mendapat hadiah.',
                        'target_word' => 'who (Relative Pronoun)',
                        'options' => [
                            'The students who arrived on time got a prize.',
                            'The students which arrived on time got a prize.',
                            'The students whom arrived on time got a prize.',
                            'The students whose arrived on time got a prize.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Who\' adalah relative pronoun subjek yang merujuk pada orang (\'The students\'). \'Which\' untuk benda, \'whom\' untuk objek, \'whose\' untuk kepemilikan.'
                    ],
                    [
                        'id' => 3,
                        'sub_lesson' => 'Pronoun',
                        'id_sentence' => 'Toko itu menerbitkan daftar harga barunya kemarin.',
                        'target_word' => 'its (Possessive Pronoun)',
                        'options' => [
                            'The shop published its new price list yesterday.',
                            'The shop published their new price list yesterday.',
                            'The shop published it\'s new price list yesterday.',
                            'The shop published hers new price list yesterday.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'The shop\' adalah satu benda/tempat tunggal, sehingga kata ganti kepemilikan yang tepat adalah \'its\' (bukan \'their\' dan bukan \'it\'s\').'
                    ],
                    [
                        'id' => 4,
                        'sub_lesson' => 'Pronoun',
                        'id_sentence' => 'Setiap anak harus membawa botol minumnya sendiri ke sekolah.',
                        'target_word' => 'each (Indefinite Pronoun)',
                        'options' => [
                            'Each child must bring their own water bottle to school.',
                            'All child must bring their own water bottle to school.',
                            'Both child must bring their own water bottle to school.',
                            'Every of child must bring their own water bottle to school.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Each child\' adalah pola baku indefinite pronoun untuk merujuk setiap anak secara terpisah.'
                    ],
                    [
                        'id' => 5,
                        'sub_lesson' => 'Pronoun',
                        'id_sentence' => 'Mainan yang dibelikan oleh ayah sangat disukai adik.',
                        'target_word' => 'which (Relative Pronoun)',
                        'options' => [
                            'The toy, which father bought, was loved by my little sibling.',
                            'The toy, whom father bought, was loved by my little sibling.',
                            'The toy, who father bought, was loved by my little sibling.',
                            'The toy, what father bought, was loved by my little sibling.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Karena merujuk pada benda (\'The toy\'), gunakan relative pronoun \'which\', bukan \'who\'/\'whom\' yang untuk orang.'
                    ],
                    [
                        'id' => 6,
                        'sub_lesson' => 'Pronoun',
                        'id_sentence' => 'Anak-anak itu bangga pada diri mereka sendiri setelah menang lomba.',
                        'target_word' => 'themselves (Reflexive Pronoun)',
                        'options' => [
                            'The children were proud of themselves after winning the race.',
                            'The children were proud of theirselves after winning the race.',
                            'The children were proud of them after winning the race.',
                            'The children were proud of each other after winning the race.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Themselves\' adalah reflexive pronoun jamak orang ketiga. Bentuk \'theirselves\' tidak ada dalam tata bahasa baku.'
                    ],
                    [
                        'id' => 7,
                        'sub_lesson' => 'Pronoun',
                        'id_sentence' => 'Kue-kue ini dibuat oleh ibu untuk acara ulang tahun.',
                        'target_word' => 'these (Demonstrative Pronoun)',
                        'options' => [
                            'These cookies were made by mother for the birthday party.',
                            'This cookies were made by mother for the birthday party.',
                            'Those cookie were made by mother for the birthday party.',
                            'That cookies were made by mother for the birthday party.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata benda jamak \'cookies\' yang dekat harus dipasangkan dengan demonstrative plural \'These\'.'
                    ],
                    [
                        'id' => 8,
                        'sub_lesson' => 'Pronoun',
                        'id_sentence' => 'Teman yang diundang oleh kakak datang membawa kado.',
                        'target_word' => 'whom (Objective Relative Pronoun)',
                        'options' => [
                            'The friend whom my sister invited came with a gift.',
                            'The friend which my sister invited came with a gift.',
                            'The friend whose my sister invited came with a gift.',
                            'The friend what my sister invited came with a gift.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Whom\' bertindak sebagai objek dari kata kerja \'invited\' dalam klausa relatif yang merujuk pada orang.'
                    ],
                    [
                        'id' => 9,
                        'sub_lesson' => 'Pronoun',
                        'id_sentence' => 'Kedua baju itu tidak muat, tidak satupun cocok untukku.',
                        'target_word' => 'neither (Indefinite Pronoun)',
                        'options' => [
                            'Both shirts didn\'t fit; neither suited me.',
                            'Both shirts didn\'t fit; none suited me.',
                            'Both shirts didn\'t fit; either suited me.',
                            'Both shirts didn\'t fit; nothing suited me.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Ketika merujuk pada dua hal (\'Both shirts\'), kata ganti negatif yang tepat adalah \'neither\' (bukan \'none\' yang digunakan untuk tiga hal atau lebih).'
                    ],
                    [
                        'id' => 10,
                        'sub_lesson' => 'Pronoun',
                        'id_sentence' => 'Siapapun yang ingin ikut piknik harus daftar sebelum Jumat.',
                        'target_word' => 'whoever (Indefinite Relative Pronoun)',
                        'options' => [
                            'Whoever wants to join the picnic must sign up before Friday.',
                            'Whomever wants to join the picnic must sign up before Friday.',
                            'Whichever wants to join the picnic must sign up before Friday.',
                            'Whatever wants to join the picnic must sign up before Friday.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Whoever\' berfungsi sebagai subjek kalimat dalam noun clause (\'Whoever wants...\').'
                    ]
                ]
            ],
            [
                'id' => 'verb',
                'name' => 'Verb (Verba / Kata Kerja)',
                'code' => '1.1.3',
                'concept_title' => 'Verb (Verba): Mengenal Kata Kerja',
                'concept_description' => 'Verb adalah kata yang menunjukkan tindakan (run, eat, play) atau keadaan (be, seem, feel). Setiap kalimat bahasa Inggris membutuhkan verb agar bisa berdiri sebagai kalimat lengkap. Pastikan verb sesuai dengan subjeknya (subject-verb agreement) dan bentuk waktunya (tense) tepat.',
                'formula' => 'Action Verb (run, cook, write) | Linking Verb (be, seem, feel)',
                'rules' => [
                    'Setiap kalimat lengkap wajib memiliki minimal satu verb (kata kerja).',
                    'Pilih kata kerja yang jelas dan tepat maknanya sesuai konteks kalimat.',
                    'Pastikan Subject-Verb Agreement: subjek tunggal memakai verb + s/es, subjek jamak memakai bentuk dasar.',
                    'Perhatikan perbedaan verb utama (misal: \'plays\') dengan bentuk -ing sebagai keterangan (misal: \'playing\' sebagai modifier).'
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'sub_lesson' => 'Verb',
                        'id_sentence' => 'Ibu memutuskan untuk memasak nasi goreng untuk makan malam.',
                        'target_word' => 'decides (Verb)',
                        'options' => [
                            'Mom decides to cook fried rice for dinner.',
                            'Mom decision to cook fried rice for dinner.',
                            'Mom decisive to cook fried rice for dinner.',
                            'Mom decisively to cook fried rice for dinner.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Decides\' adalah verb tunggal yang mempredikasi subjek \'Mom\'. Pilihan lain berupa noun (-ion), adjective (-ive), atau adverb (-ly).'
                    ],
                    [
                        'id' => 2,
                        'sub_lesson' => 'Verb',
                        'id_sentence' => 'Guru memeriksa semua tugas murid sebelum pulang sekolah.',
                        'target_word' => 'checked (Past Verb)',
                        'options' => [
                            'The teacher checked all the students\' homework before going home.',
                            'The teacher checking all the students\' homework before going home.',
                            'The teacher checks all the students\' homework before going home.',
                            'The teacher to check all the students\' homework before going home.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kalimat membutuhkan kata kerja utama bentuk lampau: \'checked\'. Bentuk \'checking\' tanpa \'was/were\' tidak bisa berdiri sebagai verb utama.'
                    ],
                    [
                        'id' => 3,
                        'sub_lesson' => 'Verb',
                        'id_sentence' => 'Buku cerita itu menunjukkan gambar yang sangat lucu.',
                        'target_word' => 'shows (Verb)',
                        'options' => [
                            'The storybook shows a very funny picture.',
                            'The storybook show a very funny picture.',
                            'The storybook showing a very funny picture.',
                            'The storybook to show a very funny picture.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Shows\' adalah finite verb untuk subjek tunggal \'The storybook\'.'
                    ],
                    [
                        'id' => 4,
                        'sub_lesson' => 'Verb',
                        'id_sentence' => 'Kakak berencana membersihkan kamarnya setiap akhir pekan.',
                        'target_word' => 'clean (Infinitive Verb)',
                        'options' => [
                            'My sister plans to clean her room every weekend.',
                            'My sister plans to cleaning her room every weekend.',
                            'My sister plans to cleaner her room every weekend.',
                            'My sister plans to cleanly her room every weekend.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Setelah partikel \'to\' (to-infinitive), gunakan bentuk kata kerja dasar (base verb): \'clean\'.'
                    ],
                    [
                        'id' => 5,
                        'sub_lesson' => 'Verb',
                        'id_sentence' => 'Adik berhasil memperbaiki sepeda roda tiganya sendiri.',
                        'target_word' => 'fixed (Past Verb)',
                        'options' => [
                            'My little brother successfully fixed his own tricycle.',
                            'My little brother successfully fix his own tricycle.',
                            'My little brother successfully fixing his own tricycle.',
                            'My little brother successfully fixes his own tricycle.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Diterangkan oleh adverb \'successfully\', predikat kalimat membutuhkan past verb \'fixed\'.'
                    ],
                    [
                        'id' => 6,
                        'sub_lesson' => 'Verb',
                        'id_sentence' => 'Hujan deras mempercepat jalan kami pulang ke rumah.',
                        'target_word' => 'hurry (Transitive Verb)',
                        'options' => [
                            'Heavy rain makes us hurry home.',
                            'Heavy rain makes us hurrying home.',
                            'Heavy rain makes us to hurry home.',
                            'Heavy rain makes us hurries home.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Setelah \'makes us\', gunakan bentuk dasar kata kerja \'hurry\' (bare infinitive).'
                    ],
                    [
                        'id' => 7,
                        'sub_lesson' => 'Verb',
                        'id_sentence' => 'Cerita ini menjelaskan mengapa langit berwarna biru.',
                        'target_word' => 'explains (Verb)',
                        'options' => [
                            'This story explains why the sky is blue.',
                            'This story explanation why the sky is blue.',
                            'This story explainable why the sky is blue.',
                            'This story explainingly why the sky is blue.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Explains\' adalah verb bermakna \'menjelaskan\' untuk subjek tunggal \'This story\'.'
                    ],
                    [
                        'id' => 8,
                        'sub_lesson' => 'Verb',
                        'id_sentence' => 'Teman-teman memprediksi bahwa tim kami akan menang pertandingan besok.',
                        'target_word' => 'predict (Reporting Verb)',
                        'options' => [
                            'My friends predict that our team will win the match tomorrow.',
                            'My friends prediction that our team will win the match tomorrow.',
                            'My friends predictive that our team will win the match tomorrow.',
                            'My friends predictably that our team will win the match tomorrow.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Predict\' adalah finite verb untuk subjek jamak \'My friends\'.'
                    ],
                    [
                        'id' => 9,
                        'sub_lesson' => 'Verb',
                        'id_sentence' => 'Helm yang bagus mengurangi risiko cedera saat bersepeda.',
                        'target_word' => 'reduces (Verb)',
                        'options' => [
                            'A good helmet reduces the risk of injury while cycling.',
                            'A good helmet reduce the risk of injury while cycling.',
                            'A good helmet reducing the risk of injury while cycling.',
                            'A good helmet reduction the risk of injury while cycling.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Reduce\' adalah verb untuk subjek tunggal \'A good helmet\', jadi membutuhkan -s.'
                    ],
                    [
                        'id' => 10,
                        'sub_lesson' => 'Verb',
                        'id_sentence' => 'Hasil ujian itu membuktikan bahwa usahanya selama ini berhasil.',
                        'target_word' => 'proved (Verb)',
                        'options' => [
                            'The exam results proved that her hard work paid off.',
                            'The exam results proof that her hard work paid off.',
                            'The exam results proving that her hard work paid off.',
                            'The exam results provingly that her hard work paid off.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Predikat kalimat harus berbentuk verb lampau: \'proved\'.'
                    ]
                ]
            ],
            [
                'id' => 'adjective',
                'name' => 'Adjective (Adjektiva / Kata Sifat)',
                'code' => '1.1.4',
                'concept_title' => 'Adjective (Adjektiva): Mengenal Kata Sifat',
                'concept_description' => 'Adjective adalah kata yang menerangkan sifat atau ciri dari sebuah noun (misal: a big house, a happy child). Adjective bisa terletak langsung sebelum noun (Attributive, misal: \'a tall tree\') atau setelah linking verb seperti be/seem/look (Predicative, misal: \'The soup is hot\').',
                'formula' => 'Attributive: [Determiner] + ADJECTIVE + [Noun] | Predicative: [Subject] + [Linking Verb] + ADJECTIVE',
                'rules' => [
                    'Attributive Position: Letakkan adjective langsung sebelum kata benda yang diterangkan (misal: a kind teacher).',
                    'Predicative Position: Gunakan adjective setelah linking verbs seperti: be, seem, look, feel, become.',
                    'Bedakan Participle Adjectives: Bentuk -ing (menyebabkan efek, misal: a boring movie) vs -ed (merasakan efek, misal: a bored student).',
                    'Adjective dalam bahasa Inggris TIDAK berubah bentuk untuk kata benda jamak (misal: tetap \'big houses\', bukan \'bigs houses\').'
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'sub_lesson' => 'Adjective',
                        'id_sentence' => 'Nenek memberikan cerita yang menarik sebelum kami tidur.',
                        'target_word' => 'interesting (Adjective)',
                        'options' => [
                            'Grandma told an interesting story before we went to sleep.',
                            'Grandma told an interest story before we went to sleep.',
                            'Grandma told an interestingly story before we went to sleep.',
                            'Grandma told an interestly story before we went to sleep.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Interesting\' adalah attributive adjective yang menerangkan kata benda \'story\'. \'Interest\' adalah noun/verb dan \'interestingly\' adalah adverb.'
                    ],
                    [
                        'id' => 2,
                        'sub_lesson' => 'Adjective',
                        'id_sentence' => 'Jawaban pertama dari kuis tersebut masih belum yakin menurut murid-murid.',
                        'target_word' => 'unsure (Predicative Adjective)',
                        'options' => [
                            'The first answer to the quiz still felt unsure to the students.',
                            'The first answer to the quiz still felt unsurely to the students.',
                            'The first answer to the quiz still felt unsureness to the students.',
                            'The first answer to the quiz still felt unsuring to the students.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Setelah linking verb \'felt\', posisi komplemen subjek harus diisi oleh predicative adjective \'unsure\'.'
                    ],
                    [
                        'id' => 3,
                        'sub_lesson' => 'Adjective',
                        'id_sentence' => 'Hujan deras merupakan masalah besar bagi para petani padi.',
                        'target_word' => 'big (Attributive Adjective)',
                        'options' => [
                            'Heavy rain is a big problem for rice farmers.',
                            'Heavy rain is a bigly problem for rice farmers.',
                            'Heavy rain is a bigness problem for rice farmers.',
                            'Heavy rain is a biggest problem for rice farmers.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Big\' (Adjective) menerangkan kata benda \'problem\'. Posisi sebelum noun tidak boleh diisi bentuk lain.'
                    ],
                    [
                        'id' => 4,
                        'sub_lesson' => 'Adjective',
                        'id_sentence' => 'Pelatih menerapkan latihan yang ketat untuk memastikan tim siap bertanding.',
                        'target_word' => 'strict (Adjective)',
                        'options' => [
                            'The coach used a strict training plan to make sure the team was ready.',
                            'The coach used a strictly training plan to make sure the team was ready.',
                            'The coach used a strictness training plan to make sure the team was ready.',
                            'The coach used a stricter training plan to make sure the team was ready.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Strict\' adalah adjective yang menerangkan kata benda \'training plan\'.'
                    ],
                    [
                        'id' => 5,
                        'sub_lesson' => 'Adjective',
                        'id_sentence' => 'Rencana yang diusulkan oleh kakak terbukti mudah dan murah.',
                        'target_word' => 'cheap (Predicative Adjective)',
                        'options' => [
                            'My sister\'s proposed plan turned out to be easy and cheap.',
                            'My sister\'s proposed plan turned out to be easy and cheaply.',
                            'My sister\'s proposed plan turned out to be easy and cheapness.',
                            'My sister\'s proposed plan turned out to be easy and cheapen.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Setelah linking verb \'to be\', gunakan predicative adjective \'cheap\'.'
                    ],
                    [
                        'id' => 6,
                        'sub_lesson' => 'Adjective',
                        'id_sentence' => 'Tulisan ini memberikan kontribusi besar terhadap diskusi kelas.',
                        'target_word' => 'big (Adjective)',
                        'options' => [
                            'This essay makes a big contribution to the class discussion.',
                            'This essay makes a bigly contribution to the class discussion.',
                            'This essay makes a bigness contribution to the class discussion.',
                            'This essay makes a biggen contribution to the class discussion.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Big\' (Adjective) menerangkan noun \'contribution\'.'
                    ],
                    [
                        'id' => 7,
                        'sub_lesson' => 'Adjective',
                        'id_sentence' => 'Bukti nyata sangat penting untuk meyakinkan teman-teman di kelas.',
                        'target_word' => 'clear (Adjective)',
                        'options' => [
                            'Clear evidence is important for convincing our classmates.',
                            'Clearly evidence is important for convincing our classmates.',
                            'Clearness evidence is important for convincing our classmates.',
                            'Clearer evidence is important for convincing our classmates.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Clear\' berfungsi sebagai adjective yang memodifikasi noun \'evidence\'.'
                    ],
                    [
                        'id' => 8,
                        'sub_lesson' => 'Adjective',
                        'id_sentence' => 'Cuaca di kota itu tampaknya stabil selama musim kemarau.',
                        'target_word' => 'stable (Predicative Adjective)',
                        'options' => [
                            'The weather in that city appears stable during the dry season.',
                            'The weather in that city appears stably during the dry season.',
                            'The weather in that city appears stability during the dry season.',
                            'The weather in that city appears stabilize during the dry season.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Setelah linking verb \'appears\', gunakan predicative adjective \'stable\'.'
                    ],
                    [
                        'id' => 9,
                        'sub_lesson' => 'Adjective',
                        'id_sentence' => 'Petunjuk yang membingungkan dapat menimbulkan kesalahpahaman saat mengerjakan tugas.',
                        'target_word' => 'confusing (Adjective)',
                        'options' => [
                            'Confusing instructions can cause misunderstandings when doing homework.',
                            'Confusingly instructions can cause misunderstandings when doing homework.',
                            'Confusion instructions can cause misunderstandings when doing homework.',
                            'Confused instructions can cause misunderstandings when doing homework.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Confusing\' (-ing: menyebabkan efek) adalah adjective yang menerangkan noun \'instructions\'.'
                    ],
                    [
                        'id' => 10,
                        'sub_lesson' => 'Adjective',
                        'id_sentence' => 'Sampah yang berbau busuk menimbulkan masalah serius bagi warga sekitar.',
                        'target_word' => 'smelly (Adjective)',
                        'options' => [
                            'Smelly trash causes a serious problem for the nearby residents.',
                            'Smellily trash causes a serious problem for the nearby residents.',
                            'Smell trash causes a serious problem for the nearby residents.',
                            'Smelling trash causes a serious problem for the nearby residents.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Smelly\' adalah adjective yang menerangkan frasa benda \'trash\'.'
                    ]
                ]
            ],
            [
                'id' => 'adverb',
                'name' => 'Adverb (Adverbia / Kata Keterangan)',
                'code' => '1.1.5',
                'concept_title' => 'Adverb (Adverbia): Mengenal Kata Keterangan',
                'concept_description' => 'Adverb menerangkan kata kerja (verb), kata sifat (adjective), atau adverb lain — biasanya menjelaskan bagaimana, kapan, di mana, atau seberapa sering sesuatu terjadi (misal: run quickly, very happy, come daily). Adverb TIDAK PERNAH menerangkan kata benda secara langsung.',
                'formula' => 'Adverb + Verb | Adverb + Adjective | Adverb + Adverb',
                'rules' => [
                    'Adverb of Manner: Menerangkan cara sesuatu dilakukan (misal: run quickly, speak softly).',
                    'Adverb of Modification: Menerangkan kata sifat (misal: very happy, really tired).',
                    'Adverb of Frequency/Time: Menunjukkan seberapa sering atau kapan (misal: always, often, yesterday).',
                    'Jangan tertukar: Akhiran -ly tidak selalu adverb (misal: \'friendly\', \'costly\', \'lovely\' adalah Adjective).'
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'sub_lesson' => 'Adverb',
                        'id_sentence' => 'Robot mainan itu bergerak dengan sangat cepat.',
                        'target_word' => 'extremely (Adverb of Degree)',
                        'options' => [
                            'The toy robot moved extremely fast.',
                            'The toy robot moved extreme fast.',
                            'The toy robot moved extremity fast.',
                            'The toy robot moved extremeness fast.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Extremely\' (Adverb berakhiran -ly) menerangkan adverb \'fast\'. Bentuk \'extreme\' adalah adjective.'
                    ],
                    [
                        'id' => 2,
                        'sub_lesson' => 'Adverb',
                        'id_sentence' => 'Harga sayur naik secara drastis setelah musim hujan.',
                        'target_word' => 'dramatically (Adverb of Manner/Degree)',
                        'options' => [
                            'Vegetable prices rose dramatically after the rainy season.',
                            'Vegetable prices rose dramatic after the rainy season.',
                            'Vegetable prices rose drama after the rainy season.',
                            'Vegetable prices rose dramatize after the rainy season.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja \'rose\' diterangkan oleh adverb \'dramatically\'. Bentuk \'dramatic\' adalah adjective.'
                    ],
                    [
                        'id' => 3,
                        'sub_lesson' => 'Adverb',
                        'id_sentence' => 'Oleh karena itu, sekolah memberlakukan jam masuk yang lebih pagi.',
                        'target_word' => 'Therefore (Conjunctive Adverb)',
                        'options' => [
                            'Therefore, the school set an earlier starting time.',
                            'There, the school set an earlier starting time.',
                            'Therefor, the school set an earlier starting time.',
                            'Thereby, the school set an earlier starting time.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Therefore\' adalah sentence adverb / conjunctive adverb yang menghubungkan akibat antar kalimat.'
                    ],
                    [
                        'id' => 4,
                        'sub_lesson' => 'Adverb',
                        'id_sentence' => 'Hasil ujian menunjukkan nilai yang sangat berbeda antar kelas.',
                        'target_word' => 'very (Adverb of Degree)',
                        'options' => [
                            'The exam results show very different scores between classes.',
                            'The exam results show truly different scores between classes.',
                            'The exam results show difference different scores between classes.',
                            'The exam results show differently different scores between classes.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Adjective \'different\' dimodifikasi oleh adverb of degree \'very\'.'
                    ],
                    [
                        'id' => 5,
                        'sub_lesson' => 'Adverb',
                        'id_sentence' => 'Air di kolam itu mengering secara perlahan selama musim kemarau.',
                        'target_word' => 'slowly (Adverb of Manner)',
                        'options' => [
                            'The water in the pond dried up slowly during the dry season.',
                            'The water in the pond dried up slow during the dry season.',
                            'The water in the pond dried up slowness during the dry season.',
                            'The water in the pond dried up slowing during the dry season.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja \'dried up\' diterangkan oleh adverb \'slowly\'.'
                    ],
                    [
                        'id' => 6,
                        'sub_lesson' => 'Adverb',
                        'id_sentence' => 'Tentu saja, olahraga rutin membuat tubuh kita lebih sehat.',
                        'target_word' => 'Certainly (Sentence Adverb)',
                        'options' => [
                            'Certainly, regular exercise makes our bodies healthier.',
                            'Certain, regular exercise makes our bodies healthier.',
                            'Certainty, regular exercise makes our bodies healthier.',
                            'Certainness, regular exercise makes our bodies healthier.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Certainly\' berfungsi sebagai sentence adverb pembuka kalimat untuk menyatakan kepastian.'
                    ],
                    [
                        'id' => 7,
                        'sub_lesson' => 'Adverb',
                        'id_sentence' => 'Kedua anak itu bermain bersama dengan rukun hampir setiap hari.',
                        'target_word' => 'happily (Adverb of Manner)',
                        'options' => [
                            'The two children happily play together almost every day.',
                            'The two children happy play together almost every day.',
                            'The two children happiness play together almost every day.',
                            'The two children happier play together almost every day.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja \'play\' dimodifikasi oleh adverb \'happily\'.'
                    ],
                    [
                        'id' => 8,
                        'sub_lesson' => 'Adverb',
                        'id_sentence' => 'Uang jajan kami berkurang banyak gara-gara sering jajan es krim.',
                        'target_word' => 'significantly (Adverb)',
                        'options' => [
                            'Our pocket money decreased significantly because we often bought ice cream.',
                            'Our pocket money decreased significant because we often bought ice cream.',
                            'Our pocket money decreased significance because we often bought ice cream.',
                            'Our pocket money decreased significate because we often bought ice cream.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja \'decreased\' membutuhkan keterangan adverb \'significantly\'.'
                    ],
                    [
                        'id' => 9,
                        'sub_lesson' => 'Adverb',
                        'id_sentence' => 'Sebaliknya, kakak saya justru suka bangun pagi-pagi sekali.',
                        'target_word' => 'However (Conjunctive Adverb)',
                        'options' => [
                            'However, my sister actually likes waking up very early.',
                            'Howbeit, my sister actually likes waking up very early.',
                            'Howsoever, my sister actually likes waking up very early.',
                            'Howling, my sister actually likes waking up very early.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'However\' adalah conjunctive adverb untuk menyatakan perbandingan kontras.'
                    ],
                    [
                        'id' => 10,
                        'sub_lesson' => 'Adverb',
                        'id_sentence' => 'Jam dinding itu harus diperiksa secara rutin agar tetap akurat.',
                        'target_word' => 'regularly (Adverb of Frequency/Time)',
                        'options' => [
                            'The wall clock must be checked regularly to stay accurate.',
                            'The wall clock must be checked regular to stay accurate.',
                            'The wall clock must be checked regularity to stay accurate.',
                            'The wall clock must be checked regularize to stay accurate.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Passive verb \'checked\' diterangkan oleh adverb of frequency \'regularly\'.'
                    ]
                ]
            ],
            [
                'id' => 'preposition',
                'name' => 'Preposition (Preposisi / Kata Depan)',
                'code' => '1.1.6',
                'concept_title' => 'Preposition (Preposisi): Mengenal Kata Depan',
                'concept_description' => 'Preposisi menghubungkan kata benda (noun) atau frasa benda dengan bagian lain dalam kalimat, biasanya menunjukkan tempat, waktu, atau arah (misal: on the table, at 7 o\'clock, to school). Banyak kata kerja dan kata sifat punya pasangan preposisi tetap yang harus dihafalkan (misal: good at, interested in).',
                'formula' => 'Preposition + Noun Phrase ➔ Prepositional Phrase',
                'rules' => [
                    'Preposition of Place: in, on, at, under, near (misal: the cat is on the sofa).',
                    'Preposition of Time: in, on, at (misal: in the morning, on Monday, at noon).',
                    'Collocation Tetap: hafalkan pasangan kata kerja/sifat + preposisi (misal: good at, afraid of, proud of, listen to).',
                    'Setelah preposisi, kata kerja yang mengikuti harus berbentuk -ing (Gerund), misal: \'after eating\', bukan \'after eat\'.'
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'sub_lesson' => 'Preposition',
                        'id_sentence' => 'Hasil ujian matematikaku ternyata sama dengan hasil milik sahabatku.',
                        'target_word' => 'the same as (Prepositional Collocation)',
                        'options' => [
                            'My math exam result turned out to be the same as my best friend\'s.',
                            'My math exam result turned out to be the same to my best friend\'s.',
                            'My math exam result turned out to be the same for my best friend\'s.',
                            'My math exam result turned out to be the same on my best friend\'s.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Frasa \'the same as\' memiliki pasangan preposisi tetap: \'as\'.'
                    ],
                    [
                        'id' => 2,
                        'sub_lesson' => 'Preposition',
                        'id_sentence' => 'Sesuai dengan jadwal sekolah, kelas berenang dimulai pukul delapan pagi.',
                        'target_word' => 'According to (Complex Preposition)',
                        'options' => [
                            'According to the school schedule, swimming class starts at eight in the morning.',
                            'According with the school schedule, swimming class starts at eight in the morning.',
                            'According for the school schedule, swimming class starts at eight in the morning.',
                            'According about the school schedule, swimming class starts at eight in the morning.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Frasa preposisi yang baku dalam bahasa formal adalah \'According to\'.'
                    ],
                    [
                        'id' => 3,
                        'sub_lesson' => 'Preposition',
                        'id_sentence' => 'Meskipun hujan deras, kami tetap pergi berkemah bersama keluarga.',
                        'target_word' => 'Despite (Preposition of Concession)',
                        'options' => [
                            'Despite the heavy rain, we still went camping with the family.',
                            'Despite of the heavy rain, we still went camping with the family.',
                            'In despite the heavy rain, we still went camping with the family.',
                            'Despite with the heavy rain, we still went camping with the family.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Despite\' adalah preposisi tunggal yang diikuti noun phrase tanpa kata \'of\' (berbeda dari \'in spite of\').'
                    ],
                    [
                        'id' => 4,
                        'sub_lesson' => 'Preposition',
                        'id_sentence' => 'Latihan rutin berkontribusi besar terhadap kemenangan tim sepak bola kami.',
                        'target_word' => 'contribute to (Dependent Preposition)',
                        'options' => [
                            'Regular practice contributed greatly to our football team\'s victory.',
                            'Regular practice contributed greatly for our football team\'s victory.',
                            'Regular practice contributed greatly in our football team\'s victory.',
                            'Regular practice contributed greatly with our football team\'s victory.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja \'contribute\' selalu berpasangan dengan preposisi \'to\' (contribute to something).'
                    ],
                    [
                        'id' => 5,
                        'sub_lesson' => 'Preposition',
                        'id_sentence' => 'Semua murid wajib mematuhi aturan keselamatan di kolam renang.',
                        'target_word' => 'adhere to (Dependent Preposition)',
                        'options' => [
                            'All students are required to adhere to the pool safety rules.',
                            'All students are required to adhere with the pool safety rules.',
                            'All students are required to adhere in the pool safety rules.',
                            'All students are required to adhere at the pool safety rules.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kolokasi kata kerja formal untuk mematuhi adalah \'adhere to\'.'
                    ],
                    [
                        'id' => 6,
                        'sub_lesson' => 'Preposition',
                        'id_sentence' => 'Buku cerita ini berfokus pada petualangan seekor kucing kecil.',
                        'target_word' => 'focuses on (Dependent Preposition)',
                        'options' => [
                            'This storybook focuses on the adventures of a little cat.',
                            'This storybook focuses in the adventures of a little cat.',
                            'This storybook focuses at the adventures of a little cat.',
                            'This storybook focuses about the adventures of a little cat.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Kata kerja \'focus\' secara baku berkolokasi dengan preposisi \'on\'.'
                    ],
                    [
                        'id' => 7,
                        'sub_lesson' => 'Preposition',
                        'id_sentence' => 'Berdasarkan ramalan cuaca, besok akan cerah sepanjang hari.',
                        'target_word' => 'Based on (Complex Preposition)',
                        'options' => [
                            'Based on the weather forecast, tomorrow will be sunny all day.',
                            'Based to the weather forecast, tomorrow will be sunny all day.',
                            'Based with the weather forecast, tomorrow will be sunny all day.',
                            'Based for the weather forecast, tomorrow will be sunny all day.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Frasa idiomatis formal yang berarti \'berdasarkan\' adalah \'Based on\'.'
                    ],
                    [
                        'id' => 8,
                        'sub_lesson' => 'Preposition',
                        'id_sentence' => 'Hadiah baru itu berdampak besar pada semangat belajar adik.',
                        'target_word' => 'impact on (Dependent Preposition)',
                        'options' => [
                            'The new gift has a big impact on my little brother\'s motivation to study.',
                            'The new gift has a big impact in my little brother\'s motivation to study.',
                            'The new gift has a big impact to my little brother\'s motivation to study.',
                            'The new gift has a big impact with my little brother\'s motivation to study.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Nomina \'impact\' berpasangan dengan preposisi \'on\' (an impact on something).'
                    ],
                    [
                        'id' => 9,
                        'sub_lesson' => 'Preposition',
                        'id_sentence' => 'Setelah menyelesaikan pekerjaan rumahnya, kakak bermain gitar.',
                        'target_word' => 'After finishing (Preposition + Gerund)',
                        'options' => [
                            'After finishing his homework, my brother played the guitar.',
                            'After finish his homework, my brother played the guitar.',
                            'After finished his homework, my brother played the guitar.',
                            'After to finish his homework, my brother played the guitar.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Setelah preposisi \'After\', kata kerja wajib berbentuk gerund (-ing): \'After finishing\'.'
                    ],
                    [
                        'id' => 10,
                        'sub_lesson' => 'Preposition',
                        'id_sentence' => 'Setiap anggota kelompok bertanggung jawab atas tugasnya masing-masing.',
                        'target_word' => 'responsible for (Dependent Preposition)',
                        'options' => [
                            'Every group member is responsible for their own task.',
                            'Every group member is responsible to their own task.',
                            'Every group member is responsible with their own task.',
                            'Every group member is responsible about their own task.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Adjective \'responsible\' berkolokasi dengan preposisi \'for\' (responsible for something).'
                    ]
                ]
            ],
            [
                'id' => 'conjunction',
                'name' => 'Conjunction (Konjungsi / Kata Sambung)',
                'code' => '1.1.7',
                'concept_title' => 'Conjunction (Konjungsi): Mengenal Kata Sambung',
                'concept_description' => 'Konjungsi menyambungkan kata, frasa, atau kalimat. Konjungsi dibagi menjadi 2 jenis utama: Coordinating Conjunctions (FANBOYS: for, and, nor, but, or, yet, so) untuk menggabungkan dua kalimat setara; dan Subordinating Conjunctions (although, because, while, since) untuk menyambungkan anak kalimat dengan kalimat utama.',
                'formula' => 'Coordinating (FANBOYS) | Subordinating (although, because, since, while)',
                'rules' => [
                    'Coordinating Conjunction: Gabungkan dua kalimat lengkap dengan tanda koma sebelum FANBOYS (Kalimat, and Kalimat).',
                    'Subordinating Conjunction: Jika anak kalimat berada di depan, bubuhkan koma di akhir anak kalimat (Although ..., Kalimat Utama).',
                    'Pastikan dua bagian kalimat yang disambung punya bentuk yang seimbang (misal: \'both playing and singing\', bukan \'both playing and to sing\').',
                    'Hindari Double Conjunction: Jangan menggabungkan \'Although\' dengan \'but\' dalam satu kalimat yang sama.'
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'sub_lesson' => 'Conjunction',
                        'id_sentence' => 'Meskipun hujan deras, kami tetap pergi ke sekolah tepat waktu.',
                        'target_word' => 'Although (Subordinating Conjunction)',
                        'options' => [
                            'Although it was raining heavily, we still got to school on time.',
                            'Although it was raining heavily, but we still got to school on time.',
                            'Despite it was raining heavily, we still got to school on time.',
                            'However it was raining heavily, we still got to school on time.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Although\' adalah subordinating conjunction yang benar. Tidak boleh menambahkan \'but\' di kalimat utama, dan \'despite\' harus diikuti frasa nomina bukan klausa lengkap.'
                    ],
                    [
                        'id' => 2,
                        'sub_lesson' => 'Conjunction',
                        'id_sentence' => 'Sementara kakak suka makanan pedas, adik lebih suka makanan manis.',
                        'target_word' => 'While (Subordinating Conjunction of Contrast)',
                        'options' => [
                            'While my brother loves spicy food, my sister prefers sweet food.',
                            'While my brother loves spicy food, but my sister prefers sweet food.',
                            'In contrast my brother loves spicy food, my sister prefers sweet food.',
                            'However my brother loves spicy food, my sister prefers sweet food.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'While\' berfungsi sebagai subordinating conjunction untuk menunjukkan perbandingan kontras langsung antara dua kalimat.'
                    ],
                    [
                        'id' => 3,
                        'sub_lesson' => 'Conjunction',
                        'id_sentence' => 'Adik tidak hanya pandai menggambar tetapi juga pandai bernyanyi.',
                        'target_word' => 'not only... but also (Correlative Conjunction)',
                        'options' => [
                            'My little sister is not only good at drawing but also good at singing.',
                            'My little sister is not only good at drawing but a good singer.',
                            'My little sister is good not only at drawing but also singing well.',
                            'My little sister is not only good at drawing and also good at singing.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Parallelism: \'not only good at drawing ... but also good at singing\'. Kedua bagian memiliki bentuk yang seimbang.'
                    ],
                    [
                        'id' => 4,
                        'sub_lesson' => 'Conjunction',
                        'id_sentence' => 'Karena ban sepedanya bocor, kakak terpaksa jalan kaki ke sekolah.',
                        'target_word' => 'Because (Subordinating Conjunction of Cause)',
                        'options' => [
                            'Because his bicycle tire was flat, my brother had to walk to school.',
                            'Because of his bicycle tire was flat, my brother had to walk to school.',
                            'Due to his bicycle tire was flat, my brother had to walk to school.',
                            'Owing to his bicycle tire was flat, my brother had to walk to school.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Because\' diikuti oleh kalimat lengkap (Subject + Verb: \'his bicycle tire was flat\'). Pilihan \'Because of\' dan \'Due to\' adalah preposisi yang hanya boleh diikuti frasa benda.'
                    ],
                    [
                        'id' => 5,
                        'sub_lesson' => 'Conjunction',
                        'id_sentence' => 'Payung itu harus dibawa, atau kita akan basah kuyup kehujanan.',
                        'target_word' => 'or (Coordinating Conjunction)',
                        'options' => [
                            'We must bring the umbrella, or we will get soaked in the rain.',
                            'We must bring the umbrella, nor we will get soaked in the rain.',
                            'We must bring the umbrella, but we will get soaked in the rain.',
                            'We must bring the umbrella, so we will get soaked in the rain.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Konjungsi koordinatif \'or\' menyatakan konsekuensi alternatif jika syarat sebelumnya tidak terpenuhi.'
                    ],
                    [
                        'id' => 6,
                        'sub_lesson' => 'Conjunction',
                        'id_sentence' => 'Baik ayah maupun ibu tidak setuju dengan rencana liburan itu.',
                        'target_word' => 'Neither... nor (Correlative Conjunction)',
                        'options' => [
                            'Neither my father nor my mother agreed with the holiday plan.',
                            'Neither my father or my mother agreed with the holiday plan.',
                            'Either my father nor my mother agreed with the holiday plan.',
                            'Both my father nor my mother agreed with the holiday plan.'
                        ],
                        'correct_index' => 0,
                        'explanation' => 'Pasangan korelasi baku untuk penolakan ganda adalah \'Neither... nor...\'.'
                    ],
                    [
                        'id' => 7,
                        'sub_lesson' => 'Conjunction',
                        'id_sentence' => 'Kamu akan boleh main ke luar asalkan kamu sudah menyelesaikan tugas sekolah.',
                        'target_word' => 'provided that (Subordinating Conjunction of Condition)',
                        'options' => [
                            'You may play outside provided that you have finished your homework.',
                            'You may play outside provided you will finish your homework.',
                            'You may play outside in provision that you finish your homework.',
                            'You may play outside provided of you finish your homework.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Provided that\' adalah konjungsi subordinatif yang bermakna \'asalkan / dengan syarat bahwa\'.'
                    ],
                    [
                        'id' => 8,
                        'sub_lesson' => 'Conjunction',
                        'id_sentence' => 'Permainan dihentikan sementara agar semua pemain bisa beristirahat.',
                        'target_word' => 'so that (Subordinating Conjunction of Purpose)',
                        'options' => [
                            'The game was paused so that all the players could take a rest.',
                            'The game was paused in order for all the players could take a rest.',
                            'The game was paused so as all the players could take a rest.',
                            'The game was paused that all the players could take a rest.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'So that\' menghubungkan klausa tujuan dan diikuti oleh modal auxiliary (could / might).'
                    ],
                    [
                        'id' => 9,
                        'sub_lesson' => 'Conjunction',
                        'id_sentence' => 'Nilai ujiannya naik pesat, namun ia masih harus belajar lebih giat.',
                        'target_word' => 'yet (Coordinating Conjunction of Contrast)',
                        'options' => [
                            'Her exam scores improved quickly, yet she still needs to study harder.',
                            'Her exam scores improved quickly, although she still needs to study harder.',
                            'Her exam scores improved quickly, despite she still needs to study harder.',
                            'Her exam scores improved quickly, unless she still needs to study harder.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Yet\' adalah coordinating conjunction yang menghubungkan dua kalimat kontras setara dengan tanda koma pemisah.'
                    ],
                    [
                        'id' => 10,
                        'sub_lesson' => 'Conjunction',
                        'id_sentence' => 'Bahkan jika cuaca buruk, pertandingan sepak bola tetap akan dilanjutkan.',
                        'target_word' => 'Even if (Subordinating Conjunction of Concession)',
                        'options' => [
                            'Even if the weather is bad, the football match will still continue.',
                            'Even though the weather will be bad, the football match will still continue.',
                            'Despite the weather is bad, the football match will still continue.',
                            'Regardless the weather is bad, the football match will still continue.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Even if\' digunakan untuk menyatakan kemungkinan kondisional (bahkan jika).'
                    ]
                ]
            ],
            [
                'id' => 'interjection',
                'name' => 'Interjection (Interjeksi / Kata Seru)',
                'code' => '1.1.8',
                'concept_title' => 'Interjection (Interjeksi): Mengenal Kata Seru',
                'concept_description' => 'Interjection adalah kata seru pendek yang mengekspresikan perasaan secara spontan, seperti terkejut, senang, sakit, atau kecewa (misal: Wow!, Ouch!, Oh no!, Yay!). Interjeksi biasanya berdiri sendiri di awal kalimat dan diikuti tanda seru (!) atau koma.',
                'formula' => 'Interjection + (,/!) + Kalimat',
                'rules' => [
                    'Interjeksi digunakan untuk mengekspresikan emosi secara singkat dan spontan.',
                    'Gunakan tanda seru (!) setelah interjeksi yang kuat, atau koma (,) jika lebih ringan.',
                    'Interjeksi berbeda-beda sesuai emosi: Wow/Great (senang), Ouch/Oh no (sakit/kecewa), Oh/Hmm (berpikir/kaget).',
                    'Interjeksi lazim dipakai dalam percakapan sehari-hari dan cerita, bukan dalam kalimat formal seperti laporan.'
                ],
                'exercises' => [
                    [
                        'id' => 1,
                        'sub_lesson' => 'Interjection',
                        'id_sentence' => 'Wow, hadiah ulang tahun ini benar-benar bagus sekali!',
                        'target_word' => 'Wow (Interjection)',
                        'options' => [
                            'Wow, this birthday present is really nice!',
                            'Wowly, this birthday present is really nice!',
                            'Wowing, this birthday present is really nice!',
                            'Wowful, this birthday present is really nice!'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Wow\' adalah interjeksi untuk mengekspresikan kekaguman atau kejutan menyenangkan.'
                    ],
                    [
                        'id' => 2,
                        'sub_lesson' => 'Interjection',
                        'id_sentence' => 'Aduh, kakiku tersandung batu di jalan!',
                        'target_word' => 'Ouch (Interjection)',
                        'options' => [
                            'Ouch, I tripped over a rock on the road!',
                            'Ouchly, I tripped over a rock on the road!',
                            'Ouching, I tripped over a rock on the road!',
                            'Ouchful, I tripped over a rock on the road!'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Ouch\' adalah interjeksi yang digunakan saat merasa sakit secara tiba-tiba.'
                    ],
                    [
                        'id' => 3,
                        'sub_lesson' => 'Interjection',
                        'id_sentence' => 'Yah, es krimku jatuh ke lantai sebelum sempat kumakan.',
                        'target_word' => 'Oh no (Interjection)',
                        'options' => [
                            'Oh no, my ice cream fell on the floor before I could eat it.',
                            'Oh nos, my ice cream fell on the floor before I could eat it.',
                            'Ohing no, my ice cream fell on the floor before I could eat it.',
                            'No oh, my ice cream fell on the floor before I could eat it.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Oh no\' digunakan untuk mengekspresikan kekecewaan atau kesedihan ringan.'
                    ],
                    [
                        'id' => 4,
                        'sub_lesson' => 'Interjection',
                        'id_sentence' => 'Hore, besok kita akan pergi ke taman bermain!',
                        'target_word' => 'Hooray (Interjection)',
                        'options' => [
                            'Hooray, we are going to the playground tomorrow!',
                            'Hoorayly, we are going to the playground tomorrow!',
                            'Hooraying, we are going to the playground tomorrow!',
                            'Hoorayful, we are going to the playground tomorrow!'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Hooray\' adalah interjeksi untuk mengekspresikan kegembiraan atau perayaan.'
                    ],
                    [
                        'id' => 5,
                        'sub_lesson' => 'Interjection',
                        'id_sentence' => 'Wah, lukisan yang dibuat adikku ternyata sangat indah.',
                        'target_word' => 'Wow (Interjection)',
                        'options' => [
                            'Wow, my little sister\'s painting turned out really beautiful.',
                            'Wower, my little sister\'s painting turned out really beautiful.',
                            'Wowest, my little sister\'s painting turned out really beautiful.',
                            'Wowness, my little sister\'s painting turned out really beautiful.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Wow\' berfungsi untuk mengekspresikan rasa kagum terhadap sesuatu.'
                    ],
                    [
                        'id' => 6,
                        'sub_lesson' => 'Interjection',
                        'id_sentence' => 'Hm, aku tidak yakin jalan mana yang harus kita ambil.',
                        'target_word' => 'Hmm (Interjection)',
                        'options' => [
                            'Hmm, I\'m not sure which way we should go.',
                            'Hmmly, I\'m not sure which way we should go.',
                            'Hmming, I\'m not sure which way we should go.',
                            'Hmmful, I\'m not sure which way we should go.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Hmm\' adalah interjeksi yang menunjukkan sedang berpikir atau ragu-ragu.'
                    ],
                    [
                        'id' => 7,
                        'sub_lesson' => 'Interjection',
                        'id_sentence' => 'Wah, hujan tiba-tiba turun sangat deras sekali.',
                        'target_word' => 'Whoa (Interjection)',
                        'options' => [
                            'Whoa, it suddenly started raining really hard.',
                            'Whoaly, it suddenly started raining really hard.',
                            'Whoaing, it suddenly started raining really hard.',
                            'Whoaful, it suddenly started raining really hard.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Whoa\' menyajikan kejutan secara spontan terhadap sesuatu yang tiba-tiba terjadi.'
                    ],
                    [
                        'id' => 8,
                        'sub_lesson' => 'Interjection',
                        'id_sentence' => 'Yah, pertandingan sepak bola kita kalah sore ini.',
                        'target_word' => 'Aww (Interjection)',
                        'options' => [
                            'Aww, our football match lost this evening.',
                            'Awwly, our football match lost this evening.',
                            'Awwing, our football match lost this evening.',
                            'Awwful, our football match lost this evening.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Aww\' adalah kosa kata sehari-hari untuk menyatakan kekecewaan ringan.'
                    ],
                    [
                        'id' => 9,
                        'sub_lesson' => 'Interjection',
                        'id_sentence' => 'Astaga, aku lupa membawa buku PR ke sekolah!',
                        'target_word' => 'Oh my (Interjection)',
                        'options' => [
                            'Oh my, I forgot to bring my homework book to school!',
                            'Oh mys, I forgot to bring my homework book to school!',
                            'Ohing my, I forgot to bring my homework book to school!',
                            'My oh, I forgot to bring my homework book to school!'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Oh my\' adalah istilah santai untuk menunjukkan rasa kaget atau panik.'
                    ],
                    [
                        'id' => 10,
                        'sub_lesson' => 'Interjection',
                        'id_sentence' => 'Asyik, akhirnya aku berhasil menyelesaikan tugas prakarya ini.',
                        'target_word' => 'Yay (Interjection)',
                        'options' => [
                            'Yay, I finally finished this craft project.',
                            'Yayly, I finally finished this craft project.',
                            'Yaying, I finally finished this craft project.',
                            'Yayful, I finally finished this craft project.'
                        ],
                        'correct_index' => 0,
                        'explanation' => '\'Yay\' adalah interjeksi untuk mengekspresikan kegembiraan atas pencapaian.'
                    ]
                ]
            ]
        ];

$questionsData = [
            [
                'sub_lesson' => 'Noun',
                'sub_lesson_slug' => 'noun',
                'number' => '1',
                'prompt' => '[Noun - Latihan #1] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Kedatangan kakekku dari kampung membuat kami semua sangat gembira." (Target: arrival (Noun))',
                'id_sentence' => 'Kedatangan kakekku dari kampung membuat kami semua sangat gembira.',
                'target_word' => 'arrival (Noun)',
                'options' => [
                    'The arrival of my grandfather from the village made us all very happy.',
                    'The arrive of my grandfather from the village made us all very happy.',
                    'The arriving of my grandfather from the village made us all very happy.',
                    'The arrivally of my grandfather from the village made us all very happy.'
                ],
                'correct_index' => 0,
                'explanation' => 'Kata \'arrival\' (Noun) tepat setelah artikel \'the\' dan berfungsi sebagai subjek kalimat. Pilihan lain (\'arrive\' = verb, \'arriving\' = gerund, \'arrivally\' bukan kata yang benar) salah secara kelas kata.'
            ],
            [
                'sub_lesson' => 'Noun',
                'sub_lesson_slug' => 'noun',
                'number' => '2',
                'prompt' => '[Noun - Latihan #2] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Keberhasilan ujianku bergantung pada ketelitian saat mengerjakan soal." (Target: accuracy (Noun))',
                'id_sentence' => 'Keberhasilan ujianku bergantung pada ketelitian saat mengerjakan soal.',
                'target_word' => 'accuracy (Noun)',
                'options' => [
                    'The success of my exam depends on the accuracy of my answers.',
                    'The success of my exam depends on the accurate of my answers.',
                    'The success of my exam depends on the accurately of my answers.',
                    'The success of my exam depends on the accuratenessly of my answers.'
                ],
                'correct_index' => 0,
                'explanation' => 'Setelah preposisi \'on the\', kita memerlukan kata benda abstrak \'accuracy\' (Noun) sebagai inti frasa nomina sebelum preposisi \'of\'.'
            ],
            [
                'sub_lesson' => 'Noun',
                'sub_lesson_slug' => 'noun',
                'number' => '3',
                'prompt' => '[Noun - Latihan #3] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Perbandingan kedua gambar itu mengungkapkan perbedaan yang jelas." (Target: comparison (Noun))',
                'id_sentence' => 'Perbandingan kedua gambar itu mengungkapkan perbedaan yang jelas.',
                'target_word' => 'comparison (Noun)',
                'options' => [
                    'The comparison of the two pictures revealed clear differences.',
                    'The compare of the two pictures revealed clear differences.',
                    'The comparative of the two pictures revealed clear differences.',
                    'The comparatively of the two pictures revealed clear differences.'
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa subjek \'The comparative ...\' membutuhkan head noun \'analysis\'. Kata \'analyze\' adalah verb dan \'analytical\' adalah adjective.'
            ],
            [
                'sub_lesson' => 'Noun',
                'sub_lesson_slug' => 'noun',
                'number' => '4',
                'prompt' => '[Noun - Latihan #4] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Keikutsertaan aktif dari murid-murid sangat penting untuk acara sekolah ini." (Target: participation (Noun))',
                'id_sentence' => 'Keikutsertaan aktif dari murid-murid sangat penting untuk acara sekolah ini.',
                'target_word' => 'participation (Noun)',
                'options' => [
                    'Active participation by the students is important for this school event.',
                    'Active participate by the students is important for this school event.',
                    'Active participatory by the students is important for this school event.',
                    'Active participatingly by the students is important for this school event.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Participation\' adalah Noun yang diterangkan oleh adjective \'Active\' dan berfungsi sebagai subjek kalimat.'
            ],
            [
                'sub_lesson' => 'Noun',
                'sub_lesson_slug' => 'noun',
                'number' => '5',
                'prompt' => '[Noun - Latihan #5] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Ibu mengukur suhu badan adik sebelum tidur." (Target: temperature (Noun))',
                'id_sentence' => 'Ibu mengukur suhu badan adik sebelum tidur.',
                'target_word' => 'temperature (Noun)',
                'options' => [
                    'Mom measured my little sibling\'s temperature before bed.',
                    'Mom measured my little sibling\'s temper before bed.',
                    'Mom measured my little sibling\'s temperate before bed.',
                    'Mom measured my little sibling\'s temperately before bed.'
                ],
                'correct_index' => 0,
                'explanation' => 'Posisi objek langsung setelah \'measured\' membutuhkan noun \'temperature\'.'
            ],
            [
                'sub_lesson' => 'Noun',
                'sub_lesson_slug' => 'noun',
                'number' => '6',
                'prompt' => '[Noun - Latihan #6] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Penggunaan cara belajar baru meningkatkan pemahaman murid secara menyeluruh." (Target: use (Noun))',
                'id_sentence' => 'Penggunaan cara belajar baru meningkatkan pemahaman murid secara menyeluruh.',
                'target_word' => 'use (Noun)',
                'options' => [
                    'The use of the new study method improved students\' overall understanding.',
                    'The used of the new study method improved students\' overall understanding.',
                    'The usable of the new study method improved students\' overall understanding.',
                    'The usingly of the new study method improved students\' overall understanding.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Use\' sebagai noun (pelafalan \'yoos\') tepat setelah artikel \'The\' dan berfungsi sebagai subjek kalimat.'
            ],
            [
                'sub_lesson' => 'Noun',
                'sub_lesson_slug' => 'noun',
                'number' => '7',
                'prompt' => '[Noun - Latihan #7] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Kurangnya persiapan membuat presentasi kelompok kami kurang lancar." (Target: preparation (Noun))',
                'id_sentence' => 'Kurangnya persiapan membuat presentasi kelompok kami kurang lancar.',
                'target_word' => 'preparation (Noun)',
                'options' => [
                    'The lack of preparation made our group presentation less smooth.',
                    'The lack of prepare made our group presentation less smooth.',
                    'The lack of prepared made our group presentation less smooth.',
                    'The lack of preparedly made our group presentation less smooth.'
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa \'The lack of ...\' membutuhkan kata benda \'preparation\' sebagai objek preposisi \'of\'.'
            ],
            [
                'sub_lesson' => 'Noun',
                'sub_lesson_slug' => 'noun',
                'number' => '8',
                'prompt' => '[Noun - Latihan #8] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Perkembangan hobi melukisnya membuka banyak peluang baru baginya." (Target: development (Noun))',
                'id_sentence' => 'Perkembangan hobi melukisnya membuka banyak peluang baru baginya.',
                'target_word' => 'development (Noun)',
                'options' => [
                    'The development of her painting hobby opened up many new opportunities for her.',
                    'The develop of her painting hobby opened up many new opportunities for her.',
                    'The developmental of her painting hobby opened up many new opportunities for her.',
                    'The developingly of her painting hobby opened up many new opportunities for her.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Development\' adalah Noun yang bertindak sebagai subjek kalimat.'
            ],
            [
                'sub_lesson' => 'Noun',
                'sub_lesson_slug' => 'noun',
                'number' => '9',
                'prompt' => '[Noun - Latihan #9] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Pemeriksaan terhadap kondisi sepeda dilakukan sebelum perjalanan dimulai." (Target: inspection (Noun))',
                'id_sentence' => 'Pemeriksaan terhadap kondisi sepeda dilakukan sebelum perjalanan dimulai.',
                'target_word' => 'inspection (Noun)',
                'options' => [
                    'An inspection of the bicycle\'s condition was done before the trip began.',
                    'An inspect of the bicycle\'s condition was done before the trip began.',
                    'An inspectable of the bicycle\'s condition was done before the trip began.',
                    'An inspectingly of the bicycle\'s condition was done before the trip began.'
                ],
                'correct_index' => 0,
                'explanation' => 'Artikel \'An\' mendahului noun tunggal yang berawalan vokal: \'inspection\'.'
            ],
            [
                'sub_lesson' => 'Noun',
                'sub_lesson_slug' => 'noun',
                'number' => '10',
                'prompt' => '[Noun - Latihan #10] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Kebersihan rumah sangat penting untuk menjaga kesehatan keluarga." (Target: cleanliness (Noun))',
                'id_sentence' => 'Kebersihan rumah sangat penting untuk menjaga kesehatan keluarga.',
                'target_word' => 'cleanliness (Noun)',
                'options' => [
                    'Household cleanliness is essential to keep the family healthy.',
                    'Household clean is essential to keep the family healthy.',
                    'Household cleanly is essential to keep the family healthy.',
                    'Household cleaning is essential to keep the family healthy.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Household\' (Adjective-like noun modifier) menerangkan \'cleanliness\' (Noun) yang berfungsi sebagai subjek kalimat.'
            ],
            [
                'sub_lesson' => 'Pronoun',
                'sub_lesson_slug' => 'pronoun',
                'number' => '1',
                'prompt' => '[Pronoun - Latihan #1] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Baik kakak maupun teman-temannya tidak membawa payung mereka." (Target: their (Pronoun))',
                'id_sentence' => 'Baik kakak maupun teman-temannya tidak membawa payung mereka.',
                'target_word' => 'their (Pronoun)',
                'options' => [
                    'Neither my brother nor his friends brought their umbrellas.',
                    'Neither my brother nor his friends brought his umbrellas.',
                    'Neither my brother nor his friends brought its umbrellas.',
                    'Neither my brother nor his friends brought them umbrellas.'
                ],
                'correct_index' => 0,
                'explanation' => 'Pada pola \'Neither... nor...\', kata ganti kepemilikan menyesuaikan dengan subjek terdekat (\'his friends\' = plural) sehingga menggunakan \'their\'.'
            ],
            [
                'sub_lesson' => 'Pronoun',
                'sub_lesson_slug' => 'pronoun',
                'number' => '2',
                'prompt' => '[Pronoun - Latihan #2] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Murid-murid yang datang tepat waktu mendapat hadiah dari guru." (Target: who (Relative Pronoun))',
                'id_sentence' => 'Murid-murid yang datang tepat waktu mendapat hadiah dari guru.',
                'target_word' => 'who (Relative Pronoun)',
                'options' => [
                    'The students who arrived on time got a prize from the teacher.',
                    'The students which arrived on time got a prize from the teacher.',
                    'The students whom arrived on time got a prize from the teacher.',
                    'The students whose arrived on time got a prize from the teacher.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Who\' adalah relative pronoun subjek yang merujuk pada manusia (\'The students\'). \'Which\' untuk benda, \'whom\' untuk objek, \'whose\' untuk kepemilikan.'
            ],
            [
                'sub_lesson' => 'Pronoun',
                'sub_lesson_slug' => 'pronoun',
                'number' => '3',
                'prompt' => '[Pronoun - Latihan #3] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Toko buku itu menerbitkan katalog barunya kemarin." (Target: its (Possessive Pronoun))',
                'id_sentence' => 'Toko buku itu menerbitkan katalog barunya kemarin.',
                'target_word' => 'its (Possessive Pronoun)',
                'options' => [
                    'The bookstore published its new catalog yesterday.',
                    'The bookstore published their new catalog yesterday.',
                    'The bookstore published it\'s new catalog yesterday.',
                    'The bookstore published hers new catalog yesterday.'
                ],
                'correct_index' => 0,
                'explanation' => '\'The bookstore\' adalah entitas tunggal, sehingga kata ganti kepemilikan yang tepat adalah \'its\' (bukan \'their\' dan bukan \'it\'s\').'
            ],
            [
                'sub_lesson' => 'Pronoun',
                'sub_lesson_slug' => 'pronoun',
                'number' => '4',
                'prompt' => '[Pronoun - Latihan #4] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Setiap anak harus membawa botol minumnya sendiri ke sekolah." (Target: each (Indefinite Pronoun))',
                'id_sentence' => 'Setiap anak harus membawa botol minumnya sendiri ke sekolah.',
                'target_word' => 'each (Indefinite Pronoun)',
                'options' => [
                    'Each child must bring their own water bottle to school.',
                    'All child must bring their own water bottle to school.',
                    'Both child must bring their own water bottle to school.',
                    'Every of child must bring their own water bottle to school.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Each child\' adalah pola baku indefinite pronoun untuk merujuk setiap individu secara terpisah.'
            ],
            [
                'sub_lesson' => 'Pronoun',
                'sub_lesson_slug' => 'pronoun',
                'number' => '5',
                'prompt' => '[Pronoun - Latihan #5] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Mainan yang dibelikan oleh ayah sangat disukai adik." (Target: which (Relative Pronoun))',
                'id_sentence' => 'Mainan yang dibelikan oleh ayah sangat disukai adik.',
                'target_word' => 'which (Relative Pronoun)',
                'options' => [
                    'The toy, which father bought, was loved by my little sibling.',
                    'The toy, whom father bought, was loved by my little sibling.',
                    'The toy, who father bought, was loved by my little sibling.',
                    'The toy, what father bought, was loved by my little sibling.'
                ],
                'correct_index' => 0,
                'explanation' => 'Karena merujuk pada benda (\'The toy\'), gunakan relative pronoun \'which\', bukan \'who\'/\'whom\' yang untuk orang.'
            ],
            [
                'sub_lesson' => 'Pronoun',
                'sub_lesson_slug' => 'pronoun',
                'number' => '6',
                'prompt' => '[Pronoun - Latihan #6] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Anak-anak itu bangga pada diri mereka sendiri setelah menang lomba." (Target: themselves (Reflexive Pronoun))',
                'id_sentence' => 'Anak-anak itu bangga pada diri mereka sendiri setelah menang lomba.',
                'target_word' => 'themselves (Reflexive Pronoun)',
                'options' => [
                    'The children were proud of themselves after winning the race.',
                    'The children were proud of theirselves after winning the race.',
                    'The children were proud of them after winning the race.',
                    'The children were proud of each other after winning the race.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Themselves\' adalah reflexive pronoun jamak orang ketiga. Bentuk \'theirselves\' tidak ada dalam tata bahasa baku.'
            ],
            [
                'sub_lesson' => 'Pronoun',
                'sub_lesson_slug' => 'pronoun',
                'number' => '7',
                'prompt' => '[Pronoun - Latihan #7] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Kue-kue ini dibuat oleh ibu untuk acara ulang tahun." (Target: these (Demonstrative Pronoun))',
                'id_sentence' => 'Kue-kue ini dibuat oleh ibu untuk acara ulang tahun.',
                'target_word' => 'these (Demonstrative Pronoun)',
                'options' => [
                    'These cookies were made by mother for the birthday party.',
                    'This cookies were made by mother for the birthday party.',
                    'Those cookie were made by mother for the birthday party.',
                    'That cookies were made by mother for the birthday party.'
                ],
                'correct_index' => 0,
                'explanation' => 'Kata benda jamak \'cookies\' yang dekat harus dipasangkan dengan demonstrative plural \'These\'.'
            ],
            [
                'sub_lesson' => 'Pronoun',
                'sub_lesson_slug' => 'pronoun',
                'number' => '8',
                'prompt' => '[Pronoun - Latihan #8] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Teman yang diundang oleh kakak datang membawa kado." (Target: whom (Objective Relative Pronoun))',
                'id_sentence' => 'Teman yang diundang oleh kakak datang membawa kado.',
                'target_word' => 'whom (Objective Relative Pronoun)',
                'options' => [
                    'The friend whom my sister invited came with a gift.',
                    'The friend which my sister invited came with a gift.',
                    'The friend whose my sister invited came with a gift.',
                    'The friend what my sister invited came with a gift.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Whom\' bertindak sebagai objek dari kata kerja \'invited\' dalam klausa relatif yang merujuk pada manusia.'
            ],
            [
                'sub_lesson' => 'Pronoun',
                'sub_lesson_slug' => 'pronoun',
                'number' => '9',
                'prompt' => '[Pronoun - Latihan #9] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Kedua baju itu tidak muat, tidak satupun cocok untukku." (Target: neither (Indefinite Pronoun))',
                'id_sentence' => 'Kedua baju itu tidak muat, tidak satupun cocok untukku.',
                'target_word' => 'neither (Indefinite Pronoun)',
                'options' => [
                    'Both shirts didn\'t fit; neither suited me.',
                    'Both shirts didn\'t fit; none suited me.',
                    'Both shirts didn\'t fit; either suited me.',
                    'Both shirts didn\'t fit; nothing suited me.'
                ],
                'correct_index' => 0,
                'explanation' => 'Ketika merujuk pada dua hal (\'Both shirts\'), kata ganti negatif yang tepat adalah \'neither\' (bukan \'none\' yang digunakan untuk tiga hal atau lebih).'
            ],
            [
                'sub_lesson' => 'Pronoun',
                'sub_lesson_slug' => 'pronoun',
                'number' => '10',
                'prompt' => '[Pronoun - Latihan #10] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Siapapun yang ingin ikut piknik harus daftar sebelum Jumat." (Target: whoever (Indefinite Relative Pronoun))',
                'id_sentence' => 'Siapapun yang ingin ikut piknik harus daftar sebelum Jumat.',
                'target_word' => 'whoever (Indefinite Relative Pronoun)',
                'options' => [
                    'Whoever wants to join the picnic must sign up before Friday.',
                    'Whomever wants to join the picnic must sign up before Friday.',
                    'Whichever wants to join the picnic must sign up before Friday.',
                    'Whatever wants to join the picnic must sign up before Friday.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Whoever\' berfungsi sebagai subjek kalimat dalam noun clause (\'Whoever wants...\').'
            ],
            [
                'sub_lesson' => 'Verb',
                'sub_lesson_slug' => 'verb',
                'number' => '1',
                'prompt' => '[Verb - Latihan #1] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Ibu memutuskan untuk memasak nasi goreng untuk makan malam." (Target: decides (Verb))',
                'id_sentence' => 'Ibu memutuskan untuk memasak nasi goreng untuk makan malam.',
                'target_word' => 'decides (Verb)',
                'options' => [
                    'Mom decides to cook fried rice for dinner.',
                    'Mom decision to cook fried rice for dinner.',
                    'Mom decisive to cook fried rice for dinner.',
                    'Mom decisively to cook fried rice for dinner.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Decides\' adalah verb tunggal yang mempredikasi subjek \'Mom\'. Pilihan lain berupa noun (-ion), adjective (-ive), atau adverb (-ly).'
            ],
            [
                'sub_lesson' => 'Verb',
                'sub_lesson_slug' => 'verb',
                'number' => '2',
                'prompt' => '[Verb - Latihan #2] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Guru memeriksa semua tugas murid sebelum pulang sekolah." (Target: checked (Past Verb))',
                'id_sentence' => 'Guru memeriksa semua tugas murid sebelum pulang sekolah.',
                'target_word' => 'checked (Past Verb)',
                'options' => [
                    'The teacher checked all the students\' homework before going home.',
                    'The teacher checking all the students\' homework before going home.',
                    'The teacher checks all the students\' homework before going home.',
                    'The teacher to check all the students\' homework before going home.'
                ],
                'correct_index' => 0,
                'explanation' => 'Kalimat membutuhkan kata kerja utama bentuk lampau: \'checked\'.'
            ],
            [
                'sub_lesson' => 'Verb',
                'sub_lesson_slug' => 'verb',
                'number' => '3',
                'prompt' => '[Verb - Latihan #3] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Buku cerita itu menunjukkan gambar yang sangat lucu." (Target: shows (Verb))',
                'id_sentence' => 'Buku cerita itu menunjukkan gambar yang sangat lucu.',
                'target_word' => 'shows (Verb)',
                'options' => [
                    'The storybook shows a very funny picture.',
                    'The storybook show a very funny picture.',
                    'The storybook showing a very funny picture.',
                    'The storybook to show a very funny picture.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Shows\' adalah finite verb untuk subjek tunggal \'The storybook\'.'
            ],
            [
                'sub_lesson' => 'Verb',
                'sub_lesson_slug' => 'verb',
                'number' => '4',
                'prompt' => '[Verb - Latihan #4] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Kakak berencana membersihkan kamarnya setiap akhir pekan." (Target: clean (Infinitive Verb))',
                'id_sentence' => 'Kakak berencana membersihkan kamarnya setiap akhir pekan.',
                'target_word' => 'clean (Infinitive Verb)',
                'options' => [
                    'My sister plans to clean her room every weekend.',
                    'My sister plans to cleaning her room every weekend.',
                    'My sister plans to cleaner her room every weekend.',
                    'My sister plans to cleanly her room every weekend.'
                ],
                'correct_index' => 0,
                'explanation' => 'Setelah partikel \'to\' (to-infinitive), gunakan bentuk kata kerja dasar (base verb): \'clean\'.'
            ],
            [
                'sub_lesson' => 'Verb',
                'sub_lesson_slug' => 'verb',
                'number' => '5',
                'prompt' => '[Verb - Latihan #5] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Adik berhasil memperbaiki sepeda roda tiganya sendiri." (Target: fixed (Past Verb))',
                'id_sentence' => 'Adik berhasil memperbaiki sepeda roda tiganya sendiri.',
                'target_word' => 'fixed (Past Verb)',
                'options' => [
                    'My little brother successfully fixed his own tricycle.',
                    'My little brother successfully fix his own tricycle.',
                    'My little brother successfully fixing his own tricycle.',
                    'My little brother successfully fixes his own tricycle.'
                ],
                'correct_index' => 0,
                'explanation' => 'Diterangkan oleh adverb \'successfully\', predikat kalimat membutuhkan past verb \'fixed\'.'
            ],
            [
                'sub_lesson' => 'Verb',
                'sub_lesson_slug' => 'verb',
                'number' => '6',
                'prompt' => '[Verb - Latihan #6] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Hujan deras mempercepat jalan kami pulang ke rumah." (Target: hurry (Transitive Verb))',
                'id_sentence' => 'Hujan deras mempercepat jalan kami pulang ke rumah.',
                'target_word' => 'hurry (Transitive Verb)',
                'options' => [
                    'Heavy rain makes us hurry home.',
                    'Heavy rain makes us hurrying home.',
                    'Heavy rain makes us to hurry home.',
                    'Heavy rain makes us hurries home.'
                ],
                'correct_index' => 0,
                'explanation' => 'Setelah \'makes us\', gunakan bentuk dasar kata kerja \'hurry\' (bare infinitive).'
            ],
            [
                'sub_lesson' => 'Verb',
                'sub_lesson_slug' => 'verb',
                'number' => '7',
                'prompt' => '[Verb - Latihan #7] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Cerita ini menjelaskan mengapa langit berwarna biru." (Target: explains (Verb))',
                'id_sentence' => 'Cerita ini menjelaskan mengapa langit berwarna biru.',
                'target_word' => 'explains (Verb)',
                'options' => [
                    'This story explains why the sky is blue.',
                    'This story explanation why the sky is blue.',
                    'This story explainable why the sky is blue.',
                    'This story explainingly why the sky is blue.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Explains\' adalah verb bermakna \'menjelaskan\' untuk subjek tunggal \'This story\'.'
            ],
            [
                'sub_lesson' => 'Verb',
                'sub_lesson_slug' => 'verb',
                'number' => '8',
                'prompt' => '[Verb - Latihan #8] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Teman-teman memprediksi bahwa tim kami akan menang pertandingan besok." (Target: predict (Reporting Verb))',
                'id_sentence' => 'Teman-teman memprediksi bahwa tim kami akan menang pertandingan besok.',
                'target_word' => 'predict (Reporting Verb)',
                'options' => [
                    'My friends predict that our team will win the match tomorrow.',
                    'My friends prediction that our team will win the match tomorrow.',
                    'My friends predictive that our team will win the match tomorrow.',
                    'My friends predictably that our team will win the match tomorrow.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Predict\' adalah finite verb untuk subjek jamak \'My friends\'.'
            ],
            [
                'sub_lesson' => 'Verb',
                'sub_lesson_slug' => 'verb',
                'number' => '9',
                'prompt' => '[Verb - Latihan #9] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Helm yang bagus mengurangi risiko cedera saat bersepeda." (Target: reduces (Verb))',
                'id_sentence' => 'Helm yang bagus mengurangi risiko cedera saat bersepeda.',
                'target_word' => 'reduces (Verb)',
                'options' => [
                    'A good helmet reduces the risk of injury while cycling.',
                    'A good helmet reduce the risk of injury while cycling.',
                    'A good helmet reducing the risk of injury while cycling.',
                    'A good helmet reduction the risk of injury while cycling.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Reduce\' adalah verb untuk subjek tunggal \'A good helmet\', jadi membutuhkan -s.'
            ],
            [
                'sub_lesson' => 'Verb',
                'sub_lesson_slug' => 'verb',
                'number' => '10',
                'prompt' => '[Verb - Latihan #10] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Hasil ujian itu membuktikan bahwa usahanya selama ini berhasil." (Target: proved (Verb))',
                'id_sentence' => 'Hasil ujian itu membuktikan bahwa usahanya selama ini berhasil.',
                'target_word' => 'proved (Verb)',
                'options' => [
                    'The exam results proved that her hard work paid off.',
                    'The exam results proof that her hard work paid off.',
                    'The exam results proving that her hard work paid off.',
                    'The exam results provingly that her hard work paid off.'
                ],
                'correct_index' => 0,
                'explanation' => 'Predikat kalimat harus berbentuk verb lampau: \'proved\'.'
            ],
            [
                'sub_lesson' => 'Adjective',
                'sub_lesson_slug' => 'adjective',
                'number' => '1',
                'prompt' => '[Adjective - Latihan #1] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Nenek memberikan cerita yang menarik sebelum kami tidur." (Target: interesting (Adjective))',
                'id_sentence' => 'Nenek memberikan cerita yang menarik sebelum kami tidur.',
                'target_word' => 'interesting (Adjective)',
                'options' => [
                    'Grandma told an interesting story before we went to sleep.',
                    'Grandma told an interest story before we went to sleep.',
                    'Grandma told an interestingly story before we went to sleep.',
                    'Grandma told an interestly story before we went to sleep.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Interesting\' adalah attributive adjective yang menerangkan kata benda \'story\'.'
            ],
            [
                'sub_lesson' => 'Adjective',
                'sub_lesson_slug' => 'adjective',
                'number' => '2',
                'prompt' => '[Adjective - Latihan #2] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Jawaban pertama dari kuis tersebut masih belum yakin menurut murid-murid." (Target: unsure (Predicative Adjective))',
                'id_sentence' => 'Jawaban pertama dari kuis tersebut masih belum yakin menurut murid-murid.',
                'target_word' => 'unsure (Predicative Adjective)',
                'options' => [
                    'The first answer to the quiz still felt unsure to the students.',
                    'The first answer to the quiz still felt unsurely to the students.',
                    'The first answer to the quiz still felt unsureness to the students.',
                    'The first answer to the quiz still felt unsuring to the students.'
                ],
                'correct_index' => 0,
                'explanation' => 'Setelah linking verb \'felt\', posisi komplemen subjek harus diisi oleh predicative adjective \'unsure\'.'
            ],
            [
                'sub_lesson' => 'Adjective',
                'sub_lesson_slug' => 'adjective',
                'number' => '3',
                'prompt' => '[Adjective - Latihan #3] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Hujan deras merupakan masalah besar bagi para petani padi." (Target: big (Attributive Adjective))',
                'id_sentence' => 'Hujan deras merupakan masalah besar bagi para petani padi.',
                'target_word' => 'big (Attributive Adjective)',
                'options' => [
                    'Heavy rain is a big problem for rice farmers.',
                    'Heavy rain is a bigly problem for rice farmers.',
                    'Heavy rain is a bigness problem for rice farmers.',
                    'Heavy rain is a biggest problem for rice farmers.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Big\' (Adjective) menerangkan kata benda \'problem\'.'
            ],
            [
                'sub_lesson' => 'Adjective',
                'sub_lesson_slug' => 'adjective',
                'number' => '4',
                'prompt' => '[Adjective - Latihan #4] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Pelatih menerapkan latihan yang ketat untuk memastikan tim siap bertanding." (Target: strict (Adjective))',
                'id_sentence' => 'Pelatih menerapkan latihan yang ketat untuk memastikan tim siap bertanding.',
                'target_word' => 'strict (Adjective)',
                'options' => [
                    'The coach used a strict training plan to make sure the team was ready.',
                    'The coach used a strictly training plan to make sure the team was ready.',
                    'The coach used a strictness training plan to make sure the team was ready.',
                    'The coach used a stricter training plan to make sure the team was ready.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Strict\' adalah adjective yang menerangkan kata benda \'training plan\'.'
            ],
            [
                'sub_lesson' => 'Adjective',
                'sub_lesson_slug' => 'adjective',
                'number' => '5',
                'prompt' => '[Adjective - Latihan #5] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Rencana yang diusulkan oleh kakak terbukti mudah dan murah." (Target: cheap (Predicative Adjective))',
                'id_sentence' => 'Rencana yang diusulkan oleh kakak terbukti mudah dan murah.',
                'target_word' => 'cheap (Predicative Adjective)',
                'options' => [
                    'My sister\'s proposed plan turned out to be easy and cheap.',
                    'My sister\'s proposed plan turned out to be easy and cheaply.',
                    'My sister\'s proposed plan turned out to be easy and cheapness.',
                    'My sister\'s proposed plan turned out to be easy and cheapen.'
                ],
                'correct_index' => 0,
                'explanation' => 'Setelah linking verb \'to be\', gunakan predicative adjective \'cheap\'.'
            ],
            [
                'sub_lesson' => 'Adjective',
                'sub_lesson_slug' => 'adjective',
                'number' => '6',
                'prompt' => '[Adjective - Latihan #6] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Tulisan ini memberikan kontribusi besar terhadap diskusi kelas." (Target: big (Adjective))',
                'id_sentence' => 'Tulisan ini memberikan kontribusi besar terhadap diskusi kelas.',
                'target_word' => 'big (Adjective)',
                'options' => [
                    'This essay makes a big contribution to the class discussion.',
                    'This essay makes a bigly contribution to the class discussion.',
                    'This essay makes a bigness contribution to the class discussion.',
                    'This essay makes a biggen contribution to the class discussion.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Big\' (Adjective) menerangkan noun \'contribution\'.'
            ],
            [
                'sub_lesson' => 'Adjective',
                'sub_lesson_slug' => 'adjective',
                'number' => '7',
                'prompt' => '[Adjective - Latihan #7] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Bukti nyata sangat penting untuk meyakinkan teman-teman di kelas." (Target: clear (Adjective))',
                'id_sentence' => 'Bukti nyata sangat penting untuk meyakinkan teman-teman di kelas.',
                'target_word' => 'clear (Adjective)',
                'options' => [
                    'Clear evidence is important for convincing our classmates.',
                    'Clearly evidence is important for convincing our classmates.',
                    'Clearness evidence is important for convincing our classmates.',
                    'Clearer evidence is important for convincing our classmates.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Clear\' berfungsi sebagai adjective yang memodifikasi noun \'evidence\'.'
            ],
            [
                'sub_lesson' => 'Adjective',
                'sub_lesson_slug' => 'adjective',
                'number' => '8',
                'prompt' => '[Adjective - Latihan #8] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Cuaca di kota itu tampaknya stabil selama musim kemarau." (Target: stable (Predicative Adjective))',
                'id_sentence' => 'Cuaca di kota itu tampaknya stabil selama musim kemarau.',
                'target_word' => 'stable (Predicative Adjective)',
                'options' => [
                    'The weather in that city appears stable during the dry season.',
                    'The weather in that city appears stably during the dry season.',
                    'The weather in that city appears stability during the dry season.',
                    'The weather in that city appears stabilize during the dry season.'
                ],
                'correct_index' => 0,
                'explanation' => 'Setelah linking verb \'appears\', gunakan predicative adjective \'stable\'.'
            ],
            [
                'sub_lesson' => 'Adjective',
                'sub_lesson_slug' => 'adjective',
                'number' => '9',
                'prompt' => '[Adjective - Latihan #9] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Petunjuk yang membingungkan dapat menimbulkan kesalahpahaman saat mengerjakan tugas." (Target: confusing (Adjective))',
                'id_sentence' => 'Petunjuk yang membingungkan dapat menimbulkan kesalahpahaman saat mengerjakan tugas.',
                'target_word' => 'confusing (Adjective)',
                'options' => [
                    'Confusing instructions can cause misunderstandings when doing homework.',
                    'Confusingly instructions can cause misunderstandings when doing homework.',
                    'Confusion instructions can cause misunderstandings when doing homework.',
                    'Confused instructions can cause misunderstandings when doing homework.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Confusing\' (-ing: menyebabkan efek) adalah adjective yang menerangkan noun \'instructions\'.'
            ],
            [
                'sub_lesson' => 'Adjective',
                'sub_lesson_slug' => 'adjective',
                'number' => '10',
                'prompt' => '[Adjective - Latihan #10] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Sampah yang berbau busuk menimbulkan masalah serius bagi warga sekitar." (Target: smelly (Adjective))',
                'id_sentence' => 'Sampah yang berbau busuk menimbulkan masalah serius bagi warga sekitar.',
                'target_word' => 'smelly (Adjective)',
                'options' => [
                    'Smelly trash causes a serious problem for the nearby residents.',
                    'Smellily trash causes a serious problem for the nearby residents.',
                    'Smell trash causes a serious problem for the nearby residents.',
                    'Smelling trash causes a serious problem for the nearby residents.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Smelly\' adalah adjective yang menerangkan frasa benda \'trash\'.'
            ],
            [
                'sub_lesson' => 'Adverb',
                'sub_lesson_slug' => 'adverb',
                'number' => '1',
                'prompt' => '[Adverb - Latihan #1] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Robot mainan itu bergerak dengan sangat cepat." (Target: extremely (Adverb of Degree))',
                'id_sentence' => 'Robot mainan itu bergerak dengan sangat cepat.',
                'target_word' => 'extremely (Adverb of Degree)',
                'options' => [
                    'The toy robot moved extremely fast.',
                    'The toy robot moved extreme fast.',
                    'The toy robot moved extremity fast.',
                    'The toy robot moved extremeness fast.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Extremely\' (Adverb berakhiran -ly) menerangkan adverb \'fast\'.'
            ],
            [
                'sub_lesson' => 'Adverb',
                'sub_lesson_slug' => 'adverb',
                'number' => '2',
                'prompt' => '[Adverb - Latihan #2] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Harga sayur naik secara drastis setelah musim hujan." (Target: dramatically (Adverb of Manner/Degree))',
                'id_sentence' => 'Harga sayur naik secara drastis setelah musim hujan.',
                'target_word' => 'dramatically (Adverb of Manner/Degree)',
                'options' => [
                    'Vegetable prices rose dramatically after the rainy season.',
                    'Vegetable prices rose dramatic after the rainy season.',
                    'Vegetable prices rose drama after the rainy season.',
                    'Vegetable prices rose dramatize after the rainy season.'
                ],
                'correct_index' => 0,
                'explanation' => 'Kata kerja \'rose\' diterangkan oleh adverb \'dramatically\'.'
            ],
            [
                'sub_lesson' => 'Adverb',
                'sub_lesson_slug' => 'adverb',
                'number' => '3',
                'prompt' => '[Adverb - Latihan #3] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Oleh karena itu, sekolah memberlakukan jam masuk yang lebih pagi." (Target: Therefore (Conjunctive Adverb))',
                'id_sentence' => 'Oleh karena itu, sekolah memberlakukan jam masuk yang lebih pagi.',
                'target_word' => 'Therefore (Conjunctive Adverb)',
                'options' => [
                    'Therefore, the school set an earlier starting time.',
                    'There, the school set an earlier starting time.',
                    'Therefor, the school set an earlier starting time.',
                    'Thereby, the school set an earlier starting time.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Therefore\' adalah conjunctive adverb yang menghubungkan akibat antar kalimat.'
            ],
            [
                'sub_lesson' => 'Adverb',
                'sub_lesson_slug' => 'adverb',
                'number' => '4',
                'prompt' => '[Adverb - Latihan #4] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Hasil ujian menunjukkan nilai yang sangat berbeda antar kelas." (Target: very (Adverb of Degree))',
                'id_sentence' => 'Hasil ujian menunjukkan nilai yang sangat berbeda antar kelas.',
                'target_word' => 'very (Adverb of Degree)',
                'options' => [
                    'The exam results show very different scores between classes.',
                    'The exam results show truly different scores between classes.',
                    'The exam results show difference different scores between classes.',
                    'The exam results show differently different scores between classes.'
                ],
                'correct_index' => 0,
                'explanation' => 'Adjective \'different\' dimodifikasi oleh adverb of degree \'very\'.'
            ],
            [
                'sub_lesson' => 'Adverb',
                'sub_lesson_slug' => 'adverb',
                'number' => '5',
                'prompt' => '[Adverb - Latihan #5] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Air di kolam itu mengering secara perlahan selama musim kemarau." (Target: slowly (Adverb of Manner))',
                'id_sentence' => 'Air di kolam itu mengering secara perlahan selama musim kemarau.',
                'target_word' => 'slowly (Adverb of Manner)',
                'options' => [
                    'The water in the pond dried up slowly during the dry season.',
                    'The water in the pond dried up slow during the dry season.',
                    'The water in the pond dried up slowness during the dry season.',
                    'The water in the pond dried up slowing during the dry season.'
                ],
                'correct_index' => 0,
                'explanation' => 'Kata kerja \'dried up\' diterangkan oleh adverb \'slowly\'.'
            ],
            [
                'sub_lesson' => 'Adverb',
                'sub_lesson_slug' => 'adverb',
                'number' => '6',
                'prompt' => '[Adverb - Latihan #6] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Tentu saja, olahraga rutin membuat tubuh kita lebih sehat." (Target: Certainly (Sentence Adverb))',
                'id_sentence' => 'Tentu saja, olahraga rutin membuat tubuh kita lebih sehat.',
                'target_word' => 'Certainly (Sentence Adverb)',
                'options' => [
                    'Certainly, regular exercise makes our bodies healthier.',
                    'Certain, regular exercise makes our bodies healthier.',
                    'Certainty, regular exercise makes our bodies healthier.',
                    'Certainness, regular exercise makes our bodies healthier.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Certainly\' berfungsi sebagai sentence adverb pembuka kalimat.'
            ],
            [
                'sub_lesson' => 'Adverb',
                'sub_lesson_slug' => 'adverb',
                'number' => '7',
                'prompt' => '[Adverb - Latihan #7] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Kedua anak itu bermain bersama dengan rukun hampir setiap hari." (Target: happily (Adverb of Manner))',
                'id_sentence' => 'Kedua anak itu bermain bersama dengan rukun hampir setiap hari.',
                'target_word' => 'happily (Adverb of Manner)',
                'options' => [
                    'The two children happily play together almost every day.',
                    'The two children happy play together almost every day.',
                    'The two children happiness play together almost every day.',
                    'The two children happier play together almost every day.'
                ],
                'correct_index' => 0,
                'explanation' => 'Kata kerja \'play\' dimodifikasi oleh adverb \'happily\'.'
            ],
            [
                'sub_lesson' => 'Adverb',
                'sub_lesson_slug' => 'adverb',
                'number' => '8',
                'prompt' => '[Adverb - Latihan #8] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Uang jajan kami berkurang banyak gara-gara sering jajan es krim." (Target: significantly (Adverb))',
                'id_sentence' => 'Uang jajan kami berkurang banyak gara-gara sering jajan es krim.',
                'target_word' => 'significantly (Adverb)',
                'options' => [
                    'Our pocket money decreased significantly because we often bought ice cream.',
                    'Our pocket money decreased significant because we often bought ice cream.',
                    'Our pocket money decreased significance because we often bought ice cream.',
                    'Our pocket money decreased significate because we often bought ice cream.'
                ],
                'correct_index' => 0,
                'explanation' => 'Kata kerja \'decreased\' membutuhkan keterangan adverb \'significantly\'.'
            ],
            [
                'sub_lesson' => 'Adverb',
                'sub_lesson_slug' => 'adverb',
                'number' => '9',
                'prompt' => '[Adverb - Latihan #9] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Sebaliknya, kakak saya justru suka bangun pagi-pagi sekali." (Target: However (Conjunctive Adverb))',
                'id_sentence' => 'Sebaliknya, kakak saya justru suka bangun pagi-pagi sekali.',
                'target_word' => 'However (Conjunctive Adverb)',
                'options' => [
                    'However, my sister actually likes waking up very early.',
                    'Howbeit, my sister actually likes waking up very early.',
                    'Howsoever, my sister actually likes waking up very early.',
                    'Howling, my sister actually likes waking up very early.'
                ],
                'correct_index' => 0,
                'explanation' => '\'However\' adalah conjunctive adverb untuk menyatakan kontras.'
            ],
            [
                'sub_lesson' => 'Adverb',
                'sub_lesson_slug' => 'adverb',
                'number' => '10',
                'prompt' => '[Adverb - Latihan #10] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Jam dinding itu harus diperiksa secara rutin agar tetap akurat." (Target: regularly (Adverb of Frequency/Time))',
                'id_sentence' => 'Jam dinding itu harus diperiksa secara rutin agar tetap akurat.',
                'target_word' => 'regularly (Adverb of Frequency/Time)',
                'options' => [
                    'The wall clock must be checked regularly to stay accurate.',
                    'The wall clock must be checked regular to stay accurate.',
                    'The wall clock must be checked regularity to stay accurate.',
                    'The wall clock must be checked regularize to stay accurate.'
                ],
                'correct_index' => 0,
                'explanation' => 'Passive verb \'checked\' diterangkan oleh adverb of frequency \'regularly\'.'
            ],
            [
                'sub_lesson' => 'Preposition',
                'sub_lesson_slug' => 'preposition',
                'number' => '1',
                'prompt' => '[Preposition - Latihan #1] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Hasil ujian matematikaku ternyata sama dengan hasil milik sahabatku." (Target: the same as (Prepositional Collocation))',
                'id_sentence' => 'Hasil ujian matematikaku ternyata sama dengan hasil milik sahabatku.',
                'target_word' => 'the same as (Prepositional Collocation)',
                'options' => [
                    'My math exam result turned out to be the same as my best friend\'s.',
                    'My math exam result turned out to be the same to my best friend\'s.',
                    'My math exam result turned out to be the same for my best friend\'s.',
                    'My math exam result turned out to be the same on my best friend\'s.'
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa \'the same as\' memiliki pasangan preposisi tetap: \'as\'.'
            ],
            [
                'sub_lesson' => 'Preposition',
                'sub_lesson_slug' => 'preposition',
                'number' => '2',
                'prompt' => '[Preposition - Latihan #2] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Sesuai dengan jadwal sekolah, kelas berenang dimulai pukul delapan pagi." (Target: According to (Complex Preposition))',
                'id_sentence' => 'Sesuai dengan jadwal sekolah, kelas berenang dimulai pukul delapan pagi.',
                'target_word' => 'According to (Complex Preposition)',
                'options' => [
                    'According to the school schedule, swimming class starts at eight in the morning.',
                    'According with the school schedule, swimming class starts at eight in the morning.',
                    'According for the school schedule, swimming class starts at eight in the morning.',
                    'According about the school schedule, swimming class starts at eight in the morning.'
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa preposisi yang baku dalam bahasa formal adalah \'According to\'.'
            ],
            [
                'sub_lesson' => 'Preposition',
                'sub_lesson_slug' => 'preposition',
                'number' => '3',
                'prompt' => '[Preposition - Latihan #3] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Meskipun hujan deras, kami tetap pergi berkemah bersama keluarga." (Target: Despite (Preposition of Concession))',
                'id_sentence' => 'Meskipun hujan deras, kami tetap pergi berkemah bersama keluarga.',
                'target_word' => 'Despite (Preposition of Concession)',
                'options' => [
                    'Despite the heavy rain, we still went camping with the family.',
                    'Despite of the heavy rain, we still went camping with the family.',
                    'In despite the heavy rain, we still went camping with the family.',
                    'Despite with the heavy rain, we still went camping with the family.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Despite\' adalah preposisi tunggal yang diikuti noun phrase tanpa kata \'of\'.'
            ],
            [
                'sub_lesson' => 'Preposition',
                'sub_lesson_slug' => 'preposition',
                'number' => '4',
                'prompt' => '[Preposition - Latihan #4] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Latihan rutin berkontribusi besar terhadap kemenangan tim sepak bola kami." (Target: contribute to (Dependent Preposition))',
                'id_sentence' => 'Latihan rutin berkontribusi besar terhadap kemenangan tim sepak bola kami.',
                'target_word' => 'contribute to (Dependent Preposition)',
                'options' => [
                    'Regular practice contributed greatly to our football team\'s victory.',
                    'Regular practice contributed greatly for our football team\'s victory.',
                    'Regular practice contributed greatly in our football team\'s victory.',
                    'Regular practice contributed greatly with our football team\'s victory.'
                ],
                'correct_index' => 0,
                'explanation' => 'Kata kerja \'contribute\' selalu berpasangan dengan preposisi \'to\'.'
            ],
            [
                'sub_lesson' => 'Preposition',
                'sub_lesson_slug' => 'preposition',
                'number' => '5',
                'prompt' => '[Preposition - Latihan #5] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Semua murid wajib mematuhi aturan keselamatan di kolam renang." (Target: adhere to (Dependent Preposition))',
                'id_sentence' => 'Semua murid wajib mematuhi aturan keselamatan di kolam renang.',
                'target_word' => 'adhere to (Dependent Preposition)',
                'options' => [
                    'All students are required to adhere to the pool safety rules.',
                    'All students are required to adhere with the pool safety rules.',
                    'All students are required to adhere in the pool safety rules.',
                    'All students are required to adhere at the pool safety rules.'
                ],
                'correct_index' => 0,
                'explanation' => 'Kolokasi kata kerja formal untuk mematuhi adalah \'adhere to\'.'
            ],
            [
                'sub_lesson' => 'Preposition',
                'sub_lesson_slug' => 'preposition',
                'number' => '6',
                'prompt' => '[Preposition - Latihan #6] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Buku cerita ini berfokus pada petualangan seekor kucing kecil." (Target: focuses on (Dependent Preposition))',
                'id_sentence' => 'Buku cerita ini berfokus pada petualangan seekor kucing kecil.',
                'target_word' => 'focuses on (Dependent Preposition)',
                'options' => [
                    'This storybook focuses on the adventures of a little cat.',
                    'This storybook focuses in the adventures of a little cat.',
                    'This storybook focuses at the adventures of a little cat.',
                    'This storybook focuses about the adventures of a little cat.'
                ],
                'correct_index' => 0,
                'explanation' => 'Kata kerja \'focus\' secara baku berkolokasi dengan preposisi \'on\'.'
            ],
            [
                'sub_lesson' => 'Preposition',
                'sub_lesson_slug' => 'preposition',
                'number' => '7',
                'prompt' => '[Preposition - Latihan #7] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Berdasarkan ramalan cuaca, besok akan cerah sepanjang hari." (Target: Based on (Complex Preposition))',
                'id_sentence' => 'Berdasarkan ramalan cuaca, besok akan cerah sepanjang hari.',
                'target_word' => 'Based on (Complex Preposition)',
                'options' => [
                    'Based on the weather forecast, tomorrow will be sunny all day.',
                    'Based to the weather forecast, tomorrow will be sunny all day.',
                    'Based with the weather forecast, tomorrow will be sunny all day.',
                    'Based for the weather forecast, tomorrow will be sunny all day.'
                ],
                'correct_index' => 0,
                'explanation' => 'Frasa idiomatis formal yang berarti \'berdasarkan\' adalah \'Based on\'.'
            ],
            [
                'sub_lesson' => 'Preposition',
                'sub_lesson_slug' => 'preposition',
                'number' => '8',
                'prompt' => '[Preposition - Latihan #8] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Hadiah baru itu berdampak besar pada semangat belajar adik." (Target: impact on (Dependent Preposition))',
                'id_sentence' => 'Hadiah baru itu berdampak besar pada semangat belajar adik.',
                'target_word' => 'impact on (Dependent Preposition)',
                'options' => [
                    'The new gift has a big impact on my little brother\'s motivation to study.',
                    'The new gift has a big impact in my little brother\'s motivation to study.',
                    'The new gift has a big impact to my little brother\'s motivation to study.',
                    'The new gift has a big impact with my little brother\'s motivation to study.'
                ],
                'correct_index' => 0,
                'explanation' => 'Nomina \'impact\' berpasangan dengan preposisi \'on\'.'
            ],
            [
                'sub_lesson' => 'Preposition',
                'sub_lesson_slug' => 'preposition',
                'number' => '9',
                'prompt' => '[Preposition - Latihan #9] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Setelah menyelesaikan pekerjaan rumahnya, kakak bermain gitar." (Target: After finishing (Preposition + Gerund))',
                'id_sentence' => 'Setelah menyelesaikan pekerjaan rumahnya, kakak bermain gitar.',
                'target_word' => 'After finishing (Preposition + Gerund)',
                'options' => [
                    'After finishing his homework, my brother played the guitar.',
                    'After finish his homework, my brother played the guitar.',
                    'After finished his homework, my brother played the guitar.',
                    'After to finish his homework, my brother played the guitar.'
                ],
                'correct_index' => 0,
                'explanation' => 'Setelah preposisi \'After\', kata kerja wajib berbentuk gerund (-ing).'
            ],
            [
                'sub_lesson' => 'Preposition',
                'sub_lesson_slug' => 'preposition',
                'number' => '10',
                'prompt' => '[Preposition - Latihan #10] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Setiap anggota kelompok bertanggung jawab atas tugasnya masing-masing." (Target: responsible for (Dependent Preposition))',
                'id_sentence' => 'Setiap anggota kelompok bertanggung jawab atas tugasnya masing-masing.',
                'target_word' => 'responsible for (Dependent Preposition)',
                'options' => [
                    'Every group member is responsible for their own task.',
                    'Every group member is responsible to their own task.',
                    'Every group member is responsible with their own task.',
                    'Every group member is responsible about their own task.'
                ],
                'correct_index' => 0,
                'explanation' => 'Adjective \'responsible\' berkolokasi dengan preposisi \'for\'.'
            ],
            [
                'sub_lesson' => 'Conjunction',
                'sub_lesson_slug' => 'conjunction',
                'number' => '1',
                'prompt' => '[Conjunction - Latihan #1] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Meskipun hujan deras, kami tetap pergi ke sekolah tepat waktu." (Target: Although (Subordinating Conjunction))',
                'id_sentence' => 'Meskipun hujan deras, kami tetap pergi ke sekolah tepat waktu.',
                'target_word' => 'Although (Subordinating Conjunction)',
                'options' => [
                    'Although it was raining heavily, we still got to school on time.',
                    'Although it was raining heavily, but we still got to school on time.',
                    'Despite it was raining heavily, we still got to school on time.',
                    'However it was raining heavily, we still got to school on time.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Although\' adalah subordinating conjunction yang benar.'
            ],
            [
                'sub_lesson' => 'Conjunction',
                'sub_lesson_slug' => 'conjunction',
                'number' => '2',
                'prompt' => '[Conjunction - Latihan #2] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Sementara kakak suka makanan pedas, adik lebih suka makanan manis." (Target: While (Subordinating Conjunction of Contrast))',
                'id_sentence' => 'Sementara kakak suka makanan pedas, adik lebih suka makanan manis.',
                'target_word' => 'While (Subordinating Conjunction of Contrast)',
                'options' => [
                    'While my brother loves spicy food, my sister prefers sweet food.',
                    'While my brother loves spicy food, but my sister prefers sweet food.',
                    'In contrast my brother loves spicy food, my sister prefers sweet food.',
                    'However my brother loves spicy food, my sister prefers sweet food.'
                ],
                'correct_index' => 0,
                'explanation' => '\'While\' berfungsi sebagai subordinating conjunction untuk menunjukkan kontras.'
            ],
            [
                'sub_lesson' => 'Conjunction',
                'sub_lesson_slug' => 'conjunction',
                'number' => '3',
                'prompt' => '[Conjunction - Latihan #3] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Adik tidak hanya pandai menggambar tetapi juga pandai bernyanyi." (Target: not only... but also (Correlative Conjunction))',
                'id_sentence' => 'Adik tidak hanya pandai menggambar tetapi juga pandai bernyanyi.',
                'target_word' => 'not only... but also (Correlative Conjunction)',
                'options' => [
                    'My little sister is not only good at drawing but also good at singing.',
                    'My little sister is not only good at drawing but a good singer.',
                    'My little sister is good not only at drawing but also singing well.',
                    'My little sister is not only good at drawing and also good at singing.'
                ],
                'correct_index' => 0,
                'explanation' => 'Parallelism: \'not only good at drawing ... but also good at singing\'.'
            ],
            [
                'sub_lesson' => 'Conjunction',
                'sub_lesson_slug' => 'conjunction',
                'number' => '4',
                'prompt' => '[Conjunction - Latihan #4] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Karena ban sepedanya bocor, kakak terpaksa jalan kaki ke sekolah." (Target: Because (Subordinating Conjunction of Cause))',
                'id_sentence' => 'Karena ban sepedanya bocor, kakak terpaksa jalan kaki ke sekolah.',
                'target_word' => 'Because (Subordinating Conjunction of Cause)',
                'options' => [
                    'Because his bicycle tire was flat, my brother had to walk to school.',
                    'Because of his bicycle tire was flat, my brother had to walk to school.',
                    'Due to his bicycle tire was flat, my brother had to walk to school.',
                    'Owing to his bicycle tire was flat, my brother had to walk to school.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Because\' diikuti oleh kalimat lengkap (Subject + Verb).'
            ],
            [
                'sub_lesson' => 'Conjunction',
                'sub_lesson_slug' => 'conjunction',
                'number' => '5',
                'prompt' => '[Conjunction - Latihan #5] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Payung itu harus dibawa, atau kita akan basah kuyup kehujanan." (Target: or (Coordinating Conjunction))',
                'id_sentence' => 'Payung itu harus dibawa, atau kita akan basah kuyup kehujanan.',
                'target_word' => 'or (Coordinating Conjunction)',
                'options' => [
                    'We must bring the umbrella, or we will get soaked in the rain.',
                    'We must bring the umbrella, nor we will get soaked in the rain.',
                    'We must bring the umbrella, but we will get soaked in the rain.',
                    'We must bring the umbrella, so we will get soaked in the rain.'
                ],
                'correct_index' => 0,
                'explanation' => 'Konjungsi koordinatif \'or\' menyatakan konsekuensi alternatif.'
            ],
            [
                'sub_lesson' => 'Conjunction',
                'sub_lesson_slug' => 'conjunction',
                'number' => '6',
                'prompt' => '[Conjunction - Latihan #6] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Baik ayah maupun ibu tidak setuju dengan rencana liburan itu." (Target: Neither... nor (Correlative Conjunction))',
                'id_sentence' => 'Baik ayah maupun ibu tidak setuju dengan rencana liburan itu.',
                'target_word' => 'Neither... nor (Correlative Conjunction)',
                'options' => [
                    'Neither my father nor my mother agreed with the holiday plan.',
                    'Neither my father or my mother agreed with the holiday plan.',
                    'Either my father nor my mother agreed with the holiday plan.',
                    'Both my father nor my mother agreed with the holiday plan.'
                ],
                'correct_index' => 0,
                'explanation' => 'Pasangan korelasi baku untuk penolakan ganda adalah \'Neither... nor...\'.'
            ],
            [
                'sub_lesson' => 'Conjunction',
                'sub_lesson_slug' => 'conjunction',
                'number' => '7',
                'prompt' => '[Conjunction - Latihan #7] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Kamu akan boleh main ke luar asalkan kamu sudah menyelesaikan tugas sekolah." (Target: provided that (Subordinating Conjunction of Condition))',
                'id_sentence' => 'Kamu akan boleh main ke luar asalkan kamu sudah menyelesaikan tugas sekolah.',
                'target_word' => 'provided that (Subordinating Conjunction of Condition)',
                'options' => [
                    'You may play outside provided that you have finished your homework.',
                    'You may play outside provided you will finish your homework.',
                    'You may play outside in provision that you finish your homework.',
                    'You may play outside provided of you finish your homework.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Provided that\' adalah konjungsi subordinatif yang bermakna \'asalkan\'.'
            ],
            [
                'sub_lesson' => 'Conjunction',
                'sub_lesson_slug' => 'conjunction',
                'number' => '8',
                'prompt' => '[Conjunction - Latihan #8] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Permainan dihentikan sementara agar semua pemain bisa beristirahat." (Target: so that (Subordinating Conjunction of Purpose))',
                'id_sentence' => 'Permainan dihentikan sementara agar semua pemain bisa beristirahat.',
                'target_word' => 'so that (Subordinating Conjunction of Purpose)',
                'options' => [
                    'The game was paused so that all the players could take a rest.',
                    'The game was paused in order for all the players could take a rest.',
                    'The game was paused so as all the players could take a rest.',
                    'The game was paused that all the players could take a rest.'
                ],
                'correct_index' => 0,
                'explanation' => '\'So that\' menghubungkan klausa tujuan dan diikuti modal auxiliary.'
            ],
            [
                'sub_lesson' => 'Conjunction',
                'sub_lesson_slug' => 'conjunction',
                'number' => '9',
                'prompt' => '[Conjunction - Latihan #9] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Nilai ujiannya naik pesat, namun ia masih harus belajar lebih giat." (Target: yet (Coordinating Conjunction of Contrast))',
                'id_sentence' => 'Nilai ujiannya naik pesat, namun ia masih harus belajar lebih giat.',
                'target_word' => 'yet (Coordinating Conjunction of Contrast)',
                'options' => [
                    'Her exam scores improved quickly, yet she still needs to study harder.',
                    'Her exam scores improved quickly, although she still needs to study harder.',
                    'Her exam scores improved quickly, despite she still needs to study harder.',
                    'Her exam scores improved quickly, unless she still needs to study harder.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Yet\' adalah coordinating conjunction yang menghubungkan dua kalimat kontras.'
            ],
            [
                'sub_lesson' => 'Conjunction',
                'sub_lesson_slug' => 'conjunction',
                'number' => '10',
                'prompt' => '[Conjunction - Latihan #10] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Bahkan jika cuaca buruk, pertandingan sepak bola tetap akan dilanjutkan." (Target: Even if (Subordinating Conjunction of Concession))',
                'id_sentence' => 'Bahkan jika cuaca buruk, pertandingan sepak bola tetap akan dilanjutkan.',
                'target_word' => 'Even if (Subordinating Conjunction of Concession)',
                'options' => [
                    'Even if the weather is bad, the football match will still continue.',
                    'Even though the weather will be bad, the football match will still continue.',
                    'Despite the weather is bad, the football match will still continue.',
                    'Regardless the weather is bad, the football match will still continue.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Even if\' digunakan untuk menyatakan kemungkinan kondisional.'
            ],
            [
                'sub_lesson' => 'Interjection',
                'sub_lesson_slug' => 'interjection',
                'number' => '1',
                'prompt' => '[Interjection - Latihan #1] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Wow, hadiah ulang tahun ini benar-benar bagus sekali!" (Target: Wow (Interjection))',
                'id_sentence' => 'Wow, hadiah ulang tahun ini benar-benar bagus sekali!',
                'target_word' => 'Wow (Interjection)',
                'options' => [
                    'Wow, this birthday present is really nice!',
                    'Wowly, this birthday present is really nice!',
                    'Wowing, this birthday present is really nice!',
                    'Wowful, this birthday present is really nice!'
                ],
                'correct_index' => 0,
                'explanation' => '\'Wow\' adalah interjeksi untuk mengekspresikan kekaguman atau kejutan menyenangkan.'
            ],
            [
                'sub_lesson' => 'Interjection',
                'sub_lesson_slug' => 'interjection',
                'number' => '2',
                'prompt' => '[Interjection - Latihan #2] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Aduh, kakiku tersandung batu di jalan!" (Target: Ouch (Interjection))',
                'id_sentence' => 'Aduh, kakiku tersandung batu di jalan!',
                'target_word' => 'Ouch (Interjection)',
                'options' => [
                    'Ouch, I tripped over a rock on the road!',
                    'Ouchly, I tripped over a rock on the road!',
                    'Ouching, I tripped over a rock on the road!',
                    'Ouchful, I tripped over a rock on the road!'
                ],
                'correct_index' => 0,
                'explanation' => '\'Ouch\' adalah interjeksi yang digunakan saat merasa sakit secara tiba-tiba.'
            ],
            [
                'sub_lesson' => 'Interjection',
                'sub_lesson_slug' => 'interjection',
                'number' => '3',
                'prompt' => '[Interjection - Latihan #3] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Yah, es krimku jatuh ke lantai sebelum sempat kumakan." (Target: Oh no (Interjection))',
                'id_sentence' => 'Yah, es krimku jatuh ke lantai sebelum sempat kumakan.',
                'target_word' => 'Oh no (Interjection)',
                'options' => [
                    'Oh no, my ice cream fell on the floor before I could eat it.',
                    'Oh nos, my ice cream fell on the floor before I could eat it.',
                    'Ohing no, my ice cream fell on the floor before I could eat it.',
                    'No oh, my ice cream fell on the floor before I could eat it.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Oh no\' digunakan untuk mengekspresikan kekecewaan atau kesedihan ringan.'
            ],
            [
                'sub_lesson' => 'Interjection',
                'sub_lesson_slug' => 'interjection',
                'number' => '4',
                'prompt' => '[Interjection - Latihan #4] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Hore, besok kita akan pergi ke taman bermain!" (Target: Hooray (Interjection))',
                'id_sentence' => 'Hore, besok kita akan pergi ke taman bermain!',
                'target_word' => 'Hooray (Interjection)',
                'options' => [
                    'Hooray, we are going to the playground tomorrow!',
                    'Hoorayly, we are going to the playground tomorrow!',
                    'Hooraying, we are going to the playground tomorrow!',
                    'Hoorayful, we are going to the playground tomorrow!'
                ],
                'correct_index' => 0,
                'explanation' => '\'Hooray\' adalah interjeksi untuk mengekspresikan kegembiraan.'
            ],
            [
                'sub_lesson' => 'Interjection',
                'sub_lesson_slug' => 'interjection',
                'number' => '5',
                'prompt' => '[Interjection - Latihan #5] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Wah, lukisan yang dibuat adikku ternyata sangat indah." (Target: Wow (Interjection))',
                'id_sentence' => 'Wah, lukisan yang dibuat adikku ternyata sangat indah.',
                'target_word' => 'Wow (Interjection)',
                'options' => [
                    'Wow, my little sister\'s painting turned out really beautiful.',
                    'Wower, my little sister\'s painting turned out really beautiful.',
                    'Wowest, my little sister\'s painting turned out really beautiful.',
                    'Wowness, my little sister\'s painting turned out really beautiful.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Wow\' berfungsi untuk mengekspresikan rasa kagum.'
            ],
            [
                'sub_lesson' => 'Interjection',
                'sub_lesson_slug' => 'interjection',
                'number' => '6',
                'prompt' => '[Interjection - Latihan #6] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Hm, aku tidak yakin jalan mana yang harus kita ambil." (Target: Hmm (Interjection))',
                'id_sentence' => 'Hm, aku tidak yakin jalan mana yang harus kita ambil.',
                'target_word' => 'Hmm (Interjection)',
                'options' => [
                    'Hmm, I\'m not sure which way we should go.',
                    'Hmmly, I\'m not sure which way we should go.',
                    'Hmming, I\'m not sure which way we should go.',
                    'Hmmful, I\'m not sure which way we should go.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Hmm\' adalah interjeksi yang menunjukkan sedang berpikir atau ragu-ragu.'
            ],
            [
                'sub_lesson' => 'Interjection',
                'sub_lesson_slug' => 'interjection',
                'number' => '7',
                'prompt' => '[Interjection - Latihan #7] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Wah, hujan tiba-tiba turun sangat deras sekali." (Target: Whoa (Interjection))',
                'id_sentence' => 'Wah, hujan tiba-tiba turun sangat deras sekali.',
                'target_word' => 'Whoa (Interjection)',
                'options' => [
                    'Whoa, it suddenly started raining really hard.',
                    'Whoaly, it suddenly started raining really hard.',
                    'Whoaing, it suddenly started raining really hard.',
                    'Whoaful, it suddenly started raining really hard.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Whoa\' menyajikan kejutan secara spontan.'
            ],
            [
                'sub_lesson' => 'Interjection',
                'sub_lesson_slug' => 'interjection',
                'number' => '8',
                'prompt' => '[Interjection - Latihan #8] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Yah, pertandingan sepak bola kita kalah sore ini." (Target: Aww (Interjection))',
                'id_sentence' => 'Yah, pertandingan sepak bola kita kalah sore ini.',
                'target_word' => 'Aww (Interjection)',
                'options' => [
                    'Aww, our football match lost this evening.',
                    'Awwly, our football match lost this evening.',
                    'Awwing, our football match lost this evening.',
                    'Awwful, our football match lost this evening.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Aww\' adalah kosa kata sehari-hari untuk menyatakan kekecewaan ringan.'
            ],
            [
                'sub_lesson' => 'Interjection',
                'sub_lesson_slug' => 'interjection',
                'number' => '9',
                'prompt' => '[Interjection - Latihan #9] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Astaga, aku lupa membawa buku PR ke sekolah!" (Target: Oh my (Interjection))',
                'id_sentence' => 'Astaga, aku lupa membawa buku PR ke sekolah!',
                'target_word' => 'Oh my (Interjection)',
                'options' => [
                    'Oh my, I forgot to bring my homework book to school!',
                    'Oh mys, I forgot to bring my homework book to school!',
                    'Ohing my, I forgot to bring my homework book to school!',
                    'My oh, I forgot to bring my homework book to school!'
                ],
                'correct_index' => 0,
                'explanation' => '\'Oh my\' adalah istilah santai untuk menunjukkan rasa kaget atau panik.'
            ],
            [
                'sub_lesson' => 'Interjection',
                'sub_lesson_slug' => 'interjection',
                'number' => '10',
                'prompt' => '[Interjection - Latihan #10] Terjemahkan kalimat bahasa Indonesia berikut ke bahasa Inggris yang akurat: "Asyik, akhirnya aku berhasil menyelesaikan tugas prakarya ini." (Target: Yay (Interjection))',
                'id_sentence' => 'Asyik, akhirnya aku berhasil menyelesaikan tugas prakarya ini.',
                'target_word' => 'Yay (Interjection)',
                'options' => [
                    'Yay, I finally finished this craft project.',
                    'Yayly, I finally finished this craft project.',
                    'Yaying, I finally finished this craft project.',
                    'Yayful, I finally finished this craft project.'
                ],
                'correct_index' => 0,
                'explanation' => '\'Yay\' adalah interjeksi untuk mengekspresikan kegembiraan atas pencapaian.'
            ]
        ];

        if (class_exists(\App\Services\SelfStudyPartsOfSpeechHelpers::class)) {
            $subLessonsData = \App\Services\SelfStudyPartsOfSpeechHelpers::attachHelpers($subLessonsData);
        }

        return [
            'banner_title' => 'Parts of Speech & Word Class Identification',
            'banner_subtitle' => 'Identifikasi kelas kata (word classes), fungsi sintaksis, dan kaidah derivasi morfemis dalam kalimat akademik formal dengan 8 sub-lesson interaktif.',
            'banner_badge' => 'MODULE 1.1 FOUNDATIONS',
            'sub_lessons' => $subLessonsData,
            'study_guide' => [
                'concept_title' => 'Konsep Dasar: Parts of Speech (Kelas Kata)',
                'concept_summary' => 'Setiap kata dalam bahasa Inggris termasuk dalam salah satu dari 8 kelas kata (Parts of Speech). Mengenali kelas kata membantu kita menyusun kalimat yang benar. Kesalahan umum sering terjadi saat tertukar antara bentuk Noun, Adjective, Verb, atau Adverb dari kata yang serupa.',
                'rules' => [
                    [
                        'rule_title' => '1. Noun (Nomina / Kata Benda)',
                        'rule_formula' => 'Root + (-tion, -ment, -ity, -ness) ➔ Noun',
                        'rule_description' => 'Noun bertindak sebagai Subjek, Objek, atau Objek Preposisi dalam kalimat. Noun menamai orang, tempat, benda, atau perasaan.',
                        'examples' => [
                            [
                                'en' => 'The kindness of my teacher made everyone happy.',
                                'id' => 'Kebaikan guruku membuat semua orang senang.',
                                'note' => '"kindness" = Subject (Noun).'
                            ],
                        ],
                    ],
                    [
                        'rule_title' => '2. Pronoun (Pronomina / Kata Ganti)',
                        'rule_formula' => 'Personal (they, it) | Relative (which, that, who) | Demonstrative (this, these) | Indefinite (each, neither)',
                        'rule_description' => 'Pronoun menggantikan Noun agar kalimat tidak mengulang-ulang nama yang sama. Pastikan Pronoun sesuai dengan jumlah dan jenis kata benda yang digantikannya.',
                        'examples' => [
                            [
                                'en' => 'Neither my brother nor my sister brought their umbrella.',
                                'id' => 'Baik kakak maupun adikku tidak membawa payung mereka.',
                                'note' => '"their" merujuk secara akurat ke anteseden jamak terdekat "my sister".'
                            ],
                        ],
                    ],
                    [
                        'rule_title' => '3. Verb (Verba / Kata Kerja)',
                        'rule_formula' => 'Action Verb (run, cook, write) | Linking Verb (be, seem, feel)',
                        'rule_description' => 'Verb adalah kata yang menunjukkan tindakan atau keadaan. Setiap kalimat lengkap membutuhkan verb agar bisa berdiri sendiri.',
                        'examples' => [
                            [
                                'en' => 'Mom decides to cook fried rice for dinner.',
                                'id' => 'Ibu memutuskan untuk memasak nasi goreng untuk makan malam.',
                                'note' => '"decides" = Verb tunggal yang mempredikasi subjek "Mom".'
                            ],
                        ],
                    ],
                    [
                        'rule_title' => '4. Adjective (Adjektiva / Kata Sifat)',
                        'rule_formula' => 'Attributive: [Determiner] + ADJECTIVE + [Noun] | Predicative: [Subject] + [Linking Verb] + ADJECTIVE',
                        'rule_description' => 'Adjective menerangkan sifat atau ciri dari sebuah noun. Bisa terletak sebelum noun atau setelah linking verb.',
                        'examples' => [
                            [
                                'en' => 'Grandma told an interesting story before we went to sleep.',
                                'id' => 'Nenek memberikan cerita yang menarik sebelum kami tidur.',
                                'note' => '"interesting" = Attributive Adjective yang menerangkan "story".'
                            ],
                        ],
                    ],
                    [
                        'rule_title' => '5. Adverb (Adverbia / Kata Keterangan)',
                        'rule_formula' => 'Adverb + Adjective | Adverb + Verb',
                        'rule_description' => 'Adverb menerangkan kata kerja, kata sifat, atau adverb lain — biasanya menjelaskan bagaimana, kapan, atau seberapa sering. Adverb TIDAK PERNAH menerangkan kata benda secara langsung.',
                        'examples' => [
                            [
                                'en' => 'The toy robot moved extremely fast.',
                                'id' => 'Robot mainan itu bergerak dengan sangat cepat.',
                                'note' => '"extremely" (Adv of degree) menerangkan adverb "fast".'
                            ],
                        ],
                    ],
                    [
                        'rule_title' => '6. Preposition (Preposisi / Kata Depan)',
                        'rule_formula' => 'Preposition + Noun Phrase ➔ Prepositional Phrase',
                        'rule_description' => 'Preposisi (in, on, at, with, under) menghubungkan nomina dengan elemen kalimat lain untuk menunjukkan tempat, waktu, atau cara.',
                        'examples' => [
                            [
                                'en' => 'According to the school schedule, swimming class starts at eight.',
                                'id' => 'Sesuai dengan jadwal sekolah, kelas berenang dimulai pukul delapan.',
                                'note' => '"According to" = Complex Preposition yang membuka frase adverbial.'
                            ],
                        ],
                    ],
                    [
                        'rule_title' => '7. Conjunction (Konjungsi / Kata Sambung)',
                        'rule_formula' => 'Coordinating (and, but, or) | Subordinating (because, although)',
                        'rule_description' => 'Konjungsi menyambungkan kata, frasa, atau kalimat. Konjungsi koordinatif seperti "and" menggabungkan dua unsur yang setara.',
                        'examples' => [
                            [
                                'en' => 'My brother and I play football every weekend.',
                                'id' => 'Kakak dan aku bermain sepak bola setiap akhir pekan.',
                                'note' => '"and" = Coordinating Conjunction yang menghubungkan dua subjek dalam satu kalimat.'
                            ],
                        ],
                    ],
                    [
                        'rule_title' => '8. Interjection (Interjeksi / Kata Seru)',
                        'rule_formula' => 'Interjection + (,/!) + Kalimat',
                        'rule_description' => 'Interjection adalah kata seru pendek yang mengekspresikan perasaan secara spontan, seperti terkejut, senang, atau sakit. Lazim digunakan dalam percakapan sehari-hari dan cerita.',
                        'examples' => [
                            [
                                'en' => 'Wow, this birthday present is really nice!',
                                'id' => 'Wow, hadiah ulang tahun ini benar-benar bagus sekali!',
                                'note' => '"Wow" mengekspresikan kekaguman spontan di awal kalimat.'
                            ],
                        ],
                    ],
                ],
                'contrast_table' => [
                    'headers' => ['Kelas Kata (Part of Speech)', 'Fungsi Sintaksis Utama', 'Ciri & Contoh Derivasi', 'Contoh Penggunaan'],
                    'rows' => [
                        ['1. Noun', 'Subjek / Objek kalimat', 'Suffix: -tion, -ment, -ity, -ness', 'The arrival was exciting.'],
                        ['2. Pronoun', 'Pengganti Noun (antecedent)', 'Personal, Relative, Demonstrative', 'The students who arrived on time.'],
                        ['3. Verb', 'Inti predikat (aksi/kondisi)', 'Suffix: -ize, -ate, -ify, -en', 'The teacher checked our homework.'],
                        ['4. Adjective', 'Penerang Nomina / Pelengkap', 'Suffix: -ive, -al, -ic, -able, -ing/-ed', 'A big problem for farmers.'],
                        ['5. Adverb', 'Penerang Verb / Adj / Klausa', 'Suffix: -ly', 'She sang the song beautifully.'],
                        ['6. Preposition', 'Menghubungkan frasa nomina', 'in, on, under, at, with', 'The cat is on the sofa.'],
                        ['7. Conjunction', 'Menghubungkan klausa / kata', 'and, but, although, while', 'While it rained, we stayed inside.'],
                        ['8. Interjection', 'Ekspresi emosi spontan', 'Wow, Ouch, Oh no, Hooray', 'Wow, what a great goal!'],
                    ],
                ],
                'common_pitfalls' => [
                    [
                        'incorrect' => 'The story was very interest.',
                        'correct' => 'The story was very interesting.',
                        'explanation' => 'Gunakan "interesting" (Adjective) setelah linking verb "was", bukan "interest" (Noun/Verb).'
                    ],
                    [
                        'incorrect' => 'The teacher reached an agree with the students.',
                        'correct' => 'The teacher reached an agreement with the students.',
                        'explanation' => 'Setelah artikel "an", posisi objek membutuhkan Noun ("agreement"), bukan Verb dasar ("agree").'
                    ],
                    [
                        'incorrect' => 'She sang the song beautiful.',
                        'correct' => 'She sang the song beautifully.',
                        'explanation' => 'Gunakan "beautifully" (Adverb) untuk menerangkan kata kerja "sang", bukan "beautiful" (Adjective).'
                    ],
                    [
                        'incorrect' => 'The boy who he won the race is my friend.',
                        'correct' => 'The boy who won the race is my friend.',
                        'explanation' => 'Double pronoun subject: jangan memasukkan "he" setelah relative pronoun "who".'
                    ],
                ],
                'exam_tips' => [
                    'Identifikasi posisi kata terlebih dahulu: Jika diapit artikel (a/an/the) dan kata depan (of/in), kata tersebut biasanya Noun.',
                    'Kata berakhiran -ly tidak selalu adverb (misal: "friendly", "costly", "lovely" adalah Adjective). Selalu cek fungsi sintaksisnya.',
                    'Perhatikan konsistensi kelas kata dalam struktur paralel (misal: "swimming and reading", bukan "swimming and to read").',
                    'Ingat 8 kelas kata: Noun, Pronoun, Verb, Adjective, Adverb, Preposition, Conjunction, dan Interjection.'
                ],
            ],
            'questions' => $questionsData,
        ];
    }

    /**
     * 1.2 Simple Present Tense: Verbal vs Nominal Forms
     */
    protected function getSimplePresentPackage(): array
    {
        return \App\Services\SelfStudySimplePresentData::getPackage();
    }


    /**
     * 1.3 Simple Present: Nominal, Passive, & Verbal vs Nominal vs Passive
     */
    protected function getSubjectVerbAgreementPackage(): array
    {
        return \App\Services\SelfStudySimplePresentNominalPassiveData::getPackage();
    }

    /**
     * 1.4 Present Negative & Academic Interrogative
     */
    protected function getPresentNegativeInterrogativePackage(): array
    {
        return \App\Services\SelfStudyPresentNegativeInterrogativeData::getPackage();
    }

    /**
     * 1.5 Core Prepositional Phrases (Level 101)
     */
    protected function getCorePrepositionalPhrasesPackage(): array
    {
        return \App\Services\SelfStudyCorePrepositionalPhrasesData::getPackage();
    }

    /**
     * 1.6 Verbals: Basic Infinitives & Gerunds
     */
    protected function getVerbalsInfinitivesGerundsPackage(): array
    {
        return \App\Services\SelfStudyVerbalsInfinitivesGerundsData::getPackage();
    }

    /**
     * 1.7 Modal Auxiliaries in Academic Context
     */
    protected function getModalAuxiliariesPackage(): array
    {
        return \App\Services\SelfStudyModalAuxiliariesData::getPackage();
    }

    /**
     * 1.8 Simple Past Tense (Verbal, Nominal, Passive)
     */
    protected function getSimplePastPackage(): array
    {
        return \App\Services\SelfStudySimplePastData::getPackage();
    }

    /**
     * 1.9 Present Continuous Tense (Verbal & Passive)
     */
    protected function getPresentContinuousPackage(): array
    {
        return \App\Services\SelfStudyPresentContinuousData::getPackage();
    }

    /**
     * 1.10 Present Perfect Tense (Verbal, Nominal, Passive)
     */
    protected function getPresentPerfectPackage(): array
    {
        return \App\Services\SelfStudyPresentPerfectData::getPackage();
    }

    /**
     * 1.11 Simple Future Tense (Will & Be Going To: Verbal, Nominal, Passive)
     */
    protected function getSimpleFuturePackage(): array
    {
        return \App\Services\SelfStudySimpleFutureData::getPackage();
    }

    /**
     * 1.12 Past Continuous & Past Perfect Tenses (Timeline Sequencing)
     */
    protected function getPastContinuousPastPerfectPackage(): array
    {
        return \App\Services\SelfStudyPastContinuousPastPerfectData::getPackage();
    }

    /**
     * 2.1 Tenses Cross-Reference & Translation Drills
     */
    protected function getTensesCrossReferencePackage(): array
    {
        return \App\Services\SelfStudyTensesCrossReferenceData::getPackage();
    }

    /**
     * 2.2 Prepositional Phrase (102)
     */
    protected function getPrepositionalPhrase102Package(): array
    {
        return \App\Services\SelfStudyPrepositionalPhrase102Data::getPackage();
    }

    /**
     * 2.3 Gerund & To-Infinitive (102)
     */
    protected function getGerundInfinitive102Package(): array
    {
        return \App\Services\SelfStudyGerundInfinitive102Data::getPackage();
    }

    /**
     * 2.4 Noun Phrase
     */
    protected function getNounPhrasePackage(): array
    {
        return \App\Services\SelfStudyNounPhraseData::getPackage();
    }

    /**
     * 2.5 Coordinating Conjunctions (FANBOYS) & Compound Sentences
     */
    protected function getCompoundSentencesFanboysPackage(): array
    {
        return \App\Services\SelfStudyCompoundSentencesFanboysData::getPackage();
    }

    /**
     * 2.6 Comparison (Degree of Comparison)
     */
    protected function getComparisonDegreePackage(): array
    {
        return \App\Services\SelfStudyComparisonDegreeData::getPackage();
    }


    /**
     * 2.1 Passive Voice in Academic Reporting
     */
    protected function getPassiveVoicePackage(): array
    {
        return [
            'banner_title' => 'Passive Voice in Academic Reporting',
            'banner_subtitle' => 'Pahami fungsi strategis kalimat pasif untuk membangun objektivitas dan fokus pada hasil riset.',
            'banner_badge' => 'MODULE 2.1 ACADEMIC PASSIVE',
            'study_guide' => [
                'concept_title' => 'Konsep Dasar: Passive Voice dalam Laporan Akademis',
                'concept_summary' => 'Kalimat pasif adalah instrumen standar dalam Academic Writing (khususnya Methodology dan Results) untuk menonjolkan objektivitas. Peneliti menggunakan kalimat pasif agar perhatian pembaca tertuju pada objek penelitian, data, atau prosedur ilmiah, bukan pada siapa yang melakukannya.',
                'rules' => [
                    [
                        'rule_title' => 'Rumus Umum Passive Voice',
                        'rule_formula' => 'Subject (Penerima Aksi) + Auxiliary "BE" (sesuai tenses) + Past Participle (Verb 3) (+ by Agent)',
                        'rule_description' => 'Bentuk "be" berubah mengikuti tense: is/are (Simple Present), was/were (Simple Past), has/have been (Present Perfect), will be (Future).',
                        'examples' => [
                            [
                                'en' => 'Water samples were collected from three distinct tributaries.',
                                'id' => 'Sampel air dikumpulkan dari tiga anak sungai yang berbeda.',
                                'note' => 'Metodologi formal: "by the researcher" dihilangkan karena tersirat dan tidak relevan.'
                            ],
                        ],
                    ],
                    [
                        'rule_title' => 'Impersonal Passive untuk Melaporkan Konsensus',
                        'rule_formula' => 'It is believed / argued / hypothesized that + Clause',
                        'rule_description' => 'Digunakan saat mengutip pandangan umum komunitas ilmiah tanpa mengklaimnya sebagai opini pribadi.',
                        'examples' => [
                            [
                                'en' => 'It has been widely argued that early bilingualism enhances cognitive flexibility.',
                                'id' => 'Telah banyak diargumentasikan bahwa kedwibahasaan sejak dini meningkatkan fleksibilitas kognitif.',
                                'note' => 'Struktur impersonal passive yang sangat dihargai dalam IELTS Academic Task 2.'
                            ],
                        ],
                    ],
                ],
                'contrast_table' => [
                    'headers' => ['Tense', 'Active Voice (Kurang Formal)', 'Passive Voice (Standar Akademik)'],
                    'rows' => [
                        ['Simple Present', 'Scientists observe the cells.', 'The cells are observed under microscopic scrutiny.'],
                        ['Simple Past', 'We conducted the survey in 2024.', 'The survey was conducted in 2024.'],
                        ['Present Perfect', 'Researchers have established a link.', 'A correlation has been firmly established.'],
                        ['Modal', 'The council must review the data.', 'The data must be thoroughly reviewed.'],
                    ],
                ],
                'common_pitfalls' => [
                    [
                        'incorrect' => 'The specimen was disappear during transit.',
                        'correct' => 'The specimen disappeared during transit.',
                        'explanation' => 'Kata kerja intransitif (seperti disappear, occur, happen, exist) TIDAK BISA dipasifkan karena tidak memiliki objek.'
                    ],
                ],
                'exam_tips' => [
                    'Gunakan pasif saat menjelaskan prosedur (Methodology). Namun gunakan kalimat aktif saat membuat klaim argumen kuat (Discussion).',
                    'Jangan memaksakan kata kerja intransitif seperti "occur" atau "deteriorate" ke dalam bentuk pasif.'
                ],
            ],
            'questions' => [
                [
                    'number' => '1',
                    'prompt' => 'Manakah kalimat pasif yang paling sesuai dengan register penulisan metode eksperimen ilmiah?',
                    'options' => [
                        'We heated the test tubes up to 80 degrees Celsius.',
                        'The test tubes were heated to 80 degrees Celsius under controlled conditions.',
                        'The test tubes was heated to 80 degrees Celsius under controlled conditions.',
                        'Heating of the test tubes was done by us to 80 degrees Celsius.',
                    ],
                    'correct_index' => 1,
                    'explanation' => 'Opsi 2 menggunakan past passive yang objektif ("were heated") dengan subjek jamak ("test tubes") tanpa kata ganti orang pertama ("we").',
                ],
                [
                    'number' => '2',
                    'prompt' => 'Pilihlah kalimat yang TIDAK BISA diubah ke dalam bentuk pasif karena kata kerjanya bersifat intransitif:',
                    'options' => [
                        'The economic recession occurred unexpectedly in the third quarter.',
                        'The government enacted new financial regulations in the third quarter.',
                        'The analyst discovered substantial discrepancies in the report.',
                        'The institution published comprehensive statistical findings.',
                    ],
                    'correct_index' => 0,
                    'explanation' => 'Kata kerja "occur" adalah intransitif (tidak memiliki direct object), sehingga mustahil memiliki bentuk pasif seperti "was occurred".',
                ],
                [
                    'number' => '3',
                    'prompt' => 'Lengkapi kalimat impersonal passive berikut: "It ________ that renewable energy will surpass fossil fuel generation by 2040."',
                    'options' => [
                        'is widely project',
                        'is widely projected',
                        'widely projected',
                        'has widely project',
                    ],
                    'correct_index' => 1,
                    'explanation' => 'Konstruksi impersonal passive membutuhkan: It + is + adverb + Past Participle ("projected").',
                ],
            ],
        ];
    }

    /**
     * 2.2 Perfect & Continuous Aspect Distinctions
     */
    protected function getAspectDistinctionsPackage(): array
    {
        return [
            'banner_title' => 'Perfect & Continuous Aspect Distinctions',
            'banner_subtitle' => 'Bedakan penggunaan Present Perfect untuk literatur terkini vs Simple Past untuk temuan historis.',
            'banner_badge' => 'MODULE 2.2 TEMPORAL PRECISION',
            'study_guide' => [
                'concept_title' => 'Aspek Waktu dalam Tinjauan Pustaka (Literature Review)',
                'concept_summary' => 'Memilih antara Simple Past dan Present Perfect adalah kunci dalam menulis tinjauan literatur (literature review). Simple Past digunakan saat merujuk studi tertentu yang selesai di masa lalu (misal: "Smith (2018) discovered..."), sedangkan Present Perfect digunakan untuk generalisasi temuan yang dampaknya masih berlanjut hingga saat ini (misal: "Recent studies have established...").',
                'rules' => [
                    [
                        'rule_title' => 'Present Perfect vs Simple Past',
                        'rule_formula' => 'Present Perfect: S + has/have + V3 (Relevansi Kini) | Simple Past: S + V2 (Selesai di Waktu Lampau Tertentu)',
                        'rule_description' => 'Gunakan Present Perfect tanpa keterangan waktu spesifik jika temuan masih menjadi konsensus ilmiah saat ini.',
                        'examples' => [
                            [
                                'en' => 'Researchers have identified several genetic markers associated with the condition.',
                                'id' => 'Para peneliti telah mengidentifikasi beberapa penanda genetik yang terkait dengan kondisi tersebut.',
                                'note' => 'Penemuan di masa lalu yang hasilnya valid dan relevan sekarang.'
                            ],
                        ],
                    ],
                ],
                'contrast_table' => [
                    'headers' => ['Aspek', 'Fungsi Akademik', 'Contoh Kalimat'],
                    'rows' => [
                        ['Simple Past', 'Merujuk pada studi atau eksperimen spesifik masa lampau', 'Johnson et al. (2020) conducted a randomized trial.'],
                        ['Present Perfect', 'Merangkum tren penelitian atau konsensus yang berkembang', 'Numerous clinical trials have corroborated these outcomes.'],
                        ['Present Continuous', 'Menggambarkan tren temporal yang sedang aktif berkembang', 'Global sea levels are currently accelerating at an alarming rate.'],
                    ],
                ],
                'common_pitfalls' => [
                    [
                        'incorrect' => 'In 2015, researchers have discovered a new catalyst.',
                        'correct' => 'In 2015, researchers discovered a new catalyst.',
                        'explanation' => 'Keterangan waktu lampau spesifik ("In 2015") mewajibkan Simple Past ("discovered"), bukan Present Perfect.'
                    ],
                ],
                'exam_tips' => [
                    'Jangan gunakan Present Perfect dengan penanda waktu lampau definitif seperti "yesterday", "in 2010", atau "last decade".'
                ],
            ],
            'questions' => [
                [
                    'number' => '1',
                    'prompt' => 'Pilihlah bentuk kata kerja yang paling tepat untuk mengawali tinjauan pustaka umum: "Over the past two decades, evolutionary biologists ________ extensive genomic datasets."',
                    'options' => [
                        'compiled (Simple Past)',
                        'have compiled (Present Perfect)',
                        'are compiling (Present Continuous)',
                        'were compiled (Passive Past)',
                    ],
                    'correct_index' => 1,
                    'explanation' => 'Frasa "Over the past two decades" menandakan rentang waktu dari masa lampau hingga saat ini, yang mewajibkan Present Perfect ("have compiled").',
                ],
                [
                    'number' => '2',
                    'prompt' => 'Manakah kalimat yang menggunakan tense secara tepat sesuai konvensi sitasi akademik berangka tahun spesifik?',
                    'options' => [
                        'In 2019, Patel and Harris have demonstrated the efficacy of targeted gene therapy.',
                        'In 2019, Patel and Harris demonstrated the efficacy of targeted gene therapy.',
                        'In 2019, Patel and Harris are demonstrating the efficacy of targeted gene therapy.',
                        'In 2019, Patel and Harris demonstrate the efficacy of targeted gene therapy.',
                    ],
                    'correct_index' => 1,
                    'explanation' => 'Penyebutan tahun spesifik ("In 2019") mewajibkan penggunaan Simple Past ("demonstrated").',
                ],
            ],
        ];
    }

    /**
     * 3.1 Subordination & Complex Clause Architecture
     */
    protected function getSubordinationPackage(): array
    {
        return [
            'banner_title' => 'Subordination & Complex Clause Architecture',
            'banner_subtitle' => 'Kembangkan arsitektur kalimat kompleks (Complex Sentences) dengan subordinating conjunctions untuk menghasilkan sintaksis band 8+.',
            'banner_badge' => 'MODULE 3.1 SYNTACTIC COMPLEXITY',
            'study_guide' => [
                'concept_title' => 'Konsep Subordinasi dalam Kalimat Akademik',
                'concept_summary' => 'Menghubungkan dua ide menggunakan subordinasi (klausa bertingkat) menunjukkan hubungan logis yang lebih matang dibandingkan hanya menggunakan koordinasi ("and", "so", "but"). Subordinasi menempatkan ide pendukung pada Dependent Clause dan ide utama pada Independent Clause.',
                'rules' => [
                    [
                        'rule_title' => 'Pola Tanda Koma pada Klausa Subordinat',
                        'rule_formula' => 'Subordinating Conjunction + Dependent Clause, + Independent Clause (PAKAI KOMA) | Independent Clause + Subordinating Conjunction + Dependent Clause (TANPA KOMA)',
                        'rule_description' => 'Jika anak kalimat ditaruh di depan, WAJIB diberi tanda koma sebelum induk kalimat.',
                        'examples' => [
                            [
                                'en' => 'Although initial fiscal projections were conservative, actual revenues exceeded expectations.',
                                'id' => 'Meskipun proyeksi fiskal awal bersifat konservatif, pendapatan aktual melampaui ekspektasi.',
                                'note' => 'Koma memisahkan Dependent Clause di awal dengan Independent Clause.'
                            ],
                        ],
                    ],
                ],
                'contrast_table' => [
                    'headers' => ['Jenis Hubungan', 'Subordinating Conjunctions', 'Contoh Kalimat'],
                    'rows' => [
                        ['Konsesi / Kontras', 'Although, Even though, Whereas, While', 'Although the sample size was limited, findings were statistically robust.'],
                        ['Sebab / Alasan', 'Because, Since, As, Given that', 'Since carbon emissions continue to rise, policy intervention is imperative.'],
                        ['Kondisi', 'If, Unless, Provided that', 'Unless stringent regulations are enforced, deforestation will accelerate.'],
                    ],
                ],
                'common_pitfalls' => [
                    [
                        'incorrect' => 'Although the sample was small, but the results were valid. (Double Conjunction)',
                        'correct' => 'Although the sample was small, the results were valid.',
                        'explanation' => 'Jangan pernah menggabungkan "Although" dengan "but" dalam satu kalimat.'
                    ],
                ],
                'exam_tips' => [
                    'Gunakan variasi posisi: Letakkan Dependent Clause di awal pada kalimat pertama, lalu di akhir pada kalimat berikutnya untuk menciptakan variasi ritme membaca (syntactic variety).'
                ],
            ],
            'questions' => [
                [
                    'number' => '1',
                    'prompt' => 'Manakah dari kalimat berikut yang bebas dari kesalahan sintaktis "double conjunction" (penumpukan kata hubung)?',
                    'options' => [
                        'Even though the preliminary trials yielded favorable outcomes, but researchers cautioned against premature optimism.',
                        'Even though the preliminary trials yielded favorable outcomes, researchers cautioned against premature optimism.',
                        'Despite the preliminary trials yielded favorable outcomes, researchers cautioned against premature optimism.',
                        'Although the preliminary trials yielded favorable outcomes, however researchers cautioned against premature optimism.',
                    ],
                    'correct_index' => 1,
                    'explanation' => 'Opsi 2 benar karena hanya menggunakan satu subordinating conjunction ("Even though") tanpa koordinasi tambahan seperti "but" atau "however".',
                ],
                [
                    'number' => '2',
                    'prompt' => 'Pilihlah kalimat yang menggunakan tanda baca koma secara tepat pada struktur klausa bertingkat:',
                    'options' => [
                        'Because economic indicators deteriorated sharply the central bank adjusted lending rates.',
                        'Because economic indicators deteriorated sharply, the central bank adjusted lending rates.',
                        'The central bank adjusted lending rates, because economic indicators deteriorated sharply.',
                        'Because, economic indicators deteriorated sharply the central bank adjusted lending rates.',
                    ],
                    'correct_index' => 1,
                    'explanation' => 'Anak kalimat keterangan di awal ("Because...") wajib dipisahkan dengan tanda koma sebelum klausa utama.',
                ],
            ],
        ];
    }

    /**
     * 3.2 Relative Clauses: Restrictive vs Non-Restrictive
     */
    protected function getRelativeClausesPackage(): array
    {
        return [
            'banner_title' => 'Relative Clauses: Restrictive vs Non-Restrictive',
            'banner_subtitle' => 'Kuasai penggunaan klausa relatif pembatas (that/who) vs non-pembatas (which/who dengan koma).',
            'banner_badge' => 'MODULE 3.2 CLAUSAL MODIFIERS',
            'study_guide' => [
                'concept_title' => 'Restrictive vs Non-Restrictive Relative Clauses',
                'concept_summary' => 'Klausa relatif (Adjective Clause) memperjelas kata benda. Restrictive Clause memberikan informasi esensial untuk mendefinisikan subjek (tanpa koma, boleh memakai "that"). Non-Restrictive Clause memberikan informasi tambahan (diapit koma, WAJIB memakai "which", dilarang memakai "that").',
                'rules' => [
                    [
                        'rule_title' => 'Kaidah Tanda Koma dan Pemilihan Pronoun',
                        'rule_formula' => 'Restrictive (Esensial): Noun + that/which (TANPA KOMA) | Non-Restrictive (Ekstra): Noun, which... , (DENGAN KOMA)',
                        'rule_description' => 'Dalam American & British Academic English, kata "that" tidak boleh digunakan setelah tanda koma untuk klausa non-restrictive.',
                        'examples' => [
                            [
                                'en' => 'Vaccines that undergo rigorous stage-three trials demonstrate high efficacy.',
                                'id' => 'Vaksin yang menjalani uji klinis tahap tiga menunjukkan efikasi tinggi (hanya vaksin tipe ini).',
                                'note' => 'Restrictive: mendefinisikan jenis vaksin.'
                            ],
                            [
                                'en' => 'The mRNA vaccine, which was synthesized in record time, proved safe.',
                                'id' => 'Vaksin mRNA tersebut, yang disintesis dalam waktu singkat, terbukti aman.',
                                'note' => 'Non-restrictive: informasi tambahan diapit koma.'
                            ],
                        ],
                    ],
                ],
                'contrast_table' => [
                    'headers' => ['Tipe Klausa', 'Tanda Koma', 'Relative Pronoun Benda', 'Arti / Makna'],
                    'rows' => [
                        ['Restrictive (Defining)', 'Dilarang menggunakan koma', 'that / which', 'Membatasi kategori benda secara esensial'],
                        ['Non-Restrictive (Non-defining)', 'Wajib diapit koma', 'Hanya boleh which (Dilarang that)', 'Hanya informasi pelengkap/ekstra'],
                    ],
                ],
                'common_pitfalls' => [
                    [
                        'incorrect' => 'The Amazon rainforest, that produces immense oxygen, faces ongoing threats.',
                        'correct' => 'The Amazon rainforest, which produces immense oxygen, faces ongoing threats.',
                        'explanation' => 'Dilarang menggunakan "that" dalam klausa relatif yang diapit tanda koma.'
                    ],
                ],
                'exam_tips' => [
                    'Jika nama subjek sudah unik/spesifik (misal nama tempat, nama orang, atau institusi seperti "Harvard University"), klausa setelahnya 100% adalah Non-Restrictive (pakai koma dan "which").'
                ],
            ],
            'questions' => [
                [
                    'number' => '1',
                    'prompt' => 'Pilihlah kalimat yang menggunakan relative pronoun dan tanda baca yang tepat secara akademis:',
                    'options' => [
                        'The protocol, that was designed by international epidemiologists, prevented outbreaks.',
                        'The protocol which was designed by international epidemiologists prevented outbreaks.',
                        'The protocol, which was designed by international epidemiologists, prevented outbreaks.',
                        'The protocol, who was designed by international epidemiologists, prevented outbreaks.',
                    ],
                    'correct_index' => 2,
                    'explanation' => 'Klausa non-restrictive diapit koma dan wajib menggunakan "which", bukan "that".',
                ],
                [
                    'number' => '2',
                    'prompt' => 'Kapan relative pronoun "that" boleh digunakan dalam klausa relatif?',
                    'options' => [
                        'Hanya dalam restrictive relative clause tanpa tanda koma',
                        'Dalam non-restrictive relative clause yang diapit tanda koma',
                        'Kapan saja sebagai pengganti bebas untuk "which" setelah tanda koma',
                        'Hanya jika subjeknya adalah nama orang terkenal',
                    ],
                    'correct_index' => 0,
                    'explanation' => '"That" hanya berlaku untuk restrictive clause yang tidak menggunakan tanda koma.',
                ],
            ],
        ];
    }

    /**
     * 3.3 Adverbial Clauses of Concession & Cause
     */
    protected function getConcessionClausesPackage(): array
    {
        return [
            'banner_title' => 'Adverbial Clauses of Concession & Cause',
            'banner_subtitle' => 'Bangun argumen berbobot dengan klausa konsesi (concession) dan kausalitas dalam register IELTS Academic.',
            'banner_badge' => 'MODULE 3.3 CONCESSION & CAUSE',
            'study_guide' => [
                'concept_title' => 'Logika Konsesi dalam Penulisan Akademis',
                'concept_summary' => 'Penulisan esai tingkat lanjut membutuhkan kemampuan menyajikan perspektif tandingan (counter-argument) sebelum menegaskan tesis utama. Klausa konsesi (menggunakan although, whereas, while, despite the fact that) menunjukkan bahwa penulis telah mempertimbangkan berbagai sudut pandang sebelum menarik kesimpulan.',
                'rules' => [
                    [
                        'rule_title' => 'Concession vs Prepositional Contrast',
                        'rule_formula' => 'Although / While + Full Clause (Subject + Verb) | Despite / In spite of + Noun Phrase / Gerund',
                        'rule_description' => 'Jangan pernah menaruh klausa utuh (S + V) langsung setelah "Despite", kecuali ditambahkan "the fact that".',
                        'examples' => [
                            [
                                'en' => 'Although economic growth stalled, consumer confidence remained steady.',
                                'id' => 'Meskipun pertumbuhan ekonomi melambat, kepercayaan konsumen tetap stabil.',
                                'note' => '"Although" diikuti klausa utuh (S + V).'
                            ],
                            [
                                'en' => 'Despite sluggish economic growth, consumer confidence remained steady.',
                                'id' => 'Terlepas dari pertumbuhan ekonomi yang lamban, kepercayaan konsumen tetap stabil.',
                                'note' => '"Despite" diikuti frasa benda (Noun Phrase).'
                            ],
                        ],
                    ],
                ],
                'contrast_table' => [
                    'headers' => ['Kata Hubung', 'Struktur Pengikut', 'Contoh Penggunaan'],
                    'rows' => [
                        ['Although / Even though', 'Full Clause (S + V)', 'Although funding was scarce, research continued.'],
                        ['Despite / In spite of', 'Noun Phrase / Gerund (-ing)', 'Despite scarce funding, research continued.'],
                        ['Whereas / While', 'Comparative Clause', 'Europe prioritized green energy, whereas other regions lagged.'],
                    ],
                ],
                'common_pitfalls' => [
                    [
                        'incorrect' => 'Despite of the high costs, the project was approved.',
                        'correct' => 'Despite the high costs, the project was approved.',
                        'explanation' => '"Despite" tidak boleh diikuti "of". Gunakan "In spite of" jika ingin memakai "of".'
                    ],
                ],
                'exam_tips' => [
                    'Dalam IELTS Task 2, gunakan klausa konsesi di kalimat pembuka paragraf argumen untuk mendapatkan skor Band 8+ pada kriteria Task Response & Cohesion.'
                ],
            ],
            'questions' => [
                [
                    'number' => '1',
                    'prompt' => 'Pilihlah kalimat yang menggunakan konjungsi konsesi tanpa kesalahan gramatikal:',
                    'options' => [
                        'Despite of initial skepticism from peers, the hypothesis was corroborated by subsequent trials.',
                        'Although initial skepticism from peers, the hypothesis was corroborated by subsequent trials.',
                        'Despite initial skepticism from peers, the hypothesis was corroborated by subsequent trials.',
                        'In spite initial skepticism from peers, the hypothesis was corroborated by subsequent trials.',
                    ],
                    'correct_index' => 2,
                    'explanation' => '"Despite" diikuti Noun Phrase ("initial skepticism...") tanpa preposisi "of".',
                ],
                [
                    'number' => '2',
                    'prompt' => 'Lengkapilah kalimat berikut: "________ the proposed tax reform aims to incentivize domestic manufacturing, industry leaders remain apprehensive."',
                    'options' => [
                        'While (Klausa konsesi)',
                        'Despite (Preposisi)',
                        'In spite of (Preposisi)',
                        'Regardless (Adverb)',
                    ],
                    'correct_index' => 0,
                    'explanation' => 'Bagian setelahnya adalah klausa utuh (Subject "the proposed tax reform" + Verb "aims"), sehingga membutuhkan subordinating conjunction "While".',
                ],
            ],
        ];
    }

    /**
     * 3.4 Nominalisation: Converting Verbs to Abstract Nouns
     */
    protected function getNominalisationPackage(): array
    {
        return [
            'banner_title' => 'Nominalisation: Converting Verbs to Abstract Nouns',
            'banner_subtitle' => 'Tingkatkan kepadatan leksikal (lexical density) dengan mengubah kata kerja dan klausa menjadi nomina abstrak.',
            'banner_badge' => 'MODULE 3.4 LEXICAL DENSITY',
            'study_guide' => [
                'concept_title' => 'Konsep Nominalisasi (Nominalisation)',
                'concept_summary' => 'Nominalisasi adalah teknik mengubah kata kerja atau kata sifat menjadi kata benda abstrak. Ini adalah ciri pembeda utama antara tulisan pemula (verbal & bercerita) dengan tulisan akademisi profesional (padat konsep & analitis). Nominalisasi memadatkan beberapa klausa panjang menjadi satu frasa subjek yang berbobot.',
                'rules' => [
                    [
                        'rule_title' => 'Mekanisme Transformasi Verbal ke Nominal',
                        'rule_formula' => 'Because X [Verb] rapidly ➔ The rapid [Noun of X] resulted in...',
                        'rule_description' => 'Aksi kata kerja diubah menjadi subjek nomina, dan kata keterangan (adverb) diubah menjadi kata sifat (adjective).',
                        'examples' => [
                            [
                                'en' => 'Before: Because technology evolved rapidly, businesses restructured their operations.',
                                'id' => 'Sebelum: Karena teknologi berkembang pesat, bisnis merestrukturisasi operasi mereka.',
                                'note' => 'Gaya bahasa bercerita (informal).'
                            ],
                            [
                                'en' => 'After: The rapid evolution of technology necessitated corporate restructuring.',
                                'id' => 'Sesudah: Evolusi teknologi yang pesat mengharuskan restrukturisasi korporasi.',
                                'note' => 'Gaya bahasa akademik dengan kepadatan leksikal tinggi.'
                            ],
                        ],
                    ],
                ],
                'contrast_table' => [
                    'headers' => ['Bentuk Verbal (Informal)', 'Bentuk Nominal (Akademis)', 'Perubahan Grammar'],
                    'rows' => [
                        ['The population grew quickly.', 'The rapid growth of the population...', 'Verb "grew" ➔ Noun "growth", Adv "quickly" ➔ Adj "rapid"'],
                        ['The government decided to intervene.', 'The government’s intervention...', 'Verb "intervene" ➔ Noun "intervention"'],
                        ['The economy deteriorated severely.', 'The severe deterioration of the economy...', 'Verb "deteriorated" ➔ Noun "deterioration"'],
                    ],
                ],
                'common_pitfalls' => [
                    [
                        'incorrect' => 'The rapid evolvement caused problems.',
                        'correct' => 'The rapid evolution caused problems.',
                        'explanation' => 'Pastikan menggunakan akhiran derivasi yang baku ("evolution", bukan "evolvement").'
                    ],
                ],
                'exam_tips' => [
                    'Gunakan nominalisasi pada Topic Sentence di Body Paragraph esai Anda untuk langsung menunjukkan tone akademik band 8+.'
                ],
            ],
            'questions' => [
                [
                    'number' => '1',
                    'prompt' => 'Manakah kalimat hasil nominalisasi yang paling efektif dari kalimat: "Because cities are expanding rapidly, farmland is disappearing"?',
                    'options' => [
                        'Rapid urban expansion has led to the depletion of arable farmland.',
                        'Because of cities expanding rapidly, farmland disappears quickly.',
                        'The expanding of cities in a rapid way causes that farmland disappears.',
                        'Cities expand so rapidly that farmland is lost as a result.',
                    ],
                    'correct_index' => 0,
                    'explanation' => 'Opsi 1 mengubah "cities are expanding rapidly" menjadi "Rapid urban expansion" dan "farmland is disappearing" menjadi "the depletion of arable farmland", menunjukkan kepadatan leksikal optimal.',
                ],
                [
                    'number' => '2',
                    'prompt' => 'Ubah klausa berikut ke bentuk nomina: "The researchers investigated the anomaly rigorously."',
                    'options' => [
                        'The researchers rigorous investigation of the anomaly',
                        'The rigorous investigation of the anomaly by researchers',
                        'The anomaly investigating rigorously by researchers',
                        'The rigorous investigate of the anomaly',
                    ],
                    'correct_index' => 1,
                    'explanation' => '"Rigorous investigation of the anomaly" mengubah verba "investigated" menjadi nomina "investigation" yang diterangkan oleh adjektiva "rigorous".',
                ],
            ],
        ];
    }

    /**
     * 4.1 Participle Clauses & Clause Reduction (Reducing & Abridgement)
     */
    protected function getParticipleReductionPackage(): array
    {
        return [
            'banner_title' => 'Participle Clauses & Clause Reduction',
            'banner_subtitle' => 'Kuasai teknik peringkasan Adjective Clause (Reducing) dan Adverbial Clause (Abridgement) sesuai standar Target Bahasa.',
            'banner_badge' => 'MODULE 4.1 ADVANCED REDUCTION',
            'study_guide' => [
                'concept_title' => 'Teknik Peringkasan Klausa: Reducing & Abridgement',
                'concept_summary' => 'Teknik peringkasan adalah senjata rahasia penulisan akademik tingkat tinggi untuk menghemat kata dan meningkatkan keringkasan. Modul Target Bahasa membagi teknik peringkasan menjadi dua kaidah mutlak: (1) REDUCING untuk Adjective Clauses, dan (2) ABRIDGEMENT untuk Adverbial Clauses.',
                'rules' => [
                    [
                        'rule_title' => '1. REDUCING (Adjective Clause Reduction)',
                        'rule_formula' => 'Aktif ➔ V-ing | Pasif ➔ V3 | Nominal ➔ Being / Adj Phrase | Certain Words (the first/only) ➔ To Infinitive',
                        'rule_description' => 'Menghilangkan relative pronoun (who/which/that) yang bertindak sebagai subjek.',
                        'examples' => [
                            [
                                'en' => 'Aktif: Scientists who research climate trends ➔ Scientists researching climate trends',
                                'id' => 'Ilmuwan yang meneliti tren iklim...',
                                'note' => 'V-ing (Present Participle) menggantikan klausa aktif.'
                            ],
                            [
                                'en' => 'Pasif: The methodology which was developed by Harvard ➔ The methodology developed by Harvard',
                                'id' => 'Metodologi yang dikembangkan oleh Harvard...',
                                'note' => 'V3 (Past Participle) menggantikan klausa pasif.'
                            ],
                            [
                                'en' => 'Certain Words: The first scholar who published the finding ➔ The first scholar to publish the finding',
                                'id' => 'Sarjana pertama yang mempublikasikan temuan tersebut...',
                                'note' => 'Frasa "the first/only/best" diringkas menggunakan To Infinitive.'
                            ],
                        ],
                    ],
                    [
                        'rule_title' => '2. ABRIDGEMENT (Adverbial Clause Reduction)',
                        'rule_formula' => 'Conjunction (after, before, while, when, although, unless) + V-ing (Aktif) / V3 (Pasif) / Nominal Phrase',
                        'rule_description' => 'Hanya boleh dilakukan jika subjek anak kalimat SAMA DENGAN subjek induk kalimat!',
                        'examples' => [
                            [
                                'en' => 'Aktif: After they analyzed the samples, the team published the paper ➔ After analyzing the samples, the team published the paper.',
                                'id' => 'Setelah menganalisis sampel, tim menerbitkan makalah tersebut.',
                                'note' => 'Conjunction + V-ing.'
                            ],
                            [
                                'en' => 'Pasif: Although it was criticized by reviewers, the paper won an award ➔ Although criticized by reviewers, the paper won an award.',
                                'id' => 'Meskipun dikritik oleh peninjau, makalah tersebut memenangkan penghargaan.',
                                'note' => 'Conjunction + V3.'
                            ],
                        ],
                    ],
                ],
                'contrast_table' => [
                    'headers' => ['Teknik', 'Klausa Asal', 'Aturan Participle', 'Contoh Kalimat'],
                    'rows' => [
                        ['Reducing Aktif', 'Adjective Clause (who/which + V-aktif)', 'V-ing', 'Students attending the lecture took notes.'],
                        ['Reducing Pasif', 'Adjective Clause (which + be + V3)', 'V3 murni', 'The data collected during the trial proved vital.'],
                        ['Abridgement Aktif', 'Adv Clause (when + S + V-aktif)', 'Conjunction + V-ing', 'While conducting the survey, we observed errors.'],
                        ['Abridgement Pasif', 'Adv Clause (unless + S + be + V3)', 'Conjunction + V3', 'Unless proven guilty, individuals retain rights.'],
                    ],
                ],
                'common_pitfalls' => [
                    [
                        'incorrect' => 'Having analysed the data thoroughly, the conclusions were drawn. (Dangling Modifier)',
                        'correct' => 'Having analysed the data thoroughly, the lead researcher drew clear conclusions.',
                        'explanation' => 'Subjek setelah tanda koma harus pihak yang melakukan analisis ("the lead researcher"), bukan "the conclusions".'
                    ],
                ],
                'exam_tips' => [
                    'Pastikan subjek kalimat utama setelah koma cocok dengan pelaku tindakan partisipil untuk mencegah kesalahan "Dangling Modifier".'
                ],
            ],
            'questions' => [
                [
                    'number' => '1',
                    'prompt' => 'Pilihlah kalimat hasil "Reducing" (Adjective Clause Reduction) pasif yang paling tepat dari: "The specimen which was discovered in the Indonesian archipelago represents an unknown genus."',
                    'options' => [
                        'The specimen discovering in the Indonesian archipelago represents an unknown genus.',
                        'The specimen discovered in the Indonesian archipelago represents an unknown genus.',
                        'The specimen being discovered in the Indonesian archipelago represents an unknown genus.',
                        'The specimen was discovered in the Indonesian archipelago represents an unknown genus.',
                    ],
                    'correct_index' => 1,
                    'explanation' => 'Klausa pasif "which was discovered" diringkas menjadi Past Participle murni "discovered". Opsi 4 salah karena menimbulkan double finite verb ("was discovered" dan "represents").',
                ],
                [
                    'number' => '2',
                    'prompt' => 'Manakah kalimat Abridgement yang BEBAS dari kesalahan "Dangling Participle"?',
                    'options' => [
                        'After reviewing the experimental data, several flaws were detected by the auditors.',
                        'After reviewing the experimental data, the auditors detected several flaws.',
                        'After reviewing the experimental data, detection of several flaws occurred.',
                        'After reviewing the experimental data, it was clear that flaws existed.',
                    ],
                    'correct_index' => 1,
                    'explanation' => 'Pihak yang melakukan tindakan "reviewing" adalah "the auditors", sehingga "the auditors" wajib menjadi subjek langsung setelah tanda koma.',
                ],
                [
                    'number' => '3',
                    'prompt' => 'Pilihlah bentuk reduksi yang tepat untuk pola "Certain Words": "Dr. Aris was the only researcher who identified the anomaly."',
                    'options' => [
                        'Dr. Aris was the only researcher identifying the anomaly.',
                        'Dr. Aris was the only researcher to identify the anomaly.',
                        'Dr. Aris was the only researcher identified the anomaly.',
                        'Dr. Aris was the only researcher for identifying the anomaly.',
                    ],
                    'correct_index' => 1,
                    'explanation' => 'Klausa relatif yang diawali frasa "the only / the first / the second / the best" wajib diringkas menggunakan To-Infinitive ("to identify").',
                ],
            ],
        ];
    }

    /**
     * 4.2 Inversion for Emphasis in Formal Prose
     */
    protected function getInversionPackage(): array
    {
        return [
            'banner_title' => 'Inversion for Emphasis in Formal Prose',
            'banner_subtitle' => 'Terapkan teknik pembalikan sintaksis (Negative Inversion) untuk memberikan penekanan retoris yang elegan.',
            'banner_badge' => 'MODULE 4.2 RHETORICAL INVERSION',
            'study_guide' => [
                'concept_title' => 'Konsep Inversion (Pembalikan Subjek-Kata Kerja)',
                'concept_summary' => 'Inversion adalah teknik menukar urutan Subjek dan Auxiliary Verb (seperti kalimat tanya) saat kalimat diawali oleh frasa negatif atau pembatas (negative/restrictive adverbials). Ini adalah fitur penulisan sastrawi dan akademik tingkat tinggi (CEFR C1-C2).',
                'rules' => [
                    [
                        'rule_title' => 'Rumus Negative Inversion',
                        'rule_formula' => 'Negative Adverbial + Auxiliary Verb (do/does/did/is/are/has/have/modal) + Subject + Main Verb',
                        'rule_description' => 'Frasa pemicu: Seldom, Rarely, Scarcely, Barely, Little, Not only... but also, Under no circumstances, At no time.',
                        'examples' => [
                            [
                                'en' => 'Normal: Scholars rarely encounter such pristine historical documents.',
                                'id' => 'Biasa: Para sarjana jarang menjumpai dokumen sejarah yang begitu murni.',
                                'note' => 'Urutan standar: S + Adverb + Verb.'
                            ],
                            [
                                'en' => 'Inverted: Rarely do scholars encounter such pristine historical documents.',
                                'id' => 'Inversi: Jarang sekali para sarjana menjumpai dokumen sejarah yang begitu murni.',
                                'note' => 'Rarely + do (Aux) + scholars (S) + encounter (Main Verb).'
                            ],
                        ],
                    ],
                    [
                        'rule_title' => 'Inversi "Not only ... but also"',
                        'rule_formula' => 'Not only + Aux + Subject + Verb, but [Subject] also [Verb]...',
                        'rule_description' => 'Inversi hanya terjadi pada klausa pertama setelah "Not only", sedangkan klausa kedua tetap menggunakan urutan normal.',
                        'examples' => [
                            [
                                'en' => 'Not only does the framework streamline data processing, but it also minimizes computational error.',
                                'id' => 'Kerangka kerja tersebut tidak hanya mempercepat pemrosesan data, namun juga meminimalkan kesalahan komputasi.',
                                'note' => 'Pola inversi formal yang sangat efektif dalam esai argumentatif.'
                            ],
                        ],
                    ],
                ],
                'contrast_table' => [
                    'headers' => ['Pemicu Inversi', 'Struktur Inversi', 'Contoh Kalimat Akademik'],
                    'rows' => [
                        ['Seldom / Rarely', 'Seldom + have/has/do + S + V', 'Seldom has a technological innovation transformed society so rapidly.'],
                        ['Not only', 'Not only + does/is + S + V', 'Not only does the vaccine protect against infection, but it prevents transmission.'],
                        ['Under no circumstances', 'Under no circumstances + should + S + V', 'Under no circumstances should raw confidential data be compromised.'],
                        ['Only after / Only when', 'Only after + Adv Clause, + AUX + S + V', 'Only after rigorous validation did the FDA grant official approval.'],
                    ],
                ],
                'common_pitfalls' => [
                    [
                        'incorrect' => 'Rarely scientists have witnessed such seismic anomalies.',
                        'correct' => 'Rarely have scientists witnessed such seismic anomalies.',
                        'explanation' => 'Setelah kata pembatas negatif "Rarely", auxiliary verb "have" WAJIB mendahului subjek "scientists".'
                    ],
                ],
                'exam_tips' => [
                    'Gunakan inversi secara hemat (1 kali dalam sebuah esai) agar memberikan dampak penekanan retoris yang maksimal tanpa terkesan berlebihan.'
                ],
            ],
            'questions' => [
                [
                    'number' => '1',
                    'prompt' => 'Pilihlah susunan inversi negatif yang benar secara tata bahasa:',
                    'options' => [
                        'Seldom international tribunals have intervened in domestic maritime disputes.',
                        'Seldom have international tribunals intervened in domestic maritime disputes.',
                        'Seldom international tribunals intervened in domestic maritime disputes.',
                        'Seldom do international tribunals intervened in domestic maritime disputes.',
                    ],
                    'correct_index' => 1,
                    'explanation' => 'Negative inversion: Negative Adverb ("Seldom") + Auxiliary ("have") + Subject ("international tribunals") + Main Verb ("intervened").',
                ],
                [
                    'number' => '2',
                    'prompt' => 'Lengkapi kalimat berikut dengan struktur inversi yang tepat: "Not only ________ crucial insights into consumer behavior, but it also revolutionized retail marketing."',
                    'options' => [
                        'the study provided',
                        'did the study provide',
                        'does the study provided',
                        'the study did provide',
                    ],
                    'correct_index' => 1,
                    'explanation' => 'Karena klausa kedua menggunakan past tense ("revolutionized"), klausa pertama memakai auxiliary past "did" + Subjek + Verb dasar ("did the study provide").',
                ],
            ],
        ];
    }

    /**
     * Fallback package for generic topics (IELTS, SAT, etc.)
     */
    protected function getGenericPackage(string $seed, string $topicTitle = '', array $meta = []): array
    {
        $displayTitle = $topicTitle ?: ucwords(str_replace(['-', '_'], ' ', $seed));
        $theory = $meta['theory'] ?? '';
        $writingApp = $meta['writing_application'] ?? '';
        $drillSpecs = $meta['drill_specs'] ?? '';

        $subtitle = $writingApp ? "Writing Application: {$writingApp}" : 'Evaluasi skenario kontekstual dan analisis linguistik di bawah ini untuk memilih respon yang optimal.';

        return [
            'banner_title' => $displayTitle,
            'banner_subtitle' => $subtitle,
            'banner_badge' => 'ACADEMIC PRACTICE MODULE',
            'study_guide' => [
                'concept_title' => "Panduan Materi: {$displayTitle}",
                'concept_summary' => $theory ? "Teori Inti: {$theory}" : "Modul latihan mandiri ini berfokus pada penguasaan konsep {$displayTitle} dalam konteks standar penulisan akademis internasional (IELTS Academic Task 1/2, TOEFL iBT, Digital SAT).",
                'rules' => [
                    [
                        'rule_title' => 'Landasan Teoretis & Kaidah Akademik',
                        'rule_formula' => $theory ?: 'Kejelasan Konseptual + Struktur Sintaksis Terarah + Kosakata Formal',
                        'rule_description' => $writingApp ?: 'Gunakan struktur kalimat baku, hindari bahasa sehari-hari (slang/colloquialism), dan pertahankan konsistensi sudut pandang objektif.',
                        'examples' => [
                            [
                                'en' => 'Empirical evidence substantiates the proposed theoretical paradigm.',
                                'id' => 'Bukti empiris memperkuat paradigma teoretis yang diusulkan.',
                                'note' => 'Gaya bahasa formal dan presisi sesuai kaidah jurnal internasional.'
                            ],
                        ],
                    ],
                ],
                'contrast_table' => [
                    'headers' => ['Aspek Evaluasi', 'Register Informal (Hindari)', 'Register Akademis (Rekomendasi)'],
                    'rows' => [
                        ['Diksi', 'get better, look into, a lot of', 'improve, investigate, a substantial number of'],
                        ['Sintaksis', 'Simple compound sentences with "and"', 'Complex clausal subordination & cohesion'],
                        ['Nada Argumen', 'I strongly think that...', 'Evidence indicates that... / It is widely argued that...'],
                    ],
                ],
                'common_pitfalls' => [
                    [
                        'incorrect' => 'Researchers did an experiment and figured out things.',
                        'correct' => 'Researchers conducted an experiment and identified significant findings.',
                        'explanation' => 'Gunakan phrasal verbs formal dan kata benda yang spesifik.'
                    ],
                ],
                'exam_tips' => [
                    $drillSpecs ? "Target Latihan: {$drillSpecs}" : 'Pastikan setiap kalimat memiliki subjek dan kata kerja utama yang jelas tanpa run-on atau comma splice.',
                    'Gunakan variasi kalimat untuk menciptakan ritme tulisan akademik yang dinamis dan berbobot.'
                ],
            ],
            'questions' => [
                [
                    'number' => '1',
                    'prompt' => 'Pilihlah kalimat yang menunjukkan register akademis formal dan sintaksis yang optimal:',
                    'options' => [
                        'The investigators examined the phenomenon and devised an innovative methodological framework.',
                        'The researchers looked into the problem and figured out a brand new way to handle it.',
                        'The team checked out the data and got a hold of really cool results.',
                        'Scientists did a lot of stuff to make sure the results were totally fine.',
                    ],
                    'correct_index' => 0,
                    'explanation' => 'Opsi 1 menggunakan diksi akademik ("investigators", "examined", "devised", "methodological framework") tanpa ekspresi percakapan kasual.',
                ],
                [
                    'number' => '2',
                    'prompt' => 'Manakah tanda baca yang paling tepat untuk menghubungkan dua independent clauses yang berkaitan erat tanpa kata hubung koordinasi?',
                    'options' => [
                        'Semicolon ( ; )',
                        'Comma ( , )',
                        'Hyphen ( - )',
                        'Slash ( / )',
                    ],
                    'correct_index' => 0,
                    'explanation' => 'Titik koma (semicolon) digunakan untuk menghubungkan dua klausa independen yang berhubungan erat tanpa menimbulkan kesalahan comma splice.',
                ],
            ],
        ];
    }
}
