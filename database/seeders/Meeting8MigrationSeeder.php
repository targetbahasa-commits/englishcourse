<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GrammarQuestion;

class Meeting8MigrationSeeder extends Seeder
{
    public function run()
    {
        // 1. Clear existing Meeting 8 data
        GrammarQuestion::where('meeting_number', 8)->delete();

        // Part A: Questions
        $questions = [
            1 => [
                'id' => '<strong class="text-blue-600">Dalam bidang teknologi lingkungan</strong>, universitas negeri ini membuka program studi baru.',
                'en' => 'In the field of environmental technology, this state university opens a new study program',
                'vocab' => ['Field' => 'Bidang', 'Environmental' => 'Lingkungan', 'State university' => 'Universitas negeri', 'Open' => 'Membuka', 'Study program' => 'Program studi']
            ],
            2 => [
                'id' => 'Pelabuhan laut ini, <strong class="text-blue-600">melalui jalur perdagangan internasional</strong>, mengatur distribusi barang.',
                'en' => 'This seaport, through international trade routes, manages the distribution of goods',
                'vocab' => ['Seaport' => 'Pelabuhan laut', 'Through' => 'Melalui', 'Trade route' => 'Jalur perdagangan', 'Manage' => 'Mengatur', 'Distribution' => 'Distribusi', 'Goods' => 'Barang']
            ],
            3 => [
                'id' => '<strong class="text-blue-600">Bagi masyarakat umum</strong>, perpustakaan kota ini memberi akses gratis.',
                'en' => 'For the general public, this city library gives free access',
                'vocab' => ['For' => 'Bagi/Untuk', 'General public' => 'Masyarakat umum', 'City library' => 'Perpustakaan kota', 'Give' => 'Memberi', 'Access' => 'Akses', 'Free' => 'Gratis']
            ],
            4 => [
                'id' => 'Sungai besar ini <strong class="text-blue-600">antara desa dan kota</strong> berfungsi sebagai jalur transportasi.',
                'en' => 'This big river between the village and the city functions as a transportation route',
                'vocab' => ['River' => 'Sungai', 'Between' => 'Antara', 'Village' => 'Desa', 'Function' => 'Berfungsi', 'As' => 'Sebagai', 'Route' => 'Jalur']
            ],
            5 => [
                'id' => 'Gedung pemerintahan ini berfungsi <strong class="text-blue-600">dengan sistem keamanan digital terbaru</strong>.',
                'en' => 'This government building functions with the latest digital security system',
                'vocab' => ['Government building' => 'Gedung pemerintahan', 'With' => 'Dengan', 'Security system' => 'Sistem keamanan', 'Digital' => 'Digital', 'Latest' => 'Terbaru']
            ],
            6 => [
                'id' => '<strong class="text-blue-600">Ke jaringan transportasi regional</strong>, stasiun kereta ini terhubung.',
                'en' => 'To the regional transportation network, this train station connects',
                'vocab' => ['To' => 'Ke', 'Network' => 'Jaringan', 'Transportation' => 'Transportasi', 'Regional' => 'Regional', 'Train station' => 'Stasiun kereta', 'Connect' => 'Terhubung']
            ],
            7 => [
                'id' => 'Rumah sakit umum ini bekerja sama <strong class="text-blue-600">dengan lembaga donor asing</strong>.',
                'en' => 'This general hospital collaborates with foreign donor institutions',
                'vocab' => ['General hospital' => 'Rumah sakit umum', 'Collaborate' => 'Bekerja sama', 'With' => 'Dengan', 'Donor institution' => 'Lembaga donor', 'Foreign' => 'Asing']
            ],
            8 => [
                'id' => 'Pasar tradisional ini terkenal <strong class="text-blue-600">karena kualitas produk segar lokal</strong>.',
                'en' => 'This traditional market is famous because of the quality of local fresh products',
                'vocab' => ['Traditional market' => 'Pasar tradisional', 'Famous' => 'Terkenal', 'Because of' => 'Karena', 'Quality' => 'Kualitas', 'Fresh product' => 'Produk segar', 'Local' => 'Lokal']
            ],
            9 => [
                'id' => 'Gunung api ini menjadi lokasi riset <strong class="text-blue-600">untuk ilmuwan internasional</strong>.',
                'en' => 'This volcano becomes a research location for international scientists',
                'vocab' => ['Volcano' => 'Gunung api', 'Become' => 'Menjadi', 'Location' => 'Lokasi', 'Research' => 'Riset', 'For' => 'Untuk', 'Scientist' => 'Ilmuwan']
            ],
            10 => [
                'id' => 'Bandara internasional ini meningkatkan hubungan <strong class="text-blue-600">antara negara tetangga</strong>.',
                'en' => 'This international airport improves relationships between neighboring countries',
                'vocab' => ['Airport' => 'Bandara', 'Improve' => 'Meningkatkan', 'Relationship' => 'Hubungan', 'Between' => 'Antara', 'Neighboring country' => 'Negara tetangga']
            ],
            11 => [
                'id' => '<strong class="text-blue-600">Dengan tema keberagaman masyarakat</strong>, pusat kebudayaan ini menampilkan pameran seni.',
                'en' => 'With the theme of community diversity, this cultural center displays art exhibitions',
                'vocab' => ['With' => 'Dengan', 'Theme' => 'Tema', 'Diversity' => 'Keberagaman', 'Community' => 'Masyarakat', 'Cultural center' => 'Pusat kebudayaan', 'Display' => 'Menampilkan', 'Exhibition' => 'Pameran']
            ],
            12 => [
                'id' => 'Jalan tol ini mempercepat arus kendaraan <strong class="text-blue-600">ke wilayah selatan</strong>.',
                'en' => 'This toll road speeds up the flow of vehicles to the southern region',
                'vocab' => ['Toll road' => 'Jalan tol', 'Speed up' => 'Mempercepat', 'Flow' => 'Arus', 'Vehicle' => 'Kendaraan', 'To' => 'Ke', 'Region' => 'Wilayah', 'Southern' => 'Selatan']
            ],
            13 => [
                'id' => 'Museum seni ini bekerja sama <strong class="text-blue-600">dengan komunitas seniman lokal</strong>.',
                'en' => 'This art museum collaborates with the local artist community',
                'vocab' => ['Art museum' => 'Museum seni', 'Collaborate' => 'Bekerja sama', 'With' => 'Dengan', 'Community' => 'Komunitas', 'Artist' => 'Seniman', 'Local' => 'Lokal']
            ],
            14 => [
                'id' => 'Kebun raya ini, <strong class="text-blue-600">di bawah pengawasan ketat</strong>, menyimpan koleksi tanaman langka.',
                'en' => 'This botanical garden, under strict supervision, stores a collection of rare plants',
                'vocab' => ['Botanical garden' => 'Kebun raya', 'Under' => 'Di bawah', 'Supervision' => 'Pengawasan', 'Strict' => 'Ketat', 'Store' => 'Menyimpan', 'Collection' => 'Koleksi', 'Rare plant' => 'Tanaman langka']
            ],
            15 => [
                'id' => 'Laboratorium riset ini mengembangkan teknologi baru <strong class="text-blue-600">untuk pengolahan air limbah</strong>.',
                'en' => 'This research laboratory develops new technology for wastewater treatment',
                'vocab' => ['Laboratory' => 'Laboratorium', 'Develop' => 'Mengembangkan', 'Technology' => 'Teknologi', 'For' => 'Untuk', 'Treatment' => 'Pengolahan', 'Wastewater' => 'Air limbah']
            ],
            16 => [
                'id' => 'Stadion olahraga ini mengadakan turnamen nasional <strong class="text-blue-600">pada setiap semester</strong>.',
                'en' => 'This sports stadium holds national tournaments in every semester',
                'vocab' => ['Stadium' => 'Stadion', 'Hold' => 'Mengadakan', 'Tournament' => 'Turnamen', 'National' => 'Nasional', 'In/On' => 'Pada', 'Every' => 'Setiap', 'Semester' => 'Semester']
            ],
            17 => [
                'id' => 'Desa wisata ini menawarkan paket edukasi <strong class="text-blue-600">tentang konservasi hutan</strong>.',
                'en' => 'This tourism village offers education packages about forest conservation',
                'vocab' => ['Tourism village' => 'Desa wisata', 'Offer' => 'Menawarkan', 'Package' => 'Paket', 'About' => 'Tentang', 'Conservation' => 'Konservasi', 'Forest' => 'Hutan']
            ],
            18 => [
                'id' => '<strong class="text-blue-600">Bagi masyarakat kota</strong>, menara komunikasi ini menjadi simbol kebanggaan.',
                'en' => 'For the urban community, this communication tower becomes a symbol of pride',
                'vocab' => ['For' => 'Bagi', 'Urban community' => 'Masyarakat kota', 'Tower' => 'Menara', 'Become' => 'Menjadi', 'Symbol' => 'Simbol', 'Pride' => 'Kebanggaan']
            ],
            19 => [
                'id' => 'Pusat pelatihan kerja ini menyediakan bimbingan <strong class="text-blue-600">dengan pendekatan praktis</strong>.',
                'en' => 'This job training center provides guidance with a practical approach',
                'vocab' => ['Training center' => 'Pusat pelatihan', 'Provide' => 'Menyediakan', 'Guidance' => 'Bimbingan', 'With' => 'Dengan', 'Approach' => 'Pendekatan', 'Practical' => 'Praktis']
            ],
            20 => [
                'id' => 'Taman kota ini mendukung program edukasi <strong class="text-blue-600">untuk anak-anak sekolah</strong>.',
                'en' => 'This city park supports education programs for school children',
                'vocab' => ['City park' => 'Taman kota', 'Support' => 'Mendukung', 'Program' => 'Program', 'For' => 'Untuk', 'School children' => 'Anak-anak sekolah']
            ]
        ];

        // Part B: Paragraph
        $paragraph = [
            'id' => '<strong class="text-blue-600">Di dalam kawasan hutan tropis</strong>, para peneliti bekerja setiap hari <strong class="text-blue-600">untuk mempelajari perubahan di dalam ekosistem alami</strong>. <strong class="text-blue-600">Dengan alat pengamatan lapangan</strong>, mereka mencatat data tentang hewan dan tumbuhan <strong class="text-blue-600">di sekitar aliran sungai</strong>. <strong class="text-blue-600">Dalam kegiatan pemantauan lingkungan</strong>, tim biolog melakukan pengukuran suhu dan kelembapan <strong class="text-blue-600">di permukaan tanah</strong> dan <strong class="text-blue-600">di dalam area vegetasi rapat</strong>. <strong class="text-blue-600">Untuk menjaga keseimbangan alam</strong>, program konservasi berlangsung secara rutin <strong class="text-blue-600">di sepanjang jalur perlindungan satwa liar</strong> dan <strong class="text-blue-600">di sekitar habitat penting</strong>. <strong class="text-blue-600">Di dalam pusat edukasi lingkungan</strong>, para siswa belajar tentang peran manusia <strong class="text-blue-600">di dalam pelestarian ekosistem</strong> dan <strong class="text-blue-600">untuk masa depan bumi</strong>.',
            'en' => 'In the tropical forest area, researchers work every day to study changes in the natural ecosystem. With field observation tools, they record data about animals and plants around the river flow. In environmental monitoring activities, the biologist team measures temperature and humidity on the soil surface and in dense vegetation areas. To maintain natural balance, conservation programs take place routinely along wildlife protection paths and around important habitats. In the environmental education center, students learn about the human role in ecosystem preservation and for the future of the earth.',
            'vocab' => [
                'Tropical forest area' => 'Kawasan hutan tropis',
                'Researcher' => 'Peneliti',
                'Study' => 'Mempelajari',
                'Natural ecosystem' => 'Ekosistem alami',
                'Field observation tool' => 'Alat pengamatan lapangan',
                'Record' => 'Mencatat',
                'River flow' => 'Aliran sungai',
                'Environmental monitoring' => 'Pemantauan lingkungan',
                'Biologist team' => 'Tim biolog',
                'Measure' => 'Melakukan pengukuran',
                'Temperature' => 'Suhu',
                'Humidity' => 'Kelembapan',
                'Soil surface' => 'Permukaan tanah',
                'Dense vegetation' => 'Vegetasi rapat',
                'Maintain' => 'Menjaga',
                'Natural balance' => 'Keseimbangan alam',
                'Conservation' => 'Konservasi',
                'Take place' => 'Berlangsung',
                'Routinely' => 'Secara rutin',
                'Wildlife protection path' => 'Jalur perlindungan satwa liar',
                'Habitat' => 'Habitat',
                'Environmental education center' => 'Pusat edukasi lingkungan',
                'Human role' => 'Peran manusia',
                'Preservation' => 'Pelestarian',
                'Future' => 'Masa depan',
                'Earth' => 'Bumi'
            ]
        ];

        // Process and Insert Questions
        foreach ($questions as $idx => $data) {
            $vocab = [];
            // Preserve vocab structure
            if (isset($data['vocab'])) {
                foreach ($data['vocab'] as $en => $val) {
                    if (is_array($val)) {
                        $vocab[$en] = $val;
                    } else {
                        $vocab[$en] = ['id' => $val];
                    }
                }
            }

            GrammarQuestion::create([
                'meeting_number' => 8,
                'section' => 'prepositional_phrases',
                'question_number' => $idx,
                'question_text' => $data['id'],
                'correct_answer' => $data['en'],
                'example' => $data['example'] ?? null,
                'vocab' => $vocab
            ]);
        }

        // Process and Insert Paragraph
        // Wrap vocab in 'sentences' structure for view compatibility
        $sentences = [
            ['vocab' => $paragraph['vocab']]
        ];

        GrammarQuestion::create([
            'meeting_number' => 8,
            'section' => 'paragraph',
            'question_number' => 1,
            'question_text' => $paragraph['id'],
            'correct_answer' => $paragraph['en'],
            'vocab' => $sentences
        ]);

        $this->command->info('Meeting 8 data migrated successfully!');
    }
}
