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
        $programId = \App\Models\Program::where('slug', 'fast-track-grammar-for-writing')->value('id') ?? Auth::user()?->program_id;
        
        $this->saveMeetingScore($meetingNumber, $sessionPayload[$scoreKey], $programId, [
            'answers' => $sessionPayload,
            'answers_data' => $sessionPayload,
        ]);

        $user = Auth::user();
        if ($user && $programId) {
            try {
                \App\Models\AssignmentDraft::updateOrCreate(
                    ['user_id' => $user->id, 'program_id' => $programId, 'meeting_number' => $meetingNumber],
                    ['answers' => $sessionPayload, 'last_saved_at' => now()]
                );
            } catch (\Throwable $e) {}
        }

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

        $programId = \App\Models\Program::where('slug', 'fast-track-grammar-for-writing')->value('id') ?? Auth::user()?->program_id;

        if ($score !== null) {
            $this->saveMeetingScore($meetingNumber, $score, $programId, !empty($sessionPayload) ? [
                'answers' => $sessionPayload,
                'answers_data' => $sessionPayload,
            ] : null);
        }

        $user = Auth::user();
        if ($user && $programId && !empty($sessionPayload)) {
            try {
                \App\Models\AssignmentDraft::updateOrCreate(
                    ['user_id' => $user->id, 'program_id' => $programId, 'meeting_number' => $meetingNumber],
                    ['answers' => $sessionPayload, 'last_saved_at' => now()]
                );
            } catch (\Throwable $e) {}
        }

        return redirect()->route($routeName);
    }

    protected function resetGrammarWritingMeetingSession(string $routeName, array $sessionKeys)
    {
        session()->forget($sessionKeys);

        if (preg_match('/meeting(\d+)/', $routeName, $matches)) {
            $meetingNumber = (int) $matches[1];
            $programId = \App\Models\Program::where('slug', 'fast-track-grammar-for-writing')->value('id') ?? Auth::user()?->program_id;

            if ($programId) {
                MeetingScore::where('user_id', Auth::id())
                    ->where('meeting_number', $meetingNumber)
                    ->where('program_id', $programId)
                    ->where('is_reported', false)
                    ->delete();

                // "Ulangi Soal Ini" only used to forget session keys above,
                // but every meetingN() view falls back to the database
                // AssignmentDraft row whenever session answers are empty -
                // so the very next page load silently restored everything
                // the reset button just cleared. meeting4Reset() already
                // did this correctly; this brings the other ~19 reset
                // endpoints that share this trait method up to the same
                // behavior. Only ever touches the clicking user's own row.
                try {
                    \App\Models\AssignmentDraft::where('user_id', Auth::id())
                        ->where('meeting_number', $meetingNumber)
                        ->where('program_id', $programId)
                        ->delete();
                } catch (\Throwable $e) {}
            }
        }

        return redirect()->route($routeName);
    }

    protected function saveMeetingScore($meetingNumber, $score, $programId = null, ?array $attributes = null)
    {
        if (!$programId) {
            $programId = \App\Models\Program::where('slug', 'fast-track-grammar-for-writing')->value('id') ?? Auth::user()?->program_id;
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
            if (isset($attributes['answers_data']) && !isset($attributes['answers'])) {
                $updateAttributes['answers'] = $attributes['answers_data'];
            }
            if (isset($attributes['answers']) && !isset($attributes['answers_data'])) {
                $updateAttributes['answers_data'] = $attributes['answers'];
            }
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