<?php

use App\Models\GrammarQuestion;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$questions = [
    1 => [
        'id' => 'Ilmuwan yang menemukan vaksin baru menyelamatkan jutaan nyawa.', 
        'en' => 'The scientist who discovered the new vaccine saved millions of lives',
        'vocab' => [
            'Scientist' => ['id' => 'Ilmuwan', 'pos' => '(n)'],
            'Discover' => ['id' => 'Menemukan', 'pos' => '(v)'],
            'Vaccine' => ['id' => 'Vaksin', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Orang yang menelpon saya tadi adalah ayah saya.',
            'en' => 'The person who called me earlier is my father.'
        ]
    ],
    2 => [
        'id' => 'Penulis yang meneliti sejarah kuno menerbitkan karya monumental.', 
        'en' => 'The writer who researched ancient history published a monumental work',
        'vocab' => [
            'Writer' => ['id' => 'Penulis', 'pos' => '(n)'],
            'Research' => ['id' => 'Meneliti', 'pos' => '(v)'],
            'Ancient' => ['id' => 'Kuno', 'pos' => '(adj)']
        ],
        'example' => [
            'id' => 'Wanita yang tinggal di sebelah rumah saya adalah seorang dokter.',
            'en' => 'The woman who lives next door is a doctor.'
        ]
    ],
    3 => [
        'id' => 'Guru yang mengajar di universitas ternama mendapatkan penghargaan akademik.', 
        'en' => 'The teacher who teaches at a renowned university received an academic award',
        'vocab' => [
            'Renowned' => ['id' => 'Ternama', 'pos' => '(adj)'],
            'University' => ['id' => 'Universitas', 'pos' => '(n)'],
            'Award' => ['id' => 'Penghargaan', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Pria yang bekerja di bank itu adalah paman saya.',
            'en' => 'The man who works at the bank is my uncle.'
        ]
    ],
    4 => [
        'id' => 'Arsitek yang merancang gedung tinggi itu memenangkan kompetisi internasional.', 
        'en' => 'The architect who designed the tall building won an international competition',
        'vocab' => [
            'Architect' => ['id' => 'Arsitek', 'pos' => '(n)'],
            'Design' => ['id' => 'Merancang', 'pos' => '(v)'],
            'Competition' => ['id' => 'Kompetisi', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Siswa yang memenangkan lomba itu sangat pintar.',
            'en' => 'The student who won the competition is very smart.'
        ]
    ],
    5 => [
        'id' => 'Petani yang membudidayakan padi organik berhasil meningkatkan hasil panen.', 
        'en' => 'The farmer who cultivates organic rice successfully increased the harvest yield',
        'vocab' => [
            'Farmer' => ['id' => 'Petani', 'pos' => '(n)'],
            'Cultivate' => ['id' => 'Membudidayakan', 'pos' => '(v)'],
            'Yield' => ['id' => 'Hasil panen', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Orang yang menanam bunga itu suka berkebun.',
            'en' => 'The person who plants the flowers likes gardening.'
        ]
    ],
    6 => [
        'id' => 'Mahasiswa yang mengikuti program pertukaran memperluas wawasan global mereka.', 
        'en' => 'Students who participate in exchange programs expand their global perspectives',
        'vocab' => [
            'Participate' => ['id' => 'Mengikuti/Berpartisipasi', 'pos' => '(v)'],
            'Exchange' => ['id' => 'Pertukaran', 'pos' => '(n)'],
            'Perspective' => ['id' => 'Wawasan/Sudut pandang', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Anak-anak yang bermain di taman terlihat senang.',
            'en' => 'The children who play in the park look happy.'
        ]
    ],
    7 => [
        'id' => 'Dokter yang meneliti penyakit langka mempresentasikan temuannya di konferensi.', 
        'en' => 'The doctor who researches rare diseases presented his findings at a conference',
        'vocab' => [
            'Research' => ['id' => 'Meneliti', 'pos' => '(v)'],
            'Rare' => ['id' => 'Langka', 'pos' => '(adj)'],
            'Conference' => ['id' => 'Konferensi', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Ilmuwan yang mempelajari bintang itu sangat terkenal.',
            'en' => 'The scientist who studies stars is very famous.'
        ]
    ],
    8 => [
        'id' => 'Fisikawan yang mempelajari partikel subatom bekerja di laboratorium khusus.', 
        'en' => 'The physicist who studies subatomic particles works in a special laboratory',
        'vocab' => [
            'Physicist' => ['id' => 'Fisikawan', 'pos' => '(n)'],
            'Particle' => ['id' => 'Partikel', 'pos' => '(n)'],
            'Laboratory' => ['id' => 'Laboratorium', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Guru yang mengajar matematika itu sangat sabar.',
            'en' => 'The teacher who teaches math is very patient.'
        ]
    ],
    9 => [
        'id' => 'Aktivis yang memperjuangkan hak lingkungan diakui dunia internasional.', 
        'en' => 'The activist who fights for environmental rights is recognized internationally',
        'vocab' => [
            'Activist' => ['id' => 'Aktivis', 'pos' => '(n)'],
            'Fight for' => ['id' => 'Memperjuangkan', 'pos' => '(v)'],
            'Recognize' => ['id' => 'Mengakui', 'pos' => '(v)']
        ],
        'example' => [
            'id' => 'Pahlawan yang berjuang untuk kemerdekaan dihormati semua orang.',
            'en' => 'The hero who fought for independence is respected by everyone.'
        ]
    ],
    10 => [
        'id' => 'Seniman yang melukis mural besar itu menginspirasi komunitas lokal.', 
        'en' => 'The artist who painted the large mural inspires the local community',
        'vocab' => [
            'Artist' => ['id' => 'Seniman', 'pos' => '(n)'],
            'Mural' => ['id' => 'Mural/Lukisan dinding', 'pos' => '(n)'],
            'Inspire' => ['id' => 'Menginspirasi', 'pos' => '(v)']
        ],
        'example' => [
            'id' => 'Penulis yang menulis novel itu memenangkan penghargaan.',
            'en' => 'The writer who wrote the novel won an award.'
        ]
    ],
    11 => [
        'id' => 'Para dokter merawat pasien yang menderita penyakit langka.', 
        'en' => 'Doctors treat patients who suffer from rare diseases',
        'vocab' => [
            'Treat' => ['id' => 'Merawat', 'pos' => '(v)'],
            'Suffer' => ['id' => 'Menderita', 'pos' => '(v)'],
            'Disease' => ['id' => 'Penyakit', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Saya membantu orang yang membutuhkan bantuan.',
            'en' => 'I help people who need help.'
        ]
    ],
    12 => [
        'id' => 'Penulis menerbitkan buku yang menguraikan sejarah Asia Tenggara.', 
        'en' => 'The writer published a book that describes the history of Southeast Asia',
        'vocab' => [
            'Publish' => ['id' => 'Menerbitkan', 'pos' => '(v)'],
            'Describe' => ['id' => 'Menguraikan/Menjelaskan', 'pos' => '(v)'],
            'History' => ['id' => 'Sejarah', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Dia membaca artikel yang membahas politik.',
            'en' => 'He reads articles that discuss politics.'
        ]
    ],
    13 => [
        'id' => 'Perusahaan mengembangkan sistem yang meningkatkan keamanan data.', 
        'en' => 'The company develops a system that improves data security',
        'vocab' => [
            'Develop' => ['id' => 'Mengembangkan', 'pos' => '(v)'],
            'Improve' => ['id' => 'Meningkatkan', 'pos' => '(v)'],
            'Security' => ['id' => 'Keamanan', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Mereka membuat aplikasi yang membantu belajar.',
            'en' => 'They create applications that help learning.'
        ]
    ],
    14 => [
        'id' => 'Relawan membantu komunitas yang terdampak bencana alam.', 
        'en' => 'Volunteers help communities that are affected by natural disasters',
        'vocab' => [
            'Volunteer' => ['id' => 'Relawan', 'pos' => '(n)'],
            'Affected' => ['id' => 'Terdampak', 'pos' => '(adj)'],
            'Disaster' => ['id' => 'Bencana', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Kami menyumbang ke panti asuhan yang membutuhkan dana.',
            'en' => 'We donate to orphanages that need funds.'
        ]
    ],
    15 => [
        'id' => 'Universitas membuka fakultas baru yang memfokuskan pada teknologi lingkungan.', 
        'en' => 'The university opens a new faculty that focuses on environmental technology',
        'vocab' => [
            'Faculty' => ['id' => 'Fakultas', 'pos' => '(n)'],
            'Focus' => ['id' => 'Memfokuskan', 'pos' => '(v)'],
            'Environment' => ['id' => 'Lingkungan', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Sekolah menawarkan program yang mengajarkan koding.',
            'en' => 'The school offers programs that teach coding.'
        ]
    ],
    16 => [
        'id' => 'Penjelajah mendaki gunung yang diselimuti salju abadi.', 
        'en' => 'The explorer climbs the mountain that is covered with eternal snow',
        'vocab' => [
            'Explorer' => ['id' => 'Penjelajah', 'pos' => '(n)'],
            'Climb' => ['id' => 'Mendaki', 'pos' => '(v)'],
            'Covered' => ['id' => 'Diselimuti', 'pos' => '(adj)']
        ],
        'example' => [
            'id' => 'Burung itu terbang di atas pohon yang tinggi.',
            'en' => 'The bird flies over the tree that is tall.'
        ]
    ],
    17 => [
        'id' => 'Seniman menciptakan mural yang menggambarkan keragaman budaya.', 
        'en' => 'The artist creates a mural that depicts cultural diversity',
        'vocab' => [
            'Create' => ['id' => 'Menciptakan', 'pos' => '(v)'],
            'Depict' => ['id' => 'Menggambarkan', 'pos' => '(v)'],
            'Diversity' => ['id' => 'Keragaman', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Dia melukis gambar yang menunjukkan keindahan alam.',
            'en' => 'She paints pictures that show the beauty of nature.'
        ]
    ],
    18 => [
        'id' => 'Perpustakaan menyimpan koleksi yang berasal dari abad pertengahan.', 
        'en' => 'The library stores collections that originate from the Middle Ages',
        'vocab' => [
            'Store' => ['id' => 'Menyimpan', 'pos' => '(v)'],
            'Collection' => ['id' => 'Koleksi', 'pos' => '(n)'],
            'Originate' => ['id' => 'Berasal', 'pos' => '(v)']
        ],
        'example' => [
            'id' => 'Museum memamerkan benda yang berusia ribuan tahun.',
            'en' => 'The museum exhibits items that are thousands of years old.'
        ]
    ],
    19 => [
        'id' => 'Arkeolog menggali situs yang menunjukkan pola pemukiman kuno.', 
        'en' => 'Archaeologists excavate sites that show ancient settlement patterns',
        'vocab' => [
            'Excavate' => ['id' => 'Menggali', 'pos' => '(v)'],
            'Site' => ['id' => 'Situs', 'pos' => '(n)'],
            'Settlement' => ['id' => 'Pemukiman', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Mereka menemukan reruntuhan yang menceritakan sejarah kota.',
            'en' => 'They found ruins that tell the history of the city.'
        ]
    ],
    20 => [
        'id' => 'Pusat riset meluncurkan proyek yang menargetkan pemulihan ekosistem laut.', 
        'en' => 'The research center launches a project that targets marine ecosystem recovery',
        'vocab' => [
            'Launch' => ['id' => 'Meluncurkan', 'pos' => '(v)'],
            'Target' => ['id' => 'Menargetkan', 'pos' => '(v)'],
            'Recovery' => ['id' => 'Pemulihan', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Pemerintah memulai program yang membantu orang miskin.',
            'en' => 'The government started a program that helps the poor.'
        ]
    ]
];

$paragraph = [
    'id' => 'Para arkeolog baru-baru ini menggali situs kuno yang menunjukkan pola pemukiman awal di daerah pesisir. Di sekitar lokasi itu, mereka menemukan peralatan batu yang digunakan untuk berburu hewan kecil. Temuan ini kemudian dikaitkan dengan catatan sejarah, termasuk naskah kuno yang menjelaskan migrasi manusia dari satu pulau ke pulau lain. Di sisi lain, para peneliti juga mempelajari fosil hewan laut yang menandakan perubahan iklim ribuan tahun lalu. Semua data tersebut dikumpulkan ke dalam laporan ilmiah yang dipublikasikan oleh lembaga riset internasional. Selain itu, perpustakaan universitas menyimpan koleksi manuskrip yang berasal dari abad pertengahan dan memberikan konteks tambahan pada penelitian ini. Para mahasiswa membaca dokumen yang memuat deskripsi perjalanan para pedagang kuno, sementara dosen mereka menyiapkan analisis yang menyoroti hubungan perdagangan dengan perkembangan budaya lokal. Dengan demikian, proyek lintas disiplin ini menciptakan sebuah gambaran sejarah yang memperlihatkan interaksi manusia dengan lingkungannya secara lebih jelas.',
    'en' => 'Archaeologists recently excavated ancient sites that show early settlement patterns in coastal areas. Around that location, they found stone tools that were used to hunt small animals. These findings were then linked to historical records, including ancient manuscripts that explain human migration from one island to another. On the other hand, researchers also studied marine animal fossils that indicate climate change thousands of years ago. All of that data was collected into a scientific report that was published by an international research institution. In addition, the university library stores manuscript collections that originate from the Middle Ages and provide additional context to this research. Students read documents that contain descriptions of ancient merchant journeys, while their lecturers prepare analyses that highlight the relationship between trade and local cultural development. Thus, this interdisciplinary project creates a historical picture that shows human interaction with their environment more clearly.',
    'vocab' => [
        'Archaeologist' => 'Arkeolog',
        'Excavate' => 'Menggali',
        'Settlement pattern' => 'Pola pemukiman',
        'Coastal area' => 'Daerah pesisir',
        'Stone tool' => 'Peralatan batu',
        'Hunt' => 'Berburu',
        'Manuscript' => 'Naskah/manuskrip',
        'Migration' => 'Migrasi',
        'Fossil' => 'Fosil',
        'Climate change' => 'Perubahan iklim',
        'Scientific report' => 'Laporan ilmiah',
        'Research institution' => 'Lembaga riset',
        'Middle Ages' => 'Abad pertengahan',
        'Merchant' => 'Pedagang',
        'Analysis' => 'Analisis',
        'Trade' => 'Perdagangan',
        'Cultural development' => 'Perkembangan budaya',
        'Interdisciplinary' => 'Lintas disiplin',
        'Interaction' => 'Interaksi'
    ]
];

// Check existing data
$existing = GrammarQuestion::where('meeting_number', 14)->count();
if ($existing > 0) {
    echo "Deleting existing data for Meeting 14 to re-seed...\n";
    GrammarQuestion::where('meeting_number', 14)->delete();
}

// Insert Questions
foreach ($questions as $num => $q) {
    GrammarQuestion::create([
        'meeting_number' => 14,
        'question_number' => $num,
        'question_text' => $q['id'],
        'correct_answer' => $q['en'],
        'vocab' => $q['vocab'],
        'example_id' => $q['example']['id'],
        'example_en' => $q['example']['en'],
    ]);
}
echo "Inserted " . count($questions) . " questions.\n";

// Insert Paragraph
GrammarQuestion::create([
    'meeting_number' => 14,
    'question_number' => 100,
    'section' => 'paragraph',
    'question_type' => 'paragraph',
    'question_text' => $paragraph['id'],
    'correct_answer' => $paragraph['en'],
    'vocab' => $paragraph['vocab'],
]);
echo "Inserted paragraph.\n";
