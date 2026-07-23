<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BatchSeeder5 extends Seeder
{
    public function run()
    {
        $topics = [
            // 23: Passive Voice
            23 => [
                'type' => 'sentence',
                'questions' => [
                    ['Mobil itu <strong>dicuci</strong> oleh ayah setiap minggu.', 'The car is washed by father every week.', '["wash", "every week"]'],
                    ['Buku ini <strong>ditulis</strong> pada tahun 1990.', 'This book was written in 1990.', '["write", "year"]'],
                    ['Kue-kue <strong>sedang dibuat</strong> oleh ibu di dapur.', 'The cakes are being made by mother in the kitchen.', '["cake", "make"]'],
                    ['Pekerjaan rumahnya <strong>belum diselesaikan</strong>.', 'His homework has not been finished yet.', '["homework", "finish"]'],
                    ['Masalah itu <strong>akan dibahas</strong> besok.', 'The problem will be discussed tomorrow.', '["problem", "discuss"]'],
                    ['Sepedaku <strong>telah dicuri</strong>!', 'My bicycle has been stolen!', '["bicycle", "steal"]'],
                    ['Surat itu <strong>harus dikirim</strong> hari ini.', 'The letter must be sent today.', '["letter", "send"]'],
                    ['Pertandingan <strong>dibatalkan</strong> karena hujan.', 'The match was canceled due to rain.', '["match", "cancel", "due to"]'],
                    ['Kamar ini <strong>dibersihkan</strong> setiap hari.', 'This room is cleaned every day.', '["room", "clean"]'],
                    ['Jembatan baru <strong>sedang dibangun</strong> di atas sungai.', 'A new bridge is being built over the river.', '["bridge", "build", "river"]'],
                    ['Pintu itu <strong>tidak boleh dibuka</strong>.', 'The door must not be opened.', '["door", "must not", "open"]'],
                    ['Dia <strong>dipilih</strong> sebagai ketua kelas.', 'He was chosen as the class president.', '["choose", "class president"]'],
                    ['Rencana itu <strong>telah disetujui</strong> oleh manajer.', 'The plan has been approved by the manager.', '["plan", "approve"]'],
                    ['Kopi <strong>ditanam</strong> di daerah ini.', 'Coffee is grown in this area.', '["grow", "area"]'],
                    ['Dompetnya <strong>ditemukan</strong> di stasiun kereta.', 'Her wallet was found at the train station.', '["wallet", "find", "train station"]'],
                    ['Uang itu <strong>sedang dihitung</strong>.', 'The money is being counted.', '["money", "count"]'],
                    ['Peraturan baru <strong>akan diterapkan</strong> bulan depan.', 'The new rules will be applied next month.', '["rule", "apply"]'],
                    ['Hadiah <strong>diberikan</strong> kepada pemenang.', 'Prizes were given to the winners.', '["prize", "give", "winner"]'],
                    ['Anak-anak <strong>diajarkan</strong> cara berenang.', 'The children are taught how to swim.', '["teach", "how to"]'],
                    ['Mobilnya <strong>telah diperbaiki</strong>.', 'His car has been repaired.', '["car", "repair"]'],
                ],
                'paragraph' => [
                    'Sebuah museum baru <strong>sedang dibangun</strong> di kota kami. Proyek ini <strong>dimulai</strong> tahun lalu dan <strong>diharapkan</strong> selesai bulan depan. Banyak artefak sejarah <strong>akan dipamerkan</strong> di sana. Saat ini, koleksi-koleksi tersebut <strong>sedang dipersiapkan</strong> oleh para ahli.',
                    'A new museum is being built in our city. This project was started last year and is expected to be finished next month. Many historical artifacts will be displayed there. Currently, the collections are being prepared by experts.',
                    '["museum", "build", "project", "start", "expect", "finish", "artifact", "display", "collection", "prepare", "expert"]'
                ]
            ],
            // 24: Advanced Tenses
            24 => [
                'type' => 'sentence',
                'questions' => [
                    ['Saya <strong>sudah selesai</strong> makan sebelum dia datang.', 'I had finished eating before he arrived.', '["finish", "eat", "arrive"]'],
                    ['Mereka <strong>telah menunggu</strong> selama dua jam ketika bus tiba.', 'They had been waiting for two hours when the bus arrived.', '["wait", "arrive"]'],
                    ['Saya <strong>akan sudah menyelesaikan</strong> laporan ini pada jam 5 sore.', 'I will have finished this report by 5 PM.', '["finish", "report"]'],
                    ['Tahun depan, kami <strong>akan telah tinggal</strong> di sini selama sepuluh tahun.', 'Next year, we will have been living here for ten years.', '["live", "for"]'],
                    ['Dia lelah karena dia <strong>telah berlari</strong> sejauh lima kilometer.', 'He was tired because he had been running for five kilometers.', '["tired", "run"]'],
                    ['Ketika polisi tiba, pencuri itu <strong>sudah melarikan diri</strong>.', 'When the police arrived, the thief had already escaped.', '["arrive", "thief", "escape"]'],
                    ['Saya <strong>belum pernah melihat</strong> salju sebelum saya pergi ke Eropa.', 'I had never seen snow before I went to Europe.', '["never", "see", "snow"]'],
                    ['Apakah kamu <strong>akan sudah lulus</strong> bulan Juli mendatang?', 'Will you have graduated by next July?', '["graduate", "next"]'],
                    ['Pada jam 8, dia <strong>akan telah bekerja</strong> selama 12 jam berturut-turut.', 'By 8 o\'clock, she will have been working for 12 hours straight.', '["work", "straight"]'],
                    ['Tanah itu basah karena <strong>telah turun hujan</strong>.', 'The ground was wet because it had been raining.', '["ground", "wet", "rain"]'],
                    ['Setelah dia <strong>menyelesaikan</strong> pekerjaannya, dia pulang.', 'After he had finished his work, he went home.', '["finish", "work", "go home"]'],
                    ['Mereka marah karena mereka <strong>telah dibiarkan</strong> menunggu.', 'They were angry because they had been kept waiting.', '["angry", "keep", "wait"]'],
                    ['Bulan depan, saya <strong>akan sudah membaca</strong> buku ini tiga kali.', 'Next month, I will have read this book three times.', '["read", "times"]'],
                    ['Dia <strong>sudah belajar</strong> bahasa Inggris selama setahun sebelum pindah.', 'He had been studying English for a year before moving.', '["study", "move"]'],
                    ['Filmnya <strong>sudah dimulai</strong> ketika kami sampai di bioskop.', 'The movie had already started when we arrived at the cinema.', '["movie", "start", "arrive", "cinema"]'],
                    ['Kami <strong>telah berjalan</strong> selama berjam-jam sebelum menemukan desa itu.', 'We had been walking for hours before finding the village.', '["walk", "find", "village"]'],
                    ['Pada akhir tahun ini, dia <strong>akan sudah bekerja</strong> di sini selama lima tahun.', 'By the end of this year, he will have worked here for five years.', '["end", "work"]'],
                    ['Saya <strong>sudah tidur</strong> saat telepon berdering.', 'I had already slept when the phone rang.', '["sleep", "ring"]'],
                    ['Mereka <strong>akan telah berlayar</strong> selama seminggu penuh besok.', 'They will have been sailing for a full week tomorrow.', '["sail", "full week"]'],
                    ['Dia merasa sakit karena dia <strong>telah makan</strong> terlalu banyak.', 'He felt sick because he had eaten too much.', '["feel sick", "eat", "too much"]'],
                ],
                'paragraph' => [
                    'Ketika saya tiba di stasiun, kereta <strong>sudah berangkat</strong>. Menjelang akhir hari ini, saya <strong>akan telah menunggu</strong> di sini selama lima jam. Saya <strong>telah berlari</strong> sejauh dua kilometer. Besok, saya <strong>akan sudah membeli</strong> tiket baru.',
                    'When I arrived at the station, the train had already left. By the end of today, I will have been waiting here for five hours. I had been running for two kilometers. Tomorrow, I will have bought a new ticket.',
                    '["arrive", "station", "leave", "wait", "run", "buy", "ticket"]'
                ]
            ],
            // 25: Conditional Sentences
            25 => [
                'type' => 'sentence',
                'questions' => [
                    ['Jika kamu memanaskan es, itu <strong>mencair</strong>.', 'If you heat ice, it melts.', '["heat", "ice", "melt"]'],
                    ['Jika hujan besok, kami <strong>akan tinggal</strong> di rumah.', 'If it rains tomorrow, we will stay at home.', '["rain", "stay"]'],
                    ['Jika saya punya banyak uang, saya <strong>akan membeli</strong> mobil itu.', 'If I had a lot of money, I would buy that car.', '["money", "buy"]'],
                    ['Jika saya telah belajar lebih giat, saya <strong>akan telah lulus</strong> ujian.', 'If I had studied harder, I would have passed the exam.', '["study hard", "pass", "exam"]'],
                    ['Jika kamu mencampur merah dan biru, kamu <strong>mendapat</strong> ungu.', 'If you mix red and blue, you get purple.', '["mix", "get", "purple"]'],
                    ['Dia akan marah jika kamu <strong>datang terlambat</strong> lagi.', 'He will be angry if you come late again.', '["angry", "come late"]'],
                    ['Jika saya adalah kamu, saya <strong>tidak akan melakukan</strong> itu.', 'If I were you, I would not do that.', '["were", "do"]'],
                    ['Kami <strong>akan telah menang</strong> jika dia tidak cedera.', 'We would have won if he had not been injured.', '["win", "injure"]'],
                    ['Tanaman <strong>mati</strong> jika mereka tidak mendapat air.', 'Plants die if they do not get water.', '["plant", "die", "get water"]'],
                    ['Jika dia menelepon, saya <strong>akan memberitahunya</strong> kabar itu.', 'If he calls, I will tell him the news.', '["call", "tell", "news"]'],
                    ['Jika anjing itu bisa berbicara, ia <strong>akan meminta</strong> lebih banyak makanan.', 'If the dog could speak, it would ask for more food.', '["speak", "ask for", "food"]'],
                    ['Jika kamu telah memberitahuku, saya <strong>akan telah membantu</strong> kamu.', 'If you had told me, I would have helped you.', '["tell", "help"]'],
                    ['Jika matahari terbenam, hari <strong>menjadi</strong> gelap.', 'If the sun sets, it gets dark.', '["sun", "set", "get dark"]'],
                    ['Kami akan ketinggalan kereta jika kita <strong>tidak bergegas</strong>.', 'We will miss the train if we do not hurry.', '["miss", "train", "hurry"]'],
                    ['Saya akan bepergian keliling dunia jika saya <strong>memenangkan</strong> lotere.', 'I would travel around the world if I won the lottery.', '["travel", "win", "lottery"]'],
                    ['Dia <strong>tidak akan telah kecelakaan</strong> jika dia mengemudi dengan hati-hati.', 'He would not have had an accident if he had driven carefully.', '["accident", "drive", "carefully"]'],
                    ['Jika air mencapai 100 derajat Celsius, ia <strong>mendidih</strong>.', 'If water reaches 100 degrees Celsius, it boils.', '["reach", "degree", "boil"]'],
                    ['Jika kamu memakannya, kamu <strong>akan sakit</strong>.', 'If you eat it, you will get sick.', '["eat", "get sick"]'],
                    ['Jika dia tahu nomornya, dia <strong>akan menelepon</strong> mereka.', 'If he knew the number, he would call them.', '["know", "number", "call"]'],
                    ['Jika saya telah melihatnya, saya <strong>akan telah menyapanya</strong>.', 'If I had seen him, I would have greeted him.', '["see", "greet"]'],
                ],
                'paragraph' => [
                    'Jika saya tahu kamu sedang sakit, saya <strong>akan telah mengunjungimu</strong> di rumah sakit. Jika kamu istirahat sekarang, kamu <strong>akan merasa</strong> lebih baik besok. Secara umum, jika orang cukup tidur, mereka <strong>menjadi</strong> lebih sehat. Jika saya seorang dokter, saya <strong>akan memberimu</strong> obat yang terbaik.',
                    'If I had known you were sick, I would have visited you in the hospital. If you rest now, you will feel better tomorrow. Generally, if people get enough sleep, they become healthier. If I were a doctor, I would give you the best medicine.',
                    '["know", "sick", "visit", "hospital", "rest", "feel better", "generally", "sleep", "healthy", "doctor", "medicine"]'
                ]
            ],
            // 26: Direct & Indirect Speech
            26 => [
                'type' => 'sentence',
                'questions' => [
                    ['Dia berkata, "Saya <strong>sangat lelah</strong>."', 'He said that he was very tired.', '["say", "tired"]'],
                    ['Budi bertanya, "Di mana <strong>kamu tinggal</strong>?"', 'Budi asked where I lived.', '["ask", "where", "live"]'],
                    ['Guru menyuruh kami, "<strong>Duduklah!</strong>"', 'The teacher told us to sit down.', '["teacher", "tell", "sit down"]'],
                    ['Dia berkata, "Saya <strong>sedang membaca</strong> buku."', 'She said that she was reading a book.', '["say", "read", "book"]'],
                    ['Mereka berkata, "Kami <strong>akan pergi</strong> besok."', 'They said that they would go the next day.', '["say", "go", "next day"]'],
                    ['Ibu bertanya, "Apakah kamu <strong>sudah makan</strong>?"', 'Mother asked if I had eaten.', '["ask", "eat"]'],
                    ['Dia berkata, "Saya <strong>telah menyelesaikan</strong> tugasku."', 'He said that he had finished his task.', '["say", "finish", "task"]'],
                    ['Dokter menasihatinya, "<strong>Jangan merokok!</strong>"', 'The doctor advised him not to smoke.', '["doctor", "advise", "smoke"]'],
                    ['Ani berkata, "Saya <strong>bisa berenang</strong>."', 'Ani said that she could swim.', '["say", "can", "swim"]'],
                    ['Dia bertanya, "Kapan kamu <strong>akan tiba</strong>?"', 'He asked when I would arrive.', '["ask", "when", "arrive"]'],
                    ['Ayah berkata, "Saya <strong>membeli</strong> mobil baru kemarin."', 'Father said that he had bought a new car the day before.', '["say", "buy", "car", "day before"]'],
                    ['Dia berkata kepadaku, "Tolong <strong>buka</strong> jendelanya."', 'She asked me to open the window.', '["ask", "open", "window"]'],
                    ['Rina berkata, "Saya <strong>harus pergi</strong> sekarang."', 'Rina said that she had to go then.', '["say", "have to", "go", "then"]'],
                    ['Pria itu bertanya, "Siapa nama<strong>mu</strong>?"', 'The man asked what my name was.', '["man", "ask", "name"]'],
                    ['Dia berkata, "Bumi <strong>itu bulat</strong>."', 'He said that the earth is round.', '["say", "earth", "round"]'],
                    ['Tom berkata, "Saya <strong>tidak suka</strong> kopi."', 'Tom said that he did not like coffee.', '["say", "like", "coffee"]'],
                    ['Dia bertanya, "Apakah kamu <strong>melihat</strong> dompetku?"', 'She asked if I had seen her wallet.', '["ask", "see", "wallet"]'],
                    ['Polisi berteriak, "<strong>Berhenti!</strong>"', 'The police shouted to stop.', '["police", "shout", "stop"]'],
                    ['Mereka berkata, "Kami <strong>sedang bermain</strong> tenis."', 'They said that they were playing tennis.', '["say", "play", "tennis"]'],
                    ['Dia berkata, "Saya <strong>akan membantumu</strong> nanti."', 'He said that he would help me later.', '["say", "help", "later"]'],
                ],
                'paragraph' => [
                    'Dia bertanya kepadaku <strong>ke mana aku akan pergi</strong>. Aku menjawab <strong>bahwa aku akan pergi</strong> ke perpustakaan. Kemudian dia memintaku <strong>untuk meminjamkan</strong> sebuah buku untuknya. Dia berkata <strong>bahwa dia sangat sibuk</strong> hari itu.',
                    'He asked me where I was going. I answered that I was going to the library. Then he asked me to borrow a book for him. He said that he was very busy that day.',
                    '["ask", "where", "go", "answer", "library", "borrow", "busy"]'
                ]
            ],
            // 27: Relative Pronoun as Subject Clauses
            27 => [
                'type' => 'sentence',
                'questions' => [
                    ['Pria <strong>yang</strong> sedang berbicara itu adalah paman saya.', 'The man who is talking is my uncle.', '["man", "talk", "uncle"]'],
                    ['Buku <strong>yang</strong> ada di atas meja itu milikku.', 'The book which is on the table is mine.', '["book", "table", "mine"]'],
                    ['Ini adalah rumah <strong>yang</strong> Jack bangun.', 'This is the house that Jack built.', '["house", "build"]'],
                    ['Wanita <strong>yang</strong> tasnya dicuri sedang menangis.', 'The woman whose bag was stolen is crying.', '["woman", "bag", "steal", "cry"]'],
                    ['Orang <strong>kepada siapa</strong> saya berbicara sangat ramah.', 'The person to whom I spoke was very friendly.', '["person", "speak", "friendly"]'],
                    ['Gadis <strong>yang</strong> memenangkan lomba itu terlihat bahagia.', 'The girl who won the race looks happy.', '["girl", "win", "race", "look happy"]'],
                    ['Mobil <strong>yang</strong> diparkir di luar adalah mobil baru.', 'The car which is parked outside is new.', '["car", "park", "outside", "new"]'],
                    ['Apakah kamu tahu anak laki-laki <strong>yang</strong> ayahnya adalah seorang dokter?', 'Do you know the boy whose father is a doctor?', '["know", "boy", "father", "doctor"]'],
                    ['Dia adalah satu-satunya orang <strong>yang</strong> saya percayai.', 'He is the only person whom I trust.', '["only person", "trust"]'],
                    ['Anjing <strong>yang</strong> menggonggong semalaman itu menggangguku.', 'The dog that barked all night annoyed me.', '["dog", "bark", "all night", "annoy"]'],
                    ['Murid-murid <strong>yang</strong> belajar dengan giat akan lulus.', 'The students who study hard will pass.', '["student", "study hard", "pass"]'],
                    ['Saya punya kucing <strong>yang</strong> matanya biru.', 'I have a cat whose eyes are blue.', '["cat", "eye", "blue"]'],
                    ['Surat <strong>yang</strong> kamu kirimkan sudah tiba.', 'The letter which you sent has arrived.', '["letter", "send", "arrive"]'],
                    ['Pria <strong>yang</strong> mobilnya saya beli adalah orang baik.', 'The man whose car I bought is a good person.', '["man", "car", "buy", "good person"]'],
                    ['Guru <strong>yang</strong> kita temui kemarin akan pensiun.', 'The teacher whom we met yesterday will retire.', '["teacher", "meet", "yesterday", "retire"]'],
                    ['Pekerjaan <strong>yang</strong> dia tawarkan sangat menarik.', 'The job that he offered is very interesting.', '["job", "offer", "interesting"]'],
                    ['Dokter <strong>yang</strong> merawat ibu saya sangat berpengalaman.', 'The doctor who treated my mother is very experienced.', '["doctor", "treat", "mother", "experienced"]'],
                    ['Film <strong>yang</strong> kita tonton tadi malam sangat membosankan.', 'The movie which we watched last night was very boring.', '["movie", "watch", "last night", "boring"]'],
                    ['Anak <strong>yang</strong> sepedanya rusak sedang sedih.', 'The child whose bicycle is broken is sad.', '["child", "bicycle", "break", "sad"]'],
                    ['Ini adalah pria <strong>tentang siapa</strong> saya bercerita kepadamu.', 'This is the man about whom I told you.', '["man", "tell"]'],
                ],
                'paragraph' => [
                    'Pria <strong>yang</strong> tinggal di sebelah rumah saya adalah seorang penulis. Dia menulis buku <strong>yang</strong> sangat populer tahun lalu. Wanita <strong>yang</strong> suaminya bekerja dengannya adalah temanku. Mereka adalah orang-orang <strong>kepada siapa</strong> saya sering meminta saran.',
                    'The man who lives next to my house is a writer. He wrote a book which was very popular last year. The woman whose husband works with him is my friend. They are the people to whom I often ask for advice.',
                    '["live next to", "writer", "write", "popular", "husband", "work", "friend", "ask for advice"]'
                ]
            ],
        ];

        foreach ($topics as $topicId => $data) {
            DB::table('grammar_topic_questions')->where('grammar_topic_id', $topicId)->delete();
            $inserts = [];
            foreach ($data['questions'] as $q) {
                $inserts[] = [
                    'grammar_topic_id' => $topicId,
                    'question_id'      => $q[0],
                    'answer_en'        => $q[1],
                    'vocab_helper'     => $q[2],
                    'type'             => 'sentence',
                    'created_at'       => Carbon::now(),
                    'updated_at'       => Carbon::now(),
                ];
            }
            $inserts[] = [
                'grammar_topic_id' => $topicId,
                'question_id'      => $data['paragraph'][0],
                'answer_en'        => $data['paragraph'][1],
                'vocab_helper'     => $data['paragraph'][2],
                'type'             => 'paragraph',
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ];
            DB::table('grammar_topic_questions')->insert($inserts);
        }
    }
}
