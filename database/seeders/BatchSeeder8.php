<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BatchSeeder8 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $topics = [38, 39, 40, 41, 42];
        DB::table('grammar_topic_questions')->whereIn('grammar_topic_id', $topics)->delete();

        $data = [];

        // Topic 38: Conditional Sentence
        $topic38_sentences = [
            [
                "question_id" => "Jika kamu <strong>belajar lebih giat</strong>, kamu akan lulus ujian.",
                "answer_en" => "If you study harder, you will pass the exam.",
                "vocab_helper" => "['study' => 'belajar', 'harder' => 'lebih giat', 'pass' => 'lulus', 'exam' => 'ujian']"
            ],
            [
                "question_id" => "Saya <strong>akan membeli</strong> mobil itu jika saya punya cukup uang.",
                "answer_en" => "I would buy that car if I had enough money.",
                "vocab_helper" => "['buy' => 'membeli', 'car' => 'mobil', 'enough' => 'cukup', 'money' => 'uang']"
            ],
            [
                "question_id" => "Jika dia <strong>telah menelepon</strong> saya, saya akan membantunya.",
                "answer_en" => "If he had called me, I would have helped him.",
                "vocab_helper" => "['call' => 'menelepon', 'help' => 'membantu']"
            ],
            [
                "question_id" => "Kamu <strong>tidak akan terlambat</strong> jika kamu bangun lebih awal.",
                "answer_en" => "You wouldn't be late if you woke up earlier.",
                "vocab_helper" => "['late' => 'terlambat', 'wake up' => 'bangun', 'earlier' => 'lebih awal']"
            ],
            [
                "question_id" => "Jika hari hujan, kita <strong>akan tinggal</strong> di rumah.",
                "answer_en" => "If it rains, we will stay at home.",
                "vocab_helper" => "['rain' => 'hujan', 'stay' => 'tinggal', 'home' => 'rumah']"
            ],
            [
                "question_id" => "Jika kamu <strong>memanaskan</strong> es, itu mencair.",
                "answer_en" => "If you heat ice, it melts.",
                "vocab_helper" => "['heat' => 'memanaskan', 'ice' => 'es', 'melt' => 'mencair']"
            ],
            [
                "question_id" => "Saya akan <strong>mengunjungi</strong> kamu jika saya datang ke kotamu.",
                "answer_en" => "I will visit you if I come to your city.",
                "vocab_helper" => "['visit' => 'mengunjungi', 'come' => 'datang', 'city' => 'kota']"
            ],
            [
                "question_id" => "Jika saya <strong>menjadi</strong> kamu, saya akan menerima tawaran itu.",
                "answer_en" => "If I were you, I would accept the offer.",
                "vocab_helper" => "['accept' => 'menerima', 'offer' => 'tawaran']"
            ],
            [
                "question_id" => "Kita akan <strong>menang</strong> jika kita bermain lebih baik.",
                "answer_en" => "We would have won if we had played better.",
                "vocab_helper" => "['win' => 'menang', 'play' => 'bermain', 'better' => 'lebih baik']"
            ],
            [
                "question_id" => "Jika mereka <strong>tidak datang</strong>, kita akan pergi tanpa mereka.",
                "answer_en" => "If they don't come, we will go without them.",
                "vocab_helper" => "['come' => 'datang', 'go' => 'pergi', 'without' => 'tanpa']"
            ],
            [
                "question_id" => "Apa yang <strong>akan kamu lakukan</strong> jika kamu memenangkan lotre?",
                "answer_en" => "What would you do if you won the lottery?",
                "vocab_helper" => "['do' => 'melakukan', 'win' => 'memenangkan', 'lottery' => 'lotre']"
            ],
            [
                "question_id" => "Jika dia <strong>tahu</strong> yang sebenarnya, dia akan marah.",
                "answer_en" => "If she knew the truth, she would be angry.",
                "vocab_helper" => "['know' => 'tahu', 'truth' => 'kebenaran', 'angry' => 'marah']"
            ],
            [
                "question_id" => "Saya tidak akan <strong>melakukan</strong> itu jika saya jadi dia.",
                "answer_en" => "I wouldn't do that if I were him.",
                "vocab_helper" => "['do' => 'melakukan', 'that' => 'itu']"
            ],
            [
                "question_id" => "Jika kamu <strong>berbicara</strong> lebih keras, saya bisa mendengarmu.",
                "answer_en" => "If you speak louder, I can hear you.",
                "vocab_helper" => "['speak' => 'berbicara', 'louder' => 'lebih keras', 'hear' => 'mendengar']"
            ],
            [
                "question_id" => "Mereka tidak akan <strong>tersesat</strong> jika mereka membawa peta.",
                "answer_en" => "They wouldn't have gotten lost if they had brought a map.",
                "vocab_helper" => "['get lost' => 'tersesat', 'bring' => 'membawa', 'map' => 'peta']"
            ],
            [
                "question_id" => "Jika air <strong>mendidih</strong>, ia berubah menjadi uap.",
                "answer_en" => "If water boils, it turns into steam.",
                "vocab_helper" => "['water' => 'air', 'boil' => 'mendidih', 'turn into' => 'berubah menjadi', 'steam' => 'uap']"
            ],
            [
                "question_id" => "Jika kamu <strong>tidak cepat</strong>, kamu akan ketinggalan kereta.",
                "answer_en" => "If you don't hurry, you will miss the train.",
                "vocab_helper" => "['hurry' => 'cepat', 'miss' => 'ketinggalan', 'train' => 'kereta']"
            ],
            [
                "question_id" => "Dia <strong>akan senang</strong> jika kamu mengundangnya.",
                "answer_en" => "She would be happy if you invited her.",
                "vocab_helper" => "['happy' => 'senang', 'invite' => 'mengundang']"
            ],
            [
                "question_id" => "Saya akan <strong>memberitahumu</strong> jika saya mendengar kabar.",
                "answer_en" => "I will tell you if I hear any news.",
                "vocab_helper" => "['tell' => 'memberitahu', 'hear' => 'mendengar', 'news' => 'kabar/berita']"
            ],
            [
                "question_id" => "Jika dia <strong>belajar</strong>, dia tidak akan gagal.",
                "answer_en" => "If he had studied, he wouldn't have failed.",
                "vocab_helper" => "['study' => 'belajar', 'fail' => 'gagal']"
            ],
            [
                "question_id" => "Jika saya tahu bahwa itu penting, saya <strong>akan segera mengerjakannya</strong>, tetapi saya baru tahu hari ini. Saya akan menyelesaikannya jika saya memiliki lebih banyak waktu, dan jika manajer bertanya, saya akan menjelaskannya padanya.",
                "answer_en" => "If I had known that it was important, I would have worked on it immediately, but I just found out today. I would finish it if I had more time, and if the manager asks, I will explain it to him.",
                "vocab_helper" => "['known' => 'tahu', 'important' => 'penting', 'immediately' => 'segera', 'find out' => 'baru tahu', 'finish' => 'menyelesaikan', 'manager' => 'manajer', 'explain' => 'menjelaskan']"
            ]
        ];

        foreach ($topic38_sentences as $index => $item) {
            $data[] = [
                'grammar_topic_id' => 38,
                'type' => ($index == 20) ? 'paragraph' : 'sentence',
                'question_id' => $item['question_id'],
                'answer_en' => $item['answer_en'],
                'vocab_helper' => $item['vocab_helper'],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        // Topic 39: Gerunds
        $topic39_sentences = [
            [
                "question_id" => "<strong>Berenang</strong> adalah olahraga favorit saya.",
                "answer_en" => "Swimming is my favorite sport.",
                "vocab_helper" => "['swim' => 'berenang', 'favorite' => 'favorit', 'sport' => 'olahraga']"
            ],
            [
                "question_id" => "Saya menikmati <strong>membaca</strong> buku di waktu luang saya.",
                "answer_en" => "I enjoy reading books in my free time.",
                "vocab_helper" => "['enjoy' => 'menikmati', 'read' => 'membaca', 'free time' => 'waktu luang']"
            ],
            [
                "question_id" => "Dia menyarankan <strong>pergi</strong> ke pantai akhir pekan ini.",
                "answer_en" => "He suggested going to the beach this weekend.",
                "vocab_helper" => "['suggest' => 'menyarankan', 'go' => 'pergi', 'beach' => 'pantai', 'weekend' => 'akhir pekan']"
            ],
            [
                "question_id" => "<strong>Merokok</strong> tidak baik untuk kesehatanmu.",
                "answer_en" => "Smoking is not good for your health.",
                "vocab_helper" => "['smoke' => 'merokok', 'good' => 'baik', 'health' => 'kesehatan']"
            ],
            [
                "question_id" => "Mereka menghindari <strong>membicarakan</strong> masalah tersebut.",
                "answer_en" => "They avoided discussing the problem.",
                "vocab_helper" => "['avoid' => 'menghindari', 'discuss' => 'membicarakan', 'problem' => 'masalah']"
            ],
            [
                "question_id" => "Saya tidak keberatan <strong>menunggu</strong> beberapa menit.",
                "answer_en" => "I don't mind waiting a few minutes.",
                "vocab_helper" => "['mind' => 'keberatan', 'wait' => 'menunggu', 'few' => 'beberapa', 'minutes' => 'menit']"
            ],
            [
                "question_id" => "Terima kasih atas <strong>membantu</strong> saya dengan proyek ini.",
                "answer_en" => "Thank you for helping me with this project.",
                "vocab_helper" => "['thank you' => 'terima kasih', 'help' => 'membantu', 'project' => 'proyek']"
            ],
            [
                "question_id" => "Dia pandai <strong>melukis</strong> pemandangan.",
                "answer_en" => "She is good at painting landscapes.",
                "vocab_helper" => "['good at' => 'pandai', 'paint' => 'melukis', 'landscape' => 'pemandangan']"
            ],
            [
                "question_id" => "Kami sedang mempertimbangkan <strong>pindah</strong> ke kota lain.",
                "answer_en" => "We are considering moving to another city.",
                "vocab_helper" => "['consider' => 'mempertimbangkan', 'move' => 'pindah', 'another' => 'lain', 'city' => 'kota']"
            ],
            [
                "question_id" => "<strong>Belajar</strong> bahasa baru membutuhkan waktu.",
                "answer_en" => "Learning a new language takes time.",
                "vocab_helper" => "['learn' => 'belajar', 'new' => 'baru', 'language' => 'bahasa', 'take time' => 'membutuhkan waktu']"
            ],
            [
                "question_id" => "Saya rindu <strong>bertemu</strong> teman-teman saya.",
                "answer_en" => "I miss seeing my friends.",
                "vocab_helper" => "['miss' => 'rindu', 'see' => 'bertemu/melihat', 'friends' => 'teman-teman']"
            ],
            [
                "question_id" => "Apakah kamu keberatan <strong>membuka</strong> jendela?",
                "answer_en" => "Do you mind opening the window?",
                "vocab_helper" => "['mind' => 'keberatan', 'open' => 'membuka', 'window' => 'jendela']"
            ],
            [
                "question_id" => "Dia menyerah <strong>berusaha</strong> untuk menang.",
                "answer_en" => "He gave up trying to win.",
                "vocab_helper" => "['give up' => 'menyerah', 'try' => 'berusaha', 'win' => 'menang']"
            ],
            [
                "question_id" => "<strong>Berjalan kaki</strong> adalah cara yang baik untuk tetap sehat.",
                "answer_en" => "Walking is a good way to stay healthy.",
                "vocab_helper" => "['walk' => 'berjalan kaki', 'way' => 'cara', 'stay' => 'tetap', 'healthy' => 'sehat']"
            ],
            [
                "question_id" => "Mereka terus <strong>berbicara</strong> selama film berlangsung.",
                "answer_en" => "They kept talking during the movie.",
                "vocab_helper" => "['keep' => 'terus', 'talk' => 'berbicara', 'during' => 'selama', 'movie' => 'film']"
            ],
            [
                "question_id" => "Saya menantikan <strong>bertemu</strong> denganmu lagi.",
                "answer_en" => "I look forward to meeting you again.",
                "vocab_helper" => "['look forward to' => 'menantikan', 'meet' => 'bertemu', 'again' => 'lagi']"
            ],
            [
                "question_id" => "<strong>Menulis</strong> adalah hasratnya.",
                "answer_en" => "Writing is her passion.",
                "vocab_helper" => "['write' => 'menulis', 'passion' => 'hasrat']"
            ],
            [
                "question_id" => "Dia meminta maaf karena <strong>terlambat</strong>.",
                "answer_en" => "He apologized for being late.",
                "vocab_helper" => "['apologize' => 'meminta maaf', 'late' => 'terlambat']"
            ],
            [
                "question_id" => "Mereka menunda <strong>membuat</strong> keputusan.",
                "answer_en" => "They postponed making a decision.",
                "vocab_helper" => "['postpone' => 'menunda', 'make' => 'membuat', 'decision' => 'keputusan']"
            ],
            [
                "question_id" => "<strong>Memasak</strong> bisa sangat menyenangkan jika kamu tahu caranya.",
                "answer_en" => "Cooking can be very fun if you know how.",
                "vocab_helper" => "['cook' => 'memasak', 'fun' => 'menyenangkan', 'know' => 'tahu', 'how' => 'caranya']"
            ],
            [
                "question_id" => "<strong>Berlari</strong> setiap pagi membantu saya tetap sehat, dan saya menikmati <strong>mendengarkan</strong> musik sambil berolahraga. Saya menantikan <strong>bergabung</strong> dengan maraton bulan depan, karena <strong>berlatih</strong> keras telah menjadi rutinitas harian saya.",
                "answer_en" => "Running every morning helps me stay healthy, and I enjoy listening to music while exercising. I look forward to joining the marathon next month, because training hard has become my daily routine.",
                "vocab_helper" => "['run' => 'berlari', 'morning' => 'pagi', 'enjoy' => 'menikmati', 'listen' => 'mendengarkan', 'exercise' => 'berolahraga', 'look forward to' => 'menantikan', 'join' => 'bergabung', 'train' => 'berlatih', 'routine' => 'rutinitas']"
            ]
        ];

        foreach ($topic39_sentences as $index => $item) {
            $data[] = [
                'grammar_topic_id' => 39,
                'type' => ($index == 20) ? 'paragraph' : 'sentence',
                'question_id' => $item['question_id'],
                'answer_en' => $item['answer_en'],
                'vocab_helper' => $item['vocab_helper'],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        // Topic 40: To Infinitives
        $topic40_sentences = [
            [
                "question_id" => "Saya ingin <strong>pergi</strong> ke bioskop malam ini.",
                "answer_en" => "I want to go to the cinema tonight.",
                "vocab_helper" => "['want' => 'ingin', 'go' => 'pergi', 'cinema' => 'bioskop', 'tonight' => 'malam ini']"
            ],
            [
                "question_id" => "Dia berjanji <strong>untuk membantu</strong> saya mengerjakan PR.",
                "answer_en" => "She promised to help me with my homework.",
                "vocab_helper" => "['promise' => 'berjanji', 'help' => 'membantu', 'homework' => 'PR']"
            ],
            [
                "question_id" => "Penting <strong>untuk belajar</strong> dari kesalahanmu.",
                "answer_en" => "It is important to learn from your mistakes.",
                "vocab_helper" => "['important' => 'penting', 'learn' => 'belajar', 'mistake' => 'kesalahan']"
            ],
            [
                "question_id" => "Mereka memutuskan <strong>untuk membeli</strong> sebuah rumah baru.",
                "answer_en" => "They decided to buy a new house.",
                "vocab_helper" => "['decide' => 'memutuskan', 'buy' => 'membeli', 'new' => 'baru', 'house' => 'rumah']"
            ],
            [
                "question_id" => "Saya lupa <strong>membawa</strong> payung saya.",
                "answer_en" => "I forgot to bring my umbrella.",
                "vocab_helper" => "['forget' => 'lupa', 'bring' => 'membawa', 'umbrella' => 'payung']"
            ],
            [
                "question_id" => "Dia mencoba <strong>untuk membuka</strong> pintu, tetapi terkunci.",
                "answer_en" => "He tried to open the door, but it was locked.",
                "vocab_helper" => "['try' => 'mencoba', 'open' => 'membuka', 'door' => 'pintu', 'locked' => 'terkunci']"
            ],
            [
                "question_id" => "Kami berencana <strong>untuk mengunjungi</strong> Paris tahun depan.",
                "answer_en" => "We plan to visit Paris next year.",
                "vocab_helper" => "['plan' => 'berencana', 'visit' => 'mengunjungi', 'next year' => 'tahun depan']"
            ],
            [
                "question_id" => "Sangat menyenangkan <strong>bertemu</strong> denganmu lagi.",
                "answer_en" => "It is nice to meet you again.",
                "vocab_helper" => "['nice' => 'menyenangkan', 'meet' => 'bertemu', 'again' => 'lagi']"
            ],
            [
                "question_id" => "Dia perlu <strong>tidur</strong> lebih awal.",
                "answer_en" => "She needs to sleep earlier.",
                "vocab_helper" => "['need' => 'perlu', 'sleep' => 'tidur', 'earlier' => 'lebih awal']"
            ],
            [
                "question_id" => "Apakah kamu belajar <strong>berbicara</strong> bahasa Inggris dengan lancar?",
                "answer_en" => "Are you learning to speak English fluently?",
                "vocab_helper" => "['learn' => 'belajar', 'speak' => 'berbicara', 'fluently' => 'dengan lancar']"
            ],
            [
                "question_id" => "Terlalu dingin <strong>untuk berenang</strong> hari ini.",
                "answer_en" => "It is too cold to swim today.",
                "vocab_helper" => "['cold' => 'dingin', 'swim' => 'berenang', 'today' => 'hari ini']"
            ],
            [
                "question_id" => "Saya tidak tahu cara <strong>memperbaiki</strong> mobil ini.",
                "answer_en" => "I don't know how to fix this car.",
                "vocab_helper" => "['know' => 'tahu', 'how' => 'cara', 'fix' => 'memperbaiki', 'car' => 'mobil']"
            ],
            [
                "question_id" => "Mereka menolak <strong>untuk menjawab</strong> pertanyaan itu.",
                "answer_en" => "They refused to answer the question.",
                "vocab_helper" => "['refuse' => 'menolak', 'answer' => 'menjawab', 'question' => 'pertanyaan']"
            ],
            [
                "question_id" => "Saya berharap <strong>melihat</strong> Anda segera.",
                "answer_en" => "I hope to see you soon.",
                "vocab_helper" => "['hope' => 'berharap', 'see' => 'melihat', 'soon' => 'segera']"
            ],
            [
                "question_id" => "Dia menyuruhku <strong>untuk menunggunya</strong> di sini.",
                "answer_en" => "He told me to wait for him here.",
                "vocab_helper" => "['tell' => 'menyuruh', 'wait' => 'menunggu', 'here' => 'di sini']"
            ],
            [
                "question_id" => "Saya punya banyak pekerjaan <strong>untuk dilakukan</strong>.",
                "answer_en" => "I have a lot of work to do.",
                "vocab_helper" => "['lot of' => 'banyak', 'work' => 'pekerjaan', 'do' => 'melakukan']"
            ],
            [
                "question_id" => "Sulit <strong>untuk memahami</strong> apa yang dia katakan.",
                "answer_en" => "It is difficult to understand what he says.",
                "vocab_helper" => "['difficult' => 'sulit', 'understand' => 'memahami', 'say' => 'mengatakan']"
            ],
            [
                "question_id" => "Dia pura-pura tidak <strong>mendengarkan</strong> saya.",
                "answer_en" => "She pretended not to hear me.",
                "vocab_helper" => "['pretend' => 'pura-pura', 'hear' => 'mendengar']"
            ],
            [
                "question_id" => "Kami setuju <strong>untuk bertemu</strong> di kafe.",
                "answer_en" => "We agreed to meet at the cafe.",
                "vocab_helper" => "['agree' => 'setuju', 'meet' => 'bertemu', 'cafe' => 'kafe']"
            ],
            [
                "question_id" => "Apakah aman <strong>untuk minum</strong> air ini?",
                "answer_en" => "Is it safe to drink this water?",
                "vocab_helper" => "['safe' => 'aman', 'drink' => 'minum', 'water' => 'air']"
            ],
            [
                "question_id" => "Saya ingin <strong>mempelajari</strong> lebih banyak tentang sejarah karena sangat penting <strong>untuk memahami</strong> masa lalu. Saya berencana <strong>untuk mengunjungi</strong> museum akhir pekan ini dan berharap <strong>untuk melihat</strong> beberapa artefak kuno.",
                "answer_en" => "I want to learn more about history because it is very important to understand the past. I plan to visit the museum this weekend and hope to see some ancient artifacts.",
                "vocab_helper" => "['learn' => 'mempelajari', 'history' => 'sejarah', 'important' => 'penting', 'understand' => 'memahami', 'past' => 'masa lalu', 'plan' => 'berencana', 'visit' => 'mengunjungi', 'museum' => 'museum', 'hope' => 'berharap', 'ancient' => 'kuno', 'artifacts' => 'artefak']"
            ]
        ];

        foreach ($topic40_sentences as $index => $item) {
            $data[] = [
                'grammar_topic_id' => 40,
                'type' => ($index == 20) ? 'paragraph' : 'sentence',
                'question_id' => $item['question_id'],
                'answer_en' => $item['answer_en'],
                'vocab_helper' => $item['vocab_helper'],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        // Topic 41: Subjunctive & Inversion
        $topic41_sentences = [
            [
                "question_id" => "Penting agar dia <strong>hadir</strong> di rapat tersebut.",
                "answer_en" => "It is important that he be present at the meeting.",
                "vocab_helper" => "['important' => 'penting', 'present' => 'hadir', 'meeting' => 'rapat']"
            ],
            [
                "question_id" => "Manajer meminta agar laporan itu <strong>diselesaikan</strong> hari ini.",
                "answer_en" => "The manager requested that the report be finished today.",
                "vocab_helper" => "['request' => 'meminta', 'report' => 'laporan', 'finish' => 'menyelesaikan', 'today' => 'hari ini']"
            ],
            [
                "question_id" => "<strong>Jarang saya melihat</strong> pemandangan yang begitu indah.",
                "answer_en" => "Rarely have I seen such a beautiful view.",
                "vocab_helper" => "['rarely' => 'jarang', 'see' => 'melihat', 'such' => 'begitu', 'beautiful' => 'indah', 'view' => 'pemandangan']"
            ],
            [
                "question_id" => "Dokter menyarankan agar dia <strong>berhenti</strong> merokok.",
                "answer_en" => "The doctor suggested that he stop smoking.",
                "vocab_helper" => "['suggest' => 'menyarankan', 'stop' => 'berhenti', 'smoking' => 'merokok']"
            ],
            [
                "question_id" => "<strong>Baru setelah</strong> dia pergi, saya menyadari kesalahannya.",
                "answer_en" => "Only after he left did I realize the mistake.",
                "vocab_helper" => "['only after' => 'baru setelah', 'leave' => 'pergi', 'realize' => 'menyadari', 'mistake' => 'kesalahan']"
            ],
            [
                "question_id" => "Saya menuntut agar mereka <strong>mengembalikan</strong> uang saya.",
                "answer_en" => "I demand that they return my money.",
                "vocab_helper" => "['demand' => 'menuntut', 'return' => 'mengembalikan', 'money' => 'uang']"
            ],
            [
                "question_id" => "<strong>Tidak pernah saya mendengar</strong> hal yang begitu konyol.",
                "answer_en" => "Never have I heard such a ridiculous thing.",
                "vocab_helper" => "['never' => 'tidak pernah', 'hear' => 'mendengar', 'ridiculous' => 'konyol']"
            ],
            [
                "question_id" => "Penting agar sistem itu <strong>diperbarui</strong> segera.",
                "answer_en" => "It is essential that the system be updated immediately.",
                "vocab_helper" => "['essential' => 'penting', 'system' => 'sistem', 'update' => 'diperbarui', 'immediately' => 'segera']"
            ],
            [
                "question_id" => "<strong>Jika saya tahu</strong> hal itu, saya akan membantunya.",
                "answer_en" => "Had I known about it, I would have helped him.",
                "vocab_helper" => "['know' => 'tahu', 'help' => 'membantu']"
            ],
            [
                "question_id" => "Sangat disarankan agar kamu <strong>mengambil</strong> cuti beberapa hari.",
                "answer_en" => "It is highly recommended that you take a few days off.",
                "vocab_helper" => "['highly' => 'sangat', 'recommend' => 'disarankan', 'take off' => 'mengambil cuti']"
            ],
            [
                "question_id" => "<strong>Dalam situasi apapun kamu tidak boleh</strong> membuka pintu ini.",
                "answer_en" => "Under no circumstances should you open this door.",
                "vocab_helper" => "['under no circumstances' => 'dalam situasi apapun tidak', 'open' => 'membuka', 'door' => 'pintu']"
            ],
            [
                "question_id" => "Saya merekomendasikan agar dia <strong>menulis</strong> ulang esainya.",
                "answer_en" => "I recommend that she rewrite her essay.",
                "vocab_helper" => "['recommend' => 'merekomendasikan', 'rewrite' => 'menulis ulang', 'essay' => 'esai']"
            ],
            [
                "question_id" => "<strong>Nyaris tidak dia mulai</strong> berbicara ketika telepon berdering.",
                "answer_en" => "Hardly had he started speaking when the phone rang.",
                "vocab_helper" => "['hardly' => 'nyaris tidak', 'start' => 'mulai', 'speak' => 'berbicara', 'phone' => 'telepon', 'ring' => 'berdering']"
            ],
            [
                "question_id" => "Adalah vital agar setiap siswa <strong>memiliki</strong> akses internet.",
                "answer_en" => "It is vital that every student have internet access.",
                "vocab_helper" => "['vital' => 'vital/penting', 'student' => 'siswa', 'have' => 'memiliki', 'access' => 'akses']"
            ],
            [
                "question_id" => "<strong>Begitu cepatnya</strong> ia berlari sehingga ia memenangkan perlombaan itu.",
                "answer_en" => "So fast did he run that he won the race.",
                "vocab_helper" => "['fast' => 'cepat', 'run' => 'berlari', 'win' => 'memenangkan', 'race' => 'perlombaan']"
            ],
            [
                "question_id" => "Saya mengusulkan agar pertemuan itu <strong>ditunda</strong>.",
                "answer_en" => "I propose that the meeting be postponed.",
                "vocab_helper" => "['propose' => 'mengusulkan', 'meeting' => 'pertemuan', 'postpone' => 'ditunda']"
            ],
            [
                "question_id" => "<strong>Tidak hanya dia pandai</strong>, tetapi dia juga sangat baik.",
                "answer_en" => "Not only is he smart, but he is also very kind.",
                "vocab_helper" => "['not only' => 'tidak hanya', 'smart' => 'pandai', 'kind' => 'baik']"
            ],
            [
                "question_id" => "Adalah krusial agar masalah ini <strong>diselesaikan</strong> dengan cepat.",
                "answer_en" => "It is crucial that this problem be resolved quickly.",
                "vocab_helper" => "['crucial' => 'krusial', 'problem' => 'masalah', 'resolve' => 'diselesaikan', 'quickly' => 'dengan cepat']"
            ],
            [
                "question_id" => "<strong>Sebaiknya kamu</strong> tidak pergi sendirian di malam hari.",
                "answer_en" => "You had better not go alone at night.",
                "vocab_helper" => "['had better' => 'sebaiknya', 'go' => 'pergi', 'alone' => 'sendirian', 'night' => 'malam']"
            ],
            [
                "question_id" => "Penting agar kita <strong>bersiap</strong> untuk segala kemungkinan.",
                "answer_en" => "It is imperative that we be prepared for any possibility.",
                "vocab_helper" => "['imperative' => 'penting', 'prepare' => 'bersiap', 'possibility' => 'kemungkinan']"
            ],
            [
                "question_id" => "Penting agar dia <strong>mengirimkan</strong> laporannya tepat waktu. <strong>Jarang saya melihat</strong> karyawan yang begitu berdedikasi. <strong>Seandainya saya tahu</strong> ia membutuhkan bantuan, saya akan menawarkan bantuan kepadanya kemarin.",
                "answer_en" => "It is essential that she submit her report on time. Rarely have I seen such a dedicated employee. Had I known she needed help, I would have offered my assistance to her yesterday.",
                "vocab_helper" => "['essential' => 'penting', 'submit' => 'mengirimkan', 'report' => 'laporan', 'on time' => 'tepat waktu', 'rarely' => 'jarang', 'dedicated' => 'berdedikasi', 'employee' => 'karyawan', 'offer' => 'menawarkan', 'assistance' => 'bantuan']"
            ]
        ];

        foreach ($topic41_sentences as $index => $item) {
            $data[] = [
                'grammar_topic_id' => 41,
                'type' => ($index == 20) ? 'paragraph' : 'sentence',
                'question_id' => $item['question_id'],
                'answer_en' => $item['answer_en'],
                'vocab_helper' => $item['vocab_helper'],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        // Topic 42: Adverbial Clause
        $topic42_sentences = [
            [
                "question_id" => "Saya akan menghubungimu <strong>setelah saya tiba</strong> di rumah.",
                "answer_en" => "I will contact you after I arrive home.",
                "vocab_helper" => "['contact' => 'menghubungi', 'after' => 'setelah', 'arrive' => 'tiba', 'home' => 'rumah']"
            ],
            [
                "question_id" => "<strong>Meskipun hujan turun deras</strong>, mereka tetap bermain sepak bola.",
                "answer_en" => "Although it rained heavily, they still played football.",
                "vocab_helper" => "['although' => 'meskipun', 'rain' => 'hujan', 'heavily' => 'deras', 'still' => 'tetap', 'play' => 'bermain', 'football' => 'sepak bola']"
            ],
            [
                "question_id" => "Dia menangis <strong>karena dia kehilangan</strong> kucingnya.",
                "answer_en" => "She cried because she lost her cat.",
                "vocab_helper" => "['cry' => 'menangis', 'because' => 'karena', 'lose' => 'kehilangan', 'cat' => 'kucing']"
            ],
            [
                "question_id" => "Saya membaca buku <strong>sementara dia menonton</strong> TV.",
                "answer_en" => "I read a book while he watched TV.",
                "vocab_helper" => "['read' => 'membaca', 'book' => 'buku', 'while' => 'sementara', 'watch' => 'menonton']"
            ],
            [
                "question_id" => "Kamu bisa pergi <strong>kapanpun kamu mau</strong>.",
                "answer_en" => "You can go whenever you want.",
                "vocab_helper" => "['go' => 'pergi', 'whenever' => 'kapanpun', 'want' => 'mau']"
            ],
            [
                "question_id" => "<strong>Karena cuaca buruk</strong>, penerbangan dibatalkan.",
                "answer_en" => "Since the weather was bad, the flight was canceled.",
                "vocab_helper" => "['since' => 'karena', 'weather' => 'cuaca', 'bad' => 'buruk', 'flight' => 'penerbangan', 'cancel' => 'dibatalkan']"
            ],
            [
                "question_id" => "Saya akan menunggumu <strong>sampai kamu selesai</strong>.",
                "answer_en" => "I will wait for you until you finish.",
                "vocab_helper" => "['wait' => 'menunggu', 'until' => 'sampai', 'finish' => 'selesai']"
            ],
            [
                "question_id" => "Dia berbicara sangat cepat <strong>sehingga saya tidak bisa memahaminya</strong>.",
                "answer_en" => "He spoke so fast that I couldn't understand him.",
                "vocab_helper" => "['speak' => 'berbicara', 'so fast' => 'sangat cepat', 'that' => 'sehingga', 'understand' => 'memahami']"
            ],
            [
                "question_id" => "Saya belajar dengan giat <strong>agar saya bisa lulus ujian</strong>.",
                "answer_en" => "I studied hard so that I could pass the exam.",
                "vocab_helper" => "['study' => 'belajar', 'hard' => 'dengan giat', 'so that' => 'agar', 'pass' => 'lulus', 'exam' => 'ujian']"
            ],
            [
                "question_id" => "<strong>Jika tidak turun hujan</strong>, kita akan pergi piknik.",
                "answer_en" => "Unless it rains, we will go for a picnic.",
                "vocab_helper" => "['unless' => 'jika tidak', 'rain' => 'hujan', 'go' => 'pergi', 'picnic' => 'piknik']"
            ],
            [
                "question_id" => "Dia pergi bekerja <strong>meskipun dia sakit</strong>.",
                "answer_en" => "She went to work even though she was sick.",
                "vocab_helper" => "['go' => 'pergi', 'work' => 'bekerja', 'even though' => 'meskipun', 'sick' => 'sakit']"
            ],
            [
                "question_id" => "Tolong beri tahu saya <strong>segera setelah kamu tiba</strong>.",
                "answer_en" => "Please let me know as soon as you arrive.",
                "vocab_helper" => "['let know' => 'beri tahu', 'as soon as' => 'segera setelah', 'arrive' => 'tiba']"
            ],
            [
                "question_id" => "Dia memarkir mobil <strong>di mana dia bisa menemukan tempat</strong>.",
                "answer_en" => "He parked the car where he could find a spot.",
                "vocab_helper" => "['park' => 'memarkir', 'car' => 'mobil', 'where' => 'di mana', 'find' => 'menemukan', 'spot' => 'tempat']"
            ],
            [
                "question_id" => "<strong>Sebagaimana kamu tahu</strong>, besok adalah hari libur.",
                "answer_en" => "As you know, tomorrow is a holiday.",
                "vocab_helper" => "['as' => 'sebagaimana', 'know' => 'tahu', 'tomorrow' => 'besok', 'holiday' => 'hari libur']"
            ],
            [
                "question_id" => "Saya tidak bisa pergi <strong>karena saya harus bekerja</strong>.",
                "answer_en" => "I cannot go because I have to work.",
                "vocab_helper" => "['cannot' => 'tidak bisa', 'go' => 'pergi', 'because' => 'karena', 'have to' => 'harus', 'work' => 'bekerja']"
            ],
            [
                "question_id" => "Dia berperilaku <strong>seolah-olah dia memiliki tempat ini</strong>.",
                "answer_en" => "He acts as if he owns this place.",
                "vocab_helper" => "['act' => 'berperilaku', 'as if' => 'seolah-olah', 'own' => 'memiliki', 'place' => 'tempat']"
            ],
            [
                "question_id" => "Saya membawa payung <strong>berjaga-jaga jika hujan</strong>.",
                "answer_en" => "I brought an umbrella in case it rained.",
                "vocab_helper" => "['bring' => 'membawa', 'umbrella' => 'payung', 'in case' => 'berjaga-jaga jika', 'rain' => 'hujan']"
            ],
            [
                "question_id" => "<strong>Sebelum kamu pergi</strong>, tolong matikan lampu.",
                "answer_en" => "Before you leave, please turn off the lights.",
                "vocab_helper" => "['before' => 'sebelum', 'leave' => 'pergi', 'turn off' => 'matikan', 'lights' => 'lampu']"
            ],
            [
                "question_id" => "Dia menabung uang <strong>agar dia bisa membeli mobil</strong>.",
                "answer_en" => "He saves money in order that he can buy a car.",
                "vocab_helper" => "['save' => 'menabung', 'money' => 'uang', 'in order that' => 'agar', 'buy' => 'membeli', 'car' => 'mobil']"
            ],
            [
                "question_id" => "<strong>Meskipun dia lelah</strong>, dia menyelesaikan pekerjaannya.",
                "answer_en" => "Even if she is tired, she finishes her work.",
                "vocab_helper" => "['even if' => 'meskipun', 'tired' => 'lelah', 'finish' => 'menyelesaikan', 'work' => 'pekerjaan']"
            ],
            [
                "question_id" => "<strong>Meskipun dia sangat lelah</strong>, dia tetap menyelesaikan pekerjaannya <strong>agar dia bisa beristirahat</strong> di akhir pekan. <strong>Ketika dia selesai</strong>, dia langsung pulang <strong>karena dia merindukan keluarganya</strong>.",
                "answer_en" => "Although he was very tired, he still finished his work so that he could rest on the weekend. When he finished, he went straight home because he missed his family.",
                "vocab_helper" => "['although' => 'meskipun', 'tired' => 'lelah', 'still' => 'tetap', 'finish' => 'menyelesaikan', 'so that' => 'agar', 'rest' => 'beristirahat', 'weekend' => 'akhir pekan', 'when' => 'ketika', 'straight' => 'langsung', 'home' => 'pulang/rumah', 'because' => 'karena', 'miss' => 'merindukan', 'family' => 'keluarga']"
            ]
        ];

        foreach ($topic42_sentences as $index => $item) {
            $data[] = [
                'grammar_topic_id' => 42,
                'type' => ($index == 20) ? 'paragraph' : 'sentence',
                'question_id' => $item['question_id'],
                'answer_en' => $item['answer_en'],
                'vocab_helper' => $item['vocab_helper'],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('grammar_topic_questions')->insert($data);
    }
}
