<?php

namespace App\Application\PlacementTest;

use App\Models\PlacementTestPackage;
use App\Models\PlacementTestResult;

class StartPlacementTestAttempt
{
    /**
     * Resumes an in-progress attempt if one exists (keeping it pinned to
     * whichever package it started with, even if that package's schedule
     * window has since closed), otherwise starts a new attempt against the
     * package that is effectively active right now (manually turned on AND,
     * if a schedule is set, within the active_from/active_until window).
     * Returns null if no package is effectively active yet.
     */
    public function execute(int $userId): ?PlacementTestResult
    {
        $existing = PlacementTestResult::where('user_id', $userId)
            ->where('status', 'in_progress')
            ->latest('id')
            ->first();

        if ($existing) {
            return $existing;
        }

        $activePackage = PlacementTestPackage::effectivelyActive()->first();
        if (!$activePackage) {
            return null;
        }

        return PlacementTestResult::create([
            'user_id' => $userId,
            'placement_test_package_id' => $activePackage->id,
            'status' => 'in_progress',
            'started_at' => now(),
        ]);
    }
}
