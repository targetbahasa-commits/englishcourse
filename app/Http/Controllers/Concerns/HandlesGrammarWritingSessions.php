<?php

namespace App\Http\Controllers\Concerns;

use App\Models\MeetingScore;
use Illuminate\Support\Facades\Auth;

trait HandlesGrammarWritingSessions
{
    use EvaluatesClassPeriodEnd;
    protected function completeGrammarWritingMeetingSubmission(int $meetingNumber, string $routeName, array $sessionPayload, string $scoreKey)
    {
        session($sessionPayload);
        $this->saveMeetingScore($meetingNumber, $sessionPayload[$scoreKey], null, [
            'answers_data' => $sessionPayload,
        ]);

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

        if (preg_match('/meeting(\d+)/', $routeName, $matches)) {
            $meetingNumber = (int) $matches[1];
            $programId = \App\Models\Program::where('slug', 'grammar-for-writing')->value('id');
            
            MeetingScore::where('user_id', Auth::id())
                ->where('meeting_number', $meetingNumber)
                ->where('program_id', $programId)
                ->where('is_reported', false)
                ->delete();
        }

        return redirect()->route($routeName);
    }

    protected function saveMeetingScore($meetingNumber, $score, $programId = null, ?array $attributes = null)
    {
        if (!$programId) {
            $programId = \App\Models\Program::where('slug', 'grammar-for-writing')->value('id');
        }

        // Determine if this submission is in Practice Mode (class has ended)
        $isReported = !$this->isStudentClassPeriodEnded('grammar-for-writing');

        $updateAttributes = [
            'score'       => $score,
            'is_reported' => $isReported,
            'submitted_at' => now(),
        ];

        if (!empty($attributes) && is_array($attributes)) {
            $updateAttributes = array_merge($updateAttributes, $attributes);
        }

        MeetingScore::updateOrCreate(
            [
                'user_id'        => Auth::id(),
                'meeting_number' => $meetingNumber,
                'program_id'     => $programId,
                'is_reported'    => $isReported,
            ],
            $updateAttributes
        );
    }
}