<?php

namespace App\Application\Scholarship;

use Carbon\Carbon;

class ScholarshipQualityGate
{
    public function passes(array $parsed): bool
    {
        return count($this->failureReasons($parsed)) === 0;
    }

    public function failureReasons(array $parsed): array
    {
        $reasons = [];

        $title = trim((string) ($parsed['title'] ?? ''));
        $applyLink = trim((string) ($parsed['apply_link'] ?? ''));
        $deadlineRaw = trim((string) ($parsed['deadline'] ?? ''));

        if (mb_strlen($title) < 8) {
            $reasons[] = 'Title terlalu pendek (min 8 karakter).';
        }

        if (!filter_var($applyLink, FILTER_VALIDATE_URL)) {
            $reasons[] = 'Apply link tidak valid.';
        }

        $deadline = null;
        try {
            $deadline = Carbon::parse($deadlineRaw);
        } catch (\Throwable $e) {
            $reasons[] = 'Deadline tidak bisa diparse sebagai tanggal valid.';
        }

        if ($deadline && $deadline->lt(now()->subDay())) {
            $reasons[] = 'Deadline sudah lewat.';
        }

        return $reasons;
    }
}
