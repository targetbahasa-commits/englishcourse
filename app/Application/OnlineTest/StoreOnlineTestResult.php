<?php

namespace App\Application\OnlineTest;

use App\Models\OnlineTestResult;
use App\Models\User;
use Carbon\Carbon;

class StoreOnlineTestResult
{
    /**
     * @param array<string, mixed> $test
     */
    public function start(User $user, array $test): OnlineTestResult
    {
        return OnlineTestResult::create([
            'user_id' => $user->id,
            'test_slug' => (string) $test['slug'],
            'test_label' => (string) $test['label'],
            'status' => 'in_progress',
            'duration_minutes' => (int) $test['duration_minutes'],
            'started_at' => Carbon::now(),
            'answers_data' => [],
            'evaluation_data' => [],
        ]);
    }

    /**
     * @param array<string, mixed> $test
     * @param array<string, string> $answers
     */
    public function submit(OnlineTestResult $result, array $test, array $answers, ?int $timeSpentSeconds = null): OnlineTestResult
    {
        $sections = collect($test['sections'] ?? []);
        $sectionKeys = $sections->pluck('key')->filter()->values()->all();

        $normalizedAnswers = [];
        foreach ($sectionKeys as $sectionKey) {
            $value = trim((string) ($answers[$sectionKey] ?? ''));
            $normalizedAnswers[$sectionKey] = $value;
        }

        $answeredCount = collect($normalizedAnswers)
            ->filter(fn ($value) => $value !== '')
            ->count();

        $totalSections = max(1, count($sectionKeys));
        $completionRate = round(($answeredCount / $totalSections) * 100, 2);

        $secondsSpent = $timeSpentSeconds;

        if ($secondsSpent === null && $result->started_at) {
            $secondsSpent = Carbon::parse($result->started_at)->diffInSeconds(Carbon::now());
        }

        $result->fill([
            'status' => 'completed',
            'score' => $completionRate,
            'time_spent_seconds' => max(0, (int) ($secondsSpent ?? 0)),
            'answers_data' => $normalizedAnswers,
            'evaluation_data' => [
                'answered_sections' => $answeredCount,
                'total_sections' => $totalSections,
                'completion_rate' => $completionRate,
                'submitted_at' => Carbon::now()->toIso8601String(),
            ],
            'completed_at' => Carbon::now(),
        ]);

        $result->save();

        return $result->fresh();
    }
}
