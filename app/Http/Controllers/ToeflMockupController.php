<?php

namespace App\Http\Controllers;

use App\Application\ToeflMockup\BuildMockupPackageCatalog;
use App\Application\ToeflMockup\BuildMockupPackageViewData;
use App\Application\ToeflMockup\BuildMockupResultViewData;
use App\Application\ToeflMockup\SubmitMockupTest;
use App\Application\ToeflMockup\UpdateMockupTranscript;
use App\Application\ToeflMockup\UploadMockupDirectionAudio;
use App\Application\ToeflMockup\UploadMockupListeningAudio;
use App\Application\ToeflMockup\UploadMockupQuestionAudio;
use App\Application\ToeflMockup\UploadMockupSrt;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ToeflMockupController extends Controller
{
    use HandlesAssignmentAccess;

    public function __construct(
        private readonly BuildMockupPackageCatalog $buildMockupPackageCatalog,
        private readonly BuildMockupPackageViewData $buildMockupPackageViewData,
        private readonly SubmitMockupTest $submitMockupTest,
        private readonly BuildMockupResultViewData $buildMockupResultViewData,
        private readonly UploadMockupDirectionAudio $uploadMockupDirectionAudio,
        private readonly UploadMockupListeningAudio $uploadMockupListeningAudio,
        private readonly UploadMockupSrt $uploadMockupSrt,
        private readonly UpdateMockupTranscript $updateMockupTranscript,
        private readonly UploadMockupQuestionAudio $uploadMockupQuestionAudio,
    ) {
        $this->registerAssignmentAccessMiddleware();
    }

    public function index()
    {
        $mockPackages = array_map(
            fn ($package) => $package->toArray(),
            $this->buildMockupPackageCatalog->handle()
        );

        return view('assignments.toefl-itp.mockup-index', compact('mockPackages'));
    }

    public function showPackage(int $package)
    {
        if (!in_array($package, [1, 2, 3], true)) {
            return redirect()->route('assignments.toefl-itp.mockup')
                ->with('error', 'Paket ini belum tersedia.');
        }

        $viewData = $this->buildMockupPackageViewData->handle($package);

        return view('assignments.toefl-itp.mockup', $viewData);
    }

    public function submit(Request $request, int $package)
    {
        $answers = $request->input('answers', []);

        $submissionResult = $this->submitMockupTest->handle($package, $answers, Auth::user());
        $responsePayload = $submissionResult->toArray();
        $responsePayload['redirectUrl'] = $submissionResult->resultId
            ? route('assignments.mock-tests.results.show', $submissionResult->resultId)
            : null;

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json($responsePayload);
        }

        if ($submissionResult->resultId) {
            return redirect()
                ->route('assignments.mock-tests.results.show', $submissionResult->resultId)
                ->with('success', 'Mock test result has been saved.');
        }

        return redirect()
            ->route('assignments.toefl-itp.mockup.package', ['package' => $package])
            ->with('success', 'Mock test submitted.');
    }

    public function showResult(int $resultId)
    {
        $result = $this->buildMockupResultViewData->handle($resultId);

        abort_unless(Auth::check(), 403);

        /** @var User $user */
        $user = Auth::user();
        $canView = $user->id === $result->user_id || $user->isAdmin() || $user->isTeacher();

        abort_unless($canView, 403);

        return view('assignments.mock-tests.results.show', compact('result'));
    }

    public function uploadAudio(Request $request, int $package)
    {
        $user = Auth::user();

        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        if ($request->filled('listening_direction_part')) {
            if (!$user->isAdmin()) {
                return redirect()->back()->with('error', 'Hanya admin yang dapat mengunggah audio directions.');
            }

            $request->validate([
                'audio_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a|max:51200',
                'existing_audio_path' => 'nullable|string|max:500',
            ]);

            if (!$request->hasFile('audio_file') && !$request->filled('existing_audio_path')) {
                return redirect()->back()->with('error', 'Unggah file audio atau pilih path audio yang ada.');
            }

            try {
                $result = $this->uploadMockupDirectionAudio->handle(
                    $package,
                    (string) $request->input('listening_direction_part'),
                    $request->file('audio_file'),
                    $request->input('existing_audio_path')
                );

                return redirect()->back()->with('success', $result['message']);
            } catch (\Exception $e) {
                Log::error('uploadToeflItpMockupAudio direction Error: ' . $e->getMessage());

                return redirect()->back()->with('error', 'Gagal menyimpan audio directions: ' . $e->getMessage());
            }
        }

        $request->validate([
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a|max:51200',
            'existing_audio_path' => 'nullable|string|max:500',
        ]);

        if (!$request->hasFile('audio_file') && !$request->filled('existing_audio_path')) {
            return redirect()->back()->with('error', 'Please upload a file or choose audio from folder.');
        }

        try {
            $questionId = $request->filled('question_id') ? (int) $request->input('question_id') : null;

            if ($questionId && !$user->isAdmin()) {
                return redirect()->back()->with('error', 'Hanya admin yang dapat menginput audio soal.');
            }

            $result = $this->uploadMockupListeningAudio->handle(
                $package,
                $questionId,
                $request->file('audio_file'),
                $request->input('existing_audio_path')
            );

            return redirect()->back()->with('success', $result['message']);
        } catch (\Exception $e) {
            Log::error('uploadToeflItpMockupAudio Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while uploading audio: ' . $e->getMessage());
        }
    }

    public function uploadSrt(Request $request, int $package)
    {
        $user = Auth::user();

        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'srt_file' => 'nullable|file|mimes:txt,srt|max:2048',
            'srt_content' => 'nullable|string',
            'language' => 'required|in:en,id',
        ]);

        if (!$request->hasFile('srt_file') && !$request->filled('srt_content')) {
            return redirect()->back()->with('error', 'Please provide an SRT file or paste the content.');
        }

        try {
            $content = $request->hasFile('srt_file')
                ? file_get_contents($request->file('srt_file')->getRealPath())
                : $request->input('srt_content');

            $this->uploadMockupSrt->handle(
                $package,
                (string) $request->input('language'),
                (string) $content
            );

            return redirect()->back()->with('success', 'SRT transcript successfully parsed and saved!');
        } catch (\Exception $e) {
            Log::error('uploadToeflItpMockupSrt Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while processing SRT: ' . $e->getMessage());
        }
    }

    public function updateTranscript(Request $request, int $package)
    {
        $user = Auth::user();

        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'transcript_en' => 'nullable|string',
            'transcript_id' => 'nullable|string',
        ]);

        try {
            $this->updateMockupTranscript->handle(
                $package,
                $request->input('transcript_en'),
                $request->input('transcript_id')
            );

            return redirect()->back()->with('success', 'Transcript saved successfully!');
        } catch (\Exception $e) {
            Log::error('updateToeflItpMockupTranscript Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while saving transcripts: ' . $e->getMessage());
        }
    }

    public function uploadQuestionAudio(Request $request, int $package, int $questionId)
    {
        $user = Auth::user();

        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'audio_file' => 'required|file|mimes:mp3,wav,ogg,m4a|max:51200',
        ]);

        try {
            $this->uploadMockupQuestionAudio->handle($package, $questionId, $request->file('audio_file'));

            return redirect()->back()->with('success', 'Question audio uploaded successfully.');
        } catch (\Exception $e) {
            Log::error('uploadToeflItpMockupQuestionAudio Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while uploading audio: ' . $e->getMessage());
        }
    }

}