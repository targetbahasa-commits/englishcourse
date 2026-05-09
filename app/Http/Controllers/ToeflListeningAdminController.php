<?php

namespace App\Http\Controllers;

use App\Application\ToeflListening\ManageListeningMeetings;
use App\Application\ToeflListening\ManageListeningMedia;
use App\Application\ToeflListening\ManageListeningQuestions;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Http\Controllers\Concerns\ResolvesAuthenticatedUser;
use Illuminate\Http\Request;

class ToeflListeningAdminController extends Controller
{
    use HandlesAssignmentAccess;
    use ResolvesAuthenticatedUser;

    public function __construct(
        private readonly ManageListeningMeetings $manageListeningMeetings,
        private readonly ManageListeningMedia $manageListeningMedia,
        private readonly ManageListeningQuestions $manageListeningQuestions,
    ) {
        $this->registerAssignmentAccessMiddleware();
    }

    public function addSet(Request $request, int $number)
    {
        $user = $this->authenticatedUser();
        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            abort(403);
        }

        $nextSet = $this->manageListeningMeetings->addSet($number);

        return back()->with('success', "Practice Set {$nextSet} added successfully.");
    }

    public function removeSet(Request $request, int $number)
    {
        $user = $this->authenticatedUser();
        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            abort(403);
        }

        $setNumber = $request->integer('set_number');
        if (!$setNumber) {
            return back()->with('error', 'Set number is required.');
        }

        $deleted = $this->manageListeningMeetings->removeSet($number, $setNumber);

        if ($deleted) {
            return back()->with('success', "Practice Set {$setNumber} removed successfully.");
        }

        return back()->with('error', 'Set not found or could not be deleted.');
    }

    public function toggleLock(Request $request, int $number)
    {
        $user = $this->authenticatedUser();
        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            abort(403);
        }

        return back()->with('success', $this->manageListeningMeetings->toggleLock($number, $request->integer('class_period_id')));
    }

    public function toggleTranscript(int $number)
    {
        $user = $this->authenticatedUser();
        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            abort(403);
        }

        return back()->with('success', $this->manageListeningMeetings->toggleTranscript($number));
    }

    public function storeQuestion(Request $request)
    {
        $user = $this->authenticatedUser();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'id' => 'nullable|integer',
            'meeting_number' => 'required|integer|min:1|max:103',
            'set_number' => 'required|integer|min:1',
            'question_number' => 'required|integer',
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D',
            'audio_file' => 'nullable|file|mimes:mp3,wav|max:5120',
        ]);

        $message = $this->manageListeningQuestions->store($request->all(), $request->file('audio_file'));

        return back()->with('success', $message);
    }

    public function updateQuestion(Request $request, int $id)
    {
        $request->merge(['id' => $id]);

        return $this->storeQuestion($request);
    }

    public function destroyQuestion(int $id)
    {
        $user = $this->authenticatedUser();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $this->manageListeningQuestions->delete($id);

        return back()->with('success', 'Question deleted successfully.');
    }

    public function updateTranscript(Request $request, int $number, int $set)
    {
        $user = $this->authenticatedUser();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'transcript_en' => 'nullable|string',
            'transcript_id' => 'nullable|string',
        ]);

        $this->manageListeningMedia->updateTranscript(
            $number,
            $set,
            $request->input('transcript_en'),
            $request->input('transcript_id'),
        );

        return back()->with('success', 'Transcript updated successfully.');
    }

    public function uploadSrt(Request $request, int $number, int $set)
    {
        $user = $this->authenticatedUser();
        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            abort(403);
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
            $content = $request->input('srt_content');
        }

        if ($this->manageListeningMedia->uploadSrt($number, $set, $request->input('language'), $content)) {
            return back()->with('success', 'SRT uploaded and parsed successfully.');
        }

        return back()->with('error', 'Failed to upload SRT file.');
    }

    public function uploadAudio(Request $request, int $number, int $set)
    {
        $user = $this->authenticatedUser();
        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            return back()->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg,m4a|max:51200',
            'existing_audio_path' => 'nullable|string|max:500',
        ]);

        if (!$request->hasFile('audio_file') && !$request->filled('existing_audio_path')) {
            return back()->with('error', 'Please upload a file or choose audio from folder.');
        }

        try {
            $message = $this->manageListeningMedia->uploadAudio(
                $number,
                $set,
                $request->file('audio_file'),
                $request->input('existing_audio_path'),
            );

            if (str_contains($message, 'invalid') || str_contains($message, 'Invalid') || str_contains($message, 'Unsupported') || str_contains($message, 'Failed') || str_contains($message, 'not found')) {
                return back()->with('error', $message);
            }

            return back()->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'Exception during audio processing: ' . $e->getMessage());
        }
    }

    public function getSourceAudioFilesList()
    {
        $user = $this->authenticatedUser();
        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($this->manageListeningMedia->sourceAudioOptions());
    }
}
