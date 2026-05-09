<?php

namespace App\Application\IeltsSpeaking;

class IeltsSpeakingFeedbackService
{
    public function grammarErrors(): array
    {
        return [
            [
                'original' => 'I am agree with you about this statement.',
                'correction' => 'I <span class="text-green-600 font-bold">agree</span> with you about this statement.',
                'explanation' => 'Jangan gunakan "am" dengan kata kerja "agree". "Agree" itu sendiri sudah merupakan kata kerja.'
            ],
            [
                'original' => 'She don\'t like to study in the morning.',
                'correction' => 'She <span class="text-green-600 font-bold">doesn\'t</span> like to study in the morning.',
                'explanation' => 'Untuk orang ketiga tunggal (she/he/it), gunakan "doesn\'t" bukan "don\'t".'
            ],
            [
                'original' => 'The informations are not correct.',
                'correction' => 'The <span class="text-green-600 font-bold">information is</span> not correct.',
                'explanation' => '"Information" adalah kata benda yang tidak dapat dihitung (uncountable) dan menggunakan kata kerja tunggal.'
            ],
            [
                'original' => 'I look forward to hear from you.',
                'correction' => 'I look forward to <span class="text-green-600 font-bold">hearing</span> from you.',
                'explanation' => 'Frasa "look forward to" harus diikuti oleh gerund (bentuk verb-ing).'
            ]
        ];
    }

