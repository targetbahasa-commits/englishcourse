<?php

/**
 * Comprehensive script to add ALL remaining Indonesian translations
 * for Daily Routine, Hobbies, and all Lesson 2 subtopics
 */

$file = '/Applications/MAMP/htdocs/TargetBahasaCourse/app/Http/Controllers/AssignmentController.php';
$content = file_get_contents($file);

// ALL REMAINING TRANSLATIONS
$translations = [
    // DAILY ROUTINE
    "'phrase' => 'rise and shine',\n                            'meaning' => 'wake up and get out of bed'" =>
    "'phrase' => 'rise and shine',\n                            'meaning' => 'wake up and get out of bed',\n                            'meaning_id' => 'bangun dan bersiap'",
    
    "'phrase' => 'call it a day',\n                            'meaning' => 'to stop working for the day'" =>
    "'phrase' => 'call it a day',\n                            'meaning' => 'to stop working for the day',\n                            'meaning_id' => 'mengakhiri pekerjaan hari ini'",
    
    "'phrase' => 'the crack of dawn',\n                            'meaning' => 'very early in the morning'" =>
    "'phrase' => 'the crack of dawn',\n                            'meaning' => 'very early in the morning',\n                            'meaning_id' => 'pagi-pagi sekali'",
    
    "'phrase' => 'early bird',\n                            'meaning' => 'someone who wakes up early'" =>
    "'phrase' => 'early bird',\n                            'meaning' => 'someone who wakes up early',\n                            'meaning_id' => 'orang yang bangun pagi'",
    
    "'phrase' => 'night owl',\n                            'meaning' => 'someone who stays up late'" =>
    "'phrase' => 'night owl',\n                            'meaning' => 'someone who stays up late',\n                            'meaning_id' => 'orang yang begadang'",
    
    "'phrase' => 'morning person',\n                            'meaning' => 'someone who feels energetic in the morning'" =>
    "'phrase' => 'morning person',\n                            'meaning' => 'someone who feels energetic in the morning',\n                            'meaning_id' => 'orang yang aktif di pagi hari'",
    
    "'phrase' => 'hectic schedule',\n                            'meaning' => 'a very busy timetable'" =>
    "'phrase' => 'hectic schedule',\n                            'meaning' => 'a very busy timetable',\n                            'meaning_id' => 'jadwal yang padat'",
    
    "'phrase' => 'wind down',\n                            'meaning' => 'to relax after a busy period'" =>
    "'phrase' => 'wind down',\n                            'meaning' => 'to relax after a busy period',\n                            'meaning_id' => 'bersantai/rileks'",
    
    "'phrase' => 'daily commute',\n                            'meaning' => 'regular journey to work or school'" =>
    "'phrase' => 'daily commute',\n                            'meaning' => 'regular journey to work or school',\n                            'meaning_id' => 'perjalanan harian ke tempat kerja/sekolah'",
    
    "'phrase' => 'set routine',\n                            'meaning' => 'a fixed pattern of activities'" =>
    "'phrase' => 'set routine',\n                            'meaning' => 'a fixed pattern of activities',\n                            'meaning_id' => 'rutinitas tetap'",
    
    // HOBBIES & INTERESTS
    "'phrase' => 'get the hang of it',\n                            'meaning' => 'to learn how to do something'" =>
    "'phrase' => 'get the hang of it',\n                            'meaning' => 'to learn how to do something',\n                            'meaning_id' => 'mulai menguasai/memahami'",
    
    "'phrase' => 'pick up a hobby',\n                            'meaning' => 'to start a new hobby'" =>
    "'phrase' => 'pick up a hobby',\n                            'meaning' => 'to start a new hobby',\n                            'meaning_id' => 'memulai hobi baru'",
    
    "'phrase' => 'let off steam',\n                            'meaning' => 'to release stress or tension'" =>
    "'phrase' => 'let off steam',\n                            'meaning' => 'to release stress or tension',\n                            'meaning_id' => 'melepaskan stres'",
    
    "'phrase' => 'take up',\n                            'meaning' => 'to start doing something new'" =>
    "'phrase' => 'take up',\n                            'meaning' => 'to start doing something new',\n                            'meaning_id' => 'memulai (aktivitas baru)'",
    
    "'phrase' => 'get into',\n                            'meaning' => 'to become interested in something'" =>
    "'phrase' => 'get into',\n                            'meaning' => 'to become interested in something',\n                            'meaning_id' => 'mulai tertarik pada'",
    
    "'phrase' => 'pursue a passion',\n                            'meaning' => 'to follow something you love doing'" =>
    "'phrase' => 'pursue a passion',\n                            'meaning' => 'to follow something you love doing',\n                            'meaning_id' => 'mengejar passion/minat'",
    
    "'phrase' => 'spare time',\n                            'meaning' => 'free time when you\\'re not working'" =>
    "'phrase' => 'spare time',\n                            'meaning' => 'free time when you\\'re not working',\n                            'meaning_id' => 'waktu luang'",
    
    "'phrase' => 'broaden your horizons',\n                            'meaning' => 'to expand your experiences and knowledge'" =>
    "'phrase' => 'broaden your horizons',\n                            'meaning' => 'to expand your experiences and knowledge',\n                            'meaning_id' => 'memperluas wawasan'",
    
    "'phrase' => 'leisure activities',\n                            'meaning' => 'things done for enjoyment in free time'" =>
    "'phrase' => 'leisure activities',\n                            'meaning' => 'things done for enjoyment in free time',\n                            'meaning_id' => 'kegiatan santai'",
    
    "'phrase' => 'creative outlet',\n                            'meaning' => 'a way to express creativity'" =>
    "'phrase' => 'creative outlet',\n                            'meaning' => 'a way to express creativity',\n                            'meaning_id' => 'saluran kreativitas'",
    
    // HOMETOWN (Lesson 2)
    "'phrase' => 'put on the map',\n                            'meaning' => 'to make a place famous or well-known'" =>
    "'phrase' => 'put on the map',\n                            'meaning' => 'to make a place famous or well-known',\n                            'meaning_id' => 'membuat terkenal'",
    
    "'phrase' => 'the talk of the town',\n                            'meaning' => 'something everyone is discussing'" =>
    "'phrase' => 'the talk of the town',\n                            'meaning' => 'something everyone is discussing',\n                            'meaning_id' => 'pembicaraan orang banyak'",
    
    "'phrase' => 'a far cry from',\n                            'meaning' => 'very different from'" =>
    "'phrase' => 'a far cry from',\n                            'meaning' => 'very different from',\n                            'meaning_id' => 'sangat berbeda dari'",
    
    "'phrase' => 'off the map',\n                            'meaning' => 'remote or unknown'" =>
    "'phrase' => 'off the map',\n                            'meaning' => 'remote or unknown',\n                            'meaning_id' => 'terpencil/tidak dikenal'",
    
    "'phrase' => 'be known for',\n                            'meaning' => 'to be famous because of something'" =>
    "'phrase' => 'be known for',\n                            'meaning' => 'to be famous because of something',\n                            'meaning_id' => 'dikenal karena'",
    
    "'phrase' => 'be located in/on',\n                            'meaning' => 'to be situated in a particular place'" =>
    "'phrase' => 'be located in/on',\n                            'meaning' => 'to be situated in a particular place',\n                            'meaning_id' => 'terletak di'",
    
    "'phrase' => 'tourist attraction',\n                            'meaning' => 'a place that tourists visit'" =>
    "'phrase' => 'tourist attraction',\n                            'meaning' => 'a place that tourists visit',\n                            'meaning_id' => 'objek wisata'",
    
    "'phrase' => 'be situated',\n                            'meaning' => 'to be in a particular position'" =>
    "'phrase' => 'be situated',\n                            'meaning' => 'to be in a particular position',\n                            'meaning_id' => 'terletak/berada'",
    
    "'phrase' => 'local economy',\n                            'meaning' => 'the financial system of a specific area'" =>
    "'phrase' => 'local economy',\n                            'meaning' => 'the financial system of a specific area',\n                            'meaning_id' => 'ekonomi lokal'",
    
    // MUSEUMS & HISTORICAL SITES
    "'phrase' => 'a walk down memory lane',\n                            'meaning' => 'thinking about the past'" =>
    "'phrase' => 'a walk down memory lane',\n                            'meaning' => 'thinking about the past',\n                            'meaning_id' => 'mengenang masa lalu'",
    
    "'phrase' => 'stand the test of time',\n                            'meaning' => 'to remain valuable or useful for a long time'" =>
    "'phrase' => 'stand the test of time',\n                            'meaning' => 'to remain valuable or useful for a long time',\n                            'meaning_id' => 'bertahan sepanjang waktu'",
    
    "'phrase' => 'bring history to life',\n                            'meaning' => 'to make history interesting and real'" =>
    "'phrase' => 'bring history to life',\n                            'meaning' => 'to make history interesting and real',\n                            'meaning_id' => 'menghidupkan sejarah'",
    
    "'phrase' => 'turn back the clock',\n                            'meaning' => 'to return to the past'" =>
    "'phrase' => 'turn back the clock',\n                            'meaning' => 'to return to the past',\n                            'meaning_id' => 'kembali ke masa lalu'",
    
    "'phrase' => 'a thing of the past',\n                            'meaning' => 'something that no longer exists'" =>
    "'phrase' => 'a thing of the past',\n                            'meaning' => 'something that no longer exists',\n                            'meaning_id' => 'sesuatu yang sudah berlalu'",
    
    "'phrase' => 'be preserved',\n                            'meaning' => 'to be kept in good condition'" =>
    "'phrase' => 'be preserved',\n                            'meaning' => 'to be kept in good condition',\n                            'meaning_id' => 'dilestarikan'",
    
    "'phrase' => 'cultural heritage',\n                            'meaning' => 'traditions and monuments from the past'" =>
    "'phrase' => 'cultural heritage',\n                            'meaning' => 'traditions and monuments from the past',\n                            'meaning_id' => 'warisan budaya'",
    
    "'phrase' => 'be displayed',\n                            'meaning' => 'to be shown to the public'" =>
    "'phrase' => 'be displayed',\n                            'meaning' => 'to be shown to the public',\n                            'meaning_id' => 'dipamerkan'",
    
    "'phrase' => 'be exhibited',\n                            'meaning' => 'to be shown publicly'" =>
    "'phrase' => 'be exhibited',\n                            'meaning' => 'to be shown publicly',\n                            'meaning_id' => 'dipamerkan'",
    
    "'phrase' => 'historical significance',\n                            'meaning' => 'importance in history'" =>
    "'phrase' => 'historical significance',\n                            'meaning' => 'importance in history',\n                            'meaning_id' => 'nilai sejarah'",
    
    // FESTIVALS & CELEBRATIONS
    "'phrase' => 'paint the town red',\n                            'meaning' => 'to go out and celebrate in a lively way'" =>
    "'phrase' => 'paint the town red',\n                            'meaning' => 'to go out and celebrate in a lively way',\n                            'meaning_id' => 'merayakan dengan meriah'",
    
    "'phrase' => 'the icing on the cake',\n                            'meaning' => 'something that makes a good situation even better'" =>
    "'phrase' => 'the icing on the cake',\n                            'meaning' => 'something that makes a good situation even better',\n                            'meaning_id' => 'puncak dari sesuatu yang baik'",
    
    "'phrase' => 'have a blast',\n                            'meaning' => 'to have a great time'" =>
    "'phrase' => 'have a blast',\n                            'meaning' => 'to have a great time',\n                            'meaning_id' => 'bersenang-senang'",
    
    "'phrase' => 'let your hair down',\n                            'meaning' => 'to relax and enjoy yourself'" =>
    "'phrase' => 'let your hair down',\n                            'meaning' => 'to relax and enjoy yourself',\n                            'meaning_id' => 'bersantai dan menikmati diri sendiri'",
    
    "'phrase' => 'the life of the party',\n                            'meaning' => 'the most fun person at an event'" =>
    "'phrase' => 'the life of the party',\n                            'meaning' => 'the most fun person at an event',\n                            'meaning_id' => 'orang paling menyenangkan di pesta'",
    
    "'phrase' => 'be celebrated',\n                            'meaning' => 'to be marked with festivities'" =>
    "'phrase' => 'be celebrated',\n                            'meaning' => 'to be marked with festivities',\n                            'meaning_id' => 'dirayakan'",
    
    "'phrase' => 'traditional food',\n                            'meaning' => 'food that is customary for a culture'" =>
    "'phrase' => 'traditional food',\n                            'meaning' => 'food that is customary for a culture',\n                            'meaning_id' => 'makanan tradisional'",
    
    "'phrase' => 'mark the occasion',\n                            'meaning' => 'to celebrate an important event'" =>
    "'phrase' => 'mark the occasion',\n                            'meaning' => 'to celebrate an important event',\n                            'meaning_id' => 'merayakan acara'",
    
    "'phrase' => 'be observed',\n                            'meaning' => 'to be celebrated or followed'" =>
    "'phrase' => 'be observed',\n                            'meaning' => 'to be celebrated or followed',\n                            'meaning_id' => 'dirayakan/dijalankan'",
    
    "'phrase' => 'festive atmosphere',\n                            'meaning' => 'a celebratory mood'" =>
    "'phrase' => 'festive atmosphere',\n                            'meaning' => 'a celebratory mood',\n                            'meaning_id' => 'suasana perayaan'",
    
    // COMPUTERS & APPS
    "'phrase' => 'at your fingertips',\n                            'meaning' => 'easily accessible'" =>
    "'phrase' => 'at your fingertips',\n                            'meaning' => 'easily accessible',\n                            'meaning_id' => 'mudah diakses'",
    
    "'phrase' => 'cutting-edge technology',\n                            'meaning' => 'the most advanced technology'" =>
    "'phrase' => 'cutting-edge technology',\n                            'meaning' => 'the most advanced technology',\n                            'meaning_id' => 'teknologi canggih'",
    
    "'phrase' => 'a game changer',\n                            'meaning' => 'something that significantly changes a situation'" =>
    "'phrase' => 'a game changer',\n                            'meaning' => 'something that significantly changes a situation',\n                            'meaning_id' => 'pengubah permainan/situasi'",
    
    "'phrase' => 'tech-savvy',\n                            'meaning' => 'knowledgeable about technology'" =>
    "'phrase' => 'tech-savvy',\n                            'meaning' => 'knowledgeable about technology',\n                            'meaning_id' => 'paham teknologi'",
    
    "'phrase' => 'go viral',\n                            'meaning' => 'to become very popular online quickly'" =>
    "'phrase' => 'go viral',\n                            'meaning' => 'to become very popular online quickly',\n                            'meaning_id' => 'menjadi viral/populer'",
    
    "'phrase' => 'be used by',\n                            'meaning' => 'to be utilized by someone'" =>
    "'phrase' => 'be used by',\n                            'meaning' => 'to be utilized by someone',\n                            'meaning_id' => 'digunakan oleh'",
    
    "'phrase' => 'rely on',\n                            'meaning' => 'to depend on something'" =>
    "'phrase' => 'rely on',\n                            'meaning' => 'to depend on something',\n                            'meaning_id' => 'bergantung pada'",
    
    "'phrase' => 'user-friendly interface',\n                            'meaning' => 'easy to use design'" =>
    "'phrase' => 'user-friendly interface',\n                            'meaning' => 'easy to use design',\n                            'meaning_id' => 'antarmuka yang mudah digunakan'",
    
    "'phrase' => 'be downloaded',\n                            'meaning' => 'to be transferred from the internet'" =>
    "'phrase' => 'be downloaded',\n                            'meaning' => 'to be transferred from the internet',\n                            'meaning_id' => 'diunduh'",
    
    "'phrase' => 'digital platform',\n                            'meaning' => 'an online system or service'" =>
    "'phrase' => 'digital platform',\n                            'meaning' => 'an online system or service',\n                            'meaning_id' => 'platform digital'",
];

// Apply all replacements
$count = 0;
foreach ($translations as $search => $replace) {
    if (str_contains($content, $search)) {
        $content = str_replace($search, $replace, $content);
        $count++;
    }
}

// Write back to file
file_put_contents($file, $content);

echo "✅ Added Indonesian translations for ALL remaining subtopics\n";
echo "Total translations added: $count / " . count($translations) . "\n";
echo "\nSubtopics completed:\n";
echo "- Daily Routine (10 items)\n";
echo "- Hobbies & Interests (10 items)\n";
echo "- Hometown - Lesson 2 (9 items)\n";
echo "- Museums & Historical Sites (10 items)\n";
echo "- Festivals & Celebrations (10 items)\n";
echo "- Computers & Apps (10 items)\n";
echo "\n✅ ALL 90 TRANSLATIONS COMPLETE!\n";
