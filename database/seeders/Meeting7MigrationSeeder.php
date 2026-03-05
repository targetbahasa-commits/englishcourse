<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GrammarQuestion;

class Meeting7MigrationSeeder extends Seeder
{
    public function run()
    {
        // 1. Clear existing Meeting 7 data
        GrammarQuestion::where('meeting_number', 7)->delete();

        // POS Map from View (for enrichment)
        $posMap = [
            'Archipelago' => '(n)', 'Tropical' => '(adj)', 'Natural resources' => '(n)', 'Biodiversity' => '(n)', 'Extraordinary' => '(adj)',
            'Institution' => '(n)', 'Research' => '(n)', 'Independent' => '(adj)', 'Famous' => '(adj)', 'Release' => '(v)', 'Annual report' => '(n)', 'Market growth' => '(n)',
            'Museum' => '(n)', 'Magnificent' => '(adj)', 'Historical' => '(adj)', 'Store' => '(v)', 'Artifact' => '(n)', 'Valuable' => '(adj)', 'Era' => '(n)',
            'Geographer' => '(n)', 'Map' => '(v)', 'Border area' => '(n)', 'Vast' => '(adj)', 'Remote' => '(adj)', 'In detail' => '(adv)',
            'Conference' => '(n)', 'Environmental' => '(adj)', 'Global' => '(adj)', 'Held' => '(v)', 'Every year' => '(adv)', 'Geneva' => '(n)',
            'Reference book' => '(n)', 'Scientific' => '(adj)', 'Thick' => '(adj)', 'Classic' => '(adj)', 'Expensive' => '(adj)', 'Linguistics' => '(n)', 'Available' => '(adj)', 'Library' => '(n)',
            'Scientist' => '(n)', 'Discover' => '(v)', 'Mineral' => '(n)', 'Rare' => '(adj)', 'Shiny' => '(adj)', 'Bottom' => '(n)', 'Ocean' => '(n)', 'Indian Ocean' => '(n)',
            'Early childhood education' => '(n)', 'Inclusive' => '(adj)', 'Innovative' => '(adj)', 'Develop' => '(v)', 'Rapidly' => '(adv)', 'Rural area' => '(n)',
            'Indigenous community' => '(n)', 'Mountain' => '(n)', 'High' => '(adj)', 'Multiethnic' => '(adj)', 'Belief system' => '(n)', 'Unique' => '(adj)',
            'Astronomy' => '(n)', 'Observe' => '(v)', 'Phenomenon/Phenomena' => '(n)', 'Cosmic' => '(adj)', 'Rare' => '(adj)', 'Complex' => '(adj)', 'Mysterious' => '(adj)', 'Edge' => '(n)', 'Galaxy' => '(n)'
        ];

        // Part A: Questions
        $questions = [
            1 => [
                'id' => '<strong>Negara kepulauan tropis besar kaya sumber daya alam ini</strong> memiliki <strong class="text-green-500">keanekaragaman hayati yang luar biasa</strong>.', 
                'en' => 'This large tropical archipelago country rich in natural resources has extraordinary biodiversity',
                'example' => ['id' => 'Pulau kecil indah kuno kaya sejarah ini menarik banyak turis.', 'en' => 'This small beautiful ancient island rich in history attracts many tourists.'],
                'vocab' => [
                    'Archipelago' => ['id' => 'Kepulauan', 'pos' => 'n'],
                    'Tropical' => ['id' => 'Tropis', 'pos' => 'adj'],
                    'Natural resources' => ['id' => 'Sumber daya alam', 'pos' => 'n'],
                    'Biodiversity' => ['id' => 'Keanekaragaman hayati', 'pos' => 'n'],
                    'Extraordinary' => ['id' => 'Luar biasa', 'pos' => 'adj']
                ]
            ],
            2 => [
                'id' => '<strong>Lembaga penelitian ekonomi global independen terkenal ini</strong> merilis <strong class="text-green-500">laporan tahunan</strong> <strong>tentang <span class="text-pink-500">pertumbuhan pasar</span></strong>.', 
                'en' => 'This famous independent global economic research institution releases annual reports on market growth',
                'example' => ['id' => 'Perusahaan teknologi lokal modern inovatif tersebut meluncurkan produk baru.', 'en' => 'That innovative modern local technology company launches new products.'],
                'vocab' => ['Institution' => 'Lembaga', 'Research' => 'Penelitian', 'Independent' => 'Independen', 'Famous' => 'Terkenal', 'Release' => 'Merilis', 'Annual report' => 'Laporan tahunan', 'Market growth' => 'Pertumbuhan pasar']
            ],
            3 => [
                'id' => '<strong>Museum nasional besar megah bersejarah ini</strong> menyimpan <strong class="text-green-500">koleksi artefak berharga</strong> <strong>dari <span class="text-pink-500">berbagai era</span></strong>.', 
                'en' => 'This large magnificent historical national museum stores valuable artifact collections from various eras',
                'example' => ['id' => 'Cincin emas berharga tua kecil ini memiliki kekuatan magis.', 'en' => 'This small old precious golden ring has magical powers.'],
                'vocab' => ['Museum' => 'Museum', 'Magnificent' => 'Megah', 'Historical' => 'Bersejarah', 'Store' => 'Menyimpan', 'Artifact' => 'Artefak', 'Valuable' => 'Berharga', 'Era' => 'Era']
            ],
            4 => [
                'id' => 'Ahli geografi memetakan <strong class="text-green-500">wilayah perbatasan luas terpencil penting negara tersebut</strong> <strong class="text-green-500">secara detail</strong>.', 
                'en' => 'Geographers map the important vast remote border areas of the country in detail',
                'example' => ['id' => 'Mereka membangun sebuah rumah pribadi mewah besar di atas bukit.', 'en' => 'They built a large luxurious private house on the hill.'],
                'vocab' => ['Geographer' => 'Ahli geografi', 'Map' => 'Memetakan', 'Border area' => 'Wilayah perbatasan', 'Vast' => 'Luas', 'Remote' => 'Terpencil', 'In detail' => 'Secara detail']
            ],
            5 => [
                'id' => '<strong>Konferensi internasional lingkungan global penting ini</strong> diadakan <strong class="text-green-500">setiap tahun</strong> di Jenewa.', 
                'en' => 'This important global environmental international conference is held every year in Geneva',
                'example' => ['id' => 'Ujian matematika akhir sulit tersebut dimulai jam 8 pagi.', 'en' => 'That difficult final math exam starts at 8 AM.'],
                'vocab' => ['Conference' => 'Konferensi', 'Environmental' => 'Lingkungan', 'Global' => 'Global', 'Held' => 'Diadakan', 'Every year' => 'Setiap tahun', 'Geneva' => 'Jenewa']
            ],
            6 => [
                'id' => '<strong>Buku referensi ilmiah tebal klasik mahal tentang linguistik</strong> tersedia di <strong class="text-green-500">perpustakaan universitas</strong>.', 
                'en' => 'Expensive thick classic scientific reference books on linguistics are available in the university library',
                'example' => ['id' => 'Sebuah kursi plastik merah kecil murah ada di sudut ruangan.', 'en' => 'A cheap small red plastic chair is in the corner of the room.'],
                'vocab' => ['Reference book' => 'Buku referensi', 'Scientific' => 'Ilmiah', 'Thick' => 'Tebal', 'Classic' => 'Klasik', 'Expensive' => 'Mahal', 'Linguistics' => 'Linguistik', 'Available' => 'Tersedia', 'Library' => 'Perpustakaan']
            ],
            7 => [
                'id' => 'Para ilmuwan menemukan <strong class="text-green-500">mineral langka mahal berkilau</strong> di <strong><span class="text-pink-500">dasar laut Samudra Hindia</span></strong>.', 
                'en' => 'Scientists discover rare expensive shiny minerals at the bottom of the Indian Ocean',
                'example' => ['id' => 'Dia membeli gaun sutra panjang indah untuk pesta.', 'en' => 'She bought a beautiful long silk dress for the party.'],
                'vocab' => ['Scientist' => 'Ilmuwan', 'Discover' => 'Menemukan', 'Mineral' => 'Mineral', 'Rare' => 'Langka', 'Shiny' => 'Berkilau', 'Bottom' => 'Dasar', 'Ocean' => 'Samudra/Laut', 'Indian Ocean' => 'Samudra Hindia']
            ],
            8 => [
                'id' => '<strong>Program pendidikan anak usia dini inklusif inovatif modern</strong> berkembang pesat di <strong class="text-green-500">wilayah pedesaan</strong>.', 
                'en' => 'Modern innovative inclusive early childhood education programs develop rapidly in rural areas',
                'example' => ['id' => 'Sebuah proyek kolaboratif kreatif sukses besar.', 'en' => 'A creative collaborative project succeeds greatly.'],
                'vocab' => ['Early childhood education' => 'Pendidikan anak usia dini', 'Inclusive' => 'Inklusif', 'Innovative' => 'Inovatif', 'Develop' => 'Berkembang', 'Rapidly' => 'Pesat', 'Rural area' => 'Wilayah pedesaan']
            ],
            9 => [
                'id' => '<strong>Masyarakat adat pegunungan tinggi terpencil multietnis ini</strong> memiliki <strong class="text-green-500">sistem kepercayaan unik</strong>.', 
                'en' => 'This multiethnic remote high mountain indigenous community has a unique belief system',
                'example' => ['id' => 'Lingkungan perkotaan padat bising ini menyebabkan stres.', 'en' => 'This noisy crowded urban environment causes stress.'],
                'vocab' => ['Indigenous community' => 'Masyarakat adat', 'Mountain' => 'Pegunungan', 'High' => 'Tinggi', 'Multiethnic' => 'Multietnis', 'Belief system' => 'Sistem kepercayaan', 'Unique' => 'Unik']
            ],
            10 => [
                'id' => 'Tim astronomi mengamati <strong class="text-green-500">fenomena kosmik langka kompleks misterius</strong> di <strong><span class="text-pink-500">tepi galaksi</span></strong>.', 
                'en' => 'Astronomy teams observe mysterious complex rare cosmic phenomena at the edge of the galaxy',
                'example' => ['id' => 'Kami melihat seekor hewan liar cepat berbahaya di hutan.', 'en' => 'We saw a dangerous fast wild animal in the forest.'],
                'vocab' => ['Astronomy' => 'Astronomi', 'Observe' => 'Mengamati', 'Phenomenon/Phenomena' => 'Fenomena', 'Cosmic' => 'Kosmik', 'Rare' => 'Langka', 'Complex' => 'Kompleks', 'Mysterious' => 'Misterius', 'Edge' => 'Tepi', 'Galaxy' => 'Galaksi']
            ]
        ];

        // Part B: Paragraph
        $paragraph = [
            'id' => '<strong>Kota metropolitan modern hijau berkelanjutan ini</strong> menjadi <strong>model pembangunan urban ramah lingkungan dunia</strong>. <strong>Pemerintah daerah progresif inovatif visioner ini</strong> menerapkan <strong>kebijakan transportasi publik efisien hemat energi</strong>. <strong>Sistem taman kota luas asri multifungsi ini</strong> berfungsi sebagai <strong>ruang hijau vital masyarakat</strong>. <strong>Program pendidikan lingkungan komprehensif inklusif partisipatif ini</strong> meningkatkan <strong>kesadaran generasi muda</strong>. <strong>Infrastruktur energi terbarukan canggih bersih hemat karbon ini</strong> mendukung <strong>kebutuhan listrik penduduk</strong>. Dengan <strong>berbagai kebijakan inovatif</strong>, <strong>kota metropolitan modern hijau berkelanjutan ini</strong> menjadi <strong>contoh global perencanaan perkotaan masa depan</strong>.',
            'en' => 'This modern green sustainable metropolitan city becomes a model of world environmentally friendly urban development. This visionary innovative progressive local government implements efficient energy-saving public transportation policies. This multifunctional green spacious city park system functions as a vital green space for the community. This participatory inclusive comprehensive environmental education program increases young generation awareness. This carbon-efficient clean advanced renewable energy infrastructure supports the electricity needs of residents. With various innovative policies, this modern green sustainable metropolitan city becomes a global example of future urban planning.',
            'sentences' => [
                ['vocab' => ['Sustainable' => 'Berkelanjutan', 'Metropolitan' => 'Metropolitan', 'Urban development' => 'Pembangunan urban', 'Model' => 'Model', 'World' => 'Dunia']],
                ['vocab' => ['Visionary' => 'Visioner', 'Progressive' => 'Progresif', 'Energy-saving' => 'Hemat energi', 'Local government' => 'Pemerintah daerah', 'Policies' => 'Kebijakan']],
                ['vocab' => ['Multifunctional' => 'Multifungsi', 'Spacious' => 'Luas', 'Vital' => 'Vital', 'Park' => 'Taman', 'Green space' => 'Ruang hijau']],
                ['vocab' => ['Participatory' => 'Partisipatif', 'Comprehensive' => 'Komprehensif', 'Awareness' => 'Kesadaran', 'Education' => 'Pendidikan', 'Youth' => 'Pemuda']],
                ['vocab' => ['Renewable' => 'Terbarukan', 'Advanced' => 'Canggih', 'Carbon-efficient' => 'Hemat karbon', 'Infrastructure' => 'Infrastruktur', 'Energy' => 'Energi']],
                ['vocab' => ['Innovative' => 'Inovatif', 'Urban planning' => 'Perencanaan perkotaan', 'City' => 'Kota', 'Example' => 'Contoh']]
            ]
        ];

        // Process and Insert Questions
        foreach ($questions as $idx => $data) {
            $vocab = [];
            foreach ($data['vocab'] as $en => $val) {
                if (is_array($val)) {
                    $vocab[$en] = $val;
                } else {
                    $vocab[$en] = [
                        'id' => $val,
                        'pos' => $posMap[$en] ?? ''
                    ];
                }
            }

            GrammarQuestion::create([
                'meeting_number' => 7,
                'section' => 'noun_phrases',
                'question_number' => $idx,
                'question_text' => $data['id'],
                'correct_answer' => $data['en'],
                'example' => $data['example'] ?? null,
                'vocab' => $vocab
            ]);
        }

        // Process and Insert Paragraph
        GrammarQuestion::create([
            'meeting_number' => 7,
            'section' => 'paragraph',
            'question_number' => 1,
            'question_text' => $paragraph['id'],
            'correct_answer' => $paragraph['en'],
            'vocab' => $paragraph['sentences'] // Storing sentences structure in vocab
        ]);

        $this->command->info('Meeting 7 data migrated successfully!');
    }
}
