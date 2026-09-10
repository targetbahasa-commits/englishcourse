<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssignmentDraft;
use App\Models\MeetingScore;
use App\Models\Program;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AdminGrammarWritingReviewController extends Controller
{
    /**
     * All Grammar Writing sub-systems that persist submissions into meeting_scores,
     * keyed by the URL-friendly track slug used in the ?track= filter. program_id
     * (resolved from Program.slug) disambiguates rows between tracks since
     * meeting_number ranges overlap (e.g. meeting 5 exists in both fast-track and
     * introductory).
     */
    public const TRACKS = [
        'fast-track' => ['slug' => 'fast-track-grammar-for-writing', 'label' => 'Fast-Track'],
        'introductory' => ['slug' => 'introductory-grammar-for-writing', 'label' => 'Introductory'],
        'complexity' => ['slug' => 'complexity-grammar-for-writing', 'label' => 'Complexity'],
        'proficiency' => ['slug' => 'proficiency-grammar-for-writing', 'label' => 'Proficiency'],
    ];

    public function __construct()
    {
        $this->middleware('role:teacher');
    }

    private function trackProgramIds(?string $track): array
    {
        $slugs = isset(self::TRACKS[$track])
            ? [self::TRACKS[$track]['slug']]
            : array_column(self::TRACKS, 'slug');

        return Program::whereIn('slug', $slugs)->pluck('id', 'slug')->values()->toArray();
    }

    public function index(Request $request)
    {
        $track = $request->query('track', 'all');
        $programIds = $this->trackProgramIds($track);

        $query = MeetingScore::with('user', 'program')
            ->whereIn('program_id', $programIds);

        $showPractice = $request->boolean('show_practice');
        if (!$showPractice) {
            $query->where('is_reported', true);
        }

        $status = $request->query('status', 'all');
        if ($status === 'pending_review') {
            $query->whereNull('reviewed_at');
        } elseif ($status === 'reviewed') {
            $query->whereNotNull('reviewed_at');
        }

        if ($request->filled('meeting_number')) {
            $query->where('meeting_number', (int) $request->query('meeting_number'));
        }

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->whereHas('user', function ($u) use ($search) {
                $u->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $scores = $query->latest('submitted_at')->paginate(20)->withQueryString();

        $stats = [
            'total' => MeetingScore::whereIn('program_id', $programIds)->where('is_reported', true)->count(),
            'pending' => MeetingScore::whereIn('program_id', $programIds)->where('is_reported', true)->whereNull('reviewed_at')->count(),
            'reviewed' => MeetingScore::whereIn('program_id', $programIds)->where('is_reported', true)->whereNotNull('reviewed_at')->count(),
        ];

        $inProgressQuery = AssignmentDraft::whereIn('program_id', $programIds)
            ->whereNotExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('meeting_scores')
                    ->whereColumn('meeting_scores.user_id', 'assignment_drafts.user_id')
                    ->whereColumn('meeting_scores.meeting_number', 'assignment_drafts.meeting_number')
                    ->whereColumn('meeting_scores.program_id', 'assignment_drafts.program_id')
                    ->where('meeting_scores.is_reported', true);
            });

        $inProgressSubmissions = $inProgressQuery->with('user', 'program')
            ->orderByDesc('last_saved_at')
            ->limit(100)
            ->get()
            ->filter(function ($draft) {
                $answers = is_array($draft->answers) ? $draft->answers : json_decode($draft->answers, true);
                if (empty($answers)) return false;
                
                return collect($answers)->flatten()->contains(function ($v) {
                    return $v !== null && trim((string) $v) !== '';
                });
            });

        $stats['inProgress'] = $inProgressSubmissions->count();

        $trackLabelsBySlug = collect(self::TRACKS)->pluck('label', 'slug')->toArray();

        return view('admin.grammar-writing-review.index', compact('scores', 'status', 'track', 'stats', 'showPractice', 'inProgressSubmissions', 'trackLabelsBySlug'));
    }

    public function show(MeetingScore $meetingScore)
    {
        $meetingScore->load(['user', 'reviewer', 'program']);

        $trackLabel = collect(self::TRACKS)->firstWhere('slug', $meetingScore->program->slug ?? null)['label'] ?? ($meetingScore->program->name ?? 'Grammar Writing');

        return view('admin.grammar-writing-review.show', compact('meetingScore', 'trackLabel'));
    }

    /**
     * Toggle AI-assisted grading on/off per individual meeting (Setting key
     * "grammar_writing_ai_{track}_meeting_{meeting}_enabled"). Read by
     * GrammarWritingAdminController::isGrammarWritingAiEnabled() at submit time.
     */
    public function toggleAi(Request $request)
    {
        $track = $request->input('track');
        if (!isset(self::TRACKS[$track])) {
            return response()->json(['status' => 'error', 'message' => 'Track tidak dikenali.'], 422);
        }

        $meeting = (int) $request->input('meeting');
        if ($meeting < 1) {
            return response()->json(['status' => 'error', 'message' => 'Meeting tidak valid.'], 422);
        }

        $enabled = $request->input('enabled') ? '1' : '0';
        \App\Models\Setting::updateOrCreate(
            ['key' => "grammar_writing_ai_{$track}_meeting_{$meeting}_enabled"],
            ['value' => $enabled]
        );

        return response()->json([
            'status' => 'success',
            'track' => $track,
            'meeting' => $meeting,
            'ai_enabled' => $enabled === '1',
            'message' => $enabled === '1'
                ? 'Penilaian AI untuk meeting ini diaktifkan kembali.'
                : 'Penilaian AI untuk meeting ini dinonaktifkan. Submission baru akan menunggu penilaian manual guru.',
        ]);
    }

    public function saveReview(Request $request, MeetingScore $meetingScore)
    {
        $validated = $request->validate([
            'teacher_score' => 'nullable|numeric|min:0|max:100',
            'teacher_feedback' => 'nullable|string|max:5000',
        ]);

        $meetingScore->update([
            'teacher_score' => $validated['teacher_score'] ?? null,
            'teacher_feedback' => $validated['teacher_feedback'] ?? null,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        Cache::forget("review_draft_{$meetingScore->id}");
        Cache::forget("review_draft_time_{$meetingScore->id}");

        return back()->with('success', 'Nilai dan catatan guru berhasil disimpan!');
    }

    /**
     * Resolve question texts (soal bahasa Indonesia) for a meeting.
     * Maps question number (as string key) to question text, including paragraph_answer.
     */
    public static function resolveQuestionsForMeeting(?string $trackSlug, int $meetingNumber): array
    {
        $questions = [];

        // Fast-track / default grammar writing
        if (in_array($trackSlug, ['fast-track-grammar-for-writing', 'fast-track', ''], true) || $trackSlug === null) {
            // Fast-Track's URL-facing meeting numbers 6-10 are served by
            // controller methods (and therefore GrammarQuestion rows) under
            // different internal meeting numbers - e.g. /fast-track/meeting8
            // routes to GrammarWritingAdvancedSessionController::meeting14()
            // (see routes/web.php). AssignmentDraft/MeetingScore store the
            // URL-visible number, so it has to be translated here before the
            // DB lookup below, or this returns another track's unrelated
            // meeting-8 questions instead (mismatched soal/jawaban in review UI).
            $fastTrackDisplayToInternalMeeting = [6 => 10, 7 => 12, 8 => 14, 9 => 15, 10 => 17];
            $meetingNumber = $fastTrackDisplayToInternalMeeting[$meetingNumber] ?? $meetingNumber;

            if ($meetingNumber === 2) {
                // Meeting 2 in Fast-Track is Latihan Penerapan Tenses (15 Practice sentences)
                $practiceQuestions = [
                    1 => 'Seluruh parameter penelitian telah diselesaikan melalui proses verifikasi yang ketat.',
                    2 => 'Para kartografer sedang melakukan pemetaan komprehensif terhadap wilayah pesisir.',
                    3 => 'Karakteristik geomorfologi di wilayah pegunungan ini sangat unik.',
                    4 => 'Peradaban kuno tersebut membangun sistem irigasi yang kompleks di wilayah gersang.',
                    5 => 'Setiap elemen dalam ekosistem ini harus tetap seimbang.',
                    6 => 'Strategi mitigasi bencana sedang ditinjau kembali oleh otoritas terkait.',
                    7 => 'Ilmuwan asal Polandia tersebut telah menjadi figur sentral dalam teori fisika kuantum.',
                    8 => 'Mekanisme fotosintesis mempermudah konversi energi surya menjadi energi kimia.',
                    9 => 'Struktur birokrasi pada masa kekaisaran tersebut tidak kaku.',
                    10 => 'Naskah kuno tersebut dikirimkan ke museum pusat untuk proses preservasi digital.',
                    11 => 'Analisis spektrum cahaya dapat memberikan informasi krusial mengenai komposisi bintang.',
                    12 => 'Para arsitek telah membangun fondasi tahan guncangan pada gedung tersebut.',
                    13 => 'Kondisi atmosfer di planet tersebut sedang berada dalam tahap transisi ekstrem.',
                    14 => 'Kebijakan dekarbonisasi ekonomi wajib diimplementasikan secara global.',
                    15 => 'Tim arkeolog menemukan sisa-sisa permukiman neolitikum selama ekskavasi kemarin.',
                ];
                foreach ($practiceQuestions as $idx => $q) {
                    $questions[(string) $idx] = $q;
                }
                $questions['paragraph_answer'] = 'Para ilmuwan di seluruh dunia terus mempelajari dinamika perubahan iklim global. Selama beberapa dekade terakhir, suhu rata-rata bumi telah meningkat secara signifikan akibat emisi gas rumah kaca. Saat ini, tim peneliti sedang menganalisis data satelit untuk memantau pencairan lapisan es di kutub. Pada tahun lalu, stasiun meteorologi mencatat rekor suhu tertinggi di berbagai belahan dunia. Jika tren pemanasan ini tidak segera dihentikan, keanekaragaman hayati laut akan mengalami kepunahan massal dalam beberapa dekade mendatang. Oleh karena itu, kebijakan transisi energi terbarukan harus diterapkan secara komprehensif oleh seluruh negara.';
                $questions['userParagraphAnswer'] = $questions['paragraph_answer'];

                return $questions;
            } elseif ($meetingNumber === 1) {
                // Meeting 1 in Fast-Track is Matrix Tenses (Bumi mengelilingi matahari, etc.)
                try {
                    $matrixQuestions = \App\Models\GrammarQuestion::where('meeting_number', 2)
                        ->where('section', 'matrix')
                        ->get();
                    if ($matrixQuestions->isNotEmpty()) {
                        foreach ($matrixQuestions as $q) {
                            if ($q->question_number) {
                                $questions[(string) $q->question_number] = $q->question_text;
                            }
                        }
                    }
                } catch (\Throwable $e) {}

                if (empty($questions)) {
                    $meeting1Fallback = [
                        1 => 'Bumi mengelilingi matahari.',
                        2 => 'Perkembangan teknologi ini penting.',
                        3 => 'Komputer dikendalikan oleh chip.',
                        4 => 'Kita sedang menghadapi global warming.',
                        5 => 'Pemerintah sedang berhati-hati.',
                    ];
                    foreach ($meeting1Fallback as $idx => $q) {
                        $questions[(string) $idx] = $q;
                    }
                }

                $questions['paragraph_answer'] = 'Ibuku seorang koki. Dia memasak makanan untuk berbagai acara, seperti pesta ulang tahun dan pernikahan. Masakannya sangat enak, sehingga banyak orang menyukainya. Dia bekerja dengan penuh semangat dan selalu menjaga kualitas makanannya. Setiap hari, banyak pelanggan memesan makanan darinya.';
                $questions['userParagraphAnswer'] = $questions['paragraph_answer'];

                return $questions;
            } elseif ($meetingNumber === 3) {
                $meeting3Fallback = [
                    1 => 'Artefak kuno dapat dilestarikan oleh metode konservasi modern.',
                    2 => 'Perubahan iklim mungkin mempercepat pemutihan terumbu karang.',
                    3 => 'Organisasi internasional mungkin adalah penggerak utama aksi iklim dunia.',
                    4 => 'Negara-negara sebaiknya melindungi spesies yang terancam punah.',
                    5 => 'Hutan tropis harus dilindungi dari deforestasi besar-besaran.',
                    6 => 'Teknologi baru dapat menghasilkan solusi energi lebih efisien.',
                    7 => 'Kerja sama global harus menjadi prioritas utama.',
                    8 => 'Fosil baru mungkin ditemukan di daerah terpencil.',
                    9 => 'Data ini dapat merupakan bukti evolusi yang signifikan.',
                    10 => 'Pemerintah akan menerapkan kebijakan lingkungan baru tahun depan.',
                    11 => 'Spesies langka sebaiknya dijaga oleh lembaga resmi.',
                    12 => 'Pendidikan sejak dini sebaiknya adalah kunci keberhasilan konservasi.',
                    13 => 'Teknologi masa depan mungkin mengurangi polusi udara secara drastis.',
                    14 => 'Bakteri tertentu dapat diuraikan oleh enzim khusus.',
                    15 => 'Perjanjian ini akan menjadi dasar hukum perlindungan laut internasional.',
                ];
                foreach ($meeting3Fallback as $idx => $q) {
                    $questions[(string) $idx] = $q;
                }
                $questions['paragraph_answer'] = 'Upaya konservasi laut harus ditingkatkan untuk melindungi terumbu karang. Spesies langka mungkin dapat bertahan jika habitat mereka dijaga dengan baik. Masyarakat sebaiknya berpartisipasi aktif dalam menjaga kebersihan lingkungan.';
                $questions['userParagraphAnswer'] = $questions['paragraph_answer'];
            } elseif ($meetingNumber === 4) {
                $meeting4Fallback = [
                    1 => 'Peneliti tidak mengabaikan temuan statistik yang signifikan.',
                    2 => 'Fasilitas ini bukan merupakan laboratorium utama.',
                    3 => 'Laporan tahunan tersebut tidak dipublikasikan secara terbuka.',
                    4 => 'Para analis tidak sedang mengabaikan fluktuasi pasar.',
                    5 => 'Kebijakan tersebut tidak sedang menjadi hambatan regulasi.',
                    6 => 'Instrumen ilmiah tersebut tidak sedang dikalibrasi.',
                    7 => 'Tim peneliti belum menyelesaikan evaluasi komprehensif.',
                    8 => 'Perusahaan tersebut belum pernah menjadi pimpinan pasar.',
                    9 => 'Dokumen rahasia tersebut belum disebarkan ke publik.',
                    10 => 'Para ilmuwan belum sedang mengamati fenomena tersebut.',
                    11 => 'Otoritas terkait belum sedang menjadi transparan.',
                    12 => 'Infrastruktur tersebut belum sedang direnovasi.',
                    13 => 'Dewan direksi tidak menyetujui usulan akuisisi kemarin.',
                    14 => 'Hasil eksperimen tersebut tidak konsisten minggu lalu.',
                    15 => 'Keputusan strategis tersebut tidak diambil tanpa pertimbangan.',
                    16 => 'Tim investigasi tidak sedang menginspeksi lokasi saat kejadian.',
                    17 => 'Kondisi ekonomi tidak sedang menjadi stabil pada periode itu.',
                    18 => 'Data mentah tersebut tidak sedang diolah oleh sistem.',
                    19 => 'Perusahaan belum mengimplementasikan sistem baru sebelum krisis.',
                    20 => 'Proyek tersebut belum pernah menjadi prioritas sebelumnya.',
                ];
                foreach ($meeting4Fallback as $idx => $q) {
                    $questions[(string) $idx] = $q;
                }
                $questions['paragraph_answer'] = 'Para peneliti harus memverifikasi data laboratorium secara berkala. Limbah kimia berbahaya tidak boleh dibuang sembarangan ke lingkungan. Seluruh staf laboratorium harus selalu waspada terhadap potensi bahaya. Laporan eksperimen ini dapat diselesaikan dalam dua hari. Hasil tes awal mungkin tidak akurat tanpa prosedur standar. Setiap asisten laboratorium harus mengenakan alat pelindung diri lengkap. Bahan kimia reaktif harus disimpan di dalam lemari asam khusus. Peralatan gelas laboratorium tidak boleh dibiarkan kotor setelah digunakan. Semua ilmuwan seharusnya mencatat setiap perubahan suhu secara cermat. Sampel biologis tersebut dapat terkontaminasi oleh udara luar. Ventilasi ruangan laboratorium harus selalu berfungsi secara optimal. Teknisi baru bisa menjadi sangat terampil melalui pelatihan intensif.';
                $questions['userParagraphAnswer'] = $questions['paragraph_answer'];
            }
        }

        // Check database GrammarQuestion table for overrides / other meetings
        try {
            $dbQuestions = \App\Models\GrammarQuestion::where('meeting_number', $meetingNumber)->get();
            foreach ($dbQuestions as $dbQ) {
                if ($dbQ->section === 'paragraph') {
                    $questions['paragraph_answer'] = $dbQ->question_text;
                    $questions['userParagraphAnswer'] = $dbQ->question_text;
                } elseif ($dbQ->question_number) {
                    $questions[(string) $dbQ->question_number] = $dbQ->question_text;
                }
            }
        } catch (\Throwable $e) {
            // Ignore DB query errors if any
        }

        return $questions;
    }

    public function saveEvaluationCanvas(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
            'user_id' => 'required|integer',
            'meeting_number' => 'required|integer',
        ]);

        $image = $request->input('image');
        if (!str_starts_with($image, 'data:image')) {
            return response()->json(['success' => false, 'message' => 'Invalid image payload.'], 422);
        }

        $imageParts = explode(';base64,', $image);
        $imageBase64 = end($imageParts);
        $imageDecoded = base64_decode($imageBase64);

        $dir = storage_path('app/public/evaluations');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $userId = (int) $request->input('user_id');
        $programId = $request->filled('program_id') ? (int) $request->input('program_id') : null;
        $meetingNumber = (int) $request->input('meeting_number');
        $scoreId = $request->filled('score_id') ? (int) $request->input('score_id') : null;

        if ($userId && $meetingNumber) {
            if ($programId) {
                file_put_contents($dir . "/eval_{$userId}_{$programId}_{$meetingNumber}.png", $imageDecoded);
            }
            file_put_contents($dir . "/eval_user_{$userId}_m_{$meetingNumber}.png", $imageDecoded);
        }

        if ($scoreId) {
            file_put_contents($dir . "/eval_{$scoreId}.png", $imageDecoded);
        }

        $score = MeetingScore::where('user_id', $userId)
            ->where('meeting_number', $meetingNumber)
            ->when($programId, fn($q) => $q->where('program_id', $programId))
            ->latest('id')
            ->first();

        if ($score) {
            file_put_contents($dir . "/eval_{$score->id}.png", $imageDecoded);
            if (!$score->reviewed_at) {
                $score->update([
                    'reviewed_at' => now(),
                    'reviewed_by' => Auth::id(),
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Hasil evaluasi coret-coret berhasil disimpan.'
        ]);
    }
}
