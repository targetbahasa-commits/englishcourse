<?php

namespace App\Http\Controllers;

use App\Application\IeltsListening\ManageIeltsListeningMeetings;
use App\Application\IeltsListening\ManageIeltsListeningMedia;
use App\Application\IeltsListening\ManageIeltsListeningMaterialMedia;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Http\Controllers\Concerns\ResolvesAuthenticatedUser;
use Illuminate\Http\Request;

class IeltsListeningAdminController extends Controller
{
    use HandlesAssignmentAccess;
    use ResolvesAuthenticatedUser;

    public function __construct(
        private readonly ManageIeltsListeningMeetings $manageIeltsListeningMeetings,
        private readonly ManageIeltsListeningMedia $manageIeltsListeningMedia,
        private readonly ManageIeltsListeningMaterialMedia $manageIeltsListeningMaterialMedia,
    ) {
        $this->registerAssignmentAccessMiddleware();
    }

    public function storeMeeting(Request $request)
    {
        $user = $this->authenticatedUser();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'meeting_number' => 'required|integer',
        ]);

        $this->manageIeltsListeningMeetings->createMeeting($validated);

        return back()->with('success', 'Practice Test created successfully');
    }

    public function reorderMeetings(Request $request)
    {
        $user = $this->authenticatedUser();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'meetings' => 'required|array',
            'meetings.*' => 'exists:meetings,id',
        ]);

        $this->manageIeltsListeningMeetings->reorderMeetings($validated['meetings']);

        return response()->json(['success' => true]);
    }

    public function uploadAudio(Request $request, int $meetingId, int $set)
    {
        $user = $this->authenticatedUser();
        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'audio_file' => 'required|file|mimes:mp3,wav,m4a|max:51200',
        ]);

        try {
            $this->manageIeltsListeningMedia->uploadAudio($meetingId, $set, $request->file('audio_file'));

            return redirect()->back()->with('success', 'Audio uploaded successfully!');
        } catch (\RuntimeException $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Upload failed: ' . $exception->getMessage());
        }
    }

    public function uploadTranscript(Request $request, int $meetingId, int $set)
    {
        $user = $this->authenticatedUser();
        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        try {
            $this->manageIeltsListeningMedia->updateTranscript(
                $meetingId,
                $set,
                $request->input('transcript_en'),
                $request->input('transcript_id'),
            );

            return redirect()->back()->with('success', 'Transcripts updated successfully!');
        } catch (\RuntimeException $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function uploadMaterialAudio(Request $request, int $id)
    {
        $user = $this->authenticatedUser();
        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            abort(403);
        }

        $request->validate([
            'audio_file' => 'required|file|mimes:mp3,wav,ogg|max:51200',
        ]);

        if (!$request->hasFile('audio_file')) {
            return back()->with('error', 'No file uploaded.');
        }

        $this->manageIeltsListeningMaterialMedia->uploadAudio($id, $request->file('audio_file'));

        return back()->with('success', 'Audio uploaded successfully.');
    }

    public function uploadMaterialSrt(Request $request, int $id)
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

        try {
            $this->manageIeltsListeningMaterialMedia->uploadTranscript(
                $id,
                $request->string('language')->toString(),
                $request->input('srt_content'),
                $request->file('srt_file'),
            );

            return back()->with('success', 'Transcript uploaded/updated successfully.');
        } catch (\RuntimeException $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function uploadMaterialAnswerKey(Request $request, int $id)
    {
        $user = $this->authenticatedUser();
        if (!$user || (!$user->isAdmin() && !$user->isTeacher())) {
            abort(403);
        }

        $request->validate([
            'answer_key' => 'required|string',
        ]);

        $this->manageIeltsListeningMaterialMedia->updateAnswerKey($id, $request->string('answer_key')->toString());

        return back()->with('success', 'Answer Key uploaded/updated successfully.');
    }
}
