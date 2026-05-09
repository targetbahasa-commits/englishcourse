<?php

namespace App\Application\Guest;

use App\Domain\FreeTest\Repositories\FreeTestRepository;

/**
 * Builds all data required for the "My English" page.
 *
 * This use case encapsulates the CEFR scoring logic that was previously
 * embedded directly in GuestController::myEnglish().
 */
class BuildGuestMyEnglishData
{
    public function __construct(
        private readonly FreeTestRepository $freeTestRepository,
    ) {}

    public function handle(?int $userId): array
    {
        $latestTest = null;
        $history    = collect();
        $hasData    = false;

        if ($userId !== null) {
            $latestTest = $this->freeTestRepository->getLatestResultForUser($userId);
            $history    = $this->freeTestRepository->getHistoryForUser($userId);
            $hasData    = (bool) $latestTest;
        }

        // Defaults
        $cefrLevel          = 'Belum Ada Data';
        $cefrDescription    = 'Ambil Free Test untuk mengetahui level bahasa Inggris Anda.';
        $estimatedIelts     = '-';
        $estimatedToefl     = '-';
        $nextSteps          = [];
        $recommendedProgram = 'IELTS Preparation';
        $radarData          = [0, 0, 0, 0, 0]; // Grammar, Listening, Vocabulary, Reading, Writing

        if ($hasData) {
            ['cefrLevel' => $cefrLevel, 'percentageScore' => $percentageScore] =
                $this->resolveCefrLevel($latestTest->score, $latestTest->test_type);

            [
                'description'        => $cefrDescription,
                'estimatedIelts'     => $estimatedIelts,
                'estimatedToefl'     => $estimatedToefl,
                'nextSteps'          => $nextSteps,
                'recommendedProgram' => $recommendedProgram,
                'radarData'          => $radarData,
            ] = $this->resolveCefrDetails($cefrLevel, $percentageScore);
        }

        return compact(
            'hasData', 'latestTest', 'history',
            'cefrLevel', 'cefrDescription',
            'estimatedIelts', 'estimatedToefl',
            'nextSteps', 'recommendedProgram', 'radarData',
        );
    }

    // ------------------------------------------------------------------ //
    //  Private helpers                                                     //
    // ------------------------------------------------------------------ //

    private function resolveCefrLevel(float $score, string $testType): array
    {
        $percentageScore = 0.0;
        $cefrLevel       = 'A1';

        if (str_starts_with($testType, 'ielts_')) {
            $percentageScore = ($score / 9) * 100;

            if ($score >= 8.0)      { $cefrLevel = 'C2'; }
            elseif ($score >= 7.0)  { $cefrLevel = 'C1'; }
            elseif ($score >= 5.5)  { $cefrLevel = 'B2'; }
            elseif ($score >= 4.0)  { $cefrLevel = 'B1'; }
            elseif ($score >= 3.0)  { $cefrLevel = 'A2'; }
        } elseif ($testType === 'toefl_itp') {
            $percentageScore = (($score - 310) / (677 - 310)) * 100;

            if ($score >= 627)      { $cefrLevel = 'C1'; }
            elseif ($score >= 543)  { $cefrLevel = 'B2'; }
            elseif ($score >= 460)  { $cefrLevel = 'B1'; }
            elseif ($score >= 337)  { $cefrLevel = 'A2'; }
        } else {
            $percentageScore = $score;

            if ($score >= 90)       { $cefrLevel = 'C2'; }
            elseif ($score >= 80)   { $cefrLevel = 'C1'; }
            elseif ($score >= 65)   { $cefrLevel = 'B2'; }
            elseif ($score >= 50)   { $cefrLevel = 'B1'; }
            elseif ($score >= 35)   { $cefrLevel = 'A2'; }
        }

        return ['cefrLevel' => $cefrLevel, 'percentageScore' => $percentageScore];
    }

