<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        // Re-using the free lessons array structure
        $freeLessons = [
            [
                'id' => 'a1',
                'title' => 'Vocabulary A1',
                'description' => 'Essential vocabulary for absolute beginners. 20 topics covering everyday situations.',
                'color' => 'blue',
                'route' => route('vocabulary-a1')
            ],
            [
                'id' => 'a2',
                'title' => 'Vocabulary A2',
                'description' => 'Elementary vocabulary to expand your daily communication skills.',
                'color' => 'green',
                'route' => route('vocabulary-a2')
            ],
            [
                'id' => 'b1',
                'title' => 'Vocabulary B1',
                'description' => 'Intermediate vocabulary for more complex conversations.',
                'color' => 'purple',
                'route' => route('vocabulary-b1')
            ],
            [
                'id' => 'b2',
                'title' => 'Vocabulary B2',
                'description' => 'Upper-intermediate vocabulary for professional fluency.',
                'color' => 'orange',
                'route' => route('vocabulary-b2')
            ],
            [
                'id' => 'c1',
                'title' => 'Vocabulary C1',
                'description' => 'Advanced vocabulary for near-native proficiency.',
                'color' => 'red',
                'route' => route('vocabulary-c1')
            ],
            [
                'id' => 'verbs',
                'title' => 'Verbs (A1-C1)',
                'description' => 'Master English verbs across 5 proficiency levels.',
                'color' => 'teal',
                'route' => route('vocabulary-verb')
            ],
            [
                'id' => 'adjectives',
                'title' => 'Adjectives (A1-C1)',
                'description' => 'Descriptive words to enhance your expression.',
                'color' => 'yellow',
                'route' => route('vocabulary-adjective')
            ],
            [
                'id' => 'adverbs',
                'title' => 'Adverbs (A1-C1)',
                'description' => 'Add nuance to your verbs and adjectives.',
                'color' => 'indigo',
                'route' => route('vocabulary-adverb')
            ],
            [
                'id' => 'expressions',
                'title' => 'English Expressions',
                'description' => 'Common expressions for natural conversation.',
                'color' => 'cyan',
                'route' => route('english-expression')
            ],
             [
                'id' => 'idioms',
                'title' => 'English Idioms',
                'description' => 'Learn idioms to sound like a native speaker.',
                'color' => 'pink',
                'route' => route('idioms')
            ],
             [
                'id' => 'phrasal-verbs',
                'title' => 'Phrasal Verbs',
                'description' => 'Essential phrasal verbs for fluency.',
                'color' => 'orange',
                'route' => route('phrasal-verbs')
            ],
             [
                'id' => 'irregular-verbs',
                'title' => 'Irregular Verbs',
                'description' => 'Complete list of irregular verbs.',
                'color' => 'purple',
                'route' => route('irregular-verbs')
            ]
        ];

        $scholarships = \App\Models\Scholarship::where('status', 'open')
            ->orderBy('deadline', 'asc')
            ->take(3)
            ->get();

        $pageTitle = 'Guest Free Tests & Lessons';
        $pageDescription = 'Welcome back!';

        return view('guest.index', compact('freeLessons', 'scholarships', 'pageTitle', 'pageDescription'));
    }

    public function myEnglish()
    {
        $user = auth()->user();
        
        // Ensure only guests access this (optional extra layer of protection)
        if ($user->role !== 'guest') {
            return redirect()->route('dashboard');
        }

        // Fetch user's test history
        $latestTest = \App\Models\FreeTestResult::where('user_id', $user->id)
                                                  ->orderByDesc('created_at')
                                                  ->first();

        $history = \App\Models\FreeTestResult::where('user_id', $user->id)
                                               ->orderByDesc('created_at')
                                               ->get();

        $hasData = $latestTest ? true : false;
        
        // Defaults
        $cefrLevel = 'Belum Ada Data';
        $cefrDescription = 'Ambil Free Test untuk mengetahui level bahasa Inggris Anda.';
        $estimatedIelts = '-';
        $estimatedToefl = '-';
        $nextSteps = [];
        $recommendedProgram = 'IELTS Preparation';
        $radarData = [0, 0, 0, 0, 0]; // Grammar, Listening, Vocabulary, Reading, Writing

        if ($hasData) {
            $score = $latestTest->score;
            $testType = $latestTest->test_type;

            // Simplified CEFR mapping based on a generic percentage score (assuming free tests are out of 100 max or normalized)
            // Adjust this logic if FreeTestResult score has a different scale (e.g., IELTS out of 9, TOEFL out of 677)
            $percentageScore = 0;
            
            if (str_starts_with($testType, 'ielts_')) { // Scale 0-9
                $percentageScore = ($score / 9) * 100;
                
                if ($score >= 8.0) { $cefrLevel = 'C2'; }
                elseif ($score >= 7.0) { $cefrLevel = 'C1'; }
                elseif ($score >= 5.5) { $cefrLevel = 'B2'; }
                elseif ($score >= 4.0) { $cefrLevel = 'B1'; }
                elseif ($score >= 3.0) { $cefrLevel = 'A2'; }
                else { $cefrLevel = 'A1'; }
                
            } elseif ($testType === 'toefl_itp') { // Scale 310-677
                $percentageScore = (($score - 310) / (677 - 310)) * 100;
                
                if ($score >= 627) { $cefrLevel = 'C1'; } // Often mapped to C1
                elseif ($score >= 543) { $cefrLevel = 'B2'; }
                elseif ($score >= 460) { $cefrLevel = 'B1'; }
                elseif ($score >= 337) { $cefrLevel = 'A2'; }
                else { $cefrLevel = 'A1'; }
                
            } else { // fallback, assume percentage 0-100
                 $percentageScore = $score;
                 if ($score >= 90) { $cefrLevel = 'C2'; }
                 elseif ($score >= 80) { $cefrLevel = 'C1'; }
                 elseif ($score >= 65) { $cefrLevel = 'B2'; }
                 elseif ($score >= 50) { $cefrLevel = 'B1'; }
                 elseif ($score >= 35) { $cefrLevel = 'A2'; }
                 else { $cefrLevel = 'A1'; }
            }

            // Estimate equivalents based on CEFR
            switch ($cefrLevel) {
                case 'C2':
                    $cefrDescription = 'Pengguna Bahasa Tingkat Mahir. Anda dapat memahami hampir semua hal dengan mudah.';
                    $estimatedIelts = '8.0 - 9.0';
                    $estimatedToefl = '677+ (ITP) / 114+ (iBT)';
                    $radarData = [min(100, $percentageScore + 5), min(100, $percentageScore + 2), min(100, $percentageScore + 8), min(100, $percentageScore + 3), $percentageScore];
                    $nextSteps = ['Berlatih aksen spesifik yang jarang didengar', 'Menulis karya ilmiah akademis tinggi', 'Mulai mendaftar beasiswa top tier'];
                    $recommendedProgram = 'Advanced Mentoring & Scholarship Prep';
                    break;
                case 'C1':
                    $cefrDescription = 'Pengguna Bahasa Tingkat Mandiri (Advanced). Anda dapat mengekspresikan ide dengan lancar.';
                    $estimatedIelts = '7.0 - 7.5';
                    $estimatedToefl = '627 - 676 (ITP) / 95 - 113 (iBT)';
                    $radarData = [$percentageScore, min(100, $percentageScore + 5), $percentageScore - 5, min(100, $percentageScore + 8), $percentageScore - 2];
                    $nextSteps = ['Perbanyak baca artikel ilmiah/berita internasional', 'Latih perbendaharaan kata idiom kompleks', 'Simulasi tes rutin tiap 2 minggu'];
                    $recommendedProgram = 'IELTS Masterclass (Band 7.0+)';
                    break;
                case 'B2':
                    $cefrDescription = 'Pengguna Bahasa Menengah Atas. Anda dapat memahami gagasan utama dari teks kompleks.';
                    $estimatedIelts = '5.5 - 6.5';
                    $estimatedToefl = '543 - 626 (ITP) / 72 - 94 (iBT)';
                    $radarData = [max(10, $percentageScore - 5), $percentageScore, max(10, $percentageScore - 10), $percentageScore + 5, max(10, $percentageScore - 8)];
                    $nextSteps = ['Fokus perbaikan struktur grammar kompleks', 'Latih berbicara topik abstrak', 'Banyak membaca essai opini'];
                    $recommendedProgram = 'Target IELTS 6.5 / TOEFL Booster';
                    break;
                case 'B1':
                    $cefrDescription = 'Pengguna Bahasa Menengah Bawah. Anda mengerti poin utama dalam bahasa baku yang jelas.';
                    $estimatedIelts = '4.0 - 5.0';
                    $estimatedToefl = '460 - 542 (ITP) / 42 - 71 (iBT)';
                    $radarData = [max(10, $percentageScore - 10), max(10, $percentageScore - 5), $percentageScore, max(10, $percentageScore - 15), max(10, $percentageScore - 20)];
                    $nextSteps = ['Perkuat fondasi grammar dasar (tenses)', 'Tambah kosakata topik sehari-hari', 'Mulai biasakan mendengar podcast Inggris pelan'];
                    $recommendedProgram = 'General English / Pre-IELTS';
                    break;
                case 'A2':
                    $cefrDescription = 'Pengguna Bahasa Tingkat Dasar. Mampu berkomunikasi dalam rutinitas sederhana.';
                    $estimatedIelts = '3.0 - 3.5';
                    $estimatedToefl = '< 337 (ITP) / < 41 (iBT)';
                    $radarData = [$percentageScore, max(0, $percentageScore - 20), max(0, $percentageScore - 10), max(0, $percentageScore - 15), max(0, $percentageScore - 25)];
                    $nextSteps = ['Banyak menghafal Vocabulary dasar', 'Belajar merangkai kalimat simple', 'Latihan listening percakapan lambat'];
                    $recommendedProgram = 'English Foundation Level 2';
                    break;
                default: // A1
                    $cefrDescription = 'Pemula Mutlak. Dapat memahami ucapan/kalimat yang sangat familiar dan mendasar.';
                    $estimatedIelts = '0 - 2.5';
                    $estimatedToefl = '< 337 (ITP)';
                    $radarData = [10, 15, 20, 10, 5]; // Default low
                    $nextSteps = ['Mulai dari pengenalan Alphabet & Angka', 'Kumpulkan kosakata benda sekitar', 'Belajar struktur kalimat Suka/Tidak Suka'];
                    $recommendedProgram = 'English Foundation Level 1';
                    break;
            }
        }

        return view('guest.my-english', compact(
            'hasData', 'latestTest', 'history', 'cefrLevel', 'cefrDescription', 
            'estimatedIelts', 'estimatedToefl', 'nextSteps', 'recommendedProgram', 'radarData'
        ));
    }
}