    public function grammarUpgrades(array $transcripts, string $topic): array
    {
        $isWork = stripos(json_encode($transcripts), 'work') !== false || stripos($topic, 'work') !== false;
        $isStudy = stripos(json_encode($transcripts), 'study') !== false || stripos($topic, 'study') !== false;

        $questionsText = '';
        foreach ($transcripts as $transcript) {
            $questionsText .= strtolower($transcript['question'] ?? '') . ' ';
        }

        if (str_contains($questionsText, 'dislike')) {
            return [
                [
                    'type' => 'Adjective Clause',
                    'example' => 'The one thing, <span class="text-indigo-600 font-bold">which I truly dislike</span>, is the long commute.',
                    'explanation' => 'Gunakan kata ganti relatif untuk menambahkan detail spesifik tentang apa yang Anda tidak sukai.'
                ],
                [
                    'type' => 'Noun Clause',
                    'example' => 'I must admit <span class="text-indigo-600 font-bold">that I find the workload overwhelming</span> sometimes.',
                    'explanation' => 'Berfungsi sebagai objek dari kata "admit".'
                ],
                [
                    'type' => 'Noun Clause as Subject',
                    'example' => '<span class="text-indigo-600 font-bold">What bothers me the most</span> is the lack of flexibility.',
                    'explanation' => 'Menggunakan klausa kata benda sebagai subjek memungkinkan Anda untuk sangat fokus pada aspek negatif.'
                ],
                [
                    'type' => 'Gerund as Subject',
                    'example' => '<span class="text-indigo-600 font-bold">Dealing with difficult clients</span> is my least favorite part.',
                    'explanation' => 'Subjek gerund mengubah tindakan menjadi konsep yang dapat Anda diskusikan.'
                ],
                [
                    'type' => 'Adverbial Clause',
                    'example' => '<span class="text-indigo-600 font-bold">Although I love my job</span>, I dislike the mandatory overtime.',
                    'explanation' => 'Gunakan "although" untuk menyeimbangkan poin negatif dengan poin positif.'
                ]
            ];
        }

        if (str_contains($questionsText, 'future') || str_contains($questionsText, 'career')) {
            return [
                [
                    'type' => 'Adjective Clause',
                    'example' => 'The career path, <span class="text-indigo-600 font-bold">which I plan to pursue</span>, requires a masters degree.',
                    'explanation' => 'Menambahkan detail pada "career path".'
                ],
                [
                    'type' => 'Noun Clause',
                    'example' => 'I hope <span class="text-indigo-600 font-bold">that I can start my own business</span> one day.',
                    'explanation' => 'Berfungsi sebagai objek dari kata "hope".'
                ],
                [
                    'type' => 'Noun Clause as Subject',
                    'example' => '<span class="text-indigo-600 font-bold">What I aim to achieve</span> is financial independence.',
                    'explanation' => 'Cara yang kuat untuk menyatakan tujuan Anda.'
                ],
                [
                    'type' => 'Gerund as Subject',
                    'example' => '<span class="text-indigo-600 font-bold">Becoming a manager</span> is my primary long-term goal.',
                    'explanation' => 'Subjek gerund mendefinisikan tujuan dengan jelas.'
                ],
                [
                    'type' => 'Adverbial Clause',
                    'example' => '<span class="text-indigo-600 font-bold">When I have enough experience</span>, I will apply for a senior role.',
                    'explanation' => 'Gunakan "when" untuk menetapkan kondisi di masa depan.'
                ]
            ];
        }

        if ($isStudy) {
            return [
                [
                    'type' => 'Adjective Clause',
                    'example' => 'The university, <span class="text-indigo-600 font-bold">which is located downtown</span>, has excellent facilities.',
                    'explanation' => 'Gunakan kata ganti relatif (who, which, that) untuk menambahkan informasi penting atau tambahan tentang kata benda (university).'
                ],
                [
                    'type' => 'Noun Clause',
                    'example' => 'I believe <span class="text-indigo-600 font-bold">that education is the key to success</span>.',
                    'explanation' => 'Klausa kata benda berfungsi sebagai objek dari "believe".'
                ],
                [
                    'type' => 'Noun Clause as Subject',
                    'example' => '<span class="text-indigo-600 font-bold">What I need to focus on</span> is my time management.',
                    'explanation' => 'Menggunakan klausa kata benda sebagai subjek ("What I need...") menciptakan penekanan yang kuat.'
                ],
                [
                    'type' => 'Gerund as Subject',
                    'example' => '<span class="text-indigo-600 font-bold">Studying for exams</span> requires a lot of discipline.',
                    'explanation' => 'Menggunakan verb+ing (gerund) sebagai subjek membuat bicara Anda lebih formal.'
                ],
                [
                    'type' => 'Adverbial Clause',
                    'example' => '<span class="text-indigo-600 font-bold">Although the assignment was tough</span>, I finished it on time.',
                    'explanation' => 'Gunakan konjungsi subordinatif untuk menunjukkan kontras.'
                ]
            ];
        }

        if ($isWork) {
            return [
                [
                    'type' => 'Adjective Clause',
                    'example' => 'My colleague, <span class="text-indigo-600 font-bold">who sits next to me</span>, is very helpful.',
                    'explanation' => 'Gunakan kata ganti relatif untuk menambahkan detail tentang seseorang (rekan kerja).'
                ],
                [
                    'type' => 'Noun Clause',
                    'example' => 'My boss mentioned <span class="text-indigo-600 font-bold">that we need to improve our sales</span>.',
                    'explanation' => 'Berfungsi sebagai objek langsung dari "mentioned".'
                ],
                [
                    'type' => 'Noun Clause as Subject',
                    'example' => '<span class="text-indigo-600 font-bold">What matters most</span> is the quality of our work.',
                    'explanation' => 'Menempatkan klausa kata benda di awal menekankan poin utama.'
                ],
                [
                    'type' => 'Gerund as Subject',
                    'example' => '<span class="text-indigo-600 font-bold">Working in a team</span> improves communication skills.',
                    'explanation' => 'Menggunakan subjek gerund menunjukkan tata bahasa tingkat tinggi.'
                ],
                [
                    'type' => 'Adverbial Clause',
                    'example' => '<span class="text-indigo-600 font-bold">Because the deadline is tight</span>, we have to work overtime.',
                    'explanation' => 'Gunakan "because" untuk menunjukkan sebab dan akibat.'
                ]
            ];
        }

        return [
            [
                'type' => 'Adjective Clause',
                'example' => 'The decision, <span class="text-indigo-600 font-bold">which I made yesterday</span>, was the right one.',
                'explanation' => 'Menambahkan informasi tambahan tentang "decision".'
            ],
            [
                'type' => 'Noun Clause',
                'example' => 'I realized <span class="text-indigo-600 font-bold">that honesty is important</span>.',
                'explanation' => 'Berfungsi sebagai objek dari "realized".'
            ],
            [
                'type' => 'Noun Clause as Subject',
                'example' => '<span class="text-indigo-600 font-bold">What surprises me</span> is how quickly technology changes.',
                'explanation' => 'Klausa kata benda subjek membuat pendapat Anda terdengar lebih bijaksana.'
            ],
            [
                'type' => 'Gerund as Subject',
                'example' => '<span class="text-indigo-600 font-bold">Travelling alone</span> helps you grow as a person.',
                'explanation' => 'Subjek gerund menciptakan pernyataan umum yang kuat.'
            ],
            [
                'type' => 'Adverbial Clause',
                'example' => '<span class="text-indigo-600 font-bold">While I enjoy relaxing</span>, I also like to stay active.',
                'explanation' => 'Gunakan "while" untuk menunjukkan kontras atau tindakan serentak.'
            ]
        ];
    }

