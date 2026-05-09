<?php

use App\Models\GrammarQuestion;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$questions = [
    1 => [
        'id' => 'Universitas itu menambah program penelitian, karena kebutuhan energi terbarukan semakin mendesak.', 
        'en' => 'The university added research programs, because the need for renewable energy is increasingly urgent',
        'vocab' => ['Renewable energy' => 'Energi terbarukan', 'Increasingly' => 'Semakin', 'Urgent' => 'Mendesak', 'Research program' => 'Program penelitian'],
        'example' => 'I stayed home, for it was raining.'
    ],
    2 => [
        'id' => 'Kota itu membangun jalur sepeda, dan warganya mulai beralih dari kendaraan bermotor.', 
        'en' => 'The city built bicycle lanes, and its residents began to switch from motor vehicles',
        'vocab' => ['Bicycle lane' => 'Jalur sepeda', 'Resident' => 'Warga', 'Switch' => 'Beralih', 'Motor vehicle' => 'Kendaraan bermotor'],
        'example' => 'She likes apples, and he likes oranges.'
    ],
    3 => [
        'id' => 'Pusat studi tersebut tidak memiliki cukup dana, maupun menerima dukungan dari organisasi internasional.', 
        'en' => 'The study center does not have enough funds, nor does it receive support from international organizations',
        'vocab' => ['Fund' => 'Dana', 'Receive' => 'Menerima', 'Support' => 'Dukungan', 'International organization' => 'Organisasi internasional'],
        'example' => 'He doesn\'t eat meat, nor does he drink milk.'
    ],
    4 => [
        'id' => 'Para ilmuwan ingin menguji teori baru, tetapi alat laboratorium mereka belum memadai.', 
        'en' => 'Scientists want to test new theories, but their laboratory equipment is not yet adequate',
        'vocab' => ['Test' => 'Menguji', 'Theory' => 'Teori', 'Equipment' => 'Peralatan', 'Adequate' => 'Memadai'],
        'example' => 'I want to go, but I am tired.'
    ],
    5 => [
        'id' => 'Mahasiswa bisa memilih fokus pada biologi laut, atau mereka dapat menekuni bidang energi berkelanjutan.', 
        'en' => 'Students can choose to focus on marine biology, or they can pursue the field of sustainable energy',
        'vocab' => ['Focus' => 'Fokus', 'Marine biology' => 'Biologi laut', 'Pursue' => 'Menekuni', 'Sustainable energy' => 'Energi berkelanjutan'],
        'example' => 'You can study now, or you can sleep.'
    ],
    6 => [
        'id' => 'Tim peneliti bekerja siang malam, namun hasil yang mereka peroleh masih belum stabil.', 
        'en' => 'The research team works day and night, yet the results they obtain are still unstable',
        'vocab' => ['Obtain' => 'Memperoleh', 'Result' => 'Hasil', 'Unstable' => 'Tidak stabil', 'Research team' => 'Tim peneliti'],
        'example' => 'It is sunny, yet it is cold.'
    ],
    7 => [
        'id' => 'Pemerintah berkomitmen mengurangi emisi, sehingga mereka menetapkan regulasi yang lebih ketat.', 
        'en' => 'The government is committed to reducing emissions, so they established stricter regulations',
        'vocab' => ['Committed' => 'Berkomitmen', 'Reduce' => 'Mengurangi', 'Emission' => 'Emisi', 'Establish' => 'Menetapkan', 'Regulation' => 'Regulasi'],
        'example' => 'I was hungry, so I ate.'
    ],
    8 => [
        'id' => 'Festival budaya berlangsung meriah, karena masyarakat ingin melestarikan tradisi leluhur.', 
        'en' => 'The cultural festival took place festively, because the community wants to preserve ancestral traditions',
        'vocab' => ['Take place' => 'Berlangsung', 'Festively' => 'Meriah', 'Preserve' => 'Melestarikan', 'Ancestral tradition' => 'Tradisi leluhur'],
        'example' => 'He is happy, because he won.'
    ],
    9 => [
        'id' => 'Bandara itu meningkatkan kapasitas penerbangan, dan infrastruktur pendukung juga diperbaiki.', 
        'en' => 'The airport increased flight capacity, and supporting infrastructure was also improved',
        'vocab' => ['Increase' => 'Meningkatkan', 'Flight capacity' => 'Kapasitas penerbangan', 'Infrastructure' => 'Infrastruktur', 'Improve' => 'Diperbaiki'],
        'example' => 'I bought a pen, and I bought a book.'
    ],
    10 => [
        'id' => 'Perusahaan itu tidak mengurangi produksi plastik sekali pakai, maupun mencoba mencari alternatif ramah lingkungan.', 
        'en' => 'The company does not reduce single-use plastic production, nor does it try to find environmentally friendly alternatives',
        'vocab' => ['Reduce' => 'Mengurangi', 'Single-use' => 'Sekali pakai', 'Production' => 'Produksi', 'Environmentally friendly' => 'Ramah lingkungan'],
        'example' => 'She didn\'t call, nor did she text.'
    ],
    11 => [
        'id' => 'Jalur kereta cepat telah dibuka, tetapi harga tiketnya masih dianggap terlalu tinggi.', 
        'en' => 'The high-speed rail line has been opened, but the ticket price is still considered too high',
        'vocab' => ['High-speed rail' => 'Kereta cepat', 'Line' => 'Jalur', 'Ticket price' => 'Harga tiket', 'Consider' => 'Dianggap'],
        'example' => 'The car is fast, but it is expensive.'
    ],
    12 => [
        'id' => 'Wisatawan dapat mengunjungi taman nasional, atau mereka bisa mengikuti program konservasi komunitas.', 
        'en' => 'Tourists can visit national parks, or they can join community conservation programs',
        'vocab' => ['Tourist' => 'Wisatawan', 'Visit' => 'Mengunjungi', 'National park' => 'Taman nasional', 'Join' => 'Mengikuti', 'Conservation' => 'Konservasi'],
        'example' => 'We can go to the beach, or we can go to the mountains.'
    ],
    13 => [
        'id' => 'Data ilmiah telah terkumpul selama bertahun-tahun, namun interpretasinya tetap menimbulkan perdebatan.', 
        'en' => 'Scientific data has been collected for years, yet its interpretation still causes debate',
        'vocab' => ['Collect' => 'Terkumpul', 'Interpretation' => 'Interpretasi', 'Cause' => 'Menimbulkan', 'Debate' => 'Perdebatan'],
        'example' => 'He is rich, yet he is unhappy.'
    ],
    14 => [
        'id' => 'Program pendidikan digital berkembang pesat, sehingga akses pembelajaran menjadi lebih merata.', 
        'en' => 'Digital education programs are developing rapidly, so learning access becomes more equitable',
        'vocab' => ['Develop' => 'Berkembang', 'Rapidly' => 'Pesat', 'Access' => 'Akses', 'Equitable' => 'Merata'],
        'example' => 'It was late, so we went home.'
    ],
    15 => [
        'id' => 'Desa itu menjaga hutan adatnya, karena mereka percaya hutan adalah sumber kehidupan.', 
        'en' => 'The village protects its customary forest, because they believe the forest is the source of life',
        'vocab' => ['Protect' => 'Menjaga', 'Customary forest' => 'Hutan adat', 'Believe' => 'Percaya', 'Source of life' => 'Sumber kehidupan'],
        'example' => 'She smiled, because she was happy.'
    ]
];

// Check if data already exists to avoid duplicates
$existingCount = GrammarQuestion::where('meeting_number', 11)->count();

if ($existingCount > 0) {
    echo "Meeting 11 data already exists ($existingCount records). Skipping migration.\n";
} else {
    foreach ($questions as $num => $q) {
        GrammarQuestion::create([
            'meeting_number' => 11,
            'question_number' => $num,
            'question_text' => $q['id'],
            'correct_answer' => $q['en'],
            'vocab' => $q['vocab'], // Model casts to array
            'example_en' => $q['example'], // Meeting 11 uses a simple string example
             // structure/type isn't explicitly used in Meeting 11 loop for styling, unlike Meeting 10.
        ]);
    }
    echo "Migrated " . count($questions) . " questions for Meeting 11.\n";
}
