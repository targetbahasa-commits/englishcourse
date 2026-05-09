<?php

namespace App\Http\Controllers\Concerns;

use App\Models\MeetingScore;
use Illuminate\Support\Facades\Auth;

trait HandlesGrammarWritingSessions
{
    protected function completeGrammarWritingMeetingSubmission(int $meetingNumber, string $routeName, array $sessionPayload, string $scoreKey)
    {
        session($sessionPayload);
        $this->saveMeetingScore($meetingNumber, $sessionPayload[$scoreKey]);

        return redirect()->route($routeName);
    }

    protected function completeConditionalGrammarWritingMeetingSubmission(
        int $meetingNumber,
        string $routeName,
        array $sessionPayload,
        ?int $score = null,
    ) {
        if (!empty($sessionPayload)) {
            session($sessionPayload);
        }

        if ($score !== null) {
            $this->saveMeetingScore($meetingNumber, $score);
        }

        return redirect()->route($routeName);
    }

    protected function resetGrammarWritingMeetingSession(string $routeName, array $sessionKeys)
    {
        session()->forget($sessionKeys);

        return redirect()->route($routeName);
    }

    protected function saveMeetingScore($meetingNumber, $score, $programId = null)
    {
        if (!$programId) {
            $programId = \App\Models\Program::where('slug', 'grammar-for-writing')->value('id');
        }

        MeetingScore::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'meeting_number' => $meetingNumber,
                'program_id' => $programId,
            ],
            [
                'score' => $score,
                'submitted_at' => now(),
            ]
        );
    }
}