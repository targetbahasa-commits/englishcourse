<?php

/**
 * Script to add Indonesian translations (meaning_id) to all idioms and collocations
 * in AssignmentController.php for IELTS Speaking Practice
 */

// Read the controller file
$file = '/Applications/MAMP/htdocs/TargetBahasaCourse/app/Http/Controllers/AssignmentController.php';
$content = file_get_contents($file);

// Define all translations
$translations = [
    // HOMETOWN (Lesson 1)
    "'phrase' => 'off the beaten track',\n                            'meaning' => 'in a place that is remote or not well-known'" => 
    "'phrase' => 'off the beaten track',\n                            'meaning' => 'in a place that is remote or not well-known',\n                            'meaning_id' => 'terpencil/jarang dikunjungi'",
    
    "'phrase' => 'a stone\\'s throw away',\n                            'meaning' => 'very close to'" =>
    "'phrase' => 'a stone\\'s throw away',\n                            'meaning' => 'very close to',\n                            'meaning_id' => 'sangat dekat'",
    
    "'phrase' => 'the heart of the city',\n                            'meaning' => 'the central or most important part'" =>
    "'phrase' => 'the heart of the city',\n                            'meaning' => 'the central or most important part',\n                            'meaning_id' => 'pusat kota'",
    
    "'phrase' => 'neck of the woods',\n                            'meaning' => 'a particular area'" =>
    "'phrase' => 'neck of the woods',\n                            'meaning' => 'a particular area',\n                            'meaning_id' => 'daerah/wilayah tertentu'",
    
    "'phrase' => 'home turf',\n                            'meaning' => 'one\\'s own territory or area'" =>
    "'phrase' => 'home turf',\n                            'meaning' => 'one\\'s own territory or area',\n                            'meaning_id' => 'wilayah sendiri'",
    
    "'phrase' => 'bustling city',\n                            'meaning' => 'a city full of activity'" =>
    "'phrase' => 'bustling city',\n                            'meaning' => 'a city full of activity',\n                            'meaning_id' => 'kota yang ramai'",
    
    "'phrase' => 'tight-knit community',\n                            'meaning' => 'a close and supportive group of people'" =>
    "'phrase' => 'tight-knit community',\n                            'meaning' => 'a close and supportive group of people',\n                            'meaning_id' => 'komunitas yang erat'",
    
    "'phrase' => 'rich cultural heritage',\n                            'meaning' => 'valuable traditions and history'" =>
    "'phrase' => 'rich cultural heritage',\n                            'meaning' => 'valuable traditions and history',\n                            'meaning_id' => 'warisan budaya yang kaya'",
    
    "'phrase' => 'local community',\n                            'meaning' => 'people living in a specific area'" =>
    "'phrase' => 'local community',\n                            'meaning' => 'people living in a specific area',\n                            'meaning_id' => 'komunitas lokal'",
    
    "'phrase' => 'scenic beauty',\n                            'meaning' => 'beautiful natural views'" =>
    "'phrase' => 'scenic beauty',\n                            'meaning' => 'beautiful natural views',\n                            'meaning_id' => 'keindahan alam'",
];

// Apply all replacements
foreach ($translations as $search => $replace) {
    $content = str_replace($search, $replace, $content);
}

// Write back to file
file_put_contents($file, $content);

echo "✅ Added Indonesian translations for Hometown (Lesson 1)\n";
echo "Total translations added: " . count($translations) . "\n";
