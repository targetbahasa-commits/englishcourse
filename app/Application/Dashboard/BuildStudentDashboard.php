<?php

namespace App\Application\Dashboard;

use App\Domain\Dashboard\Repositories\DashboardRepository;

class BuildStudentDashboard
{
    public function __construct(
        private readonly DashboardRepository $repository
    ) {
    }

    public function execute(mixed $user): array
    {
        $totalAssignments = $this->repository->countMeetings();
        if ($totalAssignments === 0) {
            $totalAssignments = 20;
        }

        $completedAssignments = $this->repository->countMeetingScoresByUser($user->id);
        $progressPercentage = $totalAssignments > 0 ? ($completedAssignments / $totalAssignments) * 100 : 0;

        $averageScore = $this->repository->averageMeetingScore($user->id);
        $highestScore = $this->repository->highestMeetingScore($user->id);
        $totalPoints = $this->repository->totalMeetingPoints($user->id);

        $recentActivity = $this->repository->recentMeetingActivity($user->id);

        $latestTest = $this->repository->latestFreeTest($user->id);
        $recommendedProgram = null;
        $targetScore = null;

        if ($latestTest) {
            $outreachMessage = $this->repository->findOutreachMessage($latestTest->test_type, $user->role, (float) $latestTest->score);

            if ($outreachMessage && $outreachMessage->program) {
                $recommendedProgram = $outreachMessage->program;
            }

            $score = (float) $latestTest->score;
            $isIelts = str_starts_with($latestTest->test_type, 'ielts_') || $latestTest->test_type === 'pte_academic';
            if ($isIelts) {
                $targetScore = min(9.0, $score + 1.0);
            } else {
                $targetScore = min(677, $score + 50);
            }
        }

        $upcomingClasses = collect();
        if ($user->class_period_id) {
            $upcomingClasses = $this->repository->upcomingClasses($user->class_period_id);
        }

        $allMeetingScores = collect($this->repository->allMeetingScoresByUser($user->id))->groupBy('program_id');
        $enrollments = collect($this->repository->enrollmentsWithProgram($user->id));

        $classScores = [];
        $classNames = [];

        if ($enrollments->isNotEmpty()) {
            foreach ($enrollments as $enrollment) {
                $program = $enrollment->program;
                if (! $program) {
                    continue;
                }

                $programScoresRaw = isset($allMeetingScores[$program->id])
                    ? $allMeetingScores[$program->id]->pluck('score', 'meeting_number')->toArray()
                    : [];

                $programScores = [];
                for ($i = 1; $i <= 20; $i++) {
                    $programScores[] = $programScoresRaw[$i] ?? null;
                }

                $classScores[$program->id] = $programScores;
                $classNames[$program->id] = $program->name;
            }
        }

        if (empty($classScores)) {
            $singleChartData = [];
            $legacyScores = collect($this->repository->allMeetingScoresByUser($user->id))->pluck('score', 'meeting_number')->toArray();
            for ($i = 1; $i <= 20; $i++) {
                $singleChartData[] = $legacyScores[$i] ?? null;
            }
            $classScores[0] = $singleChartData;
            $classNames[0] = 'All Meetings';
        }

        $chartData = count($classScores) ? reset($classScores) : [];

        $predictedScore = null;
        if ($completedAssignments > 0) {
            $isIeltsProgram = false;
            if ($latestTest) {
                $isIeltsProgram = str_starts_with($latestTest->test_type, 'ielts_') || $latestTest->test_type === 'pte_academic';
            } elseif ($user->program && stripos($user->program->name, 'IELTS') !== false) {
                $isIeltsProgram = true;
            }

            if ($isIeltsProgram) {
                $predictedScore = round(($averageScore / 100) * 9.0 * 2) / 2;
                $predictedScore = number_format(max(1.0, min(9.0, $predictedScore)), 1);
            } else {
                $baseToefl = 310;
                $predictedScore = round($baseToefl + (($averageScore / 100) * (677 - $baseToefl)));
                $predictedScore = max(310, min(677, $predictedScore));
            }
        }

        $lowestScores = $this->repository->scoresBelow($user->id, 70);

        $diagnosticStats = ['excellent' => 0, 'good' => 0, 'needs_review' => 0];
        $allScores = $this->repository->pluckScores($user->id);

        foreach ($allScores as $scoreVal) {
            if ($scoreVal >= 90) {
                $diagnosticStats['excellent']++;
            } elseif ($scoreVal >= 70) {
                $diagnosticStats['good']++;
            } else {
                $diagnosticStats['needs_review']++;
            }
        }

        $enrolledPrograms = collect();
        if ($user->program) {
            $enrolledPrograms->push($user->program);
        }
        if ($enrollments->isNotEmpty()) {
            foreach ($enrollments as $enrollment) {
                if ($enrollment->program && ! $enrolledPrograms->contains('id', $enrollment->program->id)) {
                    $enrolledPrograms->push($enrollment->program);
                }
            }
        }
        if ($enrolledPrograms->isEmpty() && $user->isStudent()) {
            $defaultProgram = $this->repository->findProgramBySlug('grammar-for-writing');
            if ($defaultProgram) {
                $enrolledPrograms->push($defaultProgram);
            }
        }
        $enrolledProgram = $enrolledPrograms->first();

        $targetScholarship = $user->targetScholarships()->first();

        $offlineTestResults = \App\Models\OfflineTestResult::where('email', $user->email)->orderBy('created_at', 'desc')->get();

        $weeklyStreak = $this->repository->weeklyStreak($user->id);
        $leaderboard = $this->repository->monthlyLeaderboard($user->id, $enrolledProgram?->id);
        $lastStudied = $recentActivity[0] ?? null;

        return [
            'user' => $user,
            'progressPercentage' => $progressPercentage,
            'totalCompleted' => $completedAssignments,
            'totalAssignments' => $totalAssignments,
            'averageScore' => round($averageScore, 1),
            'highestScore' => $highestScore,
            'totalPoints' => $totalPoints,
            'recentActivity' => $recentActivity,
            'latestTest' => $latestTest,
            'recommendedProgram' => $recommendedProgram,
            'targetScore' => $targetScore,
            'upcomingClasses' => $upcomingClasses,
            'chartData' => $chartData,
            'classScores' => $classScores,
            'classNames' => $classNames,
            'predictedScore' => $predictedScore,
            'lowestScores' => $lowestScores,
            'enrolledProgram' => $enrolledProgram,
            'enrolledPrograms' => $enrolledPrograms,
            'diagnosticStats' => $diagnosticStats,
            'targetScholarship' => $targetScholarship,
            'offlineTestResults' => $offlineTestResults,
            'pteScores' => $this->repository->getPteScores($user->id),
            'weeklyStreak' => $weeklyStreak,
            'leaderboard' => $leaderboard,
            'lastStudied' => $lastStudied,
        ];
    }
}
