<?php

namespace App\Services;

class SelfStudyPresentNegativeInterrogativeData
{
    /**
     * Get the complete Present Negative & Questions package.
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
            'banner_title' => 'Simple Present: Negative & Questions',
            'banner_subtitle' => 'Kuasai kalimat negatif verbal (do/does not), negatif nominal & pasif (is/are not), serta pertanyaan Yes/No dan WH- dalam percakapan sehari-hari.',
            'banner_badge' => 'MODULE 1.4 NEGATIVE & QUESTIONS',
            'sub_lessons' => $subLessons,
            'study_guide' => self::getStudyGuide(),
            'questions' => $questions,
        ];
    }

    /**
     * Study guide content for Topic 1.4
     */
    public static function getStudyGuide(): array
    {
        return [
            'concept_title' => 'Kaidah Kalimat Negatif & Pertanyaan (Negative & Question Forms)',
            'concept_summary' => 'Dalam percakapan sehari-hari, kita sering perlu mengatakan bahwa sesuatu TIDAK terjadi, atau bertanya tentang sesuatu. Kalimat negatif (negative) dan kalimat tanya (question) dalam Simple Present mengikuti pola yang berbeda tergantung jenis kalimatnya: verbal (ada kata kerja aksi), nominal (ada kata sifat/kata benda), atau pasif (sesuatu dikenai tindakan).',
            'rules' => [
                [
                    'rule_title' => '1. Negatif Verbal: do not vs does not + V1',
                    'rule_formula' => 'I/You/We/They + DO NOT + V1 | He/She/It + DOES NOT + V1',
                    'rule_description' => 'Setelah "do not" atau "does not", kata kerja utama WAJIB kembali ke bentuk dasar (Verb 1) tanpa akhiran -s/-es. Jangan menambahkan "is/are" pada kalimat verbal negatif.',
                    'examples' => [
                        [
                            'en' => 'My parents do not drink coffee.',
                            'id' => 'Orang tua saya tidak minum kopi.',
                            'note' => 'Subjek jamak "My parents" memakai "do not" diikuti kata kerja dasar "drink".'
                        ],
                    ],
                ],
                [
                    'rule_title' => '2. Negatif Nominal & Pasif: is/are not (+ Pelengkap / V3)',
                    'rule_formula' => 'Nominal: S + is/are not + Adjective/Noun | Pasif: S + is/are not + V3 (Past Participle)',
                    'rule_description' => 'Gunakan "to be + not" untuk kalimat tanpa kata kerja aksi (menjelaskan kata sifat, contoh: tired, ready, closed) atau saat objek dikenai suatu tindakan secara pasif.',
                    'examples' => [
                        [
                            'en' => 'The window is not closed.',
                            'id' => 'Jendela itu tidak tertutup.',
                            'note' => 'Kalimat pasif negatif: "is not" diikuti bentuk V3 "closed".'
                        ],
                    ],
                ],
                [
                    'rule_title' => '3. Pertanyaan Yes/No: Does/Do/Is/Are + Subjek...?',
                    'rule_formula' => 'Verbal: DOES/DO + Subject + V1...? | Nominal: IS/ARE + Subject + Complement...?',
                    'rule_description' => 'Untuk pertanyaan yang dijawab "Yes" atau "No", letakkan auxiliary (does/do/is/are) di awal kalimat, sebelum subjek.',
                    'examples' => [
                        [
                            'en' => 'Does she like tea?',
                            'id' => 'Apakah dia suka teh?',
                            'note' => '"Does" diletakkan di depan subjek "she", diikuti V1 "like".'
                        ],
                    ],
                ],
                [
                    'rule_title' => '4. Pertanyaan WH-: What/Where/Why/How + Aux + Subjek...?',
                    'rule_formula' => 'Wh- Word (What/Where/When/Why/How) + DOES/DO/IS/ARE + Subject + V1/Complement...?',
                    'rule_description' => 'Pertanyaan dengan kata tanya (what, where, when, why, how) tetap membutuhkan auxiliary tepat setelah kata tanya, sebelum subjek.',
                    'examples' => [
                        [
                            'en' => 'Where does he live?',
                            'id' => 'Di mana dia tinggal?',
                            'note' => '"Where" + auxiliary "does" + subjek "he" + V1 "live".'
                        ],
                    ],
                ],
            ],
            'contrast_table' => [
                'headers' => ['Parameter', '1. Negatif Verbal', '2. Negatif Nominal', '3. Negatif Pasif', '4. Pertanyaan'],
                'rows' => [
                    ['Auxiliary Wajib', 'do not / does not', 'is not / are not', 'is not / are not', 'Does / Do / Is / Are (di depan S)'],
                    ['Komponen Utama', 'Verb 1 (bentuk dasar)', 'Kata sifat / kata benda', 'Verb 3 (past participle)', 'Wh- (opsional) + Aux + S + V/Comp'],
                    ['Contoh Kalimat', 'They do not watch TV.', 'He is not tall.', 'The door is not locked.', 'Does he play tennis?'],
                    ['Kesalahan Umum', 'They are not watch TV.', 'He do not tall.', 'The door do not locked.', 'He plays tennis?'],
                ],
            ],
            'common_pitfalls' => [
                [
                    'incorrect' => 'She does not likes spicy food.',
                    'correct' => 'She does not like spicy food.',
                    'explanation' => 'Jangan menambahkan -s pada "like" karena sudah diwakili oleh "does".'
                ],
                [
                    'incorrect' => 'My brother does not tired today.',
                    'correct' => 'My brother is not tired today.',
                    'explanation' => '"Tired" adalah kata sifat, jadi wajib pakai "to be": "is not tired".'
                ],
                [
                    'incorrect' => 'Where you live?',
                    'correct' => 'Where do you live?',
                    'explanation' => 'Pertanyaan WH- tetap membutuhkan auxiliary "do" sebelum subjek "you".'
                ],
                [
                    'incorrect' => 'The cake do not baked yet.',
                    'correct' => 'The cake is not baked yet.',
                    'explanation' => 'Kalimat pasif negatif memakai "is not" + V3 "baked", bukan "do not".'
                ],
            ],
            'exam_tips' => [
                'Periksa apakah kata setelah bentuk negatif adalah kata kerja (pakai do/does not) atau kata sifat/status (pakai is/are not).',
                'Dalam pertanyaan WH-, jangan lupa menempatkan auxiliary tepat setelah kata tanya, sebelum subjek.',
                'Subjek tunggal (he/she/it/nama orang) selalu memakai "does" atau "is", bukan "do" atau "are".'
            ],
        ];
    }

