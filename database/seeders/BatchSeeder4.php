<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BatchSeeder4 extends Seeder
{
    public function run()
    {
        $topics = [
            18 => [
                'questions' => [
                    [
                        'question_id' => 'Saya <strong>bisa</strong> berenang dengan baik.',
                        'answer_en' => 'I can swim well.',
                        'vocab_helper' => ['can' => 'bisa', 'swim' => 'berenang', 'well' => 'dengan baik']
                    ],
                    [
                        'question_id' => 'Dia <strong>harus</strong> menyelesaikan pekerjaan rumahnya.',
                        'answer_en' => 'He must finish his homework.',
                        'vocab_helper' => ['must' => 'harus', 'finish' => 'menyelesaikan', 'homework' => 'pekerjaan rumah']
                    ],
                    [
                        'question_id' => 'Mereka <strong>seharusnya</strong> datang tepat waktu.',
                        'answer_en' => 'They should come on time.',
                        'vocab_helper' => ['should' => 'seharusnya', 'come' => 'datang', 'on time' => 'tepat waktu']
                    ],
                    [
                        'question_id' => 'Kami <strong>mungkin</strong> akan pergi ke pantai besok.',
                        'answer_en' => 'We might go to the beach tomorrow.',
                        'vocab_helper' => ['might' => 'mungkin', 'go' => 'pergi', 'beach' => 'pantai', 'tomorrow' => 'besok']
                    ],
                    [
                        'question_id' => 'Anda <strong>bisa</strong> menggunakan komputer saya jika perlu.',
                        'answer_en' => 'You can use my computer if you need.',
                        'vocab_helper' => ['can' => 'bisa', 'use' => 'menggunakan', 'need' => 'perlu']
                    ],
                    [
                        'question_id' => 'Saya <strong>dulu bisa</strong> berlari sangat cepat.',
                        'answer_en' => 'I could run very fast.',
                        'vocab_helper' => ['could' => 'dulu bisa', 'run' => 'berlari', 'very fast' => 'sangat cepat']
                    ],
                    [
                        'question_id' => 'Dia <strong>mungkin</strong> tahu jawabannya.',
                        'answer_en' => 'She might know the answer.',
                        'vocab_helper' => ['might' => 'mungkin', 'know' => 'tahu', 'answer' => 'jawaban']
                    ],
                    [
                        'question_id' => 'Kamu <strong>tidak boleh</strong> merokok di sini.',
                        'answer_en' => 'You must not smoke here.',
                        'vocab_helper' => ['must not' => 'tidak boleh', 'smoke' => 'merokok', 'here' => 'di sini']
                    ],
                    [
                        'question_id' => 'Dia <strong>akan</strong> senang menerima hadiah ini.',
                        'answer_en' => 'She would be happy to receive this gift.',
                        'vocab_helper' => ['would be' => 'akan', 'receive' => 'menerima', 'gift' => 'hadiah']
                    ],
                    [
                        'question_id' => 'Apakah kamu <strong>bisa</strong> membantu saya?',
                        'answer_en' => 'Can you help me?',
                        'vocab_helper' => ['can' => 'bisa', 'help' => 'membantu']
                    ],
                    [
                        'question_id' => 'Mereka <strong>seharusnya tidak</strong> mengatakan hal itu.',
                        'answer_en' => 'They should not say that.',
                        'vocab_helper' => ['should not' => 'seharusnya tidak', 'say' => 'mengatakan', 'that' => 'hal itu']
                    ],
                    [
                        'question_id' => 'Saya <strong>mungkin</strong> terlambat.',
                        'answer_en' => 'I might be late.',
                        'vocab_helper' => ['might be' => 'mungkin', 'late' => 'terlambat']
                    ],
                    [
                        'question_id' => 'Kamu <strong>harus</strong> memakai sabuk pengaman.',
                        'answer_en' => 'You must wear a seatbelt.',
                        'vocab_helper' => ['must' => 'harus', 'wear' => 'memakai', 'seatbelt' => 'sabuk pengaman']
                    ],
                    [
                        'question_id' => 'Dia <strong>dulu bisa</strong> bermain gitar.',
                        'answer_en' => 'He could play the guitar.',
                        'vocab_helper' => ['could' => 'dulu bisa', 'play' => 'bermain', 'guitar' => 'gitar']
                    ],
                    [
                        'question_id' => 'Apakah kamu <strong>bersedia</strong> membukakan pintu?',
                        'answer_en' => 'Would you open the door?',
                        'vocab_helper' => ['would' => 'bersedia', 'open' => 'membuka', 'door' => 'pintu']
                    ],
                    [
                        'question_id' => 'Kami <strong>bisa</strong> melihat gunung dari sini.',
                        'answer_en' => 'We can see the mountain from here.',
                        'vocab_helper' => ['can' => 'bisa', 'see' => 'melihat', 'mountain' => 'gunung']
                    ],
                    [
                        'question_id' => 'Dia <strong>seharusnya</strong> menelepon ibunya.',
                        'answer_en' => 'She should call her mother.',
                        'vocab_helper' => ['should' => 'seharusnya', 'call' => 'menelepon', 'mother' => 'ibu']
                    ],
                    [
                        'question_id' => 'Mereka <strong>mungkin</strong> sedang tidur sekarang.',
                        'answer_en' => 'They might be sleeping now.',
                        'vocab_helper' => ['might be sleeping' => 'mungkin sedang tidur', 'now' => 'sekarang']
                    ],
                    [
                        'question_id' => 'Saya <strong>harus</strong> pergi sekarang.',
                        'answer_en' => 'I must go now.',
                        'vocab_helper' => ['must' => 'harus', 'go' => 'pergi', 'now' => 'sekarang']
                    ],
                    [
                        'question_id' => 'Dia <strong>akan</strong> datang jika kamu mengundangnya.',
                        'answer_en' => 'He would come if you invited him.',
                        'vocab_helper' => ['would come' => 'akan datang', 'invite' => 'mengundang']
                    ],
                ],
                'paragraph' => [
                    'question_id' => 'Saya <strong>harus</strong> belajar dengan giat setiap hari karena saya <strong>bisa</strong> lulus ujian jika saya berusaha. Teman-teman saya <strong>mungkin</strong> akan belajar bersama saya nanti. Kami <strong>seharusnya</strong> tidak membuang-buang waktu. Kami <strong>akan</strong> sangat senang jika kami semua lulus.',
                    'answer_en' => 'I must study hard every day because I can pass the exam if I try. My friends might study with me later. We should not waste time. We would be very happy if we all passed.',
                    'vocab_helper' => ['must study' => 'harus belajar', 'can pass' => 'bisa lulus', 'might study' => 'mungkin belajar', 'should not waste' => 'seharusnya tidak membuang-buang', 'would be' => 'akan menjadi']
                ]
            ],
            19 => [
                'questions' => [
                    [
                        'question_id' => 'Saya <strong>tidak makan</strong> daging.',
                        'answer_en' => 'I do not eat meat.',
                        'vocab_helper' => ['do not eat' => 'tidak makan', 'meat' => 'daging']
                    ],
                    [
                        'question_id' => 'Dia <strong>tidak suka</strong> apel.',
                        'answer_en' => 'She does not like apples.',
                        'vocab_helper' => ['does not like' => 'tidak suka', 'apples' => 'apel']
                    ],
                    [
                        'question_id' => 'Mereka <strong>tidak pergi</strong> ke sekolah kemarin.',
                        'answer_en' => 'They did not go to school yesterday.',
                        'vocab_helper' => ['did not go' => 'tidak pergi', 'school' => 'sekolah', 'yesterday' => 'kemarin']
                    ],
                    [
                        'question_id' => 'Kami <strong>tidak bekerja</strong> pada hari Minggu.',
                        'answer_en' => 'We do not work on Sundays.',
                        'vocab_helper' => ['do not work' => 'tidak bekerja', 'on Sundays' => 'pada hari Minggu']
                    ],
                    [
                        'question_id' => 'Dia <strong>tidak membeli</strong> buku itu.',
                        'answer_en' => 'He did not buy the book.',
                        'vocab_helper' => ['did not buy' => 'tidak membeli', 'book' => 'buku']
                    ],
                    [
                        'question_id' => 'Anda <strong>tidak perlu</strong> khawatir.',
                        'answer_en' => 'You do not need to worry.',
                        'vocab_helper' => ['do not need' => 'tidak perlu', 'worry' => 'khawatir']
                    ],
                    [
                        'question_id' => 'Kucing itu <strong>tidak tidur</strong> di kasur.',
                        'answer_en' => 'The cat does not sleep on the bed.',
                        'vocab_helper' => ['does not sleep' => 'tidak tidur', 'bed' => 'kasur']
                    ],
                    [
                        'question_id' => 'Saya <strong>tidak melihat</strong> dia tadi malam.',
                        'answer_en' => 'I did not see him last night.',
                        'vocab_helper' => ['did not see' => 'tidak melihat', 'last night' => 'tadi malam']
                    ],
                    [
                        'question_id' => 'Mereka <strong>tidak bermain</strong> sepak bola setiap hari.',
                        'answer_en' => 'They do not play football every day.',
                        'vocab_helper' => ['do not play' => 'tidak bermain', 'football' => 'sepak bola', 'every day' => 'setiap hari']
                    ],
                    [
                        'question_id' => 'Dia <strong>tidak menulis</strong> surat itu.',
                        'answer_en' => 'She did not write the letter.',
                        'vocab_helper' => ['did not write' => 'tidak menulis', 'letter' => 'surat']
                    ],
                    [
                        'question_id' => 'Kami <strong>tidak mengerti</strong> pertanyaannya.',
                        'answer_en' => 'We do not understand the question.',
                        'vocab_helper' => ['do not understand' => 'tidak mengerti', 'question' => 'pertanyaan']
                    ],
                    [
                        'question_id' => 'Guru itu <strong>tidak memberikan</strong> PR kemarin.',
                        'answer_en' => 'The teacher did not give homework yesterday.',
                        'vocab_helper' => ['did not give' => 'tidak memberikan', 'homework' => 'PR', 'yesterday' => 'kemarin']
                    ],
                    [
                        'question_id' => 'Saya <strong>tidak minum</strong> kopi.',
                        'answer_en' => 'I do not drink coffee.',
                        'vocab_helper' => ['do not drink' => 'tidak minum', 'coffee' => 'kopi']
                    ],
                    [
                        'question_id' => 'Dia <strong>tidak tahu</strong> jawabannya.',
                        'answer_en' => 'He does not know the answer.',
                        'vocab_helper' => ['does not know' => 'tidak tahu', 'answer' => 'jawaban']
                    ],
                    [
                        'question_id' => 'Mereka <strong>tidak datang</strong> ke pesta.',
                        'answer_en' => 'They did not come to the party.',
                        'vocab_helper' => ['did not come' => 'tidak datang', 'party' => 'pesta']
                    ],
                    [
                        'question_id' => 'Burung itu <strong>tidak bernyanyi</strong> di pagi hari.',
                        'answer_en' => 'The bird does not sing in the morning.',
                        'vocab_helper' => ['does not sing' => 'tidak bernyanyi', 'morning' => 'pagi hari']
                    ],
                    [
                        'question_id' => 'Kami <strong>tidak membawa</strong> payung.',
                        'answer_en' => 'We did not bring an umbrella.',
                        'vocab_helper' => ['did not bring' => 'tidak membawa', 'umbrella' => 'payung']
                    ],
                    [
                        'question_id' => 'Dia <strong>tidak memasak</strong> makan malam.',
                        'answer_en' => 'She does not cook dinner.',
                        'vocab_helper' => ['does not cook' => 'tidak memasak', 'dinner' => 'makan malam']
                    ],
                    [
                        'question_id' => 'Anak-anak <strong>tidak menangis</strong>.',
                        'answer_en' => 'The children did not cry.',
                        'vocab_helper' => ['did not cry' => 'tidak menangis', 'children' => 'anak-anak']
                    ],
                    [
                        'question_id' => 'Saya <strong>tidak merasa</strong> sehat.',
                        'answer_en' => 'I do not feel well.',
                        'vocab_helper' => ['do not feel' => 'tidak merasa', 'well' => 'sehat']
                    ]
                ],
                'paragraph' => [
                    'question_id' => 'Saya <strong>tidak bangun</strong> pagi kemarin. Saya <strong>tidak melihat</strong> alarm saya. Ibu saya tidak marah, tetapi dia <strong>tidak berteriak</strong>. Saya <strong>tidak suka</strong> terlambat ke sekolah, jadi saya <strong>tidak melakukan</strong> kesalahan yang sama hari ini.',
                    'answer_en' => 'I did not wake up early yesterday. I did not see my alarm. My mother was not angry, but she did not yell. I do not like being late to school, so I do not make the same mistake today.',
                    'vocab_helper' => ['did not wake up' => 'tidak bangun', 'did not see' => 'tidak melihat', 'did not yell' => 'tidak berteriak', 'do not like' => 'tidak suka', 'do not make' => 'tidak melakukan']
                ]
            ],
            20 => [
                'questions' => [
                    [
                        'question_id' => '<strong>Apakah</strong> kamu suka kopi?',
                        'answer_en' => 'Do you like coffee?',
                        'vocab_helper' => ['do' => 'apakah', 'like' => 'suka', 'coffee' => 'kopi']
                    ],
                    [
                        'question_id' => '<strong>Di mana</strong> dia tinggal?',
                        'answer_en' => 'Where does he live?',
                        'vocab_helper' => ['where' => 'di mana', 'live' => 'tinggal']
                    ],
                    [
                        'question_id' => '<strong>Kapan</strong> mereka akan tiba?',
                        'answer_en' => 'When will they arrive?',
                        'vocab_helper' => ['when' => 'kapan', 'arrive' => 'tiba']
                    ],
                    [
                        'question_id' => '<strong>Mengapa</strong> dia menangis?',
                        'answer_en' => 'Why is she crying?',
                        'vocab_helper' => ['why' => 'mengapa', 'cry' => 'menangis']
                    ],
                    [
                        'question_id' => '<strong>Siapa</strong> yang membuka pintu?',
                        'answer_en' => 'Who opened the door?',
                        'vocab_helper' => ['who' => 'siapa', 'open' => 'membuka']
                    ],
                    [
                        'question_id' => '<strong>Bagaimana</strong> kabarmu?',
                        'answer_en' => 'How are you?',
                        'vocab_helper' => ['how' => 'bagaimana', 'are you' => 'kabarmu']
                    ],
                    [
                        'question_id' => '<strong>Apa</strong> yang sedang kamu lakukan?',
                        'answer_en' => 'What are you doing?',
                        'vocab_helper' => ['what' => 'apa', 'doing' => 'melakukan']
                    ],
                    [
                        'question_id' => '<strong>Apakah</strong> mereka pergi ke bioskop kemarin?',
                        'answer_en' => 'Did they go to the cinema yesterday?',
                        'vocab_helper' => ['did' => 'apakah', 'go' => 'pergi', 'cinema' => 'bioskop']
                    ],
                    [
                        'question_id' => '<strong>Berapa banyak</strong> buku yang kamu miliki?',
                        'answer_en' => 'How many books do you have?',
                        'vocab_helper' => ['how many' => 'berapa banyak', 'books' => 'buku']
                    ],
                    [
                        'question_id' => '<strong>Apakah</strong> dia seorang dokter?',
                        'answer_en' => 'Is he a doctor?',
                        'vocab_helper' => ['is' => 'apakah', 'doctor' => 'dokter']
                    ],
                    [
                        'question_id' => '<strong>Ke mana</strong> kamu pergi tadi malam?',
                        'answer_en' => 'Where did you go last night?',
                        'vocab_helper' => ['where' => 'ke mana', 'go' => 'pergi', 'last night' => 'tadi malam']
                    ],
                    [
                        'question_id' => '<strong>Jam berapa</strong> kelas dimulai?',
                        'answer_en' => 'What time does the class start?',
                        'vocab_helper' => ['what time' => 'jam berapa', 'start' => 'dimulai']
                    ],
                    [
                        'question_id' => '<strong>Apakah</strong> kamu sudah makan?',
                        'answer_en' => 'Have you eaten?',
                        'vocab_helper' => ['have' => 'apakah sudah', 'eaten' => 'makan']
                    ],
                    [
                        'question_id' => '<strong>Siapa</strong> nama temanmu?',
                        'answer_en' => 'What is your friend\'s name?',
                        'vocab_helper' => ['what' => 'siapa (nama)', 'friend' => 'teman']
                    ],
                    [
                        'question_id' => '<strong>Mengapa</strong> kamu terlambat?',
                        'answer_en' => 'Why are you late?',
                        'vocab_helper' => ['why' => 'mengapa', 'late' => 'terlambat']
                    ],
                    [
                        'question_id' => '<strong>Apakah</strong> ini buku milikmu?',
                        'answer_en' => 'Is this your book?',
                        'vocab_helper' => ['is this' => 'apakah ini', 'your' => 'milikmu']
                    ],
                    [
                        'question_id' => '<strong>Berapa lama</strong> kamu tinggal di sini?',
                        'answer_en' => 'How long have you lived here?',
                        'vocab_helper' => ['how long' => 'berapa lama', 'lived' => 'tinggal']
                    ],
                    [
                        'question_id' => '<strong>Bagaimana</strong> cara membuat kue ini?',
                        'answer_en' => 'How do you make this cake?',
                        'vocab_helper' => ['how' => 'bagaimana', 'make' => 'membuat', 'cake' => 'kue']
                    ],
                    [
                        'question_id' => '<strong>Apakah</strong> mereka sedang bermain?',
                        'answer_en' => 'Are they playing?',
                        'vocab_helper' => ['are' => 'apakah', 'playing' => 'bermain']
                    ],
                    [
                        'question_id' => '<strong>Apa</strong> makanan favoritmu?',
                        'answer_en' => 'What is your favorite food?',
                        'vocab_helper' => ['what' => 'apa', 'favorite' => 'favorit', 'food' => 'makanan']
                    ]
                ],
                'paragraph' => [
                    'question_id' => '<strong>Siapa</strong> yang mengambil buku saya? <strong>Apakah</strong> kamu melihatnya di meja? <strong>Ke mana</strong> perginya buku itu? <strong>Mengapa</strong> hal ini selalu terjadi padaku? <strong>Bisakah</strong> seseorang membantuku mencarinya sekarang?',
                    'answer_en' => 'Who took my book? Did you see it on the desk? Where did the book go? Why does this always happen to me? Can someone help me look for it now?',
                    'vocab_helper' => ['who' => 'siapa', 'did' => 'apakah', 'where' => 'ke mana', 'why' => 'mengapa', 'can' => 'bisakah']
                ]
            ],
            21 => [
                'questions' => [
                    [
                        'question_id' => 'Mobil ini <strong>lebih cepat</strong> daripada mobil itu.',
                        'answer_en' => 'This car is faster than that car.',
                        'vocab_helper' => ['faster' => 'lebih cepat', 'than' => 'daripada']
                    ],
                    [
                        'question_id' => 'Dia adalah siswa <strong>terpintar</strong> di kelas.',
                        'answer_en' => 'He is the smartest student in the class.',
                        'vocab_helper' => ['smartest' => 'terpintar', 'student' => 'siswa']
                    ],
                    [
                        'question_id' => 'Buku ini <strong>lebih menarik</strong> daripada yang itu.',
                        'answer_en' => 'This book is more interesting than that one.',
                        'vocab_helper' => ['more interesting' => 'lebih menarik', 'than' => 'daripada']
                    ],
                    [
                        'question_id' => 'Ini adalah film <strong>terburuk</strong> yang pernah saya tonton.',
                        'answer_en' => 'This is the worst movie I have ever watched.',
                        'vocab_helper' => ['worst' => 'terburuk', 'movie' => 'film']
                    ],
                    [
                        'question_id' => 'Cuaca hari ini <strong>lebih baik</strong> dari kemarin.',
                        'answer_en' => 'The weather today is better than yesterday.',
                        'vocab_helper' => ['better' => 'lebih baik', 'than' => 'dari']
                    ],
                    [
                        'question_id' => 'Gunung Everest adalah gunung <strong>tertinggi</strong> di dunia.',
                        'answer_en' => 'Mount Everest is the highest mountain in the world.',
                        'vocab_helper' => ['highest' => 'tertinggi', 'mountain' => 'gunung']
                    ],
                    [
                        'question_id' => 'Tas saya <strong>lebih berat</strong> daripada tasmu.',
                        'answer_en' => 'My bag is heavier than your bag.',
                        'vocab_helper' => ['heavier' => 'lebih berat', 'than' => 'daripada']
                    ],
                    [
                        'question_id' => 'Dia <strong>lebih tua</strong> dariku.',
                        'answer_en' => 'She is older than me.',
                        'vocab_helper' => ['older' => 'lebih tua', 'than' => 'dari']
                    ],
                    [
                        'question_id' => 'Ini adalah kue <strong>paling lezat</strong>.',
                        'answer_en' => 'This is the most delicious cake.',
                        'vocab_helper' => ['most delicious' => 'paling lezat', 'cake' => 'kue']
                    ],
                    [
                        'question_id' => 'Kamarku <strong>lebih kecil</strong> dari kamarmu.',
                        'answer_en' => 'My room is smaller than your room.',
                        'vocab_helper' => ['smaller' => 'lebih kecil', 'than' => 'dari']
                    ],
                    [
                        'question_id' => 'Siapa pelari <strong>tercepat</strong> di tim?',
                        'answer_en' => 'Who is the fastest runner on the team?',
                        'vocab_helper' => ['fastest' => 'tercepat', 'runner' => 'pelari']
                    ],
                    [
                        'question_id' => 'Masalah ini <strong>lebih sulit</strong> daripada yang pertama.',
                        'answer_en' => 'This problem is more difficult than the first one.',
                        'vocab_helper' => ['more difficult' => 'lebih sulit', 'than' => 'daripada']
                    ],
                    [
                        'question_id' => 'Itu adalah keputusan <strong>terbaik</strong>.',
                        'answer_en' => 'That was the best decision.',
                        'vocab_helper' => ['best' => 'terbaik', 'decision' => 'keputusan']
                    ],
                    [
                        'question_id' => 'Anjing saya <strong>lebih besar</strong> dari anjingnya.',
                        'answer_en' => 'My dog is bigger than his dog.',
                        'vocab_helper' => ['bigger' => 'lebih besar', 'than' => 'dari']
                    ],
                    [
                        'question_id' => 'Dia adalah orang <strong>paling ramah</strong> yang saya kenal.',
                        'answer_en' => 'She is the friendliest person I know.',
                        'vocab_helper' => ['friendliest' => 'paling ramah', 'person' => 'orang']
                    ],
                    [
                        'question_id' => 'Harga gaun ini <strong>lebih mahal</strong>.',
                        'answer_en' => 'The price of this dress is more expensive.',
                        'vocab_helper' => ['more expensive' => 'lebih mahal', 'price' => 'harga']
                    ],
                    [
                        'question_id' => 'Ini adalah jalan <strong>terpanjang</strong> di kota.',
                        'answer_en' => 'This is the longest street in the city.',
                        'vocab_helper' => ['longest' => 'terpanjang', 'street' => 'jalan']
                    ],
                    [
                        'question_id' => 'Ujian hari ini <strong>lebih mudah</strong> dari minggu lalu.',
                        'answer_en' => 'Today\'s exam is easier than last week\'s.',
                        'vocab_helper' => ['easier' => 'lebih mudah', 'than' => 'dari']
                    ],
                    [
                        'question_id' => 'Dia bekerja <strong>lebih keras</strong> daripada saya.',
                        'answer_en' => 'He works harder than me.',
                        'vocab_helper' => ['harder' => 'lebih keras', 'than' => 'daripada']
                    ],
                    [
                        'question_id' => 'Itu adalah momen <strong>paling bahagia</strong> dalam hidupnya.',
                        'answer_en' => 'That was the happiest moment in his life.',
                        'vocab_helper' => ['happiest' => 'paling bahagia', 'moment' => 'momen']
                    ]
                ],
                'paragraph' => [
                    'question_id' => 'Kota saya <strong>lebih besar</strong> daripada desa ini, tetapi desa ini jauh <strong>lebih tenang</strong>. Di kota, gedung-gedungnya adalah yang <strong>tertinggi</strong> dan mobil-mobilnya <strong>lebih cepat</strong>. Meskipun begitu, saya merasa ini adalah tempat <strong>paling damai</strong> untuk bersantai. Liburan di sini adalah pilihan <strong>terbaik</strong>.',
                    'answer_en' => 'My city is bigger than this village, but this village is much quieter. In the city, the buildings are the tallest and the cars are faster. Even so, I feel this is the most peaceful place to relax. A holiday here is the best choice.',
                    'vocab_helper' => ['bigger' => 'lebih besar', 'quieter' => 'lebih tenang', 'tallest' => 'tertinggi', 'faster' => 'lebih cepat', 'most peaceful' => 'paling damai', 'best' => 'terbaik']
                ]
            ],
            22 => [
                'questions' => [
                    [
                        'question_id' => 'Dia <strong>sama tingginya dengan</strong> saudara laki-lakinya.',
                        'answer_en' => 'He is as tall as his brother.',
                        'vocab_helper' => ['as tall as' => 'sama tingginya dengan', 'brother' => 'saudara laki-laki']
                    ],
                    [
                        'question_id' => 'Buku ini <strong>sama menariknya dengan</strong> filmnya.',
                        'answer_en' => 'This book is as interesting as the movie.',
                        'vocab_helper' => ['as interesting as' => 'sama menariknya dengan', 'movie' => 'film']
                    ],
                    [
                        'question_id' => 'Kucing saya <strong>tidak sebesar</strong> anjingmu.',
                        'answer_en' => 'My cat is not as big as your dog.',
                        'vocab_helper' => ['not as big as' => 'tidak sebesar', 'dog' => 'anjing']
                    ],
                    [
                        'question_id' => 'Hari ini <strong>sama panasnya dengan</strong> kemarin.',
                        'answer_en' => 'Today is as hot as yesterday.',
                        'vocab_helper' => ['as hot as' => 'sama panasnya dengan', 'yesterday' => 'kemarin']
                    ],
                    [
                        'question_id' => 'Saya bisa berlari <strong>secepat</strong> kamu.',
                        'answer_en' => 'I can run as fast as you.',
                        'vocab_helper' => ['as fast as' => 'secepat', 'run' => 'berlari']
                    ],
                    [
                        'question_id' => 'Mobil ini <strong>sama mahalnya dengan</strong> rumah itu.',
                        'answer_en' => 'This car is as expensive as that house.',
                        'vocab_helper' => ['as expensive as' => 'sama mahalnya dengan', 'house' => 'rumah']
                    ],
                    [
                        'question_id' => 'Ujian ini <strong>tidak sesulit</strong> yang saya kira.',
                        'answer_en' => 'This exam is not as difficult as I thought.',
                        'vocab_helper' => ['not as difficult as' => 'tidak sesulit', 'thought' => 'kira']
                    ],
                    [
                        'question_id' => 'Kamar ini <strong>sama bersihnya dengan</strong> kamarku.',
                        'answer_en' => 'This room is as clean as my room.',
                        'vocab_helper' => ['as clean as' => 'sama bersihnya dengan', 'room' => 'kamar']
                    ],
                    [
                        'question_id' => 'Dia bekerja <strong>sekeras</strong> ayahnya.',
                        'answer_en' => 'He works as hard as his father.',
                        'vocab_helper' => ['as hard as' => 'sekeras', 'works' => 'bekerja']
                    ],
                    [
                        'question_id' => 'Tas ini <strong>sama beratnya dengan</strong> batu.',
                        'answer_en' => 'This bag is as heavy as a rock.',
                        'vocab_helper' => ['as heavy as' => 'sama beratnya dengan', 'rock' => 'batu']
                    ],
                    [
                        'question_id' => 'Kopi ini <strong>tidak seenak</strong> tehnya.',
                        'answer_en' => 'This coffee is not as good as the tea.',
                        'vocab_helper' => ['not as good as' => 'tidak seenak', 'tea' => 'teh']
                    ],
                    [
                        'question_id' => 'Makanan ini <strong>sama pedasnya dengan</strong> makanan Meksiko.',
                        'answer_en' => 'This food is as spicy as Mexican food.',
                        'vocab_helper' => ['as spicy as' => 'sama pedasnya dengan', 'food' => 'makanan']
                    ],
                    [
                        'question_id' => 'Dia menyanyi <strong>seindah</strong> seorang profesional.',
                        'answer_en' => 'She sings as beautifully as a professional.',
                        'vocab_helper' => ['as beautifully as' => 'seindah', 'sings' => 'menyanyi']
                    ],
                    [
                        'question_id' => 'Saya merasa <strong>sama lelahnya dengan</strong> kamu.',
                        'answer_en' => 'I feel as tired as you.',
                        'vocab_helper' => ['as tired as' => 'sama lelahnya dengan', 'feel' => 'merasa']
                    ],
                    [
                        'question_id' => 'Jalan ini <strong>sepanjang</strong> sungai.',
                        'answer_en' => 'This street is as long as the river.',
                        'vocab_helper' => ['as long as' => 'sepanjang', 'street' => 'jalan']
                    ],
                    [
                        'question_id' => 'Cuaca di sini <strong>tidak sedingin</strong> di Kanada.',
                        'answer_en' => 'The weather here is not as cold as in Canada.',
                        'vocab_helper' => ['not as cold as' => 'tidak sedingin', 'weather' => 'cuaca']
                    ],
                    [
                        'question_id' => 'Dia <strong>sama pintarnya dengan</strong> ibunya.',
                        'answer_en' => 'She is as smart as her mother.',
                        'vocab_helper' => ['as smart as' => 'sama pintarnya dengan', 'mother' => 'ibu']
                    ],
                    [
                        'question_id' => 'Film ini <strong>tidak semembosankan</strong> yang pertama.',
                        'answer_en' => 'This movie is not as boring as the first one.',
                        'vocab_helper' => ['not as boring as' => 'tidak semembosankan', 'movie' => 'film']
                    ],
                    [
                        'question_id' => 'Pemandangannya <strong>sama indahnya dengan</strong> sebuah lukisan.',
                        'answer_en' => 'The scenery is as beautiful as a painting.',
                        'vocab_helper' => ['as beautiful as' => 'sama indahnya dengan', 'scenery' => 'pemandangan']
                    ],
                    [
                        'question_id' => 'Bahasa Inggris <strong>sama pentingnya dengan</strong> Matematika.',
                        'answer_en' => 'English is as important as Math.',
                        'vocab_helper' => ['as important as' => 'sama pentingnya dengan', 'Math' => 'Matematika']
                    ]
                ],
                'paragraph' => [
                    'question_id' => 'Saudara perempuan saya <strong>sama rajinnya dengan</strong> saya. Dia membaca buku <strong>sebanyak</strong> yang saya lakukan setiap bulan. Nilainya <strong>sama baiknya dengan</strong> nilai saya. Terkadang, ujiannya <strong>tidak sesulit</strong> ujian saya, tetapi kami belajar <strong>sekeras</strong> mungkin bersama-sama.',
                    'answer_en' => 'My sister is as diligent as me. She reads as many books as I do every month. Her grades are as good as my grades. Sometimes, her exams are not as difficult as my exams, but we study as hard as possible together.',
                    'vocab_helper' => ['as diligent as' => 'sama rajinnya dengan', 'as many books as' => 'sebanyak', 'as good as' => 'sama baiknya dengan', 'not as difficult as' => 'tidak sesulit', 'as hard as' => 'sekeras']
                ]
            ]
        ];

        foreach ($topics as $topicId => $data) {
            DB::table('grammar_topic_questions')->where('grammar_topic_id', $topicId)->delete();
            
            foreach ($data['questions'] as $q) {
                DB::table('grammar_topic_questions')->insert([
                    'grammar_topic_id' => $topicId,
                    'question_id'      => $q['question_id'],
                    'answer_en'        => $q['answer_en'],
                    'vocab_helper'     => json_encode($q['vocab_helper']),
                    'type' => 'sentence',
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }

            DB::table('grammar_topic_questions')->insert([
                'grammar_topic_id' => $topicId,
                'question_id'      => $data['paragraph']['question_id'],
                'answer_en'        => $data['paragraph']['answer_en'],
                'vocab_helper'     => json_encode($data['paragraph']['vocab_helper']),
                'type' => 'paragraph',
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
    }
}
