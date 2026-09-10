<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\GrammarQuestion;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $newQuestions = [
            [
                'meeting_number' => 10,
                'question_number' => 21,
                'question_text' => 'Bulan tampak sebesar matahari pada gerhana bulan penuh.',
                'correct_answer' => 'The moon appears as big as the sun during a total lunar eclipse.',
                'structure' => 'Positive',
                'example_id' => 'Dia setinggi ayahnya.',
                'example_en' => 'He is as tall as his father.',
                'vocab' => json_encode(['Appear' => ['id' => 'Tampak', 'pos' => '(v)'], 'Lunar eclipse' => ['id' => 'Gerhana bulan', 'pos' => '(n)'], 'Big' => ['id' => 'Besar', 'pos' => '(adj)']]),
            ],
            [
                'meeting_number' => 10,
                'question_number' => 22,
                'question_text' => 'Gigitan komodo seberbahaya racun mereka.',
                'correct_answer' => 'Komodo bites are as dangerous as their venom.',
                'structure' => 'Positive',
                'example_id' => 'Tugas ini sesulit tugas sebelumnya.',
                'example_en' => 'This task is as difficult as the previous one.',
                'vocab' => json_encode(['Bite' => ['id' => 'Gigitan', 'pos' => '(n)'], 'Dangerous' => ['id' => 'Berbahaya', 'pos' => '(adj)'], 'Venom' => ['id' => 'Racun', 'pos' => '(n)']]),
            ],
            [
                'meeting_number' => 10,
                'question_number' => 23,
                'question_text' => 'Paus sebesar dengan bus.',
                'correct_answer' => 'Whales are as big as buses.',
                'structure' => 'Positive',
                'example_id' => 'Rambutnya sehitam arang.',
                'example_en' => 'Her hair is as black as coal.',
                'vocab' => json_encode(['Whale' => ['id' => 'Paus', 'pos' => '(n)'], 'Bus' => ['id' => 'Bus', 'pos' => '(n)'], 'Big' => ['id' => 'Besar', 'pos' => '(adj)']]),
            ],
            [
                'meeting_number' => 10,
                'question_number' => 24,
                'question_text' => 'Keanekaragaman hayati di Australia tidak sekaya Amerika selatan.',
                'correct_answer' => 'Biodiversity in Australia is not as rich as South America.',
                'structure' => 'Positive',
                'example_id' => 'Rumahku tidak sebesar rumahmu.',
                'example_en' => 'My house is not as big as yours.',
                'vocab' => json_encode(['Biodiversity' => ['id' => 'Keanekaragaman hayati', 'pos' => '(n)'], 'Rich' => ['id' => 'Kaya', 'pos' => '(adj)']]),
            ],
            [
                'meeting_number' => 10,
                'question_number' => 25,
                'question_text' => 'Bakteri di badan kita sepenting nutrisi bagi diri kita.',
                'correct_answer' => 'Bacteria in our body are as important as nutrients for ourselves.',
                'structure' => 'Positive',
                'example_id' => 'Pendidikan sepenting kesehatan.',
                'example_en' => 'Education is as important as health.',
                'vocab' => json_encode(['Bacteria' => ['id' => 'Bakteri', 'pos' => '(n)'], 'Nutrient' => ['id' => 'Nutrisi', 'pos' => '(n)'], 'Important' => ['id' => 'Penting', 'pos' => '(adj)']]),
            ],
            [
                'meeting_number' => 10,
                'question_number' => 26,
                'question_text' => 'Burung-burung Trumpeter lebih suka dengan kanopi yang tebal untuk menyediakan perlindungan dan penutup di sarang mereka.',
                'correct_answer' => 'Trumpeter birds prefer thick canopy to provide protection and cover in their nests.',
                'structure' => 'Parallel Structures',
                'example_id' => 'Peneliti mengumpulkan sampel, menganalisis data, dan menyusun laporan.',
                'example_en' => 'Researchers collect samples, analyze data, and write reports.',
                'vocab' => json_encode(['Prefer' => ['id' => 'Lebih suka', 'pos' => '(v)'], 'Canopy' => ['id' => 'Kanopi/Tajuk', 'pos' => '(n)'], 'Protection' => ['id' => 'Perlindungan', 'pos' => '(n)'], 'Cover' => ['id' => 'Penutup', 'pos' => '(n)']]),
            ],
            [
                'meeting_number' => 10,
                'question_number' => 27,
                'question_text' => 'Perencanaan dari proyek baru termasuk dari pendesainan, perhitungan biaya, dan pembangunan.',
                'correct_answer' => 'Planning of the new project includes designing, costing, and construction.',
                'structure' => 'Parallel Structures',
                'example_id' => 'Kegiatan meliputi membaca, menulis, dan berdiskusi.',
                'example_en' => 'Activities include reading, writing, and discussing.',
                'vocab' => json_encode(['Planning' => ['id' => 'Perencanaan', 'pos' => '(n)'], 'Include' => ['id' => 'Termasuk', 'pos' => '(v)'], 'Costing' => ['id' => 'Perhitungan biaya', 'pos' => '(n)'], 'Construction' => ['id' => 'Pembangunan', 'pos' => '(n)']]),
            ],
            [
                'meeting_number' => 10,
                'question_number' => 28,
                'question_text' => 'Hutan harus dilindungi, diamankan, dan dilestarikan untuk generasi mendatang.',
                'correct_answer' => 'Forests must be protected, secured, and preserved for future generations.',
                'structure' => 'Parallel Structures',
                'example_id' => 'Gedung ini dirancang, dibangun, dan dirawat dengan baik.',
                'example_en' => 'This building was designed, built, and maintained properly.',
                'vocab' => json_encode(['Protect' => ['id' => 'Melindungi', 'pos' => '(v)'], 'Secure' => ['id' => 'Mengamankan', 'pos' => '(v)'], 'Preserve' => ['id' => 'Melestarikan', 'pos' => '(v)'], 'Future generations' => ['id' => 'Generasi mendatang', 'pos' => '(phrase)']]),
            ],
            [
                'meeting_number' => 10,
                'question_number' => 29,
                'question_text' => 'Kepolisian bertugas menjaga negara dan tentara bertugas mempertahankan negara.',
                'correct_answer' => 'Police are tasked with guarding the country and the military is tasked with defending the country.',
                'structure' => 'Parallel Structures',
                'example_id' => 'Dokter merawat pasien dan perawat membantu pemulihan.',
                'example_en' => 'Doctors treat patients and nurses assist recovery.',
                'vocab' => json_encode(['Police' => ['id' => 'Kepolisian', 'pos' => '(n)'], 'Guard' => ['id' => 'Menjaga', 'pos' => '(v)'], 'Defend' => ['id' => 'Mempertahankan', 'pos' => '(v)'], 'Military' => ['id' => 'Tentara', 'pos' => '(n)']]),
            ],
            [
                'meeting_number' => 10,
                'question_number' => 30,
                'question_text' => 'Laporan ini tidak hanya memuat data kuantitatif tetapi juga menyajikan analisis kualitatif.',
                'correct_answer' => 'This report not only contains quantitative data but also presents qualitative analysis.',
                'structure' => 'Parallel Structures',
                'example_id' => 'Proyek ini tidak hanya membutuhkan dana tetapi juga waktu.',
                'example_en' => 'The project requires not only funding but also time.',
                'vocab' => json_encode(['Report' => ['id' => 'Laporan', 'pos' => '(n)'], 'Contain' => ['id' => 'Memuat', 'pos' => '(v)'], 'Quantitative' => ['id' => 'Kuantitatif', 'pos' => '(adj)'], 'Qualitative' => ['id' => 'Kualitatif', 'pos' => '(adj)']]),
            ],
        ];

        foreach ($newQuestions as $q) {
            GrammarQuestion::updateOrCreate(
                [
                    'meeting_number' => $q['meeting_number'],
                    'question_number' => $q['question_number'],
                ],
                $q
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        GrammarQuestion::where('meeting_number', 10)->whereBetween('question_number', [21, 30])->delete();
    }
};
