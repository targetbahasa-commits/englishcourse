<?php

use App\Models\GrammarQuestion;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$meeting9Paragraph = [
    'id' => 'Di perairan tropis Indonesia, para ilmuwan baru-baru ini menemukan spesies koral langka yang memiliki ketahanan luar biasa terhadap perubahan suhu. Penemuan ini berawal dari pengamat pasif yang memperhatikan pola pertumbuhan unik di sekitar terumbu karang. Menggunakan sistem pemantauan canggih, departemen lingkungan mengonfirmasi bahwa koral tersebut dapat bertahan hidup meskipun suhu laut meningkat secara signifikan. Kerja lapangan dilakukan selama enam bulan, melibatkan masyarakat lokal dan staf senior dari berbagai universitas. Ekspedisi tersebut juga mengumpulkan data historis untuk dianalisis lebih lanjut. Sampel arsip dari tahun-tahun sebelumnya menunjukkan bahwa spesies ini telah ada sejak lama, namun baru sekarang teridentifikasi secara resmi. Saat ini, draf kebijakan laut yang komprehensif sedang disusun untuk melindungi habitat koral tersebut. Setelah revisi selesai, dokumen itu akan disimpan di gudang data nasional. Penemuan ini diharapkan dapat berubah menjadi pusat inovasi kolaboratif bagi penelitian kelautan di masa depan.',
    'en' => 'In Indonesia\'s tropical waters, scientists recently discovered a rare coral species that has extraordinary resilience to temperature changes. This discovery began with passive observers who noticed unique growth patterns around the coral reefs. Using sophisticated monitoring systems, the environmental department confirmed that the coral could survive even though sea temperatures increased significantly. Fieldwork was conducted for six months, involving local communities and senior staff from various universities. The expedition also collected historical data to be analyzed further. Archival samples from previous years showed that this species had existed for a long time, yet it is only now officially identified. Currently, a comprehensive marine policy draft is being drafted to protect the coral habitat. After the revision is complete, the document will be stored in the national data warehouse. This discovery is expected to transform into a collaborative innovation hub for future marine research.',
    'vocab' => [
        'Resilience' => 'Ketahanan',
        'Tropical waters' => 'Perairan tropis',
        'Passive observer' => 'Pengamat pasif',
        'Sophisticated monitoring system' => 'Sistem pemantauan canggih',
        'Environmental department' => 'Departemen lingkungan',
        'Fieldwork' => 'Kerja lapangan',
        'Local community' => 'Masyarakat lokal',
        'Senior staff' => 'Staf senior',
        'Expedition' => 'Ekspedisi',
        'Historical data' => 'Data historis',
        'Analyze' => 'Dianalisis',
        'Archival sample' => 'Sampel arsip',
        'Marine policy draft' => 'Draf kebijakan laut',
        'Comprehensive' => 'Komprehensif',
        'Revision' => 'Revisi',
        'Data warehouse' => 'Gudang data',
        'Transform' => 'Berubah',
        'Collaborative innovation hub' => 'Pusat inovasi kolaboratif'
    ]
];

// Check if data already exists to avoid duplicates
$existing = GrammarQuestion::where('meeting_number', 9)
                           ->where('section', 'paragraph')
                           ->first();

if ($existing) {
    echo "Meeting 9 paragraph data already exists. Updating if needed...\n";
    // Optional: Update logic if needed, for now just skip
} else {
    GrammarQuestion::create([
        'meeting_number' => 9,
        'question_number' => 1,
        'section' => 'paragraph',
        'question_type' => 'paragraph',
        'question_text' => $meeting9Paragraph['id'],
        'correct_answer' => $meeting9Paragraph['en'],
        'vocab' => $meeting9Paragraph['vocab'],
    ]);
    echo "Migrated Meeting 9 paragraph.\n";
}
