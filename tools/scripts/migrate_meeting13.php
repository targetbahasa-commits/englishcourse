<?php

use App\Models\GrammarQuestion;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$questions = [
    1 => [
        'id' => 'Para penduduk desa, yang pemerintah dukung selama krisis, membangun rumah baru bersama-sama.', 
        'en' => 'The villagers, who the government supported during the crisis, built new houses together',
        'vocab' => [
            'Villagers' => ['id' => 'Penduduk desa', 'pos' => '(n)'],
            'Support' => ['id' => 'Mendukung', 'pos' => '(v)'],
            'Crisis' => ['id' => 'Krisis', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Siswa yang guru puji itu sangat senang.',
            'en' => 'The student who the teacher praised was very happy.'
        ]
    ],
    2 => [
        'id' => 'Museum itu menampilkan artefak, yang para arkeolog temukan di gua, kepada masyarakat umum.', 
        'en' => 'The museum displays artifacts, which archaeologists found in caves, to the general public',
        'vocab' => [
            'Display' => ['id' => 'Menampilkan', 'pos' => '(v)'],
            'Artifact' => ['id' => 'Artefak', 'pos' => '(n)'],
            'Archaeologist' => ['id' => 'Arkeolog', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Buku yang saya beli kemarin sangat menarik.',
            'en' => 'The book which I bought yesterday is very interesting.'
        ]
    ],
    3 => [
        'id' => 'Siswa yang panitia pilih untuk penghargaan dipuji oleh gurunya.', 
        'en' => 'The student who the committee selected for the award was praised by his teacher',
        'vocab' => [
            'Committee' => ['id' => 'Panitia', 'pos' => '(n)'],
            'Select' => ['id' => 'Memilih', 'pos' => '(v)'],
            'Award' => ['id' => 'Penghargaan', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Buku yang dia tulis sangat populer.',
            'en' => 'The book which he wrote is very popular.'
        ]
    ],
    4 => [
        'id' => 'Pulau itu, yang banyak wisatawan kunjungi tahun lalu, menjadi lebih populer musim panas ini.', 
        'en' => 'The island, which many tourists visited last year, became more popular this summer',
        'vocab' => [
            'Island' => ['id' => 'Pulau', 'pos' => '(n)'],
            'Tourist' => ['id' => 'Wisatawan', 'pos' => '(n)'],
            'Popular' => ['id' => 'Populer', 'pos' => '(adj)']
        ],
        'example' => [
            'id' => 'Kota yang kami kunjungi sangat indah.',
            'en' => 'The city which we visited is very beautiful.'
        ]
    ],
    5 => [
        'id' => 'Jembatan yang banjir rusak parah diperbaiki oleh insinyur.', 
        'en' => 'The bridge that the flood severely damaged was repaired by engineers',
        'vocab' => [
            'Bridge' => ['id' => 'Jembatan', 'pos' => '(n)'],
            'Flood' => ['id' => 'Banjir', 'pos' => '(n)'],
            'Damage' => ['id' => 'Merusak', 'pos' => '(v)']
        ],
        'example' => [
            'id' => 'Mobil yang kecelakaan itu rusak parah.',
            'en' => 'The car that the accident damaged was severely broken.'
        ]
    ],
    6 => [
        'id' => 'Hasil panen, yang para pembeli minta dalam jumlah besar, dijual dengan cepat oleh petani.', 
        'en' => 'The harvest, which buyers requested in large quantities, was sold quickly by farmers',
        'vocab' => [
            'Harvest' => ['id' => 'Hasil panen', 'pos' => '(n)'],
            'Buyer' => ['id' => 'Pembeli', 'pos' => '(n)'],
            'Request' => ['id' => 'Meminta', 'pos' => '(v)']
        ],
        'example' => [
            'id' => 'Produk yang pelanggan minta sudah tersedia.',
            'en' => 'The product which customers requested is available.'
        ]
    ],
    7 => [
        'id' => 'Naskah kuno yang para biksu simpan selama berabad-abad kini ada di koleksi sejarawan.', 
        'en' => 'The ancient manuscript that monks kept for centuries is now in the historian\'s collection',
        'vocab' => [
            'Manuscript' => ['id' => 'Naskah', 'pos' => '(n)'],
            'Monk' => ['id' => 'Biksu', 'pos' => '(n)'],
            'Century' => ['id' => 'Abad', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Surat yang dia simpan sangat berharga.',
            'en' => 'The letter that she kept is very valuable.'
        ]
    ],
    8 => [
        'id' => 'Kandidat itu, yang direktur rekomendasikan, akhirnya diterima oleh perusahaan.', 
        'en' => 'The candidate, who the director recommended, was finally accepted by the company',
        'vocab' => [
            'Candidate' => ['id' => 'Kandidat', 'pos' => '(n)'],
            'Director' => ['id' => 'Direktur', 'pos' => '(n)'],
            'Recommend' => ['id' => 'Merekomendasikan', 'pos' => '(v)']
        ],
        'example' => [
            'id' => 'Karyawan yang manajer promosikan bekerja sangat keras.',
            'en' => 'The employee who the manager promoted works very hard.'
        ]
    ],
    9 => [
        'id' => 'Konser itu, yang orkestra bawakan dengan indah, membuat penonton terpesona.', 
        'en' => 'The concert, which the orchestra performed beautifully, mesmerized the audience',
        'vocab' => [
            'Concert' => ['id' => 'Konser', 'pos' => '(n)'],
            'Orchestra' => ['id' => 'Orkestra', 'pos' => '(n)'],
            'Perform' => ['id' => 'Membawakan', 'pos' => '(v)']
        ],
        'example' => [
            'id' => 'Lagu yang penyanyi nyanyikan sangat menyentuh.',
            'en' => 'The song which the singer sang was very touching.'
        ]
    ],
    10 => [
        'id' => 'Buku yang peneliti cari selama ini ditemukan oleh pustakawan.', 
        'en' => 'The book that the researcher had been looking for was found by the librarian',
        'vocab' => [
            'Researcher' => ['id' => 'Peneliti', 'pos' => '(n)'],
            'Look for' => ['id' => 'Mencari', 'pos' => '(v)'],
            'Librarian' => ['id' => 'Pustakawan', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Kunci yang saya cari ada di meja.',
            'en' => 'The key that I was looking for is on the table.'
        ]
    ],
    11 => [
        'id' => 'Proyek itu, yang para relawan selenggarakan, mendapat dukungan kuat dari masyarakat.', 
        'en' => 'The project, which volunteers organized, received strong support from the community',
        'vocab' => [
            'Volunteer' => ['id' => 'Relawan', 'pos' => '(n)'],
            'Organize' => ['id' => 'Menyelenggarakan', 'pos' => '(v)'],
            'Support' => ['id' => 'Dukungan', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Acara yang siswa adakan berjalan lancar.',
            'en' => 'The event which students held went smoothly.'
        ]
    ],
    12 => [
        'id' => 'Pembicara yang kepala sekolah sangat hormati memberi inspirasi banyak siswa.', 
        'en' => 'The speaker who the principal highly respects inspires many students',
        'vocab' => [
            'Speaker' => ['id' => 'Pembicara', 'pos' => '(n)'],
            'Principal' => ['id' => 'Kepala sekolah', 'pos' => '(n)'],
            'Respect' => ['id' => 'Menghormati', 'pos' => '(v)']
        ],
        'example' => [
            'id' => 'Guru yang kami hormati akan pensiun.',
            'en' => 'The teacher who we respect will retire.'
        ]
    ],
    13 => [
        'id' => 'Taman itu, yang pemerintah bangun baru-baru ini, menarik anak-anak dari lingkungan sekitar.', 
        'en' => 'The park, which the government built recently, attracts children from the surrounding neighborhood',
        'vocab' => [
            'Park' => ['id' => 'Taman', 'pos' => '(n)'],
            'Government' => ['id' => 'Pemerintah', 'pos' => '(n)'],
            'Attract' => ['id' => 'Menarik', 'pos' => '(v)']
        ],
        'example' => [
            'id' => 'Gedung yang mereka bangun sangat tinggi.',
            'en' => 'The building which they built is very tall.'
        ]
    ],
    14 => [
        'id' => 'Pengobatan yang para pasien butuhkan dengan segera dijelaskan oleh dokter.', 
        'en' => 'The treatment that patients urgently needed was explained by the doctor',
        'vocab' => [
            'Treatment' => ['id' => 'Pengobatan', 'pos' => '(n)'],
            'Patient' => ['id' => 'Pasien', 'pos' => '(n)'],
            'Urgently' => ['id' => 'Dengan segera', 'pos' => '(adv)']
        ],
        'example' => [
            'id' => 'Bantuan yang korban butuhkan segera datang.',
            'en' => 'The help that victims needed arrived soon.'
        ]
    ],
    15 => [
        'id' => 'Medali itu, yang para juri berikan dengan adil, memotivasi atlet untuk berlatih lebih keras.', 
        'en' => 'The medal, which the judges awarded fairly, motivates athletes to train harder',
        'vocab' => [
            'Medal' => ['id' => 'Medali', 'pos' => '(n)'],
            'Judge' => ['id' => 'Juri', 'pos' => '(n)'],
            'Award' => ['id' => 'Memberikan/Menganugerahkan', 'pos' => '(v)']
        ],
        'example' => [
            'id' => 'Hadiah yang panitia berikan sangat bagus.',
            'en' => 'The prize which the committee gave was very good.'
        ]
    ],
    16 => [
        'id' => 'Mata kuliah yang banyak mahasiswa minta dibuka oleh universitas.', 
        'en' => 'The course that many students requested was opened by the university',
        'vocab' => [
            'Course' => ['id' => 'Mata kuliah', 'pos' => '(n)'],
            'Request' => ['id' => 'Meminta', 'pos' => '(v)'],
            'University' => ['id' => 'Universitas', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Kelas yang siswa minta sudah penuh.',
            'en' => 'The class that students requested is full.'
        ]
    ],
    17 => [
        'id' => 'Lukisan itu, yang kolektor pesan beberapa bulan lalu, akhirnya selesai dibuat oleh seniman.', 
        'en' => 'The painting, which the collector ordered several months ago, was finally completed by the artist',
        'vocab' => [
            'Painting' => ['id' => 'Lukisan', 'pos' => '(n)'],
            'Collector' => ['id' => 'Kolektor', 'pos' => '(n)'],
            'Order' => ['id' => 'Memesan', 'pos' => '(v)']
        ],
        'example' => [
            'id' => 'Makanan yang kami pesan sangat enak.',
            'en' => 'The food which we ordered was very delicious.'
        ]
    ],
    18 => [
        'id' => 'Klien yang polisi tangkap tanpa bukti jelas dibela oleh pengacara.', 
        'en' => 'The client who the police arrested without clear evidence was defended by the lawyer',
        'vocab' => [
            'Client' => ['id' => 'Klien', 'pos' => '(n)'],
            'Arrest' => ['id' => 'Menangkap', 'pos' => '(v)'],
            'Evidence' => ['id' => 'Bukti', 'pos' => '(n)']
        ],
        'example' => [
            'id' => 'Pria yang polisi tangkap itu tidak bersalah.',
            'en' => 'The man who the police arrested was innocent.'
        ]
    ],
    19 => [
        'id' => 'Candi itu, yang pemandu jelaskan secara rinci, membuat wisatawan kagum.', 
        'en' => 'The temple, which the guide explained in detail, amazed the tourists',
        'vocab' => [
            'Temple' => ['id' => 'Candi', 'pos' => '(n)'],
            'Guide' => ['id' => 'Pemandu', 'pos' => '(n)'],
            'Explain' => ['id' => 'Menjelaskan', 'pos' => '(v)']
        ],
        'example' => [
            'id' => 'Pelajaran yang guru jelaskan sangat sulit.',
            'en' => 'The lesson which the teacher explained was very difficult.'
        ]
    ],
    20 => [
        'id' => 'Jalan yang truk-truk berat rusak diperbaiki oleh pemerintah kota.', 
        'en' => 'The road that heavy trucks damaged was repaired by the city government',
        'vocab' => [
            'Road' => ['id' => 'Jalan', 'pos' => '(n)'],
            'Truck' => ['id' => 'Truk', 'pos' => '(n)'],
            'Damage' => ['id' => 'Merusak', 'pos' => '(v)']
        ],
        'example' => [
            'id' => 'Pagar yang mobil tabrak itu hancur.',
            'en' => 'The fence that the car hit was destroyed.'
        ]
    ]
];

$paragraph = [
    'id' => 'Dalam beberapa tahun terakhir, universitas internasional memperkenalkan kurikulum baru, yang banyak mahasiswa butuhkan untuk menghadapi pasar kerja global. Pemerintah di berbagai negara merancang kebijakan pendidikan, yang masyarakat tuntut demi meningkatkan akses kesetaraan. Perusahaan teknologi mendanai riset ilmiah, yang para peneliti harapkan dapat menghasilkan solusi ramah lingkungan. Lembaga swadaya masyarakat meluncurkan program pelatihan, yang banyak komunitas lokal ikuti untuk memperbaiki keterampilan kerja. Sementara itu, para pendidik mengembangkan metode pembelajaran daring, yang siswa dari daerah terpencil gunakan untuk memperoleh akses pendidikan berkualitas.',
    'en' => 'In recent years, international universities have introduced new curricula, which many students need to face the global job market. Governments in various countries design education policies, which society demands to improve equal access. Technology companies fund scientific research, which researchers hope can produce environmentally friendly solutions. Non-governmental organizations launch training programs, which many local communities follow to improve work skills. Meanwhile, educators develop online learning methods, which students from remote areas use to obtain access to quality education.',
    'vocab' => [
        'Curriculum' => 'Kurikulum',
        'Job market' => 'Pasar kerja',
        'Policy' => 'Kebijakan',
        'Demand' => 'Menuntut',
        'Equal access' => 'Akses kesetaraan',
        'Fund' => 'Mendanai',
        'Scientific research' => 'Riset ilmiah',
        'Environmentally friendly' => 'Ramah lingkungan',
        'Non-governmental organization' => 'Lembaga swadaya masyarakat',
        'Training program' => 'Program pelatihan',
        'Work skills' => 'Keterampilan kerja',
        'Educator' => 'Pendidik',
        'Online learning' => 'Pembelajaran daring',
        'Remote area' => 'Daerah terpencil',
        'Quality education' => 'Pendidikan berkualitas'
    ]
];

// Check existing data
$existing = GrammarQuestion::where('meeting_number', 13)->count();
if ($existing > 0) {
    echo "Deleting existing data for Meeting 13 to re-seed...\n";
    GrammarQuestion::where('meeting_number', 13)->delete();
}

// Insert Questions
foreach ($questions as $num => $q) {
    GrammarQuestion::create([
        'meeting_number' => 13,
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
    'meeting_number' => 13,
    'question_number' => 100,
    'section' => 'paragraph',
    'question_type' => 'paragraph',
    'question_text' => $paragraph['id'],
    'correct_answer' => $paragraph['en'],
    'vocab' => $paragraph['vocab'],
]);
echo "Inserted paragraph.\n";
