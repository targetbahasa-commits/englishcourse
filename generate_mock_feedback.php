<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$topic = \App\Models\IeltsSpeakingTopic::where('slug', 'part1-topic-1')->first();
$questions = is_string($topic->questions) ? json_decode($topic->questions, true) : $topic->questions;

$systemOverride = "You are an expert IELTS Speaking examiner. Assess the candidate's speaking audio based on the official IELTS Speaking Band Descriptors: Fluency & Coherence, Lexical Resource, Grammatical Range & Accuracy, and Pronunciation. Assign precise band scores (0-9) and provide highly detailed, analytical feedback. Ensure your evaluation is rigorous and aligns strictly with the official public IELTS grading standards.";
$systemOverride .= "\n\nCRITICAL INSTRUCTION: You must provide a LOT of specific, actionable suggestions for improvement based on the candidate's actual speaking. You MUST analyze the audio comprehensively from start to finish. Each table MUST contain AT LEAST 5 to 10 rows of detailed corrections and feedback.";
$systemOverride .= "\n\nYOU MUST FORMAT YOUR DETAILED FEEDBACK STRINGS AS HTML TABLES. Present your actionable feedback using exactly this styled HTML table format for EACH criteria field:\n`<table class=\"w-full text-left border-collapse border border-gray-200 mt-4 mb-4\"><thead class=\"bg-gray-50\"><tr><th class=\"border border-gray-200 p-2\">Kutipan Lisan (English)</th><th class=\"border border-gray-200 p-2\">Masalah / Kesalahan</th><th class=\"border border-gray-200 p-2\">Penjelasan</th><th class=\"border border-gray-200 p-2\">Perbaikan (English)</th></tr></thead><tbody><tr><td class=\"border border-gray-200 p-2\">...</td>...</tr></tbody></table>`";
$systemOverride .= "\nLanguage Rules for the Table: 'Kutipan Lisan' MUST be the exact transcribed snippet from the candidate's audio in English. 'Masalah / Kesalahan' and 'Penjelasan' MUST be entirely in Bahasa Indonesia. 'Perbaikan' MUST be the corrected snippet in English.";
$systemOverride .= "\n\nYou MUST return a JSON object with EXACTLY the following keys:
- 'overall_band_score' (number)
- 'pronunciation_score' (number)
- 'pronunciation' (string) MUST start with a short summary paragraph (<p>...</p>) in Bahasa Indonesia explaining the performance, FOLLOWED BY the HTML table.
- 'fluency_and_coherence_score' (number)
- 'fluency_and_coherence' (string) MUST start with a short summary paragraph (<p>...</p>) in Bahasa Indonesia explaining the performance, FOLLOWED BY the HTML table.
- 'lexical_resource_score' (number)
- 'lexical_resource' (string) MUST start with a short summary paragraph (<p>...</p>) in Bahasa Indonesia explaining the performance, FOLLOWED BY the main HTML table. THEN you MUST provide a SECOND HTML table listing vocabulary upgrades with 2 columns: 'Kosa Kata Asli' and 'Kosa Kata yang Lebih Baik'. This second table MUST contain AT LEAST 10 ROWS of vocabulary upgrades.
- 'grammatical_range_score' (number)
- 'grammatical_range' (string) MUST start with a short summary paragraph (<p>...</p>) in Bahasa Indonesia explaining the performance, FOLLOWED BY the HTML table.
- 'overall_comment' (string, general summary in Bahasa Indonesia)";

$parts = [
    ['text' => $systemOverride]
];

// Generate fake transcript
$mockAnswers = [
    "I currently work as a software engineer at a tech company in Jakarta.",
    "I enjoy the problem-solving aspect of my work. It is very challenging but also rewarding when I figure out a solution.",
    "I prefer working with others because we can brainstorm ideas together, although sometimes I need quiet time to focus."
];

foreach ($questions as $index => $q) {
    $parts[] = ['text' => "Question: " . $q . "\nCandidate Answer: " . ($mockAnswers[$index] ?? "I don't know.")];
}

$geminiKeys = \App\Services\AiProviderKeyManager::getKeys('gemini');
$response = \Illuminate\Support\Facades\Http::withHeaders([
    'Content-Type' => 'application/json'
])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $geminiKeys[0], [
    'contents' => [
        ['parts' => $parts]
    ],
    'generationConfig' => [
        'responseMimeType' => 'application/json',
    ]
]);

$feedback = json_decode($response->json('candidates.0.content.parts.0.text'), true);

$recordings = [];
foreach ($questions as $index => $q) {
    $recordings[] = [
        'question' => $q,
        'audio_url' => null,
        'answer' => $mockAnswers[$index] ?? null
    ];
}
$feedback['recordings'] = $recordings;

file_put_contents('storage/app/mock_eval_' . $topic->id . '.json', json_encode($feedback, JSON_PRETTY_PRINT));
echo "Mock evaluation saved!\n";
