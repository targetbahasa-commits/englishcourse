<?php

namespace App\Http\Controllers;

use App\Application\ToeflListeningPractice\BuildListeningPracticeIndexData;
use App\Application\ToeflListeningPractice\BuildListeningPracticePartAIndexData;
use App\Application\ToeflListeningPractice\BuildListeningPracticePartARangeViewData;
use App\Application\ToeflListeningPractice\BuildListeningPracticePackageViewData;
use App\Application\ToeflListeningPractice\ManageListeningPracticePackageMedia;
use App\Application\ToeflListeningPractice\SubmitListeningPracticePackage;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ToeflListeningPracticeController extends Controller
{
    use HandlesAssignmentAccess;

    public function __construct(
        private readonly BuildListeningPracticeIndexData $buildListeningPracticeIndexData,
        private readonly BuildListeningPracticePartAIndexData $buildListeningPracticePartAIndexData,
        private readonly BuildListeningPracticePartARangeViewData $buildListeningPracticePartARangeViewData,
        private readonly BuildListeningPracticePackageViewData $buildListeningPracticePackageViewData,
        private readonly ManageListeningPracticePackageMedia $manageListeningPracticePackageMedia,
        private readonly SubmitListeningPracticePackage $submitListeningPracticePackage,
    ) {
        $this->registerAssignmentAccessMiddleware();
    }

    public function index()
    {
        return view('assignments.toefl-itp.listening.practice-index', $this->buildListeningPracticeIndexData->handle());
    }

    public function partA()
    {
        return view('assignments.toefl-itp.listening.practice-part-a', $this->buildListeningPracticePartAIndexData->handle());
    }

    public function showPartARange(int $start, int $end)
    {
        return view('assignments.toefl-itp.listening.practice-part-a-range', $this->buildListeningPracticePartARangeViewData->handle($start, $end));
    }

    public function showPackage(int $package)
    {
        if ($package !== 1) {
            return redirect()->route('assignments.toefl-itp.listening.practice')
                ->with('error', 'Paket ini belum tersedia.');
        }

        $viewData = $this->buildListeningPracticePackageViewData->handle($package);
        $viewData['uploadAudioRoute'] = route('assignments.toefl-itp.listening.practice.package.upload-audio', ['package' => $package]);
        $viewData['uploadSrtRoute'] = route('assignments.toefl-itp.listening.practice.package.upload-srt', ['package' => $package]);
        $viewData['updateTranscriptRoute'] = route('assignments.toefl-itp.listening.practice.package.update-transcript', ['package' => $package]);
        $viewData['listeningSubmitRoute'] = route('assignments.toefl-itp.listening.practice.package.submit', ['package' => $package]);

        return view('assignments.toefl-itp.listening-practice', $viewData);
    }

    public function uploadAudio(Request $request, int $package)
    {
        $user = Auth::user();

        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        if ($package !== 1) {
            return redirect()->back()->with('error', 'Paket ini belum tersedia.');
        }

        $request->validate([
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a|max:51200',
            'existing_audio_path' => 'nullable|string|max:500',
            'question_id' => 'nullable|integer',
        ]);

        if (!$request->hasFile('audio_file') && !$request->filled('existing_audio_path')) {
            return redirect()->back()->with('error', 'Please upload a file or choose audio from folder.');
        }

        try {
            $result = $this->manageListeningPracticePackageMedia->updateAudio(
                $package,
                $request->file('audio_file'),
                $request->input('existing_audio_path')
            );

            return redirect()->back()->with('success', $result['message']);
        } catch (\Exception $e) {
            Log::error('uploadListeningPracticePackageAudio Error: ' . $e->getMessage());

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateTranscript(Request $request, int $package)
    {
        $user = Auth::user();

        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        if ($package !== 1) {
            return redirect()->back()->with('error', 'Paket ini belum tersedia.');
        }

        $request->validate([
            'transcript_en' => 'nullable|string',
            'transcript_id' => 'nullable|string',
        ]);

        $this->manageListeningPracticePackageMedia->updateTranscript(
            $request->input('transcript_en'),
            $request->input('transcript_id')
        );

        return back()->with('success', 'Transcript updated successfully.');
    }

    public function uploadSrt(Request $request, int $package)
    {
        $user = Auth::user();

        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            abort(403);
        }

        if ($package !== 1) {
            return redirect()->back()->with('error', 'Paket ini belum tersedia.');
        }

        $request->validate([
            'srt_file' => 'required_without:srt_content|nullable|file|extensions:srt|max:2048',
            'srt_content' => 'required_without:srt_file|nullable|string',
            'language' => 'required|in:en,id',
        ]);

        $content = '';
        if ($request->hasFile('srt_file')) {
            $file = $request->file('srt_file');
            if ($file && $file->isValid()) {
                $content = file_get_contents($file->getRealPath());
            }
        } elseif ($request->filled('srt_content')) {
            $content = (string) $request->input('srt_content');
        }

        if ($content === '') {
            return back()->with('error', 'Failed to upload SRT file.');
        }

        $this->manageListeningPracticePackageMedia->uploadSrt(
            $package,
            $content,
            (string) $request->input('language')
        );

        return back()->with('success', 'SRT uploaded and parsed successfully.');
    }

    public function submit(Request $request, int $package)
    {
        if ($package !== 1) {
            abort(404);
        }

        try {
            $submissionResult = $this->submitListeningPracticePackage->handle($request->all());
        } catch (\RuntimeException $e) {
            return redirect()->route('assignments.toefl-itp.listening.practice.package', ['package' => $package])
                ->with('error', $e->getMessage());
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($submissionResult->toArray());
        }

        return redirect()->route('assignments.toefl-itp.listening.practice.package', ['package' => $package])
            ->with('success', "Paket {$package} submitted. Score: {$submissionResult->score} ({$submissionResult->correct}/{$submissionResult->total} correct)")
            ->with('listeningPackageReview', $submissionResult->reviewPayload());
    }
}