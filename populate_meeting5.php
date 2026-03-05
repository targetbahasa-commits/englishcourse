<?php

// Script to populate Meeting 5 questions directly to database
// Run with: php artisan tinker < populate_meeting5.php

use App\Models\GrammarQuestion;
use App\Models\GrammarVocabulary;

// 1. Simple Sentences (Negative)
$sentences = [
    ['id' => 'Kita tidak menyelesaikan masalah ini', 'en' => 'We do not solve this problem', 'tense' => 'Simple Present'],
    ['id' => 'Dia (it) tidak membantu.', 'en' => 'It does not help', 'tense' => 'Simple Present'],
    ['id' => 'Pemerintah tidak melindungi hutan.', 'en' => 'The government does not protect the forest', 'tense' => 'Simple Present'],
    ['id' => 'Undang - undang tidak menjamin kebebasan berekspresi.', 'en' => 'The law does not guarantee freedom of expression', 'tense' => 'Simple Present'],
    ['id' => 'Mamalia tidak menyebar secara luas 2 juta tahun yang lalu,', 'en' => 'Mammals did not spread widely 2 million years ago', 'tense' => 'Simple Past'],
];

foreach ($sentences as $s) {
    GrammarQuestion::create([
        'meeting_number' => 5,
        'section' => 'sentences',
        'question_number' => 0,
        'tense' => $s['tense'],
        'question_text' => $s['id'],
        'correct_answer' => $s['en']
    ]);
}

