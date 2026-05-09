<?php

use App\Models\GrammarQuestion;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$paragraph = [
    'id' => 'Perubahan lingkungan kini menjadi isu global yang semakin mendesak dan tidak dapat diabaikan. Banyak komunitas ilmiah di seluruh dunia sedang meneliti dampak pemanasan global terhadap keanekaragaman hayati di kawasan pesisir, hutan hujan tropis, dan wilayah kutub yang sensitif. Saya sendiri telah melihat bagaimana kualitas air menurun secara drastis selama satu dekade terakhir, terutama di daerah pesisir tempat saya melakukan penelitian kecil bersama kelompok konservasi lokal. Pada masa lalu, pemerintah membangun banyak program konservasi, tetapi sebagian besar tidak dijalankan secara efektif sehingga manfaatnya tidak dapat dirasakan secara nyata oleh masyarakat. Saat ini, prioritas utama adalah melindungi ekosistem laut, yang merupakan sumber kehidupan bagi jutaan orang dan menopang perekonomian daerah pesisir. Para ilmuwan yang saya temui menjelaskan bahwa perubahan iklim tidak hanya mempengaruhi spesies langka, tetapi juga ekonomi nelayan lokal yang semakin rentan terhadap badai dan ketidakpastian cuaca. Mereka menggunakan pengumpulan data secara sistematis untuk meningkatkan akurasi penelitian dan memperkirakan tren lingkungan jangka panjang. Untuk memahami penyebab utama kerusakan lingkungan, banyak peneliti melakukan analisis mendalam dengan metode yang lebih efisien melalui kolaborasi antaruniversitas dan lembaga internasional. Ekosistem terumbu karang adalah salah satu ekosistem paling rentan di dunia, karena lokasi di mana intensitas polusi sangat tinggi dan suhu permukaan laut terus meningkat. Komunitas nelayan, yang wilayahnya terancam naiknya permukaan laut akibat mencairnya es di kutub, terus berjuang mempertahankan mata pencaharian mereka meskipun bantuan pemerintah sering terlambat dan tidak mencukupi. Beberapa kelompok masyarakat mengembangkan strategi konservasi berbasis budaya lokal dengan harapan dapat meningkatkan kesadaran publik melalui pendidikan lingkungan dan pelatihan pengelolaan laut berkelanjutan.',
    'en' => 'Environmental change is now an increasingly urgent global issue that cannot be ignored. Many scientific communities around the world are researching the impact of global warming on biodiversity in coastal areas, tropical rainforests, and sensitive polar regions. I myself have seen how water quality has declined drastically over the last decade, especially in coastal areas where I conduct small research with local conservation groups. In the past, the government built many conservation programs, but most were not implemented effectively so that the benefits could not be felt tangibly by the community. Currently, the main priority is protecting marine ecosystems, which are a source of life for millions of people and support the economy of coastal areas. The scientists I met explained that climate change not only affects rare species, but also the economy of local fishermen who are increasingly vulnerable to storms and weather uncertainty. They use systematic data collection to improve research accuracy and predict long-term environmental trends. To understand the main causes of environmental damage, many researchers conduct in-depth analysis with more efficient methods through collaboration between universities and international institutions. Coral reef ecosystems are one of the most vulnerable ecosystems in the world, due to locations where pollution intensity is very high and sea surface temperatures continue to rise. Fishing communities, whose territories are threatened by rising sea levels due to melting polar ice, continue to struggle to maintain their livelihoods even though government assistance is often late and insufficient. Some community groups develop conservation strategies based on local culture with the hope of increasing public awareness through environmental education and sustainable marine management training.',
    'vocab' => [
        'Environmental change' => 'Perubahan lingkungan',
        'Urgent' => 'Mendesak',
        'Global issue' => 'Isu global',
        'Ignored' => 'Diabaikan',
        'Scientific community' => 'Komunitas ilmiah',
        'Research' => 'Meneliti',
        'Impact' => 'Dampak',
        'Global warming' => 'Pemanasan global',
        'Biodiversity' => 'Keanekaragaman hayati',
        'Coastal area' => 'Kawasan pesisir',
        'Tropical rainforest' => 'Hutan hujan tropis',
        'Polar region' => 'Wilayah kutub',
        'Sensitive' => 'Sensitif',
        'Water quality' => 'Kualitas air',
        'Decline' => 'Menurun',
        'Drastically' => 'Secara drastis',
        'Decade' => 'Dekade',
        'Conservation group' => 'Kelompok konservasi',
        'Conservation program' => 'Program konservasi',
        'Implemented' => 'Dijalankan',
        'Effectively' => 'Secara efektif',
        'Benefits' => 'Manfaat',
        'Tangibly' => 'Secara nyata',
        'Priority' => 'Prioritas',
        'Marine ecosystem' => 'Ekosistem laut',
        'Source of life' => 'Sumber kehidupan',
        'Support' => 'Menopang',
        'Economy' => 'Perekonomian',
        'Climate change' => 'Perubahan iklim',
        'Rare species' => 'Spesies langka',
        'Fisherman' => 'Nelayan',
        'Vulnerable' => 'Rentan',
        'Storm' => 'Badai',
        'Uncertainty' => 'Ketidakpastian',
        'Systematic' => 'Sistematis',
        'Accuracy' => 'Akurasi',
        'Predict' => 'Memperkirakan',
        'Trend' => 'Tren',
        'Long-term' => 'Jangka panjang',
        'Damage' => 'Kerusakan',
        'Analysis' => 'Analisis',
        'In-depth' => 'Mendalam',
        'Efficient' => 'Efisien',
        'Collaboration' => 'Kolaborasi',
        'Coral reef' => 'Terumbu karang',
        'Intensity' => 'Intensitas',
        'Pollution' => 'Polusi',
        'Surface' => 'Permukaan',
        'Threatened' => 'Terancam',
        'Melting' => 'Mencairnya',
        'Struggle' => 'Berjuang',
        'Livelihood' => 'Mata pencaharian',
        'Assistance' => 'Bantuan',
        'Insufficient' => 'Tidak mencukupi',
        'Awareness' => 'Kesadaran',
        'Sustainable' => 'Berkelanjutan'
    ]
];

// Clean up existing Meeting 20 data
GrammarQuestion::where('meeting_number', 20)->delete();

// Insert Paragraph
GrammarQuestion::create([
    'meeting_number' => 20,
    'question_number' => 100,
    'section' => 'paragraph',
    'question_type' => 'paragraph',
    'question_text' => $paragraph['id'],
    'correct_answer' => $paragraph['en'],
    'vocab' => $paragraph['vocab'],
]);

echo "Meeting 20 migration completed successfully.\n";
