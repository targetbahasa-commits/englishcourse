import re

file_path = "app/Http/Controllers/IeltsWritingController.php"
with open(file_path, "r") as f:
    content = f.read()

method_code = """
    public function evaluationPreview($task, $id)
    {
        $bandScore = 7.5;
        $aiFeedback = [
            'overall_band_score' => $bandScore,
            'task_achievement_score' => $bandScore,
            'task_response_score' => $bandScore,
            'task_achievement' => '<p>Dummy Task Achievement summary.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Asli</th><th class="border border-gray-200 p-2">Masalah</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Hello</td><td class="border border-gray-200 p-2">Ini masalah</td><td class="border border-gray-200 p-2">Ini penjelasan</td><td class="border border-gray-200 p-2">Hi</td></tr></tbody></table>',
            'task_response' => '<p>Dummy Task Response summary.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Asli</th><th class="border border-gray-200 p-2">Masalah</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Hello</td><td class="border border-gray-200 p-2">Ini masalah</td><td class="border border-gray-200 p-2">Ini penjelasan</td><td class="border border-gray-200 p-2">Hi</td></tr></tbody></table>',
            'coherence_cohesion_score' => $bandScore,
            'coherence_cohesion' => '<p>Dummy Coherence summary.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Asli</th><th class="border border-gray-200 p-2">Masalah</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Hello</td><td class="border border-gray-200 p-2">Ini masalah</td><td class="border border-gray-200 p-2">Ini penjelasan</td><td class="border border-gray-200 p-2">Hi</td></tr></tbody></table>',
            'lexical_resource_score' => $bandScore,
            'lexical_resource' => '<p>Dummy Lexical summary.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Asli</th><th class="border border-gray-200 p-2">Masalah</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Hello</td><td class="border border-gray-200 p-2">Ini masalah</td><td class="border border-gray-200 p-2">Ini penjelasan</td><td class="border border-gray-200 p-2">Hi</td></tr></tbody></table><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kosa Kata Asli</th><th class="border border-gray-200 p-2">Kosa Kata yang Lebih Baik</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Good</td><td class="border border-gray-200 p-2">Excellent</td></tr></tbody></table>',
            'grammatical_range_score' => $bandScore,
            'grammatical_range' => '<p>Dummy Grammar summary.</p><table class="w-full text-left border-collapse border border-gray-200 mt-4 mb-4"><thead class="bg-gray-50"><tr><th class="border border-gray-200 p-2">Kutipan Asli</th><th class="border border-gray-200 p-2">Masalah</th><th class="border border-gray-200 p-2">Penjelasan</th><th class="border border-gray-200 p-2">Perbaikan</th></tr></thead><tbody><tr><td class="border border-gray-200 p-2">Hello</td><td class="border border-gray-200 p-2">Ini masalah</td><td class="border border-gray-200 p-2">Ini penjelasan</td><td class="border border-gray-200 p-2">Hi</td></tr></tbody></table>',
            'overall_comment' => 'This is a mock admin preview evaluation.',
            'band_9_version' => '<p>Dummy band 9 version.</p>',
            'correction_html' => '<p>Dummy <del>correction</del> <ins>html</ins>.</p>',
        ];
        
        $type = $task == 1 ? 'writing_t1' : 'writing_t2';

        $submission = (object) [
            'id' => 'mock',
            'name' => 'Admin Preview',
            'email' => 'admin@example.com',
            'whatsapp' => '08123456789',
            'test_type' => $type,
            'test_id' => $id,
            'ai_raw_json_feedback' => json_encode($aiFeedback),
            'created_at' => now(),
        ];
        
        $prompt = "Mock prompt from admin preview.";

        return view('assignments.ielts.writing.evaluation_preview', compact('type', 'id', 'submission', 'aiFeedback', 'prompt'));
    }
"""

if "evaluationPreview" not in content:
    content = content.replace("public function practiceIndex", method_code + "\n    public function practiceIndex")

with open(file_path, "w") as f:
    f.write(content)

print("Method added.")
