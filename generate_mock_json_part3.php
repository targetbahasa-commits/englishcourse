<?php
$topicId = 61;
$part = 3;

$mockAnswers = [
    "I don't think so. Most people nowadays are addicted to their smartphones and social media, so they rarely have time to read books.",
    "In my country, I think self-help books and fictional novels, especially romance and mystery, are the most popular ones.",
    "It's possible, because ebooks are very convenient and environmentally friendly. However, some people still prefer the physical feeling of holding a paper book.",
    "Reading is crucial for children. It helps them expand their vocabulary, improve their imagination, and understand different perspectives of the world."
];

$questions = [
    "Do you think people read enough books these days?",
    "What kind of books are most popular in your country?",
    "Do you think ebooks will eventually replace paper books?",
    "How can reading help children in their development?"
];

$recordings = [];
foreach ($questions as $index => $q) {
    $recordings[] = [
        'question' => $q,
        'audio_url' => null,
        'answer' => $mockAnswers[$index] ?? null
    ];
}

$feedback = [
    'overall_band_score' => 8.0,
    'pronunciation_score' => 8.0,
    'pronunciation' => '<p>Pelafalan Anda sangat baik dan mudah dipahami sepenuhnya. Anda dapat menggunakan fitur pelafalan kompleks dengan fleksibilitas yang baik, meskipun masih ada beberapa penyimpangan kecil namun tidak memengaruhi kejelasan.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Lisan (English)</th><th class="border border-gray-200 p-2">Masalah / Kesalahan</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan (English)</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">environmentally friendly</td><td class="border border-gray-200 p-2">Penekanan suku kata</td><td class="border border-gray-200 p-2">Pastikan penekanan pada suku kata \'men\' di kata "environmentally".</td><td class="border border-gray-200 p-2">en-vi-ron-MEN-tal-ly</td></tr></tbody></table>',
    'fluency_and_coherence_score' => 8.0,
    'fluency_and_coherence' => '<p>Anda berbicara secara fasih dengan hanya sedikit pengulangan atau koreksi diri. Anda dapat mengembangkan topik dengan koheren dan menyampaikan pandangan Anda secara komprehensif.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Lisan (English)</th><th class="border border-gray-200 p-2">Masalah / Kesalahan</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan (English)</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">It\'s possible, because ebooks are...</td><td class="border border-gray-200 p-2">Transisi bisa ditingkatkan</td><td class="border border-gray-200 p-2">Gunakan penanda wacana yang lebih akademis untuk menjawab pertanyaan prediksi.</td><td class="border border-gray-200 p-2">It\'s highly probable, primarily because ebooks are...</td></tr></tbody></table>',
    'lexical_resource_score' => 8.0,
    'lexical_resource' => '<p>Anda menggunakan perbendaharaan kata yang luas secara fleksibel untuk menyampaikan makna yang presisi. Anda menggunakan kosakata yang kurang umum secara natural.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Lisan (English)</th><th class="border border-gray-200 p-2">Masalah / Kesalahan</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan (English)</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">addicted to their smartphones</td><td class="border border-gray-200 p-2">Pemilihan kata</td><td class="border border-gray-200 p-2">Bisa menggunakan kosakata yang lebih idiomatik atau akademis.</td><td class="border border-gray-200 p-2">glued to their screens</td></tr></tbody></table><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kosa Kata Asli</th><th class="border border-gray-200 p-2">Kosa Kata yang Lebih Baik (Band 9)</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">addicted to</td><td class="border border-gray-200 p-2">preoccupied with / engrossed in</td></tr><tr><td class="border border-gray-200 p-2">crucial</td><td class="border border-gray-200 p-2">paramount / indispensable</td></tr></tbody></table>',
    'grammatical_range_score' => 8.0,
    'grammatical_range' => '<p>Anda menggunakan berbagai macam struktur kompleks secara bebas. Mayoritas kalimat Anda tidak memiliki kesalahan tata bahasa (error-free).</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Lisan (English)</th><th class="border border-gray-200 p-2">Masalah / Kesalahan</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan (English)</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">-</td><td class="border border-gray-200 p-2">-</td><td class="border border-gray-200 p-2">Tidak ada kesalahan tata bahasa yang signifikan. Struktur kalimat sudah sangat baik.</td><td class="border border-gray-200 p-2">-</td></tr></tbody></table>',
    'overall_comment' => '<p>Luar biasa! Jawaban-jawaban Anda sangat terstruktur, relevan dengan pertanyaan abstrak di Part 3, dan didukung oleh kosakata yang kuat. Pertahankan kualitas bahasa ini.</p>',
    'recordings' => $recordings
];

file_put_contents('storage/app/mock_eval_' . $topicId . '_part_' . $part . '.json', json_encode($feedback, JSON_PRETTY_PRINT));
echo "Mock part 3 generated!\n";