// 2. Matrix Questions
$matrix = [
    // Simple Present
    ['tense' => 'Simple Present', 'structure' => 'nominal', 'id' => 'Beruang bukan karnivora.', 'en' => 'Bears are not carnivores'],
    ['tense' => 'Simple Present', 'structure' => 'passive', 'id' => 'Gajah utamanya tidak diburu untuk dagingnya.', 'en' => 'Elephants are not mainly hunted for their meat'],
    
    // Present Continuous
    ['tense' => 'Present Continuous', 'structure' => 'verbal', 'id' => 'Ekonomi global tidak sedang tumbuh.', 'en' => 'The global economy is not growing'],
    ['tense' => 'Present Continuous', 'structure' => 'nominal', 'id' => 'Pemerintah tidak sedang berhati - hati.', 'en' => 'The government is not being careful'],
    ['tense' => 'Present Continuous', 'structure' => 'passive', 'id' => 'Konsumsi bahan bakar tidak sedang dikurangi.', 'en' => 'Fuel consumption is not being reduced'],
    
    // Present Perfect
    ['tense' => 'Present Perfect', 'structure' => 'verbal', 'id' => 'Beberapa negara belum bergabung dengan PBB.', 'en' => 'Some countries have not joined the UN'],
    ['tense' => 'Present Perfect', 'structure' => 'nominal', 'id' => 'Hukum ini masih belum ada di negara kami.', 'en' => 'This law has not existed in our country yet'],
    ['tense' => 'Present Perfect', 'structure' => 'passive', 'id' => 'Air bersih masih belum dinikmati oleh banyak orang.', 'en' => 'Clean water has not been enjoyed by many people yet'],
    
    // Present Perfect Continuous
    ['tense' => 'Present Perfect Continuous', 'structure' => 'verbal', 'id' => 'Negara belum sedang mengembangkan teknologi semikonduktor.', 'en' => 'The country has not been developing semiconductor technology'],
    ['tense' => 'Present Perfect Continuous', 'structure' => 'nominal', 'id' => 'Pemerintah belum sedang berhati - hati.', 'en' => 'The government has not been being careful'],
    ['tense' => 'Present Perfect Continuous', 'structure' => 'passive', 'id' => 'Proyek ini belum sedang dibangun.', 'en' => 'This project has not been being built'],
    
    // Simple Past
    ['tense' => 'Simple Past', 'structure' => 'nominal', 'id' => 'Pantodonta tidak ada di berbagai ekosistem pada 66 juta tahun yang lalu.', 'en' => 'Pantodonta did not exist in various ecosystems 66 million years ago'],
    ['tense' => 'Simple Past', 'structure' => 'passive', 'id' => 'Kehidupan mamalia tidak dimusnahkan oleh komet.', 'en' => 'Mammalian life was not wiped out by the comet'],
    
    // Past Continuous
    ['tense' => 'Past Continuous', 'structure' => 'verbal', 'id' => 'Manusia tidak sedang menjelajahi Antartika 400 tahun yang lalu', 'en' => 'Humans were not exploring Antarctica 400 years ago'],
    ['tense' => 'Past Continuous', 'structure' => 'nominal', 'id' => 'Pemerintah tidak sedang berhati - hati tahun lalu,', 'en' => 'The government was not being careful last year'],
    ['tense' => 'Past Continuous', 'structure' => 'passive', 'id' => 'Minyak tidak sedang ditambang di Alaska.', 'en' => 'Oil was not being mined in Alaska'],
    
    // Past Perfect
    ['tense' => 'Past Perfect', 'structure' => 'verbal', 'id' => 'Columbus belum mengunjungi dataran utama Amerika di pelayaran pertama.', 'en' => 'Columbus had not visited mainland America on his first voyage'],
    ['tense' => 'Past Perfect', 'structure' => 'nominal', 'id' => 'Mamalia belum ada di Selandia Baru 1000 tahun yang lalu.', 'en' => 'Mammals had not existed in New Zealand 1000 years ago'],
    ['tense' => 'Past Perfect', 'structure' => 'passive', 'id' => 'Permafrost belum ditemukan dulu.', 'en' => 'Permafrost had not been discovered before'],
    
    // Past Perfect Continuous
    ['tense' => 'Past Perfect Continuous', 'structure' => 'verbal', 'id' => 'Banyak pabrik belum sedang menerapkan regulasi keamanan 50 tahun yang lalu.', 'en' => 'Many factories had not been implementing safety regulations 50 years ago'],
    ['tense' => 'Past Perfect Continuous', 'structure' => 'nominal', 'id' => 'Pemerintah belum sedang berhati - hati.', 'en' => 'The government had not been being careful'],
    ['tense' => 'Past Perfect Continuous', 'structure' => 'passive', 'id' => 'Nuklir belum sedang dikembangkan 100 tahun lalu.', 'en' => 'Nuclear had not been being developed 100 years ago'],
    
    // Simple Future
    ['tense' => 'Simple Future', 'structure' => 'verbal', 'id' => 'AI tidak akan menggantikan lapangan pekerjaan.', 'en' => 'AI will not replace jobs'],
    ['tense' => 'Simple Future', 'structure' => 'nominal', 'id' => 'Dunia tidak akan sama dalam 50 tahun lagi.', 'en' => 'The world will not be the same in 50 years'],
    ['tense' => 'Simple Future', 'structure' => 'passive', 'id' => 'Hidrogen tidak akan digunakan untuk bahan bakar utama dalam 10 tahun.', 'en' => 'Hydrogen will not be used as the main fuel in 10 years'],
    
    // Future Continuous
    ['tense' => 'Future Continuous', 'structure' => 'verbal', 'id' => 'Manusia tidak akan sedang menjelajahi Mars tahun depan.', 'en' => 'Humans will not be exploring Mars next year'],
    ['tense' => 'Future Continuous', 'structure' => 'nominal', 'id' => 'Pemerintah tidak akan sedang berhati - hati.', 'en' => 'The government will not be being careful'],
    ['tense' => 'Future Continuous', 'structure' => 'passive', 'id' => 'Asteroid tidak akan sedang dipelajari.', 'en' => 'Asteroids will not be being studied'],
    
    // Future Perfect
    ['tense' => 'Future Perfect', 'structure' => 'verbal', 'id' => 'Kita tidak akan sudah menemukan kehidupan alien dalam 100 tahun.', 'en' => 'We will not have found alien life in 100 years'],
    ['tense' => 'Future Perfect', 'structure' => 'nominal', 'id' => 'Teknologi tidak akan sudah ada di mana - mana.', 'en' => 'Technology will not have been everywhere'],
    ['tense' => 'Future Perfect', 'structure' => 'passive', 'id' => 'Kanker tidak akan sudah disembuhkan.', 'en' => 'Cancer will not have been cured'],
    
    // Future Perfect Continuous
    ['tense' => 'Future Perfect Continuous', 'structure' => 'verbal', 'id' => 'Ilmuwan tidak akan sudah sedang meneliti ini selama 50 tahun.', 'en' => 'Scientists will not have been researching this for 50 years'],
    ['tense' => 'Future Perfect Continuous', 'structure' => 'nominal', 'id' => 'Pemerintah tidak akan sudah sedang berhati - hati.', 'en' => 'The government will not have been being careful'],
    ['tense' => 'Future Perfect Continuous', 'structure' => 'passive', 'id' => 'Proyek ini tidak akan sudah sedang dibangun.', 'en' => 'This project will not have been being built'],
    
    // Simple Past Future
    ['tense' => 'Simple Past Future', 'structure' => 'verbal', 'id' => 'Saya tidak akan pergi.', 'en' => 'I would not go'],
    ['tense' => 'Simple Past Future', 'structure' => 'nominal', 'id' => 'Dia tidak akan ada di sana.', 'en' => 'He would not be there'],
    ['tense' => 'Simple Past Future', 'structure' => 'passive', 'id' => 'Itu tidak akan dilakukan.', 'en' => 'It would not be done'],
    
    // Past Future Continuous
    ['tense' => 'Past Future Continuous', 'structure' => 'verbal', 'id' => 'Kita tidak akan sedang rapat.', 'en' => 'We would not be meeting'],
    ['tense' => 'Past Future Continuous', 'structure' => 'nominal', 'id' => 'Dia tidak akan sedang menjadi kasar.', 'en' => 'He would not be being rude'],
    ['tense' => 'Past Future Continuous', 'structure' => 'passive', 'id' => 'Mobil itu tidak akan sedang diperbaiki.', 'en' => 'The car would not be being fixed'],
    
    // Past Future Perfect
    ['tense' => 'Past Future Perfect', 'structure' => 'verbal', 'id' => 'Saya tidak akan sudah lupa.', 'en' => 'I would not have forgotten'],
    ['tense' => 'Past Future Perfect', 'structure' => 'nominal', 'id' => 'Dia tidak akan sudah ada di sana.', 'en' => 'He would not have been there'],
    ['tense' => 'Past Future Perfect', 'structure' => 'passive', 'id' => 'Paket itu tidak akan sudah dikirim.', 'en' => 'The package would not have been sent'],
    
    // Past Future Perfect Continuous
    ['tense' => 'Past Future Perfect Continuous', 'structure' => 'verbal', 'id' => 'Mereka tidak akan sudah sedang tidur.', 'en' => 'They would not have been sleeping'],
    ['tense' => 'Past Future Perfect Continuous', 'structure' => 'nominal', 'id' => 'Dia tidak akan sudah sedang menjadi senang.', 'en' => 'He would not have been being happy'],
    ['tense' => 'Past Future Perfect Continuous', 'structure' => 'passive', 'id' => 'Buku itu tidak akan sudah sedang ditulis.', 'en' => 'The book would not have been being written'],
    
    // Modal
    ['tense' => 'Modal', 'structure' => 'verbal', 'id' => 'Kamu tidak boleh merokok.', 'en' => 'You must not smoke'],
    ['tense' => 'Modal', 'structure' => 'nominal', 'id' => 'Dia mungkin tidak sakit.', 'en' => 'He might not be sick'],
    ['tense' => 'Modal', 'structure' => 'passive', 'id' => 'Pintu itu tidak bisa dibuka.', 'en' => 'The door cannot be opened'],
];

foreach ($matrix as $m) {
    GrammarQuestion::create([
        'meeting_number' => 5,
        'section' => 'matrix',
        'question_number' => 0,
        'tense' => $m['tense'],
        'structure' => $m['structure'],
        'question_text' => $m['id'],
        'correct_answer' => $m['en']
    ]);
}

echo "Populated " . count($sentences) . " sentences and " . count($matrix) . " matrix questions\n";
echo "Total: " . GrammarQuestion::where('meeting_number', 5)->count() . " questions\n";
