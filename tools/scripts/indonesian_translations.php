<?php

// Indonesian translations for all idioms and collocations
// This file contains all translations to be added to AssignmentController.php

$translations = [
    // HOME & ACCOMMODATION
    'home sweet home' => 'rumah yang manis/nyaman',
    'make yourself at home' => 'merasa seperti di rumah sendiri',
    'a roof over your head' => 'tempat tinggal',
    'feel at home' => 'merasa nyaman',
    'home is where the heart is' => 'rumah adalah tempat hati berada',
    'cozy atmosphere' => 'suasana nyaman',
    'spacious layout' => 'tata ruang yang luas',
    'prime location' => 'lokasi strategis',
    'modern amenities' => 'fasilitas modern',
    'residential area' => 'area perumahan',
    
    // HOMETOWN (Lesson 1)
    'off the beaten track' => 'terpencil/jarang dikunjungi',
    'a stone\'s throw away' => 'sangat dekat',
    'the heart of the city' => 'pusat kota',
    'neck of the woods' => 'daerah/wilayah tertentu',
    'home turf' => 'wilayah sendiri',
    'bustling city' => 'kota yang ramai',
    'tight-knit community' => 'komunitas yang erat',
    'rich cultural heritage' => 'warisan budaya yang kaya',
    'local community' => 'komunitas lokal',
    'scenic beauty' => 'keindahan alam',
    
    // DAILY ROUTINE
    'rise and shine' => 'bangun dan bersiap',
    'call it a day' => 'mengakhiri pekerjaan hari ini',
    'the crack of dawn' => 'pagi-pagi sekali',
    'early bird' => 'orang yang bangun pagi',
    'night owl' => 'orang yang begadang',
    'morning person' => 'orang yang aktif di pagi hari',
    'hectic schedule' => 'jadwal yang padat',
    'wind down' => 'bersantai/rileks',
    'daily commute' => 'perjalanan harian ke tempat kerja/sekolah',
    'set routine' => 'rutinitas tetap',
    
    // HOBBIES & INTERESTS
    'get the hang of it' => 'mulai menguasai/memahami',
    'pick up a hobby' => 'memulai hobi baru',
    'let off steam' => 'melepaskan stres',
    'take up' => 'memulai (aktivitas baru)',
    'get into' => 'mulai tertarik pada',
    'pursue a passion' => 'mengejar passion/minat',
    'spare time' => 'waktu luang',
    'broaden your horizons' => 'memperluas wawasan',
    'leisure activities' => 'kegiatan santai',
    'creative outlet' => 'saluran kreativitas',
    
    // HOMETOWN (Lesson 2)
    'put on the map' => 'membuat terkenal',
    'the talk of the town' => 'pembicaraan orang banyak',
    'a far cry from' => 'sangat berbeda dari',
    'off the map' => 'terpencil/tidak dikenal',
    'be known for' => 'dikenal karena',
    'be located in/on' => 'terletak di',
    'tourist attraction' => 'objek wisata',
    'be situated' => 'terletak/berada',
    'local economy' => 'ekonomi lokal',
    
    // MUSEUMS & HISTORICAL SITES
    'a walk down memory lane' => 'mengenang masa lalu',
    'stand the test of time' => 'bertahan sepanjang waktu',
    'bring history to life' => 'menghidupkan sejarah',
    'turn back the clock' => 'kembali ke masa lalu',
    'a thing of the past' => 'sesuatu yang sudah berlalu',
    'be preserved' => 'dilestarikan',
    'cultural heritage' => 'warisan budaya',
    'be displayed' => 'dipamerkan',
    'be exhibited' => 'dipamerkan',
    'historical significance' => 'nilai sejarah',
    
    // FESTIVALS & CELEBRATIONS
    'paint the town red' => 'merayakan dengan meriah',
    'the icing on the cake' => 'puncak dari sesuatu yang baik',
    'have a blast' => 'bersenang-senang',
    'let your hair down' => 'bersantai dan menikmati diri sendiri',
    'the life of the party' => 'orang paling menyenangkan di pesta',
    'be celebrated' => 'dirayakan',
    'traditional food' => 'makanan tradisional',
    'mark the occasion' => 'merayakan acara',
    'be observed' => 'dirayakan/dijalankan',
    'festive atmosphere' => 'suasana perayaan',
    
    // COMPUTERS & APPS
    'at your fingertips' => 'mudah diakses',
    'cutting-edge technology' => 'teknologi canggih',
    'a game changer' => 'pengubah permainan/situasi',
    'tech-savvy' => 'paham teknologi',
    'go viral' => 'menjadi viral/populer',
    'be used by' => 'digunakan oleh',
    'rely on' => 'bergantung pada',
    'user-friendly interface' => 'antarmuka yang mudah digunakan',
    'be downloaded' => 'diunduh',
    'digital platform' => 'platform digital',
];

// Print all translations for reference
echo "=== INDONESIAN TRANSLATIONS ===\n\n";
foreach ($translations as $phrase => $meaning_id) {
    echo "'$phrase' => '$meaning_id'\n";
}

echo "\n\nTotal translations: " . count($translations) . "\n";