    private function resolveCefrDetails(string $cefrLevel, float $p): array
    {
        return match ($cefrLevel) {
            'C2' => [
                'description'        => 'Pengguna Bahasa Tingkat Mahir. Anda dapat memahami hampir semua hal dengan mudah.',
                'estimatedIelts'     => '8.0 - 9.0',
                'estimatedToefl'     => '677+ (ITP) / 114+ (iBT)',
                'nextSteps'          => ['Berlatih aksen spesifik yang jarang didengar', 'Menulis karya ilmiah akademis tinggi', 'Mulai mendaftar beasiswa top tier'],
                'recommendedProgram' => 'Advanced Mentoring & Scholarship Prep',
                'radarData'          => [min(100, $p + 5), min(100, $p + 2), min(100, $p + 8), min(100, $p + 3), $p],
            ],
            'C1' => [
                'description'        => 'Pengguna Bahasa Tingkat Mandiri (Advanced). Anda dapat mengekspresikan ide dengan lancar.',
                'estimatedIelts'     => '7.0 - 7.5',
                'estimatedToefl'     => '627 - 676 (ITP) / 95 - 113 (iBT)',
                'nextSteps'          => ['Perbanyak baca artikel ilmiah/berita internasional', 'Latih perbendaharaan kata idiom kompleks', 'Simulasi tes rutin tiap 2 minggu'],
                'recommendedProgram' => 'IELTS Masterclass (Band 7.0+)',
                'radarData'          => [$p, min(100, $p + 5), $p - 5, min(100, $p + 8), $p - 2],
            ],
            'B2' => [
                'description'        => 'Pengguna Bahasa Menengah Atas. Anda dapat memahami gagasan utama dari teks kompleks.',
                'estimatedIelts'     => '5.5 - 6.5',
                'estimatedToefl'     => '543 - 626 (ITP) / 72 - 94 (iBT)',
                'nextSteps'          => ['Fokus perbaikan struktur grammar kompleks', 'Latih berbicara topik abstrak', 'Banyak membaca essai opini'],
                'recommendedProgram' => 'Target IELTS 6.5 / TOEFL Booster',
                'radarData'          => [max(10, $p - 5), $p, max(10, $p - 10), $p + 5, max(10, $p - 8)],
            ],
            'B1' => [
                'description'        => 'Pengguna Bahasa Menengah Bawah. Anda mengerti poin utama dalam bahasa baku yang jelas.',
                'estimatedIelts'     => '4.0 - 5.0',
                'estimatedToefl'     => '460 - 542 (ITP) / 42 - 71 (iBT)',
                'nextSteps'          => ['Perkuat fondasi grammar dasar (tenses)', 'Tambah kosakata topik sehari-hari', 'Mulai biasakan mendengar podcast Inggris pelan'],
                'recommendedProgram' => 'General English / Pre-IELTS',
                'radarData'          => [max(10, $p - 10), max(10, $p - 5), $p, max(10, $p - 15), max(10, $p - 20)],
            ],
            'A2' => [
                'description'        => 'Pengguna Bahasa Tingkat Dasar. Mampu berkomunikasi dalam rutinitas sederhana.',
                'estimatedIelts'     => '3.0 - 3.5',
                'estimatedToefl'     => '< 337 (ITP) / < 41 (iBT)',
                'nextSteps'          => ['Banyak menghafal Vocabulary dasar', 'Belajar merangkai kalimat simple', 'Latihan listening percakapan lambat'],
                'recommendedProgram' => 'English Foundation Level 2',
                'radarData'          => [$p, max(0, $p - 20), max(0, $p - 10), max(0, $p - 15), max(0, $p - 25)],
            ],
            default => [ // A1
                'description'        => 'Pemula Mutlak. Dapat memahami ucapan/kalimat yang sangat familiar dan mendasar.',
                'estimatedIelts'     => '0 - 2.5',
                'estimatedToefl'     => '< 337 (ITP)',
                'nextSteps'          => ['Mulai dari pengenalan Alphabet & Angka', 'Kumpulkan kosakata benda sekitar', 'Belajar struktur kalimat Suka/Tidak Suka'],
                'recommendedProgram' => 'English Foundation Level 1',
                'radarData'          => [10, 15, 20, 10, 5],
            ],
        };
    }
}