    /**
     * Complete list of 8 sub-lessons for Topic 1.4
     */
    public static function getSubLessons(): array
    {
        return [
          [
            'id' => 'verbal_neg_plural',
            'name' => 'Verbal Negative: Subjek Jamak & I/You/We/They (do not + V1)',
            'code' => '1.4.1',
            'concept_title' => 'Kalimat Verbal Negatif dengan Subjek I, You, We, They, dan Kata Benda Jamak',
            'concept_description' => 'Kalimat verbal negatif menyatakan bahwa subjek tidak melakukan suatu tindakan. Untuk subjek jamak (They, We, You, atau kata benda jamak seperti my friends, the children), gunakan auxiliary \'do not\' diikuti bentuk dasar kata kerja (Verb 1). Jangan pernah menambahkan akhiran -s/-es atau menyisipkan \'are\' pada kalimat verbal negatif.',
            'formula' => 'Subject (I / You / We / They / Plural Nouns) + DO NOT + Verb 1 (Base Form) + Object / Complement',
            'rules' => [
              'Gunakan auxiliary \'do not\' untuk subjek jamak dan kata ganti I, You, We, They.',
              'Kata kerja utama setelah \'do not\' WAJIB berupa Verb 1 bentuk dasar murni tanpa imbuhan.',
              'Dilarang menambahkan \'are\' (misal: \'They are not like\' adalah SALAH).',
              'Bentuk singkatan \'don\'t\' juga boleh dipakai dalam percakapan santai.',
            ],
            'exercises' => [
              [
                'id' => 1,
                'id_sentence' => 'Orang tua saya tidak minum kopi di malam hari.',
                'target_word' => 'do not drink',
                'vocab' => [
                  'my parents' => ['id' => 'orang tua saya', 'pos' => '(n phr)'],
                  'drink' => ['id' => 'minum', 'pos' => '(v)'],
                  'coffee' => ['id' => 'kopi', 'pos' => '(n)'],
                  'at night' => ['id' => 'di malam hari', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'My parents do not drink coffee at night.',
                  'My parents are not drink coffee at night.',
                  'My parents does not drink coffee at night.',
                  'My parents do not drinks coffee at night.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek \'My parents\' jamak, sehingga memakai \'do not\' diikuti kata kerja dasar \'drink\'.',
              ],
              [
                'id' => 2,
                'id_sentence' => 'Anak-anak itu tidak suka sayur hijau.',
                'target_word' => 'do not like',
                'vocab' => [
                  'the children' => ['id' => 'anak-anak itu', 'pos' => '(n phr)'],
                  'like' => ['id' => 'suka', 'pos' => '(v)'],
                  'green vegetables' => ['id' => 'sayur hijau', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'The children do not like green vegetables.',
                  'The children does not like green vegetables.',
                  'The children are not like green vegetables.',
                  'The children do not likes green vegetables.',
                ],
                'correct_index' => 0,
                'explanation' => '\'The children\' bersifat jamak, memerlukan \'do not\' + V1 murni \'like\'.',
              ],
              [
                'id' => 3,
                'id_sentence' => 'Kami tidak menonton televisi pada hari sekolah.',
                'target_word' => 'do not watch',
                'vocab' => [
                  'watch' => ['id' => 'menonton', 'pos' => '(v)'],
                  'television' => ['id' => 'televisi', 'pos' => '(n)'],
                  'on school days' => ['id' => 'pada hari sekolah', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'We do not watch television on school days.',
                  'We does not watch television on school days.',
                  'We are not watch television on school days.',
                  'We do not watches television on school days.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek \'We\' memakai \'do not\' + V1 \'watch\'.',
              ],
              [
                'id' => 4,
                'id_sentence' => 'Teman-teman saya tidak bermain sepak bola pada hari Minggu.',
                'target_word' => 'do not play',
                'vocab' => [
                  'my friends' => ['id' => 'teman-teman saya', 'pos' => '(n phr)'],
                  'play' => ['id' => 'bermain', 'pos' => '(v)'],
                  'football' => ['id' => 'sepak bola', 'pos' => '(n)'],
                  'on Sundays' => ['id' => 'pada hari Minggu', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'My friends do not play football on Sundays.',
                  'My friends does not play football on Sundays.',
                  'My friends is not play football on Sundays.',
                  'My friends do not plays football on Sundays.',
                ],
                'correct_index' => 0,
                'explanation' => '\'My friends\' jamak, memakai \'do not\' + V1 \'play\'.',
              ],
              [
                'id' => 5,
                'id_sentence' => 'Kalian tidak perlu membawa payung hari ini.',
                'target_word' => 'do not need',
                'vocab' => [
                  'need' => ['id' => 'perlu', 'pos' => '(v)'],
                  'bring' => ['id' => 'membawa', 'pos' => '(v)'],
                  'umbrella' => ['id' => 'payung', 'pos' => '(n)'],
                ],
                'options' => [
                  'You do not need to bring an umbrella today.',
                  'You does not need to bring an umbrella today.',
                  'You are not need to bring an umbrella today.',
                  'You do not needs to bring an umbrella today.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek \'You\' memakai \'do not\' + V1 \'need\'.',
              ],
              [
                'id' => 6,
                'id_sentence' => 'Tetangga saya tidak memelihara hewan peliharaan.',
                'target_word' => 'do not keep',
                'vocab' => [
                  'my neighbors' => ['id' => 'tetangga saya', 'pos' => '(n phr)'],
                  'keep' => ['id' => 'memelihara', 'pos' => '(v)'],
                  'pets' => ['id' => 'hewan peliharaan', 'pos' => '(n)'],
                ],
                'options' => [
                  'My neighbors do not keep pets.',
                  'My neighbors does not keep pets.',
                  'My neighbors are not keep pets.',
                  'My neighbors do not keeps pets.',
                ],
                'correct_index' => 0,
                'explanation' => '\'My neighbors\' jamak, memakai \'do not\' + V1 \'keep\'.',
              ],
              [
                'id' => 7,
                'id_sentence' => 'Kucing-kucing itu tidak tidur di sofa.',
                'target_word' => 'do not sleep',
                'vocab' => [
                  'the cats' => ['id' => 'kucing-kucing itu', 'pos' => '(n phr)'],
                  'sleep' => ['id' => 'tidur', 'pos' => '(v)'],
                  'sofa' => ['id' => 'sofa', 'pos' => '(n)'],
                ],
                'options' => [
                  'The cats do not sleep on the sofa.',
                  'The cats does not sleep on the sofa.',
                  'The cats are not sleep on the sofa.',
                  'The cats do not sleeps on the sofa.',
                ],
                'correct_index' => 0,
                'explanation' => '\'The cats\' jamak, memakai \'do not\' + V1 \'sleep\'.',
              ],
              [
                'id' => 8,
                'id_sentence' => 'Saya dan adik saya tidak makan daging.',
                'target_word' => 'do not eat',
                'vocab' => [
                  'my sibling and I' => ['id' => 'saya dan adik saya', 'pos' => '(n phr)'],
                  'eat' => ['id' => 'makan', 'pos' => '(v)'],
                  'meat' => ['id' => 'daging', 'pos' => '(n)'],
                ],
                'options' => [
                  'My sibling and I do not eat meat.',
                  'My sibling and I does not eat meat.',
                  'My sibling and I are not eat meat.',
                  'My sibling and I do not eats meat.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek gabungan (\'My sibling and I\') dihitung jamak, memakai \'do not\' + V1 \'eat\'.',
              ],
              [
                'id' => 9,
                'id_sentence' => 'Murid-murid tidak membawa ponsel ke kelas.',
                'target_word' => 'do not bring',
                'vocab' => [
                  'the students' => ['id' => 'murid-murid', 'pos' => '(n phr)'],
                  'bring' => ['id' => 'membawa', 'pos' => '(v)'],
                  'mobile phones' => ['id' => 'ponsel', 'pos' => '(n)'],
                ],
                'options' => [
                  'The students do not bring mobile phones to class.',
                  'The students does not bring mobile phones to class.',
                  'The students are not bring mobile phones to class.',
                  'The students do not brings mobile phones to class.',
                ],
                'correct_index' => 0,
                'explanation' => '\'The students\' jamak, memakai \'do not\' + V1 \'bring\'.',
              ],
              [
                'id' => 10,
                'id_sentence' => 'Kami tidak mengunci pintu depan pada siang hari.',
                'target_word' => 'do not lock',
                'vocab' => [
                  'lock' => ['id' => 'mengunci', 'pos' => '(v)'],
                  'front door' => ['id' => 'pintu depan', 'pos' => '(n phr)'],
                  'during the day' => ['id' => 'pada siang hari', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'We do not lock the front door during the day.',
                  'We does not lock the front door during the day.',
                  'We are not lock the front door during the day.',
                  'We do not locks the front door during the day.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek \'We\' memakai \'do not\' + V1 \'lock\'.',
              ],
            ],
          ],
          [
            'id' => 'verbal_neg_singular',
            'name' => 'Verbal Negative: Subjek Tunggal & Uncountable (does not + V1)',
            'code' => '1.4.2',
            'concept_title' => 'Kalimat Verbal Negatif dengan Subjek He, She, It, dan Kata Benda Tak Terhitung',
            'concept_description' => 'Ketika subjek berupa orang ketiga tunggal (He, She, It), nama orang/benda tunggal, atau kata benda tak terhitung (water, rice, music), gunakan auxiliary \'does not\' diikuti kata kerja bentuk dasar (Verb 1). Jangan menambahkan akhiran -s/-es pada kata kerja karena sudah diwakili oleh \'does\'.',
            'formula' => 'Subject (He / She / It / Singular & Uncountable) + DOES NOT + Verb 1 (Base Form) + Complement',
            'rules' => [
              'Gunakan auxiliary \'does not\' untuk subjek tunggal orang ketiga dan kata benda tak terhitung.',
              'Kata kerja setelah \'does not\' WAJIB berupa Verb 1 tanpa akhiran -s/-es.',
              'Dilarang menggunakan \'is not\' untuk kalimat verbal (ada kata kerja aksi).',
              'Perhatikan subjek tunggal: nama orang, he/she/it, dan kata benda tak terhitung semuanya memakai \'does not\'.',
            ],
            'exercises' => [
              [
                'id' => 11,
                'id_sentence' => 'Adik saya tidak suka musik keras.',
                'target_word' => 'does not like',
                'vocab' => [
                  'my brother' => ['id' => 'adik saya (laki-laki)', 'pos' => '(n phr)'],
                  'like' => ['id' => 'suka', 'pos' => '(v)'],
                  'loud music' => ['id' => 'musik keras', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'My brother does not like loud music.',
                  'My brother do not like loud music.',
                  'My brother is not like loud music.',
                  'My brother does not likes loud music.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek \'My brother\' tunggal, memakai \'does not\' + V1 murni \'like\'.',
              ],
              [
                'id' => 12,
                'id_sentence' => 'Guru itu tidak mengajar pada hari Sabtu.',
                'target_word' => 'does not teach',
                'vocab' => [
                  'the teacher' => ['id' => 'guru itu', 'pos' => '(n phr)'],
                  'teach' => ['id' => 'mengajar', 'pos' => '(v)'],
                  'on Saturdays' => ['id' => 'pada hari Sabtu', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'The teacher does not teach on Saturdays.',
                  'The teacher do not teach on Saturdays.',
                  'The teacher is not teach on Saturdays.',
                  'The teacher does not teaches on Saturdays.',
                ],
                'correct_index' => 0,
                'explanation' => '\'The teacher\' tunggal, memakai \'does not\' + V1 \'teach\'.',
              ],
              [
                'id' => 13,
                'id_sentence' => 'Air ini tidak terasa manis.',
                'target_word' => 'does not taste',
                'vocab' => [
                  'water' => ['id' => 'air', 'pos' => '(n)'],
                  'taste' => ['id' => 'terasa', 'pos' => '(v)'],
                  'sweet' => ['id' => 'manis', 'pos' => '(adj)'],
                ],
                'options' => [
                  'This water does not taste sweet.',
                  'This water do not taste sweet.',
                  'This water is not taste sweet.',
                  'This water does not tastes sweet.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Water\' adalah kata benda tak terhitung, memakai \'does not\' + V1 \'taste\'.',
              ],
              [
                'id' => 14,
                'id_sentence' => 'Toko itu tidak buka sebelum pukul sembilan.',
                'target_word' => 'does not open',
                'vocab' => [
                  'the shop' => ['id' => 'toko itu', 'pos' => '(n phr)'],
                  'open' => ['id' => 'buka', 'pos' => '(v)'],
                  'before nine o\'clock' => ['id' => 'sebelum pukul sembilan', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'The shop does not open before nine o\'clock.',
                  'The shop do not open before nine o\'clock.',
                  'The shop is not open before nine o\'clock.',
                  'The shop does not opens before nine o\'clock.',
                ],
                'correct_index' => 0,
                'explanation' => '\'The shop\' tunggal, memakai \'does not\' + V1 \'open\'.',
              ],
              [
                'id' => 15,
                'id_sentence' => 'Nasi ini tidak membutuhkan waktu lama untuk masak.',
                'target_word' => 'does not need',
                'vocab' => [
                  'rice' => ['id' => 'nasi', 'pos' => '(n)'],
                  'need' => ['id' => 'membutuhkan', 'pos' => '(v)'],
                  'a long time' => ['id' => 'waktu lama', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'This rice does not need a long time to cook.',
                  'This rice do not need a long time to cook.',
                  'This rice is not need a long time to cook.',
                  'This rice does not needs a long time to cook.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Rice\' tak terhitung, memakai \'does not\' + V1 \'need\'.',
              ],
              [
                'id' => 16,
                'id_sentence' => 'Bus itu tidak berhenti di sini.',
                'target_word' => 'does not stop',
                'vocab' => [
                  'the bus' => ['id' => 'bus itu', 'pos' => '(n phr)'],
                  'stop' => ['id' => 'berhenti', 'pos' => '(v)'],
                  'here' => ['id' => 'di sini', 'pos' => '(adv)'],
                ],
                'options' => [
                  'The bus does not stop here.',
                  'The bus do not stop here.',
                  'The bus is not stop here.',
                  'The bus does not stops here.',
                ],
                'correct_index' => 0,
                'explanation' => '\'The bus\' tunggal, memakai \'does not\' + V1 \'stop\'.',
              ],
              [
                'id' => 17,
                'id_sentence' => 'Dia (perempuan) tidak minum susu.',
                'target_word' => 'does not drink',
                'vocab' => [
                  'she' => ['id' => 'dia (perempuan)', 'pos' => '(pron)'],
                  'drink' => ['id' => 'minum', 'pos' => '(v)'],
                  'milk' => ['id' => 'susu', 'pos' => '(n)'],
                ],
                'options' => [
                  'She does not drink milk.',
                  'She do not drink milk.',
                  'She is not drink milk.',
                  'She does not drinks milk.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek \'She\' tunggal, memakai \'does not\' + V1 \'drink\'.',
              ],
              [
                'id' => 18,
                'id_sentence' => 'Mesin itu tidak berfungsi dengan baik.',
                'target_word' => 'does not work',
                'vocab' => [
                  'the machine' => ['id' => 'mesin itu', 'pos' => '(n phr)'],
                  'work' => ['id' => 'berfungsi', 'pos' => '(v)'],
                  'properly' => ['id' => 'dengan baik', 'pos' => '(adv)'],
                ],
                'options' => [
                  'The machine does not work properly.',
                  'The machine do not work properly.',
                  'The machine is not work properly.',
                  'The machine does not works properly.',
                ],
                'correct_index' => 0,
                'explanation' => '\'The machine\' tunggal, memakai \'does not\' + V1 \'work\'.',
              ],
              [
                'id' => 19,
                'id_sentence' => 'Informasi itu tidak muncul di layar.',
                'target_word' => 'does not appear',
                'vocab' => [
                  'information' => ['id' => 'informasi', 'pos' => '(n)'],
                  'appear' => ['id' => 'muncul', 'pos' => '(v)'],
                  'on the screen' => ['id' => 'di layar', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'This information does not appear on the screen.',
                  'This information do not appear on the screen.',
                  'This information is not appear on the screen.',
                  'This information does not appears on the screen.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Information\' tak terhitung, memakai \'does not\' + V1 \'appear\'.',
              ],
              [
                'id' => 20,
                'id_sentence' => 'Anjing saya tidak menggonggong pada malam hari.',
                'target_word' => 'does not bark',
                'vocab' => [
                  'my dog' => ['id' => 'anjing saya', 'pos' => '(n phr)'],
                  'bark' => ['id' => 'menggonggong', 'pos' => '(v)'],
                  'at night' => ['id' => 'pada malam hari', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'My dog does not bark at night.',
                  'My dog do not bark at night.',
                  'My dog is not bark at night.',
                  'My dog does not barks at night.',
                ],
                'correct_index' => 0,
                'explanation' => '\'My dog\' tunggal, memakai \'does not\' + V1 \'bark\'.',
              ],
            ],
          ],
          [
            'id' => 'nominal_negative',
            'name' => 'Nominal Negative: am/is/are not + Complement',
            'code' => '1.4.3',
            'concept_title' => 'Kalimat Nominal Negatif dengan am/is/are not',
            'concept_description' => 'Kalimat nominal tidak memiliki kata kerja aksi; ia menjelaskan keadaan, sifat, atau identitas subjek menggunakan \'to be\'. Untuk menegasikannya, cukup tambahkan \'not\' setelah am/is/are. Jangan pernah menggunakan do/does untuk kalimat jenis ini.',
            'formula' => 'Subject + AM / IS / ARE NOT + Complement (Adjective / Noun Phrase / Prepositional Phrase)',
            'rules' => [
              'Gunakan \'am not\' untuk subjek I, \'is not\' untuk subjek tunggal, \'are not\' untuk subjek jamak/You.',
              'Complement bisa berupa kata sifat (tired, hungry), kata benda (a teacher), atau frasa preposisi (at home).',
              'Jangan gunakan do/does pada kalimat nominal karena tidak ada kata kerja aksi.',
            ],
            'exercises' => [
              [
                'id' => 21,
                'id_sentence' => 'Saya tidak lapar sekarang.',
                'target_word' => 'am not hungry',
                'vocab' => [
                  'hungry' => ['id' => 'lapar', 'pos' => '(adj)'],
                  'now' => ['id' => 'sekarang', 'pos' => '(adv)'],
                ],
                'options' => [
                  'I am not hungry now.',
                  'I do not hungry now.',
                  'I not am hungry now.',
                  'I am not hungries now.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek \'I\' memakai \'am not\' diikuti kata sifat \'hungry\'.',
              ],
              [
                'id' => 22,
                'id_sentence' => 'Adik saya (laki-laki) tidak tinggi.',
                'target_word' => 'is not tall',
                'vocab' => [
                  'my brother' => ['id' => 'adik saya (laki-laki)', 'pos' => '(n phr)'],
                  'tall' => ['id' => 'tinggi', 'pos' => '(adj)'],
                ],
                'options' => [
                  'My brother is not tall.',
                  'My brother do not tall.',
                  'My brother are not tall.',
                  'My brother not is tall.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'My brother\' memakai \'is not\' + kata sifat \'tall\'.',
              ],
              [
                'id' => 23,
                'id_sentence' => 'Cuaca hari ini tidak dingin.',
                'target_word' => 'is not cold',
                'vocab' => [
                  'the weather' => ['id' => 'cuaca', 'pos' => '(n phr)'],
                  'cold' => ['id' => 'dingin', 'pos' => '(adj)'],
                  'today' => ['id' => 'hari ini', 'pos' => '(adv)'],
                ],
                'options' => [
                  'The weather is not cold today.',
                  'The weather does not cold today.',
                  'The weather are not cold today.',
                  'The weather is not colds today.',
                ],
                'correct_index' => 0,
                'explanation' => '\'The weather\' tunggal, memakai \'is not\' + kata sifat \'cold\'.',
              ],
              [
                'id' => 24,
                'id_sentence' => 'Mereka tidak siap untuk ujian.',
                'target_word' => 'are not ready',
                'vocab' => [
                  'ready' => ['id' => 'siap', 'pos' => '(adj)'],
                  'exam' => ['id' => 'ujian', 'pos' => '(n)'],
                ],
                'options' => [
                  'They are not ready for the exam.',
                  'They do not ready for the exam.',
                  'They is not ready for the exam.',
                  'They not are ready for the exam.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'They\' memakai \'are not\' + kata sifat \'ready\'.',
              ],
              [
                'id' => 25,
                'id_sentence' => 'Buku ini tidak mahal.',
                'target_word' => 'is not expensive',
                'vocab' => [
                  'book' => ['id' => 'buku', 'pos' => '(n)'],
                  'expensive' => ['id' => 'mahal', 'pos' => '(adj)'],
                ],
                'options' => [
                  'This book is not expensive.',
                  'This book does not expensive.',
                  'This book are not expensive.',
                  'This book is not expensives.',
                ],
                'correct_index' => 0,
                'explanation' => '\'This book\' tunggal, memakai \'is not\' + kata sifat \'expensive\'.',
              ],
              [
                'id' => 26,
                'id_sentence' => 'Kami tidak berasal dari kota ini.',
                'target_word' => 'are not from',
                'vocab' => [
                  'from' => ['id' => 'berasal dari', 'pos' => '(prep)'],
                  'this city' => ['id' => 'kota ini', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'We are not from this city.',
                  'We do not from this city.',
                  'We is not from this city.',
                  'We not are from this city.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'We\' memakai \'are not\' + frasa preposisi \'from this city\'.',
              ],
              [
                'id' => 27,
                'id_sentence' => 'Dia (laki-laki) bukan seorang dokter.',
                'target_word' => 'is not a doctor',
                'vocab' => [
                  'he' => ['id' => 'dia (laki-laki)', 'pos' => '(pron)'],
                  'doctor' => ['id' => 'dokter', 'pos' => '(n)'],
                ],
                'options' => [
                  'He is not a doctor.',
                  'He do not a doctor.',
                  'He are not a doctor.',
                  'He not is a doctor.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'He\' memakai \'is not\' + kata benda \'a doctor\'.',
              ],
              [
                'id' => 28,
                'id_sentence' => 'Ruangan ini tidak bersih.',
                'target_word' => 'is not clean',
                'vocab' => [
                  'room' => ['id' => 'ruangan', 'pos' => '(n)'],
                  'clean' => ['id' => 'bersih', 'pos' => '(adj)'],
                ],
                'options' => [
                  'This room is not clean.',
                  'This room does not clean.',
                  'This room are not clean.',
                  'This room is not cleans.',
                ],
                'correct_index' => 0,
                'explanation' => '\'This room\' tunggal, memakai \'is not\' + kata sifat \'clean\'.',
              ],
              [
                'id' => 29,
                'id_sentence' => 'Saya tidak di rumah sekarang.',
                'target_word' => 'am not at home',
                'vocab' => [
                  'at home' => ['id' => 'di rumah', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'I am not at home now.',
                  'I do not at home now.',
                  'I not am at home now.',
                  'I is not at home now.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek \'I\' memakai \'am not\' + frasa preposisi \'at home\'.',
              ],
              [
                'id' => 30,
                'id_sentence' => 'Sepatu-sepatu itu tidak kotor.',
                'target_word' => 'are not dirty',
                'vocab' => [
                  'the shoes' => ['id' => 'sepatu-sepatu itu', 'pos' => '(n phr)'],
                  'dirty' => ['id' => 'kotor', 'pos' => '(adj)'],
                ],
                'options' => [
                  'The shoes are not dirty.',
                  'The shoes does not dirty.',
                  'The shoes is not dirty.',
                  'The shoes not are dirty.',
                ],
                'correct_index' => 0,
                'explanation' => '\'The shoes\' jamak, memakai \'are not\' + kata sifat \'dirty\'.',
              ],
            ],
          ],
          [
            'id' => 'passive_negative',
            'name' => 'Passive Negative: is/am/are not + Verb 3',
            'code' => '1.4.4',
            'concept_title' => 'Kalimat Pasif Negatif dengan is/are not + Verb 3',
            'concept_description' => 'Kalimat pasif negatif digunakan ketika subjek DIKENAI suatu tindakan (bukan melakukan tindakan), dan tindakan itu tidak terjadi. Polanya sama dengan nominal negatif (\'to be\' + not), tetapi diikuti oleh Verb 3 (past participle), bukan kata sifat biasa.',
            'formula' => 'Subject + IS / ARE NOT + Verb 3 (Past Participle) + (Keterangan / by Pelaku)',
            'rules' => [
              'Gunakan \'is not\' untuk subjek tunggal, \'are not\' untuk subjek jamak.',
              'Kata kerja setelah \'to be not\' WAJIB berbentuk Verb 3 (past participle), contoh: closed, finished, written.',
              'Jangan gunakan do/does pada kalimat pasif.',
            ],
            'exercises' => [
              [
                'id' => 31,
                'id_sentence' => 'Jendela itu tidak tertutup.',
                'target_word' => 'is not closed',
                'vocab' => [
                  'window' => ['id' => 'jendela', 'pos' => '(n)'],
                  'close' => ['id' => 'menutup', 'pos' => '(v)'],
                ],
                'options' => [
                  'The window is not closed.',
                  'The window do not closed.',
                  'The window are not closed.',
                  'The window is not close.',
                ],
                'correct_index' => 0,
                'explanation' => '\'The window\' tunggal, memakai \'is not\' + V3 \'closed\'.',
              ],
              [
                'id' => 32,
                'id_sentence' => 'Pekerjaan rumah saya belum selesai.',
                'target_word' => 'is not finished',
                'vocab' => [
                  'homework' => ['id' => 'pekerjaan rumah', 'pos' => '(n)'],
                  'finish' => ['id' => 'menyelesaikan', 'pos' => '(v)'],
                  'yet' => ['id' => 'belum', 'pos' => '(adv)'],
                ],
                'options' => [
                  'My homework is not finished yet.',
                  'My homework do not finished yet.',
                  'My homework are not finished yet.',
                  'My homework is not finish yet.',
                ],
                'correct_index' => 0,
                'explanation' => '\'My homework\' tunggal, memakai \'is not\' + V3 \'finished\'.',
              ],
              [
                'id' => 33,
                'id_sentence' => 'Surat-surat itu belum ditulis.',
                'target_word' => 'are not written',
                'vocab' => [
                  'letters' => ['id' => 'surat-surat', 'pos' => '(n)'],
                  'write' => ['id' => 'menulis', 'pos' => '(v)'],
                ],
                'options' => [
                  'The letters are not written yet.',
                  'The letters do not written yet.',
                  'The letters is not written yet.',
                  'The letters are not write yet.',
                ],
                'correct_index' => 0,
                'explanation' => '\'The letters\' jamak, memakai \'are not\' + V3 \'written\'.',
              ],
              [
                'id' => 34,
                'id_sentence' => 'Makan malam belum dimasak.',
                'target_word' => 'is not cooked',
                'vocab' => [
                  'dinner' => ['id' => 'makan malam', 'pos' => '(n)'],
                  'cook' => ['id' => 'memasak', 'pos' => '(v)'],
                ],
                'options' => [
                  'Dinner is not cooked yet.',
                  'Dinner do not cooked yet.',
                  'Dinner are not cooked yet.',
                  'Dinner is not cook yet.',
                ],
                'correct_index' => 0,
                'explanation' => '\'Dinner\' tunggal/tak terhitung, memakai \'is not\' + V3 \'cooked\'.',
              ],
              [
                'id' => 35,
                'id_sentence' => 'Mobil itu tidak diparkir di sini.',
                'target_word' => 'is not parked',
                'vocab' => [
                  'car' => ['id' => 'mobil', 'pos' => '(n)'],
                  'park' => ['id' => 'memarkir', 'pos' => '(v)'],
                ],
                'options' => [
                  'The car is not parked here.',
                  'The car do not parked here.',
                  'The car are not parked here.',
                  'The car is not park here.',
                ],
                'correct_index' => 0,
                'explanation' => '\'The car\' tunggal, memakai \'is not\' + V3 \'parked\'.',
              ],
              [
                'id' => 36,
                'id_sentence' => 'Pintu-pintu itu tidak dikunci pada siang hari.',
                'target_word' => 'are not locked',
                'vocab' => [
                  'doors' => ['id' => 'pintu-pintu', 'pos' => '(n)'],
                  'lock' => ['id' => 'mengunci', 'pos' => '(v)'],
                ],
                'options' => [
                  'The doors are not locked during the day.',
                  'The doors do not locked during the day.',
                  'The doors is not locked during the day.',
                  'The doors are not lock during the day.',
                ],
                'correct_index' => 0,
                'explanation' => '\'The doors\' jamak, memakai \'are not\' + V3 \'locked\'.',
              ],
              [
                'id' => 37,
                'id_sentence' => 'Pakaian itu belum dicuci.',
                'target_word' => 'is not washed',
                'vocab' => [
                  'clothes' => ['id' => 'pakaian', 'pos' => '(n)'],
                  'wash' => ['id' => 'mencuci', 'pos' => '(v)'],
                ],
                'options' => [
                  'This clothing is not washed yet.',
                  'This clothing do not washed yet.',
                  'This clothing are not washed yet.',
                  'This clothing is not wash yet.',
                ],
                'correct_index' => 0,
                'explanation' => '\'This clothing\' tunggal, memakai \'is not\' + V3 \'washed\'.',
              ],
              [
                'id' => 38,
                'id_sentence' => 'Lampu-lampu itu tidak dimatikan setiap malam.',
                'target_word' => 'are not turned off',
                'vocab' => [
                  'lights' => ['id' => 'lampu-lampu', 'pos' => '(n)'],
                  'turn off' => ['id' => 'mematikan', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'The lights are not turned off every night.',
                  'The lights do not turned off every night.',
                  'The lights is not turned off every night.',
                  'The lights are not turn off every night.',
                ],
                'correct_index' => 0,
                'explanation' => '\'The lights\' jamak, memakai \'are not\' + V3 \'turned off\'.',
              ],
              [
                'id' => 39,
                'id_sentence' => 'Meja ini tidak dibuat dari kayu.',
                'target_word' => 'is not made',
                'vocab' => [
                  'table' => ['id' => 'meja', 'pos' => '(n)'],
                  'make' => ['id' => 'membuat', 'pos' => '(v)'],
                  'wood' => ['id' => 'kayu', 'pos' => '(n)'],
                ],
                'options' => [
                  'This table is not made of wood.',
                  'This table do not made of wood.',
                  'This table are not made of wood.',
                  'This table is not make of wood.',
                ],
                'correct_index' => 0,
                'explanation' => '\'This table\' tunggal, memakai \'is not\' + V3 \'made\'.',
              ],
              [
                'id' => 40,
                'id_sentence' => 'Kue itu tidak dipotong dengan rapi.',
                'target_word' => 'is not cut',
                'vocab' => [
                  'cake' => ['id' => 'kue', 'pos' => '(n)'],
                  'cut' => ['id' => 'memotong', 'pos' => '(v)'],
                  'neatly' => ['id' => 'dengan rapi', 'pos' => '(adv)'],
                ],
                'options' => [
                  'The cake is not cut neatly.',
                  'The cake do not cut neatly.',
                  'The cake are not cut neatly.',
                  'The cake is not cuts neatly.',
                ],
                'correct_index' => 0,
                'explanation' => '\'The cake\' tunggal, memakai \'is not\' + V3 \'cut\'.',
              ],
            ],
          ],
          [
            'id' => 'negative_opinions',
            'name' => 'Negating Opinions & Preferences: Menyatakan Ketidaksukaan & Ketidaksetujuan',
            'code' => '1.4.5',
            'concept_title' => 'Menggunakan Kalimat Negatif untuk Opini, Kesukaan, dan Persetujuan',
            'concept_description' => 'Selain fakta sederhana, kalimat negatif sangat sering dipakai untuk mengungkapkan hal yang TIDAK kita sukai, TIDAK kita setujui, atau TIDAK kita percayai. Pola tata bahasanya sama persis dengan negatif verbal biasa (do/does not + V1), hanya konteksnya berbeda: opini dan preferensi pribadi.',
            'formula' => 'Subject + DO/DOES NOT + (like / enjoy / agree / believe / trust) + Object',
            'rules' => [
              'Pola do/does not + V1 yang sama dipakai untuk menyatakan ketidaksukaan: do not like, does not enjoy.',
              'Kata kerja opini umum: like, enjoy, agree, believe, trust, prefer.',
              'Subjek tunggal tetap memakai \'does not\', subjek jamak memakai \'do not\'.',
            ],
            'exercises' => [
              [
                'id' => 41,
                'id_sentence' => 'Saya tidak suka makanan pedas.',
                'target_word' => 'do not like',
                'vocab' => [
                  'spicy food' => ['id' => 'makanan pedas', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'I do not like spicy food.',
                  'I does not like spicy food.',
                  'I am not like spicy food.',
                  'I do not likes spicy food.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek \'I\' memakai \'do not\' + V1 \'like\'.',
              ],
              [
                'id' => 42,
                'id_sentence' => 'Dia (perempuan) tidak suka musik keras.',
                'target_word' => 'does not enjoy',
                'vocab' => [
                  'enjoy' => ['id' => 'menikmati', 'pos' => '(v)'],
                  'loud music' => ['id' => 'musik keras', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'She does not enjoy loud music.',
                  'She do not enjoy loud music.',
                  'She is not enjoy loud music.',
                  'She does not enjoys loud music.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'She\' memakai \'does not\' + V1 \'enjoy\'.',
              ],
              [
                'id' => 43,
                'id_sentence' => 'Kami tidak setuju dengan rencana itu.',
                'target_word' => 'do not agree',
                'vocab' => [
                  'agree' => ['id' => 'setuju', 'pos' => '(v)'],
                  'plan' => ['id' => 'rencana', 'pos' => '(n)'],
                ],
                'options' => [
                  'We do not agree with that plan.',
                  'We does not agree with that plan.',
                  'We are not agree with that plan.',
                  'We do not agrees with that plan.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'We\' memakai \'do not\' + V1 \'agree\'.',
              ],
              [
                'id' => 44,
                'id_sentence' => 'Ayah saya tidak percaya ramalan cuaca.',
                'target_word' => 'does not believe',
                'vocab' => [
                  'my father' => ['id' => 'ayah saya', 'pos' => '(n phr)'],
                  'believe' => ['id' => 'percaya', 'pos' => '(v)'],
                  'weather forecast' => ['id' => 'ramalan cuaca', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'My father does not believe the weather forecast.',
                  'My father do not believe the weather forecast.',
                  'My father is not believe the weather forecast.',
                  'My father does not believes the weather forecast.',
                ],
                'correct_index' => 0,
                'explanation' => '\'My father\' tunggal, memakai \'does not\' + V1 \'believe\'.',
              ],
              [
                'id' => 45,
                'id_sentence' => 'Mereka tidak lebih suka teh daripada kopi.',
                'target_word' => 'do not prefer',
                'vocab' => [
                  'prefer' => ['id' => 'lebih suka', 'pos' => '(v)'],
                  'tea' => ['id' => 'teh', 'pos' => '(n)'],
                ],
                'options' => [
                  'They do not prefer tea over coffee.',
                  'They does not prefer tea over coffee.',
                  'They are not prefer tea over coffee.',
                  'They do not prefers tea over coffee.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'They\' memakai \'do not\' + V1 \'prefer\'.',
              ],
              [
                'id' => 46,
                'id_sentence' => 'Saya tidak percaya cerita itu.',
                'target_word' => 'do not trust',
                'vocab' => [
                  'trust' => ['id' => 'percaya', 'pos' => '(v)'],
                  'story' => ['id' => 'cerita', 'pos' => '(n)'],
                ],
                'options' => [
                  'I do not trust that story.',
                  'I does not trust that story.',
                  'I am not trust that story.',
                  'I do not trusts that story.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek \'I\' memakai \'do not\' + V1 \'trust\'.',
              ],
              [
                'id' => 47,
                'id_sentence' => 'Kakak saya (perempuan) tidak suka bangun pagi.',
                'target_word' => 'does not like',
                'vocab' => [
                  'my sister' => ['id' => 'kakak saya (perempuan)', 'pos' => '(n phr)'],
                  'wake up early' => ['id' => 'bangun pagi', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'My sister does not like waking up early.',
                  'My sister do not like waking up early.',
                  'My sister is not like waking up early.',
                  'My sister does not likes waking up early.',
                ],
                'correct_index' => 0,
                'explanation' => '\'My sister\' tunggal, memakai \'does not\' + V1 \'like\'.',
              ],
              [
                'id' => 48,
                'id_sentence' => 'Kami tidak menikmati film horor.',
                'target_word' => 'do not enjoy',
                'vocab' => [
                  'horror movies' => ['id' => 'film horor', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'We do not enjoy horror movies.',
                  'We does not enjoy horror movies.',
                  'We are not enjoy horror movies.',
                  'We do not enjoys horror movies.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'We\' memakai \'do not\' + V1 \'enjoy\'.',
              ],
              [
                'id' => 49,
                'id_sentence' => 'Dia (laki-laki) tidak setuju dengan pendapat saya.',
                'target_word' => 'does not agree',
                'vocab' => [
                  'opinion' => ['id' => 'pendapat', 'pos' => '(n)'],
                ],
                'options' => [
                  'He does not agree with my opinion.',
                  'He do not agree with my opinion.',
                  'He is not agree with my opinion.',
                  'He does not agrees with my opinion.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'He\' memakai \'does not\' + V1 \'agree\'.',
              ],
              [
                'id' => 50,
                'id_sentence' => 'Teman-teman saya tidak suka bangun larut malam.',
                'target_word' => 'do not like',
                'vocab' => [
                  'staying up late' => ['id' => 'bangun larut malam', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'My friends do not like staying up late.',
                  'My friends does not like staying up late.',
                  'My friends are not like staying up late.',
                  'My friends do not likes staying up late.',
                ],
                'correct_index' => 0,
                'explanation' => '\'My friends\' jamak, memakai \'do not\' + V1 \'like\'.',
              ],
            ],
          ],
          [
            'id' => 'yes_no_questions',
            'name' => 'Yes/No Questions in Simple Present: Pertanyaan Ya/Tidak',
            'code' => '1.4.6',
            'concept_title' => 'Membentuk Pertanyaan Yes/No dalam Simple Present',
            'concept_description' => 'Pertanyaan Yes/No adalah pertanyaan yang jawabannya cukup "Yes" atau "No". Dalam Simple Present, bentuk pertanyaan ini dibuat dengan meletakkan auxiliary (Do/Does untuk kalimat verbal, Is/Are untuk kalimat nominal) di awal kalimat, sebelum subjek.',
            'formula' => 'Verbal: DOES/DO + Subject + V1 (Base Form) + Object...? | Nominal: IS/ARE + Subject + Complement...?',
            'rules' => [
              'Untuk kalimat verbal, letakkan Do/Does di awal, lalu subjek, lalu Verb 1 murni.',
              'Untuk kalimat nominal, letakkan Is/Are di awal, lalu subjek, lalu pelengkap.',
              'Subjek tunggal memakai Does/Is, subjek jamak memakai Do/Are.',
            ],
            'exercises' => [
              [
                'id' => 51,
                'id_sentence' => 'Apakah kamu suka teh?',
                'target_word' => 'Do you like',
                'vocab' => [
                  'tea' => ['id' => 'teh', 'pos' => '(n)'],
                ],
                'options' => [
                  'Do you like tea?',
                  'You do like tea?',
                  'Does you like tea?',
                  'Do you likes tea?',
                ],
                'correct_index' => 0,
                'explanation' => 'Pertanyaan Yes/No dengan subjek \'you\': \'Do\' diletakkan di awal kalimat.',
              ],
              [
                'id' => 52,
                'id_sentence' => 'Apakah dia (laki-laki) bermain sepak bola?',
                'target_word' => 'Does he play',
                'vocab' => [
                  'play' => ['id' => 'bermain', 'pos' => '(v)'],
                  'football' => ['id' => 'sepak bola', 'pos' => '(n)'],
                ],
                'options' => [
                  'Does he play football?',
                  'Do he play football?',
                  'He does play football?',
                  'Does he plays football?',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'he\' memakai \'Does\' di awal kalimat, diikuti V1 \'play\'.',
              ],
              [
                'id' => 53,
                'id_sentence' => 'Apakah dia (perempuan) seorang perawat?',
                'target_word' => 'Is she',
                'vocab' => [
                  'nurse' => ['id' => 'perawat', 'pos' => '(n)'],
                ],
                'options' => [
                  'Is she a nurse?',
                  'Does she a nurse?',
                  'She is a nurse?',
                  'Is she nurse?',
                ],
                'correct_index' => 0,
                'explanation' => 'Kalimat nominal memakai \'Is\' di awal untuk subjek tunggal \'she\'.',
              ],
              [
                'id' => 54,
                'id_sentence' => 'Apakah kalian sudah siap?',
                'target_word' => 'Are you ready',
                'vocab' => [
                  'ready' => ['id' => 'siap', 'pos' => '(adj)'],
                ],
                'options' => [
                  'Are you ready?',
                  'Do you ready?',
                  'You are ready?',
                  'Is you ready?',
                ],
                'correct_index' => 0,
                'explanation' => 'Kalimat nominal dengan subjek \'you\' memakai \'Are\' di awal kalimat.',
              ],
              [
                'id' => 55,
                'id_sentence' => 'Apakah orang tuamu tinggal di dekat sini?',
                'target_word' => 'Do your parents live',
                'vocab' => [
                  'live' => ['id' => 'tinggal', 'pos' => '(v)'],
                  'nearby' => ['id' => 'di dekat sini', 'pos' => '(adv)'],
                ],
                'options' => [
                  'Do your parents live nearby?',
                  'Does your parents live nearby?',
                  'Your parents do live nearby?',
                  'Do your parents lives nearby?',
                ],
                'correct_index' => 0,
                'explanation' => '\'Your parents\' jamak, memakai \'Do\' di awal kalimat.',
              ],
              [
                'id' => 56,
                'id_sentence' => 'Apakah restoran itu buka sekarang?',
                'target_word' => 'Is the restaurant open',
                'vocab' => [
                  'restaurant' => ['id' => 'restoran', 'pos' => '(n)'],
                  'open' => ['id' => 'buka', 'pos' => '(adj)'],
                ],
                'options' => [
                  'Is the restaurant open now?',
                  'Does the restaurant open now?',
                  'The restaurant is open now?',
                  'Are the restaurant open now?',
                ],
                'correct_index' => 0,
                'explanation' => '\'The restaurant\' tunggal, memakai \'Is\' di awal kalimat.',
              ],
              [
                'id' => 57,
                'id_sentence' => 'Apakah mereka bekerja pada hari Sabtu?',
                'target_word' => 'Do they work',
                'vocab' => [
                  'work' => ['id' => 'bekerja', 'pos' => '(v)'],
                  'on Saturdays' => ['id' => 'pada hari Sabtu', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'Do they work on Saturdays?',
                  'Does they work on Saturdays?',
                  'They do work on Saturdays?',
                  'Do they works on Saturdays?',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'they\' memakai \'Do\' di awal kalimat.',
              ],
              [
                'id' => 58,
                'id_sentence' => 'Apakah anjingmu suka berenang?',
                'target_word' => 'Does your dog like',
                'vocab' => [
                  'swim' => ['id' => 'berenang', 'pos' => '(v)'],
                ],
                'options' => [
                  'Does your dog like swimming?',
                  'Do your dog like swimming?',
                  'Your dog does like swimming?',
                  'Does your dog likes swimming?',
                ],
                'correct_index' => 0,
                'explanation' => '\'Your dog\' tunggal, memakai \'Does\' di awal kalimat.',
              ],
              [
                'id' => 59,
                'id_sentence' => 'Apakah kamu lapar?',
                'target_word' => 'Are you hungry',
                'vocab' => [
                  'hungry' => ['id' => 'lapar', 'pos' => '(adj)'],
                ],
                'options' => [
                  'Are you hungry?',
                  'Do you hungry?',
                  'You are hungry?',
                  'Is you hungry?',
                ],
                'correct_index' => 0,
                'explanation' => 'Kalimat nominal dengan subjek \'you\' memakai \'Are\' di awal kalimat.',
              ],
              [
                'id' => 60,
                'id_sentence' => 'Apakah kereta itu berangkat tepat waktu?',
                'target_word' => 'Does the train leave',
                'vocab' => [
                  'train' => ['id' => 'kereta', 'pos' => '(n)'],
                  'leave' => ['id' => 'berangkat', 'pos' => '(v)'],
                  'on time' => ['id' => 'tepat waktu', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'Does the train leave on time?',
                  'Do the train leave on time?',
                  'The train does leave on time?',
                  'Does the train leaves on time?',
                ],
                'correct_index' => 0,
                'explanation' => '\'The train\' tunggal, memakai \'Does\' di awal kalimat, diikuti V1 \'leave\'.',
              ],
            ],
          ],
          [
            'id' => 'wh_questions',
            'name' => 'WH-Questions in Simple Present: Pertanyaan dengan Kata Tanya',
            'code' => '1.4.7',
            'concept_title' => 'Membentuk Pertanyaan WH- dalam Simple Present',
            'concept_description' => 'Pertanyaan WH- dipakai untuk menanyakan informasi spesifik: What (apa), Where (di mana), When (kapan), Why (mengapa), How (bagaimana/berapa). Pola dasarnya: kata tanya diikuti auxiliary, lalu subjek, lalu kata kerja/pelengkap.',
            'formula' => 'Wh- Word (What/Where/When/Why/How) + DOES/DO/IS/ARE + Subject + V1/Complement...?',
            'rules' => [
              'Letakkan kata tanya di paling awal, diikuti auxiliary yang sesuai dengan subjek.',
              'Jangan lupa auxiliary tetap muncul meskipun sudah ada kata tanya.',
              'Subjek tunggal memakai does/is, subjek jamak memakai do/are.',
            ],
            'exercises' => [
              [
                'id' => 61,
                'id_sentence' => 'Apa yang biasa kamu lakukan setiap pagi?',
                'target_word' => 'What do you do',
                'vocab' => [
                  'every morning' => ['id' => 'setiap pagi', 'pos' => '(adv phr)'],
                ],
                'options' => [
                  'What do you do every morning?',
                  'What you do every morning?',
                  'What does you do every morning?',
                  'What do you does every morning?',
                ],
                'correct_index' => 0,
                'explanation' => '\'What\' + auxiliary \'do\' + subjek \'you\' + V1 \'do\'.',
              ],
              [
                'id' => 62,
                'id_sentence' => 'Di mana dia (perempuan) tinggal?',
                'target_word' => 'Where does she live',
                'vocab' => [
                  'live' => ['id' => 'tinggal', 'pos' => '(v)'],
                ],
                'options' => [
                  'Where does she live?',
                  'Where do she live?',
                  'Where she does live?',
                  'Where does she lives?',
                ],
                'correct_index' => 0,
                'explanation' => '\'Where\' + \'does\' (subjek tunggal \'she\') + V1 \'live\'.',
              ],
              [
                'id' => 63,
                'id_sentence' => 'Mengapa kamu terlambat?',
                'target_word' => 'Why are you late',
                'vocab' => [
                  'late' => ['id' => 'terlambat', 'pos' => '(adj)'],
                ],
                'options' => [
                  'Why are you late?',
                  'Why do you late?',
                  'Why you are late?',
                  'Why is you late?',
                ],
                'correct_index' => 0,
                'explanation' => 'Kalimat nominal, \'Why\' + \'are\' (subjek \'you\') + kata sifat \'late\'.',
              ],
              [
                'id' => 64,
                'id_sentence' => 'Berapa harga ini?',
                'target_word' => 'How much does this cost',
                'vocab' => [
                  'cost' => ['id' => 'berharga', 'pos' => '(v)'],
                ],
                'options' => [
                  'How much does this cost?',
                  'How much do this cost?',
                  'How much this does cost?',
                  'How much does this costs?',
                ],
                'correct_index' => 0,
                'explanation' => '\'How much\' + \'does\' (subjek tunggal \'this\') + V1 \'cost\'.',
              ],
              [
                'id' => 65,
                'id_sentence' => 'Kapan toko itu buka?',
                'target_word' => 'When does the shop open',
                'vocab' => [
                  'shop' => ['id' => 'toko', 'pos' => '(n)'],
                  'open' => ['id' => 'buka', 'pos' => '(v)'],
                ],
                'options' => [
                  'When does the shop open?',
                  'When do the shop open?',
                  'When the shop does open?',
                  'When does the shop opens?',
                ],
                'correct_index' => 0,
                'explanation' => '\'When\' + \'does\' (subjek tunggal \'the shop\') + V1 \'open\'.',
              ],
              [
                'id' => 66,
                'id_sentence' => 'Bagaimana mereka pergi ke sekolah?',
                'target_word' => 'How do they go',
                'vocab' => [
                  'go to school' => ['id' => 'pergi ke sekolah', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'How do they go to school?',
                  'How does they go to school?',
                  'How they do go to school?',
                  'How do they goes to school?',
                ],
                'correct_index' => 0,
                'explanation' => '\'How\' + \'do\' (subjek jamak \'they\') + V1 \'go\'.',
              ],
              [
                'id' => 67,
                'id_sentence' => 'Siapa guru favoritmu?',
                'target_word' => 'Who is your favorite',
                'vocab' => [
                  'favorite teacher' => ['id' => 'guru favorit', 'pos' => '(n phr)'],
                ],
                'options' => [
                  'Who is your favorite teacher?',
                  'Who does your favorite teacher?',
                  'Who your favorite teacher is?',
                  'Who are your favorite teacher?',
                ],
                'correct_index' => 0,
                'explanation' => 'Kalimat nominal, \'Who\' + \'is\' karena jawabannya tunggal (satu orang guru).',
              ],
              [
                'id' => 68,
                'id_sentence' => 'Mengapa anak-anak itu senang?',
                'target_word' => 'Why are the children happy',
                'vocab' => [
                  'happy' => ['id' => 'senang', 'pos' => '(adj)'],
                ],
                'options' => [
                  'Why are the children happy?',
                  'Why do the children happy?',
                  'Why the children are happy?',
                  'Why is the children happy?',
                ],
                'correct_index' => 0,
                'explanation' => '\'The children\' jamak, memakai \'are\' setelah \'Why\'.',
              ],
              [
                'id' => 69,
                'id_sentence' => 'Kapan kamu biasanya makan siang?',
                'target_word' => 'When do you usually',
                'vocab' => [
                  'have lunch' => ['id' => 'makan siang', 'pos' => '(v phr)'],
                  'usually' => ['id' => 'biasanya', 'pos' => '(adv)'],
                ],
                'options' => [
                  'When do you usually have lunch?',
                  'When does you usually have lunch?',
                  'When you do usually have lunch?',
                  'When do you usually has lunch?',
                ],
                'correct_index' => 0,
                'explanation' => '\'When\' + \'do\' (subjek \'you\') + V1 \'have\'.',
              ],
              [
                'id' => 70,
                'id_sentence' => 'Apa pekerjaan ayahmu?',
                'target_word' => 'What does your father do',
                'vocab' => [
                  'job' => ['id' => 'pekerjaan', 'pos' => '(n)'],
                ],
                'options' => [
                  'What does your father do?',
                  'What do your father do?',
                  'What your father does do?',
                  'What does your father does?',
                ],
                'correct_index' => 0,
                'explanation' => '\'What\' + \'does\' (subjek tunggal \'your father\') + V1 \'do\'.',
              ],
            ],
          ],
          [
            'id' => 'emphatic_affirmative',
            'name' => 'Emphatic Affirmative & Contrast: Penegasan dengan do/does',
            'code' => '1.4.8',
            'concept_title' => 'Menggunakan do/does untuk Penegasan (Emphatic Affirmative)',
            'concept_description' => 'Selain untuk membentuk kalimat negatif dan tanya, \'do/does\' juga bisa dipakai pada kalimat POSITIF untuk memberi penekanan (emphasis) — misalnya untuk membantah sesuatu atau menegaskan kontras. Pola ini sering muncul bersama klausa kontras dengan \'but\' atau \'although\'.',
            'formula' => 'Contrast Clause + Subject + DO / DOES + Verb 1 (Emphatic) + but/although Subject + DOES / DO NOT + Verb 1',
            'rules' => [
              'Pakai \'do/does\' sebelum kata kerja dasar untuk memberi penekanan pada kalimat positif.',
              'Pola ini sering dipakai untuk kontras: sesuatu yang tidak terjadi, tetapi hal lain terjadi.',
              'Subjek tunggal memakai \'does\', subjek jamak memakai \'do\', sama seperti pola negatif/tanya.',
            ],
            'exercises' => [
              [
                'id' => 71,
                'id_sentence' => 'Saya tidak suka kopi, tetapi saya memang suka teh.',
                'target_word' => 'do like',
                'vocab' => [
                  'coffee' => ['id' => 'kopi', 'pos' => '(n)'],
                  'tea' => ['id' => 'teh', 'pos' => '(n)'],
                ],
                'options' => [
                  'I do not like coffee, but I do like tea.',
                  'I do not like coffee, but I like tea.',
                  'I do not like coffee, but I am like tea.',
                  'I do not like coffee, but I likes tea.',
                ],
                'correct_index' => 0,
                'explanation' => 'Penegasan memakai \'do\' sebelum V1 \'like\' untuk menekankan kontras dengan klausa sebelumnya.',
              ],
              [
                'id' => 72,
                'id_sentence' => 'Dia (perempuan) jarang memasak, tetapi dia memang pandai memanggang.',
                'target_word' => 'does bake',
                'vocab' => [
                  'cook' => ['id' => 'memasak', 'pos' => '(v)'],
                  'bake well' => ['id' => 'pandai memanggang', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'She does not cook often, but she does bake well.',
                  'She does not cook often, but she bakes well.',
                  'She does not cook often, but she do bake well.',
                  'She does not cook often, but she is bake well.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'she\' memakai \'does\' untuk penegasan sebelum V1 \'bake\'.',
              ],
              [
                'id' => 73,
                'id_sentence' => 'Meskipun hujan, kami memang ingin keluar.',
                'target_word' => 'do want',
                'vocab' => [
                  'although' => ['id' => 'meskipun', 'pos' => '(conj)'],
                  'go out' => ['id' => 'keluar', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'Although it is raining, we do want to go out.',
                  'Although it is raining, we want to go out.',
                  'Although it is raining, we does want to go out.',
                  'Although it is raining, we are want to go out.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'we\' memakai \'do\' untuk penegasan sebelum V1 \'want\'.',
              ],
              [
                'id' => 74,
                'id_sentence' => 'Dia (laki-laki) tidak suka olahraga, tetapi dia memang suka berjalan kaki.',
                'target_word' => 'does like',
                'vocab' => [
                  'sports' => ['id' => 'olahraga', 'pos' => '(n)'],
                  'walking' => ['id' => 'berjalan kaki', 'pos' => '(n)'],
                ],
                'options' => [
                  'He does not like sports, but he does like walking.',
                  'He does not like sports, but he likes walking.',
                  'He does not like sports, but he do like walking.',
                  'He does not like sports, but he is like walking.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'he\' memakai \'does\' untuk penegasan sebelum V1 \'like\'.',
              ],
              [
                'id' => 75,
                'id_sentence' => 'Mereka jarang telepon, tetapi mereka memang menulis surat.',
                'target_word' => 'do write',
                'vocab' => [
                  'call' => ['id' => 'menelepon', 'pos' => '(v)'],
                  'write letters' => ['id' => 'menulis surat', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'They do not call often, but they do write letters.',
                  'They do not call often, but they write letters.',
                  'They do not call often, but they does write letters.',
                  'They do not call often, but they are write letters.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'they\' memakai \'do\' untuk penegasan sebelum V1 \'write\'.',
              ],
              [
                'id' => 76,
                'id_sentence' => 'Meskipun kecil, rumah ini memang terasa nyaman.',
                'target_word' => 'does feel',
                'vocab' => [
                  'small' => ['id' => 'kecil', 'pos' => '(adj)'],
                  'feel comfortable' => ['id' => 'terasa nyaman', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'Although it is small, this house does feel comfortable.',
                  'Although it is small, this house feels comfortable.',
                  'Although it is small, this house do feel comfortable.',
                  'Although it is small, this house is feel comfortable.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'this house\' memakai \'does\' untuk penegasan sebelum V1 \'feel\'.',
              ],
              [
                'id' => 77,
                'id_sentence' => 'Saya tidak sering berolahraga, tetapi saya memang berjalan setiap hari.',
                'target_word' => 'do walk',
                'vocab' => [
                  'exercise' => ['id' => 'berolahraga', 'pos' => '(v)'],
                  'walk' => ['id' => 'berjalan', 'pos' => '(v)'],
                ],
                'options' => [
                  'I do not exercise often, but I do walk every day.',
                  'I do not exercise often, but I walk every day.',
                  'I do not exercise often, but I does walk every day.',
                  'I do not exercise often, but I am walk every day.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek \'I\' memakai \'do\' untuk penegasan sebelum V1 \'walk\'.',
              ],
              [
                'id' => 78,
                'id_sentence' => 'Toko ini tidak besar, tetapi memang menjual barang berkualitas.',
                'target_word' => 'does sell',
                'vocab' => [
                  'big' => ['id' => 'besar', 'pos' => '(adj)'],
                  'sell quality goods' => ['id' => 'menjual barang berkualitas', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'This shop is not big, but it does sell quality goods.',
                  'This shop is not big, but it sells quality goods.',
                  'This shop is not big, but it do sell quality goods.',
                  'This shop is not big, but it is sell quality goods.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'it\' memakai \'does\' untuk penegasan sebelum V1 \'sell\'.',
              ],
              [
                'id' => 79,
                'id_sentence' => 'Anak-anak itu tidak banyak bicara, tetapi mereka memang mendengarkan dengan baik.',
                'target_word' => 'do listen',
                'vocab' => [
                  'talk much' => ['id' => 'banyak bicara', 'pos' => '(v phr)'],
                  'listen well' => ['id' => 'mendengarkan dengan baik', 'pos' => '(v phr)'],
                ],
                'options' => [
                  'The children do not talk much, but they do listen well.',
                  'The children do not talk much, but they listen well.',
                  'The children do not talk much, but they does listen well.',
                  'The children do not talk much, but they are listen well.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek jamak \'they\' memakai \'do\' untuk penegasan sebelum V1 \'listen\'.',
              ],
              [
                'id' => 80,
                'id_sentence' => 'Kakak saya (laki-laki) tidak suka membaca, tetapi dia memang suka menulis.',
                'target_word' => 'does like',
                'vocab' => [
                  'read' => ['id' => 'membaca', 'pos' => '(v)'],
                  'write' => ['id' => 'menulis', 'pos' => '(v)'],
                ],
                'options' => [
                  'My brother does not like reading, but he does like writing.',
                  'My brother does not like reading, but he likes writing.',
                  'My brother does not like reading, but he do like writing.',
                  'My brother does not like reading, but he is like writing.',
                ],
                'correct_index' => 0,
                'explanation' => 'Subjek tunggal \'he\' memakai \'does\' untuk penegasan sebelum V1 \'like\'.',
              ],
            ],
          ],
        ];
    }
}
