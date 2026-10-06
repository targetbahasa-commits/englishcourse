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
                // Deliberately NOT filtering by is_reported here. is_reported
                // just means "class period hadn't ended yet at submission
                // time" (see saveMeetingScore()) - it was never meant to be
                // a permanent grade-lock, but a student whose class period
                // has no end_date set (common data-entry gap - see the
                // admin dashboard's Jam Kelas reminder) computes is_reported
                // = true forever. With the old is_reported = false filter,
                // that row was never deleted here, so every meetingN() view
                // builder's own "fall back to the DB score row" logic kept
                // re-locking the page to the scored/readonly view on every
                // load no matter how many times the student clicked "Ulangi
                // Latihan" - the button looked like it worked (it redirected)
                // but silently did nothing. This button is the ONLY
                // self-service redo path students are given, so honor it
                // unconditionally when they explicitly click it. Only ever
                // touches the clicking user's own row.
                MeetingScore::where('user_id', Auth::id())
                    ->where('meeting_number', $meetingNumber)
                    ->where('program_id', $programId)
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

                // meetingDraft() autosave writes these with a 24h TTL and
                // BuildGrammarWritingMeetingXViewData reads Cache before
                // session/AssignmentDraft, so without this the old answers
                // silently reappeared on the very next load even though
                // session and the DB were already cleared above.
                $cacheKeyMeetings = [$meetingNumber];
                // meetingDraft() mirrors meeting 6 and 10 into each other's
                // cache keys, so a reset of either one must clear both.
                if ($meetingNumber === 6) {
                    $cacheKeyMeetings[] = 10;
                } elseif ($meetingNumber === 10) {
                    $cacheKeyMeetings[] = 6;
                }
                foreach ($cacheKeyMeetings as $m) {
                    \Illuminate\Support\Facades\Cache::forget('user_' . Auth::id() . '_meeting' . $m . '_user_answers');
                    \Illuminate\Support\Facades\Cache::forget('user_' . Auth::id() . '_meeting' . $m . '_user_paragraph_answer');
                    \Illuminate\Support\Facades\Cache::forget('user_' . Auth::id() . '_meeting' . $m . '_user_answers_saved_at');
                }
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