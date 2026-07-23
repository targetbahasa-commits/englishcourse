<?php
$topicId = 61;

$questionText = "Describe a book you have recently read.\nYou should say:\n- what kind of book it is\n- what it is about\n- what sort of people would enjoy it\nand explain why you liked it.";

$mockAnswer = "I recently read a science fiction novel called 'Dune'. It is a very famous book about a desert planet called Arrakis and the political struggles to control its most valuable resource, the spice. I think people who enjoy complex world-building and political intrigue would really enjoy this book. I liked it because the characters are very well-developed and the story is unpredictable.";

$recordings = [
    [
        'question' => $questionText,
        'audio_url' => null,
        'answer' => $mockAnswer
    ]
];

$feedback = [
    'overall_band_score' => 7.5,
    'pronunciation_score' => 7.5,
    'pronunciation' => '<p>Pelafalan Anda sangat jelas dan mudah dimengerti. Intonasi terdengar natural dengan penekanan yang tepat pada kata-kata kunci, meskipun masih ada sedikit aksen daerah.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Lisan (English)</th><th class="border border-gray-200 p-2">Masalah / Kesalahan</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan (English)</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">intrigue</td><td class="border border-gray-200 p-2">Pelafalan vokal</td><td class="border border-gray-200 p-2">Hati-hati dengan pelafalan akhiran \'gue\', yang seharusnya berbunyi seperti \'g\'.</td><td class="border border-gray-200 p-2">in-TREEG</td></tr></tbody></table>',
    'fluency_and_coherence_score' => 7.5,
    'fluency_and_coherence' => '<p>Anda berbicara dengan sangat lancar dan mempertahankan kecepatan yang baik. Ide-ide mengalir secara logis dan mudah diikuti. Anda juga menggunakan penanda wacana (discourse markers) dengan baik.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Lisan (English)</th><th class="border border-gray-200 p-2">Masalah / Kesalahan</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan (English)</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">I liked it because the characters...</td><td class="border border-gray-200 p-2">Kurang kata hubung bervariasi</td><td class="border border-gray-200 p-2">Gunakan ungkapan lain selain \'because\' untuk memberikan alasan, agar lebih bervariasi.</td><td class="border border-gray-200 p-2">What really appealed to me was how the characters...</td></tr></tbody></table>',
    'lexical_resource_score' => 7.5,
    'lexical_resource' => '<p>Kosakata yang digunakan sudah luas dan Anda menggunakan beberapa istilah yang kurang umum dengan sukses, seperti "political intrigue" dan "world-building".</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Lisan (English)</th><th class="border border-gray-200 p-2">Masalah / Kesalahan</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan (English)</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">very famous book</td><td class="border border-gray-200 p-2">Kurang canggih</td><td class="border border-gray-200 p-2">Ganti dengan ungkapan yang lebih kuat dan presisi.</td><td class="border border-gray-200 p-2">a highly acclaimed novel</td></tr></tbody></table><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kosa Kata Asli</th><th class="border border-gray-200 p-2">Kosa Kata yang Lebih Baik (Band 9)</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">very famous</td><td class="border border-gray-200 p-2">widely celebrated / renowned</td></tr><tr><td class="border border-gray-200 p-2">enjoy</td><td class="border border-gray-200 p-2">appreciate / relish</td></tr></tbody></table>',
    'grammatical_range_score' => 7.5,
    'grammatical_range' => '<p>Rentang struktur tata bahasa Anda cukup luas dan digunakan secara fleksibel. Kebanyakan kalimat Anda bebas dari kesalahan.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Lisan (English)</th><th class="border border-gray-200 p-2">Masalah / Kesalahan</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan (English)</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">-</td><td class="border border-gray-200 p-2">-</td><td class="border border-gray-200 p-2">Tata bahasa Anda sudah sangat baik.</td><td class="border border-gray-200 p-2">-</td></tr></tbody></table>',
    'overall_comment' => '<p>Performa yang sangat kuat! Anda mampu mendeskripsikan topik dengan detail yang memadai dan kosa kata yang tepat. Terus berlatih untuk mengurangi keraguan kecil agar bisa mencapai band 8.</p>',
    'recordings' => $recordings
];

file_put_contents('storage/app/mock_eval_' . $topicId . '.json', json_encode($feedback, JSON_PRETTY_PRINT));
echo "Mock generated!\n";
