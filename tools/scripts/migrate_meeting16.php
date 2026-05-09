<?php

use App\Models\GrammarQuestion;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$paragraph = [
    'id' => 'Dalam beberapa tahun terakhir, kesadaran publik tentang pelestarian lingkungan meningkat dengan lebih cepat dibandingkan dekade sebelumnya, terutama di wilayah perkotaan yang menghadapi tekanan pembangunan paling serius. Banyak komunitas lokal berusaha menciptakan ruang hijau yang setua sejarah kota itu sendiri, meskipun mereka sering terbatas oleh sumber daya yang lebih sedikit daripada organisasi besar. Di antara semua proyek konservasi yang telah diluncurkan, program restorasi mangrove adalah inisiatif yang paling penting bagi perlindungan ekosistem pesisir, karena menyediakan habitat yang banyak spesies laut sangat bergantung padanya sebagai sumber makanan. Di pusat penelitian lingkungan yang berlokasi di pesisir utara, para ilmuwan sedang mengembangkan metode pemantauan baru yang dapat membantu pemerintah membuat kebijakan berbasis data. Mereka bekerja sama dengan para nelayan lokal yang kehidupan keluarganya bergantung pada laut untuk memastikan bahwa hasil penelitian tersebut relevan dalam praktik. Banyak warga menghargai para ilmuwan yang kontribusinya sangat berarti bagi kesejahteraan masyarakat, terutama selama periode ketika kondisi iklim berubah dengan cepat dan memengaruhi ketersediaan sumber daya alam. Di kawasan pesisir di mana kerusakan ekosistem terjadi paling parah, pemerintah mulai membangun pusat edukasi publik untuk memberikan alasan mengapa masyarakat harus terlibat secara aktif dalam pelestarian lingkungan. Tempat itu kini menjadi ruang belajar terbuka di mana para siswa dan relawan bekerja bersama untuk menanam kembali vegetasi yang hilang dan mengamati pemulihan ekosistem dalam suasana kolaboratif.',
    'en' => 'In recent years, public awareness of environmental conservation has increased more rapidly than in previous decades, especially in urban areas facing the most serious development pressures. Many local communities are trying to create green spaces as old as the city\'s history itself, although they are often limited by fewer resources than large organizations. Among all the conservation projects that have been launched, the mangrove restoration program is the most important initiative for protecting coastal ecosystems, because it provides habitat that many marine species heavily depend on as a food source. At the environmental research center located on the northern coast, scientists are developing new monitoring methods that can help the government make data-based policies. They work together with local fishermen whose family livelihoods depend on the sea to ensure that the research results are relevant in practice. Many residents appreciate the scientists whose contributions are very meaningful to the community\'s welfare, especially during periods when climate conditions change rapidly and affect the availability of natural resources. In coastal areas where ecosystem damage occurs most severely, the government has started building public education centers to provide reasons why the community should be actively involved in environmental conservation. The place has now become an open learning space where students and volunteers work together to replant lost vegetation and observe ecosystem recovery in a collaborative atmosphere.',
    'vocab' => [
        'Public awareness' => 'Kesadaran publik',
        'Environmental conservation' => 'Pelestarian lingkungan',
        'Rapidly' => 'Dengan cepat',
        'Previous decade' => 'Dekade sebelumnya',
        'Urban area' => 'Wilayah perkotaan',
        'Development pressure' => 'Tekanan pembangunan',
        'Local community' => 'Komunitas lokal',
        'Green space' => 'Ruang hijau',
        'Limited by' => 'Terbatas oleh',
        'Conservation project' => 'Proyek konservasi',
        'Mangrove restoration' => 'Restorasi mangrove',
        'Initiative' => 'Inisiatif',
        'Coastal ecosystem' => 'Ekosistem pesisir',
        'Habitat' => 'Habitat',
        'Marine species' => 'Spesies laut',
        'Depend on' => 'Bergantung pada',
        'Research center' => 'Pusat penelitian',
        'Monitoring method' => 'Metode pemantauan',
        'Policymaker' => 'Pembuat kebijakan',
        'Relevance' => 'Relevansi',
        'Scientific contribution' => 'Kontribusi ilmiah',
        'Climate condition' => 'Kondisi iklim',
        'Natural resource' => 'Sumber daya alam',
        'Public education' => 'Edukasi publik',
        'Open learning space' => 'Ruang belajar terbuka',
        'Recovey' => 'Pemulihan',
        'Collaborative atmosphere' => 'Suasana kolaboratif'
    ]
];

// Check existing data
$existing = GrammarQuestion::where('meeting_number', 16)->count();
if ($existing > 0) {
    echo "Deleting existing data for Meeting 16 to re-seed...\n";
    GrammarQuestion::where('meeting_number', 16)->delete();
}

// Insert Paragraph
GrammarQuestion::create([
    'meeting_number' => 16,
    'question_number' => 100,
    'section' => 'paragraph',
    'question_type' => 'paragraph',
    'question_text' => $paragraph['id'],
    'correct_answer' => $paragraph['en'],
    'vocab' => $paragraph['vocab'],
]);
echo "Inserted paragraph for Meeting 16.\n";
