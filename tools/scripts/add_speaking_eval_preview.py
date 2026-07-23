import re

file_path = "app/Http/Controllers/IeltsSpeakingController.php"
with open(file_path, "r") as f:
    content = f.read()

method_code = """
    public function evaluationPreview($part, $id)
    {
        $bandScore = 7.5;
        $aiFeedback = [
            'overall_band_score' => $bandScore,
            'task_response_score' => $bandScore,
            'task_response' => '<p>Dummy Task Response summary.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Asli</th><th class="border border-gray-200 p-2">Masalah</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Hello</td><td class="border border-gray-200 p-2">Ini masalah</td><td class="border border-gray-200 p-2">Ini penjelasan</td><td class="border border-gray-200 p-2">Hi</td></tr></tbody></table>',
            'coherence_cohesion_score' => $bandScore,
            'coherence_cohesion' => '<p>Dummy Coherence summary.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Asli</th><th class="border border-gray-200 p-2">Masalah</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Hello</td><td class="border border-gray-200 p-2">Ini masalah</td><td class="border border-gray-200 p-2">Ini penjelasan</td><td class="border border-gray-200 p-2">Hi</td></tr></tbody></table>',
            'lexical_resource_score' => $bandScore,
            'lexical_resource' => '<p>Dummy Lexical summary.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Asli</th><th class="border border-gray-200 p-2">Masalah</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Hello</td><td class="border border-gray-200 p-2">Ini masalah</td><td class="border border-gray-200 p-2">Ini penjelasan</td><td class="border border-gray-200 p-2">Hi</td></tr></tbody></table><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kosa Kata Asli</th><th class="border border-gray-200 p-2">Kosa Kata yang Lebih Baik</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Good</td><td class="border border-gray-200 p-2">Excellent</td></tr></tbody></table>',
            'grammatical_range_score' => $bandScore,
            'grammatical_range' => '<p>Dummy Grammar summary.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Asli</th><th class="border border-gray-200 p-2">Masalah</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Hello</td><td class="border border-gray-200 p-2">Ini masalah</td><td class="border border-gray-200 p-2">Ini penjelasan</td><td class="border border-gray-200 p-2">Hi</td></tr></tbody></table>',
            'pronunciation_score' => $bandScore,
            'pronunciation' => '<p>Dummy Pronunciation summary.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Asli</th><th class="border border-gray-200 p-2">Masalah</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Hello</td><td class="border border-gray-200 p-2">Ini masalah</td><td class="border border-gray-200 p-2">Ini penjelasan</td><td class="border border-gray-200 p-2">Hi</td></tr></tbody></table>',
            'fluency_and_coherence_score' => $bandScore,
            'fluency_and_coherence' => '<p>Dummy Fluency summary.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Asli</th><th class="border border-gray-200 p-2">Masalah</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Hello</td><td class="border border-gray-200 p-2">Ini masalah</td><td class="border border-gray-200 p-2">Ini penjelasan</td><td class="border border-gray-200 p-2">Hi</td></tr></tbody></table>',
            'overall_comment' => 'This is an admin debug submission for preview evaluation.',
            'band_9_version' => '<p>Dummy band 9 version.</p>',
            'correction_html' => '<p>Dummy <del>correction</del> <ins>html</ins>.</p>',
            'recordings' => [
                [
                    'question' => 'Do you currently work or study?',
                    'audio_url' => ''
                ]
            ]
        ];

        $topic = [
            'title' => 'Speaking Practice (Admin Preview)',
            'slug' => 'speaking-practice-preview',
            'part' => $part,
        ];

        $result = $aiFeedback;
        // The evaluation blade expects transcripts
        $result['transcripts'] = [
            [
                'question' => 'Do you currently work or study?',
                'transcription' => 'This is a mock transcription for the preview.'
            ]
        ];

        return view('assignments.ielts.speaking.evaluation', compact('result', 'topic'));
    }
"""

if 'public function evaluationPreview' not in content:
    content = content.replace("public function evaluation(Request $request)\n    {", method_code + "\n    public function evaluation(Request $request)\n    {")
    with open(file_path, "w") as f:
        f.write(content)
    print("Added evaluationPreview to IeltsSpeakingController.php")
else:
    print("Method already exists")