    public function modelAnswers(array $transcripts): array
    {
        $modelAnswers = [];

        foreach ($transcripts as $item) {
            $question = $item['question'] ?? 'Unknown Question';

            $answer = 'Currently, I am working as a software engineer at a tech startup. I find it incredibly rewarding because I get to solve complex problems every day. The fast-paced environment keeps me on my toes, and I\'m constantly learning new technologies.';

            if (stripos($question, 'student') !== false) {
                $answer = 'I am currently a full-time student majoring in Computer Science. I chose this field because I have always been fascinated by technology and how it shapes our world. My studies are quite demanding, but I enjoy the challenge.';
            } elseif (stripos($question, 'dislike') !== false) {
                $answer = 'To be honest, the only downside is the long commute. Spending two hours in traffic every day can be quite draining, and I wish I could use that time more productively. However, apart from that, I thoroughly enjoy my daily routine.';
            } elseif (stripos($question, 'future') !== false) {
                $answer = 'In the future, I aspire to become a lead architect in my field. I plan to pursue a master\'s degree to deepen my specialized knowledge and eventually lead innovative projects that can have a positive impact on society.';
            }

            $modelAnswers[] = [
                'question' => $question,
                'answer' => $answer,
                'highlight' => 'Band 9 Vocabulary: <strong>rewarding, fast-paced, fascinated, demanding, draining, aspire, innovative</strong>'
            ];
        }

        return $modelAnswers;
    }

    public function pronunciationAnalysis(): array
    {
        return [
            'categories' => [
                [
                    'name' => 'Clarity (Kejelasan)',
                    'score' => 85,
                    'feedback' => 'Sebagian besar kata diartikulasikan dengan jelas. Namun, beberapa suara konsonan akhir terdengar kurang jelas (tertelan).',
                    'color' => 'blue'
                ],
                [
                    'name' => 'Word Stress (Penekanan kata)',
                    'score' => 70,
                    'feedback' => 'Anda cenderung menekan suku kata pertama bahkan pada kata bersuku kata banyak yang seharusnya menekan suku kata kedua (contoh: "tech-NO-lo-gy" bukannya "tech-no-LO-gy").',
                    'color' => 'indigo'
                ],
                [
                    'name' => 'Sentence Stress & Intonation',
                    'score' => 65,
                    'feedback' => 'Bicara Anda agak datar (monoton). Cobalah untuk lebih menekankan kata-kata isi (kata benda, kata kerja) daripada kata-kata fungsi.',
                    'color' => 'purple'
                ],
                [
                    'name' => 'Connected Speech (Pengucapan natural)',
                    'score' => 75,
                    'feedback' => 'Usaha yang bagus dalam menghubungkan kata. Cobalah gunakan bentuk lemah (weak forms) untuk kata-kata seperti "and", "to", dan "for" agar terdengar lebih fasih.',
                    'color' => 'emerald'
                ]
            ],
            'mispronounced_words' => [
                [
                    'word' => 'technology',
                    'phonetic' => '/tekˈnɒlədʒi/',
                    'user_phonetic' => '/tekˈnɒdʒi/',
                    'accuracy' => 85,
                    'issue' => 'Stress placed incorrectly.'
                ],
                [
                    'word' => 'environment',
                    'phonetic' => '/ɪnˈvaɪrənmənt/',
                    'user_phonetic' => '/ɪnˈvaɪəmənt/',
                    'accuracy' => 80,
                    'issue' => 'Missing "r" sound linking.'
                ]
            ]
        ];
    }

    public function fluencyAnalysis(): array
    {
        return [
            'score' => 6.0,
            'errors' => [
                [
                    'type' => 'Pause',
                    'detail' => 'Jeda panjang (sekitar 3 detik) sebelum menjawab pertanyaan tentang "future plans".',
                    'time' => '00:45'
                ],
                [
                    'type' => 'Repetition',
                    'detail' => 'Pengulangan kata "I think... I think" saat menjelaskan alasan.',
                    'time' => '01:12'
                ],
                [
                    'type' => 'Self-correction',
                    'detail' => 'Koreksi diri: "I go... I went to the market."',
                    'time' => '02:05'
                ]
            ],
            'descriptor_feedback' => [
                [
                    'point' => 'Willing to speak at length',
                    'description' => 'Anda bersedia berbicara panjang lebar, meskipun kadang kehilangan koherensi karena pengulangan atau koreksi diri.',
                    'status' => 'positive'
                ],
                [
                    'point' => 'Use of connectives',
                    'description' => 'Anda menggunakan berbagai kata penghubung dan penanda wacana, namun tidak selalu tepat.',
                    'status' => 'mixed'
                ],
                [
                    'point' => 'Hesitation',
                    'description' => 'Ada keragu-raguan yang nyata saat mencari kata atau struktur kalimat yang tepat.',
                    'status' => 'negative'
                ]
            ]
        ];
    }
}
