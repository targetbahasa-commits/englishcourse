<?php

use App\Models\GrammarQuestion;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$questions = [
    1 => [
        'id' => 'Saya akan menunggumu di sini sampai kamu menyelesaikan tugasmu.',
        'en' => 'I will wait for you here until you finish your task',
        'type' => 'time',
        'conjunction' => 'until (sampai)',
        'example' => ['id' => 'Kami belajar sampai perpustakaan tutup.', 'en' => 'We studied until the library closed.'],
        'vocab' => [
            'Wait' => ['id' => 'Menunggu', 'pos' => '(v)'],
            'Task' => ['id' => 'Tugas', 'pos' => '(n)'],
            'Finish' => ['id' => 'Menyelesaikan', 'pos' => '(v)'],
            'Here' => ['id' => 'Di sini', 'pos' => '(adv)']
        ]
    ],
    2 => [
        'id' => 'Piramida Mesir dibangun ketika peradaban kuno masih sangat kuat.',
        'en' => 'The Egyptian pyramids were built when the ancient civilization was still very strong',
        'type' => 'time',
        'conjunction' => 'when (ketika)',
        'example' => ['id' => 'Dia menelepon ketika saya sedang tidur.', 'en' => 'He called when I was sleeping.'],
        'vocab' => [
            'Ancient' => ['id' => 'Kuno', 'pos' => '(adj)'],
            'Pyramid' => ['id' => 'Piramida', 'pos' => '(n)'],
            'Civilization' => ['id' => 'Peradaban', 'pos' => '(n)'],
            'Collapse' => ['id' => 'Runtuh', 'pos' => '(v)']
        ]
    ],
    3 => [
        'id' => 'Penyebaran ilmu pengetahuan terbatas, sebelum mesin cetak Gutenberg diperkenalkan di Eropa.',
        'en' => 'The spread of knowledge was limited, before the Gutenberg printing press was introduced in Europe',
        'type' => 'time',
        'conjunction' => 'before (sebelum)',
        'example' => ['id' => 'Cuci tangan sebelum kamu makan.', 'en' => 'Wash your hands before you eat.'],
        'vocab' => [
            'Spread' => ['id' => 'Penyebaran', 'pos' => '(n)'],
            'Knowledge' => ['id' => 'Ilmu pengetahuan', 'pos' => '(n)'],
            'Limited' => ['id' => 'Terbatas', 'pos' => '(adj)'],
            'Printing press' => ['id' => 'Mesin cetak', 'pos' => '(n)'],
            'Introduce' => ['id' => 'Diperkenalkan', 'pos' => '(v)']
        ]
    ],
    4 => [
        'id' => 'Pola kerja manusia berubah drastis setelah revolusi industri dimulai di Inggris.',
        'en' => 'Human work patterns changed drastically after the industrial revolution began in England',
        'type' => 'time',
        'conjunction' => 'after (setelah)',
        'example' => ['id' => 'Dia pergi setelah rapat selesai.', 'en' => 'He left after the meeting ended.'],
        'vocab' => [
            'Pattern' => ['id' => 'Pola', 'pos' => '(n)'],
            'Work' => ['id' => 'Kerja', 'pos' => '(n)'],
            'Change' => ['id' => 'Berubah', 'pos' => '(v)'],
            'Drastically' => ['id' => 'Drastis', 'pos' => '(adv)'],
            'Industrial revolution' => ['id' => 'Revolusi industri', 'pos' => '(n)']
        ]
    ],
    5 => [
        'id' => 'Pemahaman tentang tata surya semakin akurat sejak astronomi berkembang sebagai ilmu modern.',
        'en' => 'Understanding of the solar system became increasingly accurate since astronomy developed as a modern science',
        'type' => 'time',
        'conjunction' => 'since (sejak)',
        'example' => ['id' => 'Saya tinggal di sini sejak tahun 2020.', 'en' => 'I have lived here since 2020.'],
        'vocab' => [
            'Understanding' => ['id' => 'Pemahaman', 'pos' => '(n)'],
            'Solar system' => ['id' => 'Tata surya', 'pos' => '(n)'],
            'Accurate' => ['id' => 'Akurat', 'pos' => '(adj)'],
            'Astronomy' => ['id' => 'Astronomi', 'pos' => '(n)'],
            'Modern' => ['id' => 'Modern', 'pos' => '(adj)']
        ]
    ],
    6 => [
        'id' => 'Epidemi luas sering terjadi sampai vaksin berhasil ditemukan.',
        'en' => 'Widespread epidemics often occurred until vaccines were successfully discovered',
        'type' => 'time',
        'conjunction' => 'until (sampai)',
        'example' => ['id' => 'Tunggu sampai hujan berhenti.', 'en' => 'Wait until the rain stops.'],
        'vocab' => [
            'Epidemic' => ['id' => 'Epidemi', 'pos' => '(n)'],
            'Widespread' => ['id' => 'Luas', 'pos' => '(adj)'],
            'Occur' => ['id' => 'Terjadi', 'pos' => '(v)'],
            'Vaccine' => ['id' => 'Vaksin', 'pos' => '(n)'],
            'Discover' => ['id' => 'Ditemukan', 'pos' => '(v)']
        ]
    ],
    7 => [
        'id' => 'Produktivitas industri meningkat signifikan segera setelah listrik diperkenalkan di kota besar.',
        'en' => 'Industrial productivity increased significantly as soon as electricity was introduced in big cities',
        'type' => 'time',
        'conjunction' => 'as soon as (segera setelah)',
        'example' => ['id' => 'Hubungi saya segera setelah kamu tiba.', 'en' => 'Contact me as soon as you arrive.'],
        'vocab' => [
            'Productivity' => ['id' => 'Produktivitas', 'pos' => '(n)'],
            'Industrial' => ['id' => 'Industri', 'pos' => '(adj)'],
            'Increase' => ['id' => 'Meningkat', 'pos' => '(v)'],
            'Significantly' => ['id' => 'Signifikan', 'pos' => '(adv)'],
            'Electricity' => ['id' => 'Listrik', 'pos' => '(n)']
        ]
    ],
    8 => [
        'id' => 'Banyak masyarakat tinggal di sekitar gunung berapi karena tanah di sekitarnya sangat subur.',
        'en' => 'Many communities live around volcanoes because the surrounding soil is very fertile',
        'type' => 'cause',
        'conjunction' => 'because (karena)',
        'example' => ['id' => 'Dia tidak datang karena dia sakit.', 'en' => 'He did not come because he was sick.'],
        'vocab' => [
            'Community' => ['id' => 'Masyarakat', 'pos' => '(n)'],
            'Volcano' => ['id' => 'Gunung berapi', 'pos' => '(n)'],
            'Surrounding' => ['id' => 'Sekitar', 'pos' => '(adj)'],
            'Soil' => ['id' => 'Tanah', 'pos' => '(n)'],
            'Fertile' => ['id' => 'Subur', 'pos' => '(adj)']
        ]
    ],
    9 => [
        'id' => 'Teori heliosentris akhirnya diterima sebagai dasar ilmu astronomi, meskipun awalnya ditolak.',
        'en' => 'The heliocentric theory was finally accepted as the basis of astronomy, although it was initially rejected',
        'type' => 'contrast',
        'conjunction' => 'although (meskipun)',
        'example' => ['id' => 'Dia tetap bekerja meskipun dia lelah.', 'en' => 'He kept working although he was tired.'],
        'vocab' => [
            'Heliocentric' => ['id' => 'Heliosentris', 'pos' => '(adj)'],
            'Theory' => ['id' => 'Teori', 'pos' => '(n)'],
            'Accept' => ['id' => 'Diterima', 'pos' => '(v)'],
            'Basis' => ['id' => 'Dasar', 'pos' => '(n)'],
            'Reject' => ['id' => 'Ditolak', 'pos' => '(v)']
        ]
    ],
    10 => [
        'id' => 'Para penjelajah berhasil menyeberangi Samudra Pasifik, walaupun lautannya sangat luas.',
        'en' => 'Explorers successfully crossed the Pacific Ocean, although the ocean was very vast',
        'type' => 'contrast',
        'conjunction' => 'although (walaupun)',
        'example' => ['id' => 'Dia lulus walaupun jarang belajar.', 'en' => 'He passed although he rarely studied.'],
        'vocab' => [
            'Explorer' => ['id' => 'Penjelajah', 'pos' => '(n)'],
            'Successfully' => ['id' => 'Berhasil', 'pos' => '(adv)'],
            'Cross' => ['id' => 'Menyeberangi', 'pos' => '(v)'],
            'Ocean' => ['id' => 'Samudra', 'pos' => '(n)'],
            'Vast' => ['id' => 'Luas', 'pos' => '(adj)']
        ]
    ],
    11 => [
        'id' => 'Keanekaragaman hayati dapat bertahan jika hutan hujan tropis tetap terjaga.',
        'en' => 'Biodiversity can survive if tropical rainforests remain preserved',
        'type' => 'condition',
        'conjunction' => 'if (jika)',
        'example' => ['id' => 'Jika hujan, saya akan di rumah.', 'en' => 'If it rains, I will stay home.'],
        'vocab' => [
            'Biodiversity' => ['id' => 'Keanekaragaman hayati', 'pos' => '(n)'],
            'Survive' => ['id' => 'Bertahan', 'pos' => '(v)'],
            'Tropical' => ['id' => 'Tropis', 'pos' => '(adj)'],
            'Rainforest' => ['id' => 'Hutan hujan', 'pos' => '(n)'],
            'Preserve' => ['id' => 'Terjaga', 'pos' => '(v)']
        ]
    ],
    12 => [
        'id' => 'Populasi ikan menurun drastis kecuali jika konservasi laut dilakukan secara serius.',
        'en' => 'Fish populations decline drastically unless marine conservation is carried out seriously',
        'type' => 'condition',
        'conjunction' => 'unless (kecuali jika)',
        'example' => ['id' => 'Kamu akan gagal kecuali jika kamu belajar.', 'en' => 'You will fail unless you study.'],
        'vocab' => [
            'Population' => ['id' => 'Populasi', 'pos' => '(n)'],
            'Decline' => ['id' => 'Menurun', 'pos' => '(v)'],
            'Marine' => ['id' => 'Laut', 'pos' => '(adj)'],
            'Conservation' => ['id' => 'Konservasi', 'pos' => '(n)'],
            'Carry out' => ['id' => 'Dilakukan', 'pos' => '(v)']
        ]
    ],
    13 => [
        'id' => 'Teknologi satelit dikembangkan agar komunikasi antarnegara menjadi lebih mudah.',
        'en' => 'Satellite technology was developed so that communication between countries became easier',
        'type' => 'purpose',
        'conjunction' => 'so that (agar)',
        'example' => ['id' => 'Dia belajar keras agar bisa lulus.', 'en' => 'He studies hard so that he can pass.'],
        'vocab' => [
            'Satellite' => ['id' => 'Satelit', 'pos' => '(n)'],
            'Technology' => ['id' => 'Teknologi', 'pos' => '(n)'],
            'Develop' => ['id' => 'Dikembangkan', 'pos' => '(v)'],
            'Communication' => ['id' => 'Komunikasi', 'pos' => '(n)'],
            'Easier' => ['id' => 'Lebih mudah', 'pos' => '(adj)']
        ]
    ],
    14 => [
        'id' => 'Interaksi budaya meningkat pesat di mana pun jalur perdagangan internasional terbuka.',
        'en' => 'Cultural interaction increased rapidly wherever international trade routes opened',
        'type' => 'place',
        'conjunction' => 'wherever (di mana pun)',
        'example' => ['id' => 'Dia pergi ke mana pun dia mau.', 'en' => 'He goes wherever he wants.'],
        'vocab' => [
            'Interaction' => ['id' => 'Interaksi', 'pos' => '(n)'],
            'Cultural' => ['id' => 'Budaya', 'pos' => '(adj)'],
            'Trade route' => ['id' => 'Jalur perdagangan', 'pos' => '(n)'],
            'International' => ['id' => 'Internasional', 'pos' => '(adj)'],
            'Open' => ['id' => 'Terbuka', 'pos' => '(v)']
        ]
    ],
    15 => [
        'id' => 'Kota Petra terlihat seakan keluar dari tebing batu, seolah-olah arsitekturnya terukir secara alami.',
        'en' => 'The city of Petra looks as if it emerges from the rock cliffs, as if its architecture was carved naturally',
        'type' => 'manner',
        'conjunction' => 'as if (seolah-olah)',
        'example' => ['id' => 'Dia bertingkah seolah-olah dia raja.', 'en' => 'He acts as if he is a king.'],
        'vocab' => [
            'Emerge' => ['id' => 'Keluar', 'pos' => '(v)'],
            'Rock cliff' => ['id' => 'Tebing batu', 'pos' => '(n)'],
            'Architecture' => ['id' => 'Arsitektur', 'pos' => '(n)'],
            'Carve' => ['id' => 'Terukir', 'pos' => '(v)'],
            'Naturally' => ['id' => 'Secara alami', 'pos' => '(adv)']
        ]
    ]
];

