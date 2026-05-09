<?php

namespace App\Application\ToeflMockup;

class SrtTranscriptParser
{
    public function parse(string $content): array
    {
        $content = $this->normalizeContent($content);
        $pattern = '/(\d+)\s+(\d{1,2}:\d{2}:\d{2}[,.]\d{1,3})\s*-->\s*(\d{1,2}:\d{2}:\d{2}[,.]\d{1,3})\s+([\s\S]*?)(?=(?:\n\s*\d+\s+\d{1,2}:\d{2}:\d{2})|$)/';

        $blocks = [];
        if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $text = trim(str_replace("\n", ' ', $match[4]));
                if ($text === '') {
                    continue;
                }

                $blocks[] = [
                    'start' => $this->srtTimeToSeconds($match[2]),
                    'end' => $this->srtTimeToSeconds($match[3]),
                    'text' => $text,
                ];
            }
        }

        return $blocks;
    }

    public function normalizeContent(string $content): string
    {
        return str_replace(["\r\n", "\r"], "\n", $content);
    }

    private function srtTimeToSeconds(string $srtTime): float
    {
        $srtTime = str_replace(',', '.', $srtTime);

        $milliseconds = 0;
        if (strpos($srtTime, '.') !== false) {
            [$time, $millisecondsPart] = explode('.', $srtTime);
            $milliseconds = (float) ('0.' . $millisecondsPart);
        } else {
            $time = $srtTime;
        }

        $parts = explode(':', $time);
        $count = count($parts);

        $hours = 0;
        $minutes = 0;
        $seconds = 0;

        if ($count === 3) {
            [$hours, $minutes, $seconds] = $parts;
        } elseif ($count === 2) {
            [$minutes, $seconds] = $parts;
        } else {
            $seconds = $parts[0];
        }

        return ($hours * 3600) + ($minutes * 60) + $seconds + $milliseconds;
    }
}