<?php

namespace App\Http\Controllers;

use App\Application\IeltsShared\ManageCambridgeMockupMaterial;
use App\Domain\IeltsShared\CambridgeAccessPolicy;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Models\IeltsListeningMockup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IeltsCambridgeMockupController extends Controller
{
    use HandlesAssignmentAccess;

    private const VALID_EDITIONS = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20];

    private const VALID_TEST_IDS = [1, 2, 3, 4];

    public function __construct(
        private readonly CambridgeAccessPolicy $cambridgeAccessPolicy,
        private readonly ManageCambridgeMockupMaterial $manageCambridgeMockupMaterial,
    ) {
        $this->registerAssignmentAccessMiddleware();
    }

    public function index()
    {
        return view('assignments.ielts.mockup.cambridge');
    }

    public function edition(int $edition)
    {
        if (!in_array($edition, self::VALID_EDITIONS, true)) {
            abort(404);
        }

        return view('assignments.ielts.mockup.cambridge-edition', ['edition' => $edition]);
    }

    public function skills(int $edition, int $id)
    {
        if (!in_array($edition, self::VALID_EDITIONS, true) || !in_array($id, self::VALID_TEST_IDS, true)) {
            abort(404);
        }

        $access = $this->cambridgeAccessPolicy->canAccess(Auth::user(), $edition, $id);

        if ($access === false) {
            return redirect()
                ->route('assignments.ielts-academic.mockup.cambridge.edition', ['edition' => $edition])
                ->with('error', "Anda belum memiliki akses ke Test $id. Silakan lakukan pembayaran terlebih dahulu.");
        }

        $requiresSignup = ($access === \App\Domain\IeltsShared\CambridgeAccessPolicy::NEEDS_SIGNUP);

        return view('assignments.ielts.mockup.cambridge-skills', [
            'edition'       => $edition,
            'testId'        => $id,
            'requiresSignup'=> $requiresSignup,
        ]);
    }

    public function transcribeAudio(int $edition, int $id, Request $request)
    {
        if (strtolower(Auth::user()->role) !== 'admin') {
            abort(403);
        }

        $request->validate([
            'part' => 'required|integer|min:1|max:4',
        ]);

        $part = (int) $request->input('part');

        try {
            $this->manageCambridgeMockupMaterial->transcribeExistingAudio($edition, $id, $part);
            return back()->with('success', "Proses transkripsi ulang (Whisper) untuk Part {$part} berhasil dijalankan.");
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Manual transcribe failed: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses transkripsi: ' . $e->getMessage());
        }
    }

    public function test(int $edition, int $id, string $skill = 'listening')
    {
        if (!in_array($edition, self::VALID_EDITIONS, true) || !in_array($id, self::VALID_TEST_IDS, true)) {
            abort(404);
        }

        $access = $this->cambridgeAccessPolicy->canAccess(Auth::user(), $edition, $id);

        if ($access === false) {
            return redirect()
                ->route('assignments.ielts-academic.mockup.cambridge.edition', ['edition' => $edition])
                ->with('error', "Anda belum memiliki akses ke Test $id. Silakan lakukan pembayaran terlebih dahulu.");
        }

        $requiresSignup = ($access === \App\Domain\IeltsShared\CambridgeAccessPolicy::NEEDS_SIGNUP);

        $uniqueTestId = $edition . str_pad((string) $id, 2, '0', STR_PAD_LEFT);
        $material = IeltsListeningMockup::firstOrCreate(['test_id' => $uniqueTestId]);

        if ($skill === 'reading') {
            $editionReadingView = 'assignments.ielts.mockup.c' . $edition . '-reading-test-' . $id;
            $readingView = 'assignments.ielts.mockup.reading-test-' . $id;

            if (view()->exists($editionReadingView)) {
                return view($editionReadingView, ['edition' => $edition, 'testId' => $id, 'requiresSignup' => $requiresSignup]);
            }

            if (view()->exists($readingView)) {
                return view($readingView, ['edition' => $edition, 'testId' => $id, 'requiresSignup' => $requiresSignup]);
            }

            abort(404);
        }

        if ($skill === 'writing') {
            $editionWritingView = 'assignments.ielts.mockup.c' . $edition . '-writing-test-' . $id;
            $writingView = 'assignments.ielts.mockup.writing-test-' . $id;

            if (view()->exists($editionWritingView)) {
                return view($editionWritingView, ['edition' => $edition, 'testId' => $id, 'requiresSignup' => $requiresSignup]);
            }

            if (view()->exists($writingView)) {
                return view($writingView, ['edition' => $edition, 'testId' => $id, 'requiresSignup' => $requiresSignup]);
            }

            abort(404);
        }

        if ($skill === 'speaking') {
            $editionSpeakingView = 'assignments.ielts.mockup.c' . $edition . '-speaking-test-' . $id;
            $speakingView = 'assignments.ielts.mockup.speaking-test-' . $id;

            if (view()->exists($editionSpeakingView)) {
                return view($editionSpeakingView, ['edition' => $edition, 'testId' => $id, 'requiresSignup' => $requiresSignup]);
            }

            if (view()->exists($speakingView)) {
                return view($speakingView, ['edition' => $edition, 'testId' => $id, 'requiresSignup' => $requiresSignup]);
            }

            abort(404);
        }

        $editionListeningView = 'assignments.ielts.mockup.c' . $edition . '-listening-test-' . $id;
        if (view()->exists($editionListeningView)) {
            return view($editionListeningView, ['edition' => $edition, 'testId' => $id, 'material' => $material, 'requiresSignup' => $requiresSignup]);
        }

        if ($id === 1) {
            return view('assignments.ielts.mockup.listening-test', ['edition' => $edition, 'testId' => $id, 'material' => $material, 'requiresSignup' => $requiresSignup]);
        }

        if ($id === 2) {
            return view('assignments.ielts.mockup.listening-test-2', ['edition' => $edition, 'testId' => $id, 'material' => $material, 'requiresSignup' => $requiresSignup]);
        }

        if ($id === 3) {
            return view('assignments.ielts.mockup.listening-test-3', ['edition' => $edition, 'testId' => $id, 'material' => $material, 'requiresSignup' => $requiresSignup]);
        }

        if ($id === 4) {
            return view('assignments.ielts.mockup.listening-test-4', ['edition' => $edition, 'testId' => $id, 'material' => $material, 'requiresSignup' => $requiresSignup]);
        }

        abort(404);
    }

    public function uploadAudio(Request $request, int $edition, int $id)
    {
        $user = Auth::user();
        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            abort(403);
        }

        $request->validate([
            'audio_file' => 'required|file|mimes:mp3,wav,ogg|max:51200',
            'part' => 'required|integer|min:1|max:4',
        ]);

        if ($request->hasFile('audio_file')) {
            $autoTranscribe = $request->boolean('auto_transcribe', true);
            $this->manageCambridgeMockupMaterial->uploadAudio(
                $edition, 
                $id, 
                $request->integer('part'), 
                $request->file('audio_file'),
                $autoTranscribe
            );

            if ($autoTranscribe) {
                return back()->with('success', 'Audio berhasil diupload dan proses transkripsi AI berjalan di latar belakang.');
            }
            return back()->with('success', 'Audio berhasil diupload (Tanpa proses transkripsi AI).');
        }

        return back()->with('error', 'No file uploaded.');
    }

    public function uploadSrt(Request $request, int $edition, int $id)
    {
        $user = Auth::user();
        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            abort(403);
        }

        $request->validate([
            'srt_file' => 'required_without:srt_content|nullable|file|extensions:srt|max:2048',
            'srt_content' => 'required_without:srt_file|nullable|string',
            'language' => 'required|in:en,id',
            'part' => 'required|integer|min:1|max:4',
        ]);

        if ($request->hasFile('srt_file')) {
            $content = file_get_contents($request->file('srt_file')->getRealPath());
        } else {
            $content = $request->input('srt_content');
        }

        if (!empty($content)) {
            $this->manageCambridgeMockupMaterial->uploadSrt(
                $edition,
                $id,
                $request->integer('part'),
                (string) $content,
                (string) $request->input('language')
            );

            return back()->with('success', 'Transcript uploaded/updated successfully.');
        }

        return back()->with('error', 'No content provided.');
    }

    public function uploadAnswerKey(Request $request, int $edition, int $id)
    {
        $user = Auth::user();
        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            abort(403);
        }

        $request->validate([
            'answer_key' => 'required|string',
            'part' => 'required|integer|min:1|max:4',
        ]);

        $this->manageCambridgeMockupMaterial->updateAnswerKey($edition, $id, $request->integer('part'), (string) $request->input('answer_key'));

        return back()->with('success', 'Answer Key uploaded/updated successfully.');
    }

    private function ensureTestAccess(int $edition, int $id): ?RedirectResponse
    {
        if (!in_array($edition, self::VALID_EDITIONS, true) || !in_array($id, self::VALID_TEST_IDS, true)) {
            abort(404);
        }

        if ($this->cambridgeAccessPolicy->canAccess(Auth::user(), $edition, $id)) {
            return null;
        }

        return redirect()
            ->route('assignments.ielts-academic.mockup.cambridge.edition', ['edition' => $edition])
            ->with('error', "Anda belum memiliki akses ke Test $id. Silakan lakukan pembayaran terlebih dahulu.");
    }
}