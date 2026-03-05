<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflReadingMeeting;
use App\Models\ToeflReadingPassage;
use App\Models\ToeflReadingQuestion;

class ToeflReadingMeeting11Seeder extends Seeder
{
    public function run()
    {
        // Get or create Meeting 11
        $meeting = ToeflReadingMeeting::where('meeting_number', 11)->first();
        
        if (!$meeting) {
            $meeting = ToeflReadingMeeting::create([
                'meeting_number' => 11,
                'title' => 'Reference Questions',
                'is_locked' => false
            ]);
        }

        // These are reference questions - each sentence is a mini passage
        // Question 1
        $passage1 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 1,
            'content' => "Detergents clean clothes by first removing particles of dirt from the fabric, then suspending the particles until <u>they</u> can be washed away.",
            'indonesian_translation' => "Deterjen membersihkan pakaian dengan terlebih dahulu menghilangkan partikel kotoran dari kain, kemudian menangguhkan partikel tersebut sampai mereka dapat dicuci."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage1->id,
            'question_number' => 1,
            'question_text' => 'What does "they" refer to?',
            'option_a' => 'clothes',
            'option_b' => 'particles of dirt',
            'option_c' => 'detergents',
            'option_d' => '',
            'correct_answer' => 'B'
        ]);

        // Question 2
        $passage2 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 2,
            'content' => "Wooly mammoths were hunted by big cats called sabertooth tigers, which also became extinct by the end of the last Ice Age. <u>They</u> were also hunted by early men armed with spears and clubs.",
            'indonesian_translation' => "Mammoth berbulu diburu oleh kucing besar yang disebut harimau sabertooth, yang juga punah pada akhir Zaman Es terakhir. Mereka juga diburu oleh manusia awal yang bersenjatakan tombak dan pentungan."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage2->id,
            'question_number' => 2,
            'question_text' => 'What does "They" refer to?',
            'option_a' => 'sabertooth tigers',
            'option_b' => 'early men',
            'option_c' => 'wooly mammoths',
            'option_d' => '',
            'correct_answer' => 'C'
        ]);

        // Question 3
        $passage3 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 3,
            'content' => "X-rays allow art historians to examine paintings internally without damaging <u>them</u>.",
            'indonesian_translation' => "Sinar-X memungkinkan sejarawan seni untuk memeriksa lukisan secara internal tanpa merusaknya."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage3->id,
            'question_number' => 3,
            'question_text' => 'What does "them" refer to?',
            'option_a' => 'x-rays',
            'option_b' => 'art historians',
            'option_c' => 'paintings',
            'option_d' => '',
            'correct_answer' => 'C'
        ]);

        // Question 4
        $passage4 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 4,
            'content' => "There is a New England influence in southern Ohio, manifesting <u>itself</u> in white churches and village greens.",
            'indonesian_translation' => "Ada pengaruh New England di Ohio selatan, yang memanifestasikan dirinya dalam gereja putih dan taman desa."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage4->id,
            'question_number' => 4,
            'question_text' => 'What does "itself" refer to?',
            'option_a' => 'a New England influence',
            'option_b' => 'southern Ohio',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        // Question 5
        $passage5 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 5,
            'content' => "Florists often refrigerate cut flowers to protect <u>their</u> fresh appearance.",
            'indonesian_translation' => "Penjual bunga sering mendinginkan bunga potong untuk melindungi penampilan segar mereka."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage5->id,
            'question_number' => 5,
            'question_text' => 'What does "their" refer to?',
            'option_a' => 'florists\'',
            'option_b' => 'flowers\'',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'B'
        ]);

        // Question 6
        $passage6 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 6,
            'content' => "A flat kite needs a tail to supply drag and to keep the kite pointed toward the sky. A simple <u>one</u> consists of cloth strips tied end to end.",
            'indonesian_translation' => "Layang-layang datar membutuhkan ekor untuk menyediakan hambatan dan untuk menjaga layang-layang mengarah ke langit. Yang sederhana terdiri dari strip kain yang diikat ujung ke ujung."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage6->id,
            'question_number' => 6,
            'question_text' => 'What does "one" refer to?',
            'option_a' => 'kite',
            'option_b' => 'tail',
            'option_c' => 'sky',
            'option_d' => '',
            'correct_answer' => 'B'
        ]);

        // Question 7
        $passage7 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 7,
            'content' => "A number of sculptors have rejected the abstractions of minimalist artists. <u>These</u> sculptors have developed a style of extreme realism involving ordinary subjects.",
            'indonesian_translation' => "Sejumlah pematung telah menolak abstraksi seniman minimalis. Pematung-pematung ini telah mengembangkan gaya realisme ekstrem yang melibatkan subjek biasa."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage7->id,
            'question_number' => 7,
            'question_text' => 'What does "These sculptors" refer to?',
            'option_a' => 'extreme realists',
            'option_b' => 'minimalists',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        // Question 8
        $passage8 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 8,
            'content' => "Water is an exception to many of nature's rules because of <u>its</u> unusual properties.",
            'indonesian_translation' => "Air adalah pengecualian untuk banyak aturan alam karena sifat-sifatnya yang tidak biasa."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage8->id,
            'question_number' => 8,
            'question_text' => 'What does "its" refer to?',
            'option_a' => 'nature\'s',
            'option_b' => 'water\'s',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'B'
        ]);

        // Question 9
        $passage9 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 9,
            'content' => "Compound bows are popular with bow hunters, but <u>they</u> are not permitted in international archery competitions.",
            'indonesian_translation' => "Busur majemuk populer dengan pemburu busur, tetapi mereka tidak diizinkan dalam kompetisi panahan internasional."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage9->id,
            'question_number' => 9,
            'question_text' => 'What does "they" refer to?',
            'option_a' => 'bow hunters',
            'option_b' => 'compound bows',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'B'
        ]);

        // Question 10
        $passage10 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 10,
            'content' => "Ropes are cords at least .15 inches in diameter and are made of three or more strands <u>which</u> are themselves formed of twisted yarns.",
            'indonesian_translation' => "Tali adalah kabel setidaknya 0,15 inci diameter dan terbuat dari tiga atau lebih untaian yang sendiri dibentuk dari benang yang dipilin."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage10->id,
            'question_number' => 10,
            'question_text' => 'What does "which" refer to?',
            'option_a' => 'yarns',
            'option_b' => 'ropes',
            'option_c' => 'strands',
            'option_d' => '',
            'correct_answer' => 'C'
        ]);

        // Question 11
        $passage11 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 11,
            'content' => "Grocers slice sides, quarters, and what are called primal cuts of beef into smaller pieces. <u>These</u> pieces are called retail cuts.",
            'indonesian_translation' => "Pedagang grosir mengiris sisi, seperempat, dan apa yang disebut potongan utama daging sapi menjadi potongan yang lebih kecil. Potongan-potongan ini disebut potongan ritel."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage11->id,
            'question_number' => 11,
            'question_text' => 'What does "These" refer to?',
            'option_a' => 'smaller pieces',
            'option_b' => 'sides, quarters, and primal cuts',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        // Question 12
        $passage12 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 12,
            'content' => "Leaves are found on all deciduous trees, but <u>they</u> differ greatly in size and shape.",
            'indonesian_translation' => "Daun ditemukan di semua pohon gugur, tetapi mereka sangat berbeda dalam ukuran dan bentuk."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage12->id,
            'question_number' => 12,
            'question_text' => 'What does "they" refer to?',
            'option_a' => 'trees',
            'option_b' => 'leaves',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'B'
        ]);

        // Question 13
        $passage13 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 13,
            'content' => "Yasuo Kuniyashi was born in Japan in 1883 and studied art at the Los Angeles School of Art and Design. He also studied art in New York City, where he gave his first one-man show. In 1925 he moved from <u>there</u> to Paris where he was influenced by the works of Chagall and other artists.",
            'indonesian_translation' => "Yasuo Kuniyashi lahir di Jepang pada tahun 1883 dan belajar seni di Los Angeles School of Art and Design. Ia juga belajar seni di New York City, di mana ia memberikan pertunjukan satu orang pertamanya. Pada tahun 1925 ia pindah dari sana ke Paris di mana ia dipengaruhi oleh karya-karya Chagall dan seniman lainnya."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage13->id,
            'question_number' => 13,
            'question_text' => 'What does "there" refer to?',
            'option_a' => 'Japan',
            'option_b' => 'Paris',
            'option_c' => 'Los Angeles',
            'option_d' => 'New York City',
            'correct_answer' => 'D'
        ]);

        // Question 14
        $passage14 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 14,
            'content' => "In the past, biologists considered mushrooms and other fungi as a type of non-green plant. Today, however, <u>they</u> are most commonly regarded as a separate kingdom of living things.",
            'indonesian_translation' => "Di masa lalu, ahli biologi menganggap jamur dan fungi lainnya sebagai jenis tanaman non-hijau. Namun hari ini, mereka paling umum dianggap sebagai kerajaan terpisah dari makhluk hidup."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage14->id,
            'question_number' => 14,
            'question_text' => 'What does "they" refer to?',
            'option_a' => 'mushrooms and other fungi',
            'option_b' => 'biologists',
            'option_c' => 'plants',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        // Question 15
        $passage15 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 15,
            'content' => "William Dean Howells, a contemporary and friend of Mark Twain, wrote a number of books that realistically portrayed life on farms in Midwestern America. One of his followers, Hamlin Garland, was even more bitter in his criticism of rural America than <u>his</u> mentor.",
            'indonesian_translation' => "William Dean Howells, seorang kontemporer dan teman Mark Twain, menulis sejumlah buku yang secara realistis menggambarkan kehidupan di pertanian di Midwestern America. Salah satu pengikutnya, Hamlin Garland, bahkan lebih pahit dalam kritiknya terhadap Amerika pedesaan daripada mentornya."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage15->id,
            'question_number' => 15,
            'question_text' => 'What does "his" refer to?',
            'option_a' => 'Hamlin Garland',
            'option_b' => 'Mark Twain',
            'option_c' => 'William Dean Howells',
            'option_d' => '',
            'correct_answer' => 'C'
        ]);

        // Question 16
        $passage16 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 16,
            'content' => "The Wisconsin Dells is a region where the Wisconsin River cuts through soft sandstone. The strange formations that have been carved out of the rocks <u>there</u> are a delight to tourists. They have names such as Devil's Elbow, Grand Piano, and Fat Man's Misery.",
            'indonesian_translation' => "Wisconsin Dells adalah wilayah di mana Sungai Wisconsin memotong batu pasir lunak. Formasi aneh yang telah diukir dari batu di sana adalah kesenangan bagi wisatawan. Mereka memiliki nama seperti Devil's Elbow, Grand Piano, dan Fat Man's Misery."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage16->id,
            'question_number' => 16,
            'question_text' => 'What does "there" refer to?',
            'option_a' => 'strange formations',
            'option_b' => 'tourists',
            'option_c' => 'rocks',
            'option_d' => '',
            'correct_answer' => 'C'
        ]);

        // Question 17
        $passage17 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 17,
            'content' => "The lives of beetles are divided into four stages, as are <u>those</u> of wasps, ants, and butterflies.",
            'indonesian_translation' => "Kehidupan kumbang dibagi menjadi empat tahap, seperti halnya kehidupan tawon, semut, dan kupu-kupu."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage17->id,
            'question_number' => 17,
            'question_text' => 'What does "those" refer to?',
            'option_a' => 'lives',
            'option_b' => 'stages',
            'option_c' => 'insects',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        // Question 18
        $passage18 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 18,
            'content' => "After electron microscopes were invented, scientists found many new viruses. Some of <u>them</u> were round, some oval, and some corkscrew-shaped.",
            'indonesian_translation' => "Setelah mikroskop elektron ditemukan, para ilmuwan menemukan banyak virus baru. Beberapa dari mereka bulat, beberapa oval, dan beberapa berbentuk pembuka botol."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage18->id,
            'question_number' => 18,
            'question_text' => 'What does "them" refer to?',
            'option_a' => 'electron microscopes',
            'option_b' => 'viruses',
            'option_c' => 'scientists',
            'option_d' => '',
            'correct_answer' => 'B'
        ]);

        // Question 19
        $passage19 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 19,
            'content' => "The detailed information in maps is now produced almost entirely from satellite photography rather than by ground surveying because <u>this method</u> is faster, cheaper, and more accurate.",
            'indonesian_translation' => "Informasi rinci dalam peta sekarang diproduksi hampir seluruhnya dari fotografi satelit daripada dengan survei darat karena metode ini lebih cepat, lebih murah, dan lebih akurat."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage19->id,
            'question_number' => 19,
            'question_text' => 'What does "this method" refer to?',
            'option_a' => 'satellite photography',
            'option_b' => 'ground surveying',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A'
        ]);

        // Question 20
        $passage20 = ToeflReadingPassage::create([
            'meeting_id' => $meeting->id,
            'passage_number' => 20,
            'content' => "An elephant is bigger than a mouse because it has trillions more cells, not because <u>its</u> cells are any bigger.",
            'indonesian_translation' => "Gajah lebih besar dari tikus karena memiliki triliunan sel lebih banyak, bukan karena selnya lebih besar."
        ]);

        ToeflReadingQuestion::create([
            'passage_id' => $passage20->id,
            'question_number' => 20,
            'question_text' => 'What does "its" refer to?',
            'option_a' => 'a mouse\'s',
            'option_b' => 'an elephant\'s',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'B'
        ]);

        $this->command->info('TOEFL Reading Meeting 11 seeded successfully!');
    }
}