$paragraph = [
    'id' => 'Perkembangan teknologi terus mengalami percepatan sejak revolusi industri dimulai di Eropa. Inovasi dalam bidang komunikasi semakin penting ketika mesin telegraf diperkenalkan pada abad ke-19. Internet menjadi tonggak besar, karena ia menghubungkan miliaran manusia dalam waktu nyata. Penyebaran informasi menjadi semakin cepat, walaupun masih terdapat kesenjangan digital di beberapa wilayah. Penelitian ilmiah pun berkembang pesat, agar masyarakat dapat memperoleh solusi atas tantangan global yang semakin kompleks.',
    'en' => 'Technological development has continued to accelerate since the industrial revolution began in Europe. Innovation in the field of communication became increasingly important when the telegraph machine was introduced in the 19th century. The internet became a major milestone, because it connects billions of humans in real time. The spread of information became increasingly fast, although there is still a digital divide in some regions. Scientific research also developed rapidly, so that society can obtain solutions to increasingly complex global challenges.',
    'vocab' => [
        'Technological development' => 'Perkembangan teknologi',
        'Accelerate' => 'Mengalami percepatan',
        'Industrial revolution' => 'Revolusi industri',
        'Innovation' => 'Inovasi',
        'Communication' => 'Komunikasi',
        'Telegraph machine' => 'Mesin telegraf',
        'Milestone' => 'Tonggak besar',
        'Connect' => 'Menghubungkan',
        'Real time' => 'Waktu nyata',
        'Spread of information' => 'Penyebaran informasi',
        'Digital divide' => 'Kesenjangan digital',
        'Scientific research' => 'Penelitian ilmiah',
        'Solution' => 'Solusi',
        'Challenge' => 'Tantangan',
        'Complex' => 'Kompleks'
    ]
];

// Meeting 12
$count = GrammarQuestion::where('meeting_number', 12)->count();
if ($count > 0) {
    echo "Meeting 12 data likely exists ($count records). Skipping.\n";
} else {
    foreach ($questions as $num => $q) {
        GrammarQuestion::create([
            'meeting_number' => 12,
            'question_number' => $num,
            'question_text' => $q['id'],
            'correct_answer' => $q['en'],
            'vocab' => $q['vocab'],
            'example' => $q['example'], // Saved as JSON array
            'structure' => $q['type'], // 'time', 'cause', etc.
            'formula' => $q['conjunction'], // Storing conjunction here
            'section' => 'default' // Explicitly set section 
        ]);
    }

    // Paragraph
    GrammarQuestion::create([
        'meeting_number' => 12,
        'question_number' => 100,
        'question_text' => $paragraph['id'],
        'correct_answer' => $paragraph['en'],
        'vocab' => $paragraph['vocab'],
        'section' => 'paragraph'
    ]);

    echo "Migrated Meeting 12 data.\n";
}
