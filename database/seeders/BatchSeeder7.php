<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BatchSeeder7 extends Seeder
{
    public function run()
    {
        $topics = [33, 34, 35, 36, 37];
        DB::table('grammar_topic_questions')->whereIn('grammar_topic_id', $topics)->delete();

        $questions = [];

        // Topic 33: Suffixes
        $t33 = [
            ["<strong>Kebaikan</strong> itu gratis.", "<strong>Kindness</strong> is free.", '{"kebaikan": "kindness", "gratis": "free"}'],
            ["Dia menunjukkan <strong>perkembangan</strong> yang bagus.", "He shows good <strong>development</strong>.", '{"perkembangan": "development", "bagus": "good"}'],
            ["Ini sangat <strong>membantu</strong>.", "This is very <strong>helpful</strong>.", '{"sangat": "very", "membantu": "helpful"}'],
            ["Anak itu sangat <strong>ceroboh</strong>.", "The child is very <strong>careless</strong>.", '{"ceroboh": "careless", "anak": "child"}'],
            ["Saya butuh <strong>kebebasan</strong>.", "I need <strong>freedom</strong>.", '{"kebebasan": "freedom", "butuh": "need"}'],
            ["Keputusannya masuk <strong>akal</strong>.", "His decision is <strong>reasonable</strong>.", '{"keputusan": "decision", "masuk akal": "reasonable"}'],
            ["Itu adalah sebuah <strong>pencapaian</strong> besar.", "That was a big <strong>achievement</strong>.", '{"pencapaian": "achievement", "besar": "big"}'],
            ["<strong>Persahabatan</strong> sangat berharga.", "<strong>Friendship</strong> is precious.", '{"persahabatan": "friendship", "berharga": "precious"}'],
            ["Dia menderita <strong>penyakit</strong>.", "He suffers from an <strong>illness</strong>.", '{"penyakit": "illness", "menderita": "suffer"}'],
            ["Apakah kamu <strong>nyaman</strong>?", "Are you <strong>comfortable</strong>?", '{"nyaman": "comfortable"}'],
            ["Itu adalah situasi yang <strong>berbahaya</strong>.", "It was a <strong>dangerous</strong> situation.", '{"berbahaya": "dangerous", "situasi": "situation"}'],
            ["Kami menghargai <strong>kejujuranmu</strong>.", "We appreciate your <strong>honesty</strong>.", '{"kejujuran": "honesty", "menghargai": "appreciate"}'],
            ["<strong>Keberhasilan</strong> membutuhkan kerja keras.", "<strong>Success</strong> requires hard work.", '{"keberhasilan": "success", "kerja keras": "hard work"}'],
            ["Ini adalah mesin yang <strong>berguna</strong>.", "This is a <strong>useful</strong> machine.", '{"berguna": "useful", "mesin": "machine"}'],
            ["Mereka merayakan <strong>kemenangan</strong>.", "They celebrated the <strong>victory</strong>.", '{"kemenangan": "victory", "merayakan": "celebrate"}'],
            ["Malam itu <strong>tanpa tidur</strong>.", "The night was <strong>sleepless</strong>.", '{"tanpa tidur": "sleepless"}'],
            ["<strong>Kegembiraan</strong> terlihat di wajahnya.", "<strong>Happiness</strong> was visible on his face.", '{"kegembiraan": "happiness", "terlihat": "visible"}'],
            ["<strong>Manajemen</strong> perusahaan ini bagus.", "The <strong>management</strong> of this company is good.", '{"manajemen": "management", "perusahaan": "company"}'],
            ["Saya butuh sedikit <strong>hiburan</strong>.", "I need some <strong>entertainment</strong>.", '{"hiburan": "entertainment", "sedikit": "some"}'],
            ["Dia memiliki <strong>kelemahan</strong>.", "He has a <strong>weakness</strong>.", '{"kelemahan": "weakness"}'],
        ];

        foreach ($t33 as $q) {
            $questions[] = [
                'grammar_topic_id' => 33,
                'question_id' => $q[0],
                'answer_en' => $q[1],
                'vocab_helper' => $q[2],
                'type' => 'sentence',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $questions[] = [
            'grammar_topic_id' => 33,
            'question_id' => "Perkembangan (development) teknologi membawa banyak kegembiraan (happiness). Namun, kita tidak boleh ceroboh (careless). Persahabatan (friendship) lebih berharga dari pada hiburan (entertainment) yang berbahaya (dangerous).",
            'answer_en' => "The development of technology brings much happiness. However, we must not be careless. Friendship is more precious than dangerous entertainment.",
            'vocab_helper' => '{"perkembangan": "development", "kegembiraan": "happiness", "ceroboh": "careless", "persahabatan": "friendship", "hiburan": "entertainment", "berbahaya": "dangerous"}',
            'type' => 'paragraph',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Topic 34: Prefixes
        $t34 = [
            ["Dia <strong>menulis ulang</strong> esainya.", "He <strong>rewrote</strong> his essay.", '{"menulis ulang": "rewrite/rewrote", "esai": "essay"}'],
            ["Tolong jangan <strong>salah paham</strong>.", "Please do not <strong>misunderstand</strong>.", '{"salah paham": "misunderstand"}'],
            ["Ini sangat <strong>tidak biasa</strong>.", "This is very <strong>unusual</strong>.", '{"tidak biasa": "unusual"}'],
            ["Tindakan itu <strong>ilegal</strong>.", "The action was <strong>illegal</strong>.", '{"ilegal": "illegal", "tindakan": "action"}'],
            ["Mereka <strong>tidak setuju</strong> dengan saya.", "They <strong>disagree</strong> with me.", '{"tidak setuju": "disagree"}'],
            ["Kisah ini benar-benar <strong>luar biasa</strong>.", "This story is truly <strong>extraordinary</strong>.", '{"luar biasa": "extraordinary", "benar-benar": "truly"}'],
            ["Kamu <strong>membaca salah</strong> pertanyaannya.", "You <strong>misread</strong> the question.", '{"membaca salah": "misread"}'],
            ["Saya harus <strong>membangun kembali</strong> rumah ini.", "I must <strong>rebuild</strong> this house.", '{"membangun kembali": "rebuild"}'],
            ["Informasi itu <strong>tidak akurat</strong>.", "The information was <strong>inaccurate</strong>.", '{"tidak akurat": "inaccurate"}'],
            ["Kamar ini sangat <strong>berantakan</strong>.", "This room is very <strong>untidy</strong>.", '{"berantakan/tidak rapi": "untidy", "kamar": "room"}'],
            ["Itu adalah sikap yang <strong>tidak sopan</strong>.", "It was an <strong>impolite</strong> attitude.", '{"tidak sopan": "impolite", "sikap": "attitude"}'],
            ["Dia <strong>menghilang</strong> ke dalam kegelapan.", "He <strong>disappeared</strong> into the darkness.", '{"menghilang": "disappear", "kegelapan": "darkness"}'],
            ["Pekerjaan ini <strong>belum selesai</strong>.", "This work is <strong>unfinished</strong>.", '{"belum selesai": "unfinished"}'],
            ["Kata sandi itu <strong>salah</strong>.", "The password is <strong>incorrect</strong>.", '{"salah/tidak benar": "incorrect"}'],
            ["Guru itu melakukan <strong>pratinjau</strong>.", "The teacher did a <strong>preview</strong>.", '{"pratinjau": "preview"}'],
            ["Jangan <strong>menyesatkan</strong> mereka.", "Do not <strong>mislead</strong> them.", '{"menyesatkan": "mislead"}'],
            ["Langkah ini <strong>mustahil</strong>.", "This step is <strong>impossible</strong>.", '{"mustahil": "impossible", "langkah": "step"}'],
            ["Dia memiliki keuntungan <strong>prabayar</strong>.", "He has a <strong>prepaid</strong> advantage.", '{"prabayar": "prepaid", "keuntungan": "advantage"}'],
            ["Rencana itu <strong>tidak adil</strong>.", "The plan is <strong>unfair</strong>.", '{"tidak adil": "unfair", "rencana": "plan"}'],
            ["Saya perlu <strong>mengisi ulang</strong> baterai saya.", "I need to <strong>recharge</strong> my battery.", '{"mengisi ulang": "recharge"}'],
        ];

        foreach ($t34 as $q) {
            $questions[] = [
                'grammar_topic_id' => 34,
                'question_id' => $q[0],
                'answer_en' => $q[1],
                'vocab_helper' => $q[2],
                'type' => 'sentence',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $questions[] = [
            'grammar_topic_id' => 34,
            'question_id' => "Sangat tidak biasa (unusual) baginya untuk tidak setuju (disagree). Dia salah paham (misunderstood) pesannya dan menulis ulang (rewrote) balasannya. Keputusan akhirnya tidak akurat (inaccurate).",
            'answer_en' => "It is very unusual for him to disagree. He misunderstood the message and rewrote his reply. The final decision was inaccurate.",
            'vocab_helper' => '{"tidak biasa": "unusual", "tidak setuju": "disagree", "salah paham": "misunderstand", "menulis ulang": "rewrite", "tidak akurat": "inaccurate"}',
            'type' => 'paragraph',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Topic 35: Regular Vs Irregular Verb
        $t35 = [
            ["Saya <strong>bermain</strong> sepak bola dan <strong>pergi</strong> ke taman.", "I <strong>played</strong> football and <strong>went</strong> to the park.", '{"bermain": "play/played", "pergi": "go/went"}'],
            ["Mereka <strong>belajar</strong> keras dan <strong>memenangkan</strong> pertandingan.", "They <strong>studied</strong> hard and <strong>won</strong> the game.", '{"belajar": "study/studied", "memenangkan": "win/won"}'],
            ["Dia <strong>makan</strong> malam lalu <strong>berjalan</strong> pulang.", "He <strong>ate</strong> dinner then <strong>walked</strong> home.", '{"makan": "eat/ate", "berjalan": "walk/walked"}'],
            ["Kami <strong>menonton</strong> film dan <strong>minum</strong> jus.", "We <strong>watched</strong> a movie and <strong>drank</strong> juice.", '{"menonton": "watch/watched", "minum": "drink/drank"}'],
            ["Saya <strong>melihat</strong> anjing itu dan <strong>memanggil</strong> namanya.", "I <strong>saw</strong> the dog and <strong>called</strong> its name.", '{"melihat": "see/saw", "memanggil": "call/called"}'],
            ["Dia <strong>membeli</strong> buku itu dan <strong>membacanya</strong>.", "She <strong>bought</strong> the book and <strong>read</strong> it.", '{"membeli": "buy/bought", "membaca": "read/read"}'],
            ["Burung itu <strong>terbang</strong> dan <strong>mendarat</strong> di pohon.", "The bird <strong>flew</strong> and <strong>landed</strong> on the tree.", '{"terbang": "fly/flew", "mendarat": "land/landed"}'],
            ["Kami <strong>bekerja</strong> sepanjang hari dan <strong>tidur</strong> nyenyak.", "We <strong>worked</strong> all day and <strong>slept</strong> soundly.", '{"bekerja": "work/worked", "tidur": "sleep/slept"}'],
            ["Dia <strong>membuka</strong> kotak itu dan <strong>menemukan</strong> kunci.", "He <strong>opened</strong> the box and <strong>found</strong> a key.", '{"membuka": "open/opened", "menemukan": "find/found"}'],
            ["Saya <strong>berbicara</strong> dengannya lalu <strong>mendengarkan</strong>.", "I <strong>spoke</strong> with him then <strong>listened</strong>.", '{"berbicara": "speak/spoke", "mendengarkan": "listen/listened"}'],
            ["Mereka <strong>berlari</strong> cepat dan <strong>melewati</strong> garis.", "They <strong>ran</strong> fast and <strong>passed</strong> the line.", '{"berlari": "run/ran", "melewati": "pass/passed"}'],
            ["Anak itu <strong>menangis</strong> lalu <strong>merasa</strong> lebih baik.", "The child <strong>cried</strong> then <strong>felt</strong> better.", '{"menangis": "cry/cried", "merasa": "feel/felt"}'],
            ["Dia <strong>menggambar</strong> gambar itu dan <strong>mewarnainya</strong>.", "She <strong>drew</strong> the picture and <strong>colored</strong> it.", '{"menggambar": "draw/drew", "mewarnai": "color/colored"}'],
            ["Kami <strong>tiba</strong> di sana dan <strong>duduk</strong>.", "We <strong>arrived</strong> there and <strong>sat</strong>.", '{"tiba": "arrive/arrived", "duduk": "sit/sat"}'],
            ["Guru itu <strong>tersenyum</strong> dan <strong>mengajar</strong> kelas.", "The teacher <strong>smiled</strong> and <strong>taught</strong> the class.", '{"tersenyum": "smile/smiled", "mengajar": "teach/taught"}'],
            ["Saya <strong>menulis</strong> surat itu dan <strong>mengirimkannya</strong>.", "I <strong>wrote</strong> the letter and <strong>mailed</strong> it.", '{"menulis": "write/wrote", "mengirimkan": "mail/mailed"}'],
            ["Kucing itu <strong>melompat</strong> dan <strong>menangkap</strong> tikus.", "The cat <strong>jumped</strong> and <strong>caught</strong> the mouse.", '{"melompat": "jump/jumped", "menangkap": "catch/caught"}'],
            ["Dia <strong>membangun</strong> rumah dan <strong>mengecatnya</strong>.", "He <strong>built</strong> a house and <strong>painted</strong> it.", '{"membangun": "build/built", "mengecat": "paint/painted"}'],
            ["Saya <strong>membayar</strong> tagihan dan <strong>meninggalkan</strong> toko.", "I <strong>paid</strong> the bill and <strong>left</strong> the store.", '{"membayar": "pay/paid", "meninggalkan": "leave/left"}'],
            ["Mereka <strong>berdiri</strong> dan <strong>bertepuk tangan</strong>.", "They <strong>stood</strong> and <strong>clapped</strong>.", '{"berdiri": "stand/stood", "bertepuk tangan": "clap/clapped"}'],
        ];

        foreach ($t35 as $q) {
            $questions[] = [
                'grammar_topic_id' => 35,
                'question_id' => $q[0],
                'answer_en' => $q[1],
                'vocab_helper' => $q[2],
                'type' => 'sentence',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $questions[] = [
            'grammar_topic_id' => 35,
            'question_id' => "Kemarin, saya pergi (went) ke museum dan belajar (studied) sejarah. Saya melihat (saw) banyak hal dan berjalan (walked) selama berjam-jam. Setelah itu, saya merasa (felt) lelah dan beristirahat (rested).",
            'answer_en' => "Yesterday, I went to the museum and studied history. I saw many things and walked for hours. After that, I felt tired and rested.",
            'vocab_helper' => '{"pergi": "go/went", "belajar": "study/studied", "melihat": "see/saw", "berjalan": "walk/walked", "merasa": "feel/felt", "beristirahat": "rest/rested"}',
            'type' => 'paragraph',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Topic 36: Participle
        $t36 = [
            ["<strong>Bayi yang menangis</strong> itu butuh susu.", "The <strong>crying baby</strong> needs milk.", '{"bayi yang menangis": "crying baby", "susu": "milk"}'],
            ["Saya sangat <strong>tertarik</strong> pada sejarah.", "I am very <strong>interested</strong> in history.", '{"tertarik": "interested", "sejarah": "history"}'],
            ["<strong>Jendela yang pecah</strong> telah diperbaiki.", "The <strong>broken window</strong> has been repaired.", '{"jendela yang pecah": "broken window", "diperbaiki": "repaired"}'],
            ["Ini adalah buku yang <strong>membosankan</strong>.", "This is a <strong>boring</strong> book.", '{"membosankan": "boring"}'],
            ["Kami melihat <strong>bintang jatuh</strong>.", "We saw a <strong>falling star</strong>.", '{"bintang jatuh": "falling star"}'],
            ["Saya merasa sangat <strong>lelah</strong>.", "I feel very <strong>tired</strong>.", '{"lelah": "tired"}'],
            ["Pria itu membersihkan <strong>daun-daun yang gugur</strong>.", "The man cleaned the <strong>fallen leaves</strong>.", '{"daun yang gugur": "fallen leaves"}'],
            ["Film itu sangat <strong>menarik</strong>.", "The movie was very <strong>interesting</strong>.", '{"menarik": "interesting"}'],
            ["Tolong buang <strong>kertas yang robek</strong> itu.", "Please throw away the <strong>torn paper</strong>.", '{"kertas yang robek": "torn paper"}'],
            ["Dia bercerita tentang <strong>harta karun yang tersembunyi</strong>.", "He told a story about <strong>hidden treasure</strong>.", '{"harta karun yang tersembunyi": "hidden treasure"}'],
            ["Apakah kamu takut pada <strong>anjing yang menggonggong</strong>?", "Are you afraid of a <strong>barking dog</strong>?", '{"anjing yang menggonggong": "barking dog", "takut": "afraid"}'],
            ["Anak laki-laki yang <strong>bersemangat</strong> itu melompat.", "The <strong>excited</strong> boy jumped.", '{"bersemangat": "excited"}'],
            ["Cerita itu sangat <strong>menakutkan</strong>.", "The story was very <strong>frightening</strong>.", '{"menakutkan": "frightening"}'],
            ["Kami minum dari <strong>botol yang dicuci</strong>.", "We drank from the <strong>washed bottle</strong>.", '{"botol yang dicuci": "washed bottle"}'],
            ["<strong>Air yang mendidih</strong> itu panas.", "The <strong>boiling water</strong> is hot.", '{"air yang mendidih": "boiling water"}'],
            ["Saya melihat <strong>mobil yang dicuri</strong>.", "I saw the <strong>stolen car</strong>.", '{"mobil yang dicuri": "stolen car"}'],
            ["Gadis itu tampak <strong>bingung</strong>.", "The girl looked <strong>confused</strong>.", '{"bingung": "confused"}'],
            ["Instruksi yang <strong>membingungkan</strong> itu menyulitkan.", "The <strong>confusing</strong> instructions made it difficult.", '{"membingungkan": "confusing", "menyulitkan": "make difficult"}'],
            ["Kami membeli <strong>sayuran beku</strong>.", "We bought <strong>frozen vegetables</strong>.", '{"sayuran beku": "frozen vegetables"}'],
            ["Orang tuanya <strong>terkejut</strong>.", "His parents were <strong>surprised</strong>.", '{"terkejut": "surprised"}'],
        ];

        foreach ($t36 as $q) {
            $questions[] = [
                'grammar_topic_id' => 36,
                'question_id' => $q[0],
                'answer_en' => $q[1],
                'vocab_helper' => $q[2],
                'type' => 'sentence',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $questions[] = [
            'grammar_topic_id' => 36,
            'question_id' => "Film yang membosankan (boring movie) itu membuat saya merasa lelah (tired). Namun, teman saya sangat tertarik (interested). Kami meninggalkan bioskop dan melihat beberapa daun yang gugur (fallen leaves) di tanah.",
            'answer_en' => "The boring movie made me feel tired. However, my friend was very interested. We left the cinema and saw some fallen leaves on the ground.",
            'vocab_helper' => '{"membosankan": "boring", "lelah": "tired", "tertarik": "interested", "daun yang gugur": "fallen leaves"}',
            'type' => 'paragraph',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Topic 37: Noun Phrase
        $t37 = [
            ["<strong>Mobil merah besar yang indah</strong> itu milik saya.", "<strong>That beautiful big red car</strong> is mine.", '{"mobil merah besar yang indah": "beautiful big red car", "milik saya": "mine"}'],
            ["Saya melihat <strong>dua kucing hitam</strong>.", "I saw <strong>two black cats</strong>.", '{"dua kucing hitam": "two black cats"}'],
            ["<strong>Gadis pintar di kelasku</strong> mendapat nilai A.", "<strong>The smart girl in my class</strong> got an A.", '{"gadis pintar di kelasku": "smart girl in my class"}'],
            ["Kami membeli <strong>buku sejarah kuno</strong>.", "We bought <strong>an ancient history book</strong>.", '{"buku sejarah kuno": "ancient history book"}'],
            ["<strong>Pria tinggi yang berdiri di sana</strong> adalah ayahku.", "<strong>The tall man standing there</strong> is my father.", '{"pria tinggi yang berdiri di sana": "tall man standing there"}'],
            ["Mereka tinggal di <strong>rumah kayu yang kecil</strong>.", "They live in <strong>a small wooden house</strong>.", '{"rumah kayu yang kecil": "small wooden house"}'],
            ["Itu adalah <strong>ide yang sangat bagus</strong>.", "That is <strong>a very good idea</strong>.", '{"ide yang sangat bagus": "very good idea"}'],
            ["<strong>Anjing cokelat yang menggonggong keras</strong> berlari.", "<strong>The brown dog barking loudly</strong> ran.", '{"anjing cokelat yang menggonggong keras": "brown dog barking loudly"}'],
            ["Saya membutuhkan <strong>komputer baru yang cepat</strong>.", "I need <strong>a fast new computer</strong>.", '{"komputer baru yang cepat": "fast new computer"}'],
            ["<strong>Tiga apel hijau di atas meja</strong> itu manis.", "<strong>The three green apples on the table</strong> are sweet.", '{"tiga apel hijau di atas meja": "three green apples on the table"}'],
            ["Kami memakan <strong>kue cokelat yang lezat</strong>.", "We ate <strong>a delicious chocolate cake</strong>.", '{"kue cokelat yang lezat": "delicious chocolate cake"}'],
            ["<strong>Cuaca dingin di pagi hari</strong> membuatku malas.", "<strong>The cold weather in the morning</strong> makes me lazy.", '{"cuaca dingin di pagi hari": "cold weather in the morning"}'],
            ["Dia membawa <strong>tas kulit hitam</strong>.", "He brought <strong>a black leather bag</strong>.", '{"tas kulit hitam": "black leather bag"}'],
            ["<strong>Bunga kuning yang cantik ini</strong> untukmu.", "<strong>This beautiful yellow flower</strong> is for you.", '{"bunga kuning yang cantik": "beautiful yellow flower"}'],
            ["Saya menemukan <strong>kotak kayu tua</strong>.", "I found <strong>an old wooden box</strong>.", '{"kotak kayu tua": "old wooden box"}'],
            ["<strong>Wanita tua dengan kacamata</strong> itu tersenyum.", "<strong>The old woman with glasses</strong> smiled.", '{"wanita tua dengan kacamata": "old woman with glasses"}'],
            ["Mereka mendaki <strong>gunung bersalju yang tinggi</strong>.", "They climbed <strong>a high snowy mountain</strong>.", '{"gunung bersalju yang tinggi": "high snowy mountain"}'],
            ["Kami minum <strong>segelas air dingin</strong>.", "We drank <strong>a glass of cold water</strong>.", '{"segelas air dingin": "glass of cold water"}'],
            ["<strong>Sebuah kota modern yang besar</strong> sangat sibuk.", "<strong>A large modern city</strong> is very busy.", '{"kota modern yang besar": "large modern city"}'],
            ["Dia memiliki <strong>suara yang sangat merdu</strong>.", "She has <strong>a very sweet voice</strong>.", '{"suara yang sangat merdu": "very sweet voice"}'],
        ];

        foreach ($t37 as $q) {
            $questions[] = [
                'grammar_topic_id' => 37,
                'question_id' => $q[0],
                'answer_en' => $q[1],
                'vocab_helper' => $q[2],
                'type' => 'sentence',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $questions[] = [
            'grammar_topic_id' => 37,
            'question_id' => "Pria tua yang baik hati (the kind old man) memberi saya sebuah kotak kayu kecil (a small wooden box). Di dalamnya ada sebuah cincin emas kuno (an ancient gold ring).",
            'answer_en' => "The kind old man gave me a small wooden box. Inside it was an ancient gold ring.",
            'vocab_helper' => '{"pria tua yang baik hati": "kind old man", "sebuah kotak kayu kecil": "small wooden box", "cincin emas kuno": "ancient gold ring"}',
            'type' => 'paragraph',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('grammar_topic_questions')->insert($questions);
    }
}
